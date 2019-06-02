<?
include "mysql.php";
$config = mysql_fetch_array(mysql_query('SELECT * FROM katalog_config'));
//echo $config[ik_shop];

$merchant_id = $config[liqpayid_from_card];
$signature = $config[liqpaymarchand_from_card];
$url = "https://www.liqpay.com/?do=clickNbuy";
$method = 'card';
//$phone = $config[liqpayphone];
//$phone = '380636003861';

	$xml="<request>      
		<version>1.2</version>
		<result_url>http://stud-help.com</result_url>
		<server_url>http://stud-help.com/modul/resultbalans.php?st=3</server_url>
		<merchant_id>$merchant_id</merchant_id>
		<order_id>$_POST[id]</order_id>
		<amount>$_POST[price]</amount>
		<currency>RUR</currency>
		<description>Пополнение счета в системе stud-help.com</description>
		<default_phone>$phone</default_phone>
		<pay_way>$method</pay_way> 
		</request>
		";
	
	
	$xml_encoded = base64_encode($xml); 
	$lqsignature = base64_encode(sha1($signature.$xml.$signature,1));
	


echo("<form id='main' action='$url' method='POST'>
      <input type='hidden' name='operation_xml' value='$xml_encoded' />
      <input type='hidden' name='signature' value='$lqsignature' />
	
	</form>");
    
echo <<<_SC

<script>
 document.getElementById('main').submit();
</script>

_SC;

?>
	
