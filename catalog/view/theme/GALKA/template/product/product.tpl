<?php echo $header; ?>
<div class="title-holder">
    <div class="inner">
        <div class="breadcrumb">
            <?php foreach ($breadcrumbs as $breadcrumb) { ?>
            <?php echo $breadcrumb['separator']; ?>
            <a href="<?php echo $breadcrumb['href']; ?>">
                <?php echo $breadcrumb['text']; ?>
            </a>
            <?php } ?>
        </div>
    </div>
</div>

<div class="inner">
<?php echo $column_left; ?>

<div id="content" itemscope itemtype="http://schema.org/Product">
<h2 class="heading_title"><span itemprop="name" ><?php echo $heading_title; ?></span></h2>
<?php echo $content_top; ?>

<meta itemprop="inLanguage" content="ru" />
<meta itemprop="url" content="<?php echo $href_item; ?>" />

<div class="product-info">
<?php if ($thumb || $images) { ?>
    <div class="left">
        <div class="wrapper">
            <div class="prev lowercase">
                <a href="<?php echo $prev; ?>"><?php echo $text_prev; ?></a>
            </div>
            <div class="next lowercase">
                <a href="<?php echo $next; ?>"><?php echo $text_next; ?></a>
            </div>
        </div>

        <?php $startDate1 = strtotime(mb_substr($startdate, 0, 10));
              $endDate2 = strtotime(date("Y-m-d"));
              $days = ceil(($endDate2 / 86400)) - ceil(($startDate1 / 86400)); ?>

        <div class="wrapp_image">
            <?php if ($price_status != 0) { ?>
            <div class="sale_save_holder">
                <?php if ($this->config->get('GALKAControl_status') == 1) { ?>
                <?php $numeroNew = $this->config->get('GALKAControl_new_label'); ?>
                <?php } else { ?>
                <?php $numeroNew = 3000; ?>
                <?php } ?>

                <?php if ($days < $numeroNew) { ?>
                <span class="new_prod"><b><?php echo $text_new_prod; ?></b></span>
                <?php } ?>

                <?php if ($special) { ?>
                    <span class="sale">
                        <b>
                            <?php if ($label_special_for_you == true) { ?>
                            <?php echo $text_for_you; ?>
                            <?php } else if ($label_special == true) { ?>
                            <?php echo $text_sale; ?>
                            <?php } else if ($label_discount == true) { ?>
                            <?php echo $text_discount; ?>
                            <?php } ?>
                        </b></span>
                <span class="save"><b>-<?php echo $sale; ?>%</b></span>
                <?php } ?>
            </div>
            <?php } ?>

            <?php if ($this->config->get('GALKAControl_preview') != null && $this->config->get('GALKAControl_status') == 1) { ?>
            <?php $imagePreviewType = $this->config->get('GALKAControl_preview'); ?>
            <?php } else { ?>
            <?php $imagePreviewType = 'zoom.php'; ?>
            <?php } ?>

            <?php include(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/' . $imagePreviewType); ?>
        </div>

        <?php if ($products) { ?>
        <div class="related">
            <div class="block_grey"><?php echo $tab_related; ?> /<?php echo count($products); ?>/</span></div>
            <div class="box-related" id="bxslider_related">
                <?php $count = 1; ?>
                <div class="box-product">

                    <?php foreach ($products as $product) { ?>
                    <a href="<?php echo $product['href']; ?>" >
                        <img src="<?php echo $product['thumb']; ?>" title="<?php echo $product['name']; ?>" alt="<?php echo $product['name']; ?>">
                        <div class="info">
                            <div class="name"><?php echo $product['name']; ?></div>
                            <div class="price"><?php echo $product['price']; ?></div>
                        </div>
                    </a>

                    <?php if ($count % 2 == 0) { ?>
                </div>
                <div class="box-product">
                    <?php } ?>
                    <?php $count++; ?>
                    <?php } ?>
                </div>
            </div>

            <?php if (count($products) > 4) { ?>
            <script type="text/javascript"><!--
                    if ($( window ).width() > 380) {
                        $('#bxslider_related').bxSlider({
                            minSlides: 2,
                            maxSlides: 2,
                            slideWidth: 322,
                            slideMargin: 10
                        });
                    }
                //--></script>
            <?php } ?>
        </div>
        <?php } ?>
    </div>
<?php } ?>

<div class="right">
    <div class="visible_info">
        <div class="center">
            <div class="description">
                <span class="model"><?php echo $text_model; ?></span>
                <span itemprop="model"><?php echo $model; ?></span>
                <br />

                <?php if ($filters) { ?>
                    <div class="wrapp_filters">
                        <table>
                            <?php foreach ($filters as $filter) { ?>
                                <tr>
                                    <td><?php echo $filter['option_name']; ?>:</td>

                                    <td>
                                        <span class="filter_margin"><?php echo $filter['values']; ?></span>
                                    </td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                <?php } ?>
            </div>

            <?php if ($price_status != 0) { ?>
                <div class="price<?php if ($discount_birthday !== null && $warning_birthday_product == false) { ?> none<?php } ?>">
                    <div class="birth_day"><span class="red"><?php echo $warning_birthday_product; ?></span></div>

                    <div class="pricetag" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                        <span class="price-new"><?php echo $text_price; ?></span>
                        <meta itemprop="priceCurrency" content="UAH" />

                        <?php if (!$special) { ?>
                            <?php echo $price_prefix_name . '&nbsp;'; ?>
                            <span itemprop="price"><?php echo $price; ?></span>
                            <?php echo '&nbsp;' . $price_after_name; ?>
                        <?php } else { ?>
                            <span class="price-new">
                              <?php echo $price_prefix_name . '&nbsp;'; ?>
                                <span itemprop="price"><?php echo $special; ?></span>
                                <?php echo '&nbsp;' . $price_after_name; ?>
                            </span>
                        <span class="price-old"><?php echo $price_prefix_name . '&nbsp;' . $price . '&nbsp;' . $price_after_name; ?></span>
                        <?php } ?>
                    </div>

                    <?php if ($special && $this->config->get('GALKAControl_status') == 1 && $this->config->get('GALKAControl_countdown') == 1) { ?>
                        <?php if ($date_end != '0000, 00 - 1, 00') { ?>
                            <div class="count_holder">
                                <span class="offer_title"><?php echo $text_limited; ?></span>
                                <div id="GALKACount"></div>
                                <script type="text/javascript">
                                    $(function () {
                                        $('#GALKACount').countdown({until: new Date(<?php echo $date_end; ?>), compact: false});
                                    });
                                </script>
                            </div>
                        <?php } ?>
                    <?php } ?>

                    <?php if ($tax) { ?>
                        <span class="price-tax"><?php echo $text_tax; ?><?php echo $tax; ?></span><br />
                    <?php } ?>

                    <?php if ($points) { ?>
                        <span class="reward"><small><?php echo $text_points; ?><?php echo $points; ?></small></span><br />
                    <?php } ?>
                </div>

                <?php if ($discount_birthday !== null && $warning_birthday_product == false) { ?>
                    <div class="birth_day">
                        <span class="red"><?php echo $text_birthday; ?></span>
                        <input type="hidden" name="gift" >
                    </div>
                <?php } ?>
            <?php } ?>
        </div>

        <div class="third">
            <div class="cart">
                <div class="plus_minus_quantity">
                    <div class="box_number">
                        <input type="text" name="quantity" class="quantity" size="2" value="<?php echo $minimum; ?>" />
                    </div>

                    <?php if(!empty($plus_minus_quantity) && $plus_minus_quantity == 1) { ?>
                    <div class="button_qty">
                        <input type="button" onclick="addQty(this)" value="+" class="qty-plus" />
                        <?php } ?>

                        <?php if (!empty($plus_minus_quantity) && $plus_minus_quantity == 1) { ?>
                        <input type="button" onclick="subtractQty(this)" value="-" class="qty-minus" />
                    </div>
                    <?php } ?>

                    <input type="hidden" name="product_id" size="2" value="<?php echo $product_id; ?>" />&nbsp;
                </div>

                <div class="buttons_holder">
                    <input type="button" value="<?php echo $button_cart; ?>" id="button-cart" class="button button_cart_product" />
                    <a onclick="addToWishList('<?php echo $product_id; ?>');" class="add_to_wishlist button" title="<?php echo $button_wishlist; ?>"><i class="icon-gift"></i></a>
                    <a onclick="addToCompare('<?php echo $product_id; ?>');" class="add_to_compare button" title="<?php echo $button_compare; ?>"><i class="icon-tasks"></i></a>
                </div>

                <?php if ($minimum > 1) { ?>
                <div class="minimum"><?php echo $text_minimum; ?></div>
                <?php } ?>
            </div>

            <div class="social">
                <div class="facebook">
                    <div class="text"><?php echo $text_facebook . ':'; ?></div>
                    <div class="button">
                        <div id="fb-root"></div>
                        <script>(function(d, s, id) {
                                var js, fjs = d.getElementsByTagName(s)[0];
                                if (d.getElementById(id)) return;
                                js = d.createElement(s); js.id = id;
                                js.src = "//connect.facebook.net/ru_RU/sdk.js#xfbml=1&version=v2.0";
                                fjs.parentNode.insertBefore(js, fjs);
                            }(document, 'script', 'facebook-jssdk'));</script>
                        <div class="fb-share-button" data-layout="button_count" data-href="<?php echo $href_item; ?>" data-width="100"></div>
                    </div>
                </div>

                <div class="vk">
                    <div class="text"><?php echo $text_vk . ':'; ?></div>
                    <div class="button">
                        <script type="text/javascript" src="http://vk.com/js/api/share.js?90" charset="windows-1251"></script>

                        <script type="text/javascript"><!--
                            document.write(VK.Share.button({url: "<?php echo $href_item; ?>"},{type: "round", text: "Поделиться"}));
                            --></script>
                    </div>
                </div>
                <div class="classmates">
                    <div class="text"><?php echo $text_classmates . ':'; ?></div>
                    <div class="button">
                        <div id="ok_shareWidget"></div>
                        <script>
                            !function (d, id, did, st) {
                                var js = d.createElement("script");
                                js.src = "http://connect.ok.ru/connect.js";
                                js.onload = js.onreadystatechange = function () {
                                    if (!this.readyState || this.readyState == "loaded" || this.readyState == "complete") {
                                        if (!this.executed) {
                                            this.executed = true;
                                            setTimeout(function () {
                                                OK.CONNECT.insertShareWidget(id,did,st);
                                            }, 0);
                                        }
                                    }};
                                d.documentElement.appendChild(js);
                            }(document,"ok_shareWidget",document.URL,"{width:190,height:30,st:'oval',sz:20,ck:2}");
                        </script>
                    </div>
                </div>
            </div>
        </div>

        <div class="clear"></div>
        <?php if ($description) { ?>
            <div class="wrapp_desc">
                <div class="block_grey"><?php echo $text_info; ?></div>
                <?php if ($description) { ?>
                <div class="tab-content" itemprop="description">
                    <?php echo $description; ?>
                </div>
                <?php } ?>
            </div>
        <?php } ?>
    </div>

<?php if ($options) { ?>
<div class="options">
    <h2><?php echo $text_option; ?></h2>
    <?php foreach ($options as $option) { ?>
    <?php if ($option['type'] == 'select') { ?>
    <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
        <div class="title_option">
            <?php if ($option['required']) { ?>
            <span class="required">*</span>
            <?php } ?>
            <?php echo $option['name']; ?>:</div>

        <select name="option[<?php echo $option['product_option_id']; ?>]">
            <option value=""><?php echo $text_select; ?></option>
            <?php foreach ($option['option_value'] as $option_value) { ?>
            <option value="<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
                <?php if ($option_value['price']) { ?>
                (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                <?php } ?>
            </option>
            <?php } ?>
        </select>
    </div>
    <br />
    <?php } ?>
    <?php if ($option['type'] == 'radio') { ?>
    <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
        <?php foreach ($option['option_value'] as $option_value) { ?>
            <div class="option_value">
                <label for="option-value-<?php echo $option_value['product_option_value_id']; ?>">
                    <div class="image">
                        <?php if ($option_value['image']) { ?>
                            <a href="<?php echo $option_value['popup']; ?>" onclick="return hs.expand(this)" >
                                <img src="<?php echo $option_value['image']; ?>" />
                            </a>
                        <?php } ?>
                    </div>
                    <div class="text">
                        <input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" id="option-value-<?php echo $option_value['product_option_value_id']; ?>" />
                        <?php echo $option_value['name']; ?>

                        <?php if ($option_value['price']) { ?>
                        (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                        <?php } ?>
                    </div>
                </label>
            </div>
        <?php } ?>
    </div>
    <br />
    <?php } ?>
    <?php if ($option['type'] == 'checkbox') { ?>
    <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
        <?php if ($option['required']) { ?>
        <span class="required">*</span>
        <?php } ?>
        <b><?php echo $option['name']; ?>:</b><br />
        <?php foreach ($option['option_value'] as $option_value) { ?>
        <input type="checkbox" name="option[<?php echo $option['product_option_id']; ?>][]" value="<?php echo $option_value['product_option_value_id']; ?>" id="option-value-<?php echo $option_value['product_option_value_id']; ?>" />
        <label for="option-value-<?php echo $option_value['product_option_value_id']; ?>"> <?php echo $option_value['name']; ?>
            <?php if ($option_value['price']) { ?>
            (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
            <?php } ?>
        </label>
        <br />
        <?php } ?>
    </div>
    <br />
    <?php } ?>
    <?php if ($option['type'] == 'text') { ?>
    <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
        <?php if ($option['required']) { ?>
        <span class="required">*</span>
        <?php } ?>
        <b><?php echo $option['name']; ?>:</b><br />
        <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" />
    </div>
    <br />
    <?php } ?>
    <?php if ($option['type'] == 'textarea') { ?>
    <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
        <?php if ($option['required']) { ?>
        <span class="required">*</span>
        <?php } ?>
        <b><?php echo $option['name']; ?>:</b><br />
        <textarea name="option[<?php echo $option['product_option_id']; ?>]" cols="40" rows="5"><?php echo $option['option_value']; ?></textarea>
    </div>
    <br />
    <?php } ?>
    <?php if ($option['type'] == 'file') { ?>
    <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
        <?php if ($option['required']) { ?>
        <span class="required">*</span>
        <?php } ?>
        <b><?php echo $option['name']; ?>:</b><br />
        <a id="button-option-<?php echo $option['product_option_id']; ?>" class="button"><span><?php echo $button_upload; ?></span></a>
        <input type="hidden" name="option[<?php echo $option['product_option_id']; ?>]" value="" />
    </div>
    <br />
    <?php } ?>
    <?php if ($option['type'] == 'date') { ?>
    <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
        <?php if ($option['required']) { ?>
        <span class="required">*</span>
        <?php } ?>
        <b><?php echo $option['name']; ?>:</b><br />
        <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" class="date" />
    </div>
    <br />
    <?php } ?>
    <?php if ($option['type'] == 'datetime') { ?>
    <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
        <?php if ($option['required']) { ?>
        <span class="required">*</span>
        <?php } ?>
        <b><?php echo $option['name']; ?>:</b><br />
        <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" class="datetime" />
    </div>
    <br />
    <?php } ?>
        <?php if ($option['type'] == 'time') { ?>
            <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
                <?php if ($option['required']) { ?>
                <span class="required">*</span>
                <?php } ?>
                <b><?php echo $option['name']; ?>:</b><br />
                <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" class="time" />
            </div>
            <br />
        <?php } ?>
    <?php } ?>
</div>
<?php } ?>
</div>

<div class="clear"></div>

<?php if ($attribute_groups) { ?>
<div class="desc_filter_attr">
    <?php if ($attribute_groups) { ?>
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
                <td class="right"><?php echo $attribute['name']; ?>:&nbsp;&nbsp;</td>
                <?php $attribute['text'] = explode(';', $attribute['text']); ?>
                <?php $attribute['text'] = implode(';</br>', $attribute['text']); ?>
                <td><?php echo $attribute['text']; ?></td>
            </tr>
            <?php } ?>
            </tbody>
            <?php } ?>
        </table>
    <?php } ?>
</div>
<?php } ?>

<?php if ($people_bought_products) { ?>
<div class="wrap_box">
    <?php foreach ($people_bought_products as $products) { ?>
    <?php echo $products; ?>
    <?php } ?>
</div>
<?php } ?>

<div class="clear"></div>

<?php if ($review_status) { ?>
<div id="comment-0" class="tab-content">
    <div id="comment" ></div>

    <div id="reply_comments">
        <h2 id="comment-title"><?php echo $text_write; ?></h2>

        <div id="comment_work_0"  style="width: 100%; margin-top: 10px;">
            <b><ins style="color: #777;"><?php   echo $entry_name; ?></ins></b>
            <br>
            <input type="text" name="name" value="<?php echo $text_login; ?>" >
            <?php if (!isset($customer_id)) { ?>
            <?php echo $text_welcome; ?>
            <?php } ?>
            <div style="overflow: hidden; line-height:1px; margin-top: 5px;"></div>
            <b><ins style="color: #777;"><?php echo $entry_comment; ?></ins></b><br>
            <textarea name="text" cols="40" rows="8" class="blog-record-textarea"></textarea>
            <br>
            <span style="font-size: 11px; opacity: 0.50"><?php echo $text_note; ?></span>
            <div style="overflow: hidden; line-height:1px; margin-top: 5px;"></div>
            <b><ins style="color: #777;"><?php echo $entry_rating; ?></ins></b>&nbsp;&nbsp;
            <span><ins style="color: red;"><?php echo $entry_bad; ?></ins></span>&nbsp;
            <input type="radio" name="rating" value="1" >
            <ins class="blog-ins_rating" style="">1</ins>
            <input type="radio" name="rating" value="2" >
            <ins class="blog-ins_rating" >2</ins>
            <input type="radio" name="rating" value="3" >
            <ins class="blog-ins_rating" >3</ins>
            <input type="radio" name="rating" value="4" >
            <ins class="blog-ins_rating" >4</ins>
            <input type="radio" name="rating" value="5" >
            <ins class="blog-ins_rating" >5</ins>
            &nbsp;&nbsp;
            <span><ins style="color: green;"><?php echo $entry_good; ?></ins></span>
            <div style="overflow: hidden; line-height:1px; margin-top: 5px;"></div>
            <div class="buttons">
                <input type="button" id="file_comment_0" class="button" value="<?php echo $text_file_comment; ?>">
                <span class="info" ></span>
                <input type="hidden" id="file_comment_hidden_0" >
                <div class="clear"></div>
                <div class="left"><a class="button button-comment" id="button-comment-0"><span><?php echo $button_write; ?></span></a></div>
            </div>
        </div>
    </div>
</div>
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
</div>

<?php echo $content_bottom; ?>
</div>
</div>

<script type="text/javascript" src="<?php echo HTTP_APPLICATION; ?>view/javascript/jquery/ajaxupload.js"></script>

<script type="text/javascript"><!--
    $('.colorbox').colorbox({
        overlayClose: true,
        opacity: 0.5
    });

    $('.first_price').children("input").attr('checked', true);
    $('.first_price').css('color', '#FFFFFF');
    $('.first_price').css('background-color', '#5BD2EC');

    $('.prod_price').click(function() {
        $('.prod_price').each(function() {
            $(this).css('background-color', '');
            $(this).css('color', '#000000');
        });

        $(this).css('color', '#FFFFFF');
        $(this).children("input").attr('checked', true);
        $(this).css('background-color', '#5BD2EC');
    });
    //--></script>

<script type="text/javascript"><!--
    $('#button-cart').bind('click', function() {
        $.ajax({
            url: 'index.php?route=checkout/cart/add',
            type: 'post',
            data: $('.product-info input[type=\'text\'], .product-info input[type=\'hidden\'], .product-info .prod_price input:radio:checked, .product-info input[type=\'checkbox\']:checked, .product-info input[type=\'radio\']:checked, .product-info select, .product-info textarea'),
            dataType: 'json',
            success: function(json) {
                $('.success, .warning, .attention, information, .error').remove();

                if (json['error']) {
                    if (json['error']['option']) {
                        for (i in json['error']['option']) {
                            $('#option-' + i).prepend('<div><span id="option_' + i + '" class="error">' + json['error']['option'][i] + '</span></div>');
                        }

                        var first = "";
                        for (first in json['error']['option']) break;
                        $('html, body').animate({ scrollTop: $('#option_' + first).offset().top }, 'slow');
                    }

                    if (json['error']['gift_quantity']) {
                        $('.birth_day').append('<div class="error"><span class="red">' + json['error']['gift_quantity'] + '</span></div>');
                    }
                }

                if (json['success']) {
                    window.location.href = "<?php echo $link_cart; ?>";
                    $('#notification').html('<div class="success" style="display: none;">' + json['success'] + '<img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>');
                    $('.success').fadeIn('slow');
                    $('#cart-total').html(json['total']);
                    $('html, body').animate({ scrollTop: 0 }, 'slow');
                    $('.birth_day').remove();
                    $('.product-info .price').removeClass('none');
                    $('#cart > .heading .cart_circle ').attr('class', 'cart_prod_many');
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


<script type="text/javascript"><!--
    new AjaxUpload($('#file_comment_0'), {
        action: 'index.php?route=product/product/upload',
        name: 'file',
        autoSubmit: true,
        responseType: 'json',
        onSubmit: function(file, extension) {
            $('#file_comment_0').after('<img src="catalog/view/theme/default/image/loading.gif" class="loading" style="padding-left: 5px;" />');
            $('#file_comment_0').attr('disabled', true);
        },
        onComplete: function(file, json) {
            $('#file_comment_0').attr('disabled', false);

            $('.error').remove();

            if (json['success']) {
                $('#file_comment_hidden_0').attr('value', json['file']);
                $('#comment_work_0 .buttons > .info').html("<?php echo $text_file_upload; ?>: " + json['file_show']);
            }

            if (json['error']) {
                $('#file_comment_0').after('<span class="error">' + json['error'] + '</span>');
            }

            $('.loading').remove();
        }
    });
    //--></script>

<script type="text/javascript">
    $('#target_id').click(function() {
        str = $(this).val();
        var heigth = 0;

        <?php if ($this->config->get('GALKAControl_status') == 1 && $this->config->get('GALKAControl_sticky_menu') == 1) { ?>
            heigth += $('#menu_wrapper').outerHeight(true);
        <?php } ?>

        jQuery.scrollTo($("#comment-title").offset().top - heigth, 1000);
    });

    function captcha() {
        $.ajax({
            type: 'POST',
            url: 'index.php?route=product/product/captcham',
            dataType: 'html',
            success: function(data){
                $('.captcha_status').html(data);
            }
        });
        return false;
    }

    $.fn.comments = function(sorting, page, scroll) {
        scroll = scroll || false;

        if (typeof(sorting) == "undefined") {
            sorting = 'none';
        }

        if (typeof(page) == "undefined") {
            page = '1';
        }

        return $.ajax({
            type: 'GET',
            url: 'index.php?route=product/product/comment&product_id=<?php echo $product_id; ?>&sorting=' + sorting + '&page=' + page,
            dataType: 'html',
            async: "false",
            success: function(data) {
                $('#comment').html(data);

                if (scroll == false && $(window.location.hash).length) {
                    var offset = $(window.location.hash).offset().top;

                    $('html, body').animate({
                        scrollTop: offset
                    }, 'slow');
                }
            }
        });
    };

    $( document ).ready(function() {
        $('#comment').comments();
    });

    $('#comment .pagination a').live('click', function() {
        $('#comment').prepend('<div class="attention"><img src="catalog/view/theme/<?php echo $theme; ?>/image/loading.gif" alt=""> <?php echo $text_wait; ?></div>');
        $('#comment').load(this.href);
        $('.attention').remove();
        return false;
    });

    function remove_success() {
        $('.success, .warning').fadeIn().animate({
            opacity: 0.0
        }, 5000, function() {
            $('.success, .warning').remove();
        });
    }

    function comment_write(event) {
        $('.success, .warning').remove();

        if (typeof(event.data.sorting) == "undefined") {
            sorting = 'none';
        } else {
            sorting = event.data.sorting;
        }

        if (typeof(event.data.page) == "undefined") {
            page = '1';
        } else {
            page = event.data.page;
        }

        if (typeof(this.id) == "undefined") {
            myid = '0';
        }  else  {
            myid = this.id.replace('button-comment-','');
        }

        $.ajax({
            type: 'POST',
            url: 'index.php?route=product/product/write&product_id=<?php echo $product_id; ?>&parent=' + myid + '&page=' + page,
            dataType: 'json',
            data: 'name=' + encodeURIComponent($('#comment_work_' + myid).find('input[name=\'name\']').val()) + '&text=' + encodeURIComponent($('#comment_work_'+myid).find('textarea[name=\'text\']').val()) + '&rating=' + encodeURIComponent($('#comment_work_'+myid).find('input[name=\'rating\']:checked').val() ? $('#comment_work_'+myid).find('input[name=\'rating\']:checked').val() : '') + '&captcha=' + encodeURIComponent($('#comment_work_'+myid).find('input[name=\'captcha\']').val()) + '&file_comment=' + $('#file_comment_hidden_' + myid).val(),
            beforeSend: function() {
                $('.success, .warning').remove();
                $('.button-comment').attr('disabled', true);
                $('#comment-title').after('<div class="attention"><img src="catalog/view/theme/<?php echo $theme; ?>/image/loading.gif" alt=""> <?php echo $text_wait; ?></div>');
            },
            success: function(data) {
                $('.attention').remove();

                if (data.error) {
                    if ( myid == '0') {
                        $('#comment-title').after('<div class="warning">' + data.error + '</div>');
                    } else {
                        $('#comment_work_'+ myid).prepend('<div class="warning">' + data.error + '</div>');
                    }
                }

                if (data.success) {
                    var scroll = true;

                    $.when($('#comment').comments(sorting, page , scroll)).done(function() {
                        if ( myid == '0') {
                            $('#comment-title').after('<div class="success">' + data.success + '</div>');
                        } else {
                            $('#comment_work_' + myid).append('<div class="success">'+  data.success +'</div>');
                        }

                        remove_success();
                    });

                    $('.comment_count').html(data.comment_count);
                    $('input[name=\'name\']').val(data.login);
                    $('textarea[name=\'text\']').val('');
                    $('input[name=\'rating\']:checked').attr('checked', '');
                    $('input[name=\'captcha\']').val('');
                    $('html, body').animate({ scrollTop: $('#comment-' + myid).offset().top }, 'slow');
                }
            }
        });
    }

    $('.button-comment').unbind();
    $('.button-comment').bind('click',{ }, comment_write);
    $('#tabs a').tabs();
</script>



<?php echo $footer; ?>