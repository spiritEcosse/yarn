var fIID = 0;
var interval = 1;
var $cookie = false;
/**
 * fix for IE
 */
if (!Array.prototype.indexOf) {
    Array.prototype.indexOf = function(obj, start) {
         for (var i = (start || 0), j = this.length; i < j; i++) {
             if (this[i] === obj) { return i; }
         }
         return -1;
    }
}

String.prototype.hashCode = function(){
    var hash = 0, i, ch;
    if (this.length == 0) return hash;
    for (i = 0; i < this.length; i++) {
        ch = this.charCodeAt(i);
        hash = ((hash<<5)-hash)+ch;
        hash = hash & hash; // Convert to 32bit integer
    }
    return hash;
};

var tag_tmpl = $.template(null, '<tr><td><input id="tag_${tag}" class="filtered" type="checkbox" name="tags[]" value="${tag}" {{if checked}} checked="checked" {{/if}}></td>' +
    '<td><label for="tag_${tag}">${name}</label></td></tr>');
var cat_tmpl = $.template(null, '<tr><td><input id="cat_${category_id}" class="filtered" type="checkbox" name="categories[]" value="${category_id}" {{if checked}} checked="checked" {{/if}}></td>'+
				'<td><label for="cat_${category_id}">${name}</label></td></tr>');

$(".price_limit").live("change", (function () {
    var b = parseInt($("#min_price").val());
    var a = parseInt($("#max_price").val());
    $("#slider-range").slider("values", [b, a]);
    iF(true, false);
}));

function synchronizeImgCheckboxes() {
    $("#filterpro input.filtered[type=\"checkbox\"]").each(function() {
        var $img = $(this).next('img');
        if ($img.length) {
            if ($(this).is(":checked")) {
                $img.addClass("selected");
            } else {
                $img.removeClass("selected");
            }
        }
    });
}

$("#filterpro .filtered").live("change", (function () {
    synchronizeImgCheckboxes();
    iF(false, false);
}));

$(function () {
    $("#slider-range").slider({range:true, min:0, max:0, values:[0, 0], stop:function (a, b) {
        iF(true, false)
    }, slide:function (a, b) {
        $("#min_price").val(b.values[0]);
        $("#max_price").val(b.values[1])
    }});
    $("#min_price").val($("#slider-range").slider("values", 0));
    $("#max_price").val($("#slider-range").slider("values", 1))
});

function success(g, b, clear) {
    var location = window.location.href;

    if ($cookie){
        var view = $cookie("display");
    }

    if (!view) {
        view = "list";
    }

    if (g.result) {
        $(".product-" + view).html("");

        if ($("#productTemplate").length != 0) {
            $("#productTemplate").tmpl(g.result, location).appendTo(".product-" + view);
            
            $.each(g.result, function() {
                year = $(this)[0].year;
                month = $(this)[0].month;
                day = $(this)[0].day;

                if (year != false && month != false && day != false) {
                    $('#GALKACountSmallCategory' + $(this)[0].product_id).countdown({until: new Date(year, month, day), compact: false});
                }
            });
        }
    }

    $('#filters_product').remove();

    var positionRight = false;
    var positionLeft = false;

    if (g.filter.filter_module.length != 0) {
        for (var count in g.filter.position) {
            if (g.filter.position[count] == 'column-left') {
                positionLeft = true;
            }
            
            if (g.filter.position[count] == 'column-right') {
                positionRight = true;
            }

            var amount_box = $('#' + g.filter.position[count]+ ' > div.box').length;
            var selector = '#' + g.filter.position[count];

            if (g.filter.sort_order[count] != 0) {
                if (amount_box > g.filter.sort_order[count]) {
                   selector += ' > div.box:nth-child(' + g.filter.sort_order[count] + ')';
                }

                $(selector).append(g.filter.filter_module);
            } else {
                $(selector).prepend(g.filter.filter_module);
            }
        }
    }

    if (positionLeft == true) {
        $('#content').css({'margin-left': '235px'});
    }

    if (positionRight == true) {
        $('#content').css({'margin-right': '235px'});
    }

    var text_fail = '';

    if (g.product_total == 0) {
        text_fail = '<div class="zero_products">По данному запросу нет товаров.';
        text_fail += '      Пожалуйста, попробуйте снова: ';
        text_fail += '      <a class="clear_filter" onclick="clear_filter();">очистить все фильтры.</a>';
        text_fail += '</div>';
    }

    $(".pagination").html(text_fail + g.pagination);

    // if (b && g.min_price == g.max_price) {
    //     $('.price_slider').hide();
    // }
    
    var min_price = parseInt(g.min_price);
    var max_price = Math.ceil(parseFloat(g.max_price));

    if (typeof(display) != "undefined") {
        view ? display(view) : display("list");
    }

    if (b) {
        $("#slider-range").slider("option", {min:min_price, max:max_price});
        
        console.log('min_max');
        
        var user_min_price = null;
        var user_max_price = null;
        
        if ($("#max_price").val() >= 1 && clear == false) {
            user_min_price = parseInt($("#min_price").val());
            user_max_price = parseInt($("#max_price").val())
        }
        
        if (min_price < user_min_price && user_min_price != null) {
            $("#min_price").val(user_min_price);
            select_min_price = user_min_price;
        } else {
            $("#min_price").val(min_price);
            select_min_price = min_price;
        }

        if (max_price > user_max_price && user_max_price != null) {
            $("#max_price").val(user_max_price);
            select_max_price = user_max_price;
        } else {
            $("#max_price").val(max_price);
            select_max_price = max_price;
        }

        $("#slider-range").slider("option", {values:[select_min_price, select_max_price]});
    }

    height();
    documentReady();
    hoverOverItem();
    flyingCountDown();
    headerModululesPositioning();
    searchFilterName();
    aLinksClick();
    dropdown();

    // if (g.totals_data) {
        //     if (g.totals_data.tags.length) {
        //         $('#filter_tags').html('');
        //         $.tmpl(tag_tmpl, g.totals_data.tags).appendTo('#filter_tags');
        //         $('#filter_tags').parents('.option_box').show();
        //     } else {
        //         $('#filter_tags').parents('.option_box').hide();
        //     }

        //     $('#filter_categories').html('');
        //     if (g.totals_data.categories.length) {
        //         $.tmpl(cat_tmpl, g.totals_data.categories).appendTo('#filter_categories');
        //         $('#filter_categories').parents('.option_box').show();
        //     } else {
        //         $('#filter_categories').parents('.option_box').hide();
        //     }

        //     var atts = {};
        //     $.each(g.totals_data.attributes, function(k, v) {
        //         atts[(v.id + "_" + v.text).replace(/\s/g, '_')] = v.t;
        //     });

        //     $('.a_name').each(function (k, v) {
        //         var at_v_i = $(v).attr('at_v_i').replace(/\s/g, '_');
        //         if (atts[at_v_i]) {
        //             $('[at_v_t="' + at_v_i + '"]').text($('[at_v_t="' + at_v_i + '"]').attr('data-value') + " (" + atts[at_v_i] + ")");
        //             $(v).removeAttr("disabled");
        //         } else {
        //             $('[at_v_t="' + at_v_i + '"]').text($('[at_v_t="' + at_v_i + '"]').attr('data-value'));
        //             $(v).attr("disabled", "disabled");
        //             $(v).removeAttr('checked');
        //             $(v).removeAttr(':selected');
        //         }
        //     });

        //     var h = [];
        //     // $.each(g.totals_data.manufacturers, function (f, k) {
        //     //     if (k.id) {
        //     //         h[h.length] = k.id;
        //     //         var j = $("#manufacturer_" + k.id);
        //     //         j.removeAttr("disabled");
        //     //         if (j.get(0).tagName == "OPTION") {
        //     //             j.text($("#m_" + k.id).val() + " (" + k.t + ")")
        //     //         } else {
        //     //             $('label[for="manufacturer_' + k.id + '"]').text($("#m_" + k.id).val() + " (" + k.t + ")")
        //     //         }
        //     //     }
        //     // });
            
        //     $(".manufacturer_value").each(function (f, k) {
        //         var j = $(this);
        //         var l = j.attr("id").match(/manufacturer_(\d+)/);
        //         if ($.inArray(l[1], h) < 0) {
        //             j.attr("disabled", "disabled");
        //             if (this.tagName == "OPTION") {
        //                 j.text($("#m_" + l[1]).val());
        //                 j.attr("selected", false)
        //             } else {
        //                 $('label[for="manufacturer_' + l[1] + '"]').text($("#m_" + l[1]).val());
        //                 j.attr("checked", false)
        //             }
        //         }
        //     });

        //     var e = [];
        //     $.each(g.totals_data.options, function (j, k) {
        //         if (k.id) {
        //             e[e.length] = k.id;
        //             var f = $("#option_value_" + k.id);
        //             if (f.length) {
        //                 f.removeAttr("disabled");
        //                 if (f.get(0).tagName == "OPTION") {
        //                     f.text($("#o_" + k.id).val() + " (" + k.t + ")")
        //                 } else {
        //                     $('label[for="option_value_' + k.id + '"]').text($("#o_" + k.id).val() + " (" + k.t + ")")
        //                 }
        //             }
        //         }
        //     });

        //     // $(".option_value").each(function (j, k) {
        //     //     var f = $(this);
        //     //     var l = f.attr("id").match(/option_value_(\d+)/);
        //     //     if ($.inArray(l[1], e) < 0) {
        //     //         f.attr("disabled", "disabled");
        //     //         if (this.tagName == "OPTION") {
        //     //             f.text($("#o_" + l[1]).val());
        //     //             f.attr("selected", false)
        //     //         } else {
        //     //             $('label[for="option_value_' + l[1] + '"]').text($("#o_" + l[1]).val());
        //     //             f.attr("checked", false)
        //     //         }
        //     //     }
        //     // })
    // }
}

function iF(b, clear) {
    clearTimeout(fIID);
    $("#filterpro_page").val(0);
    fIID = setTimeout("doFilter(" + b + ", " + clear + ")", interval)
}

var cache = [];

function doFilter(b, clear) {
    var a = $("#filterpro").serialize().replace(/[^&]+=\.?(?:&|$)/g, "").replace(/&+$/, "");

    if (!b || clear == true) {
        window.location.hash = a
    }

    var h = a.hashCode();

    // if (cache[h]) {
        // success(cache[h], b, clear);
        // console.log('cache');
    // } else {
        if ($cookie){
            var view = $cookie("display");
        }

        if (!view) {
            view = "list";
        }

        $(".product-" + view).mask();
        $("#filterpro").mask();
        $("#filters_product").mask();

        $.ajax({
            url:"index.php?route=module/filterpro/getproducts", 
            type:"POST", 
            data:a + (b ? "&getPriceLimits=true" : "") + ("&route=" + $.config.route) + ("&path=" + $.config.path), dataType:"json", 
            success:function (g) {
                success(g, b, clear);
                cache[h] = g;
                $(".product-" + view).unmask();
                $("#filterpro").unmask();
            }
        });
    // }
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

function clear_filter() {
    $("#filterpro select").val("");

    $("#filterpro :input").each(function () {
        if ($(this).is(":checked")) {
            $(this).attr("checked", false)
        }
    });

    // var b = $("#slider-range").slider("option", "min");
    // var a = $("#slider-range").slider("option", "max");
    // $("#slider-range").slider("option", {values:[b, a]});
    // $("#min_price").val(b);
    // $("#max_price").val(a);

    // $("div[id^=slider-range-]").each(function(index, element) {
    //     var id = this.id.replace(/[^\d]/g, '');

    //     var b = $(element).slider("option", "min");
    //     var a = $(element).slider("option", "max");

    //     hs = $(element).slider();
    //     hs.slider("option", {values:[b, a]});
    //     hs.slider("option","slide").call(hs, null, { handle: $(".ui-slider-handle", hs), values:[b, a] });

    //     $("#attribute_value_"+id+"_min").val('');
    //     $("#attribute_value_"+id+"_max").val('');
    // });

    $('#filterpro_filter').val('');
    $('#content select[name=\'filter_category_id\']').val('');
    $('#content input[name=\'filter_sub_category\']').attr('checked', false).attr('disabled', true);
    $('#content input[name=\'filter_description\']').attr('checked', false);

    $('#filterpro_filter_category_id').val('');
    $('#filterpro_filter_sub_category').val('');
    $('#filterpro_filter_description').val('');

    var clear = true; 
    iF(true, clear);
}

$(document).ready(function () {
    if ($.totalStorage!=undefined){
        $cookie = $.totalStorage;
    } else if ($.cookie != undefined){
        $cookie = $.cookie;
    }

    $(".option_box .option_name").click(function () {
        $(this).siblings(".collapsible").toggle();
        $(this).toggleClass("hided")
    });

    $(".option_box .attribute_group_name").click(function () {
        $(this).siblings(".attribute_box").toggle();
        $(this).toggleClass("hided")
    });

    $(".clear_filter").click(function () {
        clear_filter();
    });
    
    $(".pagination .links a").live("click", (function () {
        var a = $(this).attr("href");
        var b = a.match(/page=(\d+)/);
        $("#filterpro_page").val(b[1]);
        doFilter(false, false);
        $('html, body').animate({ scrollTop: $('.product-filter').offset().top }, 'slow');
        return false;
    }));

    if ($(".sort select").length){
        $(".sort select").get(0).onchange = null;
        $(".sort select").change(function () {
            vars = $(this).val().split("&");
            $("#filterpro_sort").val(vars[0]);
            $("#filterpro_order").val(vars[1]);
            iF(false, false)
        });

        $(".sort select option").each(function () {
            var d = $(this).val();
            var a = gUV(d, "sort");
            $(this).val(a + "&" + gUV(d, "order"))
        });
    }

    $( ".filter_option_value" ).live( "click", function() {
        var option_value = this.id.replace(/&filter=/g, '');
        $("#filterpro_filter").val(option_value);
        iF(true, false)
    });

    var filter_name = $('#content input[name=\'filter_name\']');
    var filter_category_id = $('#content select[name=\'filter_category_id\']');
    var filter_sub_category = $('#content input[name=\'filter_sub_category\']');
    var filter_description = $('#content input[name=\'filter_description\']');

    $( "#button-search" ).live( "click", function() {
        if (filter_name.val() == "") {
            return false;
        } else {
            $('#filterpro_filter_name').val(filter_name.val());
        }

        $('#filterpro_filter_category_id').val('');
        $('#filterpro_filter_sub_category').val('');
        $('#filterpro_filter_description').val('');

        if (filter_category_id.val() != 0) {
            $('#filterpro_filter_category_id').val(filter_category_id.val());
        }

        if (filter_sub_category.is(":checked")) {
            $('#filterpro_filter_sub_category').val(filter_sub_category.val());
        }
        
        if (filter_description.is(":checked")) {
            $('#filterpro_filter_description').val(filter_description.val());
        }

        iF(true, false);
    });

    if ($(".limit select").length) {
        $(".limit select").get(0).onchange = null;
        $(".limit select").change(function () {
            $("#filterpro_limit").val($(this).val());
            iF(false, false)
        });

        $(".limit select option").each(function () {
            $(this).val(gUV($(this).val(), "limit"))
        });
    }

    var hash = window.location.hash.substr(1);

    if (hash && $('instock').is(':visible') && $('instock').is(':checked')) {
        $('instock').attr("checked", false);
    }

    $("#filterpro").deserialize(hash);

    synchronizeImgCheckboxes();

    $("div[id^=slider-range-]").each(function(index, element) {
    	var id = this.id.replace(/[^\d]/g, '');
    	var arr = window['attr_arr_'+id];

    	var b = parseInt($("#attribute_value_"+id+"_min").val());
    	var a = parseInt($("#attribute_value_"+id+"_max").val());
    	b = arr.indexOf(b);
    	a = arr.indexOf(a);
    	if (a >= 0 && b >= 0){
    	    hs = $(element).slider();
    	    hs.slider("option", {values:[b, a]});
    	    hs.slider("option","slide").call(hs, null, { handle: $(".ui-slider-handle", hs), values:[b, a] });
    	}
    });

    if ($(".sort select").length) {
        if ($("#filterpro_sort").val()) {
            $(".sort select").val($("#filterpro_sort").val() + "&" + $("#filterpro_order").val())
        } else {
            vars = $(".sort select").val().split("&");
            $("#filterpro_sort").val(vars[0]);
            $("#filterpro_order").val(vars[1])
        }
    }

    if ($("#filterpro_limit").length) {
        if ($("#filterpro_limit").val()) {
            $(".limit select").val($("#filterpro_limit").val())
        } else {
            $("#filterpro_limit").val($(".limit select").val())
        }
    }

    if ($('#content input[name=\'filter_name\']').length && $('#filterpro_filter_name').val() != '') {
        $('#content input[name=\'filter_name\']').val($('#filterpro_filter_name').val());
    } else {
        $('#filterpro_filter_name').val($('#content input[name=\'filter_name\']').val());
    }

    if ($('#content select[name=\'filter_category_id\']').length && $('#filterpro_filter_category_id').val() != '') {
        $('#content select[name=\'filter_category_id\']').val($('#filterpro_filter_category_id').val());
        $('input[name=\'filter_sub_category\']').attr('disabled', false);
    }

    if ($('#content input[name=\'filter_sub_category\']').length && $('#filterpro_filter_sub_category').val() != '') {
        $('#content input[name=\'filter_sub_category\']').attr('checked', true);
        $('input[name=\'filter_sub_category\']').attr('disabled', false);
    }

    if ($('#content input[name=\'filter_description\']').length && $('#filterpro_filter_description').val() != '') {
        $('#content input[name=\'filter_description\']').attr('checked', true);
    }

    if ($.config.route == 'product/category' || $.config.route == 'product/special' || $.config.route == 'product/product' || $.config.route == 'product/manufacturer/product' || $.config.route == 'product/search') {
        doFilter(true, false);
    }
});

function gUV(e,f){
    var c=String(e).split("?");var a="";if(c[1]){var b=c[1].split("&");for(var g=0;g<=(b.length);g++){if(b[g]){var d=b[g].split("=");if(d[0]&&d[0]==f){a=d[1]}}}}return a
}