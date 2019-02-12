<?php echo $header; ?>

<div class="title-holder">
	<div class="inner">
		<div class="breadcrumb">
		    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
		    	<?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
		    <?php } ?>
	  	</div>
	</div>
</div>

<div class="inner">
	<?php echo $column_left; ?>
	<?php echo $column_right; ?>

	<div id="content">
		<h2 class="heading_title"><span><?php echo $heading_title; ?></span></h2>
		<?php echo $content_top; ?>

		<div class="checkout">
			<div id="checkout">
				<div class="checkout-heading">Заполните, пожалуйста форму.</div>
				<div class="checkout-content" style="display: block">
					<form id="checkout_form" onsubmit="return false;">
						<div class="left">
							<table class="form">
								<tr>
									<td><span class="required">*</span> <?php echo $entry_firstname; ?></td>
									<td><input type="text" name="firstname" value="<?php echo $firstname?>"
											   class="large-field"/></td>
								</tr>
								<tr>
									<td><span class="required">*</span> <?php echo $entry_lastname; ?></td>
									<td><input type="text" name="lastname" value="<?php echo $lastname?>"
											   class="large-field"/></td>
								</tr>
								<tr>
									<td><span class="required">*</span> <?php echo $entry_address_1; ?></td>
									<td><input type="text" name="address_1" value="<?php echo $address_1?>"
											   class="large-field"/></td>
								</tr>
								<tr>
									<td><span class="required">*</span> <?php echo $entry_email; ?></td>
									<td><input type="text" name="email" value="<?php echo $email?>" class="large-field"/>
									</td>
								</tr>
								<tr>
									<td><span class="required">*</span> <?php echo $entry_telephone; ?></td>
									<td><input type="text" name="telephone" value="<?php echo $telephone?>"
											   class="large-field"/></td>
								</tr>
								<tr>
									<td><?php echo $entry_comment; ?></td>
									<td><textarea rows="8" style="width: 300px"
												  name="comment"><?php echo $comment?></textarea></td>
								</tr>
                                <?php if ($zones) { ?>
                                    <tr>
                                        <td class="text_delivery">Доставка</td>
                                        <td class="text_delivery">Новая почта (по Украине)</td>
                                    </tr>

                                    <tr>
                                        <td>
                                        Регион:
                                        </td>
                                        <td>
                                            <select id="zone" name="zone_id">
                                                <option value='0'><?php echo $text_none; ?></option>
                                                <?php foreach ($zones as $zone) { ?>
                                                    <option
                                                    <?php if ($zone_id == $zone['zone_id']) { ?>
                                                        selected
                                                    <?php } ?>
                                                    value="<?php echo $zone['zone_id']; ?>">
                                                        <?php echo $zone['name']; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                             Город:
                                        </td>
                                        <td>
                                            <select id="city" name="city_id">
                                                <option value='0'><?php echo $text_none; ?></option>
                                                <?php if ($cities) { ?>
                                                    <?php foreach ($cities as $city) { ?>
                                                        <option
                                                        <?php if ($city_id == $city['city_id']) { ?>
                                                            selected
                                                        <?php } ?>
                                                        value="<?php echo $city['city_id']; ?>">
                                                        <?php echo $city['name']; ?>
                                                        </option>
                                                    <?php } ?>
                                                <?php } ?>
                                            </select>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            Отделения:
                                        </td>
                                        <td>
                                            <select id="depart" name="depart_id">
                                                <option value='0'><?php echo $text_none; ?></option>
                                                <?php if ($departs) { ?>
                                                    <?php foreach ($departs as $depart) { ?>
                                                        <option
                                                        <?php if ($depart_id == $depart['depart_id']) { ?>
                                                            selected
                                                        <?php } ?>
                                                        value="<?php echo $depart['depart_id']; ?>">
                                                        <?php echo $depart['name']; ?>
                                                        </option>
                                                    <?php } ?>
                                                <?php } ?>
                                            </select>
                                        </td>
                                    </tr>
                                <?php } ?>
							</table>
						</div>

						<div style="clear: both;">
							<div class="shipping-content" style="display: block">
								<?php if(count($shipping_methods)>1) { ?>
								<p><?php echo $text_shipping_method; ?></p>
								<table class="form">
									<?php foreach($shipping_methods as $shipping_method) { ?>
									<tr>
										<td colspan="3"><b><?php echo $shipping_method['title']; ?></b></td>
									</tr>
									<?php if(!$shipping_method['error']) { ?>
										<?php foreach($shipping_method['quote'] as $quote) { ?>
											<tr>
												<td style="width: 1px;"><?php if($quote['code'] == $code || !$code) { ?>
													<?php $code = $quote['code']; ?>
													<input type="radio" name="shipping_method"
														   value="<?php echo $quote['code']; ?>"
														   id="<?php echo $quote['code']; ?>" checked="checked"/>
													<?php } else { ?>
													<input type="radio" name="shipping_method"
														   value="<?php echo $quote['code']; ?>"
														   id="<?php echo $quote['code']; ?>"/>
													<?php } ?></td>
												<td><label
														for="<?php echo $quote['code']; ?>"><?php echo $quote['title']; ?></label>
												</td>
												<td style="text-align: right;"><label
														for="<?php echo $quote['code']; ?>"><?php echo $quote['text']; ?></label>
												</td>
											</tr>
											<?php } ?>
										<?php } else { ?>
										<tr>
											<td colspan="3">
												<div class="error"><?php echo $shipping_method['error']; ?></div>
											</td>
										</tr>
										<?php } ?>
									<?php } ?>
								</table>
								<?php } ?>
							</div>

                            <div id="payment-method">
                                <div class="checkout-content"></div>
                            </div>
						</div>
						<br/>
					</form>
				</div>
			</div>

            <div id="confirm">
                <div class="checkout-heading"><?php echo $text_checkout_confirm; ?></div>
                <div class="checkout-content"></div>
            </div>
		</div>
		<?php echo $content_bottom; ?>
	</div>
</div>

<script type="text/javascript">
    $.ajax({
        url: 'index.php?route=checkout/payment_method',
        dataType: 'html',
        success: function(html) {
            $('#payment-method .checkout-content').html(html);
            $('#payment-address .checkout-content').slideUp('slow');
            $('#payment-method .checkout-content').slideDown('slow');
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });

	$('input[name=shipping_method]').live('click', function() {
		$.ajax({
			url: 'index.php?route=checkout/checkout/change_shipping',
			type: 'post',
			data: 'shipping_method='+$("input[name=shipping_method]:checked").val(),
			dataType: 'json',
			success: function(json) {
				 $('#total_data').html(json['totals_data']);
			}
		})
	});

    $('#zone').live('change', function() {
        $.ajax({
            url: 'index.php?route=checkout/checkout/zone',
            type: 'get',
            dataType: 'json',
            data: 'zone_id=' + $(this).val(),
            success: function(json) {
                html = '<option value="0" ><?php echo $text_none; ?></option>';
                $('#depart').html(html);

                $(json['city']).each(function () {
                    html += '<option value="' + $(this).attr('city_id') + '" >' + $(this).attr('name') + '</option>';
                });

                $('#city').html(html);
            }, complete: function() {
                $.ajax({
                    url: "index.php?route=checkout/checkout/depart",
                    type: 'get',
                    data: 'depart_id=' + $('#depart').val(),
                    dataType: 'html',
                    success: function (html) {
                        $('#total_data').html(html);
                    }
                });
            }
        });
    });

    $('#city').live('change', function() {
        $.ajax({
            url: 'index.php?route=checkout/checkout/city',
            type: 'get',
            dataType: 'json',
            data: 'city_id=' + $(this).val(),
            success: function(json) {
                html = '<option value="0" ><?php echo $text_none; ?></option>';

                $(json['depart']).each(function () {
                    html += '<option value="' + $(this).attr('depart_id') + '" >' + $(this).attr('name') + '</option>';
                });

                $('#depart').html(html);
            }, complete: function() {
                $.ajax({
                    url: "index.php?route=checkout/checkout/depart",
                    type: 'get',
                    data: 'depart_id=' + $('#depart').val(),
                    dataType: 'html',
                    success: function (html) {
                        $('#total_data').html(html);
                    }
                });
            }
        });
    });

    $('#depart').live('change', function () {
        $.ajax({
            url: "index.php?route=checkout/checkout/depart",
            type: 'get',
            data: 'depart_id=' + $(this).val(),
            dataType: 'html',
            success: function (html) {
                $('#total_data').html(html);
            }
        });
    });

    $('#button-payment-method').live('click', function() {
        $.ajax({
            url: 'index.php?route=checkout/payment_method/validate',
            type: 'post',
            data: $('#payment-method input[type=\'radio\']:checked, #payment-method input[type=\'checkbox\']:checked, #payment-method textarea'),
            dataType: 'json',
            beforeSend: function() {
                $('#button-payment-method').attr('disabled', true);
                $('#button-payment-method').after('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
            },
            complete: function() {
                $('#button-payment-method').attr('disabled', false);
                $('.wait').remove();
            },
            success: function(json) {
                $('.warning, .error').remove();

                if (json['redirect']) {
                    location = json['redirect'];
                } else if (json['error']) {
                    if (json['error']['warning']) {
                        $('#payment-method .checkout-content').prepend('<div class="warning" style="display: none;">' + json['error']['warning'] + '<img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>');

                        $('.warning').fadeIn('slow');
                    }
                } else {
                    $.ajax({
                        url: 'index.php?route=checkout/checkout/validate',
                        type: 'post',
                        data: $('#checkout_form').serialize(),
                        dataType: 'json',
                        beforeSend: function() {
                            $('#button-confirm').attr('disabled', true);
                            $('#button-confirm').after('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
                        },
                        complete: function() {
                            $('#button-confirm').attr('disabled', false);
                            $('.wait').remove();
                        },
                        success: function(json) {
                            $('.warning').remove();
                            $('.error').remove();

                            if (json.errors) {
                                for (var key in json.errors) {
                                    $('#checkout .checkout-content input[name=\'' + key + '\']').
                                            after('<span class="error" >' + json.errors[key] + '</span>');

                                    $('#checkout .checkout-content select[name=\'' + key + '\']').
                                            after('<span class="error" >' + json.errors[key] + '</span>');
                                }
                            } else {
                                $.ajax({
                                    url: 'index.php?route=checkout/confirm',
                                    type: 'post',
                                    data: $('#checkout_form').serialize(),
                                    dataType: 'html',
                                    success: function(html) {
                                        $('#confirm .checkout-content').html(html);
                                        $('#checkout .checkout-heading').html('Форма заполнена.');
                                        $('#checkout .checkout-heading').append('<a><?php echo $text_modify; ?></a>');
                                        $('#checkout .checkout-content').slideUp('slow');
                                        $('#confirm .checkout-content').slideDown('slow', function() {
                                            $('#confirm .checkout-heading').html('Подтвердите заказ.');
                                            $('html, body').animate({ scrollTop: $('#confirm').offset().top }, 'slow');
                                        });
                                    },
                                    error: function(xhr, ajaxOptions, thrownError) {
                                        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                                    }
                                });
                            }
                        }
                    });
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    });

    $('#button-confirm').live('click', function() {
        $('#button-confirm').attr('disabled', true);
        $('#button-confirm').after('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
    });

    $('.checkout-heading a').live('click', function() {
        $('.checkout-content').slideUp('slow');

        $(this).parent().parent().find('.checkout-content').slideDown('slow');
    });

    //--></script>

<?php echo $footer; ?>
