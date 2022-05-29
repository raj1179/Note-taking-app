console.log("AJAX vcode loaded");

var lastUpdate = Date.now();
console.log(lastUpdate);

setInterval(updateNote, 5000);

function updateNote(){

	console.log("Update note list code initialized");

	var xhr = new XMLHttpRequest();

	xhr.onreadystatechange = function(){

		if(xhr.readyState == 4 && xhr.status == 200){

			updateNoteList(xhr.responseText);

		}
	}

	xhr.open("GET", "updateNoteList.php?lastdt=" + encodeURIComponent(lastUpdate), true);
	xhr.send(null);

}

function updateNoteList (responseText){

	var result = JSON.parse(responseText);

	for(var i = 0; i < result.length; i++){

		let noteList = document.getElementById("noteList");
		if(noteList){

			let newNote = noteList.createElement("div");
			newNote.classList.add("notebook");

	}

	}

}