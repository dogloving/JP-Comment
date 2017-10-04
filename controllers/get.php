<?php
	header('Access-Control-Allow-Origin: *');
	function getInfo($flag, $content) {
		$info = array('Flag' => $flag, 'Content' => $content);
		return $info;
	}
    class DB extends SQLite3 {
        function __construct() {
            $this->open('comments.db');
        }
    }
   try {
	/**
	*	根据url获取所有评论
	* 	@param url string 要获取评论的url
	*	@return comments array 该url下的所有评论
	*/
    $db = new DB();
	$url = $_POST['url'];
    $sql = sprintf("select * from comments,user where comments.user = user.uid and url = '%s' order by date", $url);
	$comment = $db->query($sql);
    $result = array();
    while($row = $comment->fetchArray(SQLITE3_ASSOC)) {
        $nickname = $row['NICKNAME'];
        $headicon = $row['HEADICON'];
        $date = $row['DATE'];
        $content = $row['CONTENT'];
		array_push($result, array('nickname' => $nickname, 'headicon' => $headicon, 'date' => $date, 'content' => $content));
    }
    echo urldecode(json_encode(getInfo(1, $result)));
   } catch(Exception $e) {
        echo urldecode(json_encode(getInfo(-1, $e->getMessage())));
    }
 ?>
