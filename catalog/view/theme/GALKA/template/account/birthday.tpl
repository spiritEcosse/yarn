<span style="font-size: 18px;">Здравствуйте,
    <?php echo $first_name . ' '; ?>
    <?php echo $last_name . '.'; ?>
</span>

<?php if ($birthday_description) { ?>
    <div style="margin: 10px 0px;">
        <?php echo $birthday_description; ?>
    </div>
<?php } ?>

<?php if ($warning_birthday_price) { ?>
    <div style="margin: 10px 0px;"><span style="font-size: 16px;"><?php echo $warning_birthday_price; ?></span></div>
<?php } ?>

<?php if ($discount_birthday_days_products) { ?>
    <ul style="list-style: none;">
        <?php foreach ($discount_birthday_days_products as $product) { ?>
        <li style="font-size: 14px;">
            <a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
        </li>
        <?php } ?>
    </ul>
<?php } ?>
