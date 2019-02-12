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
    <h2 class="heading_title">
      <span><?php echo $heading_title; ?></span>
    </h2>
    <?php echo $content_top; ?>
    
    <div class="table-header">
      <?php include(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/products.tpl'); ?>
    </div>
    
    <?php if ($description) { ?>
      <?php foreach ($description as $value) { ?>
        <div><?php echo $value; ?></div>
      <?php } ?>
    <?php } ?>
    
    <?php echo $content_bottom; ?>
  </div>
</div>

<?php echo $footer; ?>