<?
include "mysql.php";
if(isset($_GET[id_user])){//not na site
	require_once $_SERVER["DOCUMENT_ROOT"] . "/modul/custom_sessions.php"; CustomSessions::start();
	$_SESSION[error]=array();
	$_SESSION[result]=array();

	$_GET[id_user]=mysql_escape_string(strip_tags($_GET[id_user]));
	$_GET[keycode]=mysql_escape_string(strip_tags($_GET[keycode]));
	$f=mysql_fetch_array(mysql_query("select generetedkey from katalog_user where id_p='$_GET[id_user]' limit 1"));
	if($f[generetedkey]==$_GET[keycode]){
		array_push($_SESSION[result],'Ваш аккаунт был активирован');
		mysql_query("update katalog set menu_vizible='0' where id='$_GET[id_user]' limit 1");
	}else{
		array_push($_SESSION[error],'Ваш аккаунт не был активирован, неверный ключ активации');
	}
header("Location:../k20.html");
}else{
if(!isset($_POST[B1]) and !isset($_POST[B2])){//na site
	if($_SESSION[logintrue]){
		$f=mysql_fetch_array(mysql_query("select add_info,resh,changing,rozdil,url,mesmes,meszad,polz,zad,icq,tel,gorod,univer,dat_birth,coment,mail_spam_new_zakaz,mail_spam_new_messages from katalog_user where id_p='$_SESSION[userid]' limit 1"));
		echo '
		<script lang="javascript">
			function show(temp){
				for(i=1;i<=5;i++){
					document.getElementById(\'form\'+i).style.display="none";
				}
				document.getElementById(temp).style.display="block";
			}
		</script>
			<table class="tabs" border="0" cellpadding="5" bgcolor="ffffff">
				<tr bgcolor="365C71">
					<td>
						<table border=0 cellpadding="0" cellspacing="0">
							<tr><td><img alt=""  src="images/report_user.png" border=0 hspace=2></td>
								<td><a onclick="show(\'form1\')" href="#" class=infobold>Редактирование профиля</a></td>
							</tr>
						</table>
					</td>
					<td><a onclick="show(\'form2\')" href="#" class=infobold>Изменение настроек</a></td>
					<td><a onclick="show(\'form3\')" href="#" class=infobold>Изменение пароля</a></td>
					<td><a onclick="show(\'form4\')" href="#" class=infobold>Загрузка фотографии</a></td>
					<td><a onclick="show(\'form5\')" href="#" class=infobold>Сотрудничество</a></td>
				</tr>
			</table><table width="100%" cellpadding="10"><tr><td style="border:1px solid #70A0BA">';
			echo '
			<form action="modul/profil.php" method=post id="form1" ';if(!isset($_GET[form]) or $_GET[form]==1){echo 'style="display:block"';}else{echo 'style="display:none"';} echo '>
			<input type="hidden" name="profil" value="1">
			<table border="0" align=center>
				<tr>
					<td align="right"><font size="2" face="Arial">ICQ:</font></td>
					<td>
					</td>
					<td><input type="text" name="icq" size="40" value="',$f[icq],'" style="width:300"  class="number"></td>
				</tr>
				<tr>
					<td align="right"><font size="2" face="Arial">Телефон:</font></td>
					<td>
					</td>
					<td><input type="text" name="tel" size="40" value="',$f[tel],'" style="width:300"></td>
				</tr>
				<tr>
					<td align="right"><font face="Arial" size="2">Город:</font></td>
					<td>
					</td>
					<td><input type="text" name="gorod" size="40" value="',$f[gorod],'" style="width:300"></td>
				</tr>
				<tr>
					<td align="right" height="25"><font size="2" face="Arial">Образование:</font></td>
					<td height="25">
					</td>
					<td height="25"><input type="text" name="univer" size="40" value="',$f[univer],'" style="width:300"></td>
				</tr>
				<tr>
					<td align="right"><font size="2" face="Arial">Возраст:</font></td>
					<td>
					</td>
					<td><input type="text" name="dat_birth" size="40" value="',$f[dat_birth],'" style="width:300"  class="number"></td>
				</tr>';
                
                 $q3 = mysql_query("SELECT `vt`.*, `vu`.`rekv`
                                    FROM `vivod_types` `vt`
                                    LEFT JOIN `vivod_user_rekv` `vu` ON(`vu`.`user_id` = '$_SESSION[userid]' AND `vu`.`vivod_type` = `vt`.`id`)
                                    WHERE `vt`.`status` = 1 AND `vt`.`saved` = 1
                                    ORDER BY `vt`.`ordered`");
                
                while($res = mysql_fetch_object($q3))
                {
                    echo '<tr>
    					<td align="right" height="25"><font size="2" face="Arial">'.$res->name.':</font></td>
    					<td height="25">
    					</td>
    					<td height="25"><input type="text" name="arrekv['.$res->id.']" size="40" value="'.htmlentities($res->rekv, ENT_COMPAT | ENT_HTML401, 'windows-1251').'" style="width:300"></td>
    				</tr>';                    
                }

				echo '<tr>
					<td align="right">&nbsp;</td>
					<td>
					&nbsp;</td>
					<td>
					<b><i><font size="2" face="Arial" color="#28A8AE">В
					комментарии оставлять контактные данные запрещено!</font></i></b><font face="Arial" style="font-size: 8pt"><br>
					Максимальная длина комментария: 500 символов</font></td>
				</tr>
				<tr>
					<td align="right"><font face="Arial" size="2">Комментарии:</font></td>
					<td>
					</td>
					<td><textarea rows="2" name="coment" cols="20" style="width:300; height:100" onkeypress="return imposeMaxLength(this, 500);">',$f[coment],'</textarea></td>
				</tr>
				<tr>
					<td align="right">&nbsp;</td>
					<td>&nbsp;</td>
					<td><input type="submit" value="Изменить" name="B1"></td>
				</tr>
			</table></form>
			<form action="modul/profil.php" method=post id="form2" ';if($_GET[form]==2){echo 'style="display:block"';}else{echo 'style="display:none"';} echo '>
			<input type="hidden" name="profil" value="2">
			<table border="0" align=center>
				<tr>
					<td align="right"><font size="2" face="Arial">Количество
					задач на странице:</font></td>
					<td>
					</td>
					<td><select size="1" name="zad" style="width:50px">';
					for($i=1;$i<=10;$i=$i+2){echo '<option value="',$i*10,'" ';if($f[zad]==$i*10){echo 'selected';}echo '>',$i*10,'</option>';}
					echo '</select></td>
				</tr>
				<tr>
					<td align="right"><font size="2" face="Arial">Количество
					пользователей на странице:</font></td>
					<td>
					</td>
					<td><select size="1" name="polz" style="width:50px">';
					for($i=1;$i<=10;$i=$i+2){echo '<option value="',$i*10,'" ';if($f[polz]==$i*10){echo 'selected';}echo '>',$i*10,'</option>';}
					echo '</select></td>
				</tr>';
                
        if (isset($_SESSION[userid]) and $_SESSION[userid] > 0)
        {
            $q = mysql_query('SELECT COUNT(*) FROM ajax_actives WHERE usr_id = '.$_SESSION[userid]);
            $q = mysql_fetch_row($q);
            if ($q[0] == 0) $active_ajax_online = 1;
            else $active_ajax_online = 0;
        } 
        else $active_ajax_online = 1;?>
                
                <script>
                
                var ajax_onliner_active = <?php if ($active_ajax_online == 1) echo 'true'; else echo 'false'; ?>;
                
                $(document).ready(function(){
                  if (ajax_onliner_active) $('#ajax_cfg').html('Выключить');
                  else $('#ajax_cfg').html('Включить');
                 }); 
                 
                 function cfg_ajax_online() 
                  {
                    $('#ajax_cfg').attr("disabled", "disabled");
                    if (ajax_onliner_active) ajax_onliner_active = false; else ajax_onliner_active = true;
                    
                    $.get("ajax_online_cfg.php?pss=fyBek3m0T3D1md&active="+ajax_onliner_active, (function(data) {
                         // alert('ok');
                         // $('#ajax_cfg').removeAttr("disabled");
                          location.reload();
                        //  if (ajax_onliner_active) $('#ajax_cfg').html('Выключить');
                        //  else $('#ajax_cfg').html('Включить');
                    }));
                  } 
                  
                  function btn_recheck(btn)
                  {
                  
                    var buf_input = btn.parent().children('input:first');

                    if(buf_input.val() != 0) 
                    {
                        buf_input.val(0);
                        btn.html('Включить');
                    }
                    else
                    {
                        buf_input.val(1);
                        btn.html('Выключить');
                    }
                    
                  }
                
                </script>
                
                <tr>
                    <td align="right">Оповещение о зашедших пользователях:</td>
                    <td></td>
                    <td>
                    <button onclick="cfg_ajax_online();" id='ajax_cfg' type='button'>Add</button>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 20px 0;">
                        <b> Автоматическая рассылка на e-mail <br />
                          писем о новых задачах на сайте </b><br />
                        (при отключении этой опции Вам не будут <br />
                         приходить извещения о новых задачах на e-mail)
                    </td>
                    <td></td>
                    <td>
                    <?if($f['mail_spam_new_zakaz']):?>
                        <button onclick="btn_recheck($(this));" type='button'>Выключить</button>
                        <input type="hidden" value="1" name="mail_spam_new_zakaz" />
                    <?else:?>
                        <button onclick="btn_recheck($(this));" type='button'>Включить</button>
                        <input type="hidden" value="0" name="mail_spam_new_zakaz" />
                    <?endif?>
                    </td>
                </tr>
                <tr>
                    <td>
                       <b>Автоматическая рассылка на e-mail <br />
                        сообщений на сайте</b> <br />
                       (при отключении этой опции Вам не будут <br />
                        приходить извещения о новых письмах на e-mail)
                    </td>
                    <td></td>
                    <td>
                    <?if($f['mail_spam_new_messages']):?>
                        <button onclick="btn_recheck($(this));" type='button'>Выключить</button>
                        <input type="hidden" value="1" name="mail_spam_new_messages" />
                    <?else:?>
                        <button onclick="btn_recheck($(this));" type='button'>Включить</button>
                        <input type="hidden" value="0" name="mail_spam_new_messages" />
                    <?endif?>
                    </td>
                </tr>
                <?php 
                echo '
				<!--<tr>
					<td align="right"><font size="2" face="Arial">Уведомлять о
					сообщениях по e-mail:</font></td>
					<td>
					</td>
					<td><select size="1" name="mesmes" style="width:50px">
						<option value="1" ';if($f[mesmes]==1){echo 'selected';}echo '>да</option>
						<option value="0" ';if($f[mesmes]==0){echo 'selected';}echo '>нет</option>
						</select></td>
				</tr>
				<tr>
					<td align="right"><font face="Arial" size="2">Уведомлять о
					статусе заказов:</font></td>
					<td>
					</td>
					<td><select size="1" name="meszad" style="width:50px">
						<option value="1" ';if($f[meszad]==1){echo 'selected';}echo '>да</option>
						<option value="0" ';if($f[meszad]==0){echo 'selected';}echo '>нет</option>
						</select></td>
				</tr>-->
				<tr>
					<td align="right"><input type="submit" value="Изменить" name="B1"></td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
			</table></form>
			<form enctype="multipart/form-data" action="modul/profil.php" method=post id="form3" ';if($_GET[form]==3){echo 'style="display:block"';}else{echo 'style="display:none"';} echo '>
			<input type="hidden" name="profil" value="3">
			<table border="0" align=center>
				<tr>
					<td align="right"><font size="2" face="Arial">Старый пароль:</font></td>
					<td>
					</td>
					<td><input type=password AUTOCOMPLETE="OFF" name="oldpas" size="40" style="width:200"></td>
				</tr>
				<tr>
					<td align="right"><font size="2" face="Arial">Новый пароль:</font></td>
					<td>
					</td>
					<td><input type=password AUTOCOMPLETE="OFF" name="newpas" size="40" style="width:200"></td>
				</tr>
				<tr>
					<td align="right"><font face="Arial" size="2">Подтверждение:</font></td>
					<td>
					</td>
					<td><input type=password AUTOCOMPLETE="OFF" name="pas" size="40" style="width:200"></td>
				</tr>
				<tr>
					<td align="right">&nbsp;</td>
					<td>&nbsp;</td>
					<td><input type="submit" value="Изменить" name="B1"></td>
				</tr>
			</table></form>
			<form action="modul/profil.php" id="form4" method=post enctype="multipart/form-data" ';if($_GET[form]==4){echo 'style="display:block"';}else{echo 'style="display:none"';} echo '>
			<input type="hidden" name="profil" value="4">
			<table border="0" width=700 align=center>
				<tr>
					<td rowspan="5" width=200 valign=middle align=center><img alt=""  src="';
					if($f[url]==''){echo 'images/nophoto.png';}else{echo $f[url];}
					echo '"></td><td width=10></td>
					<td valign=top>
						<table><tr><td><i><b><font size="2" face="Arial" color="#28A8AE">
							Загрузка фотографии</font></b></i><hr style="color: #28A8AE;background-color:#28A8AE;border:0px none;height:1px;clear:both;" size=0></td>
						</tr>
						<tr>
							<td><font size="2" face="Arial">Вы можете загрузить сюда
							только собственную фотографию расширения JPG, GIF или PNG.
							Загрузка постороннего изображения приведёт к блокированию
							Вашего аккаунта.</font></td>
						</tr>
						<tr>
							<td ><font size="2" face="Arial"><font color="#28A8AE"><i><b>
							Фотография:</b></i></font>
							</font><font face="Arial"> <input type="file" name="filename" size="20"></font></td>
						</tr>
						<tr>
							<td><font size="2" face="Arial">Максимальный размер файла
							500КБ. Файл будет сжат до 200 пикселей в ширину, сохраняя
							пропорции.</font></td>
						</tr>
						<tr>
							<td><input type="submit" value="Загрузить" name="B1"> <input type="submit" value="Удалить" name="B2"></td></tr></table></td>
						</tr>
						</table>
			</form>
			<form action="modul/profil.php" id="form5" method=post ';if($_GET[form]==5){echo 'style="display:block"';}else{echo 'style="display:none"';} echo '>
			<input type="hidden" name="profil" value="5">
							<p align="center"><font face="Arial" size="2" color="#333333">Хотите
		стать решающим задачи? Тогда, вступайте в команду Stud-help.com!
		Мы предлагаем выгодные условия сотрудничества и удобство взаиморасчетов.</font></p>
<p align="center"><font face="Arial" size="2" color="#333333">Заполните
приведенную ниже форму. Поля, отмеченные <img alt=""  src="images/bullet.png">,
		обязательны для заполнения!</font></p>
			<table border="0" align=center>
				<tr>
					<td align="right"></td>
					<td></td>
					<td>';
					if($f[resh]==1){echo '<font color=#529F33 face=arial size=2>Вы в команде решающих</font>';}
					else if($f[changing]==0){echo '<font color=#529F33 face=arial size=2>Новая заявка на сотрудничество</font>';}
					if($f[changing]==1){echo '<font color=ff0000 face=arial size=2>Заявка обрабатывается</font>';}
					echo '</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td align="right"><font face="Arial" size="2">Город
					проживания:</font></td>
					<td>
					<font size="2" face="Arial" color="#333333"> <img alt=""  src="images/bullet.png"></font></td>
					<td><input type="text" name="gorod" size="40" value="',$f[gorod],'" style="width:300"></td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td align="right" height="25"><span lang="ru">
					<font face="Arial" size="2">О</font></span><font size="2" face="Arial">бразование:</font></td>
					<td height="25">
					<font size="2" face="Arial" color="#333333"> <img alt=""  src="images/bullet.png"></font></td>
					<td height="25"><input type="text" name="univer" size="40" value="',$f[univer],'" style="width:300"></td>
					<td height="25">&nbsp;</td>
				</tr>
				<tr>
					<td align="right"><font size="2" face="Arial">Возраст:</font></td>
					<td>
					<font size="2" face="Arial" color="#333333"> <img alt=""  src="images/bullet.png"></font></td>
					<td><input type="text" name="dat_birth" size="40" value="',$f[dat_birth],'" style="width:300"></td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td align="right"><font size="2" face="Arial">Разделы
					решений:</font></td>
					<td>
					<font size="2" face="Arial" color="#333333"> <img alt=""  src="images/bullet.png"></font></td>
					<td>
					<table border="0" width="100%" id="table1">';
					$rozdil=mysql_query("select page_name,id from katalog where id_p='15' ORDER BY page_name ASC");
					$rozdil_p = explode(",", $f[rozdil]);
					for($i=1;$i<=@mysql_num_rows($rozdil);$i++){
						$rozdilf=mysql_fetch_array($rozdil);
						echo '<tr>
							<td width=10><input type="checkbox" name="r',$i,'" value="',$rozdilf[id],'" ';
							if(in_array($rozdilf[id],$rozdil_p)){echo ' checked ';}
							echo '></td>
							<td><b><font color="#00AAD1" size="2" face="Arial">
							<span lang="ru">',$rozdilf[page_name],'</span></font></b></td>
						</tr>';}
					echo '</table>
					</td>
					<td><input type="hidden" name="kil" value="',@mysql_num_rows($rozdil),'"></td>
				</tr>
				<tr>
					<td align="right"><font face="Arial" size="2">Дополнительно:</font></td>
					<td>
					</td>
					<td><textarea rows="2" name="add_info" cols="20" style="width:300; height:100">',$f[add_info],'</textarea></td>
					<td><font size="2" face="Arial">Укажите в этом поле
					дополнительную информацию: разделы, которые вы можете
					решать, но, которых нет в нашем перечне, количество времени
					в день, которое вы можете тратить на выполнение заказов,
					какие конкретно области выбранных разделов вы решаете и т.п.</font></td>
				</tr>
				<tr>
					<td align="right">&nbsp;</td>
					<td>&nbsp;</td>
					<td><input type="submit" value="Подать заявку" name="B1"></td>
					<td>&nbsp;</td>
				</tr>
			</table>
			</form></td></tr></table>';
	}else{
	$_SESSION[error]=array();
	$_SESSION[result]=array();
	array_push($_SESSION[error],'Вы не авторизированый пользователь. <a href="k20.html">Войдите</a> в систему');
    echo '<script lang="javascaript">location.href="./k20.html"</script>';
	}
}else{//not na site
	require_once $_SERVER["DOCUMENT_ROOT"] . "/modul/custom_sessions.php"; CustomSessions::start();

	$_SESSION[error]=array();
	$_SESSION[result]=array();

	include "sequrity.php";
    require_once($_SERVER["DOCUMENT_ROOT"] . '/modul/pass.php');

		$_POST[icq]=mysql_escape_string(strip_tags($_POST[icq]));
		$_POST[tel]=mysql_escape_string(strip_tags($_POST[tel]));
		$_POST[gorod]=mysql_escape_string(strip_tags($_POST[gorod]));
		$_POST[univer]=mysql_escape_string(strip_tags($_POST[univer]));
		$_POST[coment]=mysql_escape_string(strip_tags($_POST[coment]));
		$_POST[dat_birth]=mysql_escape_string(strip_tags($_POST[dat_birth]));
		$_POST[add_info]=mysql_escape_string(strip_tags($_POST[add_info]));

	if($_SESSION[logintrue]){
/**/	if($_POST[profil]==1){//-----------profil
			mysql_query("update katalog_user set icq='$_POST[icq]',tel='$_POST[tel]',gorod='$_POST[gorod]',univer='$_POST[univer]',dat_birth='$_POST[dat_birth]',coment='$_POST[coment]' where id_p='$_SESSION[userid]' limit 1")or die(mysql_error());
            
            $q3 = mysql_query('SELECT id FROM vivod_types WHERE status = 1');
            while($res = mysql_fetch_object($q3))
            {
                $rekv = trim(mysql_escape_string(strip_tags($_POST[arrekv][$res->id])));
                
                if($rekv)
                    mysql_query("REPLACE INTO vivod_user_rekv(user_id,vivod_type,rekv) VALUES ('$_SESSION[userid]','$res->id','$rekv')");
                else
                    mysql_query("DELETE FROM vivod_user_rekv WHERE user_id = '$_SESSION[userid]' AND vivod_type = '$res->id'");
            }
            
/**/	}else if($_POST[profil]==2){//--------nastr
			mysql_query("update katalog_user set zad='$_POST[zad]',polz='$_POST[polz]',mesmes='$_POST[mesmes]',meszad='$_POST[meszad]',mail_spam_new_zakaz=$_POST[mail_spam_new_zakaz], mail_spam_new_messages=$_POST[mail_spam_new_messages] where id_p='$_SESSION[userid]' limit 1")or die(mysql_error());
			$_SESSION[userpolz]=$_POST[polz];
			$_SESSION[userzadach]=$_POST[zad];
/**/	}else if($_POST[profil]==3){//---------password
			$f=mysql_fetch_array(mysql_query("select user_password from katalog_user where id_p='$_SESSION[userid]' limit 1"));
			if($_POST[newpas]!='' and $_POST[oldpas]!='' and $_POST[pas]!=''){
				if(check_password($_POST[oldpas], $f['user_password'])){    
					if($_POST[newpas]==$_POST[pas]){
					   $_POST[newpas] = hash_password($_POST[newpas]);
                       mysql_query("update katalog_user set user_password='$_POST[newpas]' where id_p='$_SESSION[userid]' limit 1")or die(mysql_error());
					   $_SESSION[userpas]=$_POST[newpas];
					}else{array_push($_SESSION[error],'Повторный пароль был веден неправильно');}
				}else{array_push($_SESSION[error],'Старый пароль не совпадает');}
			}else{array_push($_SESSION[error],'Вы не заполнили все поля');}

/**/	}else if($_POST[profil]==4){//----------foto
			if(!isset($_POST[B2])){
				if($_FILES["filename"]["size"]){
					if($_FILES["filename"]["size"]/1024<500){
				         list($width,$height)=$size=getimagesize($_FILES['filename']['tmp_name']);
				         $url="katalog/f_".$_SESSION[userid];
				         $f=mysql_fetch_array(mysql_query("select url from katalog_user where id_p='$_SESSION[userid]' limit 1"));
					     if(is_file("../".$f[url])){unlink("../".$f[url]);}

				         $allowed=array(
				          'image/jpeg',
				          'image/jpg',
				          'image/gif',
				          'image/png',
				          );

						 if($size['mime']==$allowed[0] or $size['mime']==$allowed[1]){
						   $url.=".jpg";
						   $uploadedfile = $_FILES["filename"]['tmp_name'];
						   $src = imagecreatefromjpeg($uploadedfile);

						   $newwidth=200;$newheight=($height/$width)*200;

						   $tmp=@imagecreatetruecolor($newwidth,$newheight);
						   @imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
						   @imagejpeg($tmp,"../".$url);

						   @imagedestroy($src);
						   @imagedestroy($tmp);

						 }else if($size['mime']==$allowed[2]){
						   $url.=".png";
						   $uploadedfile = $_FILES["filename"]['tmp_name'];
						   $src = imagecreatefromgif($uploadedfile);

						   $newwidth=200;$newheight=($height/$width)*200;

						   $tmp=@imagecreatetruecolor($newwidth,$newheight);
						   imagesavealpha($tmp, true);
						   $trans=imagecolorallocatealpha($tmp,0,0,0,127);
						   imagefill($tmp, 0, 0, $trans);
						   @imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
						   @imagepng($tmp,"../".$url);
						   @imagedestroy($src);
						   @imagedestroy($tmp);

						 }else if($size['mime']==$allowed[3]){
						   $url.=".png";
						   $uploadedfile = $_FILES["filename"]['tmp_name'];
						   $src = imagecreatefrompng($uploadedfile);

						   $newwidth=200;$newheight=($height/$width)*200;

						   $tmp=@imagecreatetruecolor($newwidth,$newheight);
						   imagesavealpha($tmp, true);
						   $trans=imagecolorallocatealpha($tmp,0,0,0,127);
						   imagefill($tmp, 0, 0, $trans);
						   @imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
						   @imagepng($tmp,"../".$url);
						   @imagedestroy($src);
						   @imagedestroy($tmp);

						 }else{$url=$f[url];array_push($_SESSION[error],'Неверный формат файла');}
					}else{$url=$f[url];array_push($_SESSION[error],'Файл превышает 500 Кб, слишком большой');}
				}else{$url=$f[url];array_push($_SESSION[error],'Нет Файла');}

				if(count($_SESSION[error])==0){
					mysql_query("update katalog_user set url='$url' where id_p='$_SESSION[userid]' limit 1");
				}
			}else{
				$f=mysql_fetch_array(mysql_query("select url from katalog_user where id_p='$_SESSION[userid]' limit 1"));
				if(is_file("../".$f[url])){unlink("../".$f[url]);}
				mysql_query("update katalog_user set url='' where id_p='$_SESSION[userid]' limit 1");
			}
		}else if($_POST[profil]==5){//---------password
			$f=mysql_fetch_array(mysql_query("select pas from katalog_user where id_p='$_SESSION[userid]' limit 1"));
			if($_POST[gorod]!='' and $_POST[univer]!='' and $_POST[dat_birth]!=''){
				for($i=1;$i<=$_POST[kil];$i++){
					if($_POST['r'.$i]!=''){$str.=$_POST['r'.$i].',';}
				}
				if($str!=''){
					mysql_query("update katalog_user set add_info='$_POST[add_info]',resh='0',changing='1',dat_birth='$_POST[dat_birth]',gorod='$_POST[gorod]',univer='$_POST[univer]',rozdil='$str' where id_p='$_SESSION[userid]' limit 1")or die(mysql_error());
					array_push($_SESSION[result],'Заявка была принята. После проверки администратором Вы станите решающим задач');
				}else{array_push($_SESSION[error],'Вы не выбрали не один раздел');}
			}else{array_push($_SESSION[error],'Вы не заполнили все обязательные поля');}

/**/	}
		if(count($_SESSION[error])==0){array_push($_SESSION[result],'Изменения сохранены');}
		header("Location:../k21.html?form=".$_POST[profil]);
  	}else{
    	array_push($_SESSION[error],'Вы не авторизированый пользователь. <a href="k20.html">Войдите</a> в систему');
    	header("Location:../k20.html");
	}
	}
}
?>