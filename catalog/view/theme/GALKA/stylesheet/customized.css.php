<style type="text/css">
body {
<?php if($this->config->get('GALKAControl_bodyBgImg') != '') { ?>
    background:url("<?php echo $base; ?>image/<?php echo  $this->config->get('GALKAControl_bodyBgImg');?>") top center repeat;
<?php } ?>

<?php if(( $this->config->get('GALKAControl_body_bg_pattern') != null) && ($this->config->get('GALKAControl_body_bg_pattern') != 'pattern0.png') && ($this->config->get('GALKAControl_bodyBgImg') == '')) { ?>
    background:url("catalog/view/theme/<?php echo $this->config->get('config_template'); ?>/image/backgrounds/<?php echo  $this->config->get('GALKAControl_body_bg_pattern');?>") top center repeat;
<?php } ?>
    <?php if ($this->config->get('GALKAControl_text_color')) { ?>
        color:#<?php echo $this->config->get('GALKAControl_text_color'); ?>;
    <?php } ?>
}
h1, h2, h3, h4, h5, h6, #menu ul li.top_cat > a, #column-left .box .box-heading, #column-right .box .box-heading, .htabs a, .product-info .price-old, .product-info .price-new, .product-info .cart .button, .offer_title, .name a, #content .boxPlain .box-heading {
<?php if( $this->config->get('GALKAControl_custom_font') != null) { ?>
    font-family: '<?php echo  $this->config->get('GALKAControl_custom_font_family'); ?>';
<?php } ?>
}
<?php if(($this->config->get('GALKAControl_status') == '1') && ( $this->config->get('GALKAControl_headings_color') != null)) { ?>
h1, h2, h2.heading_title, h3, h4, h5, h6, #column-left .box .box-heading, #column-right .box .box-heading {
    color:#<?php echo $this->config->get('GALKAControl_headings_color'); ?>;
}
<?php
}
?>  <?php if(($this->config->get('GALKAControl_status') == '1') && ( $this->config->get('GALKAControl_header_top_border') != null)) {
?> #container {
           border-color:#<?php echo $this->config->get('GALKAControl_header_top_border') ?>;
       }
<?php
}
?>  <?php if(($this->config->get('GALKAControl_status') == '1') && ( $this->config->get('GALKAControl_headings1_size') != null)) {
?> h1 {
           font-size:<?php echo $this->config->get('GALKAControl_headings1_size') ?>px;
       }
<?php
}
?>  <?php if(($this->config->get('GALKAControl_status') == '1') && ( $this->config->get('GALKAControl_headings2_size') != null)) {
?> h2, #content .boxPlain .box-heading {
           font-size:<?php echo $this->config->get('GALKAControl_headings2_size') ?>px;
       }
<?php
}
?>  <?php if(($this->config->get('GALKAControl_status') == '1') && ( $this->config->get('GALKAControl_headings3_size') != null)) {
?> h3 {
           font-size:<?php echo $this->config->get('GALKAControl_headings3_size') ?>px;
       }
<?php
}
?>  <?php if(($this->config->get('GALKAControl_status') == '1') && ( $this->config->get('GALKAControl_headings4_size') != null)) {
?> h4 {
           font-size:<?php echo $this->config->get('GALKAControl_headings4_size') ?>px;
       }
<?php
}
?>  <?php if(($this->config->get('GALKAControl_status') == '1') && ( $this->config->get('GALKAControl_price_size') != null)) {
?> .product-info .price {
           font-size:<?php echo $this->config->get('GALKAControl_price_size') ?>px;
       }
<?php
}
?>  <?php if(($this->config->get('GALKAControl_status') == '1') && ( $this->config->get('GALKAControl_module_title_size') != null)) {
?> #content h2.heading_title span {
           font-size:<?php echo $this->config->get('GALKAControl_module_title_size') ?>px;
       }
<?php
}
?>  <?php if(($this->config->get('GALKAControl_status') == '1') && ( $this->config->get('GALKAControl_column_title_size') != null)) {
?> #column-left .box .box-heading, #column-right .box .box-heading {
           font-size:<?php echo $this->config->get('GALKAControl_column_title_size') ?>px;
       }
<?php
}
?>  <?php if(($this->config->get('GALKAControl_status') == '1') && ( $this->config->get('GALKAControl_category_item_size') != null)) {
?> #menu ul#topnav > li > a, #menu > ul.topnav2 > li > a {
           font-size:<?php echo $this->config->get('GALKAControl_category_item_size') ?>px;
       }
<?php
}
?>  <?php if(($this->config->get('GALKAControl_status') == '1') && ( $this->config->get('GALKAControl_headings_accent') != null)) {
?> #content .heading_title span {
           border-color:#<?php echo $this->config->get('GALKAControl_headings_accent') ?>;
       }
<?php
}
?>  <?php if(($this->config->get('GALKAControl_status') == '1') && ( $this->config->get('GALKAControl_links_color') != null)) {
?> a, a:visited {
           color:#<?php echo $this->config->get('GALKAControl_links_color') ?>;
       }
<?php
}
?>  <?php if(($this->config->get('GALKAControl_status') == '1') && ( $this->config->get('GALKAControl_links_color_hover') != null)) {
?> a:hover {
           color:#<?php echo $this->config->get('GALKAControl_links_color_hover') ?>;
       }
<?php
}
?>  <?php if(($this->config->get('GALKAControl_status') == '1') && ( $this->config->get('GALKAControl_buttons_color') != null)) {
?> a.button, input.button {
           background-color:#<?php echo $this->config->get('GALKAControl_buttons_color') ?>;
       }
<?php
}
?>  <?php if(($this->config->get('GALKAControl_status') == '1') && ( $this->config->get('GALKAControl_buttons_color_hover') != null)) {
?> a.button:hover, input.button:hover {
           background-color:#<?php echo $this->config->get('GALKAControl_buttons_color_hover') ?>;
       }
<?php
}
?>  <?php if(($this->config->get('GALKAControl_status') == '1') && ( $this->config->get('GALKAControl_new_label_color') != null)) {
?> .new_prod b {
           background-color:#<?php echo $this->config->get('GALKAControl_new_label_color') ?>;
       }
<?php
}
?>  <?php if(($this->config->get('GALKAControl_status') == '1') && ( $this->config->get('GALKAControl_sale_label_color') != null)) {
?> .sale b {
           background-color:#<?php echo $this->config->get('GALKAControl_sale_label_color') ?>;
       }
<?php
}
?>  <?php if(($this->config->get('GALKAControl_status') == '1') && ( $this->config->get('GALKAControl_save_label_color') != null)) {
?> .save b {
           background-color:#<?php echo $this->config->get('GALKAControl_save_label_color') ?>;
       }
<?php
}
?>  <?php if(($this->config->get('GALKAControl_status') == '1') && ( $this->config->get('GALKAControl_breadcrumb_color') != null)) {
?> .breadcrumb, .breadcrumb a {
           color:#<?php echo $this->config->get('GALKAControl_breadcrumb_color') ?>;
       }
<?php
}
?>
#header {
<?php if($this->config->get('GALKAControl_HeaderBgImg') != '') { ?>
    background:url("<?php echo $base; ?>image/<?php echo  $this->config->get('GALKAControl_HeaderBgImg');?>") top center repeat;
<?php } ?>
<?php if(( $this->config->get('GALKAControl_header_bg_pattern') != null) && ($this->config->get('GALKAControl_header_bg_pattern') != 'pattern0.png') && ($this->config->get('GALKAControl_HeaderBgImg') == '')) { ?>
    background:url("catalog/view/theme/<?php echo $this->config->get('config_template'); ?>/image/backgrounds/<?php echo  $this->config->get('GALKAControl_header_bg_pattern');?>") top center repeat;
<?php } ?>
<?php if(($this->config->get('GALKAControl_status') == '1') && ( $this->config->get('GALKAControl_header_bg_color') != null)) { ?>
    background-color:#<?php echo $this->config->get('GALKAControl_header_bg_color') ?>;
<?php } ?>
<?php if(($this->config->get('GALKAControl_status') == '1') && ( $this->config->get('GALKAControl_header_top_color') != null)) { ?>
    border-top-color:#<?php echo $this->config->get('GALKAControl_header_top_color') ?>;
<?php } ?>
}
<?php if(($this->config->get('GALKAControl_status') == '1') && ( $this->config->get('GALKAControl_header_top_color') != null)) { ?>
#header_colapse, #togglerone {
    background-color:#<?php echo $this->config->get('GALKAControl_header_top_color') ?>;
}
<?php } ?>
#menu ul#topnav {
<?php if(($this->config->get('GALKAControl_status') == '1') && ( $this->config->get('GALKAControl_category_menu_back') != null)) { ?>
    background-color:#<?php echo $this->config->get('GALKAControl_category_menu_back') ?>;
<?php } ?>
}
#menu {
<?php if(($this->config->get('GALKAControl_status') == '1') && ( $this->config->get('GALKAControl_category_menu_border') != null)) { ?>
    border-bottom-color:#<?php echo $this->config->get('GALKAControl_category_menu_border') ?>;
<?php } ?>
}
<?php if(($this->config->get('GALKAControl_status') == '1') && ( $this->config->get('GALKAControl_main_menu_color') != null)) { ?>
#header .links a, #header .links ul li.subico span {
    color:#<?php echo $this->config->get('GALKAControl_main_menu_color') ?>;
}
<?php } ?>
#header .links a:hover, #header .links a.selected {
<?php if(($this->config->get('GALKAControl_status') == '1') && ( $this->config->get('GALKAControl_main_menu_hover_color') != null)) { ?>
    color:#<?php echo $this->config->get('GALKAControl_main_menu_hover_color') ?>;
<?php } ?>
<?php if(($this->config->get('GALKAControl_status') == '1') && ( $this->config->get('GALKAControl_main_menu_hover_background') != null)) { ?>
    background-color:#<?php echo $this->config->get('GALKAControl_main_menu_hover_background') ?>;
<?php } ?>
}
<?php if(($this->config->get('GALKAControl_status') == '1') && ( $this->config->get('GALKAControl_category_menu_color') != null)) { ?>
#menu ul#topnav > li > a, #menu > ul.topnav2 > li > a, #menu ul#topnav ul.children li.pic_name h3 a span, #menu ul#topnav ul.children a, #menu ul#topnav li:hover ul.children a, #menu > ul.topnav2 >li ul > li > a, #menu > ul#topnav > li > div ul > li > a {
    color:#<?php echo $this->config->get('GALKAControl_category_menu_color') ?>;
}
<?php } ?>
#menu > ul.topnav2 > li:hover > a, #menu > ul#topnav > li:hover > a, #menu ul#topnav ul.children li a:hover, #menu > ul.topnav2 > li ul > li > a:hover, #menu > ul#topnav > li div ul > li > a:hover {
<?php if(($this->config->get('GALKAControl_status') == '1') && ( $this->config->get('GALKAControl_category_menu_hover_color') != null)) { ?>
    color:#<?php echo $this->config->get('GALKAControl_category_menu_hover_color') ?>;
<?php } ?>
<?php if(($this->config->get('GALKAControl_status') == '1') && ( $this->config->get('GALKAControl_category_menu_hover_background') != null)) { ?>
    background-color:#<?php echo $this->config->get('GALKAControl_category_menu_hover_background') ?>;
<?php } ?>
}
#menu ul#topnav li a.selected {
<?php if(($this->config->get('GALKAControl_status') == '1') && ( $this->config->get('GALKAControl_category_menu_hover_background') != null)) { ?>
    background-color:#<?php echo $this->config->get('GALKAControl_category_menu_hover_background') ?>;
<?php } ?>
}
<?php if(($this->config->get('GALKAControl_status') == '1') && ( $this->config->get('GALKAControl_menu_icon_back') != null)) { ?>
#header .button-search {
    background-color:#<?php echo $this->config->get('GALKAControl_menu_icon_back') ?>;
}
<?php } ?>
<?php if(($this->config->get('GALKAControl_status') == '1') && ( $this->config->get('GALKAControl_cart_icon_back') != null)) { ?>
#header #cart .cart_circle {
    background-color:#<?php echo $this->config->get('GALKAControl_cart_icon_back') ?>;
}
<?php } ?>
<?php if(($this->config->get('GALKAControl_status') == '1') && ( $this->config->get('GALKAControl_drop_border') != null)) { ?>
#header .links ul.secondary, #header #cart .content, #menu > ul.topnav2 > li > div, #menu > ul#topnav > li > div, #menu ul#topnav ul.children, #menu ul#topnav ul.children2 {
    border-bottom-color:#<?php echo $this->config->get('GALKAControl_drop_border') ?>;
}
<?php } ?>
#footer {
<?php if($this->config->get('GALKAControl_FooterBgImg') != '') { ?>
    background:url("<?php echo $base; ?>image/<?php echo  $this->config->get('GALKAControl_FooterBgImg');?>") top center repeat;
<?php } ?>
<?php if(( $this->config->get('GALKAControl_header_bg_pattern') != null) && ($this->config->get('GALKAControl_footer_bg_pattern') != 'pattern0.png') && ($this->config->get('GALKAControl_FooterBgImg') == '')) {
?> background:url("catalog/view/theme/<?php echo $this->config->get('config_template'); ?>/image/backgrounds/<?php echo  $this->config->get('GALKAControl_footer_bg_pattern');?>") top center repeat;
<?php
}
?> <?php if(($this->config->get('GALKAControl_status') == '1') && ( $this->config->get('GALKAControl_footer_bg_color') != null)) {
?> background-color:#<?php echo $this->config->get('GALKAControl_footer_bg_color') ?>;
<?php
}
?> <?php if(($this->config->get('GALKAControl_status') == '1') && ( $this->config->get('GALKAControl_prefooter_border_top') != null)) {
?> border-top-color:#<?php echo $this->config->get('GALKAControl_prefooter_border_top') ?>;
<?php
}
?>
}
<?php if(($this->config->get('GALKAControl_status') == '1') && ( $this->config->get('GALKAControl_footer_link_color') != null)) {
?> #footer h4 {
       color:#<?php echo $this->config->get('GALKAControl_footer_link_color') ?>;
   }
<?php
}
?>  <?php if(($this->config->get('GALKAControl_status') == '1') && ( $this->config->get('GALKAControl_footer_link_border') != null)) {
?> #footer h4, .tweet_list li, .footer_time, .footer_address, .footer_phone, .footer_fax, .footer_mail, .footer_skype, #footer .column ul.footer_links li, #footer .column:first-child {
           border-color:#<?php echo $this->config->get('GALKAControl_footer_link_border') ?>;
       }
<?php
}
?>  #powered {
    <?php if(($this->config->get('GALKAControl_status') == '1') && ( $this->config->get('GALKAControl_powered_bg') != null)) {
   ?> background-color:#<?php echo $this->config->get('GALKAControl_powered_bg') ?>;
    <?php
    }
    ?> <?php if(($this->config->get('GALKAControl_status') == '1') && ( $this->config->get('GALKAControl_powered_text') != null)) {
?> color:#<?php echo $this->config->get('GALKAControl_powered_text') ?>;
    <?php
   }
   ?>
    }
<?php if(($this->config->get('GALKAControl_status') == '1') && ( $this->config->get('GALKAControl_cart_button_color') != null)) {
?> input.button_cart_product, a.add_to_cart_small {
       background-color:#<?php echo $this->config->get('GALKAControl_cart_button_color') ?>;
   }
<?php
}
?>  <?php if(($this->config->get('GALKAControl_status') == '1') && ( $this->config->get('GALKAControl_wish_button_color') != null)) {
?> a.add_to_wishlist_small {
           background-color:#<?php echo $this->config->get('GALKAControl_wish_button_color') ?>;
       }
<?php
}
?>  <?php if(($this->config->get('GALKAControl_status') == '1') && ( $this->config->get('GALKAControl_compare_button_color') != null)) {
?> a.add_to_compare_small {
           background-color:#<?php echo $this->config->get('GALKAControl_compare_button_color') ?>;
       }
<?php
}
?>  <?php if(($this->config->get('GALKAControl_status') == '1') && ( $this->config->get('GALKAControl_main_price_color') != null)) {
?> div.prod_hold .price-new, .accordeonHolder .price-new, div.prod_hold .prod-info-fly .price, .accordeonHolder .price, .product-info .price {
           color:#<?php echo $this->config->get('GALKAControl_main_price_color') ?>;
       }
<?php
}
?>  <?php if(($this->config->get('GALKAControl_status') == '1') && ( $this->config->get('GALKAControl_old_price_color') != null)) {
?> .product-info .price-old, div.prod_hold .price-old, .accordeonHolder .price-old {
           color:#<?php echo $this->config->get('GALKAControl_old_price_color') ?>;
       }
<?php
}
?>  <?php if(($this->config->get('GALKAControl_status') == '1') && ( $this->config->get('GALKAControl_product_tab_color') != null)) {
?> .htabs a.selected, .htabs a:hover {
           border-top-color:#<?php echo $this->config->get('GALKAControl_product_tab_color') ?>;
           color:#<?php echo $this->config->get('GALKAControl_product_tab_color') ?>;
       }
<?php
}
?>  <?php if(($this->config->get('GALKAControl_status') == '1') && ( $this->config->get('GALKAControl_site_mode') == '0')) {
?> #header #cart, #header .links a.cart_link, a.add_to_cart_small, input#button-cart, input.compare_cart, img.wish-cart, .plus_minus_quantity {
           display:none;
       }
div.prod_hold {
    height:360px;
}
<?php
}
?>
<?php if(($this->config->get('GALKAControl_status') == '1') && ( $this->config->get('GALKAControl_countdown_color') != null)) {
?> .count_holder, .count_holder_small {
       background-color:#<?php echo $this->config->get('GALKAControl_countdown_color') ?>;
   }
<?php
}
?>
<?php if(($this->config->get('GALKAControl_status') == '1') && ($this->config->get('GALKAControl_custom_css') != null)) {
?> <?php echo $this->config->get('GALKAControl_custom_css') ?> <?php
}
?>
</style>
