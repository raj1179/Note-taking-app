username = document.getElementById("username");
username.addEventListener("blur", validEmail);

password = document.getElementById("password");
password.addEventListener("blur", validPassword);

password_confirm = document.getElementById("password_confirm");
password_confirm.addEventListener("blur", validPasswordConfirm);

screenName = document.getElementById("screenName");
screenName.addEventListener("blur", validScreenName);

avatarImage = document.getElementById("avatarImage");
avatarImage.addEventListener("blur", validAvatarImage);

// form = document.getElementById("Form");
// form.addEventListener("submit", validForm, false);

function validForm(event) {

	let username = document.getElementById("username").value;
	let password = document.getElementById("password").value;
	let password_confirm = document.getElementById("password_confirm").value;
	let screenName = document.getElementById("screenName").value;
	let avatarImage = document.getElementById("avatarImage").value;

	if (!isEmpty(username) && isRegex(username, regex_Email)
		&& !isEmpty(password) && !isShort(password) && isRegex(password, regex_Password)
		&& !isEmpty(password_confirm) && password_confirm == password
		&& !isEmpty(screenName) && !isRegex(screenName, regex_ScreenName)
		&& !isEmpty(avatarImage)) {
		console.log("All inputs are correctly formatted.");
	} else {
		event.preventDefault();
		console.log("one or mare input is invalid.");
	}

}