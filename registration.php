<?php
$firstname = $_POST['firstname'];
$lastname =$_POST['lastname']
$organisation =$_POST['organisation']
$email =$_POST['email']

if (!empty($firstname)) || !empty($lastname) || !empty($organisation) || !empty($email) {
	$host = "localhost";
	$dbUsername = "root";
	$dbPassword = "";
	$dbname = "registration";
	$conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);
	if (mysql_connect_error()) {
		die('Connect Error('. mysqli_connect_errno().')'.mysql_connect_error());
	}else{
		$SELECT = "SELECT email from register where email = ? limit 1";
		$INSERT = "INSERT Into register (firstname, lastname, organisation, email) values(?, ?, ?, ?,)";

		$stmt = $conn->prepare($SELECT);
		$stmt->bind_param("s", $email);
		$stmt-execute();
		$stmt->bind_result($email);
		$stmt->store_result();
		$rnum = $stmt->num_rows;

		if ($rnum==0) {
			$stmt->close();

			$stmt = $conn->prepare($INSERT);
			$stmt->bind_param("ssss", $firstname, $lastname, $organisation, $email);
			$stmt->execute();
			echo "new record inserted successfully";
		}else{
			echo "someone already registered using this email";
		}
		$stmt->close();
		$conn->close();
	}
	else{
		echo "all fields are required";
		die();
	}
?>