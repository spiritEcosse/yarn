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
            <h1><img src="view/image/product.png" alt="" /> <?php echo $heading_title; ?></h1>
            <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a></div>
        </div>
        <div class="content">
            <div id="tabs" class="htabs">
                <a href="#tab-general"><?php echo $tab_general; ?></a>
                <a href="#tab-data"><?php echo $tab_data; ?></a>
                <a href="#tab-links"><?php echo $tab_links; ?></a>
                <a href="#tab-filter"><?php echo $tab_filter; ?></a>
                <a href="#tab-attribute"><?php echo $tab_attribute; ?></a>
                <a href="#tab-option"><?php echo $tab_option; ?></a>
                <a href="#tab-discount"><?php echo $tab_discount; ?></a>
                <a href="#tab-special"><?php echo $tab_special; ?></a>
                <a href="#tab-image"><?php echo $tab_image; ?></a>
                <a href="#tab-design"><?php echo $tab_design; ?></a>
                <a href="#tab-reward"><?php echo $tab_reward; ?></a>
                <a href="#tab-product_tab"><?php echo $tab_product_tab; ?></a>
            </div>
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
                
                <div id="tab-general">
                    <div id="languages" class="htabs">
                        <?php foreach ($languages as $language) { ?>
                        <a href="#language<?php echo $language['language_id']; ?>"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a>
                        <?php } ?>
                    </div>
                    <?php foreach ($languages as $language) { ?>
                    <div id="language<?php echo $language['language_id']; ?>">
                        <table class="form">
                            <tr>
                                <td><span class="required">*</span> <?php echo $entry_name; ?></td>
                                <td>
                                    <input type="text" name="product_description[<?php echo $language['language_id']; ?>][name]" maxlength="255" size="100" value="<?php echo isset($product_description[$language['language_id']]) ? $product_description[$language['language_id']]['name'] : ''; ?>" />
                                    <?php if (isset($error_name[$language['language_id']])) { ?>
                                    <span class="error"><?php echo $error_name[$language['language_id']]; ?></span>
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo $entry_seo_h1; ?></td>
                                <td><input type="text" name="product_description[<?php echo $language['language_id']; ?>][seo_h1]" maxlength="255" size="100" value="<?php echo isset($product_description[$language['language_id']]) ? $product_description[$language['language_id']]['seo_h1'] : ''; ?>" /></td>
                            </tr>
                            <tr>
                                <td><?php echo $entry_seo_title; ?></td>
                                <td><input type="text" name="product_description[<?php echo $language['language_id']; ?>][seo_title]" maxlength="255" size="100" value="<?php echo isset($product_description[$language['language_id']]) ? $product_description[$language['language_id']]['seo_title'] : ''; ?>" /></td>
                            </tr>
                            <tr>
                                <td><?php echo $entry_meta_keyword; ?></td>
                                <td><input type="text" name="product_description[<?php echo $language['language_id']; ?>][meta_keyword]" maxlength="255" size="100" value="<?php echo isset($product_description[$language['language_id']]) ? $product_description[$language['language_id']]['meta_keyword'] : ''; ?>" /></td>
                            </tr>
                            <tr>
                                <td><?php echo $entry_meta_description; ?></td>
                                <td><textarea name="product_description[<?php echo $language['language_id']; ?>][meta_description]" cols="100" rows="2"><?php echo isset($product_description[$language['language_id']]) ? $product_description[$language['language_id']]['meta_description'] : ''; ?></textarea></td>
                            </tr>
                            <tr>
                                <td><?php echo $entry_description; ?></td>
                                <td><textarea name="product_description[<?php echo $language['language_id']; ?>][description]" id="description<?php echo $language['language_id']; ?>"><?php echo isset($product_description[$language['language_id']]) ? $product_description[$language['language_id']]['description'] : ''; ?></textarea></td>
                            </tr>
                            <tr>
                                <td><?php echo $entry_tag; ?></td>
                                <td><input type="text" name="product_tag[<?php echo $language['language_id']; ?>]" value="<?php echo isset($product_tag[$language['language_id']]) ? $product_tag[$language['language_id']] : ''; ?>" size="80" /></td>
                            </tr>
                        </table>
                    </div>
                    <?php } ?>
                </div>
                <div id="tab-data">
                    <table class="form">
                        <tr>
                            <td><?php echo $entry_model; ?></td>
                            <td>
                                <input type="text" name="model" value="<?php echo $model; ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_sku; ?></td>
                            <td><input type="text" name="sku" value="<?php echo $sku; ?>" /></td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_upc; ?></td>
                            <td><input type="text" name="upc" value="<?php echo $upc; ?>" /></td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_location; ?></td>
                            <td><input type="text" name="location" value="<?php echo $location; ?>" /></td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_price; ?></td>
                            <td>
                                <select name="price_prefix_id">
                                    <option value="0"><?php echo $text_no; ?></option>

                                    <?php foreach ($price_prefixes as $price_prefix) { ?>
                                        <option value="<?php echo $price_prefix['price_prefix_id']; ?>" 
                                            <?php if ($price_prefix['price_prefix_id'] == $price_prefix_id) { ?>
                                                selected
                                            <?php } ?>

                                            ><?php echo $price_prefix['name']; ?>
                                        </option>
                                    <?php } ?>
                                </select>

                                <input type="text" name="price" value="<?php echo $price; ?>" />
                                <?php echo $entry_view_price; ?>

                                <select name="price_after_id">
                                    <option value="0"><?php echo $text_no; ?></option>

                                    <?php foreach ($price_afters as $price_after) { ?>
                                        <option value="<?php echo $price_after['price_after_id']; ?>" 
                                            <?php if ($price_after['price_after_id'] == $price_after_id) { ?>
                                                selected
                                            <?php } ?>

                                            ><?php echo $price_after['name']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_price_status; ?></td>
                            <td>
                                <?php if ($price_status == 1) { ?>
                                    <input type="checkbox" name="price_status" value="1" checked="checked" />
                                <?php } else { ?>
                                    <input type="checkbox" name="price_status" value="1" />
                                <?php } ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_tax_class; ?></td>
                            <td><select name="tax_class_id">
                                    <option value="0"><?php echo $text_none; ?></option>
                                    <?php foreach ($tax_classes as $tax_class) { ?>
                                    <?php if ($tax_class['tax_class_id'] == $tax_class_id) { ?>
                                    <option value="<?php echo $tax_class['tax_class_id']; ?>" selected="selected"><?php echo $tax_class['title']; ?></option>
                                    <?php } else { ?>
                                    <option value="<?php echo $tax_class['tax_class_id']; ?>"><?php echo $tax_class['title']; ?></option>
                                    <?php } ?>
                                    <?php } ?>
                                </select></td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_quantity; ?></td>
                            <td><input type="text" name="quantity" value="<?php echo $quantity; ?>" size="2" /></td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_minimum; ?></td>
                            <td><input type="text" name="minimum" value="<?php echo $minimum; ?>" size="2" /></td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_subtract; ?></td>
                            <td><select name="subtract">
                                    <?php if ($subtract) { ?>
                                    <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                                    <option value="0"><?php echo $text_no; ?></option>
                                    <?php } else { ?>
                                    <option value="1"><?php echo $text_yes; ?></option>
                                    <option value="0" selected="selected"><?php echo $text_no; ?></option>
                                    <?php } ?>
                                </select></td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_stock_status; ?></td>
                            <td><select name="stock_status_id">
                                    <?php foreach ($stock_statuses as $stock_status) { ?>
                                        <?php if ($stock_status['stock_status_id'] == $stock_status_id) { ?>
                                            <option value="<?php echo $stock_status['stock_status_id']; ?>" selected="selected"><?php echo $stock_status['name']; ?></option>
                                        <?php } else { ?>
                                            <option value="<?php echo $stock_status['stock_status_id']; ?>"><?php echo $stock_status['name']; ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select></td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_shipping; ?></td>
                            <td><?php if ($shipping) { ?>
                                <input type="radio" name="shipping" value="1" checked="checked" />
                                <?php echo $text_yes; ?>
                                <input type="radio" name="shipping" value="0" />
                                <?php echo $text_no; ?>
                                <?php } else { ?>
                                <input type="radio" name="shipping" value="1" />
                                <?php echo $text_yes; ?>
                                <input type="radio" name="shipping" value="0" checked="checked" />
                                <?php echo $text_no; ?>
                                <?php } ?></td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_keyword; ?></td>
                            <td><input type="text" name="keyword" value="<?php echo $keyword; ?>" /></td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_image; ?></td>
                            <td><div class="image"><img src="<?php echo $thumb; ?>" alt="" id="thumb" /><br />
                                    <input type="hidden" name="image" value="<?php echo $image; ?>" id="image" />
                                    <a onclick="image_upload('image', 'thumb');"><?php echo $text_browse; ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a onclick="$('#thumb').attr('src', '<?php echo $no_image; ?>'); $('#image').attr('value', '');"><?php echo $text_clear; ?></a></div></td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_date_available; ?></td>
                            <td><input type="text" name="date_available" value="<?php echo $date_available; ?>" size="12" class="date" /></td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_dimension; ?></td>
                            <td><input type="text" name="length" value="<?php echo $length; ?>" size="4" />
                                <input type="text" name="width" value="<?php echo $width; ?>" size="4" />
                                <input type="text" name="height" value="<?php echo $height; ?>" size="4" /></td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_length; ?></td>
                            <td><select name="length_class_id">
                                    <?php foreach ($length_classes as $length_class) { ?>
                                    <?php if ($length_class['length_class_id'] == $length_class_id) { ?>
                                    <option value="<?php echo $length_class['length_class_id']; ?>" selected="selected"><?php echo $length_class['title']; ?></option>
                                    <?php } else { ?>
                                    <option value="<?php echo $length_class['length_class_id']; ?>"><?php echo $length_class['title']; ?></option>
                                    <?php } ?>
                                    <?php } ?>
                                </select></td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_weight; ?></td>
                            <td><input type="text" name="weight" value="<?php echo $weight; ?>" /></td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_weight_class; ?></td>
                            <td><select name="weight_class_id">
                                    <?php foreach ($weight_classes as $weight_class) { ?>
                                    <?php if ($weight_class['weight_class_id'] == $weight_class_id) { ?>
                                    <option value="<?php echo $weight_class['weight_class_id']; ?>" selected="selected"><?php echo $weight_class['title']; ?></option>
                                    <?php } else { ?>
                                    <option value="<?php echo $weight_class['weight_class_id']; ?>"><?php echo $weight_class['title']; ?></option>
                                    <?php } ?>
                                    <?php } ?>
                                </select></td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_status; ?></td>
                            <td><select name="status">
                                    <?php if ($status) { ?>
                                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                    <option value="0"><?php echo $text_disabled; ?></option>
                                    <?php } else { ?>
                                    <option value="1"><?php echo $text_enabled; ?></option>
                                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                                    <?php } ?>
                                </select></td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_sort_order; ?></td>
                            <td><input type="text" name="sort_order" value="<?php echo $sort_order; ?>" size="2" /></td>
                        </tr>
                    </table>
                </div>
                <div id="tab-links">
                    <table class="form">
                        <tr>
                            <td><?php echo $entry_manufacturer; ?></td>
                            <td><select name="manufacturer_id">
                                    <option value="0" selected="selected"><?php echo $text_none; ?></option>
                                    <?php foreach ($manufacturers as $manufacturer) { ?>
                                    <?php if ($manufacturer['manufacturer_id'] == $manufacturer_id) { ?>
                                    <option value="<?php echo $manufacturer['manufacturer_id']; ?>" selected="selected"><?php echo $manufacturer['name']; ?></option>
                                    <?php } else { ?>
                                    <option value="<?php echo $manufacturer['manufacturer_id']; ?>"><?php echo $manufacturer['name']; ?></option>
                                    <?php } ?>
                                    <?php } ?>
                                </select></td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_main_category; ?></td>
                            <td><select name="main_category_id">
                                    <option value="0" selected="selected"><?php echo $text_none; ?></option>
                                    <?php foreach ($categories as $category) { ?>
                                    <?php if ($category['category_id'] == $main_category_id) { ?>
                                    <option value="<?php echo $category['category_id']; ?>" selected="selected"><?php echo $category['name']; ?></option>
                                    <?php } else { ?>
                                    <option value="<?php echo $category['category_id']; ?>"><?php echo $category['name']; ?></option>
                                    <?php } ?>
                                    <?php } ?>
                                </select></td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_category; ?></td>
                            <td class="scroll"><div class="scrollbox">
                                    <?php $class = 'odd'; ?>
                                    
                                    <?php foreach ($categories as $category) { ?>
                                        <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                                        
                                        <div class="<?php echo $class; ?>">
                                            <?php if (in_array($category['category_id'], $product_category)) { ?>
                                                <input type="checkbox" name="product_category[]" value="<?php echo $category['category_id']; ?>" checked="checked" />
                                                <?php echo $category['name']; ?>
                                            <?php } else { ?>
                                                <input type="checkbox" name="product_category[]" value="<?php echo $category['category_id']; ?>" />
                                                <?php echo $category['name']; ?>
                                            <?php } ?>
                                        </div>
                                    <?php } ?>
                                </div>
                                <a onclick="$(this).parent().find(':checkbox').attr('checked', true);"><?php echo $text_select_all; ?></a> / <a onclick="$(this).parent().find(':checkbox').attr('checked', false);"><?php echo $text_unselect_all; ?></a></td>
                        </tr>
                        <tr>
                            <td>
                                Копирование категорий в другие товары
                            </td>
                            <td>
                                <div class="select_manufacturer">
                                    <select onchange="listProduct(this.options[this.selectedIndex].value, this, 'category');">
                                        <option value="0">Не выбрано</option>
                                        <?php foreach ($manufacturers as $manufacturer) { ?>
                                            <option value="<?php echo $manufacturer['manufacturer_id']; ?>"><?php echo $manufacturer['name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_store; ?></td>
                            <td><div class="scrollbox">
                                    <?php $class = 'even'; ?>
                                    <div class="<?php echo $class; ?>">
                                        <?php if (in_array(0, $product_store)) { ?>
                                        <input type="checkbox" name="product_store[]" value="0" checked="checked" />
                                        <?php echo $text_default; ?>
                                        <?php } else { ?>
                                        <input type="checkbox" name="product_store[]" value="0" />
                                        <?php echo $text_default; ?>
                                        <?php } ?>
                                    </div>
                                    <?php foreach ($stores as $store) { ?>
                                    <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                                    <div class="<?php echo $class; ?>">
                                        <?php if (in_array($store['store_id'], $product_store)) { ?>
                                        <input type="checkbox" name="product_store[]" value="<?php echo $store['store_id']; ?>" checked="checked" />
                                        <?php echo $store['name']; ?>
                                        <?php } else { ?>
                                        <input type="checkbox" name="product_store[]" value="<?php echo $store['store_id']; ?>" />
                                        <?php echo $store['name']; ?>
                                        <?php } ?>
                                    </div>
                                    <?php } ?>
                                </div></td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_download; ?></td>
                            <td><div class="scrollbox">
                                    <?php $class = 'odd'; ?>
                                    <?php foreach ($downloads as $download) { ?>
                                    <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                                    <div class="<?php echo $class; ?>">
                                        <?php if (in_array($download['download_id'], $product_download)) { ?>
                                        <input type="checkbox" name="product_download[]" value="<?php echo $download['download_id']; ?>" checked="checked" />
                                        <?php echo $download['name']; ?>
                                        <?php } else { ?>
                                        <input type="checkbox" name="product_download[]" value="<?php echo $download['download_id']; ?>" />
                                        <?php echo $download['name']; ?>
                                        <?php } ?>
                                    </div>
                                    <?php } ?>
                                </div></td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_related; ?></td>
                            <td><input type="text" name="related" value="" /></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>
                                <div id="product-related" class="scrollbox">
                                    <?php $class = 'odd'; ?>
                                    <?php foreach ($product_related as $product_related) { ?>
                                    <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                                    <div id="product-related<?php echo $product_related['product_id']; ?>" class="<?php echo $class; ?>"> <?php echo $product_related['name']; ?><img src="view/image/delete.png" />
                                        <input type="hidden" name="product_related[]" value="<?php echo $product_related['product_id']; ?>" />
                                    </div>
                                    <?php } ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="copy_fabric">
                                    <div class="title">Копирование рекомендуемых товаров в другие товары</div>
                                    <div class="select_manufacturer">
                                        <select onchange="listProduct(this.options[this.selectedIndex].value, this, 'related');">
                                            <option value="0">Не выбрано</option>
                                            <?php foreach ($manufacturers as $manufacturer) { ?>
                                                <option value="<?php echo $manufacturer['manufacturer_id']; ?>"><?php echo $manufacturer['name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>

                <div id="tab-filter">
                    <?php if (isset($category_options_error) and $category_options_error!="") { ?>
                       <?php echo $category_options_error; ?>
                    <?php } ?>
                    
                    <?php if ($category_options) { ?>
                     <table class="form">
                         <?php foreach ($category_options as $option) { ?>
                             <tr>
                                <td width="20%"><b><?php echo $option['name'];?></td>
                                <td width="80%">
                                    <?php if ($option['category_option_values']) { ?>
                                      <select multiple name="product_to_value_id[<?php echo $option['option_id']; ?>][]">
                                          <?php foreach ($option['category_option_values'] as $value) { ?>
                                               <?php if (in_array($value['value_id'], $product_to_value_id)) { ?>
                                                   <option value="<?php echo $value['value_id'];?>" selected="selected"><?php echo $value['language'][$language_id]['name'];?></option>
                                               <?php } else { ?>
                                                   <option value="<?php echo  $value['value_id'];?>"><?php echo $value['language'][$language_id]['name']; ?></option>
                                               <?php } ?>
                                          <?php } ?>
                                      </select>
                                    <?php } ?>
                                </td>
                             </tr>
                         <?php } ?>
                     </table>
                    <?php } ?>
                </div>

                <div id="tab-attribute">
                    <table id="attribute" class="list">
                        <thead>
                            <tr>
                                <td class="left"><?php echo $entry_attribute; ?></td>
                                <td class="left"><?php echo $entry_text; ?></td>
                                <td></td>
                            </tr>
                        </thead>
                        <?php $attribute_row = 0; ?>
                        <?php foreach ($product_attributes as $product_attribute) { ?>
                        <tbody id="attribute-row<?php echo $attribute_row; ?>">
                            <tr>
                                <td class="left"><input type="text" name="product_attribute[<?php echo $attribute_row; ?>][name]" value="<?php echo $product_attribute['name']; ?>" />
                                    <input type="hidden" name="product_attribute[<?php echo $attribute_row; ?>][attribute_id]" value="<?php echo $product_attribute['attribute_id']; ?>" /></td>
                                <td class="left"><?php foreach ($languages as $language) { ?>
                                    <textarea name="product_attribute[<?php echo $attribute_row; ?>][product_attribute_description][<?php echo $language['language_id']; ?>][text]" cols="40" rows="5"><?php echo isset($product_attribute['product_attribute_description'][$language['language_id']]) ? $product_attribute['product_attribute_description'][$language['language_id']]['text'] : ''; ?></textarea>
                                    <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" align="top" /><br />
                                    <?php } ?></td>
                                <td class="left"><a onclick="$('#attribute-row<?php echo $attribute_row; ?>').remove();" class="button"><?php echo $button_remove; ?></a></td>
                            </tr>
                        </tbody>
                        <?php $attribute_row++; ?>
                        <?php } ?>
                        <tfoot>
                            <tr>
                                <td colspan="2"></td>
                                <td class="left"><a onclick="addAttribute();" class="button"><?php echo $button_add_attribute; ?></a></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div id="tab-option">
                    <div id="vtab-option" class="vtabs">
                        <?php $option_row = 0; ?>
                        
                        <?php foreach ($product_options as $product_option) { ?>
                            <?php $option_id = 'option_id'; ?>
                            <?php $product_option_id = 'product_option_id'; ?>
                            
                            <a href="#tab-option-<?php echo $option_row; ?>" id="option-<?php echo $option_row; ?>"><?php echo $product_option['name']; ?>&nbsp;<img src="view/image/delete.png" alt="" onclick="$('#vtabs a:first').trigger('click'); $('#option-<?php echo $option_row; ?>').remove(); $('#tab-option-<?php echo $option_row; ?>').remove(); return false;" /></a>
                            <?php $option_row++; ?>
                        <?php } ?>
                        <span id="option-add">
                            <input name="option" value="" style="width: 130px;" />
                            &nbsp;<img src="view/image/add.png" alt="<?php echo $button_add_option; ?>" title="<?php echo $button_add_option; ?>" />
                        </span>
                    </div>
                    <?php $option_row = 0; ?>
                    <?php $option_value_row = 0; ?>

                    <script type="text/javascript">
                        var option_value_id = [];
                    </script>

                    <?php if ($product_options) { ?>
                    <?php foreach ($product_options as $product_option) { ?>
                    <div id="tab-option-<?php echo $option_row; ?>" class="vtabs-content">
                        <input type="hidden" name="product_option[<?php echo $option_row; ?>][product_option_id]" value="<?php echo $product_option['product_option_id']; ?>" />
                        <input type="hidden" name="product_option[<?php echo $option_row; ?>][name]" value="<?php echo $product_option['name']; ?>" />
                        <input type="hidden" name="product_option[<?php echo $option_row; ?>][option_id]" value="<?php echo $product_option['option_id']; ?>" />
                        <input type="hidden" name="product_option[<?php echo $option_row; ?>][type]" value="<?php echo $product_option['type']; ?>" />
                        <table class="form">
                            <tr>
                                <td><?php echo $entry_required; ?></td>
                                <td><select name="product_option[<?php echo $option_row; ?>][required]">
                                        <?php if ($product_option['required']) { ?>
                                        <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                                        <option value="0"><?php echo $text_no; ?></option>
                                        <?php } else { ?>
                                        <option value="1"><?php echo $text_yes; ?></option>
                                        <option value="0" selected="selected"><?php echo $text_no; ?></option>
                                        <?php } ?>
                                    </select></td>
                            </tr>
                            <?php if ($product_option['type'] == 'text') { ?>
                            <tr>
                                <td><?php echo $entry_option_value; ?></td>
                                <td><input type="text" name="product_option[<?php echo $option_row; ?>][option_value]" value="<?php echo $product_option['option_value']; ?>" /></td>
                            </tr>
                            <?php } ?>
                            <?php if ($product_option['type'] == 'textarea') { ?>
                            <tr>
                                <td><?php echo $entry_option_value; ?></td>
                                <td><textarea name="product_option[<?php echo $option_row; ?>][option_value]" cols="40" rows="5"><?php echo $product_option['option_value']; ?></textarea></td>
                            </tr>
                            <?php } ?>
                            <?php if ($product_option['type'] == 'file') { ?>
                            <tr style="display: none;">
                                <td><?php echo $entry_option_value; ?></td>
                                <td><input type="text" name="product_option[<?php echo $option_row; ?>][option_value]" value="<?php echo $product_option['option_value']; ?>" /></td>
                            </tr>
                            <?php } ?>
                            <?php if ($product_option['type'] == 'date') { ?>
                            <tr>
                                <td><?php echo $entry_option_value; ?></td>
                                <td><input type="text" name="product_option[<?php echo $option_row; ?>][option_value]" value="<?php echo $product_option['option_value']; ?>" class="date" /></td>
                            </tr>
                            <?php } ?>
                            <?php if ($product_option['type'] == 'datetime') { ?>
                            <tr>
                                <td><?php echo $entry_option_value; ?></td>
                                <td><input type="text" name="product_option[<?php echo $option_row; ?>][option_value]" value="<?php echo $product_option['option_value']; ?>" class="datetime" /></td>
                            </tr>
                            <?php } ?>
                            <?php if ($product_option['type'] == 'time') { ?>
                            <tr>
                                <td><?php echo $entry_option_value; ?></td>
                                <td><input type="text" name="product_option[<?php echo $option_row; ?>][option_value]" value="<?php echo $product_option['option_value']; ?>" class="time" /></td>
                            </tr>
                            <?php } ?>
                        </table>
                        <?php if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') { ?>
                        <table id="option-value<?php echo $option_row; ?>" class="list">
                            <thead>
                                <tr>
                                    <td class="left"><?php echo $entry_option_value; ?></td>
                                    <td class="right"><?php echo $entry_quantity; ?></td>
                                    <td class="left"><?php echo $entry_subtract; ?></td>
                                    <td class="right"><?php echo $entry_price; ?></td>
                                    <td class="right"><?php echo $entry_option_points; ?></td>
                                    <td class="right"><?php echo $entry_weight; ?></td>
                                    <td class="right"><?php echo $entry_sort_order; ?></td>
                                    <td></td>
                                </tr>
                            </thead>
                            <?php foreach ($product_option['product_option_value'] as $product_option_value) { ?>

                            <tbody id="option-value-row<?php echo $option_value_row; ?>">
                                <tr>
                                    <td class="left">
                                        <select name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][option_value_id]">
                                            <?php if (isset($option_values[$product_option['option_id']])) { ?>
                                            <?php foreach ($option_values[$product_option['option_id']] as $option_value) { ?>
                                            <?php if ($option_value['option_value_id'] == $product_option_value['option_value_id']) { ?>
                                                <script type="text/javascript">
                                                    option_value_id[<?php echo $option_row; ?>] = <?php echo $option_value['option_value_id']; ?>;
                                                </script>

                                                <option value="<?php echo $option_value['option_value_id']; ?>" selected="selected"><?php echo $option_value['name']; ?></option>
                                            <?php } else { ?>
                                                <option value="<?php echo $option_value['option_value_id']; ?>"><?php echo $option_value['name']; ?></option>
                                            <?php } ?>
                                            <?php } ?>
                                            <?php } ?>
                                        </select>
                                        <input type="hidden" name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][product_option_value_id]" value="<?php echo $product_option_value['product_option_value_id']; ?>" /></td>
                                    <td class="right"><input type="text" name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][quantity]" value="<?php echo $product_option_value['quantity']; ?>" size="3" /></td>
                                    <td class="left"><select name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][subtract]">
                                            <?php if ($product_option_value['subtract']) { ?>
                                            <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                                            <option value="0"><?php echo $text_no; ?></option>
                                            <?php } else { ?>
                                            <option value="1"><?php echo $text_yes; ?></option>
                                            <option value="0" selected="selected"><?php echo $text_no; ?></option>
                                            <?php } ?>
                                        </select></td>
                                    <td class="right"><select name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][price_prefix]">
                                            <?php if ($product_option_value['price_prefix'] == '+') { ?>
                                            <option value="+" selected="selected">+</option>
                                            <?php } else { ?>
                                            <option value="+">+</option>
                                            <?php } ?>
                                            <?php if ($product_option_value['price_prefix'] == '-') { ?>
                                            <option value="-" selected="selected">-</option>
                                            <?php } else { ?>
                                            <option value="-">-</option>
                                            <?php } ?>
                                        </select>
                                        <input type="text" name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][price]" value="<?php echo $product_option_value['price']; ?>" size="5" /></td>
                                    <td class="right"><select name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][points_prefix]">
                                            <?php if ($product_option_value['points_prefix'] == '+') { ?>
                                            <option value="+" selected="selected">+</option>
                                            <?php } else { ?>
                                            <option value="+">+</option>
                                            <?php } ?>
                                            <?php if ($product_option_value['points_prefix'] == '-') { ?>
                                            <option value="-" selected="selected">-</option>
                                            <?php } else { ?>
                                            <option value="-">-</option>
                                            <?php } ?>
                                        </select>
                                        <input type="text" name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][points]" value="<?php echo $product_option_value['points']; ?>" size="5" /></td>
                                    <td class="right"><select name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][weight_prefix]">
                                            <?php if ($product_option_value['weight_prefix'] == '+') { ?>
                                            <option value="+" selected="selected">+</option>
                                            <?php } else { ?>
                                            <option value="+">+</option>
                                            <?php } ?>
                                            <?php if ($product_option_value['weight_prefix'] == '-') { ?>
                                            <option value="-" selected="selected">-</option>
                                            <?php } else { ?>
                                            <option value="-">-</option>
                                            <?php } ?>
                                        </select>
                                        <input type="text" name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][weight]" value="<?php echo $product_option_value['weight']; ?>" size="5" /></td>
                                    <td class="right">
                                        <input type="text" name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][sort_order]"  size="5" value="<?php echo $product_option_value['sort_order']; ?>" />
                                    </td>
                                    <?php $option_value_id = 'option_value_id'; ?>
                                    <?php $product_option_value_id = 'product_option_value_id'; ?>
                                    <?php $product_option_id = 'product_option_id'; ?>
                                    <td class="left"><a class="button" onclick="$('#option-value-row<?php echo $option_value_row; ?>').remove();"><?php echo $button_remove; ?></a></td>
                                </tr>
                            </tbody>
                            <?php $option_value_row++; ?>
                            <?php } ?>
                            <tfoot>
                                <tr>
                                    <td colspan="7"></td>
                                    <td class="left">
                                        <a onclick="addOptionValue('<?php echo $option_row; ?>', '<?php echo $option_value_row; ?>');" class="button"><?php echo $button_add_option_value; ?></a></td>
                                </tr>
                            </tfoot>
                        </table>
                            <select id="option-values<?php echo $option_row; ?>" style="display: none;">
                            <?php if (isset($option_values[$product_option['option_id']])) { ?>
                            <?php foreach ($option_values[$product_option['option_id']] as $option_value) { ?>
                                <option id="option_value_row_<?php echo $option_row; ?>_<?php echo $option_value['option_value_id']; ?>" value="<?php echo $option_value['option_value_id']; ?>"><?php echo $option_value['name']; ?></option>
                            <?php } ?>
                            <?php } ?>
                        </select>
                        <?php } ?>
                    </div>
                    <?php $option_row++; ?>
                    <?php } ?>
                    <?php } ?>
                </div>

                <div id="tab-discount">
                    <table id="discount" class="list">
                        <thead>
                            <tr>
                                <td class="left"><?php echo $entry_customer_group; ?></td>
                                <td class="right"><?php echo $entry_quantity; ?></td>
                                <td class="right"><?php echo $entry_priority; ?></td>
                                <td class="right"><?php echo $entry_price; ?></td>
                                <td class="left"><?php echo $entry_date_start; ?></td>
                                <td class="left"><?php echo $entry_date_end; ?></td>
                                <td></td>
                            </tr>
                        </thead>
                        <?php $discount_row = 0; ?>
                        <?php foreach ($product_discounts as $product_discount) { ?>
                        <tbody id="discount-row<?php echo $discount_row; ?>">
                            <tr>
                                <td class="left"><select name="product_discount[<?php echo $discount_row; ?>][customer_group_id]">
                                        <?php foreach ($customer_groups as $customer_group) { ?>
                                        <?php if ($customer_group['customer_group_id'] == $product_discount['customer_group_id']) { ?>
                                        <option value="<?php echo $customer_group['customer_group_id']; ?>" selected="selected"><?php echo $customer_group['name']; ?></option>
                                        <?php } else { ?>
                                        <option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>
                                        <?php } ?>
                                        <?php } ?>
                                    </select></td>
                                <td class="right"><input type="text" name="product_discount[<?php echo $discount_row; ?>][quantity]" value="<?php echo $product_discount['quantity']; ?>" size="2" /></td>
                                <td class="right"><input type="text" name="product_discount[<?php echo $discount_row; ?>][priority]" value="<?php echo $product_discount['priority']; ?>" size="2" /></td>
                                <td class="right"><input type="text" name="product_discount[<?php echo $discount_row; ?>][price]" value="<?php echo $product_discount['price']; ?>" /></td>
                                <td class="left"><input type="text" name="product_discount[<?php echo $discount_row; ?>][date_start]" value="<?php echo $product_discount['date_start']; ?>" class="date" /></td>
                                <td class="left"><input type="text" name="product_discount[<?php echo $discount_row; ?>][date_end]" value="<?php echo $product_discount['date_end']; ?>" class="date" /></td>
                                <td class="left"><a onclick="$('#discount-row<?php echo $discount_row; ?>').remove();" class="button"><?php echo $button_remove; ?></a></td>
                            </tr>
                        </tbody>
                        <?php $discount_row++; ?>
                        <?php } ?>
                        <tfoot>
                            <tr>
                                <td colspan="6"></td>
                                <td class="left"><a onclick="addDiscount();" class="button"><?php echo $button_add_discount; ?></a></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div id="tab-special">
                    <table id="special" class="list">
                        <thead>
                            <tr>
                                <td class="left"><?php echo $entry_customer_group; ?></td>
                                <td class="right"><?php echo $entry_priority; ?></td>
                                <td class="right"><?php echo $entry_price; ?></td>
                                <td class="left"><?php echo $entry_date_start; ?></td>
                                <td class="left"><?php echo $entry_date_end; ?></td>
                                <td></td>
                            </tr>
                        </thead>
                        <?php $special_row = 0; ?>
                        <?php foreach ($product_specials as $product_special) { ?>
                        <tbody id="special-row<?php echo $special_row; ?>">
                            <tr>
                                <input type="hidden" name="product_special[<?php echo $special_row; ?>][product_special_id]" value="<?php echo $product_special['product_special_id']; ?>">
                                <td class="left">
                                    <select name="product_special[<?php echo $special_row; ?>][customer_group_id]">
                                        <?php foreach ($customer_groups as $customer_group) { ?>
                                        <?php if ($customer_group['customer_group_id'] == $product_special['customer_group_id']) { ?>
                                        <option value="<?php echo $customer_group['customer_group_id']; ?>" selected="selected"><?php echo $customer_group['name']; ?></option>
                                        <?php } else { ?>
                                        <option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>
                                        <?php } ?>
                                        <?php } ?>
                                    </select></td>
                                <td class="right"><input type="text" name="product_special[<?php echo $special_row; ?>][priority]" value="<?php echo $product_special['priority']; ?>" size="2" /></td>
                                <td class="right"><input type="text" name="product_special[<?php echo $special_row; ?>][price]" value="<?php echo $product_special['price']; ?>" /></td>
                                <td class="left"><input type="text" name="product_special[<?php echo $special_row; ?>][date_start]" value="<?php echo $product_special['date_start']; ?>" class="date" /></td>
                                <td class="left"><input type="text" name="product_special[<?php echo $special_row; ?>][date_end]" value="<?php echo $product_special['date_end']; ?>" class="date" /></td>
                                <td class="left"><a onclick="$('#special-row<?php echo $special_row; ?>').remove();" class="button"><?php echo $button_remove; ?></a></td>
                            </tr>
                        </tbody>
                        <?php $special_row++; ?>
                        <?php } ?>
                        <tfoot>
                            <tr>
                                <td colspan="5"></td>
                                <td class="left"><a onclick="addSpecial();" class="button"><?php echo $button_add_special; ?></a></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div id="tab-image">
                    <table id="images" class="list">
                        <thead>
                            <tr>
                                <td class="left"><?php echo $entry_image; ?></td>
                                <td class="right"><?php echo $entry_sort_order; ?></td>
                                <td></td>
                            </tr>
                        </thead>
                        <?php $image_row = 0; ?>
                        <?php foreach ($product_images as $product_image) { ?>
                        <tbody id="image-row<?php echo $image_row; ?>">
                            <tr>
                                <td class="left"><div class="image"><img src="<?php echo $product_image['thumb']; ?>" alt="" id="thumb<?php echo $image_row; ?>" />
                                        <input type="hidden" name="product_image[<?php echo $image_row; ?>][image]" value="<?php echo $product_image['image']; ?>" id="image<?php echo $image_row; ?>" />
                                        <br />
                                        <a onclick="image_upload('image<?php echo $image_row; ?>', 'thumb<?php echo $image_row; ?>');"><?php echo $text_browse; ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a onclick="$('#thumb<?php echo $image_row; ?>').attr('src', '<?php echo $no_image; ?>'); $('#image<?php echo $image_row; ?>').attr('value', '');"><?php echo $text_clear; ?></a></div></td>
                                <td class="right"><input type="text" name="product_image[<?php echo $image_row; ?>][sort_order]" value="<?php echo $product_image['sort_order']; ?>" size="2" /></td>
                                <td class="left"><a onclick="$('#image-row<?php echo $image_row; ?>').remove();" class="button"><?php echo $button_remove; ?></a></td>
                            </tr>
                        </tbody>
                        <?php $image_row++; ?>
                        <?php } ?>
                        <tfoot>
                            <tr>
                                <td colspan="2"></td>
                                <td class="left"><a onclick="addImage();" class="button"><?php echo $button_add_image; ?></a></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div id="tab-product_tab">
                    <div id="vtab-product_tab" class="vtabs">
                        <?php $product_tab_row = 0; ?>

                        <?php foreach ($product_tabs as $product_tab) { ?>
                            <a href="#tab-product_tab-<?php echo $product_tab_row; ?>" id="product_tab-<?php echo $product_tab_row; ?>"><?php echo $product_tab['name']; ?>&nbsp; <img src="view/image/delete.png" alt="" onclick="$('#tab-product_tab-<?php echo $product_tab_row; ?>').remove(); $('#product_tab-<?php echo $product_tab_row; ?>').remove(); $('#vtab-product_tab a:first').trigger('click'); return false;" /></a>
                            <?php $product_tab_row++; ?>
                        <?php } ?>

                        <span id="product_tab-add">
                        <input name="producttab" value="" style="width: 130px;" />
                        &nbsp;<img src="view/image/add.png" alt="<?php echo $button_add_product_tab; ?>" title="<?php echo $button_add_product_tab; ?>" /></span>
                    </div>

                    <?php $product_tab_row = 0; ?>

                    <?php foreach ($product_tabs as $product_tab) { ?>
                        <div id="tab-product_tab-<?php echo $product_tab_row; ?>" class="vtabs-content">
                            <input type="hidden" name="product_tab[<?php echo $product_tab_row; ?>][name]" value="<?php echo $product_tab['name']; ?>" />
                            <input type="hidden" name="product_tab[<?php echo $product_tab_row; ?>][tab_id]" value="<?php echo $product_tab['tab_id']; ?>" />
                            <table class="form">
                                <tr>
                                    <td>
                                        <div id="product_tab-<?php echo $product_tab_row; ?>-languages" class="htabs">
                                            <?php foreach ($languages as $language) { ?>
                                                <a href="#product_tab-<?php echo $product_tab_row; ?>-languages-<?php echo $language['language_id']; ?>"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a>
                                            <?php } ?>
                                        </div>

                                        <?php foreach ($languages as $language) { ?>
                                            <div id="product_tab-<?php echo $product_tab_row; ?>-languages-<?php echo $language['language_id']; ?>">
                                                <textarea name="product_tab[<?php echo $product_tab_row; ?>][product_tab_description][<?php echo $language['language_id']; ?>][text]" cols="40" rows="5"><?php echo isset($product_tab['product_tab_description'][$language['language_id']]) ? $product_tab['product_tab_description'][$language['language_id']]['text'] : ''; ?></textarea>
                                            </div>
                                        <?php } ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <?php $product_tab_row++; ?>
                    <?php } ?>
                </div>

                <div id="tab-reward">
                    <table class="form">
                        <tr>
                            <td><?php echo $entry_points; ?></td>
                            <td><input type="text" name="points" value="<?php echo $points; ?>" /></td>
                        </tr>
                    </table>
                    <table class="list">
                        <thead>
                            <tr>
                                <td class="left"><?php echo $entry_customer_group; ?></td>
                                <td class="right"><?php echo $entry_reward; ?></td>
                            </tr>
                        </thead>
                        <?php foreach ($customer_groups as $customer_group) { ?>
                        <tbody>
                            <tr>
                                <td class="left"><?php echo $customer_group['name']; ?></td>
                                <td class="right"><input type="text" name="product_reward[<?php echo $customer_group['customer_group_id']; ?>][points]" value="<?php echo isset($product_reward[$customer_group['customer_group_id']]) ? $product_reward[$customer_group['customer_group_id']]['points'] : ''; ?>" /></td>
                            </tr>
                        </tbody>
                        <?php } ?>
                    </table>
                </div>

                <div id="tab-design">
                    <table class="list">
                        <thead>
                            <tr>
                                <td class="left"><?php echo $entry_store; ?></td>
                                <td class="left"><?php echo $entry_layout; ?></td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="left"><?php echo $text_default; ?></td>
                                <td class="left"><select name="product_layout[0][layout_id]">
                                        <option value=""></option>
                                        <?php foreach ($layouts as $layout) { ?>
                                        <?php if (isset($product_layout[0]) && $product_layout[0] == $layout['layout_id']) { ?>
                                        <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
                                        <?php } else { ?>
                                        <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
                                        <?php } ?>
                                        <?php } ?>
                                    </select></td>
                            </tr>
                        </tbody>
                        <?php foreach ($stores as $store) { ?>
                        <tbody>
                            <tr>
                                <td class="left"><?php echo $store['name']; ?></td>
                                <td class="left"><select name="product_layout[<?php echo $store['store_id']; ?>][layout_id]">
                                        <option value=""></option>
                                        <?php foreach ($layouts as $layout) { ?>
                                        <?php if (isset($product_layout[$store['store_id']]) && $product_layout[$store['store_id']] == $layout['layout_id']) { ?>
                                        <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
                                        <?php } else { ?>
                                        <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
                                        <?php } ?>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>
                        </tbody>
                        <?php } ?>
                    </table>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
var manufacturers = <?php echo json_encode($manufacturers) ?>;
var class_prod = "odd";
var fabric_option_count = <?php echo count($product_fabric); ?>;
var fabric_option_value_count = 0;
var fabric_option_value_product = [];
var table_image = '';
var price_prefixes = <?php echo json_encode($price_prefixes); ?>;
var price_afters = <?php echo json_encode($price_afters); ?>;

function getInputPrice(obj) {
    var html = '<div>';
    html += '   <select name="product_price[price_prefix_id][]" onchange="getInputPrice(this)" >';
    html += '   <option value="0"><?php echo $text_none; ?></option>';

    $(price_prefixes).each(function() {
        html += '<option value="' + $(this).attr('price_prefix_id') + '">' + $(this).attr('name') + '</option>';
    });

    html += '   </select>';
    html += '   <input type="text" name="product_price[product_price][]" >';
    html += '</div>';

    $(obj).attr('onchange', '');
    $(obj).parent().after(html);
}

function deleteOptionValue(option_value_id) {
    $('#fabric_option_value_' + option_value_id).remove();
}

function deleteFabricProduct(option_value_id, product_id) {
    $('#option_value_' + option_value_id + '_product_' + product_id).remove();
}

function deleteOption(option_id) {
    $('.wrapp_option_' + option_id).remove();
}

function listProductFabric(manufacturer_id, option_value_id, fabric_option_value_count, fabric_option_count) {
    var url = "index.php?route=catalog/product/getProduct&token=" + token;
    
    if (manufacturer_id == 0) {
        return false;
    }

    $.get(
        url,
        "manufacturer_id=" + manufacturer_id,
        function (product) {
            if (product.type == 'error') {
                alert(product.message);
                return(false);
            } else {
                $('#fabric_option_value_' + option_value_id + ' > .entry > #list_product_' + option_value_id).remove();
                var div = '<div class="scrollbox_product" id="list_product_' + option_value_id + '">';

                $(product.data).each(function() {
                    class_prod = (class_prod == 'even' ? 'odd' : 'even');

                    div += '<div id="product_id" class="' + class_prod + '">';
                    div += '    <input type="checkbox" onclick="addFabricProduct(this, ' + option_value_id + ', ' + fabric_option_value_count + ', ' + fabric_option_count + ', ' + $(this).attr('product_id') + ', &quot;' + $(this).attr('name') + '&quot;, &quot;' + $(this).attr('model') + '&quot;);" >';
                    div += '(' + $(this).attr('model') + ') ' + $(this).attr('name');
                    div += '</div>';
                });
                div += '</div>';

                $('#fabric_option_value_' + option_value_id + ' > .entry > .select_manufacturer_' + option_value_id).after(div);
            }
        },
        "json"
    );
}

function addFabricProduct(obj, option_value_id, fabric_option_value_count, fabric_option_count, product_id, name, model) {
    if ($('#option_value_' + option_value_id + '_product_' + product_id).length != 0 || obj.checked == false) {
        if (obj.checked == false) {
            $('#option_value_' + option_value_id + '_product_' + product_id).remove();
        }

        return false;
    }

    var product_checked = '';
    var html = '';

    class_prod = (class_prod == 'even' ? 'odd' : 'even');

    product_checked += '<div id="option_value_' + option_value_id + '_product_' + product_id + '" class="' + class_prod + '">';
    product_checked += '     <input type="hidden" name="product_fabric[' + fabric_option_count + '][product_fabric_option_value][' + fabric_option_value_count + '][product_fabric_option_value_product][' + fabric_option_value_product + '][product_id]" value="' + product_id + '">(' + model + ') ' + name;
    product_checked += '     <span class="img_delete_option" onclick="deleteFabricProduct(' + option_value_id + ', ' + product_id + ');"></span>';
    product_checked += '     <input type="hidden" name="product_fabric[' + fabric_option_count + '][product_fabric_option_value][' + fabric_option_value_count + '][product_fabric_option_value_product][' + fabric_option_value_product + '][product_fabric_option_value_product_id]" value="" >';
    product_checked += '</div>';
    fabric_option_value_product += 1;

    if ($('#checked_product_' + option_value_id).length == 0) {
        html += '<div class="scrollbox" id="checked_product_' + option_value_id + '" >';
        html += product_checked;
        html += '</div>';
        $('#list_product_' + option_value_id).after(html);
    } else {
        $('#checked_product_' + option_value_id).append(product_checked);
    }
}

function addFabricOptionValue(option_id, fabric_option_count) {
    var option_value_id = $('#select_option_value_' + option_id).val();

    if ($('#fabric_option_value_' + $('#select_option_value_' + option_id).val()).length != 0 || option_value_id == 0) {
        return false;
    }

    html = '<div class="option_value inactive" id="fabric_option_value_' + option_value_id + '">';
    html += '<input type="hidden" name="product_fabric[' + fabric_option_count + '][product_fabric_option_value][' + fabric_option_value_count + '][product_fabric_option_value_id]" value="">';
    html += '<input type="hidden" name="product_fabric[' + fabric_option_count + '][product_fabric_option_value][' + fabric_option_value_count + '][option_value_id]" value="' + option_value_id + '">';
    html +=    '<div class="title" onclick="slide(this);">';
    html +=         '<h3>' + $('#select_option_value_' + option_id + ' :selected').html() + '</h3>';
    html +=         '<span class="img_active"></span>';
    html +=         '<span class="img_delete" onclick="deleteOptionValue(' + option_value_id + ');"></span>';
    html +=     '</div>';
    html +=     '<div class="entry">';
    html +=     '   <div class="select_manufacturer_' + option_value_id + '">';
    html +=     '       <select onchange="listProductFabric(this.options[this.selectedIndex].value, ' + option_value_id + ', ' + fabric_option_value_count + ', ' + fabric_option_count + ');">';
    html +=     '           <option value="0">Не выбрано</option>';

    $(manufacturers).each(function() {
        html +=     '      <option value="' + $(this).attr('manufacturer_id') + '">' + $(this).attr('name') + '</option>';
    });

    html +=     '       </select>';
    html +=     '   </div>';
    html +=     '</div>';
    html += '</div>';

    $('#select_option_value_' + option_id).before(html);
    fabric_option_value_count += 1;
}

function addFabricOption() {
    var option_id = $('#select_option_id').val();
    var data_option = getOptionValues(option_id);

    if ($('.wrapp_option_' + option_id).length != 0 || option_id == 0) {
        return false;
    }

    html = '<div class="wrapp_option_' + option_id + '">';
    html += '   <input type="hidden" name="product_fabric[' + fabric_option_count + '][product_fabric_option_id]" value="">';
    html += '   <input type="hidden" name="product_fabric[' + fabric_option_count + '][option_id]" value="' + option_id + '">';
    html += '   <div class="title_option">';
    html += '       <span class="img_delete_option" onclick="deleteOption(' + option_id + ');"></span>';
    html +=         $('#select_option_id :selected').html();
    html += '   </div>';
    
    html += '   <select id="select_option_value_' + option_id + '">';
    html += '       <option value="0">Нет</option>';

    $(data_option.options_value).each(function() {
       html += '    <option value=' + $(this).attr('option_value_id') + '>' + $(this).attr('name') + '</option>';
    });

    html += '   </select>';
    html += '   <a class="button" onclick="addFabricOptionValue(' + option_id + ', ' + fabric_option_count + ');">';
    html += '       Добавить значение опции';
    html += '   </a>';
    html += '</div>';

    $('.wrapp_list_option').append(html);
    fabric_option_count += 1;
}

function slide(obj) {
    $(obj).next('.entry').slideToggle();
    $(obj).parent().toggleClass('inactive');
}

function deleteProduct(obj) {
    $(obj).parent().remove();
}

function box_product(obj, id, model, name) {
    var html = '';

    if ($('#box_product').length != 0 && obj.checked == false) {
        $('#box_product').find('#product_id_' + id).remove();
        return;
    }

    class_prod = (class_prod == 'even' ? 'odd' : 'even');

    if ($('#box_product').length == 0) {
        html += '<div class="scrollbox" id="box_product">';
    }

    if ($('#product_id_' + id).length == 0) {
        html += '   <div id="product_id_' + id + '" class="' + class_prod + '">';
        html += '       <input type="hidden" name="product_copy_category[]" value="' + id + '">';
        html +=         '(' + model + ') ' + name;
        html += '       <span class="img_delete_option" onclick="deleteProduct(this);"></span>';
        html += '   </div>';
    }

    if ($('#box_product').length == 0) {
        html += '</div>';
        $(obj).parent().parent().parent().parent().append(html);
    } else {
        $(obj).parent().parent().parent().parent().find('#box_product').append(html);
    }
}

function listProduct(manufacturer_id, obj, type) {
    if (manufacturer_id == 0) {
        return(false);
    }
    
    var url  = "index.php?route=catalog/product/getProduct&token=" + token;

    $.get(
        url,
        "manufacturer_id=" + manufacturer_id,
        function (product) {
            if (product.type == 'error') {
                alert(product.message);
                return false;
            } else {
                var html = '<div class="product_list">'
                html += '    <div class="scrollbox" >';
                class_prod = 'odd';

                $(product.data).each(function() {
                    class_prod = (class_prod == 'even' ? 'odd' : 'even');

                    html += '  <div id="product_id" class="' + class_prod + '">';

                    if (type == 0) {
                        html += '    <input type="checkbox" id="product_data" name="product_copy[]" value="' + $(this).attr('product_id') + '" >';
                    } else if (type == 'table') {
                        html += '    <input type="checkbox" id="product_data" name="product_copy_table[]" value="' + $(this).attr('product_id') + '" >';
                    } else if (type == 'related') {
                        html += '    <input type="checkbox" id="product_data" name="product_copy_related[]" value="' + $(this).attr('product_id') + '" >';
                    } else if (type == 'category') {
                        html += '    <input type="checkbox" onclick="box_product(this, ' + $(this).attr('product_id') + ', \'' + $(this).attr('model') + '\', \'' + $(this).attr('name') + '\');" id="product_data" >';
                    }

                    html +=          "(" + $(this).attr('model') + ") " + $(this).attr('name');
                    html += '  </div>';
                });

                html += '    </div>';
                html += '    <a onclick="$(this).parent().find(&quot;:checkbox&quot;).attr(&quot;checked&quot;, true);">Выделить всё</a>';
                html += '    <a onclick="$(this).parent().find(&quot;:checkbox&quot;).attr(&quot;checked&quot;, false);">Снять выделение</a>';
                html += '</div>';

                $(obj).parent().parent().find('.product_list').remove();
                $(obj).parent().after(html);
            }
        },
        "json"
    );
}

</script>
<script type="text/javascript"><!-- 
var token = "<?php echo $_GET['token']; ?>";
var product_id = "<?php echo $_GET['product_id']; ?>";
var options = <?php echo json_encode($options); ?>;

//--></script>
<script type="text/javascript">
//<![CDATA[
var count_option_value = 0;

function getOptionValues(option_id) {
    var url  = "index.php?route=catalog/product/getOptionValues&token=" + token + '&option_id=' + option_id;
    var data = null;

    var data = $.ajax({
        type: "GET",
        url: url,
        dataType: 'json',
        async: false
    }).responseText;

    console.log($.parseJSON(data));
    return $.parseJSON(data);
}

function updateId(table, old_obj, option_value_id, option_id) {
    var new_id = 'table_' + table + '_option_value_id_' + option_value_id;
    var td_id_equal = document.getElementsByTagName('td');
    var class_option_value_id = 'table_' + table + '_row_' + option_value_id;
    var class_main = 'table_' + table + '_option_id_' + option_id + '_main';
    var class_last_td = /table_(\d+)_option_id_(\d+)_tr_(\d+)_last/ig;
    var old_obj_id = old_obj.id;
    
    if ($('#' + new_id).length != 0 || option_value_id == 0) {
        return false;
    }

    if (old_obj.className == class_main) {
        $(old_obj).attr('data-option-value-id', option_value_id);

        $(old_obj.parentNode).each(function() {
            if ($('.' + class_option_value_id).length == 0) {
                $(this).attr('class', class_option_value_id);

                $($(this).children()).each(function() {
                    if ($(this).attr('class') != undefined) {
                        if ($(this).attr('class').match(class_last_td) != null) {
                            $(this).attr('class', 'table_' + table + '_option_id_' + $(this).attr('data-option-id') + '_tr_' + option_value_id + '_last');
                        }

                        if ($(this).attr('class').match(/table_(\d+)_delete_row_(\d+)_not_select/ig) != null || $(this).attr('class').match(/table_(\d+)_delete_row_(\d+)/ig) != null) {
                            $(this).attr('class', 'table_' + table + '_delete_row_' + option_value_id);
                        }
                    }
                });
            }
        });
    }

    $('#' + old_obj_id + ' > a.delete_col').each(function() {
        $(this).attr('onclick', 'deleteCol("' + new_id + '", ' + option_id + ', ' + table + ')');
    });

    $(td_id_equal).each(function() {
        if ($(this).attr("id") != undefined) {
            if ($(this).attr('id') == old_obj_id) {
                $(this).attr('id', new_id);

                if ($(this).attr('class') == 'table_' + table + '_option_id_' + option_id) {
                    $(this).attr('data-option-value-id', option_value_id);
                }
            }
        }
    });
    
    addName(table);
}

function deleteTable(number_table) {
    $('#table_' + number_table + '_wrapp').remove();
}

function deleteRow(obj, table) {
    $(obj.parentNode.parentNode).remove();

    if ($('.table_' + table + '_main_option_vertical').length != 0) {
        $('.table_' + table + '_main_option_vertical').each(function() {
            if ($('.table_' + table + '_option_id_' + $(this).attr('data-option-id') + '_main').length == 0) {
                $('.table_' + table + '_delete_row').remove();
            }
        });
    } else {
        $('.table_' + table + '_delete_row').remove();
    }
}

function deleteCol(id, option_id, table) {
    var horizont_option_id = $('#table_' + table + '_horizont_option_id_' + option_id);
    var colSpan = horizont_option_id.attr('colspan');
    var count = 0;
    var main_option = mainOptionVertical(table);
    var thead_td = '<td class="table_' + table + '_price" rowspan="3">Цена</td>';
    var price_input = '';

    if (colSpan == undefined || colSpan == 2) {
        horizont_option_id.remove();
        $('.table_' + table + '_option_id_' + option_id).remove();
        $('#table_' + table + '_option_value_id_' + option_id + '_not_select').remove();
        $('.table_' + table + '_option_id_' + option_id + '_delete_col_last').remove();
    } else {
        colSpan -= 1;
        horizont_option_id.attr('colspan', colSpan);
    }

    var td_id_equal = document.getElementsByTagName('td');

    $(td_id_equal).each(function() {
        if ($(this).attr('id') == id) {
            var classLastOptionId = 'table_' + table + '_option_id_' + option_id + '_tr_' + main_option[count] + '_last';
            var classLastOptionIdNotSelect = classLastOptionId + '_not_select';
            var classLastOptionIdDelete = 'table_' + table + '_option_id_' + option_id + '_delete_col_last';
            var classOptionId = null;

            if ($(this).attr('class') != undefined) {
                if ($(this).attr('class') == classLastOptionId) {
                    classOptionId = classLastOptionId;
                }

                if ($(this).attr('class') == classLastOptionIdNotSelect) {
                    classOptionId = classLastOptionIdNotSelect;
                }

                if ($(this).attr('class') == classOptionId && $(this).prev().attr('data-option-id') == option_id) {
                    $(this).prev().attr('colspan', '2');
                    $(this).prev().attr('class', classOptionId);
                    count += 1;
                }
            }

            if ($(this).attr('class') == classLastOptionIdDelete && $(this).prev().attr('data-option-id') == option_id) {
                $(this).prev().attr('colspan', '2');
                $(this).prev().attr('class', classLastOptionIdDelete);
            }

            $(this).remove();
        }
    });

    if ( $('.table_' + table + '_delete_row').children().length <= 1 ) {
        $('.table_' + table + '_delete_row').remove();
    }

    if ($('.table_' + table + '_horizont').length == 0) {
        $('.table_' + table + '_first_row_0').remove();
    }

    if ($('.table_' + table + '_horizont').length == 0 && $('.table_' + table + '_vertical').length != 0) {
        option_id = null;

        price_input = '<td>';
        price_input += price_about(price_prefixes, 'price_prefix');
        price_input += '<input type="number" class="price">';
        price_input += price_about(price_afters, 'price_after');
        price_input += '<input type="hidden" class="product_table_option_value_price_id">';
        price_input += '</td>';

        insertSelect(table, option_id, price_input, thead_td, true, false);
    }

    addName(table);
}

function deleteColVertical(table, option_id, class_option_id) {
    var td_id_equal = document.getElementsByTagName('td');
    
    if (class_option_id == 'table_' + table + '_option_id_' + option_id + '_main') {
        if ($('.table_' + table + '_main_option_vertical').length != 0) {
            $('.table_' + table + '_main_option_vertical').each(function() {
                $('.table_' + table + '_option_id_' + $(this).attr('data-option-id') + '_main').each(function() {
                    $(this).parent().remove();
                });
            });
        }

        $('.table_' + table + '_delete_row').remove();

        $('.table_' + table + '_vertical').each(function() {
            $(this).remove();
        });

        $('.table_' + table + '_price').remove();
    }

    $('.' + class_option_id + '_delete').remove();
    $('#table_' + table + '_option_value_id_' + option_id + '_not_select').remove();
    $('#table_' + table + '_vertical_option_id_' + option_id).remove();

    $(td_id_equal).each(function() {
        if ($(this).attr('class') == class_option_id) {
            $(this).remove();
        }
    });

    if ( $('.table_' + table + '_delete_row').children().length <= 1 ) {
        $('.table_' + table + '_delete_row').remove();
    }
}

function addRow(table) {
    if ($('.table_' + table + '_main_option_vertical').length != 0 || $('.table_' + table + '_first_row_0').length <= 0) {
        if ($('.table_' + table + '_vertical').length > 0 || $('.table_' + table + '_horizont').length > 0) {
            var td = '';
            var delete_td = '';
            var number_row = 0;
            var tr = null;
            var thead_td = '<td class="table_' + table + '_price" rowspan="3" >Цена</td>';
            var html = null;
            var first_option = null;

            if ($('.table_' + table + '_main_option_vertical').length != 0) {
                number_row = $('.table_' + table + '_main_option_vertical').attr('data-option-id');

                if ($('.table_' + table + '_first_row_' + number_row).length != 0) {     
                    return false;
                }
            }

            if ($('.table_' + table + '_horizont').length == 0 && $('.table_' + table + '_price').length == 0) {
                var option_id = null;
                insertSelect(table, option_id, html, thead_td, true, false);
            }

            $('.table_' + table + '_vertical').each(function() {
                var option_id = $(this).attr('data-option-id');
                var data = getOptionValues(option_id);
                var product_table_option = "product_table[table][" + table + "][option_id][" + option_id + "][product_table_option_value][" + count_option_value + "]";
                
                if (first_option == null) {
                    first_option = product_table_option;
                }

                var class_option_id = "table_" + table + "_option_id_" + option_id;
                count_option_value += 1;
                td += "<td ";

                if (option_id == number_row) {
                    class_option_id += '_main';
                    td += " id='table_" + table + "_option_value_id_" + option_id + "_not_select' data-option-value-id='" + option_id + "' ";
                }

                td += " class='" + class_option_id + "'  ><select class='option_value_id' name='" + product_table_option + "[option_value_id]' onchange='updateId(" + table + ", this.parentNode, this.options[this.selectedIndex].value, " + option_id + ");'>";
                td += '<option value="0">Нет</option>';

                $(data.options_value).each(function() {
                    td += "<option value='" +  $(this).attr('option_value_id') + "'>" + $(this).attr('name') + "</option>";
                });

                td += ' </select>';
                td += ' <input type="hidden" name="' + product_table_option + '[product_table_option_value_id]" class="product_table_option_value_id" ><input type="number" name="' + product_table_option + '[product_table_option_value_sort]" >';
                td += '</td>';
                
                delete_td += "<td class='" + class_option_id + "_delete' ><a class='button delete_col_vertical' onclick='deleteColVertical(" + table + ", " + option_id + ", \"" + class_option_id + "\");'>Удалить</a></td>";
            });
            
            if ($('.table_' + table + '_horizont').length == 0) {
                td += '<td>';
                td += price_about(price_prefixes, 'price_prefix');
                td += '<input type="number" class="price" /><input type="hidden"  class="product_table_option_value_price_id" >';
                td += price_about(price_afters, 'price_after');
                td += '</td>';
            }

            tr = '<tr class="table_' + table + '_first_row_' + number_row + '">';
            tr +=  '<td class="center">';

            if (number_row != 0) {
                tr +=    '<div class="image">';
                tr +=       '<img alt="" id="table_image_' + table_image + '" />';
                tr +=       '<input type="hidden" value="" id="table_image_input_' + table_image + '" ';

                if (first_option != null) {
                    tr +=     'name="' + first_option + '[product_table_option_value_image]"';
                }

                tr +=       ' /><br />';
                tr +=       '<a onclick="image_upload(\'table_image_input_' + table_image + '\', \'table_image_' + table_image + '\');">';
                tr +=           '<?php echo $text_browse; ?>';
                tr +=       '</a>';
                tr +=       '&nbsp;&nbsp;|&nbsp;&nbsp;';
                tr +=       '<a onclick="$(\'#table_image_' + table_image + '\').attr(\'src\', \'<?php echo $no_image; ?>\'); $(\'#table_image_input_' + table_image + '\').attr(\'value\', \'\');">';
                tr +=           '<?php echo $text_clear; ?>';
                tr +=       '</a>';
                tr +=   '</div>';
            }

            tr +=  '</td>';
            tr += td;
            table_image += 1;

            $('.table_' + table + '_horizont').each(function() {
                var option_id = $(this).attr('data-option-id');
                var obj_option_id = $('.table_' + table + '_option_id_' + option_id);
                var count = 1;

                if (obj_option_id.length != 1) {
                    $(obj_option_id).each(function() {
                        if (count < obj_option_id.length) {
                            delete_td += "<td id='" + $(this).attr('id') + "'";
                            tr += "<td id='" + $(this).attr('id') + "'";
                            
                            if (count == obj_option_id.length - 1) {
                                delete_td += " class='table_" + table + "_option_id_" + option_id + "_delete_col_last" + "' colspan='2' ";
                                tr += " class='table_" + table + "_option_id_" + option_id + "_tr_" + number_row + "_last_not_select" + "' colspan='2' ";
                            }
                            
                            delete_td += "data-option-id='" + option_id + "' ><a class='button delete_col' onclick='deleteCol(\"" + $(this).attr('id') + "\", " + option_id + ", " + table + ");'>Удалить</a></td>";
                            tr += " data-option-id='" + option_id + "'  ><input class='price' type='number' /><input type='hidden'  class='product_table_option_value_price_id' >";
                            tr += "</td>";
                        }
                        
                        count += 1;
                    });
                } else {
                    $(obj_option_id).each(function() {
                        delete_td += "<td class='table_" + table + "_option_id_" + option_id + "_delete_col_last" + "' id='" + $(this).attr('id') + "' data-option-id='" + option_id + "'><a class='button delete_col' onclick='deleteCol(\"" + $(this).attr('id') + "\", " + option_id + ", " + table + ");'>Удалить</a></td>";
                        tr += "<td class='table_" + table + "_option_id_" + option_id + "_tr_" + number_row + "_last_not_select" + "' id='" + $(this).attr('id') + "' data-option-id='" + option_id + "'><input class='price' type='number' /><input type='hidden'  class='product_table_option_value_price_id' ></td>"
                    });
                }
            });
            
            tr += "<td class='table_" + table +"_delete_row_" + number_row + "_not_select'><a class='button' onclick='deleteRow(this, " + table + ");'>Удалить</a></td>";
            tr += '</tr>';
            
            if ($('.table_' + table + '_delete_row').length == 0) {
                var delete_row = "<tr class='table_" + table + "_delete_row'><td></td>";

                delete_row += delete_td;
                delete_row += "</tr>";
                tr += delete_row;

                $("#table_" + table + "_tr_last").before(tr);
            } else {
                $(".table_" + table + "_delete_row").before(tr);
            }

            if (number_row == 0) {
                addName(table);
            }
        }
    }
}

function price_about(price_about, price_about_text) {
    var html_select = '';

    if (price_about) {
        html_select += '<select class="table_' + price_about_text + '">';
        html_select += '    <option value="0"><?php echo $text_no; ?></option>';

        $(price_about).each( function() {
            html_select += '<option value="' + $(this).attr(price_about_text + '_id') + '" >' + $(this).attr('name') + '</option>';
        });

        html_select += '</select>';
    }

    return html_select;
}

function addOption(option_id, position_vertical, table) {
    var vertical = 1;
    var product_table_option = "product_table[table][" + table + "][option_id][" + option_id + "]";

    if (document.getElementById('table_' + table + '_horizont_option_id_' + option_id) != undefined || document.getElementById('table_' + table + '_vertical_option_id_' + option_id) != undefined) {
        return false;
    }

    if (position_vertical == false && $('.table_' + table + '_price').length != 0) {
        return false;
    }

    if (position_vertical == false) {
        vertical = 0;
    }

    var name_option = null;
    var data = getOptionValues(option_id);

    for (var i in data.option_desc) {
        name_option = data.option_desc[i].name;
    }

    if (name_option == null) {
        return false;
    }
    
    html = getSelectOptionValueId(table, option_id, position_vertical);

    var input_hidden = "<input type='hidden' name='" + product_table_option + "[vertical]' value='" + vertical + "' /><input type='hidden' name='" + product_table_option + "[product_table_option_id]' value='' />";

    if (position_vertical == false) {
        $("#table_" + table + "_horizont_select").before("<td class='table_" + table + "_horizont' data-option-id='" + option_id + "' id='table_" + table + "_horizont_option_id_" + option_id + "'>" + name_option + input_hidden + "</td>");

        if (document.getElementById('table_' + table + '_tr_2') == undefined) {
            $("#table_" + table + "_tr_1").after("<tr id='table_" + table + "_tr_2'>" + html + "</tr>");
        } else {
            $("#table_" + table + "_tr_2").append(html);
        }

        insertInput(table, option_id, false, 1);
    } else {
        if ($('.table_' + table + '_first_row_0').length == 0) {
            var thead_td = "<td class='";

            if ($('.table_' + table + '_main_option_vertical').length == 0) {
                thead_td += "table_" + table + "_main_option_vertical ";
            }

            thead_td += "table_" + table + "_vertical' data-option-id='" + option_id + "' id='table_" + table + "_vertical_option_id_" + option_id + "' rowspan=\"3\">" + name_option + input_hidden + "</td>";

            insertSelect(table, option_id, html, thead_td, position_vertical, true);
        }
    }
}

function getSelectOptionValueId(table, option_id, position_vertical) {
    var data = getOptionValues(option_id);
    var product_table_option = "product_table[table][" + table + "][option_id][" + option_id + "]";
    var product_table_option_value = product_table_option + '[product_table_option_value][' + count_option_value + ']';
    var html = "<td class='table_" + table + "_option_id_" + option_id + "' ";
    
    if (position_vertical == false) {
        html += " id='table_" + table + "_option_value_id_" + option_id + "_not_select' ";
    }

    html += "><select name='" + product_table_option_value + "[option_value_id]' ";
    
    count_option_value += 1;

    if (position_vertical == false) {
        vertical = 0;
        html += ' onchange="addOptionValueTalbe(this, ' + option_id + ', ' + table + ', this.options[this.selectedIndex].value)"';
    }

    html += ' class="option_value_id" >';
    html += '<option value="0">Нет</option>';

    $(data.options_value).each(function() {
        html += "<option value='" +  $(this).attr('option_value_id') + "'>" + $(this).attr('name') + "</option>";
    });
    
    html += "</select>";
    html += '<input type="hidden" name="' + product_table_option_value + '[product_table_option_value_id]" class="product_table_option_value_id" >';
    html += '<input type="number" name="' + product_table_option_value + '[product_table_option_value_sort]">';
    html += "</td>";

    return html;
}

function addOptionValueTalbe(obj, option_id, table, option_value_id) {
    var html_option_value_id = 'table_' + table + '_option_value_id_' + option_value_id;
    
    if (document.getElementById(html_option_value_id) != undefined || option_value_id == 0) {
        return false;
    }
    
    if (obj.parentNode.id != 'table_' + table + '_option_value_id_' + option_id + '_not_select') {
        updateId(table, obj.parentNode, option_value_id, option_id);
        return false;
    }
    
    updateId(table, obj.parentNode, option_value_id, option_id);
    
    var product_table_option = "product_table[table][" + table + "][option_id][" + option_id + "][product_table_option_value][" + count_option_value + "]";
    count_option_value += 1;

    var data = getOptionValues(option_id);
    var html = "<td class='table_" + table + "_option_id_" + option_id + "' id='table_" + table + "_option_value_id_" + option_id + "_not_select'>";

    html += '<select  name="' + product_table_option + '[option_value_id]" class="option_value_id" ';
    html += 'onchange="addOptionValueTalbe(this, ' + option_id + ', ' + table + ', this.options[this.selectedIndex].value)"';
    html += ">";

    html += '<option value="0">Нет</option>';
    $(data.options_value).each(function() {
        html += "<option value='" +  $(this).attr('option_value_id') + "'>" + $(this).attr('name') + "</option>";
    });

    html += "</select>";
    html += '<input name="' + product_table_option + '[product_table_option_value_id]" type="hidden" class="product_table_option_value_id" >';
    html += '<input type="number" name="' + product_table_option + '[product_table_option_value_sort]">';
    html += "</td>";

    var colspan = $('.table_' + table + '_option_id_' + option_id).length;
    colspan += 1;
    $('#table_' + table + '_horizont_option_id_' + option_id).attr('colspan', colspan);
    
    $(html).insertAfter(obj.parentNode);
    insertInput(table, option_id, option_value_id, 2);
}

function insertRowInput(table, option_value_id, vertical_option_value_id, colspan, option_id, not_select) {
    var product_table_option = null;

    if (vertical_option_value_id == 0 || $('#table_' + table + '_option_value_id_' + vertical_option_value_id).length != 0) {
        if (option_value_id != false) {
            product_table_option = "product_table[table][" + table + "][option_value_horizont][" + option_value_id + "][option_value_vertical][" + vertical_option_value_id + "]";
        }
    }

    var td_tbody = '<td id="table_' + table + '_option_value_id_';
    
    if (option_value_id == false) {
        td_tbody += option_id + '_not_select';
    } else {
        td_tbody += option_value_id;
    }

    td_tbody += '" class="table_' + table + '_option_id_' + option_id + '_tr_' + vertical_option_value_id + '_last' + not_select + '" data-option-id="' + option_id + '" colspan="' + colspan + '"><input class="price" type="number"'
    
    if (product_table_option != null) {
        td_tbody += '" name="' + product_table_option + '[price]" ';
    }
    
    td_tbody += '/><input type="hidden" ';

    if (product_table_option != null) {
       td_tbody += ' name="' + product_table_option + '[product_table_option_value_price_id]" ';
    }

    td_tbody += ' class="product_table_option_value_price_id" ></td>';

    if ($('.table_' + table + '_option_id_' + option_id + '_tr_' + vertical_option_value_id + '_last' + not_select).length != 0) {
        $('.table_' + table + '_option_id_' + option_id + '_tr_' + vertical_option_value_id + '_last' + not_select).each(function() {
            if ($('.table_' + table + '_option_id_' + option_id).length >= 3) {
                $(this).after(td_tbody);
                
                $(this).attr('colspan', '1');
                $(this).attr('class', '');
            } else {
                $(this).attr('colspan', '2');
            }
        });
    } else {
        $('.table_' + table + '_delete_row_' + vertical_option_value_id + not_select).before(td_tbody);
    }
    
    addName(table);
}

function insertInput(table, option_id, option_value_id, colspan) {
    var obj_main_option = $('.table_' + table + '_main_option_vertical');
    var number_row = 0;
    var not_select = '';

    if (obj_main_option.length != 0) {
        var vertical_option_id = obj_main_option.attr('data-option-id');
        number_row = vertical_option_id;

        $('.table_' + table + '_option_id_' + vertical_option_id + '_main').each(function() {
            if ($(this).attr('id').match(/table_(\d+)_option_value_id_(\d+)_not_select/ig) == null) {
                var vertical_option_value_id = $(this).attr('data-option-value-id');

                $('.table_' + table + '_row_' + vertical_option_value_id).each(function() {
                    insertRowInput(table, option_value_id, vertical_option_value_id, colspan, option_id, not_select);
                });
            }
        });
    }

    $('.table_' + table + '_first_row_' + number_row).each(function() {
        not_select = '_not_select';
        insertRowInput(table, option_value_id, number_row, colspan, option_id, not_select);
    });

    $('.table_' + table + '_delete_row').each(function() {
        var id = "table_" + table + "_option_value_id_";
        
        if (option_value_id == false) {
            id += option_id + "_not_select";
        } else {
            id += option_value_id;
        }

        var td_delete_col = "<td class='table_" + table + "_option_id_" + option_id + "_delete_col_last" + "' id='" + id + "' colspan='" + colspan + "' data-option-id='" + option_id + "'><a class='button delete_col' onclick='deleteCol(\"" + id + "\", " + option_id + ", " + table + ");'>Удалить</a></td>";
        
        $('.table_' + table + '_option_id_' + option_id + '_delete_col_last').each(function() {
            if ($('.table_' + table + '_option_id_' + option_id).length >= 3) {
                $(this).after(td_delete_col);
                
                $(this).attr('colspan', '1');
                $(this).attr('class', '');
            } else {
                $(this).attr('colspan', '2');
            }
        });
        
        if ($('.table_' + table + '_option_id_' + option_id + '_delete_col_last').length == 0) {
            $(this).append(td_delete_col);
        }
    });
}

function insertSelect(table, option_id, html, thead_td, position_vertical, addOption) {
    var main = "_main";
    var last_option_class = null;
    var last_option = null;
    var vertical_obj = null;
    
    $('.table_' + table + '_vertical').each(function() {
        vertical_obj = $(this);
    });
    
    if (vertical_obj == null) {
        $("#table_" + table + "_vertical_select").after(thead_td);
    } else {
        $(vertical_obj).after(thead_td);
    }

    $(vertical_obj).each(function() {
        last_option = $(this).attr('data-option-id');
        last_option_class = $(this).attr('class');
    });

    if (last_option_class == 'table_' + table + '_vertical') {
        main = "";
    }
    
    if (html != null && addOption == false) {
        $('.table_' + table + '_option_id_' + last_option + main).each(function () {
            $(this).after(html);
        });
    } else {
        $('.table_' + table + '_option_id_' + last_option + main).each(function () {
            $(this).after(getSelectOptionValueId(table, option_id, position_vertical));
        });
    }

    if (option_id != null) {
        var class_option_id = "table_" + table + "_option_id_" + option_id;
        var delete_td = "<td class='" + class_option_id + "_delete' ><a class='button delete_col_vertical' onclick='deleteColVertical(" + table + ", " + option_id + ", \"" + class_option_id + "\");'>Удалить</a></td>";

        $('.table_' + table + '_option_id_' + last_option + main + '_delete').after(delete_td);
    }
}

function mainOptionVertical(table) {
    var main_option = [];

    if ($('.table_' + table + '_main_option_vertical').length != 0) {
        $('.table_' + table + '_main_option_vertical').each(function() {
            $('.table_' + table + '_option_id_' + $(this).attr('data-option-id') + '_main').each(function() {
                main_option.push($(this).attr('data-option-value-id'));
            });
        });
    }

    if (main_option.length == 0) {
        main_option.push(0);
    }

    return main_option;
}

function addName(table) {
    var main_option = mainOptionVertical(table);

    for (var i in main_option) {
        var vertical_option_value_id = main_option[i];
        
        $($('.table_' + table + '_row_' + main_option[i]).children()).each(function() {
            inputPrice($(this), table, vertical_option_value_id);
        });
    }

    if (main_option[0] == 0) {
        vertical_option_value_id == 0;

        $($('.table_' + table + '_first_row_0').children()).each(function() {
            inputPrice($(this), table, vertical_option_value_id);
        });
    }
}

function inputPrice(obj, table, vertical_option_value_id) {
    var horizont_option_value_id = $('#' + obj.attr('id')).attr('data-option-value-id');

    if ($('.table_' + table + '_horizont').length == 0) {
        horizont_option_value_id = 0;
    }

    if ( horizont_option_value_id != undefined ) {
        $(obj.children()).each(function() {
            var product_table = 'product_table[table][' + table + '][option_value_horizont][' + horizont_option_value_id + '][option_value_vertical][' + vertical_option_value_id + ']';

            if ($(this).attr('class') == 'price') {
                $(this).attr('name', product_table + '[price]');
            }
            
            if ($(this).attr('class') == 'product_table_option_value_price_id') {
                $(this).attr('name', product_table + '[product_table_option_value_price_id]');
            }

            if ($(this).attr('class') == 'table_price_prefix') {
                $(this).attr('name', product_table + '[price_prefix_id]');
            }

            if ($(this).attr('class') == 'table_price_after') {
                $(this).attr('name', product_table + '[price_after_id]');
            }
        });
    }
}

function addTable(number_table) {
    var table = '<div class="category_div" id="table_' + number_table + '_wrapp">';

    table += '<input type="hidden" name="product_table[table][' + number_table + '][product_table_id]" />';
    table += 'Копировать <input type="checkbox" name="product_table_number[]" value="' + number_table + '" >';
    table += 'Доп. опции';
    table += '<select name="product_table[table][' + number_table + '][type_table]"  >';
    table += '  <option value="0">Нет</option>';
    table += '  <option value="1">Да</option>';
    table += '</select>';
    table += 'Сортировка: <input type="number" name="product_table[table][' + number_table + '][product_table_sort]" />';
    table += 'Название таблицы: <input maxlength="255" size="100" type="text" name="product_table[table][' + number_table + '][product_table_name]" />';
    
    table += '<table class="category" id="table_' + number_table + '"><thead>';
    
    table += '<tr id="table_' + number_table + '_tr_1" >';
    table +=    '<td id="table_' + number_table + '_vertical_select" rowspan="3">';

    if (options.length != 0) {
        table += '<select onchange="addOption(this.options[this.selectedIndex].value, true, ' + number_table + ')">';
        table += "<option value='0'>Нет</option>";

        $(options).each(function() {
            table += "<option value='" + $(this).attr('option_id') + "'>" + $(this).attr('name') + "</option>";
        });

        table += '</select>';
    }

    table +=    '</td>';
    table +=    '<td id="table_' + number_table + '_horizont_select" rowspan="3">';
    
    if (options.length != 0) {
        table += '<select onchange="addOption(this.options[this.selectedIndex].value, false, ' + number_table + ')">';
        table += "<option value='0'>Нет</option>";

        $(options).each(function() {
            table += "<option value='" + $(this).attr('option_id') + "'>" + $(this).attr('name') + "</option>";
        });

        table += '</select>';
    }

    table +=    '</td>';

    table += '</tr>';
    table += '</thead>';
    table += '<tbody>';
    table +=    '<tr id="table_' + number_table + '_tr_last">';
    table +=        '<td><a class="button" onclick="addRow(' + number_table + ')">Добавить</a></td>';
    table +=    '</tr>';
    table += '</tbody></table><a class="button" onclick="deleteTable(' + number_table + ')">Удалить таблицу</a></div>';

    number_table += 1;

    $('.add_table').attr('onclick', 'addTable(' + number_table + ')');
    $('.add_table').before(table);
}
//]]>
</script>

<script type="text/javascript" src="view/javascript/ckeditor/ckeditor.js"></script>

<script type="text/javascript"><!--
    <?php for($i=0; $i < $product_tab_row; $i++) { ?>
        <?php foreach ($languages as $language) { ?>
            CKEDITOR.replace('product_tab[<?php echo $i; ?>][product_tab_description][<?php echo $language['language_id']; ?>][text]',  {
                filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
                filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
                filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
                filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
                filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
                filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>'
            });
        <?php } ?>
    <?php } ?>
//--></script>

<script type="text/javascript"><!--
<?php foreach ($languages as $language) { ?>
    CKEDITOR.replace('description<?php echo $language['language_id']; ?>', {
    filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
    filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
    filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
    filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
    filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
    filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>'
});
<?php } ?>
//</script>

<script type="text/javascript">
$("input[name=\"product_category[]\"]").live('change', function() {
    getFilterOptionsByCategoryId();
});

<?php if (isset($this->request->get['product_id'])) { ?>
  <?php $if_product_id = '&product_id=' . $this->request->get['product_id']; ?>
  getFilterOptionsByCategoryId();
<?php } else { ?>
  <?php $if_product_id = ''; ?>
<?php } ?>

function getFilterOptionsByCategoryId() {
  var loadURL = '';
  var fields = $("input[name=\"product_category[]\"]").serializeArray();
  $.each(fields, function(i, field){
     if (field.value == '') {
      loadURL += '';
     } else {
      if (loadURL == '') {
        loadURL += field.value;
      } else {
        loadURL += '_' + field.value;
      }
     }
  });

  $('#tab-filter').load('index.php?route=catalog/filter/get&token=<?php echo $token; ?><?php echo $if_product_id; ?>&path=' + loadURL);
}

$('input[name=\'related\']').autocomplete({
    delay: 0,
    source: function(request, response) {
    $.ajax({
        url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
        dataType: 'json',
        success: function(json) {       
            response($.map(json, function(item) {
                return {
                    label: item.name,
                    value: item.product_id
                }
            }));
        }
    });

    }, 
    select: function(event, ui) {
        $('#product-related' + ui.item.value).remove();

        $('#product-related').append('<div id="product-related' + ui.item.value + '">' + ui.item.label + '<img src="view/image/delete.png" /><input type="hidden" name="product_related[]" value="' + ui.item.value + '" /></div>');

        $('#product-related div:odd').attr('class', 'odd');
        $('#product-related div:even').attr('class', 'even');

        return false;
    },
    focus: function(event, ui) {
        return false;
    }
});

$('#product-related div img').live('click', function() {
    $(this).parent().remove();
    
    $('#product-related div:odd').attr('class', 'odd');
    $('#product-related div:even').attr('class', 'even');   
});
</script> 
<script type="text/javascript"><!--
var attribute_row = <?php echo $attribute_row; ?>;

function addAttribute() {
    html  = '<tbody id="attribute-row' + attribute_row + '">';
    html += '  <tr>';
    html += '    <td class="left"><input type="text" name="product_attribute[' + attribute_row + '][name]" value="" /><input type="hidden" name="product_attribute[' + attribute_row + '][attribute_id]" value="" /></td>';
    html += '    <td class="left">';
    <?php foreach ($languages as $language) { ?>
    html += '<textarea name="product_attribute[' + attribute_row + '][product_attribute_description][<?php echo $language['language_id']; ?>][text]" cols="40" rows="5"></textarea><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" align="top" /><br />';
    <?php } ?>
    html += '    </td>';
    html += '    <td class="left"><a onclick="$(\'#attribute-row' + attribute_row + '\').remove();" class="button"><?php echo $button_remove; ?></a></td>';
    html += '  </tr>';  
    html += '</tbody>';

    $('#attribute tfoot').before(html);

    attributeautocomplete(attribute_row);

    attribute_row++;
}

$.widget('custom.catcomplete', $.ui.autocomplete, {
    _renderMenu: function(ul, items) {
    var self = this, currentCategory = '';

        $.each(items, function(index, item) {
            if (item.category != currentCategory) {
                ul.append('<li class="ui-autocomplete-category">' + item.category + '</li>');

                currentCategory = item.category;
            }

            self._renderItem(ul, item);
        });
    }
});

function attributeautocomplete(attribute_row) {
    $('input[name=\'product_attribute[' + attribute_row + '][name]\']').catcomplete({
        delay: 0,
        source: function(request, response) {
            $.ajax({
                url: 'index.php?route=catalog/attribute/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
                dataType: 'json',
                success: function(json) {   
                    response($.map(json, function(item) {
                        return {
                            category: item.attribute_group,
                            label: item.name,
                            value: item.attribute_id
                        }
                    }));
                }
            });
        }, 
        select: function(event, ui) {
            $('input[name=\'product_attribute[' + attribute_row + '][name]\']').attr('value', ui.item.label);
            $('input[name=\'product_attribute[' + attribute_row + '][attribute_id]\']').attr('value', ui.item.value);

            return false;
        },
        focus: function(event, ui) {
            return false;
        }
    });
}

$('#attribute tbody').each(function(index, element) {
    attributeautocomplete(index);
});
//</script>

<script type="text/javascript"><!--
    var product_tab_row = <?php echo $product_tab_row; ?>;

    $('input[name=\'producttab\']').autocomplete({
        delay: 500,
        source: function(request, response) {
            $.ajax({
                url: 'index.php?route=catalog/tab/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
                dataType: 'json',
                success: function(json) {
                    response($.map(json, function(item) {
                        return {
                            label: item.name,
                            value: item.tab_id
                        }
                    }));
                }
            });
        },
        select: function(event, ui) {
            html  = '<div id="tab-product_tab-' + product_tab_row + '" class="vtabs-content">';
            html += '   <input type="hidden" name="product_tab[' + product_tab_row + '][name]" value="' + ui.item.label + '" />';
            html += '   <input type="hidden" name="product_tab[' + product_tab_row + '][tab_id]" value="' + ui.item.value + '" />';
            html += '   <table class="form">';
            html += '     <tr>';
            html += '       <td>';
            html += '   <div id="product_tab-' + product_tab_row + '-languages" class="htabs">';
            <?php foreach ($languages as $language) { ?>
                html += '   <a href="#product_tab-' + product_tab_row + '-languages-<?php echo $language['language_id']; ?>"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a>';
            <?php } ?>
            html += '   </div>';
            <?php foreach ($languages as $language) { ?>
            html += '   <div id="product_tab-' + product_tab_row + '-languages-<?php echo $language['language_id']; ?>">';
            html += '<textarea name="product_tab[' + product_tab_row + '][product_tab_description][<?php echo $language['language_id']; ?>][text]" cols="40" rows="5"></textarea>';
            html += '   </div>';
            <?php } ?>
            html += '   </td>';
            html += ' </tr>';
            html += ' </table>';
            html += '</div>';

            $('#tab-product_tab').append(html);

            $('#product_tab-add').before('<a href="#tab-product_tab-' + product_tab_row + '" id="product_tab-' + product_tab_row + '">' + ui.item.label + '&nbsp; <img src="view/image/delete.png" alt="" onclick="$(\'#tab-product_tab-' + product_tab_row + '\').remove(); $(\'#product_tab-' + product_tab_row + '\').remove(); $(\'#vtab-product_tab a:first\').trigger(\'click\'); return false;" /></a>');

            $('#vtab-product_tab a').tabs();

            $('#product_tab-' + product_tab_row + '-languages a').tabs();

            <?php foreach ($languages as $language) { ?>
            CKEDITOR.replace('product_tab[' + product_tab_row + '][product_tab_description][<?php echo $language['language_id']; ?>][text]',  {
                filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
                filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
                filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
                filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
                filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
                filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>'
            });
            <?php } ?>

            $('#product_tab-' + product_tab_row).trigger('click');

            product_tab_row++;

            $(this).val('');

            return false;
        },
        focus: function(event, ui) {
                return false;
        }
    });
//--></script>

<script type="text/javascript"><!-- 
    var option_row = <?php echo $option_row; ?>;
    var option_value_row = <?php echo $option_value_row; ?>;

    $('input[name=\'option\']').catcomplete({
        delay: 0,
        source: function(request, response) {
            $.ajax({
                url: 'index.php?route=catalog/option/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
                dataType: 'json',
                success: function(json) {
                    response($.map(json, function(item) {
                        return {
                            category: item.category,
                            label: item.name,
                            value: item.option_id,
                            type: item.type,
                            option_value: item.option_value
                        }
                    }));
                }
            });
        }, 
        select: function(event, ui) {
            html  = '<div id="tab-option-' + option_row + '" class="vtabs-content">';
            html += '   <input type="hidden" name="product_option[' + option_row + '][product_option_id]" value="" />';
            html += '   <input type="hidden" name="product_option[' + option_row + '][name]" value="' + ui.item.label + '" />';
            html += '   <input type="hidden" name="product_option[' + option_row + '][option_id]" value="' + ui.item.value + '" />';
            html += '   <input type="hidden" name="product_option[' + option_row + '][type]" value="' + ui.item.type + '" />';
            html += '   <table class="form">';
            html += '     <tr>';
            html += '       <td><?php echo $entry_required; ?></td>';
            html += '               <td><select name="product_option[' + option_row + '][required]">';
            html += '                   <option value="1"><?php echo $text_yes; ?></option>';
            html += '                   <option value="0"><?php echo $text_no; ?></option>';
            html += '               </select></td>';
            html += '         </tr>';
            
            if (ui.item.type == 'text') {
            html += '     <tr>';
            html += '       <td><?php echo $entry_option_value; ?></td>';
            html += '       <td><input type="text" name="product_option[' + option_row + '][option_value]" value="" /></td>';
            html += '     </tr>';
            }

            if (ui.item.type == 'textarea') {
            html += '     <tr>';
            html += '       <td><?php echo $entry_option_value; ?></td>';
            html += '       <td><textarea name="product_option[' + option_row + '][option_value]" cols="40" rows="5"></textarea></td>';
            html += '     </tr>';                       
            }

            if (ui.item.type == 'file') {
            html += '     <tr style="display: none;">';
            html += '       <td><?php echo $entry_option_value; ?></td>';
            html += '       <td><input type="text" name="product_option[' + option_row + '][option_value]" value="" /></td>';
            html += '     </tr>';           
            }

            if (ui.item.type == 'date') {
            html += '     <tr>';
            html += '       <td><?php echo $entry_option_value; ?></td>';
            html += '       <td><input type="text" name="product_option[' + option_row + '][option_value]" value="" class="date" /></td>';
            html += '     </tr>';           
            }

            if (ui.item.type == 'datetime') {
            html += '     <tr>';
            html += '       <td><?php echo $entry_option_value; ?></td>';
            html += '       <td><input type="text" name="product_option[' + option_row + '][option_value]" value="" class="datetime" /></td>';
            html += '     </tr>';           
            }

            if (ui.item.type == 'time') {
            html += '     <tr>';
            html += '       <td><?php echo $entry_option_value; ?></td>';
            html += '       <td><input type="text" name="product_option[' + option_row + '][option_value]" value="" class="time" /></td>';
            html += '     </tr>';           
            }

            html += '  </table>';

            if (ui.item.type == 'select' || ui.item.type == 'radio' || ui.item.type == 'checkbox' || ui.item.type == 'image') {
                html += '  <table id="option-value' + option_row + '" class="list">';
                html += '    <thead>'; 
                html += '      <tr>';
                html += '        <td class="left"><?php echo $entry_option_value; ?></td>';
                html += '        <td class="right"><?php echo $entry_quantity; ?></td>';
                html += '        <td class="left"><?php echo $entry_subtract; ?></td>';
                html += '        <td class="right"><?php echo $entry_price; ?></td>';
                html += '        <td class="right"><?php echo $entry_option_points; ?></td>';
                html += '        <td class="right"><?php echo $entry_weight; ?></td>';
                html += '        <td class="right"><?php echo $entry_sort_order; ?></td>';
                html += '        <td></td>';
                html += '      </tr>';
                html += '    </thead>';
                html += '    <tfoot>';
                html += '      <tr>';
                html += '        <td colspan="7"></td>';
                html += '        <td class="left"><a onclick="addOptionValue(' + option_row + ');" class="button"><?php echo $button_add_option_value; ?></a></td>';
                html += '      </tr>';
                html += '    </tfoot>';
                html += '  </table>';
                html += '  <select id="option-values' + option_row + '" style="display: none;">';

                for (i = 0; i < ui.item.option_value.length; i++) {
                    html += '  <option id="option_value_row_' + option_row + '_' + ui.item.option_value[i]['option_value_id'] + '" value="' + ui.item.option_value[i]['option_value_id'] + '">' + ui.item.option_value[i]['name'] + '</option>';
                    value_id = ui.item.option_value[i]['option_value_id'];
                }

                option_value_id[option_row] = value_id;

                html += '  </select>';
                html += '</div>';   
            }

            $('#tab-option').append(html);

            $('#option-add').before('<a href="#tab-option-' + option_row + '" id="option-' + option_row + '">' + ui.item.label + '&nbsp;<img src="view/image/delete.png" alt="" onclick="$(\'#vtab-option a:first\').trigger(\'click\'); $(\'#option-' + option_row + '\').remove(); $(\'#tab-option-' + option_row + '\').remove(); return false;" /></a>');

            $('#vtab-option a').tabs();

            $('#option-' + option_row).trigger('click');

            $('.date').datepicker({dateFormat: 'yy-mm-dd'});
            $('.datetime').datetimepicker({
                dateFormat: 'yy-mm-dd',
                timeFormat: 'h:m'
            }); 

            $('.time').timepicker({timeFormat: 'h:m'}); 

            option_row++;

            return false;
        },
        focus: function(event, ui) {
            return false;
        }
    });
//--></script>

<script type="text/javascript"><!--     
function addOptionValue(option_row) {
    html  = '<tbody id="option-value-row' + option_value_row + '">';
    html += '  <tr>';
    html += '    <td class="left"><select id="product_option[' + option_row + '][product_option_value][' + option_value_row + '][option_value_id]" name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][option_value_id]" onclick="javascript: option_value_id[' + option_row + '] = this.value; ">';
    html += $('#option-values' + option_row).html();

    html += '    </select><input type="hidden" name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][product_option_value_id]" value="" /></td>';

    html += '    <td class="right"><input type="text" name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][quantity]" value="" size="3" /></td>'; 
    html += '    <td class="left"><select name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][subtract]">';
    html += '      <option value="0"><?php echo $text_no; ?></option>';
    html += '      <option value="1"><?php echo $text_yes; ?></option>';
    html += '    </select></td>';
    html += '    <td class="right"><select name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][price_prefix]">';
    html += '      <option value="+">+</option>';
    html += '      <option value="-">-</option>';
    html += '    </select>';
    html += '    <input type="text" name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][price]" value="" size="5" /></td>';
    html += '    <td class="right"><select name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][points_prefix]">';
    html += '      <option value="+">+</option>';
    html += '      <option value="-">-</option>';
    html += '    </select>';
    html += '    <input type="text" name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][points]" value="" size="5" /></td>';   
    html += '    <td class="right"><select name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][weight_prefix]">';
    html += '      <option value="+">+</option>';
    html += '      <option value="-">-</option>';
    html += '    </select>';
    html += '    <input type="text" name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][weight]" value="" size="5" /></td>';

    html += '    <td class="right">';
    html += '    <input type="text" name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][sort_order]" value="" size="5" /></td>';

    html += '    <td class="left"><a onclick="$(\'#option-value-row' + option_value_row + '\').remove();" class="button"><?php echo $button_remove; ?></a></td>';
    html += '  </tr>';
    html += '</tbody>';

    $('#option-value' + option_row + ' tfoot').before(html);

    if (option_value_id[option_row] != undefined) {
        var temp = $('#option-value' + option_row + ' #option_value_row_' + option_row + '_' + option_value_id[option_row]).next().attr('value');

        if (temp == undefined) {
            temp = $('#option-value' + option_row + ' #option_value_row_' + option_row + '_' + option_value_id[option_row]).parent().filter(':last').attr('value');
        }

        option_value_id[option_row] = temp;
        $('#option-value' + option_row + ' #option_value_row_' + option_row + '_' + option_value_id[option_row]).parent().val(option_value_id[option_row]);

        $('#option-value' + option_row + ' #option_value_row_' + option_row + '_' + option_value_id[option_row]).parent().children().each( function() {
            $(this).attr('id', '');
        });
    }

    option_value_row++;
}
//--></script> 
<script type="text/javascript"><!--
var discount_row = <?php echo $discount_row; ?>;

function addDiscount() {
    html  = '<tbody id="discount-row' + discount_row + '">';
    html += '  <tr>'; 
    html += '    <td class="left"><select name="product_discount[' + discount_row + '][customer_group_id]">';
    <?php foreach ($customer_groups as $customer_group) { ?>
    html += '      <option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>';
    <?php } ?>
    html += '    </select></td>';       
    html += '    <td class="right"><input type="text" name="product_discount[' + discount_row + '][quantity]" value="" size="2" /></td>';
    html += '    <td class="right"><input type="text" name="product_discount[' + discount_row + '][priority]" value="" size="2" /></td>';
    html += '    <td class="right"><input type="text" name="product_discount[' + discount_row + '][price]" value="" /></td>';
    html += '    <td class="left"><input type="text" name="product_discount[' + discount_row + '][date_start]" value="" class="date" /></td>';
    html += '    <td class="left"><input type="text" name="product_discount[' + discount_row + '][date_end]" value="" class="date" /></td>';
    html += '    <td class="left"><a onclick="$(\'#discount-row' + discount_row + '\').remove();" class="button"><?php echo $button_remove; ?></a></td>';
    html += '  </tr>';  
    html += '</tbody>';

    $('#discount tfoot').before(html);

    $('#discount-row' + discount_row + ' .date').datepicker({dateFormat: 'yy-mm-dd'});

    discount_row++;
}
//--></script> 
<script type="text/javascript"><!--
var special_row = <?php echo $special_row; ?>;

function addSpecial() {
    html  = '<tbody id="special-row' + special_row + '">';
    html += '  <tr>'; 
    html += '    <td class="left"><select name="product_special[' + special_row + '][customer_group_id]">';
    <?php foreach ($customer_groups as $customer_group) { ?>
    html += '      <option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>';
    <?php } ?>
    html += '    </select></td>';       
    html += '    <td class="right"><input type="text" name="product_special[' + special_row + '][priority]" value="" size="2" /></td>';
    html += '    <td class="right"><input type="text" name="product_special[' + special_row + '][price]" value="" /></td>';
    html += '    <td class="left"><input type="text" name="product_special[' + special_row + '][date_start]" value="" class="date" /></td>';
    html += '    <td class="left"><input type="text" name="product_special[' + special_row + '][date_end]" value="" class="date" /></td>';
    html += '    <td class="left"><a onclick="$(\'#special-row' + special_row + '\').remove();" class="button"><?php echo $button_remove; ?></a></td>';
    html += '  </tr>';
    html += '</tbody>';

    $('#special tfoot').before(html);

    $('#special-row' + special_row + ' .date').datepicker({dateFormat: 'yy-mm-dd'});

    special_row++;
}
//--></script> 
<script type="text/javascript"><!--
function image_upload(field, thumb) {
    $('#dialog').remove();

    $('#content').prepend('<div id="dialog" style="padding: 3px 0px 0px 0px;"><iframe src="index.php?route=common/filemanager&token=<?php echo $token; ?>&field=' + encodeURIComponent(field) + '" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe></div>');

    $('#dialog').dialog({
        title: '<?php echo $text_image_manager; ?>',
        close: function (event, ui) {
            if ($('#' + field).attr('value')) {
                $.ajax({
                    url: 'index.php?route=common/filemanager/image&token=<?php echo $token; ?>&image=' + encodeURIComponent($('#' + field).attr('value')),
                    dataType: 'text',
                    success: function(text) {
                        $('#' + thumb).replaceWith('<img src="' + text + '" alt="" id="' + thumb + '" />');
                    }
                });
            }
        },  
        bgiframe: false,
        width: 960,
        height: 500,
        resizable: false,
        modal: false,
        dialogClass: 'dlg'
    });
};
//--></script> 
<script type="text/javascript"><!--
var image_row = <?php echo $image_row; ?>;

function addImage() {
    html  = '<tbody id="image-row' + image_row + '">';
    html += '  <tr>';
    html += '    <td class="left">';
    html += '       <div class="image">';
    html += '           <img src="<?php echo $no_image; ?>" alt="" id="thumb' + image_row + '" />';
    html += '           <input type="hidden" name="product_image[' + image_row + '][image]" value="" id="image' + image_row + '" /><br />';
    html += '           <a onclick="image_upload(\'image' + image_row + '\', \'thumb' + image_row + '\');">';
    html += '                <?php echo $text_browse; ?>';
    html += '           </a>';
    html += '           &nbsp;&nbsp;|&nbsp;&nbsp;';
    html += '           <a onclick="$(\'#thumb' + image_row + '\').attr(\'src\', \'<?php echo $no_image; ?>\'); $(\'#image' + image_row + '\').attr(\'value\', \'\');">';
    html += '               <?php echo $text_clear; ?>';
    html += '           </a>';
    html += '       </div>';
    html += '    </td>';
    html += '    <td class="right"><input type="text" name="product_image[' + image_row + '][sort_order]" value="" size="2" /></td>';
    html += '    <td class="left"><a onclick="$(\'#image-row' + image_row  + '\').remove();" class="button"><?php echo $button_remove; ?></a></td>';
    html += '  </tr>';
    html += '</tbody>';

    $('#images tfoot').before(html);

    image_row++;
    return  image_row-1;
}
//--></script> 
<script type="text/javascript" src="view/javascript/jquery/ui/jquery-ui-timepicker-addon.js"></script> 
<script type="text/javascript"><!--
$('.date').datepicker({dateFormat: 'yy-mm-dd'});
$('.datetime').datetimepicker({
    dateFormat: 'yy-mm-dd',
    timeFormat: 'h:m'
});
$('.time').timepicker({timeFormat: 'h:m'});
//--></script> 
<script type="text/javascript"><!--
$('#tabs a').tabs(); 
$('#languages a').tabs(); 
$('#vtab-product_tab a').tabs();
<?php for( $i=0; $i < $product_tab_row; $i++ ) { ?>
    $('#product_tab-<?php echo $i; ?>-languages a').tabs();
<?php } ?>
$('#vtab-option a').tabs();
//--></script>

<?php echo $footer; ?>