<?
include "mysql.php";
$r = mysql_query("SELECT * FROM katalog where id='$_GET[r]'")or die(mysql_error());
$f=mysql_fetch_array($r);
if($f[menu_dozvil]==1){$f[menu_dozvil]=0;}else{$f[menu_dozvil]=1;}
mysql_query("update katalog set menu_dozvil='$f[menu_dozvil]' where id='$_GET[r]'")or die(mysql_error());

mysql_query('REPLACE `katalog_userIP`
         	 SELECT (NULL), (0), `user_IP`, `mask_IP`, (0), (1)
         	 FROM `katalog_userIP`
        	 WHERE id_p = '.(int)$_GET[r].' AND block = 0');
             
mysql_query('UPDATE `katalog_userIP`
             SET block = 1
             WHERE id_p = '.(int)$_GET[r].' AND block = 0');

header("Location: katalog.html?r=".$f[id_p]);exit();
?>