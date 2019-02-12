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
      <h1><?php echo $heading_title; ?></h1>
      <div class="buttons">
        <a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a>
        <a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a>
      </div>
    </div>

    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
    	  <table class="form">
      		<?php foreach ($languages as $language) { ?>
            <tr>
      				<td class="left">
                <strong>(<?php echo $language['name']; ?>)</strong><?php echo $text_heading_title; ?>
              </td>
      				<td class="left">
                <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <input type="text" name="GALKAalso_bought_heading_title_<?php echo $language['language_id'];?>" value="<?php echo $box_heading_title[$language['language_id']]; ?>" size="40" />
              </td>
      			</tr>
          <?php } ?>

      		<tr class="hide">
      			<td class="left"><?php echo $text_delete_cache; ?></td>
      			<td class="left">
      				<input type="text" name="GALKAalso_bought_dc_period" value="<?php echo $GALKAalso_bought_dc_period; ?>"/>(<?php echo $text_hours; ?>)
        			<?php if ($error_dc_period) { ?>
        				<span class="error"><?php echo $error_dc_period; ?></span> 
        			<?php } ?>
      			</td>
      		</tr>
    	  </table>

        <table id="module" class="list">
          <thead>
            <tr>
              <td class="left"><?php echo $entry_limit; ?></td>
              <td class="left"><?php echo $entry_image; ?></td>
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
          			<td class="left hide">
                  <select name="GALKAalso_bought_module[<?php echo $module_row; ?>][order_status_operand]">
          				  <option value="<="  <?php echo (html_entity_decode($module['order_status_operand']) == "<=")? "selected" : "" ?>><=</option> 
                  </select>
                </td>

          			<td class="left hide">
                  <select name="GALKAalso_bought_module[<?php echo $module_row; ?>][order_status_id]">
            				<?php foreach($orders_statuses as $order_status){?>
            					<?php if ( $module['order_status_id'] == $order_status['order_status_id']) { ?>
            						<option value="<?php echo $order_status['order_status_id']; ?>" selected><?php echo $order_status['name']; ?></option>
            					<?php } else { ?>
            						<option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
            					<?php } ?>	
            				<?php } ?>
          				</select>
                </td>

            		<td class="left hide">
                  <select name="GALKAalso_bought_module[<?php echo $module_row; ?>][button_cart]">
                    <?php if ($module['button_cart']) { ?>
                      <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                    <?php } else { ?>
                      <option value="1"><?php echo $text_yes; ?></option>
                    <?php } ?>
                  </select>
                </td>

                <td class="left">
                  <input type="text" name="GALKAalso_bought_module[<?php echo $module_row; ?>][limit]" value="<?php echo $module['limit']; ?>" size="1" />
                </td>

                <td class="left">
                  <input type="text" name="GALKAalso_bought_module[<?php echo $module_row; ?>][image_width]" value="<?php echo $module['image_width']; ?>" size="3" />
                  <input type="text" name="GALKAalso_bought_module[<?php echo $module_row; ?>][image_height]" value="<?php echo $module['image_height']; ?>" size="3" />
                  <?php if (isset($error_image[$module_row])) { ?>
                    <span class="error"><?php echo $error_image[$module_row]; ?></span>
                  <?php } ?>
                </td>

                <td class="left hide">
                  <select name="GALKAalso_bought_module[<?php echo $module_row; ?>][sort]">
            				<?php if ($module['sort'] == 'no_sells') { ?>
                      <option value="no_sells" selected="selected"><?php echo $text_sale; ?></option>
                    <?php } else { ?>
            				  <option value="no_sells"><?php echo $text_sale; ?></option>
            				<?php } ?>
                  </select><br />

          			  <select name="GALKAalso_bought_module[<?php echo $module_row; ?>][sort_type]">
            				<?php if ($module['sort_type'] == 'ASC') { ?>
                      <option value="ASC" selected="selected">ASC</option>
                      <option value="DESC">DESC</option>
                    <?php } else { ?>
          				    <option value="ASC">ASC</option>
                      <option value="DESC" selected="selected">DESC</option>
            				<?php } ?>
                  </select>
                </td>

                <td class="left">
                  <select name="GALKAalso_bought_module[<?php echo $module_row; ?>][layout_id]">
                    <?php foreach($layouts as $layout) { ?>
    				          <?php if ($layout['layout_id'] == $module['layout_id']) { ?> 
                        <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
              				<?php } else { ?>
              				  <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
              				<?php } ?>
              			<?php } ?>
                  </select>
                </td>

                <td class="left">
                  <select name="GALKAalso_bought_module[<?php echo $module_row; ?>][position]">
                    <?php //if ($module['position'] == 'content_top') { ?>
                      <!-- <option value="content_top" selected="selected"><?php echo $text_content_top; ?></option> -->
                    <?php //} else { ?>
                      <!-- <option value="content_top"><?php echo $text_content_top; ?></option> -->
                    <?php //} ?>

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
                  </select>
                </td>

                <td class="left">
                  <select name="GALKAalso_bought_module[<?php echo $module_row; ?>][status]">
                    <?php if ($module['status']) { ?>
                      <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                      <option value="0"><?php echo $text_disabled; ?></option>
                    <?php } else { ?>
                      <option value="1"><?php echo $text_enabled; ?></option>
                      <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                    <?php } ?>
                  </select>
                </td>

                <td class="right">
                  <input type="text" name="GALKAalso_bought_module[<?php echo $module_row; ?>][sort_order]" value="<?php echo $module['sort_order']; ?>" size="3" />
                </td>

                <td class="left">
                  <a onclick="$('#module-row<?php echo $module_row; ?>').remove();" class="button"><?php echo $button_remove; ?></a>
                </td>
              </tr>
            </tbody>
            <?php $module_row++; ?>
          <?php } ?>
          <tfoot>
            <tr>
              <td colspan="10"></td>
              <td class="left"><a onclick="addModule();" class="button"><?php echo $button_add_module; ?></a></td>
            </tr>
          </tfoot>
        </table>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript"><!--
var module_row = <?php echo $module_row; ?>;

function addModule() {	
	html  = '<tbody id="module-row' + module_row + '">';
	html += '  <tr>';
	html += '    <td class="left hide"><select name="GALKAalso_bought_module[' + module_row + '][order_status_operand]">';
    html += '      <option value="<="><=</option>';
	html += '    </select></td>'; 
	html += '    <td class="left hide"><select name="GALKAalso_bought_module[' + module_row + '][order_status_id]">';
	<?php foreach($orders_statuses as $order_status) { ?>
	html += '    <option value="<?php echo $order_status['order_status_id'];?>"><?php echo $order_status['name']; ?></option>'
	<?php } ?>
	html += '    </select></td>'; 
	html += '    <td class="left hide"><select name="GALKAalso_bought_module[' + module_row + '][button_cart]">';
    html += '      <option value="1" selected="selected"><?php echo $text_yes; ?></option>';
    html += '    </select></td>';
	html += '    <td class="left"><input type="text" name="GALKAalso_bought_module[' + module_row + '][limit]" value="5" size="1" /></td>';
	html += '    <td class="left"><input type="text" name="GALKAalso_bought_module[' + module_row + '][image_width]" value="80" size="3" /> <input type="text" name="GALKAalso_bought_module[' + module_row + '][image_height]" value="80" size="3" /></td>';	
	html += '    <td class="left hide"><select name="GALKAalso_bought_module[' + module_row + '][sort]">';
	html += '      <option value="no_sells"><?php echo $text_sale; ?></option>';
	html += '    </select><br />';
	html += '    <select name="GALKAalso_bought_module[' + module_row + '][sort_type]">';
	html += '      <option value="DESC">DESC</option>';
	html += '      <option value="ASC">ASC</option>';
	html += '    </select></td>';
	html += '    <td class="left"><select name="GALKAalso_bought_module[' + module_row + '][layout_id]">';
	<?php foreach($layouts as $layout){ ?>
	<?php if ($layout['layout_id'] == 2){ ?>
	html += '      <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>';
	<?php } else { ?>
	html += '      <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>';
	<?php } ?>
	<?php } ?>
	html += '    </select></td>';
	html += '    <td class="left"><select name="GALKAalso_bought_module[' + module_row + '][position]">';
	// html += '      <option value="content_top"><?php echo $text_content_top; ?></option>';
	html += '      <option value="content_bottom"><?php echo $text_content_bottom; ?></option>';
	html += '      <option value="column_left"><?php echo $text_column_left; ?></option>';
	html += '      <option value="column_right"><?php echo $text_column_right; ?></option>';
	html += '    </select></td>';
	html += '    <td class="left"><select name="GALKAalso_bought_module[' + module_row + '][status]">';
    html += '      <option value="1" selected="selected"><?php echo $text_enabled; ?></option>';
    html += '      <option value="0"><?php echo $text_disabled; ?></option>';
    html += '    </select></td>';
	html += '    <td class="right"><input type="text" name="GALKAalso_bought_module[' + module_row + '][sort_order]" value="" size="3" /></td>';
	html += '    <td class="left"><a onclick="$(\'#module-row' + module_row + '\').remove();" class="button"><?php echo $button_remove; ?></a></td>';
	html += '  </tr>';
	html += '</tbody>';
	
	$('#module tfoot').before(html);
	
	module_row++;
}
//--></script>
<?php echo $footer; ?>