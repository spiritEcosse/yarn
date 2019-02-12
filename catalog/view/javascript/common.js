$(document).ready(function() {
	documentReady();
});

function slide(obj) {
    $(obj).next('.filter-item').slideToggle();
    $(obj).toggleClass('inactive');
}

function slide_cat(obj) {
    $(obj).next('ul').slideToggle();
    $(obj).parent().toggleClass('inactive');
}

function height() {
    var columnLeft = $('#column-left').height();
    var columnRight = $('#column-right').height();
    var max = '400';

    if (max < columnLeft) {
        max = columnLeft;
    }

    if (max < columnRight) {
        max = columnRight;
    }

    $('#container > .inner > #content').css({'min-height' : max});
}

function documentReady() {
	/* Search */
	$('.button-search').bind('click', function() {
		search();
	});

	$('#header input[name=\'filter_name\']').bind('keydown', function(e) {
		if (e.keyCode == 13) {
			search();
		}
	});

	/* Aj//ax Cart */
	$('#cart > .heading').live('mouseover', function() {
		$('#cart .content').slideDown('slow');

        $('#cart').addClass('active');

		$('#cart').load('index.php?route=module/cart #cart > *');

        $('#cart').live('mouseleave', function() {
		    $('#cart .content').slideUp('slow');
			$(this).removeClass('active');
        });
    });

	/* Mega Menu */
	$('#menu ul > li > a + div').each(function(index, element) {
		// IE6 & IE7 Fixes
		if ($.browser.msie && ($.browser.version == 7 || $.browser.version == 6)) {
			var category = $(element).find('a');
			var columns = $(element).find('ul').length;

			$(element).css('width', (columns * 143) + 'px');
			$(element).find('ul').css('float', 'left');
		}

		var menu = $('#menu').offset();
		var dropdown = $(this).parent().offset();

		i = (dropdown.left + $(this).outerWidth()) - (menu.left + $('#menu').outerWidth());

		if (i > 0) {
			$(this).css('margin-left', '-' + (i + 5) + 'px');
		}
	});

	// IE6 & IE7 Fixes
	if ($.browser.msie) {
		if ($.browser.version <= 6) {
			$('#column-left + #column-right + #content, #column-left + #content').css('margin-left', '195px');

			$('#column-right + #content').css('margin-right', '195px');

			$('.box-category ul li a.active + ul').css('display', 'block');
		}

		if ($.browser.version <= 7) {
			$('#menu > ul > li').bind('mouseover', function() {
				$(this).addClass('active');
			});

			$('#menu > ul > li').bind('mouseout', function() {
				$(this).removeClass('active');
			});
		}
	}

	$('.success img, .warning img, .attention img, .information img').live('click', function() {
		$(this).parent().fadeOut('slow', function() {
			$(this).remove();
		});
	});

	$('.boxgrid.caption').hover(function(){
            $(".cover", this).stop().animate({top:'45%'},{queue:false,duration:0});
        }, function() {
            $(".cover", this).stop().animate({top:'300%'},{queue:false,duration:0});
    });
}

function search() {
	var url = $('base').attr('href') + 'index.php?route=product/search';
	var filter_name_val = $('#header input[name=\'filter_name\']').attr('value');

	if (filter_name_val == '') {
		return false;
	}

	url += '&filter_name=' + filter_name_val;
    location = url;
}

function getURLVar(urlVarName) {
	var urlHalves = String(document.location).toLowerCase().split('?');
	var urlVarValue = '';

	if (urlHalves[1]) {
		var urlVars = urlHalves[1].split('&');

		for (var i = 0; i <= (urlVars.length); i++) {
			if (urlVars[i]) {
				var urlVarPair = urlVars[i].split('=');

				if (urlVarPair[0] && urlVarPair[0] == urlVarName.toLowerCase()) {
					urlVarValue = urlVarPair[1];
				}
			}
		}
	}

	return urlVarValue;
}

function addToCart(product_id, quantity) {
	quantity = typeof(quantity) != 'undefined' ? quantity : 1;

	$.ajax({
		url: 'index.php?route=checkout/cart/add',
		type: 'post',
		data: 'product_id=' + product_id + '&quantity=' + quantity,
		dataType: 'json',
		success: function(json) {
			$('.success, .warning, .attention, .information, .error').remove();

			if (json['redirect']) {
				location = json['redirect'];
			}

			if (json['success']) {
				$('#notification').html('<div class="success" style="display: none;">' + json['success'] + '<img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>');

				$('.success').fadeIn('slow');

				$('#cart-total').html(json['total']);

				$('html, body').animate({ scrollTop: 0 }, 'slow');
			}
		}
	});
}

function addToWishList(product_id) {
	$.ajax({
		url: 'index.php?route=account/wishlist/add',
		type: 'post',
		data: 'product_id=' + product_id,
		dataType: 'json',
		success: function(json) {
			$('.success, .warning, .attention, .information').remove();

			if (json['success']) {
				$('#notification').html('<div class="success" style="display: none;">' + json['success'] + '<img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>');

				$('.success').fadeIn('slow');

				$('#wishlist-total').html(json['total']);
				$('#wishlist-total-footer').html(json['total']);

				$('html, body').animate({ scrollTop: 0 }, 'slow');
			}
		}
	});
}

function addToCompare(product_id) {
	$.ajax({
		url: 'index.php?route=product/compare/add',
		type: 'post',
		data: 'product_id=' + product_id,
		dataType: 'json',
		success: function(json) {
			$('.success, .warning, .attention, .information').remove();

			if (json['success']) {
				$('#notification').html('<div class="success" style="display: none;">' + json['success'] + '<img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>');

				$('.success').fadeIn('slow');

				$('#compare-total').html(json['total']);
				$('#compare-total-header').html(json['total']);
				$('#compare-total-footer').html(json['total']);

				$('html, body').animate({ scrollTop: 0 }, 'slow');
			}
		}
	});
}

function config(http, template, route, path, product_id) {
    $.config = {
        url: http,
        templ: template,
        route: route,
        path: path,
        product_id: product_id
    };
}