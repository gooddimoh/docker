<?
if(!isset($_POST[B1])){
$_POST=$_SESSION[temp_form];
unset($_SESSION[temp_form]);
echo '<form action="modul/recoverykey.php" method=post>
<table border="0" align=center>
	<tr>
		<td align="right"><font size="2" face="Arial">��� ������������:</td>
		<td>
		<img alt=""  src="images/bullet.png"></td>
		<td><input type="text" name="login" size="40" value="',$_POST[login],'"></td>
	</tr>
	<tr>
		<td align="right">&nbsp;</td>
		<td>&nbsp;</td>
		<td><input type="submit" value="���������" name="B1"></td>
	</tr>
</table></form>';}
else{
	require_once $_SERVER["DOCUMENT_ROOT"] . "/modul/custom_sessions.php"; CustomSessions::start();

	$_SESSION[temp_form]=$_POST;
	$_SESSION[error]=array();
	$_SESSION[result]=array();

	$_POST[login]=mysql_escape_string(strip_tags($_POST[login]));

	include "../mysql.php";
	$f=mysql_fetch_array(mysql_query("select id_p,email,generetedkey,login from katalog_user where login='$_POST[login]' limit 1"));

	if($f[id_p]==''){
		array_push($_SESSION[error],'������ ������������ ��� � ����� ���� �������������');
	}
	if($_POST[login]==''){
		array_push($_SESSION[error],'�� �� ����� ��� ������������');
	}

    if(count($_SESSION[error])==0){

		unset($_SESSION[temp_form]);
	    include_once('rozsl/class.phpmailer.php');
	    include "config.php";

	    $info='<font size="2" face="Arial">��� ����, ����� ������������ ��� ������� ��������� �� ������:
			<a href="http://'.$_SERVER["SERVER_NAME"].'/modul/profil.php?id_user='.$f[id_p].'&keycode='.$f[generetedkey].'">http://'.$_SERVER["SERVER_NAME"].'/modul/profil.php?id_user='.$f[id_p].'&keycode='.$f[generetedkey].'</a><p>
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
		$mail->Subject    = "����������� ���";
		$mail->AltBody    = "����������� ���"; // optional, comment out and test
		$mail->MsgHTML($body);
		$mail->AddAddress($f[email], $f[login]);

		if($mail->Send()){
			array_push($_SESSION[result],'C����� ��� ��������� �������� ���� ���������� �� ��� email');
		}else{
			array_push($_SESSION[error],'C����� ��� ��������� �������� �� ���� ���������� �� ��� email. ���������� � �������������� �������');
		}

	header("Location:../k20.html");
	}else{
	header("Location:../k74.html");
	}
}
?>