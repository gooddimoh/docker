<?php

die();

require_once $_SERVER["DOCUMENT_ROOT"] . '/modul/custom_sessions.php';


CustomSessions::start();

var_dump($_SESSION);

$_SESSION['aaa'] = 'test';
