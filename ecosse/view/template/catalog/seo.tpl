<?php echo $header; ?>
<div id="content">
    <div class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
        <?php } ?>
    </div>
    <?php if ($error_warning) { ?>
    <div class="warning"><?php echo $error_warning; ?></div>
    <?php } ?>

    <?php if ($success) { ?>
        <div class="success"><?php echo $success; ?></div>
    <?php } ?>

    <div class="box">
        <div class="heading">
            <h1><img src="view/image/information.png" alt="" /> <?php echo $heading_title; ?></h1>
            <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a></div>
        </div>
        <div class="content">
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
                <table class="form">
                    <tr>
                        <td>
                            Каталог
                        </td>
                        <td>
                            <span class="error"><?php echo $error_product_catalog; ?></span>
                            <input name="catalog" value="<?php echo $catalog; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Акции
                        </td>
                        <td>
                            <span class="error"><?php echo $error_product_special; ?></span>
                            <input name="special" value="<?php echo $special; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>Скидки</td>
                        <td>
                            <span class="error"><?php echo $error_product_discount; ?></span>
                            <input name="discount" value="<?php echo $discount; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>Контакты</td>
                        <td>
                            <span class="error"><?php echo $error_information_contact; ?></span>
                            <input name="contacts" value="<?php echo $contacts; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>Список категорий Video</td>
                        <td>
                            <span class="error"><?php echo $error_catalog_video; ?></span>
                            <input name="catalog_video" value="<?php echo $catalog_video; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>Карта сайта</td>
                        <td>
                            <span class="error"><?php echo $error_information_sitemap; ?></span>
                            <input name="information_sitemap" value="<?php echo $information_sitemap; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>Корзина</td>
                        <td>
                            <span class="error"><?php echo $error_checkout_cart; ?></span>
                            <input name="checkout_cart" value="<?php echo $checkout_cart; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>Войти</td>
                        <td>
                            <span class="error"><?php echo $error_account_login; ?></span>
                            <input name="account_login" value="<?php echo $account_login; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>Зарегистрироваться</td>
                        <td>
                            <span class="error"><?php echo $error_account_register; ?></span>
                            <input name="account_register" value="<?php echo $account_register; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>Мои желания</td>
                        <td>
                            <span class="error"><?php echo $error_account_wishlist; ?></span>
                            <input name="account_wishlist" value="<?php echo $account_wishlist; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>Сравнения</td>
                        <td>
                            <span class="error"><?php echo $error_product_compare; ?></span>
                            <input name="product_compare" value="<?php echo $product_compare; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>Распродажа</td>
                        <td>
                            <span class="error"><?php echo $error_product_sale; ?></span>
                            <input name="product_sale" value="<?php echo $product_sale; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>Список категорий статей</td>
                        <td>
                            <span class="error"><?php echo $error_list_category_article; ?></span>
                            <input name="list_category_article" value="<?php echo $list_category_article; ?>">
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>
<?php echo $footer; ?>