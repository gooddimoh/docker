<?
$key=3;
$r=mysql_query("select * from katalog where id_p='$key' and page_type='2' and menu_vizible='0' and menu_dozvil='0' order by menu_sort desc");
if(@mysql_num_rows($r)!=0){	echo '<p align="center"><b><font face="Arial" size="2" color="#192C36">ѕоследние новости</font></b><br>';
	for($i=0;$i<@mysql_num_rows($r);$i++){
	$f=mysql_fetch_array($r);
	$fnews=mysql_fetch_array(mysql_query("select * from katalog_news where id_p='$f[id]' limit 1"));
	echo '<font face="Arial" size="1" color="#192C36">.............................................................
		<p align="justify"><b>[',date('d.m.y H:i',$fnews[dat]),']</b></font><br>
		<font face="Arial" style="font-size: 8pt" color="#333333">',$f[page_name],'</font>
		<a href="k',$f[id],'-',$f[translit],'.html" title="',$f[page_name],'">подробнее ЫЫ</a>';
	}
 	echo '<p><font face="Arial" size="1" color="#192C36">.............................................................</font>
 	<center><a href="k3.html">все новости ЫЫ</a>';
}
?>