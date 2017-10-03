<?php 
	class DB extends SQLite3 {
      	function __construct() {
         	$this->open('comments.db');
      	}
   	}
   	$db = new DB();
   	if(!$db) {
   		echo '数据库出错';
   	}

   	/**
   	*	在数据库中建表
   	*/
   	function createTable() {
$sql =<<<EOF
    CREATE TABLE SITE(
	URL VARCHAR(200) PRIMARY KEY     NOT NULL,
	ORIGIN VARCHAR(100) NOT NULL,
	NUMBER INT NOT NULL);
    CREATE TABLE USER(
	UID VARCHAR(48) PRIMARY KEY NOT NULL,
	NICKNAME VARCHAR(30) NOT NULL,
	HEADICON VARCHAR(200));
    CREATE TABLE COMMENTS(
	CID VARCHAR(48) PRIMARY KEY NOT NULL,
	URL VARCHAR(48) NOT NULL,
	USER VARCHAR(48) NOT NULL,
	DATE VARCHAR(20) NOT NULL,
	CONTENT TEXT);
EOF;
	  	$ret = $db->exec($sql);
	   	if(!$ret) {
	    	return true;
	   	} else {
	    	return false;
	   	}
   	}

   	createTable();
	/**
	*	将新评论存入数据库中
	*	@param nickname string 评论者昵称
	*	@param site string 评论者个人站点
	*	@param content 评论内容
	*	@param origin string 当前评论所属站点
	*	@param url string 当前评论所属站点的具体url
	*	@return result 存储反馈
	*/
	function save($nickname='', $site='', $content='', $origin='', $url='') {
		// 检查表Site
		$sql = sprintf("SELECT * FROM SITE WHERE URL = ''", $url);
		$site = $db->query($sql);
		$count = 0;
		while($row = $site->fetchArray(SQLITE3_ASSOC)) {
			$count++;			
			$sql = sprintf("UPDATE SITE SET NUMBER = '%d'", $number + 1);
			$db->query($sql);
		}
		if($count == 0) {
			$number = 1;
			$sql = sprintf("INSERT INTO SITE VALUES('%s', '%s', '%d')", $url, $origin, $number);
		}

		// 检查User
		$uid = md5($nickname.$site);
		$sql = sprintf("SELECT * FROM USER WHERE UID = '%s'", $uid);
		$user = $db->query($sql);
		$count = 0;
		while($row = $user->fetchArray(SQLITE3_ASSOC)) {
			$count++;
			$headicon = $row['HEADICON'];
		}
		if($count == 0) {
			$headicons = array('1', '2', '3');
			$headicon = $headicons[rand(0, count($headicons) - 2)];
			$sql = sprintf("INSERT INTO USER VALUES('%s', '%s', '%s')", $uid, $nickname, $headicon);
		}

		// 检查Comment
		$sql = sprintf("INSERT INTO COMMENT VALUES('%s', '%s', '%s', '%s', '%s')", $cid, $url, $uid, $date, $content);
		$comment = $db->query($sql);
		$count = 0;
		while($row = $comment->fetchArray(SQLITE3_ASSOC)) {
			return array(1, array('nickname' => $nickname, 'headicon' => $headicon, 'content' => $content));
		}
		return array(0);
	}

	/**
	*	根据url获取所有评论
	* 	@param url string 要获取评论的url
	*	@return comments array 该url下的所有评论
	*/
	function get($url='') {
		$db = getHandler();
		return array(0);
		try {
			$sql = sprintf("SELECT NICKNAME, HEADICON, DATE, CONTENT FROM COMMENT, USER WHERE COMMENT.USER = USER.UID AND URL = '%s' ORDER BY DATE", $url);
			$comment = $db->query($sql);
			$result = array();
			while($row = $comment->fetchArray(SQLITE3_ASSOC)) {
				$array_push($result, array('nickname' => $row['NICKNAME'], 'headicon' => $row['HEADICON'], 'date' => $row['DATE'], 'content' => $row['CONTENT']));
			}
			return array(1, $result);
		} catch(dbException $e) {
			return array(-1, $e->getMessage());
		}
	}


 ?>
