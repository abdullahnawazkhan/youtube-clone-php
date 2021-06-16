<?php
	session_start();

	$conn = new mysqli('localhost', 'root', '', 'yt_db', '3308');

	if ($conn->connect_error) {
		die("Connection Failed to Database");
	}
	else {
		$vid_id = $_GET['v_id'];
		$user_id = $_SESSION['user_id'];
		
		if ($_GET['op'] == 'like') {
			$query = "SELECT * FROM likes WHERE user_id=$user_id AND vid_id=$vid_id";
			$res = $conn->query($query);
			if ($res->num_rows > 0) {
				// User has already liked video
				// Removing user like
				
				// removing from 'likes' table
				$query = "DELETE FROM likes WHERE user_id=$user_id AND vid_id=$vid_id";
				if (!($conn->query($query))) {
					//echo("Error : " + $conn->error);
					die();
				}
				//echo("- removed from likes table\n");

				// decrementing 'likes' of video by 1
				$query = "SELECT * FROM VIDEOS WHERE id=$vid_id";
				$result = ($conn->query($query))->fetch_assoc();
				$likes = $result['likes'];
				$likes = $likes - 1;

				$query = "UPDATE VIDEOS SET likes=$likes WHERE id=$vid_id";
				if (!($conn->query($query))) {
					//echo("Error : " + $conn->error);
					die();
				}
				//echo("- Likes count decremented\n\n");

				echo("like removed");
				$conn->close();
			}
			else {
				// User has not liked video before
				// incrementing 'likes' of video by 1
				$query = "SELECT * FROM VIDEOS WHERE id=$vid_id";
				$result = ($conn->query($query))->fetch_assoc();
				$likes = $result['likes'];
				$likes = $likes + 1;

				$q = "UPDATE VIDEOS SET likes=$likes WHERE id=$vid_id";
				if ($conn->query($q)) {
					// echo("- Likes count incremented\n");
					// storing in likes table
					$query = "INSERT into likes(user_id, vid_id) VALUES($user_id, $vid_id)";
					if($conn->query($query)) {
						// echo("- Stored in likes table\n");
						// removing record from dislikes if user has disliked this previously
						$query = "SELECT * from dislikes WHERE user_id=$user_id AND vid_id=$vid_id";
						$res = $conn->query($query);
						if ($res->num_rows > 0) {
							$query = "DELETE from dislikes WHERE user_id=$user_id AND vid_id=$vid_id";
							if ($conn->query($query)) {
								// echo("- Removed from disliked table\n");
								// decrementing 'dislikes' of video by 1
								$query = "SELECT * FROM VIDEOS WHERE id=$vid_id";
								$result = ($conn->query($query))->fetch_assoc();
								$dislikes = $result['dislikes'];
								$dislikes = $dislikes - 1;

								$query = "UPDATE VIDEOS SET dislikes=$dislikes WHERE id=$vid_id";
								if ($conn->query($query)) {
									// echo("- Dislike count decremented\n");
								}
							}
						}
						$conn->close();
						echo("like added");
						// header("Location:video_page.php?id=$vid_id");
					}
					else {
						$conn->close();
						echo("Unable to store likes in [likes] table");
						die();
					}
				}
				else {
					echo("Error: " + $conn->error);
					die();
					$conn->close();
				}
			}
		}
		else {
			$query = "SELECT * FROM dislikes WHERE user_id=$user_id AND vid_id=$vid_id";
			$res = $conn->query($query);
			if ($res->num_rows > 0) {
				// User has already disliked video
				// Removing user dislike
				
				// removing from 'dislikes' table
				$query = "DELETE FROM dislikes WHERE user_id=$user_id AND vid_id=$vid_id";
				if (!($conn->query($query))) {
					// echo("Error : " + $conn->error);
					die();
				}
				// echo("- Removed from dislikes table\n");

				// decrementing 'dislikes' of video by 1
				$query = "SELECT * FROM VIDEOS WHERE id=$vid_id";
				$result = ($conn->query($query))->fetch_assoc();
				$dislikes = $result['dislikes'];
				$dislikes = $dislikes - 1;

				$query = "UPDATE VIDEOS SET dislikes=$dislikes WHERE id=$vid_id";
				if (!($conn->query($query))) {
					// echo("Error : " + $conn->error);
				}
				// echo("- Dislikes decremented by 1\n\n");

				echo("dislike removed");
				$conn->close();
			}
			else {
				// user has not disliked video before
				// incrementing 'dislikes' of video by 1
				$query = "SELECT * FROM VIDEOS WHERE id=$vid_id";
				$result = ($conn->query($query))->fetch_assoc();
				$dislikes = $result['dislikes'];
				$dislikes = $dislikes + 1;

				$q = "UPDATE VIDEOS SET dislikes=$dislikes WHERE id=$vid_id";
				if ($conn->query($q)) {
					// echo("- dislikes count incremented\n");

					// storing in the dislikes table
					$query = "INSERT into dislikes(user_id, vid_id) VALUES($user_id, $vid_id)";
					if($conn->query($query)) {
						// echo("- Stored in dislikes table\n");

						// removing from likes table if user has already liked it
						$query = "SELECT * from likes WHERE user_id=$user_id AND vid_id=$vid_id";
						$res = $conn->query($query);
						if ($res->num_rows > 0) {
							$query = "DELETE from likes WHERE user_id=$user_id AND vid_id=$vid_id";
							if ($conn->query($query)) {
								// echo("- Removed from liked table\n");

								// decrementing 'likes' of video by 1
								$query = "SELECT * FROM VIDEOS WHERE id=$vid_id";
								$result = ($conn->query($query))->fetch_assoc();
								$likes = $result['likes'];
								$likes = $likes - 1;

								$query = "UPDATE VIDEOS SET likes=$likes WHERE id=$vid_id";
								if ($conn->query($query)) {
									// echo("- like count decremented\n");
								}
							}
						}
						echo("dislike added");
						$conn->close();
					}
					else {
						$conn->close();
						echo("Unable to store dislikes in [dislikes] table");
						die();
					}
				}
				else {
					echo("Unable to Dislike Video");
					die();
					$conn->close();
				}
			}
		}
	}
?>