<?
if(count($_SESSION[error])>0){echo '
<table border="0" width=500 align=center style="border: 1px solid #9F1111" cellspacing="10" bgcolor="#FfF9F9" cellpadding="0" id="error">
        <tr>
            <td width="70" align=center><img alt=""  border="0" src="images/stop.png"></td>
            <td><p align="justify"><font color="#9F1111" size="2" face="Arial"><i><b>бмхлюмхе! </b></i>
            </font><font color="#9F1111" face="Arial" style="font-size: 8pt"><p>';
			for($i=0;$i<count($_SESSION[error]);$i++){echo "<b>∙ ньхайю:</b> ",$_SESSION[error][$i],"<br>";}
			echo'</font><img alt=""  src="images/close.png" border=0 align="right" style="cursor:hand;cursor:pointer" onclick="document.getElementById(\'error\').style.display=\'none\';">
            </td>
        </tr>
</table>';
unset($_SESSION[error]);
}
?>