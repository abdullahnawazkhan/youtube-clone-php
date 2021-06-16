<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
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

		#login {
			display: flex;
			flex-direction: column;
		}

		#username {
			font-size: 20px;
			margin-bottom: 15px;
		}

		#password {
			font-size: 20px;
			margin-bottom: 15px;
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
	<title>Login</title>
</head>
<body>
	<div id="container">
		<h2>Login</h2>
		<div id="msg-area">
			<?php
				session_start();

				if (isset($_SESSION["msg"])) {
					echo("{$_SESSION['msg']}"."<br>");
					unset($_SESSION["msg"]);
				}

				unset($_SESSION['logged']);
				unset($_SESSION['user_id']);
			?>
		</div>
		<form action="ver_login.php" method="post" id="login" autocomplete='off'>
			<input type="text" id="username" name="username" placeholder="User Name">
			
			<input type="password" id="password" name="password" placeholder="password">
			
			<input type="submit" name="submit" id='submit' value="Submit">
		</form>

		<a href="create_user.php" class="button" id='new_user'>Create New User</a>

		<a href="homepage.php?acc=guest" class="button" id='guest'>Continue as Guest</a>
	</div>
</body>
</html>
