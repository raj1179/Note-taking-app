<?php

	session_start();

	if(!isset($_SESSION["user_id"])){
		header("Location: index.php");
		exit();
	} else {
		require_once("db.php");
		$user_id = $_SESSION["user_id"];
		$screenName = $_SESSION["screen_name"];
		$imagePath = $_SESSION["avatar_URL"];
		$note_id = $_GET["note_id"];
		echo "<script>console.log('note_id: " . $note_id . "' );</script>";
		$error = "";


				try{
					$db = new PDO($attr, $db_user, $db_pwd, $opts);
				}catch(PDOException $e){
					throw new PDOException($e->getMessage(), (int)$e->getCode());
				}

				$curretUserRole = "SELECT role_id FROM Roles WHERE user_id = '$user_id'";
				$resultRoleID = $db->query($curretUserRole);
				$rowRole = $resultRoleID->fetch();
				$role_id = $rowRole['role_id'];

			$qOwner = "SELECT Users.screen_name, Users.avatar_URL, Notes.title, Notes.create_at FROM Users LEFT JOIN Roles ON (Users.user_id = Roles.User_id) LEFT JOIN Notes ON (Notes.note_id = Roles.note_id) WHERE Roles.role = 'owner' && Notes.note_id = '$note_id'";

			$resultOwner = $db->query($qOwner);
			$row3 = $resultOwner->fetch();
			$noteOwner = $row3['screen_name'];
			$noteOwnerAvatar = $row3['avatar_URL'];

			$qSelect = "SELECT Roles.role, Users.screen_name, Users.avatar_URL, Contributions.save_dt, Contributions.contribution FROM Contributions LEFT JOIN Roles ON(Contributions.role_id = Roles.role_id) LEFT JOIN Users ON (Roles.user_id = Users.user_id) WHERE Contributions.note_id='$note_id'";

			$result = $db->query($qSelect);



		if($_SERVER["REQUEST_METHOD"] == "POST"){

			$validator = true;
			$userContribution = trim($_POST["userContribution"]);

			if($userContribution == null || $userContribution == "" || strlen($userContribution) >= 1500){
				$validator = false;
			}
						if($validator == false){
				$error = ("Invalid Input.");
			}else{
				$str = addslashes($userContribution);
					$qInsert = "INSERT INTO Contributions (role_id, note_id, contribution, save_dt) VALUES ('$role_id', '$note_id', '$str', NOW())";

					$result = $db->query($qInsert);
					if($result->rowCount() > 0){
						$row = $result->fetch();
						$qUpdate = "UPDATE Notes SET last_modified = NOW() WHERE note_id = $note_id";
						$db->query($qUpdate);
						$db = null;
						header("Location: view-contribute-note.php");
						exit();
						}
					}
				}
			}
?>



<!-- userContribution -->
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<title>View and Contribute</title>
		<link rel="stylesheet"
					href="styles/style.css" />
		<script type="text/javascript"
						src="js/validate.js"></script>
	</head>

	<body class="gridContainer">
		<div class="top">
			Classwork

			<div class="floatRight">
				<img class="pfp"
						 src=<?=$imagePath?>
						 alt="pfp" />
				<span class="rightText">
					Logged in as <?=$screenName?>
					<a class="Button"
						 href="logout.php"> Logout </a>
				</span>
			</div>
		</div>

		<div class="left">
			<div class="sidebar">
				<h1 class="sidebarTitle"><?=$row3['title']?> </h1>
				<div class="sidebarText">
					<p>Owned By:</p>
					<p>
						<img class="pfp"
								 src=<?=$row3['avatar_URL']?>
								 alt="pfp" /> <?=$row3['screen_name']?>
					</p>
					<p>Created on:</p>
					<p><?=date_format(date_create($row3["create_at"]), "M d, Y")?></p>
					<p><?=date_format(date_create($row3["create_at"]), "h:i A")?></p>
				</div>
			</div>
		</div>

		<div id="view"
				 class="view">

			<?php
			while($row = $result ->fetch()){
			?>
			<div class="userContent">
				<p>
					<img class="pfp"
							 src=<?=$row['avatar_URL']?>
							 alt="pfp" /> <?=$row['screen_name']?>
					<span class="floatRight contentPostInfo">
						<?=date_format(date_create($row["save_dt"]), "M d, Y")?> |
						<?=date_format(date_create($row["save_dt"]), "h:i A")?>
					</span>
				</p>
			</div>
			<div class="content">
				<?=$row['contribution']?>
			</div>
			<?php }?>
		</div>

		<div class="makeContribution">
			<p>Make your contribution
			<p id="countTyped"> 0 characters typed.</p>
			<p id="countLeft"> 1500 characters remaining.</p>
			</p>
			<span id="textAreaErrorEmpty"
						class="invalid hide">
				*Your contribution can't be empty.
			</span>
			<span id="textAreaErrorLong"
						class="invalid hide">
				*Your contribution can't be longer than 1500 characters.
			</span>
			<span class="invalid"><?=$error?> </span>
			<br />
			<span>
				<textarea id="textArea"
									class="userContributionInputField"
									name="userContribution"
									rows="1"
									cols="50"></textarea>
			</span>

			<button id="saveButton"
							type="button"
							class="Button userContributionButton"
							value="Contribute">Save</button>

			<button id="resetButton"
							type="button"
							class="Button userContributionButton">Reset</button>
		</div>
		<script type="text/javascript"
						src="js/view-contribute-note-r.js"></script>

		<script type="text/javascript"
						src=js/contribution-ajax.js></script>
	</body>

</html>