<?php

if(!class_exists('PHPMailer')) require($_SERVER["DOCUMENT_ROOT"] . '/modul/rozsl/class.phpmailer.php');

$mail             = new PHPMailer();
$body             = 'test';
$body             = eregi_replace("[\]",'',$body);
$mail->CharSet    = 'windows-1251';
$mail->IsSMTP(); // telling the class to use SMTP
$mail->Host       = '127.0.0.1'; // SMTP server
$mail->From       = 'no-reply@stud-help.com';
$mail->FromName   = 'Контакты Решебник';
$mail->Subject    = $mail->AltBody = 'Новое сообщение в системе от';
//$mail->AltBody    = 'stud-help.com'; // optional, comment out and test
$mail->addReplyTo('no-reply@stud-help.com', 'No-Reply');
$mail->MsgHTML($body);
$mail->AddAddress( 'test258@inbox.ru');  //$_POST[email]


$mail->MsgHTML("Вам пришло письмо с сайта <a href='http://stud-help.com'>stud-help.com</a> :<BR>");
//$mail->ClearAddresses();
//$mail->AddAddress( 'jdhsfiu@mail.ru');

var_dump($mail->Send());


?>