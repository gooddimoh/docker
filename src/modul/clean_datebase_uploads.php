<?php
include ('mysql.php');
echo 'test';
    $_SERVER['DOCUMENT_ROOT'] = dirname(__FILE__) . '/..';

 $clean_time = strtotime("-2 week");
 
 $q = mysql_query('SELECT url FROM katalog_files WHERE data_create <= ' . $clean_time);
 
 //var_dump($q);
 
 while($res = mysql_fetch_assoc($q))
 {
   @unlink($_SERVER["DOCUMENT_ROOT"].'/'.$res['url']);
 }
 
 mysql_query('DELETE FROM katalog_files WHERE data_create <= ' . $clean_time);

?>