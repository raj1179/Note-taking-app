noteName = document.getElementById("createNewNotebook");
noteName.addEventListener("blur", validNoteName);

// form = document.getElementById("Form");
// form.addEventListener("submit", validForm);

function validForm(event) {

	let createNewNotebook = document.getElementById("createNewNotebook").value;

	if (!isEmpty(createNewNotebook) && createNewNotebook.length <= 256) {
		console.log("All inputs are correctly formatted.");
	} else {
		event.preventDefault();
		console.log("one or mare input is invalid.");
	}

}