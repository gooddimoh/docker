<?

$dir=dirname(__FILE__).'/';
if(isset($_GET['file'])) {
	$file=urldecode($_GET['file']);
	$file=$dir.$file;
	if(is_file($file)) {

		if($info=getimagesize($file)) {
			$width=$info[0];
			$height=$info[1];

			if($width>=$height) $maxWidth=1000;
			else $maxWidth=540;

			$q=$p=null;
			$ratio=$width/$height;
			if($width > $maxWidth) $width1=$maxWidth;
			else $width1=$width;

			if((int)$_GET['w']==200) $width1=200; else $width1=100;
			if(((int)$_GET['w'])>200) $width1=(int)$_GET['w'];
			$height1=(int)$width1/$ratio;

			$types=array(1=>'image/gif',2=>'image/JPG',3=>'image/png');
			//$types=$types[$info[2]];

			switch ($info[2]) {
				case 1:
					//gif
					$im=imagecreatefromgif($file);

		$im1=imagecreatetruecolor($width1,$height1);
		imagecopyresampled($im1,$im,0,0,0,0,$width1,$height1,$width,$height);

					$func='imagegif';
					$types=$types[1];

					break;

				case 2:
					//jpg
					$im=imagecreatefromjpeg($file);
					$im1=imagecreatetruecolor($width1,$height1);
					$bg_white = imagecolorallocate($im1, 255, 255, 255);
					imagefill($im1, 0,0,$bg_white);
					imageantialias($im1, true);





					//imagecopyresampled($im1,$im,0,0,0,0,$width1,$height1,$width,$height);
					
					imagecopyresized($im1,$im,0,0,0,0,$width1,$height1,$width,$height);
					
					
					$func='imagejpeg';
					$types=$types[2];
					$q=100;

					break;

				case 3:
					//png
					$im=imagecreatefrompng($file);
					$im1=imagecreatetruecolor($width1,$height1);

					imagecopyresampled($im1,$im,0,0,0,0,$width1,$height1,$width,$height);
					$func='imagepng';
					$types=$types[2];

					break;
				default:
					break;
			}


			header('Content-type: '.$types);
			$func($im1,$p,$q);
			@imagedestroy($im);
			@imagedestroy($im1);
		}
	}
}
?>