<table class='fabric'>
    <thead>
    <tr>
        <h2><?php echo "Категория " . $fabric_name; ?></h2>
        <td class='left'>Название</td>
        <td class='left'>Производитель</td>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($fabric_values as $fabric_value) { ?>
        <tr>
            <td>
                <?php if ($fabric_value['description'] != '') { ?>
                    <a class='' onclick='return hs.htmlExpand(this, { outlineType: "rounded-white",
                                wrapperClassName: "draggable-header", objectType: "ajax", width: 650, height: 750  } )' 
                                href="http://<?php echo $_SERVER['SERVER_NAME']; ?>/index.php?route=product/product/getDesc&product_id=<?php echo $fabric_value['product_id']; ?>">
                      <?php echo $fabric_value['product_name']; ?>
                    </a>
                <?php } else { ?>
                    <?php echo $fabric_value['product_name']; ?>
                <?php } ?>
            </td>
            <td><?php echo $fabric_value['manufacturer_name']; ?></td>
        </tr>
    <?php } ?>
    </tbody>
</table>