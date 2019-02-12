<?php if (isset($_SERVER['HTTP_USER_AGENT']) && !strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 6')) echo '<?xml version="1.0" encoding="UTF-8"?>'. "\n"; ?>
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
        
        <link rel="stylesheet" type="text/css" href=
                    "catalog/view/theme/default/stylesheet/furniture_order_style.css" />
        
        <?php foreach ($styles as $style) { ?>
        <link rel="<?php echo $style['rel']; ?>" type="text/css" href="<?php echo $style['href']; ?>" media="<?php echo $style['media']; ?>" />
        <?php } ?>
        
        <script type="text/javascript" src="catalog/view/javascript/jquery/jquery-1.7.1.min.js"></script>

        <script type="text/javascript" src="catalog/view/javascript/jquery/ui/jquery-ui-1.8.16.custom.min.js"></script>
        <link rel="stylesheet" type="text/css" href="catalog/view/javascript/jquery/ui/themes/ui-lightness/jquery-ui-1.8.16.custom.css" />
        <script type="text/javascript" src="catalog/view/javascript/jquery/ui/external/jquery.cookie.js"></script>
        <script type="text/javascript" src="catalog/view/javascript/jquery/colorbox/jquery.colorbox.js"></script>
        <link rel="stylesheet" type="text/css" href="catalog/view/javascript/jquery/colorbox/colorbox.css" media="screen" />
        <script type="text/javascript" src="catalog/view/javascript/jquery/tabs.js"></script>
        <script type="text/javascript" src="catalog/view/javascript/common.js"></script>

        <script type='text/javascript'>$(function(){$.config = {url:'<?php echo HTTP_SERVER; ?>'};});</script>
        <script type="text/javascript" src="catalog/view/javascript/jquery.liveValidation.js"></script>

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
        
        <!--<link rel="STYLESHEET" type="text/css" href="catalog/view/theme/default/stylesheet/highslide.css">-->
            <!--<script type="text/javascript" src="catalog/view/javascript/highslide.js"></script>-->
            
            <link rel="STYLESHEET" type="text/css" href="catalog/view/theme/default/stylesheet/highslid.css">
            <script type="text/javascript" src="catalog/view/javascript/highslid.js"></script>
            
            <script type="text/javascript">
    hs.graphicsDir = 'catalog/view/javascript/highslide/graphics/';
            </script>
            <script type="text/javascript">
    // Language strings
    hs.lang = {
    cssDirection:     'ltr',
    loadingText :     'Ожидание...',
    loadingTitle :    'Нажмите, чтобы отменить',
    focusTitle :      'Нажмите, чтобы выдвинуть на',
    fullExpandTitle : 'Развернуть до исходного размера',
    fullExpandText :  'Полный экран',
    creditsText :     'Работает на Highslide JS',
    creditsTitle :    'Перейдите на главную страницу Highslide JS',
    previousText :    'Предыдущий',
    previousTitle :   'Предыдущие (стрелка влево)',
    nextText :        'Следующий',
    nextTitle :       'Дальше (стрелка вправо)',
    moveTitle :       'Двигаться',
    moveText :        'Двигаться',
    closeText :       'Закрывать',
    closeTitle :      'Закрыть (Esc)',
    resizeTitle :     'Размер восстановление',
    playText :        'Играть',
    playTitle :       'Воспроизвести слайд-шоу (пробел)',
    pauseText :       'Пауза',
    pauseTitle :      'Пауза слайд-шоу (пробел)',
    number :          'Изображение 1 2',
    restoreTitle :    'Нажмите, чтобы закрыть изображения, нажмите и удерживайте, чтобы перетащить. Используйте стрелки для движения вперед и назад.'
};

hs.addSlideshow({
// slideshowGroup: 'group1',
interval: 5000,
repeat: false,
useControls: true,
fixedControls: true,
overlayOptions: {
opacity: .6,
position: 'top center',
hideOnMouseOut: true
}
});
// Optional: a crossfade transition looks good with the slideshow
hs.transitions = ['expand', 'crossfade'];

            </script>
    </head>
    <body>
         <div class="page">
            <div class="for_rasporka">
            <div class="header">
                <div class="linetop" >
                    <?php //if ($logo) { ?>
                    <!-- <a href="<?php echo $home; ?>">
                        <img src="image/data/logotitle.jpg" />
                    </a> -->
                    <?php //} ?>

                    <div class="top_menu">
                        <?php foreach ($tops as $top) { ?>
                        <a href="<?php echo $top['href']; ?>"><?php echo $top['title']; ?></a>
                        <?php } ?>    
                    </div>
                </div>
                <?php //if ($logo) { ?>
                <!-- <div id="logo">
                    <a href="<?php echo $home; ?>">
                        <img src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" />
                    </a>
                </div> -->
                <?php //} ?>

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
                    <div class="image_top">
                        <img src="/image/data/mts.jpg" />
                        <img src="/image/data/kievstar.jpg" />
                        <img src="/image/data/life.jpg" />
                    </div>
                    <div class="number">
                        <?php foreach ($telephones as $telephone ) { ?>
                        <?php echo "<b>$telephone</b>"; ?>
                        <?php } ?>
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
            </div>
            <div id="notification"></div>
