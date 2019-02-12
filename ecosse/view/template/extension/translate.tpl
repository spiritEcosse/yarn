<?php echo $header; ?>
<div id="content">
    <div class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
        <?php } ?>
    </div>
    <?php if ($success) { ?>
    <div class="success"><?php echo $success; ?></div>
    <?php } ?>
    <?php if ($error) { ?>
    <div class="warning"><?php echo $error; ?></div>
    <?php } ?>

    <?php if ($error_warning) { ?>
        <?php foreach ($error_warning as $error) { ?>
            <div class="warning"><?php echo $error; ?></div>
        <?php } ?>
    <?php } ?>

    <div class="box">
        <div class="heading">
            <h1><img src="view/image/feed.png" alt="" /> <?php echo $heading_title; ?></h1>
        </div>
        <div class="content">
            <a href="<?php echo $action; ?>" class="button">Перевести seo</a>
        </div>
    </div>
</div>
<?php echo $footer; ?>