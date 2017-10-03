<?php
echo phpinfo();
class MyDB extends SQLite3
   {
      function __construct()
      {
         $this->open('comments.db');
      }
   }
   $db = new MyDB();
   if(!$db){
      echo $db->lastErrorMsg();
   } else {
      echo "Opened database successfully\n";
   }

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
   if(!$ret){
      echo $db->lastErrorMsg();
   } else {
      echo "Table created successfully\n";
   }
   
   $sql = sprintf("select * from SITE where URL = '%s'", 'site');
   $ret = $db->query($sql);
   while($row = $ret->fetchArray(SQLITE3_ASSOC) ){
	echo '<br/>'.row['URL'];
	echo '<br/>'.row['ORIGIN'];
	echo 'hahahaha';
   }
   echo 'fuck';
   $db->close();
?>
