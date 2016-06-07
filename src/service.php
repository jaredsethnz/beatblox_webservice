<?php

function authenticateUser($db)
{
	return true;
}

function getScores($db)
{
	$sql = "select * from `highscores`";
	$qur = $db->query($sql)->fetch();
	$result =array();
	while($r = $qur->fetch_array()){
		//var_dump($r);
		$result[] = array("nickname" => $r['nickname'], "score" => $r['score']); 
	}
	$json = array("status" => 1, "info" => $result);
	
	@mysqli_close($conn);

	/* Output header */
	header('Content-type: application/json');
	echo json_encode($json);
}

function addScore($db)
{
	if($_SERVER['REQUEST_METHOD'] == "POST"){
	// Get data
	$nick = $_POST['nick'];
	$score = $_POST['score'];
	$email = $_POST['email'];

	// Insert data into data base
	$sql = "INSERT INTO `highscores` VALUES (NULL, '$nick', '$email', '$score')";
	$qur = $db->query($sql);
	if($qur){
		$json = array("status" => 1, "msg" => "Done User added!");
	}else{
		$json = array("status" => 0, "msg" => "Error adding user!");
	}
}else{
	$json = array("status" => 0, "msg" => "Request method not accepted");
  }

/* Output header */
header('Content-type: application/json');
echo json_encode($json);
}

function checkNickname($db)
{
	if($_SERVER['REQUEST_METHOD'] == "POST"){
	// Get data
	$nick = $_POST['nick'];
	// Insert data into data base
	$sql = "select * from `highscores` where nickname = '$nick'";
	$qur = $db->query($sql)->size();

	if($qur == 0){
		$json = array("status" => 1, "msg" => "available");
	}else{
		$json = array("status" => 0, "msg" => "used");
	}
}else{
	$json = array("status" => 0, "msg" => "Request method not accepted");
  }
	header('Content-type: application/json');
	echo json_encode($json);
}

function checkEmail($db)
{
	if($_SERVER['REQUEST_METHOD'] == "POST"){
	// Get data
	$email = $_POST['email'];
	// Insert data into data base
	$sql = "select * from `highscores` where email = '$email'";
	$qur = $db->query($sql)->size();

	if($qur == 0){
		$json = array("status" => 1, "msg" => "available");
	}else{
		$json = array("status" => 0, "msg" => "used");
	}
}else{
	$json = array("status" => 0, "msg" => "Request method not accepted");
  }
	header('Content-type: application/json');
	echo json_encode($json);
}