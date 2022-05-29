<?php

	session_start();

	if(!isset($_SESSION["user_id"])){
		header("Location: index.php");
		exit();
	}else{
		require_once("db.php");
		$user_id = $_SESSION["user_id"];
		$screenName = $_SESSION["screen_name"];
		$imagePath = $_SESSION["avatar_URL"];
		try{
			$db = new PDO($attr, $db_user, $db_pwd, $opts);
		}catch(PDOException $e){
			throw new PDOException($e->getMessage(), (int)$e->getCode());
		}

		$q1 = "SELECT Notes.note_id, Notes.title, Notes.create_at, Notes.last_modified,
  			Roles.role, Roles.role_id
  			FROM Notes LEFT JOIN Roles ON (Notes.note_id = Roles.note_id)
  			LEFT JOIN Users ON (Roles.user_id = Users.user_id)
  			WHERE Roles.user_id = '$user_id' AND Roles.role != 'none'
  			ORDER BY Notes.create_at DESC";

		$result = $db->query($q1);

		if($_SERVER["REQUEST_METHOD"] == "POST"){
			if(isset($_POST["note_id"])){
				$_SESSION["note_id"] = $_POST["note_id"];
				$db = null;
				header("Location: view-contribute-note.php");
				exit();
			}

			if(isset($_POST["role_id"])){
				$_SESSION["note_id"] = $_POST["role_id"];
				$db = null;
				header("Location: share-note.php");
				exit();
			}

		}

	}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<title>Your Notebooks</title>
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

		<div class="navigation">
			<ul class="navMenu list">
				<li class="navli">
					<a class="aNav"
						 href="note-list.php">My Notebooks</a>
				</li>
				<li class="navli">
					<a class="aNav"
						 href="">Shared Notebooks</a>
				</li>
				<li class="navli">
					<a class="aNav"
						 href="">Favorite Notebooks</a>
				</li>
				<li class="navli">
					<a class="aNav"
						 href="">Deleted Notebooks</a>
				</li>
			</ul>
		</div>

		<div class="main">
			<p class="pageTitle">My Notebooks</p>
			<a class="Button floatRight newNote"
				 href="create-note.php">
				New Notebook
			</a>

			<div id="noteList"
					 class="noteList">
				<?php
					while($row = $result ->fetch()){
						$note_id = $row["note_id"];
						$role_id = $row["role_id"];

						$q2 = "SELECT COUNT(Contributions.contribution_id) as contribution_count FROM Contributions LEFT JOIN Notes ON (Contributions.note_id = Notes.note_id) WHERE Notes.note_id = '$note_id'";

						$result1 = $db->query($q2);
						$row2 = $result1->fetch();

						$q3 = "SELECT Users.screen_name, Users.avatar_URL FROM Users LEFT JOIN Roles ON (Users.user_id = Roles.User_id) LEFT JOIN Notes ON (Notes.note_id = Roles.note_id) WHERE Roles.role = 'owner' AND Notes.note_id = '$note_id'";

						$result3 = $db->query($q3);
						$row3 = $result3->fetch();
						$noteOwner = $row3['screen_name'];
						$noteOwnerAvatar = $row3['avatar_URL'];

				?>
				<div class="notebook">
					<div class="floatRight info">
						<p>
							<img class="pfp"
									 src=<?=$row3["avatar_URL"]?>>
							Owned by <?=$row3["screen_name"]?> | <?=date_format(date_create($row["create_at"]), "M d, Y")?> |
							<?=date_format(date_create($row["create_at"]), "h:i A")?>
						</p>
						<p>
							Last modified on <?=date_format(date_create($row["last_modified"]), "M d, Y")?> |
							<?=date_format(date_create($row["last_modified"]), "h:i A")?></p>
					</div>

					<div>
						<p class="notebookTitle">
							<?=$row["title"]?>
							<span style="font-weight: 300;">(<?=$row["role"]?>)</span>
						</p>

						<p class="sharedInfo"><?=$row2["contribution_count"]?> Contributions</p>

						<ul style="margin-left: -30px">
							<li class="viewShareButtn">
							<a class="Button" href="view-contribute-note.php?note_id=<?=$row['note_id']?>"> View </a>
							</li>

							<li class="viewShareButtn">
								<?php if($row['role'] == 'owner'){ ?>
									<a class="Button" href="share-note.php?note_id=<?=$row['note_id']?>"> Share </a>
								<?php } ?>
							</li>
						</ul>
					</div>
				</div>
				<?php } ?>
			</div>
		</div>
		<script type="text/javascript"
						src="js/note-list-ajax.js"></script>
	</body>

</html>