<?

if(isset($_GET['ajax'])) {
	include "mysql.php";
//print_r($_POST);
	if(isset($_POST['country'])) $_POST['country'] = iconv('utf-8','cp1251',$_POST['country']);
	if(isset($_POST['city'])) $_POST['city'] = iconv('utf-8','cp1251',$_POST['city']);
	if(isset($_POST['vuz_name'])) $_POST['vuz_name'] = iconv('utf-8','cp1251',$_POST['vuz_name']);
	if(isset($_POST['kafedra'])) $_POST['kafedra'] = iconv('utf-8','cp1251',$_POST['kafedra']);
	$vuz_name = explode("(",$_POST['vuz_name']);
	$_POST['vuz_name'] = $vuz_name[0];

	$where[] = 'km.status > 0 ';
	if(isset($_POST['country'])&&$_POST['country']!='0') { $country = $_POST['country'] = $_POST['country']; $where[] = 'km.country = "'.addslashes(trim($country)).'"'; }
	if(isset($_POST['city'])&&$_POST['city']!='0') { $city = $_POST['city'] = $_POST['city']; $where[] = 'km.city = "'.addslashes(trim($city)).'"'; }
	if(isset($_POST['vuz_name'])&&$_POST['vuz_name']!='0') { $vuz_name = $_POST['vuz_name'] = $_POST['vuz_name']; $where[] = 'km.vuz_name = "'.addslashes(trim($vuz_name)).'"'; }
	if(isset($_POST['kafedra'])&&$_POST['kafedra']!='0') { $kafedra = $_POST['kafedra'] = $_POST['kafedra']; $where[] = 'km.kafedra = "'.addslashes(trim($kafedra)).'"'; }
	if(isset($_POST['year'])&&$_POST['year']!='0') { $year = $_POST['year'] = $_POST['year']; $where[] = 'km.year = "'.addslashes(trim($year)).'"'; }


	$query = mysql_query("select country from katalog_metods as km WHERE km.status > 0 GROUP BY country");
	if(mysql_num_rows($query))
		while($res = mysql_fetch_array($query)) $sel_country[] = '<option '.($_POST['country']==$res['country']?' selected="selected" ':'').' value="'.$res['country'].'">'.$res['country'].'</option>';

	$country = $_POST['country'];
	if(trim($country)!=''){
		$query = mysql_query('select city from katalog_metods as km WHERE '.implode(" AND ", $where).' GROUP BY city');
		if(mysql_num_rows($query))
			while($res = mysql_fetch_array($query)) $sel_city[] = '<option '.($_POST['city']==$res['city']?' selected="selected" ':'').' value="'.$res['city'].'">'.$res['city'].'</option>';		
	}
	$city = $_POST['city'];
	if(trim($city)!=''){
		$query = mysql_query('select vuz_name, vuz_short_name from katalog_metods as km WHERE '.implode(" AND ", $where).' GROUP BY vuz_name');
		if(mysql_num_rows($query))
			while($res = mysql_fetch_array($query)) $sel_vuz[] = '<option '.($_POST['vuz_name']==$res['vuz_name']?' selected="selected" ':'').' value="'.$res['vuz_name'].'">'.$res['vuz_name'].'('.$res['vuz_short_name'].')</option>';
		
	}

	$vuz_name = $_POST['vuz_name'];
	if(trim($vuz_name)!=''){
		$query = mysql_query('select kafedra from katalog_metods as km WHERE '.implode(" AND ", $where).' GROUP BY kafedra');
		if(mysql_num_rows($query))
			while($res = mysql_fetch_array($query)) $sel_kafedra[] = '<option '.($_POST['kafedra']==$res['kafedra']?' selected="selected" ':'').' value="'.$res['kafedra'].'">'.$res['kafedra'].'</option>';
		
	}
		?>
	<label>
	<select name="country" onchange="sel_vuz136()"><option value="0">Выберите страну</option><?if(sizeof($sel_country)) echo implode($sel_country);?></select></label>
	<label>
	<select name="city" onchange="sel_vuz136()"><option value="0">Выберите город</option><?if(sizeof($sel_city)) echo implode($sel_city);?></select></label>
	<label>
	<select name="vuz_name" onchange="sel_vuz136()"><option value="0">Выберите ВУЗ</option><?if(sizeof($sel_vuz)) echo implode($sel_vuz);?></select></label>
	<label>
	<select name="kafedra" onchange="sel_vuz136()"><option value="0">Выберите кафедру</option><?if(sizeof($sel_kafedra)) echo implode($sel_kafedra);?></select></label>

<?
	exit;

}





//include "mysql.php";

	$where[] = 'km.status > 0 ';
	if(isset($_GET['user_id'])&&(int)$_GET['user_id']) $where[] = 'km.user_id = '.(int)$_GET['user_id'];
	if(isset($_POST['country'])&&$_POST['country']!='0') { $country = $_POST['country'] = $_POST['country']; $where[] = 'km.country = "'.addslashes(trim($country)).'"'; }
	if(isset($_POST['city'])&&$_POST['city']!='0') { $city = $_POST['city'] = $_POST['city']; $where[] = 'km.city = "'.addslashes(trim($city)).'"'; }
	if(isset($_POST['vuz_name'])&&$_POST['vuz_name']!='0') { $vuz_name = $_POST['vuz_name'] = $_POST['vuz_name']; $where[] = 'km.vuz_name = "'.addslashes(trim($vuz_name)).'"'; }
	if(isset($_POST['kafedra'])&&$_POST['kafedra']!='0') { $kafedra = $_POST['kafedra'] = $_POST['kafedra']; $where[] = 'km.kafedra = "'.addslashes(trim($kafedra)).'"'; }
	if(isset($_POST['year'])&&$_POST['year']!='0') { $year = $_POST['year'] = $_POST['year']; $where[] = 'km.year = "'.addslashes(trim($year)).'"'; }

/*
	if(isset($_POST['search'])&&trim($_POST['search'])!=''){
		$s = addslashes(trim($_POST['search'])); $s = explode(" ",$s);
		if(is_array($s)) foreach ($s as $item2) $wh2[] = ' CONCAT(`vuz_name`, `vuz_short_name`, `kafedra`, `year`, `metod_name`, `description`) LIKE "%'.$item2.'%"';
			else $wh2[] = ' CONCAT(`vuz_name`, `vuz_short_name`, `kafedra`, `year`, `metod_name`, `description`) LIKE "%'.$s.'%"';
	}
*/
	$sel_country = $sel_city = $sel_vuz = $sel_kafedra = array();
	$query = mysql_query('select country from katalog_metods as km WHERE '.implode(" AND ", $where).' GROUP BY country');
	if(mysql_num_rows($query))
		while($res = mysql_fetch_array($query)) $sel_country[] = '<option '.($_POST['country']==$res['country']?' selected="selected" ':'').' value="'.$res['country'].'">'.$res['country'].'</option>';

	$query = mysql_query('select city from katalog_metods as km WHERE '.implode(" AND ", $where).'  GROUP BY city');
	if(mysql_num_rows($query))
			while($res = mysql_fetch_array($query)) $sel_city[] = '<option '.($_POST['city']==$res['city']?' selected="selected" ':'').' value="'.$res['city'].'">'.$res['city'].'</option>';		
	
	$query = mysql_query('select vuz_name, vuz_short_name from katalog_metods as km WHERE '.implode(" AND ", $where).' GROUP BY vuz_name');
	if(mysql_num_rows($query))
			while($res = mysql_fetch_array($query)) $sel_vuz[] = '<option '.($_POST['vuz_name']==$res['vuz_name']?' selected="selected" ':'').' value="'.$res['vuz_name'].'">'.$res['vuz_name'].'('.$res['vuz_short_name'].')</option>';
		
	$query = mysql_query('select kafedra from katalog_metods as km WHERE '.implode(" AND ", $where).' GROUP BY kafedra');
	if(mysql_num_rows($query))
		while($res = mysql_fetch_array($query)) $sel_kafedra[] = '<option '.($_POST['kafedra']==$res['kafedra']?' selected="selected" ':'').' value="'.$res['kafedra'].'">'.$res['kafedra'].'</option>';

	//$query = mysql_query('select year from katalog_metods as km WHERE '.implode(" AND ", $where).' AND km.year!="" GROUP BY year');
	//if(mysql_num_rows($query))
	//	while($res = mysql_fetch_array($query)) $sel_year[] = '<option '.($_POST['year']==$res['year']?' selected="selected" ':'').' value="'.$res['year'].'">'.$res['year'].'</option>';


?>
<td>

		<script type="text/javascript">
			function sel_vuz136(){ 
				var country = jQuery("#form136 select[name='country']").val();
				var city = jQuery("#form136 select[name='city']").val();
				var vuz_name = jQuery("#form136 select[name='vuz_name']").val();
				var kafedra = jQuery("#form136 select[name='kafedra']").val();
				jQuery.post("/modul/metods_block.php?ajax",{country:country, city:city, vuz_name:vuz_name, kafedra:kafedra }, function(data){ jQuery("#form138").html(data);});
			}
			jQuery(document).ready(function(){sel_vuz136()});
		</script>
<form method="POST" id="form136" action="/k136.html">
<div class="main_mf searchBlock">

				
	<h3></h3>
	<input id="poisk" type="text" name="search" placeholder="По ключевым словам..." value="<?=$_POST['search']?>" />

<div id="form138">
	<label>
	<select name="country" onchange="sel_vuz136()"><option value="0">Выберите страну</option><?if(sizeof($sel_country)) echo implode($sel_country);?></select></label>
	<label>
	<select name="city" onchange="sel_vuz136()"><option value="0">Выберите город</option><?if(sizeof($sel_city)) echo implode($sel_city);?></select></label>
	<label>
	<select name="vuz_name" onchange="sel_vuz136()"><option value="0">Выберите ВУЗ</option><?if(sizeof($sel_vuz)) echo implode($sel_vuz);?></select></label>
	<label>
	<select name="kafedra" onchange="sel_vuz136()"><option value="0">Выберите кафедру</option><?if(sizeof($sel_kafedra)) echo implode($sel_kafedra);?></select></label>
</div>
	<input type="hidden" name="sort" value="datedesc"/>
	<input type="submit" value="Найти"/>
	<!--input type="button" value="Сбросить фильтры" onclick="document.location.href='/k136.html'"-->
				
</div>
</form>
<?


?>