<title><?

function err404()
{
    header('Location: /k5774.html');
    die();
}


if($_SESSION[mat_lang]==''){$_SESSION[mat_lang]=='ru';}
$ide=$_GET[ide];

if($ide[0]=="k"){

	$zahv="k";

	for($i=0;$i<strlen($ide);$i++){
		if($ide[$i]=='k' and $forvard!=1){$zahv="k";$i++;$forvard=1;}
		else if($ide[$i]=='-'){$zahv="";$i=strlen($ide);}
		if($zahv=="k"){$d.=$ide[$i];}
  	}

	$content = mysql_query("SELECT * FROM katalog where id='$d' limit 1");
    
}else if($ide==''){
    
	$content = mysql_query("SELECT * FROM katalog where id='6' limit 1");$d=6;
}else{
    
    err404();
  //  $title='Решебник задач';
}

if($d!=''){
    $contentf=mysql_fetch_array($content);
    
    if($d != 6)
    {
        $buf = '/k' . $d . '-' . $contentf[page_translit] . '.html';
        $buf1 = '/k' . $d . '.html';
        $uri = (strpos($_SERVER['REQUEST_URI'], '?') === false ? $_SERVER['REQUEST_URI'] : substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['REQUEST_URI'], '?')));
        if($buf != $uri && $buf1 != $uri) err404();   
    }

    
	$title=$contentf[page_title];
	$desc=$contentf[page_descr];
	$title.=' | Решебник задач';
	$name=$contentf[page_name];
	$keyword=$contentf[page_keyword];
    define('BOTTOM_SEO_TEXT', $contentf[bottom_text], true);
} 
echo $title;
?></title>
<meta name="Description" content="<?echo $desc;?>">
<meta name="Keywords" content="<?echo $keyword;?>">
