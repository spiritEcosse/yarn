<div class="bxslider">
  <ul id="bxslider_<?php echo $module; ?>" class="jcarousel-skin-opencart">
    <?php foreach ($banners as $banner) { ?>
        <li>
            <a href="<?php echo $banner['link']; ?>">
                <img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" title="<?php echo $banner['title']; ?>" />
            </a>
        </li>
    <?php } ?>
  </ul>
</div>

<?php if (count($banners) > 0) { ?>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#bxslider_<?php echo $module; ?>').bxSlider({
                auto: true,
                mode: 'fade',
                autoControls: true
            });
        });
    </script>
<?php } ?>