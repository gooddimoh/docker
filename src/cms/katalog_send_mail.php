<?
/*
 * ������ ��� �������� ����������� �� ������..
 * ����� ��� ����� POST
 * */

$err = '';
if(trim($_POST['subject'])=='') $err = '�� ��������� ���� "����" <br/>';
if(trim($_POST['message'])=='') $err .= '��������� �� ����� ���� ������ <br/>';


if(!isset($_GET['send'])||$err!=''){


?>

<font color="red"><?=$err?></font>
<form method="POST" action="/cms/katalog_send_mail.html?send">
��������� �������������:<select name="cat_user">
<option value="1">���� �������������</option>
<option value="2" <?=((int)$_REQUEST['cat_user']==2?' selected="selected" ':'')?> >��������</option>
<option value="3" <?=((int)$_REQUEST['cat_user']==3?' selected="selected" ':'')?> >����������</option>
</select><br/>
����:<input type="text" name="subject"/><br/>
���������:<textarea name="message"></textarea><br/>
<input type="submit" value="���������" name="send"/>
<input type="button" value="��������" onclick="document.location.href='/cms/katalog.html?r=2'"/>
</form>
<?	
} else {

ini_set('max_execution_time', 360);

	$coddin =  mb_detect_encoding($_POST["message"]);
	//if (!strcasecmp($coddin, "UTF-8"))
		//$_POST["message"]  = iconv("utf-8", "windows-1251",$_POST["message"]);

	if((int)$_POST['cat_user']==2) $resh = " WHERE resh = 1";
	if((int)$_POST['cat_user']==3) $resh = " WHERE resh = 0";
	$r = mysql_query("select * from katalog_user ".$resh."");
	//$r = mysql_query("select * from katalog_user WHERE email LIKE '%bars1602%' ");


		/*$charset = "windows-1251";
		$content = "text/html;";
		$subject = trim($_POST['subject'])==''?"��������� � ����� http://stud-help.com/":trim($_POST['subject']);

		$headers  = "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: $content  charset=$charset\r\n";
		$headers .= "Date: ".date("Y-m-d (H:i:s)",time())."\r\n";
		$headers .= "From: �������� �������� <no-replay@zadachi.com.ua>\r\n";*/

		$message .= "<B>���� �����������: ".date("Y-m-d (H:i:s)",time())."\r\n</B><BR><BR><BR>";
		
		$message .= $_POST["message"]."<BR><BR>";

	$mail = new PHPMailer();
    $mail->CharSet = "windows-1251";
    $mail->IsSMTP();
    $mail->Host = '127.0.0.1';
    $mail->From = 'no-reply@stud-help.com';
    $mail->FromName = '�������� ��������';
    $mail->Subject = $mail->AltBody = trim($_POST['subject'])==''?"��������� � ����� http://stud-help.com/":trim($_POST['subject']);
    $mail->addReplyTo('no-reply@stud-help.com', 'No-Reply');

	while($row=mysql_fetch_array($r)) {
		$mailto  = $row["email"];
		
        $mail->MsgHTML($message);
        $mail->ClearAddresses();
        $mail->AddAddress($mailto);
        $send_ok = $mail->Send();
        
        //$send_ok = mail($mailto,$subject,$message,$headers);
		echo ++$i.'. '.$row["id_p"].' - '.$row["email"].' : '.($send_ok == 1?'��������� ����������':'������').'<br/>';
	}

	echo '<input type="button" value="���������" onclick="history.back(1)"/>';
}


exit;


?>

