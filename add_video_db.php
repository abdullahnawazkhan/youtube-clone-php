<?php
	session_start();

	$user_id = $_SESSION['user_id'];
	$title = $_POST['vtitle'];
	$link = $_POST['link'];
	$description = $_POST['description'];
	$thumb_link = $_POST['img_path'];
	$category = $_POST['category'];

	$conn = new mysqli('localhost', 'root', '', 'yt_db', '3308');

	if ($conn->connect_error) {
		die("Connection Failed to Database");
	}
	else {
		$query = "INSERT INTO videos(title, user_id, video_path, description, category, img_path) VALUES('$title', '$user_id', '$link', '$description', '$category', '$thumb_link')";

		if ($conn->query($query)) {
			header("Location:homepage.php");
			$conn->close();
		}
		else {
			echo($conn->error);
			$conn->close();
		}
	}
?>