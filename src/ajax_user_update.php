<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/modul/custom_sessions.php"; CustomSessions::start();
include "mysql.php";
//include "modul/sequrity.php";
include ('modul/ajax_user_status.php'); 

//$_SESSION['statistik'] = 0;exit();
//var_dump($_SESSION); exit();

$usr_status = new UserStatus;

$usr_status->get_new_users();

?>