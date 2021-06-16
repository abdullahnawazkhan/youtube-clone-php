<?php
	/* if (isset($_SESSION["logged"]) == false) {
		$_SESSION["msg"] = "Please Log in";
		header("Location:index.php");
		exit();
	}  
	 */
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Add Video</title>
	<link rel="stylesheet" href="style/style.css">
</head>
<body>
	<?php
	require('header.php');
	require('side_panel.php');
	?>
	<div id="main_body">
		<h2 id='title'>Add Video</h2>

		<form action="add_video_db.php" method="post" autocomplete="off" style="margin-left:15px;margin-top:25px">
			<input type="text" id="vtitle" name="vtitle" placeholder="Enter Title" style='margin-bottom:15px;height:30px;width:550px;font-size:20px'><br>
			<input type="text" id="link" name="link" placeholder="Enter YT Embedded Link" style='margin-bottom:15px;height:30px;width:550px;font-size:20px'><br>
			<input type="text" name="description" id="description" placeholder="Enter Description" style='margin-bottom:15px;height:30px;width:550px;font-size:20px'><br>
			<input type="text" name="img" id="T" placeholder="Enter Thumbnail link" style='margin-bottom:15px;height:30px;width:550px;font-size:20px'><br>
			<input type="text" name="category" id="category" placeholder="Enter Category" style='margin-bottom:15px;height:30px;width:550px;font-size:20px'><br>
			<input type="submit" name="submit" value="Submit" style="font-size:20px">
		</form>
		
		<!-- <form action="add_video_db.php" method="post" id="login">
			<input type="text" id="title" name="title" placeholder="Enter Title"><br>
			<input type="text" id="link" name="link" placeholder="Enter Link"><br>
			<input type="text" name="description" id="description" placeholder="Enter Description"><br>
			<input type="text" name="img_path" id="T" placeholder="Enter Thumbnail link"><br>
			<input type="text" name="category" id="category" placeholder="Enter Category"><br>
			<input type="submit" name="submit" value="Submit">
		</form> -->

	</div>
</body>
</html>
