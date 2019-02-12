<?php echo $header; ?>
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
<table>
<tr valign="top">
	<td>
		<table id="settings" class="list" style="width: 400px;">
			<thead>
			<tr>
				<td></td>
				<td></td>
				<td><?php echo $text_expanded?></td>
			</tr>
			</thead>
			<tr>
				<td><?php echo $text_price_slider?></td>
				<td colspan="2"><input id="price_slider_yes" type="radio" name="filterpro_setting[price_slider]"
						   value="1" <?php if(!isset($setting['price_slider']) || $setting['price_slider'] == '1') echo " checked='checked'"?>>
					<label for="price_slider_yes"><?php echo $text_yes?></label>
					<input id="price_slider_no" type="radio" name="filterpro_setting[price_slider]"
						   value="0" <?php if(isset($setting['price_slider']) && $setting['price_slider'] == '0') echo " checked='checked'"?>>
					<label for="price_slider_no"><?php echo $text_no?></label></td>
			</tr>
			<tr>
				<td><?php echo $text_manufacturer?></td>
				<td>
					<select name="filterpro_setting[display_manufacturer]">
						<?php foreach($display_options as $display_option) { ?>
						<option value="<?php echo $display_option['value']?>"
							<?php if(isset($setting['display_manufacturer']) && $display_option['value'] == $setting['display_manufacturer']) echo ' selected="selected"';?>>
							<?php echo $display_option['name']?>
						</option>
						<?php }?>
					</select>
				</td>
				<td><input type="checkbox" name="filterpro_setting[expanded_manufacturer]" <?php if(isset($setting['expanded_manufacturer'])) echo ' checked="checked"';?>></td>
			</tr>
			<tr>
				<td><?php echo $text_categories?></td>
				<td>
					<select name="filterpro_setting[display_categories]">
						<?php foreach($display_categories as $display) { ?>
						<option value="<?php echo $display['value']?>"
							<?php if(isset($setting['display_categories']) && $display['value'] == $setting['display_categories']) echo ' selected="selected"';?>>
							<?php echo $display['name']?>
						</option>
						<?php }?>
					</select>
				</td>
				<td><input type="checkbox" name="filterpro_setting[expanded_categories]" <?php if(isset($setting['expanded_categories'])) echo ' checked="checked"';?>></td>
			</tr>
			<tr>
				<td><?php echo $text_tags?></td>
				<td>
					<select name="filterpro_setting[display_tags]">
						<?php foreach($display_categories as $display) { ?>
						<option value="<?php echo $display['value']?>"
							<?php if(isset($setting['display_tags']) && $display['value'] == $setting['display_tags']) echo ' selected="selected"';?>>
							<?php echo $display['name']?>
						</option>
						<?php }?>
					</select>
				</td>
				<td><input type="checkbox" name="filterpro_setting[expanded_tags]" <?php if(isset($setting['expanded_tags'])) echo ' checked="checked"';?>></td>
			</tr>
			<tr>
				<td colspan="3">&nbsp;</td>
			</tr>
			<?php foreach($options as $option){?>
			<tr>
				<td><?php echo $option['name']?></td>
				<td>
					<select name="filterpro_setting[display_option_<?php echo $option['option_id']?>]">
						<?php foreach($display_options as $display_option) { ?>
						<option value="<?php echo $display_option['value']?>"
							<?php if(isset($setting['display_option_' . $option['option_id']]) && $display_option['value'] == $setting['display_option_' . $option['option_id']]) echo '  selected="selected"';?>>
							<?php echo $display_option['name']?>
						</option>
						<?php }?>
					</select>
				</td>
				<td><input type="checkbox" name="filterpro_setting[expanded_option_<?php echo $option['option_id']?>]" <?php if(isset($setting['expanded_option_' . $option['option_id']])) echo ' checked="checked"';?>></td>
			</tr>
			<?php }?>
			<tr>
				<td colspan="3">&nbsp;</td>
			</tr>
			<?php $attribute_group = false;?>
			<?php foreach($attributes as $attribute){?>
			<?php if ($attribute_group !=$attribute['attribute_group']) { ?>
				<?php $attribute_group = $attribute['attribute_group'];?>
				<tr>
					<td colspan="3" style="text-align: center;"><?php echo $attribute['attribute_group']?></td>
				</tr>
			<?php }	?>
			<tr>
				<td><?php echo $attribute['name']?></td>
				<td>
					<select name="filterpro_setting[display_attribute_<?php echo $attribute['attribute_id']?>]">
						<?php foreach($display_options_attr as $display_option) { ?>
						<option value="<?php echo $display_option['value']?>"
							<?php if(isset($setting['display_attribute_' . $attribute['attribute_id']]) && $display_option['value'] == $setting['display_attribute_' . $attribute['attribute_id']]) echo '  selected="selected"';?>>
							<?php echo $display_option['name']?>
						</option>
						<?php }?>
					</select>
				</td>
				<td><input type="checkbox" name="filterpro_setting[expanded_attribute_<?php echo $attribute['attribute_id']?>]" <?php if(isset($setting['expanded_attribute_' . $attribute['attribute_id']])) echo ' checked="checked"';?>></td>
			</tr>
			<?php }?>
			<tr>
				<td><?php echo $text_instock; ?></td>
				<td><input id="instock_checked" type="checkbox" name="filterpro_setting[instock_checked]" <?php if (isset($setting['instock_checked'])) echo ' checked="checked"'; ?>>&nbsp;<label for="instock_checked"><?php echo $text_checked; ?></label></td>
				<td><input id="instock_visible" type="checkbox" name="filterpro_setting[instock_visible]" <?php if (isset($setting['instock_visible'])) echo ' checked="checked"'; ?>>&nbsp;<label for="instock_visible"><?php echo $text_visible; ?></label></td>
			</tr>

		</table>
	</td>
	<td>
		<table class="list" style="width: 400px; float: left">
			<tr>
				<td><?php echo $text_attr_delimeter?></td>
				<td><input id="attr_delimeter" type="text" name="filterpro_setting[attr_delimeter]" size="3"
						   value="<?php if(isset($setting['attr_delimeter'])) echo $setting['attr_delimeter']; else echo ':'; ?>">
				</td>
			</tr>
			<tr>
				<td><?php echo $text_tax?></td>
				<td><input id="tax" type="text" name="filterpro_setting[tax]" size="3"
						   value="<?php if(isset($setting['tax'])) echo $setting['tax']; else echo '0'; ?>">
				</td>
			</tr>
			<tr>
				<td><?php echo $text_option_mode?></td>
				<td><input id="option_mode_or" type="radio" name="filterpro_setting[option_mode]"
						   value="or" <?php if(!isset($setting['option_mode']) || $setting['option_mode'] == 'or') echo " checked='checked'"?>>
					<label for="option_mode_or"><?php echo $text_mode_or?></label>
					<input id="option_mode_and" type="radio" name="filterpro_setting[option_mode]"
						   value="and" <?php if(isset($setting['option_mode']) && $setting['option_mode'] == 'and') echo " checked='checked'"?>>
					<label for="option_mode_and"><?php echo $text_mode_and?></label>
				</td>
			</tr>
			<tr>
				<td><?php echo $text_attribute_mode?></td>
				<td><input id="attribute_mode_or" type="radio" name="filterpro_setting[attribute_mode]"
						   value="or" <?php if(!isset($setting['attribute_mode']) || $setting['attribute_mode'] == 'or') echo " checked='checked'"?>>
					<label for="attribute_mode_or"><?php echo $text_mode_or?></label>
					<input id="attribute_mode_and" type="radio" name="filterpro_setting[attribute_mode]"
						   value="and" <?php if(isset($setting['attribute_mode']) && $setting['attribute_mode'] == 'and') echo " checked='checked'"?>>
					<label for="attribute_mode_and"><?php echo $text_mode_and?></label>
				</td>
			</tr>
			<tr>
				<td colspan="2">&nbsp;</td>
			</tr>
			<tr>
				<td><?php echo $text_attr_group?></td>
				<td><input id="text_attr_group_off" type="radio" name="filterpro_setting[attr_group]"
						   value="0" <?php if(!isset($setting['attr_group']) || $setting['attr_group'] == '0') echo " checked='checked'"?>>
					<label for="text_attr_group_off"><?php echo $text_no?></label>
					<input id="text_attr_group_on" type="radio" name="filterpro_setting[attr_group]"
						   value="1" <?php if(isset($setting['attr_group']) && $setting['attr_group'] == '1') echo " checked='checked'"?>>
					<label for="text_attr_group_on"><?php echo $text_yes?></label>
				</td>
			</tr>
			<tr>
				<td colspan="2">&nbsp;</td>
			</tr>
			<tr>
				<td><?php echo $text_sku_display?></td>
				<td><input id="sku_display_yes" type="radio" name="filterpro_setting[sku_display]"
						   value="1" <?php if(isset($setting['sku_display']) && $setting['sku_display'] == '1') echo " checked='checked'"?>>
					<label for="sku_display_yes"><?php echo $text_yes?></label>
					<input id="sku_display_no" type="radio" name="filterpro_setting[sku_display]"
						   value="0" <?php if(!isset($setting['sku_display']) || $setting['sku_display'] == '0') echo " checked='checked'"?>>
					<label for="sku_display_no"><?php echo $text_no?></label>
				</td>
			</tr>
			<tr>
				<td><?php echo $text_model_display?></td>
				<td><input id="model_display_yes" type="radio" name="filterpro_setting[model_display]"
						   value="1" <?php if(isset($setting['model_display']) && $setting['model_display'] == '1') echo " checked='checked'"?>>
					<label for="model_display_yes"><?php echo $text_yes?></label>
					<input id="model_display_no" type="radio" name="filterpro_setting[model_display]"
						   value="0" <?php if(!isset($setting['model_display']) || $setting['model_display'] == '0') echo " checked='checked'"?>>
					<label for="model_display_no"><?php echo $text_no?></label>
				</td>
			</tr>
			<tr>
				<td><?php echo $text_brand_display?></td>
				<td><input id="brand_display_yes" type="radio" name="filterpro_setting[brand_display]"
						   value="1" <?php if(isset($setting['brand_display']) && $setting['brand_display'] == '1') echo " checked='checked'"?>>
					<label for="brand_display_yes"><?php echo $text_yes?></label>
					<input id="brand_display_no" type="radio" name="filterpro_setting[brand_display]"
						   value="0" <?php if(!isset($setting['brand_display']) || $setting['brand_display'] == '0') echo " checked='checked'"?>>
					<label for="brand_display_no"><?php echo $text_no?></label>
				</td>
			</tr>
			<tr>
				<td><?php echo $text_location_display?></td>
				<td><input id="location_display_yes" type="radio" name="filterpro_setting[location_display]"
						   value="1" <?php if(isset($setting['location_display']) && $setting['location_display'] == '1') echo " checked='checked'"?>>
					<label for="location_display_yes"><?php echo $text_yes?></label>
					<input id="location_display_no" type="radio" name="filterpro_setting[location_display]"
						   value="0" <?php if(!isset($setting['location_display']) || $setting['location_display'] == '0') echo " checked='checked'"?>>
					<label for="location_display_no"><?php echo $text_no?></label>
				</td>
			</tr>
			<tr>
				<td><?php echo $text_upc_display?></td>
				<td><input id="upc_display_yes" type="radio" name="filterpro_setting[upc_display]"
						   value="1" <?php if(isset($setting['upc_display']) && $setting['upc_display'] == '1') echo " checked='checked'"?>>
					<label for="upc_display_yes"><?php echo $text_yes?></label>
					<input id="upc_display_no" type="radio" name="filterpro_setting[upc_display]"
						   value="0" <?php if(!isset($setting['upc_display']) || $setting['upc_display'] == '0') echo " checked='checked'"?>>
					<label for="upc_display_no"><?php echo $text_no?></label>
				</td>
			</tr>
			<tr>
				<td><?php echo $text_stock_display?></td>
				<td><input id="stock_display_yes" type="radio" name="filterpro_setting[stock_display]"
						   value="1" <?php if(isset($setting['stock_display']) && $setting['stock_display'] == '1') echo " checked='checked'"?>>
					<label for="stock_display_yes"><?php echo $text_yes?></label>
					<input id="stock_display_no" type="radio" name="filterpro_setting[stock_display]"
						   value="0" <?php if(!isset($setting['stock_display']) || $setting['stock_display'] == '0') echo " checked='checked'"?>>
					<label for="stock_display_no"><?php echo $text_no?></label>
				</td>
			</tr>
		</table>
	</td>
</tr>

</table>
<?php echo $text_filter_position; ?>
      <table id="module" class="list">
        <thead>
          <tr>
            <td class="left"><?php echo $entry_layout; ?></td>
            <td class="left"><?php echo $entry_position; ?></td>
            <td class="left"><?php echo $entry_status; ?></td>
            <td class="right"><?php echo $entry_sort_order; ?></td>
            <td></td>
          </tr>
        </thead>
        <?php
        $module_row = 0;
        ?>
        <?php foreach ($modules as $module) { ?>
		  <?php if($module['type'] !=0){continue;}?>
        <tbody id="module-row<?php echo $module_row; ?>">
          <tr>
            <td class="left"><input type="hidden" name="filterpro_module[<?php echo $module_row; ?>][type]" value="0">
				<select name="filterpro_module[<?php echo $module_row; ?>][layout_id]">
                <?php foreach ($layouts as $layout) { ?>
                <?php if ($layout['layout_id'] == $module['layout_id']) { ?>
                <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select></td>
            <td class="left"><select name="filterpro_module[<?php echo $module_row; ?>][position]">
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
            <td class="left"><select name="filterpro_module[<?php echo $module_row; ?>][status]">
                <?php if ($module['status']) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
            <td class="right"><input type="text" name="filterpro_module[<?php echo $module_row; ?>][sort_order]" value="<?php echo $module['sort_order']; ?>" size="3" /></td>
            <td class="left"><a onclick="$('#module-row<?php echo $module_row; ?>').remove();" class="button"><span><?php echo $button_remove; ?></span></a></td>
          </tr>
        </tbody>
        <?php $module_row++; ?>
        <?php } ?>
		  <tfoot>
			<tr>
			  <td colspan="4"></td>
			  <td class="left"><a onclick="addModule();" class="button"><span><?php echo $button_add_module; ?></span></a></td>
			</tr>
		  </tfoot>
	  </table>
<?php echo $text_product_container?>
<table id="module_container" class="list">
        <thead>
          <tr>
            <td class="left"><?php echo $entry_layout; ?></td>
            <td class="left"><?php echo $entry_status; ?></td>
            <td class="right"><?php echo $entry_sort_order; ?></td>
            <td></td>
          </tr>
        </thead>

        <?php foreach ($modules as $module) { ?>
				  <?php if($module['type'] !=1){continue;}?>
        <tbody id="modulec-row<?php echo $module_row; ?>">
          <tr>
            <td class="left">
				<input type="hidden" name="filterpro_module[<?php echo $module_row; ?>][type]" value="1">
				<input type="hidden" name="filterpro_module[<?php echo $module_row; ?>][position]" value="content_top">
				<select name="filterpro_module[<?php echo $module_row; ?>][layout_id]">
                <?php foreach ($layouts as $layout) { ?>
                <?php if ($layout['layout_id'] == $module['layout_id']) { ?>
                <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select></td>
            <td class="left"><select name="filterpro_module[<?php echo $module_row; ?>][status]">
                <?php if ($module['status']) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
            <td class="right"><input type="text" name="filterpro_module[<?php echo $module_row; ?>][sort_order]" value="<?php echo $module['sort_order']; ?>" size="3" /></td>
            <td class="left"><a onclick="$('#modulec-row<?php echo $module_row; ?>').remove();" class="button"><span><?php echo $button_remove; ?></span></a></td>
          </tr>
        </tbody>
        <?php $module_row++; ?>
        <?php } ?>
		  <tfoot>
			<tr>
			  <td colspan="3"></td>
			  <td class="left"><a onclick="addModuleContainer();" class="button"><span><?php echo $button_add_module; ?></span></a></td>
			</tr>
		  </tfoot>
	  </table>
    </form>
  </div>
</div>
<script type="text/javascript"><!--
var module_row = <?php echo $module_row; ?>;

function addModule() {
	html  = '<tbody id="module-row' + module_row + '">';
	html += '  <tr>';
	html += '    <td class="left"><input type="hidden" name="filterpro_module[' + module_row + '][type]" value="0">'+
		'<select name="filterpro_module[' + module_row + '][layout_id]">';
	<?php foreach ($layouts as $layout) { ?>
	html += '      <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>';
	<?php } ?>
	html += '    </select></td>';
	html += '    <td class="left"><select name="filterpro_module[' + module_row + '][position]">';
	html += '      <option value="content_top"><?php echo $text_content_top; ?></option>';
	html += '      <option value="content_bottom"><?php echo $text_content_bottom; ?></option>';
	html += '      <option value="column_left"><?php echo $text_column_left; ?></option>';
	html += '      <option value="column_right"><?php echo $text_column_right; ?></option>';
	html += '    </select></td>';
	html += '    <td class="left"><select name="filterpro_module[' + module_row + '][status]">';
    html += '      <option value="1" selected="selected"><?php echo $text_enabled; ?></option>';
    html += '      <option value="0"><?php echo $text_disabled; ?></option>';
    html += '    </select></td>';
	html += '    <td class="right"><input type="text" name="filterpro_module[' + module_row + '][sort_order]" value="" size="3" /></td>';
	html += '    <td class="left"><a onclick="$(\'#module-row' + module_row + '\').remove();" class="button"><?php echo $button_remove; ?></a></td>';
	html += '  </tr>';
	html += '</tbody>';

	$('#module tfoot').before(html);

	module_row++;
}

function addModuleContainer() {
	html  = '<tbody id="modulec-row' + module_row + '">';
	html += '  <tr>';
	html += '    <td class="left"><input type="hidden" name="filterpro_module[' + module_row + '][type]" value="1">'+
			'<input type="hidden" name="filterpro_module[' + module_row + '][position]" value="content_top">'+
			'<select name="filterpro_module[' + module_row + '][layout_id]">';
	<?php foreach ($layouts as $layout) { ?>
	html += '      <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>';
	<?php } ?>
	html += '    </select></td>';
	html += '    <td class="left"><select name="filterpro_module[' + module_row + '][status]">';
    html += '      <option value="1" selected="selected"><?php echo $text_enabled; ?></option>';
    html += '      <option value="0"><?php echo $text_disabled; ?></option>';
    html += '    </select></td>';
	html += '    <td class="right"><input type="text" name="filterpro_module[' + module_row + '][sort_order]" value="" size="3" /></td>';
	html += '    <td class="left"><a onclick="$(\'#modulec-row' + module_row + '\').remove();" class="button"><?php echo $button_remove; ?></a></td>';
	html += '  </tr>';
	html += '</tbody>';

	$('#module_container tfoot').before(html);

	module_row++;
}
//--></script>
copyright &copy; <a href="mailto:ruslan.shv@gmail.com?Subject=Filterpro%20support">Ruslan Shvarev</a>

<?php echo $footer; ?>