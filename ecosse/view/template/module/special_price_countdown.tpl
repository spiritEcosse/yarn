<?php echo $header; ?>

<script type="text/javascript" src="view/javascript/jquery/jquery.lwtCountdown-1.0.js"></script>
<script type="text/javascript" src="view/javascript/jquery/misc.js"></script>
<link rel="stylesheet" type="text/css" href="view/stylesheet/countdown.css" />
<script type="text/javascript" src="view/javascript/jquery/jquery.countdown.js"></script>


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
    <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a></div>
  </div>
  <div class="content">
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
	  <table class="form">
		<?php foreach ($languages as $language) { ?>
            <tr>
				<td class="left"><?php echo $text_heading_title; ?></td>
				<td class="left"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <input type="text" name="special_price_countdown_heading_title_<?php echo $language['language_id'];?>" value="<?php echo $box_heading_title[$language['language_id']]; ?>" size="40" /></td>
			</tr>
        <?php } ?>
	  </table>
	
      <table id="module" class="list">
        <thead>
          <tr>
            <td class="left"><?php echo $entry_type; ?></td>
            <td class="left"><?php echo $entry_layout; ?></td>
            <td class="left"><?php echo $entry_position; ?></td>
            <td class="left"><?php echo $entry_status; ?></td>
            <td class="right"><?php echo $entry_sort_order; ?></td>
            <td></td>
          </tr>
        </thead>
        <?php $module_row = 0; ?>
        <?php foreach ($modules as $module) { ?>
        <tbody id="module-row<?php echo $module_row; ?>">
          <tr>
            <td class="left"><select name="special_price_countdown_module[<?php echo $module_row; ?>][type]" />
				<?php if ($module['type'] == 1) { ?>
					<option value="1" selected="selected"><?php echo $text_type1; ?></option>
					<option value="2" ><?php echo $text_type2; ?></option>
				<?php } else { ?>
					<option value="1"><?php echo $text_type1; ?></option>
					<option value="2" selected="selected"><?php echo $text_type2; ?></option>
				<?php } ?>
			</td>
            <td class="left"><select name="special_price_countdown_module[<?php echo $module_row; ?>][layout_id]">
                <?php foreach ($layouts as $layout) { ?>
                <?php if ($layout['layout_id'] == $module['layout_id']) { ?>
                <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select></td>
            <td class="left"><select name="special_price_countdown_module[<?php echo $module_row; ?>][position]">
                <?php if ($module['position'] == 'content_top') { ?>
                <option value="content_top" selected="selected"><?php echo $text_content_top; ?></option>
                <?php } else { ?>
                <option value="content_top"><?php echo $text_content_top; ?></option>
                <?php } ?>
                <?php if ($module['position'] == 'content_bottom') { ?>
                <option value="content_bottom" selected="selected"><?php echo $text_content_bottom; ?></option>
                <?php } else { ?>
                <option value="content_bottom"><?php echo $text_content_bottom; ?></option>
                <?php } ?>
                <?php if ($module['position'] == 'column_left') { ?>
                <option value="column_left" selected="selected"><?php echo $text_column_left; ?></option>
                <?php } else { ?>
                <option value="column_left"><?php echo $text_column_left; ?></option>
                <?php } ?>
                <?php if ($module['position'] == 'column_right') { ?>
                <option value="column_right" selected="selected"><?php echo $text_column_right; ?></option>
                <?php } else { ?>
                <option value="column_right"><?php echo $text_column_right; ?></option>
                <?php } ?>
              </select></td>
            <td class="left"><select name="special_price_countdown_module[<?php echo $module_row; ?>][status]">
                <?php if ($module['status']) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
            <td class="right"><input type="text" name="special_price_countdown_module[<?php echo $module_row; ?>][sort_order]" value="<?php echo $module['sort_order']; ?>" size="3" /></td>
            <td class="left"><a onclick="$('#module-row<?php echo $module_row; ?>').remove();" class="button"><?php echo $button_remove; ?></a></td>
          </tr>
        </tbody>
        <?php $module_row++; ?>
        <?php } ?>
        <tfoot>
          <tr>
            <td colspan="5"></td>
            <td class="left"><a onclick="addModule();" class="button"><?php echo $button_add_module; ?></a></td>
          </tr>
        </tfoot>
      </table>
	  
	  
	  <table class="form">
		  <tr>
		    <td><?php echo $entry_type1; ?></td>
			<td>
				<!-- Countdown dashboard start -->
				<div id="countdown_dashboard">
					<div class="dash days_dash">
						<span class="dash_title"><?php $text_days; ?></span>
						<div class="digit">0</div>
						<div class="digit">1</div>
					</div>

					<div class="dash hours_dash">
						<span class="dash_title"><?php $text_hours; ?></span>
						<div class="digit">1</div>
						<div class="digit">3</div>
					</div>

					<div class="dash minutes_dash">
						<span class="dash_title"><?php $text_minutes; ?></span>
						<div class="digit">5</div>
						<div class="digit">3</div>
					</div>

					<div class="dash seconds_dash">
						<span class="dash_title"><?php $text_seconds; ?></span>
						<div class="digit">2</div>
						<div class="digit">3</div>
					</div>

				</div>
			</td>
		  </tr>	
		  <tr>
			<td><?php echo $entry_type2; ?></td>
			<td>
				<div id="counter"></div>
				<div class="desc">
					<div><?php $text_days; ?></div><div class="space">&nbsp;</div>
					<div><?php $text_hours; ?></div><div class="space">&nbsp;</div>
					<div><?php $text_minutes; ?></div><div class="space">&nbsp;</div>
					<div><?php $text_seconds; ?></div>
				</div>
				<br />
				<br />
			</td>
		  </tr>
      </table>
    </form>
  </div>
</div>

<script type="text/javascript"><!--
var module_row = <?php echo $module_row; ?>;

function addModule() {	
	html  = '<tbody id="module-row' + module_row + '">';
	html += '  <tr>';
	html += '    <td class="left"><select name="special_price_countdown_module[' + module_row + '][type]">';
	html += '		<option value="1"><?php echo $text_type1; ?></option>';
	html += '		<option value="2" selected="selected"><?php echo $text_type2; ?></option>';
	html += '	 </select></td>';
	html += '    <td class="left"><select name="special_price_countdown_module[' + module_row + '][layout_id]">';
	<?php foreach ($layouts as $layout) { ?>
	<?php if ($layout['layout_id'] == 2) { ?>
	html += '      <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>';
	<?php } else { ?>
	html += '      <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>';
	<?php } ?>
	<?php } ?>
	html += '    </select></td>';
	html += '    <td class="left"><select name="special_price_countdown_module[' + module_row + '][position]">';
	html += '      <option value="content_top"><?php echo $text_content_top; ?></option>';
	html += '      <option value="content_bottom"><?php echo $text_content_bottom; ?></option>';
	html += '      <option value="column_left"><?php echo $text_column_left; ?></option>';
	html += '      <option value="column_right"><?php echo $text_column_right; ?></option>';
	html += '    </select></td>';
	html += '    <td class="left"><select name="special_price_countdown_module[' + module_row + '][status]">';
    html += '      <option value="1" selected="selected"><?php echo $text_enabled; ?></option>';
    html += '      <option value="0"><?php echo $text_disabled; ?></option>';
    html += '    </select></td>';
	html += '    <td class="right"><input type="text" name="special_price_countdown_module[' + module_row + '][sort_order]" value="" size="3" /></td>';
	html += '    <td class="left"><a onclick="$(\'#module-row' + module_row + '\').remove();" class="button"><?php echo $button_remove; ?></a></td>';
	html += '  </tr>';
	html += '</tbody>';
	
	$('#module tfoot').before(html);
	
	module_row++;
}
//--></script>

<script language="javascript" type="text/javascript">
jQuery(document).ready(function() {
	$('#countdown_dashboard').countDown({
		targetDate: {
			'day': 		<?php echo date('d') ?>,
			'month': 	<?php echo date('m') ?>,
			'year': 	<?php echo date('Y')+1 ?>,
			'hour': 	0,
			'min': 		0,
			'sec': 		0
		}
	});
});
</script>

<script type="text/javascript">
  $(function(){
	$('#counter').countdown({
	  image: 'view/image/digits.png',
	  startTime: '02:12:12:00'
	});
  });
</script>



<?php echo $footer; ?>