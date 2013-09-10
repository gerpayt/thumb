<?php
/**
*	By chenfeng
*	2013-09-10
*	Make a thumbnail
*/
class CThumb extends CApplicationComponent {
	public static function resizeImage($path, $width, $height, $name) {
		$im = null;
		$imagetype = strtolower(pathinfo($path, PATHINFO_EXTENSION));
		if($imagetype == 'gif')
			$im = imagecreatefromgif($path);
		else if ($imagetype == 'jpg')
			$im = imagecreatefromjpeg($path);
		else if ($imagetype == 'png')
			$im = imagecreatefrompng($path);

		$pic_width = imagesx ( $im );
		$pic_height = imagesy ( $im );

		if($pic_width/$width > $pic_height/$height)
		{
			$ratio=$pic_height/$height;
			$sw=$width*$ratio;
			$sh=$pic_height;
			$sx=($pic_width-$sw)/2;
			$sy=0;
		}
		else
		{
			$ratio=$pic_width/$width;
			$sw=$pic_width;
			$sh=$height*$ratio;
			$sx=0;
			$sy=($pic_height-$sh)/2;
		}
		if (function_exists ( "imagecopyresampled" )) {
			$newim = imagecreatetruecolor ( $width, $height );
			imagecopyresampled ( $newim, $im, 0, 0, $sx, $sy, $width, $height, $sw, $sh );
		} else {
			$newim = imagecreate ( $width, $height );
			imagecopyresized ( $newim, $im, 0, 0, $sx, $sy, $width, $height, $sw, $sh );
		}
			
		imagejpeg ( $newim, $name );
		imagedestroy ( $newim );
	}
}
?>
