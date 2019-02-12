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
        <a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a>
        <a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a>
      </div>
    </div>

    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <table id="module" class="list">
          <thead>
            <tr>
              <td class="left"><?php echo $entry_banner; ?></td>
              <td class="left"><span class="required">*</span><?php echo $entry_dimension; ?></td>
              <td class="left"><?php echo $entry_layout; ?></td>
              <td class="left"><?php echo 'Размещение'; ?></td>
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
                <td class="left">
                  <select name="banner_module[<?php echo $module_row; ?>][banner_id]">
                    <?php foreach ($banners as $banner) { ?>
                      <?php if ($banner['banner_id'] == $module['banner_id']) { ?>
                        <option value="<?php echo $banner['banner_id']; ?>" selected="selected"><?php echo $banner['name']; ?></option>
                      <?php } else { ?>
                        <option value="<?php echo $banner['banner_id']; ?>"><?php echo $banner['name']; ?></option>
                      <?php } ?>
                    <?php } ?>
                  </select>
                </td>

                <td class="left">
                  <input type="text" name="banner_module[<?php echo $module_row; ?>][width]" value="<?php echo $module['width']; ?>" size="3" />
                  <input type="text" name="banner_module[<?php echo $module_row; ?>][height]" value="<?php echo $module['height']; ?>" size="3" />
                  
                  <?php if (isset($error_dimension[$module_row])) { ?>
                    <span class="error"><?php echo $error_dimension[$module_row]; ?></span>
                  <?php } ?>
                </td>

                <?php $route_product_select = null; ?>

                <td class="left">
                  <select name="banner_module[<?php echo $module_row; ?>][layout_id]" onchange="routeLayout(this.options[this.selectedIndex].id, <?php echo $module_row; ?>);" >
                    <?php foreach ($layouts as $layout) { ?>
                      <option value="<?php echo $layout['layout_id']; ?>"
                        <?php if ($layout['route'] == $route_product) { ?>
                          id = "route_product"
                        <?php } ?>

                        <?php if ($layout['layout_id'] == $module['layout_id']) { ?>
                          selected="selected"

                          <?php if ($layout['route'] == $route_product) { ?>
                            <?php $route_product_select = $route_product; ?>
                          <?php } ?>
                        <?php } ?>
                      ><?php echo $layout['name']; ?></option>
                    <?php } ?>
                  </select>
                </td>

                <td id="targ_<?php echo $module_row; ?>">
                  <?php if ($route_product_select != null) { ?>
                    <select id="select_manufacturer_<?php echo $module_row; ?>" onchange="listProduct(<?php echo $module_row; ?>, this.options[this.selectedIndex].value)">
                        <option value="0" selected="selected"><?php echo $text_none; ?></option>
                        <?php foreach ($manufacturers as $manufacturer) { ?>
                            <option value="<?php echo $manufacturer['manufacturer_id']; ?>"><?php echo $manufacturer['name']; ?></option>
                        <?php } ?>
                    </select>

                    <?php if (isset($module['product_route_product'])) { ?>
                      <div class="scrollbox" id="checked_product_<?php echo $module_row; ?>">
                        <?php $class = "odd"; ?>

                        <?php foreach ($module['product_route_product'] as $product) { ?>
                          <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>

                          <div id="row_<?php echo $module_row; ?>_product_<?php echo $product['product_id']; ?>" class="<?php echo $class; ?>">
                            <input type="hidden" name="banner_module[<?php echo $module_row; ?>][product_route_product][]" value="<?php echo $product['product_id']; ?>">
                            (<?php echo $product['model']; ?>) <?php echo $product['name']; ?>
                            <span class="img_delete_option" onclick="deleteModuleProduct(<?php echo $module_row; ?>, <?php echo $product['product_id']; ?>);"></span>
                          </div>
                        <?php } ?>
                      </div>
                    <?php } ?>
                  <?php } ?>
                </td>

                <td class="left">
                  <select name="banner_module[<?php echo $module_row; ?>][position]">
                    <?php if ($module['position'] == 'content_header') { ?>
                      <option value="content_header" selected="selected">Header</option>
                    <?php } else { ?>
                      <option value="content_header">Header</option>
                    <?php } ?>

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
                  </select>
                </td>

                <td class="left">
                  <select name="banner_module[<?php echo $module_row; ?>][status]">
                    <?php if ($module['status']) { ?>
                      <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                      <option value="0"><?php echo $text_disabled; ?></option>
                    <?php } else { ?>
                      <option value="1"><?php echo $text_enabled; ?></option>
                      <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                    <?php } ?>
                  </select>
                </td>

                <td class="right"><input type="text" name="banner_module[<?php echo $module_row; ?>][sort_order]" value="<?php echo $module['sort_order']; ?>" size="3" /></td>
                <td class="left"><a onclick="$('#module-row<?php echo $module_row; ?>').remove();" class="button"><?php echo $button_remove; ?></a></td>
              </tr>
            </tbody>
            <?php $module_row++; ?>
          <?php } ?>

          <tfoot>
            <tr>
              <td colspan="7"></td>
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
  var token = "<?php echo $_GET['token']; ?>";
  var class_prod = "odd";
  
  function addModule() {  
    html  = '<tbody id="module-row' + module_row + '">';
    html += '  <tr>';
    html += '    <td class="left"><select name="banner_module[' + module_row + '][banner_id]">';
    <?php foreach ($banners as $banner) { ?>
    html += '      <option value="<?php echo $banner['banner_id']; ?>"><?php echo addslashes($banner['name']); ?></option>';
    <?php } ?>
    html += '    </select></td>';
    html += '    <td class="left"><input type="text" name="banner_module[' + module_row + '][width]" value="" size="3" /> <input type="text" name="banner_module[' + module_row + '][height]" value="" size="3" /></td>';
    html += '    <td class="left"><select name="banner_module[' + module_row + '][layout_id]" onchange="routeLayout(this.options[this.selectedIndex].id, ' + module_row + ');" >';

    <?php foreach ($layouts as $layout) { ?>
      html += '      <option ';
      <?php if ($layout['route'] == $route_product) { ?>
        html += "       id='route_product' ";
      <?php } ?>
      html += '     value="<?php echo $layout['layout_id']; ?>"><?php echo addslashes($layout['name']); ?></option>';
    <?php } ?>
    
    html += '    </select></td>';
    html += '<td id="targ_' + module_row + '"></td>';
    html += '    <td class="left"><select name="banner_module[' + module_row + '][position]">';
    html += '      <option value="content_header">Header</option>';
    html += '      <option value="content_top"><?php echo $text_content_top; ?></option>';
    html += '      <option value="content_bottom"><?php echo $text_content_bottom; ?></option>';
    html += '      <option value="column_left"><?php echo $text_column_left; ?></option>';
    html += '      <option value="column_right"><?php echo $text_column_right; ?></option>';
    html += '    </select></td>';
    html += '    <td class="left"><select name="banner_module[' + module_row + '][status]">';
    html += '      <option value="1" selected="selected"><?php echo $text_enabled; ?></option>';
    html += '      <option value="0"><?php echo $text_disabled; ?></option>';
    html += '    </select></td>';
    html += '    <td class="right"><input type="text" name="banner_module[' + module_row + '][sort_order]" value="" size="3" /></td>';
    html += '    <td class="left"><a onclick="$(\'#module-row' + module_row + '\').remove();" class="button"><?php echo $button_remove; ?></a></td>';
    html += '  </tr>';
    html += '</tbody>';
    
    $('#module tfoot').before(html);
    
    module_row++;
  }

  function routeLayout(id_option, row) {
    if (id_option != '' && id_option == 'route_product') {
      table_body = '<select id="select_manufacturer_' + row + '" onchange="listProduct(' + row + ', this.options[this.selectedIndex].value)">';
      table_body += "<option value='0' selected='selected'><?php echo $text_none; ?></option>";
          <?php foreach ($manufacturers as $manufacturer) { ?>
            table_body += "<option value='<?php echo $manufacturer['manufacturer_id']; ?>'><?php echo $manufacturer['name']; ?></option>";
          <?php } ?>
      table_body += "</select>";

      $('#targ_' + row).html(table_body);
    } else {
      $('#targ_' + row).empty();
    }
  }

  function loading(row) {
    var bmodal = document.createElement('div');
    bmodal.setAttribute("id", "modal-product");
    
    var img = document.createElement('img');
    img.src = "view/image/loading-admin.gif";
    
    bmodal.appendChild(img);
    $('#product_copy_id_' + row).append(bmodal);
  }

  function deleteLoading() {
    var elem = document.getElementById('modal-product');
    elem.parentNode.removeChild(elem);
  }

  function deleteModuleProduct(row, product_id) {
    $('#row_' + row + '_product_' + product_id).remove();
  }

  function listProduct(row, manufacturer_id) {    
    $('#list_product_' + row).remove();

    if (manufacturer_id == 0) {
      return false;
    }

    var url = "index.php?route=module/banner/getProduct&token=" + token;
    
    $.get(
        url,
        "manufacturer_id=" + manufacturer_id,
        function (product) {
            if (product.type == 'error') {
                alert(product.message);
            } else {
                var div = '<div class="scrollbox_product" id="list_product_' + row + '" >';

                $(product.data).each(function() {
                    class_prod = (class_prod == 'even' ? 'odd' : 'even');

                    div += '<div id="product_id" class="' + class_prod + '">';
                    div += '  <input type="checkbox" id="product_data" value="' + $(this).attr('product_id') + '" ';
                    div += '  name="banner_module[' + row + '][product_route_product][]" ';
                    div += '  onclick="addModuleProduct(this, ' + row + ', ' + $(this).attr('product_id') + ', &quot;' + $(this).attr('name') + '&quot;, &quot;' + $(this).attr('model') + '&quot;)" ';
                    div += '>';
                    div +=    $(this).attr('name') + " (" + $(this).attr('model') + ")";
                    div += '</div>';
                });
                div += '</div>';

                $('#select_manufacturer_' + row).after(div);
            }
        },
        "json"
    );
  }

  function addModuleProduct(obj, row, product_id, name, model) {
    if ($('#row_' + row + '_product_' + product_id).length != 0 || obj.checked == false) {
        if (obj.checked == false) {
            $('#row_' + row + '_product_' + product_id).remove();
        }

        return false;
    }

    var product_checked = '';
    var html = '';

    class_prod = (class_prod == 'even' ? 'odd' : 'even');

    product_checked += '<div id="row_' + row + '_product_' + product_id + '" class="' + class_prod + '">';
    product_checked += '     <input type="hidden" name="banner_module[' + row + '][product_route_product][]]" value="' + product_id + '">(' + model + ') ' + name;
    product_checked += '     <span class="img_delete_option" onclick="deleteModuleProduct(' + row + ', ' + product_id + ');"></span>';
    product_checked += '</div>';

    if ($('#checked_product_' + row).length == 0) {
        html += '<div class="scrollbox" id="checked_product_' + row + '" >';
        html += product_checked;
        html += '</div>';
        $('#list_product_' + row).after(html);
    } else {
        $('#checked_product_' + row).append(product_checked);
    }
  }
//--></script>

<?php echo $footer; ?>