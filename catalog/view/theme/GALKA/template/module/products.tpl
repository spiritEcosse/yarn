<?php if ($products) { ?>
<div id="bxslider_<?php echo get_called_class(); ?>" class="product-list">
    <?php foreach ($products as $product) { ?>
    <div class="prod_hold" >
        <?php if ($product['thumb'] !== false) { ?>
        <div class="image">
            <a href="<?php echo $product['href']; ?>">
                <img class="prod_image" src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" />
            </a>
            <a class="add_to_wishlist_small" onclick="addToWishList('<?php echo $product['product_id']; ?>');" title="<?php echo $text_wish; ?>">
                <i class="icon-gift"></i>
            </a>
            <a class="add_to_compare_small" onclick="addToCompare('<?php echo $product['product_id']; ?>');" title="<?php echo $text_compare; ?>">
                <i class="icon-tasks"></i>
            </a>
        </div>
        <?php } ?>

        <div class="name">
            <a href="<?php echo $product['href']; ?>">
                <?php echo $product['name']; ?>
            </a>
        </div>

        <div class="model">
            <?php echo $text_model; ?>
            <?php echo $product['model']; ?>
        </div>

        <div class="prod-info-fly">
            <div class="sale_save_holder">
                <?php if ($product['new_prod'] == true) { ?>
                <span class="new_prod"><b><?php echo $text_new_prod; ?></b></span>
                <?php } ?>

                <?php if ($product['special'] !== false && $product['price_status'] != 0) { ?>
                <span class="sale">
                    <b>
                        <?php if ($product['label_special_for_you'] == true) { ?>
                            <?php echo $text_for_you; ?>
                        <?php } else if ($product['label_special'] == true) { ?>
                            <?php echo $text_sale; ?>
                        <?php } else if ($product['label_discount'] == true) { ?>
                            <?php echo $text_discount; ?>
                        <?php } ?>
                    </b>
                </span>
                <span class="save"><b>-<?php echo $product['sale']; ?>%</b></span>
                <?php } ?>
            </div>

            <?php if ($product['price'] !== false && $product['price_status'] != 0) { ?>
            <div class="price">
                <?php $product['price'] = $product['price_prefix'] . '&nbsp;' . $product['price'] . '&nbsp;' . $product['price_after']; ?>

                <?php if ($product['special'] == false) { ?>
                Цена: <span class="price_red"><?php echo $product['price']; ?></span>
                <?php } else { ?>
                  <span class="price-old">
                    <?php echo $product['price_prefix']; ?>
                      <div>Цена: <?php echo ' ' . $product['price']; ?></div>
                  </span>

                  <span class="price-new">
                    <?php echo $product['price_prefix']; ?>
                      <div>Цена: <span class="price_red"><?php echo ' ' . $product['special'] . ''; ?></span>
                          <?php echo $product['price_after']; ?></div>
                  </span>

                <?php if ($product['special_date_end'] !== false) { ?>
                <div class="count_holder_small">
                    <div class="count_info"><?php echo $text_limited; ?></div>
                    <div id="GALKACountSmall<?php echo get_called_class(); ?><?php echo $product['product_id']; ?>"></div>
                    <script type="text/javascript">
                        $(function () {
                            $('#GALKACountSmall<?php echo get_called_class(); ?><?php echo $product['product_id']; ?>').countdown({until: new Date(<?php echo $product['special_date_end']; ?>), compact: false});
                        });
                    </script>
                    <div class="clear"></div>
                </div>
                <?php } ?>
                <?php } ?>
                <div class="clear"></div>
            </div>
            <?php } ?>
        </div>

        <?php if (isset($product['filters']) && $product['filters']) { ?>
            <div class="wrapp_filters">
                <table class="product_filters">
                    <thead><tr><td colspan="2"><?php echo $tab_attribute; ?></td></tr></thead>

                    <?php foreach($product['filters'] as $filter) { ?>
                        <tr>
                            <td><?php echo $filter['option_name']; ?>:&nbsp;&nbsp;</td>
                            <td>
                                <div class="option_value_<?php echo $filter['option_id']; ?>">
                                    <div class="list_option_value">
                                        <?php foreach ($filter['values'] as $value) { ?>
                                            <div class="filters_option_value"><?php echo $value['name']; ?></div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        <?php } ?>
    </div>
    <?php } ?>
</div>

<?php if (count($products) > 3) { ?>
    <script type="text/javascript">
            if ($( window ).width() > 1080) {
                $('#bxslider_<?php echo get_called_class(); ?>').bxSlider({
                    minSlides: 1,
                    maxSlides: 5,
                    slideWidth: 228,
                    slideMargin: 10,
                    adaptiveHeight: true
                });
            }
    </script>
<?php } ?>
<?php } ?>