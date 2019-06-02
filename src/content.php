<?
include "modul/error.php";
include "modul/result.php";
if($ide[0]=="k"){include "modul/page.php";}
else if($ide==""){$d=4; include "modul/page.php";}
else {echo '<script lang=javascript>location.href="http://'.$_SERVER["SERVER_NAME"].'"</script>';}

if($d==6){include "modul/zadachi.php";}
else if($d==7){include "modul/zakaz.php";}
else if($d==13){include "mail/index.php";}
else if($d==16){include "modul/reg.php";}
else if($d==12){include "modul/otzivi.php";}
else if($d==2){include "modul/polzov.php";}
else if($d==77){include "modul/oneuser.php";}
else if($d==20){include "modul/enter.php";}
else if($d==74){include "modul/recoverykey.php";}
else if($d==75){include "modul/recoveryemail.php";}
else if($d==18){include "modul/message.php";}
else if($d==19){include "modul/balans.php";}
else if($d==21){include "modul/profil.php";}
else if($d==95){include "modul/status_form.php";}
else if($d==134){include "modul/files.php";}
else if($d==135){include "modul/metods.php";}
else if($d==136){include "modul/metods_list.php";} 
else if($d==137){include "modul/metods_edit.php";}
else if($d==138){include "checkout_success.php";}
?>