<?php echo $header; ?>
<?php echo $column_left; ?>
<?php echo $column_right; ?>

<div id="content"><?php echo $content_top; ?>
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <div class="blog-heading_title">
  <h1><?php echo $heading_title; ?></h1>
  </div>

  <?php if ($description)
  {
  ?>
  <div class="blog-info">
    <?php if ($thumb && $description) { ?>
    <div class="image blog-image imagebox"><img src="<?php echo $thumb; ?>" alt="<?php echo $heading_title; ?>" /></div>
    <?php } ?>
    <?php if ($description) { ?>
    <div class="blog-description">
    <?php echo $description; ?>
    </div>
    <?php } ?>
  </div>

  <?php } ?>


 <div class="blog-divider"></div>

  <?php if ($categories) { ?>
  <div class="blog-child_divider">&nbsp;</div>
  <h2 class="blog-refine_title"><?php echo $text_refine; ?>:</h2>
  <div class="blog-list" >
    <?php if (count($categories) <= 2) { ?>
    <ul>
      <?php foreach ($categories as $blog) { ?>
      <li><a href="<?php echo $blog['href']; ?>"><?php echo $blog['name']; ?></a></li>
      <?php } ?>
    </ul>
    <?php } else { ?>
    <?php for ($i = 0; $i < count($categories);) { ?>
    <ul>
      <?php $j = $i + ceil(count($categories) / 3); ?>
      <?php for (; $i < $j; $i++) { ?>
      <?php if (isset($categories[$i])) { ?>
      <li><a href="<?php echo $categories[$i]['href']; ?>"><?php echo $categories[$i]['name']; ?></a></li>
      <?php } ?>
      <?php } ?>
    </ul>
    <?php } ?>
    <?php } ?>
  </div>
	<div class="blog-child_divider" style="margin-top: 5px;">&nbsp;</div>
  <?php } ?>


  <?php if ($records) { ?>

  <div class="blog-record-list-small">
    <?php foreach ($records as $record) { ?>

    <div style="width: 250px; height: 300px; float: left;">
     <div class="name" style="margin-bottom: 5px;">
    	<a href="<?php echo $record['blog_href']; ?>" class="blog-title"><?php echo $record['blog_name']; ?></a><ins class="blog-arrow">&nbsp;&rarr;&nbsp;</ins>
    	<a href="<?php echo $record['href']; ?>" class="blog-title"><?php echo $record['name']; ?></a>
     </div>

      <?php if ($record['thumb']) { ?>
      <div class="">
	      <a href="<?php echo $record['popup']; ?>" title="<?php echo $record['name']; ?>" class="imagebox" rel="imagebox">
	      <img src="<?php echo $record['thumb']; ?>"  title="<?php echo $record['name']; ?>" alt="<?php echo $record['name']; ?>" >
	      </a>
      </div>
      <?php } ?>

		<?php if ($record['description']!='') { ?>
          	<div class="description" style="font-size: 15px; line-height: 23px;"><?php echo $record['description']; ?>&nbsp;
          	<a href="<?php echo $record['href']; ?>" class="description blog-further"><?php echo $this->language->get('text_further'); ?></a>
          	</div>
		<?php } ?>

      <div class="" style="float:none;">
      <?php if ($record['date_available']) { ?>
        <div class="blog-date"><?php echo $record['date_available']; ?></div>
      <?php } ?>

      <?php if ($record['rating']) { ?>
      <div class=""><img src="catalog/view/theme/<?php echo $theme; ?>/image/blogstars-<?php echo $record['rating']; ?>.png" alt="Rating"></div>
      <?php } ?>

  <div class="" style="float: left; width: 100%; height: 100%; overflow: hidden;"><!-- AddThis Button BEGIN -->

  <div class="addthis_toolbox addthis_default_style "
        addthis:url="<?php echo $record['href']; ?>"
        addthis:title="<?php echo $record['name']; ?>"
        addthis:description="<?php echo strip_tags($record['description']); ?>">




          <a class="addthis_button_facebook"></a>
          <a class="addthis_button_vk"></a>
          <a class="addthis_button_odnoklassniki_ru"></a>
          <a class="addthis_button_twitter"></a>
          <a class="addthis_button_email"></a>
          <a class="addthis_button_compact"></a>
          </div>

          <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js"></script>
          <!-- AddThis Button END -->

        </div>

      <div style="">
	      <div class="blog-comments"><?php echo $text_comments; ?> <?php echo $record['comments']; ?></div>
	      <div class="blog-viewed"><?php echo $text_viewed; ?> <?php echo $record['viewed']; ?></div>
      </div>




      <div style="overflow: hidden; line-height: 1px; ">&nbsp;</div>



      </div>
 	<?php
    require_once(DIR_SYSTEM . 'library/user.php');
    // User
	$this->registry->set('user', new User($this->registry));

	  if ($this->user->isLogged())
    	{
          $userLogged = true;
    	}
    	else
    	{
    	  $userLogged = false;
    	}


	 if ($userLogged)
	  {
	?>
	<div class="">
	   <a class="zametki" target="_blank" href="/admin/index.php?route=catalog/record/update&token=<?php echo $this->session->data['token']; ?>&record_id=<?php echo $record['record_id']; ?>"><?php echo $this->language->get('text_edit');?></a>
	 </div>
	<?php
	 }
	?>

  <div class="blog-child_divider">&nbsp;</div>

    </div>


    <?php } ?>
  </div>


    <div class="record-filter" style="width: 100%; overflow: hidden;">
  <div class="limit" style="float:left;"><b><?php echo $text_limit; ?></b>
      <select onchange="location = this.value;">
        <?php foreach ($limits as $limits) { ?>
        <?php if ($limits['value'] == $limit) { ?>
        <option value="<?php echo $limits['href']; ?>" selected="selected"><?php echo $limits['text']; ?></option>
        <?php } else { ?>
        <option value="<?php echo $limits['href']; ?>"><?php echo $limits['text']; ?></option>
        <?php } ?>
        <?php } ?>
      </select>
    </div>
    <div class="sort" style="float:left; margin-left: 10px;"><b><?php echo $text_sort; ?></b>
      <select onchange="location = this.value;">
        <?php foreach ($sorts as $sorts) { ?>
        <?php if ($sorts['value'] == $sort . '-' . $order) { ?>
        <option value="<?php echo $sorts['href']; ?>" selected="selected"><?php echo $sorts['text']; ?></option>
        <?php } else { ?>
        <option value="<?php echo $sorts['href']; ?>"><?php echo $sorts['text']; ?></option>
        <?php } ?>
        <?php } ?>
      </select>
    </div>
  </div>

  <div class="pagination" style="margin-top:5px;" ><?php echo $pagination; ?></div>



  <?php } ?>
  <?php if (!$categories && !$records) { ?>
  <div class="content"><?php echo $text_empty; ?></div>
  <div class="buttons">
    <div class="right"><a href="<?php echo $continue; ?>" class="button"><span><?php echo $button_continue; ?></span></a></div>
  </div>
  <?php } ?>
  <?php echo $content_bottom; ?></div>

<?php if ($imagebox=='colorbox') { ?>
<script type="text/javascript">
$('.imagebox').colorbox({
	overlayClose: true,
	opacity: 0.5
});
</script>
<?php } ?>

<?php if ($imagebox=='fancybox') { ?>
<script type="text/javascript">
$('.imagebox').fancybox({
	cyclic: false,
	autoDimensions: true,
	autoScale: false,
	'onComplete' : function(){
        $.fancybox.resize();
  }
});
</script>
<?php } ?>




<?php echo $footer; ?>