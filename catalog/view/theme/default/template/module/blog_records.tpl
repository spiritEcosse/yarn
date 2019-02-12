<?php
if ($this->browser() !=  'ieO') {
?>
<script type="text/javascript">
if ($('head').html().indexOf('blog.css')< 0) {
	$('head').append('<link href="catalog/view/theme/<?php echo $theme."/stylesheet/blog.css"; ?>" type="text/css" rel="stylesheet" />');
 }
</script>
<?php }
else
{
?>
<style>
<?php
 include (DIR_TEMPLATE.$theme.'/stylesheet/blog.css');
?>
</style>
<?php
}
?>
 <?php if ($records) { ?>
  <div class="box-title">

<ins class="box-ins"><?php echo $heading_title; ?></ins>
</div>
  <div class="blog-record-list-small">
    <?php foreach ($records as $record) { ?>
    <div>
     <?php if ($record['date_available']) { ?>
        <div class="blog-date"><?php echo $record['date_available']; ?></div>
      <?php } ?>
     <div class="name" style="margin-bottom: 5px;">
    <a href="<?php echo $record['blog_href']; ?>" class="blog-title"><?php echo $record['blog_name']; ?></a><ins class="blog-arrow">&nbsp;&rarr;&nbsp;</ins>
    <a href="<?php echo $record['href']; ?>" class="blog-title"><?php echo $record['name']; ?></a>
     </div>

      <?php if ($record['thumb']) { ?>
      <div class="image blog-image"><a href="<?php echo $record['href']; ?>"><img src="<?php echo $record['thumb']; ?>" title="<?php echo $record['name']; ?>" alt="<?php echo $record['name']; ?>" /></a></div>
      <?php } ?>

          	<div class="description"><?php echo $record['description']; ?>&nbsp;
          	<a href="<?php echo $record['href']; ?>" class="description blog-further"><?php echo $this->language->get('text_further'); ?></a></div>


      <div class="blog-date_container">


      <?php if ($record['rating']) { ?>
      <div class="rating blog-rate_container"><img src="catalog/view/theme/<?php echo $theme; ?>/image/blogstars-<?php echo $record['rating']; ?>.png" alt="Rating"></div>
      <?php } ?>

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

  <?php } ?>
