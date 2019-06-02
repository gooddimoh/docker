<?
function get_var($name, $default = 'none') {
  return (isset($_GET[$name])) ? $_GET[$name] : ((isset($_POST[$name])) ? $_POST[$name] : $default);
}


// logging


include_once (dirname(__FILE__)."/../mysql.php");
$config = mysql_fetch_array(mysql_query('SELECT * FROM katalog_config'));



if(isset($_POST)&&isset($_POST['signature'])/*||$_GET['test']==1*/){


// variables prepearing
$crc = get_var('signature');
$xml = get_var('operation_xml');

$xml_decoded=base64_decode($xml);
$obj_xml = simplexml_load_string($xml_decoded);
$inv_id = (int)$obj_xml->order_id;
$hash = base64_encode(sha1($config[shop_liqpay_secret].$xml_decoded.$config[shop_liqpay_secret],1));

//if ($_GET['test']==1) $inv_id = 119;

$fp = fopen(dirname(__FILE__).'/liqpay.log', 'a+');
$str=date('Y-m-d H:i:s').' - ';
foreach ($_POST as $vn=>$vv) {
	$str.=$vn.'='.$vv.';';
}
foreach ($_GET as $vn=>$vv) {
	$str.=$vn.'='.$vv.';';
}

$str .= '$hash='.$hash."\n";
$str .= '$crc='.$crc."\n";
$str .= $obj_xml->status."\n";
//$str .= print_r($obj_xml, true)."\n";


   if (/*$_GET['test']==1 ||*/ ($obj_xml->status == 'success' AND $hash == $crc)) {

	$q = mysql_query('SELECT * FROM katalog_orders WHERE id = '.$inv_id.' AND ( status = 0 or status = 0)');
//	$str .= 'SELECT * FROM katalog_orders WHERE id = '.$inv_id.' AND status = 0';
	if(mysql_num_rows($q)==1||$_GET['test']==1){
		$res = mysql_fetch_array($q);
		mysql_query('UPDATE katalog_user SET balance = balance + '.(((float)$res['price'] - (float)$res['price'] * ($config['shop_procent'])/100)*$config['shop_kurs']).' WHERE id_p = '.(int)$res['user_ispolnitel']);
//	$str .= 'UPDATE katalog_user SET balance = balance + '.(((float)$res['price']*$config['shop_kurs'] - (float)$res['price'] * (100-$config['shop_procent']))*$config['shop_kurs']).' WHERE id_p = '.(int)$res['user_ispolnitel'];
//		$str .= 'UPDATE katalog_user SET balance = balance + '.(((float)$res['price'] - (float)$res['price'] * ($config['shop_procent'])/100)*$config['shop_kurs']).' WHERE id_p = '.(int)$res['user_ispolnitel'];
		mysql_query('UPDATE katalog_orders SET status = 1 WHERE id = '.$inv_id);

		include "../modul/keyganarator.php";
		$rnd=createRandomKey(10);
		$data = time();
		mysql_query("insert into katalog_finanse(status,inu,outu,type,rnd,add_data,price) values('1','".(int)$res['user_ispolnitel']."',0,'1','$rnd', '$data', ".((float)$res['price'] * $config['shop_procent']/100 * $config['shop_kurs']).")");
		//$str .= "insert into katalog_finanse(status,outu,type,rnd,add_data,price) values('0','".(int)$res['user_ispolnitel']."','4','$rnd', NOW(), ".((float)$res['price'] * $config['shop_procent']/100 * $config['shop_kurs']).")";
//	$str .= 'UPDATE katalog_orders SET status = 1 WHERE id = '.$inv_id;

		$res2 = mysql_fetch_array(mysql_query('SELECT * FROM katalog_user WHERE id_p = '.(int)$res['user_ispolnitel']));
		include_once('rozsl/class.phpmailer.php');
		include "config.php";

			$info = '<font size="2" face="Arial">Ваш заказ №'.$inv_id.' оплачен. <br/><a href="http://stud-help.com/upload.php?file='.$res['file_name2'].'">Ссылка для скачивания файла</a> (действительна сутки) <a href="http://stud-help.com/k6.html">http://stud-help.com</a></font>';
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


fwrite($fp, $str."\n");
fclose($fp);


		header('Location: /k138.html'); exit;
	
	} else $_SESSION[result] = 'Такой заказ отсутствует';
	header('Location: /');
   }

}



$merchant_id = $config[shop_liqpay_merch];
$signature = $config[shop_liqpay_secret];
$url = "https://www.liqpay.com/?do=clickNbuy";
$method = 'card';
//$phone = $config[liqpayphone];

	$xml = "<request>      
		<version>1.2</version>
		<result_url>http://stud-help.com/</result_url>
		<server_url>http://stud-help.com/payment/liqpay.php</server_url>
		<merchant_id>$merchant_id</merchant_id>
		<order_id>$order_id</order_id>
		<amount>".(float)$res['price']."</amount>
		<currency>USD</currency>
		<description>".iconv('cp1251','utf-8',$res['name_zadacha'])."</description>
		<default_phone>$phone</default_phone>
		<pay_way>$method</pay_way> 
		</request>
		";
	
	
	$xml_encoded = base64_encode($xml); 
	$lqsignature = base64_encode(sha1($signature.$xml.$signature,1));
	
//echo $xml;

$form = "<div id='form'><form id='main' action='$url' method='POST'>
      <input type='hidden' name='operation_xml' value='$xml_encoded' />
      <input type='hidden' name='signature' value='$lqsignature' />
	
	</form></div>";

echo <<<_SC
<script type="text/javascript" src="jquery/jquery.min.js"></script>
<script>
	jQuery(document).ready(function(){ parent.jQuery('body').append(jQuery('#form').html()); parent.jQuery("#main").submit(); });
</script>

_SC;

echo $form;

?>
	
