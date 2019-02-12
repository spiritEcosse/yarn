<?php echo $header; ?><?php
if ($this->browser() !=  'ieO') {
?>
<script type="text/javascript">
if ($('head').html().indexOf('blog.css') < 0) {
	$('head').append('<link href="/ecosse/view/stylesheet/blog.css" type="text/css" rel="stylesheet">');
	$('head').append('<link href="http://fonts.googleapis.com/css?family=Open+Sans&subset=latin,cyrillic-ext,latin-ext" rel="stylesheet" type="text/css">');
 }
</script>
<?php }
else
{
?>
<!-- �� ��� ��� ���������� IE ������ ������? ��, ��... -->
<style>
<?php
 include (DIR_APPLICATION.'view/stylesheet/blog.css');
?>
</style>
<?php } ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>

<div style="margin:5px;">
<a href="<?php echo $url_blog; ?>" class="markbutton"><div style="float: left;"><img src="view/image/blog-icon-m.png" style="" ></div><div style="float: left; margin-left: 7px; margin-top: 3px; "><?php echo $url_blog_text; ?></div></a>
<a href="<?php echo $url_record; ?>" class="markbutton"><div style="float: left;"><img src="view/image/blog-rec-m.png"  style="" ></div><div style="float: left; margin-left: 7px; margin-top: 3px; "><?php echo $url_record_text; ?></div></a>
<a href="<?php echo $url_comment; ?>" class="markbutton"><div style="float: left;"><img src="view/image/blog-com-m.png"  style="" ></div><div style="float: left; margin-left: 7px; margin-top: 3px; "><?php echo $url_comment_text; ?></div></a>
<a href="<?php echo $url_back; ?>" class="markbutton"><div style="float: left;"><img src="view/image/blog-back-m.png"  style="" ></div><div style="float: left; margin-left: 7px; margin-top: 3px; "><?php echo $url_back_text; ?></div></a>
</div>

  <div class="box">
    <div class="heading">
      <h1><img src="view/image/blog.png" alt="" style="width: 24px; height: 24px;"/> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a>
      <a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a>
      </div>



    </div>
    <div class="content">
      <div id="tabs" class="htabs"><a href="#tab-general"><?php echo $tab_general; ?></a><a href="#tab-data"><?php echo $tab_data; ?></a><a href="#tab-design"><?php echo $tab_design; ?></a><a href="#tab-options"><?php echo $tab_options; ?></a></div>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <div id="tab-general">
          <div id="languages" class="htabs">
            <?php foreach ($languages as $language) { ?>
            <a href="#language<?php echo $language['language_id']; ?>"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a>
            <?php } ?>
          </div>
          <?php foreach ($languages as $language) { ?>
          <div id="language<?php echo $language['language_id']; ?>">
            <table class="form">
              <tr>
                <td><span class="required">*</span> <?php echo $entry_name; ?></td>
                <td><input type="text" name="blog_description[<?php echo $language['language_id']; ?>][name]" size="100" value="<?php echo isset($blog_description[$language['language_id']]) ? $blog_description[$language['language_id']]['name'] : ''; ?>" />
                  <?php if (isset($error_name[$language['language_id']])) { ?>
                  <span class="error"><?php echo $error_name[$language['language_id']]; ?></span>
                  <?php } ?></td>
              </tr>
              <tr>
                <td><?php echo $entry_meta_description; ?></td>
                <td><textarea name="blog_description[<?php echo $language['language_id']; ?>][meta_description]" cols="40" rows="5"><?php echo isset($blog_description[$language['language_id']]) ? $blog_description[$language['language_id']]['meta_description'] : ''; ?></textarea></td>
              </tr>
              <tr>
                <td><?php echo $entry_meta_keyword; ?></td>
                <td><textarea name="blog_description[<?php echo $language['language_id']; ?>][meta_keyword]" cols="40" rows="5"><?php echo isset($blog_description[$language['language_id']]) ? $blog_description[$language['language_id']]['meta_keyword'] : ''; ?></textarea></td>
              </tr>
              <tr>
                <td><?php echo $entry_description; ?></td>
                <td><textarea name="blog_description[<?php echo $language['language_id']; ?>][description]" id="description<?php echo $language['language_id']; ?>"><?php echo isset($blog_description[$language['language_id']]) ? $blog_description[$language['language_id']]['description'] : ''; ?></textarea></td>
              </tr>
            </table>
          </div>
          <?php } ?>
        </div>
        <div id="tab-data">
          <table class="form">
            <tr>
              <td><?php echo $entry_parent; ?></td>
              <td><select name="parent_id">
                  <option value="0"><?php echo $text_none; ?></option>
                  <?php foreach ($categories as $blog) { ?>
                  <?php if ($blog['blog_id'] == $parent_id) { ?>
                  <option value="<?php echo $blog['blog_id']; ?>" selected="selected"><?php echo $blog['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $blog['blog_id']; ?>"><?php echo $blog['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select></td>
            </tr>
            <tr>
              <td><?php echo $entry_store; ?></td>
              <td><div class="scrollbox">
                  <?php $class = 'even'; ?>
                  <div class="<?php echo $class; ?>">
                    <?php if (in_array(0, $blog_store)) { ?>
                    <input type="checkbox" name="blog_store[]" value="0" checked="checked" />
                    <?php echo $text_default; ?>
                    <?php } else { ?>
                    <input type="checkbox" name="blog_store[]" value="0" />
                    <?php echo $text_default; ?>
                    <?php } ?>
                  </div>
                  <?php foreach ($stores as $store) { ?>
                  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                  <div class="<?php echo $class; ?>">
                    <?php if (in_array($store['store_id'], $blog_store)) { ?>
                    <input type="checkbox" name="blog_store[]" value="<?php echo $store['store_id']; ?>" checked="checked" />
                    <?php echo $store['name']; ?>
                    <?php } else { ?>
                    <input type="checkbox" name="blog_store[]" value="<?php echo $store['store_id']; ?>" />
                    <?php echo $store['name']; ?>
                    <?php } ?>
                  </div>
                  <?php } ?>
                </div></td>
            </tr>
            <tr>
              <td><?php echo $entry_keyword; ?></td>
              <td><input type="text" name="keyword" value="<?php echo $keyword; ?>" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_image; ?></td>
              <td valign="top"><div class="image"><img src="<?php echo $thumb; ?>" alt="" id="thumb" />
                <input type="hidden" name="image" value="<?php echo $image; ?>" id="image" />
                <br /><a onclick="image_upload('image', 'thumb');"><?php echo $text_browse; ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a onclick="$('#thumb').attr('src', '<?php echo $no_image; ?>'); $('#image').attr('value', '');"><?php echo $text_clear; ?></a></div></td>
            </tr>
            <tr>
              <td><?php echo $entry_sort_order; ?></td>
              <td><input type="text" name="sort_order" value="<?php echo $sort_order; ?>" size="1" /></td>
            </tr>

            <tr>
                <td><?php echo $entry_customer_group; ?></td>
                <td>
                  <select name="customer_group_id">
                    <?php foreach ($customer_groups as $customer_group) { ?>
                    <?php if ($customer_group['customer_group_id'] == $customer_group_id) { ?>
                    <option value="<?php echo $customer_group['customer_group_id']; ?>" selected="selected"><?php echo $customer_group['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </td>
             </tr>




            <tr>
              <td><?php echo $entry_status; ?></td>
              <td><select name="status">
                  <?php if ($status) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select></td>
            </tr>
          </table>
        </div>
        <div id="tab-design">

        <table class="list">
            <thead>
              <tr>
                <td class="left"><?php echo $entry_store; ?></td>
                <td class="left"><?php echo $entry_layout; ?></td>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="left"><?php echo $text_default; ?></td>
                <td class="left"><select name="blog_layout[0][layout_id]">
                    <option value=""></option>
                    <?php foreach ($layouts as $layout) { ?>
                    <?php if (isset($blog_layout[0]) && $blog_layout[0] == $layout['layout_id']) { ?>
                    <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select></td>
              </tr>
            </tbody>
            <?php foreach ($stores as $store) { ?>
            <tbody>
              <tr>
                <td class="left"><?php echo $store['name']; ?></td>
                <td class="left"><select name="blog_layout[<?php echo $store['store_id']; ?>][layout_id]">
                    <option value=""></option>
                    <?php foreach ($layouts as $layout) { ?>
                    <?php if (isset($blog_layout[$store['store_id']]) && $blog_layout[$store['store_id']] == $layout['layout_id']) { ?>
                    <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select></td>
              </tr>
            </tbody>
            <?php } ?>
          </table>
        </div>


        <div id="tab-options">

   <table class="mynotable" style="margin-bottom:20px; background: white; vertical-align: center;">

    <tr>
     <td class="left"><?php echo $entry_small_dim; ?></td>
     <td class="left">
      <input type="text" name="blog_design[blog_small][width]" value="<?php if (isset($blog_design['blog_small']['width'])) echo $blog_design['blog_small']['width']; ?>" size="3" />x
      <input type="text" name="blog_design[blog_small][height]" value="<?php if (isset($blog_design['blog_small']['height'])) echo $blog_design['blog_small']['height']; ?>" size="3" />
     </td>
    </tr>

    <tr>
     <td class="left"><?php echo $entry_big_dim; ?></td>
     <td class="left">
      <input type="text" name="blog_design[blog_big][width]" value="<?php  if (isset($blog_design['blog_big']['width'])) echo $blog_design['blog_big']['width']; ?>" size="3" />x
      <input type="text" name="blog_design[blog_big][height]" value="<?php if (isset($blog_design['blog_big']['height'])) echo $blog_design['blog_big']['height']; ?>" size="3" />
     </td>
    </tr>

    <tr>
     <td class="left"><?php echo $entry_blog_num_records; ?></td>
     <td class="left">
      <input type="text" name="blog_design[blog_num_records]" value="<?php  if (isset($blog_design['blog_num_records'])) echo $blog_design['blog_num_records']; ?>" size="3" />
     </td>
    </tr>

    <tr>
     <td class="left"><?php echo $entry_blog_num_comments; ?></td>
     <td class="left">
      <input type="text" name="blog_design[blog_num_comments]" value="<?php  if (isset($blog_design['blog_num_comments'])) echo $blog_design['blog_num_comments']; ?>" size="3" />
     </td>
    </tr>

    <tr>
     <td class="left"><?php echo $entry_blog_num_desc; ?></td>
     <td class="left">
      <input type="text" name="blog_design[blog_num_desc]" value="<?php  if (isset($blog_design['blog_num_desc'])) echo $blog_design['blog_num_desc']; ?>" size="3" />
     </td>
    </tr>

    <tr>
     <td class="left"><?php echo $entry_blog_num_desc_words; ?></td>
     <td class="left">
      <input type="text" name="blog_design[blog_num_desc_words]" value="<?php  if (isset($blog_design['blog_num_desc_words'])) echo $blog_design['blog_num_desc_words']; ?>" size="3" />
     </td>
    </tr>

    <tr>
     <td class="left"><?php echo $entry_blog_num_desc_pred; ?></td>
     <td class="left">
      <input type="text" name="blog_design[blog_num_desc_pred]" value="<?php  if (isset($blog_design['blog_num_desc_pred'])) echo $blog_design['blog_num_desc_pred']; ?>" size="3" />
     </td>
    </tr>

    <tr>
     <td class="left"><?php echo $entry_blog_template; ?></td>
     <td class="left">
      <input type="text" name="blog_design[blog_template]" value="<?php  if (isset($blog_design['blog_template'])) echo $blog_design['blog_template']; ?>" size="50" />
     </td>
    </tr>

    <tr>
     <td class="left"><?php echo $entry_blog_template_record; ?></td>
     <td class="left">
      <input type="text" name="blog_design[blog_template_record]" value="<?php  if (isset($blog_design['blog_template_record'])) echo $blog_design['blog_template_record']; ?>" size="50" />
     </td>
    </tr>

      <tr>
     <td class="left"><?php echo  $this->language->get('entry_blog_template_comment'); ?></td>
     <td class="left">
      <input type="text" name="blog_design[blog_template_comment]" value="<?php  if (isset($blog_design['blog_template_comment'])) echo $blog_design['blog_template_comment']; ?>" size="50" />
     </td>
    </tr>

            <tr>
              <td><?php echo $entry_devider; ?></td>
              <td><?php
              if (!isset($blog_design['blog_devider'])) $blog_design['blog_devider']=1;
              if ($blog_design['blog_devider']==1)  { ?>
                <input type="radio" name="blog_design[blog_devider]" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <input type="radio" name="blog_design[blog_devider]" value="0" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="blog_design[blog_devider]" value="1" />
                <?php echo $text_yes; ?>
                <input type="radio" name="blog_design[blog_devider]" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } ?></td>
            </tr>


            <tr>
              <td><?php echo $entry_short_path; ?></td>
              <td><?php if (isset($blog_design['blog_short_path']) && $blog_design['blog_short_path']==1)  { ?>
                <input type="radio" name="blog_design[blog_short_path]" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <input type="radio" name="blog_design[blog_short_path]" value="0" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="blog_design[blog_short_path]" value="1" />
                <?php echo $text_yes; ?>
                <input type="radio" name="blog_design[blog_short_path]" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } ?></td>
            </tr>


    <tr>
     <td></td>
     <td></td>
    </tr>









   </table>

      </div>



      </form>
    </div>
  </div>
</div>
<script type="text/javascript" src="view/javascript/ckeditor/ckeditor.js"></script>
<script type="text/javascript"><!--
<?php foreach ($languages as $language) { ?>
CKEDITOR.replace('description<?php echo $language['language_id']; ?>', {
	filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>'
});
<?php } ?>
//--></script>
<script type="text/javascript"><!--
function image_upload(field, thumb) {
	$('#dialog').remove();

	$('#content').prepend('<div id="dialog" style="padding: 3px 0px 0px 0px;"><iframe src="index.php?route=common/filemanager&token=<?php echo $token; ?>&field=' + encodeURIComponent(field) + '" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe></div>');

	$('#dialog').dialog({
		title: '<?php echo $text_image_manager; ?>',
		close: function (event, ui) {
			if ($('#' + field).attr('value')) {
				$.ajax({
					url: 'index.php?route=common/filemanager/image&token=<?php echo $token; ?>&image=' + encodeURIComponent($('#' + field).val()),
					dataType: 'text',
					success: function(data) {
						$('#' + thumb).replaceWith('<img src="' + data + '" alt="" id="' + thumb + '" />');
					}
				});
			}
		},
		bgiframe: false,
		width: 800,
		height: 400,
		resizable: false,
		modal: false
	});
};
//--></script>
<script type="text/javascript"><!--
$('#tabs a').tabs();
$('#languages a').tabs();
//--></script>
<?php echo $footer; ?>