<?php if ($show_special_price_countdown) { ?>

<link rel="stylesheet" type="text/css" href="catalog/view/theme/<?php echo $theme_name; ?>/stylesheet/countdown.css" />

<?php if ($type == 1){ ?>
<script type="text/javascript" src="catalog/view/javascript/jquery/jquery.lwtCountdown-1.0.js"></script>
<script type="text/javascript" src="catalog/view/javascript/jquery/misc.js"></script>

<div class="box">
  <div class="box-heading"><?php echo $heading_title; ?></div>
  <div class="box-content">
    <div class="box-product">   
		
		<div id="countdown_dashboard_<?php echo $module; ?>" class="countdown_dashboard" style="width:auto; display:block;">
			<div class="dash days_dash">
				<div class="digit"><?php echo  $date['days'][0]; ?></div>
				<div class="digit"><?php echo $date['days'][1]; ?></div>
			</div>

			<div class="dash hours_dash">
				<div class="digit"><?php echo $date['hours'][0]; ?></div>
				<div class="digit"><?php echo $date['hours'][1]; ?></div>
			</div>

			<div class="dash minutes_dash">
				<div class="digit"><?php echo $date['mins'][0]; ?></div>
				<div class="digit"><?php echo $date['mins'][1]; ?></div>
			</div>

			<div class="dash seconds_dash">
				<div class="digit"><?php echo $date['secs'][0]; ?></div>
				<div class="digit"><?php echo $date['secs'][1]; ?></div>
			</div>
		</div>
		
    </div>
  </div>
</div>
<!-- Countdown dashboard end -->

<script language="javascript" type="text/javascript">
	jQuery(document).ready(function() {
		$('#countdown_dashboard_<?php echo $module; ?>').countDown({
			targetDate: {
				'day': 		<?php echo $target_split[2]; ?>,
				'month': 	<?php echo $target_split[1]; ?>,
				'year': 	<?php echo $target_split[0]; ?>,
				'hour': 	0,
				'min': 		0,
				'sec': 		0
			}
		});
	});
</script>

<?php } else { ?>

<script type="text/javascript" src="catalog/view/javascript/jquery/jquery.countdown.js"></script>

<div class="box">
  <div class="box-heading"><?php echo $heading_title; ?></div>
  <div class="box-content">
    <div class="box-product">

	<div id="counter_<?php echo $module; ?>" style="width:auto; display:block;"></div>
	
	
    </div>
  </div>
</div>

<script type="text/javascript">
$(document).ready(function() {
  $('#counter_<?php echo $module; ?>').countdown({
	  image: 'catalog/view/theme/<?php echo $theme_name; ?>/image/digits.png',
	  startTime: '<?php echo ($days < 10)? "0" . $days : $days; ?>:<?php echo ($hours < 10)? "0" . $hours : $hours; ?>:<?php echo ($mins < 10)? "0" . $mins : $mins; ?>:<?php echo ($secs < 10)? "0" . $secs : $secs; ?>'
	});
});
  
</script>

<?php } ?>
<?php } ?>