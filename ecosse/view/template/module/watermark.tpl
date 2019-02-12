<?php echo $header; ?>
<script type="text/javascript" src="view/javascript/jquery/jquery-spin.js"></script>
<script type="text/javascript" src="view/javascript/jquery/iColorPicker.js"></script>
<div id="content">
<div class="breadcrumb">
  <?php foreach ($breadcrumbs as $breadcrumb) { ?>
  <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
  <?php } ?>
</div>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<div class="box">
  <div class="heading">
    <h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>
    <div class="buttons">
	<a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
  </div>
  <div class="content">
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <table class="form">        
        <!--Watermark-->
			<tr>
            <td><?php echo $entry_watermark; ?></td>
            <td><input type="hidden" name="config_watermark" value="<?php echo $config_watermark; ?>" id="watermark" />
             <img src="<?php echo $watermark; ?>" alt="" id="preview-watermark" class="image" onclick="image_upload('watermark', 'preview_watermark');" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_ext_options; ?></td>
            <td>
			<?php if ($config_use_extended) { ?>
              <input type="checkbox" name="config_use_extended" checked="checked" id="display_extra_options" />
              <?php } else { ?>
              <input type="checkbox" name="config_use_extended" id="display_extra_options" />
              <?php } ?></td>
          </tr>
		  <tr>
            <td id="cfp_label1"><?php echo $entry_ex_text; ?></td>
            <td id="cfp_label2">
			<input type="text" name="config_water_text" id="config_water_text" value="<?php echo $config_water_text; ?>" size="45"/>
			<input type="text" name="config_image_rotate" id="config_image_rotate" value="<?php echo $config_image_rotate; ?>" size="1"/> -> 
			<?php echo $entry_rotate_text; ?>
			<div style=" margin:5px;">
			<?php echo $entry_scalex; ?><input type="text" name="config_scalex" id="config_scalex" value="<?php echo $config_scalex; ?>" size="1" />
			<?php echo $entry_scaley; ?><input type="text" name="config_scaley" id="config_scaley" value="<?php echo $config_scaley; ?>" size="1" /> 
			<?php echo $entry_text_color; ?><input id="config_text_color" name="config_text_color" type="text" value="<?php echo $config_text_color; ?>" class="iColorPicker" size="5"/><br>
			<?php echo $entry_text_opacity; ?> <input type="text" name="config_opacity" id="config_opacity" value="<?php echo $config_opacity; ?>" size="1"/> %
			<?php echo $entry_text_opacity_desc; ?></div>
			</td>
          </tr>       
          <tr>
            <td><?php echo $entry_watermark_pos; ?></td>
            <td>
			<select name="config_watermark_pos">
                <?php if ($config_watermark_pos == 'topleft') { ?>
                <option value="topleft" selected="selected">Topleft</option>
                <?php } else { ?>
                <option value="topleft">Topleft</option>
                <?php } ?>
                <?php if ($config_watermark_pos == 'topright') { ?>
                <option value="topright" selected="selected">Topright</option>
                <?php } else { ?>
                <option value="topright">Topright</option>
                <?php } ?>
				<?php if ($config_watermark_pos == 'bottomleft') { ?>
                <option value="bottomleft" selected="selected">Bottomleft</option>
                <?php } else { ?>
                <option value="bottomleft">Bottomleft</option>
                <?php } ?>
				<?php if ($config_watermark_pos == 'bottomright') { ?>
                <option value="bottomright" selected="selected">Bottomright</option>
                <?php } else { ?>
                <option value="bottomright">Bottomright</option>
                <?php } ?>
				<?php if ($config_watermark_pos == 'center') { ?>
                <option value="center" selected="selected">Center</option>
                <?php } else { ?>
                <option value="center">Center</option>
                <?php } ?>
              </select>
			  </td>
          </tr>
		  <tr>
            <td><?php echo $entry_ext_folder; ?></td>
            <td>
				<select name="config_excepted">
                  <?php foreach ($excepteds as $excepted) { ?>
                  <?php if ($excepted == $config_excepted) { ?>
                  <option value="<?php echo $excepted; ?>" selected="selected"><?php echo $excepted; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $excepted; ?>"><?php echo $excepted; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select>
				 - <?php echo $entry_ext_folder_desc; ?>
			</td>
          </tr>	
			<!--End-->
      </table>
    </form>
  </div>
</div>
<script type="text/javascript"><!--
function image_upload(field, preview) {
	$('#dialog').remove();
	
	$('#content').prepend('<div id="dialog" style="padding: 3px 0px 0px 0px;"><iframe src="index.php?route=common/watermanager&token=<?php echo $token; ?>&field=' + encodeURIComponent(field) + '" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe></div>');
	
	$('#dialog').dialog({
		title: '<?php echo $text_image_manager; ?>',
		close: function (event, ui) {
			if ($('#' + field).attr('value')) {
				$.ajax({
					url: 'index.php?route=common/watermanager/image&token=<?php echo $token; ?>',
					type: 'POST',
					data: 'image=' + encodeURIComponent($('#' + field).val()),
					dataType: 'text',
					success: function(data) {
						$('#' + preview).replaceWith('<img src="' + data + '" alt="" id="' + preview + '" class="image" onclick="image_upload(\'' + field + '\', \'' + preview + '\');" />');
					}
				});
			}
		},	
		bgiframe: false,
		width: 700,
		height: 400,
		resizable: false,
		modal: false
	});
};
//--></script> 
<script type="text/javascript"><!--
/* Extra Options */
$(document).ready(function(){
	$('#display_extra_options').change(function() {
	if ($('input[name="config_use_extended"]:checked').val())
	{ 
	$('#cfp_label1').show();
	$('#cfp_label2').show(); 
	} else { 
	$('#cfp_label1').hide(); 
	$('#cfp_label2').hide();
	$('#config_water_text').removeAttr('value');
	$('#config_image_rotate').removeAttr('value')='0';
	$('#config_scalex').removeAttr('value');
	$('#config_scaley').removeAttr('value');
	$('#config_text_color').removeAttr('value'); 
	$('#config_opacity').removeAttr('value'); 
	}
	});
	$("#display_extra_options").change();
	
});

$(document).ready(function(){
	$('.simple_color').simpleColor();
	
	$('.simple_color_custom').simpleColor({
			cellWidth: 9,
			cellHeight: 9,
			border: '1px solid #333333',
			buttonClass: 'button'
	});
	
});
</script>
