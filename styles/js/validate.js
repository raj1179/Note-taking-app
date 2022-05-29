var form, username, password, password_confirm, screenName, avatarImage, noteName, textArea;

var regex_Email = /^[\w.]+@uregina.ca$/i;
var regex_Password = /[\W]+/;
var regex_ScreenName = /[\S]+[\W]+/;

console.log("JS file loaded.");

function isEmpty(element_value) {

	if (element_value == "" || element_value == null) {
		return true;
	} else {
		return false;
	}
}

function isRegex(element_value, regex) {

	if (regex.test(element_value)) {
		return true;
	} else {
		return false;
	}

}

function isShort(element_value) {
	if (element_value.length < 6) {
		return true;
	} else {
		return false;
	}
}

function validEmail(event) {

	let element_value = event.target.value;
	let instruction = document.getElementById(event.target.id + "Instruction");
	let errorEmpty = document.getElementById(event.target.id + "ErrorEmpty");
	let errorFormat = document.getElementById(event.target.id + "ErrorFormat");

	if (isEmpty(element_value)) {
		console.log("Email is empty");
		errorEmpty.classList.remove("hide");
	} else {
		console.log("Email is not empty");
		errorEmpty.classList.add("hide");
	}

	if (!isRegex(element_value, regex_Email) && !isEmpty(element_value)) {
		console.log("Email address is correctly formatted");
		errorFormat.classList.remove("hide");
	} else {
		console.log("Email address is not correctly formatted");
		errorFormat.classList.add("hide");
	}

}

function validPassword(event) {

	let element_value = event.target.value;

	let instruction = document.getElementById(event.target.id + "Instruction");
	let errorEmpty = document.getElementById(event.target.id + "ErrorEmpty");
	let errorShort = document.getElementById(event.target.id + "ErrorShort");
	let errorSymbol = document.getElementById(event.target.id + "ErrorSymbol");

	if (isEmpty(element_value)) {
		console.log("Password is empty.");
		errorEmpty.classList.remove("hide");
	} else {
		console.log("Password is not empty.");
		errorEmpty.classList.add("hide");
	}

	if (isShort(element_value) && !isEmpty(element_value)) {
		console.log("Passeord is short.");
		errorShort.classList.remove("hide");
	} else {
		console.log("Password is not short.");
		errorShort.classList.add("hide");
	}

	if (!isRegex(element_value, regex_Password) && !isEmpty(element_value)) {
		errorSymbol.classList.remove("hide");
	} else {
		errorSymbol.classList.add("hide");
	}

}

function validPasswordConfirm(event) {

	let element_value = event.target.value;
	let password_value = document.getElementById("password").value;

	let errorEmpty = document.getElementById(event.target.id + "ErrorEmpty");
	let errorMatch = document.getElementById(event.target.id + "ErrorMatch");

	if (isEmpty(element_value)) {
		console.log("Confirm password is empty.");
		errorEmpty.classList.remove("hide");
	} else {
		console.log("Confirm password is not empty.");
		errorEmpty.classList.add("hide");
	}

	if (element_value != password_value && !isEmpty(element_value)) {
		console.log("Passwrod does not matches.");
		errorMatch.classList.remove("hide");
	} else {
		console.log("Password matches.");
		errorMatch.classList.add("hide");
	}

}

function validScreenName(event) {

	let element_value = event.target.value;
	let errorEmpty = document.getElementById(event.target.id + "ErrorEmpty");
	let errorFormat = document.getElementById(event.target.id + "ErrorFormat");

	if (isEmpty(element_value)) {
		console.log("Screen name is empty");
		errorEmpty.classList.remove("hide");
	} else {
		console.log("Screen name is not empty");
		errorEmpty.classList.add("hide");
	}

	if (isRegex(element_value, regex_ScreenName) && !isEmpty(element_value)) {
		console.log("Screen name is not formatted");
		errorFormat.classList.remove("hide");
	} else {
		console.log("Screen name is correctly formatted.");
		errorFormat.classList.add("hide");
	}

}

function validAvatarImage(event) {

	let element_value = event.target.value;
	let errorEmpty = document.getElementById(event.target.id + "ErrorEmpty");


	if (isEmpty(element_value)) {
		console.log("Image file is empty");
		errorEmpty.classList.remove("hide");
	} else {
		console.log("Image file is not empty");
		errorEmpty.classList.add("hide");
	}

}

function validNoteName(event) {

	let element_value = event.target.value;
	let errorEmpty = document.getElementById(event.target.id + "ErrorEmpty");
	let errorLong = document.getElementById(event.target.id + "ErrorLong");

	if (isEmpty(element_value)) {
		console.log("Note name is empty");
		errorEmpty.classList.remove("hide");
	} else {
		console.log("Note name is not empty");
		errorEmpty.classList.add("hide");
	}

	if (element_value.length > 256) {
		console.log("title is longer than 256 characters");
		errorLong.classList.remove("hide");
	} else {
		console.log("Title is shorter than 256 characters")
		errorLong.classList.add("hide");
	}

}

function validTextArea(event) {

	let element_value = event.target.value;
	let errorEmpty = document.getElementById(event.target.id + "ErrorEmpty");
	let errorLong = document.getElementById(event.target.id + "ErrorLong");

	if (isEmpty(element_value)) {
		console.log("Textarea is empty");
		errorEmpty.classList.remove("hide");
	} else {
		errorEmpty.classList.add("hide");
	}

	if (element_value.length > 1500) {
		console.log("the input is too large");
		errorLong.classList.remove("hide");
	} else {
		errorLong.classList.add("hide");
	}

}
