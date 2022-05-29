username = document.getElementById("username");
username.addEventListener("blur", validEmail);

password = document.getElementById("password");
password.addEventListener("blur", validPassword);

// form = document.getElementById("Form");
// form.addEventListener("submit", validForm, false);

function validForm(event) {

	let username = document.getElementById("username").value;
	let password = document.getElementById("password").value;

	if (!isEmpty(username) && isRegex(username, regex_Email) && !isEmpty(password) && !isShort(password) && isRegex(password, regex_Password)) {
		console.log("All inputs are correctly formatted.");
	} else {
		event.preventDefault();
		console.log("one or mare input is invalid.");
	}

}