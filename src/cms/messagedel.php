<?
include "mysql.php";
if(isset($_GET[id])){    mysql_query("delete from katalog_message where id='$_GET[id]' limit 1");}else if(isset($_GET[alldel])){
	mysql_query("delete from katalog_message");
}
header("Location:message.html");
?>