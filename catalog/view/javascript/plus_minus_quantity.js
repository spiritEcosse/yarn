function addToCartQty(product_id, e) {
	var input=$(e).parent().find('input[type=text]');
	var qty = input.val();
	
	if (!isNaN(qty)) {
		if(!qty){qty=1;}
		input.val(1);
		
		$.ajax({
			url: 'index.php?route=checkout/cart/add',
			type: 'post',
			data: 'product_id=' + product_id + '&quantity=' + qty,
			dataType: 'json',
			success: function(json) {
				$('.success, .warning, .attention, .information, .error').remove();
				
				if (json['redirect']) {
					location = json['redirect'];
				}
				
				if (json['success']) {
					// $('#cart_add_sound')[0].play();
					$('#notification').html('<div class="success" style="display: none;">' + json['success'] + '<img src="catalog/view/theme/default/image/close.png" alt="close" class="close" /></div>');
					
					$('.success').fadeIn('slow');
					
					$('#cart-total').html(json['total']);
					
					$('html, body').animate({ scrollTop: 0 }, 'slow'); 
				}	
			}
		});
	}
}

function addQty(e) {
	var input = $(e).parent().parent().find('input[type=text]');

	if (isNaN(input.val())) {
		input.val(0);
	}
	input.val(parseInt(input.val())+1);
}

function subtractQty(e) {
	var input=$(e).parent().parent().find('input[type=text]');
	if (isNaN(input.val())) {
		input.val(1);
	}
	if ($(input).val()>1) {
		$(input).val(parseInt($(input).val())-1);
	}
}