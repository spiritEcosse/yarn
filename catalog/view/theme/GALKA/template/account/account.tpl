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
<?php if ($success) { ?>
<div class="success"><?php echo $success; ?></div>
<?php } ?>
<?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content">
<h2 class="heading_title"><span><?php echo $heading_title; ?></span></h2>
<?php echo $content_top; ?>
  
  <div class="content accountPage_content">
    <ul class="tiles">
      <li class="edit_info"><a href="<?php echo $edit; ?>"><?php echo $text_edit; ?></a></li>
      <li class="edit_password"><a href="<?php echo $password; ?>"><?php echo $text_password; ?></a></li>
      <li class="edit_address"><a href="<?php echo $address; ?>"><?php echo $text_address; ?></a></li>
      <li class="edit_wishlist"><a href="<?php echo $wishlist; ?>"><?php echo $text_wishlist; ?></a></li>
      <li class="edit_newsletter"><a href="<?php echo $newsletter; ?>"><?php echo $text_newsletter; ?></a></li>
    </ul>
  </div>
  <h2 class="heading_title"><span><?php echo $text_my_orders; ?></span></h2>
  <div class="content accountPage_content">
    <ul class="tiles">
      <li class="edit_orders"><a href="<?php echo $order; ?>"><?php echo $text_order; ?></a></li>
      <li class="edit_downloads"><a href="<?php echo $download; ?>"><?php echo $text_download; ?></a></li>
      <?php if ($reward) { ?>
        <li class="edit_reward"><a href="<?php echo $reward; ?>"><?php echo $text_reward; ?></a></li>
      <?php } ?>
    </ul>
  </div>
  <?php echo $content_bottom; ?></div>
  
  </div>
<?php echo $footer; ?>