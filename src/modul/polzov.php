<?
if($_SESSION[userpolz]=='' or $_SESSION[userid]==''){$_SESSION[userpolz]=20;}
if(!isset($_GET[first])){$_GET[first]=0;}

if(isset($_GET[r])){$searchstr=' and resh=\'1\' ';}
else if(isset($_GET[p])){$searchstr=' and resh=\'0\' ';}
else{
	if(isset($_GET[ser])){$_SESSION[search]=$_POST[search];}
	$_POST[search]=$_SESSION[search];
	$_POST[search]=mysql_escape_string(strip_tags($_POST[search]));
	if($_POST[search]!=''){
	   //$searchstr=' and login like \'%'.$_POST[search].'%\' ';
       if($_POST['search_as'] == 'id')
        $searchstr = ' and id_p = "' . (int)$_POST[search] . '"';
       else
        $searchstr=' and login like \'%'.$_POST[search].'%\' ';
       }
}
if(isset($_GET[method])){$methodstr=' asc ';}else{$methodstr=' desc ';}

$limitstr=' limit '.$_GET[first].','.$_SESSION[userpolz].' ';



if(isset($_GET[resh])){$sqlstr=' order by resh ';}
else if(isset($_GET[name])){$sqlstr=' order by login ';}
else if(isset($_GET[zadach])){$sqlstr=' order by zadach ';}
else if(isset($_GET[dat_reg])){$sqlstr=' order by dat_reg ';}
else if(isset($_GET[dat_enter])){$sqlstr=' order by dat_enter ';}
else {$sqlstr=' order by id_p ';}

if(isset($_GET[first])){$limit="&first=".$_GET[first];}

$allr=mysql_query("select * from katalog_user where id_p in(select id from katalog where menu_dozvil='0' and menu_vizible='0' and page_type='4') ".$searchstr.$sqlstr.$methodstr)or die(mysql_error());
$r=mysql_query("select * from katalog_user where id_p in(select id from katalog where menu_dozvil='0' and menu_vizible='0' and page_type='4') ".$searchstr.$sqlstr.$methodstr.$limitstr)or die(mysql_error());
?>
<form action="k2.html?ser" method=post id="serchform">
<table border="0">
	<tr>
		<td>
            
            <select name="search_as">
                <option value="name">����� �� ����� ������������:</option>
                <option <?php if($_POST['search_as'] == 'id') echo 'selected'; ?> value="id">����� �� ID ������������:</option>
            </select>
        </td>
		<td><input type="text" name="search" size="30" value="<?echo $_POST[search];?>"></td>
		<td><img alt=""  style="cursor:pointer;cursor:hand" border="0" src="images/control_play.png" width="16" height="16" onclick="document.getElementById('serchform').submit();"></td>
		<td><font size="2" face="Arial">�������: <?echo @mysql_num_rows($r);?></font></td>
	</tr>
</table></form>
<table border="0" width="100%" cellspacing="1" cellpadding="0" bgcolor="#cccccc">
	<tr>
		<td height="25" bgcolor="#365C71" align="center"><font size="2" face="Arial" color="#FFFFFF">ID</font></td>
		<td height="25" bgcolor="#365C71" align="center">
<table><tr><td><font size="2" face="Arial" color="#FFFFFF">��� ������������</font>
<td><table border="0" align=left cellpadding=0 cellspacing=0><tr>
	<td><a href="k2.html?name&method<?echo $limit;?>"><img alt=""  border="0" src="images/arrow_blue_up.png" width="10" height="10"></td></tr><tr>
	<td><a href="k2.html?name<?echo $limit;?>"><img alt=""  border="0" src="images/arrow_blue_down.png" width="10" height="10"></td></tr>
</table></td></tr></table>
		<td height="25" bgcolor="#365C71" align="center">
<table><tr><td><font size="2" face="Arial" color="#FFFFFF">������</font>
<td><table border="0" align=left cellpadding=0 cellspacing=0><tr>
	<td><a href="k2.html?resh&method<?echo $limit;?>"><img alt=""  border="0" src="images/arrow_blue_up.png" width="10" height="10"></td></tr><tr>
	<td><a href="k2.html?resh<?echo $limit;?>"><img alt=""  border="0" src="images/arrow_blue_down.png" width="10" height="10"></td></tr>
</table></td></tr></table>
		<td height="25" bgcolor="#365C71" align="center">
<table><tr><td><font size="2" face="Arial" color="#FFFFFF">�������� �����</font>
<td><table border="0" align=left cellpadding=0 cellspacing=0><tr>
	<td><a href="k2.html?zadach&method<?echo $limit;?>"><img alt=""  border="0" src="images/arrow_blue_up.png" width="10" height="10"></td></tr><tr>
	<td><a href="k2.html?zadach<?echo $limit;?>"><img alt=""  border="0" src="images/arrow_blue_down.png" width="10" height="10"></td></tr>
</table></td></tr></table>
		<td height="25" bgcolor="#365C71" align="center">
<table><tr><td><font size="2" face="Arial" color="#FFFFFF">���� �����������</font>
<td><table border="0" align=left cellpadding=0 cellspacing=0><tr>
	<td><a href="k2.html?dat_reg&method<?echo $limit;?>"><img alt=""  border="0" src="images/arrow_blue_up.png" width="10" height="10"></td></tr><tr>
	<td><a href="k2.html?dat_reg<?echo $limit;?>"><img alt=""  border="0" src="images/arrow_blue_down.png" width="10" height="10"></td></tr>
</table></td></tr></table>
		<td height="25" bgcolor="#365C71" align="center">
<table><tr><td><font size="2" face="Arial" color="#FFFFFF">��������� ����������</font>
<td><table border="0" align=left cellpadding=0 cellspacing=0><tr>
	<td><a href="k2.html?dat_enter&method<?echo $limit;?>"><img alt=""  border="0" src="images/arrow_blue_up.png" width="10" height="10"></td></tr><tr>
	<td><a href="k2.html?dat_enter<?echo $limit;?>"><img alt=""  border="0" src="images/arrow_blue_down.png" width="10" height="10"></td></tr>
</table></td></tr></table>
		<td width="20" height="25" bgcolor="#365C71" align="center"></td>
		<td width="20" height="25" bgcolor="#365C71" align="center"></td>
	</tr>
<?
for($i=0;$i<@mysql_num_rows($r);$i++){
	$f=mysql_fetch_array($r);
	echo '<tr bgcolor="#FFFFFF">
		<td align=center><font color="#333333" face="Arial" style="font-size: 11px">',$f[id_p],'</td>
		<td align=center><a href="k77.html?id_user=',$f[id_p],'"  class=blue>',$f[login],'</a></td>
		<td align=center><font color=#00AAD1 face="Arial" style="font-size: 11px">';
		if($f[resh]==1){echo '��������';}else{echo '������������';}echo '</td>
		<td align=center><font color="#333333" face="Arial" style="font-size: 11px">',$f[zadach],'</td>
		<td align=center><font color="#333333" face="Arial" style="font-size: 11px">',date('d/m/y H:i',$f[dat_reg]),'</td>
		<td align=center><font color="#333333" face="Arial" style="font-size: 11px">';if($f[dat_enter]){echo date('d/m/y H:i',$f[dat_enter]);}else{echo '�� ���� ����������';}echo '</td>
		<td width=20 align=center><img alt=""  style="cursor:pointer;cursor:hand" src="images/zadachi/info.png" class=info id="I',$i,'" border=0></td>
		<td width=20 align=center>';
		if($_SESSION[logintrue]==1){
			echo '<a href="k18.html?form=2&id=',$f[id_p],'"><img alt=""  style="cursor:pointer;cursor:hand" src="images/zadachi/message.png" border=0></a>';
		}else{
			echo '<img alt=""  style="cursor:pointer;cursor:hand" src="images/zadachi/no_message.png" border=0>';
		}
		echo '</td>
	</tr>
	<tr bgcolor="#FFFFFF"><td colspan="13" bgcolor="#E3EDF2">
	<div id="DI',$i,'" style="display:none;padding:10px">';
//if($_SESSION[logintrue]){
echo '<font color="#365C71" face="Arial" style="font-size: 11px; font-weight: 700;">��������� ���������� � ������������ ID=',$f[id_p],'</font>
<table border="0" width="100%" cellspacing="0" cellpadding="0">
	<tr>
	<td valign="top"  width=50%><font style="font-size: 8pt" color="#333333" face="Arial">
	<b>������������:</b> ',$f[login],'<br>
	<b><font color=#00AAD1>������:</b> ';if($f[resh]==0){echo '������������';}else{echo '��������';} echo '</font> <br>
	<b>���� �����������:</b> ',date('d/m/y H:i',$f[dat_reg]),'<br>
	<b>��������� ����������: </b>';if($f[dat_enter]){echo date('d/m/y H:i',$f[dat_enter]);}else{echo '�� ���� ����������';}echo '<br>
	<b>���������� ���������� �����:</b> ',$f[zadach_zakaz],'<br>
	<b>�����������:</b> ',$f[coment],'</font>
	</font></td><td valign="top" width=50%>
	<font style="font-size: 8pt" color="#333333" face="Arial">
	<b>�����:</b> ',$f[gorod],'<br>
	<b>����� �����:</b> ',$f[univer],'<br>
	<b>�������:</b> ',$f[dat_birth],'<br>
	<font color=#00AAD1><b>���������� �������� �����:</b> ',$f[zadach],'<br>
	<b>�������� �������:</b> ';
	if($f[rozdil]!='' and $f[resh]==1){
		$rozdil=mysql_query("select page_name,id from katalog where id_p='15'");
		$rozdil_p = explode(",", $f[rozdil]);
		for($z=1;$z<=@mysql_num_rows($rozdil);$z++){
			$rozdilf=mysql_fetch_array($rozdil);
			if(in_array($rozdilf[id],$rozdil_p)){echo $rozdilf[page_name],', ';}
		;}
	}else{
		echo '���';
	} echo '</font><br>
	</td>
	</tr>
</table>';
//}else{echo '<font color="#365C71" face="Arial" style="font-size: 11px; font-weight: 700;">� ��� ������������ ���� ��� ��������� ��������� ���������� � ������������. ����������������� ��� �������� � �������</font>';}
echo '</div></td></tr>';}
?>
</table><center><font size="2" face="Arial">����� ������� <?echo mysql_num_rows($allr)?> ������������, ��������:
<?
for($i=0;$i<ceil(@mysql_num_rows($allr)/$_SESSION[userpolz]);$i++){
	echo '<a href="k2.html?first=',$i*$_SESSION[userpolz],'" class=blue><b>',$i+1,'</b></a>. ';
}
?>


