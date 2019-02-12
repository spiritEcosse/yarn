<div id="flexslideshow<?php echo $module; ?>" class="flexslider loading">
  <ul class="slides">
    <?php foreach ($banners as $banner) { ?>
      <?php if ($banner['link']) { ?>
        <li>
          <a href="<?php echo $banner['link']; ?>">
            <div class="bigPic" style="width: <?php echo $width; ?>px; height: <?php echo $height; ?>px; background:url(<?php echo $banner['image']; ?>) 50% 0 no-repeat;"></div>
            <img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" class="slide_img" />
          </a>
        </li>
      <?php } else { ?>
        <li>
          <div class="bigPic" style="width: <?php echo $width; ?>px; height: <?php echo $height; ?>px; background:url(<?php echo $banner['image']; ?>) 50% 0 no-repeat;"></div>
          <img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" class="slide_img" />
        </li>
      <?php } ?>
    <?php } ?>
  </ul>
</div>

<div class="progress_bar_container">
  <div class="progress_bar"></div>
</div>

<script type="text/javascript">
  $(window).load(function() {
    $('#flexslideshow<?php echo $module; ?>').flexslider({
      animation: "fade",
		  pauseOnHover: true,
		  pauseOnAction: false,
		  touch: true,
		  animationSpeed: 1300,
		  slideshowSpeed: 6500,
		  smoothHeight: false,
		  controlNav: false,
      directionNav: true,
		  start: function(slider) {
        slider.removeClass('loading');
      }
    });

	function run() {
    jQuery('.progress_bar').animate({'width': window.innerWidth+"px"}, 6500, run).width(0);
  }

  run();
  jQuery('.flexslider').hover(
    function() {
      jQuery('.progress_bar').stop();
    }
  );

  jQuery('.flexslider').mouseout(
    function() {
      jQuery('.progress_bar').animate({'width': window.innerWidth+"px"}, 6500, run).width(0);
    }
  );
});
</script>

<?php if (($setting['position'] == 'content_header')){ ?>
  <script type="text/javascript"><!--
    $(document).ready(function() {
      if (document.getElementById("banner_header")!= null) {
        $('#banner_header').addClass("lifted");
      	$('#module_area .inner').addClass("lifted_inner");
      	$('#module_area').addClass("colorless_borderless");
      	$('#header').addClass("borderless");
    	}
    });
  //--></script>
<?php } ?>