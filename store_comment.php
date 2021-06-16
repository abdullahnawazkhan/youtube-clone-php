<?php
	session_start();

	$comment = $_POST['comment'];
	$user_id = $_SESSION['user_id'];
	$video_id = $_GET['id'];

	$conn = new mysqli('localhost', 'root', '', 'yt_db', '3308');

	if ($conn->connect_error) {
		die("Connection Failed to Database");
	}
	else {
		
		$query = $conn->prepare("INSERT INTO COMMENTS(vid_id, user_id, comment) VALUES(?, ?, ?)");

		if ($query == false) {
			echo("Invalid SQL Query: " . $conn->error);
			die();
		}

		$res = $query->bind_param("iis", $video_id, $user_id, $comment);

		if ($res == false ) {
			echo("Error while binding parameters - " . $conn->error);
			die();
		}

		if ($query->execute()) {
			$conn->close();
			echo("Comment Saved");
		}
		else {
			echo("UNABLE TO ADD COMMENT");
			echo($conn->error);
			$conn->close();
		}
	}
?>
