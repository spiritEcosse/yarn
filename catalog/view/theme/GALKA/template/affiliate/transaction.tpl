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
<?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content">
<h2 class="heading_title"><span><?php echo $heading_title; ?></span></h2>
<?php echo $content_top; ?>
  
  <p><?php echo $text_balance; ?><b> <?php echo $balance; ?></b>.</p>
  <table class="list">
    <thead>
      <tr>
        <td class="left"><?php echo $column_date_added; ?></td>
        <td class="left"><?php echo $column_description; ?></td>
        <td class="right"><?php echo $column_amount; ?></td>
      </tr>
    </thead>
    <tbody>
      <?php if ($transactions) { ?>
      <?php foreach ($transactions  as $transaction) { ?>
      <tr>
        <td class="left"><?php echo $transaction['date_added']; ?></td>
        <td class="left"><?php echo $transaction['description']; ?></td>
        <td class="right"><?php echo $transaction['amount']; ?></td>
      </tr>
      <?php } ?>
      <?php } else { ?>
      <tr>
        <td class="center" colspan="5"><?php echo $text_empty; ?></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
  <div class="pagination"><?php echo $pagination; ?></div>
  <div class="buttons">
    <div class="right"><a href="<?php echo $continue; ?>" class="button"><?php echo $button_continue; ?></a></div>
  </div>
  <?php echo $content_bottom; ?></div>
  
  </div>
<?php echo $footer; ?>