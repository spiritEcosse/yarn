<!-- // for the lazy. no offense, i wanted to help them :) -->
<?php if ($captcha_status) { ?>
<div style="color: #555; font-size: 13px; line-height: 19px;"><?php echo $entry_captcha_title; ?>&nbsp;&darr;</div>
<div style="color: #999; font-size: 13px;"><?php echo $entry_captcha; ?></div>

<div style="height:30px;">
<img src="<?php echo $captcha_filename; ?>" alt="captcha" style="height: 30px; vertical-align: top; border: 1px solid green;">
<input type="text" name="captcha" value="" id="captcha" class="captcha" style="font-size: 21px; width: 87px; height: 24px; vertical-align: top; border: 1px solid green;" maxlength="5" size="5">
</div>

<div style="width: 100%">
	<div style="width: 100px;float: left; vertical-align: center; text-align: center; ">
	 <a href="#icaptcha" onclick="captcha(); return false;"><?php echo $entry_captcha_update; ?></a>
	</div>

	<div style="margin-top:2px; margin-left: 100px; ">
	<?php

 	for ($i=0; $i<strlen($captcha_keys); $i++) { ?><input type="button" class="bkey" style="width: 24px;" value='<?php echo $captcha_keys[$i];?>'><?php }  ?>	</div>
</div>


<script type="text/javascript">
		$('.bkey').bind('click', subcaptcha);

     	// wait for the image captcha, for, because may not see captcha image
     	var pic = new Image();
		pic.src = '<?php if (isset($captcha_filename)) echo $captcha_filename; ?>' ;
		$(pic).load(function()
		{
            $.ajax({
			type: 'POST',
			url: 'index.php?route=record/record/captchadel',
			dataType: 'html',
		   	success: function(data)
		    {
		    }
	  });
	});
</script>
<?php } ?>