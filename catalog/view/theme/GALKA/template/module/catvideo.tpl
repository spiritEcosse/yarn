<?php if (count($categories) > 0) { ?>
<div class="box">
    <div class="box-heading"><?php echo $heading_title; ?></div>
    <div class="box-content">
        <div class="box-category">
            <ul>
                <?php foreach ($categories as $category) { ?>
                    <li >
                        <?php if (in_array($category['category_video_id'], $categories_active)) { ?>
                            <a href="<?php echo $category['href']; ?>" class="active"><?php echo $category['name']; ?></a>
                            <?php $class_ul = 'block'; ?>
                        <?php } else { ?>
                            <a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a>

                            <?php if ($category['children']) { ?>
                                <span class="img_active" onclick="slide_cat(this);"></span>
                                <?php $class_ul = 'none'; ?>
                            <?php } ?>
                        <?php } ?>

                        <?php if ($category['children']) { ?>
                            <?php getCat($category['children'], $categories_active, ' ', $class_ul); ?>
                        <?php } ?>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>
<?php } ?>

<?php function getCat($categories, $categories_active, $pref, $class_ul = 'block') { ?>
    <?php if (count($categories) > 0) { ?>
        <ul class="<?php echo $class_ul; ?>">
            <?php $pref .= '&nbsp;&nbsp;'; ?>

            <?php foreach ($categories as $category) { ?>
            <li>
                <a href="<?php echo $category['href']; ?>"

                <?php if (in_array($category['category_video_id'], $categories_active)) { ?>
                    class="active"
                <?php } ?>

                ><?php echo $pref . '- ' . $category['name']; ?></a>

                <?php getCat($category['children'], $categories_active, $pref); ?>
            </li>
            <?php } ?>
        </ul>
    <?php } ?>
<?php } ?>