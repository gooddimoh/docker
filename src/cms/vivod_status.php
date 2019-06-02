<?
include "mysql.php";
if(isset($_GET[del])){ //---------- знищити заявку
	mysql_query("delete from katalog_vivod where id='$_GET[r]' ");
}else if(isset($_GET[alldel])){ //-- знищити всі заявки	mysql_query("delete from katalog_vivod");
}else if(isset($_GET[ok])){  //---------- провести заявку	$data=time();
	$zayava=mysql_fetch_array(mysql_query("select type,price,user from katalog_vivod where id='$_GET[r]'"));
    mysql_query("update katalog_user set balance=balance-$zayava[price] where id_p=$zayava[user]") or die(mysql_error());
    mysql_query("update katalog_vivod set status='1' where id='$_GET[r]' limit 1") or die(mysql_error());
    mysql_query("insert into katalog_finanse(inu,outu,add_data,type,status,price) values('$zayava[user]','$zayava[type]','$data','5','1','$zayava[price]')")or die(mysql_error());}else{   //--------------------------------- відхилити заявку	mysql_query("update katalog_vivod set status='2' where id='$_GET[r]' limit 1") or die(mysql_error());}
header("Location: vivod.html");
?>