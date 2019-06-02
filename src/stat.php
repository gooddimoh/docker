<?
include "mysql.php";
$data=time();
//mysql_query("insert into katalog_stat(id_user,data) values('2','$data')")or die(mysql_error());
require_once $_SERVER["DOCUMENT_ROOT"] . "/modul/custom_sessions.php"; CustomSessions::start();
echo $_SESSION[statistik_id],'<br>';
$r=mysql_query("select * from katalog_stat")or die(mysql_error());
for($i=0;$i<@mysql_num_rows($r);$i++){
	$f=mysql_fetch_array($r);
	echo $f[id],'-',date('d.m.y H:i',$f[data]),'-',$f[status],'-',$f[id_user],'-',$f[ip],'<br>';
}
?>