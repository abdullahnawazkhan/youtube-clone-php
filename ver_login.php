<?php
	session_start();

	$user_name = $_POST["username"];
	$password = $_POST["password"];

	$conn = new mysqli('localhost', 'root', '', 'yt_db', '3308');

	if ($conn->connect_error) {
		die("Connection Failed to Database");
	}
	else {
		$query = "SELECT * FROM USERS WHERE username='$user_name' AND password='$password'";

		$result = $conn->query($query);
		$res = $result->fetch_assoc();

		if ($result->num_rows != 0) {
			$loc = "homepage.php";
			$_SESSION["logged"] = "yes";
			$_SESSION["user_id"] = $res['ID'];
		}
		else {
			$_SESSION["msg"] = "Unvalid Username/Password Combo";
			$loc = "index.php";
		}
		$conn->close();
		header("Location:$loc");
	}
?>
