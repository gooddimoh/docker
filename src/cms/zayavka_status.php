<?
include "mysql.php";
if(isset($_GET[ok])){	mysql_query("update katalog_user set resh='1',changing='0' where id_p='$_GET[r]' limit 1")or die(mysql_error());}else{	mysql_query("update katalog_user set resh='0',changing='0' where id_p='$_GET[r]' limit 1")or die(mysql_error());}
header("Location: zayavka.html");
?>