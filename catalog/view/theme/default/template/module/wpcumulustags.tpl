<div class="box">
  <div class="top"><?php echo $heading_title; ?></div>
  <div class="middle" style="text-align:center;">
        <?php
		echo "<script type='text/javascript' src='catalog/view/theme/default/template/swfobject.js'></script>";
    	echo "<div id='flashcontenttags'>ERRO - FLASH ou JAVASCRIPT DESABILITADO!</div>";
		echo "<script type='text/javascript'>";
        echo "var so = new SWFObject('catalog/view/theme/default/template/tagcloudtags.swf', 'tagcloudtags', '".$wpcumulustags_horizontal_size."', '".$wpcumulustags_vertical_size."', '7', '#".$wpcumulustags_background_color."');";
		if ($wpcumulustags_background_transparency == 'true') {
        echo "so.addParam('wmode', 'transparent');";
        }
        else{
        echo "so.addParam('wmode', 'opaque');";
        }
		echo "so.addVariable('tcolor', '0x".$wpcumulustags_default_text_color."');";
		echo "so.addVariable('tcolor2', '0x009900');";
		echo "so.addVariable('hicolor', '0x".$wpcumulustags_mouseover_text_color."');";
        echo "so.addVariable('bgcolor', '0x".$wpcumulustags_background_color."');";
		echo "so.addVariable('tspeed', '".$wpcumulustags_speed."');";
		echo "so.addVariable('distr', 'true');";
        echo "so.addVariable('trans', '".$wpcumulustags_background_transparency."');";
		echo "so.addVariable('xmlpath', 'catalog/view/theme/default/template/wpcumulustags.xml');";
		echo "so.write('flashcontenttags');";
		echo "</script>";
//        new dBug (get_defined_vars());
        ?>
  </div>
  <div class="bottom">&nbsp;</div>
</div>
