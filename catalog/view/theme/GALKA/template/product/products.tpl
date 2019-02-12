<?php if (isset($products) && $products) { ?>
<div class="product-filter">

    <?php if (isset($price_slider) && $price_slider == 1) { ?>
    <div class="price_slider">
        <div class="wrap_clear_filter">
            <a class="clear_filter" href="<?php echo $clear_filter_link; ?>" ><?php echo $clear_filter; ?></a>
        </div>

        <label class="label_min_price" for="min_price"><?php echo $text_price_range; ?></label>
        <div class="price_input">
            <?php if ($symbol_left) { ?>
            <b><?php echo $symbol_left; ?></b>
            <?php } ?>
            <input class="price_limit" type="text" name="min_price" value="-1" id="min_price"/>
            -
            <input class="price_limit" type="text" name="max_price" value="-1" id="max_price"/>

            <?php if ($symbol_right) { ?>
                <?php echo $symbol_right; ?>
            <?php } ?>
        </div>
        <div id="slider-range"></div>
    </div>
    <?php } ?>

    <div class="special_link"><a id="special_link" href="<?php echo $special; ?>">Акции</a></div>

    <div class="limit">
        <b><?php echo $text_limit; ?></b>

        <select onchange="location = this.value;">
            <?php foreach ($limits as $limits) { ?>
            <?php if ($limits['value'] == $limit) { ?>
            <option value="<?php echo $limits['href']; ?>" selected="selected"><?php echo $limits['text']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $limits['href']; ?>"><?php echo $limits['text']; ?></option>
            <?php } ?>
            <?php } ?>
        </select>
    </div>

    <div class="sort">
        <b><?php echo $text_sort; ?></b>

        <select onchange="location = this.value;">
            <?php foreach ($sorts as $sorts) { ?>
            <?php if ($sorts['value'] == $sort . '-' . $order) { ?>
            <option value="<?php echo $sorts['href']; ?>" selected="selected"><?php echo $sorts['text']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $sorts['href']; ?>"><?php echo $sorts['text']; ?></option>
            <?php } ?>
            <?php } ?>
        </select>
    </div>
</div>
<?php } ?>

<div id="list_records"></div>

<?php if (isset($products) && $products) { ?>
<div class="pagination" id="pagination_top">
    <?php echo $pagination; ?>
</div>

<div class="product-list">
    <?php foreach ($products as $product) { ?>
    <div class="prod_hold">
        <?php if ($product['thumb'] !== false) { ?>
        <div class="image">
            <a href="<?php echo $product['href']; ?>">
                <img class="prod_image" src="<?php echo $product['thumb']; ?>" title="<?php echo $product['name']; ?>" alt="<?php echo $product['name']; ?>"/>
            </a>
            <a class="add_to_wishlist_small" onclick="addToWishList(<?php echo $product['product_id']; ?>);" alt="<?php echo $button_wishlist; ?>" title="<?php echo $button_wishlist; ?>">
                <i class="icon-gift"></i>
            </a>
            <a class="add_to_compare_small" onclick="addToCompare(<?php echo $product['product_id']; ?>);" alt="<?php echo $button_compare; ?>" title="<?php echo $button_compare; ?>">
                <i class="icon-tasks"></i>
            </a>
        </div>
        <?php } ?>

        <div class="name">
            <a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
        </div>

        <div class="model">
            <?php echo $text_model; ?><?php echo $product['model']; ?>
        </div>

        <div class="prod-info-fly">
            <div class="sale_save_holder">
                <?php if ($product['new_prod'] == true) { ?>
                <span class="new_prod"><b><?php echo $text_new_prod; ?></b></span>
                <?php } ?>

                <?php if ($product['special'] !== false && $product['price_status'] != 0) { ?>
                    <span class="sale"><b>

                    <?php if ($product['label_special_for_you'] == true) { ?>
                            <?php echo $text_for_you; ?>
                    <?php } else if ($product['label_special'] == true) { ?>
                        <?php echo $text_sale; ?>
                    <?php } else if ($product['label_discount'] == true) { ?>
                        <?php echo $text_discount; ?>
                    <?php } ?>

                    </b></span>
                <span class="save"><b>-<?php echo $product['sale']; ?> %</b></span>
                <?php } ?>
            </div>

            <?php if ($product['price_status'] != 0 && $product['price']) { ?>
            <div class="price">
                <?php if ($product['special'] == false) { ?>
                    <?php echo $product['price_prefix']; ?>
                    <div>Цена: <span class="price_red"><?php echo $product['price']; ?></span> <?php echo $product['price_after']; ?></div>
                <?php } else { ?>
                    <span class="price-old">
                        <?php echo $product['price_prefix']; ?>
                        <div><span class="old_price">Цена: <?php echo $product['price'] . ' ' . $product['price_after']; ?></span></div>
                    </span>

                    <span class="price-new">
                        <?php echo $product['price_prefix']; ?>
                        <div>Цена: <span class="price_red"><?php echo $product['special']; ?></span> <?php echo $product['price_after']; ?></div>
                    </span>

                    <?php if ($product['special_date_end']) { ?>
                    <div class="count_holder_small">
                        <div class="count_info"><?php echo $text_limited; ?></div>
                        <div id="GALKACountSmallCategory<?php echo $product['product_id']; ?>"></div>
                        <script type="text/javascript">
                            $(function () {
                                $('#GALKACountSmallCategory<?php echo $product['product_id']; ?>').countdown({until: new Date(<?php echo $product['special_date_end']; ?>), compact: false});
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

        <?php if ($product['rating']) { ?>
        <div class="rating"><img src="catalog/view/theme/default/image/stars-<?php echo $product['rating']; ?>.png" alt="<?php echo $product['reviews']; ?>"/></div>
        <?php } ?>
    </div>
    <?php } ?>
</div>

<div class="pagination" id="pagination_bottom">
    <?php echo $pagination; ?>
</div>
<?php } else { ?>
<div class="content">
    <div class="products_fail"><?php echo $text_empty; ?></div>
    <a class="button" href="<?php echo $continue; ?>"><?php echo $button_continue; ?></a>
</div>
<?php } ?>

<script type="text/javascript">
    var min_price = <?php echo $min_price; ?>;
    var max_price = <?php echo $max_price; ?>;
    var url = '<?php echo html_entity_decode($url_minus_price); ?>';

//    $(function () {
        $("#slider-range").slider({range:true, min:0, max:0, values:[0, 0], stop:function (a, b) {
            min_price = parseInt($('#min_price').val());
            max_price = parseInt($('#max_price').val());
            location = url + '&min_price=' + min_price + '&max_price=' + max_price;

            }, slide:function (a, b) {
            $("#min_price").val(parseInt(b.values[0]));
            $("#max_price").val(parseInt(b.values[1]));
        }
    });

//    $("#min_price").val($("#slider-range").slider("values", 0));
//    $("#max_price").val($("#slider-range").slider("values", 1));
//    });

//    $(document).ready(function() {
        var min_price = <?php echo $min_price; ?>;
        var max_price = <?php echo $max_price; ?>;
        var bd_min_price = <?php echo $bd_min_price; ?>;
        var bd_max_price = <?php echo $bd_max_price; ?>;

        $("#min_price").val(min_price);
        $("#max_price").val(max_price);
        $("#slider-range").slider("option", {min:bd_min_price, max:bd_max_price});
        $("#slider-range").slider("option", {values:[min_price, max_price]});
//    });

    $(".price_limit").live("change", (function () {
        min_price = parseInt($('#min_price').val());
        max_price = parseInt($('#max_price').val());
        location = url + '&min_price=' + min_price + '&max_price=' + max_price;
    }));
</script>