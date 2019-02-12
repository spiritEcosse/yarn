<ul class="topnav2" id="topnav2">
    <li class="top_cat">
        <a href="<?php echo $tv; ?>"><?php echo $text_tv; ?></a>
    </li>
    <li class="top_cat">
        <a href="<?php echo $club; ?>"><?php echo $text_club; ?></a>
    </li>

    <?php foreach ($tops as $top) { ?>
        <li class="top_cat">
            <a href="<?php echo $top['href']; ?>"><?php echo $top['title']; ?></a>
        </li>
    <?php } ?>

    <li class="top_cat">
        <a href="<?php echo $special; ?>"><?php echo $text_special; ?></a>
    </li>

    <li class="top_cat">
        <a href="<?php echo $discount; ?>"><?php echo $text_discount; ?></a>
    </li>
    <li class="top_cat">
        <a href="<?php echo $catalog; ?>"><?php echo $text_catalog; ?></a>
    </li>
    <li class="home top_cat">
        <a href="<?php echo $base; ?>" class="home_link"><?php echo $text_home; ?></a>
    </li>
</ul>
