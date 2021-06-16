<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Create New User</title>
	<style>
		body {
		padding: 0;
		margin: 0;
		}

		#container {
			margin: auto;
			width: 350px;
			height: 350px;
			color: white;
			background-color: #5BC0EB;
			padding: 10px;
		}

		#new_user {
			display: flex;
			flex-direction: column;
		}

		.field {
			font-size: 20px;
			margin-bottom: 5px;
		}

		#submit {
			font-size: 20px;
			margin-bottom: 40px;
		}

		#new_user {
			color: white;
			font-size: 20px;
			text-decoration: none;
		}

		#new_user:hover {
			color:yellow;
		}

		#guest {
			color: white;
			font-size: 20px;
			text-decoration: none;
			margin-left: 45px;
		}

		#guest:hover {
			color:yellow;
		}
	</style>
</head>
<body>
	<div id='container'>
		<h1>Create User</h1>
		<div id="error">
				<?php
					session_start();

					if (isset($_SESSION["msg"])) {
						echo("{$_SESSION['msg']}"."<br>");
						unset($_SESSION["msg"]);
					}
				?>
			</div>
		<form action="add_user.php" method="post" id='new_user' autocomplete="off">
			<input type="text" class="field" name="username" placeholder="ENTER USERNAME"><br>
			
			<input type="password" class="field" name="password" placeholder="ENTER PASSWORD"><br>
			
			<input type="password" class="field" name="r_password" placeholder="RE-ENTER PASSWORD"><br>

			<input type="email" name="email" class="field" placeholder="ENTER EMAIL"><br>

			<input type="submit" name="submit" id='submit' value="Submit">
		</form>
	</div>
	<?php

	?>
</body>
</html>
