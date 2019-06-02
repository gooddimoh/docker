<?
	include "../mysql.php";
	if(!isset($_GET[f])){
		$r = mysql_query("SELECT id_p,url,urlresh FROM katalog_zadach where id_p='$_GET[id]' limit 1");
		$f=mysql_fetch_array($r);
		if($f[id_p]){
			if(isset($_GET[u])){
				$file_name='../'.$f[url];
			}else if(isset($_GET[r])){
		        $file_name='../'.$f[urlresh];
			}else{header("Location:http://stud-help.com/");exit();}
		}else{header("Location:http://stud-help.com/");exit();}
	}else if(isset($_GET[f])){
		$r = mysql_query("SELECT id,url FROM katalog_files where id='$_GET[id]' limit 1");
		$f=mysql_fetch_array($r);
		if($f[id]){
			$file_name='../'.$f[url];
		}else{header("Location:http://stud-help.com/");exit();}
	}else{header("Location:http://stud-help.com/");exit();}

    if (file_exists($file_name) && $file_name != '../')
    {
    	header("Content-Length: ".filesize($file_name));
    	header("Content-Disposition: attachment; filename=".$file_name);
    	header("Content-Type: application/x-force-download; name=\"".$file_name."\"");
    	readfile($file_name);
    }
    else
    {
        echo <<<_SC
      <script>
        alert("Даная задача удалена из-за окончания срока ее размещения на сайте");
        window.close();
      </script>  
_SC;
    }
?>