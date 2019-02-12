<?php
/**
 * Liqpay Payment Module
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category        Liqpay
 * @package         Payment
 * @version         0.0.1
 * @author          Liqpay
 * @copyright       Copyright (c) 2014 Liqpay
 * @license         http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 *
 * EXTENSION INFORMATION
 *
 * OpenCart         1.5.6
 * LiqPay API       https://www.liqpay.com/ru/doc
 *
 */
?>

<div class="buttons">
    <div class="right">
        <?php echo $data; ?>
    </div>
</div>

<script type="text/javascript">
    $("input[name='btn_text']").click(function() {
        $.ajax({
            type: 'get',
            url: '<?=$url_confirm?>',
            success: function() {
                $("form#liqpay").submit();
            }
        });
    });
</script>
