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
        <div class="left"></div>
        <div class="right"></div>
        <div class="heading">
            <h1 style=""><?php echo $heading_title; ?></h1>

            <div class="buttons">
                <a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a>
                <a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a>
            </div>
        </div>
        <div class="content">
            <form id="form" action="<?php echo $action; ?>" method="post">
                <div style="float:left;width:600px;">
                    <table class="form">
                        <tr>
                            <td><?php echo $entry_name; ?></td>
                            <td>
                                <?php foreach ($languages as $language) { ?>
                                <input type="text" name="category_option_description[<?php echo $language['language_id']; ?>][name]" value="<?php echo (isset($name[$language['language_id']]) ? $name[$language['language_id']]['name'] : ''); ?>" />&nbsp;<img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /><br />
                                <?php } ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_category; ?></td>
                            <td><div class="scrollbox">
                                    <?php $class = 'odd'; ?>
                                    <?php foreach ($categories as $category) { ?>
                                    <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                                    <div class="<?php echo $class; ?>">
                                        <?php if (in_array($category['category_id'], $option_categories)) { ?>
                                        <input type="checkbox" name="category_id[]" value="<?php echo $category['category_id']; ?>" checked="checked" />
                                        <?php echo $category['name']; ?>
                                        <?php } else { ?>
                                        <input type="checkbox" name="category_id[]" value="<?php echo $category['category_id']; ?>" />
                                        <?php echo $category['name']; ?>
                                        <?php } ?>
                                    </div>
                                    <?php } ?>
                                </div>
                                <a onclick="$(this).parent().find(':checkbox').attr('checked', true);"><?php echo $text_select_all; ?></a> / <a onclick="$(this).parent().find(':checkbox').attr('checked', false);"><?php echo $text_unselect_all; ?></a></td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_sort_order; ?></td>
                            <td><input type="text" name="sort_order" value="<?php echo $sort_order; ?>" size="2" /></td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_status; ?></td>
                            <td>
                                <select name="status">
                                    <?php if ($status) { ?>
                                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                    <option value="0"><?php echo $text_disabled; ?></option>
                                    <?php } else { ?>
                                    <option value="1"><?php echo $text_enabled; ?></option>
                                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                    </table>
                </div>

                <div style="padding-left:620px;">
                    <table id="block_option" style="width: 270px;">
                        <thead>
                        <tr><th align="left" style="width: 185px;"><?php echo $entry_values; ?></th><th>&nbsp;</th></tr>
                        </thead>
                        <?php if ($option_values) { ?>
                        <?php foreach ($option_values as $value) { ?>
                        <tr id="option_value<?php echo $value['value_id']; ?>" class="option">
                            <td style="width: 170px;background-color: #F5EFD1;padding:4px;">
                                <?php foreach ($languages as $language) { ?>
                                <input type="text" name="option_value[<?php echo $value['value_id']; ?>][language][<?php echo $language['language_id']; ?>][name]" value="<?php echo (isset($value['language'][$language['language_id']]) ? $value['language'][$language['language_id']]['name'] : ''); ?>" />&nbsp;<img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /><br />
                                <?php } ?>
                            </td>

                            <td>
                                <div class="image">
                                    <img src="<?php echo $value['thumb']; ?>" alt="" id="thumb<?php echo $value['value_id']; ?>" />
                                    <input type="hidden" name="option_value[<?php echo $value['value_id']; ?>][image_option]" value="<?php echo $value['image_option']; ?>" id="image<?php echo $value['value_id']; ?>" >
                                    <a onclick="image_upload('image<?php echo $value['value_id']; ?>', 'thumb<?php echo $value['value_id']; ?>');"><?php echo $text_browse; ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a onclick="$('#thumb<?php echo $value['value_id']; ?>').attr('src', '<?php echo $no_image; ?>'); $('#image<?php echo $value['value_id']; ?>').attr('value', '');"><?php echo $text_clear; ?></a>
                                </div>
                            </td>

                            <td align="center">
                                <a onclick="removeValue('<?php echo $value['value_id']; ?>');" class="button"><span><?php echo $text_delete; ?></span></a>
                            </td>
                        </tr>
                        <?php } ?>
                        <?php } ?>
                    </table>
                    <a onclick="addValue();" class="button"><span><?php echo $text_add_value; ?></span></a>
                </div>

            </form>
        </div>
    </div>
</div>
</div>

<?php $token = $_GET['token']; ?>

<script type="text/javascript"><!--
    var option_value_row = <?php echo $last_inserted_id + 1; ?>;
    function addValue() {
        html  = '<tr id="option_value' + option_value_row + '" class="option">';
        html  += '<td style="width: 185px;background-color: #F5EFD1;padding:4px;">';
    <?php foreach ($languages as $language) { ?>
            html += '<input type="text" name="option_value[' + option_value_row + '][language][<?php echo $language['language_id']; ?>][name]" value="<?php echo $text_value; ?> ' + option_value_row + '" />&nbsp;<img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /><br />';
        <?php } ?>
        html += '</td>';

        html += '<td>';
        html += ' <div class="image">';
        html += '   <img src="<?php echo $no_image; ?>" alt="" id="thumb' + option_value_row + '" />';
        html += '   <input type="hidden" name="option_value[' + option_value_row + '][image_option]" value="" id="image' + option_value_row + '" /><br />';
        html += '   <a onclick="image_upload(\'image' + option_value_row + '\', \'thumb' + option_value_row + '\');">';
        html += '     <?php echo $text_browse; ?>';
        html += '   </a>';
        html += '   &nbsp;&nbsp;|&nbsp;&nbsp;';
        html += '   <a onclick="$(\'#thumb' + option_value_row + '\').attr(\'src\', \'<?php echo $no_image; ?>\'); $(\'#image' + option_value_row + '\').attr(\'value\', \'\');">';
        html += '     <?php echo $text_clear; ?>';
        html += '   </a>';
        html += '</div>';
        html += '</td>';

        html += '<td align="center"><a onclick="removeValue(' + option_value_row + ');" class="button"><span><?php echo $text_delete; ?></span></a></td>';
        html += '</tr>';

        $('#block_option').append(html);

        option_value_row++;
    }

    function removeValue(option_value_row) {
        $('#option_value' + option_value_row).remove();
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
<?php echo $footer; ?>