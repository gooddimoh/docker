<?
include "mysql.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/modul/custom_sessions.php"; CustomSessions::start();

$_SESSION[error]=array();
$_SESSION[result]=array();
include "sequrity.php";

if($_SESSION[logintrue]){	$f=mysql_fetch_array(mysql_query("select id from katalog_message WHERE user_in='$_SESSION[userid]' or user_out='$_SESSION[userid]' limit 1"));
	if($f[id]){		mysql_query("delete from katalog_message where id='$_GET[id]' limit 1");
		array_push($_SESSION[result],'Сообщение удалено');
		if(isset($_GET[in])){$an='&in';}
		else if(isset($_GET[out])){$an='&out';}
		else if(isset($_GET[all])){$an='&all';}
		header("Location:../k18.html?form=1".$an);
	}else{		array_push($_SESSION[error],'Это не Ваше сообщение');
    	header("Location:../k18.html?form=1");	}
}else{	array_push($_SESSION[error],'Вы не авторизированый пользователь. <a href="k20.html">Войдите</a> в систему');
    header("Location:../k20.html");
 }
?>