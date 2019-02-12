<?php if ($thumb) { ?>
    <div class="image">
        <a itemprop="image" href="<?php echo $popup; ?>" title="<?php echo $heading_title; ?>" onclick="return hs.expand(this)">
            <img itemprop="thumbnailUrl" src="<?php echo $thumb; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" id="image" />
        </a>
    </div>
    <div class="clear"></div>
<?php } ?>

<script type="text/javascript">
    function replace_img(thumb, popup) {
        $('#image').attr('src', thumb);
        $('#image').parent().attr('href', popup);
    }
</script>

<?php if ($images) { ?>
    <div id='bxslider_images' class="image-additional">
        <?php foreach ($images as $image) { ?>
            <a href="<?php echo $image['popup']; ?>" title="<?php echo $heading_title; ?>" onclick="return hs.expand(this)">
                <img onmouseover="replace_img('<?php echo $image['thumb_replace']; ?>', '<?php echo $image['popup']; ?>');" src="<?php echo $image['thumb']; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" />
            </a>
        <?php } ?>
    </div>

    <?php if (count($images) > 3) { ?>
        <script type="text/javascript">
                $('#bxslider_images').bxSlider({
                    minSlides: 4,
                    maxSlides: 5,
                    slideWidth: 40,
                    slideMargin: 5,
                    adaptiveHeight: true
                });
        </script>
    <?php } ?>
<?php } ?>