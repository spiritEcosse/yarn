<?php if ($records) { ?>
  <div class="box">
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
            <div class="image blog-image">
              <a href="<?php echo $record['href']; ?>">
                <img src="<?php echo $record['thumb']; ?>" title="<?php echo $record['name']; ?>" alt="<?php echo $record['name']; ?>" />
              </a>
            </div>
          <?php } ?>

        	<div class="description"><?php echo $record['description']; ?></div>
          
          <div>
            <a href="<?php echo $record['href']; ?>" class="description blog-further"><?php echo $this->language->get('text_further'); ?></a>
          </div>

          <div class="blog-date_container">
            <?php if ($record['rating']) { ?>
              <div class="rating blog-rate_container">
                <img src="catalog/view/theme/<?php echo $theme; ?>/image/blogstars-<?php echo $record['rating']; ?>.png" title="Rating" alt="Rating" />
              </div>
            <?php } ?>
            
            <div class="blog-comment_container">
      	      <div class="blog-comments"><?php echo $text_comments; ?> <?php echo $record['comments']; ?></div>
      	      <div class="blog-viewed"><?php echo $text_viewed; ?> <?php echo $record['viewed']; ?></div>
            </div>

            <div style="overflow: hidden; line-height: 1px; ">&nbsp;</div>
          </div>

          <?php require_once(DIR_SYSTEM . 'library/user.php'); ?>
        	<?php $this->registry->set('user', new User($this->registry)); ?>

        	<?php if ($this->user->isLogged()) { ?>
            <?php $userLogged = true; ?>
        	<?php } else { ?>
        	  <?php $userLogged = false; ?>
        	<?php } ?>

          <div class="blog-child_divider">&nbsp;</div>
        </div>
      <?php } ?>
    </div>
  </div>
<?php } ?>