<?php

// Include confi.php
include_once('config.php');

if($_SERVER['REQUEST_METHOD'] == "POST"){
	// Get data
	$nick = $_POST['nick'];
	$score = $_POST['score'];
	// $password = isset($_POST['pwd']) ? mysql_real_escape_string($_POST['pwd']) : "";
	// $status = isset($_POST['status']) ? mysql_real_escape_string($_POST['status']) : "";
	echo $nick . '<br>';
	echo $score . '<br>';

	// Insert data into data base
	$sql = "INSERT INTO `highscores` VALUES (NULL, '$nick', '$score');";
	echo "$sql";
	$qur = mysqli_query($conn, $sql);
	if($qur){
		$json = array("status" => 1, "msg" => "Done User added!");
	}else{
		$json = array("status" => 0, "msg" => "Error adding user!");
	}
}else{
	$json = array("status" => 0, "msg" => "Request method not accepted");
}

@mysqli_close($conn);

/* Output header */
header('Content-type: application/json');
echo json_encode($json);