<div id="blog-menu_top_source" style="display: none ;">
	<ul class="secondary">
		<?php if (count($myblogs) > 0) { ?>
			<?php foreach ($myblogs as $blogs) { ?>
				<?php for ($i = 0; $i < $blogs['flag_start']; $i++) { ?>
					<li><a href="<?php if ($blogs['active'] == 'active') echo $blogs['href'] . "#"; else echo $blogs['href'];?>" class="<?php if ($blogs['active'] == 'active') echo 'active'; if ($blogs['active'] == 'pass')	echo 'pass'; ?>">
					<?php echo $blogs['name'];	if ($blogs['count'] > 0) echo " (" . $blogs['count'] . ")"; ?></a>
					
					<?php if ($i >= $blogs['flag_end']) { ?>
						<ul>
					<?php } ?>

					<?php for ($m = 0; $m < $blogs['flag_end']; $m++) { ?>
						</li>
						<?php if ($blogs['flag_start'] <= $m) { ?>
							</ul>
						<?php } ?>
					<?php } ?>
				<?php } ?>
			<?php } ?>
		<?php } ?>
	</ul>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		var blog_menu = $('#blog-menu_top_source').html();
		$('#blog-menu_top').append(blog_menu);
	});
</script>