 <?php if ($records) { ?>
   <div class="box-title">

<ins class="box-ins"><?php echo $heading_title; ?></ins>
</div>
  <div class="blog-record-list">
    <?php foreach ($records as $record) { ?>
    <div>
     <div class="name" style="margin-bottom: 5px;">
    <a href="<?php echo $record['blog_href']; ?>" class="blog-title"><?php echo $record['blog_name']; ?></a><ins class="blog-arrow">&nbsp;&rarr;&nbsp;</ins>
    <a href="<?php echo $record['href']; ?>" class="blog-title"><?php echo $record['name']; ?></a>
     </div>

      <?php if ($record['thumb']) { ?>
      <div class="image" class="blog-image"><a href="<?php echo $record['href']; ?>"><img src="<?php echo $record['thumb']; ?>" title="<?php echo $record['name']; ?>" alt="<?php echo $record['name']; ?>" /></a></div>
      <?php } ?>

          	<div class="description" style="font-size: 15px; line-height: 23px;"><?php echo $record['description']; ?>&nbsp;
          	<a href="<?php echo $record['href']; ?>" class="description blog-further"><?php echo $this->language->get('text_further'); ?></a></div>


      <div class="blog-date_container">
      <?php if ($record['date_available']) { ?>
        <div class="blog-date"><?php echo $record['date_available']; ?></div>
      <?php } ?>

      <?php if ($record['rating']) { ?>
      <div class="rating blog-rate_container"><img src="catalog/view/theme/<?php echo $theme; ?>/image/blogstars-<?php echo $record['rating']; ?>.png" alt="Rating"></div>
      <?php } ?>

  <div class="share blog-share_container"><!-- AddThis Button BEGIN -->

  <div class="addthis_toolbox addthis_default_style "
        addthis:url="<?php echo $record['href']; ?>"
        addthis:title="<?php echo $record['name']; ?>"
        addthis:description="<?php echo $record['description']; ?>">




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

      <div class="blog-comment_container">
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
	<div class="blog-edit_container">
	   <a class="zametki" target="_blank" href="/admin/index.php?route=catalog/record/update&token=<?php echo $this->session->data['token']; ?>&record_id=<?php echo $record['record_id']; ?>"><?php echo $this->language->get('text_edit');?></a>
	 </div>
	<?php
	 }
	?>

  <div class="blog-child_divider">&nbsp;</div>

    </div>
    <?php } ?>
  </div>


    <div class="record-filter">
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
