<?
if(!isset($_GET[method])){$methodstr=' desc ';}else{$methodstr=' asc ';}

if(isset($_GET[id_p])){$sqlstr=' order by id ';}
else if(isset($_GET[data_create])){$sqlstr=' order by data_create ';}
else {$sqlstr=' order by id ';}

$r = mysql_query("SELECT * FROM katalog_message ".$sqlstr.$methodstr)or die(mysql_error());//підрозділи теперішнього розділу
?>

<center><input type="button" value="Знищити всі повідомлення" onClick="if (confirm('Знищити всі повідомлення?')) {location.href='messagedel.php?alldel';return true; } else return false;"></center>

<table border="0" width="100%" id="table2" style="border:1px solid #bbbbbb" >
        <tr>
		        <td bgcolor="#023761" align="center" width=30>
<table><tr><td><b><font size="1" face="arial" color=#ffffff>id</font></b>
<td><table border="0" align=left cellpadding=0 cellspacing=0><tr>
	<td><a href="message.html?r=<?echo $_GET[r],'&id_p&method';?>"><img border="0" src="images/arrow_blue_up.png" width="10" height="10"></td></tr><tr>
	<td><a href="message.html?r=<?echo $_GET[r],'&id_p';?>"><img border="0" src="images/arrow_blue_down.png" width="10" height="10"></td></tr>
</table></td></tr></table>
				</td>
                <td bgcolor="#023761" align="center" width=100>
<table><tr><td><b><font size="1" face="arial" color=#ffffff>Дата створення</font></b>
<td><table border="0" align=left cellpadding=0 cellspacing=0><tr>
	<td><a href="message.html?r=<?echo $_GET[r],'&data_create&method';?>"><img border="0" src="images/arrow_blue_up.png" width="10" height="10"></td></tr><tr>
	<td><a href="message.html?r=<?echo $_GET[r],'&data_create';?>"><img border="0" src="images/arrow_blue_down.png" width="10" height="10"></td></tr>
</table></td></tr></table>
                </td>
				<td bgcolor="#023761" align="center" ><b><font size="1" face="arial" color=#ffffff>Від</font></b></td>
				<td bgcolor="#023761" align="center" width=10></td>
				<td bgcolor="#023761" align="center" ><b><font size="1" face="arial" color=#ffffff>Кому</font></b></td>
				<td bgcolor="#023761" align="center" ><b><font size="1" face="arial" color=#ffffff>Текст</font></b></td>
				<td width=50 bgcolor="#023761" align="center" ><b><font size="1" face="arial" color=#ffffff>блок. корист.</font></b></td>
				<td width=50 bgcolor="#023761" align="center" ><b><font size="1" face="arial" color=#ffffff>зн.</font></b></td>
        </tr>
        <?

        for($i=0; $i<@mysql_num_rows($r); $i++){
        $f=mysql_fetch_array($r);

        $userin=mysql_fetch_array(mysql_query("select id_p,login from katalog_user where id_p='$f[user_in]' limit 1"));
        $userout=mysql_fetch_array(mysql_query("select id_p,login from katalog_user where id_p='$f[user_out]' limit 1"));

        $userinblock=mysql_fetch_array(mysql_query("select menu_dozvil from katalog where id='$userin[id_p]' limit 1"));

	echo '<tr  onmouseover="this.style.backgroundColor=\'#ECF7FF\'" onmouseout="this.style.backgroundColor=\'#ffffff\'">
		<td align="center" style="border:1px solid #eeeeee">
			<font size="1" face="arial" color=#023761>',$f[id],'</font>
		</td>
		<td align="center" style="border:1px solid #eeeeee">
			<font size="1" face="arial" color=#023761>',date('d.m.y H:i',$f[data_create]),'</font>
		</td>
		<td align="center" style="border:1px solid #eeeeee">
			<font size="1" face="arial" color=#023761>',$userin[login],'</font>
		</td>
		<td width=10 align="center" style="border:1px solid #eeeeee"><img src="images/arrow_circle.png"></td>
		<td align="center" style="border:1px solid #eeeeee">
			<font size="1" face="arial" color=#023761>',$userout[login],'</font>
		</td>
		<td style="border:1px solid #eeeeee">
			<font size="1" face="arial" color=#023761>',$f[text],'</font>
		</td>
		<td align=center style="border:1px solid #eeeeee">';
			if($userinblock[menu_dozvil]==0){echo '<a href="katalog_dozv.php?r=',$userin[id_p],'"><img border=0 src="images/bot2.png"></a>';}else{echo '<a href="katalog_dozv.php?r=',$userin[id_p],'"><img border=0 src="images/bot.png"></a>';}
           	echo '
		</td>
        <td align=center style="border:1px solid #eeeeee">
           	<a href="messagedel.php?id=',$f[id],'" onClick="if (confirm(\'знищити повідомлення\')) { this.href+=\'&confirm=1\'; return true; } else return false;"><img border=0 src="images/del.gif"></a>
        </td>
        </tr>';}?>
</table>
<p align=center></a>
