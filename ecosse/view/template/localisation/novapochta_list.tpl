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
            <h1><img src="view/image/country.png" alt="" /> <?php echo $heading_title_depart; ?></h1>
            <div class="buttons"><a href="<?php echo $insert; ?>" class="button"><?php echo $button_insert; ?></a><a onclick="$('form').submit();" class="button"><?php echo $button_delete; ?></a></div>
        </div>
        <div class="content">
            <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
                <table class="list">
                    <thead>
                    <tr>
                        <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
                        <td class="left">
                            <?php if ($sort == 'title_country') { ?>
                            <a href="<?php echo $sort_title_country; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_title_country; ?></a>
                            <?php } else { ?>
                            <a href="<?php echo $sort_title_country; ?>"><?php echo $column_title_country; ?></a>
                            <?php } ?>
                        </td>
                        <td class="left">
                            <?php if ($sort == 'title_zone') { ?>
                            <a href="<?php echo $sort_title_zone; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_title_zone; ?></a>
                            <?php } else { ?>
                            <a href="<?php echo $sort_title_zone; ?>"><?php echo $column_title_zone; ?></a>
                            <?php } ?>
                        </td>
                        <td class="left">
                            <?php if ($sort == 'title_city') { ?>
                            <a href="<?php echo $sort_title_city; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_title_city; ?></a>
                            <?php } else { ?>
                            <a href="<?php echo $sort_title_city; ?>"><?php echo $column_title_city; ?></a>
                            <?php } ?>
                        </td>
                        <td class="left">
                            <?php if ($sort == 'title_depart') { ?>
                            <a href="<?php echo $sort_title_depart; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_title_depart; ?></a>
                            <?php } else { ?>
                            <a href="<?php echo $sort_title_depart; ?>"><?php echo $column_title_depart; ?></a>
                            <?php } ?>
                        </td>
                        <td class="right"><?php echo $column_action; ?></td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if ($departs) { ?>
                    <?php foreach ($departs as $depart) { ?>
                    <tr>
                        <td style="text-align: center;"><?php if ($depart['selected']) { ?>
                            <input type="checkbox" name="selected[]" value="<?php echo $depart['depart_id']; ?>" checked="checked" />
                            <?php } else { ?>
                            <input type="checkbox" name="selected[]" value="<?php echo $depart['depart_id']; ?>" />
                            <?php } ?>
                        </td>
                        <td class="left"><?php echo $depart['title_country']; ?></td>
                        <td class="left"><?php echo $depart['title_zone']; ?></td>
                        <td class="left"><?php echo $depart['title_city']; ?></td>
                        <td class="left"><?php echo $depart['title_depart']; ?></td>
                        <td class="right">
                            <?php foreach ($depart['action'] as $action) { ?>
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
            <div class="pagination"><?php echo $pagination; ?></div>
        </div>
    </div>
</div>
<?php echo $footer; ?>