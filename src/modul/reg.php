<?
if(!isset($_POST[B1])){
$_SESSION[random]=rand(1000,9999);
$_POST=$_SESSION[temp_form];
unset($_SESSION[temp_form]);
echo '<form action="modul/reg.php" method=post>
<table border="0" align=center>
	<tr>
		<td align="right"><font size="2" face="Arial">Имя пользователя (<span lang="uk">логин</span>) :</td>
		<td>
		<img alt=""  src="images/bullet.png"></td>
		<td><input type="text" name="login" size="40" value="',$_POST[login],'"></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td align="right"><font size="2" face="Arial">Пароль :</font></td>
		<td>
		<img alt=""  src="images/bullet.png"></td>
		<td><input type="password" AUTOCOMPLETE="OFF" name="pas" size="40"></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td align="right"><font size="2" face="Arial">Подтверждение:</font></td>
		<td>
		<img alt=""  src="images/bullet.png"></td>
		<td><input type="password" AUTOCOMPLETE="OFF" name="pas_two" size="40"></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td align="right"><font size="2" face="Arial">ICQ:</font></td>
		<td>
		</td>
		<td><input type="text" name="icq" size="40" value="',$_POST[icq],'"></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td align="right"><font size="2" face="Arial">Телефон:</font></td>
		<td>
		</td>
		<td><input type="text" name="tel" size="40" value="',$_POST[tel],'"></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td align="right"><font size="2" face="Arial">Email (для активации):</font></td>
		<td>
		<img alt=""  src="images/bullet.png"></td>
		<td><input type="text" name="email" size="40" value="',$_POST[email],'"></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td align="right"><font size="2" face="Arial">Код на картинке :</font></td>
		<td>
		<img alt=""  src="images/bullet.png"></td>
		<td><input type="text" name="kod" size="40"></td>
		<td><img alt=""  src="./mail/img.php"></td>
	</tr>
	<tr>
		<td align="right">&nbsp;</td>
		<td>&nbsp;</td>
		<td><input type="submit" value="Регистрация" name="B1"></td>
		<td>&nbsp;</td>
	</tr>
</table></form>';}
else{
	require_once $_SERVER["DOCUMENT_ROOT"] . "/modul/custom_sessions.php"; CustomSessions::start();

	$_SESSION[temp_form]=$_POST;
	$_SESSION[error]=array();
	$_SESSION[result]=array();

	$_POST[login]=mysql_escape_string(strip_tags($_POST[login]));
			$_POST[email]=mysql_escape_string(strip_tags($_POST[email]));
				$_POST[pas_two]=mysql_escape_string(strip_tags($_POST[pas_two]));
					$_POST[kod]=mysql_escape_string(strip_tags($_POST[kod]));
						$_POST[icq]=mysql_escape_string(strip_tags($_POST[icq]));
							$_POST[tel]=mysql_escape_string(strip_tags($_POST[tel]));

	include "../mysql.php";
	$f=mysql_fetch_array(mysql_query("select id_p from katalog_user where login='$_POST[login]' limit 1"));
	$f2=mysql_fetch_array(mysql_query("select id_p from katalog_user where email='$_POST[email]' limit 1"));

	if($_POST[login]==''){
	array_push($_SESSION[error],'Вы не ввели имя пользователя');
	}elseif( strpos($_POST[login],'@') != null || is_numeric($_POST[login]) ){
	   array_push($_SESSION[error],'В логине нельзя указывать контактные данные - е-мейл, номер телефона или аськи. Пожалуйста, придумайте новый логин и пройдите регистрацию.');
	}
    
	if($f[id_p]!=''){
	array_push($_SESSION[error],'Логин уже занят другим пользователем');
	}
	if($f2[id_p]!=''){
	array_push($_SESSION[error],'Email уже занят другим пользователем');
	}
	if($_POST[pas]==''){
	array_push($_SESSION[error],'Вы не ввели пароль');
	}
	if($_POST[pas]!=$_POST[pas_two]){
	array_push($_SESSION[error],'Пароль и подтверждение не совпадают');
	}
	if($_POST[email]=='' or !eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $_POST[email])){
	array_push($_SESSION[error],'Вы не ввели e-mail, или ввели e-mail неправильного формата');
	}
	if($_SESSION[random]!=$_POST[kod]){
	array_push($_SESSION[error],'Вы неверно ввели код на картинке');
	}
    
   // echo strpos($_POST[login],'@');

	if(count($_SESSION[error])==0){

		unset($_SESSION[temp_form]);
		$sort=@mysql_result(mysql_query("select menu_sort from katalog where id_p='2' and page_type='4' order by menu_sort desc"),0)+1;

		mysql_query("insert into katalog(id_p,page_name,page_type,menu_vizible,menu_dozvil,menu_sort)
		values('2','$_POST[login]','4','1','0','$sort')")or die(mysql_error());

		$id=mysql_insert_id();                         		//id uder
		$data=time();                                  		//data registration
		require_once($_SERVER["DOCUMENT_ROOT"] . '/modul/pass.php');
        include "keyganarator.php";$key=createRandomKey(24);//random key 12 chars
		mysql_query("insert into katalog_user(id_p,login,user_password,icq,tel,email,generetedkey,dat_reg)
		values('$id','$_POST[login]','".hash_password($_POST[pas])."','$_POST[icq]','$_POST[tel]','$_POST[email]','$key','$data')")or die(mysql_error());

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
		$mail->AddAddress($_POST[email], $_POST[login]);  //$_POST[email]

		if($mail->Send()){
			array_push($_SESSION[result],'Поздравляем, Вы успешно зарегистрировались в системе, для активации Вашего аккаунта проверьте почту и перейдите по ссылке, которую выслала Вам система');

		}else{
			array_push($_SESSION[error],'Регистрация прошла успешно но код активации не был отправлен на Ваш email. Обратитесь к администратору системы');
		}

	header("Location:../k20.html");
	}else{
	header("Location:../k16.html");
	}

}
?>