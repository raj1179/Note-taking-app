<?php

	require_once("db.php");
	$error = "";
	$email = "";

	// check for the form submission
	if($_SERVER["REQUEST_METHOD"] == "POST"){

		// get email and password
		$email = trim($_POST["email"]);
		$password = trim($_POST["password"]);

		if(strlen($email) > 0 && strlen($password) > 0){

			try{
				$db = new PDO($attr, $db_user, $db_pwd, $opts);
			} catch(PDOException $e) {
				throw new PDOException($e->getMessage(), (int)$e->getCode());
			}

			// verify email and password on database
			$qVerify = "SELECT user_id, screen_name, avatar_URL FROM Users WHERE email = '$email' AND password = '$password'";

			$result = $db->query($qVerify);

			if($result->rowCount() > 0){
				// Successful login
				session_start();
				$row = $result->fetch();
				$_SESSION["user_id"] = $row["user_id"];
				$_SESSION["screen_name"] = $row["screen_name"];
				$_SESSION["avatar_URL"] = $row["avatar_URL"];

				$db = null;
				header("Location: note-list.php");
				exit();
			} else {
				// unsuccessful Login
				$error = ("No User found. Please check your Username and Password.");
			}
		} else {
			$error = ("One or more field is empty");
		}
	}

?>


<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<title>Login</title>
		<link rel="stylesheet"
					href="styles/style.css" />
		<script type="text/javascript"
						src="js/validate.js"></script>
	</head>

	<body class="gridContainer">
		<h1 class="top">Classwork</h1>

		<form id="Form"
					class="Form"
					method="post"
					action="">

			<h1 class="formHead">Login</h1>
			<p class="invalid"> <?=$error?> </p>
			<p>
				Username:
				<span id="usernameErrorFormat"
							class="invalid hide">
					*Invalid format, format it as a uregina.ca email address.
				</span>
				<span id="usernameErrorEmpty"
							class="invalid hide">
					*Username is Empty.
				</span>
				<br />
				<input class="inputField"
							 type="text"
							 name="email"
							 id="username" />
				<span id="usernameInstruction"
							class="instruction">
					*Your Username is your email.
				</span>
			</p>
			<p>
				Password:

				<span id="passwordErrorEmpty"
							class="invalid hide">
					*Password is empty.
				</span>
				<span id="passwordErrorShort"
							class="invalid hide">
					*The password is too short
				</span>
				<span id="passwordErrorSymbol"
							class="invalid hide">
					*The password must have a symbol.
				</span>

				<br />
				<input name="password"
							 id="password"
							 class="inputField"
							 type="password" />

				<span id="passwordInstruction"
							class="instruction">
					*Must contain 8 characters and at least one symbol.
				</span>
			</p>
			<p>
				<input class="Button"
							 value="Log in"
							 type="submit" />

				<span class="signup instruction">
					New User? <a href="signup.php">Sign-up</a> here
				</span>
			</p>
		</form>
		<script type="text/javascript"
						src="js/login-r.js"></script>
	</body>

</html>