<?php
	$conn = new mysqli('localhost', 'root', '', 'yt_db', '3308');

	if ($conn->connect_error) {
		die("Connection Failed to Database");
	}

	if (isset($_GET['acc']) && $_GET['acc'] == 'guest'){
		$_SESSION['logged'] = 'no';
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="style/style.css">
	<title>Youtube</title>
</head>
<body>
	<?php 
		require('header.php');
	?>

	<?php 
		require('side_panel.php');
	?>

	<div id="main_body">		
		<div id="video_area">
			<h3 id='title'>Videos</h3>
			<table style='border-spacing: 30px;margin-top:-5px'>
				<?php
					$query = "SELECT * FROM videos LIMIT 20";
					$result = $conn->query($query);
					
					$count = 0;
					echo("<tr>");
					while ($row = $result->fetch_assoc()) {
						/* echo("$row , $j<br>"); */
						if ($count == 4) {
							echo("</tr>");
							echo("<tr>");
							$count = 0;
						}

						$img = $row['img_path'];
						$video_title = $row['title'];
						$vid_id = $row['id'];
						$upload = $row['upload_date'];
						$user_id = $row['user_id'];

						$q = "SELECT * FROM users WHERE ID=$user_id";
						$res = $conn->query($q);
						$r = $res->fetch_assoc();
						$username = $r['username'];

						$upload = new DateTime(date('Y-m-d H:i:s', strtotime($upload)));
						$current = new DateTime(date('Y-m-d H:i:s'));
						$diff = $upload->diff($current);
						$diff = $diff->format('%h hours %i mins');

						$vid_link = "video_page.php?id=$vid_id";
						echo("<td>");
						echo("<a href=$vid_link><img src=$img alt='video' width='300' height='200'></a><br>");
						echo("<a href=$vid_link><strong>$video_title</strong></a><br>");
						echo("<a href=$vid_link>$username</a><br>");
						echo("$diff ago");
						echo("</td>");
						$count++;
					}
					echo("</tr>");

					$conn->close();
				?>
			</table>
		</div>
	</div>
</body>
</html>