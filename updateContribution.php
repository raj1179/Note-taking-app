<?php

	session_start();
	$user_id = $_SESSION["user_id"];
	$note_id = $_SESSION["note_id"];
	$str = $_GET["contribution"];

	require_once("db.php");

	try{
		$db = new PDO($attr, $db_user, $db_pwd, $opts);
	} catch (PDOException $e){
		throw new PDOException($e->getMessage(), (int)$e->getCode());
	}

	$curretUserRole = "SELECT role_id FROM Roles WHERE user_id = '$user_id'";
	$resultRoleID = $db->query($curretUserRole);
	$rowRole = $resultRoleID->fetch();
	$role_id = $rowRole['role_id'];

	$qInsert = "INSERT INTO Contributions (role_id, note_id, contribution, save_dt) VALUES ('$role_id', '$note_id', '$str', NOW())";

	$r_Insert = $db->query($qInsert);

	if($r_Insert->rowCount() > 0){

		$q_SelectLastID = "SELECT MAX(contribution_id) FROM Contributions";
		$r_LastID = $db->query($q_SelectLastID);
		$row_LastID = $r_LastID->fetch();
		$lastID = $row_LastID["MAX(contribution_id)"];

		// get the information of the last contribution
		$q_SelectContribution = "SELECT Roles.role, Users.screen_name, Users.avatar_URL, Contributions.contribution_id, Contributions.save_dt, Contributions.contribution FROM Contributions LEFT JOIN Roles ON(Contributions.role_id = Roles.role_id) LEFT JOIN Users ON (Roles.user_id = Users.user_id) WHERE Contributions.note_id='$note_id' AND Contributions.contribution_id = '$lastID' ";

		$r_SelectContribution = $db->query($q_SelectContribution);

		$jsonArray = array("contributionInfo" => array());
		while($row_SelectContribution = $r_SelectContribution->fetch()){
			$jsonArray["contributionInfo"][] = $row_SelectContribution;
		}

		$qUpdate = "UPDATE Notes SET last_modified = NOW() WHERE note_id = $note_id";
		$r_Update = $db->query($qUpdate);

		print(json_encode($jsonArray));

		$db = null;

	} else {

		print("[]");

	}

?>