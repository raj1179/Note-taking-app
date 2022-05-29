console.log("AJAX vcode loaded");

var lastUpdate = Date.now();
console.log(lastUpdate);

setInterval(updateNote, 10000);

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

  lastUpdate = Date.now();

	console.log("I'm inside updateNoteList function now!");
	var result = JSON.parse(responseText);



	for(var i = 0; i < result.UserNote.length; i++){
		console.log("inside for loop");

		// create a div for the note information
		var newNote = document.createElement("div");
		newNote.className = "notebook";
		newNote.id = "notebook" + result.UserNote[i].note_id;

		// create a div for to display the information on right.
		var noteInfo = document.createElement("div");
		noteInfo.className = "floatRight info";
		noteInfo.id = "noteInfo";

		// create a ptag to print the note information
		var pNoteInfo = document.createElement("p"); 
		pNoteInfo.id = "pNoteInfo";

		// iamge tag for avatar
		var imgTag = document.createElement("img");
		imgTag.className = "pfp";
		imgTag.id = "imgTag";
		imgTag.src = result.NoteOwner[i].avatar_URL;

		pNoteInfo.innerHTML = " Owned by " + result.NoteOwner[i].screen_name + " | " + result.UserNote[i].create_at;

		// ptag for contribution info
		var pContributionInfo = document.createElement("p");
		pContributionInfo.id = "pContributionInfo";



		document.getElementById("noteList").appendChild(newNote);
		document.getElementById("notebook" + result.UserNote[i].note_id).appendChild(noteInfo);
		document.getElementById("noteInfo").appendChild(pNoteInfo);
		document.getElementById("pNoteInfo").appendChild(imgTag);

	}

}