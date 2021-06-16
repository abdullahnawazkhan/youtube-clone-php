<?php
	$video_id = $_GET["id"];

	require('header.php');
	require('side_panel.php');
	
	if (isset($_SESSION['logged']) && $_SESSION['logged'] == 'yes') {
		$user = $_SESSION['user_id'];
	}

	$conn = new mysqli('localhost', 'root', '', 'yt_db', '3308');

	if ($conn->connect_error) {
		die("Connection Failed to Database");
	}
	else {
		$q = "SELECT * FROM USERS WHERE ID=$user";
		$r = $conn->query($q);
		$r = $r->fetch_assoc();
		$logged_username = $r['username'];

		$query = "SELECT * FROM videos WHERE id=$video_id";
		$result = $conn->query($query);
		
		$row = $result->fetch_array();
  
		$video_title = $row['title'];
		$video_path = $row['video_path'];
		$description = $row['description'];
		$upload_date = $row['upload_date'];
		$user_id = $row['user_id'];

		$query = "SELECT * FROM USERS WHERE ID=$user_id";
		$result = $conn->query($query);

		$row = $result->fetch_array();
		$user_name = $row['username'];

		$conn->close();
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo($video_title);?></title>
	<link rel="stylesheet" href="style/style.css">
	<script src="jquery-3.5.1.min.js"></script>
</head>
<body>
	<div id="main_body">
		<div id="player">
			<iframe id='video_player' width="800" height="500" src=<?php echo($video_path);?> frameborder="0" allow="autoplay;" allowfullscreen></iframe>
			<h3 id="video_title" style='margin-bottom:10px'><?php echo($video_title);?></h3>
			<?php
				$conn = new mysqli('localhost', 'root', '', 'yt_db', '3308');
				if ($conn->connect_error) {
					die("Connection Failed to Database");
				}
				else {
					$query = "SELECT * FROM videos WHERE id=$video_id";
					$result = $conn->query($query);
					$r = $result->fetch_assoc();

					$likes = $r['likes'];
					$dislikes = $r['dislikes'];
					$overall = $likes - $dislikes;

					echo("<h3 style='margin-bottom:10px'>Score: <span id='score'>$overall</span> </h3>");
					
					$conn->close();
				}
			?>
			<?php
				if (isset($_SESSION['logged']) && $_SESSION['logged'] == 'yes') {
					$conn = new mysqli('localhost', 'root', '', 'yt_db', '3308');
					if ($conn->connect_error) {
						die("Connection Failed to Database");
					}
					else {
						$query = "SELECT * FROM likes WHERE vid_id=$video_id AND user_id=$user";
						if (!($conn->query($query))) {
							echo("SOME ERROR : " + $conn->error);
							die();
						}
						$res = $conn->query($query);
						if ($res->num_rows > 0) {
							echo("<img src='img/like.png' alt='like_button' width='25' height='25' id='like_button' style='filter: grayscale(0%);'>");
							echo("<img src='img/dislike.png' alt='dislike_button' width='25' height='25' style='margin-left:20px; filter: grayscale(100%);' id='dislike_button'>");
						}
						else {
							echo("<img src='img/like.png' alt='like_button' width='25' height='25' id='like_button' style='filter: grayscale(100%);'>");

							$query = "SELECT * FROM dislikes WHERE vid_id=$video_id AND user_id=$user";
							if (!($res = $conn->query($query))) {
								echo("Some error: " + $conn->error);
								die();
							}
							if ($res->num_rows > 0) {
								echo("<img src='img/dislike.png' alt='dislike_button' width='25' height='25' style='margin-left:20px; filter: grayscale(0%);' id='dislike_button'>");
							}
							else {
								echo("<img src='img/dislike.png' alt='dislike_button' width='25' height='25' style='margin-left:20px; filter: grayscale(100%);' id='dislike_button'>");
							}
						}
						$conn->close();
					}

				}
				else {
					echo ("<p style='color:red;font-family:'Lucida Grande';'>Please Sign in to Like/Dislike Video</p><br>");
				}
			?>
			<h4 id="user_name"><?php echo($user_name);?></h4>
			<h5 id="date">Uploaded on <?php echo($upload_date);?></h5>
			
			<hr id='line1'>

			<h3 id='comment_title'>Comments</h3>
			<div id="add_comment_section">
				<?php
					if (isset($_SESSION['logged']) && $_SESSION['logged'] == 'yes') {
						echo(
							"<div style='display:flex; flex-direction:row; margin-bottom: 40px'>
								<input type='text' name='comment' id='comment' placeholder='Enter Comment' id='add_comment' style='color:white;width: 790px;padding: 5px;font-size: 15px;border: solid #383838;background-color: #121212;' autocomplete='off'>
								<img src='img/comment.png' alt='comment_button' id='comment_button'>
							</div>"
						);
					}
					else {
						echo ("<p style='color:red;font-family:'Lucida Grande';'>Please Sign in to Comment on Video</p><br>");
					}
				?>
			</div>
			<div id="comment_section">
				<?php
					$conn = new mysqli('localhost', 'root', '', 'yt_db', '3308');
					if ($conn->connect_error) {
						die("Connection Failed to Database");
					}
					else {
						$query = "SELECT * FROM comments WHERE vid_id=$video_id ORDER BY date DESC";
						$result = $conn->query($query);
						
						while ($row = $result->fetch_array()) {		
							$comment = $row['comment'];
							$user = $row['user_id'];
							$date = $row['date'];

							$q = "SELECT * FROM USERS WHERE ID=$user";
							$r = $conn->query($q);
							$r = $r->fetch_assoc();
							$username = $r['username'];
							echo("<p id='c1'><strong>$username</strong> commented:</p><br>");
							echo("<p id='c2'>$comment</p><br>");
							echo("<p id='c3'>$date</p><br>");
						}
				
						$conn->close();
					}
				?>
			</div>
		</div>
	</div>
	
	<script> 
		document.addEventListener("DOMContentLoaded", function(){
			document.getElementById("comment_button").addEventListener("click", function() {
				process_comment(<?php echo($video_id) ?>);
			});

			document.getElementById("like_button").addEventListener("click", function() {
				process_like_dislike("like", <?php echo($video_id) ?>);
			});

			document.getElementById("dislike_button").addEventListener("click", function() {
				process_like_dislike("dislike", <?php echo($video_id) ?>);
			});
		});

		function process_comment(v_id) {
			var comment = document.getElementById("comment").value;
			document.getElementById("comment").value = "";

			$.ajax({
				type: "POST",
				url: 'store_comment.php?id=' + v_id,
				data: {
					comment : comment
				},
				success: function(response) {
					if (response == "Comment Saved") {
						update_comment_section(comment);
					}
					console.log("From backend " + response);
				}
			});
		}

		function update_comment_section(comment) {	
			var new_comm = "<p id='c1'><strong><?php echo($logged_username)?></strong> commented:</p><br><p id='c2'>" + comment + 
			"</p><br><p id='c3'><?php echo date("Y-m-d h:i:s", time()); ?></p><br>";
			
			document.getElementById('comment_section').innerHTML = new_comm + "<br>" + document.getElementById('comment_section').innerHTML;
		}

		function process_like_dislike(op, v_id) {
			$.ajax({
				type: "GET",
				url: 'alter_likes.php',
				data: {
					v_id : v_id,
					op: op
				},
				success: function(response) {
					var new_score = parseInt(document.getElementById("score").innerHTML);
					if (response == "like added") {
						new_score += 1;

						if (document.getElementById("dislike_button").style.filter == "grayscale(0%)") {
							new_score += 1;
							document.getElementById("dislike_button").style.filter = "grayscale(100%)"
						}
						document.getElementById("like_button").style.filter = "grayscale(0%)";
					}
					else if (response == "like removed") {
						new_score -= 1;

						document.getElementById("like_button").style.filter = "grayscale(100%)";
					}
					else if (response == "dislike removed") {
						new_score += 1;

						document.getElementById("dislike_button").style.filter = "grayscale(100%)";
					}
					else if (response == "dislike added") {
						new_score -= 1;

						if (document.getElementById("like_button").style.filter == "grayscale(0%)") {
							new_score -= 1;
							document.getElementById("like_button").style.filter = "grayscale(100%)"
						}

						document.getElementById("dislike_button").style.filter = "grayscale(0%)";
					}

					document.getElementById("score").innerHTML = new_score;
				}
			});
		}
	</script>

</body>
</html>
