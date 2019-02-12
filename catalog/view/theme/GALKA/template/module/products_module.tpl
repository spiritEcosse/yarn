<?php if ($products) { ?>
    <?php if ($setting['position'] == 'content_top' || $setting['position'] == 'content_bottom') { ?>
        <div class="box">
            <h2 class="heading_title"><span><?php echo $heading_title; ?></span></h2>
            <div class="box-content">
                <div class="box-product">
                    <?php include(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/products.tpl'); ?>
                </div>
            </div>
        </div>
    <?php } else { ?>
    <div class="box">
        <div class="box-heading"><?php echo $heading_title; ?></div>
        <div class="box-content">
            <?php foreach ($products as $product) { ?>
            <div class="prod_hold" >
                <div class="sale_save_holder">
                    <?php if ($product['new_prod'] == true) { ?>
                    <span class="new_prod"><b><?php echo $text_new_prod; ?></b></span>
                    <?php } ?>

                    <?php if ($product['special'] !== false && $product['price_status'] != 0) { ?>
                    <span class="sale"><b><?php echo $text_sale; ?></b></span>
                    <span class="save"><b>-<?php echo $product['sale']; ?>%</b></span>
                    <?php } ?>
                </div>

                <?php if ($product['thumb'] !== false) { ?>
                <div class="image" >
                    <a href="<?php echo $product['href']; ?>">
                        <img class="prod_image" src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>"/>
                        <a class="add_to_wishlist_small" onclick="addToWishList('<?php echo $product['product_id']; ?>');" title="<?php echo $text_wish; ?>">
                            <i class="icon-gift"></i>
                        </a>
                        <a class="add_to_compare_small" onclick="addToCompare('<?php echo $product['product_id']; ?>');" title="<?php echo $text_compare; ?>">
                            <i class="icon-tasks"></i>
                        </a>
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

                <?php if ($product['price_status'] != 0 && $product['price'] !== false) { ?>
                <div class="price">
                    <?php if ($product['special'] == false) { ?>
                    Цена: <span class="price_red"><?php echo $product['price']; ?></span>
                    <?php } else { ?>
                      <span class="price-old">
                        <div>Цена: <?php echo $product['price']; ?></div>
                      </span>

                      <span class="price-new">
                        <div>Цена: <span class="price_red"><?php echo $product['special']; ?></span></div>
                      </span>
                    <?php } ?>
                </div>

                <div class="cart">
                    <?php if (!empty($plus_minus_quantity) && $plus_minus_quantity == 1) { ?>
                    <div class="plus_minus_quantity">
                        <div class="box_number">
                            <input type="text" value="1" size="1" class="quantity" name="quantity_<?php echo $product['product_id']; ?>">
                        </div>
                        <div class="button_qty">
                            <input type="button" onclick="addQty(this)" value="+" class="qty-plus" />
                            <input type="button" onclick="subtractQty(this)" value="-" class="qty-minus" />
                        </div>
                    </div>

                    <a class="add_to_cart_small" title="<?php echo $button_cart; ?>" onclick="addToCartQty('<?php echo $product['product_id']; ?>', this);">
                        <?php echo $button_cart; ?>
                    </a>
                    <?php } else {	?>
                    <a class="add_to_cart_small" title="<?php echo $button_cart; ?>" onclick="addToCart('<?php echo $product['product_id']; ?>');">
                        <?php echo $button_cart; ?>
                    </a>
                    <?php } ?>

                    <div class="clear"></div>
                    <div class="button_fastorder">
                        <a class="button fastorder" data-name="<?php echo $product['name']; ?>" data-url="<?php echo $product['href']; ?>" href="javascript:void(0)"><span><?php echo $text_fastorder; ?></span></a>
                    </div>
                </div>
                <?php } ?>
            </div>
            <?php } ?>
        </div>
    </div>
    <?php } ?>
<?php } ?>
