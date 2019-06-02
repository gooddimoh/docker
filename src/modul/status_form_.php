<?
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
include "mysql.php";

require_once $_SERVER["DOCUMENT_ROOT"] . "/modul/custom_sessions.php"; CustomSessions::start();
$_SESSION[error]=array();
$_SESSION[result]=array();

$user=mysql_fetch_array(mysql_query("select resh,balance from katalog_user WHERE id_p='$_SESSION[userid]' limit 1"));
$zadacha=mysql_fetch_array(mysql_query("select id_p,podrazdel,end_time,status,url,userresh,userzakaz,price,coment from katalog_zadach where id_p='$_GET[id]' limit 1"));

if(!isset($_POST[B1])){//na site
	if($_SESSION[logintrue]){
		echo '<table border="0" cellpadding="5" bgcolor="ffffff">
				<tr bgcolor="365C71">
					<td>
						<table border=0 cellpadding="0" cellspacing="0">
							<tr><td><img alt=""  src="images/zadachi/zayava.png" border=0 hspace=2></td>
								<td><a href="#" class=infobold>';
									if($_GET[st]==4){echo 'Добавить заявку на решение задачи ID = '.$_GET[id];             //resh
									}else if($_GET[st]==5){echo 'Загрузить решение';
									}else if($_GET[st]==6){echo 'Выбор решающего';       //user
									}else if($_GET[st]==7){echo 'Редактировать задачу ID='.$_GET[id];}
								echo '</a></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			<table width="100%" cellpadding="10"><tr><td style="border:1px solid #70A0BA">';

				//add zayava
				if($_GET[st]==4){
					if($zadacha[status]<3){
                       	echo '<form action="modul/status_form.php?id=',$_GET[id],'&st=4" method="post"  enctype="multipart/form-data">
						<p><font size="2" face="Arial" color="#333333">Пожалуйста, заполните форму, приведенную ниже (поля, отмеченные <img alt=""  src="images/bullet.png"> ,
						обязательны для заполнения).</font></p>
						<table border="0">
							<tr>
								<td align="right" width="150"><font size="2" face="Arial" color="#333333">
								Ваш срок решения:</font></td>
								<td> <img alt=""  src="images/bullet.png"></td>
								<td>
								<table border="0" width="100%" id="table1">
									<tr>
										<td align="right"><font size="2" face="Arial" color="#28A8BC">день</font><span lang="ru"> </span>
										</td>
										<td align="right"><select size="1" name="D1">';for($i=1;$i<=31;$i++){echo '<option value="',$i,'" ';if(date('d',$zadacha[end_time])==$i){echo 'selected';}echo '>';if($i<10){echo '0';} echo $i,'</option>';}echo '</select></td>
										<td align="right"><font size="2" face="Arial" color="#28A8BC">месяц</font></td>
										<td align="right"><select size="1" name="D2">';for($i=1;$i<=12;$i++){echo '<option value="',$i,'" ';if(date('m',$zadacha[end_time])==$i){echo 'selected';}echo '>';if($i<10){echo '0';} echo $i,'</option>';}echo '</select></td>
										<td align="right"><font size="2" face="Arial" color="#28A8BC">год</font></td>
										<td align="right"><select size="1" name="D3">';for($i=0;$i<=20;$i++){echo '<option value="',$i,'" ';if(date('y',$zadacha[end_time])==$i){echo 'selected';}echo '>20';if($i<10){echo '0';} echo $i,'</option>';}echo '</select></td>
										<td align="right"><font size="2" face="Arial" color="#28A8BC">врямя</font></td>
										<td align="right"><select size="1" name="D4">';for($i=0;$i<=24;$i++){echo '<option value="',$i,'" ';if(date('H',$zadacha[end_time])==$i){echo 'selected';}echo '>';if($i<10){echo '0';} echo $i,':00</option>';}echo '</select></td>
									</tr>
								</table>
								</td>
								<td></td>
								<td><span lang="ru"><font face="Arial" size="2" color="#333333">
								Но не пожже</font></span><font size="2" face="Arial" color="#333333">: <font size="2" face="Arial" color="#28A8BC">',date('d.m.y H:i',$zadacha[end_time]),'</font></font></td>
							</tr>
							<tr>
								<td align="right"><font size="2" face="Arial" color="#333333">
								Ваша цена:</font></td>
								<td> <img alt=""  src="images/bullet.png"></td>
								<td><input type="text" name="price" size="20" style="width:350px" onkeyup="recalculate_price(this,\'my_price\','.(100-$config[procent]).')" name="cost" class="cost"><span lang="ru"> </span></td>
								<td>&nbsp;</td>
								<td><font size="2" face="Arial" color="#333333"><b>RUR</b><span lang="ru">
								</span></font><span lang="ru">
								<font face="Arial" size="2" color="#333333">Но не ниже</font></span><font size="2" face="Arial" color="#333333">: <font size="2" face="Arial" color="#28A8BC">';
								$price=@mysql_fetch_array(mysql_query("select price from katalog_zayava where id_p in(select id from katalog where id_p='$_GET[id]') order by price asc limit 1"));
								if($price[price]>=$zadacha[price]){echo $price[price];}else{echo $zadacha[price];}
								echo ' RUR</font></font></td>
							</tr>
                            <tr>
								<td align="right"><font size="2" face="Arial" color="#333333">
								Ваш заработок:</font></td>
                                <td>&nbsp;</td>
                                <td><font size="2" face="Arial" color="#333333"><b id="my_price"></b></font></td>
                                <td></td>
                                <td></td>
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
								<td colspan="3"><input id="pravila" type="checkbox" name="pravila" value="1" onchange="chek();"><font size="2" face="Arial" color="#333333">С <a href="k5.html">
								правилами оформления заказов</a> и условиями решения согласен</font></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td><input type="submit" value="Добавить заяву" name="B1" disabled id="sub"></td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
						</table>
						<font size="2" face="Arial">Заказ был просмотрен</font><p>
                        	<table border="0" width="100%" cellspacing="1" cellpadding="0" bgcolor="#cccccc">
								<tr>
									<td height="25" bgcolor="#365C71" align="center">
									<font face="Arial" size="2" color="#FFFFFF">Решающей</font></td>
									<td height="25" bgcolor="#365C71" align="center"><span lang="ru">
									<font size="2" face="Arial" color="#FFFFFF">Кол-во решенных задач</font></span></td>
									<td height="25" bgcolor="#365C71" align="center"><span lang="ru">
									<font size="2" face="Arial" color="#FFFFFF">Стоимость</font></span></td>
									<td height="25" bgcolor="#365C71" align="center"><span lang="ru">
									<font size="2" face="Arial" color="#FFFFFF">Дата добавления</font></span></td>
									<td height="25" bgcolor="#365C71" align="center"><span lang="ru">
									<font size="2" face="Arial" color="#FFFFFF">Время решения задачи</font></span></td>
									<td height="25" bgcolor="#365C71" align="center"><span lang="ru">
									<font size="2" face="Arial" color="#FFFFFF">Время продления</font></span></td>
								</tr>';
								$r=mysql_query("select userresh,price,add_time,end_time from katalog_zayava where id_p in(select id from katalog where id_p='$_GET[id]') order by price desc")or die(mysql_error());
								for($i=1;$i<=@mysql_num_rows($r);$i++){
									$f=mysql_fetch_array($r);
									$userresh=mysql_fetch_array(mysql_query("select login,zadach from katalog_user where id_p='$f[userresh]'"));
									echo '
									<tr bgcolor=white>
										<td align=center><a onmousemove="usr_vis('.$i.',2);" onmouseout="noShow()" href="k77.html?id_user=',$f[userresh],'"  class=blue target="_blank">',$userresh[login],'</a>
                                        ';
                                                echo <<<_USERINFO
 <div onmouseout="usr_hide($i,2)" class="usr_info" id="userinfo2_$i"> 
  <a onmousemove="clearTimeout(tmr);" href="k77.html?id_user=$f[userresh]"  class="profile">Профиль ($userresh[login])</a><br />
_USERINFO;

	echo '<a style="background: url(/images/zadachi/mail.png) no-repeat;" class="thickbox" onmousemove="clearTimeout(tmr);" href="/modul/messagea.php?form=2&noerr&id=',$f[userresh],'&TB_iframe=true&modal=false&height=200&width=300" title="">Написать письмо</a>';
            echo '<br /><a onmousemove="clearTimeout(tmr);" href="k19.html?usr_id='.$f[userresh].'" class="money">Переслать деньги</a>';
            echo '<br /><a onmousemove="clearTimeout(tmr);" href="k12-otzivi_o_proekte_reshenie_zadach.html?usr_id='.$f[userresh].'" class="otzyv">Оставить отзыв</a>';
echo '</div></td>';


echo'
										<td align=center><font color="#333333" face="Arial" style="font-size: 11px">',$userresh[zadach],'</td>
										<td align=right><font color="#333333" face="Arial" style="font-size: 11px">',$f[price],' <b>RUR</b>&nbsp;&nbsp;</td>
										<td align=center><font color="#333333" face="Arial" style="font-size: 11px">',date('d.m.y H:i',$f[add_time]),'</td>
										<td align=center><font color="#333333" face="Arial" style="font-size: 11px">',date('d.m.y H:i',$f[end_time]),'</td>
										<td align=center><font color="#333333" face="Arial" style="font-size: 11px">';if((($f[end_time]-$zadacha[end_time])/60/60)>0){echo '+';} echo ($f[end_time]-$zadacha[end_time])/60/60,' часов</td>
									</tr>';}
							echo '</table><form>';
					}else{array_push($_SESSION[error],'Заказ уже имеет решащего');}
				//download resh
				}else if($_GET[st]==5){
					if($zadacha[userresh]==$_SESSION[userid]){
		               	if($zadacha[status]==3){
       	                    echo '<form action="modul/status_form.php?id=',$_GET[id],'&st=5" method="post"  enctype="multipart/form-data">
                        	<p align="justify"><font size="2" face="Arial">В этом разделе вы можете
							<span lang="ru">загрузить решение</span> задачи. <span lang="ru">Файл</span>
							<span lang="ru">решения</span> должен быть в одном из следующих
							 форматов:</font></p>
							<p align="justify"><font size="2" face="Arial">Текстовые: TXT, DOC (Microsoft Word), DOCX (Microsoft Word 2007), PDF<br />
							Графические: JPG, GIF, PNG<br />
							Архивы: RAR, ZIP</font></p>
							<p align="justify"><font size="2" face="Arial">Формат DOC является
							предпочтительным, если у вас в <span lang="ru">решение</span> фигурируют сложные
							 выражения с дробями, корнями и т.п. Размер прикрепляемого файла не должен
							 превышать <b>500КБ </b>(если размер файла больше, залейте условие на любой
							 файлообменник, поместите ссылку в текстовый и загрузите его в качестве
							 файла-условия).</font></p>
							<table border="0" width="100%" id="table1" style="border: 1px solid #FB7B00" cellspacing="10" cellpadding="0">
							    <tbody>
							        <tr>
							            <td width="80"><img alt=""  border="0" alt="" width="80" height="80" src="images/alert.png" /></td>
							            <td>
							            <p align="justify"><font color="#EA6B00" size="2" face="Arial"><i><b>ВНИМАНИЕ! </b></i>
							 			После того, как заказ будет оплачен на ваш счет
										поступит полная сумма заказа и решение будет
										доступно для скачивания!</font></p>
							            </td>
							        </tr>
							    </tbody>
							</table><p>
                        	<table border="0" id="table2">
								<tr>
									<td><b><font face="Arial" size="2" color="#006666">Файл:</font></b></td>
									<td><input type="file" name="filename" size="20"></td>
									<td><input type="submit" value="Загрузить" name="B1"></td>
								</tr>
							</table></form>';
						}else{array_push($_SESSION[error],'Вы не можете отказаться, заказ уже частично оплачен');}
					}else{array_push($_SESSION[error],'У Вас нет прав на изменение заказа');}
				//vibor reshayuschego
				}else if($_GET[st]==6){
					if($zadacha[userzakaz]==$_SESSION[userid]){
						if($zadacha[status]<3){
                        	echo '<form action="modul/status_form.php?id=',$_GET[id],'&st=6" method="post"  enctype="multipart/form-data">
                        	<p align="justify"><font size="2" face="Arial">Ваш заказ был просмотрен одним или несколькими решающими. Необходимо выбрать одного из них в качестве исполнителя заказа. При выборе решающего основывайтесь на цену и количество выполненых им задач</font></p>
							<table border="0" width="100%" id="table1" style="border: 1px solid #FB7B00" cellspacing="10" cellpadding="0">
							    <tbody>
							        <tr>
							            <td><img alt=""  border="0" alt="" width="80" height="80" src="images/alert.png" /></td>
							            <td>
							            <p align="justify"><font color="#EA6B00" size="2" face="Arial"><b><i>
										ВНИМАНИЕ! </i></b>Для того, чтобы согласится на решение задач
										необходимо иметь на балансе сумму, равную не менее половины от
										стоимости решения. Она будет использована в качестве предоплаты,
										т.е. будет вычетана с вашего баланса! Также обратите внимание, что
										срок решения задач автоматическе продлится на время, равное разности
										между датой согласия и датой просмотра заказа конкретным решающими.
										Время в часах, на которое продлится срок решения указан в таблице
										для каждого решающего</font></p>
							            </td>
							        </tr>
							    </tbody>
							</table><p>
                        	<table border="0" width="100%" cellspacing="1" cellpadding="0" bgcolor="#cccccc">
								<tr>
									<td height="25" width=20 bgcolor="#365C71" align="center">
									&nbsp;</td>
									<td height="25" bgcolor="#365C71" align="center">
									<font face="Arial" size="2" color="#FFFFFF">Решающей</font></td>
									<td height="25" bgcolor="#365C71" align="center"><span lang="ru">
									<font size="2" face="Arial" color="#FFFFFF">Кол-во решенных задач</font></span></td>
									<td height="25" bgcolor="#365C71" align="center"><span lang="ru">
									<font size="2" face="Arial" color="#FFFFFF">Стоимость</font></span></td>
									<td height="25" bgcolor="#365C71" align="center"><span lang="ru">
									<font size="2" face="Arial" color="#FFFFFF">Дата добавления</font></span></td>
									<td height="25" bgcolor="#365C71" align="center"><span lang="ru">
									<font size="2" face="Arial" color="#FFFFFF">Время решения задачи</font></span></td>
									<td height="25" bgcolor="#365C71" align="center"><span lang="ru">
									<font size="2" face="Arial" color="#FFFFFF">Время продления</font></span></td>
								</tr>';
								$r=mysql_query("select userresh,price,add_time,end_time from katalog_zayava where id_p in(select id from katalog where id_p='$_GET[id]') order by price desc")or die(mysql_error());
								for($i=1;$i<=@mysql_num_rows($r);$i++){
									$f=mysql_fetch_array($r);
									$userresh=mysql_fetch_array(mysql_query("select login,zadach from katalog_user where id_p='$f[userresh]'"));
									echo '
									<tr bgcolor=white>
										<td align=center><input type=radio value="',$f[userresh],'" name="userresh" checked></td>
										<td align=center><a href="k77.html?id_user=',$f[userresh],'"  class=blue target="_blank">',$userresh[login],'</a></td>
										<td align=center><font color="#333333" face="Arial" style="font-size: 11px">',$userresh[zadach],'</td>
										<td align=right><font color="#333333" face="Arial" style="font-size: 11px">',$f[price],' <b>RUR</b>&nbsp;&nbsp;</td>
										<td align=center><font color="#333333" face="Arial" style="font-size: 11px">',date('d.m.y H:i',$f[add_time]),'</td>
										<td align=center><font color="#333333" face="Arial" style="font-size: 11px">',date('d.m.y H:i',$f[end_time]),'</td>
										<td align=center><font color="#333333" face="Arial" style="font-size: 11px">';if((($f[end_time]-$zadacha[end_time])/60/60)>0){echo '+';} echo ($f[end_time]-$zadacha[end_time])/60/60,' часов</td>
									</tr>';}
							echo '</table><p align=center><input type="submit" value="Выбрать решающего" name="B1"></form>';
						}else{array_push($_SESSION[error],'Вы уже выбрали решающего');}
					}else{array_push($_SESSION[error],'У Вас нет прав на изменение заказа');}
				//edit zadach //prodlit
				}else if($_GET[st]==7){
					if($zadacha[userzakaz]==$_SESSION[userid]){
							echo '<form action="modul/status_form.php?id=',$_GET[id],'&st=7" method="post"  enctype="multipart/form-data">
								<table border="0" width="100%">
									<tr>
										<td align="right" width=120><font size="2" face="Arial" color="#333333">Условие задачи:</font></td>
										<td> <img alt=""  src="images/bullet.png"></td>
										<td><input type="file" name="filename"></td>
										<td>&nbsp;</td>
										<td><font size="2" face="Arial">Оставьте пустым, если изменение не требуется</font></td>
									</tr>
									<tr>
										<td align="right"><font size="2" face="Arial" color="#333333">Подраздел:</font></td>
										<td> <img alt=""  src="images/bullet.png"></td>
										<td><b><font face=arial size=2>';
											$r=mysql_fetch_array(mysql_query("select page_name from katalog where id='$zadacha[podrazdel]' limit 1"));
										echo $r[page_name],'</td>
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
												<td align="right"><select size="1" name="D1">';for($i=1;$i<=31;$i++){echo '<option value="',$i,'" ';if(date('d',$zadacha[end_time])==$i){echo 'selected';}echo '>';if($i<10){echo '0';} echo $i,'</option>';}echo '</select></td>
												<td align="right"><font size="2" face="Arial" color="#28A8BC">месяц</font></td>
												<td align="right"><select size="1" name="D2">';for($i=1;$i<=12;$i++){echo '<option value="',$i,'" ';if(date('m',$zadacha[end_time])==$i){echo 'selected';}echo '>';if($i<10){echo '0';} echo $i,'</option>';}echo '</select></td>
												<td align="right"><font size="2" face="Arial" color="#28A8BC">год</font></td>
												<td align="right"><select size="1" name="D3">';for($i=0;$i<=20;$i++){echo '<option value="',$i,'" ';if(date('y',$zadacha[end_time])==$i){echo 'selected';}echo '>20';if($i<10){echo '0';} echo $i,'</option>';}echo '</select></td>
												<td align="right"><font size="2" face="Arial" color="#28A8BC">врямя</font></td>
												<td align="right"><select size="1" name="D4">';for($i=0;$i<=24;$i++){echo '<option value="',$i,'" ';if(date('H',$zadacha[end_time])==$i){echo 'selected';}echo '>';if($i<10){echo '0';} echo $i,':00</option>';}echo '</select></td>
											</tr>
										</table>
										</td>
										<td></td>
										<td><font size="2" face="Arial" color="#333333">Cейчас: <font size="2" face="Arial" color="#28A8BC">',date('d.m.y H:i'),'</font></font></td>
									</tr>
									<tr>
										<td align="right"><font size="2" face="Arial" color="#333333">Стоимость:</font></td>
										<td> <img alt=""  src="images/bullet.png"></td>
										<td><input type="text" name="price" size="20" style="width:350px" name="cost" class="cost" value="',$zadacha[price],'"><span lang="ru"> </span></td>
										<td>&nbsp;</td>
										<td><b><font size="2" face="Arial" color="#333333">RUR</font></b><font size="2" face="Arial" color="#333333"> <a href="k9.html">Как верно выбрать стоимость?</a></font></td>
									</tr>
									<tr>
										<td height="26" align="right">
										<font size="2" face="Arial" color="#333333">Комментарии:</font></td>
										<td height="26">&nbsp;</td>
										<td height="26">
										<textarea rows="2" name="coment" cols="20" style="width:350; height:100">',$zadacha[coment],'</textarea></td>
										<td height="26">&nbsp;</td>
										<td height="26"><b><i><font size="2" face="Arial" color="#28A8BC">В комментарии, как и в тексте заказа, оставлять
										контактные данные запрещено!</font></i></b><font size="2" face="Arial" color="#333333"><br>
										</font><font face="Arial" color="#333333" style="font-size: 8pt">Максимальная длина комментария: 350 символов</font></td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td><input type="submit" value="Сохранить изменения" name="B1"></td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
									</tr>
								</table><form>';
					}else{array_push($_SESSION[error],'У Вас нет прав на изменение заказа');}
				}else{array_push($_SESSION[error],'Неверное действие');}

			if(count($_SESSION[error])!=0){echo '<script lang="javascaript">location.href="./k6.html"</script>';}
			echo '</td></tr></table>';

	}else{//not na site
		require_once $_SERVER["DOCUMENT_ROOT"] . "/modul/custom_sessions.php"; CustomSessions::start();
		$_SESSION[error]=array();
		$_SESSION[result]=array();
		array_push($_SESSION[error],'Вы не авторизированый пользователь. <a href="k20.html">Войдите</a> в систему');
		echo '<script lang="javascaript">location.href="./k20.html"</script>';
	}
}else{//not na site

	include "sequrity.php";
    $data=time();
	$_POST[price]=mysql_escape_string(strip_tags($_POST[price]));
	$_POST[coment]=mysql_escape_string(strip_tags($_POST[coment]));

	if($_SESSION[logintrue]){
			if($zadacha[userzakaz]!=$_SESSION[userid] and $zadacha[userresh]!=$_SESSION[userid]){//---------------------------------/*ne zamovnik*/  ok
			//add zayava
				if($_GET[st]==4){
					if($zadacha[status]<3){
						$end_time=mktime($_POST[D4],0,0,$_POST[D2],$_POST[D1],$_POST[D3]);
						if($end_time>=$zadacha[end_time]){

							// min cina zayavki rishayuchih
							$price=@mysql_fetch_array(mysql_query("select price from katalog_zayava where id_p in(select id from katalog where id_p='$_GET[id]') order by price asc limit 1"));

							if($_POST[price]>=$zadacha[price] and $_POST[price]>=$price[price]){

								// ------------------ нова дата та сортування заявки
								$add_time=time();
								$sort=@mysql_result(mysql_query("select menu_sort from katalog where id_p='$_GET[id]' and page_type='6' order by menu_sort desc limit 1"),0)+1;

								// ------------------ знищити попередні заявки рішаючого на дану задачу
								if($q_tmp = mysql_query("select id from katalog where page_type='6' and id_p='$_GET[id] and id in (select id_p from katalog_zayava where userresh='$_SESSION[userid]')"))
								if(mysql_num_rows($q_tmp)) {
									$oldzayavaid=mysql_result($q_tmp,0);
									mysql_query("DELETE FROM katalog_zayava WHERE id_p='$oldzayavaid' ");
									mysql_query("DELETE FROM katalog WHERE id='$oldzayavaid' ");
								}
								//$oldzayavaid=mysql_result(mysql_query("select id from katalog where page_type='6' and id_p='$_GET[id] and id in (select id_p from katalog_zayava where userresh='$_SESSION[userid]')"),0);
								//mysql_query("DELETE FROM katalog_zayava WHERE id_p='$oldzayavaid' ");
								//mysql_query("DELETE FROM katalog WHERE id='$oldzayavaid' ");

								// ------------------ додати нову заявку на дану задачу
								mysql_query("insert into katalog(id_p,page_name,page_type,menu_vizible,menu_dozvil,menu_sort)
								values('$_GET[id]','Заява пользователя ID=$_SESSION[userid]','6','0','0','$sort')")or die(mysql_error());
								$id=mysql_insert_id();
								mysql_query("insert into katalog_zayava(id_p,add_time,end_time,price,userresh)
								values('$id','$add_time','$end_time','$_POST[price]','$_SESSION[userid]')")or die(mysql_error());

								// ------------------- встановити нову дату заявки
								mysql_query("update katalog_zadach set status='2',data_prosmotra='$add_time' where id_p='$_GET[id]'")or die(mysql_error());

								// ------------------- відправити замовнику повідомлення
								mysql_query("insert into katalog_message(user_in,user_out,text,data_create) values('$_SESSION[userid]','$zadacha[userzakaz]','Задача ID=$_GET[id]. Поступила заявка на решение','$data')");

								array_push($_SESSION[result],'Ваша заявка была принята');
							}else{array_push($_SESSION[error],'Ваша цена меньша той которую Вы указали в прошлой заявке, или меньша за стоимость заказа');}
						}else{array_push($_SESSION[error],'Ваше время решение раньше указаного термина в заказе');}
					}else{array_push($_SESSION[error],'Заказ уже имеет решащего');}
				}else{array_push($_SESSION[error],'Неверное действие');}
			}else if($zadacha[userresh]==$_SESSION[userid]){//---------------------------------/*sam rishayuchiy*/
			//download resh
				if($_GET[st]==5){
	               	if($zadacha[status]==3){
						if($_FILES["filename"]["size"]){
							if($_FILES["filename"]["size"]/1024<500){
								if($_FILES["filename"]["type"]=='image/jpeg' or $_FILES["filename"]["type"]=='image/bmp' or $_FILES["filename"]["type"]=='image/png' or $_FILES["filename"]["type"]=='image/gif' or $_FILES["filename"]["type"]=='text/plain' or $_FILES["filename"]["type"]=='application/msword' or $_FILES["filename"]["type"]=='application/msword' or $_FILES["filename"]["type"]=='application/pdf' or $_FILES["filename"]["type"]=='application/x-rar-compressed' or $_FILES["filename"]["type"]=='application/zip'){
									 
									$_FILES['filename']['name']=translit($_FILES['filename']['name']);
									$url="files/f_".$_GET[id]."_".$_FILES['filename']['name'];
									copy($_FILES['filename']['tmp_name'], "../".$url);

									mysql_query("update katalog_zadach set data_resh='$data',status='4',urlresh='$url' WHERE id_p='$_GET[id]' limit 1");
									mysql_query("update katalog_user set zadach=zadach+1 WHERE id_p='$_SESSION[userid]' limit 1");

									mysql_query("insert into katalog_message(user_in,user_out,text,data_create) values('$_SESSION[userid]','$zadacha[userzakaz]','Решающий задачи ID=$_GET[id] загрузил решение','$data')");
									/*
									 * 
									 * GIM Block
									 * відправка листа - тому кого назначили виконавцем
									 * 
									 * */
									$r_	=	mysql_query("select * from katalog_user where id_p = '$zadacha[userzakaz]'");
									//print "select * from katalog_user where id_p = '$zadacha[userzakaz]'";
									$text_email = "Решающий задачи ID=$_GET[id] загрузил решение";
								
									while($row=mysql_fetch_array($r_)) {
										//print "Start";
										$old=$row["email"]; 
										$message = "<B>Вам пришло письмо с сайта <a href='http://stud-help.com'>stud-help.com</a> :</B><BR>";
										$mailto  = $row["email"];
										$charset = "windows-1251";
										$content = "text/html;";
										$subject = "Новое сообщение в системе от ".$_SESSION["userlogin"];
										$headers  = "MIME-Version: 1.0\r\n";
										$headers .= "Content-Type: $content  charset=$charset\r\n";
										$headers .= "Date: ".date("Y-m-d (H:i:s)",time())."\r\n";
										$headers .= "From: Контакты Решебник <no-replay@stud-help.com>\r\n";
										$message .= "Дата відправлення: ".date("Y-m-d (H:i:s)",time())."\r\n</B><BR><BR>";
										$message .= $text_email."<BR><BR>Это письмо составлено роботом, и отвечать на него не надо.";
										$send_ok = mail($mailto,$subject,$message,$headers);
										break;
									}
									//print "EXIT";
									//exit;
									///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
									///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
									///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////									

									array_push($_SESSION[result],'Решение загружено');
								}else{array_push($_SESSION[error],'Файла неверного формата');}
							}else{array_push($_SESSION[error],'Файл превышает 500 Кб, слишком большой');}
						}else{array_push($_SESSION[error],'Нет файла задачи');}
					}else{array_push($_SESSION[error],'Вы не можете отказаться, заказ уже частично оплачен');}
				}else{array_push($_SESSION[error],'Неверное действие');}
			}else if($zadacha[userzakaz]==$_SESSION[userid]){//-------------------------------------/*zamovnik*/
			//vibor reshayuschego
				if($_GET[st]==6){
					if($zadacha[status]<3){
						//informaciya po zayavi
						$zayava=@mysql_fetch_array(mysql_query("select price,end_time from katalog_zayava where userresh='$_POST[userresh]' and id_p in(select id from katalog where id_p='$_GET[id]') limit 1"));
						$price=$zayava[price]*0.5;
						if($user[balance]>=$price){
							 
							//zmina statusu zadachi
							mysql_query("update katalog_zadach set price='$zayava[price]',end_time='$zayava[end_time]',status='3',userresh='$_POST[userresh]' WHERE id_p='$_GET[id]' limit 1");
							//zmenshenya balansy zamovnika
							mysql_query("update katalog_user set balance=balance-'$price' WHERE id_p='$_SESSION[userid]' limit 1");
                            //znuschenya lishnih zayav
							mysql_query("DELETE FROM katalog_zayava WHERE userresh<>'$_POST[userresh]' and id_p in(select id from katalog where id_p='$_GET[id]')");
							mysql_query("DELETE FROM katalog WHERE id_p='$_GET[id]' and id not in(select id_p from katalog_zayava)")or die(mysql_error());
							 
                            mysql_query("insert into katalog_message(user_in,user_out,text,data_create) values('$_SESSION[userid]','$_POST[userresh]','$_SESSION[userid] $_POST[userresh] Вас выбрали решающим задачи ID=$_GET[id]','$data')");
							/*
							 * 
							 * GIM Block
							 * відправка листа - тому кого назначили виконавцем
							 * 
							 * */
							$r_	=	mysql_query("select * from katalog_user where id_p = '$_POST[userresh]'");
							$text_email = "Вас выбрали решающим задачи ID=$_GET[id]";
						
							while($row=mysql_fetch_array($r_)) {
								$old=$row["email"]; 
								$message = "<B>Вам пришло письмо с сайта <a href='http://stud-help.com'>stud-help.com</a> :</B><BR>";
								$mailto  = $row["email"];
								$charset = "windows-1251";
								$content = "text/html;";
								$subject = "Новое сообщение в системе от ".$_SESSION["userlogin"];
								$headers  = "MIME-Version: 1.0\r\n";
								$headers .= "Content-Type: $content  charset=$charset\r\n";
								$headers .= "Date: ".date("Y-m-d (H:i:s)",time())."\r\n";
								$headers .= "From: Контакты Решебник <no-replay@stud-help.com>\r\n";
								$message .= "Дата відправлення: ".date("Y-m-d (H:i:s)",time())."\r\n</B><BR><BR>";
								$message .= $text_email."<BR><BR>Это письмо составлено роботом, и отвечать на него не надо.";
								$send_ok = mail($mailto,$subject,$message,$headers);
								break;
							}
							///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
							///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
							///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
							array_push($_SESSION[result],'Решающий выбран');
	                    }else{array_push($_SESSION[error],'Недостаточно средств на Вашем балансе');}
					}else{array_push($_SESSION[error],'Вы уже выбрали решающего');}
			//edit zadacha
				}else if($_GET[st]==7){
					if($_POST[price]!=''){
						if($_FILES["filename"]["size"]){
							if($_FILES["filename"]["type"]=='image/jpeg' or $_FILES["filename"]["type"]=='image/bmp' or $_FILES["filename"]["type"]=='image/png' or $_FILES["filename"]["type"]=='image/gif' or $_FILES["filename"]["type"]=='text/plain' or $_FILES["filename"]["type"]=='application/msword' or $_FILES["filename"]["type"]=='application/msword' or $_FILES["filename"]["type"]=='application/pdf' or $_FILES["filename"]["type"]=='application/x-rar-compressed' or $_FILES["filename"]["type"]=='application/zip'){
								if($_FILES["filename"]["size"]/1024<500){
									if(is_file("../".$zadacha[url])){unlink("../".$zadacha[url]);}
									$_FILES['filename']['name']=translit($_FILES['filename']['name']);
									$url="files/f_".$zadacha[id_p]."_".$_FILES['filename']['name'];
									copy($_FILES['filename']['tmp_name'], "../".$url);
								}else{array_push($_SESSION[error],'Файл превышает 500 Кб, слишком большой');}
							}else{array_push($_SESSION[error],'Файла неверного формата');}
						}else{$url=$zadacha[url];}
						$end_time=mktime($_POST[D4],0,0,$_POST[D2],$_POST[D1],$_POST[D3]);
						if($end_time>=$zadacha[end_time]){
							mysql_query("update katalog_zadach set end_time ='$end_time',coment='$_POST[coment]',price='$_POST[price]',url='$url' WHERE id_p='$_GET[id]' limit 1");
							array_push($_SESSION[result],'Изменения сохранены');
						}else{array_push($_SESSION[error],'Новый срок выполнения менше или равен уже установленого');}
					}else{array_push($_SESSION[error],'Вы не ввели цену');}
				}else{array_push($_SESSION[error],'Неверное действие');}
			}else{array_push($_SESSION[error],'У Вас нет прав на изменение заказа');}

		header("Location:../k6.html");
  	}else{//avtorization
    	array_push($_SESSION[error],'Вы не авторизированый пользователь. <a href="k20.html">Войдите</a> в систему');
    	header("Location:../k20.html");
	}
}
?>
