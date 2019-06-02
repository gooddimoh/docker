<?
if(!isset($_POST[B1]) && empty($_GET['k'])){
$_POST=$_SESSION[temp_form];
unset($_SESSION[temp_form]);
echo '<form action="modul/recoveryemail.php" method=post>
<table border="0" align=center>
	<tr>
		<td align="right"><font size="2" face="Arial">Имя пользователя:</td>
		<td>
		<img alt=""  src="images/bullet.png"></td>
		<td><input type="text" name="login" size="40" value="',$_POST[login],'"></td>
	</tr>
	<tr>
		<td align="right">&nbsp;</td>
		<td>&nbsp;</td>
		<td><input type="submit" value="Отправить" name="B1"></td>
	</tr>
</table></form>';}
else{
	require_once $_SERVER["DOCUMENT_ROOT"] . "/modul/custom_sessions.php"; CustomSessions::start();

	$_SESSION[temp_form]=$_POST;
	$_SESSION[error]=array();
	$_SESSION[result]=array();

	include "../mysql.php";
    require_once($_SERVER["DOCUMENT_ROOT"] . '/modul/pass.php');
    
    if(empty($_GET['k']))
    {
        $_POST[login]=mysql_escape_string(strip_tags($_POST[login]));
        
    	$f = mysql_fetch_array(mysql_query("select id_p, login, email, recovery_key_password_send_time from katalog_user where login='$_POST[login]' limit 1"));
    
    	if($f[id_p]==''){
    		array_push($_SESSION[error],'Такого пользователя нет в нашей базе пользователей');
    	}
    	if($_POST[login]==''){
    		array_push($_SESSION[error],'Вы не ввели имя пользователя');
    	}
        
        if( time() < ( $f['recovery_key_password_send_time'] + (24 * 60 * 60) ) )
        {
            array_push($_SESSION[error],'Запрос на восстановление пароля можно подавать не чаще чем 1 раз в сутки'); 
        }                        
    } 
    else
    {
    	$f = mysql_fetch_array(mysql_query("select id_p, login, email, recovery_key_password_send_time, recovery_key_password from katalog_user where id_p=".(int)$_GET['user']." limit 1"));

    	if(!$f[id_p] || !$f['recovery_key_password_send_time'] || !$f['recovery_key_password'] || time() > ( $f['recovery_key_password_send_time'] + (24 * 60 * 60) ) || $f['recovery_key_password'] !== $_GET['k'])
        {
            array_push($_SESSION[error], 'В процессе восстановления пароля произошла ошибка. Пожалуйста, попробуйте ещё раз или обратитесь к администратору системы.');
    	}
    }

    if(count($_SESSION[error])==0){

		unset($_SESSION[temp_form]);
	    include_once('rozsl/class.phpmailer.php');
	    include "config.php";

        if(empty($_GET['k']))
        {
            $recovery_key = generate_recovery_key_password();
            $link = 'http://' . $_SERVER["SERVER_NAME"] . '/k75.html?user='.$f[id_p].'&k=' . urlencode($recovery_key);
            
            mysql_query('UPDATE katalog_user 
                         SET recovery_key_password = "' . $recovery_key . '",
                             recovery_key_password_send_time = ' . time() . '
                         WHERE id_p = ' . $f[id_p]);
            
    	    $info='<font size="2" face="Arial">
                <p>Для восстановления пароля перейдите по этой ссылке: <a href="'.$link.'">'.$link.'</a><p>
    			Письмо составлено роботом, и отвечать на него не нужно!</font>';
        }
        else
        {
            require_once($_SERVER["DOCUMENT_ROOT"] . '/modul/keyganarator.php');
            
            $new_password = createRandomKey(12);
            mysql_query('UPDATE katalog_user 
                         SET user_password = "' . hash_password($new_password) . '",
                             recovery_key_password = NULL
                         WHERE id_p = ' . $f[id_p]);
            
    	    $info='<font size="2" face="Arial">Ниже находятся Ваши персональные данные для входа в систему.<p>
    			<i>URL системы:</i> <a href="http://stud-help.com">http://stud-help.com</a><br>
    			<i>Пользователь:</i> '.$f[login].' <br>
    			<i>Пароль:</i> '.$new_password.' <p>
    			Письмо составлено роботом, и отвечать на него не нужно!</font>';
        }


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
		$mail->Subject    = "Восстановление пароля";
		$mail->AltBody    = "Восстановление пароля"; // optional, comment out and test
		$mail->MsgHTML($body);
		$mail->AddAddress($f[email], $f[login]);

		if($mail->Send()){
			if(empty($_GET['k']))
                array_push($_SESSION[result], 'Данные для восстановления пароля отправлены на Ваш email');
            else
                array_push($_SESSION[result], 'Данные для входа в систему отправлены на Ваш email');
		}else{
			array_push($_SESSION[error],'Данные для входа в систему не были отправлены на Ваш email. Обратитесь к администратору системы');
		}

	header("Location:../k20.html");
	}else{
	header("Location:../k75.html");
	}
}
?>