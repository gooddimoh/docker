<?
//$max_size_file = '500Kb';//get_cfg_var('upload_max_filesize');
//$max_size_file_int =(int)$max_size_file;
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
//var_dump($_SERVER['REQUEST_METHOD']); die();
//if(!isset($_POST[B1])){
if($_SERVER['REQUEST_METHOD'] != 'POST'){
	if($_SESSION[logintrue]){
		$f=mysql_fetch_array(mysql_query("select url,mesmes,meszad,polz,zad,icq,tel,gorod,univer,dat_birth,coment from katalog_user where id_p='$_SESSION[userid]' limit 1"));
		echo '
		<script lang="javascript">
			function show(temp){
				for(i=1;i<=2;i++){
					document.getElementById(\'form\'+i).style.display="none";
				}
				document.getElementById(temp).style.display="block";
			}
		</script>
			<table class="tabs" border="0" cellpadding="5" bgcolor="ffffff">
				<tr bgcolor="365C71">
					<td>
						<table border=0 cellpadding="0" cellspacing="0">
							<tr><td><img alt=""  src="images/tree.png" border=0 hspace=2></td>
								<td><a onclick="show(\'form1\')" href="#" class=infobold>��� �����</a></td>
							</tr>
						</table>
					</td>
					<td><a onclick="show(\'form2\')" href="#" class=infobold>��������� ����</a></td>
				</tr>
			</table><table width="100%" cellpadding="10"><tr><td style="border:1px solid #70A0BA">';
			echo '
<!---->		<form enctype="multipart/form-data" action="modul/files.php" method=post id="form2" ';if($_GET[form]==2){echo 'style="display:block"';}else{echo 'style="display:none"';} echo '>
			<table border="0" width="100%" id="table1">
				<tr>
					<td>
					<p align="justify"><font size="2" face="Arial">�&nbsp;������ ������� �� ������ ��������� ��
					<font color="#006666"><b>10 ������</b>.</font> ������ ������
					����� �� ����� ��������� <font color="#006666"><b>'.$max_size_file.'</b>.</font>
					����� ����� ���� ������ �� ��������� ����������: </font></p>
					<p align="justify"><font face="Arial" size="2"><font color="#006666">
					���������: TXT, DOC (Microsoft Word), DOCX (Microsoft Word 2007), PDF<br>
					�����������: JPG, GIF, PNG<br>
					������: RAR, ZIP</font><br>
					<br>
					������������ ���� �������� ������ �� ������� -<font color="#006666"><b> 2 ������</b>,</font> ����� �����
					������������� ���������. ����� �������� ���� ������� ������������
					������� ������ ���������� ������ �� ���� � ���. ������ � ����, ���
					���������� ������ ����� ���� ������ ��, ��� ��������������� ��������� �
					������� (��������������� ���������, ������� � �.�.).</font></td>
				</tr>
				<tr>
					<td>
					&nbsp;</td>
				</tr>
				<tr>
					<td>
					<table border="0" id="table2">
						<tr>
							<td><b><font face="Arial" size="2" color="#006666">����:</font></b></td>
							<td><input type="file" name="filename" size="20"></td>
							<td><input type="submit" value="���������" name="B1"></td>
						</tr>
					</table>
					</td>
				</tr>
			</table></form>
<!---->		<form action="modul/files.php" method=post id="form1" ';if(!isset($_GET[form]) or $_GET[form]==1){echo 'style="display:block"';}else{echo 'style="display:none"';} echo '>
			<table border="0" width="100%" cellspacing="1" cellpadding="0" bgcolor="#cccccc">
				<tr>
					<td height="25" width=150 bgcolor="#365C71" align="center"><span lang="ru">
					<font size="2" face="Arial" color="#FFFFFF">���� ��������</font></span></td>
					<td height="25" width=150 bgcolor="#365C71" align="center"><span lang="ru">
					<font size="2" face="Arial" color="#FFFFFF">���� �������� ��</font></span></td>
					<td height="25" bgcolor="#365C71" align="center"><span lang="ru">
					<font size="2" face="Arial" color="#FFFFFF">������ ��� ����������</font></span></td>
					<td height="25" bgcolor="#365C71" align="center"><span lang="ru">
					<font size="2" face="Arial" color="#FFFFFF">������</font></span></td>
					<td width=20px height="25" bgcolor="#365C71" align="center"></td>
				</tr>';

			$r=mysql_query("select * from katalog_files where user='$_SESSION[userid]' order by data_create desc");

			for($i=1;$i<=@mysql_num_rows($r);$i++){
			$f=mysql_fetch_array($r);
			echo '<tr bgcolor="#ffffff" onmouseover="this.style.backgroundColor=\'#ECF7FF\'" onmouseout="this.style.backgroundColor=\'#ffffff\'">
			<td align=center><font color="#333333" face="Arial" style="font-size: 11px">',date('d.m.y H:i',$f[data_create]),'</td>
			<td align=center><font color="#333333" face="Arial" style="font-size: 11px">',date('d.m.y',$f[data_create]+1209600),'</td>
			<td align=center><font color="#333333" face="Arial" style="font-size: 11px">http://stud-help.com/modul/download.php?id=',$f[id],'&f</td>
			<td align=center><font color="#333333" face="Arial" style="font-size: 11px">',round(filesize($f[url])/1024/1024,2),' ��.</td>
			<td align=center><a href="modul/uploaddel.php?id=',$f[id],'"><img alt=""  src="images/mail_del.gif" border=0></a></td>
					</tr>';
			}
			echo '
			</table></form>
		</td></tr></table>';
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
        
        if($_FILES["filename"]["error"] == UPLOAD_ERR_NO_FILE){
		array_push($_SESSION[error],'��� �����');
		}else{
		    if (end(explode(".",$_FILES['filename']['name'])) == 'php') {
         //   if($_FILES["filename"]["type"]!='image/jpeg' and $_FILES["filename"]["type"]!='image/bmp' and $_FILES["filename"]["type"]!='image/png' and $_FILES["filename"]["type"]!='image/gif' and $_FILES["filename"]["type"]!='text/plain' and $_FILES["filename"]["type"]!='application/msword' and $_FILES["filename"]["type"]!='application/msword' and $_FILES["filename"]["type"]!='application/pdf' and $_FILES["filename"]["type"]!='application/x-rar-compressed' and $_FILES["filename"]["type"]!='application/zip'){
		    array_push($_SESSION[error],'����� ��������� �������');
        	}
		}
		if($_FILES["filename"]["size"]>$max_size_file_int || $_FILES["filename"]["error"] == UPLOAD_ERR_INI_SIZE || !count($_FILES)){
			array_push($_SESSION[error],'���� ��������� '. $max_size_file .', ������� �������');
		}
		$r=mysql_query("select id from katalog_files where user='$_SESSION[userid]'");
		if(@mysql_num_rows($r)>=10){
			array_push($_SESSION[error],'�������� ����� ���������� ������');
		}

			if(count($_SESSION[error])==0){

                $_FILES['filename']['name']=translit($_FILES['filename']['name']);
        		$url="uploads/f_".$data."_".$_SESSION[userid]."_".$_FILES['filename']['name'];
				copy($_FILES['filename']['tmp_name'], "../".$url);

				mysql_query("insert into katalog_files(url,data_create,user) values('$url','$data','$_SESSION[userid]')")or die(mysql_error());
			}

		if(count($_SESSION[error])==0){array_push($_SESSION[result],'���� ������� ��������');header("Location:../k134.html?form=1");}
		else{header("Location:../k134.html");}
  	}else{
    	array_push($_SESSION[error],'�� �� ��������������� ������������. <a href="k20.html">�������</a> � �������');
    	header("Location:../");
	}
}
?>