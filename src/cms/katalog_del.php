<?
include "mysql.php";
$r = mysql_query("SELECT * FROM katalog where id='$_GET[r]'")or die(mysql_error());
$fk=mysql_fetch_array($r);

//--unsort
$sortr = mysql_query("SELECT * FROM katalog where id_p='$fk[id_p]' and menu_sort>'$fk[menu_sort]'")or die(mysql_error());
for($i=0;$i<mysql_num_rows($sortr);$i++){
	$sortf=mysql_fetch_array($sortr);
	$sortf[menu_sort]=$sortf[menu_sort]-1;
	mysql_query("update katalog set menu_sort='$sortf[menu_sort]' where id='$sortf[id]' limit 1");
}
//--unsort

$r=mysql_query("DELETE FROM katalog WHERE id = '$_GET[r]'");

if($fk[page_type]==1){//------------------- page
$r=mysql_query("DELETE FROM katalog_page WHERE id_p = '$_GET[r]'");
}
else if($fk[page_type]==4){//-------------- user
$r = mysql_query("SELECT * FROM katalog_user where id_p='$_GET[r]'")or die(mysql_error());
$f=mysql_fetch_array($r);
if(is_file("../".$f[url])){unlink("../".$f[url]);}

mysql_query("DELETE FROM katalog_user WHERE id_p='$_GET[r]'");

mysql_query("DELETE FROM katalog_message WHERE user_out='$_GET[r]' or user_in='$_GET[r]'");
mysql_query("DELETE FROM katalog_finanse WHERE in='$_GET[r]' or out='$_GET[r]'");

mysql_query("DELETE FROM katalog_otzivi WHERE userto='$_GET[r]' or userfrom='$_GET[r]'");
mysql_query("DELETE FROM katalog_zadach WHERE katalog_zadach='$_GET[r]' or userresh='$_GET[r]'");
mysql_query("DELETE FROM katalog_zayava WHERE userresh='$_GET[r]'");

}
else if($fk[page_type]==2){//------------- news
$r=mysql_query("DELETE FROM katalog_news WHERE id_p = '$_GET[r]'");
}
else if($fk[page_type]==9){//------------- otzivi
$r=mysql_query("DELETE FROM katalog_otzivi WHERE id_p = '$_GET[r]'");
}
else if($fk[page_type]==6){//------------- zayava
$r=mysql_query("DELETE FROM katalog_zayava WHERE id_p = '$_GET[r]'");
}
else if($fk[page_type]==5){//------------- zadacha ================================
$r = mysql_query("SELECT * FROM katalog_zadach where id_p='$_GET[r]'")or die(mysql_error());
$f=mysql_fetch_array($r);
mysql_query("DELETE FROM katalog_zadach WHERE id_p='$_GET[r]' limit 1");;
if(is_file("../".$f[url])){unlink("../".$f[url]);}
if(is_file("../".$f[urlresh])){unlink("../".$f[urlresh]);}
}
header("Location: katalog.html?r=".$fk[id_p]);exit();
?>