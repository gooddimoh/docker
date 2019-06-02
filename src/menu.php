<?
$key=1;
$r=mysql_query("select * from katalog where id_p='$key' and page_type='1' and menu_vizible='0' and menu_dozvil='0' order by menu_sort asc");
for($i=0;$i<@mysql_num_rows($r);$i++){
$f=mysql_fetch_array($r);
if($f['id']!=4)
echo '<tr>
		<td width="12">
		<img alt="" border="0" src="images/rozdil.gif" width="12" height="12"></td>
		<td><a class=leftmenu href="k',$f[id],'-',$f[page_translit],'.html" title="',$f[page_name],'">',$f[page_name],'</a></td>
	</tr>';
else
echo '<tr>
		<td width="12">
		<img alt="" border="0" src="images/rozdil.gif" width="12" height="12"></td>
		<td><a class=leftmenu href="/" title="',$f[page_name],'">',$f[page_name],'</a></td>
	</tr>';
}
?>