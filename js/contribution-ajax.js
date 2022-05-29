console.log("contribution-ajax.js is loaded");

var text = document.getElementById("textArea").value;



function updateContribution(event) {

	console.log("update contribution code is initialized");
	var text = document.getElementById("textArea").value;

	if (!isEmpty(text) && text.length <= 1500) {
		console.log("All inputs are correctly formatted.");
		var xhr = new XMLHttpRequest();

		xhr.onreadystatechange = function () {

			if (xhr.readyState == 4 && xhr.status == 200) {

				updateSavedContribution(xhr.responseText);

			}
		}

		xhr.open("GET", "updateContribution.php?contribution=" + encodeURIComponent(text), true);
		xhr.send(null);
	} else {
		event.preventDefault();
		console.log("one or mare input is invalid.");
	}

}

function updateSavedContribution(responseText) {

	var result = JSON.parse(responseText);

	for (let i = 0; i < result.length; i++) {

		// create a div for to display the information on right.
		var contributorInfo = document.createElement("div");
		contributorInfo.className = "userContent";
		contributorInfo.id = "contributorInfo" + result.contributionInfo[i].contribution_id;

		// create a ptag to print the note information
		var pContributorInfo = document.createElement("p");
		pContributorInfo.id = "pContributorInfo" + result.contributionInfo[i].contribution_id;

		// iamge tag for avatar
		var imgTag = document.createElement("img");
		imgTag.className = "pfp";
		imgTag.id = "imgTag" + result.contributionInfo[i].contribution_id;
		imgTag.src = result.contributionInfo[i].avatar_URL;

		var spanContributionTime = document.createElement("span");
		spanContributionTime.id = "spanRole" + result.contributionInfo[i].contribution_id;
		spanContributionTime.className = "floatRight contentPostInfo";

		var divContent = document.createElement("div");
		divContent.id = "divContent" + result.contributionInfo[i].contribution_id;
		divContent.className = "content";

		document.getElementById("view").appendChild(contributorInfo);

		document.getElementById("contributorInfo" + result.contributionInfo[i].contribution_id).appendChild(pContributorInfo);
		pContributorInfo.innerHTML = result.contributionInfo[i].screen_name;
		document.getElementById("pContributorInfo" + result.contributionInfo[i].contribution_id).prepend(imgTag);

		document.getElementById("pContributorInfo" + result.contributionInfo[i].contribution_id).appendChild(spanContributionTime);

		divContent.innerHTML = result.contributionInfo[i].contribution;
		document.getElementById("view").appendChild(divContent);

	}

}

let submit = document.getElementById("saveButton");
submit.addEventListener("click", updateContribution);