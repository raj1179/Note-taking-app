console.log("AJAX vcode loaded");

var lastUpdate = Date.now();
console.log(lastUpdate);

setInterval(updateNote, 5000);

function updateNote() {

	var lastUpdate = Date.now();

	console.log("Update note list code initialized");

	var xhr = new XMLHttpRequest();

	xhr.onreadystatechange = function () {

		if (xhr.readyState == 4 && xhr.status == 200) {

			updateNoteList(xhr.responseText);

		}
	}

	xhr.open("GET", "updateNoteList.php?lastdt=" + encodeURIComponent(lastUpdate), true);
	xhr.send(null);

}

function updateNoteList(responseText) {

	console.log("I'm inside updateNoteList function now!");
	var result = JSON.parse(responseText);


	for (var i = 0; i < result.UserNote.length; i++) {
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


		// ptag for contribution info
		var pContributionInfo = document.createElement("p");
		pContributionInfo.id = "pContributionInfo";

		// div for note title, role of the current user, number of contributions and view/share buttons
		var leftDiv = document.createElement("div");
		leftDiv.id = "leftDiv";

		var pNoteTitle = document.createElement("p");
		pNoteTitle.className = "notebookTitle";
		pNoteTitle.id = "noteTitle" + result.UserNote[i].note_id;

		var spanRole = document.createElement("span");
		spanRole.id = "spanRole";
		var styleRole = document.createAttribute("style");
		styleRole.value = "font-weight: 300";
		spanRole.setAttributeNode(styleRole);

		var pNoContribution = document.createElement("p");
		pNoContribution.id = "pNoContribution";
		pNoContribution.className = "sharedInfo";

		var buttonUL = document.createElement("ul");
		buttonUL.id = "buttonUL";
		var styleButtonUL = document.createAttribute("style");
		styleButtonUL.value = "margin-left = -30px";
		buttonUL.setAttributeNode(styleButtonUL);

		var viewButtonLI = document.createElement("li");
		viewButtonLI.id = "viewButtonLI";
		viewButtonLI.className = "viewShareButtn";

		document.getElementById("noteList").prepend(newNote);

		document.getElementById("notebook" + result.UserNote[i].note_id).appendChild(noteInfo);

		document.getElementById("noteInfo").appendChild(pNoteInfo);

		pNoteInfo.innerHTML = " Owned by " + result.NoteOwner[i].screen_name + " | " + result.UserNote[i].create_at;
		document.getElementById("pNoteInfo").prepend(imgTag);

		pContributionInfo.innerHTML = " Last modified on " + result.UserNote[i].last_modified;
		document.getElementById("noteInfo").appendChild(pContributionInfo);

		document.getElementById("notebook" + result.UserNote[i].note_id).appendChild(leftDiv);

		pNoteTitle.innerHTML = result.UserNote[i].title;
		document.getElementById("leftDiv").appendChild(pNoteTitle);

		spanRole.innerHTML = "(" + result.UserNote[i].role + ")";
		document.getElementById("noteTitle" + result.UserNote[i].note_id).appendChild(spanRole);

		pNoContribution.innerHTML = result.UserNote[i].Contribution_count + " Contribution"
		document.getElementById("leftDiv").appendChild(pNoContribution);

		document.getElementById("leftDiv").appendChild(buttonUL);

		document.getElementById("buttonUL").appendChild(viewButtonLI);

	}

}