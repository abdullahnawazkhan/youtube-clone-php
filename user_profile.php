<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link rel="stylesheet" href="style/style.css"> 
</head>
<body>
	<?php 
		require('header.php');
	?>
	<?php
		require('side_panel.php');
	?>

	<div id="main_body">
		<div id='profile_portion'>
			<h1 id='user_p'>User Profile</h1>
			<?php
				$user_id = $_GET['id'];
				
				$conn = new mysqli('localhost', 'root', '', 'yt_db', '3308');
				if ($conn->connect_error) {
					die("Connection Failed to Database");
				}
				
				$q = "SELECT * FROM users WHERE ID=$user_id";
				$result = $conn->query($q);
				$result = $result->fetch_assoc();
				$name = $result['username'];

				echo("<h2 id='name'>$name</h2>");
				
			?>
			<div id='options'>
				<?php
					echo("<div id='option' style='display:flex;'>");
					echo("<a  href='user_profile.php?op=1&id=$user_id'>VIDEOS</a>");
					echo("<a href='user_profile.php?op=2&id=$user_id'>COMMENTS</a>");
					echo("<a href='user_profile.php?op=3&id=$user_id'>LIKES</a>");
					echo("<a href='user_profile.php?op=4&id=$user_id'>DISLIKES</a>");
					echo("</div>");
				?>
			</div>
			<hr id='line'>
			<div>
				<?php
					$option = $_GET['op'];
					if ($option == '1') {
						// displaying videos uploaded by user						
						$query = "SELECT * FROM videos WHERE user_id=$user_id";
						$result = $conn->query($query);

						$count = 0;
						echo("<h2 id='heading'>Videos Uploaded</h2>");
						echo("<div id='video_area'><table style='border-spacing: 30px;margin-top:-5px;margin-left:-25px'>");
						echo("<tr>");
						while ($row = $result->fetch_assoc()) {
							if ($count == 4) {
								echo("</tr>");
								echo("<tr>");
							}
							$img = $row['img_path'];
							$video_title = $row['title'];
							$vid_id = $row['id'];
							$upload = $row['upload_date'];
							
							$upload = new DateTime(date('Y-m-d H:i:s', strtotime($upload)));
							$current = new DateTime(date('Y-m-d H:i:s'));
							$diff = $upload->diff($current);
							$diff = $diff->format('%h hours %i mins');

							$vid_link = "video_page.php?id=$vid_id";
							echo("<td>");
							echo("<a href=$vid_link><img src=$img alt='video' width='300' height='200'></a><br>");
							echo("<a href=$vid_link><strong>$video_title</strong></a><br>");
							echo("$diff ago");
							echo("</td>");
							$count++;
						}
						echo("</tr>");
						echo("</table></div>");

						$conn->close();
					}
					elseif ($option == '2') {
						// display comments made by user	
						echo("<h3 id='heading'>Comments Made on Videos</h3>");
						$query = "SELECT * FROM comments WHERE user_id=$user_id";
						$result = $conn->query($query);
						while ($row = $result->fetch_assoc()) {
							$comment = $row['comment'];
							
							$vid = $row['vid_id'];
							$q = "SELECT * FROM videos WHERE id=$vid";
							$r = $conn->query($q);
							$r = $r->fetch_assoc();
							$title = $r['title'];

							echo("<br><br><div style='font-size:18px;font-family:sans-serif;'>Commented On: $title</div><br>");
							echo("<div style='font-size:16px;font-family:sans-serif;margin-top:-10px'>$comment</div>");
						}
						$conn->close();
					}
					elseif ($option == '3') {
						// display videos liked by user						
						$query = "SELECT * FROM likes WHERE user_id=$user_id";
						$result = $conn->query($query);

						$count = 0;
						echo("<h2 id='heading'>Videos Liked</h2>");
						echo("<div id='video_area'><table style='border-spacing: 30px;margin-top:-5px;margin-left:-25px'>");
						echo("<tr>");
						while ($row = $result->fetch_assoc()) {
							if ($count == 4) {
								echo("</tr>");
								echo("<tr>");
							}
							$vid_id = $row['vid_id'];
							$q = "SELECT * FROM videos WHERE ID=$vid_id";
							$r = $conn->query($q);
							$r = $r->fetch_assoc();

							$img = $r['img_path'];
							$video_title = $r['title'];
							$upload = $r['upload_date'];
							
							$upload = new DateTime(date('Y-m-d H:i:s', strtotime($upload)));
							$current = new DateTime(date('Y-m-d H:i:s'));
							$diff = $upload->diff($current);
							$diff = $diff->format('%h hours %i mins');

							$vid_link = "video_page.php?id=$vid_id";
							echo("<td>");
							echo("<a href=$vid_link><img src=$img alt='video' width='300' height='200'></a><br>");
							echo("<a href=$vid_link><strong>$video_title</strong></a><br>");
							echo("$diff ago");
							echo("</td>");
							$count++;
						}
						echo("</tr>");
						echo("</table></div>");

						$conn->close();
					}
					else {
						// display videos disliked by user						
						$query = "SELECT * FROM dislikes WHERE user_id=$user_id";
						$result = $conn->query($query);

						$count = 0;
						echo("<h2 id='heading'>Videos Disliked</h2>");
						echo("<div id='video_area'><table style='border-spacing: 30px;margin-top:-5px;margin-left:-25px'>");
						echo("<tr>");
						while ($row = $result->fetch_assoc()) {
							if ($count == 4) {
								echo("</tr>");
								echo("<tr>");
							}
							$vid_id = $row['vid_id'];
							$q = "SELECT * FROM videos WHERE ID=$vid_id";
							$r = $conn->query($q);
							$r = $r->fetch_assoc();

							$img = $r['img_path'];
							$video_title = $r['title'];
							$upload = $r['upload_date'];
							
							$upload = new DateTime(date('Y-m-d H:i:s', strtotime($upload)));
							$current = new DateTime(date('Y-m-d H:i:s'));
							$diff = $upload->diff($current);
							$diff = $diff->format('%h hours %i mins');

							$vid_link = "video_page.php?id=$vid_id";
							echo("<td>");
							echo("<a href=$vid_link><img src=$img alt='video' width='300' height='200'></a><br>");
							echo("<a href=$vid_link><strong>$video_title</strong></a><br>");
							echo("$diff ago");
							echo("</td>");
							$count++;
						}
						echo("</tr>");
						echo("</table></div>");

						$conn->close();
					}
				?>
			</div>
		</div>
	</div>
</body>
</html>