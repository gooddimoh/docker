<?
include "mysql.php";
if (isset($_GET[id]))
{
$f = mysql_fetch_array(mysql_query("SELECT inu FROM katalog_finanse where id='$_GET[id]' limit 1"));
if($f[inu]==-1){mysql_query("delete from katalog_wm where id_p='$_GET[id]' limit 1");}
else if($f[inu]==-2){mysql_query("delete from katalog_ik where id_p='$_GET[id]' limit 1");}
else if($f[inu]==-3){mysql_query("delete from katalog_liqpay where id_p='$_GET[id]' limit 1");}

mysql_query("delete from katalog_finanse where id='$_GET[id]' limit 1");
header("Location:stat.html");
} 
else
{
    if (count($_POST['itms']) > 0)
    {
        foreach($_POST['itms'] as $_GET[id])
        {
            $f = mysql_fetch_array(mysql_query("SELECT inu FROM katalog_finanse where id='$_GET[id]' limit 1"));
            if($f[inu]==-1){mysql_query("delete from katalog_wm where id_p='$_GET[id]' limit 1");}
            else if($f[inu]==-2){mysql_query("delete from katalog_ik where id_p='$_GET[id]' limit 1");}
            else if($f[inu]==-3){mysql_query("delete from katalog_liqpay where id_p='$_GET[id]' limit 1");}
            
            mysql_query("delete from katalog_finanse where id='$_GET[id]' limit 1");
        }
    }
header("Location:stat.html");
}
?>