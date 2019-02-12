<?php echo $header; ?>

<div class="title-holder">
  <div class="inner">
    <div class="breadcrumb">
      <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <?php echo $breadcrumb['separator']; ?>
        <a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
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
    
    <?php if ($categories) { ?>
      <p>
        <b><?php echo $text_index; ?></b>

        <?php foreach ($categories as $category) { ?>
          &nbsp;&nbsp;&nbsp;
          <button id="targed-id" value="<?php echo $category['name']; ?>" ><b><?php echo $category['name']; ?></b></button>
        <?php } ?>
      </p>
      
      <?php foreach ($categories as $category) { ?>
        <div class="manufacturer-list">
          <div class="manufacturer-heading"><?php echo $category['name']; ?><a id="<?php echo $category['name']; ?>"></a></div>
          <div class="manufacturer-content">
            <?php if ($category['manufacturer']) { ?>
              <?php for ($i = 0; $i < count($category['manufacturer']); ) { ?>
                <ul>
                  <?php $j = $i + ceil(count($category['manufacturer']) / 4); ?>

                  <?php for ( ; $i < $j; $i++) { ?>
                    <?php if (isset($category['manufacturer'][$i])) { ?>
                      <li>
                        <a href="<?php echo $category['manufacturer'][$i]['href']; ?>">
                          <?php echo $category['manufacturer'][$i]['name']; ?>

                          <?php if ($category['manufacturer'][$i]['image'] != '') { ?>
                            <div class="image_manufacturer" >
                              <img src="<?php echo $category['manufacturer'][$i]['image']; ?>" />
                            </div>
                          <?php } ?>
                        </a>
                      </li>
                    <?php } ?>
                  <?php } ?>
                </ul>
              <?php } ?>
            <?php } ?>
          </div>
        </div>
      <?php } ?>
    <?php } else { ?>
      <div class="content"><?php echo $text_empty; ?></div>
      <div class="buttons">
        <div class="right"><a href="<?php echo $continue; ?>" class="button"><?php echo $button_continue; ?></a></div>
      </div>
    <?php } ?>

    <?php echo $content_bottom; ?>
  </div>
</div>

<?php echo $footer; ?>

<script type="text/javascript">
  $('button#targed-id').click(function() {
    str = $(this).val();
    var heigth = 100;
    
    <?php if ($this->config->get('GALKAControl_status') == 1 && $this->config->get('GALKAControl_sticky_menu') == 1) { ?>
      heigth += $('#menu_wrapper').outerHeight(true);
    <?php } ?>
    
    jQuery.scrollTo($("#" + str).offset().top - heigth, 1000);
  });
</script>
