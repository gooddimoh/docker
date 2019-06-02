<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/modul/custom_sessions.php"; CustomSessions::start();
if ($_GET['pss'] == 'fyBek3m0T3D1md' && isset($_SESSION[userid]) and $_SESSION[userid] > 0)
{
    include "mysql.php";
    
    if ($_GET['active'] == 'true')
    {
        mysql_query('DELETE FROM ajax_actives WHERE usr_id = '.$_SESSION[userid]);
    } 
    else
    {
      $q = mysql_query('SELECT COUNT(*) FROM ajax_actives WHERE usr_id = '.$_SESSION[userid]);
      $q = mysql_fetch_row($q);
        if ($q[0] == 0) mysql_query('INSERT INTO ajax_actives VALUES('.$_SESSION[userid].',0)');
    } 
    
}

?>