<?
// максимальний розмір загружаемого файлу
//$max_size_file = get_cfg_var('upload_max_filesize');
//$max_size_file_int =(int)$max_size_file;


//---translit
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
//---translit
if(!isset($_POST[B1])){
	if($_SESSION[logintrue]){
		echo '
		<p align="center"><font size="2" face="Arial" color="#333333">Пожалуйста, заполните форму, приведенную ниже (поля, отмеченные <img alt=""  src="images/bullet.png"> ,		обязательны для заполнения).</font></p>
		<form action="modul/zakaz.php" onsubmit="$(\'[data-load-toggle]\').toggle();" method="post"  enctype="multipart/form-data">
		<table border="0" width="100%">
			<tr>
				<td align="right" width=120><font size="2" face="Arial" color="#333333">Условие задачи:</font></td>
				<td> <img alt=""  src="images/bullet.png"></td>
				<td><input type="file" name="filename" style="width:350px"></td>
				<td>&nbsp;</td>
				<td><font size="2" face="Arial" color="#333333">Форматы файлов: jpg, jpeg, bmp, png, gif, tif, txt, doc, docx, xls, xlsx, ppt, pptx, pdf, rar, zip</font></td>
			</tr>
			<tr>
				<td align="right"><font size="2" face="Arial" color="#333333">Раздел:</font></td>
				<td> <img alt=""  src="images/bullet.png"></td>
				<td>
		<select id="s_razdel" onchange="razdel_change();" size="1" name="razdel" style="width:350px">
		<option value="0">Выберете раздел</option>';
        $r=mysql_query("select id,page_name from katalog where id_p='15' and page_type='1' and menu_vizible='0' and menu_dozvil='0' order by page_name,menu_sort asc");
		for($i=0;$i<@mysql_num_rows($r);$i++){
			$f=mysql_fetch_array($r);
            $main_razdels[] = $f[id];
			echo '<option value="',$f[id],'">'.$f[page_name].'</option>';
		}echo '</select></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			
            <tr id="s_podrazdel" style="display: none;">
				<td align="right"><font size="2" face="Arial" color="#333333">Подраздел:</font></td>
				<td> <img alt=""  src="images/bullet.png"></td>
				<td>';
         for($i=0;$i<Count($main_razdels);$i++){
			$rr=mysql_query("select id,page_name from katalog where id_p='$main_razdels[$i]' and page_type='1' and menu_vizible='0' and menu_dozvil='0' order by page_name,menu_sort asc");
		    echo '<select style="display: none;" disabled="true" id="s_podrazdel_'.$main_razdels[$i].'" size="1" name="podrazdel" style="width:350px">';  
        	echo '<option value=0>Выберете подраздел</option>';
            for($j=0;$j<@mysql_num_rows($rr);$j++){
				$ff=mysql_fetch_array($rr);
				echo '<option value=',$ff[id],'>',$ff[page_name],'</option>';
             }
            echo '</select>'; 
         }
        echo '  </td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
            
			<tr>
				<td align="right"><font size="2" face="Arial" color="#333333">Срок решения:</font></td>
				<td> <img alt=""  src="images/bullet.png"></td>
				<td>
				<table border="0" width="100%" id="table1">
					<tr>
						<td align="right"><font size="2" face="Arial" color="#28A8BC">день</font><span lang="ru"> </span>
						</td>
						<td align="right"><select size="1" name="D1">';for($i=1;$i<=31;$i++){echo '<option value="',$i,'" ';if(date('d')==$i){echo 'selected';}echo '>';if($i<10){echo '0';} echo $i,'</option>';}echo '</select></td>
						<td align="right"><font size="2" face="Arial" color="#28A8BC">месяц</font></td>
						<td align="right"><select size="1" name="D2">';for($i=1;$i<=12;$i++){echo '<option value="',$i,'" ';if(date('m')==$i){echo 'selected';}echo '>';if($i<10){echo '0';} echo $i,'</option>';}echo '</select></td>
						<td align="right"><font size="2" face="Arial" color="#28A8BC">год</font></td>
						<td align="right"><select size="1" name="D3">';for($i=0;$i<=20;$i++){echo '<option value="',$i,'" ';if(date('y')==$i){echo 'selected';}echo '>20';if($i<10){echo '0';} echo $i,'</option>';}echo '</select></td>
						<td align="right"><font size="2" face="Arial" color="#28A8BC">врямя</font></td>
						<td align="right"><select size="1" name="D4">';for($i=0;$i<=24;$i++){echo '<option value="',$i,'" ';if(date('H')==$i){echo 'selected';}echo '>';if($i<10){echo '0';} echo $i,':00</option>';}echo '</select></td>
					</tr>
				</table>
				</td>
				<td></td>
				<td><font size="2" face="Arial" color="#333333">Cейчас: <font size="2" face="Arial" color="#28A8BC">',date('d.m.y H:i'),'</font></font></td>
			</tr>
			<tr>
				<td align="right"><font size="2" face="Arial" color="#333333">Стоимость:</font></td>
				<td> <img alt=""  src="images/bullet.png"></td>
				<td><input type="text" name="price" size="20" style="width:350px" class="cost"><span lang="ru"> </span></td>
				<td>&nbsp;</td>
				<td><b><font size="2" face="Arial" color="#333333">RUR</font></b><font size="2" face="Arial" color="#333333"> <a href="k9.html">Как верно выбрать стоимость?</a></font></td>
			</tr>
			<tr>
				<td height="26" align="right">
				<font size="2" face="Arial" color="#333333">Комментарии:</font></td>
				<td height="26">&nbsp;</td>
				<td height="26">
				<textarea rows="2" name="coment" cols="20" style="width:350; height:100"></textarea></td>
				<td height="26">&nbsp;</td>
				<td height="26"><b><i><font size="2" face="Arial" color="#28A8BC">В комментарии, как и в тексте заказа, оставлять
				контактные данные запрещено!</font></i></b><font size="2" face="Arial" color="#333333"><br>
				</font><font face="Arial" color="#333333" style="font-size: 8pt">Максимальная длина комментария: 350 символов</font></td>
			</tr>
		<script lang="javascript">
		function chek() {
		if(document.getElementById(\'pravila\').checked) {
		document.getElementById(\'sub\').disabled = false;
		} else {
		document.getElementById(\'sub\').disabled = true;
		}
		}</script>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan="3"><input id="pravila" type="checkbox" name="pravila" value="1" onchange="chek();"><font size="2" face="Arial" color="#333333">С <a href="k5.html">правилами
				оформления заказов</a> и условиями решения согласен</font></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>
                    <input data-load-toggle type="submit" value="Добавить заказ" name="B1" disabled id="sub">
                    <img data-load-toggle style="display: none;" src="/images/load-am.gif" />
                </td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
		</table><form>';
	}else{
	echo '<p align="center"><font size="2" face="Arial"><font color="#FF0000">Вы не авторизированый пользователь. Для оформления заказа
</font> <a href="k16.html">зарегистируйтель</a><font color="#FF0000"> или </font> <a href="k20.html">ввойдите</a><font color="#FF0000"> в систему</font></font></p>';
	}
}else{
	require_once $_SERVER["DOCUMENT_ROOT"] . "/modul/custom_sessions.php"; CustomSessions::start();

	$_SESSION[error]=array();
	$_SESSION[result]=array();

	$_POST[price]=mysql_escape_string(strip_tags($_POST[price]));
	$_POST[coment]=mysql_escape_string(strip_tags($_POST[coment]));

	include "../mysql.php";
	include "sequrity.php";

	//$balans=@mysql_result(mysql_query("select balance from katalog_user where id_p='$_SESSION[userid]' limit 1"),0);
	if($_SESSION[logintrue]){
	   
       $end_time=mktime($_POST[D4],0,0,$_POST[D2],$_POST[D1],$_POST[D3]);
        //array_push($_SESSION[error],'Сейчас - '. time() . ' Срок до - '. $end_time);
		if($_POST[razdel]==0){
		array_push($_SESSION[error],'Вы не выбрали раздел');
		} elseif($_POST[podrazdel]==0){
		array_push($_SESSION[error],'Вы не выбрали подраздел');
		}
        
        if (time() >= $end_time) array_push($_SESSION[error],'Срок выполнения Вашей задачи совпадает со временем на даный момент. Продлите немного срок выполнения заказа');
        
		if($_POST[price]==''){
		array_push($_SESSION[error],'Вы не ввели цену');
		}
		//if($_POST[price]>$balans){
		//array_push($_SESSION[error],'Недостаточно средств. Пополните свой <a href="k19.html">баланс</a>');
		//}
		//print_r($_FILES);print "<BR>==";
		//print ini_get('upload_tmp_dir');
		//exit;
		if(!$_FILES["filename"]["size"]){
		array_push($_SESSION[error],'Нет файла задачи');
		}else{
			$allowedarray=array('jpg','jpeg','bmp','tif','png','gif','txt','doc','docx','xls','xlsx','ppt','pptx','pdf','rar','zip', 'php','doc', 'docx', 'RAR', 'ZIP');$filearray=explode('.',$_FILES["filename"]["name"]);
			if($filearray[count($filearray)-1] == 'php'){
		   /* if($_FILES["filename"]["type"]!='image/jpeg' and
		    $_FILES["filename"]["type"]!='image/bmp' and
		    $_FILES["filename"]["type"]!='image/png' and
		    $_FILES["filename"]["type"]!='image/gif' and

			$_FILES["filename"]["type"]!="text/plain" and
		    $_FILES["filename"]["type"]!="application/msword" and
		    $_FILES["filename"]["type"]!="application/doc" and
		    $_FILES["filename"]["type"]!="application/docx" and
		    $_FILES["filename"]["type"] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document" and

		    $_FILES["filename"]["type"]!="application/vnd.ms-excel" and
		    $_FILES["filename"]["type"]!="application/xls" and
		    $_FILES["filename"]["type"]!="application/xlsx" and
		    $_FILES["filename"]["type"]!="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" and

		    $_FILES["filename"]["type"]!="application/ppt" and
		    $_FILES["filename"]["type"]!="application/pptx" and

		    $_FILES["filename"]["type"]!='application/pdf' and

		    $_FILES["filename"]["type"]!="application/rar" and
		    $_FILES["filename"]["type"]!="application/x-rar-compressed" and
		    $_FILES["filename"]["type"]!='application/zip' and
		    $_FILES["filename"]["type"]!="application/x-zip-compressed" and
		    $_FILES["filename"]["type"]!="multipart/x-zip")
		   	{   */
		    	array_push($_SESSION[error],'Файла неверного формата');
        	}
		}
		if($_FILES["filename"]["size"]>$max_size_file_int){
			array_push($_SESSION[error],'Файл превышает '.$max_size_file.', слишком большой');
		}

			if(count($_SESSION[error])==0){
			//	$end_time=mktime($_POST[D4],0,0,$_POST[D2],$_POST[D1],$_POST[D3]);

				$sort=@mysql_result(mysql_query("select menu_sort from katalog where id_p='$_SESSION[userid]' and page_type='5' order by menu_sort desc limit 1"),0)+1;
				$razdel=@mysql_result(mysql_query("select id_p from katalog where id='$_POST[podrazdel]' limit 1"),0);

				mysql_query("insert into katalog(id_p,page_name,page_type,menu_vizible,menu_dozvil,menu_sort)
				values('$_SESSION[userid]','Задача пользователя ID=$_SESSION[userid]','5','0','0','$sort')")or die(mysql_error());

				$id=mysql_insert_id();         //id uder
				$add_time=time();          	   //data add

                $_FILES['filename']['name']=translit($_FILES['filename']['name']);
        		$url="files/f_".$id."_".$_FILES['filename']['name'];
				copy($_FILES['filename']['tmp_name'], "../".$url);

                mysql_query("update katalog_user set zadach_zakaz=zadach_zakaz+1 where id_p='$_SESSION[userid]'");

				mysql_query("insert into katalog_zadach(id_p,end_time,price,razdel,podrazdel,userzakaz,url,add_time,coment)
				values('$id','$end_time','$_POST[price]','$razdel','$_POST[podrazdel]','$_SESSION[userid]','$url','$add_time','$_POST[coment]')")or die(mysql_error());

				array_push($_SESSION[result],'Заказ принят');
                CustomSessions::write_close();
                header("Location:../k6.html");
                flush();

				$r=mysql_query("select email,rozdil,login from katalog_user where mail_spam_new_zakaz = 1 AND rozdil like '%$razdel%'");
				$razdel=mysql_fetch_array(mysql_query("select page_name from katalog where id='$razdel' limit 1"));
				include_once('rozsl/class.phpmailer.php');
				include "config.php";
				$et=date('d.m.y H:i',$end_time);$at=date('d.m.y H:i',$add_time);
				for($i=0;$i<@mysql_num_rows($r);$i++){
					$f=mysql_fetch_array($r);
					$info='<font size="2" face="Arial">Сообщаем Вам, что в раздел [ '.$razdel[page_name].' ] поступила новая задача!<br>
					Создана: [ '.$at.' ], Срок решения: [ '.$et.' ], Стоимость: [ '.$_POST[price].' RUR ]<br>
					Посмотреть новые задачи можно здесь <a href="http://stud-help.com/k6.html">http://stud-help.com</a></font>';
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
					$mail->Subject    = "Новые задачи на сайте: stud-help.com";
					$mail->AltBody    = "Новые задачи на сайте: stud-help.com";
					$mail->MsgHTML($body);
					$mail->AddAddress($f[email], $f[login]);
                 //   $mail->AddAddress('hunk.redfield9@gmail.com', $f[login]);
					$mail->Send();
				}
                die();
			}
            else header("Location:../k7.html");
            
  	}else{
    	array_push($_SESSION[error],'Вы не авторизированый пользователь. Для оформления заказа <a href="k16.html">зарегистируйтель</a> и <a href="k20.html">ввойдите</a> в систему');
    	header("Location:../k20.html");
	}
}
