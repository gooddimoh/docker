<?
include "mysql.php";

if(0):

if(!isset($_POST[B1]) and !isset($_GET[result]) and !isset($_POST[status])){
	if($_SESSION[logintrue]){
        $data=time();
		$f=mysql_fetch_array(mysql_query("select * from katalog_finanse where status='0' and outu='$_SESSION[userid]' limit 1"));

		if($f[id]==''){
		    include "modul/keyganarator.php";
			$rnd=createRandomKey(10);
			mysql_query("insert into katalog_finanse(status,outu,type,rnd,add_data) values('0','$_SESSION[userid]','4','$rnd','$data')");
		}else{
			mysql_query("update katalog_finanse set add_data='$data' where id='$f[id]' ");
		}

		$chet=mysql_fetch_array(mysql_query("select * from katalog_finanse where status='0' and outu='$_SESSION[userid]' limit 1"));

		$f=mysql_fetch_array(mysql_query("select balance,url,mesmes,meszad,polz,zad,icq,tel,gorod,univer,dat_birth,coment from katalog_user where id_p='$_SESSION[userid]' limit 1"));
		echo '
		<script lang="javascript">
			function show(temp){
				for(i=1;i<=3;i++){
					document.getElementById(\'form\'+i).style.display="none";
				}
				document.getElementById(temp).style.display="block";
                
                $("[form-infobold]").each(function(){

                    if($(this).attr("onclick").toString().indexOf(temp) > 0)
                        $(this).parent().addClass("form-infobold-selected");
                    else
                        $(this).parent().removeClass("form-infobold-selected");
                    
                });
			}
		</script>
		<script lang="javascript">
			function showm(tempm){
				for(j=1;j<=4;j++){
					document.getElementById(\'meth\'+j).style.display="none";
				}
				document.getElementById(tempm).style.display="block";
			}
		</script>
		<script lang="javascript">
			function showv(tempv){
				for(j=1;j<=2;j++){
					document.getElementById(\'methv\'+j).style.display="none";
				}
				document.getElementById(tempv).style.display="block";
			}
		</script>
			<table class="tabs" border="0" cellpadding="5" bgcolor="ffffff">
				<tr bgcolor="365C71">
					<td>
						<table border=0 cellpadding="0" cellspacing="0">
							<tr><td><img alt=""  src="images/zadachi/cash.png" border=0 hspace=2></td>
								<td'.($_REQUEST['form'] < 2 ? ' class="form-infobold-selected"' : '').'><a onclick="show(\'form1\')" form-infobold href="javascript:void(0)" class=infobold>Пополнение баланса</a></td>
							</tr>
						</table>
					</td>
					<td'.($_REQUEST['form'] == 2 ? ' class="form-infobold-selected"' : '').'><a onclick="show(\'form2\')" form-infobold href="javascript:void(0)" class=infobold>Вывод средств</a></td>
					<td'.($_REQUEST['form'] == 3 ? ' class="form-infobold-selected"' : '').'><a onclick="show(\'form3\')" form-infobold href="javascript:void(0)" class=infobold>История</a></td>
				</tr>
			</table><table width="100%" cellpadding="10"><tr><td style="border:1px solid #70A0BA">
			<table border="0" cellpadding=5 style="border:1px solid #365C71">
				<tr>
					<td><font size="2" face="Arial" color="#365C71">Текущий счет</font></td>
					<td><font size="2" face="Arial">Пользователь: <b>',$_SESSION[userlogin],'</b></font></td>
					<td><font size="2" face="Arial">Баланс: <b>',$f[balance],' RUR</b></font></td>
				</tr>
			</table>';
echo '
<!------------------------------------------------------------ OPLATA-->
				<div method=post id="form1" ';if(!isset($_GET[form]) or $_GET[form]==1){echo 'style="display:block"';}else{echo 'style="display:none"';} echo '>
				<table border="0" cellpadding=5>
					<tr>
						<td><img alt=""  border="0" src="images/balans/webmoney.png"></td>
						<td>&nbsp;<a onclick="showm(\'meth1\')" href="#" id=menu>Кошелек WebMoney</a></td>

						<td><img alt=""  border="0" src="images/balans/webmoney.png"></td>
						<td>&nbsp;<a onclick="showm(\'meth4\')" href="#" id=menu>Терминал WebMoney</a></td>

						<td><img alt=""  border="0" src="images/balans/interkassa.jpg"></td>
						<td>&nbsp;<a onclick="showm(\'meth2\')" href="#" id=menu>Interkassa.Com</a></td>

						<td><img alt=""  border="0" src="images/balans/visa.png"><img alt=""  border="0" src="images/balans/mastercard.png"></td>
						<td>&nbsp;<a onclick="showm(\'meth3\')" href="#" id=menu>Пополнить картой</a></td>
					</tr>
				</table>
				<hr style="color: #70A0BA;background-color:#70A0BA;border:0px none;height:1px;clear:both;" size=0 align="justify">
<!------------------------------------------------------------ TERMINAL WEBMONEY-->
				<div id="meth4" ';if($_GET[method]==4){echo 'style="display:block"';}else{echo 'style="display:none"';} echo '>
				<form action="https://merchant.webmoney.ru/lmi/payment.asp" method="POST" id=pay name=pay>
				<b><font color="#333333" size="4" face="Arial">Терминал WebMoney</font></b><p>
					<input type="hidden" name="LMI_PAYMENT_DESC" value="Пополнение счета в системе Stud-help.com"><!-- призначення платежу-->
					<input type="hidden" name="LMI_PAYMENT_NO" value="',$chet[id],'">						       <!-- номер рахунку-->
					<input type="hidden" name="LMI_PAYEE_PURSE" value="U254337407718">					   <!-- на яйкий перерахунок гроші-->
					<input type="hidden" name="LMI_SIM_MODE" value="0">											   <!-- 1 - тестовий режим 0 - реальний режим-->
					<input type="hidden" name="LMI_ALLOW_SDP" value="8"> 											<!-- режим термынал -->

                    <input type="hidden" name="RND" value="',$chet[rnd],'">
					<input type="hidden" name="ID_USER" value="',$_SESSION[userid],'">								<!-- поле користувача, користувач-->

				<table border="0" width="100%">
					<tr>
						<td><font size="2" face="Arial" color="#333333">Если сумма для оплаты - число
				нецелое, то отделять дробную часть следует точкой, незначищие нули в конце
				писать не надо. Данный способ доступен только для Украины и может быть включен только для U-кошельков.
				<a href="http://www.webmoney.ru/" target=_blank>WebMoney</a>.<br>
				<br>
				Более подробно о способах оплаты можно узнать <a href="k10.html">здесь</a>.</font></td>
					</tr>
					<tr>
						<td height="24">
						<table border="0">
							<tr>
								<td><b><font size="2" face="Arial" color=#192C36>Введите сумму для оплаты:</font></b></td>
								<td><input type="text" name="LMI_PAYMENT_AMOUNT" size="10" class="cost" onblur="this.value=parseFloat(this.value).toFixed(2);"  value="1.00"></td>
								<td><input type="submit" value="Платить с терминала" name="B1"></td>
								<td></td>
							</tr>
						</table>
						</td>
					</tr>
				</table>
				</form></div>
<!------------------------------------------------------------ KOSHELEK WEBMONEY-->
				<div id="meth1" ';if(!isset($_GET[method]) or $_GET[method]==1){echo 'style="display:block"';}else{echo 'style="display:none"';} echo '>
				<form action="https://merchant.webmoney.ru/lmi/payment.asp" method="POST" id=pay name=pay>
				<b><font color="#333333" size="4" face="Arial">Кошелек WebMoney</font></b><p>
					<input type="hidden" name="LMI_PAYMENT_DESC" value="Пополнение счета в системе stud-help.com"><!-- призначення платежу-->
					<input type="hidden" name="LMI_PAYMENT_NO" value="',$chet[id],'">						       <!-- номер рахунку-->
					<input type="hidden" name="LMI_PAYEE_PURSE" value="',$config[webmoney],'">					   <!-- на яйкий перерахунок гроші-->
					<input type="hidden" name="LMI_SIM_MODE" value="0">											   <!-- 1 - тестовий режим 0 - реальний режим-->

                    <input type="hidden" name="RND" value="',$chet[rnd],'">
					<input type="hidden" name="ID_USER" value="',$_SESSION[userid],'">								<!-- поле користувача, користувач-->

				<table border="0" width="100%">
					<tr>
						<td><font size="2" face="Arial" color="#333333">Если сумма для оплаты - число
				нецелое, то отделять дробную часть следует точкой, незначищие нули в конце
				писать не надо. Платежи выполняются через Merchant WebMoney Transfer. На
				сегодняшний день доступно пополнение только с кошелька WMR. Если у Вас есть
				кошельки других типов, обменяйте деньги на рубли в системе <a href="http://www.webmoney.ru/" target=_blank>WebMoney</a>.<br>
				<br>
				Более подробно о способах оплаты можно узнать <a href="k10.html">здесь</a>.</font></td>
					</tr>
					<tr>
						<td height="24">
						<table border="0">
							<tr>
								<td><b><font size="2" face="Arial" color=#192C36>Введите сумму для оплаты:</font></b></td>
								<td><input type="text" name="LMI_PAYMENT_AMOUNT" size="10" class="cost" onblur="this.value=parseFloat(this.value).toFixed(2);"  value="1.00"></td>
								<td><input type="submit" value="Платить с кошелька" name="B1"></td>
							</tr>
						</table>
						</td>
					</tr>
				</table>
				</form></div>
<!------------------------------------------------------------ INTERKASSA-->
				<div id="meth2" ';if($_GET[method]==2){echo 'style="display:block"';}else{echo 'style="display:none"';} echo '>
				<form name="payment" action="https://sci.interkassa.com/" method="post" accept-charset="cp1251">
				<b><font color="#333333" size="4" face="Arial">Interkassa.Com</font></b><p>
					<input type="hidden" name="ik_co_id" value="',$config[ik_shop],'">
					<input type="hidden" name="ik_pm_no" value="',$chet[id],'">
                    <input type="hidden" name="ik_enc" value="cp1251">
                    <input type="hidden" name="ik_cur" value="RUB">
					<input type="hidden" name="ik_desc" value="Пополнение счета в системе stud-help.com">

					<font size="2" face="Arial" color=#333333>Если сумма для оплаты - число нецелое, то
					отделять дробную часть следует точкой, незначищие нули в конце писать не надо.
					Платежи выполняются через систему INTERKASSA.COM. <br>
					<br>
					C помощью системы INTERKASSA.COM вы сможете пополнить баланс в системе
					автоматически Яндекс.Деньгами, кредитными картами VISA/Mastercard, Webmoney
					(WMZ, WMU, WME), через Единый кошелек, MoneyMail, RBK Money, Сбербанк,
					Украинский банк, а также посредством некоторых других платежных систем и
					автоматов экспресс-оплаты. Все способы пополнения вы увидете при переходе на
					страницу оплаты, нажав кнопку &quot;Пополнить&quot;.<br>
					<br>
					Более подробно о способах оплаты можно узнать
					<a href="http://stud-help.com/k10.html" target=_blank>здесь</a>.</font></p>
					<table border="0" width="100%">
						<tr>
							<td height="24">
							<table border="0">
								<tr>
									<td><b><font size="2" face="Arial" color=#192C36>Введите сумму для оплаты:</font></b></td>
									<td><input type="text" name="ik_am" size="10" class="cost" onblur="this.value=parseFloat(this.value).toFixed(2);" value="1.00"></td>
									<td><input type="submit" value="Продолжить" name="process"></td>
								</tr>
							</table>
							</td>
						</tr>
					</table>
				</form></div>
<!------------------------------------------------------------ LIQPAY-->
				<div id="meth3" ';
                
                if($_GET[method]==3){echo 'style="display:block"';}else{echo 'style="display:none"';} echo '>
				<form action="liqpay.php" method="POST" accept-charset="utf-8">
				<b><font color="#333333" size="4" face="Arial">LiqPay.com</font></b><p>
                    <input type="hidden" name="id"  value="',$chet[id],'" />

				<table border="0" width="100%">
					<tr>
						<td><font size="2" face="Arial" color="#333333">Для пополнения баланса посредством карты оплаты введите номер карты и пароль. Получить данные карты можно, заполнив заявку на ввод средств здесь. Для получения подробной информации обратитесь к администрации системы.</font></p>
						<p><font size="2" face="Arial" color="#333333">Более подробно о способах оплаты можно узнать
						<a href="k10.html">здесь.</a></font></td>
					</tr>
					<tr>
						<td height="24">
						<table border="0">
							<tr>
								<td><b><font size="2" face="Arial" color=#192C36>Введите сумму для оплаты:</font></b></td>
								<td><input type="text" name="price" size="10" class="cost" onblur="this.value=parseFloat(this.value).toFixed(2);"></td>
								<td><input type="submit" value="Продолжить" name="B1"></td>
							</tr>
						</table>
						</td>
					</tr>
				</table></form></div>
			</div>';
			echo '
<!------------------------------------------------------------ VIVOD SREDSTV--->
			<div method=post id="form2" ';if($_GET[form]==2){echo 'style="display:block"';}else{echo 'style="display:none"';} echo '>
			<input type="hidden" name="profil" value="2">
			<table border="0" cellpadding=5>
				<tr>
					<td>
					<img alt=""  border="0" src="images/zadachi/cash.png"></td>
					<td>
					&nbsp;<a onclick="showv(\'methv1\')" href="#" id=menu>Оформить заявку</a></td>
					<td>
					<img alt=""  border="0" src="images/report_user.png"></td>
					<td>
					&nbsp;<a onclick="showv(\'methv2\')" href="#" id=menu>Перевод средств другому пользователю</a></td>
				</tr>
			</table>
			<hr style="color: #70A0BA;background-color:#70A0BA;border:0px none;height:1px;clear:both;" size=0 align="justify">
<!------------------------------------------------------------ ZAYAVKA NA VIVOD-->
				<div id="methv1" ';if(!isset($_GET[method]) or $_GET[method]==1){echo 'style="display:block"';}else{echo 'style="display:none"';} echo '>
				<form action="modul/balans.php?st=4" method=post>
				<b><font color="#333333" size="4" face="Arial">Оформить заявку на вывод</font></b><p>
				<table border="0" width="100%">
					<tr>
						<td><font size="2" face="Arial" color="#333333">Для оформления заявки на вывод средств из системы заполните, пожалуйста, следующую форму.

				Имейте в виду, что деньги выводятся 3 раза в месяц (1, 11 и 21 числа) и только за те задачи, решение которые было получено заказчиками более недели назад.</a></font></td>
					</tr>
					<tr>
						<td height="24">
						<table border="0">
							<tr>
								<td><b><font size="2" face="Arial" color=#192C36>Сумма:</font></b></td>
								<td><input type="text" name="suma" size="20" class="cost" style="width:200px"><b><font size="2" face="Arial" color=#192C36> RUR</font></b></td>
							</tr>
							<tr>
								<td><b><font size="2" face="Arial" color="#192C36">Тип платежа:</font></b></td>
								<td>
                                
                                <script>
                                $(document).ready(function(){
                                    $("select[name=\'type\'").change();
                                });
                                </script>
                                
                                <select name="type" onchange="this.form.rekv.value = ($(this).find(\'option:selected\').attr(\'data-rekv\'));" style="width:200px">
									';
                                    
                              $q = mysql_query("SELECT `vt`.*, `vu`.`rekv`
                                                FROM `vivod_types` `vt`
                                                LEFT JOIN `vivod_user_rekv` `vu` ON(`vu`.`user_id` = '$_SESSION[userid]' AND `vu`.`vivod_type` = `vt`.`id`)
                                                WHERE `vt`.`status` = 1 ORDER BY `vt`.`ordered`");
                                                
                              while($res = mysql_fetch_object($q))
                                echo '<option value="'.$res->id.'" data-rekv="'.htmlentities($res->rekv, ENT_COMPAT | ENT_HTML401, 'windows-1251').'">'.$res->name.'</option>';
                                
                              echo '
								</select></td>
							</tr>
							<tr>
								<td><b><font size="2" face="Arial" color="#192C36">Реквизиты:</font></b></td>
								<td><input type="text" name="rekv" size="20" style="width:300px"></td>
							</tr>
							<tr>
								<td><b><font size="2" face="Arial" color="#192C36">Комментарий:</font></b></td>
								<td><textarea rows="2" name="comerc" cols="20" style="width:300px"></textarea></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td><input type="submit" value="Оформить" name="B1"></td>
							</tr>
						</table>
						</td>
					</tr>
				</table></form></div>
<!------------------------------------------------------------ PEREVOD DRUGOMU POLZOVATELU-->
			<div id="methv2" ';if($_GET[method]==2){echo 'style="display:block"';}else{echo 'style="display:none"';} echo '>
				<form action="modul/balans.php?st=5" method=post>
				<b><font color="#333333" size="4" face="Arial">Перевод средств другому пользователю</font></b><p>
				<table border="0" width="100%">
					<tr>
						<td><font size="2" face="Arial" color="#333333">Для перевода средств укажите ID пользователя и переводимую сумму. Учтите что за перевод пользователя решающему взимается комиссия, согласно текущему проценту решающего. Переводы пользователь -> пользователь, решающий -> пользователь, решающий -> решающий выполняются без комиссии.</a></font></td>
					</tr>
					<tr>
						<td height="24">
						<table border="0">
							<tr>
								<td><b><font size="2" face="Arial" color=#192C36>Сумма:</font></b></td>
								<td><input type="text" name="suma" size="20" class="cost" style="width:200px"></td>
							</tr>
							<tr>
								<td><b><font size="2" face="Arial" color="#192C36">ID пользователя:</font></b></td>
								<td><input type="text" name="id" size="20" value="'.$_GET[usr_id].'" style="width:200px" class="number"></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td><input type="submit" value="Перевести" name="B1"></td>
							</tr>
						</table>
						</td>
					</tr>
				</table></form></div>
			</div>';
   if (isset($_GET[usr_id])) echo <<<_SCRIPT
   <script>
 $(document).ready(function() {
   show('form2');
   showv('methv2');
 });
   </script>
_SCRIPT;
echo '
<!------------------------------------------------------------ ISTTORIA-->
		<div method=post id="form3" ';if($_GET[form]==3){echo 'style="display:block"';}else{echo 'style="display:none"';} echo '>
            
            <link rel="stylesheet" type="text/css" href="/jquery/plugins/tablesorter/themes/blue/style.css">
            <script type="text/javascript" src="/jquery/plugins/tablesorter/jquery.tablesorter.js"></script>
            
            
            <script>
                $(document).ready(function(){
                    
                    balanceTablesorterInit();
                    
                });
            </script>
            
            <p>
            <select onchange="balanceTablesorterFilterType(this.value);" style="float: right; margin-top: -35px;">
                <option value="">все</option>
                <option value="оплата заказа">оплата заказа</option>
                <option value="пополнение">пополнение</option>
                <option value="перечисление">перечисление</option>
            </select>
            <table width="100%" border="0" class="tablesorter" id="table-sort-1" cellspacing="1" cellpadding="0" bgcolor="#cccccc">
				<thead>
                <tr>
					<th bgcolor="#365C71" height="25" align=center><font size="2" face="Arial" color="#FFFFFF">ID</font></th>
					<th bgcolor="#365C71" align=center><font size="2" face="Arial" color="#FFFFFF">Дата платежа</font></th>
					<th bgcolor="#365C71" align=center><font size="2" face="Arial" color="#FFFFFF">Сумма</font></th>
					<th bgcolor="#365C71" align=center><font size="2" face="Arial" color="#FFFFFF">Статус платежа</font></th>
					<th bgcolor="#365C71" align=center><font size="2" face="Arial" color="#FFFFFF">Платеж</font></th>
					<th bgcolor="#365C71" align=center><font size="2" face="Arial" color="#FFFFFF">Тип платежа</font></th>
				</tr>
                </thead>
                <tbody>';
			$fin=mysql_query("select * from katalog_finanse where (outu='$_SESSION[userid]' or type='5') and status<>'0'");
			for($i=1;$i<=@mysql_num_rows($fin);$i++){
				$finf=mysql_fetch_array($fin);
            echo '<tr bgcolor="#ffffff">
					<td align=center><font color="#333333" face="Arial" style="font-size: 11px">',$finf[id],'</font></td>
					<td align=center><font color="#333333" face="Arial" style="font-size: 11px">';
					if($finf[add_data]=='' or $finf[add_data]==0){echo 'оплата не осуществлена';}else{echo date('d.m.Y H:i',$finf[add_data]);}
					echo '</font></td>
					<td align=center><font color="#333333" face="Arial" style="font-size: 11px">',$finf[price],'</font></td>
					<td align=center><font color="#333333" face="Arial" style="font-size: 11px">';
					if($finf[status]==1){echo 'выполнен';}
					else if($finf[status]==2){echo 'в обработке';}
					else if($finf[status]==4){echo 'не выполнен';}
					echo '</font></td>
					<td  align=center><font color="#333333" face="Arial" style="font-size: 11px">';
					if($finf[inu]==-1){echo 'webmoney';}
					else if($finf[inu]==-2){echo 'interkassa';}
					else if($finf[inu]==-3){echo 'liqpay';}
					else if($finf[inu]==0){echo 'админ';}
					else{
						$us=mysql_fetch_array(mysql_query("select login from katalog_user where id_p='$finf[inu]'"));
						echo $us[login];
					}
					echo '</font></td>
					<td  align=center><font color="#333333" face="Arial" style="font-size: 11px" data-table-filter-type>';
					if($finf[type]==1){echo '%';}
					else if($finf[type]==2){echo 'оплата заказа';}
					else if($finf[type]==3){echo 'перечисление';}
					else if($finf[type]==4){echo 'пополнение';}
					else if($finf[type]==5){echo 'вывод';}
					echo '</font></td>
				</tr>';}
			echo '</tbody></table>
			</div>
			</td></tr></table>';
	}else{
	$_SESSION[error]=array();
	array_push($_SESSION[error],'Ваш аккаунт заблокирован');
	echo '<script lang="javascaript">location.href="./"</script>';
	}
}else{
	require_once $_SERVER["DOCUMENT_ROOT"] . "/modul/custom_sessions.php"; CustomSessions::start();
	$_SESSION[error]=array();
	$_SESSION[result]=array();
    $data=time();
	include "sequrity.php";

	if($_SESSION[logintrue]){
// ------------------------------------------------------------ PISLYA OPLATI
		$user=mysql_fetch_array(mysql_query("select resh,balance from katalog_user WHERE id_p='$_SESSION[userid]' limit 1"));

		if($_GET[st]==1){                       //-----------webmoney
        	if($_GET[result]=='success'){
                array_push($_SESSION[result],'Webmoney. Платеж выполнен, средства скоро поступят на Ваш счет');
        	}else if($_GET[result]=='fail'){
            	array_push($_SESSION[error],'Webmoney. Произошла ошибка, платеж не выполнен, возможно средства поступят позже');
        	}
        	header("Location:../k19.html?form=3");exit();
		}else if($_GET[st]==2){                 //----- interkassa
        	if($_GET[result]=='success'){
                array_push($_SESSION[result],'Interkassa. Платеж выполнен, средства скоро поступят на Ваш счет');
        	}else if($_GET[result]=='fail'){
            	array_push($_SESSION[error],'Interkassa. Произошла ошибка, платеж не выполнен, возможно средства поступят позже');
        	}
        	header("Location:../k19.html?form=3");exit();
		}else if($_GET[st]==3){                  //-----liqpay
        	if ($_POST['status'] == "success"){
				array_push($_SESSION[result],'LiqPay. Платеж выполнен');
			}else if($_POST['status'] == "wait_secure"){
				array_push($_SESSION[result],'LiqPay. Платеж в режиме ожидания');
			}else{
				array_push($_SESSION[result],'LiqPay. Платеж не удачный');
			}
        	header("Location:../k19.html?form=3");exit();
// ------------------------------------------------------------ VIVOD SREDSTV
		}else if($_GET[st]==4){//-----zayava
			if($_POST[suma]!='' and $_POST[rekv]!='' and $_POST[comerc]!=''){
				$_POST[suma]=mysql_escape_string(strip_tags($_POST[suma]));
				$_POST[type]=mysql_escape_string(strip_tags($_POST[type]));
				$_POST[rekv]=mysql_escape_string(strip_tags($_POST[rekv]));
				$_POST[comerc]=mysql_escape_string(strip_tags($_POST[comerc]));
				mysql_query("insert into katalog_vivod(user,price,rekv,comerc,data,type) values('$_SESSION[userid]','$_POST[suma]','$_POST[rekv]','$_POST[comerc]','$data','$_POST[type]')");
				mysql_query("REPLACE INTO vivod_user_rekv(user_id,vivod_type,rekv) VALUES ('$_SESSION[userid]','$_POST[type]','$_POST[rekv]')");
                array_push($_SESSION[result],'Ваша заявка успешно принята');
	        	header("Location:../k19.html?form=2");exit();
	      }else{array_push($_SESSION[error],'Были введенные не все данные');}
// ------------------------------------------------------------ PEREVOD SREDSTV
		}else if($_GET[st]==5){//-----perevod
			if($_POST[suma]<$user[balance]){
				$user_out=@mysql_fetch_array(mysql_query("select id_p from katalog_user WHERE id_p='$_POST[id]' limit 1"));
            	if($user_out[id_p]){
            		if($_SESSION[userresh]==0 and $user[resh]==1){
            			$config=mysql_fetch_array(mysql_query("select * from katalog_config limit 1"));

   $q1 = mysql_query('SELECT * FROM usr_stavka WHERE usr_id = '.$_POST[id]); 
   if (mysql_num_rows($q1) > 0)
   {
     $q1 = mysql_fetch_assoc($q1);
     $config[procent] = 100-$q1['stavka'];
   }

            			$procent=$_POST[suma]*$config[procent]/100;
            			$_POST[suma]=$_POST[suma]-$procent;
            			mysql_query("insert into katalog_finanse(inu,outu,add_data,type,status,price) values('$_SESSION[userid]','0','$data','1','1','$procent')")or die(mysql_error());
            		}
            		mysql_query("update katalog_user set balance=balance-$_POST[suma] WHERE id_p='$_SESSION[userid]' limit 1");
            		mysql_query("update katalog_user set balance=balance+$_POST[suma] WHERE id_p='$_POST[id]' limit 1");
            		mysql_query("insert into katalog_finanse(inu,outu,add_data,type,status,price) values('$_SESSION[userid]','$_POST[id]','$data','3','1','$_POST[suma]')")or die(mysql_error());
            		mysql_query("insert into katalog_message(user_in,user_out,text,data_create) values('$_SESSION[userid]','$_POST[id]','Пользователь ID=$_POST[id] пополнил Ваш счет на $_POST[suma] RUR','$data')");
            		array_push($_SESSION[result],'Перевод успешно выполнен');
            		header("Location:../k19.html?form=2&method=2");exit();
            	}else{array_push($_SESSION[error],'Нет такого пользователя');}
			}else{array_push($_SESSION[error],'На вашем счету недостаточно средств');}
		}else{array_push($_SESSION[error],'Неверное действие');}
		header("Location:../k19.html");
  	}else{//avtorization
    	array_push($_SESSION[error],'Вы не авторизированый пользователь. <a href="k20.html">Войдите</a> в систему');
    	header("Location:../k20.html");
	}
}

endif;

?>