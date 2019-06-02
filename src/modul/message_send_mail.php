<?
/*
 * Модуль для розсилки повыдомлень на емайли..
 * Вхідні дані берез POST
 * */
include "mysql.php";
if(!class_exists('PHPMailer')) require($_SERVER["DOCUMENT_ROOT"] . '/modul/rozsl/class.phpmailer.php');

	if (!isset($_POST["text"])) $_POST["text"] = "No data!!! Test messages!";
	if (!isset($_POST["user"])) $_POST["user"] = "No USER";
	if (!isset($_POST["usto"])) $_POST["usto"] = "NO USER";
	
	$coddin =  mb_detect_encoding($_POST["text"]);
	if (!strcasecmp($coddin, "UTF-8"))
		$_POST["text"]  = iconv("utf-8", "windows-1251",$_POST["text"]);
	
	
	$r	=	mysql_query("select * from katalog_user where login like '".$_POST["usto"]."'");
	
	$mail = new PHPMailer();
    $mail->CharSet = "windows-1251";
    $mail->IsSMTP();
    $mail->Host = '127.0.0.1';
    $mail->From = 'no-reply@stud-help.com';
    $mail->FromName = 'Контакты Решебник';
    $mail->Subject = $mail->AltBody = "Новое сообщение в системе от ".$_POST["user"];
    $mail->addReplyTo('no-reply@stud-help.com', 'No-Reply');
    
    while($row=mysql_fetch_array($r)) {
		 
		$old=$row["email"]; 
		//$row["email"] = "igorchyk@gmail.com";
		
		print $row["email"];
		$message = "";
		

		$mailto  = $row["email"];
		/*$charset = "windows-1251";
		$content = "text/html;";
		$subject = "Новое сообщение в системе от ".$_POST["user"];

		$headers  = "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: $content  charset=$charset\r\n";
		$headers .= "Date: ".date("Y-m-d (H:i:s)",time())."\r\n";
		$headers .= "From: Контакты Решебник <no-replay@stud-help.com>\r\n";*/

		$message .= "<B>Дата відправлення: ".date("Y-m-d (H:i:s)",time())."\r\n</B><BR><BR><BR>";
		
		$message .= $_POST["text"]."<BR><BR><BR><BR>Адресовано:".$_POST["usto"].",  $old";

        $mail->MsgHTML($message);
        $mail->ClearAddresses();
        $mail->AddAddress($mailto);
        $send_ok = $mail->Send();

		//$send_ok = mail($mailto,$subject,$message,$headers);
		print "<BR>Result=".$send_ok;
		
		//print $message;
		break;
	}


?>

