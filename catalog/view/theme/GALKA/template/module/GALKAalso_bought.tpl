<?php if ($products) { ?>
    <div class="users_selected">
        <div class="block_grey"><?php echo $text_users_selected; ?></div>
        <div class="people_bought_product" id="bxslider_people_bought_<?php echo $count; ?>" >
            <?php foreach ($products as $product) { ?>
            <div class="box-product">
                <a href="<?php echo $product['href']; ?>" >
                    <img src="<?php echo $product['thumb']; ?>" title="<?php echo $product['name']; ?>" alt="<?php echo $product['name']; ?>">
                    <div class="wrapp_info_user_select">
                        <div class="info">
                            <div class="name"><?php echo $product['name']; ?></div>
                            <div class="price"><?php echo $product['price']; ?></div>
                        </div>
                    </div>
                </a>
            </div>
            <?php } ?>
        </div>

        <?php if (count($products) > 2) { ?>
        <script type="text/javascript">
                $('#bxslider_people_bought_<?php echo $count; ?>').bxSlider({
                    minSlides: 3,
                    mode: 'vertical',
                    maxSlides: 5,
                    slideWidth: 250,
                    slideMargin: 10
                });
        </script>
        <?php } ?>
    </div>
<?php } ?>