<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<title>Shared Notebooks</title>
		<link rel="stylesheet"
					href="styles/style.css" />
	</head>

	<body class="gridContainer">
		<div class="top">
			Classwork

			<div class="floatRight">
				<img class="pfp"
						 src="./pfp.jpg"
						 alt="pfp" />
				<span class="rightText">
					Logged in as Raj
					<a class="Button"
						 href="index.php"> Logout </a>
				</span>
			</div>
		</div>

		<div class="navigation">
			<ul class="navMenu list">
				<li class="navli">
					<a class="aNav"
						 href="note-list.php">My Notebooks</a>
				</li>
				<li class="navli">
					<a class="aNav"
						 href="shared-notes.php">Shared Notebooks</a>
				</li>
				<li class="navli">
					<a class="aNav"
						 href="">Favorite Notebooks</a>
				</li>
				<li class="navli">
					<a class="aNav"
						 href="">Deleted Notebooks</a>
				</li>
			</ul>
		</div>

		<div class="main">
			<p class="pageTitle">Shared Notebooks</p>
			<a class="Button floatRight newNote"
				 href="create-note.php">
				New Notebook
			</a>

			<div class="noteList">
				<div class="notebook">
					<div class="floatRight info">
						<p>Owned by ME | Jan 18, 2022 | 5:00pm</p>
						<p>
							Last Contributed by PERSON1 | Jan 19, 2022 | 10:00pm
						</p>
					</div>
					<div>
						<p class="notebookTitle">
							Notebook1
							<span>
								<a class="Button floatRight noteViewBttn"
									 href="view-contribute-note.php">View
								</a>
							</span>
						</p>
					</div>
					<div>
						<p class="sharedInfo">5 Contributors</p>
						<span>
							<a class="Button floatRight noteContriBttn"
								 href="share-note.php">Share
							</a>
						</span>
					</div>
				</div>

				<div class="notebook">
					<div class="floatRight info">
						<p>Owned by ME | Jan 31, 2022 | 07:20pm</p>
						<p>
							Last Contributed by PERSON4 | Feb 01, 2022 | 10:00pm
						</p>
					</div>
					<div>
						<p class="notebookTitle">
							Notebook2
							<span>
								<input class="Button floatRight noteViewBttn"
											 type="submit"
											 value="View" />
							</span>
						</p>
					</div>
					<div>
						<p class="sharedInfo">5 Contributors</p>
						<span>
							<input class="Button floatRight noteContriBttn"
										 type="submit"
										 value="Share" />
						</span>
					</div>
				</div>
				<div class="notebook">
					<div class="floatRight info">
						<p>Owned by ME | Jan 18, 2022 | 5:00pm</p>
						<p>Last Contributed by ME | Jan 30, 2022 | 07:00pm</p>
					</div>
					<div>
						<p class="notebookTitle">
							Notebook10
							<span>
								<input class="Button floatRight noteViewBttn"
											 type="submit"
											 value="View" />
							</span>
						</p>
					</div>
					<div>
						<p class="sharedInfo">10 Contributors</p>
						<span>
							<input class="Button floatRight noteContriBttn"
										 type="submit"
										 value="Share" />
						</span>
					</div>
				</div>

				<div class="notebook">
					<div class="floatRight info">
						<p>Owned by ME | Jan 01, 2022 | 5:00pm</p>
						<p>Last Contributed by ME | Jan 19, 2022 | 10:00am</p>
					</div>
					<div>
						<p class="notebookTitle">
							Notebook4
							<span>
								<input class="Button floatRight noteViewBttn"
											 type="submit"
											 value="View" />
							</span>
						</p>
					</div>
					<div>
						<p class="sharedInfo">2 Contributors</p>
						<span>
							<input class="Button floatRight noteContriBttn"
										 type="submit"
										 value="Share" />
						</span>
					</div>
				</div>
			</div>
		</div>
	</body>

</html>