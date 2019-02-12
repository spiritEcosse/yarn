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
    <div class="box">
        <div class="heading">
            <h1><img src="view/image/information.png" alt="" /> <?php echo $heading_title; ?></h1>
            <div class="buttons">
                <a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a>
                <a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a>
            </div>
        </div>
        <div class="content">
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
                <table class="form">
                    <tr>
                        <td><span class="required">*</span> <?php echo $entry_name; ?></td>
                        <td>
                            <span class="error"><?php echo $error_name; ?></span>
                            <input type="text" name="name" value="<?php if ($name) { echo $name; } ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="required">*</span> Ссылка
                        </td>
                        <td>
                            <span class="error"><?php echo $error_video_link; ?></span>
                            <input type="text" size="100" name="video_link" value="<?php if ($video_link) { echo $video_link; } ?>" >
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $entry_sort_order; ?></td>
                        <td><input type="text" name="sort_order" value="<?php echo $sort_order; ?>" size="1" /></td>
                    </tr>
                    <tr>
                        <td><?php echo $entry_main_category; ?></td>
                        <td>
                            <select name="main_category_video_id">
                                <option value="0" selected="selected"><?php echo $text_none; ?></option>
                                <?php foreach ($categories as $category) { ?>
                                    <?php if ($category['category_video_id'] == $main_category_video_id) { ?>
                                        <option value="<?php echo $category['category_video_id']; ?>" selected="selected"><?php echo $category['name']; ?></option>
                                    <?php } else { ?>
                                        <option value="<?php echo $category['category_video_id']; ?>"><?php echo $category['name']; ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $entry_description; ?></td>
                        <td>
                            <textarea name="video_description" id="description">
                                <?php echo isset($video_description) ? $video_description : ''; ?>
                            </textarea>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $entry_category; ?></td>
                        <td class="scroll">
                            <div class="scrollbox">
                                <?php $class = 'odd'; ?>

                                <?php foreach ($categories as $category) { ?>
                                    <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>

                                    <div class="<?php echo $class; ?>">
                                        <?php if (in_array($category['category_video_id'], $video_category)) { ?>
                                            <input type="checkbox" name="video_category[]" value="<?php echo $category['category_video_id']; ?>" checked="checked" />
                                        <?php echo $category['name']; ?>
                                            <?php } else { ?>
                                            <input type="checkbox" name="video_category[]" value="<?php echo $category['category_video_id']; ?>" />
                                            <?php echo $category['name']; ?>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                            </div>
                            <a onclick="$(this).parent().find(':checkbox').attr('checked', true);"><?php echo $text_select_all; ?></a> / <a onclick="$(this).parent().find(':checkbox').attr('checked', false);"><?php echo $text_unselect_all; ?></a>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $entry_status; ?></td>
                        <td>
                            <select name="video_status">
                                <option value="0"><?php echo $text_no; ?></option>
                                <option value="1"

                                <?php if ($video_status == 1) { ?>
                                    selected="selected"
                                <?php } ?>

                                ><?php echo $text_yes; ?></option>
                            </select>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>
<?php echo $footer; ?>

<script type="text/javascript" src="view/javascript/ckeditor/ckeditor.js"></script>

<?php $token = $_GET['token']; ?>

<script type="text/javascript">
    CKEDITOR.replace('description', {
    filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
    filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
    filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
    filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
    filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
    filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>'
    });
</script>