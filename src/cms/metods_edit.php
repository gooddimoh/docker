<?
$max_size_file = get_cfg_var('upload_max_filesize');
$max_size_file_int =(int)$max_size_file;
//---translit
function translit($st){
	$st=strtr($st,"абвгдежзийклмнопрстуфыэАБВГДЕЖЗИЙКЛМНОПРСТУФЫЭ","abvgdegziyklmnoprstufieABVGDEGZIYKLMNOPRSTUFIE");
	$st=strtr($st,array('ё'=>"yo",'ї'=>"yi", 'х'=>"h", 'ц'=>"ts", 'ч'=>"ch", 'ш'=>"sh",'й'=>"y",
	            		'щ'=>"shch",'і'=>"i", 'ъ'=>"", 'ь'=>"", 'ю'=>"yu", 'я'=>"ya",
		                'Ё'=>"YO", 'Х'=>"H", 'Ц'=>"TS", 'Ч'=>"CH", 'Ш'=>"SH",'Й'=>"Y",
		                'Щ'=>"SHCH", 'Ъ'=>"", 'Ь'=>"", 'Ю'=>"YU", 'Я'=>"YA",
		                '№'=>"",'#'=>"",' '=>"_",'!'=>"",'?'=>"",'-'=>"",'@'=>"",
		                '('=>"_",')'=>"",'"'=>"","'"=>"",","=>""));
	return $st;
}
//---translit

include "mysql.php";

if(isset($_GET['ajax'])) {
	require_once $_SERVER["DOCUMENT_ROOT"] . "/modul/custom_sessions.php"; CustomSessions::start();
	//if(!$_SESSION[logintrue]) exit;
	if(isset($_POST['country'])) $_POST['country'] = iconv('utf-8','cp1251',$_POST['country']);
	if(isset($_POST['city'])) $_POST['city'] = iconv('utf-8','cp1251',$_POST['city']);
	if(isset($_POST['vuz_name'])) $_POST['vuz_name'] = iconv('utf-8','cp1251',$_POST['vuz_name']);
	if(isset($_POST['kafedra'])) $_POST['kafedra'] = iconv('utf-8','cp1251',$_POST['kafedra']);
	$vuz_name = explode("(",$_POST['vuz_name']);
	$_POST['vuz_name'] = $vuz_name[0];

	$query = mysql_query("select country from katalog_metods GROUP BY country");
	if(mysql_num_rows($query))
		while($res = mysql_fetch_array($query)) $sel_country[] = '<option '.($_POST['country']==$res['country']?' selected="selected" ':'').' value="'.$res['country'].'">'.$res['country'].'</option>';

	$country = $_POST['country'];
	if(trim($country)!=''){
		$query = mysql_query('select city from katalog_metods WHERE country = "'.addslashes(trim($country)).'" GROUP BY city');
		if(mysql_num_rows($query))
			while($res = mysql_fetch_array($query)) $sel_city[] = '<option '.($_POST['city']==$res['city']?' selected="selected" ':'').' value="'.$res['city'].'">'.$res['city'].'</option>';		
	}
	$city = $_POST['city'];
	if(trim($city)!=''){
		$query = mysql_query('select vuz_name, vuz_short_name from katalog_metods WHERE country = "'.addslashes(trim($country)).'" AND city = "'.addslashes(trim($city)).'" GROUP BY vuz_name');
		if(mysql_num_rows($query))
			while($res = mysql_fetch_array($query)) $sel_vuz[] = '<option '.($_POST['vuz_name']==$res['vuz_name']?' selected="selected" ':'').' value="'.$res['vuz_name'].'('.$res['vuz_short_name'].')">'.$res['vuz_name'].'('.$res['vuz_short_name'].')</option>';
		
	}

	$vuz_name = $_POST['vuz_name'];
	if(trim($vuz_name)!=''){
		$query = mysql_query('select kafedra from katalog_metods WHERE country = "'.addslashes(trim($country)).'" AND city = "'.addslashes(trim($city)).'" AND vuz_name = "'.addslashes(trim($vuz_name)).'" GROUP BY kafedra');
		if(mysql_num_rows($query))
			while($res = mysql_fetch_array($query)) $sel_kafedra[] = '<option '.($_POST['kafedra']==$res['kafedra']?' selected="selected" ':'').' value="'.$res['kafedra'].'">'.$res['kafedra'].'</option>';
		
	}
		?>

						<tr><td colspan="3">Выбор ВУЗа</td></tr>
						<tr>
							<td>Страна</td>
							<td><select name="country" onchange="if(jQuery(this).val()=='-1') jQuery(this).parent().next().show(); else  { jQuery(this).parent().next().hide(); sel_vuz() }"><option value="0">Выберите страну</option><?if(sizeof($sel_country)) echo implode($sel_country);?><option value="-1">Страны нет в списке</option></select></td>
							<td class="hid"><input type="text" value="" name="country_new"/></td>
						</tr>
						<tr>
							<td>Город</td>
							<td><select name="city" onchange="if(jQuery(this).val()=='-1') jQuery(this).parent().next().show(); else  { jQuery(this).parent().next().hide(); sel_vuz() }"><option value="0">Выберите город</option><?if(sizeof($sel_city)) echo implode($sel_city);?><option value="-1">Города нет в списке</option></select></td>
							<td class="hid"><input type="text" value="" name="city_new"/></td>
						</tr>
						<tr>
							<td>ВУЗ</td>
							<td><select name="vuz_name" onchange="if(jQuery(this).val()=='-1') jQuery(this).parent().next().show(); else  { jQuery(this).parent().next().hide(); sel_vuz() }"><option value="0">Выберите ВУЗ</option><?if(sizeof($sel_vuz)) echo implode($sel_vuz);?><option value="-1">ВУЗа нет в списке</option></select></td>
							<td class="hid">Вуз:<input type="text" value="" name="vuz_name_new"/>Вуз(аббревиатура):<input type="text" value="" name="vuz_short_name_new"/></td>
						</tr>
						<tr>
							<td>Кафедра</td>
							<td><select name="kafedra" onchange="if(jQuery(this).val()=='-1') jQuery(this).parent().next().show(); else  { jQuery(this).parent().next().hide(); }"><option value="0">Выберите кафедру</option><?if(sizeof($sel_kafedra)) echo implode($sel_kafedra);?><option value="-1">кафедры нет в списке</option></select></td>
							<td class="hid"><input type="text" value="" name="kafedra_new"/></td>
						</tr>


<?
	exit;

} 
//echo $_SESSION[logintrue].'-'.(int)$_GET['mid'].'-'.(int)$_GET['zid']; exit;
if((int)$_GET['mid']<1&&(int)$_GET['zid']<1)  { echo '<script>document.location.href="/cms/metods.html"</script>'; exit; }

if(!isset($_POST[B1])&&!isset($_POST['B2'])){
	if(1||$_SESSION[logintrue]){ ?>
		
		<style>.hid{display:none}</style>
		<script lang="javascript">
			function sel_vuz(){ 
				var country = jQuery("#form2 select[name='country']").val();
				var city = jQuery("#form2 select[name='city']").val();
				var vuz_name = jQuery("#form2 select[name='vuz_name']").val();
				var kafedra = jQuery("#form2 select[name='kafedra']").val();
				jQuery.post("/cms/metods_edit.php?ajax",{country:country, city:city, vuz_name:vuz_name, kafedra:kafedra }, function(data){ jQuery("#vuzselect").html(data);})
			}
		</script>
		
		<?if((int)$_GET['mid']) { 
			$query = mysql_query('SELECT * FROM katalog_metods WHERE id = '.(int)$_GET['mid'].'');
			if(!mysql_num_rows($query)) { echo '<script>document.location.href="/cms/metods.html"</script>'; exit; }
			$res = mysql_fetch_array($query); ?>
	
<!---->		<form enctype="multipart/form-data" action="/cms/metods_edit.html?mid=<?=(int)$_GET['mid']?>" method=post id="form2">
			<table border="0" width="100%" id="table1">
				<tr>
					<td>
					</td>
				</tr>
				<tr>
					<td>
					&nbsp;</td>
				</tr>
				<tr>
					<td>
					<table id="vuzselect" border="0">
						<tr><td colspan="3">Выбор ВУЗа</td></tr>
						<tr>
							<td>Страна</td>
							<td><select name="country" onchange="sel_vuz()"><option value="<?=$res['country']?>"></option></td>
							<td class="hid"><input type="text" value="" name="country_new"/></td>
						</tr>
						<tr>
							<td>Город</td>
							<td><select name="city" onchange="sel_vuz()"><option value="<?=$res['city']?>"></option></select></td>
							<td class="hid"><input type="text" value="" name="city_new"/></td>
						</tr>
						<tr>
							<td>ВУЗ</td>
							<td><select name="vuz_name" onchange="sel_vuz()"><option value="<?=$res['vuz_name']?>"></option></select></td>
							<td class="hid"><input type="text" value="" name="vuz_name_new"/><input type="text" value="" name="vuz_short_name_new"/></td>
						</tr>
						<tr>
							<td>Кафедра</td>
							<td><select name="kafedra"><option value="<?=$res['kafedra']?>"></option></select></td>
							<td class="hid"><input type="text" value="" name="kafedra_new"/></td>
						</tr>
					</table>
					<script> jQuery(document).ready(function(){sel_vuz()});</script>
					<table border="0" id="table2">
<?
	$arr = array("методичка","Диплом","Курсовая","Реферат");
?>
						<tr><td colspan="3"><?=$arr[$res['diplom']]?></td></tr>
						<tr>
							<td><b><font face="Arial" size="2" color="#006666">Название:</font></b></td>
							<td><input type="text" name="metod_name" value="<?=$res['metod_name']?>"></td>
							<td></td>
						</tr>
						<tr>
							<td><b><font face="Arial" size="2" color="#006666">Год издания:</font></b></td>
							<td><input type="text" name="year" value="<?=$res['year']?>"></td>
							<td></td>
						</tr>
<?if(!$res['diplom']) { ?>
						<tr>
							<td><b><font face="Arial" size="2" color="#006666">Авторы:</font></b></td>
							<td><input type="text" name="authors" value="<?=$res['authors']?>"></td>
							<td></td>
						</tr>
<? } else { ?>
						<tr>
							<td><b><font face="Arial" size="2" color="#006666">Страниц:</font></b></td>
							<td><input type="text" name="pages" value="<?=$res['pages']?>"></td>
							<td></td>
						</tr>
						<tr>
							<td><b><font face="Arial" size="2" color="#006666">Стоимость:</font></b></td>
							<td><input type="text" name="price" value="<?=$res['price']?>"></td>
							<td></td>
						</tr>
<? } ?>
						<tr>
							<td colspan="3"><img src="/<?=$res['img_name']?>"></td>
						</tr>
						<tr>
							<td><b><font face="Arial" size="2" color="#006666">Обложка:</font></b><a href="/<?=$res['img_name']?>"><?=$res['img_name']?></a></td>
							<td><input type="file" name="imgname" size="20"></td>
							<td></td>
						</tr>
<?if($res['diplom']) { ?>
						<tr>
							<td><b><font face="Arial" size="2" color="#006666">Часть работы:</font></b><a href="/<?=$res['fileshort_name']?>"><?=$res['fileshort_name']?></a></td>
							<td><input type="file" name="fileshortname" size="20"></td>
							<td></td>
						</tr>
<? } ?>
						<tr>
							<td><b><font face="Arial" size="2" color="#006666">Файл:</font></b><a href="/<?=$res['file_name']?>"><?=$res['file_name']?></a></td>
							<td><input type="file" name="filename" size="20"></td>
							<td><input type="submit" value="Сохранить" name="B1"></td>
						</tr>
					</table>
					<a href="javascript:void(0)" onclick="history.go(-1)">Вернуться</a>
					</td>
				</tr>
			</table></form>
		<? } else { 
			$query = mysql_query('SELECT kmz.* FROM katalog_metods_zad as kmz LEFT JOIN katalog_metods as km ON(km.id = kmz.metod_id) WHERE kmz.id = '.(int)$_GET['zid'].' ');
			if(!mysql_num_rows($query)) { echo '<script>document.location.href="/cms/metods.html"</script>'; exit; }
			$res = mysql_fetch_array($query); 
		?>
		<form enctype="multipart/form-data" action="/cms/metods_edit.html?zid=<?=(int)$_GET['zid']?>" method=post id="form3">
			<table border="0" width="100%" id="table1">
				<tr>
					<td>
					</td>
				</tr>
				<tr>
					<td>
					&nbsp;</td>
				</tr>
				<tr>
					<td>
					<table border="0" id="table3">
						<tr><td colspan="3">Редактирование задачи</td></tr>
						<tr>
							<td>Методичка</td>
							<? $query1 = mysql_query('select * from katalog_metods WHERE diplom = 0');
							   if(mysql_num_rows($query1))
								while($res1 = mysql_fetch_array($query1)) $sel_metod[] = '<option '.($res1['id']==$res['metod_id']?' selected = "selected" ':'').' value="'.$res1['id'].'">'.$res1['metod_name'].'('.$res1['vuz_short_name'].')</option>'; 
							?>
							<td><select name="metods"><option>Выберите методичку</option><?=implode($sel_metod)?></select></td>
							<td class="hid"></td>
						</tr>
						<tr>
							<td>Задача (название)</td>
							<td><input type="text" value="<?=$res['name_zadacha']?>" name="name_zadacha"/></td>
							<td class="hid"></td>
						</tr>
						<tr>
							<td>Раздел (название)</td>
							<td><input type="text" value="<?=$res['name_razdel']?>" name="name_razdel"/></td>
							<td class="hid"></td>
						</tr>
						<tr>
							<td>Стоимость</td>
							<td><input type="text" value="<?=$res['price']?>" name="price"/></td>
							<td class="hid"></td>
						</tr>
					</table>
					
					<table border="0">
						<tr><td colspan="3">Решение</td></tr>
						<tr><td colspan="3"><img src="/<?=$res['img_name']?>" alt=""/></td></tr>
						<tr>
							<td><b><font face="Arial" size="2" color="#006666">Скан задачи:</font></b></td>
							<td><input type="file" name="imgname" size="20"></td>
							<td></td>
						</tr>
						<tr>
							<td><b><font face="Arial" size="2" color="#006666">Файл решения:</font></b></td>
							<td><input type="file" name="filename" size="20"></td>
							<td><input type="submit" value="Сохранить" name="B2"></td>
						</tr>
					</table>
					</td>
				</tr>
			</table></form>
	<? } ?>
<?
	}else{
	array_push($_SESSION[error],'Вы не авторизированый пользователь. <a href="k20.html">Войдите</a> в систему');
	echo '<script lang="javascaript">location.href="./"</script>';
	}
}else{
	require_once $_SERVER["DOCUMENT_ROOT"] . "/modul/custom_sessions.php"; CustomSessions::start();
	$_SESSION[error]=array();
	$_SESSION[result]=array();

	//include "sequrity.php";
	$data=time();

	if(1||$_SESSION[logintrue]){
		if($_FILES["imgname"]["size"]){
			if (end(explode(".",$_FILES['imgname']['name'])) == 'php') {
			    array_push($_SESSION[error],'Файла неверного формата');
        		}

			$_FILES['imgname']['name'] = translit($_FILES['imgname']['name']);
        		$imgurl = "uploads/f_".$data."_".$_SESSION['userid']."_".$_FILES['imgname']['name'];
			copy($_FILES['imgname']['tmp_name'], dirname(__FILE__)."/../".$imgurl);
		} else $imgurl = '';

		if($_FILES["fileshortname"]["size"]){
		    if (end(explode(".",$_FILES['fileshortname']['name'])) == 'php') {
			    array_push($_SESSION[error],'Файла неверного формата');
        		}

			$_FILES['fileshortname']['name'] = translit($_FILES['fileshortname']['name']);
        		$fileshorturl = "uploads/f_".$data."_".$_SESSION['userid']."_".$_FILES['fileshortname']['name'];
			copy($_FILES['fileshortname']['tmp_name'], dirname(__FILE__)."/../".$fileshorturl);
		} else $fileshorturl = '';

		if($_FILES["filename"]["size"]){
		    if (end(explode(".",$_FILES['filename']['name'])) == 'php') {
			    array_push($_SESSION[error],'Файла неверного формата');
        		}

			$_FILES['filename']['name'] = translit($_FILES['filename']['name']);
        		$url = "uploads/f_".$data."_".$_SESSION['userid']."_".$_FILES['filename']['name'];
			copy($_FILES['filename']['tmp_name'], dirname(__FILE__)."/../".$url);
		} else $url = '';
/*
			if(0&&$_FILES["filename"]["size"]/1024>$max_size_file_int*1000){
				array_push($_SESSION[error],'Файл превышает 500 Кб, слишком большой');
			}
			$r=mysql_query("select id from katalog_files where user='$_SESSION[userid]'");
			if(0&&@mysql_num_rows($r)>=10){
				array_push($_SESSION[error],'Исчерпан лимит количества файлов');
			}
*/
		if(count($_SESSION[error])==0){

		if(isset($_POST['B1'])){
				if($_POST['country']!="-1") $country = addslashes(trim($_POST['country'])); else $country = addslashes(trim($_POST['country_new']));
				if($_POST['city']!="-1") $city = addslashes(trim($_POST['city'])); else $city = addslashes(trim($_POST['city_new']));
				if($_POST['vuz_name']!="-1") { $vuz_name = explode("(",addslashes(trim($_POST['vuz_name']))); $vuz_short_name = str_replace(")","",$vuz_name[1]); $vuz_name = $vuz_name[0];  }else { $vuz_name = addslashes(trim($_POST['vuz_name_new'])); $vuz_short_name = addslashes(trim($_POST['vuz_short_name_new']));}
				if($_POST['kafedra']!="-1") $kafedra = addslashes(trim($_POST['kafedra'])); else $kafedra = addslashes(trim($_POST['kafedra_new']));
				$year = addslashes(trim($_POST['year']));
				$authors = addslashes(trim($_POST['authors']));
				$metod_name = addslashes(trim($_POST['metod_name']));
				$price = (float)$_POST['price'];
				$pages = (int)$_POST['pages'];

				mysql_query('UPDATE katalog_metods SET '.($fileshorturl!=''?' fileshort_name = "'.$fileshorturl.'", ':'').''.($url!=''?' file_name = "'.$url.'", ':'').''.($imgurl!=''?' img_name = "'.$imgurl.'", ':'').' country = "'.$country.'", city = "'.$city.'", vuz_name = "'.$vuz_name.'", vuz_short_name = "'.$vuz_short_name.'", kafedra = "'.$kafedra.'", metod_name = "'.$metod_name.'", year = "'.$year.'", authors = "'.$authors.'", pages = "'.$pages.'", price = "'.$price.'" WHERE id = '.(int)$_GET['mid'].' ')or die(mysql_error());
		}
		if(isset($_POST['B2'])){
				$name_zadacha = addslashes(trim($_POST['name_zadacha']));
				$name_razdel = addslashes(trim($_POST['name_razdel']));
				$metod_id = (int)$_POST['metods'];
				$price = (float)$_POST['price'];

				mysql_query('UPDATE katalog_metods_zad SET '.($url!=''?' file_name = "'.$url.'", ':'').''.($imgurl!=''?' img_name = "'.$imgurl.'", ':'').' metod_id = '.$metod_id.', name_zadacha = "'.$name_zadacha.'", name_razdel = "'.$name_razdel.'", price = '.(float)$price.' WHERE id = '.(int)$_GET['zid'].' ')or die(mysql_error());
		}
			}

		if(count($_SESSION[error])==0){ 
			if(isset($_POST['B1'])) array_push($_SESSION[result],'Методичка сохранена'); 
			if(isset($_POST['B2'])) array_push($_SESSION[result],'Задача сохранена'); 
			
		}
		else{
			//header("Location:../k135.html");
		}
		echo '<script>document.location.href="/cms/metods_edit.html"</script>';
  	}else{
    	array_push($_SESSION[error],'Вы не авторизированый пользователь. <a href="k20.html">Войдите</a> в систему');
    	header("Location:../");
	}
}
?>