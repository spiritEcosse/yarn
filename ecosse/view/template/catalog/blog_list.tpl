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

  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <?php if ($success) { ?>
  <div class="success"><?php echo $success; ?></div>
  <?php } ?>

<div style="margin:5px;">
<a href="<?php echo $url_blog; ?>" class="markbutton"><div style="float: left;"><img src="view/image/blog-icon-m.png" style="" ></div><div style="float: left; margin-left: 7px; margin-top: 3px; "><?php echo $url_blog_text; ?></div></a>
<a href="<?php echo $url_record; ?>" class="markbutton"><div style="float: left;"><img src="view/image/blog-rec-m.png"  style="" ></div><div style="float: left; margin-left: 7px; margin-top: 3px; "><?php echo $url_record_text; ?></div></a>
<a href="<?php echo $url_comment; ?>" class="markbutton"><div style="float: left;"><img src="view/image/blog-com-m.png"  style="" ></div><div style="float: left; margin-left: 7px; margin-top: 3px; "><?php echo $url_comment_text; ?></div></a>
<a href="<?php echo $url_back; ?>" class="markbutton"><div style="float: left;"><img src="view/image/blog-back-m.png"  style="" ></div><div style="float: left; margin-left: 7px; margin-top: 3px; "><?php echo $url_back_text; ?></div></a>
</div>

  <div class="box">
    <div class="heading">
      <h1><img src="view/image/blog-icon.png" style="height: 21px;" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="location = '<?php echo $insert; ?>'" class="button"><?php echo $button_insert; ?></a>
      <a onclick="$('#form').submit();" class="button"><?php echo $button_delete; ?></a>

      </div>
    </div>
    <div class="content">
      <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="mytable">
          <thead>
            <tr>
              <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
              <td class="left"><?php echo $column_name; ?></td>
              <td class="right"><?php echo $column_sort_order; ?></td>
              <td class="right"><?php echo $column_action; ?></td>
            </tr>
          </thead>
          <tbody>
            <?php if ($categories) { ?>
            <?php foreach ($categories as $blog) { ?>
            <tr>
              <td style="text-align: center;"><?php if ($blog['selected']) { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $blog['blog_id']; ?>" checked="checked" />
                <?php } else { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $blog['blog_id']; ?>" />
                <?php } ?></td>
              <td class="left"><?php echo $blog['name']; ?></td>
              <td class="right"><?php echo $blog['sort_order']; ?></td>
              <td class="right"><?php foreach ($blog['action'] as $action) { ?>
                <a href="<?php echo $action['href']; ?>"  class="markbuttono"><?php echo $action['text']; ?></a>
                <?php } ?></td>
            </tr>
            <?php } ?>
            <?php } else { ?>
            <tr>
              <td class="center" colspan="4"><?php echo $text_no_results; ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </form>
    </div>
  </div>
</div>
<?php echo $footer; ?>