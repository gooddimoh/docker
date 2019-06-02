<?
if(isset($_GET[method])){$methodstr=' asc ';}else{$methodstr=' desc ';}

if(isset($_GET[id_p])){$sqlstr=' order by id ';}
else if(isset($_GET[login])){$sqlstr=' order by user ';}
else if(isset($_GET[status])){$sqlstr=' order by status ';}
else {$sqlstr=' order by id ';}

$r = mysql_query("SELECT *, 
                    (SELECT name FROM vivod_types WHERE id = katalog_vivod.type) AS type_name 
                  FROM katalog_vivod ".$sqlstr.$methodstr)or die(mysql_error());//підрозділи теперішнього розділу
?>
<table border="0" width="100%" id="table2" style="border:1px solid #bbbbbb" >
        <tr>
		        <td bgcolor="#023761" align="center" width=30>
<table><tr><td><b><font size="1" face="arial" color=#ffffff>id</font></b>
<td><table border="0" align=left cellpadding=0 cellspacing=0><tr>
	<td><a href="vivod.html?r=<?echo $_GET[r],'&id_p&method';?>"><img border="0" src="images/arrow_blue_up.png" width="10" height="10"></td></tr><tr>
	<td><a href="vivod.html?r=<?echo $_GET[r],'&id_p';?>"><img border="0" src="images/arrow_blue_down.png" width="10" height="10"></td></tr>
</table></td></tr></table>
				</td>
                <td bgcolor="#023761" align="center">
<table><tr><td><b><font size="1" face="arial" color=#ffffff>Користувач</font></b>
<td><table border="0" align=left cellpadding=0 cellspacing=0><tr>
	<td><a href="vivod.html?r=<?echo $_GET[r],'&login&method';?>"><img border="0" src="images/arrow_blue_up.png" width="10" height="10"></td></tr><tr>
	<td><a href="vivod.html?r=<?echo $_GET[r],'&login';?>"><img border="0" src="images/arrow_blue_down.png" width="10" height="10"></td></tr>
</table></td></tr></table>
                </td>
				<td bgcolor="#023761" align="center" ><b><font size="1" face="arial" color=#ffffff>Сума</font></b></td>
				<td bgcolor="#023761" align="center">
<table><tr><td><b><font size="1" face="arial" color=#ffffff>Статус</font></b>
<td><table border="0" align=left cellpadding=0 cellspacing=0><tr>
	<td><a href="vivod.html?r=<?echo $_GET[r],'&status&method';?>"><img border="0" src="images/arrow_blue_up.png" width="10" height="10"></td></tr><tr>
	<td><a href="vivod.html?r=<?echo $_GET[r],'&status';?>"><img border="0" src="images/arrow_blue_down.png" width="10" height="10"></td></tr>
</table></td></tr></table>
                </td>
				<td bgcolor="#023761" align="center" ><b><font size="1" face="arial" color=#ffffff>Тип платежу</font></b></td>
				<td bgcolor="#023761" align="center" ><b><font size="1" face="arial" color=#ffffff>Реквізити</font></b></td>
				<td bgcolor="#023761" align="center" ><b><font size="1" face="arial" color=#ffffff>Коментарій</font></b></td>
				<td bgcolor="#023761" align="center" ><b><font size="1" face="arial" color=#ffffff>Заявка подана</font></b></td>
				<td width=50 bgcolor="#023761" align="center" ><b><font size="1" face="arial" color=#ffffff>пров.</font></b></td>
				<td width=50 bgcolor="#023761" align="center" ><b><font size="1" face="arial" color=#ffffff>відм.</font></b></td>
				<td width=50 bgcolor="#023761" align="center" ><b><font size="1" face="arial" color=#ffffff>зн.</font></b></td>
        </tr>
        <?

        for($i=0; $i<@mysql_num_rows($r); $i++){
        $f=mysql_fetch_array($r);

		$user = mysql_fetch_array(mysql_query("SELECT login FROM katalog_user where id_p='$f[user]'"))or die(mysql_error());//підрозділи теперішнього розділу

		echo '
        <tr  bgcolor="';if($f[status]!=0){echo '#DBF7D5';}else{echo '#ffffff';} echo '">
		<td align="center" style="border:1px solid #eeeeee">
			<font size="1" face="arial" color=#023761>',$f[id],'</font>
		</td>
		<td align="center" style="border:1px solid #eeeeee">
			<font size="1" face="arial" color=#023761>',$user[login],'</font>
		</td>
		<td align="center" style="border:1px solid #eeeeee">
			<font size="1" face="arial" color=#023761>',$f[price],'</font>
		</td>
		<td align="center" style="border:1px solid #eeeeee">
			<font size="1" face="arial" color=#023761>';
			if($f[status]==1){echo 'виконаний';}
			else if($f[status]==2){echo 'не виконаний';}
			else{echo 'новий';}
			echo '</font>
		</td>
		<td align="center" style="border:1px solid #eeeeee">
			<font size="1" face="arial" color=#023761>';
            echo $f[type_name];
            /*
            if($f[type]==-1){echo 'webmoney';}
			else if($f[type]==-3){echo 'на карту';}
			else if($f[type]==-4){echo 'другой';}*/
			echo '</font>
		</td>
		<td align="center" style="border:1px solid #eeeeee">
			<font size="1" face="arial" color=#023761>',$f[rekv],'</font>
		</td>
		<td align="center" style="border:1px solid #eeeeee">
			<font size="1" face="arial" color=#023761>',$f[comerc],'</font>
		</td>
		<td align="center" style="border:1px solid #eeeeee">
			<font size="1" face="arial" color=#023761>',date('d.m.y H:i',$f[data]),'</font>
		</td>
		<td align=center style="border:1px solid #eeeeee">
           	';if($f[status]==0){echo '<a href="vivod_status.php?r=',$f[id],'&ok" onClick="if (confirm(\'підтвердити заявку?\')) { this.href+=\'&confirm=1\'; return true; } else return false;"><img border=0 src="images/ok.png"></a>';}echo '
		</td>
        <td align=center style="border:1px solid #eeeeee">
           		';if($f[status]==0){echo '<a href="vivod_status.php?r=',$f[id],'" onClick="if (confirm(\'відмінити заявку?\')) { this.href+=\'&confirm=1\'; return true; } else return false;"><img border=0 src="images/del.gif"></a>';}echo '
        </td>
        <td align=center style="border:1px solid #eeeeee">
        	<a href="vivod_status.php?r=',$f[id],'&del" onClick="if (confirm(\'знищити заявку?\')) { this.href+=\'&confirm=1\'; return true; } else return false;"><img border=0 src="images/del.gif"></a>
        </td>
        </tr>';}?>
</table>
<p align=center><input type="button" value="Знищити всі заявки" onClick="if (confirm('Знищити всі заявки?')) {location.href='vivod_status.php?alldel';return true; } else return false;"></a>
