<?
echo $_POST[filtr];
//if(isset($_POST['searchword']))  $_POST['searchword'] = $_GET['searchword'];
$roz = '';
if(isset($_POST[filtr])){ $roz = " and katalog_user.rozdil like '%".$_POST[filtr]."%' and  katalog_user.rozdil!='' ";$_SESSION[temp_form]=$_GET;}
if(isset($_POST['searchword'])) $roz .= " and ( katalog_user.id_p = ".(int)$_POST['searchword']." OR katalog_user.login LIKE '%".addslashes($_POST['searchword'])."%' OR katalog_user.email LIKE '%".addslashes($_POST['searchword'])."%' )";

if(isset($_GET[method])){$methodstr=' desc ';}else{$methodstr=' asc ';}

if(isset($_GET[id])){$sqlstr=' order by id ';}
else if(isset($_GET[menu_sort])){$sqlstr=' order by menu_sort ';}
else if(isset($_GET[page_name])){$sqlstr=' order by page_name ';}
else if(isset($_GET[menu_dozvil])){$sqlstr=' order by menu_dozvil ';}
else if(isset($_GET[menu_vizible])){$sqlstr=' order by menu_vizible ';}
else {$sqlstr=' order by menu_sort ';}

if($_GET[r]==""){$_GET[r]='0';}
if($_GET[r]==2){	$r = mysql_query("SELECT katalog.*,katalog_user.rozdil,balance,dat_enter,dat_reg,email FROM katalog,katalog_user where katalog.id_p='2' and katalog.id=katalog_user.id_p ".$roz.$sqlstr.$methodstr)or die(mysql_error());//підрозділи теперішнього розділу
}else{	$r = mysql_query("SELECT * FROM katalog where katalog.id_p='$_GET[r]' ".$sqlstr.$methodstr)or die(mysql_error());//підрозділи теперішнього розділу
}

$rp = mysql_query("SELECT * FROM katalog where id='$_GET[r]' limit 1")or die(mysql_error());//підрозділи теперішнього розділу
$fp=mysql_fetch_array($rp);
?>

<a href="katalog.html?r=<?echo $fp[id_p];?>" id=href>назад ‹‹</a>
<b><font size="2" face="arial" color=#023761>| <?if($fp[page_name]!=''){echo $fp[page_name];}else{echo "Корінь сайту";}?> |</font></b>
<a href="katalog_add.html?r=<?echo $_GET[r];?>" id=href>›› додати сторінку</a><p>

<?if($_GET[r]==2){echo '<form method="POST" action="',$_SERVER['REQUEST_URI'],'">
	<p><select size="1" name="filtr"><option value="">Все дисциплины</option>';
	$rozdil=mysql_query("select page_name,id from katalog where id_p='15' order by page_name asc ");
	for($j=1;$j<=@mysql_num_rows($rozdil);$j++){
		$rozdilf=mysql_fetch_array($rozdil);
		echo '<option value="',$rozdilf[id],'">',$rozdilf[page_name],'</option>';
	}
	echo '</select><input type="submit" value="фільтр" name="B1">
		<span style="margin-left:50px">&nbsp;</span><input type="text" value="" name="searchword"/><input type="submit" value="пошук" name="B1">
		<span style="margin-left:50px">&nbsp;</span><a href="/cms/katalog_send_mail.html">Написати листа</a>
</form><p>';}?>

<table border="0" width="100%" id="table2" style="border:1px solid #bbbbbb" >
        <tr>
		        <td bgcolor="#023761" align="center" width=30>
<table><tr><td><b><font size="1" face="arial" color=#ffffff>id</font></b>
<td><table border="0" align=left cellpadding=0 cellspacing=0><tr>
	<td><a href="katalog.html?r=<?echo $_GET[r],'&id';?>"><img border="0" src="images/arrow_blue_up.png" width="10" height="10"></td></tr><tr>
	<td><a href="katalog.html?r=<?echo $_GET[r],'&id&method';?>"><img border="0" src="images/arrow_blue_down.png" width="10" height="10"></td></tr>
</table></td></tr></table>
				</td>
                <td bgcolor="#023761" align="center" width=30>
<table><tr><td><b><font size="1" face="arial" color=#ffffff>сорт.</font></b>
<td><table border="0" align=left cellpadding=0 cellspacing=0><tr>
	<td><a href="katalog.html?r=<?echo $_GET[r],'&menu_sort';?>"><img border="0" src="images/arrow_blue_up.png" width="10" height="10"></td></tr><tr>
	<td><a href="katalog.html?r=<?echo $_GET[r],'&menu_sort&method';?>"><img border="0" src="images/arrow_blue_down.png" width="10" height="10"></td></tr>
</table></td></tr></table>
                </td>
                <td bgcolor="#023761" align="center">
<table><tr><td><b><font size="1" face="arial" color=#ffffff>Назви сторінок</font></b>
<td><table border="0" align=left cellpadding=0 cellspacing=0><tr>
	<td><a href="katalog.html?r=<?echo $_GET[r],'&page_name';?>"><img border="0" src="images/arrow_blue_up.png" width="10" height="10"></td></tr><tr>
	<td><a href="katalog.html?r=<?echo $_GET[r],'&page_name&method';?>"><img border="0" src="images/arrow_blue_down.png" width="10" height="10"></td></tr>
</table></td></tr></table>
                </td>
                <td bgcolor="#023761" align="center" width=50><b><font size="1" face="arial" color=#ffffff>характеристики</font></b></td>
				<td bgcolor="#023761" align="center" width=50><b><font size="1" face="arial" color=#ffffff>кіл. стор.</font></b></td>
				<td bgcolor="#023761" align="center" width=50>
<table><tr><td><b><font size="1" face="arial" color=#ffffff>меню</font></b>
<td><table border="0" align=left cellpadding=0 cellspacing=0><tr>
	<td><a href="katalog.html?r=<?echo $_GET[r],'&menu_vizible';?>"><img border="0" src="images/arrow_blue_up.png" width="10" height="10"></td></tr><tr>
	<td><a href="katalog.html?r=<?echo $_GET[r],'&menu_vizible&method';?>"><img border="0" src="images/arrow_blue_down.png" width="10" height="10"></td></tr>
</table></td></tr></table>
				</td>
                <td bgcolor="#023761" align="center" width=70>
<table><tr><td><b><font size="1" face="arial" color=#ffffff>активність</font></b>
<td><table border="0" align=left cellpadding=0 cellspacing=0><tr>
	<td><a href="katalog.html?r=<?echo $_GET[r],'&menu_dozvil';?>"><img border="0" src="images/arrow_blue_up.png" width="10" height="10"></td></tr><tr>
	<td><a href="katalog.html?r=<?echo $_GET[r],'&menu_dozvil&method';?>"><img border="0" src="images/arrow_blue_down.png" width="10" height="10"></td></tr>
</table></td></tr></table>
				</td>
                <td bgcolor="#023761" align="center" width=30><b><font size="1" face="arial" color=#ffffff>IP</font></b></td>
                <td bgcolor="#023761" align="center" width=30><b><font size="1" face="arial" color=#ffffff>редаг.</font></b></td>
                <td bgcolor="#023761"  align="center" width=30><b><font size="1" face="arial" color=#ffffff>знищ.</font></b></td>

        </tr>
        <?

        for($i=0; $i<@mysql_num_rows($r); $i++){
        $f=mysql_fetch_array($r);

	$rk = mysql_query("SELECT * FROM katalog where id_p='$f[id]'")or die(mysql_error());//підрозділи теперішнього розділу

	echo '
        <tr  onmouseover="this.style.backgroundColor=\'#ECF7FF\'" onmouseout="this.style.backgroundColor=\'#ffffff\'">
		<td align="center" style="border:1px solid #eeeeee">
			<font size="2" face="arial" color=#023761>',$f[id],'</font>
		</td>
		<td align="center" style="border:1px solid #eeeeee">
			<font size="2" face="arial" color=#023761>',$f[menu_sort],'</font>
		</td>
        	<td align="left" style="border:1px solid #eeeeee">
			<b><a id=href href="katalog.html?r=',$f[id],'">',$f[page_name],'</a></b>';
			if($f[page_type]==4){echo '<br><font style="font-size:11px">',$f[email],'</font>';}echo '</font></td>
		<td style="border:1px solid #eeeeee" align=left>';
		if($f[page_type]==4){
				echo '<table><tr><td width=70><font size=1>',$f[balance],' RUR</td><td width=70><font size=1>др. ',date('d.m.y',$f[dat_reg]),'</td><td width=70><font size=1 ';if($f[dat_enter]==0){echo 'color="red"';}echo '>';if($f[dat_enter]==0){echo 'не входив';}else{echo 'вх. ',date('d.m.y',$f[dat_enter]);}echo '</td><td><font size=1>';
				$rozdil=mysql_query("select page_name,id from katalog where id_p='15'");
				$rozdil_p = explode(",", $f[rozdil]);
				for($j=1;$j<=@mysql_num_rows($rozdil);$j++){
					$rozdilf=mysql_fetch_array($rozdil);
					if(in_array($rozdilf[id],$rozdil_p)){echo $rozdilf[page_name],', ';}
				;}
				echo '</td></tr></table>';}
		echo '</td>
		<td align="center" style="border:1px solid #eeeeee">
			<font size="2" face="arial" color=#023761>',mysql_num_rows($rk),'</font>
		</td>
		<td align=center style="border:1px solid #eeeeee">';
			if($f[menu_vizible]==0){echo '<a href="katalog_vizible.php?r=',$f[id],'"><img border=0 src="images/bot2.png"></a>';}else{echo '<a href="katalog_vizible.php?r=',$f[id],'"><img border=0 src="images/bot.png"></a>';}
			echo '
		</td>
		<td align=center style="border:1px solid #eeeeee">';
			if($f[menu_dozvil]==0){echo '<a href="katalog_dozv.php?r=',$f[id],'"><img border=0 src="images/bot2.png"></a>';}else{echo '<a href="katalog_dozv.php?r=',$f[id],'"><img border=0 src="images/bot.png"></a>';}
			echo '
		</td>
	    <td align="center" style="border:1px solid #eeeeee">
        	<a href="katalog_user_IP.html?id_p=',$f[id],'">IP</a>
		</td>
	    <td align="center" style="border:1px solid #eeeeee">
        	<a href="katalog_redag.html?r=',$f[id],'"><img border=0 src="images/edit_k.jpg" alt="редактор"></a>
		</td>
                <td align=center style="border:1px solid #eeeeee">';
                	if(@mysql_num_rows($rk)==0 and @mysql_num_rows($rr)==0){echo '<a href="katalog_del.php?r=',$f[id],'" onClick="if (confirm(\'підтвердити знищиння\')) { this.href+=\'&confirm=1\'; return true; } else return false;"><img border=0 src="images/del.gif"></a>';}
                	echo '
                </td>
        </tr>';}?>
</table>
