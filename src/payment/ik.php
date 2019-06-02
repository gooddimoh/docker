<?

/*
$fp = fopen(dirname(__FILE__).'/ik.log', 'a+');
$str=date('Y-m-d H:i:s').' - ';
foreach ($_POST as $vn=>$vv) {
	$str.=$vn.'='.$vv.';';
}
foreach ($_GET as $vn=>$vv) {
	$str.=$vn.'='.$vv.';';
}

fwrite($fp, $str."\n");
fclose($fp);
*/

include_once (dirname(__FILE__)."/../mysql.php");

$config = mysql_fetch_array(mysql_query('SELECT * FROM katalog_config'));


//$_POST['ik_co_id'] = $_GET['ik_co_id'];
//$_POST['ik_pm_no'] = $_GET['ik_pm_no'];

if(isset($_POST['ik_co_id'])&&isset($_POST['ik_pm_no'])&&(int)$_POST['ik_pm_no']){


        mysql_query("insert into katalog_error(error) values('". addslashes(json_encode(array('TIME' => date('d.m.Y H:i:s'), 'GET' => &$_GET, 'POST' => &$_POST, 'REQUEST_URI' => $_SERVER['REQUEST_URI']))) ."')");

        $ik_key = $config[ik_secret_key];
        $merchant_id = $config[ik_shop];
        $data = array();
        foreach ($_REQUEST as $key => $value) {
            if (!preg_match('/ik_/', $key)) continue;
            $data[$key] = $value;
        }
        $ik_sign = $data['ik_sign'];
        unset($data['ik_sign']);
        ksort($data, SORT_STRING);
        array_push($data, $ik_key);
        $signString = implode(':', $data);
        $sign = base64_encode(md5($signString, true));


/*
	$secret_key = $config[shop_ik_secret];
	//------------ !config
	$sing_hash_str = $_POST[ik_co_id].':'.
		$_POST[ik_am].':'.
		$_POST[ik_pm_no].':'.
		$_POST[ik_paysystem_alias].':'.
		$_POST[ik_baggage_fields].':'.
		$_POST[ik_payment_state].':'.
		$_POST[ik_trans_id].':'.
		$_POST[ik_currency_exch].':'.
		$_POST[ik_fees_payer].':'.
		$secret_key;

    $str .= $_POST[ik_payment_state].'*'.strtoupper($_POST[ik_sign_hash]).'*'.strtoupper(md5($sing_hash_str));
    fwrite($fp, $str."\n");
    fclose($fp);
*/

	//if($_POST[ik_payment_state] == "success" && strtoupper($_POST[ik_sign_hash]) == strtoupper(md5($sing_hash_str))){
    if ($sign == $ik_sign && $data['ik_co_id'] == $merchant_id && $data['ik_inv_st'] == 'success') {
//		$sign_hash = strtoupper(md5($sing_hash_str));
//		if(strtoupper($_POST[ik_sign_hash]) == $sign_hash) {




	$q = mysql_query('SELECT * FROM katalog_orders WHERE id = '.(int)$_POST['ik_pm_no'].' AND status = 0');
	if(mysql_num_rows($q)==1){
		$res = mysql_fetch_array($q);
        
        if((float)$res['price'] != (float)$data['ik_am'])
        {
            mysql_query("insert into katalog_error(error) values('". sprintf('error price. send: %s. need: %s. order_id: %d', $data['ik_am'], $res['price'], $_POST['ik_pm_no']) ."')");
            die('Error price.');
        }
        
		mysql_query('UPDATE katalog_user SET balance = balance + '.(((float)$res['price'] - (float)$res['price'] * ($config['shop_procent'])/100)*$config['shop_kurs']).' WHERE id_p = '.(int)$res['user_ispolnitel']);
		mysql_query('UPDATE katalog_orders SET status = 1 WHERE id = '.(int)$_POST['ik_pm_no']);

		include "../modul/keyganarator.php";
		$rnd=createRandomKey(10);
		$date = time();
		mysql_query("insert into katalog_finanse(status,inu,outu,type,rnd,add_data,price) values('1','".(int)$res['user_ispolnitel']."',0,'1','$rnd', '$date', ".((float)$res['price'] * $config['shop_procent']/100 * $config['shop_kurs']).")");

		$res2 = mysql_fetch_array(mysql_query('SELECT * FROM katalog_user WHERE id_p = '.(int)$res['user_ispolnitel']));
		include_once('rozsl/class.phpmailer.php');
		include "config.php";

			$info = '<font size="2" face="Arial">Ваш заказ №'.(int)$_POST['ik_pm_no'].' оплачен. <br/><a href="http://stud-help.com/upload.php?file='.$res['file_name2'].'">Ссылка для скачивания файла</a> (действительна сутки) <a href="http://stud-help.com/k6.html">http://stud-help.com</a></font>';
			$info2 = '<font size="2" face="Arial">Ваша задача '.$res['name_zadacha'].' куплена. На счет зачислено $ '.((float)$res['price'] * 0.6).' <a href="http://stud-help.com/k6.html">http://stud-help.com</a></font>';
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
					$mail->AddAddress($res['email'], $res['email']);
					$mail->Send();

					$body             = $info2;
					$body             = eregi_replace("[\]",'',$body);
					$mail->MsgHTML($body);
					$mail->ClearAddresses();
					$mail->AddAddress($res2['email'], $res2['email']);
					$mail->Send();

		$_SESSION[result] = 'Заказ оплачен';


		header('Location: /k138.html'); exit;
	
	} else $_SESSION[result] = 'Такой заказ отсутствует';
	header('Location: /');
	}
	header('Location: /'); exit;
}

//$config['ik_shop'] = 'F2A64543-296E-66F9-62F6-1CE55F887B0F';
$form = <<<HTML

<!------------------------------------------------------------ INTERKASSA-->
				<div id="form">
				<form id="main" name="payment" action="https://sci.interkassa.com/" method="post" accept-charset="cp1251">
				<b><font color="#333333" size="4" face="Arial">Interkassa.Com</font></b><p>
					<input type="hidden" name="ik_co_id" value="$config[shop_ik_merch]">
					<input type="hidden" name="ik_pm_no" value="$order_id">
					<input type="hidden" name="ik_desc" value="$res[name_zadacha]">
                    <input type="hidden" name="ik_enc" value="cp1251">
                    <input type="hidden" name="ik_cur" value="RUB">

					</p>
					<input type="hidden" name="ik_am" size="10" value="$res[price]">

					<input type="submit" value="Продолжить" name="process">
				</form></div>

HTML;


echo <<<_SC
<script type="text/javascript" src="jquery/jquery.min.js"></script>
<script>
	jQuery(document).ready(function(){ parent.jQuery('body').append(jQuery('#form').html()); parent.jQuery("#main").submit(); });
</script>

_SC;

echo $form;

?>
	
