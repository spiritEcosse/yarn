<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<div class="box">
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
          <h1><img src="view/image/payment.png" alt="" /> <?php echo $heading_title; ?></h1>
    <div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location='<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
  </div>
  <div class="content">
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <table class="form">
      	<tr>
        <td width="25%"><span class="required">*</span> <?php echo $entry_merchant_id; ?></td>
        <td><input type="text" name="pay2pay_merchant_id" value="<?php echo $pay2pay_merchant_id; ?>" />
          <br />
          <?php if ($error_merchant_id) { ?>
          <span class="error"><?php echo $error_merchant_id; ?></span>
          <?php } ?></td>
      	</tr>
      	<tr>
        <td><span class="required">*</span> <?php echo $entry_secret_key; ?></td>
        <td><input type="text" name="pay2pay_secret_key" value="<?php echo $pay2pay_secret_key; ?>" />
          <br />
          <?php if ($error_secret_key) { ?>
          <span class="error"><?php echo $error_secret_key; ?></span>
          <?php } ?></td>
      	</tr>
      	<tr>
        <td><span class="required">*</span> <?php echo $entry_hidden_key; ?></td>
        <td><input type="text" name="pay2pay_hidden_key" value="<?php echo $pay2pay_hidden_key; ?>" />
          <br />
          <?php if ($error_hidden_key) { ?>
          <span class="error"><?php echo $error_hidden_key; ?></span>
          <?php } ?></td>
      	</tr>
      	<tr>
       		<td>Result URL:</td>
        	<td><?php echo $copy_result_url; ?></td>
      	</tr>
      	<tr>
        	<td>Success URL:</td>
        	<td><?php echo $copy_success_url; ?></td>
      	</tr>
      	<tr>
        	<td>Fail URL:</td>
        	<td><?php echo $copy_fail_url; ?></td>
      	</tr>
		<tr>
        <td><?php echo $entry_paymode; ?></td>
        <td><input type="text" name="pay2pay_paymode" value="<?php echo $pay2pay_paymode; ?>" />
          <br />
		</td>
      	</tr>
      	<tr>
          <td><?php echo $entry_test; ?></td>
          <td><?php if ($pay2pay_test) { ?>
            <input type="radio" name="pay2pay_test" value="1" checked="checked" />
            <?php echo $text_yes; ?>
            <input type="radio" name="pay2pay_test" value="0" />
            <?php echo $text_no; ?>
            <?php } else { ?>
            <input type="radio" name="pay2pay_test" value="1" />
            <?php echo $text_yes; ?>
            <input type="radio" name="pay2pay_test" value="0" checked="checked" />
            <?php echo $text_no; ?>
            <?php } ?></td>
        </tr>

      	<tr>
        <td><?php echo $entry_order_status; ?></td>
        <td><select name="pay2pay_order_status_id">
            <?php foreach ($order_statuses as $order_status) { ?>
            <?php if ($order_status['order_status_id'] == $pay2pay_order_status_id) { ?>
            <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
            <?php } ?>
            <?php } ?>
          </select></td>
      	</tr>
      	<tr>
        <td><?php echo $entry_geo_zone; ?></td>
        <td><select name="pay2pay_geo_zone_id">
            <option value="0"><?php echo $text_all_zones; ?></option>
            <?php foreach ($geo_zones as $geo_zone) { ?>
            <?php if ($geo_zone['geo_zone_id'] == $pay2pay_geo_zone_id) { ?>
            <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
            <?php } ?>
            <?php } ?>
          </select></td>
      	</tr>
      	<tr>
        <td><?php echo $entry_status; ?></td>
        <td><select name="pay2pay_status">
            <?php if ($pay2pay_status) { ?>
            <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
            <option value="0"><?php echo $text_disabled; ?></option>
            <?php } else { ?>
            <option value="1"><?php echo $text_enabled; ?></option>
            <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
            <?php } ?>
          </select></td>
      	</tr>
      	 <tr>
          <td><?php echo $entry_sort_order; ?></td>
          <td><input type="text" name="pay2pay_sort_order" value="<?php echo $pay2pay_sort_order; ?>" size="1" /></td>
      </table>
    </form>
  </div>
</div>
<?php echo $footer; ?>