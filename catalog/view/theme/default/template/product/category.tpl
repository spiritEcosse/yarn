<?php echo $header; ?>
<?php echo $column_left; ?>
<?php echo $column_right; ?>

<div id="content"><?php echo $content_top; ?>
    <div class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
        <?php } ?>
    </div>
    <h1><?php echo $heading_title; ?></h1>

    <?php if ($sale_category == true) { ?> 
        <div class="sale_category">
            <div class="sale_title">Скидка дня! (<?php echo date('d/m/Y'); ?>)</div>
            <div class="sale_img">
                <span class="sale_number">3%</span>
                <img src="/catalog/view/theme/default/image/sale_category.png">
            </div>
            <div class="sale_desc">на ортопедические матрасы</div>
        </div>
    <?php } ?>
    
    <?php if ($thumb || $description) { ?>
        <div class="category-info" style="display: table-row-group; ">
            <?php //if ($thumb) { ?>
                <!-- <div class="image"><img src="<?php //echo $thumb; ?>" alt="<?php //echo $heading_title; ?>" /></div> -->
            <?php //} ?>

            <?php if ($description) { ?>
                <?php echo $description; ?>
            <?php } ?>
        </div>
    <?php } ?>
    
    <div style="display: table-header-group; ">
        <?php if ($categories) { ?>
            <h2><?php echo $text_refine; ?></h2>
            <div class="category-list">
                <?php if (count($categories) <= 5) { ?>
                    <ul>
                        <?php foreach ($categories as $category) { ?>
                            <li><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a></li>
                        <?php } ?>
                    </ul>
                <?php } else { ?>
                    <?php for ($i = 0; $i < count($categories);) { ?>
                    <ul>
                        <?php $j = $i + ceil(count($categories) / 4); ?>
                            <?php for (; $i < $j; $i++) { ?>
                                <?php if (isset($categories[$i])) { ?>
                                    <li><a href="<?php echo $categories[$i]['href']; ?>"><?php echo $categories[$i]['name']; ?></a></li>
                                <?php } ?>
                        <?php } ?>
                    </ul>
                    <?php } ?>
                <?php } ?>
            </div>
        <?php } ?>
        
        <?php if ($products) { ?>
            <div class="product-filter">
                <div class="display"><b><?php echo $text_display; ?></b> <?php echo $text_list; ?> <b>/</b> <a onclick="display('grid');"><?php echo $text_grid; ?></a></div>
                <div class="limit"><b><?php echo $text_limit; ?></b>
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
                <div class="sort"><b><?php echo $text_sort; ?></b>
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
                <div class="pagination"><?php echo $pagination; ?></div>
            </div>

            <div class="product-compare"><a href="<?php echo $compare; ?>" id="compare-total"><?php echo $text_compare; ?></a></div>
            <div class="product-list">
                <?php foreach ($products as $product) { ?>
                <div>
                    <?php if ($product['special']) { ?>
                        <div class="sale"><img src="http://opencart/catalog/view/theme/default/image/sale.png"></div>
                    <?php } ?>
                    
                    <?php if ($product['thumb']) { ?>
                    <div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" title="<?php echo $product['name']; ?>" alt="<?php echo $product['name']; ?>" /></a></div>
                    <?php } ?>
                    <div class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
                    <div class="model"><?php echo "$text_model" . $product['model']; ?></div>
                    <!--       <br> -->
                    <div class="description">
                        <div><?php echo $product['description']; ?></div>
                        <div><a href="<?php echo $product['href']; ?>" class="button">Подробнее >>> </a></div>
                    </div>
                    
                    <?php if ($product['price_status'] != 0) { ?>
                    <?php if ($product['price']) { ?>
                    <div class="price">
                        <?php $product['price'] = $product['price_prefix'] . '&nbsp;' . $product['price'] . '&nbsp;' . $product['price_after']; ?>

                        <?php echo "Цена: ";
                        if (!$product['special']) { ?>
                            <?php echo $product['price']; ?>
                        <?php } else { ?>
                            <?php $product['special'] = $product['price_prefix'] . '&nbsp;' . $product['special'] . '&nbsp;' . $product['price_after']; ?>
                            
                            <span class="price-old"><?php echo $product['price']; ?></span>
                            <span class="price-new"><?php echo $product['special']; ?></span>
                        <?php } ?>
                        <?php if ($product['tax']) { ?>
                        <br />
                        <span class="price-tax"><?php echo $text_tax; ?> <?php echo $product['tax']; ?></span>
                        <?php } ?>
                    </div>
                    <?php } ?>
                    <?php } ?>

                    <?php if ($product['rating']) { ?>
                        <div class="rating"><img src="catalog/view/theme/default/image/stars-<?php echo $product['rating']; ?>.png" alt="<?php echo $product['reviews']; ?>" /></div>
                    <?php } ?>
                    
                    <?php if ($product['price_status'] != 0) { ?>
                        <div class="cart">
                            <input type="button" value="<?php echo $button_cart; ?>" onclick="addToCart('<?php echo $product['product_id']; ?>');" class="button" />
                        </div>
                        <div class="button_fastorder">
                            <a class="button fastorder" data-name="<?php echo $product['name']; ?>" data-url="<?php echo $product['href']; ?>" href="javascript:void(0)"><span><?php echo $text_fastorder; ?></span></a>
                        </div>
                    <?php } ?>
                    
                    <div class="wishlist"><a onclick="addToWishList('<?php echo $product['product_id']; ?>');"><?php echo $button_wishlist; ?></a></div>
                    <br clear="all">
                    <div class="compare"><a onclick="addToCompare('<?php echo $product['product_id']; ?>');"><?php echo $button_compare; ?></a></div>
                </div>
                <?php } ?>
            </div>
            <div class="pagination"><?php echo $pagination; ?></div>
        <?php } ?>

        <?php if (!$categories && !$products) { ?>
            <div class="content"><?php echo $text_empty; ?></div>
            <div class="buttons">
                <div class="right"><a href="<?php echo $continue; ?>" class="button"><?php echo $button_continue; ?></a></div>
            </div>
        <?php } ?>
    </div>
    
    <?php echo $content_bottom; ?></div>
<script type="text/javascript"><!--
function display(view) {
    if (view == 'list') {
        $('.product-grid').attr('class', 'product-list');
        
        $('.product-list > div').each(function(index, element) {
			
        html = '<div class="left">';
    
        var sale = $(element).find('.sale').html();

        if (sale !== null) {
            html += '<div class="sale">' + sale + '</div>';
        }
    
        var image = $(element).find('.image').html();

        html += '  <div class="imagePrice">';

        if (image != null) { 
            html += '<div class="image">' + image + '</div>';
        }

        html += '<br clear="all">';
        html += '  <div class="right">';

        var price = $(element).find('.price').html();

        if (price != null) {
            html += '<div class="price">' + price  + '</div>';
        }

        var cart = $(element).find('.cart').html();

        if (cart != null) {
            html += '    <div class="cart">' + cart + '</div>';
        }

        var fastorder = $(element).find('.button_fastorder').html();

        if (fastorder != null) {
            html += '    <div class="button_fastorder">' + fastorder + '</div>';
        }

        html += '    <div class="wishlist">' + $(element).find('.wishlist').html() + '</div>';
        html += '    <div class="compare">' + $(element).find('.compare').html() + '</div>';

        html += '  </div>';
        html += '</div>';

        html += '  <div class="name">' + $(element).find('.name').html() + '</div>';
        html += '  <div class="model">' + $(element).find('.model').html() + '</div>';
        // 			html += '<br>';
        html += '  <div class="description">' + $(element).find('.description').html() + '</div>';

        var rating = $(element).find('.rating').html();

        if (rating != null) {
            html += '<div class="rating">' + rating + '</div>';
        }

        html += '</div>';


        $(element).html(html);
        });		

        $('.display').html('<b><?php echo $text_display; ?></b> <?php echo $text_list; ?> <b>/</b> <a onclick="display(\'grid\');"><?php echo $text_grid; ?></a>');

        $.cookie('display', 'list'); 
    } else {
        $('.product-list').attr('class', 'product-grid');

        $('.product-grid > div').each(function(index, element) {
        html = '';

        var sale = $(element).find('.sale').html();

        if (sale !== null) {
            html += '<div class="sale">' + sale + '</div>';
        }

        var image = $(element).find('.image').html();

        if (image != null) {
            html += '<div class="image">' + image + '</div>';
        }

        html += '<div class="name">' + $(element).find('.name').html() + '</div>';
        html += '  <div class="model">' + $(element).find('.model').html() + '</div>';
        // 			html += '<br>';
        html += '<div class="description">' + $(element).find('.description').html() + '</div>';

        var price = $(element).find('.price').html();

        if (price != null) {
            html += '<div class="price">' + price  + '</div>';
        }

        var rating = $(element).find('.rating').html();

        if (rating != null) {
            html += '<div class="rating">' + rating + '</div>';
        }

        var cart = $(element).find('.cart').html();

        if (cart != null) {
            html += '    <div class="cart">' + cart + '</div>';
        }

        var fastorder = $(element).find('.button_fastorder').html();

        if (fastorder != null) {
            html += '    <div class="button_fastorder">' + fastorder + '</div>';
        }

        html += '<div class="wishlist">' + $(element).find('.wishlist').html() + '</div>';
        html += '<br clear="all">';
        html += '<div class="compare">' + $(element).find('.compare').html() + '</div>';

        $(element).html(html);
        });	

        $('.display').html('<b><?php echo $text_display; ?></b> <a onclick="display(\'list\');"><?php echo $text_list; ?></a> <b>/</b> <?php echo $text_grid; ?>');

        $.cookie('display', 'grid');
    }
}

view = $.cookie('display');

if (view) {
display(view);
} else {
display('list');
}
//--></script> 
<?php echo $footer; ?>