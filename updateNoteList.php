<?php

	session_start();
	$user_id = $_SESSION["user_id"];

	require_once("db.php");

	try{
		$db = new PDO($attr, $db_user, $db_pwd, $opts);
	} catch (PDOException $e){
		throw new PDOException($e->getMessage(), (int)$e->getCode());
	}

	$lastdt = date('Y-m-d H:i:s', $_GET["lastdt"]/1000);

	$q_NewNote = "SELECT Notes.note_id FROM Notes LEFT JOIN Roles ON(Notes.note_id = Roles.note_id) WHERE Notes.create_at >= '$lastdt' AND Roles.role = 'contributor' AND Roles.user_id = '$user_id' ";
	$r_NewNote = $db->query($q_NewNote);

	if($r_NewNote->rowCount() > 0){

		$row_NewNote = $r_NewNote->fetch();
		$note_id = $row_NewNote["note_id"];

		// The Query to retrieve all the notes that the logged in user has access to.
		$q_UserNotes = "SELECT Roles.role_id, Roles.role, Notes.note_id, Notes.title, Notes.create_at, Notes.last_modified, COUNT(Contributions.contribution_id) as Contribution_count
			FROM Roles LEFT JOIN Notes
			ON(Roles.note_id = Notes.note_id)
			LEFT JOIN Contributions
			ON(Roles.note_id = Contributions.note_id)
			WHERE Roles.note_id = '$note_id' AND Roles.user_id = '$user_id' AND Roles.role = 'contributor'
			GROUP BY Roles.role_id";

		// The query to retrive the data of the owner of the given note_id
		$q_NoteOwner = "SELECT Users.screen_name, Users.avatar_URL FROM Users LEFT JOIN Roles ON (Users.user_id = Roles.User_id) LEFT JOIN Notes ON (Notes.note_id = Roles.note_id) WHERE Roles.role = 'owner' AND Notes.note_id = '$note_id'";

		$r_UserNote = $db->query($q_UserNotes);
		$r_NoteOwner = $db->query($q_NoteOwner);

		$jsonArray = array("UserNote" => array(), "NoteOwner" => array());

		while($row_UserNote = $r_UserNote->fetch()){
			$jsonArray["UserNote"][] = $row_UserNote;
		}

		while($row_NoteOwner = $r_NoteOwner->fetch()){
			$jsonArray["NoteOwner"][] = $row_NoteOwner;
		}

		print(json_encode($jsonArray));

		$db = null;

	} else {

		print("[]");

	}

?>