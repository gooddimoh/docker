<?require_once $_SERVER["DOCUMENT_ROOT"] . "/modul/custom_sessions.php"; CustomSessions::start();?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<META NAME="webmoney.attestation.label" CONTENT="webmoney attestation label#ABA9744F-2176-4C5A-A46A-F2BDB96B1D3A">

<linkrel="SHORTCUT ICON" href="favicon.ico">
<link rel="stylesheet" type="text/css" href="jquery/clickmenu.css">
<link rel="stylesheet" type="text/css" href="style.css">

<script type="text/javascript" src="jquery/jquery.min.js"></script>
<script type="text/javascript" src="jquery/jquery.easytooltip.js"></script>
<script type="text/javascript" src="jquery/jquery.clickmenu.js"></script>

<script type="text/javascript" src="jquery/jquery.min.js"></script>

<script type='text/javascript' src='jquery/jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="jquery/jquery.autocomplete.css" />

<script type="text/javascript" src="key.js"></script>
<?
include "mysql.php";
include "modul/sequrity.php";
include "meta.php";
$config=mysql_fetch_array(mysql_query("select * from katalog_config limit 1"));
?>
<meta name="google-site-verification" content="Q-U2v9Fg-Y99lQz_1xd1YU0DS-hER7inBue4QroYAf4" />
<meta name='yandex-verification' content='431ddc9df2ad9ae3' />
</head>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td height="155">
			<table width="100%" height="200" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td style="background:url('images/topfon.gif') repeat-x 0% 0%" height="155">
						<table border="0" width="100%" height=155 cellpadding=0 cellspacing=0>
							<tr>
								<td style="background:url('images/index_01.gif') no-repeat 0% 0%">
								<table border="0" width="100%" height="155" cellpadding=0 cellspacing=0>
									<tr>
										<td width=350 onclick="location.href='<?echo 'http://'.$_SERVER["SERVER_NAME"];?>'" style="cursor:hand;cursor:pointer">&nbsp;<p align="center">&nbsp;</p>
										<p align="center">
										<font color="#FFFFFF" face="Arial" style="font-size: 9pt">
										<span lang="ru">Если есть у Вас задача - мы решим ее!</span></font></td>
										<td align=right valign=bottom><b>
										<table><tr>
											<td align=right>

<form method="POST" accept-charset="utf-8" id="siteheart_button_37348" action="https://siteheart.com/webconsultation/37348?s=1" target="siteheart_button_37348"><input type="hidden" name="_charset_"><input type="hidden" name="data[your_name]" value="your_value"> <img src="http://webindicator.siteheart.com/webindicator/help2?ent=37348&company=37348" border="0" style="cursor:pointer;" alt="SiteHeart" onclick="window.open('about:blank','siteheart_button_37348','width=500,height=400,resizable=1') ;document.getElementById('siteheart_button_37348').submit();"/> </form>
<!-- BEGIN JIVOSITE CODE {literal} -->
<script type="text/javascript">
(function() { var widget_id = '13840';
var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss); })(); </script>
<!-- {/literal} END JIVOSITE CODE -->

<a href="https://passport.webmoney.ru/asp/certview.asp?wmid=264265686165" target=_blank>
<IMG SRC="http://passport.webmoney.ru/images/atstimg/75x75_star/grey_light_rus.gif" title="Здесь находится аттестат нашего WM идентификатора 264265686165" border="0"></a>
											</tr><tr><td>
												<font color="#FFFFFF" size="1" face="Arial">
												<span lang="ru">Текущее время системы (Украина):
												<?date_default_timezone_set('Europe/Kiev');?>
												<?echo date('H:i d.m.y');?><br>
												&nbsp; </span></font></b>
											</td>
										</tr></table>
										</td>
										<td align=right valign=bottom width="10"></td>
									</tr>
								</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table width=100% cellpadding=0 cellspacing=0>
							<tr>
								<td width="428"><img src="images/index_02.gif" width="428" height="45" alt=""></td>
								<td style="background:url('images/topfon_menu.gif') repeat-x 0% 0%" align=right>
								<table border="0" height=100% cellpadding=0 cellspacing=0>
									<tr>
										<?
											if($_SESSION[logintrue]){
											echo '
										<td><a href="k21.html" class="topmenu">Мой профиль</a></td>
										<td><img border="0" src="images/line.gif" width="11" height="45"></td>
										<td>';
										if(@mysql_num_rows($email)!=0){echo '<a href="k18.html?in" class="topmenu"><img src="images/email.png" border=0></a>';}
										echo ' <a href="k18.html?in" class="topmenu">Сообщения</a></td>
										<td><img border="0" src="images/line.gif" width="11" height="45"></td>
										<td><a href="k19.html" class="topmenu">Баланс</a></td>
										<td><img border="0" src="images/line.gif" width="11" height="45"></td>
										<td><a href="k134.html" class="topmenu">Файлы</a></td>
										<td><img border="0" src="images/line.gif" width="11" height="45"></td>
										<td><a href="k2.html" class="topmenu">Пользователи</a></td>
										<td><img border="0" src="images/line.gif" width="11" height="45"></td>
										<td><a href="k6.html" class="topmenu">Задачи</a></td>
										<td><img border="0" src="images/line.gif" width="11" height="45"></td>
										<td><a href="k13.html" class="topmenu">Контакты</a></td>';
										}else{
										echo '
										<td><a href="k16.html" class="topmenu">Регистрация</a></td>
										<td><img border="0" src="images/line.gif" width="11" height="45"></td>
										<td><a href="k2.html" class="topmenu">Пользователи</a></td>
										<td><img border="0" src="images/line.gif" width="11" height="45"></td>
										<td><a href="k6.html" class="topmenu">Задачи</a></td>
										<td><img border="0" src="images/line.gif" width="11" height="45"></td>
										<td><a href="k13.html" class="topmenu">Контакты</a></td>';
										}
										?>
										<td width=30></td>
									</tr>
								</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td style="background:url('images/topfon_menu_a.gif') repeat-x 0% 0%" height="26">
			<table border="0" width="100%" cellpadding=0 cellspacing=0 height=100%>
				<tr>
					<td width="251" align=right>
					<img border="0" src="images/index_04.gif" width="43" height="26"></td>
					<td width=50></td>
					<?
						if($_SESSION[logintrue]){
						$user=mysql_fetch_array(mysql_query("select balance,zadach_zakaz,zadach from katalog_user WHERE id_p='$_SESSION[userid]' limit 1"));
						echo '
							<td><font color="#FFFFFF" face="Arial" style="font-size: 9pt">Вы ввошли как <img src="images/user.png"> ',ucfirst($_SESSION[userlogin]),'
							<a href="modul/close.php" class="info">›› Выход</a></td>
							<td align=right><font color="#FFFFFF" face="Arial" style="font-size: 9pt">';
							if($_SESSION[userresh]==1){echo 'Ваша ставка: <b>',100-$config[procent],'% </b>';}
							echo ' Ваш баланс: <a href="k19.html?form=3" title="Ваш баланс" class="infobold"><img class="pic" src="images/zadachi/cash.png" border=0> <u>',$user[balance],' RUR</u>
							</a> Заказанных задач: <a href="k6.html?my" title="Заказанных задач" class="infobold"><u>',$user[zadach_zakaz],'</u></a>
							</a> Решенных задач: <a href="k6.html?my" title="Решенных задач" class="infobold"><u>',$user[zadach],'</u></a>
							</td><td width=30></td>';
						}else{
							echo '
							<td><font color="#FFFFFF" face="Arial" style="font-size: 9pt">Вы ввошли как Гость <img src="images/user.png"> </font>
							<a href="k20.html" class="info">›› Вход </a> <a href="k16.html" class="info">›› Регистрация</a></td>';
						}
					?>
				</tr>
			</table>
			</td>
	</tr>
	<tr>
		<td style="background:url('images/topfon_menu_b.gif') repeat-x 0% 0%" height="28">
			<table align=left style="background:url('images/left.gif') no-repeat 0% 0%" border="0" cellpadding=0 cellspacing=0 width="470" height="28">
				<tr>
					<td width="50%" align=center><b><font face="Arial" style="font-size: 9pt" color="#FFFFFF">Разделы сайта</font></b></td>
					<td width="50%" align=center><a href="k6.html" title="Текущие задачи" class="infobold">Текущие задачи</a></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<table border="0" cellpadding=0 cellspacing=0 width="100%" height=100% style="background:url('images/content.gif') repeat-x 100% 0%">
				<tr>
					<td valign=top width=198 style="border-right:1px solid #70A0BA;padding:10px">
					<table border="0" width="100%">
						<?include "menu.php";?>
					</table>
						<?include "news.php";?>
<p align=center><!-- begin WebMoney Transfer : accept label -->
<a href="http://www.megastock.ru/" target="_blank"><img src="http://www.megastock.ru/Doc/88x31_accept/grey_light_rus.gif" alt="www.megastock.ru" border="0"></a>
<!-- end WebMoney Transfer : accept label -->
<!-- begin WebMoney Transfer : attestation label -->
<a href="https://passport.webmoney.ru/asp/certview.asp?wmid=264265686165" target="_blank"><img src="grey_light_rus.gif" alt="Здесь находится аттестат нашего WM идентификатора 264265686165" border="0"><br><span style="font-size: 0,7em;">Проверить аттестат</span></a>
<!-- end WebMoney Transfer : attestation label -->
<table width="100%"><tr>
<td>

<!--bigmir)net TOP 100-->
<script type="text/javascript" language="javascript"><!--
function BM_Draw(oBM_STAT){
document.write('<table cellpadding="0" cellspacing="0" border="0" style="display:inline;margin-right:4px;"><tr><td><div style="margin:0px;padding:0px;font-size:1px;width:88px;"><div style="background:url(\'http://i.bigmir.net/cnt/samples/diagonal/b60_top.gif\') no-repeat bottom;"> </div><div style="font:10px Tahoma;background:url(\'http://i.bigmir.net/cnt/samples/diagonal/b60_center.gif\');"><div style="text-align:center;"><a href="http://www.bigmir.net/" target="_blank" style="color:#0000ab;text-decoration:none;font:10px Tahoma;">bigmir<span style="color:#ff0000;">)</span>net</a></div><div style="margin-top:3px;padding: 0px 6px 0px 6px;color:#426ed2;"><div style="float:left;font:10px Tahoma;">'+oBM_STAT.hosts+'</div><div style="float:right;font:10px Tahoma;">'+oBM_STAT.hits+'</div></div><br clear="all"/></div><div style="background:url(\'http://i.bigmir.net/cnt/samples/diagonal/b60_bottom.gif\') no-repeat top;"> </div></div></td></tr></table>');
}
//-->
</script>

<script type="text/javascript" language="javascript"><!--
bmN=navigator,bmD=document,bmD.cookie='b=b',i=0,bs=[],bm={o:1,v:16861666,s:16861666,t:0,c:bmD.cookie?1:0,n:Math.round((Math.random()* 1000000)),w:0};
for(var f=self;f!=f.parent;f=f.parent)bm.w++;
try{if(bmN.plugins&&bmN.mimeTypes.length&&(x=bmN.plugins['Shockwave Flash']))bm.m=parseInt(x.description.replace(/([a-zA-Z]|\s)+/,''));
else for(var f=3;f<20;f++)if(eval('new ActiveXObject("ShockwaveFlash.ShockwaveFlash.'+f+'")'))bm.m=f}catch(e){;}
try{bm.y=bmN.javaEnabled()?1:0}catch(e){;}
try{bmS=screen;bm.v^=bm.d=bmS.colorDepth||bmS.pixelDepth;bm.v^=bm.r=bmS.width}catch(e){;}
r=bmD.referrer.slice(7);if(r&&r.split('/')[0]!=window.location.host){bm.f=escape(r);bm.v^=r.length}
bm.v^=window.location.href.length;for(var x in bm) if(/^[ovstcnwmydrf]$/.test(x)) bs[i++]=x+bm[x];
bmD.write('<sc'+'ript type="text/javascript" language="javascript" src="http://c.bigmir.net/?'+bs.join('&')+'"></sc'+'ript>');
//-->
</script>
<noscript>
<a href="http://www.bigmir.net/" target="_blank"><img src="http://c.bigmir.net/?v16861666&s16861666&t2" width="88" height="31" alt="bigmir)net TOP 100" title="bigmir)net TOP 100" border="0" /></a>
</noscript>
<!--bigmir)net TOP 100-->
<td>
<!-- begin of Top100 code -->

<!--Rating@Mail.ru counter-->
<script language="javascript"><!--
d=document;var a='';a+=';r='+escape(d.referrer);js=10;//--></script>
<script language="javascript1.1"><!--
a+=';j='+navigator.javaEnabled();js=11;//--></script>
<script language="javascript1.2"><!--
s=screen;a+=';s='+s.width+'*'+s.height;
a+=';d='+(s.colorDepth?s.colorDepth:s.pixelDepth);js=12;//--></script>
<script language="javascript1.3"><!--
js=13;//--></script><script language="javascript" type="text/javascript"><!--
d.write('<a href="http://top.mail.ru/jump?from=1964792" target="_top">'+
'<img src="http://da.cf.bd.a1.top.mail.ru/counter?id=1964792;t=56;js='+js+
a+';rand='+Math.random()+'" alt="Рейтинг@Mail.ru" border="0" '+
'height="31" width="88"><\/a>');if(11<js)d.write('<'+'!-- ');//--></script>
<noscript><a target="_top" href="http://top.mail.ru/jump?from=1964792">
<img src="http://da.cf.bd.a1.top.mail.ru/counter?js=na;id=1964792;t=56"
height="31" width="88" border="0" alt="Рейтинг@Mail.ru"></a></noscript>
<script language="javascript" type="text/javascript"><!--
if(11<js)d.write('--'+'>');//--></script>
<!--// Rating@Mail.ru counter-->

<a href="http://top100.rambler.ru/navi/2229018/">
<img src="http://counter.rambler.ru/top100.cnt?2229018" alt="Rambler's Top100" border="0" />
</a>

<!-- end of Top100 code -->

</tr></table>
					</td>
					<td style="padding:20px" valign=top>
					<?include "content.php";?>
					</td>
					<? if($ide=='' or $d=='4') echo '<td width=220 valign=top>
					<table border="0" width="100%" cellpadding=0 cellspacing=0>
						<tr>
							<td height="134" style="background:url(\'images/menu1.gif\') no-repeat 0% 0%;padding:14px" valign=bottom align=center>
							<b><span lang="ru">
							<font size="2" face="Arial" color="#FFFFFF">Заказать</font></span></b></td>
						</tr>
						<tr>
							<td style="padding:10px"><p><font face="Arial" style="font-size: 8pt">Сделать заказ в нашей системе очень
просто. Стоит только лишь <a href="k16.html">зарегистрироваться</a> (если Вы это
еще не сделали). Затем перейти в раздел &quot;<a href="k7.html">Оформить заказ</a>&quot;.</font></p>
							</td>
						</tr>
						<tr>
							<td height=40 style="background:url(\'images/menu2.gif\') no-repeat 0% 0%;padding:10px">
							<p align="center"><span lang="ru"><b>
							<font face="Arial" size="2" color="#FFFFFF">Оплатить</font></b></span></td>
						</tr>
						<tr>
							<td style="padding:10px"><p><font face="Arial"><span style="font-size: 8pt">Для оплаты услуг решения
нужно <a href="k10.html">пополнить баланс</a> в системе. Это можно сделать при
помощи системы <a href="http://webmoney.ru" target=_blank>Webmoney</a>. Или другим
<a href="k10.html">доступным способом.</a></span></font></p></td>
						</tr>
						<tr>
							<td height=40 style="background:url(\'images/menu3.gif\') no-repeat 0% 0%;padding:10px">
							<p align="center"><span lang="ru"><b>
							<font face="Arial" size="2" color="#FFFFFF">Получить</font></b></span></td>
						</tr>
						<tr>
							<td style="padding:10px"><font face="Arial" style="font-size: 8pt">Чтобы незамедлительно получить решение Вашей задачи просто оплатите его стоимость, используя виртуальный баланс в системе.</font></td>
						</tr>
					</table>
					</td>';?>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td height=74>
			<table border="0" cellpadding=0 cellspacing=0 width="100%" style="background:url('images/bottom_right.gif') repeat-x 100% 0%">
				<tr>
					<td style="background:url('images/bottom.gif') repeat-x 0% 0%;padding:10px">
					<?$time=time();?>

					<?$user=mysql_query("select id_p from katalog_user")?>
					<?$user2=mysql_query("select id_p from katalog_user where resh='1'")?>

					<?$zadach=mysql_query("select id_p from katalog_zadach")?>
					<?$zadach2=mysql_query("select id_p from katalog_zadach where status>3")?>

					<font face="Arial" style="font-size: 8pt">Количество пользователей, зарегистрированных в системе: <b><i><?echo @mysql_num_rows($user);?></i></b>,
					из них решающие: <i><b><?echo @mysql_num_rows($user2);?></b></i><br>
					Количество задач, решение которых заказано в системе: <i><b><?echo @mysql_num_rows($zadach);?></b></i>,
					из них решенных: <i><b><?echo @mysql_num_rows($zadach2);?></b></i><br>

					<?
					//--------- statistika posescheniy

					$yes=time()-1440;  //------ -24 min
					$ip=$_SERVER["REMOTE_ADDR"];

					if($_SESSION[statistik]!=1){

						mysql_query("delete from katalog_stat where data<='$yes' ");
                        $_SESSION[statistik]=1;

						mysql_query("insert into katalog_stat(data,id_user,ip) values('$time','0','$ip')");
						$_SESSION[statistik_id]=mysql_insert_id();

					}else{
						mysql_query("update katalog_stat set data='$time' where id='$_SESSION[statistik_id]' limit 1");
					}
                    //--------- statistika posescheniy
					?>

					Гости сейчас на сайте:
					<?
					$r=mysql_query("select id from katalog_stat where id_user='0' and data>'$yes' ");
					if(@mysql_num_rows($r)>0){
						echo '(',@mysql_num_rows($r),')';
					}else{echo '(0)';}
					?>,

					Решающие онлайн:
					<?$r=mysql_query("select katalog_stat.id,id_user,katalog_user.login from katalog_stat,katalog_user where katalog_stat.id_user=katalog_user.id_p and katalog_stat.id_user<>'0'  and katalog_stat.data>'$yes' and katalog_stat.status='1' GROUP BY katalog_stat.id_user");
					if(@mysql_num_rows($r)>0){
						echo '(',@mysql_num_rows($r),') ';
						for($i=0;$i<@mysql_num_rows($r);$i++){
							$f=mysql_fetch_array($r);
							echo '<a href="k77.html?id_user=',$f[id_user],'" class=blue>',$f[login],'</a>, ';
						}
					}else{echo '(0) ';}
					unset($r,$f,$i);?>

					Заказчики онлайн:
					<?$r=mysql_query("select katalog_stat.id,id_user,katalog_user.login from katalog_stat,katalog_user where katalog_stat.id_user=katalog_user.id_p and katalog_stat.id_user<>'0'  and katalog_stat.data>'$yes' and katalog_stat.status='0'  GROUP BY katalog_stat.id_user");
					if(@mysql_num_rows($r)>0){
						echo '(',@mysql_num_rows($r),') ';
						for($i=0;$i<@mysql_num_rows($r);$i++){
							$f=mysql_fetch_array($r);
							echo '<a href="k77.html?id_user=',$f[id_user],'" class=blue>',$f[login],'</a>, ';
						}
					}else{echo '(0) ';}
					unset($r,$f,$i);?>

					</font></td>
					<td></td>
					<td style="background:url('images/bottom_one.gif') no-repeat 0% 0%;padding:10px" width=420  width="1000" height="74">
					<table border="0" width="100%" id="table2">
						<tr>
							<td width="54">&nbsp;</td>
							<td>
							<font style="font-size: 8pt" face="Arial" color="#FFFFFF">
							<a href="k2.html?r" class="buttonmenu">Решающие</a> | <a href="k2.html?p" class="buttonmenu">Только пользователи</a> | <a href="k2.html" class="buttonmenu">Все</a> <br>
							<a href="k6.html?s" class="buttonmenu">Свободные задачи</a> | <a href="k6.html?r" class="buttonmenu">Решаемые задачи</a> | <a href="k6.html?rr" class="buttonmenu">Решенные задачи</a></font></td>
						</tr>
					</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td height="25">
<table width=100%>
<tr>
<td align=left><!-- I.UA counter --><a href="http://www.i.ua/" target="_blank" onclick="this.href='http://i.ua/r.php?114082';" title="Rated by I.UA">
<script type="text/javascript" language="javascript"><!--
iS='<img src="http://r.i.ua/s?u114082&p4&n'+Math.random();
iD=document;if(!iD.cookie)iD.cookie="b=b; path=/";if(iD.cookie)iS+='&c1';
try{iHP=document.body.firstChild;
iHP.style.behavior="url('#default#homePage')";
iHP.addBehavior('#default#homePage');
if (iHP.isHomePage(window.location.href))iS+='&o1';
} catch (e) { }
iS+='&d'+(screen.colorDepth?screen.colorDepth:screen.pixelDepth)
+"&w"+screen.width+'&h'+screen.height;
iT=iD.referrer.slice(7);iH=window.location.href.slice(7);
((iI=iT.indexOf('/'))!=-1)?(iT=iT.substring(0,iI)):(iI=iT.length);
if(iT!=iH.substring(0,iI))iS+='&f'+escape(iD.referrer.slice(7));
iS+='&r'+escape(iH);
iD.write(iS+'" border="0" width="88" height="31" />');
//--></script></a><!-- End of I.UA counter -->

<script type="text/javascript" src="http://jspy.ru/load/855/jspy.js"></script>
<SCRIPT LANGUAGE="JavaScript" SRC="http://www.top150.ru/top.php?id=1525&js=1"></SCRIPT>
<NOSCRIPT><a href="http://www.top150.ru/" style="cursor:hand;"><img src="http://www.top150.ru/top.php?id=1525&js=0" border="0"/></a></NOSCRIPT>
<td align=right  valign=middle>
<!-- hit.ua invisible part -->
<a href='http://hit.ua/?x=40047' target='_blank'>
<script language="javascript" type="text/javascript"><!--
Cd=document;Cr="&"+Math.random();Cp="&s=1";
Cd.cookie="b=b";if(Cd.cookie)Cp+="&c=1";
Cp+="&t="+(new Date()).getTimezoneOffset();
if(self!=top)Cp+="&f=1";
//--></script>
<script language="javascript1.1" type="text/javascript"><!--
if(navigator.javaEnabled())Cp+="&j=1";
//--></script>
<script language="javascript1.2" type="text/javascript"><!--
if(typeof(screen)!='undefined')Cp+="&w="+screen.width+"&h="+
screen.height+"&d="+(screen.colorDepth?screen.colorDepth:screen.pixelDepth);
//--></script>
<script language="javascript" type="text/javascript"><!--
Cd.write("<sc"+"ript src='http://c.hit.ua/hit?i=40047&g=0&x=3"+Cp+Cr+
"&r="+escape(Cd.referrer)+"&u="+escape(window.location.href)+"'></sc"+"ript>");
//--></script>
<noscript>
<img src='http://c.hit.ua/hit?i=40047&amp;g=0&amp;x=2' border='0'/>
</noscript></a>
<!-- / hit.ua invisible part -->

<!-- hit.ua visible part -->
<script language="javascript" type="text/javascript"><!--
if (typeof(hitua) == 'object') document.write("<table cellpadding='0' cellspacing='0' border='0' style='display: inline'><tr><td><div style='width: 86px; height: 13px; padding: 0px; margin: 0px; border: solid #223A47 1px; background-color: #223A47'><a href='http://hit.ua/?x=" + hitua.site_id + "' target='_blank' style='float: left; padding: 1px; font: bold 9px tahoma; text-decoration: none; color: #fff' title='hit.ua - сервис интернет статистики'>HIT.UA</a><div style='padding: 1px; float: right; text-align: right; font: 9px tahoma; color: #fff' title='hit.ua: посетителей за сегодня'>" + hitua.uid_count + "</div></div></td></tr></table>");
//--></script>
<!-- / hit.ua visible part -->

<td align=right width=200 valign=middle>
<!--bigmir)net TOP 100-->
<script type="text/javascript" language="javascript"><!--
function BM_Draw(oBM_STAT){
document.write('<table cellpadding="0" cellspacing="0" border="0" style="display:inline;margin-right:4px;"><tr><td><div style="font-family:Tahoma;font-size:10px;padding:0px;margin:0px;"><div style="width:7px;float:left;background:url(\'http://i.bigmir.net/cnt/samples/default/b53_left.gif\');height:17px;padding-top:2px;background-repeat:no-repeat;"></div><div style="float:left;background:url(\'http://i.bigmir.net/cnt/samples/default/b53_center.gif\');text-align:left;height:17px;padding-top:2px;background-repeat:repeat-x;"><a href="http://www.bigmir.net/" target="_blank" style="color:#0000ab;text-decoration:none;">bigmir<span style="color:#ff0000;">)</span>net</a>  <span style="color:#969696;">хиты</span> <span style="color:#003596;font:10px Tahoma;">'+oBM_STAT.hits+'</span> <span style="color:#969696;">хосты</span> <span style="color:#003596;font:10px Tahoma;">'+oBM_STAT.hosts+'</span></div><div style="width:7px;float: left;background:url(\'http://i.bigmir.net/cnt/samples/default/b53_right.gif\');height:17px;padding-top:2px;background-repeat:no-repeat;"></div></div></td></tr></table>');
}
//-->
</script>
<script type="text/javascript" language="javascript"><!--
bmN=navigator,bmD=document,bmD.cookie='b=b',i=0,bs=[],bm={o:1,v:16857022,s:16857022,t:0,c:bmD.cookie?1:0,n:Math.round((Math.random()* 1000000)),w:0};
for(var f=self;f!=f.parent;f=f.parent)bm.w++;
try{if(bmN.plugins&&bmN.mimeTypes.length&&(x=bmN.plugins['Shockwave Flash']))bm.m=parseInt(x.description.replace(/([a-zA-Z]|\s)+/,''));
else for(var f=3;f<20;f++)if(eval('new ActiveXObject("ShockwaveFlash.ShockwaveFlash.'+f+'")'))bm.m=f}catch(e){;}
try{bm.y=bmN.javaEnabled()?1:0}catch(e){;}
try{bmS=screen;bm.v^=bm.d=bmS.colorDepth||bmS.pixelDepth;bm.v^=bm.r=bmS.width}catch(e){;}
r=bmD.referrer.slice(7);if(r&&r.split('/')[0]!=window.location.host){bm.f=escape(r);bm.v^=r.length}
bm.v^=window.location.href.length;for(var x in bm) if(/^[ovstcnwmydrf]$/.test(x)) bs[i++]=x+bm[x];
bmD.write('<sc'+'ript type="text/javascript" language="javascript" src="http://c.bigmir.net/?'+bs.join('&')+'"></sc'+'ript>');
//-->
</script>
<noscript>
<a href="http://www.bigmir.net/" target="_blank"><img src="http://c.bigmir.net/?v16857022&s16857022&t2" width="88" height="31" alt="bigmir)net TOP 100" title="bigmir)net TOP 100" border="0" /></a>
</noscript>
<!--bigmir)net TOP 100-->
</tr></table>
		</td>
	</tr>
</table>
<script type="text/javascript">
jQuery.noConflict();
jQuery(".info").click(function() {
	if (jQuery("#D"+$(this).attr("id")).is(":hidden")) {
		jQuery("#D"+$(this).attr("id")).slideDown();
	} else {
		jQuery("#D"+$(this).attr("id")).slideUp();
	}
});
</script>
<script type="text/javascript">
jQuery.noConflict();
$(document).ready(function(){
	$("abbr").easyTooltip();

});
</script>
<script type="text/javascript">
jQuery.noConflict();
$(document).ready(function(){
	$("a").easyTooltip();

});
</script>
<script type="text/javascript">
<?if($d==6){for($i=1;$i<=30;$i++){
	echo '$(\'.menu',$i,'\').clickMenu({onClick:function(){$(\'.menu',$i,'\').trigger(\'closemenu\');return false;}});';
}}?>
</script>

</body>
</html>