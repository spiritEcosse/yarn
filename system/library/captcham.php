<?php
class Captcha
{
	protected $code;
	protected $width = 30;
	protected $height = 95;
	function __construct()
	{
		$this->code = substr(sha1(mt_rand()), 17, 4);
		$this->root = str_replace('/image/', '', DIR_IMAGE);
	}
	function getCode()
	{
		return $this->code;
	}
	function makeImage()
	{
		$noise    = true;
		$nb_noise = 10;
		$image    = imagecreatetruecolor($this->height, $this->width);
		$width    = imagesx($image);
		$height   = imagesy($image);
		$back     = ImageColorAllocate($image, intval(rand(224, 255)), intval(rand(224, 255)), intval(rand(224, 255)));
		ImageFilledRectangle($image, 0, 0, $width, $height, $back);
		if ($noise) {
			for ($i = 0; $i < $nb_noise; $i++) {
				$size  = intval(rand(6, 14));
				$angle = intval(rand(0, 360));
				$x     = intval(rand(10, $width - 10));
				$y     = intval(rand(0, $height - 5));
				$color = imagecolorallocate($image, intval(rand(160, 224)), intval(rand(160, 224)), intval(rand(160, 224)));
				$text  = chr(intval(rand(45, 250)));
				ImageTTFText($image, $size, $angle, $x, $y, $color, $this->get_font(), $this->code);
			}
		} else {
			for ($i = 0; $i < $width; $i += 10) {
				$color = imagecolorallocate($image, intval(rand(160, 224)), intval(rand(160, 224)), intval(rand(160, 224)));
				imageline($image, $i, 0, $i, $height, $color);
			}
			for ($i = 0; $i < $height; $i += 10) {
				$color = imagecolorallocate($image, intval(rand(160, 224)), intval(rand(160, 224)), intval(rand(160, 224)));
				imageline($image, 0, $i, $width, $i, $color);
			}
		}
		for ($i = 0, $x = 5; $i < strlen($this->code); $i++) {
			$r      = intval(rand(0, 128));
			$g      = intval(rand(0, 128));
			$b      = intval(rand(0, 128));
			$color  = ImageColorAllocate($image, $r, $g, $b);
			$shadow = ImageColorAllocate($image, $r + 128, $g + 128, $b + 128);
			$size   = intval(rand(14, 19));
			$angle  = intval(rand(-20, 20));
			$text   = strtoupper(substr($this->code, $i, 1));
			ImageTTFText($image, $size, $angle, $x + 7, 26, $shadow, $this->get_font(), $text);
			ImageTTFText($image, $size - 1, $angle + 2, $x + 5, 24, $color, $this->get_font(), $text);
			$x += $size + 2;
		}
		$filename = $this->get_filename();
		imagejpeg($image, $this->root . $filename, 100);
		ImageDestroy($image);
		return $filename;
	}
	function get_filename()
	{
		if ($this->code == "")
			$public = $this->code;
		$this->tempdir = "/image/cache";
		if (!file_exists($this->root . $this->tempdir)) {
			mkdir($this->root . $this->tempdir);
			umask(0);
			chmod($this->root . $this->tempdir, 0755);
		}
		$this->captcha_filename = $this->tempdir . "/" . $this->code . ".jpg";
		return $this->captcha_filename;
	}
	function get_font()
	{
		static $fonts = array();
		if (!sizeof($fonts)) {
			$dr = opendir($this->root . "/image/data/fonts/");
			if (!$dr) {
				trigger_error('Unable to open', E_USER_ERROR);
			}
			while (false !== ($entry = readdir($dr))) {
				if (strtolower(pathinfo($entry, PATHINFO_EXTENSION)) == 'ttf') {
					$fonts[] = $this->root . "/image/data/fonts/" . $entry;
				}
			}
			closedir($dr);
		}
		return $fonts[mt_rand(0, sizeof($fonts) - 1)];
	}
}
?>