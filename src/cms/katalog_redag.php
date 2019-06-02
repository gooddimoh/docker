<?
include "mysql.php";

$config=mysql_fetch_array(mysql_query("select procent from katalog_config limit 1"));

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
$r = mysql_query("SELECT * FROM katalog where id='$_GET[r]' limit 1")or die(mysql_error());//підрозділи теперішнього розділу
$f=mysql_fetch_array($r);

$rf = mysql_query("SELECT resh FROM katalog_user where id_p='$_GET[r]' limit 1");
$rf = mysql_fetch_assoc($rf);
if ($rf[resh]==1)
{
   $q1 = mysql_query('SELECT * FROM usr_stavka WHERE usr_id = '.$_GET[r]); 
   if (mysql_num_rows($q1) > 0)
   {
     $q1 = mysql_fetch_assoc($q1);
     if (isset($_POST[B1])) 
     mysql_query('UPDATE usr_stavka SET stavka = '.$_POST[stavka].' WHERE usr_id = '.$_GET[r]);
     
     $config[procent] = 100-$q1['stavka'];
   }
   else
   {
     if (isset($_POST[B1]) && (100-$config[procent]) != $_POST[stavka]) 
     mysql_query('INSERT INTO usr_stavka VALUES ('.$_GET[r].','.$_POST[stavka].')');
   }
}

$f=str_replace('"', '&quot;', $f);
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
if(isset($_POST[page_translit])){$translit=translit($_POST[page_translit]);}else{$translit=translit($f[page_translit]);}
//---translit

if(isset($_POST[id_p])){$vuv=$_POST[id_p];}else{$vuv=$f[id_p];}

if(!isset($_POST[B1])){

echo '<center><a href="katalog.html?r=',$f[id_p],'" id=href>>> назад</a>
<form method="POST" action="katalog_redag.php?r=',$_GET[r],'" ENCTYPE="multipart/form-data" onsubmit="if(this.pas.value) return confirm(\'Вы действительно хотите установить новый пароль?\');">
<input type="hidden" name="page_type" value="',$f[page_type],'">
<table border="0" align=center width=780 style="border:1px solid #023761">
	<tr>
		<td width=150 align=left><span lang="uk"><font size="2" face="Arial">сорт.</span></td>
		<td width=20>&nbsp;</td>
		<td><input type="text" name="menu_sort" size="10" value="',$f[menu_sort],'"> <font size="2" face="Arial">скрите меню</span> <input type="checkbox" name="menu_vizible" value="1" ';if($f[menu_vizible]==1){echo 'checked';} echo '> <font size="2" face="Arial">не виводити</span> <input type="checkbox" name="menu_dozvil" value="1" ';if($f[menu_dozvil]==1){echo 'checked';} echo '></td>
	</tr>
	<tr>
		<td align=left><span lang="uk"><font size="2" face="Arial">розділ</span></td>
		<td>&nbsp;</td>
		<td><select name=id_p style="width:550px"><option value="0" ';if($vuv==0){echo 'selected';$nopage=1;}echo '>Корінь сайту</option>';include "rozdil.php"; echo'</select></td>
	</tr>
	<tr>
		<td><font size="2" face="Arial">назва меню</td>
		<td>&nbsp;</td>
		<td><input type="text" name="page_name" style="width:550px" value="',$f[page_name],'"></td>
	</tr>
	<tr >
		<td><font size="2" face="Arial" color="#023761">назва сторінки (Title)</td>
		<td>&nbsp;</td>
		<td><input type="text" name="page_title" style="width:550px" value="',$f[page_title],'"></td>
	</tr>
	<tr >
		<td><font size="2" face="Arial" color="#023761">короткий опис сторінки <br /> (description)</td>
		<td>&nbsp;</td>
		<td><textarea rows="4" name="page_descr" style="width:550px">',$f[page_descr],'</textarea></td>
	</tr>
	<tr >
		<td><font size="2" face="Arial" color="#023761">ключові слова (keyword)</td>
		<td>&nbsp;</td>
		<td><input type="text" name="page_keyword" style="width:550px" value="',$f[page_keyword],'"></td>
	</tr>
	<tr>
		<td><span lang="uk"><font size="2" face="Arial">Translit</span></td>
		<td>&nbsp;</td>
		<td><input type="text" name="page_translit" style="width:300px" value="',$translit,'"></td>
	</tr>
</table>';
//---------------------------------- PAGE

if($f[page_type]==1){
$rf = mysql_query("SELECT * FROM katalog_page where id_p='$_GET[r]' limit 1")or die(mysql_error());//підрозділи теперішнього розділу
$ff=mysql_fetch_array($rf);
echo '<br>
<table border="0" id="table1" align=center width=780>
	<tr>
		<td colspan="3">';
include("editor/fckeditor.php");
$oFCKeditor = new FCKeditor('textarea') ;
$oFCKeditor->BasePath	= './editor/';
$oFCKeditor->Value = $ff[text];
$oFCKeditor->Width = 780;
$oFCKeditor->Height = 300;
$oFCKeditor->Create() ;
echo '</td>
	</tr>
</table>';

echo '<br><h1>Уникальное описание<h1/>
<table border="0" id="table11" align=center width=780>
	<tr>
		<td colspan="3">';
$oFCKeditor2 = new FCKeditor('bottom_text');
$oFCKeditor2->BasePath	= './editor/';
$oFCKeditor2->Value = $f[bottom_text];
$oFCKeditor2->Width = 780;
$oFCKeditor2->Height = 300;
$oFCKeditor2->Create() ;
echo '</td>
	</tr>
</table>';
}
//----------------------------------- NEWS
else if($f[page_type]==2){
$rf = mysql_query("SELECT * FROM katalog_news where id_p='$_GET[r]' limit 1")or die(mysql_error());//підрозділи теперішнього розділу
$ff=mysql_fetch_array($rf);
echo '<br>
<table border="0" id="table1" align=center width=780>
	<tr>
		<td colspan="3">';
include("editor/fckeditor.php");
$oFCKeditor = new FCKeditor('textarea') ;
$oFCKeditor->BasePath	= './editor/';
$oFCKeditor->Value = $ff[text];
$oFCKeditor->Width = 780;
$oFCKeditor->Height = 300;
$oFCKeditor->Create() ;
echo '</td>
	</tr>
</table>';
}
//------------------------------- USER
else if($f[page_type]==4){
$rf = mysql_query("SELECT * FROM katalog_user where id_p='$_GET[r]' limit 1")or die(mysql_error());//підрозділи теперішнього розділу
$ff=mysql_fetch_array($rf);
echo '<br>
<table width=780 style="border:1px solid #023761" align=center >
	<tr>
		<td width=150><font face="Arial" size="2">логин</font></td>
		<td width=20>&nbsp;</td>
		<td><input type="text" name="login" size="20" style="width:300px" value="',$ff[login],'"></td>
	</tr>
	<tr>
		<td width=150><font face="Arial" size="2">новый пароль</font></td>
		<td width=20>&nbsp;</td>
		<td><input type="text" name="pas" size="20" style="width:300px"> - оставить пустым если не нужно изменять</td>
	</tr>
	<tr>
		<td width=150><font face="Arial" size="2">email</font></td>
		<td width=20>&nbsp;</td>
		<td><input type="text" name="email" size="20" style="width:300px" value="',$ff[email],'"></td>
	</tr>
	<tr>
		<td width=150><font face="Arial" size="2">icq</font></td>
		<td width=20>&nbsp;</td>
		<td><input type="text" name="icq" size="20" style="width:300px" value="',$ff[icq],'"></td>
	</tr>
	<tr>
		<td width=150><font face="Arial" size="2">телефон</font></td>
		<td width=20>&nbsp;</td>
		<td><input type="text" name="tel" size="20" style="width:300px" value="',$ff[tel],'"></td>
	</tr>
	<tr>
		<td width=150><font face="Arial" size="2">код провірки</font></td>
		<td width=20>&nbsp;</td>
		<td><input type="text" name="generetedkey" size="20" style="width:300px" value="',$ff[generetedkey],'"></td>
	</tr>
	<tr>
		<td width=150><font face="Arial" size="2">місто</font></td>
		<td width=20>&nbsp;</td>
		<td><input type="text" name="gorod" size="20" style="width:300px" value="',$ff[gorod],'"></td>
	</tr>
	<tr>
		<td width=150><font face="Arial" size="2">освіта</font></td>
		<td width=20>&nbsp;</td>
		<td><input type="text" name="univer" size="20" style="width:300px" value="',$ff[univer],'"></td>
	</tr>
	<tr>
		<td width=150><font face="Arial" size="2">вік</font></td>
		<td width=20>&nbsp;</td>
		<td><input type="text" name="dat_birth" size="20" style="width:300px" value="',$ff[dat_birth],'"></td>
	</tr>
	<tr>
		<td width=150><font face="Arial" size="2">коментарій</font></td>
		<td width=20>&nbsp;</td>
		<td><textarea name="coment" style="width:300px">',$ff[coment],'</textarea></td>
	</tr>
	<tr>
		<td width=150><font face="Arial" size="2">додаткова інформація</font></td>
		<td width=20>&nbsp;</td>
		<td><textarea name="add_info" style="width:300px">',$ff[add_info],'</textarea></td>
	</tr>
	<tr>
		<td width=150><font face="Arial" size="2">управління балансом</font></td>
		<td width=20>&nbsp;</td>
		<td><table>
			<tr>
				<td><font face="Arial" size="2"><b>',$ff[balance],' RUB</b></font>
				<td>
					<input type="text" name="add" style="width:60px" id="cost">
			 	</td>
			 	<td>
				 	<table border="0">
						<tr>
							<td><input type="radio" value="0" checked name="tur"></td>
							<td><b><font size="2" face="Arial">no</font></b></td>
							<td><input type="radio" value="1" name="tur"></td>
							<td><b><font face="Arial" size="2">plus</font></b></td>
							<td><input type="radio" value="2" name="tur"></td>
							<td><b><font face="Arial" size="2">minus</font></b></td>
						</tr>
					</table>
			 	</td>
			</tr>
			</table>
		</td>
	</tr>';
    if ($ff[resh] == 1) echo '
    <tr>
        <td>Процентная ставка</td>
        <td width=20>&nbsp;</td>
        <td><input type="text" maxlength="3" value="'.(100-$config[procent]).'" name="stavka" style="width:30px;margin-right:4px;" id="stavka">%</td>
    </tr>
    ';
    echo'
</table>';
}
/*//---------------------------- ZAYAVKA NA ZADACHU
else if($f[page_type]==6){
$rf = mysql_query("SELECT * FROM katalog_zadach where id_p='$_GET[r]' limit 1")or die(mysql_error());//підрозділи теперішнього розділу
$ff=mysql_fetch_array($rf);
echo '<table width=780 style="border:1px solid #023761" align=center >
	<tr>
		<td><font face="Arial" size="2">файл</font></td>
		<td>&nbsp;</td>
		<td><input type="file" name="filename" style="width:200px" ></td>
	</tr>
	</table>';
}*/
//-------------------------- ZADACHI
else if($f[page_type]==5){
$rf = mysql_query("SELECT * FROM katalog_zadach where id_p='$_GET[r]' limit 1")or die(mysql_error());//підрозділи теперішнього розділу
$ff=mysql_fetch_array($rf);
echo '<table width=780 style="border:1px solid #023761" align=center >
	<tr>
		<td width=150><font face="Arial" size="2">додаткова інформація</font></td>
		<td width=20>&nbsp;</td>
		<td><textarea name="coment" style="width:300px">',$ff[coment],'</textarea></td>
	</tr>
</table>';
}
/*//------------------------- OTZIV
else if($f[page_type]==9){
$rf = mysql_query("SELECT * FROM katalog_zadach where id_p='$_GET[r]' limit 1")or die(mysql_error());//підрозділи теперішнього розділу
$ff=mysql_fetch_array($rf);
echo '<table width=780 style="border:1px solid #023761" align=center >
	<tr>
		<td><font face="Arial" size="2">файл</font></td>
		<td>&nbsp;</td>
		<td><input type="file" name="filename" style="width:200px" ></td>
	</tr>
	</table>';
}*/
//-------------------------------------------------------------------

echo '<p align=center><input type="submit" value="Змінити сторінку" name="B1"></p>';
echo '</form>';}
//==============================================================обробка
else{

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

mysql_query("update katalog set page_translit='$translit',id_p='$_POST[id_p]',page_title='$_POST[page_title]',page_descr='$_POST[page_descr]',page_keyword='$_POST[page_keyword]',page_name='$_POST[page_name]',menu_vizible='$_POST[menu_vizible]',menu_dozvil='$_POST[menu_dozvil]',menu_sort='$_POST[menu_sort]',bottom_text='$_POST[bottom_text]' where id='$_GET[r]'")or die(mysql_error());

if($_POST[page_type]==1){ //---------- PAGE
mysql_query("update katalog_page set text='$_POST[textarea]' where id_p='$_GET[r]'")or die(mysql_error());
}
//------------------------------------ NEWS
else if($_POST[page_type]==2){
mysql_query("update katalog_news set text='$_POST[textarea]' where id_p='$_GET[r]'")or die(mysql_error());
}
//-----------------------------------  USER
else if($_POST[page_type]==4){
if($_POST[tur]==1){
	mysql_query("update katalog_user set balance=balance+$_POST[add] where id_p='$_GET[r]'");
	mysql_query("insert into katalog_message(user_in,user_out,text,data_create) values('0','$_GET[r]','Администратор сайта пополнил Ваш баланс на $_POST[add] RUR','$data')")or die(mysql_error());
}else if($_POST[tur]==2){
	mysql_query("update katalog_user set balance=balance-$_POST[add] where id_p='$_GET[r]'");
	mysql_query("insert into katalog_message(user_in,user_out,text,data_create) values('0','$_GET[r]','Администратор сайта снял с Вашего баланса $_POST[add] RUR','$data')")or die(mysql_error());
}

if($_POST[pas])
{
    require_once($_SERVER["DOCUMENT_ROOT"] . '/modul/pass.php');
    $sql_set_password = 'user_password = "' . hash_password($_POST[pas]) . '", ';
}
else $sql_set_password = '';

mysql_query("update katalog_user set $sql_set_password email='$_POST[email]',tel='$_POST[tel]',icq='$_POST[icq]',generetedkey='$_POST[generetedkey]',gorod='$_POST[gorod]',univer='$_POST[univer]',dat_birth='$_POST[dat_birth]',coment='$_POST[coment]',add_info='$_POST[add_info]' where id_p='$_GET[r]'")or die(mysql_error());
}
/*//------------------------------------ ZAYAVKA NA ZADACHU
else if($_POST[page_type]==6){
mysql_query("update katalog_page set text='$_POST[textarea]' where id_p='$_GET[r]'")or die(mysql_error());
}*/
//------------------------------------ ZADACHA
else if($_POST[page_type]==5){
mysql_query("update katalog_zadach set coment='$_POST[coment]' where id_p='$_GET[r]'")or die(mysql_error());
}
//------------------------------------ OTZIV
/*else if($_POST[page_type]==9){
mysql_query("update katalog_page set text='$_POST[textarea]' where id_p='$_GET[r]'")or die(mysql_error());
}*/
//-------------------------------------------------------------
header("Location: katalog.html?r=".$_POST[id_p]);exit();
}?>