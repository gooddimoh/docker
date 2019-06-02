<?
if(isset($_GET[method])){$methodstr=' desc ';}else{$methodstr=' asc ';}

if(isset($_GET[id_p])){$sqlstr=' order by id_p ';}
else if(isset($_GET[login])){$sqlstr=' order by login ';}
else {$sqlstr=' order by id_p ';}

$r = mysql_query("SELECT * FROM katalog_user where changing='1' ".$sqlstr.$methodstr)or die(mysql_error());//підрозділи теперішнього розділу
?>
<table border="0" width="100%" id="table2" style="border:1px solid #bbbbbb" >
        <tr>
		        <td bgcolor="#023761" align="center" width=30>
<table><tr><td><b><font size="1" face="arial" color=#ffffff>id</font></b>
<td><table border="0" align=left cellpadding=0 cellspacing=0><tr>
	<td><a href="katalog.html?r=<?echo $_GET[r],'&id_p';?>"><img border="0" src="images/arrow_blue_up.png" width="10" height="10"></td></tr><tr>
	<td><a href="katalog.html?r=<?echo $_GET[r],'&id_p&method';?>"><img border="0" src="images/arrow_blue_down.png" width="10" height="10"></td></tr>
</table></td></tr></table>
				</td>
                <td bgcolor="#023761" align="center">
<table><tr><td><b><font size="1" face="arial" color=#ffffff>Користувачі</font></b>
<td><table border="0" align=left cellpadding=0 cellspacing=0><tr>
	<td><a href="katalog.html?r=<?echo $_GET[r],'&login';?>"><img border="0" src="images/arrow_blue_up.png" width="10" height="10"></td></tr><tr>
	<td><a href="katalog.html?r=<?echo $_GET[r],'&login&method';?>"><img border="0" src="images/arrow_blue_down.png" width="10" height="10"></td></tr>
</table></td></tr></table>
                </td>
				<td bgcolor="#023761" align="center" ><b><font size="1" face="arial" color=#ffffff>Місто</font></b></td>
<td bgcolor="#023761" align="center" ><b><font size="1" face="arial" color=#ffffff>Тел.</font></b></td>
<td bgcolor="#023761" align="center" ><b><font size="1" face="arial" color=#ffffff>E-mail</font></b></td>
<td bgcolor="#023761" align="center" ><b><font size="1" face="arial" color=#ffffff>ICQ</font></b></td>
				<td bgcolor="#023761" align="center" ><b><font size="1" face="arial" color=#ffffff>Освіта</font></b></td>
				<td bgcolor="#023761" align="center" ><b><font size="1" face="arial" color=#ffffff>Вік</font></b></td>
				<td bgcolor="#023761" align="center" ><b><font size="1" face="arial" color=#ffffff>Дата доб.</font></b></td>
				<td bgcolor="#023761" align="center" ><b><font size="1" face="arial" color=#ffffff>Дата зм.</font></b></td>
				<td bgcolor="#023761" align="center" ><b><font size="1" face="arial" color=#ffffff>Розділи</font></b></td>
				<td bgcolor="#023761" align="center" ><b><font size="1" face="arial" color=#ffffff>Додаткова інформація</font></b></td>
				<td width=50 bgcolor="#023761" align="center" ><b><font size="1" face="arial" color=#ffffff>підтв.</font></b></td>
				<td width=50 bgcolor="#023761" align="center" ><b><font size="1" face="arial" color=#ffffff>відм.</font></b></td>
        </tr>
        <?

        for($i=0; $i<@mysql_num_rows($r); $i++){
        $f=mysql_fetch_array($r);
        $rozdil_p = explode(",", $f[rozdil]);

	$rk = mysql_query("SELECT * FROM katalog where id_p='$f[id]'")or die(mysql_error());//підрозділи теперішнього розділу

	echo '
        <tr  onmouseover="this.style.backgroundColor=\'#ECF7FF\'" onmouseout="this.style.backgroundColor=\'#ffffff\'">
		<td align="center" style="border:1px solid #eeeeee">
			<font size="1" face="arial" color=#023761>',$f[id_p],'</font>
		</td>
		<td align="center" style="border:1px solid #eeeeee">
			<font size="1" face="arial" color=#023761>',$f[login],'</font>
		</td>
		<td align="center" style="border:1px solid #eeeeee">
			<font size="1" face="arial" color=#023761>',$f[gorod],'</font>
		</td>
		<td align="center" style="border:1px solid #eeeeee">
			<font size="1" face="arial" color=#023761>',$f[tel],'</font>
		</td>
		<td align="center" style="border:1px solid #eeeeee">
			<font size="1" face="arial" color=#023761>',$f[email],'</font>
		</td>
		<td align="center" style="border:1px solid #eeeeee">
			<font size="1" face="arial" color=#023761>',$f[icq],'</font>
		</td>
		<td align="center" style="border:1px solid #eeeeee">
			<font size="1" face="arial" color=#023761>',$f[univer],'</font>
		</td>
		<td align="center" style="border:1px solid #eeeeee">
			<font size="1" face="arial" color=#023761>',$f[dat_birth],'</font>
		</td>
		<td align="center" style="border:1px solid #eeeeee">
			<font size="1" face="arial" color=#023761>',date('d.m.y H:i',$f[dat_reg]),'</font>
		</td>
		<td align="center" style="border:1px solid #eeeeee">
			<font size="1" face="arial" color=#023761>',date('d.m.y H:i',$f[dat_enter]),'</font>
		</td>
        <td align="left" style="border:1px solid #eeeeee"><font face=arial size=1>';
        for($i=0;$i<count($rozdil_p)-1;$i++){
        	$id=$rozdil_p[$i];
	        $rozdil_name = @mysql_fetch_array(mysql_query("SELECT page_name FROM katalog where id='$rozdil_p[$i]' limit 1"));
	        echo $rozdil_name[page_name],',';
	    }
		echo '</font></td>
		<td align="center" style="border:1px solid #eeeeee">
			<font size="1" face="arial" color=#023761>',$f[add_info],'</font>
		</td>
		<td align=center style="border:1px solid #eeeeee">
           	<a href="zayavka_status.php?r=',$f[id_p],'&ok" onClick="if (confirm(\'підтвердити заявку\')) { this.href+=\'&confirm=1\'; return true; } else return false;"><img border=0 src="images/ok.png"></a>
		</td>
        <td align=center style="border:1px solid #eeeeee">
           	<a href="zayavka_status.php?r=',$f[id_p],'" onClick="if (confirm(\'відмінити заявку\')) { this.href+=\'&confirm=1\'; return true; } else return false;"><img border=0 src="images/del.gif"></a>
        </td>
        </tr>';}?>
</table>
