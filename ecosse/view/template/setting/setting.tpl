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
<?php if ($success) { ?>
<div class="success"><?php echo $success; ?></div>
<?php } ?>
<div class="box">
<div class="heading">
    <h1><img src="view/image/setting.png" alt="" /> <?php echo $heading_title; ?></h1>
    <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a></div>
</div>
<div class="content">
<div id="tabs" class="htabs"><a href="#tab-general"><?php echo $tab_general; ?></a><a href="#tab-store"><?php echo $tab_store; ?></a><a href="#tab-local"><?php echo $tab_local; ?></a><a href="#tab-option"><?php echo $tab_option; ?></a><a href="#tab-image"><?php echo $tab_image; ?></a><a href="#tab-mail"><?php echo $tab_mail; ?></a><a href="#tab-fraud"><?php echo $tab_fraud; ?></a><a href="#tab-sms"><?php echo $tab_sms; ?></a><a href="#tab-server"><?php echo $tab_server; ?></a></div>
<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
<div id="tab-general">
    <table class="form">
        <tr>
            <td><span class="required">*</span> <?php echo $entry_name; ?></td>
            <td><input type="text" name="config_name" value="<?php echo $config_name; ?>" size="40" />
                <?php if ($error_name) { ?>
                <span class="error"><?php echo $error_name; ?></span>
                <?php } ?></td>
        </tr>
        <tr>
            <td><span class="required">*</span> <?php echo $entry_owner; ?></td>
            <td><input type="text" name="config_owner" value="<?php echo $config_owner; ?>" size="40" />
                <?php if ($error_owner) { ?>
                <span class="error"><?php echo $error_owner; ?></span>
                <?php } ?></td>
        </tr>
        <tr>
            <td><span class="required">*</span> <?php echo $entry_address; ?></td>
            <td><textarea name="config_address" cols="40" rows="5"><?php echo $config_address; ?></textarea>
                <?php if ($error_address) { ?>
                <span class="error"><?php echo $error_address; ?></span>
                <?php } ?></td>
        </tr>
        <tr>
            <td><span class="required">*</span> <?php echo $entry_email; ?></td>
            <td><input type="text" name="config_email" value="<?php echo $config_email; ?>" size="40" />
                <?php if ($error_email) { ?>
                <span class="error"><?php echo $error_email; ?></span>
                <?php } ?></td>
        </tr>
        <tr>
            <td><span class="required">*</span> <?php echo $entry_telephone; ?></td>
            <td><input type="text" name="config_telephone" value="<?php echo $config_telephone; ?>" />
                <?php if ($error_telephone) { ?>
                <span class="error"><?php echo $error_telephone; ?></span>
                <?php } ?></td>
        </tr>
        <tr>
            <td><?php echo $entry_fax; ?></td>
            <td><input type="text" name="config_fax" value="<?php echo $config_fax; ?>" /></td>
        </tr>
        <tr>
            <td><?php echo $entry_skype; ?></td>
            <td><input type="text" name="config_skype" value="<?php echo $config_skype; ?>" /></td>
        </tr>

    </table>
</div>
<div id="tab-store">
    <table class="form">
        <tr>
            <td><span class="required">*</span> <?php echo $entry_title; ?></td>
            <td><input type="text" name="config_title" value="<?php echo $config_title; ?>" />
                <?php if ($error_title) { ?>
                <span class="error"><?php echo $error_title; ?></span>
                <?php } ?>
            </td>
        </tr>
        <tr>
            <td><?php echo $entry_meta_description; ?></td>
            <td><textarea name="config_meta_description" cols="40" rows="5"><?php echo $config_meta_description; ?></textarea></td>
        </tr>
        <tr>
            <td><?php echo $entry_template; ?></td>
            <td><select name="config_template" onchange="$('#template').load('index.php?route=setting/setting/template&token=<?php echo $token; ?>&template=' + encodeURIComponent(this.value));">
                    <?php foreach ($templates as $template) { ?>
                    <?php if ($template == $config_template) { ?>
                    <option value="<?php echo $template; ?>" selected="selected"><?php echo $template; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $template; ?>"><?php echo $template; ?></option>
                    <?php } ?>
                    <?php } ?>
                </select>
            </td>
        </tr>
        <tr>
            <td></td>
            <td id="template"></td>
        </tr>
        <tr>
            <td><?php echo $entry_layout; ?></td>
            <td><select name="config_layout_id">
                    <?php foreach ($layouts as $layout) { ?>
                    <?php if ($layout['layout_id'] == $config_layout_id) { ?>
                    <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                </select></td>
        </tr>
    </table>
</div>
<div id="tab-local">
    <table class="form">
        <tr>
            <td><?php echo $entry_country; ?></td>
            <td><select name="config_country_id">
                    <?php foreach ($countries as $country) { ?>
                    <?php if ($country['country_id'] == $config_country_id) { ?>
                    <option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                </select></td>
        </tr>
        <tr>
            <td><?php echo $entry_zone; ?></td>
            <td><select name="config_zone_id">
                </select></td>
        </tr>
        <tr>
            <td><?php echo $entry_language; ?></td>
            <td><select name="config_language">
                    <?php foreach ($languages as $language) { ?>
                    <?php if ($language['code'] == $config_language) { ?>
                    <option value="<?php echo $language['code']; ?>" selected="selected"><?php echo $language['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $language['code']; ?>"><?php echo $language['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                </select></td>
        </tr>
        <tr>
            <td><?php echo $entry_admin_language; ?></td>
            <td><select name="config_admin_language">
                    <?php foreach ($languages as $language) { ?>
                    <?php if ($language['code'] == $config_admin_language) { ?>
                    <option value="<?php echo $language['code']; ?>" selected="selected"><?php echo $language['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $language['code']; ?>"><?php echo $language['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                </select></td>
        </tr>
        <tr>
            <td><?php echo $entry_currency; ?></td>
            <td><select name="config_currency">
                    <?php foreach ($currencies as $currency) { ?>
                    <?php if ($currency['code'] == $config_currency) { ?>
                    <option value="<?php echo $currency['code']; ?>" selected="selected"><?php echo $currency['title']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $currency['code']; ?>"><?php echo $currency['title']; ?></option>
                    <?php } ?>
                    <?php } ?>
                </select></td>
        </tr>
        <tr>
            <td><?php echo $entry_currency_auto; ?></td>
            <td><?php if ($config_currency_auto) { ?>
                <input type="radio" name="config_currency_auto" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <input type="radio" name="config_currency_auto" value="0" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="config_currency_auto" value="1" />
                <?php echo $text_yes; ?>
                <input type="radio" name="config_currency_auto" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } ?></td>
        </tr>
        <tr>
            <td><?php echo $entry_length_class; ?></td>
            <td><select name="config_length_class_id">
                    <?php foreach ($length_classes as $length_class) { ?>
                    <?php if ($length_class['length_class_id'] == $config_length_class_id) { ?>
                    <option value="<?php echo $length_class['length_class_id']; ?>" selected="selected"><?php echo $length_class['title']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $length_class['length_class_id']; ?>"><?php echo $length_class['title']; ?></option>
                    <?php } ?>
                    <?php } ?>
                </select>
            </td>
        </tr>
        <tr>
            <td><?php echo $entry_weight_class; ?></td>
            <td><select name="config_weight_class_id">
                    <?php foreach ($weight_classes as $weight_class) { ?>
                    <?php if ($weight_class['weight_class_id'] == $config_weight_class_id) { ?>
                    <option value="<?php echo $weight_class['weight_class_id']; ?>" selected="selected"><?php echo $weight_class['title']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $weight_class['weight_class_id']; ?>"><?php echo $weight_class['title']; ?></option>
                    <?php } ?>
                    <?php } ?>
                </select></td>
        </tr>
    </table>
</div>
<div id="tab-option">

<table class="form">
    <tr>
        <td>SKU в списке продуктов ?</td>
        <td><?php if ($config_display_sku) { ?>
            <input type="radio" name="config_display_sku" value="1" checked="checked" />
            <?php echo $text_yes; ?>
            <input type="radio" name="config_display_sku" value="0" />
            <?php echo $text_no; ?>
            <?php } else { ?>
            <input type="radio" name="config_display_sku" value="1" />
            <?php echo $text_yes; ?>
            <input type="radio" name="config_display_sku" value="0" checked="checked" />
            <?php echo $text_no; ?>
            <?php } ?></td>
    </tr>

    <tr>
        <td>SKU на странице продукта?</td>
        <td><?php if ($config_display_skup) { ?>
            <input type="radio" name="config_display_skup" value="1" checked="checked" />
            <?php echo $text_yes; ?>
            <input type="radio" name="config_display_skup" value="0" />
            <?php echo $text_no; ?>
            <?php } else { ?>
            <input type="radio" name="config_display_skup" value="1" />
            <?php echo $text_yes; ?>
            <input type="radio" name="config_display_skup" value="0" checked="checked" />
            <?php echo $text_no; ?>
            <?php } ?></td>
    </tr>

    <tr>
        <td>Модель в списке продуктов?</td>
        <td><?php if ($config_display_model) { ?>
            <input type="radio" name="config_display_model" value="1" checked="checked" />
            <?php echo $text_yes; ?>
            <input type="radio" name="config_display_model" value="0" />
            <?php echo $text_no; ?>
            <?php } else { ?>
            <input type="radio" name="config_display_model" value="1" />
            <?php echo $text_yes; ?>
            <input type="radio" name="config_display_model" value="0" checked="checked" />
            <?php echo $text_no; ?>
            <?php } ?></td>
    </tr>

    <tr>
        <td>Производитель в списке продуктов?</td>
        <td><?php if ($config_display_brand) { ?>
            <input type="radio" name="config_display_brand" value="1" checked="checked" />
            <?php echo $text_yes; ?>
            <input type="radio" name="config_display_brand" value="0" />
            <?php echo $text_no; ?>
            <?php } else { ?>
            <input type="radio" name="config_display_brand" value="1" />
            <?php echo $text_yes; ?>
            <input type="radio" name="config_display_brand" value="0" checked="checked" />
            <?php echo $text_no; ?>
            <?php } ?></td>
    </tr>

    <tr>
        <td>Расположение в списке продуктов?</td>
        <td><?php if ($config_display_location) { ?>
            <input type="radio" name="config_display_location" value="1" checked="checked" />
            <?php echo $text_yes; ?>
            <input type="radio" name="config_display_location" value="0" />
            <?php echo $text_no; ?>
            <?php } else { ?>
            <input type="radio" name="config_display_location" value="1" />
            <?php echo $text_yes; ?>
            <input type="radio" name="config_display_location" value="0" checked="checked" />
            <?php echo $text_no; ?>
            <?php } ?></td>
    </tr>

    <tr>
        <td>Расположение на странице товара?</td>
        <td><?php if ($config_display_locationp) { ?>
            <input type="radio" name="config_display_locationp" value="1" checked="checked" />
            <?php echo $text_yes; ?>
            <input type="radio" name="config_display_locationp" value="0" />
            <?php echo $text_no; ?>
            <?php } else { ?>
            <input type="radio" name="config_display_locationp" value="1" />
            <?php echo $text_yes; ?>
            <input type="radio" name="config_display_locationp" value="0" checked="checked" />
            <?php echo $text_no; ?>
            <?php } ?></td>
    </tr>

    <tr>
        <td>UPC в списке продуктов?</td>
        <td><?php if ($config_display_upc) { ?>
            <input type="radio" name="config_display_upc" value="1" checked="checked" />
            <?php echo $text_yes; ?>
            <input type="radio" name="config_display_upc" value="0" />
            <?php echo $text_no; ?>
            <?php } else { ?>
            <input type="radio" name="config_display_upc" value="1" />
            <?php echo $text_yes; ?>
            <input type="radio" name="config_display_upc" value="0" checked="checked" />
            <?php echo $text_no; ?>
            <?php } ?></td>
    </tr>

    <tr>
        <td>UPC на странице продукта?</td>
        <td><?php if ($config_display_upcp) { ?>
            <input type="radio" name="config_display_upcp" value="1" checked="checked" />
            <?php echo $text_yes; ?>
            <input type="radio" name="config_display_upcp" value="0" />
            <?php echo $text_no; ?>
            <?php } else { ?>
            <input type="radio" name="config_display_upcp" value="1" />
            <?php echo $text_yes; ?>
            <input type="radio" name="config_display_upcp" value="0" checked="checked" />
            <?php echo $text_no; ?>
            <?php } ?></td>
    </tr>

    <tr>
        <td>Наличие товара в списке продуктов?</td>
        <td><?php if ($config_display_listock) { ?>
            <input type="radio" name="config_display_listock" value="1" checked="checked" />
            <?php echo $text_yes; ?>
            <input type="radio" name="config_display_listock" value="0" />
            <?php echo $text_no; ?>
            <?php } else { ?>
            <input type="radio" name="config_display_listock" value="1" />
            <?php echo $text_yes; ?>
            <input type="radio" name="config_display_listock" value="0" checked="checked" />
            <?php echo $text_no; ?>
            <?php } ?></td>
    </tr>
</table>

<h2><?php echo $text_will_save_sort_order; ?></h2>
<table class="form">
    <tr>
        <td>
            <?php echo 'Сортировка:'; ?>
        </td>
        <td>
            <input type="number" name="will_save_sort_order" value="<?php echo $will_save_sort_order; ?>" >
        </td>
    </tr>
</table>

<h2><?php echo $text_items; ?></h2>
<table class="form">
    <tr>
        <td><span class="required">*</span> <?php echo $entry_catalog_limit; ?></td>
        <td><input type="text" name="config_catalog_limit" value="<?php echo $config_catalog_limit; ?>" size="3" />
            <?php if ($error_catalog_limit) { ?>
            <span class="error"><?php echo $error_catalog_limit; ?></span>
            <?php } ?></td>
    </tr>
    <tr>
        <td><span class="required">*</span> <?php echo $entry_admin_limit; ?></td>
        <td><input type="text" name="config_admin_limit" value="<?php echo $config_admin_limit; ?>" size="3" />
            <?php if ($error_admin_limit) { ?>
            <span class="error"><?php echo $error_admin_limit; ?></span>
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td><span class="required">*</span> <?php echo $entry_limit_category_video; ?></td>
        <td>
            <input type="text" name="config_category_video_limit" value="<?php echo $config_category_video_limit; ?>" size="3" />
            <?php if ($error_limit_category_video) { ?>
                <span class="error"><?php echo $error_limit_category_video; ?></span>
            <?php } ?>
        </td>
    </tr>
</table>

<h2>Footer</h2>
<table class="form">
    <tr>
        <td>Страница information/contact</td>
        <td>
            <input type="text" size="100" name="text_contact" value="<?php echo $text_contact; ?>">
        </td>
    </tr>
</table>

<h2><?php echo $text_discount_by_birthday; ?></h2>
<table class="form">
    <tr>
        <td>
            <?php echo $entry_discount_birthday_enable; ?>
        </td>
        <td>
            <input type="radio" name="discount_birthday_enable" value="0" <?php if ($discount_birthday_enable == 0) { ?> checked <?php } ?> >Нет
            <input type="radio" name="discount_birthday_enable" value="1" <?php if ($discount_birthday_enable == 1) { ?> checked <?php } ?> >Да
        </td>
    </tr>
    <tr>
        <td>
            <?php echo $entry_discount_birthday_days; ?>
        </td>
        <td>
            <input type="number" name="discount_birthday_days" value="<?php echo $discount_birthday_days; ?>" >
        </td>
    </tr>
    <tr>
        <td>
            Количество одного товара
        </td>
        <td>
            <input type="number" name="discount_birthday_one_gift" value="<?php echo $discount_birthday_one_gift; ?>" >
        </td>
    </tr>
    <tr>
        <td>
            Тема письма:
        </td>
        <td>
            <input type="text" size="100" name="discount_birthday_subject" value="<?php echo $discount_birthday_subject; ?>" >
        </td>
    </tr>
    <tr>
        <td>
            Минимальная общая сумма покупки:
        </td>
        <td>
            <input type="number"  name="discount_birthday_total_price" value="<?php echo $discount_birthday_total_price; ?>" >
        </td>
    </tr>
    <tr>
        <td>
            Текст с поздравлением, для клиента:
        </td>
        <td>
            <textarea name="birthday_description" id="birthday_description" cols="100" rows="20">
                <?php echo $birthday_description ; ?>
            </textarea>
        </td>
    </tr>

    <script type="text/javascript" src="view/javascript/ckeditor/ckeditor.js"></script>

    <script type="text/javascript"><!--
        CKEDITOR.replace('birthday_description', {
            filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
            filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
            filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
            filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
            filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
            filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>'
        });
        //-->
    </script>

    <tr>
        <td>
            Скидка на товар:
        </td>
        <td>
            <div class="select_manufacturer">
                <div>Производитель:</div>
                <select onchange="listProduct(this.options[this.selectedIndex].value, this, 'category');">
                    <option value="0">Не выбрано</option>
                    <?php foreach ($manufacturers as $manufacturer) { ?>
                    <option value="<?php echo $manufacturer['manufacturer_id']; ?>"><?php echo $manufacturer['name']; ?></option>
                    <?php } ?>
                </select>
            </div>

            <?php if ($discount_birthday_days_products) { ?>
                <div class="scrollbox" id="box_product">
                    <?php $class = 'even'; ?>

                    <?php foreach ($discount_birthday_days_products as $product) { ?>
                        <div id="product_id_<?php echo $product['product_id']; ?>" class="<?php echo $class; ?>">
                            <input type="hidden" name="discount_birthday_days_products[]" value="<?php echo $product['product_id']; ?>">
                            (<?php echo $product['product_id']; ?>) <?php echo $product['name']; ?>
                            <span class="img_delete_option" onclick="deleteProduct(this);"></span>
                        </div>
                        <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                    <?php } ?>
                </div>
            <?php } ?>
        </td>
    </tr>
</table>

<h2>Напоминание о товарах в корзине, по email зарегистрированным пользователям.</h2>
<table class="form">
    <tr>
        <td>Часовой интервал</td>
        <td>
            <input type="number" name="hour_interval"  value="<?php echo $hour_interval; ?>">
        </td>
    </tr>
    <tr>
        <td>Тема письма</td>
        <td>
            <input size="100" type="text" name="subject_user_cart"  value="<?php echo $subject_user_cart; ?>">
        </td>
    </tr>
    <tr>
        <td>
            Описание
        </td>
        <td>
            <textarea name="text_info_cart" id="text_info_cart" cols="100" rows="20">
                <?php echo $text_info_cart; ?>
            </textarea>

            <script type="text/javascript"><!--
                CKEDITOR.replace('text_info_cart', {
                    filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
                    filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
                    filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
                    filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
                    filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
                    filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>'
                });
                //-->
            </script>
        </td>
    </tr>
</table>

<h2><?php echo $text_product; ?></h2>
<table class="form">
    <tr>
        <td><?php echo $entry_product_count; ?></td>
        <td><?php if ($config_product_count) { ?>
            <input type="radio" name="config_product_count" value="1" checked="checked" />
            <?php echo $text_yes; ?>
            <input type="radio" name="config_product_count" value="0" />
            <?php echo $text_no; ?>
            <?php } else { ?>
            <input type="radio" name="config_product_count" value="1" />
            <?php echo $text_yes; ?>
            <input type="radio" name="config_product_count" value="0" checked="checked" />
            <?php echo $text_no; ?>
            <?php } ?></td>
    </tr>
    <tr>
        <td><?php echo $entry_review; ?></td>
        <td><?php if ($config_review_status) { ?>
                <input type="radio" name="config_review_status" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <input type="radio" name="config_review_status" value="0" />
                <?php echo $text_no; ?>
            <?php } else { ?>
                <input type="radio" name="config_review_status" value="1" />
                <?php echo $text_yes; ?>
                <input type="radio" name="config_review_status" value="0" checked="checked" />
                <?php echo $text_no; ?>
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td>
            Комментирование разрешено, только зарегистрированым пользователям
        </td>
        <td>
            <input type="radio" name="config_comment_status_reg" value="0"
            <?php if ($config_comment_status_reg == 0) { ?>
                checked="checked"
            <?php } ?>

            /><?php echo $text_no; ?>

            <input type="radio" name="config_comment_status_reg" value="1"

            <?php if ($config_comment_status_reg == 1) { ?>
                 checked="checked"
            <?php } ?>

            /><?php echo $text_yes; ?>
        </td>
    </tr>
    <tr>
        <td>
            Комментарии сразу публикуются на сайте, без модерирования
        </td>
        <td>
            <input type="radio" name="config_comment_status_now" value="0"
            <?php if ($config_comment_status_now == 0) { ?>
                checked="checked"
            <?php } ?>

            /><?php echo $text_no; ?>

            <input type="radio" name="config_comment_status_now" value="1"

            <?php if ($config_comment_status_now == 1) { ?>
                checked="checked"
            <?php } ?>

            /><?php echo $text_yes; ?>
        </td>
    </tr>
    <tr>
        <td>
            Рейтинг
        </td>
        <td>
            <input type="radio" name="config_comment_rating" value="0"
            <?php if ($config_comment_rating == 0) { ?>
            checked="checked"
            <?php } ?>

            /><?php echo $text_no; ?>

            <input type="radio" name="config_comment_rating" value="1"

            <?php if ($config_comment_rating == 1) { ?>
            checked="checked"
            <?php } ?>

            /><?php echo $text_yes; ?>
        </td>
    </tr>
    <tr>
        <td>
            Лимит голосования рейтинга в записи
        </td>
        <td>
            <input type="number" name="config_comment_rating_num"
            <?php if ($config_comment_rating_num) { ?>
            value="<?php echo $config_comment_rating_num; ?>"
            <?php } ?>
            />
        </td>
    </tr>
    <tr>
        <td><?php echo $entry_download; ?></td>
        <td><?php if ($config_download) { ?>
            <input type="radio" name="config_download" value="1" checked="checked" />
            <?php echo $text_yes; ?>
            <input type="radio" name="config_download" value="0" />
            <?php echo $text_no; ?>
            <?php } else { ?>
            <input type="radio" name="config_download" value="1" />
            <?php echo $text_yes; ?>
            <input type="radio" name="config_download" value="0" checked="checked" />
            <?php echo $text_no; ?>
            <?php } ?></td>
    </tr>
    <tr>
        <td><?php echo $entry_upload_allowed; ?></td>
        <td><textarea name="config_upload_allowed" cols="40" rows="5"><?php echo $config_upload_allowed; ?></textarea></td>
    </tr>
</table>
<h2><?php echo $text_voucher; ?></h2>
<table class="form">
    <tr>
        <td><?php echo $entry_voucher_min; ?></td>
        <td><input type="text" name="config_voucher_min" value="<?php echo $config_voucher_min; ?>" />
            <?php if ($error_voucher_min) { ?>
            <span class="error"><?php echo $error_voucher_min; ?></span>
            <?php } ?></td>
    </tr>
    <tr>
        <td><?php echo $entry_voucher_max; ?></td>
        <td><input type="text" name="config_voucher_max" value="<?php echo $config_voucher_max; ?>" />
            <?php if ($error_voucher_max) { ?>
            <span class="error"><?php echo $error_voucher_max; ?></span>
            <?php } ?></td>
    </tr>
</table>
<h2><?php echo $text_tax; ?></h2>
<table class="form">
    <tr>
        <td><?php echo $entry_tax; ?></td>
        <td><?php if ($config_tax) { ?>
            <input type="radio" name="config_tax" value="1" checked="checked" />
            <?php echo $text_yes; ?>
            <input type="radio" name="config_tax" value="0" />
            <?php echo $text_no; ?>
            <?php } else { ?>
            <input type="radio" name="config_tax" value="1" />
            <?php echo $text_yes; ?>
            <input type="radio" name="config_tax" value="0" checked="checked" />
            <?php echo $text_no; ?>
            <?php } ?></td>
    </tr>
    <tr>
        <td><?php echo $entry_vat; ?></td>
        <td><?php if ($config_vat) { ?>
            <input type="radio" name="config_vat" value="1" checked="checked" />
            <?php echo $text_yes; ?>
            <input type="radio" name="config_vat" value="0" />
            <?php echo $text_no; ?>
            <?php } else { ?>
            <input type="radio" name="config_vat" value="1" />
            <?php echo $text_yes; ?>
            <input type="radio" name="config_vat" value="0" checked="checked" />
            <?php echo $text_no; ?>
            <?php } ?></td>
    </tr>
    <tr>
        <td><?php echo $entry_tax_default; ?></td>
        <td><select name="config_tax_default">
                <option value=""><?php echo $text_none; ?></option>
                <?php  if ($config_tax_default == 'shipping') { ?>
                <option value="shipping" selected="selected"><?php echo $text_shipping; ?></option>
                <?php } else { ?>
                <option value="shipping"><?php echo $text_shipping; ?></option>
                <?php } ?>
                <?php  if ($config_tax_default == 'payment') { ?>
                <option value="payment" selected="selected"><?php echo $text_payment; ?></option>
                <?php } else { ?>
                <option value="payment"><?php echo $text_payment; ?></option>
                <?php } ?>
            </select></td>
    </tr>
    <tr>
        <td><?php echo $entry_tax_customer; ?></td>
        <td><select name="config_tax_customer">
                <option value=""><?php echo $text_none; ?></option>
                <?php  if ($config_tax_customer == 'shipping') { ?>
                <option value="shipping" selected="selected"><?php echo $text_shipping; ?></option>
                <?php } else { ?>
                <option value="shipping"><?php echo $text_shipping; ?></option>
                <?php } ?>
                <?php  if ($config_tax_customer == 'payment') { ?>
                <option value="payment" selected="selected"><?php echo $text_payment; ?></option>
                <?php } else { ?>
                <option value="payment"><?php echo $text_payment; ?></option>
                <?php } ?>
            </select></td>
    </tr>
</table>
<h2><?php echo $text_account; ?></h2>
<table class="form">
    <tr>
        <td><?php echo $entry_customer_group; ?></td>
        <td><select name="config_customer_group_id">
                <?php foreach ($customer_groups as $customer_group) { ?>
                <?php if ($customer_group['customer_group_id'] == $config_customer_group_id) { ?>
                <option value="<?php echo $customer_group['customer_group_id']; ?>" selected="selected"><?php echo $customer_group['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>
                <?php } ?>
                <?php } ?>
            </select></td>
    </tr>
    <tr>
        <td><?php echo $entry_customer_group_display; ?></td>
        <td><div class="scrollbox">
                <?php $class = 'odd'; ?>
                <?php foreach ($customer_groups as $customer_group) { ?>
                <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                <div class="<?php echo $class; ?>">
                    <?php if (in_array($customer_group['customer_group_id'], $config_customer_group_display)) { ?>
                    <input type="checkbox" name="config_customer_group_display[]" value="<?php echo $customer_group['customer_group_id']; ?>" checked="checked" />
                    <?php echo $customer_group['name']; ?>
                    <?php } else { ?>
                    <input type="checkbox" name="config_customer_group_display[]" value="<?php echo $customer_group['customer_group_id']; ?>" />
                    <?php echo $customer_group['name']; ?>
                    <?php } ?>
                </div>
                <?php } ?>
            </div>
            <?php if ($error_customer_group_display) { ?>
            <span class="error"><?php echo $error_customer_group_display; ?></span>
            <?php } ?></td>
    </tr>
    <tr>
        <td><?php echo $entry_customer_price; ?></td>
        <td><?php if ($config_customer_price) { ?>
            <input type="radio" name="config_customer_price" value="1" checked="checked" />
            <?php echo $text_yes; ?>
            <input type="radio" name="config_customer_price" value="0" />
            <?php echo $text_no; ?>
            <?php } else { ?>
            <input type="radio" name="config_customer_price" value="1" />
            <?php echo $text_yes; ?>
            <input type="radio" name="config_customer_price" value="0" checked="checked" />
            <?php echo $text_no; ?>
            <?php } ?></td>
    </tr>
    <tr>
        <td><?php echo $entry_account; ?></td>
        <td><select name="config_account_id">
                <option value="0"><?php echo $text_none; ?></option>
                <?php foreach ($informations as $information) { ?>
                <?php if ($information['information_id'] == $config_account_id) { ?>
                <option value="<?php echo $information['information_id']; ?>" selected="selected"><?php echo $information['title']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $information['information_id']; ?>"><?php echo $information['title']; ?></option>
                <?php } ?>
                <?php } ?>
            </select></td>
    </tr>
</table>
<h2><?php echo $text_checkout; ?></h2>
<table class="form">
    <tr>
        <td><?php echo $entry_cart_weight; ?></td>
        <td><?php if ($config_cart_weight) { ?>
            <input type="radio" name="config_cart_weight" value="1" checked="checked" />
            <?php echo $text_yes; ?>
            <input type="radio" name="config_cart_weight" value="0" />
            <?php echo $text_no; ?>
            <?php } else { ?>
            <input type="radio" name="config_cart_weight" value="1" />
            <?php echo $text_yes; ?>
            <input type="radio" name="config_cart_weight" value="0" checked="checked" />
            <?php echo $text_no; ?>
            <?php } ?></td>
    </tr>
    <tr>
        <td><?php echo $entry_guest_checkout; ?></td>
        <td><?php if ($config_guest_checkout) { ?>
            <input type="radio" name="config_guest_checkout" value="1" checked="checked" />
            <?php echo $text_yes; ?>
            <input type="radio" name="config_guest_checkout" value="0" />
            <?php echo $text_no; ?>
            <?php } else { ?>
            <input type="radio" name="config_guest_checkout" value="1" />
            <?php echo $text_yes; ?>
            <input type="radio" name="config_guest_checkout" value="0" checked="checked" />
            <?php echo $text_no; ?>
            <?php } ?></td>
    </tr>
    <tr>
        <td><?php echo $entry_checkout; ?></td>
        <td><select name="config_checkout_id">
                <option value="0"><?php echo $text_none; ?></option>
                <?php foreach ($informations as $information) { ?>
                <?php if ($information['information_id'] == $config_checkout_id) { ?>
                <option value="<?php echo $information['information_id']; ?>" selected="selected"><?php echo $information['title']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $information['information_id']; ?>"><?php echo $information['title']; ?></option>
                <?php } ?>
                <?php } ?>
            </select></td>
    </tr>
    <tr>
        <td><?php echo $entry_order_edit; ?></td>
        <td><input type="text" name="config_order_edit" value="<?php echo $config_order_edit; ?>" size="3" /></td>
    </tr>
    <tr>
        <td><?php echo $entry_invoice_prefix; ?></td>
        <td><input type="text" name="config_invoice_prefix" value="<?php echo $config_invoice_prefix; ?>" /></td>
    </tr>
    <tr>
        <td><?php echo $entry_order_status; ?></td>
        <td><select name="config_order_status_id">
                <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $config_order_status_id) { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
                <?php } ?>
            </select></td>
    </tr>
    <tr>
        <td><?php echo $entry_complete_status; ?></td>
        <td><select name="config_complete_status_id">
                <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $config_complete_status_id) { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
                <?php } ?>
            </select></td>
    </tr>
</table>
<h2><?php echo $text_stock; ?></h2>
<table class="form">
    <tr>
        <td><?php echo $entry_stock_display; ?></td>
        <td><?php if ($config_stock_display) { ?>
            <input type="radio" name="config_stock_display" value="1" checked="checked" />
            <?php echo $text_yes; ?>
            <input type="radio" name="config_stock_display" value="0" />
            <?php echo $text_no; ?>
            <?php } else { ?>
            <input type="radio" name="config_stock_display" value="1" />
            <?php echo $text_yes; ?>
            <input type="radio" name="config_stock_display" value="0" checked="checked" />
            <?php echo $text_no; ?>
            <?php } ?></td>
    </tr>
    <tr>
        <td><?php echo $entry_stock_warning; ?></td>
        <td><?php if ($config_stock_warning) { ?>
            <input type="radio" name="config_stock_warning" value="1" checked="checked" />
            <?php echo $text_yes; ?>
            <input type="radio" name="config_stock_warning" value="0" />
            <?php echo $text_no; ?>
            <?php } else { ?>
            <input type="radio" name="config_stock_warning" value="1" />
            <?php echo $text_yes; ?>
            <input type="radio" name="config_stock_warning" value="0" checked="checked" />
            <?php echo $text_no; ?>
            <?php } ?></td>
    </tr>
    <tr>
        <td><?php echo $entry_stock_checkout; ?></td>
        <td><?php if ($config_stock_checkout) { ?>
            <input type="radio" name="config_stock_checkout" value="1" checked="checked" />
            <?php echo $text_yes; ?>
            <input type="radio" name="config_stock_checkout" value="0" />
            <?php echo $text_no; ?>
            <?php } else { ?>
            <input type="radio" name="config_stock_checkout" value="1" />
            <?php echo $text_yes; ?>
            <input type="radio" name="config_stock_checkout" value="0" checked="checked" />
            <?php echo $text_no; ?>
            <?php } ?></td>
    </tr>
    <tr>
        <td><?php echo $entry_stock_status; ?></td>
        <td><select name="config_stock_status_id">
                <?php foreach ($stock_statuses as $stock_status) { ?>
                <?php if ($stock_status['stock_status_id'] == $config_stock_status_id) { ?>
                <option value="<?php echo $stock_status['stock_status_id']; ?>" selected="selected"><?php echo $stock_status['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $stock_status['stock_status_id']; ?>"><?php echo $stock_status['name']; ?></option>
                <?php } ?>
                <?php } ?>
            </select></td>
    </tr>
</table>
<h2><?php echo $text_affiliate; ?></h2>
<table class="form">
    <tr>
        <td><?php echo $entry_affiliate; ?></td>
        <td><select name="config_affiliate_id">
                <option value="0"><?php echo $text_none; ?></option>
                <?php foreach ($informations as $information) { ?>
                <?php if ($information['information_id'] == $config_affiliate_id) { ?>
                <option value="<?php echo $information['information_id']; ?>" selected="selected"><?php echo $information['title']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $information['information_id']; ?>"><?php echo $information['title']; ?></option>
                <?php } ?>
                <?php } ?>
            </select></td>
    </tr>
    <tr>
        <td><?php echo $entry_commission; ?></td>
        <td><input type="text" name="config_commission" value="<?php echo $config_commission; ?>" size="3" /></td>
    </tr>
</table>
<h2><?php echo $text_return; ?></h2>
<table class="form">
    <tr>
        <td><?php echo $entry_return_status; ?></td>
        <td><select name="config_return_status_id">
                <?php foreach ($return_statuses as $return_status) { ?>
                <?php if ($return_status['return_status_id'] == $config_return_status_id) { ?>
                <option value="<?php echo $return_status['return_status_id']; ?>" selected="selected"><?php echo $return_status['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $return_status['return_status_id']; ?>"><?php echo $return_status['name']; ?></option>
                <?php } ?>
                <?php } ?>
            </select></td>
    </tr>
</table>
</div>
<div id="tab-image">
    <table class="form">
        <tr>
            <td><?php echo $entry_logo; ?></td>
            <td><div class="image"><img src="<?php echo $logo; ?>" alt="" id="thumb-logo" />
                    <input type="hidden" name="config_logo" value="<?php echo $config_logo; ?>" id="logo" />
                    <br />
                    <a onclick="image_upload('logo', 'thumb-logo');"><?php echo $text_browse; ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a onclick="$('#thumb-logo').attr('src', '<?php echo $no_image; ?>'); $('#logo').attr('value', '');"><?php echo $text_clear; ?></a></div></td>
        </tr>
        <tr>
            <td><?php echo $entry_icon; ?></td>
            <td><div class="image"><img src="<?php echo $icon; ?>" alt="" id="thumb-icon" />
                    <input type="hidden" name="config_icon" value="<?php echo $config_icon; ?>" id="icon" />
                    <br />
                    <a onclick="image_upload('icon', 'thumb-icon');"><?php echo $text_browse; ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a onclick="$('#thumb-icon').attr('src', '<?php echo $no_image; ?>'); $('#icon').attr('value', '');"><?php echo $text_clear; ?></a></div></td>
        </tr>
        <tr>
            <td><span class="required">*</span> <?php echo $entry_image_category; ?></td>
            <td><input type="text" name="config_image_category_width" value="<?php echo $config_image_category_width; ?>" size="3" />
                x
                <input type="text" name="config_image_category_height" value="<?php echo $config_image_category_height; ?>" size="3" />
                <?php if ($error_image_category) { ?>
                <span class="error"><?php echo $error_image_category; ?></span>
                <?php } ?></td>
        </tr>

        <tr>
            <td><span class="required">*</span> <?php echo $entry_image_category_menu; ?></td>
            <td><input type="text" name="config_image_category_menu_width" value="<?php echo $config_image_category_menu_width; ?>" size="3" />
                x
                <input type="text" name="config_image_category_menu_height" value="<?php echo $config_image_category_menu_height; ?>" size="3" />
                <?php if ($error_image_category_menu) { ?>
                <span class="error"><?php echo $error_image_category_menu; ?></span>
                <?php } ?></td>
        </tr>

        <tr>
            <td><span class="required">*</span> <?php echo $entry_image_thumb; ?></td>
            <td><input type="text" name="config_image_thumb_width" value="<?php echo $config_image_thumb_width; ?>" size="3" />
                x
                <input type="text" name="config_image_thumb_height" value="<?php echo $config_image_thumb_height; ?>" size="3" />
                <?php if ($error_image_thumb) { ?>
                <span class="error"><?php echo $error_image_thumb; ?></span>
                <?php } ?></td>
        </tr>
        <tr>
            <td><span class="required">*</span> <?php echo $entry_image_popup; ?></td>
            <td><input type="text" name="config_image_popup_width" value="<?php echo $config_image_popup_width; ?>" size="3" />
                x
                <input type="text" name="config_image_popup_height" value="<?php echo $config_image_popup_height; ?>" size="3" />
                <?php if ($error_image_popup) { ?>
                <span class="error"><?php echo $error_image_popup; ?></span>
                <?php } ?></td>
        </tr>
        <tr>
            <td><span class="required">*</span> <?php echo $entry_image_product; ?></td>
            <td><input type="text" name="config_image_product_width" value="<?php echo $config_image_product_width; ?>" size="3" />
                x
                <input type="text" name="config_image_product_height" value="<?php echo $config_image_product_height; ?>" size="3" />
                <?php if ($error_image_product) { ?>
                <span class="error"><?php echo $error_image_product; ?></span>
                <?php } ?></td>
        </tr>
        <tr>
            <td><span class="required">*</span> <?php echo $entry_image_additional; ?></td>
            <td><input type="text" name="config_image_additional_width" value="<?php echo $config_image_additional_width; ?>" size="3" />
                x
                <input type="text" name="config_image_additional_height" value="<?php echo $config_image_additional_height; ?>" size="3" />
                <?php if ($error_image_additional) { ?>
                <span class="error"><?php echo $error_image_additional; ?></span>
                <?php } ?></td>
        </tr>
        <tr>
            <td><span class="required">*</span> <?php echo $entry_image_related; ?></td>
            <td><input type="text" name="config_image_related_width" value="<?php echo $config_image_related_width; ?>" size="3" />
                x
                <input type="text" name="config_image_related_height" value="<?php echo $config_image_related_height; ?>" size="3" />
                <?php if ($error_image_related) { ?>
                <span class="error"><?php echo $error_image_related; ?></span>
                <?php } ?></td>
        </tr>
        <tr>
            <td><span class="required">*</span> <?php echo $entry_image_compare; ?></td>
            <td><input type="text" name="config_image_compare_width" value="<?php echo $config_image_compare_width; ?>" size="3" />
                x
                <input type="text" name="config_image_compare_height" value="<?php echo $config_image_compare_height; ?>" size="3" />
                <?php if ($error_image_compare) { ?>
                <span class="error"><?php echo $error_image_compare; ?></span>
                <?php } ?></td>
        </tr>
        <tr>
            <td><span class="required">*</span> <?php echo $entry_image_wishlist; ?></td>
            <td><input type="text" name="config_image_wishlist_width" value="<?php echo $config_image_wishlist_width; ?>" size="3" />
                x
                <input type="text" name="config_image_wishlist_height" value="<?php echo $config_image_wishlist_height; ?>" size="3" />
                <?php if ($error_image_wishlist) { ?>
                <span class="error"><?php echo $error_image_wishlist; ?></span>
                <?php } ?></td>
        </tr>
        <tr>
            <td><span class="required">*</span> <?php echo $entry_image_manufacturer; ?></td>
            <td><input type="text" name="config_image_manufacturer_width" value="<?php echo $config_image_manufacturer_width; ?>" size="3" />
                x
                <input type="text" name="config_image_manufacturer_height" value="<?php echo $config_image_manufacturer_height; ?>" size="3" />
                <?php if ($error_image_manufacturer) { ?>
                <span class="error"><?php echo $error_image_manufacturer; ?></span>
                <?php } ?></td>
        </tr>
        <tr>
            <td><span class="required">*</span> <?php echo $entry_image_manufacturer_menu; ?></td>
            <td><input type="text" name="config_image_manufacturer_menu_width" value="<?php echo $config_image_manufacturer_menu_width; ?>" size="3" />
                x
                <input type="text" name="config_image_manufacturer_menu_height" value="<?php echo $config_image_manufacturer_menu_height; ?>" size="3" />
                <?php if ($error_image_manufacturer_menu) { ?>
                <span class="error"><?php echo $error_image_manufacturer_menu; ?></span>
                <?php } ?></td>
        </tr>
        <tr>
            <td><span class="required">*</span> <?php echo $entry_image_manufacturer_main; ?></td>
            <td><input type="text" name="config_image_manufacturer_width_main" value="<?php echo $config_image_manufacturer_width_main; ?>" size="3" />
                x
                <input type="text" name="config_image_manufacturer_height_main" value="<?php echo $config_image_manufacturer_height_main; ?>" size="3" />
                <?php if ($error_image_manufacturer_main) { ?>
                <span class="error"><?php echo $error_image_manufacturer_main; ?></span>
                <?php } ?></td>
        </tr>
        <tr>
            <td><span class="required">*</span> <?php echo $entry_image_cart; ?></td>
            <td><input type="text" name="config_image_cart_width" value="<?php echo $config_image_cart_width; ?>" size="3" />
                x
                <input type="text" name="config_image_cart_height" value="<?php echo $config_image_cart_height; ?>" size="3" />
                <?php if ($error_image_cart) { ?>
                <span class="error"><?php echo $error_image_cart; ?></span>
                <?php } ?></td>
        </tr>
    </table>
</div>
<div id="tab-mail">
    <table class="form">
        <tr>
            <td><?php echo $entry_mail_protocol; ?></td>
            <td><select name="config_mail_protocol">
                    <?php if ($config_mail_protocol == 'mail') { ?>
                    <option value="mail" selected="selected"><?php echo $text_mail; ?></option>
                    <?php } else { ?>
                    <option value="mail"><?php echo $text_mail; ?></option>
                    <?php } ?>
                    <?php if ($config_mail_protocol == 'smtp') { ?>
                    <option value="smtp" selected="selected"><?php echo $text_smtp; ?></option>
                    <?php } else { ?>
                    <option value="smtp"><?php echo $text_smtp; ?></option>
                    <?php } ?>
                </select></td>
        </tr>
        <tr>
            <td><?php echo $entry_mail_parameter; ?></td>
            <td><input type="text" name="config_mail_parameter" value="<?php echo $config_mail_parameter; ?>" /></td>
        </tr>
        <tr>
            <td><?php echo $entry_smtp_host; ?></td>
            <td><input type="text" name="config_smtp_host" value="<?php echo $config_smtp_host; ?>" /></td>
        </tr>
        <tr>
            <td><?php echo $entry_smtp_username; ?></td>
            <td><input type="text" name="config_smtp_username" value="<?php echo $config_smtp_username; ?>" /></td>
        </tr>
        <tr>
            <td><?php echo $entry_smtp_password; ?></td>
            <td><input type="text" name="config_smtp_password" value="<?php echo $config_smtp_password; ?>" /></td>
        </tr>
        <tr>
            <td><?php echo $entry_smtp_port; ?></td>
            <td><input type="text" name="config_smtp_port" value="<?php echo $config_smtp_port; ?>" /></td>
        </tr>
        <tr>
            <td><?php echo $entry_smtp_timeout; ?></td>
            <td><input type="text" name="config_smtp_timeout" value="<?php echo $config_smtp_timeout; ?>" /></td>
        </tr>
        <tr>
            <td><?php echo $entry_alert_mail; ?></td>
            <td><?php if ($config_alert_mail) { ?>
                <input type="radio" name="config_alert_mail" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <input type="radio" name="config_alert_mail" value="0" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="config_alert_mail" value="1" />
                <?php echo $text_yes; ?>
                <input type="radio" name="config_alert_mail" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } ?></td>
        </tr>
        <tr>
            <td><?php echo $entry_account_mail; ?></td>
            <td><?php if ($config_account_mail) { ?>
                <input type="radio" name="config_account_mail" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <input type="radio" name="config_account_mail" value="0" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="config_account_mail" value="1" />
                <?php echo $text_yes; ?>
                <input type="radio" name="config_account_mail" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } ?></td>
        </tr>
        <tr>
            <td><?php echo $entry_alert_emails; ?></td>
            <td><textarea name="config_alert_emails" cols="40" rows="5"><?php echo $config_alert_emails; ?></textarea></td>
        </tr>
    </table>
</div>
<div id="tab-fraud">
    <table class="form">
        <tr>
            <td><?php echo $entry_fraud_detection; ?></td>
            <td><?php if ($config_fraud_detection) { ?>
                <input type="radio" name="config_fraud_detection" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <input type="radio" name="config_fraud_detection" value="0" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="config_fraud_detection" value="1" />
                <?php echo $text_yes; ?>
                <input type="radio" name="config_fraud_detection" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } ?></td>
        </tr>
        <tr>
            <td><?php echo $entry_fraud_key; ?></td>
            <td><input type="text" name="config_fraud_key" value="<?php echo $config_fraud_key; ?>" /></td>
        </tr>
        <tr>
            <td><?php echo $entry_fraud_score; ?></td>
            <td><input type="text" name="config_fraud_score" value="<?php echo $config_fraud_score; ?>" /></td>
        </tr>
        <tr>
            <td><?php echo $entry_fraud_status; ?></td>
            <td><select name="config_fraud_status_id">
                    <?php foreach ($order_statuses as $order_status) { ?>
                    <?php if ($order_status['order_status_id'] == $config_fraud_status_id) { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                </select></td>
        </tr>
    </table>
</div>
<div id="tab-sms">
    <table class="form">
        <tr>
            <td><?php echo $entry_sms_alert; ?></td>
            <td><?php if ($config_sms_alert) { ?>
                <input type="radio" name="config_sms_alert" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <input type="radio" name="config_sms_alert" value="0" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="config_sms_alert" value="1" />
                <?php echo $text_yes; ?>
                <input type="radio" name="config_sms_alert" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } ?></td>
        </tr>
        <tr>
            <td><?php echo $entry_sms_gatename; ?></td>
            <td>
                <select name="config_sms_gatename">
                    <?php foreach($sms_gatenames as $sms_gatename) { ?>
                    <?php if ($config_sms_gatename == $sms_gatename) { ?>
                    <option value="<?php echo $sms_gatename; ?>" selected="selected"><?php echo $sms_gatename; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $sms_gatename; ?>"><?php echo $sms_gatename; ?></option>
                    <?php } ?>
                    <?php } ?>
                </select>
            </td>
        </tr>
        <tr>
            <td><?php echo $entry_sms_from; ?></td>
            <td><input type="text" name="config_sms_from" value="<?php echo $config_sms_from; ?>" maxlength="15" /></td>
        </tr>
        <tr>
            <td><?php echo $entry_sms_to; ?></td>
            <td><input type="text" name="config_sms_to" value="<?php echo $config_sms_to; ?>" maxlength="15" /></td>
        </tr>
        <tr>
            <td valign="top"><?php echo $entry_sms_copy; ?></td>
            <td><textarea name="config_sms_copy" cols="40"><?php echo $config_sms_copy; ?></textarea></td>
        </tr>
        <tr>
            <td valign="top"><?php echo $entry_sms_message; ?></td>
            <td><textarea name="config_sms_message" cols="40" rows="5"><?php echo $config_sms_message; ?></textarea></td>
        </tr>
        <tr>
            <td><?php echo $entry_sms_gate_username; ?></td>
            <td><input type="text" name="config_sms_gate_username" value="<?php echo $config_sms_gate_username; ?>" /></td>
        </tr>
        <tr>
            <td><?php echo $entry_sms_gate_password; ?></td>
            <td><input type="text" name="config_sms_gate_password" value="<?php echo $config_sms_gate_password; ?>" /></td>
        </tr>
    </table>
</div>
<div id="tab-server">
    <table class="form">
        <tr>
            <td><?php echo $entry_use_ssl; ?></td>
            <td><?php if ($config_use_ssl) { ?>
                <input type="radio" name="config_use_ssl" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <input type="radio" name="config_use_ssl" value="0" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="config_use_ssl" value="1" />
                <?php echo $text_yes; ?>
                <input type="radio" name="config_use_ssl" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } ?></td>
        </tr>
        <tr>
            <td><?php echo $entry_seo_url; ?></td>
            <td><?php if ($config_seo_url) { ?>
                <input type="radio" name="config_seo_url" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <input type="radio" name="config_seo_url" value="0" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="config_seo_url" value="1" />
                <?php echo $text_yes; ?>
                <input type="radio" name="config_seo_url" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } ?></td>
        </tr>
        <tr>
            <td><?php echo $entry_seo_url_type; ?></td>
            <td><select name="config_seo_url_type">
                    <?php foreach ($seo_types as $seo_type) { ?>
                    <?php if ($seo_type['type'] == $config_seo_url_type) { ?>
                    <option value="<?php echo $seo_type['type']; ?>" selected="selected"><?php echo $seo_type['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $seo_type['type']; ?>"><?php echo $seo_type['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                </select></td>
        </tr>
        <tr>
            <td><?php echo $entry_seo_url_include_path; ?></td>
            <td><?php if ($config_seo_url_include_path) { ?>
                <input type="radio" name="config_seo_url_include_path" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <input type="radio" name="config_seo_url_include_path" value="0" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="config_seo_url_include_path" value="1" />
                <?php echo $text_yes; ?>
                <input type="radio" name="config_seo_url_include_path" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } ?></td>
        </tr>
        <tr>
            <td><?php echo $entry_seo_url_postfix; ?></td>
            <td><input type="text" name="config_seo_url_postfix" value="<?php echo $config_seo_url_postfix; ?>" size="3" /></td>
        </tr>
        <tr>
            <td><?php echo $entry_maintenance; ?></td>
            <td><?php if ($config_maintenance) { ?>
                <input type="radio" name="config_maintenance" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <input type="radio" name="config_maintenance" value="0" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="config_maintenance" value="1" />
                <?php echo $text_yes; ?>
                <input type="radio" name="config_maintenance" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } ?></td>
        </tr>
        <tr>
            <td><?php echo $entry_encryption; ?></td>
            <td><input type="text" name="config_encryption" value="<?php echo $config_encryption; ?>" /></td>
        </tr>
        <tr>
            <td><?php echo $entry_compression; ?></td>
            <td><input type="text" name="config_compression" value="<?php echo $config_compression; ?>" size="3" /></td>
        </tr>
        <tr>
            <td><?php echo $entry_error_display; ?></td>
            <td><?php if ($config_error_display) { ?>
                <input type="radio" name="config_error_display" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <input type="radio" name="config_error_display" value="0" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="config_error_display" value="1" />
                <?php echo $text_yes; ?>
                <input type="radio" name="config_error_display" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } ?></td>
        </tr>
        <tr>
            <td><?php echo $entry_error_log; ?></td>
            <td><?php if ($config_error_log) { ?>
                <input type="radio" name="config_error_log" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <input type="radio" name="config_error_log" value="0" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="config_error_log" value="1" />
                <?php echo $text_yes; ?>
                <input type="radio" name="config_error_log" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } ?></td>
        </tr>
        <tr>
            <td><span class="required">*</span> <?php echo $entry_error_filename; ?></td>
            <td><input type="text" name="config_error_filename" value="<?php echo $config_error_filename; ?>" />
                <?php if ($error_error_filename) { ?>
                <span class="error"><?php echo $error_error_filename; ?></span>
                <?php } ?></td>
        </tr>
        <tr>
            <td><?php echo $entry_google_analytics; ?></td>
            <td><textarea name="config_google_analytics" cols="40" rows="5"><?php echo $config_google_analytics; ?></textarea></td>
        </tr>
    </table>
</div>
</form>
</div>
</div>
</div>
<script type="text/javascript"><!--
    $('#template').load('index.php?route=setting/setting/template&token=<?php echo $token; ?>&template=' + encodeURIComponent($('select[name=\'config_template\']').attr('value')));
    //--></script>
<script type="text/javascript"><!--
    $('select[name=\'config_country_id\']').bind('change', function() {
        $.ajax({
            url: 'index.php?route=setting/setting/country&token=<?php echo $token; ?>&country_id=' + this.value,
            dataType: 'json',
            beforeSend: function() {
                $('select[name=\'country_id\']').after('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
            },
            complete: function() {
                $('.wait').remove();
            },
            success: function(json) {
                if (json['postcode_required'] == '1') {
                    $('#postcode-required').show();
                } else {
                    $('#postcode-required').hide();
                }

                html = '<option value=""><?php echo $text_select; ?></option>';

                if (json['zone'] != '') {
                    for (i = 0; i < json['zone'].length; i++) {
                        html += '<option value="' + json['zone'][i]['zone_id'] + '"';

                        if (json['zone'][i]['zone_id'] == '<?php echo $config_zone_id; ?>') {
                            html += ' selected="selected"';
                        }

                        html += '>' + json['zone'][i]['name'] + '</option>';
                    }
                } else {
                    html += '<option value="0" selected="selected><?php echo $text_none; ?></option>';
                }

                $('select[name=\'config_zone_id\']').html(html);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    });

    $('select[name=\'config_country_id\']').trigger('change');
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
                        url: 'index.php?route=common/filemanager/image&token=<?php echo $token; ?>&image=' + encodeURIComponent($('#' + field).val()),
                        dataType: 'text',
                        success: function(data) {
                            $('#' + thumb).replaceWith('<img src="' + data + '" alt="" id="' + thumb + '" />');
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

    function box_product(obj, id, name) {
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
            html += '       <input type="hidden" name="discount_birthday_days_products[]" value="' + id + '">';
            html +=         '(' + id + ') ' + name;
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

        var url  = "index.php?route=catalog/product/getProduct&token=<?php echo $token; ?>";

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

                            if (type == 'category') {
                                html += '    <input type="checkbox" onclick="box_product(this, ' + $(this).attr('product_id') + ', \'' + $(this).attr('name') + '\');" id="product_data" >';
                            }

                            html +=          "(" + $(this).attr('product_id') + ") " + $(this).attr('name');
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

    function deleteProduct(obj) {
        $(obj).parent().remove();
    }
    //--></script>
<script type="text/javascript"><!--
    $('#tabs a').tabs();
    //--></script>
<?php echo $footer; ?>