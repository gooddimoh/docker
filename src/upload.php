<?php

function file_force_download($file) {
  $t = explode("_", $file);
	$file = dirname(__FILE__).'/'.$file;
  if (file_exists($file)) {
    // ���������� ����� ������ PHP, ����� �������� ������������ ������ ���������� ��� ������
    // ���� ����� �� ������� ���� ����� �������� � ������ ���������!
    if (ob_get_level()) {
      ob_end_clean();
    }
    // ���������� ������� �������� ���� ���������� �����
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . $t[sizeof($t)-1]);
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    // ������ ���� � ���������� ��� ������������
    readfile($file);
    exit;
  }
}
$file = dirname(__FILE__).'/uploads/'.$_GET['file'];
include "mysql.php";

$q = mysql_query('SELECT * FROM katalog_orders WHERE file_name2 = "'.addslashes($_GET['file']).'" AND date_add + INTERVAL 1 DAY > NOW()');
if(mysql_num_rows($q)==1){
	$res = mysql_fetch_array($q);
	file_force_download($res['file_name']);	
}


?>