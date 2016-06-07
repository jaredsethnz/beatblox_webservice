<?php
	// Include confi.php
	include_once('config.php');

	$uid = $_POST['nick'];
	if(!empty($uid)){
		$qur = mysqli_query($conn, "select * from `highscores`");
		$result =array();
		while($r = mysqli_fetch_array($qur)){
			extract($r);
			$result[] = array("nickname" => $nickname, "score" => $score); 
		}
		$json = array("status" => 1, "info" => $result);
	}else{
		$json = array("status" => 0, "msg" => "No scores available!");
	}
	@mysqli_close($conn);

	/* Output header */
	header('Content-type: application/json');
	echo json_encode($json);
