$(document).ready(function(){
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////						   
								
	// -------------------------------------------------------------------------------------------------------
	// Dropdown Menu
	// -------------------------------------------------------------------------------------------------------

	dropdown();

	// -------------------------------------------------------------------------------------------------------
	// Header modulules positioning
	// -------------------------------------------------------------------------------------------------------
	headerModululesPositioning();
	
	// -------------------------------------------------------------------------------------------------------
	// FLYING COUNTDOWN
	// -------------------------------------------------------------------------------------------------------
	flyingCountDown();

	aLinksClick();

	// -------------------------------------------------------------------------------------------------------
	// FADING ELEMENTS
	// -------------------------------------------------------------------------------------------------------
	//hoverOverItem();
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////	
});

function dropdown() {
	if ( ! ( $.browser.msie && ($.browser.version == 6 || $.browser.version == 7) ) ){
		$("ul#topnav li:has(ul), ul.topnav2 li:has(ul)").addClass("dropdown");
	}
}

function aLinksClick() {
	$('a[href="#"]').click(function(event){ 
		event.preventDefault(); 
	});
}

function searchFilterName() {
	$('#search').find('[name=filter_name]').first().keyup(function(ev){
		dosearch_suggest(ev, this.value);
	}).focus(function(ev){
		dosearch_suggest(ev, this.value);
	}).keydown(function(ev){
		upDownEvent( ev );
	}).blur(function(){
		window.setTimeout("$('#search_suggest_search_results').remove();updown=0;", 1500);
	});

	$(document).bind('keydown', function(ev) {
		try {
			if( ev.keyCode == 13 && $('.highlighted').length > 0 ) {
				document.location.href = $('.highlighted').find('a').first().attr('href');
			}
		}
		catch(e) {}
	});
}

function headerModululesPositioning() {
	$('#module_area .banner').prependTo('#module_area .inner');
	$('#module_area .slideshow').prependTo('#module_area .inner');
	$('#notification').prependTo('#container');
}

function flyingCountDown() {
	$(function() {
	    $('div.prod_hold').each(function() {
			var tip = $(this).find('div.count_holder_small');

			$(this).hover(
				function() {
					tip.appendTo('body');
				},
				function() {
					tip.appendTo(this);
				}
			).mousemove(function(e) {
	          	var x = e.pageX + 60,
					y = e.pageY - 40,
					w = tip.width(),
					h = tip.height(),
					dx = $(window).width() - (x + w),
					dy = $(window).height() - (y + h);

				if ( dx < 50 ) x = e.pageX - w - 60;
				if ( dy < 50 ) y = e.pageY - h + 50;

				tip.css({ left: x, top: y });
	      	});
	    });
    });
}

function hoverOverItem() {
	//$(".banner > div, .LatestNews-unit, .prod_hold").hover(
  	//	function () {
	//   		$(this).siblings().stop().animate({
	//  			opacity: .4
	//		}, 500)
  	//	},
  	//	function () {
	//        $(this).siblings().stop().animate({
	//  		opacity: 1
	//		}, 500)
  	//	}
	//);
}

function dosearch_suggest( ev, keywords ) {
	if( ev.keyCode == 38 || ev.keyCode == 40 ) {
		return false;
	}

	$('#search_suggest_search_results').remove();
	updown = -1;

	if( keywords == '' || keywords.length == 0 ) {
		return false;
	}
	
	keywords = encodeURI(keywords);

	$.ajax({url: $('base').attr('href') + 'index.php?route=product/search/ajax&keyword=' + keywords, dataType: 'json', success: function(result) {
		if( result.length > 0 ) {
			var eList = document.createElement('ul');
			eList.id = 'search_suggest_search_results';
			var eListElem;
			var eLink;
			for( var i in result ) {
				eListElem = document.createElement('li');
				eLink = document.createElement('a');
				eLink.appendChild( document.createTextNode(result[i].name) );
				if( typeof(result[i].href) != 'undefined' ) {
					eLink.href = result[i].href;
				}
				else {
					eLink.href = $('base').attr('href') + 'index.php?route=product/product&product_id=' + result[i].product_id + '&keyword=' + keywords;
				}
				eListElem.appendChild(eLink);
				eList.appendChild(eListElem);
			}
			if( $('#search_suggest_search_results').length > 0 ) {
				$('#search_suggest_search_results').remove();
			}
			$('#search').append(eList);
		}
	}});

	return true;
}

function upDownEvent( ev ) {
	var elem = document.getElementById('search_suggest_search_results');
	var fkey = $('#search').find('[name=filter_name]').first();

	if( elem ) {
		var length = elem.childNodes.length - 1;

		if( updown != -1 && typeof(elem.childNodes[updown]) != 'undefined' ) {
			$(elem.childNodes[updown]).removeClass('highlighted');
		}

		// Up
		if( ev.keyCode == 38 ) {
			updown = ( updown > 0 ) ? --updown : updown;
		}
		else if( ev.keyCode == 40 ) {
			updown = ( updown < length ) ? ++updown : updown;
		}

		if( updown >= 0 && updown <= length ) {
			$(elem.childNodes[updown]).addClass('highlighted');

			var text = elem.childNodes[updown].childNodes[0].text;
			if( typeof(text) == 'undefined' ) {
				text = elem.childNodes[updown].childNodes[0].innerText;
			}

			$('#search').find('[name=filter_name]').first().val( new String(text).replace(/(\s\(.*?\))$/, '') );
		}
	}

	return false;
}

var updown = -1;

$(document).ready(function(){
	searchFilterName();
});

function activeLink(request, route) {
	for (var elem in request) {
		if (route == request[elem].route) {
			$(request[elem].ident).addClass('selected');
		} else if (route == null) {
			$('a.home_link').addClass('selected');
		}
    }
}

