<?php

function authenticateUser($db)
{
	if($_SERVER['REQUEST_METHOD'] == "POST"){
	// Get data
	$nickname = filter_input(INPUT_POST, 'nick');
	$password = filter_input(INPUT_POST, 'pass');

	// Get data from database
	$sql = "select * from `player` where nickname = '$nickname'";
	$qur = $db->query($sql)->fetch();
	
	if($qur){
		if (password_verify($password, $qur->fetch_array()['passwordhash']))
		{
			return true;
		}
		else
		{
			return false;
		}
		
	}else{
		return false;
	}
  }
}

function getScore($db)
{
	$nick = $_POST['nick'];
	$sql = "select * from `highscores` where playernickname = '$nick' limit 1";
	$qur = $db->query($sql)->fetch();
	$result =array();
	while($r = $qur->fetch_array()){
		//var_dump($r);
		$result[] = array("playernickname" => $r['playernickname'], "score" => $r['score']); 
	}
	$json = array("status" => 1, "info" => $result);
	
	@mysqli_close($conn);

	/* Output header */
	header('Content-type: application/json');
	echo json_encode($json);
}

function getScores($db)
{
	$sql = "select * from `highscores` order by score desc";
	$qur = $db->query($sql)->fetch();
	$result =array();
	while($r = $qur->fetch_array()){
		//var_dump($r);
		$result[] = array("playernickname" => $r['playernickname'], "score" => $r['score']); 
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

	// Insert data into data base
	$sql = "select * from `highscores` where playernickname = '$nick'";
	if ($db->query($sql)->size() > 0) {
		$sql = "UPDATE highscores SET score = '$score' WHERE playernickname = '$nick'";
	} else {
		$sql = "INSERT INTO `highscores` VALUES ('$nick', '$score')";
	}
	echo "$sql";
	$qur = $db->query($sql);
	if($qur){
		$json = array("status" => 1, "msg" => "true");
	}else{
		$json = array("status" => 0, "msg" => "false");
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
	$sql = "select * from `player` where nickname = '$nick'";
	$qur = $db->query($sql)->size();

	if($qur == 0){
		$json = array("status" => 1, "msg" => "true");
	}else{
		$json = array("status" => 0, "msg" => "false");
	}
}else{
	$json = array("status" => 0, "msg" => "Request method not accepted");
  }
	header('Content-type: application/json');
	echo json_encode($json);
}

function registerUser($db)
{
	if($_SERVER['REQUEST_METHOD'] == "POST"){
	// Get data
	$nickname = filter_input(INPUT_POST, 'nick');
	$password = filter_input(INPUT_POST, 'pass');

	$passwordHash = password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]);
	if ($passwordHash === false)
	{
		echo "Password hash failed";
	}

	// Get data from database
	$sql = "insert into player values ('$nickname', '$passwordHash')";
	$qur = $db->query($sql);
	if($qur){
		$json = array("status" => 1, "msg" => "true");
	}else{
		$json = array("status" => 0, "msg" => "false");
	}
}else{
	$json = array("status" => 0, "msg" => "Request method not accepted");
  }
	header('Content-type: application/json');
	echo json_encode($json);
	}

function checkLogin($db)
{
	if($_SERVER['REQUEST_METHOD'] == "POST"){
	// Get data
	$nickname = filter_input(INPUT_POST, 'nick');
	$password = filter_input(INPUT_POST, 'pass');

	// Get data from database
	$sql = "select * from `player` where nickname = '$nickname'";
	$qur = $db->query($sql)->fetch();
	
	if($qur){
		$json = array("status" => 1, "msg" => "true");
		if (password_verify($password, $qur->fetch_array()['passwordhash']))
		{
			$json = array("status" => 0, "msg" => "true");
		}
		else
		{
			$json = array("status" => 0, "msg" => "false");
		}
		
	}else{
		$json = array("status" => 0, "msg" => "false");
	}
}else{
	$json = array("status" => 0, "msg" => "Request method not accepted");
  }
	header('Content-type: application/json');
	echo json_encode($json);
	}

