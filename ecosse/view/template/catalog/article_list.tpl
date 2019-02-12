<?php echo $header; ?>
<div id="content">
    <div class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
        <?php } ?>
    </div>
    <?php if ($error_warning) { ?>
    <div class="warning"><?php echo $error_warning; ?></div>
    <?php } ?>
    <?php if ($success) { ?>
    <div class="success"><?php echo $success; ?></div>
    <?php } ?>
    <div class="box">
        <div class="heading">
            <h1><img src="view/image/order.png" alt="" /> <?php echo $heading_title; ?></h1>
            <div class="buttons">
                <a onclick="location = '<?php echo $insert; ?>'" class="button"><?php echo $button_insert; ?></a>
                <a onclick="$('form').submit();" class="button"><?php echo $button_delete; ?></a>

                <a onclick="$('#form').attr('action', '<?php echo $copy; ?>'); $('#form').submit();" class="button"><?php echo $button_copy; ?></a>
            </div>
        </div>
        <div class="content">
            <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
                <table class="list">
                    <thead>
                    <tr>
                        <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
                        <td class="right"><?php if ($sort == 'article_date_added') { ?>
                            <a href="<?php echo $sort_article_date_added; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_article_date_added; ?></a>
                            <?php } else { ?>
                            <a href="<?php echo $sort_article_date_added; ?>"><?php echo $column_article_date_added; ?></a>
                            <?php } ?>
                        </td>
                        <td class="left">
                            <?php if ($sort == 'name') { ?>
                            <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
                            <?php } else { ?>
                            <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
                            <?php } ?>
                        </td>
                        <td class="right"><?php if ($sort == 'sort_order') { ?>
                            <a href="<?php echo $sort_sort_order; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_sort_order; ?></a>
                            <?php } else { ?>
                            <a href="<?php echo $sort_sort_order; ?>"><?php echo $column_sort_order; ?></a>
                            <?php } ?>
                        </td>
                        <td class="right"><?php if ($sort == 'article_status') { ?>
                            <a href="<?php echo $sort_article_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_sort_article_status; ?></a>
                            <?php } else { ?>
                            <a href="<?php echo $sort_article_status; ?>"><?php echo $column_sort_article_status; ?></a>
                            <?php } ?>
                        </td>
                        <td class="right"><?php echo $column_action; ?></td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if ($articles) { ?>
                    <?php foreach ($articles as $article) { ?>
                    <tr>
                        <td style="text-align: center;">
                            <?php if ($article['selected']) { ?>
                            <input type="checkbox" name="selected[]" value="<?php echo $article['article_id']; ?>" checked="checked" />
                            <?php } else { ?>
                            <input type="checkbox" name="selected[]" value="<?php echo $article['article_id']; ?>" />
                            <?php } ?>
                        </td>
                        <td class="left"><?php echo $article['article_date_added']; ?></td>
                        <td class="left"><?php echo $article['name']; ?></td>
                        <td class="right"><?php echo $article['sort_order']; ?></td>
                        <td class="right"><?php echo $article['article_status'] ? 'Включен' : 'Отключен'; ?></td>
                        <td class="right">
                            <?php foreach ($article['action'] as $action) { ?>
                            [ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
                            <?php } ?>
                        </td>
                    </tr>
                    <?php } ?>
                    <?php } else { ?>
                    <tr>
                        <td class="center" colspan="5"><?php echo $text_no_results; ?></td>
                    </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>
<?php echo $footer; ?>