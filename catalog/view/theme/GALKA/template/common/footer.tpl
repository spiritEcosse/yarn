<div id="footer">
    <div class="footer_top">
        <div class="inner">
            <div class="block_newsletter">
                <div class="text"><?php echo $text_newsletter; ?></div>
                <?php echo $content_footer; ?>
            </div>
            <div class="block_social">
                <div  class="text"><?php echo $text_social; ?></div>
                <div class="wrapp_social">
                    <?php if ($this->config->get('GALKAControl_status') == 1) { ?>
                        <?php if ($this->config->get('GALKAControl_vk_link') != null) { ?>
                            <a href="<?php echo $this->config->get('GALKAControl_vk_link'); ?>" class="vk"></a>
                        <?php } ?>

                        <?php if ($this->config->get('GALKAControl_facebook_link') != null) { ?>
                            <a href="<?php echo $this->config->get('GALKAControl_facebook_link'); ?>" class="facebook"></a>
                        <?php } ?>

                        <?php if ($this->config->get('GALKAControl_twitter_link') != null) { ?>
                            <a href="<?php echo $this->config->get('GALKAControl_twitter_link'); ?>" class="twitter"></a>
                        <?php } ?>

                        <?php if ($this->config->get('GALKAControl_classmates_link') != null) { ?>
                            <a href="<?php echo $this->config->get('GALKAControl_classmates_link'); ?>" class="classmates"></a>
                        <?php } ?>
                    <?php } ?>
                </div>
                <div class="block_share">
                    <div class="text"><?php echo $text_share; ?></div>
                    <div class="facebook">
                        <div id="fb-root"></div>
                        <script>(function(d, s, id) {
                                var js, fjs = d.getElementsByTagName(s)[0];
                                if (d.getElementById(id)) return;
                                js = d.createElement(s); js.id = id;
                                js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=164073580341460";
                                fjs.parentNode.insertBefore(js, fjs);
                            }(document, 'script', 'facebook-jssdk'));
                        </script>
                        <div class="fb-share-button" data-layout="button_count" data-href="<?php echo $_SERVER['REQUEST_URI']; ?>" data-width="100"></div>
                    </div>
                    <div class="vk">
                        <?php $this_url = $_SERVER['REQUEST_URI']; ?>
                        <script type="text/javascript" src="http://vk.com/js/api/share.js?90" charset="windows-1251"></script>

                        <script type="text/javascript"><!--
                            document.write(VK.Share.button({url: "<?php echo $this_url; ?>"},{type: "round", text: "Поделиться"}));
                            --></script>
                    </div>
                    <div class="classmates">
                        <div id="ok_shareWidget_footer"></div>
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
                            }(document,"ok_shareWidget_footer",document.URL,"{width:190,height:30,st:'oval',sz:20,ck:2}");
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="inner">
        <div class="one_fourth column">
            <h4><?php echo $text_information; ?></h4>
            <ul class="footer_links">
                <?php foreach ($informations as $information) { ?>
                <li><a href="<?php echo $information['href']; ?>"><?php echo $information['title']; ?></a></li>
                <?php } ?>
            </ul>
        </div>

        <div class="one_fourth column">
            <h4><?php echo $text_service; ?></h4>
            <ul class="footer_links">
                <?php foreach ($supports as $support) { ?>
                <li><a href="<?php echo $support['href']; ?>"><?php echo $support['title']; ?></a></li>
                <?php } ?>
                <li><a href="<?php echo $sitemap; ?>"><?php echo $text_sitemap; ?></a></li>
            </ul>
        </div>

        <div class="one_fourth column">
            <h4><?php echo $text_extra; ?></h4>
            <ul class="footer_links">
                <li><a href="<?php echo $special; ?>"><?php echo $text_special; ?></a></li>
                <li><a href="<?php echo $discount; ?>"><?php echo $text_discount; ?></a></li>
                <li><a href="<?php echo $sale; ?>"><?php echo $text_sale; ?></a></li>
                <li><a href="<?php echo $compare; ?>" class="compare_link"><?php echo $text_compare; ?></a></li>
                <li><a href="<?php echo $wishlist; ?>"><?php echo $text_wishlist; ?></a></li>
            </ul>
        </div>

        <?php if ($this->config->get('GALKAControl_status') == 1) { ?>
            <div class="one_fourth last column">
                <h4><?php echo $text_payment_and_delivery; ?></h4>
                <ul class="footer_links">
                    <li class="liqpay_icon cards_icon">LiqPay</li>

                    <?php if ($this->config->get('GALKAControl_paypal') == 1) { ?>
                        <li class="paypal_icon cards_icon">PayPal</li>
                    <?php } ?>

                    <?php if ($this->config->get('GALKAControl_visa') == 1) { ?>
                        <li class="visa_icon cards_icon">Visa</li>
                    <?php } ?>

                    <?php if ($this->config->get('GALKAControl_electron') == 1) { ?>
                    <li class="electron_icon cards_icon">Visa Electron</li>
                    <?php } ?>

                    <?php if ($this->config->get('GALKAControl_master') == 1) { ?>
                    <li class="master_icon cards_icon">MasterCard</li>
                    <?php } ?>

                    <?php if ($this->config->get('GALKAControl_maestro') == 1) { ?>
                    <li class="maestro_icon cards_icon">Maestro</li>
                    <?php } ?>

                    <?php if ($this->config->get('GALKAControl_cirrus') == 1) { ?>
                    <li class="cirrus_icon cards_icon">Cirrus</li>
                    <?php } ?>

                    <?php if ($this->config->get('GALKAControl_american') == 1) { ?>
                    <li class="american_icon cards_icon">American Express</li>
                    <?php } ?>

                    <?php if ($this->config->get('GALKAControl_2checkout') == 1) { ?>
                    <li class="two_checkout_icon cards_icon"></li>
                    <?php } ?>

                    <?php if ($this->config->get('GALKAControl_delta') == 1) { ?>
                    <li class="delta_icon cards_icon">Delta</li>
                    <?php } ?>

                    <?php if ($this->config->get('GALKAControl_discover') == 1) { ?>
                    <li class="discover_icon cards_icon">Discover</li>
                    <?php } ?>

                    <?php if ($this->config->get('GALKAControl_google') == 1) { ?>
                    <li class="google_icon cards_icon">Google</li>
                    <?php } ?>

                    <?php if ($this->config->get('GALKAControl_moneybookers') == 1) { ?>
                    <li class="moneybookers_icon cards_icon">Moneybookers</li>
                    <?php } ?>

                    <?php if ($this->config->get('GALKAControl_sage') == 1) { ?>
                    <li class="sage_icon cards_icon">Sage</li>
                    <?php } ?>

                    <?php if ($this->config->get('GALKAControl_solo') == 1) { ?>
                    <li class="solo_icon cards_icon">Solo</li>
                    <?php } ?>

                    <?php if ($this->config->get('GALKAControl_switch') == 1) { ?>
                    <li class="switch_icon cards_icon">Switch</li>
                    <?php } ?>

                    <?php if ($this->config->get('GALKAControl_western') == 1) { ?>
                    <li class="western_icon cards_icon">Western</li>
                    <?php } ?>
                </ul>
                <?php if ($this->config->get('GALKAControl_delivery_switch') == 1) { ?>
                    <div class="delivery_icon"><?php echo $this->config->get('GALKAControl_delivery_text'); ?></div>
                <?php } ?>
            </div>
        <?php } ?>

        <div class="clear"></div>

        <div class="text_security">
            <h4><?php echo $text_security; ?></h4>
            <div class="desc">
                <?php echo $text_security_desc; ?>
            </div>
        </div>

        <div class="clear"></div>
    </div>
</div>
<div id="powered">
    <div class="inner">
        <?php if ($this->config->get('GALKAControl_copyright') != null && $this->config->get('GALKAControl_status') == 1) { ?>
        <?php echo html_entity_decode($this->config->get('GALKAControl_copyright')); ?>
        <?php } else { ?>
        <?php echo $powered; ?>
        <?php } ?>
    </div>
</div>
</div>

<?php if ($this->config->get('GALKAControl_status') == 1) { ?>
<?php if ($this->config->get('GALKAControl_responsive') == 1) { ?>
<script>
    selectnav('main_nav', {
        label: ' Главное меню ',
        nested: true,
        activeclass: 'selected',
        indent: '-'
    });
</script>

<script>
    selectnav('topnav', {
        label: ' Категории ',
        nested: true,
        activeclass: 'selected',
        indent: '-'
    });
    selectnav('topnav2', {
        label: ' Категории ',
        nested: true,
        activeclass: 'selected',
        indent: '-'
    });
</script>
<?php } ?>

<?php } ?>


<a style='position: fixed; bottom: 60px; right: 1px; cursor:pointer; display:none;'
   href='#' id='Go_Top'>
    <img src="/image/up.png" alt="Наверх" title="Наверх">
</a>
<a style='position: fixed; bottom: 20px; right: 1px; cursor:pointer; display:none;'
   href='#' id='Go_Bottom'>
    <img src="/image/down.png" alt="Вниз" title="Вниз">
</a>


<script language="JavaScript" type="text/javascript"
        src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js">
</script>
<script language="JavaScript" type="text/javascript">
    var go_down = jQuery('body');
    jQuery(function() {
        $("#Go_Top").hide().removeAttr("href");
        if ($(window).scrollTop() >= "250") $("#Go_Top").fadeIn("slow")
        var scrollDiv = $("#Go_Top");
        $(window).scroll(function() {
            if ($(window).scrollTop() <= "250") $(scrollDiv).fadeOut("slow")
            else $(scrollDiv).fadeIn("slow")
        });
        $("#Go_Bottom").hide().removeAttr("href");
        if ($(window).scrollTop() <= go_down.height()-"999") $("#Go_Bottom").fadeIn("slow")
        var scrollDiv_2 = $("#Go_Bottom");
        $(window).scroll(function() {
            if ($(window).scrollTop() >= go_down.height()-"999") $(scrollDiv_2).fadeOut("slow")
            else $(scrollDiv_2).fadeIn("slow")
        });
        $("#Go_Top").click(function() {
            $("html, body").animate({scrollTop: 0}, "slow")
        })
        $("#Go_Bottom").click(function() {
            $("html, body").animate({scrollTop: go_down.height()}, "slow")
        })
    });
</script>

</body>
</html>