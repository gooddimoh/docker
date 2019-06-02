<?
include "mysql.php";
$r = mysql_query("SELECT * FROM katalog where id='$_GET[r]'")or die(mysql_error());
$f=mysql_fetch_array($r);
if($f[menu_vizible]==1){$f[menu_vizible]=0;}else{$f[menu_vizible]=1;}
mysql_query("update katalog set menu_vizible='$f[menu_vizible]' where id='$_GET[r]'")or die(mysql_error());
header("Location: katalog.html?r=".$f[id_p]);exit();
?>