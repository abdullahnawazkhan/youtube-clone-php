<?php
	session_start();

	$user_name = $_POST["username"];
	$password = $_POST["password"];
	$r_password = $_POST["r_password"];
	$email = $_POST["email"];

	// validation if data is entered or not
	if ($user_name == "") {
		$_SESSION["msg"] = "Please Enter Username";
		header("Location:create_user.php");
		exit();
	}
	if ($password == "") {
		$_SESSION["msg"] = "Please Enter Password";
		header("Location:create_user.php");
		exit();
	}
	else {
		if (strlen($password) < 8) {
			$_SESSION["msg"] = "Password must be:<br>-Greater than 8 characters<br>-Have atleast 1 number";
			header("Location:create_user.php");
			exit();
		}
		else {
			$has_number = false;

			for ($i = 0; $i < strlen($password); $i++) {
				if (ord($password[$i]) > 47 && ord($password[$i]) < 58) {
					$has_number = true;
					break;
				}
			}

			if ($has_number == false) {
				$_SESSION["msg"] = "Password must be:\n-Greater than 8 characters\n-Have atleast 1 number";
				header("Location:create_user.php");
				exit();
			}
		}
	}

	if ($r_password == "") {
		$_SESSION["msg"] = "Please re-enter password";
		header("Location:create_user.php");
		exit();
	}
	if ($password != $r_password) {
		$_SESSION["msg"] = "Passwords do not match";
		header("Location:create_user.php");
		exit();
	}
	if ($email == "") {
		$_SESSION["msg"] = "Please Enter Email";
		header("Location:create_user.php");
		exit();
	}
	

	$conn = new mysqli('localhost', 'root', '', 'yt_db', '3308');

	if ($conn->connect_error) {
		die("Connection Failed to Database");
	}
	else {
		// checking if username already exists
		$query = "SELECT * FROM USERS WHERE username='$user_name'";
		$res = $conn->query($query);

		if ($res->num_rows > 0) {
			# username already exists
			$_SESSION["msg"] = "Username already taken.";
			$conn->close();
			header("Location:create_user.php");
			exit();
		}

		// checking if email already exists
		$query = "SELECT * FROM USERS WHERE email='$email'";
		$res = $conn->query($query);

		if ($res->num_rows > 0) {
			# username already exists
			$_SESSION["msg"] = "Email already in use.";
			$conn->close();
			header("Location:create_user.php");
			exit();
		}

		$query = "INSERT INTO USERS(username, password, email) VALUES('$user_name', '$password', '$email')";

		if ($conn->query($query)) {
			$_SESSION["msg"] = "User Created";
			$conn->close();
			header("Location:index.php");
			exit();
		}
		else {
			$_SESSION["msg"] = "Unable to create user";
			$conn->close();
			header("Location:create_user.php");
			exit();
		}

		$conn->close();
	}
?>
