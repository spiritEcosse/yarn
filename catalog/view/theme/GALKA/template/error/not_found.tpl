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
    <div class="content"><?php echo $text_error; ?></div>
    <div class="buttons">
      <div class="right"><a href="<?php echo $continue; ?>" class="button"><?php echo $button_continue; ?></a></div>
    </div>
    <?php echo $content_bottom; ?>
  </div>  
</div>
<?php echo $footer; ?>