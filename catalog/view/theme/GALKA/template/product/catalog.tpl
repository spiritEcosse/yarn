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
        <h2 class="heading_title" id="heading_title_main"><span><?php echo $heading_title; ?></span></h2>
        <?php echo $content_top; ?>

        <div class="category-info" >
            <?php if ($thumb) { ?>
                <div class="image"><img src="<?php echo $thumb; ?>" alt="<?php echo $heading_title; ?>" title="<?php echo $heading_title; ?>"/></div>
            <?php } ?>

            <?php if ($description) { ?>
                <?php echo $description; ?>
            <?php } ?>
        </div>

        <div class="table-header">
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
        </div>

        <?php echo $content_bottom; ?>
    </div>
</div>

<?php echo $footer; ?>