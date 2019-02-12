<?php if ($category_options) { ?>
    <div class="box" id="filters_product">
        <div class="box-heading"><?php echo $heading_title; ?></div>
        <div class="box-content">
            <form id="filters">
                <?php $flag = false; ?>

                <?php foreach ($category_options as $category_option) { ?>
                    <?php if ($category_option['active'] == 'true') { ?>
                        <?php $flag = true; ?>
                    <?php } ?>
                <?php } ?>

                <?php if ($flag == true) { ?>
                    <div class="filters_selected">
                        <div class="title_selected">Активные фильтры</div>
                <?php } ?>

                <?php foreach ($category_options as $category_option) { ?>
                    <?php if ($category_option['values'] && $category_option['active'] == 'true') { ?>
                        <div class="wrapp_option_name inactive"  onclick="slide(this);">
                            <span class="option_name"><?php echo $category_option['name']; ?></span>
                            <span class="img_active"></span>
                        </div>

                        <div class="filter-item" style='display: block'; >
                            <?php foreach ($category_option['values'] as $value) { ?>
                                <?php $onclick = 'onclick="reload_page(\'' . $value['href'] . '\');"'; ?>

                                <?php if (in_array($value['value_id'], $filter_values_id)) { ?>
                                    <label class="active">
                                        <input type="checkbox" checked="checked" <?php echo $onclick; ?>>
                                        <a href="<?php echo $value['href'] . '#filters_product'; ?>" ><?php echo $value['name']; ?></a>
                                    </label>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    <?php } ?>
                <?php } ?>
                        <?php if ($flag == true) { ?>
                    </div>
                <?php } ?>

                <div class="title_not_select"><?php echo $text_select_filter; ?></div>
                <?php foreach ($category_options as $category_option) { ?>
                    <div class="wrapp_option_name <?php if ($category_option['active'] == true) { echo 'inactive'; } ?>" onclick="slide(this);">
                        <span class="option_name"><?php echo $category_option['name']; ?></span>
                        <span class="img_active"></span>
                    </div>

                    <div class="filter-item" <?php if ($category_option['active'] == true) { echo 'style="display: block"'; } ?> >
                        <?php if ($category_option['values']) { ?>
                            <?php foreach ($category_option['values'] as $value) { ?>
                                <?php $onclick = 'onclick="reload_page(\'' . $value['href'] . '\');"'; ?>

                                <?php if (in_array($value['value_id'], $filter_values_id)) { ?>
                                    <label class="active">
                                        <input type="checkbox" checked="checked" <?php echo $onclick; ?>>
                                        <a href="<?php echo $value['href'] . '#filters_product'; ?>" ><?php echo $value['name']; ?></a>
                                    </label>
                                <?php } else { ?>
                                    <?php if ($value['products']) { ?>
                                        <label>
                                            <input type="checkbox" <?php echo $onclick; ?>>
                                            <a href="<?php echo $value['href'] . '#filters_product'; ?>"><?php echo $value['name']; ?></a>
                                            (<?php echo $value['products']; ?>)
                                        </label>
                                    <?php } else { ?>
                                        <label>
                                            <input type="checkbox" disabled>
                                            <span><?php echo $value['name']; ?></span>
                                        </label>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    </div>
                <?php } ?>
            </form>
        </div>
    </div>

    <script>
        function reload_page(href) {
            window.location = href + '#filters_product';
        }
    </script>
<?php } ?>