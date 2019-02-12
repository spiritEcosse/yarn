
<h4><?php echo $heading_title; ?></h4>
<div class="subscribe_module">
<p><?php echo $entry_subscribe_text; ?></p>
<input style="color:#777777;width:95%" type="text" value="<?php echo $text_email; ?>" onclick="if(this.value == '<?php echo $text_email; ?>') {this.value = ''; }" onkeydown="this.style.color = '#000000';" name="email" id="subscribero_email" />
<br />
<br />
<a class="button" id="button-subscribero"><span><?php echo $entry_email; ?></span></a>
<small><?php echo $entry_policy_text; ?></small>
</div> 
<script type="text/javascript"><!--
$('#button-subscribero').live('click', function() {
	$.ajax({
		url: 'index.php?route=module/subscribero/validate',
		type: 'post',
		data: $('#subscribero_email'),
		dataType: 'json',
		beforeSend: function() {
			$('#button-subscribero').attr('disabled', true);
			$('#button-subscribero').after('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
		},	
		complete: function() {
			$('#button-subscribero').attr('disabled', false);
			$('.wait').remove();
		},				
		success: function(json) {
			if (json['error']) {
				alert(json['error']['warning']);
			} else {
				alert(json['success']);
			}
		}
	});	
});	
$('#subscribero_email').bind('keydown', function(e) {
	if (e.keyCode == 13) {
		$('#button-subscribero').trigger('click');
	}
});
//--></script> 
