<?
include "mysql.php";
if (get_magic_quotes_gpc()) {
    function stripslashes_deep($value)
    {
        $value = is_array($value) ?
                    array_map('stripslashes_deep', $value) :
                    stripslashes($value);

        return $value;
    }

    $_POST = array_map('stripslashes_deep', $_POST);
    $_GET = array_map('stripslashes_deep', $_GET);
    $_COOKIE = array_map('stripslashes_deep', $_COOKIE);
}
//---translit
function translit($st){
	$st=strtr($st,"абвгдежзийклмнопрстуфыэАБВГДЕЖЗИЙКЛМНОПРСТУФЫЭ","abvgdegziyklmnoprstufieABVGDEGZIYKLMNOPRSTUFIE");
	$st=strtr($st,array('ё'=>"yo",'ї'=>"yi", 'х'=>"h", 'ц'=>"ts", 'ч'=>"ch", 'ш'=>"sh",'й'=>"y",
	            		'щ'=>"shch",'і'=>"i", 'ъ'=>"", 'ь'=>"", 'ю'=>"yu", 'я'=>"ya",
		                'Ё'=>"YO", 'Х'=>"H", 'Ц'=>"TS", 'Ч'=>"CH", 'Ш'=>"SH",'Й'=>"Y",
		                'Щ'=>"SHCH", 'Ъ'=>"", 'Ь'=>"", 'Ю'=>"YU", 'Я'=>"YA",
		                '№'=>"",'#'=>"",' '=>"_",'.'=>"",'!'=>"",'?'=>"",'-'=>"",'@'=>"",'('=>"_",')'=>"",'"'=>"","'"=>"","."=>"",","=>""));
	return $st;
}
$_POST[page_translit]=translit($_POST[page_translit]);
//---translit

if(isset($_POST[id_p])){$vuv=$_POST[id_p];}else{$vuv=$_GET[r];}

if(!isset($_POST[B2])){
//----sortkatalog
	$r = mysql_query("SELECT * FROM katalog where id_p='$_GET[r]' order by menu_sort desc limit 1")or die(mysql_error());//підрозділи теперішнього розділу
	$f=mysql_fetch_array($r);
	if(!isset($_POST[menu_sort])){$sort=$f[menu_sort]+1;}else{$sort=$_POST[menu_sort];}
//----sortkatalog
echo '
<center><a href="katalog.html?r=',$_GET[r],'" id=href>назад ‹‹</a><br><br>';
if(isset($_POST[B1])){echo '<form method="POST" action="katalog_add.php" ENCTYPE="multipart/form-data">';$_POST=str_replace('"', '&quot;', $_POST);}
else{echo '<form method="POST" action="katalog_add.html?r=',$_GET[r],'" ENCTYPE="multipart/form-data">';}
echo'
<table border="0" align=center width=780 style="border:1px solid #023761">
	<tr>
		<td width=150 align=left><font size="2" face="Arial">сорт.</td>
		<td width=20>&nbsp;</td>
		<td><input type="text" name="menu_sort" size="10" value="',$sort,'"> <font size="2" face="Arial">скрите меню <input type="checkbox" name="menu_vizible" value="1" ';if($_POST[menu_vizible]==1){echo 'checked';} echo '> <font size="2" face="Arial">не виводити <input type="checkbox" name="menu_dozvil" value="1" ';if($_POST[menu_dozvil]==1){echo 'checked';} echo '></td>
	</tr>
	<tr>
		<td align=left><font size="2" face="Arial">розділ</td>
		<td>&nbsp;</td>
		<td><select name=id_p style="width:550px"><option value="0" ';if($vuv==0){echo 'selected';$nopage=1;}echo '>Корінь сайту</option>';include "rozdil.php"; echo'</select></td>
	</tr>
	<tr>
		<td><font size="2" face="Arial">назва меню</td>
		<td>&nbsp;</td>
		<td><input type="text" name="page_name" style="width:550px" value="',$_POST[page_name],'"></td>
	</tr>
	<tr >
		<td><font size="2" face="Arial" color="#023761">назва сторінки</td>
		<td>&nbsp;</td>
		<td><input type="text" name="page_title" style="width:550px" value="',$_POST[page_title],'"></td>
	</tr>
	<tr >
		<td><font size="2" face="Arial" color="#023761">короткий опис сторінки</td>
		<td>&nbsp;</td>
		<td><textarea rows="4" name="page_descr" style="width:550px">',$_POST[page_descr],'</textarea></td>
	</tr>
	<tr >
		<td><font size="2" face="Arial" color="#023761">ключові слова</td>
		<td>&nbsp;</td>
		<td><input type="text" name="page_keyword" style="width:550px" value="',$_POST[page_keyword],'"></td>
	</tr>
	<tr>
		<td><font size="2" face="Arial">Translit</td>
		<td>&nbsp;</td>
		<td><input type="text" name="page_translit" style="width:280px" value="',$_POST[page_translit],'"></td>
	</tr>
';if(!isset($_POST[B1])){echo '
	<tr>
		<td><font size="2" face="Arial">тип сторінки</td>
		<td>&nbsp;</td>
		<td>
			<table border="0" id="table1">
				<tr>
					<td><input type="radio" value="1" ';if($_POST[page_type]==1 or $_POST[page_type]==''){echo 'checked';}echo ' name="page_type" ></font></td>
					<td><font face="Arial" style="font-size: 8pt">рубр.\розд.\стор.</font></td>
					<td><input type="radio" value="2" ';if($_POST[page_type]==2){echo 'checked';}echo ' name="page_type"></font></td>
					<td><font face="Arial" style="font-size: 8pt">новина</font></td>
				</tr>
			</table>
		</td>
	</tr>';}else{echo '<input type=hidden name=page_type value=',$_POST[page_type],'>';}echo '
</table>';if(!isset($_POST[B1])){echo '<p align=center><input type="submit" value="Продовжити" name="B1"></p>';}
//---------------------------------------------------------------
if(isset($_POST[B1])){

if($_POST[page_type]==1){
echo '<br>
<table border="0" align=center width=780>
	<tr>
		<td colspan="3">
		';
include("./editor/fckeditor.php");
$oFCKeditor = new FCKeditor('textarea') ;
$oFCKeditor->BasePath	= './editor/';
$oFCKeditor->Value = '';
$oFCKeditor->Width = 780;
$oFCKeditor->Height = 300;
$oFCKeditor->Create() ;
echo '
		</td>
	</tr>
</table>';
}
//-------------------------------------------------------------------
else if($_POST[page_type]==2){
echo '<br>
<table border="0" align=center width=780>
	<tr>
		<td>
		';
include("./editor/fckeditor.php");
$oFCKeditor = new FCKeditor('textarea') ;
$oFCKeditor->BasePath	= './editor/';
$oFCKeditor->Value = '';
$oFCKeditor->Width = 780;
$oFCKeditor->Height = 300;
$oFCKeditor->Create() ;
echo '
	</td>
	</tr>
</table>';
}
//-------------------------------------------------------------------
echo '<p align=center><input type="submit" value="Створити сторінку" name="B2"></p>';

}echo '</form>';
//=====================================================================
}else{
include "mysql.php";
$data=time();
$_POST=str_replace("'", "\'", $_POST);

//-----sort
$r = mysql_query("SELECT * FROM katalog where id_p='$_POST[id_p]' order by menu_sort asc")or die(mysql_error());//підрозділи теперішнього розділу
for($i=0;$i<mysql_num_rows($r);$i++){
	$f=mysql_fetch_array($r);
	if(!$issort){
		if($_POST[menu_sort]<$f[menu_sort]){$i=mysql_num_rows($r);}
		else if($_POST[menu_sort]==$f[menu_sort]){$issort=1;}
	}
	if($issort){
		$f[menu_sort]=$f[menu_sort]+1;
		mysql_query("update katalog set menu_sort='$f[menu_sort]' where id='$f[id]' limit 1");
	}
}
//-----sort

mysql_query("insert into katalog(page_translit,id_p,page_title,page_descr,page_keyword,page_name,page_type,menu_vizible,menu_dozvil,menu_sort)
values('$_POST[page_translit]','$_POST[id_p]','$_POST[page_title]','$_POST[page_descr]','$_POST[page_keyword]','$_POST[page_name]','$_POST[page_type]','$_POST[menu_vizible]','$_POST[menu_dozvil]','$_POST[menu_sort]')")or die(mysql_error());

$id=mysql_insert_id();
//------------------------------------------------------------------
if($_POST[page_type]==1){
mysql_query("insert into katalog_page(id_p,text) values('$id','$_POST[textarea]')")or die(mysql_error());
}
//------------------------------------------------------------
else if($_POST[page_type]==2){
$dat=time();mysql_query("insert into katalog_news(id_p,text,dat) values('$id','$_POST[textarea]','$dat')")or die(mysql_error());}
header("Location: katalog.html?r=".$_POST[id_p]);exit();
}