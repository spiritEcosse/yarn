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
      
      <div class="sitemap-info">
        <div class="left">
          <?php if ($categories) { ?>
            <ul>
              <?php foreach ($categories as $category) { ?>
                <li>
                  <a class="main_category" href="<?php echo $category['href']; ?>">
                    <?php echo $category['name']; ?>
                  </a>
                  
                  <?php getSubCategoriesSiteMap($category['children']); ?>
                </li>
              <?php } ?>
            </ul>
          <?php } ?>
        </div>

        <div class="right">
          <ul>
            <li><a href="<?php echo $special; ?>"><?php echo $text_special; ?></a></li>
            <li><a href="<?php echo $account; ?>"><?php echo $text_account; ?></a>
              <ul>
                <li><a href="<?php echo $edit; ?>"><?php echo $text_edit; ?></a></li>
                <li><a href="<?php echo $password; ?>"><?php echo $text_password; ?></a></li>
                <li><a href="<?php echo $address; ?>"><?php echo $text_address; ?></a></li>
                <li><a href="<?php echo $history; ?>"><?php echo $text_history; ?></a></li>
                <li><a href="<?php echo $download; ?>"><?php echo $text_download; ?></a></li>
              </ul>
            </li>
            <li><a href="<?php echo $cart; ?>"><?php echo $text_cart; ?></a></li>
            <li><a href="<?php echo $checkout; ?>"><?php echo $text_checkout; ?></a></li>
            <li><a href="<?php echo $search; ?>"><?php echo $text_search; ?></a></li>
            <li><?php echo $text_information; ?>
              <ul>
                <?php foreach ($informations as $information) { ?>
                  <li><a href="<?php echo $information['href']; ?>"><?php echo $information['title']; ?></a></li>
                <?php } ?>

                <li><a href="<?php echo $contact; ?>"><?php echo $text_contact; ?></a></li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
      <?php echo $content_bottom; ?>
  </div>
</div>

<?php echo $footer; ?>

<?php function getSubCategoriesSiteMap($categories) { ?>
  <?php foreach ($categories as $category) { ?>
    <ul class="map_children">
      <li>
        <a href="<?php echo $category['href']; ?>">
          <?php echo $category['name']; ?>
        </a>
        
        <?php getSubCategoriesSiteMap($category['children']); ?>
      </li>
    </ul>
  <?php } ?>
<?php } ?>