<?

include "mysql.php";

	$where[] = 'km.status > 0';
	if(isset($_GET['user_id'])&&(int)$_GET['user_id']) $where[] = 'km.user_id = '.(int)$_GET['user_id'];
	if(isset($_POST['country'])&&$_POST['country']!='0') { $country = $_POST['country'] = $_POST['country']; $where[] = 'km.country = "'.addslashes(trim($country)).'"'; }
	if(isset($_POST['city'])&&$_POST['city']!='0') { $city = $_POST['city'] = $_POST['city']; $where[] = 'km.city = "'.addslashes(trim($city)).'"'; }
	if(isset($_POST['vuz_name'])&&$_POST['vuz_name']!='0') { $vuz_name = $_POST['vuz_name'] = $_POST['vuz_name']; $where[] = 'km.vuz_name = "'.addslashes(trim($vuz_name)).'"'; }
	if(isset($_POST['kafedra'])&&$_POST['kafedra']!='0') { $kafedra = $_POST['kafedra'] = $_POST['kafedra']; $where[] = 'km.kafedra = "'.addslashes(trim($kafedra)).'"'; }
	if(isset($_POST['year'])&&$_POST['year']!='0') { $year = $_POST['year'] = $_POST['year']; $where[] = 'km.year = "'.addslashes(trim($year)).'"'; }


/*
	$arr_s = array('vuz_name', 'vuz_short_name', 'kafedra', 'year', 'metod_name', 'description');
	if(isset($_POST['search'])&&trim($_POST['search'])=='По ключевым словам...') unset($_POST['search']);
	if(isset($_POST['search'])&&trim($_POST['search'])!=''){
		$s = addslashes(trim($_POST['search'])); $s = explode(" ",$s);
		foreach($arr_s as $item) 
			if(is_array($s)) foreach ($s as $item2) $wh2[] = $item.' LIKE "%'.$item2.'%"';
			else $wh2[] = $item.' LIKE "%'.$s.'%"';
	}
*/
	if(isset($_POST['search'])&&trim($_POST['search'])=='По ключевым словам...') unset($_POST['search']);

	if(isset($_POST['search'])&&trim($_POST['search'])!=''){
		$s = addslashes(trim($_POST['search'])); $s = explode(" ",$s);
		if(is_array($s)) foreach ($s as $item2) $wh2[] = ' CONCAT(`authors`, `vuz_name`, `vuz_short_name`, `kafedra`, `year`, `metod_name`, `description`) LIKE "%'.$item2.'%"';
			else $wh2[] = ' CONCAT(`authors`, `vuz_name`, `vuz_short_name`, `kafedra`, `year`, `metod_name`, `description`) LIKE "%'.$s.'%"';
	}


	//$query = mysql_query('select country from katalog_metods as km WHERE '.implode(" AND ", $where).' GROUP BY country');
	$query = mysql_query('select country from katalog_metods as km WHERE km.status >0 GROUP BY country');
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

	$query = mysql_query('select year from katalog_metods as km WHERE '.implode(" AND ", $where).' AND km.year!="" GROUP BY year');
	if(mysql_num_rows($query))
		while($res = mysql_fetch_array($query)) $sel_year[] = '<option '.($_POST['year']==$res['year']?' selected="selected" ':'').' value="'.$res['year'].'">'.$res['year'].'</option>';


?>


<?
$arr = array("Методичка","Диплом","Курсовая","Реферат");
if(isset($_GET['metod_id'])&&(int)$_GET['metod_id']){
?>

		<script type="text/javascript">
			jQuery(document).ready(function(){jQuery.post("/modul/metods_block.php?ajax",{country:"", city:"", vuz_name:"", kafedra:"" }, function(data){ jQuery("#form137").html(data);});});
			function sel_vuz(){ 
				var country = jQuery("#form1 select[name='country']").val();
				var city = jQuery("#form1 select[name='city']").val();
				var vuz_name = jQuery("#form1 select[name='vuz_name']").val();
				var kafedra = jQuery("#form1 select[name='kafedra']").val();
				jQuery.post("/modul/metods_block.php?ajax",{country:country, city:city, vuz_name:vuz_name, kafedra:kafedra }, function(data){ jQuery("#form137").html(data);});
			}
		</script>

<div class="methodsPage">
	<form class="methodsPageForm" method="POST" id="form1" action="/k136.html">
		<div class="main_m">
		<?
			$query = mysql_query('SELECT km.*, ku.login FROM katalog_metods as km LEFT JOIN katalog_user as ku ON(ku.id_p = km.user_id) WHERE km.id = '.(int)$_GET['metod_id'].'');

			if(mysql_num_rows($query)==0){
				echo 'Нет методичек по условиям поиска';
			} else {
				$res = mysql_fetch_array($query);

?> 

<h2><?=($res['diplom']?$arr[$res['diplom']].': ':'')?><?=$res['metod_name']?></h2>

<?				if(!$res['diplom']){
					echo '<div class="test1">';
					echo '<a class="imgWrap" onclick="tb_show(\'\',\'/'.$res['img_name'].'?TB_iframe=true\'); jQuery(\'#TB_window\').addClass(\'imagePopup\'); return false;" href="/'.$res['img_name'].'"><img class="img1" src="/getImage.php?file='.$res['img_name'].'&w=300" alt=""  /></a>';
					echo '<ul><li><b>Авторы:</b> '.$res['authors'].'';
					echo '<li><b>Страна:</b> '.$res['country'].'';
					echo '<li><b>Город:</b> '.$res['city'].'';
					echo '<li><b>ВУЗ:</b> '.$res['vuz_name'].'('.$res['vuz_short_name'].')';
					echo '<li><b>Кафедра:</b> '.$res['kafedra'].'';
					echo '<li><b>Методичка:</b> '.$res['metod_name'].'';
					echo '<li><b>год:</b> '.$res['year'].'';
					echo '<li><p><a class="dlBlue" href="/'.$res['file_name'].'">Скачать методичку</a></p></ul><div class="clear"></div>';
					echo '<p>Задачи с данной методички постоянно загружаются. Если вы не нашли нужнной задачи, можете ее заказать у менеджера в <a onclick="o=window.open;o(\'https://siteheart.com/webconsultation/37348?\', \'siteheart_sitewindow_37348\', \'width=550,height=400,top=30,left=30,resizable=yes\'); return false;" target="siteheart_sitewindow_ 37348" href="https://siteheart.com/webconsultation/37348?" title="">онлайн чате</a> или же выслать запрос на почтовый ящик: <a href="mailto:danko2009@inbox.ru">danko2009@inbox.ru</a>. Как только отсутствующее задание будет нами сделано - оно автоматически появится на этой странице</p>';
					echo '<p>Описание заданий: '.$res['description'].'</p></div>';
                    
                    $sort_type = (boolean)$_GET['sort'];
                    
                    
                    $razdely = array(0 => 'Все');
                    $q2 = mysql_query('SELECT name_razdel FROM katalog_metods_zad WHERE metod_id = '.$res['id'] . ' GROUP BY name_razdel ORDER BY name_razdel ASC');
                    while($res2 = mysql_fetch_row($q2))
                    {
                        $razdely[] = $res2[0];
                    }
                    $razdel_id = ((isset($_GET['razdel']) and isset($razdely[(int)$_GET['razdel']])) ? (int)$_GET['razdel'] : 0);
                    //var_dump($razdely);
                    $zad_qty = mysql_fetch_row(mysql_query('SELECT COUNT(*) FROM katalog_metods_zad WHERE metod_id = '.$res['id'] . ($razdel_id ? ' AND name_razdel = "'.$razdely[$razdel_id].'"' : '')));
                    $zad_qty = $zad_qty[0];
                    
					if(!$zad_qty) {
						echo 'Для данной методички нет решенных задач';
					} else {
                    
                    $pages_select = array(10, 30, 50, 70, 90, 0);
                   // $pages_select = array(2, 5, 10, 20, 40, 0);
                    $onpage_id = (int)$_GET['onpage'];
                    if(!isset($pages_select[$onpage_id])) $onpage_id = 0;
                    $onpage = $pages_select[$onpage_id];
                    
                    if($pages_select[$onpage_id] > 0) $pages_qty = ceil($zad_qty / $onpage);
                    else $pages_qty = 1;
                    
                    $current_page = ((isset($_GET['page']) and (int)$_GET['page'] > 1 and (int)$_GET['page'] <= $pages_qty) ? (int)$_GET['page'] : 1);
                    
                        $select = '<select name="razdel" onChange="reload_page(\'metod_id='.$_GET['metod_id'].'&razdel='.$_GET['razdel'].'&onpage=\' + $(this).children(\':selected\').val())">';
                        for ($x = 0; $x < count($pages_select); $x++)
                        {
                            if($pages_select[$x] == 0) $select .= '<option '. ($onpage_id == $x ? 'selected' : '') .' value="'. $x .'">Все</option>';
                            else $select .= '<option '. ($onpage_id == $x ? 'selected' : '') .' value="'. $x .'">'. $pages_select[$x] .'</option>';
                        }
                        $select .= '</select>';
                        
                        echo '<p><b>Решенные задачи:</b> <span style="float: right">Количество задач на странице: '. $select .'</span></p>';
                    
                    $pagination = '';
                    if($pages_qty > 1)
                        for ($x = 1; $x <= $pages_qty; $x++)
                        {
                            if($current_page == $x) $pagination .= '<span style="text-decoration:underline;color:green"><b>' . $x . '</b></span>. ';
                            else $pagination .= '<a class="blue" href="?metod_id=' . $_GET['metod_id'] . (isset($_GET['razdel']) ? '&razdel=' . $_GET['razdel'] : '') . '&page=' . $x . '&onpage=' . $onpage_id . '">' . $x . '</a>. ';
                        }
                    $pagination = 'Всего найдено '. $zad_qty .' решенных задач' . ($pages_qty > 1 ? ', Страница: ' . $pagination : '.');
                    
                    $zad_query = mysql_query('SELECT * FROM katalog_metods_zad WHERE metod_id = '.$res['id'] . ($razdel_id ? ' AND name_razdel = "'.$razdely[$razdel_id].'"' : '') . ' ORDER BY name_zadacha ASC ' . ($onpage ? ' LIMIT ' . (($current_page - 1) * $onpage).','.$onpage : '')); 
                        /*
						while($zad_res = mysql_fetch_array($zad_query)){
							echo '<p><b>Раздел:</b> '.$zad_res['name_razdel'].'<br/><b>Название задачи:</b> '.$zad_res['name_zadacha'].'</p>';
							echo '<p><a onclick="tb_show(\'\',\'/'.$zad_res['img_name'].'?TB_iframe=true\'); jQuery(\'#TB_window\').addClass(\'imagePopup\'); return false;" href="/'.$zad_res['img_name'].'"><img src="/getImage.php?file='.$zad_res['img_name'].'&w=200" alt=""  WIDTH="200"/></a></p>';
							//echo '<p><img src="/'.$zad_res['img_name'].'" alt=""/></p>';
							echo '<p>Цена: $'.$zad_res['price'].'</p>';
							echo '<p><a class="buy" href="javascript:void(0)" onclick="tb_show(\'\',\'/cart.php?zid='.$zad_res['id'].'?TB_iframe=true\'); jQuery(\'#TB_window\').addClass(\'cart\'); return false;">Купить</a></p>';
						}*/
                        $buf = '';
                        
						while($zad_res = mysql_fetch_array($zad_query)){
                            $buf .= '<tr><td>'.$zad_res['name_zadacha'].'</td><td>'.$zad_res['name_razdel'].'</td>';
							//echo '<td><a onclick="tb_show(\'\',\'/'.$zad_res['img_name'].'?TB_iframe=true\'); jQuery(\'#TB_window\').addClass(\'imagePopup\'); return false;" href="/'.$zad_res['img_name'].'"><img src="/getImage.php?file='.$zad_res['img_name'].'&w=200" alt=""  WIDTH="200"/></a></td>';
							$buf .= '<td><a href="/'.$zad_res['img_name'].'">Скачать условие</a></td>';
							//echo '<p><img src="/'.$zad_res['img_name'].'" alt=""/></p>';
							$buf .= '<td>'.$res['login'].'</td><td><p> $ '.$zad_res['price'].'</p></td>';
							$buf .= '<td><a class="buy" href="javascript:void(0)" onclick="tb_show(\'\',\'/cart.php?zid='.$zad_res['id'].'?TB_iframe=true\');jQuery(\'#TB_window\').addClass(\'cart\');  return false;" title="Купить"></a></td></tr>';
						}
                       
                        $select = '<select name="razdel" onChange="reload_page(\'metod_id='.$_GET['metod_id'].'&onpage='.$onpage_id.'&razdel=\' + $(this).children(\':selected\').val())">';

                        for ($x = 0; $x < count($razdely); $x++)
                        {
                            $select .= '<option '. ($razdel_id == $x ? 'selected' : '') .' value="'. $x .'">'. $razdely[$x] .'</option>';
                        }
                        $select .= '</select>';
						echo '<table class="solved"><tr><th>Название или<br/> номер задачи</th><th>Раздел '.$select.'</th><th>Описание</th><th>Загрузивший задачу</th><th>Цена $</th><th class="buyTH" title="Купить"></th></tr>';
                        echo $buf;
                        echo '</table>';
                        echo $pagination;
					}
				} else {
					echo '<div class="test2">';
					echo '<a class="imgWrap" onclick="tb_show(\'\',\'/'.$res['img_name'].'?TB_iframe=true\'); jQuery(\'#TB_window\').addClass(\'imagePopup\'); return false;"><img class="img1" src="/'.$res['img_name'].'" alt=""/></a>';
					echo '<ul><li><b>Страна:</b> '.$res['country'].'';
					echo '<li><b>Город:</b> '.$res['city'].'';
					echo '<li><b>ВУЗ:</b> '.$res['vuz_name'].'('.$res['vuz_short_name'].')';
					echo '<li><b>Кафедра:</b> '.$res['kafedra'].'';
					echo '<li><b>'.$arr[$res['diplom']].':</b> '.$res['metod_name'].'';
					echo '<li><b>Авторы:</b> '.$res['authors'].'</li>';
					echo '<li><b>Загрузивший:</b> '.$res['login'].'</li>';
					echo '<li><b>Год: </b> '.$res['year'].'';
					echo '<li><b>Страниц: </b> '.$res['pages'].'';
					echo '<li><b>Стоимость: $ </b> '.$res['price'].'';
					if($res['fileshort_name']!='') echo '<li><p><a class="piece" href="/'.$res['fileshort_name'].'">Скачать часть работы</a></p>';
					echo '<li><p><a class="buy" href="javascript:void(0)" onclick="tb_show(\'\',\'/cart.php?mid='.$res['id'].'?TB_iframe=true\'); jQuery(\'#TB_window\').addClass(\'cart\'); return false;">Купить</a></p></ul><div class="clear"></div>';

				}

				echo '';
			} ?>
		</div>
		<div class="main_mf searchBlock test23">
			<h3></h3>
			<input id="poisk" type="text" name="search" placeholder="По ключевым словам..." value="<?=$_POST['search']?>" />
<div id="form137">						
			<label>
			<select name="country" onchange="document.getElementById('form1').submit()"><option value="0">Выберите страну</option><?if(sizeof($sel_country)) echo implode($sel_country);?></select></label>
			<label>
			<select name="city" onchange="document.getElementById('form1').submit()"><option value="0">Выберите город</option><?if(sizeof($sel_city)) echo implode($sel_city);?></select></label>
			<label>
			<select name="vuz_name" onchange="document.getElementById('form1').submit()"><option value="0">Выберите ВУЗ</option><?if(sizeof($sel_vuz)) echo implode($sel_vuz);?></select></label>
			<label>
			<select name="kafedra" onchange="document.getElementById('form1').submit()"><option value="0">Выберите кафедру</option><?if(sizeof($sel_kafedra)) echo implode($sel_kafedra);?></select></label>
</div>
			<!--label>
			<select name="year" onchange="document.getElementById('form1').submit()" ><option value="0">Выберите год</option><?if(sizeof($sel_year)) echo implode($sel_year);?></select></label-->
			<!--input type="submit" value="Искать"/><br/>
			<input type="button" value="Сбросить фильтры" onclick="document.location.href='/k136.html'"-->
			<div class="searchBtn">
				<input class="search" type="submit" value="Искать"/>
				<a class="filtersOff" title="Сбросить фильтры" href="javascript:void(0);" onclick="document.location.href='/k136.html'">Сбросить фильтры</a>
			</div>
						
		</div>
	</form>
</div>
<?
	return;
}
?>


<?

		
		?>


<?
if(isset($_POST['sort'])&&$_POST['sort']=='datedesc') $sort = ' ORDER BY `year` DESC';
if(isset($_POST['sort'])&&$_POST['sort']=='dateasc') $sort = ' ORDER BY `year` ASC';
if(isset($_POST['sort'])&&$_POST['sort']=='vuzdesc') $sort = ' ORDER BY `vuz_name` DESC';
if(isset($_POST['sort'])&&$_POST['sort']=='vuzasc') $sort = ' ORDER BY `vuz_name` ASC';

$metods_onpages = array(10, 30, 50, 70, 90, 0);
$metods_onpage_id = (isset($metods_onpages[(int)$_POST['onpage']]) ? (int)$_POST['onpage'] : 0);
$metods_onpage = $metods_onpages[(int)$_POST['onpage']];
$metods_page = (isset($_POST['page']) ? (int)$_POST['page'] : '');


//echo 'SELECT km.*, ku.login, ku.id_p as uid FROM katalog_metods as km LEFT JOIN katalog_user as ku ON(ku.id_p = km.user_id) WHERE '.implode(" AND ", $where).''.(sizeof($wh2)>0?' AND ('.implode(' AND ', $wh2).')':'').''.$sort;
$query1 = mysql_query('SELECT COUNT(*) FROM katalog_metods as km LEFT JOIN katalog_user as ku ON(ku.id_p = km.user_id) WHERE '.implode(" AND ", $where).''.(sizeof($wh2)>0?' AND ('.implode(' AND ', $wh2).')':'').''.$sort );
$query1 = mysql_fetch_row($query1);
$metods_qty = $query1[0];
$metods_pages_qty = ceil($metods_qty / $metods_onpage);
$metods_page = (isset($_POST['page']) ? (int)$_POST['page'] : 1);
if($metods_page < 1 || $metods_page > $metods_pages_qty) $metods_page = 1;

$query = mysql_query('SELECT km.*, ku.login, ku.id_p as uid FROM katalog_metods as km LEFT JOIN katalog_user as ku ON(ku.id_p = km.user_id) WHERE '.implode(" AND ", $where).''.(sizeof($wh2)>0?' AND ('.implode(' AND ', $wh2).')':'').''.$sort.($metods_onpage ? ' LIMIT '. ( ($metods_page - 1) * $metods_onpage ).', '. $metods_onpage : ''));
?>


<!--td class="rightCol test3">
<table border="0" cellpadding=0 cellspacing=0-->
<div class="searchPage">

<form method="POST" id="form1" action="">

<div class="main_m searchBlock">
	<h3></h3>
	<a href="/k135.html">Загрузить задачу в магазин >></a>
	<div class="searchWrap">
	<p>В этом зазделе Вы можете как найти готовые, так и продать свои решенные задачи, лабораторные, курсовые или дипломы</p>
	<p>С помощью системы поиска Вы можете найти на сайте дипломные, курсовые, лабораторные работы, задачи и методички.<br /> 
		Воспользуйтесь общей системой поиска или установите фильтры. <br /> 
		Не нашли нужной задачи - закажите её решение, перейдя по ссылке: <a href="/k7-oformit_zakaz_pravila_zakaza_zadachi.html">заказать задачу</a> </p>
	<h2>Продажа задач</h2>
	<p>Чтобы продать свои задачи - перейдите в раздел <a href="/k135.html">"Мой магазин"</a></p>
	<input id="poisk" type="text" name="search" placeholder="По ключевым словам..." value="<?=$_POST['search']?>" />
	</div>
	<div class="searchBtn">
		<input class="search" type="submit" value="Искать"/>
		<!--input type="button" value="Сбросить фильтры" onclick="document.location.href='/k136.html'"-->
		<a class="filtersOff" title="Сбросить фильтры" href="javascript:void(0);" onclick="document.location.href='/k136.html'">Сбросить фильтры</a>
	</div>
	
	
<div class="main_mf searchBlock test24"  <?=(isset($_GET['user_id'])?' style="display:none" ':'')?> >

	<label>
	<select name="country" onchange="document.getElementById('form1').submit()"><option value="0">Выберите страну</option><?if(sizeof($sel_country)) echo implode($sel_country);?></select></label>
	<label>
	<select name="city" onchange="document.getElementById('form1').submit()"><option value="0">Выберите город</option><?if(sizeof($sel_city)) echo implode($sel_city);?></select></label>
	<label>
	<select name="vuz_name" onchange="document.getElementById('form1').submit()"><option value="0">Выберите ВУЗ</option><?if(sizeof($sel_vuz)) echo implode($sel_vuz);?></select></label>
	<label>
	<select name="kafedra" onchange="document.getElementById('form1').submit()"><option value="0">Выберите кафедру</option><?if(sizeof($sel_kafedra)) echo implode($sel_kafedra);?></select></label>
	<label>
	<select name="year" onchange="document.getElementById('form1').submit()" ><option value="0">Выберите год</option><?if(sizeof($sel_year)) echo implode($sel_year);?></select></label>
	<input type="hidden" name="sort" value="datedesc"/>
<!--<div class="searchBtn">
		<input type="submit" value="Искать"/>
		<input type="button" value="Сбросить фильтры" onclick="document.location.href='/k136.html'">
		<a class="filtersOff" title="Сбросить фильтры" href="javascript:void(0);" onclick="document.location.href='/k136.html'">Сбросить фильтры</a>
	</div>
-->
				
</div>
	
	
	
<?
if(sizeof($where)==1&&!sizeof($wh2)){

} else 

if(mysql_num_rows($query)==0){
	echo '<div style="color: #f00; text-align: left;">
			<p>По запросу <b>'.$_POST['search'].'</b> ничего не найдено.</p>

			<p>Рекомендации:</p>
			<ul>
				<li>Убедитесь, что все слова написаны без ошибок.
				<li>Попробуйте использовать другие ключевые слова.
				<li>Попробуйте использовать более популярные ключевые слова.
			</ul>
		</div>';
} else { ?>
<?
$select = '<select name="metods_onpage" onChange="document.getElementById(\'form1\').page.value=1;document.getElementById(\'form1\').onpage.value = $(this).children(\':selected\').val();document.getElementById(\'form1\').submit();">';
for ($x = 0; $x < count($metods_onpages); $x++)
{
    if($metods_onpages[$x] == 0) $select .= '<option '. ($metods_onpage_id == $x ? 'selected' : '') .' value="'. $x .'">Все</option>';
    else $select .= '<option '. ($metods_onpage_id == $x ? 'selected' : '') .' value="'. $x .'">'. $metods_onpages[$x] .'</option>';
}
$select .= '</select>';
//$select = '';

?>
<p>Найдено <?=$metods_qty?> задач. <?=' Страница: '.$metods_page?>  <span style="float: right">Количество задач на странице: <?=$select?></span></p>
<table class="searchResults"><tr>
	<th>Фото</th>
	<th>Название</th><th>Авторы</th>
	<th>Вуз&nbsp;
		<a href="javascript:void(0)" onclick="document.getElementById('form1').sort.value = 'vuzdesc';document.getElementById('form1').submit()" class="minus"></a>&nbsp;
		<a href="javascript:void(0)" onclick="document.getElementById('form1').sort.value = 'vuzasc';document.getElementById('form1').submit()" class="plus"></a>
	</th>
	<th>Кафедра</th><th>Страна</th><th>Город</th>
	<th style="width: 60px;">Год&nbsp;
		<a href="javascript:void(0)" onclick="document.getElementById('form1').sort.value = 'datedesc';document.getElementById('form1').submit()" class="minus"></a>&nbsp;
		<a href="javascript:void(0)" onclick="document.getElementById('form1').sort.value = 'dateasc';document.getElementById('form1').submit()" class="plus"></a>
	</th></tr>

<?	while($res = mysql_fetch_array($query)){
		$count = mysql_fetch_array(mysql_query('SELECT COUNT(*) FROM katalog_metods_zad WHERE metod_id = '.$res['id'].''));

		echo '<tr><td><a onclick="tb_show(\'\',\'/'.$res['img_name'].'?TB_iframe=true\'); jQuery(\'#TB_window\').addClass(\'imagePopup\'); return false;" href="/'.$res['img_name'].'"><img src="/getImage.php?file='.$res['img_name'].'" alt=""  WIDTH="45"/></a></td>';
		echo '<td><a class="name" href="/k136.html?metod_id='.$res['id'].'">'.$res['metod_name'].'</a><!--br/>Автор:<a href="/k136.html?user_id='.$res['uid'].'">'.$res['login'].'</a--></td>';
		echo '<td>'.$res['authors'].'</td>';
		echo '<td>'.$res['vuz_short_name'].'</td>';
		echo '<td>'.$res['kafedra'].'</td>';
		echo '<td>'.$res['country'].'</td>';
		echo '<td>'.$res['city'].'</td>';
		echo '<td>'.$res['year'].'</td></tr>';
		//echo '<td>решенных задач:'.$count[0].'</td>';
	}
	
?> 
</table> 
<?
		if((int)$metods_pages_qty > 1)
        {
            echo '<center><font size="2" face="Arial">Страница: ';
    		for($i=1;$i<=$metods_pages_qty;$i++){
    			if($i == $metods_page) echo '<span style="text-decoration:underline;color:green"><b> '.$i.' </b></span>';
    			else echo '<a href="javascript:void(0)" onclick="document.getElementById(\'form1\').onpage.value='.$metods_onpage_id.';document.getElementById(\'form1\').page.value='.$i.';document.getElementById(\'form1\').submit();" class=blue><b>'.$i.'</b></a>'.' ';
    		}
    		echo '</font></center>';            
        }


}

?>

</div>
<!--div class="main_mf searchBlock test24"  <?=(isset($_GET['user_id'])?' style="display:none" ':'')?> >

	<label>
	<select name="country" onchange="document.getElementById('form1').submit()"><option value="0">Выберите страну</option><?if(sizeof($sel_country)) echo implode($sel_country);?></select></label>
	<label>
	<select name="city" onchange="document.getElementById('form1').submit()"><option value="0">Выберите город</option><?if(sizeof($sel_city)) echo implode($sel_city);?></select></label>
	<label>
	<select name="vuz_name" onchange="document.getElementById('form1').submit()"><option value="0">Выберите ВУЗ</option><?if(sizeof($sel_vuz)) echo implode($sel_vuz);?></select></label>
	<label>
	<select name="kafedra" onchange="document.getElementById('form1').submit()"><option value="0">Выберите кафедру</option><?if(sizeof($sel_kafedra)) echo implode($sel_kafedra);?></select></label>
	<label>
	<select name="year" onchange="document.getElementById('form1').submit()" ><option value="0">Выберите год</option><?if(sizeof($sel_year)) echo implode($sel_year);?></select></label>
	<input type="hidden" name="sort" value="datedesc"/>
	<!--div class="searchBtn">
		<input type="submit" value="Искать"/>
		<!--input type="button" value="Сбросить фильтры" onclick="document.location.href='/k136.html'"-->
		<!--a class="filtersOff" title="Сбросить фильтры" href="javascript:void(0);" onclick="document.location.href='/k136.html'">Сбросить фильтры</a>
	</div-->
				
<!--/div-->
<input type="hidden" name="page" value="<?=(int)$_POST['page']?>"/>
<input type="hidden" name="onpage" value="<?=(int)$_POST['onpage']?>"/>
</form>
</div>
<!--/td-->
<?

//print_r(mysql_fetch_array($query));
//exit;

?>