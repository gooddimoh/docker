<?
if(count($_SESSION[result])>0){echo '
<table border="0" width=500 align=center style="border: 1px solid #529F33" cellspacing="10" bgcolor="#F8FCF5" cellpadding="0" id="result">
        <tr>
            <td width="70" align=center><img alt=""  border="0" src="images/ok.png" width="64" height="64"></td>
            <td><font color="#529F33" size="2" face="Arial"><i><b>яннаыемхе яхярелш</b></i>
            </font><p><font color="#529F33" face="Arial" size="2">';
			for($i=0;$i<count($_SESSION[result]);$i++){echo $_SESSION[result][$i],"<br>";}
			echo'</font><img alt=""  src="images/close.png" border=0 align="right" style="cursor:hand;cursor:pointer" onclick="document.getElementById(\'result\').style.display=\'none\';">
			</td>
        </tr>
</table>';
unset($_SESSION[result]);
}
?>