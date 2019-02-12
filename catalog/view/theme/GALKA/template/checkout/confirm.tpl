<?php if (!isset($redirect)) { ?>

<div class="checkout-product">
    <table>
        <thead>
        <tr>
            <td class="fotot"><?php echo $column_foto; ?></td>
            <td class="name"><?php echo $column_name; ?></td>
            <td class="model"><?php echo $column_model; ?></td>
            <td class="quantity"><?php echo $column_quantity; ?></td>
            <td class="price"><?php echo $column_price; ?></td>
            <td class="total"><?php echo $column_total; ?></td>
        </tr>
        </thead>

        <tbody>
        <?php foreach($products as $product) { ?>
        <tr>
            <td class="foto"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['image']; ?>"></a></td>
            <td class="name">
                <a href="<?php echo $product['href']; ?>">
                    <?php echo $product['name']; ?>
                    <?php if ($product['prefix_name'] != '') { ?>
                    (<?php echo $product['prefix_name']; ?>)
                    <?php } ?>
                </a>
                <?php foreach($product['option'] as $option) { ?>
                <br/>
                &nbsp;
                <small> - <?php echo $option['name']; ?>
                    : <?php echo $option['value']; ?></small>
                <?php } ?></td>
            <td class="model"><?php echo $product['product_id']; ?></td>
            <td class="quantity"><?php echo $product['quantity']; ?></td>
            <td class="price">
                <?php if ($product['gift'] == false) { ?>
                <div class="rightPrice red">
                    <?php echo $product['price']; ?>
                </div>
                <?php if ($product['diff_price']) { ?>
                <div><span class="old_price"><?php echo $product['old_price']; ?></span></div>
                <div><?php echo '-' . $product['sale'] . '%'; ?></div>
                <?php } ?>
                <?php } ?>
            </td>
            <td class="total">
                <?php if ($product['gift'] == true) { ?>
                <?php echo $text_birthday; ?>
                <?php } else { ?>
                <div class="rightPrice">
                    <span class="red"><?php echo $product['total']; ?></span>

                    <?php if ($product['diff_price']) { ?>
                    <div><span class="old_price"><?php echo $product['old_price_total']; ?></span></div>
                    <?php } ?>
                </div>
                <?php } ?>
            </td>
        </tr>
        <?php } ?>

        <?php foreach($vouchers as $voucher) { ?>
        <tr>
            <td class="name"><?php echo $voucher['description']; ?></td>
            <td class="model"></td>
            <td class="quantity">1</td>
            <td class="price"><?php echo $voucher['amount']; ?></td>
            <td class="total"><?php echo $voucher['amount']; ?></td>
        </tr>
        <?php } ?>
        </tbody>

        <tfoot id="total_data">
        <?php echo $total_data; ?>
        </tfoot>
    </table>
</div>

<div class="payment"><?php echo $payment; ?></div>
<?php } else { ?>
<script type="text/javascript"><!--
    location = '<?php echo $redirect; ?>';
    //--></script>
<?php } ?>