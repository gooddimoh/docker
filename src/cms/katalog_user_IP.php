<?
/*
 * Модуль для розсилки повыдомлень на емайли..
 * Вхідні дані берез POST
 * */

if(isset($_POST['add']))
{
    if($_POST['ip']!=''&&$_POST['mask']!='')
        $_POST['ar_ip'][] = $_POST['ip'] . '|' . $_POST['mask'];
    
    foreach($_POST['ar_ip'] as $id => $ip_mask)
    {
        list($ip, $mask) = explode('|', $ip_mask);
        mysql_query("REPLACE `katalog_userIP` VALUES ('',0,'".addslashes($ip)."','".addslashes($mask)."',0,1)");
        
        if($id) mysql_query('UPDATE katalog_userIP SET block = 1 WHERE id = ' . (int)$id);
    }    
}

if(isset($_POST['del']) && count($_POST['ar_ip']))
{
    mysql_query("DELETE from katalog_userIP WHERE CONCAT(user_ip, '|', mask_ip) IN('". implode("','", array_map('addslashes', $_POST['ar_ip'])) ."') AND id_p = 0");
    mysql_query("UPDATE katalog_userIP SET block = 0 WHERE CONCAT(user_ip, '|', mask_ip) IN('". implode("','", array_map('addslashes', $_POST['ar_ip'])) ."')");
}

if(isset($_POST['ip_del']) && count($_POST['ar_ip']))
{
    mysql_query("DELETE from katalog_userIP WHERE id IN(". implode(',', array_map('intval', $_POST['ar_ip'])) .") AND id_p = 0");
    mysql_query("UPDATE katalog_userIP SET block = 0 WHERE id IN(". implode(',', array_map('intval', $_POST['ar_ip'])) .")");
}

if(isset($_GET[id_p])&&(int)$_GET[id_p]>0){
	//echo '<style>td{border:grey solid 2px;}</style>';
	$r = mysql_query("select * from katalog_user WHERE id_p = ".(int)$_GET['id_p']."");
	$row = mysql_fetch_array($r);
    echo '<form action="/cms/katalog_user_IP.html?id_p='.(int)$_GET['id_p'].'" method="post">';
    ?>
    
    <script>
    function SearchIP(ip)
    {
        if(ip !== false)
        {
            $('[data-search-ip]').each(function(){
                
                var self = $(this);
                
                if($.trim(self.text()) == ip)
                    self.parent().show();
                else
                    self.parent().hide();
                
            });
        }
        else
            $('[data-search-ip]').parent().show();
    }
    </script>
	
	<table style="border:grey solid 2px;"><tr style="border:grey solid 2px;"><td colspan="4">Пользователь <?=$row['login']?>, <?=$row['email']?></td></tr>
	<tr><td>№</td><td>IP</td><td>MASK</td><td>block</td><td><input type="checkbox" onclick="if(!this.checked) $('[data-add-in-blacklist]').removeAttr('checked'); else $('[data-add-in-blacklist]').attr('checked', 'checked');" /></td></tr>
<?
	$r = mysql_query("select * from katalog_userIP WHERE id_p = ".(int)$_GET[id_p]."");

	while($row = mysql_fetch_array($r)) 
		echo '<tr><td>'.++$i.'</td><td>'.$row['user_IP'].'</td><td>'.$row['mask_IP'].'</td><td>'.$row['block'].'</td><td><input type="checkbox" data-add-in-blacklist name="ar_ip['.$row['id'].']" value="'.$row['user_IP'].'|'.$row['mask_IP'].'" /></td></tr>';
	echo '</table>';
    echo '<br /><input type="submit" name="add" value="Заблокировать выбранные" /> <input type="submit" name="del" value="Разблокировать выбранные" />';
    echo '</form>';
	
    
    echo '<br /><br /><br /><input type="text" id="ip-search" /> <input type="button" onclick="SearchIP($(\'#ip-search\').val());" value="Найти" /> <input type="button" onclick="SearchIP(false); $(\'#ip-search\').val(\'\');" value="Сбросить" /><br /><br />';
    echo '<form action="/cms/katalog_user_IP.html?id_p='.(int)$_GET['id_p'].'" method="post">';
    echo '<table style="border:grey solid 2px;"><tr><td colspan="5">Все заблокированные IP</td></tr><tr><td>№</td><td>IP</td><td>MASK</td><td>block</td><td><input type="checkbox" onclick="if(!this.checked) $(\'[data-del-in-blacklist]\').removeAttr(\'checked\'); else $(\'[data-del-in-blacklist]\').attr(\'checked\', \'checked\');" /></td></tr>';
	$r = mysql_query("select * from katalog_userIP WHERE block = 1 AND id_p = 0");
	$i = 0;
	while($row = mysql_fetch_array($r)) 
		echo '<tr><td>'.++$i.'</td><td data-search-ip>'.$row['user_IP'].'</td><td>'.$row['mask_IP'].'</td><td>'.$row['block'].'</td><td><input type="checkbox" data-del-in-blacklist name="ar_ip[]" value="'.$row['id'].'" /></td></tr>';
	echo '</table>';
    echo '<br /><input type="submit" name="ip_del" value="Удалить выбранные из чёрного списка" />';
    echo '<br /><br /><input type="submit" name="ip_del" onclick="if(!confirm(\'Очистить чёрный список?\')) return false; $(\'[data-del-in-blacklist]\').attr(\'checked\', \'checked\');" value="Очистить чёрный список" />';
	echo '</form>';
    
    echo '<br/><br/><form action="/cms/katalog_user_IP.html?id_p='.(int)$_GET['id_p'].'" method="post">';
	echo 'IP:<input type="text" name="ip"/>&nbsp;MASK:<input type="text" name="mask" value="255.255.255.255"/><input type="hidden" name="add" value="1"/>';
	echo '<input type="submit" name="sub" value="Добавить">';
	echo '</form>';
}
?>

