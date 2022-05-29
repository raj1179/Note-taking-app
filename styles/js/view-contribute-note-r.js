textArea = document.getElementById("textArea");
textArea.addEventListener("blur", validTextArea);

textArea.addEventListener("keyup", countTyped);
textArea.addEventListener("keyup", countRemain);

// form = document.getElementById("Form");
// form.addEventListener("submit", validForm);

function countTyped() {

	document.getElementById("countTyped").innerHTML = (textArea.value.length + " characters typed.");

}

function countRemain() {

	let maxChar = 1500;

	document.getElementById("countLeft").innerHTML = ((maxChar - textArea.value.length) + " characters remaining.");

}

function validForm(event) {

	let textArea = document.getElementById("textArea").value;

	if (!isEmpty(textArea) && textArea.length <= 1500) {
		console.log("All inputs are correctly formatted.");
	} else {
		event.preventDefault();
		console.log("one or mare input is invalid.");
	}

}