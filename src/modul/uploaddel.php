<?
include "mysql.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/modul/custom_sessions.php"; CustomSessions::start();

$_SESSION[error]=array();
$_SESSION[result]=array();
include "sequrity.php";

if($_SESSION[logintrue]){
	$f=mysql_fetch_array(mysql_query("select id from katalog_files WHERE user='$_SESSION[userid]' limit 1"));
	if($f[id]){
		mysql_query("delete from katalog_files where id='$_GET[id]' limit 1");

		$r = mysql_query("SELECT * FROM katalog_files where id='$_GET[id]' and user='$_SESSION[userid]'")or die(mysql_error());
		$f=mysql_fetch_array($r);
		if(is_file("../".$f[url])){unlink("../".$f[url]);}
		array_push($_SESSION[result],'Файл удален');

		header("Location:../k134.html?form=1");
	}else{
		array_push($_SESSION[error],'Это не Ваш файл');
    	header("Location:../k134.html?form=1");
	}
}else{
	array_push($_SESSION[error],'Вы не авторизированый пользователь. <a href="k20.html">Войдите</a> в систему');
    header("Location:../k20.html");
 }
?>