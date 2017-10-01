<?php 
	require('../models/db.php');
	header('Access-Control-Allow-Origin: *');
	
	function getInfo($flag, $content) {
		return array('Flag' => $flag, 'Content' => $content);
	}

	/**
	*	根据url获取所有评论
	* 	@param url string 要获取评论的url
	*	@return comments array 该url下的所有评论
	*/

	$url = $_POST['url'];
	$result = save($url);
	if($result[0] > 0) {
		echo urldecode(json_encode(getInfo(1, $result[1])));
	} else {
		echo urldecode(json_encode(getInfo(result[0], '评论获取失败')));
	}

 ?>