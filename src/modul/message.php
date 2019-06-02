<? 
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

if($_SERVER['REQUEST_METHOD'] != 'POST'){
	if($_SESSION[logintrue]){
		$f=mysql_fetch_array(mysql_query("select url,mesmes,meszad,polz,zad,icq,tel,gorod,univer,dat_birth,coment from katalog_user where id_p='$_SESSION[userid]' limit 1"));
		echo '
		<script lang="javascript">
			function show(temp){
				for(i=1;i<=2;i++){
					document.getElementById(\'form\'+i).style.display="none";
				}
				document.getElementById(temp).style.display="block";
			}
		</script>
			<table class="tabs" border="0" cellpadding="5" bgcolor="ffffff">
				<tr bgcolor="365C71">
					<td>
						<table border=0 cellpadding="0" cellspacing="0">
							<tr><td><img alt=""  src="images/zadachi/mail.png" border=0 hspace=2></td>
								<td><a onclick="show(\'form1\')" href="#" class=infobold>Мои сообщения</a></td>
							</tr>
						</table>
					</td>
					<td><a onclick="show(\'form2\')" href="#" class=infobold>Написать сообщение</a></td>
				</tr>
			</table><table width="100%" cellpadding="10"><tr><td style="border:1px solid #70A0BA">';
			echo '
			<script type=\'text/javascript\'>var users = [';
	$users=mysql_query("select login from katalog_user where id_p<>'$_SESSION[userid]'");

	if(isset($_GET[id])){
		$_GET[id]=mysql_escape_string(strip_tags($_GET[id]));
		$login=@mysql_fetch_array(@mysql_query("select login from katalog_user where id_p='$_GET[id]' limit 1"));
	}
	for($i=1;$i<=@mysql_num_rows($users);$i++){
		$usersf=mysql_fetch_array($users);echo "'",$usersf[login],"',";
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
<!---->		<form enctype="multipart/form-data" action="modul/message.php" method=post id="form2" ';if($_GET[form]==2){echo 'style="display:block"';}else{echo 'style="display:none"';} echo '>
			<input type="hidden" name="profil" value="2">
			<table border="0" align="left" style="width:450px;">
				<tr>
					<td align="right"><font face="Arial" size="2">Пользователь:</font></td>
					<td>
					</td>
					<td colspan="3"><input type="text" name="user" size="20" id="user" value="',$login[login],'"></td>
				</tr>
				<tr>
					<td align="right">&nbsp;</td>
					<td>
					&nbsp;</td>
					<td colspan="3">
					<b><i><font size="2" face="Arial" color="#28A8AE">В
					письме оставлять контактные данные запрещено!</font></i></b><font face="Arial" style="font-size: 8pt"><br>
					Максимальная длина письма: 500 символов</font></td>
				</tr>
				<tr>
					<td align="right"><font size="2" face="Arial">Сообщение:</font></td>
					<td>
					</td>
					<td colspan="3"><textarea rows="10" name="text" cols="54" onkeypress="return imposeMaxLength(this, 500);"></textarea></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td style="width:100%;"><input type="submit" value="Отправить" name="B1"></td>
					<td style="font-family:Arial;font-size:12px;">Прикрепить:</td>
					<td>';
                    
            		$q=mysql_query("select id from katalog_files where user='$_SESSION[userid]'");
            		if(@mysql_num_rows($q)>=10)
                        echo '<a href="/k134.html?form=1" target="_blank">лимит исчерпан</a>';
                    else
                        echo '<input style="margin:0;width:auto;" alt="Обзор..." type="file" name="filename" size="20">';
                        
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
			</table></form>
<!---->		<form action="modul/message.php" method=post id="form1" ';if(!isset($_GET[form]) or $_GET[form]==1){echo 'style="display:block"';}else{echo 'style="display:none"';} echo '>
			<a href="?all">Все</a> <a href="?in">Входящие</a> <a href="?out">Отправленые</a><p>
			<table border="0" width="100%" cellspacing="1" cellpadding="0" bgcolor="#cccccc">
				<tr>
					<td height="25" width="20" bgcolor="#365C71" align="center"></td>
					<td height="25" width=150 bgcolor="#365C71" align="center"><span lang="ru">
					<font size="2" face="Arial" color="#FFFFFF">Дата создания</font></span></td>
					<td height="25" bgcolor="#365C71" align="center"><span lang="ru">
					<font size="2" face="Arial" color="#FFFFFF">От кого</font></span></td>
					<td height="25" bgcolor="#365C71" align="center"><span lang="ru">
					<font size="2" face="Arial" color="#FFFFFF">Кому</font></span></td>
					<td height="25" bgcolor="#365C71" align="center"><span lang="ru">
					<font size="2" face="Arial" color="#FFFFFF">Сообщение</font></span></td>
					<td width=20px height="25" bgcolor="#365C71" align="center"></td>
					<td width=20px height="25" bgcolor="#365C71" align="center"></td>
				</tr>';
			if(isset($_GET[method])){$methodstr=' asc ';}else{$methodstr=' desc ';}

			if(!isset($_GET[first])){$_GET[first]=0;}
			if(isset($_GET[first])){$limitstr=' limit '.$_GET[first].',20 ';}

			if(isset($_GET[data])){$sqlstr=' order by data_create ';}
			else {$sqlstr=' order by data_create ';}

			if(isset($_GET[in])){$_SESSION[type]='&in';$sql='<>\''.$_SESSION[userid].'\' ';}
			if(isset($_GET[out])){$_SESSION[type]='&out';$sql='=\''.$_SESSION[userid].'\' ';}
			if(isset($_GET[all])){$_SESSION[type]='&all';$sql='';}

			$allr=mysql_query("select id from katalog_message where user_in='$_SESSION[userid]' or user_out='$_SESSION[userid]' and user_in".$sql.$sqlstr.$methodstr);
			$r=mysql_query("select * from katalog_message where (user_in='$_SESSION[userid]' or user_out='$_SESSION[userid]') and user_in ".$sql.$sqlstr.$methodstr.$limitstr)or die(mysql_error());

			if(isset($_GET[first])){$limit="&first=".$_GET[first];}

			for($i=1;$i<=@mysql_num_rows($r);$i++){
				$f=mysql_fetch_array($r);
				if($f[user_out]==$_SESSION[userid]){mysql_query("update katalog_message set status='1' where user_out='$_SESSION[userid]' and id='$f[id]'");}
				$user_in=mysql_fetch_array(mysql_query("select login from katalog_user where id_p='$f[user_in]' limit 1"));
				$user_out=mysql_fetch_array(mysql_query("select login from katalog_user where id_p='$f[user_out]' limit 1"));
				echo '<tr bgcolor="#ffffff" onmouseover="this.style.backgroundColor=\'#ECF7FF\'" onmouseout="this.style.backgroundColor=\'#ffffff\'">
			<td align=center><img alt=""  src="images/';if($f[status]==0 and $f[user_out]==$_SESSION[userid]){echo 'zadachi/new.png';}else{if($f[user_in]!=$_SESSION[userid]){echo 'mail_in.png';}else{echo 'mail_out.png';}} echo '"></td>
			<td align=center><font color="#333333" face="Arial" style="font-size: 11px">',date('d.m.y H:i',$f[data_create]),'</td>
			<td align=center>';if($f[user_in]=='0'){echo '<font color="#333333" face="Arial" style="font-size: 11px">администратор';}else{echo '<a href="k77.html?id_user=',$f[user_in],'"  class=blue>',$user_in[login],'</a></td>';}
			echo '<td align=center><a href="k77.html?id_user=',$f[user_out],'"  class=blue>',$user_out[login],'</a></td>
			<td align=center><font color="#333333" face="Arial" style="font-size: 11px">',$f[text],'</td>
			<td align=center>';if($f[user_in]!=$_SESSION[userid]){echo '<a href="k18.html?form=2&id=',$f[user_in],'"><img alt=""  border=0 src="images/mail_back.png"></a>';}echo '</td>
			<td align=center><a href="modul/messagedel.php?id=',$f[id];
			if(isset($_GET[in])){echo '&in';}
			else if(isset($_GET[out])){echo '&out';}
			else if(isset($_GET[all])){echo '&all';}
			echo '"><img alt=""  src="images/mail_del.gif" border=0></a></td>
					</tr>';
			}
			echo '</table><center><font size="2" face="Arial">Страница:';
			for($i=0;$i<ceil(@mysql_num_rows($allr)/20);$i++){
				echo '<a href="',$ide,'.html?first=',$i*20,$_SESSION[type],'" class=blue><b>',$i+1,'</b></a>. ';
			}
			echo '
			</form>
		</td></tr></table>';
	}else{
	array_push($_SESSION[error],'Вы не авторизированый пользователь. <a href="k20.html">Войдите</a> в систему');
	echo '<script lang="javascaript">location.href="./"</script>';
	}
}else{
	require_once $_SERVER["DOCUMENT_ROOT"] . "/modul/custom_sessions.php"; CustomSessions::start();
	$_SESSION[error]=array();
	$_SESSION[result]=array();

	include "sequrity.php";
		$text_email = $_POST[text];
		$pattern = "#([-0-9a-z_\.]+@[-0-9a-z_\.]+\.[a-z]{2,6})#i"; 
        
		$_POST[text]=mysql_escape_string(strip_tags($_POST[text]));
  		$text = preg_replace($pattern, "***@***.***", $_POST[text]);
		$text = str_replace("vk.com","", $text);
		$text = str_replace("facebook.com","", $text);
		$text = str_replace("odnoklassniki.ru","", $text);
        
        if ($_POST[text] != $text)
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
                
    			//$send_ok = mail('danko2009@inbox.ru',$subject,$message,$headers);
                exit();
                
            }
            
       $_POST[text] = $text;

		$_POST[user]=mysql_escape_string(strip_tags($_POST[user]));
		$data=time();

	if($_SESSION[logintrue]){
		if($_POST[text]!=''){
			if($_POST[user]){
				if($_POST[profil]==2){//--------message
					$user_out=mysql_fetch_array(mysql_query("select id_p from katalog_user where login='$_POST[user]' limit 1"));
					mysql_query("insert into katalog_message(user_in,user_out,text,data_create) values('$_SESSION[userid]','$user_out[id_p]','$_POST[text]','$data')")or die(mysql_error());
                    $msg_id = mysql_insert_id();
				}
			}else{array_push($_SESSION[error],'Вы не ввели пользователя');}
		}else{array_push($_SESSION[error],'Вы не ввели сообщение');}
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
					window.location = '../k18.html?form=1&out';
				</SCRIPT>";*/
				
		$r	=	mysql_query("select * from katalog_user where mail_spam_new_messages = 1 AND login like '".$_POST["user"]."'");
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
		
		print "<SCRIPT languare=\"JavaScript\">window.location = '../k18.html?form=1&out';</SCRIPT>";
					
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		
		//header("Location:../k18.html?form=1&out");
  	}else{
    	array_push($_SESSION[error],'Вы не авторизированый пользователь. <a href="k20.html">Войдите</a> в систему');
    	header("Location:../");
	}
	
	
	
	
}




?>









