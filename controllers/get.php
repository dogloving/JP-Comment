<?php
	header('Access-Control-Allow-Origin: *');
	function getInfo($flag, $content) {
		$info = array('Flag' => $flag, 'Content' => $content);
		return $info;
	}
   try {
	/**
	*	根据url获取所有评论
	* 	@param url string 要获取评论的url
	*	@return comments array 该url下的所有评论
	*/
    $db = new SQLite3('comments.db');
	$url = $_POST['url'];
    $sql = sprintf("select * from comments,user where comments.uid = user.uid and url = '%s' order by date", $url);
	$comment = $db->query($sql);
    $result = array();
    while($row = $comment->fetchArray()) {
        $nickname = $row['nickname'];
        $headicon = $row['headicon'];
        $date = $row['date'];
        $content = $row['content'];
        $site = $row['sites'];
		array_push($result, array('nickname' => $nickname, 'headicon' => $headicon, 'date' => $date, 'content' => $content, 'site' => $site));
    }
    echo urldecode(json_encode(getInfo(1, $result)));
   } catch(Exception $e) {
    echo urldecode(json_encode(getInfo(-1, $e->getMessage())));
    }
    $db->close();
 ?>
