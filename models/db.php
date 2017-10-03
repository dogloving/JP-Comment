<?php 
	function getHandler(){
		$host = 'localhost';
		$database = 'comments';
		$username = 'root';
		$password = '';
		$pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$pdo->exec('set names "utf8"');
		return $pdo;
	}

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
		$pdo = getHandler();
		try {
			// 检查表Site
			$sql = sprintf("SELECT * FROM Site WHERE url = ''", $url);
			$site = $pdo->query($sql);
			if($site->rowCount()) {
				foreach ($site as $row) {
					$number = $row['number'];
				}
				$sql = sprintf("UPDATE Site SET number = '%d'", $number + 1);
				$pdo->query($sql);
			} else {
				$number = 1;
				$sql = sprintf("INSERT INTO Site VALUES('%s', '%s', '%s')", $url, $origin, $number);
			}

			// 检查User
			$uid = md5($nickname.$site);
			$sql = sprintf("SELECT * FROM User WHERE uid = '%s'", $uid);
			$user = $pdo->query($sql);
			if($user->rowCount()) {
				foreach ($user as $row) {
					$headicon = $row['headicon'];
				}
			} else {
				$headicons = array('1', '2', '3');
				$headicon = $headicons[rand(0, count($headicons) - 2)];
				$sql = sprintf("INSERT INTO User VALUES('%s', '%s', '%s')", $uid, $nickname, $headicon);
			}

			// 检查Comment
			$sql = sprintf("INSERT INTO Comment VALUES('%s', '%s', '%s', '%s', '%s')", $cid, $url, $uid, $date, $content);
			$comment = $pdo->query($sql);
			if($comment.rowCount()) {
				return array(1, array('nickname' => $nickname, 'headicon' => $headicon, 'content' => $content));
			} else {
				return array(0);
			}
		} catch(PDOException $e) {
			return array(-1, $e->getMessage());
		}
	}

	/**
	*	根据url获取所有评论
	* 	@param url string 要获取评论的url
	*	@return comments array 该url下的所有评论
	*/
	function get($url='') {
		$pdo = getHandler();
		return array(0);
		try {
			$sql = sprintf("SELECT nickname, headicon, date, content FROM Comment, User WHERE Comment.user = User.uid AND url = '%s' ORDER BY date", $url);
			$comment = $pdo->query($sql);
			$result = array();
			if($comment.rowCount()) {
				foreach ($comment as $row) {
					$array_push($result, array('nickname' => $row['nickname'], 'headicon' => $row['headicon'], 'date' => $row['date'], 'content' => $row['content']));
				}
				return array(1, $result);
			}
			return array(0);
		} catch(PDOException $e) {
			return array(-1, $e->getMessage());
		}
	}


 ?>
