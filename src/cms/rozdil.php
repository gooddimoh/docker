<?
$a=array();
$key=0;$menu=0;
$vuvid=0;$versh=0;
$poch=0;

$rs=mysql_query("select id from katalog where page_type='1'");
$kil=mysql_num_rows($rs);

while(count($a)<$kil){

	$rs=mysql_query("select * from katalog where id_p='$key' and page_type='1' order by menu_sort asc");
	$versh=0;

	for($i=0;$i<$kil;$i++){
		$fs=mysql_fetch_array($rs);
		if($fs[id_p]==$key and !in_array($fs[id],$a)){
			array_push($a,$fs[id]);$key=$fs[id];$versh=1;

			if($fs[id_p]==$poch){$vuvid=1;}

				if($vuvid==1){
				echo '<option value="',$fs[id],'" ';if($fs[id]==$vuv){echo 'selected';$nopage=1;}if($menu==0){echo ' style="background-color:#99CCFF" ';}echo '>';
				$menu++;
				for($h=0;$h<=$menu;$h++){echo '&nbsp;&nbsp;';}
				echo substr($fs[page_name],0,70),'...</option>';
				}
			}
        }

	if($versh==0){
		$rs=mysql_query("select id,id_p from katalog where id='$key'");
		$fs=mysql_fetch_array($rs);$key=$fs[id_p];$menu=$menu-1;
		if($fs[id_p]==$poch){$vuvid=0;}

	}

}
	if($nopage==0){		$rs=mysql_query("select * from katalog where id='$vuv' limit 1");
		$fs=mysql_fetch_array($rs);
		echo '<option value="',$fs[id],'" selected style="background-color:#E7E7E7">',substr($fs[page_name],0,70),'...</option>';	}
?>