<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content">
  <div class="top">
    <div class="left"></div>
    <div class="right"></div>
    <div class="center">
      <h1><?php echo $heading_title; ?></h1>
    </div>
  </div>
  <div  class="middle" style=" width:630px; float:left">
    <?php if ($success) { ?>
    <div class="success"><?php echo $success; ?></div>
    <?php } ?>

<h2><?php echo $text_my_account; ?></h2>

  <div class="content">
    <ul>

	<div style="float: left; width: 260px; margin-bottom: 10px; padding: 5px;"><img src="/catalog/view/theme/default/image/edit1.png" alt="Account Details" style="float: left; margin-right: 8px;"><a href="/index.php?route=account/edit" style="font-weight: bold;"><?php echo $text_edit; ?><br></div>
   
    
    <div style="float: right; width: 260px; margin-bottom: 10px; padding: 5px;"><img src="/catalog/view/theme/default/image/password.png" alt="Account Password" style="float: left; margin-right: 8px;"><a href="/index.php?route=account/password" style="font-weight: bold;"><?php echo $text_password; ?><br></div>


      <div style="float: left; width: 260px; margin-bottom: 10px; padding: 5px;"><img src="/catalog/view/theme/default/image/delivery.png" alt="Address book" style="float: left; margin-right: 8px;"><a href="/index.php?route=account/address" style="font-weight: bold;"><?php echo $text_address; ?></a><br></div>


    <div  style="float: right; width: 260px; margin-bottom: 10px; padding: 5px;"><img src="/catalog/view/theme/default/image/wishlist.png" alt="Wishlist" style="float: left; margin-right: 8px;"><a href="/index.php?route=account/wishlist" style="font-weight: bold;"><?php echo $text_wishlist; ?></a><br></div>


    </ul>
  </div>


  <h2><?php echo $text_my_orders; ?></h2>
  <div class="content">
    <ul>


    <div style="float: left; width: 260px; margin-bottom: 10px; padding: 5px;"><img src="/catalog/view/theme/default/image/orders.png" alt="Order History" style="float: left; margin-right: 8px;"><a href="/index.php?route=account/order" style="font-weight: bold;"><?php echo $text_order; ?></a><br></div>
        
      <div style="float: right; width: 260px; margin-bottom: 10px; padding: 5px;"><img src="/catalog/view/theme/default/image/download.png" alt="Your Downloads" style="float: left; margin-right: 8px;"><a href="/index.php?route=account/download" style="font-weight: bold;"><?php echo $text_download; ?></a><br></div>

    <!--<div style="float: left; width: 260px; margin-bottom: 10px; padding: 5px;"><img src="/catalog/view/theme/default/image/reward.png" alt="Reward Points" style="float: left; margin-right: 8px;"><a href="/index.php?route=account/reward" style="font-weight: bold;"><?php echo $text_reward; ?></a><br></div>-->


      <div style="float: right; width: 260px; margin-bottom: 10px; padding: 5px;"><img src="/catalog/view/theme/default/image/return.png" alt="Your Returns" style="float: left; margin-right: 8px;"><a href="/index.php?route=account/return" style="font-weight: bold;"><?php echo $text_return; ?></a><br></div>

    <div style="float: left; width: 260px; margin-bottom: 10px; padding: 5px;"><img src="/catalog/view/theme/default/image/trans.png" alt="transaction" style="float: left; margin-right: 8px;"><a href="/index.php? route=account/transaction" style="font-weight: bold;"><?php echo $text_transaction; ?></a><br></div>

    </ul>
  </div>

        
  <h2><?php echo $text_my_newsletter; ?></h2>
  <div class="content">
    <ul>
        
      <div style="float: left; width: 260px; margin-bottom: 10px; padding: 5px;"><img src="/catalog/view/theme/default/image/newsletter.png" alt="Your Newsletter" style="float: left; margin-right: 8px;"><a href="/index.php?route=account/newsletter" style="font-weight: bold;"><?php echo $text_newsletter; ?></a><br></div>

    </ul>
  </div>

  </div>
  <div class="bottom" style="width:580px; float:left;">
    <div class="left"></div>
    <div class="right"></div>
    <div class="center"></div>
  </div>
</div>
<?php echo $footer; ?> 