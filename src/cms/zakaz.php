<?
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
if(!isset($_POST[B1])){
	if($_SESSION[logintrue]){		echo '
		<p align="center"><font size="2" face="Arial" color="#333333">����������, ��������� �����, ����������� ���� (����, ���������� <img src="images/bullet.png"> ,		����������� ��� ����������).</font></p>
		<form action="modul/zakaz.php" method="post"  enctype="multipart/form-data">
		<table border="0" width="100%">
			<tr>
				<td align="right" width=120><font size="2" face="Arial" color="#333333">������� ������:</font></td>
				<td> <img src="images/bullet.png"></td>
				<td><input type="file" name="filename"></td>
				<td>&nbsp;</td>
				<td></td>
			</tr>
			<tr>
				<td align="right"><font size="2" face="Arial" color="#333333">���������:</font></td>
				<td> <img src="images/bullet.png"></td>
				<td>
		<select size="1" name="podrazdel" style="width:350px">
		<option value="0">�������� ���������</option>';
		$r=mysql_query("select id,page_name from katalog where id_p='15' and page_type='1' and menu_vizible='0' and menu_dozvil='0' order by menu_sort asc");
		for($i=0;$i<@mysql_num_rows($r);$i++){
			$f=mysql_fetch_array($r);
			echo '<optgroup label="',$f[page_name],'" style="background-color:#365C71;"></optgroup>';
			$rr=mysql_query("select id,page_name from katalog where id_p='$f[id]' and page_type='1' and menu_vizible='0' and menu_dozvil='0' order by menu_sort asc");
			for($j=0;$j<@mysql_num_rows($rr);$j++){
				$ff=mysql_fetch_array($rr);
				echo '<option value=',$ff[id],' style="background:#ffffff;">�� ',$ff[page_name],'</option>';
			}
		}echo '</select></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td align="right"><font size="2" face="Arial" color="#333333">���� �������:</font></td>
				<td> <img src="images/bullet.png"></td>
				<td>
				<table border="0" width="100%" id="table1">
					<tr>
						<td align="right"><font size="2" face="Arial" color="#28A8BC">����</font><span lang="ru"> </span>
						</td>
						<td align="right"><select size="1" name="D1">';for($i=1;$i<=31;$i++){echo '<option value="',$i,'" ';if(date('d')==$i){echo 'selected';}echo '>';if($i<10){echo '0';} echo $i,'</option>';}echo '</select></td>
						<td align="right"><font size="2" face="Arial" color="#28A8BC">�����</font></td>
						<td align="right"><select size="1" name="D2">';for($i=1;$i<=12;$i++){echo '<option value="',$i,'" ';if(date('m')==$i){echo 'selected';}echo '>';if($i<10){echo '0';} echo $i,'</option>';}echo '</select></td>
						<td align="right"><font size="2" face="Arial" color="#28A8BC">���</font></td>
						<td align="right"><select size="1" name="D3">';for($i=0;$i<=20;$i++){echo '<option value="',$i,'" ';if(date('y')==$i){echo 'selected';}echo '>20';if($i<10){echo '0';} echo $i,'</option>';}echo '</select></td>
						<td align="right"><font size="2" face="Arial" color="#28A8BC">�����</font></td>
						<td align="right"><select size="1" name="D4">';for($i=0;$i<=24;$i++){echo '<option value="',$i,'" ';if(date('H')==$i){echo 'selected';}echo '>';if($i<10){echo '0';} echo $i,':00</option>';}echo '</select></td>
					</tr>
				</table>
				</td>
				<td></td>
				<td><font size="2" face="Arial" color="#333333">C�����: <font size="2" face="Arial" color="#28A8BC">',date('d.m.y H:i'),'</font></font></td>
			</tr>
			<tr>
				<td align="right"><font size="2" face="Arial" color="#333333">���������:</font></td>
				<td> <img src="images/bullet.png"></td>
				<td><input type="text" name="price" size="20" style="width:350px" class="cost"><span lang="ru"> </span></td>
				<td>&nbsp;</td>
				<td><b><font size="2" face="Arial" color="#333333">RUR</font></b><font size="2" face="Arial" color="#333333"> <a href="k9.html">��� ����� ������� ���������?</a></font></td>
			</tr>
			<tr>
				<td height="26" align="right">
				<font size="2" face="Arial" color="#333333">�����������:</font></td>
				<td height="26">&nbsp;</td>
				<td height="26">
				<textarea rows="2" name="coment" cols="20" style="width:350; height:100"></textarea></td>
				<td height="26">&nbsp;</td>
				<td height="26"><b><i><font size="2" face="Arial" color="#28A8BC">� �����������, ��� � � ������ ������, ���������
				���������� ������ ���������!</font></i></b><font size="2" face="Arial" color="#333333"><br>
				</font><font face="Arial" color="#333333" style="font-size: 8pt">������������ ����� �����������: 350 ��������</font></td>
			</tr>
		<script lang="javascript">
		function chek() {
		if(document.getElementById(\'pravila\').checked) {
		document.getElementById(\'sub\').disabled = false;
		} else {
		document.getElementById(\'sub\').disabled = true;
		}
		}</script>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan="3"><input id="pravila" type="checkbox" name="pravila" value="1" onchange="chek();"><font size="2" face="Arial" color="#333333">� <a href="k5.html">���������
				���������� �������</a> � ��������� ������� ��������</font></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td><input type="submit" value="�������� �����" name="B1" disabled id="sub"></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
		</table><form>';
	}else{	echo '<p align="center"><font size="2" face="Arial"><font color="#FF0000">�� �� ��������������� ������������. ��� ���������� ������
</font> <a href="k16.html">����������������</a><font color="#FF0000"> ��� </font> <a href="k20.html">��������</a><font color="#FF0000"> � �������</font></font></p>';
	}
}else{	require_once $_SERVER["DOCUMENT_ROOT"] . "/modul/custom_sessions.php"; CustomSessions::start();

	$_SESSION[error]=array();
	$_SESSION[result]=array();

	$_POST[price]=mysql_escape_string(strip_tags($_POST[price]));
	$_POST[coment]=mysql_escape_string(strip_tags($_POST[coment]));

	include "../mysql.php";
	include "sequrity.php";

	//$balans=@mysql_result(mysql_query("select balance from katalog_user where id_p='$_SESSION[userid]' limit 1"),0);
	if($_SESSION[logintrue]){

		if($_POST[podrazdel]==0){
		array_push($_SESSION[error],'�� �� ������� ���������');
		}
		if($_POST[price]==''){
		array_push($_SESSION[error],'�� �� ����� ����');
		}
		//if($_POST[price]>$balans){
		//array_push($_SESSION[error],'������������ �������. ��������� ���� <a href="k19.html">������</a>');
		//}
		if(!$_FILES["filename"]["size"]){
		array_push($_SESSION[error],'��� ����� ������');
		}else{		    if($_FILES["filename"]["type"]!='image/jpeg' and $_FILES["filename"]["type"]!='image/bmp' and $_FILES["filename"]["type"]!='image/png' and $_FILES["filename"]["type"]!='image/gif' and $_FILES["filename"]["type"]!='text/plain' and $_FILES["filename"]["type"]!='application/msword' and $_FILES["filename"]["type"]!='application/msword' and $_FILES["filename"]["type"]!='application/pdf' and $_FILES["filename"]["type"]!='application/x-rar-compressed' and $_FILES["filename"]["type"]!='application/zip'){
		    array_push($_SESSION[error],'����� ��������� �������');
        	}		}
		if($_FILES["filename"]["size"]/1024>10000){			array_push($_SESSION[error],'���� ��������� 10 ��, ������� �������');		}

			if(count($_SESSION[error])==0){
				$end_time=mktime($_POST[D4],0,0,$_POST[D2],$_POST[D1],$_POST[D3]);

				$sort=@mysql_result(mysql_query("select menu_sort from katalog where id_p='$_SESSION[userid]' and page_type='5' order by menu_sort desc limit 1"),0)+1;
				$razdel=@mysql_result(mysql_query("select id_p from katalog where id='$_POST[podrazdel]' limit 1"),0);

				mysql_query("insert into katalog(id_p,page_name,page_type,menu_vizible,menu_dozvil,menu_sort)
				values('$_SESSION[userid]','������ ������������ ID=$_SESSION[userid]','5','0','0','$sort')")or die(mysql_error());

				$id=mysql_insert_id();         //id uder
				$add_time=time();          	   //data add

                $_FILES['filename']['name']=translit($_FILES['filename']['name']);
        		$url="files/f_".$id."_".$_FILES['filename']['name'];
				copy($_FILES['filename']['tmp_name'], "../".$url);

                mysql_query("update katalog_user set zadach_zakaz=zadach_zakaz+1 where id_p='$_SESSION[userid]'");

				mysql_query("insert into katalog_zadach(id_p,end_time,price,razdel,podrazdel,userzakaz,url,add_time,coment)
				values('$id','$end_time','$_POST[price]','$razdel','$_POST[podrazdel]','$_SESSION[userid]','$url','$add_time','$_POST[coment]')")or die(mysql_error());
			}

		if(count($_SESSION[error])==0){array_push($_SESSION[result],'����� ������');header("Location:../k6.html");}
		else{header("Location:../k7.html");}
  	}else{
    	array_push($_SESSION[error],'�� �� ��������������� ������������. ��� ���������� ������ <a href="k16.html">����������������</a> � <a href="k20.html">��������</a> � �������');
    	header("Location:../k20.html");
	}}