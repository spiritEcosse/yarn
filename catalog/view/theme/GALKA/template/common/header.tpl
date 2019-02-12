<!DOCTYPE html>
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<head>
    <meta charset="UTF-8" />
    <title><?php echo $title; ?></title>
    <base href="<?php echo $base; ?>" />

    <?php foreach($fbmetas as $fbmeta) { ?>
    <meta property="<?php echo $fbmeta['property']; ?>" content="<?php echo addslashes($fbmeta['content']); ?>" />
    <?php } ?>

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

    <script type="text/javascript" src="catalog/view/javascript/jquery/jquery-1.7.1.min.js"></script>
    <script type="text/javascript" src="catalog/view/javascript/jquery/ui/jquery-ui-1.8.16.custom.min.js"></script>

    <?php foreach ($scripts as $script) { ?>
    <script type="text/javascript" src="<?php echo $script; ?>"></script>
    <?php } ?>

    <?php echo $google_analytics; ?>

    <?php if ($this->config->get('GALKAControl_status') == 1) { ?>
    <?php include(DIR_TEMPLATE . $this->config->get('config_template') . '/stylesheet/customized.css.php'); ?>

    <?php if ($this->config->get('GALKAControl_responsive') == 1) {  ?>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <?php } else { ?>
    <meta name="viewport" content="width=1024">
    <?php } ?>
    <?php } ?>

    <!--[if IE 6]>
    <script type="text/javascript" >
        var markup =  '<div id="update_browser"><ul><li><a href="http://www.google.com/intl/ru/chrome/browser/"></a></li><li><a href="http://www.opera.com/browser/"></a></li><li><a href="https://www.mozilla.org/ru/firefox/new/"></a></li><li><a href="http://support.apple.com/kb/DL1531?viewlocale=ru_RU"></a></li><li><a href="http://windows.microsoft.com/ru-RU/internet-explorer/download-ie"></a></li></ul></div>';
        $(function(){
            $("body").html(markup);
        });
    </script>
    <![endif]-->

    <script type="text/javascript">
        var request = <?php echo json_encode($request); ?>;
        var route = null;
        var path = null;
        var product_id = null;

        <?php if (isset($this->request->get['route'])) { ?>
            route = "<?php echo $this->request->get['route']; ?>";
        <?php } ?>

        <?php if (isset($this->request->get['path'])) { ?>
            path = "<?php echo $this->request->get['path']; ?>";
        <?php } ?>

        <?php if (isset($this->request->get['product_id'])) { ?>
            product_id = "<?php echo $this->request->get['product_id']; ?>";
        <?php } ?>

        $(document).ready(function() {
            activeLink(request, route);
        });

        config('<?php echo HTTP_SERVER; ?>', "<?php echo $this->config->get('config_template'); ?>", route, path, product_id);
    </script>

    <!-- Put this script tag to the <head> of your page -->
    <script type="text/javascript" src="//vk.com/js/api/openapi.js?115"></script>

    <script type="text/javascript">
        VK.init({apiId: 4645499, onlyWidgets: true});
    </script>
</head>

<body>
<?php if ($audio == 1) { ?>
    <audio id="cart_add_sound" controls preload="auto" hidden="hidden">
        <?php if ($this->config->get('GALKAControl_status') == 1 && $this->config->get('GALKAControl_play_sound') == 1) { ?>
            <source src="<?php echo $base; ?>catalog/view/theme/<?php echo $this->config->get('config_template'); ?>/stylesheet/cart_add.wav" controls></source>
        <?php } ?>
    </audio>
<?php } ?>

<?php echo $this->config->get('GALKAControl_FooterBgImg'); ?>

<div id="container" class="<?php if($this->config->get('GALKAControl_layout') != null && $this->config->get('GALKAControl_status') == 1) { ?>
      <?php echo $this->config->get('GALKAControl_layout') ?>
    <?php } else { ?>
      <?php echo "full_width_container"; ?>
<?php } ?>">
<div id="header">
    <div class="inner main_head_inner">
        <?php if ($logo) { ?>
        <div id="logo">
            <a href="<?php echo $home; ?>">
                <img src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" />
            </a>
        </div>
        <?php } ?>

        <div id="welcome">
            <?php if (!$logged) { ?>
                <?php echo $text_welcome; ?>
            <?php } else { ?>
                <div class="block_welcome">
                    <?php echo $text_logged; ?>
                </div>
            <?php } ?>
        </div>
        <div id="notification"></div>

        <?php echo $cart; ?>
    </div>

    <?php echo $content_header; ?>

    <div class="inner wrapp_menu_header">
        <div id="search">
            <?php if ($search) { ?>
            <input type="text" name="filter_name" value="<?php echo $filter_name; ?>" />
            <?php } else { ?>
            <input type="text" name="filter_name" onfocus="if (this.value == '<?php echo $text_search; ?>') this.value = ''; " onblur="if (this.value == '') this.value = '<?php echo $text_search; ?>';" value="<?php echo $text_search; ?>" onclick="this.value = '';" onkeydown="this.style.color = '#000000';" />
            <?php } ?>
            <div class="button-search"></div>
        </div>

        <?php include(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/' . $menuType); ?>
    </div>
</div>
