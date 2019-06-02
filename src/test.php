<?php 
/*
$chkstring = 'sdfdsfsd';
$md5sum = strtoupper(md5($chkstring));*/

//echo hash('sha256', 'ertert');

//file_put_contents('test.txt', date('d.m.Y H:i:s'));

//var_dump(error_log('test', E_NOTICE));
//echo $_SERVER["DOCUMENT_ROOT"];

$res = fopen($_SERVER["DOCUMENT_ROOT"] . '/tmp/ttt', 'r+');
$l = flock(self::$fileHandle, LOCK_EX);

var_dump($l);