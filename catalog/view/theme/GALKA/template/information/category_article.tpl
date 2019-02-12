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

        <?php if ($articles) { ?>
        <div class="list_article">
            <?php foreach ($articles as $article) { ?>
            <div class="article">
                <div class="name">
                    <h3>
                        <?php echo $article['name']; ?>
                    </h3>
                </div>
                <div class="description"><?php echo html_entity_decode($article['article_description']); ?></div>
                <?php echo html_entity_decode($article['article_link'], ENT_QUOTES, 'UTF-8'); ?>
            </div>
            <?php } ?>
        </div>

        <div class="pagination" id="pagination_bottom">
            <?php echo $pagination; ?>
        </div>
        <?php } else { ?>
        <div class="content">
            <div class="products_fail"><?php echo $text_empty; ?></div>
            <a class="button" href="<?php echo $continue; ?>"><?php echo $button_continue; ?></a>
        </div>
        <?php } ?>

        <?php echo $content_bottom; ?>
    </div>
</div>

<?php echo $footer; ?>