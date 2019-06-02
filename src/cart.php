<?php
include 'mysql.php';
require_once $_SERVER["DOCUMENT_ROOT"] . "/modul/custom_sessions.php"; CustomSessions::start();
	
	if($_SESSION['logintrue']){
		$q2 = mysql_query('SELECT * FROM katalog_user WHERE id_p = '.(int)$_SESSION['userid'].'');
		if(!mysql_num_rows($q2)) { echo '<script>parent.document.location.href="/k136.html"</script>';exit; }
		$user = mysql_fetch_array( $q2 );
	}

	if((int)$_GET['zid']) $query = mysql_query('SELECT kmz.*, km.metod_name, km.user_id FROM katalog_metods_zad as kmz LEFT JOIN katalog_metods as km ON(km.id = kmz.metod_id) WHERE kmz.id = '.(int)$_GET['zid'].'');
	if((int)$_GET['mid']) $query = mysql_query('SELECT * FROM katalog_metods WHERE id = '.(int)$_GET['mid'].'');

	if(!mysql_num_rows($query)) { echo '<script>parent.document.location.href="/k136.html"</script>'; exit; }	
	$res = mysql_fetch_array( $query );

if(isset($_POST['saveorder'])){

	include 'validate_email.inc.php';

	$err_style = ' style="border:1px solid red" ';

	if(!$_SESSION['logintrue']){
		$firstname = trim($_POST['firstname']);
		$phone = trim($_POST['phone']);
		$email = trim($_POST['email']);

		if($firstname == '') { $error['firstname']['style'] = $err_style; $error['firstname']['text'] = 'Не заполнено поле Имя';};
		if($phone == '') { $error['phone']['style'] = $err_style; $error['phone']['text'] = 'Не заполнено поле Телефон';};
		if($email == ''||!validate_email($email)) { $error['email']['style'] = $err_style; $error['email']['text'] = 'Не корректное значение поля E-mail';};
	} else {
		$firstname = $user['login'];
		$phone = (trim($_POST['phone'])!=''?trim($_POST['phone']):$user['tel']);
		if($phone == '') { $error['phone']['style'] = $err_style; $error['phone']['text'] = 'Не заполнено поле Телефон';};
		$email = $user['email'];
	}

	$payment = trim(str_replace(".","",$_POST['payment']));
	if($payment == '') { $error['payment']['style'] = $err_style; $error['payment']['text'] = 'Выберите способ оплаты';};

	if(sizeof($error)) unset($_POST['saveorder']);
	else {
		$q = mysql_query('INSERT INTO katalog_orders SET username = "'.addslashes($firstname).'", user_ispolnitel = '.$res['user_id'].',
								phone = "'.addslashes($phone).'",
								email = "'.addslashes($email).'",
								name_zadacha = "'.addslashes($res['name_zadacha']).'('.$res['metod_name'].')",
								file_name = "'.$res['file_name'].'", file_name2 = "'.md5($res['file_name'].time()).'", 
								price = '.(float)$res['price'].', date_add = NOW(),
								status = 0
								');
		$order_id = mysql_insert_id();
		include "payment/".$payment.'.php';
		echo 'Заказ принят, № '.$order_id;
	}
} 
if(!isset($_POST['saveorder'])){ 

?>
<link href="style.css" type="text/css" rel="stylesheet" />
<div class="cartPopup">
<? if(is_array($error)) foreach($error as $item) echo '<p style="color: #F00;">'.$item['text'].'</p>';?>
<? 
	if($_SESSION['logintrue']){
		$firstname = $user['login'];
		$phone = $user['tel'];
		$email = $user['email'];
		//$readonly = ' readonly = "readonly" ';
	}
?>
	<p><b>Купить решение:</b> <?=$res['name_zadacha']?></p>
	<p><b>Раздел:</b> <?=$res['name_razdel']?></p>
	<p><b>Методичка:</b> <?=$res['metod_name']?></p>
	<p><b>Стоимость:</b> <?=$res['price']?></p>
	<form method="POST">
		<label><b>Имя:</b>* <input <?=$readonly.$error['firstname']['style']?> type="text" name="firstname" value="<?=$firstname?>"/></label>
		<label><b>Телефон:</b>*  
			<input <?=$readonly.$error['phone']['style']?> type="text" name="phone" value="<?=$phone?>"/></label>
		<label><b>E-Mail:</b>* 
			<input <?=$readonly.$error['email']['style']?> type="text" name="email" value="<?=$email?>"/></label>
		<label><b>Способ оплаты:</b>* 
			<select <?=$error['payment']['style']?> name="payment">
				<option value="">Выберите способ оплаты</option>
				<option <?=($payment=="liqpay"?' selected = "selected" ':'')?> value="liqpay">LiqPay</option>
				<option <?=($payment=="ik"?' selected = "selected" ':'')?> value="ik">InterKassa</option>
			</select></label>
		<input type="hidden" name="saveorder" value="1"/>
		<input type="submit" value="Оформить заказ"/>
	</form>
</div>
<? }

?>