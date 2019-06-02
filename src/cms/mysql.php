<?$link=mysql_connect("localhost","admin_zadachi","df439fTWiD") or die("Could not connect");
//$link=mysql_connect("db.trio.hosted.in","zadachic_main","CTZDIyvqnKy7") or die("Could not connect");
if( !$link ) die( mysql_error() );
mysql_select_db ("admin_zadachi-new")or die("Could not connec1");
mysql_query ("set character_set_client='cp1251'");
mysql_query ("set character_set_results='cp1251'");
mysql_query ("set collation_connection='cp1251_general_ci'");

//header('X-Frame-Options: SAMEORIGIN');
//header('X-XSS-Protection: 1; mode=block');
?>