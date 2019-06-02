<?$starttime=time();?>
<html>
<head>
<title>WEBMARKER CMS v2.5</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<link rel="stylesheet" type="text/css" href="style.css">
<script type="text/javascript" src="../jquery/jquery.min.js"></script>
<script type="text/javascript" src="../key.js"></script>
</head>
<?include "mysql.php";?>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" style="background:url('images/fon.jpg') repeat-x 0% 0%">
	<tr>
		<td height=140 style="background: url('images/logo.jpg') 0% 0% no-repeat;">
		<table border="0" width="100%" height=140 cellpadding=0 cellspacing=0>
			<tr>
				<td rowspan="2" width="194">
				<a href="info.html"><img border="0" src="images/info.png" width="45" height="72"></a></td>
				<td valign=bottom><font size="2" face="Arial" color="#FFFFFF">WEBMARKER CMS v2.5</font></td>
			</tr>
			<tr>
				<td valign=bottom height="54" style="padding-bottom:5px">
				<table border="0" cellpadding=0 cellspacing=0>
					<tr>
						<td>
						<img border="0" src="images/menu_left.jpg" width="13" height="29"></td>
						<td style="background:url('images/menu_center.jpg') repeat-x 0% 0%"><a href="./" id=topmenu>Головна</a></td>
						<td>
						<img border="0" src="images/menu_right.jpg" width="13" height="29"></td>
						<td>
						<img border="0" src="images/menu_left.jpg" width="13" height="29"></td>
						<td style="background:url('images/menu_center.jpg') repeat-x 0% 0%"><a href="http://<?echo $_SERVER['HTTP_HOST'];?>" target=_blank id=topmenu>Перейти на сайт</a></td>
						<td>
						<img border="0" src="images/menu_right.jpg" width="13" height="29"></td>
					</tr>
				</table>
				</td>
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td align=left style="padding:20px;" valign=top>
			<? include "content.php";?><br>
			<font color=#aaaaaa face="arial" size=2>Виконано за: <?$endtime=time();echo ceil(date('s',$endtime-$starttime));?> с.</font>
		</td>
	</tr>
</table>
</body>
</html>