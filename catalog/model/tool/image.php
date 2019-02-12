<?php
class ModelToolImage extends Model {
	function resize($filename, $width, $height, $path_to_image = DIR_IMAGE) {
		//Wathermark
		$wat = $this->config->get('config_watermark');
		$pos = $this->config->get('config_watermark_pos');
		//---
		$extopt = $this->config->get('config_use_extended');
		$wtext = $this->config->get('config_water_text');
		$imgrotate = $this->config->get('config_image_rotate');
		$scalex = $this->config->get('config_scalex');
		$scaley = $this->config->get('config_scaley');
		$textcolor = $this->config->get('config_text_color');
		$excepts = $this->config->get('config_excepted');
		//---

		if (!file_exists($path_to_image . $filename) || !is_file($path_to_image . $filename)) {
			return;
        }

		$old_image = $filename;
		$new_image = 'cache/' . substr($filename, 0, strrpos($filename, '.')) . '-' . $width . 'x' . $height . '.jpg';
			
	
		if (!file_exists($path_to_image . $new_image) || (filemtime($path_to_image . $old_image) > filemtime($path_to_image . $new_image))) {
			$path = '';
			
			$directories = explode('/', dirname(str_replace('../', '', $new_image)));
			
			foreach ($directories as $directory) {
				$path = $path . '/' . $directory;
				
				if (!file_exists($path_to_image . $path)) {
					@mkdir($path_to_image . $path, 0777);
				}		
			}				
			$image = new Image($path_to_image . $old_image);
			if ($directory == $excepts){
			$image = new Image($path_to_image . $old_image);
			$image->resize($width, $height);
			$image->save($path_to_image . $new_image);
			}else{
			if ($extopt == 'on'){
			$image->watermark($path_to_image . $wat, $pos);
			$image->rotate($imgrotate);
			$image->text($wtext, $scalex, $scaley, 100, $textcolor);
			$image->resize($width, $height);
			$image->save($path_to_image . $new_image);
			}else{
			$image->watermark($path_to_image . $wat, $pos);
			$image->resize($width, $height);
			$image->save($path_to_image . $new_image);
			}
			}
		}

        if ($path_to_image == DIR_IMAGE) {
            if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
                return HTTPS_IMAGE . $new_image;
            } else {
                return HTTP_IMAGE . $new_image;
            }
        } elseif ($path_to_image == DIR_DOWNLOAD) {
            return HTTP_DOWNLOAD . $new_image;
        }
	}
}
?>