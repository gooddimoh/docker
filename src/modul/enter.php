<?
$redir = $_REQUEST['redir'];
if(!isset($_POST[B1])){
$_POST=$_SESSION[temp_form];
unset($_SESSION[temp_form]);
//echo '<!--'.print_r($_SERVER,true).'-->'; 

echo '<form action="modul/enter.php?'.CustomSessions::name().'='.CustomSessions::id().'" onsubmit="return _filtersLoadFormFix;" method=post>
<table border="0" align=center>
	<tr>
		<td align="right"><font size="2" face="Arial">Имя пользователя (<span lang="uk">логин</span>) :</td>
		<td>
		<img alt=""  src="images/bullet.png"></td>
		<td><input type="text" name="login" size="40" value="',$_POST[login],'"></td>
	</tr>
	<tr>
		<td align="right"><font size="2" face="Arial">Пароль :</font></td>
		<td>
		<img alt=""  src="images/bullet.png"></td>
		<td>
            <input type="password" AUTOCOMPLETE="OFF" name="pas" size="40">
        </td>
	</tr>
	<tr>
		<td align="right">&nbsp;</td>
		<td>&nbsp;</td>
		<td>
            <label><input style="margin: 5px 0 15px 0" type="checkbox" name="remember" value="1"> Запомнить меня</label>
            <br />
            <input type="submit" value="Войти" name="B1"><input type="hidden" value="'.$redir.'" name="redir">
        </td>
	</tr>
</table></form>
<table border="0" align=center>
	<tr>
		<td><a href="k16.html">Регистрация</a></td>
		<td>|</td>
		<td><a href="k74.html">Не пришла ссылка для активации?</a></td>
		<td>|</td>
		<td><a href="k75.html">Забыли пароль?</a></td>
	</tr>
</table>';}
else{
    require_once $_SERVER["DOCUMENT_ROOT"] . "/modul/custom_sessions.php"; CustomSessions::start();

	$_SESSION[temp_form]=$_POST;
	$_SESSION[error]=array();
	$_SESSION[result]=array();

	$_POST[login]=mysql_escape_string(strip_tags($_POST[login]));

	include "../mysql.php";
    require_once($_SERVER["DOCUMENT_ROOT"] . '/modul/pass.php');
    
	$f=mysql_fetch_array(mysql_query("select resh,polz,zad,user_password,login,id_p from katalog_user where login='$_POST[login]' limit 1"));
	$f2=mysql_fetch_array(mysql_query("select menu_vizible,menu_dozvil from katalog where id='$f[id_p]' limit 1"));

	if($_POST[login]==''){
		array_push($_SESSION[error],'Вы не ввели имя пользователя');
	}
	if($_POST[pas]==''){
		array_push($_SESSION[error],'Вы не ввели пароль');
	}
	if($f[id_p]=='' || !check_password($_POST[pas], $f['user_password'])){
		array_push($_SESSION[error],'Неверный логин или пароль');
	}
	if($f2[menu_vizible]==1){
		array_push($_SESSION[error],'Вы не актевировали свой аккаунт. Если вам не пришла ссылка для активации аккаунта, то его можно отправить вам на e-mail еще раз <a href="k74.html">здесь</a>');
	}
	if($f2[menu_dozvil]==1){
		array_push($_SESSION[error],'Ваш аккаунт заблокирован');
	}
	$f3 = mysql_query("select * from katalog_userIP where block = 1");
	if(mysql_num_rows($f3))
		while($row = mysql_fetch_array($f3)){
			$mask = explode(".", $row['mask_IP']);// print_r($mask); echo sizeof($mask); exit;
			$ip = explode(".", $row['user_IP']);
			$remote = explode(".", $_SERVER['REMOTE_ADDR']);
			if(sizeof($mask)!=4||sizeof($ip)!=4||sizeof($remote)!=4) continue;
			$err = 1;
			for($i=0;$i<4;$i++){
			//	print_r($remote);
			//	print_r($mask);
			//	print_r($ip);
//			echo $remote[$i].' '.$mask[$i].' '.$ip[$i].' '.$mask[$i].'*'.((int)$remote[$i] & (int)$mask[$i]).'^'.($ip[$i]&$mask[$i]).'<br/>';
				if(((int)$remote[$i]&(int)$mask[$i])!=((int)$ip[$i]&(int)$mask[$i])) { $err = 0; }
//			if($_SERVER['REMOTE_ADDR']=='91.124.38.153')	exit;
			}
//			if($_SERVER['REMOTE_ADDR']=='91.124.38.153')	exit;
			if($err) { array_push($_SESSION[error],'Ваш IP заблокирован'); continue;}
		}

	if(count($_SESSION[error])==0){

		//--------- statistika posescheniy
		$time=time();
		mysql_query("update katalog_stat set data='$time',status='$f[resh]',id_user='$f[id_p]' where id='$_SESSION[statistik_id]' limit 1");
		mysql_query("REPLACE `katalog_userIP` VALUES ('',".$f['id_p'].",'".$_SERVER['REMOTE_ADDR']."','255.255.255.255',0,0)");

        //--------- statistika posescheniy

		unset($_SESSION[temp_form]);
		array_push($_SESSION[result],'Вы успешно вошли в систему');

		$_SESSION[userlogin]=$f[login];
		$_SESSION[userpas]=$f['user_password'];
		$_SESSION[userpolz]=$f[polz];
		$_SESSION[userzadach]=$f[zad];
		$_SESSION[userresh]=$f[resh];
        
        if($_POST['remember'])
            remember_user((int)$f[id_p]);
            
		mysql_query("update katalog_user set dat_enter='$time' where id_p='$f[id_p]' limit 1")or die(mysql_error());
if(trim($redir)!='') { header("Location: /".$redir.".html"); exit; }
	header("Location: /k6.html");
	}else{
	header("Location:../k20.html".($redir!=''?'?redir='.$redir:''));
	}
}
?>