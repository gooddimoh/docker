<?
if(isset($_SESSION[userpas]) and isset($_SESSION[userlogin]) and isset($_SESSION[userpolz]) and isset($_SESSION[userzadach]) and isset($_SESSION[userresh])){
	$f=mysql_fetch_array(mysql_query("select id_p,resh from katalog_user where login='$_SESSION[userlogin]' and user_password='$_SESSION[userpas]' and id_p in(select id from katalog where menu_dozvil='0' and menu_vizible='0' and page_type='4') limit 1"));
	if($f[id_p]==''){
		unset($_SESSION[userpas]);
		unset($_SESSION[userlogin]);
		unset($_SESSION[userpolz]);
		unset($_SESSION[userzadach]);
		unset($_SESSION[userresh]);
		$_SESSION[logintrue]=0;
	}else{
		$_SESSION[logintrue]=1;
		$_SESSION[userid]=$f[id_p];
		$_SESSION[userresh]=$f[resh];

		if(isset($_GET['clean'])&&isset($_GET['id'])&&(int)$_GET['id']){
		// очистим сообщения отвечающие за назначение решающего
			@mysql_query('UPDATE katalog_message SET new_resh = 0, select_resh = 0, resh_ok = 0, status = 1 WHERE ( resh_ok > 0 OR new_resh > 0 OR select_resh >0 ) AND status = 0 AND user_out = '.(int)$_SESSION[userid].'');
		}

		$email=mysql_query("select id, new_resh, select_resh, resh_ok from katalog_message where user_out='$_SESSION[userid]' and status='0'");
		if(@mysql_num_rows($email)!=0){
			$no_msg = 0;
			$_SESSION[result]=array();
			while($row = mysql_fetch_array($email)) {
				if((int)$row['new_resh']>0) { $no_msg = 1; array_push($_SESSION[result],'<br><br><br><font style="font-size:18.7px">Вашу задачу посмотрели и готовы решить. <a href="k95.html?id='.(int)$row['new_resh'].'&st=6&clean">Кликните, чтобы посмотреть состояние Вашей задачи.</a></font><br><br><br>');}
				if((int)$row['select_resh']>0) { $no_msg = 1; array_push($_SESSION[result],'<br><br><br><font style="font-size:18.7px">Вас выбрали решающим задачи ID='.$row['select_resh'].'. Можете приступать к ее решению.</font><br><br><br>');}
				if((int)$row['resh_ok']>0) { $no_msg = 1; array_push($_SESSION[result],'<br><br><br><font style="font-size:18.7px">Ваша задача решена.<br/><a href="/modul/status.php?id='.(int)$row['resh_ok'].'&st=2&clean">Кликните, чтобы скачать решение задачи.</a></font><br><br><br>');}
			}
			if($no_msg == 0)
				array_push($_SESSION[result],'<br><br><br><font style="font-size:18.7px">Вам пришло новое сообщение <a href="k18.html?in">просмотреть</a></font><br><br><br>');
		}
	}
}else{$_SESSION[logintrue]=0;}

?>