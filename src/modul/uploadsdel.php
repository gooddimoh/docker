<?
$date=time();
include "mysql.php";
$r = mysql_query("SELECT * FROM katalog_files where data_create+1209600<'$date'")or die(mysql_error());
for($i=0;$i<@mysql_num_rows($r);$i++){
	$f=mysql_fetch_array($r);
	if(is_file("../".$f[url])){unlink("../".$f[url]);}
	mysql_query("delete from katalog_files where id='$f[id]' limit 1");
}
echo date('d.m.y H:i').' '.@mysql_num_rows($r).' files was deleted';
?>