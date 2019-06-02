<?
include "mysql.php";
if($_POST[typ]==1){
	mysql_query("update katalog_user set balance=balance+$_POST[add] where id_p='$_GET[id]'");
}else{	mysql_query("update katalog_user set balance=balance-$_POST[add] where id_p='$_GET[id]'");}
print_r($_GET);
print_r($_POST);
//header("Location:katalog_redag.html?r=".$_GET[id]);
?>