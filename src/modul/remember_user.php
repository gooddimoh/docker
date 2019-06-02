<?php

function fix_xss(&$v)
{
    if(is_array($v))
    {
        foreach($v as $key => $val)
            fix_xss($v[$key]);
    }
    elseif(is_string($v))
    {
        $v = strip_tags($v);
    }
}

fix_xss($_POST);
fix_xss($_GET);
fix_xss($_REQUEST);


class UserRememberEnterException extends Exception { }

function remember_user($user_id)
{
    $data = array();
    $data['data_rand'] = mcrypt_create_iv(64, MCRYPT_DEV_URANDOM);
    $data['salt'] = mcrypt_create_iv(64, MCRYPT_DEV_URANDOM);
    $data['hash'] = hash('sha512', $user_id . $data['data_rand'] . $data['salt']);
    $data['expire'] = time() + (14 * 24 * 60 * 60);
    $data['ip'] = $_SERVER['REMOTE_ADDR'];
    
    $data['data_rand'] = base64_encode($data['data_rand']);
    $data['salt'] = base64_encode($data['salt']);
    
    setcookie('user_remember', implode(':', array($user_id, $data['data_rand'], $data['hash'])), $data['expire'], '/', null, false, true);

    mysql_query('UPDATE katalog_user 
                 SET remember_user = "' . addslashes(json_encode($data)) . '"
                 WHERE id_p = ' . $user_id);
    
}

function enter_remember_user()
{
    list($user_id, $data_rand, $hash) = explode(':', $_COOKIE['user_remember']);
    
    $user_id = (int)$user_id;
    
    if(!$user_id || !$data_rand || !$hash)
        return;
    
    $q = mysql_query('SELECT * FROM katalog_user WHERE id_p = ' . $user_id);
    if(!$f = mysql_fetch_assoc($q))
        return;
    
    if(!$data = json_decode($f['remember_user']))
        return;
    
    try{
        
        if($data->expire <= time()) throw new UserRememberEnterException;
        if($data->ip !== $_SERVER['REMOTE_ADDR']) return;
        if(hash('sha512', $user_id . base64_decode($data_rand) . base64_decode($data->salt)) !== $hash) return;
        if($data->data_rand !== $data_rand) throw new UserRememberEnterException;
        
        
        $f2=mysql_fetch_assoc(mysql_query("select menu_vizible,menu_dozvil from katalog where id=$user_id limit 1"));
    	if($f2[menu_dozvil]==1 || $f2[menu_vizible]==1) throw new UserRememberEnterException;
        
    	$f3 = mysql_query("select * from katalog_userIP where block = 1");
    	if(mysql_num_rows($f3))
    		while($row = mysql_fetch_array($f3)){
    			$mask = explode(".", $row['mask_IP']);
    			$ip = explode(".", $row['user_IP']);
    			$remote = explode(".", $_SERVER['REMOTE_ADDR']);
    			if(sizeof($mask)!=4||sizeof($ip)!=4||sizeof($remote)!=4) continue;
    			$err = 1;
    			for($i=0;$i<4;$i++){
    				if(((int)$remote[$i]&(int)$mask[$i])!=((int)$ip[$i]&(int)$mask[$i])) { $err = 0; }
    			}
    			if($err) return;
    		}
        
		$_SESSION[userlogin]=$f[login];
		$_SESSION[userpas]=$f['user_password'];
		$_SESSION[userpolz]=$f[polz];
		$_SESSION[userzadach]=$f[zad];
		$_SESSION[userresh]=$f[resh];
        
        mysql_query("update katalog_user set dat_enter=".time()." where id_p=$user_id limit 1");
        mysql_query("insert into katalog_stat(data,id_user,ip,status) values(".time().", $user_id, '".$_SERVER['REMOTE_ADDR']."','$f[resh]')");
        remember_user($user_id);
              
    }catch(UserRememberEnterException $e){
        
        exit_remember_user($user_id);
        
    }
}

function exit_remember_user($user_id)
{
    if(!$user_id) return;
    
    setcookie('user_remember', '', 1, '/', null, false, true);
    mysql_query('UPDATE katalog_user SET remember_user = NULL WHERE id_p = ' . $user_id);
}

if(!empty($_COOKIE['user_remember']) && !isset($_SESSION[userlogin]))
    enter_remember_user();
    
