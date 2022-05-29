<?php

	session_start();

	if(!isset($_SESSION["user_id"])){
		header("Location: index.php");
		exit();
	}else{
		require_once("db.php");
		$user_id = $_SESSION["user_id"];
		echo "<script>console.log('user_id: " . $user_id . "' );</script>";
		$screenName = $_SESSION["screen_name"];
		$imagePath = $_SESSION["avatar_URL"];
		$note_id = $_GET["note_id"];
		echo "<script>console.log('note_id: " . $note_id . "' );</script>";

		try{
			$db = new PDO($attr, $db_user, $db_pwd, $opts);
		}catch(PDOException $e){
			throw new PDOException($e->getMessage(), (int)$e->getCode());
		}
	}

	$q1 = "SELECT Users.screen_name, Users.avatar_URL, Roles.role, Roles.role_id, Notes.title, Notes.note_id FROM Users LEFT JOIN Roles ON (Users.user_id = Roles.user_id) LEFT JOIN Notes ON (Roles.note_id = Notes.note_id) WHERE Notes.note_id = '$note_id' AND Users.user_id != '$user_id'";

	$result = $db->query($q1);
	$row = $result->fetch();

	if($_SERVER["REQUEST_METHOD"] == "POST"){

		if(isset($_POST['share'])){

			$roleID = $_POST['share'];

			$qGrant = "UPDATE Roles SET role = 'contributor' WHERE role_id = '$roleID' ";
			$db->query($qGrant);

			$db = null;
			header("Location: share-note.php");
			exit();

		}

		if(isset($_POST['unShare'])){
			
			$roleID = $_POST['unShare'];
			$qRevoke = "UPDATE Roles SET role = 'none' WHERE role_id = '$roleID' ";
			$db->query($qRevoke);

			$db = null;
			header("Location: share-note.php");
			exit();

		}

}

?>


<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<title>Share Notebook</title>
		<link rel="stylesheet"
					href="styles/style.css" />
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

		<div class="Form">
			<h1 class="formHead">Share <span style="text-decoration: underline;"><?=$row['title']?></span> with People</h1>

			<ul class="list">

				<?php while($row = $result->fetch()){ ?>

					<div class="listItem">
						<img class="pfp"
								 src=<?=$row['avatar_URL']?>
								 alt="pfp" />
						<?= $row['screen_name']?>

						<?php if($row['role'] == 'none' && $row['note_id'] == $note_id){ ?>
						<form action="" method="post">
							<input class = "Button floatRight"
										type="submit"
										name=""
										value="Grant" />
							<input type="hidden" name="share" value ="<?=$row["role_id"]?>" />
						</form>
						<?php } ?>

						<?php if($row['role'] == 'contributor' && $row['note_id'] == $note_id){ ?>
						<form action="" method="post">
							<input class="Button floatRight"
										 type="submit"
										 name=""
										 value="Revoke" />
							<input type="hidden" name="unShare" value="<?=$row['role_id']?>" />

						</form>
						<?php } ?>
					</div>
				<?php } ?>
			</ul>

			<form action="note-list.php">
					<input class="Button"
								 type="submit"
								 value ="Done" />
			</form>
		</div>
		<p class="bottom"></p>
	</body>
</html>