<?
if(isset($_GET['status'])&&isset($_GET['mid'])&&(int)$_GET['mid']){
	include "mysql.php";
	$r = mysql_query('UPDATE katalog_metods SET status = '.(int)$_GET['status'].' WHERE id = '.(int)$_GET['mid'].'')or die(mysql_error());
	header('Location: /cms/metods.html');
}
if(isset($_GET['status'])&&isset($_GET['zid'])&&(int)$_GET['zid']){
	include "mysql.php";
	$r = mysql_query('UPDATE katalog_metods_zad SET status = '.(int)$_GET['status'].' WHERE id = '.(int)$_GET['zid'].'')or die(mysql_error());
	header('Location: /cms/metods.html');
}
if(isset($_GET['del'])&&isset($_GET['id'])&&(int)$_GET['id']){
	include "mysql.php";
	$r = mysql_query('DELETE FROM katalog_metods WHERE id = '.(int)$_GET['id'].'')or die(mysql_error());
	$r = mysql_query('DELETE FROM katalog_metods_zad WHERE metod_id = '.(int)$_GET['id'].'')or die(mysql_error());
	header('Location: /cms/metods.html');
}

if(!isset($_GET[method])){$methodstr=' desc ';}else{$methodstr=' asc ';}

if(isset($_GET[id_p])){$sqlstr=' order by id ';}
//else if(isset($_GET[data_create])){$sqlstr=' order by data_create ';}
else {$sqlstr=' order by id ';}

$r = mysql_query("SELECT * FROM katalog_metods ".$sqlstr.$methodstr)or die(mysql_error());//підрозділи теперішнього розділу
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
                <td bgcolor="#023761" align="center" width=200><b><font size="1" face="arial" color=#ffffff>Метод.</font></b></td>
                <td bgcolor="#023761" align="center" width=200><b><font size="1" face="arial" color=#ffffff>ВУЗ</font></b></td>
                <td bgcolor="#023761" align="center" width=50><b><font size="1" face="arial" color=#ffffff>ВУЗ (аббревиатура)</font></b></td>
		<td bgcolor="#023761" align="center" ><b><font size="1" face="arial" color=#ffffff>Добавил пользователь</font></b></td>
		<td bgcolor="#023761" align="center" ><b><font size="1" face="arial" color=#ffffff>Регион</font></b></td>
		<td bgcolor="#023761" align="center" ><b><font size="1" face="arial" color=#ffffff>Название методички</font></b></td>
		<td bgcolor="#023761" align="center" ><b><font size="1" face="arial" color=#ffffff>Скан обложки</font></b></td>
		<td bgcolor="#023761" align="center" ><b><font size="1" face="arial" color=#ffffff>Методичка</font></b></td>
		<td bgcolor="#023761" align="center" ><b><font size="1" face="arial" color=#ffffff>Год издания</font></b></td>
		<td width=50 bgcolor="#023761" align="center" ><b><font size="1" face="arial" color=#ffffff>Опубликовано</font></b></td>
		<td width=50 bgcolor="#023761" align="center" ><b><font size="1" face="arial" color=#ffffff>упр.</font></b></td>
<td width=20px height="25" bgcolor="#365C71" align="center"><span lang="ru">
					<font size="2" face="Arial" color="#FFFFFF">ред.</font></span></td>
		<td width=50 bgcolor="#023761" align="center" ><b><font size="1" face="arial" color=#ffffff></font></b></td>

        </tr>
        <?

$arr = array("Методичка", "Диплом", "Курсовая", "Реферат");
        for($i=0; $i<@mysql_num_rows($r); $i++){
        $f=mysql_fetch_array($r);

        $userin=mysql_fetch_array(mysql_query("select id_p,login from katalog_user where id_p='$f[user_id]' limit 1"));

        $userinblock=mysql_fetch_array(mysql_query("select menu_dozvil from katalog where id='$userin[id_p]' limit 1"));

        $query_zad = mysql_query('SELECT * FROM katalog_metods_zad WHERE metod_id = '.$f['id'].'');

	echo '<tr onmouseover="this.style.backgroundColor=\'#ECF7FF\'" onmouseout="this.style.backgroundColor=\'#ffffff\'">
		<td align="center" style="border:1px solid #eeeeee">'.($f['status']==2?' red ':'').'
			<font size="1" face="arial" color=#023761>'.$f[id].'</font>'.(mysql_num_rows($query_zad)>0?'<a href="javascript:void(0)" onclick="jQuery(this).parent().parent().next().toggle()">+</a>':'').'
		</td>
		<td align="center" style="border:1px solid #eeeeee">
			<font size="1" face="arial" color=#023761>'.$arr[$f['diplom']].'</font>
		</td>
		<td align="center" style="border:1px solid #eeeeee">
			<font size="1" face="arial" color=#023761>'.$f['vuz_name'].'</font>
		</td>
		<td align="center" style="border:1px solid #eeeeee">
			<font size="1" face="arial" color=#023761>'.$f['vuz_short_name'].'</font>
		</td>
		<td align="center" style="border:1px solid #eeeeee">
			<font size="1" face="arial" color=#023761>',$userin[login],'</font>
		</td>
		<td width=10 align="center" style="border:1px solid #eeeeee">'.$f['country'].',&nbsp;'.$f['city'].'</td>
		<td align="center" style="border:1px solid #eeeeee">
			<font size="1" face="arial" color=#023761>'.$f['metod_name'].'</font>
		</td>
		<td style="border:1px solid #eeeeee">
			<font size="1" face="arial" color=#023761><a href="/'.$f['img_name'].'">'.$f['img_name'].'</a></font>
		</td>
		<td style="border:1px solid #eeeeee">
			<font size="1" face="arial" color=#023761><a href="/'.$f['file_name'].'">'.$f['file_name'].'</a></font>
		</td>
		<td align="center" style="border:1px solid #eeeeee">
			<font size="1" face="arial" color=#023761>'.$f['year'].'</font>
		</td>
		<td align=center style="border:1px solid #eeeeee">';
			if($f['status']==1){echo '<img border=0 src="images/ok.png">';}
           	echo '
		</td>
		<td align=center style="border:1px solid #eeeeee">';
			echo '<a href="metods.php?mid='.$f['id'].'&status=1"><img border=0 src="images/bot2.png"></a>&nbsp;<a href="metods.php?mid='.$f['id'].'&status=0"><img border=0 src="images/bot.png"></a>';
           	echo '
		</td><td align=center><a href="/cms/metods_edit.html?mid=',$f[id],'"><img alt=""  src="/images/information.png" border=0></a></td>
        <td align=center style="border:1px solid #eeeeee">
           	<a href="metods.php?id='.$f[id].'&del" onClick="if (confirm(\'знищити методичку\')) { this.href+=\'&confirm=1\'; return true; } else return false;"><img border=0 src="images/del.gif"></a>
        </td></tr>';
	if(mysql_num_rows($query_zad)){
		echo '<tr style="display:none"><td colspan="11"><table><tr><th>id</th><th>Раздел</th><th>Название</th><th>Цена</th><th>скан условия</th><th>решение</th><th>ред.</th><th>Status</th></tr>';
		while($r2 = mysql_fetch_array($query_zad))
			echo '<tr><td>'.$r2['id'].'</td><td>'.$r2['name_razdel'].'</td><td>'.$r2['name_zadacha'].'</td><td>'.$r2['price'].'</td><td><a href="/'.$f['img_name'].'">'.$f['img_name'].'</a></td><td><a href="/'.$f['file_name'].'">'.$f['file_name'].'</a></td>
				<td><a href="/cms/metods_edit.html?zid=',$r2['id'],'"><img alt=""  src="/images/information.png" border=0></a></td>
				<td>'.($r2['status']==1?'<img src="images/ok.png" alt=""/>':'').'</td>
				<td align=center style="border:1px solid #eeeeee">
				<a href="metods.php?zid='.$r2['id'].'&status=1"><img border=0 src="images/bot2.png"></a>&nbsp;<a href="metods.php?zid='.$r2['id'].'&status=2"><img border=0 src="images/bot.png"></a>
           			</td></tr>';
		echo '</table></tr>';
	}



        echo '</tr>';}?>
</table>
