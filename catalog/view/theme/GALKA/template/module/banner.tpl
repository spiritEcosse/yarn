<?php if (count($banners) == 1) { ?>
  <?php $banNum = "full_width"; ?>
<?php } ?>

<?php if (count($banners) == 2) { ?>
  <?php $banNum = "one_half"; ?>
<?php } ?>

<?php if (count($banners) == 3) { ?>
  <?php $banNum = "one_third"; ?>
<?php } ?>

<?php if (count($banners) == 4) { ?>
  <?php $banNum = "one_fourth"; ?>
<?php } ?>

<?php if (count($banners) == 5) { ?>
  <?php $banNum = "one_fifth"; ?>
<?php } ?>

<?php if ($setting['position'] == 'content_header') { ?>
  <div class="box-heading"><?php echo $name_banner; ?></div>

  <div id="banner_header" class="banner">

    <?php foreach ($banners as $banner) { ?>
      <div class="<?php echo $banNum; ?>">

      <?php if ($banner['link']) { ?>
          <a href="<?php echo $banner['link']; ?>">
            <img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" title="<?php echo $banner['title']; ?>" />
          </a>
      <?php } else { ?>
          <img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" title="<?php echo $banner['title']; ?>" />
      <?php } ?>

      </div>
    <?php } ?>

    <div class="clear"></div>
  </div>
<?php } elseif ($setting['position'] == 'content_top' || $setting['position'] == 'content_bottom') { ?>
  <div class="box-heading"><?php echo $name_banner; ?></div>

  <div id="banner<?php echo $module; ?>" class="banner">

    <?php foreach ($banners as $banner) { ?>
      <div class="<?php echo $banNum; ?>">
      
      <?php if ($banner['link']) { ?>
          <a href="<?php echo $banner['link']; ?>">
            <img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" title="<?php echo $banner['title']; ?>" />
          </a>
      <?php } else { ?>
          <img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" title="<?php echo $banner['title']; ?>" />
      <?php } ?>

      </div>
    <?php } ?>

  </div>
<?php } else { ?>
  <div class="box">
    <div class="box-heading"><?php echo $name_banner; ?></div>
    <div id="banner<?php echo $module; ?>" class="banner">

      <?php foreach ($banners as $banner) { ?>
        <div>

        <?php if ($banner['link']) { ?>
            <a href="<?php echo $banner['link']; ?>">
              <img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" title="<?php echo $banner['title']; ?>" />
            </a>
        <?php } else { ?>
            <img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" title="<?php echo $banner['title']; ?>" />
        <?php } ?>
        
        </div>
      <?php } ?>
    </div>
    <script type="text/javascript"><!--
      $(document).ready(function() {
      	$('#banner<?php echo $module; ?> div:first-child').css('display', 'block');
      });

      var banner =
      	$('#banner<?php echo $module; ?>').cycle({
      		before: function(current, next) {
      			$(next).parent().height($(next).outerHeight());
      		}
      	});

      setTimeout(banner, 2000);
      //-->
    </script>
  </div>
<?php } ?>