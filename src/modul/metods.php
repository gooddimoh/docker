<?

if(!$_SESSION[logintrue]&&!isset($_GET['ajax'])&&!isset($_POST[B1])&&!isset($_POST['B2'])&&!isset($_POST['B3'])){ ?>


<div class="page test20">


<p>�� �� ��������������� ������������. ��� ����, ����� �������� ����� �� ������� ������  � on-line ��������� ���������� ������ ��������� �����������.</p>
<!--
<p align="justify"><font size="2" face="Arial">�� ���� �������� �� ������ �������� ����� ��   ������� ������ � on-line ���������. ���� � ������� ������ ���� � ����� �� ���������   ��������:</font></p>
<p align="justify"><font size="2" face="Arial">���������: TXT, DOC (Microsoft Word), DOCX (Microsoft Word 2007), PDF<br />
�����������: JPG, GIF, PNG<br />
������: RAR, ZIP</font></p>
<p align="justify"><font size="2" face="Arial">������ �������������� ����� �� ������   ��������� <b>50M�&nbsp;</b>(���� ������ ����� ������, ���������� ������� �� �����   ��������������, ��������� ������ � ��������� ��� ���������� ���� � ��������� ��� � ��������   ������� �� ����).</font></p>
<table border="0" width="100%" id="table1" style="border: 1px solid #FB7B00" cellspacing="10" cellpadding="0">
    <tbody>
        <tr>
            <td><img border="0" alt="" width="80" height="80" src="images/alert.png" /></td>
            <td>
            <p align="justify"><font color="#EA6B00" size="2" face="Arial"><i><b>��������! </b></i>&nbsp; <br />
            1. ����� ����� ����� ��������� ����� ������� ���� ������ � �� ������� ����� ������������� ������� �� �����.<br />
            2. ����� ����, ��� ��� ����� ����� ����������, ���������� ����� ������   		����������, ������ 50% �� ��������� ������. �� �������� ����������   		������� ������ ������ <strong>�� �����!</strong> ��� ��������������� ���������� �   		�������� �� �������, ���� ������� ����� ���� ������������� �������!   		������ ��� ����� � �� ���������� � ���� ����� ����� &quot;����������&quot; ����!</font></p>
            </td>
        </tr>
    </tbody>
</table>
-->
</div>
<div class="test21">
<center><table border=0 width="100%"></table></center></div><p align="center"><font size="2" face="Arial"><font color="#FF0000">�� �� ��������������� ������������. ��� ���������� ������ � �������� �����
</font> <a href="k16.html">�����������������</a><font color="#FF0000"> ��� </font> <a href="k20.html?redir=k135">�������</a><font color="#FF0000"> � �������</font></font></p>				




<?
return;
}

//$max_size_file = get_cfg_var('upload_max_filesize');
//$max_size_file_int =(int)$max_size_file;
$arr_stat = array("���������", "��������", "�� ���������");
$arr_diplom = array("���������", "������", "��������", "�������");
//---translit
function translit($st){
	$st=strtr($st,"����������������������������������������������","abvgdegziyklmnoprstufieABVGDEGZIYKLMNOPRSTUFIE");
	$st=strtr($st,array('�'=>"yo",'�'=>"yi", '�'=>"h", '�'=>"ts", '�'=>"ch", '�'=>"sh",'�'=>"y",
	            		'�'=>"shch",'�'=>"i", '�'=>"", '�'=>"", '�'=>"yu", '�'=>"ya",
		                '�'=>"YO", '�'=>"H", '�'=>"TS", '�'=>"CH", '�'=>"SH",'�'=>"Y",
		                '�'=>"SHCH", '�'=>"", '�'=>"", '�'=>"YU", '�'=>"YA",
		                '�'=>"",'#'=>"",' '=>"_",'!'=>"",'?'=>"",'-'=>"",'@'=>"",
		                '('=>"_",')'=>"",'"'=>"","'"=>"",","=>""));
	return $st;
}
//---translit

include "mysql.php";

if(isset($_GET['ajax'])) {
	require_once $_SERVER["DOCUMENT_ROOT"] . "/modul/custom_sessions.php"; CustomSessions::start();
	if(!$_SESSION[logintrue]) exit;

	$where[] = 'km.status >0 ';
	$form = ($_POST['form']==2?'2':'');
	if(isset($_POST['country'])) $_POST['country'] = iconv('utf-8','cp1251',$_POST['country']);
	if(isset($_POST['city'])) $_POST['city'] = iconv('utf-8','cp1251',$_POST['city']);
	if(isset($_POST['vuz_name'])) $_POST['vuz_name'] = iconv('utf-8','cp1251',$_POST['vuz_name']);
	$vuz_name = explode("[",$_POST['vuz_name']);
	$_POST['vuz_name'] = $vuz_name[0];

	if(isset($_POST['country'])&&$_POST['country']!='0') { $country = $_POST['country']; $where[] = 'km.country = "'.addslashes(trim($country)).'"'; }
	if(isset($_POST['city'])&&$_POST['city']!='0') { $city = $_POST['city']; $where[] = 'km.city = "'.addslashes(trim($city)).'"'; }
	if(isset($_POST['vuz_name'])&&$_POST['vuz_name']!='0') { $vuz_name = $_POST['vuz_name']; $where[] = 'km.vuz_name = "'.addslashes(trim($vuz_name)).'"'; }
	if(isset($_POST['kafedra'])&&$_POST['kafedra']!='0') { $kafedra = $_POST['kafedra']; $where[] = 'km.kafedra = "'.addslashes(trim($kafedra)).'"'; }
	if(isset($_POST['year'])&&$_POST['year']!='0') { $year = $_POST['year']; $where[] = 'km.year = "'.addslashes(trim($year)).'"'; }

	$query = mysql_query("select country from katalog_metods as km WHERE km.status > 0 GROUP BY country");
	if(mysql_num_rows($query))
		while($res = mysql_fetch_array($query)) $sel_country[] = '<option '.($_POST['country']==$res['country']?' selected="selected" ':'').' value="'.$res['country'].'">'.$res['country'].'</option>';

	$country = $_POST['country'];
	if(trim($country)!=''){
		$query = mysql_query('select city from katalog_metods as km WHERE '.implode(" AND ", $where).' GROUP BY city');
		if(mysql_num_rows($query))
			while($res = mysql_fetch_array($query)) $sel_city[] = '<option '.($_POST['city']==$res['city']?' selected="selected" ':'').' value="'.$res['city'].'">'.$res['city'].'</option>';		
	}
	$city = $_POST['city'];
	if(trim($city)!=''){
		$query = mysql_query('select vuz_name, vuz_short_name from katalog_metods as km WHERE '.implode(" AND ", $where).' GROUP BY vuz_name');
		if(mysql_num_rows($query))
			while($res = mysql_fetch_array($query)) $sel_vuz[] = '<option '.($_POST['vuz_name']==$res['vuz_name']?' selected="selected" ':'').' value="'.$res['vuz_name'].'['.$res['vuz_short_name'].']">'.$res['vuz_name'].'['.$res['vuz_short_name'].']</option>';
		
	}

	$vuz_name = $_POST['vuz_name'];
	if(trim($vuz_name)!=''){
		$query = mysql_query('select kafedra from katalog_metods as km WHERE '.implode(" AND ", $where).' GROUP BY kafedra');
		if(mysql_num_rows($query))
			while($res = mysql_fetch_array($query)) $sel_kafedra[] = '<option value="'.$res['kafedra'].'">'.$res['kafedra'].'</option>';
		
	}
		?>
						<tr><td colspan="3">����� ����</td></tr>
						<tr>
							<td>������</td>
							<td><select name="country" onchange="if(jQuery(this).val()=='-1') jQuery(this).parent().next().show(); else  { jQuery(this).parent().next().hide(); sel_vuz11<?=$form?>() }"><option value="0">�������� ������</option><?if(sizeof($sel_country)) echo implode($sel_country);?><option value="-1">�������� ������</option></select></td>
							<td class="hid"><input type="text" value="" name="country_new"/></td>
						</tr>
						<tr>
							<td>�����</td>
							<td><select name="city" onchange="if(jQuery(this).val()=='-1') jQuery(this).parent().next().show(); else  { jQuery(this).parent().next().hide(); sel_vuz11<?=$form?>() }"><option value="0">�������� �����</option><?if(sizeof($sel_city)) echo implode($sel_city);?><option value="-1">�������� �����</option></select></td>
							<td class="hid"><input type="text" value="" name="city_new"/></td>
						</tr>
						<tr>
							<td>���</td>
							<td><select name="vuz_name" onchange="if(jQuery(this).val()=='-1') jQuery(this).parent().next().show(); else  { jQuery(this).parent().next().hide(); sel_vuz11<?=$form?>() }"><option value="0">�������� ���</option><?if(sizeof($sel_vuz)) echo implode($sel_vuz);?><option value="-1">�������� ���</option></select></td>
							<td class="hid">���<input type="text" value="" name="vuz_name_new"/>���<span class="brackets">(������������)</span><input type="text" value="" name="vuz_short_name_new"/></td>						</tr>
						<tr>
							<td>�������</td>
							<td><select name="kafedra" onchange="if(jQuery(this).val()=='-1') jQuery(this).parent().next().show(); else  { jQuery(this).parent().next().hide(); }"><option value="0">�������� �������</option><?if(sizeof($sel_kafedra)) echo implode($sel_kafedra);?><option value="-1">�������� �������</option></select></td>
							<td class="hid"><input type="text" value="" name="kafedra_new"/></td>
						</tr>

<?
	exit;

}
if(isset($_GET['action'])&&$_GET['action']=='del'&&$_SESSION[logintrue]){
	if(isset($_GET['mid'])&&(int)$_GET['mid']) {
		mysql_query('DELETE FROM katalog_metods_zad WHERE metod_id IN (SELECT id FROM katalog_metods WHERE id = '.(int)$_GET['mid'].' AND user_id = '.(int)$_SESSION['userid'].')');
		mysql_query('DELETE FROM katalog_metods WHERE id = '.(int)$_GET['mid'].' AND user_id = '.(int)$_SESSION['userid'].'');
	}
	if(isset($_GET['zid'])&&(int)$_GET['zid']) {
		mysql_query('DELETE FROM katalog_metods_zad WHERE metod_id IN (SELECT id FROM katalog_metods WHERE user_id = '.(int)$_SESSION['userid'].') AND id = '.(int)$_GET['zid'].'');
	}
	echo '<script>document.location.href="/k135.html"</script>';
}
if(!isset($_POST[B1])&&!isset($_POST['B2'])&&!isset($_POST['B3'])){
	if($_SESSION[logintrue]){
		
		echo '<style>.hid{display:none}</style>';

		$f=mysql_fetch_array(mysql_query("select url,mesmes,meszad,polz,zad,icq,tel,gorod,univer,dat_birth,coment from katalog_user where id_p='$_SESSION[userid]' limit 1"));
		?>
		<script lang="javascript">
			function show(temp){
				for(i=1;i<=4;i++){
					document.getElementById('form'+i).style.display="none";
				}
				document.getElementById(temp).style.display="block";
			}
			function check_form11(){ 
				jQuery("#form2 select[name='country']").css("border","");
				if(jQuery("#form2 select[name='country']").val()==0||(jQuery("#form2 select[name='country']").val()==-1&&jQuery("#form2 input[name='country_new']").val()=='')) { jQuery("#form2 select[name='country']").css("border","red 1px solid"); alert('�� ������ ������'); return false; }
				jQuery("#form2 select[name='city']").css("border","");
				if(jQuery("#form2 select[name='city']").val()==0||(jQuery("#form2 select[name='city']").val()==-1&&jQuery("#form2 input[name='city_new']").val()=='')) { jQuery("#form2 select[name='city']").css("border","red 1px solid"); alert('�� ������ �����'); return false; }
				jQuery("#form2 select[name='vuz_name']").css("border","");
				if(jQuery("#form2 select[name='vuz_name']").val()==0||(jQuery("#form2 select[name='vuz_name']").val()==-1&&jQuery("#form2 input[name='vuz_name_new']").val()=='')) { jQuery("#form2 select[name='vuz_name']").css("border","red 1px solid");alert('�� ������ ���'); return false; }
				jQuery("#form2 select[name='kafedra']").css("border","");
				if(jQuery("#form2 select[name='kafedra']").val()==0||(jQuery("#form2 select[name='kafedra']").val()==-1&&jQuery("#form2 input[name='kafedra_new']").val()=='')) { jQuery("#form2 select[name='kafedra']").css("border","red 1px solid");alert('�� ������� �������'); return false; }
				jQuery("#form2 input[name='metod_name']").css("border","");
				if(jQuery("#form2 input[name='metod_name']").val()=='') { jQuery("#form2 input[name='metod_name']").css("border","red 1px solid"); alert('������� �������� ���������'); return false; }
				jQuery("#form2 textarea[name='description']").css("border","");
				if(jQuery("#form2 textarea[name='description']").val()=='') { jQuery("#form2 textarea[name='description']").css("border","red 1px solid"); alert('������� �������� ����� ���������'); return false; }
				jQuery("#form2 input[name='year']").css("border","");
				if(jQuery("#form2 input[name='year']").val()=='') { jQuery("#form2 input[name='year']").css("border","red 1px solid"); alert('������� ��� �������'); return false; }
				jQuery("#form2 input[name='authors']").css("border","");
				if(jQuery("#form2 input[name='authors']").val()=='') { jQuery("#form2 input[name='authors']").css("border","red 1px solid"); alert('������� ������� ���������'); return false; }
				jQuery("#form2 [name='imgname']").css("border","");
				if(jQuery("#form2 [name='imgname']").val()=='') { jQuery("#form2 [name='imgname']").css("border","red 1px solid"); alert('�� ������ ���� �������'); return false; }
				a = jQuery("#form2 [name='imgname']")[0];
				b = jQuery("#form2 [name='imgname']").val().split('.');
				if(a.files[0].size > 20000000) { jQuery("#form2 [name='imgname']").css("border","red 1px solid"); alert('������ ����� �� ������ ��������� 20 ��'); return false; }
				if(b[b.length-1] != 'JPG' && b[b.length-1] != 'jpg' && b[b.length-1] !='jpeg' && b[b.length-1] !='gif' && b[b.length-1] !='png' && b[b.length-1] !='bmp' && b[b.length-1] !='tif' && b[b.length-1] !='doc' && b[b.length-1] !='docx') { jQuery("#form2 [name='imgname']").css("border","red 1px solid"); alert('������������ ���������� ����� �������'); return false; }

				jQuery("#form2 [name='filename']").css("border","");
				if(jQuery("#form2 [name='filename']").val()=='') { jQuery("#form2 [name='filename']").css("border","red 1px solid"); alert('�� ������ ���� � ����������'); return false; }
				a = jQuery("#form2 [name='filename']")[0];
				b = jQuery("#form2 [name='filename']").val().split('.');
				if(a.files[0].size > 20000000) { jQuery("#form2 [name='filename']").css("border","red 1px solid"); alert('������ ����� �� ������ ��������� 20 ��'); return false; }
				if(b[b.length-1] != 'JPG' && b[b.length-1] != 'jpg' && b[b.length-1] != 'doc' && b[b.length-1] !='txt' && b[b.length-1] !='zip' && b[b.length-1] !='rar' && b[b.length-1] !='pdf' && b[b.length-1] !='PDF' && b[b.length-1] !='xls') { jQuery("#form2 [name='filename']").css("border","red 1px solid"); alert('������������ ���������� ����� ���������'); return false; }

				return true;
			}

			function check_form113(){ 
				jQuery("#form3 select[name='metods']").css("border","");
				if(jQuery("#form3 select[name='metods']").val()=='') { jQuery("#form3 select[name='metods']").css("border","red 1px solid");alert('�� ������� ���������'); return false; }
				jQuery("#form3 input[name='name_zadacha']").css("border","");
				if(jQuery("#form3 input[name='name_zadacha']").val()=='') { jQuery("#form3 input[name='name_zadacha']").css("border","red 1px solid"); alert('������� �������� ���������'); return false; }
				//jQuery("#form3 input[name='name_razdel']").css("border","");
				//if(jQuery("#form3 input[name='name_razdel']").val()=='') { jQuery("#form3 input[name='name_razdel']").css("border","red 1px solid"); alert('������� �������� �������'); return false; }

				jQuery("#form3 input[name='price']").css("border","");
				if(jQuery("#form3 input[name='price']").val()=='') { jQuery("#form3 input[name='price']").css("border","red 1px solid"); alert('������� ����'); return false; }
				jQuery("#form3 [name='imgname']").css("border","");
				if(jQuery("#form3 [name='imgname']").val()=='') { jQuery("#form3 [name='imgname']").css("border","red 1px solid"); alert('�� ������ ���� �������'); return false; }
				a = jQuery("#form3 [name='imgname']")[0];
				b = jQuery("#form3 [name='imgname']").val().split('.');
				if(a.files[0].size > 20000000) { jQuery("#form3 [name='imgname']").css("border","red 1px solid"); alert('������ ����� �� ������ ��������� 20 ��'); return false; }
				if(b[b.length-1] != 'JPG' && b[b.length-1] != 'jpg' && b[b.length-1] !='jpeg' && b[b.length-1] !='gif' && b[b.length-1] !='png' && b[b.length-1] !='bmp') { jQuery("#form3 [name='imgname']").css("border","red 1px solid"); alert('������������ ���������� ����� �������'); return false; }

				jQuery("#form3 [name='filename']").css("border","");
				if(jQuery("#form3 [name='filename']").val()=='') { jQuery("#form3 [name='filename']").css("border","red 1px solid"); alert('�� ������ ���� � ����������'); return false; }

				a = jQuery("#form3 [name='filename']")[0];
				b = jQuery("#form3 [name='filename']").val().split('.');
				if(a.files[0].size > 20000000) { jQuery("#form3 [name='filename']").css("border","red 1px solid"); alert('������ ����� �� ������ ��������� 20 ��'); return false; }
				if(b[b.length-1] != 'JPG' && b[b.length-1] != 'jpg' && b[b.length-1] != 'doc' && b[b.length-1] !='txt' && b[b.length-1] !='zip' && b[b.length-1] !='rar' && b[b.length-1] !='pdf' && b[b.length-1] !='PDF' && b[b.length-1] !='xls') { jQuery("#form3 [name='filename']").css("border","red 1px solid"); alert('������������ ���������� ����� ���������'); return false; }
				return true;
			}

			function check_form112(){ 
				jQuery("#form4 select[name='country']").css("border","");
				if(jQuery("#form4 select[name='country']").val()==0||(jQuery("#form4 select[name='country']").val()==-1&&jQuery("#form4 input[name='country_new']").val()=='')) { jQuery("#form4 select[name='country']").css("border","red 1px solid"); alert('�� ������ ������'); return false; }
				jQuery("#form4 select[name='city']").css("border","");
				if(jQuery("#form4 select[name='city']").val()==0||(jQuery("#form4 select[name='city']").val()==-1&&jQuery("#form4 input[name='city_new']").val()=='')) { jQuery("#form4 select[name='city']").css("border","red 1px solid"); alert('�� ������ �����'); return false; }
				jQuery("#form4 select[name='vuz_name']").css("border","");
				if(jQuery("#form4 select[name='vuz_name']").val()==0||(jQuery("#form4 select[name='vuz_name']").val()==-1&&jQuery("#form4 input[name='vuz_name_new']").val()=='')) { jQuery("#form4 select[name='vuz_name']").css("border","red 1px solid");alert('�� ������ ���'); return false; }
				jQuery("#form4 select[name='kafedra']").css("border","");
				if(jQuery("#form4 select[name='kafedra']").val()==0||(jQuery("#form4 select[name='kafedra']").val()==-1&&jQuery("#form4 input[name='kafedra_new']").val()=='')) { jQuery("#form4 select[name='kafedra']").css("border","red 1px solid");alert('�� ������� �������'); return false; }
				jQuery("#form4 input[name='metod_name']").css("border","");
				if(jQuery("#form4 input[name='metod_name']").val()=='') { jQuery("#form4 input[name='metod_name']").css("border","red 1px solid"); alert('������� �������� ���������'); return false; }
				jQuery("#form4 input[name='authors']").css("border","");
				if(jQuery("#form4 input[name='authors']").val()=='') { jQuery("#form4 input[name='authors']").css("border","red 1px solid"); alert('������� ������ �������/��������'); return false; }
				jQuery("#form4 input[name='year']").css("border","");
				if(jQuery("#form4 input[name='year']").val()=='') { jQuery("#form4 input[name='year']").css("border","red 1px solid"); alert('������� ��� �������'); return false; }
				jQuery("#form4 input[name='pages']").css("border","");
				if(jQuery("#form4 input[name='pages']").val()=='') { jQuery("#form4 input[name='pages']").css("border","red 1px solid"); alert('������� ���������� �������'); return false; }

				jQuery("#form4 input[name='price']").css("border","");
				if(jQuery("#form4 input[name='price']").val()=='') { jQuery("#form4 input[name='price']").css("border","red 1px solid"); alert('������� ���������'); return false; }

				jQuery("#form4 [name='imgname']").css("border","");
				if(jQuery("#form4 [name='imgname']").val()=='') { jQuery("#form4 [name='imgname']").css("border","red 1px solid"); alert('�� ������ ���� �������'); return false; }
				a = jQuery("#form4 [name='imgname']")[0];
				b = jQuery("#form4 [name='imgname']").val().split('.');
				if(a.files[0].size > 20000000) { jQuery("#form4 [name='imgname']").css("border","red 1px solid"); alert('������ ����� �� ������ ��������� 20 ��'); return false; }
				if(b[b.length-1] != 'JPG' && b[b.length-1] != 'jpg' && b[b.length-1] !='jpeg' && b[b.length-1] !='gif' && b[b.length-1] !='png' && b[b.length-1] !='bmp') { jQuery("#form4 [name='imgname']").css("border","red 1px solid"); alert('������������ ���������� ����� �������'); return false; }

				jQuery("#form4 [name='fileshortname']").css("border","");
				if(jQuery("#form4 [name='fileshortname']").val()=='') { jQuery("#form4 [name='fileshortname']").css("border","red 1px solid"); alert('�� ������ ���� � ����������'); return false; }
				a = jQuery("#form4 [name='fileshortname']")[0];
				b = jQuery("#form4 [name='fileshortname']").val().split('.');
				if(a.files[0].size > 20000000) { jQuery("#form4 [name='fileshortname']").css("border","red 1px solid"); alert('������ ����� �� ������ ��������� 20 ��'); return false; }
				if(b[b.length-1] != 'JPG' && b[b.length-1] != 'jpg' && b[b.length-1] != 'doc' && b[b.length-1] !='txt' && b[b.length-1] !='zip' && b[b.length-1] !='rar' && b[b.length-1] !='pdf' && b[b.length-1] !='PDF' && b[b.length-1] !='xls') { jQuery("#form4 [name='fileshortname']").css("border","red 1px solid"); alert('������������ ���������� ����� ����� �������'); return false; }

				jQuery("#form4 [name='filename']").css("border","");
				if(jQuery("#form4 [name='filename']").val()=='') { jQuery("#form4 [name='filename']").css("border","red 1px solid"); alert('�� ������ ���� � ����������'); return false; }
				a = jQuery("#form4 [name='filename']")[0];
				b = jQuery("#form4 [name='filename']").val().split('.');
				if(a.files[0].size > 20000000) { jQuery("#form4 [name='filename']").css("border","red 1px solid"); alert('������ ����� �� ������ ��������� 20 ��'); return false; }
				if(b[b.length-1] != 'JPG' && b[b.length-1] != 'jpg' && b[b.length-1] != 'doc' && b[b.length-1] !='txt' && b[b.length-1] !='zip' && b[b.length-1] !='rar' && b[b.length-1] !='pdf' && b[b.length-1] !='PDF' && b[b.length-1] !='xls') { jQuery("#form4 [name='filename']").css("border","red 1px solid"); alert('������������ ���������� ����� �������/��������'); return false; }

				return true;
			}

			function sel_vuz11(){ 
				var country = jQuery("#form2 select[name='country']").val();
				var city = jQuery("#form2 select[name='city']").val();
				var vuz_name = jQuery("#form2 select[name='vuz_name']").val();
				var kafedra = jQuery("#form2 select[name='kafedra']").val();
				jQuery.post("/modul/metods.php?ajax",{country:country, city:city, vuz_name:vuz_name, kafedra:kafedra }, function(data){ jQuery("#vuzselect").html(data); FilterInputs();})
			}
			function sel_vuz112(){ 
				var country = jQuery("#form4 select[name='country']").val();
				var city = jQuery("#form4 select[name='city']").val();
				var vuz_name = jQuery("#form4 select[name='vuz_name']").val();
				var kafedra = jQuery("#form4 select[name='kafedra']").val();
				jQuery.post("/modul/metods.php?ajax",{country:country, city:city, vuz_name:vuz_name, kafedra:kafedra, form: 2 }, function(data){ jQuery("#vuzselect2").html(data); FilterInputs();})
			}
			jQuery(document).ready(function(){sel_vuz11();sel_vuz112();});
		</script>



<div class="myShopTable">
<h2>��� �������</h2>
<p>� ���� ������� �� ������ ��������� ��� ������� ��� ���� �������� ������, ����������� ������������, �������� ��� �������.</p>
<p>����� ��������� ����� ��������� ������� ���������, ���� ��� �� ��������� �����.</p>
	<table class="tabs" border="0" cellpadding="5" bgcolor="ffffff">
		<tr bgcolor="365C71">
			<td <?=($_GET['form']==1||!isset($_GET['form'])?' class="active" ':'')?> ><a onclick="jQuery('.active').removeClass('active');jQuery(this).parent().addClass('active');show('form1');return false" href="#" class=infobold>��� ���������</a></td>
			<td<?=($_GET['form']==2?' class="active" ':'')?>><a onclick="jQuery('.active').removeClass('active');jQuery(this).parent().addClass('active');show('form2');return false" href="#" class=infobold>��������� ���������</a></td>
			<td<?=($_GET['form']==3?' class="active" ':'')?>><a onclick="jQuery('.active').removeClass('active');jQuery(this).parent().addClass('active');show('form3');return false" href="#" class=infobold>��������� ������</a></td>
			<td<?=($_GET['form']==4?' class="active" ':'')?>><a onclick="jQuery('.active').removeClass('active');jQuery(this).parent().addClass('active');show('form4');return false" href="#" class=infobold>��������� ������/��������/�������</a></td>
		</tr>
	</table>
			<table class="methodWrap" width="100%" cellpadding="10"><tr><td style="border:1px solid #70A0BA">
		
<!---->		<form enctype="multipart/form-data" action="modul/metods.php" method=post id="form2" <? if($_GET[form]==2){echo 'style="display:block"';}else{echo 'style="display:none"';} ?> >
			<table border="0" width="100%" id="table1">
				<tr>
					<td class="attention"><p>��������! ��� ���� ���������� ��� ����������</p></td>
				</tr>
				<tr>
					<td>
					&nbsp;</td>
				</tr>
				<tr>
					<td>
					<table  id="vuzselect" border="0">
						<tr><td colspan="3">����� ����</td></tr>
						<tr>
							<td>������</td>
							<td><select name="country" onchange="sel_vuz()"><option value="0">�������� ������</option><option value="-1">�������� ������</option></select></td>
							<td class="hid"><input type="text" value="" name="country_new"/></td>
						</tr>
						<tr>
							<td>�����</td>
							<td><select name="city" onchange="sel_vuz()"><option value="0">�������� �����</option><option value="-1">�������� �����</option></select></td>
							<td class="hid"><input type="text" value="" name="city_new"/></td>
						</tr>
						<tr>
							<td>���</td>
							<td><select name="vuz_name" onchange="sel_vuz()"><option value="0">�������� ���</option><option value="-1">�������� ���</option></select></td>
							<td class="hid">���<input type="text" value="" name="vuz_name_new"/>���<span class="brackets">(������������)</span><input type="text" value="" name="vuz_short_name_new"/></td>
						</tr>
						<tr>
							<td>�������</td>
							<td><select name="kafedra"><option value="0">�������� �������</option><option value="-1">�������� �������</option></select></td>
							<td class="hid"><input type="text" value="" name="kafedra_new"/></td>
						</tr>
					</table>
					
					<table border="0" id="table2">
						<tr><td colspan="3">���������</td></tr>
						<tr>
							<td>��������</td>
							<td><input type="text" name="metod_name" ></td>
							<td></td>
						</tr>
						<tr>
							<td>�������� ����� ��������� <span class="brackets">(�������� � ��������� �������� � ���� ���������)</span></td>
							<td><textarea name="description" rows="4"></textarea></td>
							<td></td>
						</tr>
						<tr>
							<td>��� �������</td>
							<td><input type="text" name="year" ></td>
							<td></td>
						</tr>
						<tr>
							<td>������</td>
							<td><input type="text" name="authors" ></td>
							<td></td>
						</tr>
						<tr>
							<td>������� <span class="brackets">(��������� �������� ���������)</span></td>
							<td><input type="file" name="imgname" size="20"></td>
							<td></td>
						</tr>
						<tr>
							<td>���� � ���������� <span class="brackets">(����� ��������� doc, txt, zip, rar, pdf, xls �� 20 mb)</span></td>
							<td><input type="file" name="filename" size="20"></td>
						</tr>
						<tr>
							<td></td>
							<td><input class="upload" type="submit" onclick="return check_form11()" value="���������" name="B1"></td> 
						</tr>
					</table>
					</td>
				</tr>
			</table></form>
<!---->		<form enctype="multipart/form-data" action="modul/metods.php" method=post id="form3" <? if($_GET[form]==3){echo 'style="display:block"';}else{echo 'style="display:none"';} ?> >
			<table border="0" width="100%" id="table1">
				<tr>
					<td class="attention">
						<p>��������! ��� ���� ���������� ��� ����������</p>
						<div>
							<p>��������!</p>
							<p>1. �������������� ���� �� ���� ������ � �������� ���.</p>
							<p>2. ���� ���������� ������ (��� �����): <font style="color:red"><?=100-$config[shop_procent]?>% �� ����, ������������� ���� �� ������.</font></p>
							<p>������ ������� ���, ����� �������������� ���� �� ���� ������.</p>
						</div>
					</td>
				</tr>
				<tr>
					<td>
					&nbsp;</td>
				</tr>
				<tr>
					<td>
					<table border="0" id="table3">
						<tr><td colspan="3">��������� ������</td></tr>
						<tr>
							<td>���������</td>
							<? 

                               if(empty($_SESSION['metods_save'])) $_SESSION['metods_save'] = 0;
                                
                               $query = mysql_query('select * from katalog_metods where user_id="'.$_SESSION['userid'].'"');
							   $sel_metod = array();
                               if(mysql_num_rows($query))
								while($res = mysql_fetch_array($query)) $sel_metod[] = '<option '.($_SESSION['metods_save'] == $res['id'] ? 'selected' : '').' value="'.$res['id'].'">'.$res['metod_name'].'('.$res['vuz_short_name'].')</option>'; 
							?>
							<td>
                                <select name="metods"><option>�������� ���������</option><?=implode($sel_metod)?></select>
                                <div style="margin-top: 5px;"><input type="checkbox" <?if($_SESSION['metods_save']):?> checked="checked" <?endif?> name="metods_save" value="1" /> ������������� ��������� �� ������ (������ �������, ���� ���������� ����� �����)</div>
                            </td>
							<td class="hid"></td>
						</tr>
						<tr>
							<td>������ <span class="brackets">(��������)<br /> � �������: ������ � (��� ������� �)</span></td>
							<td><input type="text" value="" name="name_zadacha"/></td>
							<td class="hid"></td>
						</tr>
						<tr>
							<td>������ <span class="brackets">(��������)<br /> � �������: ������ � (��� �������� �������, ���� ��������� �������� �������)<br />�������� ���� ������, ���� ��������� ������� �� ��������.</span></td>
							<td><input type="text" value="" name="name_razdel"/></td>
							<td class="hid"></td>
						</tr>
						<tr>
							<td>��������� <span class="brackets">(� ��������)<br />����������� ������������ ���� � ���� ���������� �����. ������� ����� ���������� �� ����� ����� �������(,) ��� ������(.)</span></td>
							<td><input type="text" value="" name="price"/></td>
							<td class="hid"></td>
						</tr>
					</table>
					
					<table class="solution" border="0">
						<tr><td colspan="3">�������</td></tr>
						<tr>
							<td>���� ������� ������</td>
							<td><input type="file" name="imgname" size="20"></td>
							<td></td>
						</tr>
						<tr>
							<td>���� ������� <span class="brackets">(��, ��� �� ��������. ����� ��������� doc, txt, zip, rar, pdf, xls �� 20 mb)</span></td>
							<td><input type="file" name="filename" size="20"></td>
						</tr>
						<tr>
							<td></td>
							<td><input class="upload" type="submit" onclick="return check_form113()" value="���������" name="B2"></td>
						</tr>
					</table>
					</td>
				</tr>
			</table></form>
<!---->	<form enctype="multipart/form-data" action="modul/metods.php" method=post id="form4" <? if($_GET[form]==4){echo 'style="display:block"';}else{echo 'style="display:none"';} ?> >
			<table border="0" width="100%" id="table1">
				<tr>
					<td class="attention">
						<p>��������! ��� ���� ���������� ��� ����������</p>
						<div>
							<p>��������!</p>
							<p>1. �������������� ���� �� ���� ������ � �������� ���.</p>
							<p>2. ���� ���������� ������ (��� �����): <font style="color:red"><?=100-$config[shop_procent]?>% �� ����, ������������� ���� �� ������.</font></p>
							<p>������ ������� ���, ����� �������������� ���� �� ���� ������.</p>
						</div>
					</td>
				</tr>
				<tr>
					<td>
					&nbsp;</td>
				</tr>
				<tr>
					<td>
					<table id="vuzselect2" border="0">
						<tr><td colspan="3">����� ����</td></tr>
						<tr>
							<td>������</td>
							<td><select name="country" onchange="sel_vuz()"><option value="0">�������� ������</option><option value="-1">�������� ������</option></select></td>
							<td class="hid"><input type="text" value="" name="country_new"/></td>
						</tr>
						<tr>
							<td>�����</td>
							<td><select name="city" onchange="sel_vuz()"><option value="0">�������� �����</option><option value="-1">�������� �����</option></select></td>
							<td class="hid"><input type="text" value="" name="city_new"/></td>
						</tr>
						<tr>
							<td>���</td>
							<td><select name="vuz_name" onchange="sel_vuz()"><option value="0">�������� ���</option><option value="-1">�������� ���</option></select></td>
							<td class="hid">���<input type="text" value="" name="vuz_name_new"/>���<span class="brackets">(������������)</span><input type="text" value="" name="vuz_short_name_new"/></td>
						</tr>
						<tr>
							<td>�������</td>
							<td><select name="kafedra"><option value="0">�������� �������</option><option value="-1">�������� �������</option></select></td>
							<td class="hid"><input type="text" value="" name="kafedra_new"/></td>
						</tr>
					</table>
					<table border="0" id="table4">
						<tr>
							<td><b><font face="Arial" size="2" color="#006666">������</font></b></td>
							<td><select name="diplom">
								<option value="1">������</option>
								<option value="2">��������</option>
								<option value="3">�������</option>
							    </select></td>
							<td></td>
						</tr>
						<tr>
							<td>��������</td>
							<td><input type="text" name="metod_name" ></td>
							<td></td>
						</tr>
						<tr>
							<td>�����</td>
							<td><input type="text" name="authors" ></td>
							<td></td>
						</tr>
						<tr>
							<td>��� �������</td>
							<td><input type="text" name="year" ></td>
							<td></td>
						</tr>
						<tr>
							<td>�������</td>
							<td><input type="text" name="pages" ></td>
							<td></td>
						</tr>
						<tr>
							<td>��������� <span class="brackets">(� ��������)</span></td>
							<td><input type="text" name="price" ></td>
							<td></td>
						</tr>
						<tr>
							<td>��������� �������� <span class="brackets">(����� ��������� jpg, gif, tif, jpeg, bmp, doc, docx �� 20 mb)</span></td>
							<td><input type="file" name="imgname" size="20"></td>
							<td></td>
						</tr>
						<tr>
                            <td>���� <span class="brackets">(��, ��� �� ��������.<br/>����� ��������� doc, txt, zip, rar, pdf, xls �� 20 mb)</span></td>
							<td><input type="file" name="fileshortname" size="20"></td>
							<td></td>
						</tr>
						<tr>
							<td>����� ������� <span class="brackets">(��������, ���������� �������, �������� ��������)</span></td>
							<td><input type="file" name="filename" size="20"></td>
						</tr>
						<tr>
							<td></td>
							<td><input class="upload" type="submit" onclick="return check_form112()" value="���������" name="B3"></td>
						</tr>
					</table>
					</td>
				</tr>
			</table></form>

<!---->		<form action="modul/metods.php" method=post id="form1" <?if(!isset($_GET[form]) or $_GET[form]==1){echo 'style="display:block"';}else{echo 'style="display:none"';} ?> >
			<table class="myShopMethodsTable" border="0" width="100%" cellspacing="1" cellpadding="0" bgcolor="#cccccc">
				<tr>
					<td height="25" width=150 bgcolor="#365C71" align="center"><span lang="ru">
					<font size="2" face="Arial" color="#FFFFFF">������</font></span></td>
					<td height="25" width=150 bgcolor="#365C71" align="center"><span lang="ru">
					<font size="2" face="Arial" color="#FFFFFF">���</font></span></td>
					<td height="25" width=150 bgcolor="#365C71" align="center"><span lang="ru">
					<font size="2" face="Arial" color="#FFFFFF">������</font></span></td>
					<td height="25" bgcolor="#365C71" align="center"><span lang="ru">
					<font size="2" face="Arial" color="#FFFFFF">��������</font></span></td>
					<td height="25" bgcolor="#365C71" align="center"><span lang="ru">
					<font size="2" face="Arial" color="#FFFFFF">���</font></span></td>
					<td height="25" bgcolor="#365C71" align="center"><span lang="ru">
					<font size="2" face="Arial" color="#FFFFFF">������</font></span></td>
					<td height="25" bgcolor="#365C71" align="center"><span lang="ru">
					<font size="2" face="Arial" color="#FFFFFF">����</font></span></td>
					<td width=20px height="25" bgcolor="#365C71" align="center"><span lang="ru">
					<font size="2" face="Arial" color="#FFFFFF">���.</font></span></td>
					<td width=20px height="25" bgcolor="#365C71" align="center"></td>
				</tr>

			<? $r = mysql_query("select * from katalog_metods where user_id='$_SESSION[userid]' ");

			for($i=1;$i<=@mysql_num_rows($r);$i++){
			$f=mysql_fetch_array($r); 
			echo '<tr bgcolor="#ffffff" onmouseover="this.style.backgroundColor=\'#ECF7FF\'" onmouseout="this.style.backgroundColor=\'#ffffff\'">
			<td align=center><font color="#333333" face="Arial" style="font-size: 11px">'.$arr_diplom[$f['diplom']].'</td>
			<td align=center><font color="#333333" face="Arial" style="font-size: 11px">'.$f['vuz_name'].' �������:'.$f['kafedra'].'</td>
			<td align=center><font color="#333333" face="Arial" style="font-size: 11px">'.$f['country'].' '.$f['city'].'</td>
			<td align=center><font color="#333333" face="Arial" style="font-size: 11px">'.$f['metod_name'].'</td>
			<td align=center><font color="#333333" face="Arial" style="font-size: 11px">'.$f['year'].'</td>
			<td align=center><font color="#333333" face="Arial" style="font-size: 11px">'.$arr_stat[$f['status']].'</td>
			<td align=center><font color="#333333" face="Arial" style="font-size: 11px">$ '.$f['price'].'</td>
			<td align=center>'.($f['status']!=1?'<a href="/k137.html?mid='.$f['id'].'"><img alt=""  src="images/information.png" border=0></a>':'').
			''.($f['status']==1?'<a href="/k136.html?metod_id='.$f['id'].'" target="_blank"><img alt=""  src="images/information.png" border=0></a>':'').'</td>
			<td align=center><a href="/k135.html?action=del&mid=',$f[id],'"><img alt=""  src="images/mail_del.gif" border=0></a></td>';
			echo '</tr>';

			$q2 = mysql_query('select * from katalog_metods_zad where metod_id = '.$f['id'].' ');
			if(mysql_num_rows($q2)){
				while($r2 = mysql_fetch_array($q2)) { ?>
					<tr bgcolor="#ffffff"><td  align="center" class="arrow_td">������</td><td></td><td></td>
					<td align="center"><?=$r2['name_zadacha']?></td><td></td><td></td>
					<td align="center">$ <?=$r2['price']?></td>
					<td align="center"><a href="/k137.html?zid=<?=$r2['id']?>"><img src="/images/information.png" alt=""/></a></td>
					<td align=center><a href="/k135.html?action=del&zid=<?=$r2['id']?>"><img alt=""  src="images/mail_del.gif" border=0></a></td>
					</tr>
				<? }
			}

			}
			echo '
			</table></form>
		</td></tr></table><!-- end of .methodWrap -->';
	}else{
	array_push($_SESSION[error],'�� �� ��������������� ������������. <a href="k20.html">�������</a> � �������');
	echo '<script lang="javascaript">location.href="./"</script>';
	}
}else{
	require_once $_SERVER["DOCUMENT_ROOT"] . "/modul/custom_sessions.php"; CustomSessions::start();
	$_SESSION[error]=array();
	$_SESSION[result]=array();

	include "sequrity.php";
	$data=time();

	if($_SESSION[logintrue]){
		if(!$_FILES["filename"]["size"]){
		array_push($_SESSION[error],'��� �����');
		}else{
		    if (end(explode(".",$_FILES['fileshortname']['name'])) == 'php'||end(explode(".",$_FILES['filename']['name'])) == 'php'||end(explode(".",$_FILES['imgname']['name'])) == 'php') {
         //   if($_FILES["filename"]["type"]!='image/jpeg' and $_FILES["filename"]["type"]!='image/bmp' and $_FILES["filename"]["type"]!='image/png' and $_FILES["filename"]["type"]!='image/gif' and $_FILES["filename"]["type"]!='text/plain' and $_FILES["filename"]["type"]!='application/msword' and $_FILES["filename"]["type"]!='application/msword' and $_FILES["filename"]["type"]!='application/pdf' and $_FILES["filename"]["type"]!='application/x-rar-compressed' and $_FILES["filename"]["type"]!='application/zip'){
		    array_push($_SESSION[error],'����� ��������� �������');
        	}
		}
		if(0&&$_FILES["filename"]["size"]>$max_size_file_int){
			array_push($_SESSION[error],'���� ��������� '. $max_size_file .', ������� �������');
		}
		$r=mysql_query("select id from katalog_files where user='$_SESSION[userid]'");
		if(0&&@mysql_num_rows($r)>=10){
			array_push($_SESSION[error],'�������� ����� ���������� ������');
		}

			if(count($_SESSION[error])==0){

                $_FILES['filename']['name']=translit($_FILES['filename']['name']);
        		$url="uploads/f_".$data."_".$_SESSION['userid']."_".$_FILES['filename']['name'];
				@copy($_FILES['filename']['tmp_name'], "../".$url);
                $_FILES['fileshortname']['name']=translit($_FILES['fileshortname']['name']);
        		$fileshorturl="uploads/f_".$data."_".$_SESSION['userid']."_".$_FILES['fileshortname']['name'];
				@copy($_FILES['fileshortname']['tmp_name'], "../".$fileshorturl);

                $_FILES['imgname']['name']=translit($_FILES['imgname']['name']);
        		$imgurl="uploads/f_".$data."_".$_SESSION['userid']."_".$_FILES['imgname']['name'];
				@copy($_FILES['imgname']['tmp_name'], "../".$imgurl);
		if(isset($_POST['B1'])){
				if($_POST['country']!="-1") $country = addslashes(trim($_POST['country'])); else $country = addslashes(trim($_POST['country_new']));
				if($_POST['city']!="-1") $city = addslashes(trim($_POST['city'])); else $city = addslashes(trim($_POST['city_new']));
				if($_POST['vuz_name']!="-1") { $vuz_name = explode("[",addslashes(trim($_POST['vuz_name']))); $vuz_short_name = str_replace("]","",$vuz_name[1]); $vuz_name = $vuz_name[0];  }else { $vuz_name = addslashes(trim($_POST['vuz_name_new'])); $vuz_short_name = addslashes(trim($_POST['vuz_short_name_new']));}
				if($_POST['kafedra']!="-1") $kafedra = addslashes(trim($_POST['kafedra'])); else $kafedra = addslashes(trim($_POST['kafedra_new']));
				$year = addslashes(trim($_POST['year']));
				$authors = addslashes(trim($_POST['authors']));
				$metod_name = addslashes(trim($_POST['metod_name']));
				$description = addslashes(trim($_POST['description']));

				mysql_query('insert into katalog_metods (user_id, file_name, img_name, country, city, vuz_name, vuz_short_name, kafedra, metod_name, year, authors, description, status ) values("'.$_SESSION[userid].'","'.$url.'","'.$imgurl.'","'.$country.'","'.$city.'", "'.$vuz_name.'", "'.$vuz_short_name.'","'.$kafedra.'","'.$metod_name.'","'.$year.'","'.$authors.'","'.$description.'", 2)')or die(mysql_error());
		}
		if(isset($_POST['B2'])){
                
                if(isset($_POST['metods_save'])) $_SESSION['metods_save'] = (int)$_POST['metods'];
                else $_SESSION['metods_save'] = 0;
                
                $name_zadacha = addslashes(trim($_POST['name_zadacha']));
				$name_razdel = addslashes(trim($_POST['name_razdel']));
				$metod_id = (int)$_POST['metods'];
				$price = (float)str_replace(",",".",$_POST['price']);

				mysql_query('insert into katalog_metods_zad (metod_id, name_zadacha, name_razdel, price, img_name, file_name ) values("'.$metod_id.'","'.$name_zadacha.'","'.$name_razdel.'","'.$price.'","'.$imgurl.'","'.$url.'")')or die(mysql_error());
		}
		if(isset($_POST['B3'])){
				if($_POST['country']!="-1") $country = addslashes(trim($_POST['country'])); else $country = addslashes(trim($_POST['country_new']));
				if($_POST['city']!="-1") $city = addslashes(trim($_POST['city'])); else $city = addslashes(trim($_POST['city_new']));
				if($_POST['vuz_name']!="-1") { $vuz_name = explode("[",addslashes(trim($_POST['vuz_name']))); $vuz_short_name = str_replace("]","",$vuz_name[1]); $vuz_name = $vuz_name[0];  }else { $vuz_name = addslashes(trim($_POST['vuz_name_new'])); $vuz_short_name = addslashes(trim($_POST['vuz_short_name_new']));}
				if($_POST['kafedra']!="-1") $kafedra = addslashes(trim($_POST['kafedra'])); else $kafedra = addslashes(trim($_POST['kafedra_new']));
				$year = addslashes(trim($_POST['year']));
				$pages = (int)$_POST['pages'];
				$authors = addslashes(trim($_POST['authors']));
				$diplom = (int)$_POST['diplom'];
				$price = (float)str_replace(",",".",$_POST['price']);
				$metod_name = addslashes(trim($_POST['metod_name']));
				mysql_query('insert into katalog_metods (user_id, file_name, fileshort_name, img_name, country, city, vuz_name, vuz_short_name, kafedra, metod_name, year, pages, price, diplom, status ) values("'.$_SESSION[userid].'", "'.$fileshorturl.'", "'.$url.'","'.$imgurl.'","'.$country.'","'.$city.'", "'.$vuz_name.'", "'.$vuz_short_name.'","'.$kafedra.'","'.$metod_name.'","'.$year.'","'.$pages.'","'.$price.'","'.$diplom.'",2)')or die(mysql_error());
		}
			}

		if(count($_SESSION[error])==0){array_push($_SESSION[result],'���� ������� ��������');header("Location:../k135.html?form=1");}
		else{header("Location:../k135.html");}
  	}else{
    	array_push($_SESSION[error],'�� �� ��������������� ������������. <a href="k20.html">�������</a> � �������');
    	header("Location:../");
	}
}
?>
</div><!-- end of .myShopTable-->