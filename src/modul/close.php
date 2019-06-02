<?
require_once $_SERVER["DOCUMENT_ROOT"] . "/modul/custom_sessions.php"; CustomSessions::start();
$time=time();
include "../mysql.php";

if(!empty($_COOKIE['user_remember']))
    exit_remember_user((int)$_SESSION['userid']);

unset($_SESSION[result]);
unset($_SESSION[error]);
unset($_SESSION[userlogin]);
unset($_SESSION[userpas]);
unset($_SESSION[userpolz]);
unset($_SESSION[userzadach]);
unset($_SESSION[userresh]);

//--------- statistika posescheniy
mysql_query("update katalog_stat set data='$time',status='0',id_user='0' where id='$_SESSION[statistik_id]' limit 1");
//--------- statistika posescheniy

header("Location:../");
?>