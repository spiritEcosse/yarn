<?php if (isset($_SERVER['HTTP_USER_AGENT']) && !strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 6')) { 
    echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
} ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" xml:lang="<?php echo $lang; ?>">
    <head>
        <title><?php echo $title; ?></title>
        <base href="<?php echo $base; ?>" />

        <?php if ($description) { ?>
            <meta name="description" content="<?php echo $description; ?>" />
        <?php } ?>

        <?php if ($keywords) { ?>
            <meta name="keywords" content="<?php echo $keywords; ?>" />
        <?php } ?>

        <?php if ($icon) { ?>
            <link href="<?php echo $icon; ?>" rel="icon" />
        <?php } ?>

        <?php foreach ($links as $link) { ?>
            <link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
        <?php } ?>

        <?php foreach ($styles as $style) { ?>
            <link rel="<?php echo $style['rel']; ?>" type="text/css" href="<?php echo $style['href']; ?>" media="<?php echo $style['media']; ?>" />
        <?php } ?>

        <?php foreach ($scripts as $script) { ?>
            <script type="text/javascript" src="<?php echo $script; ?>"></script>
        <?php } ?>

        <!--[if IE 7]>
        <link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/ie7.css" />
        <![endif]-->
        <!--[if lt IE 7]>
        <link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/ie6.css" />
        <script type="text/javascript" src="catalog/view/javascript/DD_belatedPNG_0.0.8a-min.js"></script>
        <script type="text/javascript">
        DD_belatedPNG.fix('#logo img');
        </script>
        <![endif]-->
        <?php echo $google_analytics; ?>

        <script type="text/javascript">
          config('<?php echo HTTP_SERVER; ?>', "<?php echo $this->config->get('config_template'); ?>");
        </script> 
    </head>
    <body>
        <div id="container">
            <div id="header">
                <div class="linetop" >
                    <?php if ($logo) { ?>
                        <a href="<?php echo $home; ?>">
                            <img src="image/data/logotitle.jpg" />
                        </a>
                    <?php } ?>

                    <?php echo $cart; ?>

                    <div class="top_menu">
                        <?php foreach ($tops as $top) { ?>
                        <a href="<?php echo $top['href']; ?>"><?php echo $top['title']; ?></a>
                        <?php } ?>    
                    </div>
                </div>
                <?php if ($logo) { ?>
                <div id="logo">
                    <a href="<?php echo $home; ?>">
                        <img src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" />
                    </a>
                    <div class="list_city">
                        Киев, Днепропетровск, Донецк, Харьков
                    </div>
                </div>
                <?php } ?>
                <?php //echo $language; ?>
                <?php //echo $currency; ?>
                <div id="welcome">
                    <?php if (!$logged) { ?>
                    <?php echo $text_welcome; ?>
                    <?php } else { ?>
                    <?php echo $text_logged; ?>
                    <?php } ?>
                </div>

                <?php if ( $telephones ) { ?>
                    <div class="telephone_top">
                        <h3><?php echo $text_telephone; ?></h3>
                        <div class="number">
                            <b>
                                <span class="prefix">(044)</span>
                                <span class="number">&nbsp;362-19-40</span>
                            </b>
                            <b>
                                <span class="prefix">(098)</span>
                                <span class="number">&nbsp;110-04-60</span>
                            </b>
                            <b>
                                <span class="prefix">(063)</span>
                                <span class="number">&nbsp;597-47-55</span>
                            </b>
                            <b>
                                <span class="prefix">(099)</span>
                                <span class="number">&nbsp;561-01-32</span>
                            </b>
                        </div>
                    </div>
                <?php } ?>
                <?php if ( $email_shop ) { ?>
                <div class="email_top">
                    <h3><?php echo $text_email; ?></h3>
                    <b><?php echo $email_shop; ?></b>
                </div>
                <?php } ?>
                
                <?php if ( $skype ) { ?>
                <div class="skype_top">
                    <h3><?php echo $text_skype; ?></h3>
                    <b><?php echo $skype; ?></b>
                </div>
                <?php }?>
                <?php if ($credit_href && $credit_title) { ?>
                <div class="credit">
                    <a class="ukr_sib" href="<?php echo $credit_href; ?>">
                        <img src="/image/data/ukrsibbank.png" title="кредит в укрсиббанке" alt="кредит в укрсиббанке" />
                    </a>
                    <a href="<?php echo $credit_href; ?>">
                        <img src="<?php echo $credit_image; ?>"  title="<?php echo $credit_title; ?>" alt="<?php $credit_title; ?>" />
                    </a>
                </div>
                <?php } ?>
                
                <div id="search">
                    <div class="button-search"></div>

                    <?php if ($filter_name) { ?>
                        <input type="text" name="filter_name" value="<?php echo $filter_name; ?>" />
                    <?php } else { ?>
                        <input type="text" name="filter_name" value="<?php echo $text_search; ?>" onclick="this.value = '';" onkeydown="this.style.color = '#000000';" />
                    <?php } ?>
                </div>
                <div class="links">
                    <a href="<?php echo $home; ?>"><?php echo $text_home; ?></a>
                    <a href="<?php echo $wishlist; ?>" id="wishlist-total"><?php echo $text_wishlist; ?></a>
                    <a href="<?php echo $account; ?>"><?php echo $text_account; ?></a>
                    <a href="<?php echo $shopping_cart; ?>"><?php echo $text_shopping_cart; ?></a>
                    <a href="<?php echo $checkout; ?>"><?php echo $text_checkout; ?></a>
                </div>
            </div>
            <div id="topmenu">
                <?php $parts = array(); ?>
                
                <?php if (isset($this->request->get['path'])) {
                    $parts = explode('_', (string)$this->request->get['path']);
                } ?>

                <?php if ($categories) { ?>
                    <ul class="sf-menu">

                    <?php foreach ($categories as $category) { ?>
                        <?php $class = ''; ?> 

                        <?php if (in_array($category['category_id'], $parts)) { ?>
                            <?php $class = "topactive"; ?> 
                        <?php } ?>

                        <li>
                            <a href="<?php echo $category['href']; ?>" class="<?php echo $class; ?>" >
                                <?php echo $category['name']; ?>
                            </a>

                            <?php getSubCategories($category['children']); ?>
                        </li>
                    <?php } ?>
                    </ul>
                <?php } ?>
            </div>
            <div id="notification"></div>

<?php function getSubCategories($categories) { ?>    
    <ul>
        <?php foreach ($categories as $category) { ?>
            <?php $class = ""; ?>

            <?php if ($category['children']) { ?>
                <?php $class = $class ? " class=\"activeparent\"" : " class=\"parent\""; ?>
            <?php } ?>

            <li>
                <a href="<?php echo $category['href']; ?>" <?php echo $class; ?> >
                    <?php echo $category['name']; ?>
                </a>

                <?php if ($category['children']) { ?>
                    <?php getSubCategories($category['children']); ?>
                <?php } ?>
            </li>
        <?php } ?>
    </ul>
<?php } ?>
