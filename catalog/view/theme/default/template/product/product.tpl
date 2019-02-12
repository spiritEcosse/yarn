<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
    <div class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
        <?php } ?>
    </div>
    <h1><?php echo $heading_title; ?><br />
        <span><?php echo "$text_model"; ?></span><span class="product_model"><?php echo $model; ?></span><br />
    </h1>
    <div class="product-info">
        <?php if ($thumb || $images) { ?>
            <div class="left">
                <?php if ($thumb) { ?>
                    <div class="image">
                        <a href="<?php echo $popup; ?>" title="<?php echo $heading_title; ?>" class="colorbox" rel="colorbox">
                            <img src="<?php echo $thumb; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" id="image" />
                        </a>
                    </div>
                <?php } ?>
                
                <?php if ($price_status != 0 && $price) { ?>
                    <div class="price">
                    <?php echo $text_price; ?>
                    <?php $price = $price_prefix_name . '&nbsp;' . $price . '&nbsp;' . $price_after_name; ?>
                    
                    <?php if (!$special) { ?>
                        <?php echo $price; ?>
                    <?php } else { ?>
                        <?php $special = $price_prefix_name . '&nbsp;' . $special . '&nbsp;' . $price_after_name; ?>
                        
                        <span class="price-old"><?php echo $price; ?></span>
                        <span class="price-new"><?php echo $special; ?></span>
                    <?php } ?>
                    
                    <br />
                    <?php if ($tax) { ?>
                        <span class="price-tax"><?php echo $text_tax; ?> <?php echo $tax; ?></span><br />
                    <?php } ?>

                    <?php if ($points) { ?>
                        <span class="reward"><small><?php echo $text_points; ?> <?php echo $points; ?></small></span><br />
                    <?php } ?>

                    <?php if ($discounts) { ?>
                        <br />
                        <div class="discount">
                            <?php foreach ($discounts as $discount) { ?>
                                <?php echo sprintf($text_discount, $discount['quantity'], $discount['price']); ?><br />
                            <?php } ?>
                        </div>
                    <?php } ?>

                    </div>
                <?php } ?>
                
                <div class="cart">
                    <?php if ($price_status != 0) { ?>
                        <div>
                            <?php echo $text_qty; ?>
                            <input type="text" name="quantity" size="2" value="<?php echo $minimum; ?>" />
                            <input type="hidden" name="product_id" size="2" value="<?php echo $product_id; ?>" />
                            &nbsp;
                            <input type="button" value="<?php echo $button_cart; ?>" id="button-cart" class="button" />
                        </div>
                        <div><span>&nbsp;&nbsp;&nbsp;<?php echo $text_or; ?>&nbsp;&nbsp;&nbsp;</span></div>
                        <div>
                            <a class="button fastorder" data-name="<?php echo $heading_title; ?>" data-url="<?php echo "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']; ?>" href="javascript:void(0)">
                                <span><?php echo $text_fastorder; ?></span>
                            </a>
                        </div>
                        <div><span>&nbsp;&nbsp;&nbsp;<?php echo $text_or; ?>&nbsp;&nbsp;&nbsp;</span></div>
                    <?php } ?>
                    
                    <div>
                        <a onclick="addToWishList('<?php echo $product_id; ?>');">
                            <?php echo $button_wishlist; ?>
                        </a>
                        <br />
                        <a onclick="addToCompare('<?php echo $product_id; ?>');">
                            <?php echo $button_compare; ?>
                        </a>
                    </div>
                    
                    <?php if ($minimum > 1) { ?>
                        <div class="minimum"><?php echo $text_minimum; ?></div>
                    <?php } ?>
                </div>

                <div class="description">
                    <?php if ($manufacturer) { ?>
                    <span><?php echo $text_manufacturer; ?></span> <a href="<?php echo $manufacturers; ?>"><?php echo $manufacturer; ?></a><br />
                    <?php } ?>
                    <?php if ($reward) { ?>
                    <span><?php echo $text_reward; ?></span> <?php echo $reward; ?><br />
                    <?php } ?>
                    <span><?php echo $text_stock; ?></span> <?php echo $stock; ?>
                </div>
                
                <?php if ($review_status) { ?>
                    <div class="review">
                        <div>
                            <img src="catalog/view/theme/default/image/stars-<?php echo $rating; ?>.png" alt="<?php echo $reviews; ?>" />
                            &nbsp;&nbsp;
                            <a onclick="$('a[href=\'#tab-review\']').trigger('click');">
                                <?php echo $reviews; ?>
                            </a>
                            &nbsp;&nbsp;|&nbsp;&nbsp;
                            <a onclick="$('a[href=\'#tab-review\']').trigger('click');">
                                <?php echo $text_write; ?>
                            </a>
                        </div>
                        <div class="share"><!-- AddThis Button BEGIN -->
                            <div class="addthis_default_style">
                                <a class="addthis_button_compact">
                                    <?php echo $text_share; ?>
                                </a>
                                <a class="addthis_button_email"></a>
                                <a class="addthis_button_print"></a>
                                <a class="addthis_button_facebook"></a>
                                <a class="addthis_button_twitter"></a>
                            </div>
                            <script type="text/javascript" src="//s7.addthis.com/js/250/addthis_widget.js"></script> 
                            <!-- AddThis Button END --> 
                        </div>
                    </div>
                <?php } ?>
                
                <?php if ($images) { ?>
                    <div class="image-additional">
                        <h2>Дополнительные изображения</h2>
                        
                        <?php foreach ($images as $image) { ?>
                            <a href="<?php echo $image['popup']; ?>" title="<?php echo $heading_title; ?>" class="colorbox" rel="colorbox">
                                <img src="<?php echo $image['thumb']; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" />
                            </a>
                        <?php } ?>
                    </div>
                <?php } ?>

                <?php } ?>
            </div>
        <div class="right">
            <div id="tabs" class="htabs"><a href="#tab-description"><?php echo $tab_description; ?></a>
                <?php if ($attribute_groups) { ?>
                    <a href="#tab-attribute"><?php echo $tab_attribute; ?></a>
                <?php } ?>

                <?php if ($review_status) { ?>
                    <a href="#tab-review"><?php echo $tab_review; ?></a>
                <?php } ?>

                <?php if ($products) { ?>
                    <a href="#tab-related"><?php echo $tab_related; ?> (<?php echo count($products); ?>)</a>
                <?php } ?>
                
                <?php if ($tabs) { ?> 
                    <?php foreach ($tabs as $tab) { ?>
                        <a href="#tab-<?php echo $tab['id']; ?>"><?php echo $tab['name']; ?></a>
                    <?php } ?>
                <?php }?>
            </div>

            <div id="tab-description" class="tab-content"><?php echo $description; ?></div>

            <?php if ($attribute_groups) { ?>
                <div id="tab-attribute" class="tab-content">
                    <table class="attribute">
                        <?php foreach ($attribute_groups as $attribute_group) { ?>
                        <thead>
                            <tr>
                                <td colspan="2"><?php echo $attribute_group['name']; ?></td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($attribute_group['attribute'] as $attribute) { ?>
                            <tr>
                                <td><?php echo $attribute['name']; ?></td>
                                <td><?php echo $attribute['text']; ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                        <?php } ?>
                    </table>
                </div>
            <?php } ?>

            <?php if ($review_status) { ?>
                <div id="tab-review" class="tab-content">
                    <div id="review"></div>
                    <h2 id="review-title"><?php echo $text_write; ?></h2>
                    <b><?php echo $entry_name; ?></b><br />
                    <input type="text" name="name" value="" />
                    <br />
                    <br />
                    <b><?php echo $entry_review; ?></b>
                    <textarea name="text" cols="40" rows="8" style="width: 98%;"></textarea>
                    <span style="font-size: 11px;"><?php echo $text_note; ?></span><br />
                    <br />
                    <b><?php echo $entry_rating; ?></b> <span><?php echo $entry_bad; ?></span>&nbsp;
                    <input type="radio" name="rating" value="1" />
                    &nbsp;
                    <input type="radio" name="rating" value="2" />
                    &nbsp;
                    <input type="radio" name="rating" value="3" />
                    &nbsp;
                    <input type="radio" name="rating" value="4" />
                    &nbsp;
                    <input type="radio" name="rating" value="5" />
                    &nbsp;<span><?php echo $entry_good; ?></span><br />
                    <br />
                    <b><?php echo $entry_captcha; ?></b><br />
                    <input type="text" name="captcha" value="" />
                    <br />
                    <img src="index.php?route=product/product/captcha" alt="" id="captcha" /><br />
                    <br />
                    <div class="buttons">
                        <div class="right"><a id="button-review" class="button"><?php echo $button_continue; ?></a></div>
                    </div>
                </div>
            <?php } ?>
            
            <?php if ($products) { ?>
                <div id="tab-related" class="tab-content">
                    <div class="box-product">
                        <?php foreach ($products as $product) { ?>
                        <div>
                            <?php if ($product['thumb']) { ?>
                            <div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" /></a></div>
                            <?php } ?>
                            
                            <br clear="all">
                            <div class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
                            <div class="model"><?php echo "Артикул: "; ?></span> <?php echo $product['model']; ?></div>
                            
                            <?php if ($product['price_status'] != 0) { ?>
                                <?php if ($product['price']) { ?>
                                    <div class="price">
                                    <?php echo $text_price; ?>
                                    <?php $product['price'] = $product['price_prefix'] . '&nbsp;' . $product['price'] . '&nbsp;' . $product['price_after']; ?>

                                    <?php if (!$product['special']) { ?>
                                        <?php echo $product['price']; ?>
                                    <?php } else { ?>
                                        <?php $product['special'] = $product['price_prefix'] . '&nbsp;' . $product['special'] . '&nbsp;' . $product['price_after']; ?>

                                        <span class="price-old"><?php echo $product['price']; ?></span>
                                        <span class="price-new"><?php echo $product['special']; ?></span>
                                    <?php } ?>
                                </div>
                                <?php } ?>
                            <?php } ?>
                            
                            <?php if ($product['rating']) { ?>
                                <div class="rating"><img src="catalog/view/theme/default/image/stars-<?php echo $product['rating']; ?>.png" alt="<?php echo $product['reviews']; ?>" /></div>
                            <?php } ?>

                            <?php if ($product['price_status'] != 0) { ?>
                                <a onclick="addToCart('<?php echo $product['product_id']; ?>');" class="button"><?php echo $button_cart; ?></a></div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
            
            <?php if ($tabs) { ?>
                <?php foreach ($tabs as $tab) { ?>
                    <div id="tab-<?php echo $tab['id']; ?>" class="tab-content">
                        <?php echo $tab['description']; ?>
                    </div>
                <?php } ?>
            <?php } ?>
            
            <?php if ($tags) { ?>
            <div class="tags"><b><?php echo $text_tags; ?></b>
                <?php for ($i = 0; $i < count($tags); $i++) { ?>
                <?php if ($i < (count($tags) - 1)) { ?>
                <a href="<?php echo $tags[$i]['href']; ?>"><?php echo $tags[$i]['tag']; ?></a>,
                <?php } else { ?>
                <a href="<?php echo $tags[$i]['href']; ?>"><?php echo $tags[$i]['tag']; ?></a>
                <?php } ?>
                <?php } ?>
            </div>
            <?php } ?>
            <?php echo $content_bottom; ?>
        </div>
    </div>
</div>
<script type="text/javascript"><!--
    $('.colorbox').colorbox({
    overlayClose: true,
    opacity: 0.5
});
//--></script> 
<script type="text/javascript"><!--
$('#button-cart').bind('click', function() {
$.ajax({
url: 'index.php?route=checkout/cart/add',
type: 'post',
data: $('.product-info input[type=\'text\'], .product-info input[type=\'hidden\'], .product-info input[type=\'radio\']:checked, .product-info input[type=\'checkbox\']:checked, .product-info select, .product-info textarea'),
dataType: 'json',
success: function(json) {
$('.success, .warning, .attention, information, .error').remove();
			
if (json['error']) {
if (json['error']['option']) {
for (i in json['error']['option']) {
$('#option-' + i).after('<span class="error">' + json['error']['option'][i] + '</span>');
}
}
} 
			
if (json['success']) {
$('#notification').html('<div class="success" style="display: none;">' + json['success'] + '<img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>');
					
$('.success').fadeIn('slow');
					
$('#cart-total').html(json['total']);
				
$('html, body').animate({ scrollTop: 0 }, 'slow'); 
}	
}
});
});
//--></script>
<script type="text/javascript"><!--
$('#review .pagination a').live('click', function() {
$('#review').fadeOut('slow');
		
$('#review').load(this.href);
	
$('#review').fadeIn('slow');
	
return false;
});			

$('#review').load('index.php?route=product/product/review&product_id=<?php echo $product_id; ?>');

$('#button-review').bind('click', function() {
$.ajax({
url: 'index.php?route=product/product/write&product_id=<?php echo $product_id; ?>',
type: 'post',
dataType: 'json',
data: 'name=' + encodeURIComponent($('input[name=\'name\']').val()) + '&text=' + encodeURIComponent($('textarea[name=\'text\']').val()) + '&rating=' + encodeURIComponent($('input[name=\'rating\']:checked').val() ? $('input[name=\'rating\']:checked').val() : '') + '&captcha=' + encodeURIComponent($('input[name=\'captcha\']').val()),
beforeSend: function() {
$('.success, .warning').remove();
$('#button-review').attr('disabled', true);
$('#review-title').after('<div class="attention"><img src="catalog/view/theme/default/image/loading.gif" alt="" /> <?php echo $text_wait; ?></div>');
},
complete: function() {
$('#button-review').attr('disabled', false);
$('.attention').remove();
},
success: function(data) {
if (data['error']) {
$('#review-title').after('<div class="warning">' + data['error'] + '</div>');
}
			
if (data['success']) {
$('#review-title').after('<div class="success">' + data['success'] + '</div>');
								
$('input[name=\'name\']').val('');
$('textarea[name=\'text\']').val('');
$('input[name=\'rating\']:checked').attr('checked', '');
$('input[name=\'captcha\']').val('');
}
}
});
});
//--></script> 
<script type="text/javascript"><!--
$('#tabs a').tabs();
//--></script> 

<script type="text/javascript"><!--
if ($.browser.msie && $.browser.version == 6) {
$('.date, .datetime, .time').bgIframe();
}

$('.date').datepicker({dateFormat: 'yy-mm-dd'});
$('.datetime').datetimepicker({
dateFormat: 'yy-mm-dd',
timeFormat: 'h:m'
});
$('.time').timepicker({timeFormat: 'h:m'});
//--></script> 

<?php echo $footer; ?>
