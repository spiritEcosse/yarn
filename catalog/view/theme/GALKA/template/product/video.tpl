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
    <?php echo $column_left; ?>
    <?php echo $column_right; ?>

    <div id="content">
        <h2 class="heading_title" id="heading_title_main"><span><?php echo $heading_title; ?></span></h2>
        <?php echo $content_top; ?>

        <?php if ($videos) { ?>
            <div class="product-list">
                <?php foreach ($videos as $video) { ?>
                    <div class="video">
                        <div class="name"><?php echo $video['name']; ?></div>
                        <div class="video_link">
                            <?php echo $video['video_link']; ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php } else { ?>
            <div class="content">
                <div class="products_fail"><?php echo $text_empty; ?></div>
                <a class="button" href="<?php echo $continue; ?>"><?php echo $button_continue; ?></a>
            </div>
        <?php } ?>

        <?php echo $content_bottom; ?>
    </div>
</div>

<?php echo $footer; ?>