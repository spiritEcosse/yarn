<?php echo $header; ?>

<div class="title-holder">
    <div class="inner">
        <div class="breadcrumb">
            <?php foreach ($breadcrumbs as $breadcrumb) { ?>
            <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
            <?php } ?>
        </div>
    </div>
</div>

<div class="inner">
    <?php echo $column_left; ?>
    <?php echo $column_right; ?>

    <div id="content">
        <h2 class="heading_title"><span><?php echo $heading_title; ?></span></h2>
        <?php echo $content_top; ?>

        <b><?php echo $text_critea; ?></b>
        <div class="content filter">
            <p>
                <?php echo $entry_search; ?>
                <input type="text" name="filter_name" value="<?php echo $filter_name; ?>" onclick="this.value = '';" onkeydown="this.style.color = '000000'" style="color: #999;"/>

                <?php $indent = "&nbsp;&nbsp;"; ?>
                <select name="filter_category_id">
                    <option value="0"><?php echo $text_category; ?></option>

                    <?php foreach ($categories as $category) { ?>
                        <option

                        <?php if ($filter_category_id == $category['category_id']) { ?>
                            selected
                        <?php } ?>

                        value="<?php echo $category['category_id']; ?>"><?php echo $category['name']; ?></option>
                        <?php getSubCategoriesSearch($category['children'], $indent, $filter_category_id); ?>
                    <?php } ?>
                </select>

                <?php if ($filter_sub_category) { ?>
                    <input type="checkbox" name="filter_sub_category" value="1" id="sub_category" checked="checked" />
                <?php } else { ?>
                    <input type="checkbox" name="filter_sub_category" value="1" id="sub_category" />
                <?php } ?>

                <label for="sub_category"><?php echo $text_sub_category; ?></label>
            </p>

            <?php if ($filter_description) { ?>
                <input type="checkbox" name="filter_description" value="1" id="description" checked="checked" />
            <?php } else { ?>
                <input type="checkbox" name="filter_description" value="1" id="description" />
            <?php } ?>

            <label for="description"><?php echo $entry_description; ?></label>
            <div class="buttons">
                <div class="right"><input type="button" value="<?php echo $button_search; ?>" id="button-search" class="button" /></div>
            </div>
        </div>

        <h2><?php echo $text_search; ?></h2>

        <?php include(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/products.tpl'); ?>

        <?php echo $content_bottom; ?>
    </div>
</div>

<?php function getSubCategoriesSearch($categories, $indent, $filter_category_id) { ?>
    <?php $indent .= $indent; ?>

    <?php foreach ($categories as $category) { ?>
        <option

        <?php if ($filter_category_id == $category['category_id']) { ?>
            selected
        <?php } ?>

        value="<?php echo $category['category_id']; ?>"><?php echo $indent . $category['name']; ?></option>
        <?php getSubCategoriesSearch($category['children'], $indent, $filter_category_id); ?>
    <?php } ?>
<?php } ?>

<script type="text/javascript"><!--
    $('#content input[name=\'filter_name\']').keydown(function(e) {
        if (e.keyCode == 13) {
            $('#button-search').trigger('click');
        }
    });

    $('#button-search').bind('click', function() {
        url = $('base').attr('href') + 'index.php?route=product/search';

        var filter_name = $('#content input[name=\'filter_name\']').attr('value');

        if (filter_name) {
            url += '&filter_name=' + encodeURIComponent(filter_name);

            var filter_category_id = $('#content select[name=\'filter_category_id\']').attr('value');

            if (filter_category_id > 0) {
                url += '&filter_category_id=' + encodeURIComponent(filter_category_id);
            }

            var filter_sub_category = $('#content input[name=\'filter_sub_category\']:checked').attr('value');

            if (filter_sub_category) {
                url += '&filter_sub_category=true';
            }

            var filter_description = $('#content input[name=\'filter_description\']:checked').attr('value');

            if (filter_description) {
                url += '&filter_description=true';
            }

            location = url;
        }
    });

    $('select[name=\'filter_category_id\']').bind('change', function() {
        if (this.value == '0') {
            $('input[name=\'filter_sub_category\']').attr('disabled', 'disabled');
            $('input[name=\'filter_sub_category\']').removeAttr('checked');
        } else {
            $('input[name=\'filter_sub_category\']').removeAttr('disabled');
        }
    });

    $('select[name=\'filter_category_id\']').trigger('change');
    //--></script>

<?php echo $footer; ?>