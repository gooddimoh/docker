<img src="images/scaper.gif" height=1 width=800><br>
<table width=100%>
	<tr>
		<!--<td width=200 valign=top>
			<div style="width:200px;height:380px;overflow:auto;">
			<img src="images/scaper.gif" height=1 width=300>
			<?//include "tree.php";?></div>
		</td>-->
		<td valign=top><?
			$ide=$_GET[ide];
			if($_GET[ide]=="main"){include "main.php";}
			else if($_GET[ide]=="katalog"){include "katalog.php";}
            else if($_GET[ide]=="log"){include "log.php";}
			else if($_GET[ide]=="katalog_redag"){include "katalog_redag.php";}
			else if($_GET[ide]=="katalog_add"){include "katalog_add.php";}
			else if($_GET[ide]=="zayavka"){include "zayavka.php";}
			else if($_GET[ide]=="city"){include "city.php";}
			else if($_GET[ide]=="info"){include "info.php";}
			else if($_GET[ide]=="vivod"){include "vivod.php";}
			else if($_GET[ide]=="stat"){include "stat.php";}
			else if($_GET[ide]=="message"){include "message.php";}
			else if($_GET[ide]=="config"){include "config.php";}
			else if($_GET[ide]=="katalog_user_IP"){include "katalog_user_IP.php";}
			else if($_GET[ide]=="katalog_send_mail"){include "katalog_send_mail.php";}
			else if($_GET[ide]=="metods"){include "metods.php";}
			else if($_GET[ide]=="metods_edit"){include "metods_edit.php";}
			else if($_GET[ide]=="orders"){include "orders.php";}
			else{include "main.php";}
			?>
		</td>
	</tr>
</table>