<?php

Class UserStatus {
    
    public $active_ajax_online;
    
    public function __construct($updated = true) {
       
        if (!$updated) return;
        
        $time=time(); 
        mysql_query("update katalog_stat set data='$time' where id='$_SESSION[statistik_id]' limit 1"); 
        
        if (isset($_SESSION[userid]) and $_SESSION[userid] > 0)
        {
            $q = mysql_query('SELECT COUNT(*) FROM ajax_actives WHERE usr_id = '.$_SESSION[userid]);
            $q = mysql_fetch_row($q);
            if ($q[0] == 0) $this->active_ajax_online = 1;
            else $this->active_ajax_online = 0;
        } 
        else $this->active_ajax_online = 1;
     }
     
    
    public function save_user_status()
    {
        $_SESSION['online_list'] = array();
        $q = mysql_query('SELECT id_user FROM katalog_stat WHERE id_user > 0');
       
        if(mysql_num_rows($q))
            while($res = mysql_fetch_assoc($q))
                $_SESSION['online_list'][] = $res['id_user'];
    }
    
    public function get_new_users()
    {
        if ($this->active_ajax_online == 0) return;
        
        $q = mysql_query('SELECT id_user,status FROM katalog_stat WHERE id_user > 0');
        $buf = array();
        while($res = mysql_fetch_assoc($q))
        {
            $buf[] = $res['id_user'];
            if (!in_array($res['id_user'],$_SESSION['online_list']))
            {
                  $q2 = mysql_query('SELECT login FROM katalog_user WHERE id_p = '.$res['id_user']);
                  $usr_name = mysql_fetch_row($q2);
                  $result .= '<li><a href="k77.html?id_user='.$res['id_user'].'">'.$usr_name[0].'</a>';
                  if ($res['status'] == 1) $result .= '(Решающий)';
                  else $result .= '(Заказчик)';
                  $result .= '</li>';
                  $_SESSION['online_list'][] = $res['id_user'];
            }
        }
        
        if (count($buf) <> count($_SESSION['online_list']))
            for ($x=0; $x<count($_SESSION['online_list']); $x++)
              if (!in_array($_SESSION['online_list'][$x],$buf)) unset($_SESSION['online_list'][$x]);

        if (strlen($result) > 0) echo '<center><b>На сайт зашли:</b></center>' . $result;  
        else echo $result;
    }
      
}

?>