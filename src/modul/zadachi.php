<?

if(isset($_GET[s])){$_SESSION[status]=1;}
else if(isset($_GET[r])){$_SESSION[status]=3;}
else if(isset($_GET[rr])){$_SESSION[status]=4;}
else if(isset($_GET[my])){$_SESSION[status]=9;}

if(isset($_GET[ser])){$_SESSION[status]=$_POST[status];$_SESSION[razdel]=$_POST[razdel];}
if (empty($_GET[id_from_usr])) $_POST[status]=$_SESSION[status];
$_POST[razdel]=$_SESSION[razdel];

if($_SESSION[userid]==''){$_SESSION[userid]=0;}
if($_SESSION[userzadach]=='' or $_SESSION[userid]==0){$_SESSION[userzadach]=20;}
if(!isset($_GET[first])){$_GET[first]=0;}

if(isset($_GET[id_from_usr]))
{
    switch ($_GET[sts]) {
    case 1:
        $searchstr=' and (userzakaz='.$_GET[id_from_usr].')';
        break;
    case 2:
        $searchstr=' and (userresh='.$_GET[id_from_usr].') ';
        break;
    }
}

if($_POST[status]==1){$searchstr=' and (status=\'1\' or  status=\'2\') and userzakaz<>'.$_SESSION[userid].' and end_time>'.time().' ';}
if($_POST[status]==3){$searchstr=' and status=\'3\' and userzakaz<>'.$_SESSION[userid].' and end_time>'.time().' ';}
if($_POST[status]==4){$searchstr=' and (status=\'4\' or  status=\'5\') and userzakaz<>'.$_SESSION[userid].' ';}
if($_POST[status]==9){$searchstr=' and (userzakaz='.$_SESSION[userid].' or userresh='.$_SESSION[userid].') ';}
if($_POST[status]==5 && (int)$_POST[id_p]){$searchstr=' and id_p= ' . (int)$_POST[id_p];}

if($_POST[razdel]!=0){$searchstr.=' and razdel='.$_POST[razdel].' ';}

if(isset($_GET[method])){$methodstr=' asc ';}else{$methodstr=' desc ';}

$limitstr=' limit '.$_GET[first].','.$_SESSION[userzadach].' ';

if(isset($_GET[status])){$sqlstr=' order by status ';}
else if(isset($_GET[price])){$sqlstr=' order by price ';}
else if(isset($_GET[id])){$sqlstr=' order by id_p ';}
else if(isset($_GET[end_time])){$sqlstr=' order by end_time ';}
else {$sqlstr=' order by id_p ';}

if(isset($_GET[first])){$limit="&first=".$_GET[first];}
$all_qty = (int) end(mysql_fetch_row(mysql_query("select COUNT(*) from katalog_zadach where id_p ".$searchstr.$sqlstr.$methodstr)));
$r=mysql_query("select * from katalog_zadach where id_p ".$searchstr.$sqlstr.$methodstr.$limitstr)or die(mysql_error());
?>

<script>
$(document).ready(function(){
    
    $('#select-status').change();
    
});
</script>

<form method="POST" action="k6.html?ser" id="format">
	<table border="0" cellpadding="5">
		<tr>
			<td><font size="2" face="Arial">��� �����:</font></td>
			<td><select size="1" name="status" id="select-status" onchange="$('[data-search-type]').hide(); $('[data-search-type*='+this.value+']').show();">
					<option value="0">���</option>
					<option value="9" <?if($_POST[status]==9){echo 'selected';}?>>������ ���</option>
					<option value="1" <?if($_POST[status]==1){echo 'selected';}?>>���������</option>
	 				<option value="3" <?if($_POST[status]==3){echo 'selected';}?>>��������</option>
					<option value="4" <?if($_POST[status]==4){echo 'selected';}?>>��������</option>
                    <option value="5" <?if($_POST[status]==5){echo 'selected';}?>>����� �� ID</option>
				</select></td>
            <td data-search-type="5" style="display: none;"><font size="2" face="Arial">ID:</font></td>
            <td data-search-type="5" style="display: none;"><input type="text" value="<?php echo $_POST[id_p]; ?>" name="id_p" /></td>
			<td data-search-type="0,9,1,3,4" style="display: none;"><font size="2" face="Arial">������:</font></td>
			<td data-search-type="0,9,1,3,4" style="display: none;"><select size="1" name="razdel">
			<option value="0">���</option><?
$z=mysql_query("select * from katalog where id_p='15' and page_type='1' and menu_vizible='0' and menu_dozvil='0' order by page_name, menu_sort asc");
for($i=0;$i<@mysql_num_rows($z);$i++){
	$zf=mysql_fetch_array($z);
	echo '<option value=',$zf[id],' ';if($zf[id]==$_POST[razdel]){echo 'selected';}echo '>',$zf[page_name],'</option>';
}?></select></td>
			<td bgcolor="#FFFFFF"><a href="#" class=blue onclick="document.getElementById('format').submit();">��������� ������</a></td>
		</tr>
	</table>
</form>
<table class="zadachiTable" border="0" width="100%" cellspacing="1" cellpadding="0" bgcolor="#cccccc">
	<tr>
		<td height="25" width="20" bgcolor="#365C71" align="center">
<table border="0" align=center cellpadding=0 cellspacing=0><tr>
	<td><a href="k6.html?status&method<?echo $limit;?>"><img alt=""  border="0" src="images/arrow_blue_up.png" width="10" height="10"></td></tr><tr>
	<td><a href="k6.html?status<?echo $limit;?>"><img alt=""  border="0" src="images/arrow_blue_down.png" width="10" height="10"></td></tr>
</table></td>
		<td height="25" bgcolor="#365C71" align="center">
		<table><tr><td><font size="1" face="Arial" color="#FFFFFF">ID</font>
<td><table border="0" align=left cellpadding=0 cellspacing=0><tr>
	<td><a href="k6.html?id&method<?echo $limit;?>"><img alt=""  border="0" src="images/arrow_blue_up.png" width="10" height="10"></td></tr><tr>
	<td><a href="k6.html?id<?echo $limit;?>"><img alt=""  border="0" src="images/arrow_blue_down.png" width="10" height="10"></td></tr>
</table></td></tr></table></td>
		<td height="25" bgcolor="#365C71" align="center"><span lang="ru">
		<font size="1" face="Arial" color="#FFFFFF">�������</font></span></td>
		<td height="25" bgcolor="#365C71" align="center"><span lang="ru">
		<font size="1" face="Arial" color="#FFFFFF">�������</font></span></td>
		<td height="25" bgcolor="#365C71" align="center"><span lang="ru">
		<font size="1" face="Arial" color="#FFFFFF">��������</font></span></td>
		<td height="25" bgcolor="#365C71" align="center"><span lang="ru">
		<font size="1" face="Arial" color="#FFFFFF">��������</font></span></td>
		<td height="25" bgcolor="#365C71" align="center"><table><tr><td><font size="1" face="Arial" color="#FFFFFF">������</font>
<td><table border="0" align=left cellpadding=0 cellspacing=0><tr>
	<td><a href="k6.html?status&method<?echo $limit;?>"><img alt=""  border="0" src="images/arrow_blue_up.png" width="10" height="10"></td></tr><tr>
	<td><a href="k6.html?status<?echo $limit;?>"><img alt=""  border="0" src="images/arrow_blue_down.png" width="10" height="10"></td></tr>
</table></td></tr></table>
		</td>
		<td height="25" bgcolor="#365C71" align="center"><table><tr><td><font size="1" face="Arial" color="#FFFFFF">����</font>
<td><table border="0" align=left cellpadding=0 cellspacing=0><tr>
	<td><a href="k6.html?price&method<?echo $limit;?>"><img alt=""  border="0" src="images/arrow_blue_up.png" width="10" height="10"></td></tr><tr>
	<td><a href="k6.html?price<?echo $limit;?>"><img alt=""  border="0" src="images/arrow_blue_down.png" width="10" height="10"></td></tr>
</table></td></tr></table>
		</td>
		<td height="25" bgcolor="#365C71" align="center"><table><tr><td><font size="1" face="Arial" color="#FFFFFF">���� �������</font>
<td><table border="0" align=left cellpadding=0 cellspacing=0><tr>
	<td><a href="k6.html?end_time&method<?echo $limit;?>"><img alt=""  border="0" src="images/arrow_blue_up.png" width="10" height="10"></td></tr><tr>
	<td><a href="k6.html?end_time<?echo $limit;?>"><img alt=""  border="0" src="images/arrow_blue_down.png" width="10" height="10"></td></tr>
</table></td></tr></table>
		</td>
		<td height="25" bgcolor="#365C71" align="center">
		<font size="1" face="Arial" color="#FFFFFF">������</font></td>
		<td height="25" bgcolor="#365C71" align="center">
		<font size="1" face="Arial" color="#FFFFFF">���������</font></td>
		<td width=20px height="25" bgcolor="#365C71" align="center" style="padding: 0 5px;">
		<font size="1" face="Arial" color="#FFFFFF">����</font></td>
		<td width=20px height="25" bgcolor="#365C71" align="center" style="padding: 0 3px;">
		<font size="1" face="Arial" color="#FFFFFF">������</font></td>
	</tr>
    

<?
for($i=1;$i<=@mysql_num_rows($r);$i++){
	$f=mysql_fetch_array($r);
	$user=mysql_fetch_array(mysql_query("select login from katalog_user where id_p='$f[userzakaz]' limit 1"));
	$razdel=mysql_fetch_array(mysql_query("select id,page_name from katalog where id='$f[razdel]' limit 1"));
	$podrazdel=mysql_fetch_array(mysql_query("select id,page_name from katalog where id='$f[podrazdel]' limit 1"));
	echo '<tr bgcolor="';if($f[status]==5 or $f[status]==4){echo '#DBF7D5';}else{if($f[end_time]<time()){echo '#FFEAEA';}else{if($_SESSION[userid]==$f[userzakaz]){echo '#E3EDF2';}else{echo '#FFFFFF';}}} echo '">
		<td width=20px align=center>';
if($f[end_time]>time()){ // ----------------------------- �� ��� ������
if($_SESSION[userid]!=$f[userzakaz]){
           
            $buf_logins = mysql_query('SELECT u.login as login,
                                              u.id_p as id  
                    FROM katalog as c
                    LEFT JOIN katalog_zayava as k ON k.id_p = c.id
                    LEFT JOIN katalog_user as u On u.id_p = k.userresh
                    WHERE c.id_p='.$f[id_p]);
            $resh = false;
            while ($buf = mysql_fetch_array($buf_logins))
            {
                if ($buf[id] == $_SESSION[userid]) $resh = true;
                $buf_logins_r[] = $buf;
            }
	if($_SESSION[userresh]==1){// -----------------------�������
		if($f[status]==1){  // -----------------------------------���� ������, ����� �������� ������
		echo '<ul class="menu',$i,'">
		<li><a href="#" title="����� �����. ��������, ����� �������� ������ �� �������"><img alt=""  src="images/zadachi/new.png" border=0></a>
			<ul id="menustyle">
				<li onclick="window.location=\'k95.html?id=',$f[id_p],'&st=4\'"><a href="#"><img alt=""  class="pic" src="images/zadachi/add.png" border=0>�������� ������</a></li>
				<li class="disabled"><a href="#"><img alt=""  class="pic" src="images/zadachi/minus.png" border=0>����������</a></li>
				<li class="disabled"><a href="#"><img alt=""  class="pic" src="images/zadachi/upload.png" border=0>��������� �������</a></li>
			</ul>
		</li>
		</ul>';
		}else if($f[status]==2){  // ---------------------������ �� �������� ��� �����, ����� �������� ���� ������
		echo '<ul class="menu',$i,'">
		<li><a href="#" title="����� ����������. ��������, ����� �������� ������ �� �������"><img alt=""  src="images/zadachi/eye.png" border=0></a>
			<ul id="menustyle">
				<li onclick="window.location=\'k95.html?id=',$f[id_p],'&st=4\'"><a href="#"><img alt=""  class="pic" src="images/zadachi/add.png" border=0>�������� ������</a></li>';
                $logins=mysql_query("select id_p from katalog_zayava where userresh='$_SESSION[userid]' and id_p in(select id from katalog where id_p='$f[id_p]')");
        		if(@mysql_num_rows($logins)!=0){
					echo '<li onclick="window.location=\'modul/status.php?id=',$f[id_p],'&st=1\'"><a href="#"><img alt=""  class="pic" src="images/zadachi/minus.png" border=0>����������</a></li>';
				}else{
					echo '<li class="disabled"><a href="#"><img alt=""  class="pic" src="images/zadachi/minus.png" border=0>����������</a></li>';
				}
				echo '<li class="disabled"><a href="#"><img alt=""  class="pic" src="images/zadachi/upload.png" border=0>��������� �������</a></li>
			</ul>
		</li>
		</ul>';
		}else if($f[status]==3){  // ------------------------����� ����������, ������� ��������, �������� ���� �� ������
		echo '<ul class="menu',$i,'">
		<li><a href="#" title="'.($f[userresh]==$_SESSION[userid] ? '��������, ����� ��������� ������� ������' : '����� ��������� �� ���������� ��������').'"><img alt=""  src="images/zadachi/ok.png" border=0></a>
			<ul id="menustyle">
				<li class="disabled"><a href="#"><img alt=""  class="pic" src="images/zadachi/add.png" border=0>�������� ������</a></li>
				<li class="disabled"><a href="#"><img alt=""  class="pic" src="images/zadachi/minus.png" border=0>����������</a></li>';
				if($f[userresh]==$_SESSION[userid]){ // ���� ���������� ������ �����������
					echo '<li onclick="window.location=\'k95.html?id=',$f[id_p],'&st=5\'"><a href="#"><img alt=""  class="pic" src="images/zadachi/upload.png" border=0>��������� �������</a></li>';
				}else{
					echo '<li class="disabled"><a href="#"><img alt=""  class="pic" src="images/zadachi/upload.png" border=0>��������� �������</a></li>';
				}
			echo '</ul>
		</li>
		</ul>';
		}else if($f[status]==4){ //----------------------------- ������ �����������, ��������� ������ �������
		echo '<ul class="menu',$i,'">
		<li><a href="#" title="����� ��������"><img alt=""  src="images/zadachi/upload.png" border=0></a>
			<ul id="menustyle">
				<li class="disabled"><a href="#"><img alt=""  class="pic" src="images/zadachi/add.png" border=0>�������� ������</a></li>
				<li class="disabled"><a href="#"><img alt=""  class="pic" src="images/zadachi/minus.png" border=0>����������</a></li>
				<li class="disabled"><a href="#"><img alt=""  class="pic" src="images/zadachi/upload.png" border=0>��������� �������</a></li>
			</ul>
		</li>
		</ul>';
		}else if($f[status]==5){ // ----------------------------���������� �������, ������ ��������
		echo '<ul class="menu',$i,'">
		<li><a href="#" title="����� ��������"><img alt=""  src="images/zadachi/done.png" border=0></a>
			<ul id="menustyle">
				<li class="disabled"><a href="#"><img alt=""  class="pic" src="images/zadachi/add.png" border=0>�������� ������</a></li>
				<li class="disabled"><a href="#"><img alt=""  class="pic" src="images/zadachi/minus.png" border=0>����������</a></li>
				<li class="disabled"><a href="#"><img alt=""  class="pic" src="images/zadachi/upload.png" border=0>��������� �������</a></li>
			</ul>
		</li>
		</ul>';
		}
	}else{ // -------------------------------------------------�������� ������ � ���
		echo '<a href="#" title="������ ����������"><img alt=""  src="images/zadachi/del.png" border=0></a>';
	}
}else{// ---------------------------------------------------��������
	if($f[status]==1){  // -------------------------------- ���� ������, ������� ������ , ���������� ��������, ����������
	echo '<ul class="menu',$i,'">
	<li><a href="#" title="����� �����"><img alt=""  src="images/zadachi/new.png" border=0></a>
		<ul id="menustyle">
			<li onclick="window.location=\'k95.html?id=',$f[id_p],'&st=7\'"><a href="#"><img alt=""  class="pic" src="images/zadachi/edit.png" border=0>�������������</a></li>
			<li class="disabled"><a href="#"><img alt=""  class="pic" src="images/zadachi/user.png" border=0>������� ���������</li>
			<li class="disabled"><a href="#"><img alt=""  class="pic" src="images/zadachi/cash.png" border=0>�������� �������</li>
			<li onclick="window.location=\'modul/status.php?id=',$f[id_p],'&st=3\'"><a href="#"><img alt=""  class="pic" src="images/zadachi/close.png" border=0>������� \ ����������</a></li>
		</ul>
	</li>
	</ul>';
	}
	else if($f[status]==2){ // --------------------------����� ������ �� ��������, ������� ������� ��������� ��� ����������
       echo '<ul class="menu',$i,'">
	<li><a href="#" title="����� ����������"><img alt=""  src="images/zadachi/eye.png" border=0></a>
		<ul id="menustyle">
			<li class="disabled"><a href="#"><img alt=""  class="pic" src="images/zadachi/edit.png" border=0>�������������</li>
			<li onclick="window.location=\'k95.html?id=',$f[id_p],'&st=6\'"><a href="#"><img alt=""  class="pic" src="images/zadachi/user.png" border=0>������� ���������</a></li>
			<li class="disabled"><a href="#"><img alt=""  class="pic" src="images/zadachi/upload.png" border=0>��������� �������</li>
			<li class="disabled"><a href="#"><img alt=""  class="pic" src="images/zadachi/cash.png" border=0>�������� �������</li>
			<li onclick="window.location=\'modul/status.php?id=',$f[id_p],'&st=3\'"><a href="#"><img alt=""  class="pic" src="images/zadachi/close.png" border=0>������� \ ����������</a></li>
		</ul>
	</li>
	</ul>';
	}
	else if($f[status]==3){ // -------------------------- ���������� �� ��������
       echo '<ul class="menu',$i,'">
	<li><a href="#" title="����� ��������� �� ���������� ��������"><img alt=""  src="images/zadachi/ok.png" border=0></a>
		<ul id="menustyle">
			<li class="disabled"><a href="#"><img alt=""  class="pic" src="images/zadachi/edit.png" border=0>�������������</li>
			<li class="disabled"><a href="#"><img alt=""  class="pic" src="images/zadachi/user.png" border=0>������� ���������</a></li>
			<li class="disabled"><a href="#"><img alt=""  class="pic" src="images/zadachi/cash.png" border=0>�������� �������</li>
			<li class="disabled"><a href="#"><img alt=""  class="pic" src="images/zadachi/close.png" border=0>������� \ ����������</a></li>
		</ul>
	</li>
	</ul>';
	}
	else if($f[status]==4){ // -------------------------- ������ ����������� � ����� �� ������
       echo '<ul class="menu',$i,'">
	<li><a href="#" title="����� ��������"><img alt=""  src="images/zadachi/upload.png" border=0></a>
		<ul id="menustyle">
			<li class="disabled"><a href="#"><img alt=""  class="pic" src="images/zadachi/edit.png" border=0>�������������</li>
			<li class="disabled"><a href="#"><img alt=""  class="pic" src="images/zadachi/user.png" border=0>������� ���������</a></li>
			<li onclick="window.location=\'modul/status.php?id=',$f[id_p],'&st=2\'"><a href="#"><img alt=""  class="pic" src="images/zadachi/cash.png" border=0>�������� �������</li>
			<li class="disabled"><a href="#"><img alt=""  class="pic" src="images/zadachi/close.png" border=0>������� \ ����������</a></li>
		</ul>
	</li>
	</ul>';
	}
	else if($f[status]==5){ // ------------------------- ���������� ��������
	echo '<ul class="menu',$i,'">
	<li><a href="#" title="����� �������"><img alt=""  src="images/zadachi/done.png" border=0></a>
		<ul id="menustyle">
			<li class="disabled"><a href="#"><img alt=""  class="pic" src="images/zadachi/edit.png" border=0>�������������</li>
			<li class="disabled"><a href="#"><img alt=""  class="pic" src="images/zadachi/user.png" border=0>������� ���������</a></li>
			<li class="disabled"><a href="#"><img alt=""  class="pic" src="images/zadachi/cash.png" border=0>�������� �������</li>
			<li class="disabled"><a href="#"><img alt=""  class="pic" src="images/zadachi/close.png" border=0>������� \ ����������</a></li>
		</ul>
	</li>
	</ul>';
	}
}
}else{ // -------------------------- ��� ������
	if($_SESSION[userid]!=$f[userzakaz]){ // -------------------------- ���� ���� �������� �� ������ �����������
		echo '<a href="#" title="����� ������, ����� �����"><img alt=""  src="images/zadachi/del.png" border=0></a>';
	}else if($f[status]!=5){ // --------------------------------------------- ���� �������� �� �������
		echo '<ul class="menu',$i,'">
		<li><a href="#" title="�������� �����"><img alt=""  src="images/zadachi/clock.png" border=0></a>
			<ul id="menustyle">
				<li onclick="window.location=\'k95.html?id=',$f[id_p],'&st=7\'"><a href="#"><img alt=""  class="pic" src="images/zadachi/clock.png" border=0>��������</a></li>
			</ul>
		</li>
		</ul>';
	}else{ // --------------------------------------------------------------- ���� �������� �������
		echo '<a href="#" title="����� �������"><img alt=""  src="images/zadachi/done.png" border=0></a>';
	}
}
echo '
</td>
		<td align=center><font color="#333333" face="Arial" style="font-size: 11px"><abbr title="ID ������">',$f[id_p],'</td>
		<td align=center><a class="zadachi blue" title="��������, ����� ������� ������� ������" href="modul/download.php?id=',$f[id_p],'&u" target="_blank">������� <span class="arrow"></span> </a></td>
		<td align=center>';
		if($f[status]>4){echo '<a class="zadachi" title="��������, ����� ������� ������� ������" href="modul/download.php?id=',$f[id_p],'&r" target="_blank">�������</a>';}
		else if($f[status]==4){echo '<font color="#333333" face="Arial" style="font-size: 11px">������ �� �� ��������</a>';}
		else{echo '<font color="#333333" face="Arial" style="font-size: 11px"><abbr title="������ ��� �� ������">�� ������</a>';}
		echo '</td>
		<td align=center><a onmousemove="usr_vis('.$i.',2);" onmouseout="noShow()" class="blue" href="k77.html?id_user=',$f[userzakaz],'">',$user[login],'</a>';
       
        echo <<<_USERINFO
 <div onmouseout="usr_hide($i,2)" class="usr_info" id="userinfo2_$i"> 
  <a onmousemove="clearTimeout(tmr);" href="k77.html?id_user=$f[userzakaz]"  class="profile">������� ($user[login])</a><br />
_USERINFO;

		if($_SESSION['logintrue']==1){
			echo '<a style="background: url(/images/zadachi/mail.png) no-repeat;" class="thickbox" onmousemove="clearTimeout(tmr);" href="/modul/messagea.php?form=2&noerr&id=',$f[userzakaz],'&TB_iframe=true&modal=false&height=281&width=500" title="">�������� ������</a>';
            echo '<br /><a onmousemove="clearTimeout(tmr);" href="k19.html?usr_id='.$f[userzakaz].'" class="money">��������� ������</a>';
            echo '<br /><a onmousemove="clearTimeout(tmr);" href="k12-otzivi_o_proekte_reshenie_zadach.html?usr_id='.$f[userzakaz].'" class="otzyv">�������� �����</a>';
    } else 
    echo '  <span onmousemove="clearTimeout(tmr);" style="color:gray;">�������� ������ <br />
  ��������� ������ <br />
  �������� �����</span>';
  
    echo '</div></td>';
        echo '
        <td align=center><font color="#333333" face="Arial" style="font-size: 11px">';
        $login=@mysql_fetch_array(mysql_query("select id_p,login from katalog_user where id_p in(select userresh from katalog_zadach where id_p='$f[id_p]')"));
                    
       // $logins=mysql_query("select login from katalog_user where id_p in(select userresh from katalog_zayava where id_p in(select id from katalog where id_p='$f[id_p]'))");
        if($f[status]<3){
        	echo '-';
        }else{
        	echo '<a onmousemove="usr_vis('.$i.',1);" onmouseout="noShow()" href="k77.html?id_user='.$login[id_p].'"  class=blue>'.$login[login].'</a>';
        echo <<<_USERINFO
 <div onmouseout="usr_hide($i,1)" class="usr_info" id="userinfo1_$i"> 
  <a onmousemove="clearTimeout(tmr);" href="k77.html?id_user=$login[id_p]"  class="profile">������� ($login[login])</a>
 <br />
_USERINFO;
		if($_SESSION['logintrue']==1){
			echo '<a style="background: url(/images/zadachi/mail.png) no-repeat;" class="thickbox" onmousemove="clearTimeout(tmr);" href="/modul/messagea.php?form=2&noerr&id=',$login[id_p],'&TB_iframe=true&modal=false&height=281&width=500" title="">�������� ������</a>';
            echo '<br /><a onmousemove="clearTimeout(tmr);" href="k19.html?usr_id='.$login[id_p].'" class="money">��������� ������</a>';
            echo '<br /><a onmousemove="clearTimeout(tmr);" href="k12-otzivi_o_proekte_reshenie_zadach.html?usr_id='.$login[id_p].'" class="otzyv">�������� �����</a>';
    }
    else 
    echo '  <span onmousemove="clearTimeout(tmr);" style="color:gray;">�������� ������ <br />
  ��������� ������ <br />
  �������� �����</span>';
    echo '</div>';
        }
        $str='';
        if(count($buf_logins_r) > 0){
			for($z=0;$z<@count($buf_logins_r);$z++){
			//	$loginsf=mysql_fetch_array($buf_logins);
				$str.= $buf_logins_r[$z][login].', ';
			}
		}
		echo '</td>
		<td align=center><font color="#333333" face="Arial" style="font-size: 11px">';
		if($f[status]==1){$stat='�����';
			echo '<abbr title="����� �����, ��� �� ��� ���������� ���������">�����</abbr>';
		}else if($f[status]==2){$stat='����������';
			echo '<abbr title="����� ��� ���������� ��������(�): ',$str,' ���������� ������� ������ �� ���, ������ ���������� � ��������� ���� �������� ��� ������ �������">����������</abbr>';
		}else if($f[status]==3){$stat='��������';
			echo '<abbr title="�������� ���� ���������� � �������� ���� �������� �� �������">��������</abbr>';
		}else if($f[status]==4){$stat='��������';
			echo '<abbr title="����� ��� �������� � �������� �� ����, ��� ������� ����� �������� ����� �� ����� �������� ���������� ���������">��������</abbr>';
		}else if($f[status]==5){$stat='�������';
			echo '<abbr title="����� ��� ������� � ������� �������� ��� ���������">�������</abbr>';
		}
		echo '</td>
		<td align=center><font color="#333333" face="Arial" style="font-size: 11px"><abbr title="���� �� ������ (� ������), ������������ ����������">',$f[price],'</td>
		<td align=center><font  face="Arial" style="font-size: 11px" ';if($f[end_time]<time() and $f[status]!=5){echo 'color="#ff0000"';}else{echo 'color="#333333"';}echo '><abbr title="���� �������, ������������� ����������">';if($f[status]==5){echo '����� ������';}else{echo date('d.m.y H:i',$f[end_time]);}echo '</td>
		<td align=center><a class="blue" href="k',$razdel[id],'.html" title="',$razdel[page_name],'" target="_blank">',$razdel[page_name],'</a></td>
		<td align=center><a class="zadachi" href="k',$podrazdel[id],'.html" target="_blank" title="',$podrazdel[page_name],'">',substr($podrazdel[page_name],0,10),'...</a></td>
		<td width=20 align=center><span class="helpInfo"><img alt=""  style="cursor:pointer;cursor:hand" src="images/zadachi/info.png" class=info id="I',$i,'" border=0>';

if(1||$_SESSION['userlogin']=='ddd'){

echo '

<span><font color="#365C71" face="Arial" style="font-size: 11px; font-weight: 700;">��������� ���������� � ������ ID=',$f[id_p],'</font>
<table border="0" width="100%" cellspacing="0" cellpadding="0">
	<tr>
	<td valign="top"  width=50%><font color="#333333" face="Arial" style="font-size: 11px">
		<b>������:</b> ',$razdel[page_name],' <br>
		<b>���������:</b> ',$podrazdel[page_name],' <br>
		<b>������� ������:</b> ����� ������� <a class="zadachi" href="modul/download.php?id=',$f[id_p],'&u" target="_blank">�����</a> <br>
		<b>��������� �������:</b> ',$f[price],' ������ (��������� ����, ��������� ����������)<br>
		<b>��������� ����������:</b> ';if($f[userresh]==0){echo '0';}else{echo $f[price]*0.5;}echo' ������<br>
		<b>���� ����������:</b> ',date('d.m.y H:i',$f[add_time]),'<br>
		<b>���� ��������� ��������:</b> ';if($f[data_prosmotra]==0){echo '�� �����������';}else{echo date('d.m.y H:i',$f[data_prosmotra]);}echo '<br>
		<b>���� �������� �������:</b> ';if($f[data_resh]==0){echo '��� �� ��� �����';}else{echo date('d.m.y H:i',$f[data_resh]);}echo ' <br>
		<b>���� ������:</b> ';if($f[data_oplati]==0){echo '��� �� ��� �������';}else{echo date('d.m.y H:i',$f[data_oplati]);}echo '<br>
		<b>��������� ���� �������:</b> ',date('d.m.y H:i',$f[end_time]),'</font>
	</td><td valign="top"  width=50%><font color="#333333" face="Arial" style="font-size: 8pt">
		<b>��������:</b> ',$user[login],'<br>
		<b>������: </b>',$stat,'<br>
		<b>�������� �� �������: </b>';if($f[status]<3){echo '����������';}else{echo '��������';}echo '<br>
		<b>����� ��� ����������:</b> ';if($f[status]<2){echo '���';}else{echo $str;}echo ' <br>
		<b>��������:</b> ';if($f[status]<3){echo '���';}else{echo $str;}echo '<br>
		<b>�������:</b> ';if($f[status]<4){echo '�� ���������';}else if($f[status]==4){echo '������ �� �� ��������';}else{echo '����� ������� <a class="zadachi" href="modul/download.php?id=',$f[id_p],'&r" target="_blank">�����</a>';}echo ' <br>
		<b>�����������:</b> ',$f[coment],'
	</font></td>
	</tr>
</table>';
echo '</span></span></td>';
}

echo '		<td width=20 align=center>';
//		if($_SESSION[logintrue]==1){
//			echo '<a href="k18.html?form=2&id=',$f[userzakaz],'"><img alt=""  style="cursor:pointer;cursor:hand" src="images/zadachi/message.png" border=0></a>';
//		}else{
//			echo '<img alt=""  style="cursor:pointer;cursor:hand" src="images/zadachi/no_message.png" border=0>';
//		}

		if($_SESSION['logintrue']==1/*&&$_SESSION['userlogin']=='ddd'*/){
			echo '<a title="��������, ����� �������� ������ ���������" href="/modul/messagea.php?form=2&noerr&id=',$f[userzakaz],'&TB_iframe=true&modal=false&height=281&width=500" class="thickbox" title=""><img alt=""  style="cursor:pointer;cursor:hand" src="images/zadachi/mail.png" border=0></a>';
		}
		elseif($_SESSION['logintrue']==1&&$_SESSION['userlogin']!='ddd') {
			echo '<a title="��������, ����� �������� ������ ���������" href="k18.html?form=2&id=',$f[userzakaz],'"><img alt=""  style="cursor:pointer;cursor:hand" src="images/zadachi/message.png" border=0></a>';
		}elseif($_SESSION['logintrue']!=1){
			echo '<a title="��������, ����� �������� ������ ���������" href="javascript:void(0)" onclick="alert(\'����� �������� ������ ���������, ��� ����� ������������������ ��� ����� � ������� ��� ����� ������� � �������\')"><img alt=""  style="cursor:pointer;cursor:hand" src="images/zadachi/no_message.png" border=0></a>';
		}

		echo '</td>
	</tr>
	<tr bgcolor="#FFFFFF"><td colspan="13" bgcolor="#E3EDF2">
	<div id="DI',$i,'" style="display:none;padding:10px">';
//if($_SESSION[logintrue]){
echo '<font color="#365C71" face="Arial" style="font-size: 11px; font-weight: 700;">��������� ���������� � ������ ID=',$f[id_p],'</font>
<table border="0" width="100%" cellspacing="0" cellpadding="0">
	<tr>
	<td valign="top"  width=50%><font color="#333333" face="Arial" style="font-size: 11px">
		<b>������:</b> ',$razdel[page_name],' <br>
		<b>���������:</b> ',$podrazdel[page_name],' <br>
		<b>������� ������:</b> ����� ������� <a class="zadachi" href="modul/download.php?id=',$f[id_p],'&u" target="_blank">�����</a> <br>
		<b>��������� �������:</b> ',$f[price],' ������ (��������� ����, ��������� ����������)<br>
		<b>��������� ����������:</b> ';if($f[userresh]==0){echo '0';}else{echo $f[price]*0.5;}echo' ������<br>
		<b>���� ����������:</b> ',date('d.m.y H:i',$f[add_time]),'<br>
		<b>���� ��������� ��������:</b> ';if($f[data_prosmotra]==0){echo '�� �����������';}else{echo date('d.m.y H:i',$f[data_prosmotra]);}echo '<br>
		<b>���� �������� �������:</b> ';if($f[data_resh]==0){echo '��� �� ��� �����';}else{echo date('d.m.y H:i',$f[data_resh]);}echo ' <br>
		<b>���� ������:</b> ';if($f[data_oplati]==0){echo '��� �� ��� �������';}else{echo date('d.m.y H:i',$f[data_oplati]);}echo '<br>
		<b>��������� ���� �������:</b> ',date('d.m.y H:i',$f[end_time]),'</font>
	</td><td valign="top"  width=50%><font color="#333333" face="Arial" style="font-size: 8pt">
		<b>��������:</b> ',$user[login],'<br>
		<b>������: </b>',$stat,'<br>
		<b>�������� �� �������: </b>';if($f[status]<3){echo '����������';}else{echo '��������';}echo '<br>
		<b>����� ��� ����������:</b> ';if($f[status]<2){echo '���';}else{echo $str;}echo ' <br>
		<b>��������:</b> ';if($f[status]<3){echo '���';}else{echo $str;}echo '<br>
		<b>�������:</b> ';if($f[status]<4){echo '�� ���������';}else if($f[status]==4){echo '������ �� �� ��������';}else{echo '����� ������� <a class="zadachi" href="modul/download.php?id=',$f[id_p],'&r" target="_blank">�����</a>';}echo ' <br>
		<b>�����������:</b> ',$f[coment],'
	</font></td>
	</tr>
</table>';
//}else{echo '<font color="#365C71" face="Arial" style="font-size: 11px; font-weight: 700;">� ��� ������������ ���� ��� ��������� ��������� ���������� � ������. ����������������� ��� �������� � �������</font>';}
echo '</div></td></tr>';}
?>
</table><center><font size="2" face="Arial"> ����� ������� <?echo $all_qty?> �����, ��������:
<?

$pages = array();
$pages_count = ceil($all_qty / $_SESSION[userzadach]);
$page_current = $_GET['first'] / $_SESSION[userzadach] + 1;
if($page_current < 1) $page_current = 1;

if($pages_count > 20)
{
    if($page_current < 5)
    {
        for($j = 1; $j <= 5; $j++)
            $pages[$j] = $j;
            
        $pages[$j] = null;
        $pages[$pages_count] = $pages_count;
    }
    elseif($page_current > $pages_count - 4)
    {
        $pages[1] = 1;
        $pages[2] = null;
        
        for($j = $pages_count - 4; $j <= $pages_count; $j++)
            $pages[$j] = $j;
    }
    else
    {
        $pages[1] = 1;
        $pages[2] = null;
        
        for($j = $page_current - 2; $j <= $page_current + 2; $j++)
            $pages[$j] = $j;
            
        $pages[$pages_count - 1] = null;
        $pages[$pages_count] = $pages_count;
    }
}
else
{
    for($j = 1; $j <= $pages_count; $j++)
        $pages[$j] = $j;    
}

foreach($pages as $id => $caption): ?>
    <?if($caption === null):?>
        <span>..</span>
    <?else:?>
        <?if($id == $page_current):?>
            <span style="text-decoration:underline;color:green"><b><?=$caption?></span>
        <?else:?>
            <a href="k6.html?first=<?=(($id - 1) * $_SESSION[userzadach])?>"><?=$caption?></a>
        <?endif;?>
    <?endif;?>
<? endforeach;


/*
if (isset($_GET[id_from_usr]))
{
        for($i=0;$i<ceil($all_qty/$_SESSION[userzadach]);$i++){
        	echo '<a href="k6.html?first=',$i*$_SESSION[userzadach],'&id_from_usr='.$_GET[id_from_usr].'&sts='.$_GET[sts].'" class=blue><b>',$i+1,'</b></a>. ';
        }
}
else
{
        for($i=0;$i<ceil($all_qty/$_SESSION[userzadach]);$i++){
        	if($i*$_SESSION[userzadach]==$_GET['first']) echo '<span style="text-decoration:underline;color:green"><b>',$i+1,'</b></span>. ';
		else echo '<a href="k6.html?first=',$i*$_SESSION[userzadach],'" class=blue ><b>',$i+1,'</b></a>. ';
        }
}*/
?>


