<?php echo $header; ?>
<?php if ($success) { ?>
<div class="success"><?php echo $success; ?><img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>
<?php } ?>
<?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <h1><?php echo $heading_title; ?></h1>
  <?php if ($products) { ?>
  <table class="compare-info">
    <thead>
      <tr>
        <td class="compare-product" colspan="<?php echo count($products) + 1; ?>"><?php echo $text_product; ?></td>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><?php echo $text_name; ?></td>
        <?php foreach ($products as $product) { ?>
        <td class="name"><a href="<?php echo $products[$product['product_id']]['href']; ?>"><?php echo $products[$product['product_id']]['name']; ?></a></td>
        <?php } ?>
      </tr>
      <tr>
        <td><?php echo $text_image; ?></td>
        <?php foreach ($products as $product) { ?>
        <td><?php if ($products[$product['product_id']]['thumb']) { ?>
          <img src="<?php echo $products[$product['product_id']]['thumb']; ?>" alt="<?php echo $products[$product['product_id']]['name']; ?>" />
          <?php } ?></td>
        <?php } ?>
      </tr>
      <tr>
        <td><?php echo $text_price; ?></td>
        <?php foreach ($products as $product) { ?>
        <td><?php if ($product['price_status'] != 0) { ?>
            <?php if ($products[$product['product_id']]['price']) { ?>
          <?php if (!$products[$product['product_id']]['special']) { ?>
          
          <?php if ($products[$product['product_id']]['price_prefix_name'] !== NULL) { ?>
                <span class="simple"><?php echo $products[$product['product_id']]['price_prefix_name']; ?></span>
          <?php } ?>
          <?php echo $products[$product['product_id']]['price']; ?>
          <?php if ($products[$product['product_id']]['price_after_name'] !== NULL) { ?>
             <span class="simple"><?php echo $products[$product['product_id']]['price_after_name']; ?></span>
          <?php } ?>
          
          <?php } else { ?>
          <span class="price-old">
              <?php if ($products[$product['product_id']]['price_prefix_name'] !== NULL) { ?>
                <span class="simple"><?php echo $products[$product['product_id']]['price_prefix_name']; ?></span>
              <?php } ?>
                
              <?php echo $products[$product['product_id']]['price']; ?>
                
              <?php if ($products[$product['product_id']]['price_after_name'] !== NULL) { ?>
                  <span class="simple"><?php echo $products[$product['product_id']]['price_after_name']; ?></span>
              <?php } ?>
          </span> </br> <span class="price-new">
              <?php if ($products[$product['product_id']]['price_prefix_name'] !== NULL) { ?>
                <?php echo $products[$product['product_id']]['price_prefix_name']; ?>
              <?php } ?>
                
              <?php echo $products[$product['product_id']]['special']; ?>
                
              <?php if ($products[$product['product_id']]['price_after_name'] !== NULL) { ?>
                  <span class="simple"><?php echo $products[$product['product_id']]['price_after_name']; ?></span>
              <?php } ?>
          </span>
          <?php } ?>
          <?php } ?>
        <?php } ?></td>
        <?php } ?>
      </tr>
      <tr>
        <td><?php echo $text_model; ?></td>
        <?php foreach ($products as $product) { ?>
        <td><?php echo $products[$product['product_id']]['model']; ?></td>
        <?php } ?>
      </tr>
      <tr>
        <td><?php echo $text_manufacturer; ?></td>
        <?php foreach ($products as $product) { ?>
        <td><?php echo $products[$product['product_id']]['manufacturer']; ?></td>
        <?php } ?>
      </tr>
      <tr>
        <td><?php echo $text_availability; ?></td>
        <?php foreach ($products as $product) { ?>
        <td><?php echo $products[$product['product_id']]['availability']; ?></td>
        <?php } ?>
      </tr>
      <tr>
        <td><?php echo $text_rating; ?></td>
        <?php foreach ($products as $product) { ?>
        <td><img src="catalog/view/theme/default/image/stars-<?php echo $products[$product['product_id']]['rating']; ?>.png" alt="<?php echo $products[$product['product_id']]['reviews']; ?>" /><br />
          <?php echo $products[$product['product_id']]['reviews']; ?></td>
        <?php } ?>
      </tr>
      <tr>
        <td><?php echo $text_summary; ?></td>
        <?php foreach ($products as $product) { ?>
        <td class="description"><?php echo $products[$product['product_id']]['description']; ?></td>
        <?php } ?>
      </tr>
      <tr>
        <td><?php echo $text_weight; ?></td>
        <?php foreach ($products as $product) { ?>
        <td><?php echo $products[$product['product_id']]['weight']; ?></td>
        <?php } ?>
      </tr>
      <tr>
        <td><?php echo $text_dimension; ?></td>
        <?php foreach ($products as $product) { ?>
        <td><?php echo $products[$product['product_id']]['length']; ?> x <?php echo $products[$product['product_id']]['width']; ?> x <?php echo $products[$product['product_id']]['height']; ?></td>
        <?php } ?>
      </tr>
    </tbody>
    <?php foreach ($attribute_groups as $attribute_group) { ?>
    <thead>
      <tr>
        <td class="compare-attribute" colspan="<?php echo count($products) + 1; ?>"><?php echo $attribute_group['name']; ?></td>
      </tr>
    </thead>
    <?php foreach ($attribute_group['attribute'] as $key => $attribute) { ?>
    <tbody>
      <tr>
        <td><?php echo $attribute['name']; ?></td>
        <?php foreach ($products as $product) { ?>
        <?php if (isset($products[$product['product_id']]['attribute'][$key])) { ?>
        <td><?php echo $products[$product['product_id']]['attribute'][$key]; ?></td>
        <?php } else { ?>
        <td></td>
        <?php } ?>
        <?php } ?>
      </tr>
    </tbody>
    <?php } ?>
    <?php } ?>
    <tr>
      <td></td>
      <?php foreach ($products as $product) { ?>
      <td>
          <?php if ($product['price_status'] != 0) { ?>
          <input type="button" value="<?php echo $button_cart; ?>" onclick="addToCart('<?php echo $product['product_id']; ?>');" class="button" />
          &nbsp;&nbsp;&nbsp;<?php echo $text_or; ?>&nbsp;&nbsp;&nbsp;
          <a class="button fastorder" data-name="<?php echo $product['name']; ?>" data-url="<?php echo $product['href']; ?>" href="javascript:void(0)"><span><?php echo $text_fastorder; ?></span></a>  
      <?php } ?>
      </td>
      <?php } ?>
      
    </tr>
    
    <tr>
      <td></td>
      <?php foreach ($products as $product) { ?>
      <td class="remove"><a href="<?php echo $product['remove']; ?>" class="button"><?php echo $button_remove; ?></a></td>
      <?php } ?>
    </tr>
  </table>
  <div class="buttons">
    <div class="right"><a href="<?php echo $continue; ?>" class="button"><?php echo $button_continue; ?></a></div>
  </div>
  <?php } else { ?>
  <div class="content"><?php echo $text_empty; ?></div>
  <div class="buttons">
    <div class="right"><a href="<?php echo $continue; ?>" class="button"><?php echo $button_continue; ?></a></div>
  </div>
  <?php } ?>
  <?php echo $content_bottom; ?></div>
<?php echo $footer; ?>