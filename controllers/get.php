<?php 
	header('Access-Control-Allow-Origin: *');
	require('../models/db.php');
	
	function getInfo($flag, $content) {
		$info = array('Flag' => $flag, 'Content' => $content);
		return $info;
	}

	/**
	*	根据url获取所有评论
	* 	@param url string 要获取评论的url
	*	@return comments array 该url下的所有评论
	*/
	$url = $_POST['url'];
	$result = get($url);
	if($result[0] > 0) {
		echo urldecode(json_encode(getInfo(1, $result[1])));
	} else {
		echo urldecode(json_encode(getInfo(result[0], '评论获取失败')));
	}

 ?>
