<div class="clear"></div>
<div class="footer-top-left"><div class="footer-top-right"><div class="footer-top-middle"> </div></div></div>
<div id="footer">
 <div class="footer-bg">
  <?php if ($informations) { ?>
  <div class="column">
    <h3 class="info"><?php echo $text_information; ?></h3>
    <ul>
      <?php foreach ($informations as $information) { ?>
      <li><a href="<?php echo $information['href']; ?>"><?php echo $information['title']; ?></a></li>
      <?php } ?>    
    </ul>
  </div>
  <?php } ?>
  <div class="column">
    <h3 class="service"><?php echo $text_service; ?></h3>
    <ul>
      <li><a href="<?php echo $contact; ?>"><?php echo $text_contact; ?></a></li>
      <li><a href="<?php echo $return; ?>"><?php echo $text_return; ?></a></li>
      <li><a href="<?php echo $sitemap; ?>"><?php echo $text_sitemap; ?></a></li>
    </ul>
  </div>
  <div class="column">
    <h3 class="extra"><?php echo $text_extra; ?></h3>
    <ul>
      <li><a href="<?php echo $manufacturer; ?>"><?php echo $text_manufacturer; ?></a></li>
      <!--<li><a href="<?php echo $voucher; ?>"><?php echo $text_voucher; ?></a></li>
      <li><a href="<?php echo $affiliate; ?>"><?php echo $text_affiliate; ?></a></li>-->
      <li><a href="<?php echo $special; ?>"><?php echo $text_special; ?></a></li>
    </ul>
  </div>
  <div class="column" style="background:none;">
    <h3 class="account"><?php echo $text_account; ?></h3>
	<ul>
      <li><a href="<?php echo $account; ?>"><?php echo $text_account; ?></a></li>
      <li><a href="<?php echo $order; ?>"><?php echo $text_order; ?></a></li>
      <li><a href="<?php echo $wishlist; ?>"><?php echo $text_wishlist; ?></a></li>
      <li><a href="<?php echo $newsletter; ?>"><?php echo $text_newsletter; ?></a></li>
    </ul>
  </div>
 </div>
</div>
</div>
<div id="footer-bottom">
  <div id="footer-menu">
   <div class="footer-links"><a class="home" href="<?php echo $home; ?>"><?php echo $text_home; ?></a><a href="<?php echo $wishlist; ?>" id="wishlist-total-footer"><?php echo $text_wishlist; ?></a><a href="<?php echo $compare; ?>" id="compare-total-footer"><?php echo $text_compare; ?></a><a href="<?php echo $account; ?>"><?php echo $text_account; ?></a><a href="<?php echo $shopping_cart; ?>"><?php echo $text_shopping_cart; ?></a><a href="<?php echo $checkout; ?>"><?php echo $text_checkout; ?></a></div>
  </div>
<!-- 
OpenCart is open source software and you are free to remove the powered by OpenCart if you want, but its generally accepted practise to make a small donation.
Please donate via PayPal to donate@opencart.com
//-->
<div id="powered"><?php echo $powered; ?></div>
<!-- 
OpenCart is open source software and you are free to remove the powered by OpenCart if you want, but its generally accepted practise to make a small donation.
Please donate via PayPal to donate@opencart.com
//-->


</div>
</body></html>

<div id="callme"><input type="button" id="viewform" /></div>
<div id="callmeform" class="hide-off"><div id="cme_cls"></div><h6>Заказать обратный звонок</h6>
  <table cellpadding="0" cellspacing="0">
    <tr><td>Ваше имя</td></tr>
    <tr><td><input class="txt" type="text" maxlength="150" id="cname" value="" /></td></tr>
    <tr><td>Телефон</td></tr>
    <tr><td><input class="txt" type="text" maxlength="150" value="+380" id="cphone" /></td></tr>
    <tr><td>Вопрос или комментарий</td></tr>
    <tr><td><input class="txt" type="text" maxlength="1000" id="ccmnt" /></td></tr>
    <tr><td>
    <div id="cm_crds">&copy; CallMe</div>
    <input class="btn" type="button" value="Перезвоните мне"></td>
    </tr>
  </table>
  <div id="callme_result"></div>
</div>