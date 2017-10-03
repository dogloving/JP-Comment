<?php 
	header('Access-Control-Allow-Origin: *');
	function getInfo($flag, $content) {
		return array('Flag' => $flag, 'Content' => $content);
	}
	require('../models/db.php');

	/**
	*	将新评论存入数据库中
	*	@param nickname string 评论者昵称
	*	@param site string 评论者个人站点
	*	@param content 评论内容
	*	@param origin string 当前评论所属站点
	*	@param url string 当前评论所属站点的具体url
	*	@return result int 存储反馈
	*/
	$nickname = $_POST['nickname'];
	$site = $_POST['site'];
	$content = $_POST['content'];
	$origin = $_POST['origin'];
	$url = $_POST['url'];
	$result = save($nickname, $site, $content, $origin, $url);
	if($result[0] > 0) {
		echo urldecode(json_encode(getInfo(1, $result[1])));
	} else {
		echo urldecode(json_encode(getInfo(result[0], '评论失败')));
	}

 ?>
