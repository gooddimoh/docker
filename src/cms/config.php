<?if(!isset($_POST[B1])){
$config=mysql_fetch_array(mysql_query("select * from katalog_config limit 1"));
echo '
<form action="config.php" method=post>
<table border="0" width="100%">
	<tr>
		<td align="right"><font color="#003366" size="2" face="Arial">Комісія системи</font></td>
		<td width=10></td>
		<td><input type="text" name="procent" value="',$config[procent],'"> <font face="Arial" size="2" color="#003366">%</font></td>
	</tr>
	<tr>
		<td align="right"><font color="#003366" size="2" face="Arial">WebMoney id</font></td>
		<td width=10></td>
		<td><input type="text" name="webmoney" value="',$config[webmoney],'"></td>
	</tr>
	<tr>
		<td align="right"><font color="#003366" size="2" face="Arial">WebMoney SecretKey</font></td>
		<td width=10></td>
		<td><input type="text" name="webmoneykey" value="',$config[webmoneykey],'"></td>
	</tr>
	<tr>
		<td align="right"><font color="#003366" size="2" face="Arial">Liqpay id</font></td>
		<td width=10></td>
		<td><input type="text" name="liqpayid_from_card" value="',$config[liqpayid_from_card],'"></td>
	</tr>
	<tr>
		<td align="right"><font color="#003366" size="2" face="Arial">Liqpay Key</font></td>
		<td width=10></td>
		<td><input type="text" name="liqpaymarchand_from_card" value="',$config[liqpaymarchand_from_card],'"></td>
	</tr>
	<tr>
		<td align="right"><font color="#003366" size="2" face="Arial">Яндекс.Кошелек</font></td>
		<td width=10></td>
		<td><input type="text" name="yandex" value="',$config[yandex],'"></td>
	</tr>
	<tr>
		<td align="right"><font color="#003366" size="2" face="Arial">Індифікатор магазина Інтеркаса</font></td>
		<td width=10></td>
		<td><input type="text" name="ik_shop" value="',$config[ik_shop],'"></td>
	</tr>
	<tr>
		<td align="right"><font color="#003366" size="2" face="Arial">Секретний ключ Інтеркаса</font></td>
		<td width=10></td>
		<td><input type="text" name="ik_secret_key" value="',$config[ik_secret_key],'"></td>
	</tr>
	<tr>
		<td align="right"><font color="#003366" size="2" face="Arial">Індифікатор магазина Інтеркаса(методички/дипломы)</font></td>
		<td width=10></td>
		<td><input type="text" name="shop_ik_merch" value="',$config[shop_ik_merch],'"></td>
	</tr>
	<tr>
		<td align="right"><font color="#003366" size="2" face="Arial">Секретний ключ Інтеркаса(методички/дипломы)</font></td>
		<td width=10></td>
		<td><input type="text" name="shop_ik_secret" value="',$config[shop_ik_secret],'"></td>
	</tr>
	<tr>
		<td align="right"><font color="#003366" size="2" face="Arial">Індифікатор магазина liqpay(методички/дипломы)</font></td>
		<td width=10></td>
		<td><input type="text" name="shop_liqpay_merch" value="',$config[shop_liqpay_merch],'"></td>
	</tr>
	<tr>
		<td align="right"><font color="#003366" size="2" face="Arial">Секретний ключ liqpay(методички/дипломы)</font></td>
		<td width=10></td>
		<td><input type="text" name="shop_liqpay_secret" value="',$config[shop_liqpay_secret],'"></td>
	</tr>
	<tr>
		<td align="right"><font color="#003366" size="2" face="Arial">Процент системы(методички/дипломы)</font></td>
		<td width=10></td>
		<td><input type="text" name="shop_procent" value="',$config[shop_procent],'">%</td>
	</tr>
	<tr>
		<td align="right"><font color="#003366" size="2" face="Arial">Курс $ системы(методички/дипломы)</font></td>
		<td width=10></td>
		<td><input type="text" name="shop_kurs" value="',$config[shop_kurs],'"></td>
	</tr>
	<tr>
		<td align="right"></td>
		<td width=10></td>
		<td><input type="submit" value="Змінити" name="B1"></td>
	</tr>
</table></form>';
}else{
	include "mysql.php";
	//echo "update katalog_config set shop_liqpay_merch='$_POST[shop_liqpay_merch]', shop_liqpay_secret='$_POST[shop_liqpay_secret]', shop_kurs = ".(float)$_POST['shop_kurs'].", shop_ik_merch='$_POST[shop_ik_merch]',shop_ik_secret='$_POST[shop_ik_secret]',shop_procent='$_POST[shop_procent]',ik_shop='$_POST[ik_shop]',ik_secret_key='$_POST[ik_secret_key]',yandex='$_POST[yandex]',liqpayid_from_card='$_POST[liqpayid]',liqpaymarchand_from_card='$_POST[liqpaymarchand]',procent='$_POST[procent]',webmoney='$_POST[webmoney]',webmoneykey='$_POST[webmoneykey]' limit 1";
	//exit;
	mysql_query("update katalog_config set shop_liqpay_merch='$_POST[shop_liqpay_merch]', shop_liqpay_secret='$_POST[shop_liqpay_secret]', shop_kurs = ".(float)$_POST['shop_kurs'].", shop_ik_merch='$_POST[shop_ik_merch]',shop_ik_secret='$_POST[shop_ik_secret]',shop_procent='$_POST[shop_procent]',ik_shop='$_POST[ik_shop]',ik_secret_key='$_POST[ik_secret_key]',yandex='$_POST[yandex]',liqpayid_from_card='$_POST[liqpayid_from_card]',liqpaymarchand_from_card='$_POST[liqpaymarchand_from_card]',procent='$_POST[procent]',webmoney='$_POST[webmoney]',webmoneykey='$_POST[webmoneykey]' limit 1");
	header("Location: config.html");
  //  echo mysql_error();
}
?>