<?php

include "mysql.php";


$l=trim(stripslashes($_GET['q']));

if(strlen($l)<3) exit;

	$arr_s = array('vuz_name', 'vuz_short_name', 'kafedra', 'year', 'metod_name');
	$s = addslashes(trim(iconv('utf-8','cp1251',$_GET['q']))); $s = explode(" ", $s);
//	foreach($arr_s as $item) if(is_array($s)) foreach($s as $item2) $wh2[] = $item.' LIKE "%'.$item2.'%"';
//		else $wh2[] = $item.' LIKE "%'.$s.'%"';

	if(is_array($s)) foreach ($s as $item2) $wh2[] = ' CONCAT(`vuz_name`, `vuz_short_name`, `kafedra`, `year`, `metod_name`, `description`) LIKE "%'.$item2.'%"';
		else $wh2[] = ' CONCAT(`vuz_name`, `vuz_short_name`, `kafedra`, `year`, `metod_name`, `description`) LIKE "%'.$s.'%"';

	$where[] = 'km.status = 1';

	//echo 'SELECT km.*, ku.login FROM katalog_metods as km LEFT JOIN katalog_user as ku ON(ku.id_p = km.user_id) WHERE '.implode(" AND ", $where).''.(sizeof($wh2)>0?' AND ('.implode(' OR ', $wh2).')':'').'';
	$query = mysql_query('SELECT km.*, ku.login FROM katalog_metods as km LEFT JOIN katalog_user as ku ON(ku.id_p = km.user_id) WHERE '.implode(" AND ", $where).''.(sizeof($wh2)>0?' AND ('.implode(' AND ', $wh2).')':'').'');
	while($res = mysql_fetch_array($query)) {
		$i++;	
		echo $res['metod_name']."\n";
	}

?>
