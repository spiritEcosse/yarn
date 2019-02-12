<?php if ($logged) { ?>
    <div class="box">
        <div class="box-heading"><?php echo $heading_title; ?></div>
        <div class="box-content">
            <div class="box-category">
                <ul>
                    <?php if ($discount_birthday != null) { ?>
                        <li><a href="<?php echo $href_discount_birthday; ?>"><?php echo $text_gifts; ?></a></li>
                    <?php } ?>

                    <li><a href="<?php echo $account; ?>"><?php echo $text_account; ?></a></li>

                    <li><a href="<?php echo $edit; ?>"><?php echo $text_edit; ?></a></li>
                    <li><a href="<?php echo $password; ?>"><?php echo $text_password; ?></a></li>

                    <li><a href="<?php echo $wishlist; ?>"><?php echo $text_wishlist; ?></a></li>
                    <li><a href="<?php echo $order; ?>"><?php echo $text_order; ?></a></li>
                    <li><a href="<?php echo $download; ?>"><?php echo $text_download; ?></a></li>
                    <li><a href="<?php echo $newsletter; ?>"><?php echo $text_newsletter; ?></a></li>

                    <?php if ($logged) { ?>
                    <li><a href="<?php echo $logout; ?>"><?php echo $text_logout; ?></a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
<?php  } ?>