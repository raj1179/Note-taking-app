<?php
	session_start();

	$error = "";
	$noteTitle = "";

	if(!isset($_SESSION["user_id"])){

		header("Location:index.php");
		exit();

	} else {

		require_once("db.php");
		$user_id = $_SESSION["user_id"];
		$screenName = $_SESSION["screen_name"];
		$imagePath = $_SESSION["avatar_URL"];

		if($_SERVER["REQUEST_METHOD"] == "POST"){

			$validator = true;
			$noteTitle = trim($_POST["newNotebook"]);
			echo "<script>console.log('noteTitle: " . $noteTitle . "' );</script>";

			if($noteTitle == null || $noteTitle == "" || strlen($noteTitle) > 256){
				$validator = false;
			}

			if($validator == false){
				$error = ("Invalid Input.");
			} else {
				try{
					$db = new PDO($attr, $db_user, $db_pwd, $opts);
				} catch(PDOException $e){
					throw new PDOException($e->getMessage(), (int)$e->getCode());
				}

				$qCreate = "INSERT INTO Notes (title, create_at, last_modified) VALUES ('$noteTitle', NOW(), NOW())";


				$result = $db->query($qCreate);

				if($result->rowCount() > 0){
					$lastInsertId = $db->lastInsertId();

					$qFetchUsers = "SELECT user_id FROM Users WHERE user_id != '$user_id'";
					$resultFetchUser = $db->query($qFetchUsers);

					while($rowUserId = $resultFetchUser->fetch()){
						$allUser_id = $rowUserId['user_id'];
						$qNoneRole = "INSERT INTO Roles (user_id, note_id, role) VALUES ('$allUser_id', '$lastInsertId', 'none')";
						$db->query($qNoneRole);
					}

					$qRole = "INSERT INTO Roles (user_id, note_id, role) VALUES ('$user_id', '$lastInsertId', 'owner')";
					$db->query($qRole);

					$db = null;
					header("Location: note-list.php");
					exit();
				}
			}
		}
	}

?>


<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<title>Create New Notebook</title>
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
						 href="index.php"
						 enctype="multipart/form-data"> Logout </a>
				</span>
			</div>
		</div>

		<form id="Form"
					class="Form"
					action=""
					method="post">
			<h1 class="formHead">Create New Notebook</h1>
			<p>
				Notebook Name:<br />
				<span id="createNewNotebookErrorEmpty"
							class="invalid hide">
					*Notebook title is empty.
				</span>
				<span id="createNewNotebookErrorLong"
							class="invalid hide">
					*Title can't be longer than 256 characters.
				</span>
				<span class="invalid"><?=$error?></span>
				<br />
				<input id="createNewNotebook"
							 class="inputField"
							 type="text"
							 name="newNotebook" />
			</p>
			<input type="submit"
						 class="Button"
						 href="note-list.php"
						 style="text-align: center"
						 value="Create" />
		</form>
		<script type="text/javascript"
						src="js/create-note-r.js"></script>
	</body>

</html>