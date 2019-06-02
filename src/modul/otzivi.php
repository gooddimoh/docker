<?if(!isset($_POST[B1])){
	if($_SESSION[logintrue]){
		echo '
		<hr style="color: #70A0BA;background-color:#70A0BA;border:0px none;height:1px;clear:both;" size=0>
		<b><i><font size="2" face="Arial" color="#28A8AE">Добавить отзыв</font></i></b>
		<form action="modul/otzivi.php" method=post>
			<table border="0">
				<tr>
					<td align="right"><font face="Arial" size="2">Отзыв о:</font></td>
					<td>
					</td>
					<td><select size="1" name="to" style="width:200px">
						<option value="0">Системе</option>';
						$r=mysql_query("select id_p,login from katalog_user where id_p<>'$_SESSION[userid]' order by login");
						for($i=0;$i<@mysql_num_rows($r);$i++){
							$f=mysql_fetch_array($r);
							echo '<option '.($_GET[usr_id] == $f[id_p] || $_GET[ot_from] == $f[id_p] ? 'selected="true"':'').' value="',$f[id_p],'">',$f[login],'</option>';
						}
						echo '</select></td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td align="right"><font size="2" face="Arial">Текст отзыва:</font></td>
					<td>
					</td>
					<td><textarea rows="5" name="text" cols="34" onkeypress="return imposeMaxLength(this, 2000);"></textarea></td>
					<td>
					<b><i><font size="2" face="Arial" color="#28A8AE">В отзыве оставлять контактные данные запрещено!</font></i></b><font face="Arial" style="font-size: 8pt"><br>
					Максимальная длина письма: 2000 символов</font></td>
				</tr>
				<tr>
					<td align="right">&nbsp;</td>
					<td>&nbsp;</td>
					<td><input type="submit" value="Добавить отзыв" name="B1"></td>
					<td>&nbsp;</td>
				</tr>
			</table>
		</form>';}
	echo '<hr style="color: #70A0BA;background-color:#70A0BA;border:0px none;height:1px;clear:both;" size=0><b><i><font size="2" face="Arial" color="#28A8AE">Отзывы</font></i></b><p>';

    $allr=mysql_query("select id_p from katalog_otzivi".(isset($_GET['ot_from']) ? ' WHERE userto = '.$_GET['ot_from'] : ''));

    if(!isset($_GET[first])){$_GET[first]=0;}
	if(isset($_GET[first])){$limitstr=' limit '.$_GET[first].',20 ';}

	$r=mysql_query("select id,page_name,page_descr from katalog where menu_dozvil='0' and menu_vizible='0' and page_type='9' order by id desc ".$limitstr);
	for($i=0;$i<@mysql_num_rows($r);$i++){
		$f=mysql_fetch_array($r);
		$ff=mysql_fetch_array(mysql_query("select data_create,userto,userfrom from katalog_otzivi where id_p='$f[id]' limit 1"));
        if (isset($_GET['ot_from'])) 
            if ($_GET['ot_from'] != $ff[userto]) continue;
		$fto=mysql_fetch_array(mysql_query("select login from katalog_user where id_p='$ff[userto]' limit 1"));
		$ffrom=mysql_fetch_array(mysql_query("select login from katalog_user where id_p='$ff[userfrom]' limit 1"));
		echo '<table border="0" width="100%" id="table1">
		<tr><td style="border-bottom:1px #999999 dotted;" bgcolor="#F8F8F8"><a href="k77.html?id_user=',$ff[userfrom],'"  class=blue>',$ffrom[login],'</a>
		<font face="Arial" color="#666666" size="2"> (',date('d.m.y H:i',$ff[data_create]),')</b></font></i>
		</tr><tr><td><font face="Arial" size="2">',$f[page_descr],'<br>(
		отзыв о ';
		if($ff[userto]!=0){echo '<a href="k77.html?id_user=',$ff[userto],'"  class=blue>',$fto[login],'</a>';}
		else{echo 'системе';}echo ' )</font></td></tr></table>';
	}
	echo '<center><font size="2" face="Arial">Страница:';
	for($i=0;$i<ceil(@mysql_num_rows($allr)/20);$i++){
		echo '<a href="',$ide,'.html?first=',$i*20,'" class=blue><b>',$i+1,'</b></a>. ';
	}
}else{
	require_once $_SERVER["DOCUMENT_ROOT"] . "/modul/custom_sessions.php"; CustomSessions::start();

	$_SESSION[error]=array();
	$_SESSION[result]=array();

	$_POST[text]=mysql_escape_string(strip_tags($_POST[text]));

	include "../mysql.php";
	include "sequrity.php";

	if($_SESSION[logintrue]){

		$sort=@mysql_result(mysql_query("select menu_sort from katalog where id_p='12' and page_type='9' order by menu_sort desc limit 1"),0)+1;

		mysql_query("insert into katalog(id_p,page_descr,page_name,page_type,menu_vizible,menu_dozvil,menu_sort)
		values('12','$_POST[text]','$_SESSION[userlogin]','9','1','0','$sort')")or die(mysql_error());

		$id=mysql_insert_id();         //id uder
		$data=time();          	   //data add

		mysql_query("insert into katalog_otzivi(id_p,data_create,userfrom,userto)
		values('$id','$data','$_SESSION[userid]','$_POST[to]')")or die(mysql_error());
		array_push($_SESSION[result],'Отзыв принят и будет опубликован после проверки');
	}else{array_push($_SESSION[error],'Вы ввошли как незарегистрированный пользователь');}
header("Location:../k12.html");
}