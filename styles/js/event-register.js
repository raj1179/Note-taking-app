/****************************************************************
Event Registration
****************************************************************/

noteName = document.getElementById("createNewNotebook");
noteName.addEventListener("blur", validNoteName);

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

form = document.getElementById("Form");
form.addEventListener("submit", validForm);