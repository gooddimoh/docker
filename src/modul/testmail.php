<?php

$_SESSION[error] = array();

	    include_once('rozsl/class.phpmailer.php');
	    include "config.php";

	    $info='<font size="2" face="Arial">������� �� ����������� � �������
			stud-help.com. ���� ��������� ���� ������������ ������ ��� ����� � �������.<p>
			<i>URL �������:</i> <a href="http://stud-help.com">http://stud-help.com</a><br>
			<i>������������:</i> '.$_POST[login].' <br>
			<i>������:</i> '.$_POST[pas].' <p>
			��� ����, ����� ������������ ��� ������� ��������� �� ������:
			<a href="http://'.$_SERVER["SERVER_NAME"].'/modul/profil.php?id_user='.$id.'&keycode='.$key.'">http://'.$_SERVER["SERVER_NAME"].'/modul/profil.php?id_user='.$id.'&keycode='.$key.'</a><p>
			������ ���������� �������, � �������� �� ���� �� �����!</font>';

		$mail             = new PHPMailer();
		$body             = $info;
		$body             = eregi_replace("[\]",'',$body);
		$mail->CharSet    = "windows-1251";
		$mail->IsSMTP(); // telling the class to use SMTP
		//$mail->Host       = $smthhost; // SMTP server
		//$mail->From       = $emailfrom;
        $mail->Host       = '127.0.0.1'; // SMTP server
        $mail->From       = 'no-reply@stud-help.com';
		$mail->FromName   = "��������";
		$mail->Subject    = "��� ������� � stud-help.com";
		$mail->AltBody    = "��� ������� � stud-help.com"; // optional, comment out and test
		$mail->MsgHTML($body);
		$mail->AddAddress('bars1602@gmail.com', 'bars1602');  //$_POST[email]

		echo $send = $mail->Send();
		echo $mail->ErrorInfo;
		if($send){
			array_push($_SESSION[result],'�����������, �� ������� ������������������ � �������, ��� ��������� ������ �������� ��������� ����� � ��������� �� ������, ������� ������� ��� �������');

		}else{
			array_push($_SESSION[error],'����������� ������ ������� �� ��� ��������� �� ��� ��������� �� ��� email. ���������� � �������������� �������');
		}

print_r($_SESSION[error]);
?>