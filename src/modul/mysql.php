<?$link=mysql_connect("localhost","admin_zadachi","df439fTWiD") or die("Could not connect");
//$link=mysql_connect("db.trio.hosted.in","zadachic_main","CTZDIyvqnKy7") or die("Could not connect");
if( !$link ) die( mysql_error() );
mysql_select_db ("admin_zadachi-new")or die("Could not connec1");
mysql_query ("set character_set_client='cp1251'");
mysql_query ("set character_set_results='cp1251'");
mysql_query ("set collation_connection='cp1251_general_ci'");
date_default_timezone_set('Europe/Moscow');

header('X-Frame-Options: SAMEORIGIN');
header('X-XSS-Protection: 1; mode=block');

$max_size_file = '2M';
$max_size_file_int = 2* 1024 * 1024;

if(count($_FILES) > 0)
{
    foreach($_FILES as $file)
    {
        if($file['size'] > $max_size_file_int || $file['error'] == UPLOAD_ERR_INI_SIZE)
        {
            $_FILES = array();
            $_POST = array();
            $_SERVER['REQUEST_METHOD'] = 'POST';
            break;
        }
        
        if($file['error'] == UPLOAD_ERR_OK || $file['error'] == UPLOAD_ERR_NO_FILE)
            continue;
            
        echo '<script>alert("Не удалось загрузить файл. Код ошибки: '.$file['error'].'"); window.history.back();</script>';
        die();
    }
}

if($_SERVER['REQUEST_METHOD'] == 'POST' && !count($_POST) && !count($_FILES))
{
    echo '<script>alert("Файл превышает '.$max_size_file.', слишком большой"); window.history.back();</script>';
    die();
}

require_once('remember_user.php');

?>