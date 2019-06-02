<?
$stat = array("Новый", "Оплачен", "Отменен");
if(isset($_GET['del'])&&isset($_GET['id'])&&(int)$_GET['id']){
	include "mysql.php";
	$r = mysql_query('DELETE FROM katalog_orders WHERE id = '.(int)$_GET['id'].'')or die(mysql_error());
	header('Location: /cms/orders.html');
}

if(!isset($_GET[method])){$methodstr=' desc ';}else{$methodstr=' asc ';}

if(isset($_GET[id_p])){$sqlstr=' order by id ';}
//else if(isset($_GET[data_create])){$sqlstr=' order by data_create ';}
else {$sqlstr=' order by id ';}

$r = mysql_query("SELECT * FROM katalog_orders ".$sqlstr.$methodstr)or die(mysql_error());//підрозділи теперішнього розділу
?>
<table border="0" width="100%" id="table2" style="border:1px solid #bbbbbb" >
        <tr>
		        <td bgcolor="#023761" align="center" width=30>
<table><tr><td><b><font size="1" face="arial" color=#ffffff>id</font></b>
<td><table border="0" align=left cellpadding=0 cellspacing=0><tr>
	<td><a href="message.html?r=<?echo $_GET[r],'&id_p&method';?>"><img border="0" src="images/arrow_blue_up.png" width="10" height="10"></td></tr><tr>
	<td><a href="message.html?r=<?echo $_GET[r],'&id_p';?>"><img border="0" src="images/arrow_blue_down.png" width="10" height="10"></td></tr>
</table></td></tr></table>
				</td>
                <td bgcolor="#023761" align="center" width=200><b><font size="1" face="arial" color=#ffffff>Дата</font></b></td>
                <td bgcolor="#023761" align="center" width=200><b><font size="1" face="arial" color=#ffffff>User</font></b></td>
                <td bgcolor="#023761" align="center" width=50><b><font size="1" face="arial" color=#ffffff>Задача</font></b></td>
		<td bgcolor="#023761" align="center" ><b><font size="1" face="arial" color=#ffffff>Цена</font></b></td>
		<td bgcolor="#023761" align="center" ><b><font size="1" face="arial" color=#ffffff>Статус</font></b></td>
		<td width=50 bgcolor="#023761" align="center" ><b><font size="1" face="arial" color=#ffffff></font></b></td>

        </tr>
        <?

        for($i=0; $i<@mysql_num_rows($r); $i++){
        $f=mysql_fetch_array($r);

	echo '<tr  onmouseover="this.style.backgroundColor=\'#ECF7FF\'" onmouseout="this.style.backgroundColor=\'#ffffff\'">
		<td align="center" style="border:1px solid #eeeeee">
			<font size="1" face="arial" color=#023761>'.$f[id].'</font>
		</td>
		<td align="center" style="border:1px solid #eeeeee">
			<font size="1" face="arial" color=#023761>'.$f['date_add'].'</font>
		</td>
		<td align="center" style="border:1px solid #eeeeee">
			<font size="1" face="arial" color=#023761>'.$f['username'].'</font>
		</td>
		<td align="center" style="border:1px solid #eeeeee">
			<font size="1" face="arial" color=#023761>'.$f['name_zadacha'].'</font>
		</td>
		<td align="center" style="border:1px solid #eeeeee">
			<font size="1" face="arial" color=#023761>'.$f['price'].'</font>
		</td>
		<td align="center" style="border:1px solid #eeeeee">
			<font size="1" face="arial" color=#023761>'.$stat[$f['status']].'</font>
		</td>
	        <td align=center style="border:1px solid #eeeeee">
        	   	<a href="orders.php?id='.$f[id].'&del" onClick="if (confirm(\'знищити заказ\')) { this.href+=\'&confirm=1\'; return true; } else return false;"><img border=0 src="images/del.gif"></a>
        	</td></tr>';

        echo '</tr>';}?>
</table>
