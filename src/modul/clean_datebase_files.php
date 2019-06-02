<?php
include ('mysql.php');
//echo 'test';
    $_SERVER['DOCUMENT_ROOT'] = dirname(__FILE__) . '/..';

 $clean_time = strtotime("-1 month");
 
 $q = mysql_query('SELECT add_time,url,urlresh FROM katalog_zadach WHERE add_time <= ' . $clean_time);
 //$q1 = mysql_query('update katalog_zadach set price=301 WHERE id=7986 ');

 //var_dump($q);
 
 while($res = mysql_fetch_assoc($q))
 {
   @unlink($_SERVER["DOCUMENT_ROOT"].'/'.$res['url']);
   @unlink($_SERVER["DOCUMENT_ROOT"].'/'.$res['urlresh']);
 }

?>