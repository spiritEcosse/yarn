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
    <?php if ($success) { ?>
    <div class="success"><?php echo $success; ?><img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>
    <?php } ?>

    <?php echo $column_left; ?>
    <?php echo $column_right; ?>

    <div id="content">
        <h2 class="heading_title"><span><?php echo $heading_title; ?></span></h2>
        <?php echo $content_top; ?>

        <?php if ($products) { ?>
        <div class="wrapp_compare_info">
            <table class="compare-info">
                <thead>
                <tr>
                    <td class="compare-product" colspan="<?php echo count($products) + 1; ?>"><?php echo $text_product; ?></td>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><?php echo $text_name . ':'; ?></td>
                    <?php foreach ($products as $product) { ?>
                    <td class="name">
                        <a href="<?php echo $product['href']; ?>">
                            <?php echo $product['name']; ?>
                        </a>
                    </td>
                    <?php } ?>
                </tr>

                <?php if ($product['label_discount'] || $product['label_special']) { ?>
                    <tr>
                        <td>
                            <?php if ($product['label_discount']) { ?>
                                <?php echo $text_discount; ?>
                            <?php } else if ($product['label_special']) { ?>
                                <?php echo $text_sale; ?>
                            <?php } ?>
                        </td>
                        <td>
                            <div class="sale_save_holder">
                                <?php if ($product['special'] !== false && $product['price_status'] != 0) { ?>
                                    <span class="sale">
                                        <b>
                                            <?php if ($product['label_special_for_you'] == true) { ?>
                                                <?php echo $text_for_you; ?>
                                            <?php } else if ($product['label_discount']) { ?>
                                                <?php echo $text_discount; ?>
                                            <?php } else if ($product['label_special']) { ?>
                                                <?php echo $text_sale; ?>
                                            <?php } ?>
                                        </b>
                                    </span>
                                <span class="save"><b>-<?php echo $product['sale']; ?>%</b></span>
                                <?php } ?>
                            </div>
                        </td>
                    </tr>
                <?php } ?>

                <tr>
                    <td ><?php echo $text_image. ':'; ?></td>
                    <?php foreach ($products as $product) { ?>
                    <td>
                        <?php if ($product['thumb'] !== false) { ?>
                        <img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>"/>
                        <?php } ?>
                    </td>
                    <?php } ?>
                </tr>

                <tr>
                    <td><?php echo $text_price; ?></td>
                    <?php foreach ($products as $product) { ?>
                    <td>
                        <?php if ($product['price']) { ?>
                            <?php if ($product['special'] == false) { ?>
                                <span class="red bold"><?php echo $product['price']; ?></span>
                            <?php } else { ?>
                                <div><span class="price-new red"><?php echo $product['special']; ?></span></div>
                                <div><span class="price-old"><?php echo $product['price']; ?></span></div>
                            <?php } ?>
                        <?php } ?>
                    </td>
                    <?php } ?>
                </tr>

                <tr>
                    <td><?php echo $text_model; ?></td>
                    <?php foreach ($products as $product) { ?>
                    <td><?php echo $product['model']; ?></td>
                    <?php } ?>
                </tr>

                <?php foreach ($filters as $key => $filter) { ?>
                    <tr>
                        <td>
                            <?php echo $filter. ':'; ?>
                        </td>

                        <?php foreach ($products as $product) { ?>
                            <td>
                                <?php if (isset($product['filters']) && isset($product['filters'][$key])) { ?>
                                    <?php echo array_shift($product['filters'][$key]['values'])['name']; ?>

                                    <?php foreach ($product['filters'][$key]['values'] as $value) { ?>
                                        <?php echo ', ' . $value['name']; ?>
                                    <?php } ?>
                                <?php } ?>
                            </td>
                        <?php } ?>
                    </tr>
                <?php } ?>

                </tbody>

                <tr>
                    <td></td>
                    <?php foreach ($products as $product) { ?>
                        <td class="cart">
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
                                <a class="add_to_cart_small" title="<?php echo $button_cart; ?>" onclick="addToCartQty('<?php echo $product['product_id']; ?>', this);"><?php echo $button_cart; ?></a>
                        <?php } ?>
                        </td>
                    <?php } ?>
                </tr>
                <tr>
                    <td></td>
                    <?php foreach ($products as $product) { ?>
                    <td class="remove"><a href="<?php echo $product['remove']; ?>" class="button"><?php echo $button_remove; ?></a></td>
                    <?php } ?>
                </tr>
            </table>
        </div>

        <div class="buttons">
            <div class="right"><a href="<?php echo $continue; ?>" class="button"><?php echo $button_continue; ?></a></div>
        </div>
        <?php } else { ?>
        <div class="content"><?php echo $text_empty; ?></div>
        <div class="buttons">
            <div class="right"><a href="<?php echo $continue; ?>" class="button"><?php echo $button_continue; ?></a></div>
        </div>
        <?php } ?>
        <?php echo $content_bottom; ?>
    </div>
</div>

<?php echo $footer; ?>