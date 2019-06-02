<div>
<? //---------------------- DETALNO
$r=mysql_query("SELECT * FROM katalog where id='$d' and id<>'0' and menu_dozvil='0' limit 1");
$f=mysql_fetch_array($r);

if($f[page_type]==1){
	$page = mysql_query("SELECT * FROM katalog_page where id_p='$d' limit 1");
	$pagef=mysql_fetch_array($page);
	$max_size_file = get_cfg_var('upload_max_filesize');
	$pagef[text]  = str_replace('%FILE_SIZE%', $max_size_file, $pagef['text']);
	echo $pagef[text];
}else if($f[page_type]==2){

	$page = mysql_query("SELECT * FROM katalog_news where id_p='$d' limit 1");
	$pagef=mysql_fetch_array($page);
	echo '<table border="0" width="100%" style="border:1px dotted #bbbbbb;" bgcolor="F5F9FA">
			<tr>
				<td valign=top style="padding:5px;text-align:justify">
					<font face="Arial" size="1" color="#192C36"><b>[',date('d.m.y H:i',$pagef[dat]),']</b></font>
					<font face="Arial" style="font-size: 8pt" color="#333333">',$f[page_name],'<p>
					',$pagef[text],'</font>
				</td>
			</tr>
		</table>';
}else{echo '<script lang="javascript">location.href=\'../\'</script>';}
?>
</div>
<div>
<? //-------------------- SPISOK
$rr=mysql_query("SELECT * FROM katalog where id_p='$d' and id_p<>'0' and menu_vizible='0' and menu_dozvil='0' and page_type<>'4' order by menu_sort asc");
$horizont=3;
echo '<center><table border=0 width="100%"><tr>';
for($i=0;$i<@mysql_num_rows($rr);$i++){

	$ff=mysql_fetch_array($rr);
	if($pt!='' and $pt!=$ff[page_type]){echo '</tr></table><br><table width="100%" border=0><tr>';}
	$pt=$ff[page_type];
	if($pk>=$horizont){echo '</tr><tr><td width=10% valign=top>';$pk=1;
	}else{$pk++;echo '<td width=10% valign=top>';}

	//---
	if($ff[page_type]==1){//-------page
		$r = mysql_query("SELECT * FROM katalog_page where id_p='$ff[id]' limit 1");
		$f=mysql_fetch_array($r);

		echo 'Х <a href="k',$ff[id],'-',$ff[page_translit],'.html" title="',$ff[page_name],'" id=pagekatalog>',$ff[page_name],'</a>';}

	//---
	else if($ff[page_type]==2){//-------news
		$r = mysql_query("SELECT * FROM katalog_news where id_p='$ff[id]' limit 1")or die(mysql_error());
		$f=mysql_fetch_array($r);
		$pk=$pk+$horizont-1;
		echo '<table border="0" width="100%" style="border:1px dotted #bbbbbb;" bgcolor="F5F9FA">
				<tr>
					<td valign=top style="padding:5px;text-align:justify">
						<font face="Arial" size="1" color="#192C36"><b>[',date('d.m.y H:i',$f[dat]),']</b></font>
						<font face="Arial" style="font-size: 8pt" color="#333333">',$ff[page_name],'</font>
						<a href="k',$ff[id],'-',$ff[translit],'.html" title="',$ff[page_name],'">подробнее ЫЫ</a>
					</td>
				</tr>
			</table>';}
}
echo '</tr></table></center>';
//-----------------------------------------------------------
?>
</div>