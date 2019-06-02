<? require_once $_SERVER["DOCUMENT_ROOT"] . "/modul/custom_sessions.php"; CustomSessions::start();
include "mysql.php";

function translit($st){
	$st=strtr($st,"абвгдежзийклмнопрстуфыэАБВГДЕЖЗИЙКЛМНОПРСТУФЫЭ","abvgdegziyklmnoprstufieABVGDEGZIYKLMNOPRSTUFIE");
	$st=strtr($st,array('ё'=>"yo",'ї'=>"yi", 'х'=>"h", 'ц'=>"ts", 'ч'=>"ch", 'ш'=>"sh",'й'=>"y",
	            		'щ'=>"shch",'і'=>"i", 'ъ'=>"", 'ь'=>"", 'ю'=>"yu", 'я'=>"ya",
		                'Ё'=>"YO", 'Х'=>"H", 'Ц'=>"TS", 'Ч'=>"CH", 'Ш'=>"SH",'Й'=>"Y",
		                'Щ'=>"SHCH", 'Ъ'=>"", 'Ь'=>"", 'Ю'=>"YU", 'Я'=>"YA",
		                '№'=>"",'#'=>"",' '=>"_",'!'=>"",'?'=>"",'-'=>"",'@'=>"",
		                '('=>"_",')'=>"",'"'=>"","'"=>"",","=>""));
	return $st;
}

if(!class_exists('PHPMailer')) require($_SERVER["DOCUMENT_ROOT"] . '/modul/rozsl/class.phpmailer.php');

if(isset($_POST['id'])) $_GET['id'] = $_POST['id'];
if($_SERVER['REQUEST_METHOD'] != 'POST'){
	if($_SESSION['logintrue']){

		if(isset($_SESSION['error'])&&sizeof($_SESSION['error'])>0&&!isset($_GET['noerr'])) foreach($_SESSION['error'] as $item) echo '<span>'.$item.'</span><br/>';
		$_SESSION['error'] = array();

		$f=mysql_fetch_array(mysql_query("select url,mesmes,meszad,polz,zad,icq,tel,gorod,univer,dat_birth,coment from katalog_user where id_p='$_SESSION[userid]' limit 1"));
		echo '<script type="text/javascript" src="/jquery/jquery.min.js"></script>
                <script type="text/javascript" src="/filter.js"></script>
			<script type="text/javascript" src="/jquery/jquery.autocomplete.js"></script>
			<link rel="stylesheet" type="text/css" href="/jquery/jquery.autocomplete.css" />

			<script type=\'text/javascript\'>var users = [';
			$users=mysql_query("select login from katalog_user where id_p<>'".$_SESSION['userid']."'");

			if(isset($_GET['id'])){
				$_GET['id']=mysql_escape_string(strip_tags($_GET['id']));
				$login=@mysql_fetch_array(@mysql_query("select login from katalog_user where id_p='".$_GET['id']."' limit 1"));
			}
			for($i=1;$i<=@mysql_num_rows($users);$i++){
				$usersf=mysql_fetch_array($users);echo "'",$usersf['login'],"',";
			}
			echo '\'\'];</script>
	<script type="text/javascript">
	jQuery.noConflict();
	jQuery(document).ready(function() {
		jQuery("#user").autocomplete(users, {
			minChars: 0, // число мін символів для виводу співпадінь
			max: 10, //число виводів співпадінь
			autoFill: true, //автозаповнення при введенні
			mustMatch: true,
			matchContains: false, //пошук по першій букві, пошук співпадінь в контенті співпадінь
			scrollHeight: 220,
			formatItem: function(data, i, total) {
				if ( data[0] == users[new Date().getMonth()] )
					return false;
				return data[0];
			}
		});
	});
	</script>
<!---->		<form enctype="multipart/form-data" action="/modul/messagea.php" method=post id="form2" ';if($_GET['form']==2){echo 'style="display:block"';}else{echo 'style="display:none"';} echo '>
			<input type="hidden" name="profil" value="2">
			<table border="0" align=center>
				<tr>
					<td align="right"><font face="Arial" size="2">Пользователь:</font></td>
					<td>
					</td>
					<td colspan="3"><input type="text" name="user" size="20" id="user" value="',$login['login'],'"></td>
				</tr>
				<tr>
					<td align="right">&nbsp;</td>
					<td>&nbsp;</td>
					<td colspan="3">
					<b><i><font size="2" face="Arial" color="#28A8AE">В
					письме оставлять контактные данные запрещено!</font></i></b><font face="Arial" style="font-size: 8pt"><br>
					Максимальная длина письма: 500 символов</font></td>
				</tr>
				<tr>
					<td align="right"><font size="2" face="Arial">Сообщение:</font></td>
					<td></td>
					<td colspan="3"><textarea rows="10" name="text" cols="54" onkeypress="return imposeMaxLength(this, 500);"></textarea></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td style="width:100%;"><input type="hidden" name="id" value="'.$_GET['id'].'"/>
						<input type="submit" value="Отправить" name="B1"></td>
					<td style="font-family:Arial;font-size:12px;">Прикрепить:</td>
					<td>';
                    
            		$q=mysql_query("select id from katalog_files where user='$_SESSION[userid]'");
            		if(@mysql_num_rows($q)>=10)
                        echo '<a href="/k134.html?form=1" target="_blank">лимит исчерпан</a>';
                    else
                        echo '<input style="margin:0;" alt="Обзор..." type="file" name="filename" size="20">';
                        
                    echo '</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td colspan="2" style="color:#006666;font-family:Arial;font-size:9px;">
						Размер одного файла не может превышать <b>2Mb</b><br />
						Типы файлов для загрузки: txt, doc, docx, pdf, jpg, png, gif, rar, zip
					</td>
				</tr>
			</table></form>';
 		return;
	}else{
	array_push($_SESSION[error],'Вы не авторизированый пользователь. <a href="k20.html">Войдите</a> в систему');
	echo '<script lang="javascaript">location.href="./"</script>';
	}
}else{
	$_SESSION['error']=array();
	$_SESSION['result']=array();

	include "sequrity.php";
		$text_email = $_POST['text'];
		$_POST['text']=mysql_escape_string(strip_tags($_POST['text']));
		$_POST['user']=mysql_escape_string(strip_tags($_POST['user']));
		$data=time();

	if($_SESSION['logintrue']){
	   
		if($_POST['text']!=''){
			$pattern = "#([-0-9a-z_\.]+@[-0-9a-z_\.]+\.[a-z]{2,6})#i"; 
  			$text = preg_replace($pattern, "***@***.***", $_POST['text']);
			$text = str_replace("vk.com","", $text);
			$text = str_replace("facebook.com","", $text);
			$text = str_replace("odnoklassniki.ru","", $text);
            
            if ($_POST['text'] != $text)
            {
                mysql_query("UPDATE katalog SET menu_dozvil=1 WHERE id=$_SESSION[userid]");
    			/*$charset = "windows-1251";
    			$content = "text/html;";
    			$subject = "Блокировка пользователя ".$_SESSION["userlogin"].' (ID='.$_SESSION[userid].')';
    			$headers  = "MIME-Version: 1.0\r\n";
    			$headers .= "Content-Type: $content  charset=$charset\r\n";
    			$headers .= "Date: ".date("Y-m-d (H:i:s)",time())."\r\n";
    			$headers .= "From: Контакты Решебник <no-replay@stud-help.com>\r\n";*/
    			$message = "<B>Дата блокировки: ".date("Y-m-d (H:i:s)",time())."\r\n</B><BR>";
                $message .= 'Причина: E-mail в сообщении. <br /><br /><center>***ТЕКСТ СООБЩЕНИЯ***</center><BR />'.$_POST['text'];
                
				$mail = new PHPMailer();
                $mail->CharSet = "windows-1251";
                $mail->IsSMTP();
                $mail->Host = '127.0.0.1';
                $mail->From = 'no-reply@stud-help.com';
                $mail->FromName = 'Контакты Решебник';
                $mail->Subject = $mail->AltBody = "Блокировка пользователя ".$_SESSION["userlogin"].' (ID='.$_SESSION[userid].')';
                $mail->addReplyTo('no-reply@stud-help.com', 'No-Reply');
                
                $mail->MsgHTML($message);
                $mail->ClearAddresses();
                $mail->AddAddress('danko2009@inbox.ru');
                $send_ok = $mail->Send();
                
    		//	$send_ok = mail('danko2009@inbox.ru',$subject,$message,$headers);
                exit();
            }
            
  			$_POST['text'] = $text;
			if($_POST['user']){
				if($_POST['profil']==2){//--------message
					$user_out=mysql_fetch_array(mysql_query("select id_p from katalog_user where login='".$_POST['user']."' limit 1"));
                    if ($_SESSION['userid'] === $user_out['id_p']) array_push($_SESSION['error'],'Нельзя отправить самому себе');// echo 'Сам себе';
                    else 
                    {
					mysql_query("insert into katalog_message(user_in,user_out,text,data_create) values('".$_SESSION['userid']."','".$user_out['id_p']."','".addslashes($_POST['text'])."','$data')")or die(mysql_error());
				    $msg_id = mysql_insert_id();
                    }
                }
			}else{array_push($_SESSION['error'],'Вы не ввели пользователя');}
		}else{array_push($_SESSION['error'],'Вы не ввели сообщение');}
		if(count($_SESSION[error])==0){
		  
            array_push($_SESSION[result],'Cообщение отправлено');
            
            /** FILE ***********************************/
            
    		if($_FILES["filename"]["size"]){
		    
                if (end(explode(".",$_FILES['filename']['name'])) == 'php') {
    		      array_push($_SESSION[error],'Файла неверного формата');
            	}
        		
        		if($_FILES["filename"]["size"]>$max_size_file_int || $_FILES["filename"]["error"] == UPLOAD_ERR_INI_SIZE || !count($_FILES)){
        			array_push($_SESSION[error],'Файл превышает '. $max_size_file .', слишком большой');
        		}
                
        		$r=mysql_query("select id from katalog_files where user='$_SESSION[userid]'");
        		if(@mysql_num_rows($r)>=10){
        			array_push($_SESSION[error],'Исчерпан лимит количества файлов');
        		}
        
    			if(count($_SESSION[error])==0){
    
                    $_FILES['filename']['name']=translit($_FILES['filename']['name']);
            		$url="uploads/f_".$data."_".$_SESSION[userid]."_".$_FILES['filename']['name'];
    				copy($_FILES['filename']['tmp_name'], "../".$url);
    
    				mysql_query("insert into katalog_files(url,data_create,user) values('$url','$data','$_SESSION[userid]')")or die(mysql_error());
                    $file_id = mysql_insert_id();
                    $file_text_link = "<a href='http://stud-help.com/modul/download.php?id=$file_id&f'>файл</a>";
                    
                    mysql_query('UPDATE `katalog_message`
                                 SET `text` = CONCAT(`text`, " ' . addslashes($file_text_link) . '")
                                 WHERE `id` = ' . $msg_id);
                    
                     $text_email .= ' ' . $file_text_link;                                                                                       
    			}
            
            }
    		//if(count($_SESSION[error])==0){array_push($_SESSION[result],'Файл успешно загружен');}
    		//else{header("Location:../k134.html");}
            
            /** FILE END ************************************/
        }
		
		if(sizeof($_SESSION['error'])) { header('Location:/modul/messagea.php?form=2&id='.$_POST['id']); exit; }
		
		/*
		 * GIM block
		 * Відправка листів всім учасникам...
		 * 
		 * */
		 
		/* 
		$r	=	mysql_query("select * from katalog_user");
		while($row=mysql_fetch_array($r)) {
			//print_r($row);
			print $row["email"]."<BR>";
		}
		
		 */
		 /*
		 print "
				<script type=\"text/javascript\" src=\"..\jquery/jquery.min.js\"></script>
				<SCRIPT languare=\"JavaScript\">
					 
					var dat = {text:'".$_POST["text"]."', user:'".$_SESSION["userlogin"]."', usto:'".$_POST["user"]."'};
					//alert('start');
					$.ajax(
							{
								url:'message_send_mail.php',
								type:'post',
								data:dat,
								success:function(data) { 
									alert(data);
									//alert('Send Email OK!');
								}
							} 
							);
							//alert('Ok');
					//window.location = '../k18.html?form=1&out';
				</SCRIPT>";*/
				
		$r	=	mysql_query("select * from katalog_user where login like '".$_POST["user"]."'");
		$text_email = str_replace("\n","<br>", $text_email);
	
		$mail = new PHPMailer();
        $mail->CharSet = "windows-1251";
        $mail->IsSMTP();
        $mail->Host = '127.0.0.1';
        $mail->From = 'no-reply@stud-help.com';
        $mail->FromName = 'Контакты Решебник';
        $mail->Subject = $mail->AltBody = "Новое сообщение в системе от ".$_SESSION["userlogin"];
        $mail->addReplyTo('no-reply@stud-help.com', 'No-Reply');
    
    	while($row=mysql_fetch_array($r)) {
			 
			$old=$row["email"]; 
			$message = "Вам пришло письмо с сайта <a href='http://stud-help.com'>stud-help.com</a> :<BR>";
			$mailto  = $row["email"];
			/*$charset = "windows-1251";
			$content = "text/html;";
			$subject = "Новое сообщение в системе от ".$_SESSION["userlogin"];
			$headers  = "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: $content  charset=$charset\r\n";
			$headers .= "Date: ".date("Y-m-d (H:i:s)",time())."\r\n";
			$headers .= "From: Контакты Решебник <no-replay@stud-help.com>\r\n";*/
			$message .= "<B>Дата відправлення: ".date("Y-m-d (H:i:s)",time())."\r\n</B><BR><BR><BR>";
			$message .= $text_email."<BR><BR><BR><BR>Это письмо составлено роботом, и отвечать на него не надо.";
		
            $mail->MsgHTML($message);
            $mail->ClearAddresses();
            $mail->AddAddress($mailto);
            $send_ok = $mail->Send();
        
        //	$send_ok = mail($mailto,$subject,$message,$headers);
			break;
		}
		
		print "<span>Сообщение отправлено</span><br/><button onclick='self.parent.tb_remove();' >Закрыть</button>";
		unset($_SESSION['error']);
		unset($_SESSION['result']);

					
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		
		//header("Location:../k18.html?form=1&out");
  	}else{
    	array_push($_SESSION['error'],'Вы не авторизированый пользователь. <a href="k20.html">Войдите</a> в систему');
    	//header("Location:../");
	}
}

?>
