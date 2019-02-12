<?php echo $header; ?>

<div class="title-holder">
    <div class="inner">
        <div class="breadcrumb">
            <?php foreach ($breadcrumbs as $breadcrumb) { ?>
            <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
            <?php } ?>
        </div>
    </div>
</div>

<div class="inner">
    <?php echo $column_left; ?>
    <?php echo $column_right; ?>

    <div id="content">
        <?php if ($categories) { ?>
            <h2 class="heading_title" id="heading_title_main"><span><?php echo $heading_title; ?></span></h2>
            <?php echo $content_top; ?>

            <div class="category-list">
                <ul class="sub_cats">
                    <?php foreach ($categories as $category) { ?>
                    <li class="cat_hold" >
                        <a href="<?php echo $category['href']; ?>">

                            <?php if ($category['thumb']) { ?>
                                <img src="<?php echo $category['thumb']; ?>" title="<?php echo $category['name']; ?>" alt="<?php echo $category['name']; ?>" />
                            <?php } ?>

                            <div><span class="cat_name"><?php echo $category['name']; ?></span></div>
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </div>
        <?php } else { ?>
            <div class="products_fail"><?php echo $text_empty; ?></div>
            <a class="button" href="<?php echo $continue; ?>"><?php echo $button_continue; ?></a>
        <?php } ?>

        <?php echo $content_bottom; ?>
    </div>
</div>

<?php echo $footer; ?>