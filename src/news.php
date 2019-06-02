<?
$key=3;
$r=mysql_query("select * from katalog where id_p='$key' and page_type='2' and menu_vizible='0' and menu_dozvil='0' order by menu_sort desc LIMIT 2");
if(@mysql_num_rows($r)!=0){
	echo '<div class="lastNews"><h3>ѕоследние новости</h3>';
	for($i=0;$i<@mysql_num_rows($r);$i++){
	$f=mysql_fetch_array($r);
	$fnews=mysql_fetch_array(mysql_query("select * from katalog_news where id_p='$f[id]' limit 1"));
	echo '
		<p><b>[',date('d.m.y H:i',$fnews[dat]),']</b><br>
		',$f[page_name],'
		<a href="k',$f[id],'-',$f[page_translit],'.html" title="',$f[page_name],'">подробнее ЫЫ</a>';
	}
 	echo '<center><a href="k3.html">все новости ЫЫ</a></center>
	</div>';
}
?>
