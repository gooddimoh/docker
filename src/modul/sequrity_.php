<?
if(isset($_SESSION[userpas]) and isset($_SESSION[userlogin]) and isset($_SESSION[userpolz]) and isset($_SESSION[userzadach]) and isset($_SESSION[userresh])){	$f=mysql_fetch_array(mysql_query("select id_p,resh from katalog_user where login='$_SESSION[userlogin]' and pas='$_SESSION[userpas]' and id_p in(select id from katalog where menu_dozvil='0' and menu_vizible='0' and page_type='4') limit 1"));
	if($f[id_p]==''){
		unset($_SESSION[userpas]);
		unset($_SESSION[userlogin]);
		unset($_SESSION[userpolz]);
		unset($_SESSION[userzadach]);
		unset($_SESSION[userresh]);
		$_SESSION[logintrue]=0;	}else{		$_SESSION[logintrue]=1;
		$_SESSION[userid]=$f[id_p];
		$_SESSION[userresh]=$f[resh];

		$email=mysql_query("select id from katalog_message where user_out='$_SESSION[userid]' and status='0'");
		if(@mysql_num_rows($email)!=0){
			$_SESSION[result]=array();
			array_push($_SESSION[result],'<br><br><br><font style="font-size:18.7px">Вам пришло новое сообщение <a href="k18.html?in">просмотреть</a></font><br><br><br>');
		}
	}
}else{$_SESSION[logintrue]=0;}

?>