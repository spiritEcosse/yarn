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

    <?php echo $column_left; ?><?php echo $column_right; ?>
    <div id="content">
        <h2 class="heading_title"><span><?php echo $heading_title; ?></span></h2>
        <?php echo $content_top; ?>

        <?php if ($products) { ?>
        <div class="wishlist-info">
            <table>
                <thead>
                <tr>
                    <td class="image"><?php echo $column_image; ?></td>
                    <td class="name"><?php echo $column_name; ?></td>
                    <td class="model"><?php echo $column_model; ?></td>
                    <td class="stock"><?php echo $column_stock; ?></td>
                    <td class="price"><?php echo $column_price; ?></td>
                </tr>
                </thead>
                <?php foreach ($products as $product) { ?>
                <tbody id="wishlist-row<?php echo $product['product_id']; ?>">
                <tr>
                    <td class="image">
                        <div class="sale_save_holder">
                            <?php if ($product['special'] !== false && $product['price_status'] != 0) { ?>
                            <span class="sale"><b><?php echo $text_sale; ?></b></span>
                            <span class="save"><b>-<?php echo $product['sale']; ?>%</b></span>
                            <?php } ?>
                        </div>

                        <?php if ($product['thumb'] !== false) { ?>
                        <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" /></a>
                        <?php } ?>
                    </td>
                    <td class="name">
                        <a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
                        <br />
                        <br />
                        <img src="catalog/view/theme/default/image/cart-add.png" alt="<?php echo $button_cart; ?>" title="<?php echo $button_cart; ?>" onclick="addToCart('<?php echo $product['product_id']; ?>');" class="wish-cart" />
                        &nbsp;&nbsp;
                        <a href="<?php echo $product['remove']; ?>">
                            <img src="catalog/view/theme/default/image/remove.png" alt="<?php echo $button_remove; ?>" title="<?php echo $button_remove; ?>" />
                        </a>
                    </td>
                    <td class="model"><?php echo $product['model']; ?></td>
                    <td class="stock"><?php echo $product['availability']; ?></td>
                    <td class="price"><?php if ($product['price']) { ?>
                        <div class="price">
                            <?php if ($product['special'] == false) { ?>
                            <span class="red bold"><?php echo $product['price']; ?></span>
                            <?php } else { ?>
                            <div><span class="price-new red"><?php echo $product['special']; ?></span></div>
                            <div><span class="price-old"><?php echo $product['price']; ?></span></div>
                            <?php } ?>
                        </div>
                        <?php } ?>
                    </td>
                </tr>
                </tbody>
                <?php } ?>
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