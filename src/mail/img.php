<?
require_once $_SERVER["DOCUMENT_ROOT"] . "/modul/custom_sessions.php"; CustomSessions::start();
header("Content-type: image/png");
$string = $_SESSION[random];
$im = imagecreatefrompng("bottom.png");
$white = imagecolorallocate($im, 255, 255, 255);
$px  = (imagesx($im) - 7.5 * strlen($string))/2;
imagestring($im, 4, $px, 3, $string, $white);
imagepng($im);
imagedestroy($im);
?>