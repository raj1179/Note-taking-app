<?php

	require_once("db.php");

	$error ="";
	$validator = true;
			 echo "<script>console.log('validator init: " . $validator . "' );</script>";
	$email="";
	$password="";

	$email_regex = "/^[\w.]+@uregina.ca$/i";
	$password_regex = "/[\W]+/";
	$screenName_regex = "/[^S]+[^W]+/";

	// check for form submit
	if($_SERVER["REQUEST_METHOD"] == "POST"){

		$screenName = trim($_POST["screenName"]);
		 echo "<script>console.log('ScreenName: " . $screenName . "' );</script>";
		$screenName_regex_test = preg_match($screenName_regex, $screenName);
		echo "<script>console.log('regex screenName: " . $screenName_regex_test . "' );</script>";

		$email = trim($_POST["email"]);
		 echo "<script>console.log('email: " . $email . "' );</script>";
		$email_regex_test = preg_match($email_regex, $email);
			echo "<script>console.log('regex email: " . $email_regex_test . "' );</script>";

		$password = trim($_POST["password"]);
		 echo "<script>console.log('password: " . $password . "' );</script>";
		$password_regex_test = preg_match($password_regex, $password);
			echo "<script>console.log('regex password: " . $password_regex_test . "' );</script>";

		$confirmPassword = trim($_POST["confirmPassword"]);
		 echo "<script>console.log('ConfirmPassword: " . $confirmPassword . "' );</script>";

		$avatar = ($_POST["avatar"]);
				 echo "<script>console.log('avatar: " . $avatar . "' );</script>";

		// screenName validation
		if($screenName == null || $screenName == "" || $screenName_regex_test == false){
			$validator = false;
			echo "<script>console.log('validator screenName: " . $validator . "' );</script>";
		}

		// email validation
		if($email == null || $email == "" || $email_regex_test == false){
			$validator = false;
			echo "<script>console.log('validator email: " . $validator . "' );</script>";
		}

		// password validator
		if($password == null || $password == "" || $password_regex_test == false){
			$validator = false;
			echo "<script>console.log('validator password: " . $validator . "' );</script>";
		}

		// confirmPassword validation
		if($confirmPassword == null || $confirmPassword != $password){
			$validator = false;
			echo "<script>console.log('validator confPassword: " . $validator . "' );</script>";
		}

		/***********************
		File Upload
		***********************/
		$file = $_FILES['avatar'];

		$fileName = $_FILES['avatar']['name'];
		$fileTempName = $_FILES['avatar']['tmp_name'];
		$fileType = $_FILES['avatar']['type'];
		$fileError = $_FILES['avatar']['error'];
		$fileSize = $_FILES['avatar']['size'];

		// file types check
		$fileExt = explode('.', $fileName);
		$fileActualExt = strtolower(end($fileExt));

		$allowed = array('jpg', 'jpeg', 'png');

		if(!in_array($fileActualExt, $allowed)){
			// file is of invalid type.
			$validator = false;
		}

		if($fileError !== 0){
			//errors while uploading the image
			$validator = false;
		}

		if($fileSize > 100000){
			// file is not so big
			$validator = false;
		}

		if($validator == false){

			$error = ("One or more fields has invalid input");

		} else {

			try{
				$db = new PDO($attr, $db_user, $db_pwd, $opts);
			} catch(PDOException $e) {
				throw new PDOException($e->getMessage(), (int)$e->getCode());
			}

		$fileNameNew = uniqid('', true) . "." . $fileActualExt;
		$fileDestination = 'uploads/' . $fileNameNew;
		move_uploaded_file($fileTempName, $fileDestination);

			$qInsert = "INSERT INTO Users(email, screen_name, password, avatar_URL) VALUES('$email','$screenName', '$password', '$fileDestination')";

			$result = $db->query($qInsert);

			if($result->rowCount() > 0){
				$db = null;
				header("Location: index.php");
				exit();
			}
		}
	}
?>


<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<title>Sign-Up</title>
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
					action=""
					enctype="multipart/form-data">

			<h1 class="formHead">Sign-Up</h1>

			<p class="invalid">
					<?=$error?>
			</p>

			<p>
				Screen Name:
				<span id="screenNameErrorFormat"
							class="invalid hide">
					*No space or non-word characters.
				</span>
				<span id="screenNameErrorEmpty"
							class="invalid hide">
					*Screen name is empty.
				</span>
				<br />
				<input name="screenName"
							 id="screenName"
							 class="inputField"
							 type="text" />
				<span id="screenNameInstruction"
							class="instruction">
					*People would know you by the screen name.
				</span>
			</p>

			<!-- Since username is the user's "uregina.ca" email address the id used for email address is username. It was done to re-use the JS code.
            -->
			<p>
				Email Address:
				<span id="usernameErrorFormat"
							class="invalid hide">
					*Invalid format, format it as a uregina.ca email address.
				</span>
				<span id="usernameErrorEmpty"
							class="invalid hide">
					*Email address is empty.
				</span>
				<br /><input name="email"
							 id="username"
							 class="inputField"
							 type="text" />
				<span id="usernameInstuction"
							class="instruction">
					*Enter your uregina.ca email address.
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
				<br /><input name="password"
							 id="password"
							 class="inputField"
							 type="password" />
				<span id="passwordInstruction"
							class="instruction">
					*Must contain 8 characters and at least one symbol.
				</span>

			</p>
			<p>
				Confirm Password:
				<span id="password_confirmErrorEmpty"
							class="invalid hide">
					*Confirm password is empty.</span>
				<span id="password_confirmErrorMatch"
							class="invalid hide">
					*Password Does not match.</span>
				<br />
				<input name="confirmPassword"
							 id="password_confirm"
							 class="inputField"
							 type="password" />
				<span id="password_confirmInstruction"
							class="instruction">
					*Enter the exact same password</span>
			</p>
			<p>
				Choose your profile picture. <br />
				<span id="avatarImageErrorEmpty"
							class="invalid hide">
					*No avatar image selected.
				</span>
			<p id="avatarImageErrorOneFile"
				 class="invalid hide">
				*Only one image file allowed.
			</p>
			<input name="avatar"
						 id="avatarImage"
						 type="file" />
			</p>
			<p>
				<input class="Button"
							 type="submit"
							 value="Sign-Up" />

							 <span class="instruction" style="margin-left: 25px">Already has an account? <a href = "index.php"> Log in</a></span>
			</p>
		</form>
		<script type="text/javascript"
						src="js/signup-r.js"></script>
	</body>

</html>