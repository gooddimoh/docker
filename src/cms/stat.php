<?
if(!isset($_GET[method])){$methodstr=' desc ';}else{$methodstr=' asc ';}

if(isset($_GET[id_p])){$sqlstr=' order by id ';}
else if(isset($_GET[add_data])){$sqlstr=' order by add_data ';}
else if(isset($_GET[inu])){$sqlstr=' order by inu ';$sqladd=',add_data desc ';}
else if(isset($_GET[outu])){$sqlstr=' order by outu ';$sqladd=',add_data desc ';}
else {$sqlstr=' order by id ';}

$r = mysql_query("SELECT *,
                    (SELECT name FROM vivod_types WHERE id = katalog_finanse.inu) AS inu_name,
                    (SELECT name FROM vivod_types WHERE id = katalog_finanse.outu) AS outu_name
                  FROM katalog_finanse where status<>'0' ".$sqlstr.$methodstr.$sqladd)or die(mysql_error());//підрозділи теперішнього розділу
$bal=mysql_fetch_array(mysql_query("SELECT sum(price) FROM katalog_finanse where outu=0 group by outu"));
$baluser=mysql_fetch_array(mysql_query("SELECT sum(balance) FROM katalog_user"));
?>

<style>
.del_inp{
   display: block;
   margin: 0 auto; 
}
</style>

<script>

var check = false;

function recheck_all(cur)
{
     if (check) 
     {
       check = false;
       $("input:checkbox").attr("checked",""); 
     }
     else 
     {
        check = true;
        $("input:checkbox").attr("checked","checked");
     }   
}

</script>

<form action='statdel.php' method='post'>

<b><font size="2" face="arial" color=#023761>Прибуток системи: <?echo $bal[0];?> RUR </font></b><p>
<input style="position: absolute; right: 20px; margin-top: -30px;" type='submit' onclick="if (!confirm('Знищити обранi?')) return false;" value='Знищити' />
<table border="0" width="100%" id="table2" style="border:1px solid #bbbbbb" >
	<tr>
		<td bgcolor="#023761" align="center" width=30>
			<table><tr><td><b><font size="1" face="arial" color=#ffffff> id</font></b>
			<td><table border="0" align=left cellpadding=0 cellspacing=0><tr>
			<td><a href="stat.html?r=<?echo $_GET[r],'&id&method';?>"><img border="0" src="images/arrow_blue_up.png" width="10" height="10"></td></tr><tr>
			<td><a href="stat.html?r=<?echo $_GET[r],'&id';?>"><img border="0" src="images/arrow_blue_down.png" width="10" height="10"></td></tr>
			</table></td></tr></table>
		</td>
		<td bgcolor="#023761" align="center">
			<table><tr><td><b><font size="1" face="arial" color=#ffffff>Від</font></b>
			<td><table border="0" align=left cellpadding=0 cellspacing=0><tr>
			<td><a href="stat.html?r=<?echo $_GET[r],'&inu&method';?>"><img border="0" src="images/arrow_blue_up.png" width="10" height="10"></td></tr><tr>
			<td><a href="stat.html?r=<?echo $_GET[r],'&inu';?>"><img border="0" src="images/arrow_blue_down.png" width="10" height="10"></td></tr>
			</table></td></tr></table>
		</td>
		<td bgcolor="#023761" align="center">
			<table><tr><td><b><font size="1" face="arial" color=#ffffff>Кому</font></b>
			<td><table border="0" align=left cellpadding=0 cellspacing=0><tr>
			<td><a href="stat.html?r=<?echo $_GET[r],'&outu&method';?>"><img border="0" src="images/arrow_blue_up.png" width="10" height="10"></td></tr><tr>
			<td><a href="stat.html?r=<?echo $_GET[r],'&outu';?>"><img border="0" src="images/arrow_blue_down.png" width="10" height="10"></td></tr>
			</table></td></tr></table>
		</td>
		<td bgcolor="#023761" align="center">
			<table><tr><td><b><font size="1" face="arial" color=#ffffff>дата платежу</font></b>
			<td><table border="0" align=left cellpadding=0 cellspacing=0><tr>
			<td><a href="stat.html?r=<?echo $_GET[r],'&add_data&method';?>"><img border="0" src="images/arrow_blue_up.png" width="10" height="10"></td></tr><tr>
			<td><a href="stat.html?r=<?echo $_GET[r],'&add_data';?>"><img border="0" src="images/arrow_blue_down.png" width="10" height="10"></td></tr>
			</table></td></tr></table>
		</td>
		<td bgcolor="#023761" align="center"><b><font size="1" face="arial" color=#ffffff>cума</font></b></td>
		<td bgcolor="#023761" align="center"><b><font size="1" face="arial" color=#ffffff>cтатус платежу</font></b></td>
		<td bgcolor="#023761" align="center"><b><font size="1" face="arial" color=#ffffff>тип платежу</font></b></td>
		<td bgcolor="#023761" align="center"><b><font size="1" face="arial" color=#ffffff> <input type="checkbox" onchange="recheck_all(this)" name="all_del" value="1" /> </font></b></td>
        <td width=50 bgcolor="#023761" align="center" ><b><font size="1" face="arial" color=#ffffff>знищ.</font></b></td>
	</tr>
<?
for($i=1;$i<=@mysql_num_rows($r);$i++){
	$rf=mysql_fetch_array($r);
	        echo '<tr ';if($rf[type]==1){echo 'bgcolor="#ECF7FF"';}else{echo 'onmouseover="this.style.backgroundColor=\'#ECF7FF\'" onmouseout="this.style.backgroundColor=\'#ffffff\'"';} echo '>
		<td style="border:1px solid #eeeeee"><font color="#333333" face="Arial" style="font-size: 11px">',$rf[id],'</font></td>
		<td style="border:1px solid #eeeeee"><font color="#333333" face="Arial" style="font-size: 11px">';
		/*if($rf[inu]==-1){echo 'webmoney';}
		else if($rf[inu]==-2){echo 'interkassa';}
		else if($rf[inu]==-3){echo 'liqpay';}
		else if($rf[inu]==-5){echo 'админ';}*/
        if($rf[inu_name]) echo $rf[inu_name];
		else{
			$us=mysql_fetch_array(mysql_query("select login from katalog_user where id_p='$rf[inu]'"));
			echo $us[login];
		}
		echo '</font></td>
		<td style="border:1px solid #eeeeee"><font color="#333333" face="Arial" style="font-size: 11px">
		<font color="#333333" face="Arial" style="font-size: 11px">';
		/*if($rf[outu]==0){echo 'система';}
		else if($rf[outu]==-1){echo 'webmoney';}
		else if($rf[outu]==-3){echo 'liqpay';}
		else if($rf[outu]==-4){echo 'другое';}*/
        if($rf[outu_name]) echo $rf[outu_name];
		else{
			$us=mysql_fetch_array(mysql_query("select login from katalog_user where id_p='$rf[outu]'"));
			echo $us[login];
		}
		echo '</font></td>
		<td align=center style="border:1px solid #eeeeee"><font color="#333333" face="Arial" style="font-size: 11px">';
		if($rf[add_data]=='' or $rf[add_data]==0){echo 'оплата не осуществлена';}else{echo date('d.m.y H:i',$rf[add_data]);}
		echo '</font></td>
		<td align=center style="border:1px solid #eeeeee"><font color="#333333" face="Arial" style="font-size: 11px">',$rf[price],'</font></td>
		<td align=center style="border:1px solid #eeeeee"><font color="#333333" face="Arial" style="font-size: 11px">';
		if($rf[status]==1){echo 'выполнен';}
		else if($rf[status]==2){echo 'в обработке';}
		else if($rf[status]==4){echo 'не выполнен';}
		echo '</font></td>
		<td  align=center style="border:1px solid #eeeeee"><font color="#333333" face="Arial" style="font-size: 11px">';
		if($rf[type]==1){echo '%';}
		else if($rf[type]==2){echo 'оплата заказа';}
		else if($rf[type]==3){echo 'перечисление';}
		else if($rf[type]==4){echo 'пополнение';}
		else if($rf[type]==5){echo 'вывод';}
		echo '</font></td>
        <td><input class="del_inp" name="itms[]" value="'.$rf[id].'" type="checkbox"></td>
		<td align=center style="border:1px solid #eeeeee">
           	<a href="statdel.php?id=',$rf[id],'" onClick="if (confirm(\'знищити операцію\')) { this.href+=\'&confirm=1\'; return true; } else return false;"><img border=0 src="images/del.gif"></a>
        </td>
	</tr>';}
?>
</table>
</form>