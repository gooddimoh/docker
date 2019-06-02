<?php

$_SESSION[error] = array();

	    include_once('rozsl/class.phpmailer.php');
	    include "config.php";

	    $info='<font size="2" face="Arial">Спасибо за регистрацию в системе
			stud-help.com. Ниже находятся Ваши персональные данные для входа в систему.<p>
			<i>URL системы:</i> <a href="http://stud-help.com">http://stud-help.com</a><br>
			<i>Пользователь:</i> '.$_POST[login].' <br>
			<i>Пароль:</i> '.$_POST[pas].' <p>
			Для того, чтобы активировать ваш аккаунт перейдите по ссылке:
			<a href="http://'.$_SERVER["SERVER_NAME"].'/modul/profil.php?id_user='.$id.'&keycode='.$key.'">http://'.$_SERVER["SERVER_NAME"].'/modul/profil.php?id_user='.$id.'&keycode='.$key.'</a><p>
			Письмо составлено роботом, и отвечать на него не нужно!</font>';

		$mail             = new PHPMailer();
		$body             = $info;
		$body             = eregi_replace("[\]",'',$body);
		$mail->CharSet    = "windows-1251";
		$mail->IsSMTP(); // telling the class to use SMTP
		//$mail->Host       = $smthhost; // SMTP server
		//$mail->From       = $emailfrom;
        $mail->Host       = '127.0.0.1'; // SMTP server
        $mail->From       = 'no-reply@stud-help.com';
		$mail->FromName   = "Решебник";
		$mail->Subject    = "Ваш аккаунт в stud-help.com";
		$mail->AltBody    = "Ваш аккаунт в stud-help.com"; // optional, comment out and test
		$mail->MsgHTML($body);
		$mail->AddAddress('bars1602@gmail.com', 'bars1602');  //$_POST[email]

		echo $send = $mail->Send();
		echo $mail->ErrorInfo;
		if($send){
			array_push($_SESSION[result],'Поздравляем, Вы успешно зарегистрировались в системе, для активации Вашего аккаунта проверьте почту и перейдите по ссылке, которую выслала Вам система');

		}else{
			array_push($_SESSION[error],'Регистрация прошла успешно но код активации не был отправлен на Ваш email. Обратитесь к администратору системы');
		}

print_r($_SESSION[error]);
?>