<?
include "mysql.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/modul/custom_sessions.php"; CustomSessions::start();

// - 0.- ���� ������
// - 1.- ����������� ������
// - 2.- �������� ����������
// - 3.- ������ 50%, �����������
// - 4.- ����������� ������
// - 5.- ������ 50%, ���������� �������

$_SESSION[error]=array();
$_SESSION[result]=array();
include "sequrity.php";

if(!class_exists('PHPMailer')) require($_SERVER["DOCUMENT_ROOT"] . '/modul/rozsl/class.phpmailer.php');

$config=mysql_fetch_array(mysql_query("select * from katalog_config limit 1"));

if($_SESSION[logintrue]){
    $data=time();
	$_GET[id]=mysql_escape_string(strip_tags($_GET[id]));
	$_GET[st]=mysql_escape_string(strip_tags($_GET[st]));

	$user=mysql_fetch_array(mysql_query("select balance,resh from katalog_user WHERE id_p='$_SESSION[userid]' limit 1"));
	$zadacha=mysql_fetch_array(mysql_query("select status,url,userresh,userzakaz,price from katalog_zadach where id_p='$_GET[id]' limit 1"));
	$config=mysql_fetch_array(mysql_query("select procent from katalog_config limit 1"));
    

   $q1 = mysql_query('SELECT * FROM usr_stavka WHERE usr_id = '.$zadacha[userresh]); 
   if (mysql_num_rows($q1) > 0)
   {
     $q1 = mysql_fetch_assoc($q1);
     $config[procent] = 100-$q1['stavka'];
   }
    
		if($zadacha[userzakaz]!=$_SESSION[userid]){ // ------------------------------ �� ��������, �������
			if($_GET[st]==1){ // ------------------------------ ������ �� ������
				if($zadacha[status]<3){ // ------------------ ���� ������ ����� ������� ��������

					mysql_query("DELETE FROM katalog_zayava WHERE userresh='$_SESSION[userid]' and id_p in(select id from katalog where id_p='$_GET[id]')");
                       mysql_query("DELETE FROM katalog WHERE id_p='$_GET[id]' and id not in(select id_p from katalog_zayava)");
					if(@mysql_num_rows(@mysql_query("select * from katalog WHERE id_p='$_GET[id]'"))==0){
						mysql_query("update katalog_zadach set status='1' where id_p='$_GET[id]'");
					}
					array_push($_SESSION[result],'���� ������ ���� ���������');
				}else{
					array_push($_SESSION[error],'�� �� ������ ����������, ����� ��� �������� �������');
				}
			}else{
				array_push($_SESSION[error],'�������� ��������');
			}
		}else if($zadacha[userzakaz]==$_SESSION[userid]){// ------------------------------ ��������
			if($_GET[st]==2){ // ------------------------------ ������ ������� ������
				if($zadacha[status]==4){
					$price=$zadacha[price]*0.5;
					if($user[balance]>=$price){
						//zmenshenya balansu
						mysql_query("update katalog_user set balance=balance-$price WHERE id_p='$_SESSION[userid]' limit 1");
						$procent=$zadacha[price]*($config[procent]/100);
						$price=$zadacha[price]-$procent;
						//oplata zakaza
						mysql_query("update katalog_user set balance=balance+$price WHERE id_p='$zadacha[userresh]' limit 1");
						//finans zvit
						$date=time();
						mysql_query("insert into katalog_finanse(inu,outu,add_data,type,status,price) values('$_SESSION[userid]','$zadacha[userresh]','$date','2','1','$price')")or die(mysql_error());
						mysql_query("insert into katalog_finanse(inu,outu,add_data,type,status,price) values('$zadacha[userresh]','0','$date','1','1','$procent')")or die(mysql_error());
						//status zadachi
						mysql_query("update katalog_zadach set data_oplati='$date',status='5' WHERE id_p='$_GET[id]' limit 1");

						mysql_query("insert into katalog_message(user_in,user_out,text,data_create) values('$_SESSION[userid]','$zadacha[userresh]','������ ID=$_GET[id] ���� ��������� ��������','$data')");
									/*
									 * 
									 * GIM Block
									 * �������� ����� - ���� ���� ��������� ����������
									 * 
									 * */
									$r_	=	mysql_query("select * from katalog_user where id_p = '$zadacha[userresh]'");
									//print "select * from katalog_user where id_p = '$zadacha[userzakaz]'";
									$text_email = "������ ID=$_GET[id] ���� ��������� ��������";
								
									$mail = new PHPMailer();
                                    $mail->CharSet = "windows-1251";
                                    $mail->IsSMTP();
                                    $mail->Host = '127.0.0.1';
                                    $mail->From = 'no-reply@stud-help.com';
                                    $mail->FromName = '�������� ��������';
                                    $mail->Subject = $mail->AltBody = "����� ��������� � ������� �� ".$_SESSION["userlogin"];
                                    $mail->addReplyTo('no-reply@stud-help.com', 'No-Reply');
                                
									while($row=mysql_fetch_array($r_)) {
										//print "Start";
										$old=$row["email"]; 
										$message = "<B>��� ������ ������ � ����� <a href='http://stud-help.com'>stud-help.com</a> :</B><BR>";
										$mailto  = $row["email"];
										/*$charset = "windows-1251";
										$content = "text/html;";
										$subject = "����� ��������� � ������� �� ".$_SESSION["userlogin"];
										$headers  = "MIME-Version: 1.0\r\n";
										$headers .= "Content-Type: $content  charset=$charset\r\n";
										$headers .= "Date: ".date("Y-m-d (H:i:s)",time())."\r\n";
										$headers .= "From: �������� �������� <no-replay@stud-help.com>\r\n";*/
										$message .= "���� �����������: ".date("Y-m-d (H:i:s)",time())."\r\n</B><BR><BR>";
										$message .= $text_email."<BR><BR>��� ������ ���������� �������, � �������� �� ���� �� ����.";
										
                                        $mail->MsgHTML($message);
                                        $mail->ClearAddresses();
                                        $mail->AddAddress($mailto);
                                        $send_ok = $mail->Send();
                                        
                                        //$send_ok = mail($mailto,$subject,$message,$headers);
										break;
									}
									//print "EXIT";
									//exit;
									///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
									///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
									///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////												
                        $info = <<<_INFO
             ����� ��� ��������� �������  <br />
             <a href="k12-otzivi_o_proekte_reshenie_zadach.html?usr_id=$zadacha[userresh]">�������� ����� � �������� ($row[login])</a> <br />
             <a class="thickbox" href="/modul/messagea.php?form=2&noerr&id=$zadacha[userresh]&TB_iframe=true&modal=false&height=200&width=300">������������� ��������� ($row[login])</a> <br />
             <a class="thickbox" href="/modul/messagea.php?form=2&noerr&id=357&TB_iframe=true&modal=false&height=200&width=300">������������ �� ��������� ($row[login])</a>
_INFO;
                        array_push($_SESSION[result],$info);			
						
						
					}else{
						array_push($_SESSION[error],'������������ ������� �� ����� �������');
					}
				}else{
					array_push($_SESSION[error],'������ ��� �� ��������� ��� ��� ��������');
				}
			}else if($_GET[st]==3){ // ------------------------------ ������� ���������� ������
				if($zadacha[status]<3){
					mysql_query("DELETE FROM katalog WHERE id='$_GET[id]' limit 1");
		 			mysql_query("DELETE FROM katalog_zadach WHERE id_p='$_GET[id]' limit 1");
		        	mysql_query("DELETE FROM katalog_zayava WHERE id_p in (select id from katalog where id_p='$_GET[id]')");
					mysql_query("DELETE FROM katalog WHERE id_p='$_GET[id]'");
		        	if(is_file("../".$zadacha[url])){unlink("../".$zadacha[url]);}
		        	if(is_file("../".$zadacha[urlresh])){unlink("../".$zadacha[urlresh]);}
		   			array_push($_SESSION[result],'����� ��� ��������� ������');
				}else{
					array_push($_SESSION[error],'�� �� ������ ����������, ����� ��� ������ �� ����������');
				}
			}else{
				array_push($_SESSION[error],'�������� ��������');
			}
		}else {
			// ------------------------------ �� �������� � �� �������
			array_push($_SESSION[error],'� ��� ��� ���� �� ��������� ������');
		}
}else{array_push($_SESSION[error],'�� �� ��������������� ������������. <a href="k20.html">�������</a> � �������');}
header("Location:../k6.html");
?>
