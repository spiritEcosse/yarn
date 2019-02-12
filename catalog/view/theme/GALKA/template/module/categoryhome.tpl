<?php if ($categoryhome) { ?>
	<div class="category-list">
        <h2 class="heading_title"><span><?php echo $heading_title; ?></span></h2>

        <ul class="sub_cats">
            <?php foreach ($categoryhome as $category) { ?>
              <li class="cat_hold" >
                <a href="<?php echo $category['href']; ?>">

                <?php if ($category['thumb']) { ?>
                  <img src="<?php echo $category['thumb']; ?>" title="<?php echo $category['name']; ?>" alt="<?php echo $category['name']; ?>" />
                <?php } else { ?>
                  <img src="catalog/view/theme/<?php echo $this->config->get('config_template'); ?>/image/cat_not_found.png" title="<?php echo $category['name']; ?>" alt="<?php echo $category['name']; ?>" />
                <?php } ?>

                <div><span class="cat_name"><?php echo $category['name']; ?></span></div>
                </a>
              </li>
            <?php } ?>
        </ul>
	</div>
<?php } ?>