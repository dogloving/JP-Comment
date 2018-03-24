<?php
	header('Access-Control-Allow-Origin: *');
	function getInfo($flag, $content) {
		return array('Flag' => $flag, 'Content' => $content);
    }
try {
	/**
	*	将新评论存入数据库中
	*	@param nickname string 评论者昵称
	*	@param site string 评论者个人站点
	*	@param content 评论内容
	*	@param origin string 当前评论所属站点
	*	@param url string 当前评论所属站点的具体url
	*	@return result int 存储反馈
	*/
    $db = new SQLite3('comments.db');
	$nickname = $_POST['nickname'];
	$sites = $_POST['site'];
	$content = $_POST['content'];
	$origin = $_POST['origin'];
    $url = $_POST['url'];
    $date = $_POST['datee'];

		// 检查表Site
	$sql = sprintf("select number from site where url = '%s'", $url);
	$site = $db->query($sql);
	$count = 0;
	while($row = $site->fetchArray()) {
		$count++;
		$number = $row['number'];
		$sql = sprintf("update site set number = '%d'", $number + 1);
		$db->query($sql);
	}
	if($count == 0) {
		$number = 1;
		$sql = sprintf("insert into site values('%s', '%s', '%d')", $url, $origin, $number);
        $db->query($sql);
	}
	// 检查User
	$uid = md5($nickname.$sites);
	$sql = sprintf("select headicon from user where uid = '%s'", $uid);
	$user = $db->query($sql);
	$count = 0;
    $headicon = '';
	while($row = $user->fetchArray()) {
		$count++;
		$headicon = $row['headicon'];
	}
	if($count == 0) {
        $headicons = array('1.jpg', '2.jpg', '3.jpg', '4.jpg', '5.jpg', '6.jpg', '7.jpg', '8.jpg', '9.jpg', '10.jpg', '11.jpg', '12.jpg',
            '13.jpg', '14.jpg', '15.jpg', 'uh_1.gif', 'uh_2.gif', 'uh_3.gif', 'uh_4.gif', 'uh_5.gif', 'uh_6.gif', 'uh_7.gif', 'uh_8.gif', 'uh_9.gif');
		$headicon = 'https://www.nkuhjp.com/JP-Comment/assets/img/'.$headicons[array_rand($headicons, 1)];
        $uid = md5($uid.$date);
		$sql = sprintf("insert into user values('%s', '%s', '%s', '%s')", $uid, $nickname, $headicon, $sites);
        $db->query($sql);
	}
	// 检查Comment
    $cid = md5($date.$uid);
	$sql = sprintf("insert into comments values('%s', '%s', '%s', '%s', '%s')", $cid, $url, $uid, $date, $content);
	$comment = $db->query($sql);
	$count = 0;
    echo urldecode(json_encode(getInfo(1, array('nickname' => $nickname, 'headicon' => $headicon, 'content' => $content, 'date' => $date, 'site' => $sites))));
} catch(Exception $e) {
    echo urldecode(json_encode(getInfo(-1, $e->getMessage())));
}
$db->close();
 ?>
