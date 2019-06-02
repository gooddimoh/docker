<?
$errors_name = 'Введите ваше имя';
$errors_mailfrom = 'Введите свой E-mail адрес';
$errors_tel = 'Введите свой телефон';
$errors_incorrect = 'Заполните правильно Ваш E-mail адрес';
$errors_message = 'Наберите текст вашего сообщения';
$errors_subject = 'Введите тему сообщения';
$captcha_error = 'Проверьте правильность ввода защитного кода';
$send = 'Ваше сообщение успешно отправлено';

if(!class_exists('PHPMailer')) require($_SERVER["DOCUMENT_ROOT"] . '/modul/rozsl/class.phpmailer.php');

$statusError = "";
$statusSuccess = "";

	if (isset($_POST[formsend]))
	{
	    if($_SESSION[random] ==  $_POST['keystring'])
	    {
	        if (isset($_POST['posName']) && $_POST['posName'] == "")
	        {
	         $statusError = "$errors_name";$_SESSION[random]=rand(1000,9999);
	        }
	        elseif (isset($_POST['posEmail']) && $_POST['posEmail'] == "")
	        {
	         $statusError = "$errors_mailfrom";$_SESSION[random]=rand(1000,9999);
	        }
	        elseif (isset($_POST['postel']) && $_POST['postel'] == "")
	        {
	         $statusError = "$errors_tel";$_SESSION[random]=rand(1000,9999);
	        }
	        elseif(isset($_POST['posEmail']) && !preg_match("/^([a-z,._,0-9])+@([a-z,._,0-9])+(.([a-z])+)+$/", $_POST['posEmail']))
	        {
	         $statusError = "$errors_incorrect";$_SESSION[random]=rand(1000,9999);
	         unset($_POST['posEmail']);$_SESSION[random]=rand(1000,9999);
	        }
	        elseif (isset($_POST['posRegard']) && $_POST['posRegard'] == "")
	        {
	         $statusError = "$errors_subject";$_SESSION[random]=rand(1000,9999);
	        }
	        elseif (isset($_POST['posText']) && $_POST['posText'] == "")
	        {
	         $statusError = "$errors_message";$_SESSION[random]=rand(1000,9999);
	        }
		else if(!empty($_POST))
			{
			$mailto = "danko2009@inbox.ru";
			$charset = "windows-1251";
			$content = "text/plain";
			/*$subject = $_POST['posRegard'];

			$headers  = "MIME-Version: 1.0\r\n";
	 		$headers .= "Content-Type: $content  charset=$charset\r\n";
	 		$headers .= "Date: ".date("Y-m-d (H:i:s)",time())."\r\n";
			$headers .= "From: Контакты Решебник <no-replay@stud-help.com>\r\n";*/

	 		$message .= "Дата відправлення: ".date("Y-m-d (H:i:s)",time())."\r\n";
	 		$message .= "Від: ".$_POST['posName']." e-mail: ".$_POST['posEmail']." тел: ".$_POST['postel']."\n\n";
			$message .= $_POST['posText'];

			$mail = new PHPMailer();
            $mail->CharSet = "windows-1251";
            $mail->IsSMTP();
            $mail->Host = '127.0.0.1';
            $mail->From = 'no-reply@stud-help.com';
            $mail->FromName = 'Контакты Решебник';
            $mail->Subject = $mail->AltBody = $_POST['posRegard'];
            $mail->addReplyTo('no-reply@stud-help.com', 'No-Reply');
            
            $mail->MsgHTML($message);
            $mail->ClearAddresses();
            $mail->AddAddress($mailto);
            $mail->Send();

	 	//	mail($mailto,$subject,$message,$headers);

	 		$statusSuccess = "$send";
			$statusSuccess .= "<p>";
			}

		}else{
			$statusError = "$captcha_error";
			$statusError .= "<p>";
			$_SESSION[random]=rand(1000,9999);
	     }
	}else{
		$_SESSION[random]=rand(1000,9999);
	}

?>
<center><font face="Arial" color="#328D7D" style="font-size:9pt"><?echo "$statusSuccess";?><?echo "$statusError";?></font>
<form action="k13.html" method="post">
	<table border="0" width="460">
		<tr>
			<td colspan="2">
				<table border="0" width="100%" cellpadding=0 cellspacing=0>
					<tr>
						<td ><font face="Arial" size="2">Вы можете отправить сообщение здесь:<br><br></font></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<table border="0" width="100%" cellpadding=0 cellspacing=0>
					<tr>
						<td width=108><font face="Arial" size="2">Ваше имя:</font></td>
						<td align="right" >
							<input class="text" style="width:330px;" name="posName" id="posName"  value="<?echo $_POST[posName];?>"/></font>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td  colspan="2">
				<table border="0" width="100%" id="table2" cellpadding=0 cellspacing=0>
					<tr>
						<td width=108><font size="2" face="Arial">E-mail:</font></td>
						<td align="right">
							<input class="text" style="width:330px;" name="posEmail" id="posEmail" value="<?echo $_POST[posEmail];?>" /></font>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td  colspan="2">
				<table border="0" width="100%" id="table4" cellpadding=0 cellspacing=0>
					<tr>
						<td width=107><font size="2" face="Arial">Телефон:</font></td>
						<td align="right">
							<input class="text" style="width:330px;" name="postel" id="postel" value="<?echo $_POST[postel];?>" /></font>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td  colspan="2">
				<table border="0" width="100%" id="table3" cellpadding=0 cellspacing=0>
					<tr>
						<td width=106><font size="2" face="Arial">Тема сообщения:</td>
						<td align="right">
							<input class="text" style="width:330px;" name="posRegard" id="posRegard" value="<?echo $_POST[posRegard];?>"/></font>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td align="left"><font size="2" face="Arial" color="#555555">Сообщение:</td>
			<td >&nbsp;</td>
		</tr>
		<tr>
			<td colspan="2" align="left">
				<textarea style="width:455px;" rows="6" name="posText" id="posText"><?echo $_POST[posText];?></textarea></font>
			</td>
		</tr>
		<tr>
			<td align="left">
				<font size="2" color="#555555" face="Arial">Введите число на изображении:</font>
			</td>
			<td  align="right">
				<input class="text" style="width:80px;" name="keystring" id="keystring"></td>
		</tr>
		<tr>
			<td align="left"><b>
				<font size="1" face="Arial" color="#333333">Если вам не понятен текст на изображении обновите страницу, нажав F5</font></b>
			</td>
			<td  align="right"><img src="./mail/img.php"></td>
		</tr>
		<tr>
			<td  colspan="2" align=center>
				<input align=center type="submit" name="formsend" value=" Отправить " style="font-weight: 700">
			</td>
		</tr>
	</table>
</form>