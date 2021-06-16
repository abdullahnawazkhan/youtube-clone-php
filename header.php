<?php
	session_start();	
?>

<style>
	#top_bar {
		background-color: #272727;
		width: 100%;
		height: 60px;
		padding-left: 20px;
		flex-direction: row;
		display: flex;
		align-items: center;
		position: fixed;
	}

	#menu_button_button {
		background-color: #272727;
		border: none;
	}

	#youtube_logo {
		/* border: thin solid pink; */
		margin-left: 15px;
	}

	#search_bar {
		color:white;
		width: 700px;
		/* height: 15px; */
		padding: 5px;
		font-size: 20px;
		margin-left: 150px;
		
		border: solid #383838;
		background-color: #121212;
	}

	#search_button {
		padding-top: 4px;
	}
</style>

<div id="top_bar">
	<div><button id="menu_button_button"><img src="img/menu.png" alt="menu_button" width="50" height="45" id="menu_button"></button></div>
	<img><a href="homepage.php"><img src="img/youtube_logo.png" alt="youtube_logo" width="115" height="35" id="youtube_logo"></img></a>

	<div><input type="text" placeholder="Search" id="search_bar"></div>
	<div><img src="img/search_button.png" alt="" width="70" height="37.5" id="search_button"></div>

	<div><a href='add_video.php'><img src="img/add_video.png" alt="add_video" width="60" height="45" id="add_video"></a></div>
	<div><a href='index.php'><img src="img/log-in.png" alt="login" width="35" height="30" id="login" title="log in"></a></div>
	<div><a href='index.php'><img src="img/log-out.png" alt="logout" width="35" height="30" id="logout" title="log out"></a></div>
	<?php
		if (isset($_SESSION['logged']) && $_SESSION['logged'] == 'yes') {
			$user_id = $_SESSION['user_id'];
			echo("<div><a href='user_profile.php?op=1&id=$user_id'><img src='img/user.png' alt='profile' width='40' height='35' id='profile'></a></div>");
		}
	?>
	<?php 
		if (isset($_SESSION['logged']) && $_SESSION['logged'] == 'yes') {
			echo("<style>#logout{margin-left: 25px;};</style>");
			echo("<style>#login{display: none;};</style>");
			echo("<style>#profile {
			background-color: white;
				border-radius: 50%;
				margin-left: 30px;
				margin-top: 2px;
			};</style>");
			echo("<style>#add_video {
				padding-top: 3px;
				margin-left: 150px;
			};</style>");
		}
		else {
			echo("<style>#login{margin-left: 150px;};</style>");
			echo("<style>#logout{display: none;};</style>");
			echo("<style>#profile {display: none;};</style>");
			echo("<style>#add_video{display: none;};</style>");
		}
	?>
</div>