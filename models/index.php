<?php
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
   $sql = sprintf("select * from site where url = '%s';", 'line1');
//   $sql = sprintf("insert into SITE values('%s', '%s', '%s')", 'line1', 'line2', 'line3');
echo $sql;
$db = new Sqlite3('comments.db');
   $ret = $db->query($sql);
   while($row = $ret->fetchArray()){
$result = $row;
echo $row;
echo $row[0];
echo count($row);
  }
echo $result;
echo'<br/>'. $row[0];
   $db->close();
?>
