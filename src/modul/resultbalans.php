<?
//foreach ($_GET as $vn=>$vv) {
//  $_POST[$vn] = $vv;
//}

if(0):

include "../mysql.php";
$data = $time = time();

//mysql_query("insert into katalog_error(error) values('Vhid s interkassi $_GET[st] $_SERVER[SERVER_NAME] $_SERVER[REQUEST_URI] ')");
//mysql_query("insert into katalog_error(error) values('Vhid s interkassi || $_POST[ik_payment_id] || $_POST[ik_payment_amount] || $_POST[ik_payment_id] || $_POST[ik_payment_amount]')");

mysql_query("insert into katalog_error(error) values('". addslashes(json_encode(array('TIME' => date('d.m.Y H:i:s'), 'GET' => &$_GET, 'POST' => &$_POST, 'REQUEST_URI' => $_SERVER['REQUEST_URI']))) ."')");

$config=mysql_fetch_array(mysql_query("select * from katalog_config limit 1"));
//--------------------------------------------------------------- webmoney
if($_GET[st]==1){
	mysql_query("insert into katalog_error(error) values('Vhid s interkassi1')");
	//---------------------------- # Prerequest
	if( isset($_POST[LMI_PREREQUEST]) && $_POST[LMI_PREREQUEST] == 1){
	    $pay = mysql_fetch_array(mysql_query("select id,rnd from katalog_finanse where outu='$_POST[ID_USER]' and status='0' limit 1"));
		if($_POST[RND] == $pay[rnd]){                                  # rand site key
			if($_POST[LMI_PAYMENT_NO] == $pay[id]){
				if($_POST[LMI_PAYEE_PURSE] == $config[webmoney]){          # webmoney koshelek prodavca
					mysql_query("UPDATE katalog_finanse SET status='2',inu='-1',price='$_POST[LMI_PAYMENT_AMOUNT]' WHERE id='$pay[id]'")or die(mysql_error());
					echo 'YES';
				}else{
					mysql_query("insert into katalog_error(error) values('Невірний кошельок продавця № $_POST[LMI_PAYEE_PURSE]')");
					mysql_query("UPDATE katalog_finanse SET status='4',add_data='$data' WHERE id='$pay[id]'");
					echo 'NO';
				}
			}else{
				mysql_query("insert into katalog_error(error) values('Немає рахунку id $_POST[LMI_PAYMENT_NO]')");
				mysql_query("UPDATE katalog_finanse SET status='4',add_data='$data' WHERE id='$pay[id]'");
				echo 'NO';
			}
		}else{
			mysql_query("insert into katalog_error(error) values('Контрольне число замовлення $pay[id] не співпало')");
			mysql_query("UPDATE katalog_finanse SET status='4',add_data='$data' WHERE id='$pay[id]'");
			echo 'NO';
		}
	//---------------------------- # Payment notification
	}else{
		//------------ config
	    $pay = mysql_fetch_array(mysql_query("SELECT * FROM katalog_finanse WHERE id ='$_POST[LMI_PAYMENT_NO]' limit 1"));
		//$LMI_SIM_MODE = '0'; //rejim test ok

		//$LMI_MODE = $_SERVER["REMOTE_ADDR"] == '46.118.241.198' ? '1' : '0'; // 1-testoviy rejim 0-realniy rejim
		$LMI_MODE = '0';
        //$LMI_HASH_METHOD = 'MD5';
		$secret_key=$config[webmoneykey];
		//------------ config
		$chkstring =  $config[webmoney].$_POST[LMI_PAYMENT_AMOUNT].$pay[id].
		$_POST[LMI_MODE].$_POST[LMI_SYS_INVS_NO].$_POST[LMI_SYS_TRANS_NO].$_POST[LMI_SYS_TRANS_DATE].
		$secret_key.$_POST[LMI_PAYER_PURSE].$_POST[LMI_PAYER_WM];

        /*
		if ( $LMI_HASH_METHOD == 'MD5' ) {
		    $md5sum = strtoupper(md5($chkstring));
		}else{
			mysql_query("insert into katalog_error(error) values('Невірний метод шифрування')");
			mysql_query("UPDATE katalog_finanse SET status='4',add_data='$data' WHERE id='$pay[id]'");
		}*/

        if(strtoupper($_POST[LMI_HASH]) == strtoupper(hash('sha256', $chkstring))){
			if($_POST[LMI_PAYMENT_NO] == $pay[id] # Check if payment id, purse number and amount correspond
					&& $_POST[LMI_PAYEE_PURSE] == $config[webmoney]
					&& $_POST[LMI_PAYMENT_AMOUNT] == $pay[price]
					&& $_POST[LMI_MODE] == $LMI_MODE) {

						mysql_query("insert into katalog_wm(id_p,LMI_SYS_TRANS_NO,LMI_SYS_INVS_NO,LMI_PAYER_PURSE,LMI_PAYER_WM,LMI_SYS_TRANS_DATE)
						values('$pay[id]','$_POST[LMI_SYS_TRANS_NO]','$_POST[LMI_SYS_INVS_NO]','$_POST[LMI_PAYER_PURSE]','$_POST[LMI_PAYER_WM]','$_POST[LMI_SYS_TRANS_DATE]')");

						mysql_query("UPDATE katalog_finanse SET status='1',add_data='$data' WHERE id='$pay[id]'");
						mysql_query("UPDATE katalog_user SET balance=balance+$_POST[LMI_PAYMENT_AMOUNT] WHERE id_p='$pay[outu]'");
			}else{
				mysql_query("insert into katalog_error(error) values('Невірний дані замовлення $_POST[LMI_PAYMENT_NO]')");
				mysql_query("UPDATE katalog_finanse SET status='4',add_data='$data' WHERE id='$pay[id]'");
			}
		}else{
				mysql_query("insert into katalog_error(error) values('Невірний ключ замовлення id $pay[id] клієнта id $pay[outu]')");
				mysql_query("UPDATE katalog_finanse SET status='4',add_data='$data' WHERE id='$pay[id]'");
		}
	}
//--------------------------------------------------------------- interkassa
}else if(isset($_POST[ik_shop_id])||$_GET[st]==2){
    
    if ($_POST['ik_co_id']) {
        
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
        
        mysql_query("insert into katalog_error(error) values('$sign || ".strtoupper($ik_sign)."')");
        
        if ($sign == $ik_sign && $data['ik_co_id'] == $merchant_id) {
            
            $order_id = (int)$data['ik_pm_no'];
            $amount = (float)$data['ik_am'];
            
            mysql_query("insert into katalog_error(error) values('Vhid s interkassi2')");
        	//------------ config
            $q = mysql_query("select * from katalog_finanse where id='$order_id' and status='0' limit 1");
            if(!mysql_num_rows($q)) die();
          
            $pay = mysql_fetch_array($q);
            $qq = "UPDATE katalog_finanse SET status=2 ,inu=-2 ,price=$amount WHERE id='$pay[id]'";
           // mysql_query("insert into katalog_error(error) values('".mysql_real_escape_string($qq)."')");
        	mysql_query($qq);
            
            /*
        	$secret_key = $config[ik_secret_key];
        	//------------ !config
        	$sing_hash_str = $_POST[ik_shop_id].':'.
        		$_POST[ik_payment_amount].':'.
        		$_POST[ik_payment_id].':'.
        		$_POST[ik_paysystem_alias].':'.
        		$_POST[ik_baggage_fields].':'.
        		$_POST[ik_payment_state].':'.
        		$_POST[ik_trans_id].':'.
        		$_POST[ik_currency_exch].':'.
        		$_POST[ik_fees_payer].':'.
        		$secret_key;
        
           	mysql_query("insert into katalog_error(error) values('$sing_hash_str || ".strtoupper($_POST[ik_sign_hash])." || $sign_hash')");
        */
        
        	   
        		if($data['ik_inv_st'] == 'success') {
        
        			mysql_query("insert into katalog_ik(id_p,ik_paysystem_alias,ik_trans_id,ik_currency_exch)
        			values('$pay[id]','$_POST[ik_pw_via]','$_POST[ik_trn_id]','')");
        
        			mysql_query("UPDATE katalog_finanse SET status='1',add_data='$time' WHERE id='$pay[id]'");
        			mysql_query("UPDATE katalog_user SET balance=balance+$amount WHERE id_p='$pay[outu]'");
                  //  if() mysql_query("UPDATE katalog_finanse SET price=");
        
        		}else{
         	        mysql_query("insert into katalog_error(error) values('Невірний статус замовлення id $pay[id] клієнта id $pay[outu]')");
            	    mysql_query("UPDATE katalog_finanse SET status='4',add_data='$time' WHERE id='$pay[id]'");
        		}
        
        } else
            mysql_query("insert into katalog_error(error) values('Невірний секретний ключ замовлення id $pay[id] клієнта id $pay[outu]')");
    
    } else echo 'NO';
//--------------------------------------------------------------- liqpay
}else if($_GET[st]==3){
    mysql_query("insert into katalog_error(error) values('Vhid s liqpay3')");

    $decode_xml = base64_decode($_POST['operation_xml']);
    $xml = new SimpleXMLElement($decode_xml);
    $sign = base64_encode(sha1($config[liqpaymarchand_from_card].$decode_xml.$config[liqpaymarchand_from_card],1));
    
    $q = mysql_query("select * from katalog_finanse where id=$xml->order_id and status='0' limit 1");
    if(!mysql_num_rows($q)) die();
            
	$pay = mysql_fetch_array($q);
	mysql_query("UPDATE katalog_finanse SET status=2 ,inu=-3 ,price=$xml->amount WHERE id=$pay[id]");
    /**
	$version = $_POST[version];            // versia systemi
	$action_name = $_POST[action_name];    // sposob otveta server or result
	$sender_phone = $_POST[sender_phone];  // telefon klienta
	$merchant_id = $_POST[merchant_id];	 // id nash
	$amount = $_POST[amount];				 // suma
	$currency = $_POST[currency];          // valuta
	$order_id = $_POST[order_id];			 // nomer rahunka
	$transaction_id = $_POST[transaction_id];  // nomer rahunka v sistemi
	$status = $_POST[status];				 // starus
	$code = $_POST[code];                  // cod ne vikorist

	$merchant_password = $config[liqpaymarchand];
    **/
	#Выполняем кодировку
//	$signature_source = "|$version|$merchant_password|$action_name|$sender_phone|$merchant_id|$amount|$currency|$order_id|$transaction_id|$status|$code|";
//	$sign=base64_encode(sha1($signature_source,1));

	#проверка подписи
	if($xml->status == "success" || $xml->status == "wait_secure"){
	//mysql_query("insert into katalog_error(error) values('Cтатус $_POST[status]')");
		if ($_POST[signature] == $sign){
			//mysql_query("insert into katalog_error(error) values('Сігнатура правильна для клієнта $pay[outu]')");
			mysql_query("insert into katalog_liqpay(id_p,sender_phone,transaction_id,currency)
			values('$xml->order_id','$xml->sender_phone','$xml->transaction_id','$xml->currency')");// liqpay ok
			mysql_query("UPDATE katalog_finanse SET status = 1 ,add_data='$data' WHERE id='$xml->order_id'");
			mysql_query("UPDATE katalog_user SET balance = balance + $xml->amount WHERE id_p = $pay[outu] ");
		}else{
			mysql_query("insert into katalog_error(error) values('Невірний ключ замовлення id $pay[id] клієнта id $pay[outu]')");
			mysql_query("UPDATE katalog_finanse SET status='4',add_data='$data' WHERE id='$pay[id]'");}
    }else{
    	mysql_query("insert into katalog_error(error) values('Status feil is $xml->status id $pay[id] client id $pay[outu]')");
    	mysql_query("UPDATE katalog_finanse SET status='4',add_data='$data' WHERE id='$pay[id]'");
    }
}else{
	mysql_query("insert into katalog_error(error) values('Vhid s interkassiNO')");
	mysql_query("insert into katalog_error(error) values('Невірна дія клієнта')");
}
mysql_query("insert into katalog_error(error) values('Vhid end')");

endif;

?>