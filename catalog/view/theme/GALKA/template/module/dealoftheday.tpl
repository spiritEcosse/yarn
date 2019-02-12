<?php if ($products) { ?>
  <?php if ($setting['position'] == 'content_header'){ ?>
  <div class="inner deal-inner">
    <h2 class="heading_title"><span><?php echo $heading_title; ?></span></h2>
    <div id="alldeals">
      <?php foreach ($products as $product) { ?>
      <div class="deal_holder" data-in="top:-1000;duration:2000;delay:250;ease:easeInOutBounce" data-out="duration:1500;delay:4000;opacity:0">
      <div class="deal_image" data-in="top:-1000;duration:2000;delay:1000;ease:easeInOutBounce" data-out="duration:1500;delay:3000;opacity:0">
        <?php if ($product['thumb']) { ?>
          <a class="img_deal" href="<?php echo $product['href']; ?>">
            <img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>"  title="<?php echo $product['name']; ?>" />
          </a>
        <?php } ?>

        <div class="sale_save_holder">
          <?php
          $startDate1 = strtotime(mb_substr($product['startdate'], 0, 10));
          $endDate2 = strtotime(date("Y-m-d"));
          $days = ceil(($endDate2 / 86400)) - ceil(($startDate1 / 86400));
          ?>
          <?php if($this->config->get('GALKAControl_status') == '1'){ ?>
          <?php $numeroNew = $this->config->get('GALKAControl_new_label'); ?>
          <?php } else { ?>
          <?php $numeroNew = 30; ?>
          <?php } ?>
          <?php if ($days < $numeroNew) { ?>
          <span class="new_prod"><b><?php echo $text_new_prod; ?></b></span>
          <?php } ?>
          <?php if ($product['special']) { ?>
          <?php 
          $val1 = preg_replace("/[^0-9.]/", "", $product['special']);
  		    $val2 = preg_replace("/[^0-9.]/", "", $product['price']);
          ?>
          <?php
          $res = ($val1 / $val2) * 100;
          $res = 100 - $res;
          $res = round($res, 1);
          ?>
          <span class="sale"><b><?php echo $text_sale; ?></b></span><span class="save"><b>-<?php echo $res; ?>%</b></span>
          <?php } ?>
        </div>

       <div class="clear"></div> 
      </div>

      <div class="deal_info">
        <div class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
        <div class="deal_desc"><?php echo $product['description']; ?></div>
        <?php if ($product['price']) { ?>
        <div class="price">
          <?php if (!$product['special']) { ?>
          <?php echo $product['price']; ?>
          <?php } else { ?>
          <div class="count_holder">
            <?php if(($this->config->get('GALKAControl_status') == '1') && ($this->config->get('GALKAControl_countdown') == '1')){ ?>
            <?php if ($product['date_end'] != '0000, 00 - 1, 00') { ?>
            <div class="offer_title"><?php echo $text_limited; ?></div>
            <div id="GALKACountSmallDeal<?php echo $product['product_id']; ?>" class="doubled"></div>
            <script type="text/javascript">
  					$(function () {	
  						$('#GALKACountSmallDeal<?php echo $product['product_id']; ?>').countdown({until: new Date(<?php echo $product['date_end']; ?>), compact: false});
  					});
  				  </script>
            <div class="clear"></div>
            <div class="deal_price"> <span class="price-old one_third" data-in="left:1000;duration:1000;delay:1500;ease:easeInOutBounce;opacity:0" data-out="delay:5000;opacity:0"> <small><?php echo $text_old_price; ?></small> <span><?php echo $product['price']; ?> </span></span> <span class="price-new one_third" data-in="left:1000;duration:1000;delay:1800;ease:easeInOutBounce;opacity:0" data-out="delay:5000;opacity:0"> <small><?php echo $text_deal_price; ?></small> <?php echo $product['special']; ?> </span> <span class="deal_save one_third last" data-in="left:1000;duration:1000;delay:2100;ease:easeInOutBounce;opacity:0" data-out="delay:5000;opacity:0"> <small><?php echo $text_saving; ?></small> <b><?php echo $res; ?>%</b> </span>
              <div class="clear"></div>
            </div>

            <?php if ($quantity_left) { ?>
              <div class="count_info info_prod_left">
                <?php echo $text_only; ?>
                <b><?php echo $product['quantity']; ?></b>
              <?php echo $text_left; ?>!</div>
            <?php } ?>

            <?php if ($quantity_start) { ?>
              <div class="count_info info_prod_sold"><b><?php echo $quantity_left; ?></b> <?php echo $text_purchased; ?></div>
              <div class="clear"></div>
            <?php } ?>
          </div>
          <?php } ?>
          <?php } ?>
          <?php } ?>
        </div>
        <?php } ?>
        <div class="cart">
          <a class="add_to_cart_small" title="<?php echo $button_cart; ?>" onclick="addToCart('<?php echo $product['product_id']; ?>');"><?php echo $text_buy; ?></a>
        </div>
      </div>
      </div>

      <?php } ?> 
      </div>
      <noscript>
      <p>Please enable JavaScript to get the full experience.</p>
      </noscript>
      <div class="clear"></div>
  </div>
  <?php } else { ?>
   <div class="box">
    <h2 class="heading_title"><span><?php echo $heading_title; ?></span></h2>
    <div id="alldeals">
      <?php foreach ($products as $product) { ?>
      <div class="deal_holder" data-in="top:-1000;duration:2000;delay:250;ease:easeInOutBounce" data-out="duration:1500;delay:4000;opacity:0">
      <div class="deal_image" data-in="top:-1000;duration:2000;delay:1000;ease:easeInOutBounce" data-out="duration:1500;delay:3000;opacity:0">
        <?php if ($product['thumb']) { ?>
        <a href="<?php echo $product['href']; ?>">
          <img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" /></a>
        <?php } ?>
        <div class="sale_save_holder">
          <?php
          $startDate1 = strtotime(mb_substr($product['startdate'], 0, 10));
          $endDate2 = strtotime(date("Y-m-d"));
          $days = ceil(($endDate2 / 86400)) - ceil(($startDate1 / 86400));
          ?>
          <?php if($this->config->get('GALKAControl_status') == '1'){ ?>
          <?php $numeroNew = $this->config->get('GALKAControl_new_label'); ?>
          <?php } else { ?>
          <?php $numeroNew = 30; ?>
          <?php } ?>
          <?php if ($days < $numeroNew) { ?>
          <span class="new_prod"><b><?php echo $text_new_prod; ?></b></span>
          <?php } ?>
          <?php if ($product['special']) { ?>
          <?php 
          $val1 = preg_replace("/[^0-9.]/", "", $product['special']);
  		    $val2 = preg_replace("/[^0-9.]/", "", $product['price']);
          ?>
          <?php
          $res = ($val1 / $val2) * 100;
          $res = 100 - $res;
          $res = round($res, 1);
          ?>
          <span class="sale"><b><?php echo $text_sale; ?></b></span><span class="save"><b>-<?php echo $res; ?>%</b></span>
          <?php } ?>
        </div>
       <div class="clear"></div> 
      </div>
      <div class="deal_info">
        <div class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
        <div class="deal_desc"><?php echo $product['description']; ?></div>
        <?php if ($product['price']) { ?>
        <div class="price">
          <?php if (!$product['special']) { ?>
          <?php echo $product['price']; ?>
          <?php } else { ?>
          <div class="count_holder">
            <?php if(($this->config->get('GALKAControl_status') == '1') && ($this->config->get('GALKAControl_countdown') == '1')){ ?>
            <?php if ($product['date_end'] != '0000, 00 - 1, 00') { ?>
            <div class="offer_title"><?php echo $text_limited; ?></div>
            <div id="GALKACountSmallDeal<?php echo $product['product_id']; ?>" class="doubled"></div>
            <script type="text/javascript">
  					$(function () {	
  						$('#GALKACountSmallDeal<?php echo $product['product_id']; ?>').countdown({until: new Date(<?php echo $product['date_end']; ?>), compact: false});
  					});
  				  </script>
            <div class="clear"></div>
            <div class="deal_price"> <span class="price-old one_third" data-in="left:1000;duration:1000;delay:1500;ease:easeInOutBounce;opacity:0" data-out="delay:5000;opacity:0"> <small><?php echo $text_old_price; ?></small> <span><?php echo $product['price']; ?> </span></span> <span class="price-new one_third" data-in="left:1000;duration:1000;delay:1800;ease:easeInOutBounce;opacity:0" data-out="delay:5000;opacity:0"> <small><?php echo $text_deal_price; ?></small> <?php echo $product['special']; ?> </span> <span class="deal_save one_third last" data-in="left:1000;duration:1000;delay:2100;ease:easeInOutBounce;opacity:0" data-out="delay:5000;opacity:0"> <small><?php echo $text_saving; ?></small> <b>-<?php echo $res; ?>%</b> </span>
              <div class="clear"></div>
            </div>
            <?php if ($quantity_left) { ?>
            <div class="count_info info_prod_left"><?php echo $text_only; ?> <b><?php echo $product['quantity']; ?></b> <?php echo $text_left; ?>!</div>
            <?php } ?>

            <?php if ($quantity_start) { ?>
              <div class="count_info info_prod_sold"><b><?php echo $quantity_left; ?></b> <?php echo $text_purchased; ?></div>
              <div class="clear"></div>
            <?php } ?>
            
          </div>
          <?php } ?>
          <?php } ?>
          <?php } ?>
        </div>
        <?php } ?>
        <div class="cart">
          
          <a class="add_to_cart_small" title="<?php echo $button_cart; ?>" onclick="addToCart('<?php echo $product['product_id']; ?>');"><?php echo $text_buy; ?></a>
          
        </div>
      </div>
      </div>

      <?php } ?> 
      </div>
    </div>
  <?php } ?>
<?php } ?>

<script>
  $(document).ready(function(){
    $('#alldeals').ayaSlider({
    easeIn : 'easeOutBack',
    easeOut : 'linear',
    delay : 5000,
    previous : $('.prev'),
    next : $('.next'),
    list : $('.slideControl')
    });
  });
</script>
