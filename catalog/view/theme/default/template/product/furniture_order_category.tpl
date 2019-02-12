<?php echo $furniture_order_header; ?>

<div class="content" >
    <?php echo $furniture_order_column_left; ?>

    <div class="main">
        <div class="breadcrumb">
            <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
            <?php } ?>
        </div>
        <h1 class="title"><?php echo $heading_title; ?></h1>

        <div class="desc">
            <?php if ($thumb) { ?>
                <div class="image">
                    <img src="<?php echo $thumb; ?>" alt="<?php echo $heading_title; ?>"/>
                </div>
            <?php } ?>

            <?php if ($description) { ?>
                <div class="text">
                    <?php echo $description; ?>
                </div>
            <?php } ?>
            
            <?php if ($images) { ?>
                <div class="image-additional">
                    <h2>Галерея</h2>
                    <div class="wrapp_image">
                        <?php foreach ($images as $image) { ?>
                        <a onclick="return hs.expand(this)" href="<?php echo $image['popup']; ?>" title="<?php echo $heading_title; ?>" >
                            <img src="<?php echo $image['thumb']; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" />
                        </a>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<?php echo $furniture_order_footer; ?>

<script type="text/javascript"><!--
    $('.colorbox').colorbox({
    overlayClose: true,
    opacity: 0.5
});
//--></script> 