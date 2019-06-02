<?
//if($_SESSION[logintrue]){
$f=mysql_fetch_array(mysql_query("select rozdil,url,dat_birth,dat_reg,id_p,login,dat_enter,coment,gorod,univer,zadach_zakaz,zadach,resh from katalog_user where id_p='$_GET[id_user]' limit 1"));
echo '
<table border="0" cellpadding="5" bgcolor="ffffff">
	<tr bgcolor="365C71">
		<td>
			<table border=0 cellpadding="0" cellspacing="0">
				<tr><td><img alt=""  src="images/report_user.png" border=0 hspace=2></td>
					<td><a href="#" class=infobold>Просмотр профиля пользователя ',$f[login],' (ID=',$f[id_p],')</a></td>
				</tr>
			</table>
		</td>
	</tr>
</table><table width="100%" cellpadding="10"><tr><td style="border:1px solid #70A0BA">
<table border="0" width=700 align=center>
	<tr>
		<td rowspan="5" width=200 valign=middle align=center><img alt=""  src="';
		if($f[url]==''){echo 'images/nophoto.png';}else{echo $f[url];}
		echo '"></td><td width=10></td>
		<td valign=top>
			<table border="0" id="table1">
				<tr>
					<td><font size="2" face="Arial" color="#333333">
					Пользователь:</font></td>
					<td>&nbsp;</td>
					<td><font size="2" face="Arial" color="#333333">
					',$f[login],'</font></td>
				</tr>
				<tr>
					<td><font size="2" face="Arial" color="#333333">
					Группа:</font></td>
					<td>&nbsp;</td>
					<td><font size="2" face="Arial" color="#333333">
					';if($f[resh]==0){echo 'Пользователи';}else{echo 'Решающие';} echo '</font></td>
				</tr>
				<tr>
					<td><font size="2" face="Arial" color="#333333">
					Дата регистрации:</font></td>
					<td>&nbsp;</td>
					<td><i><b>
					<font size="2" face="Arial" color="#333333">
					',date('d/m/y H:i',$f[dat_reg]),'</font></b></i></td>
				</tr>
				<tr>
					<td><font size="2" face="Arial" color="#333333">
					Последняя активность:</font></td>
					<td>&nbsp;</td>
					<td><i><b>
					<font size="2" face="Arial" color="#333333">
					';if($f[dat_enter]){echo date('d/m/y H:i',$f[dat_enter]);}else{echo 'Не было активности';}echo '</font></b></i></td>
				</tr>
				<tr>
					<td><font size="2" face="Arial" color="#333333">
					Количество заказанных задач:</font></td>
					<td>&nbsp;</td>
					<td><font size="2" face="Arial" color="#333333">
				    <a href="k6.html?id_from_usr='.$f[id_p].'&sts=1">',$f[zadach_zakaz],'</a></font></td>
				</tr>';
				if($f[resh]){
				echo '<tr>
					<td><font size="2" face="Arial" color="#00AAD1">
					Количество решенных задач:</font></td>
					<td>&nbsp;</td>
					<td><font size="2" face="Arial" color="#00AAD1">
					<a href="k6.html?id_from_usr='.$f[id_p].'&sts=2">',$f[zadach],'</a></font></td>
				</tr>
				<tr>
					<td><font size="2" face="Arial" color="#00AAD1">
					Решаемые разделы:</font></td>
					<td>&nbsp;</td>
					<td><font size="2" face="Arial" color="#00AAD1"><b>';
					$rozdil=mysql_query("select page_name,id from katalog where id_p='15'");
					$rozdil_p = explode(",", $f[rozdil]);
					for($i=1;$i<=@mysql_num_rows($rozdil);$i++){
						$rozdilf=mysql_fetch_array($rozdil);
						if(in_array($rozdilf[id],$rozdil_p)){echo $rozdilf[page_name],', ';}
					;}
					echo '</b></font></td>
				</tr>';
				}
                
                $buf_q = mysql_query('SELECT COUNT(*) FROM katalog_otzivi WHERE userto = '.$f[id_p]);
                $otziv_count = mysql_fetch_row($buf_q);
                echo '<tr>
					<td><font size="2" face="Arial" color="#333333">
					Отзывы:</font></td>
					<td>&nbsp;</td>
					<td><font size="2" face="Arial" color="#333333">
					'.($otziv_count[0] > 0 ? '<a href="k12-otzivi_o_proekte_reshenie_zadach.html?ot_from='.$f[id_p].'">'.$otziv_count[0].'</a>' : $otziv_count[0]).'
                    </font></td>
				</tr>
                ';
                
				echo '<tr>
					<td><font size="2" face="Arial" color="#333333">
					Город:</font></td>
					<td>&nbsp;</td>
					<td><font size="2" face="Arial" color="#333333">
					',$f[gorod],'</font></td>
				</tr>
				<tr>
					<td><font size="2" face="Arial" color="#333333">
					Место учебы:</font></td>
					<td>&nbsp;</td>
					<td><font size="2" face="Arial" color="#333333">
					',$f[univer],'</font></td>
				</tr>
				<tr>
					<td><font size="2" face="Arial" color="#333333">
					Возраст:</font></td>
					<td>&nbsp;</td>
					<td><font size="2" face="Arial" color="#333333">
					',$f[dat_birth],'</font></td>
				</tr>
				<tr>
					<td><font size="2" face="Arial" color="#333333">
					Комментарии:</font></td>
					<td>&nbsp;</td>
					<td><font size="2" face="Arial" color="#333333">
					',$f[coment],'</font></td>
				</tr>';


				$q2 = mysql_query('SELECT * FROM katalog_metods WHERE user_id = '.(int)$_GET[id_user].' AND status = 1' );
				if(1||mysql_num_rows($q2)) echo '<tr>
					<td><font size="2" face="Arial" color="#333333">
					Методички/курсовые:</font></td>
					<td>&nbsp;</td>
					<td><font size="2" face="Arial" color="#333333">
					<a href="/k136.html?user_id='.(int)$_GET[id_user].'">'.mysql_num_rows($q2).'</a>'.($_GET[id_user]==$_SESSION['userid']&&$_SESSION[logintrue]?'&nbsp;<a href="/k135.html">(редактировать)</a>':'').'</font></td>
				</tr>';
                 if($_SESSION['logintrue']==1) echo '
                <tr>
                  <td>
                   <a class="thickbox" href="/modul/messagea.php?form=2&noerr&id=',$f[id_p],'&TB_iframe=true&modal=false&height=300&width=590" title="Написать письмо">Написать письмо</a>
			      </td>
                </tr>';
                
                echo '
            </table>
		</td>
	</tr>
</table></td></tr></table>';
/*}else{
	$_SESSION[error]=array();
	$_SESSION[result]=array();
	array_push($_SESSION[error],'У Вас недостаточно прав для просмотра детальной информации про пользователя. Зарегистрируйтесь или ввойдите в систему');
	echo '<script lang="javascaript">location.href="./"</script>';
}*/
?>