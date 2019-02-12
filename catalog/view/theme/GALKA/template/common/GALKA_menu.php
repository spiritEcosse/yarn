<?php function getSubCategories($categories, $class_ul, $class_li, $main_name = null, $description = null, $catCustomTop = null, $catCustomBottom = null, $picCat = null) { ?>
	<?php if ($categories) { ?>
		<ul class="<?php echo $class_ul; ?>">

		<?php if ($catCustomTop != null) { ?>
			<span class="cat_custom_top"><?php echo $catCustomTop; ?></span>
		<?php } ?>

		<?php if ($main_name != null || $picCat != null || $description != null) { ?>
			<span class="cat_preview">
				<?php if ($main_name != null) { ?>
					<h3><?php echo $main_name; ?></h3>

					<?php if ($picCat != null) { ?>
						<img src="<?php echo $picCat; ?>" alt="<?php echo $main_name; ?>" title="<?php echo $main_name; ?>"/>
					<?php } ?>
				<?php } ?>

				<?php if ($description != null && !empty($description)) { ?>
					<p><?php echo mb_substr(strip_tags($description), 0, 200); ?>...</p>
				<?php } ?>
			</span>
		<?php } ?>
	<?php } ?>

	<?php foreach ($categories as $category) { ?>
		<li class="<?php echo $class_li; ?>">
			<a href="<?php echo $category['href']; ?>">
				<span>
					<?php echo $category['name']; ?>
				</span>
			</a>

			<?php getSubCategories($category['children'], 'children2', 'sub_subcat'); ?>
		</li>
	<?php } ?>

	<?php if ($categories) { ?>
		<?php if ($catCustomBottom != null) { ?>
			<span class="cat_custom_bottom"><?php echo $catCustomBottom; ?></span>
		<?php } ?>

		</ul>
	<?php } ?>
<?php } ?>

<?php if ($categories) { ?>
	<ul id="topnav">
		<li class="home top_cat">
			<a href="<?php echo $base; ?>" class="home_link"><?php echo $text_home; ?></a>
		</li>
<?php } ?>

<?php foreach ($categories as $category) { ?>
	<li class="top_cat">
	    <a
	    <?php if ($category['color_text'] != '') { ?>
	    	style="color:<?php echo $category['color_text']; ?>"
	    <?php } ?>
	    href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a>
	    <?php $picCat = null; ?>

		<?php if ($category['image']) { ?>
	    	<?php $picCat = $this->model_tool_image->resize($category['image'], $this->config->get('config_image_category_width'), $this->config->get('config_image_category_height')); ?>
	    <?php } ?>

		<?php if ($category['drop_down'] == 1) { ?>
			<?php getSubCategories($category['children'], 'children', 'subcat', $category['name'], $category['description'], $catCustomTop, $catCustomBottom, $picCat); ?>
		<?php } ?>
	</li>
<?php } ?>

<?php if ($this->config->get('GALKAControl_specials_link') == 1) { ?>
	<li class="top_cat"><a href="<?php echo $special; ?>"><?php echo $text_special; ?></a></li>
<?php } ?>

<?php if ($brands) { ?>
	<li class="top_cat">
	<a href="<?php echo $brand; ?>"><?php echo $text_brands; ?></a>
	<span>
	<ul class="children children_brands">
	<span class="brand_custom_top"><?php echo $brandCustomTop; ?></span>

	<?php foreach ($brands as $brand) { ?>
		<li style="width:<?php echo $config_image_manufacturer_menu_width; ?>px;">
			<a href="<?php echo $brand['href']; ?>" style="height:<?php echo $config_image_manufacturer_menu_height + 2; ?>px;">
				<img src="<?php echo $brand['image']; ?>" alt="<?php echo $brand['name']; ?>" title="<?php echo $brand['name']; ?>"/>
				<div><span style="height:<?php echo $config_image_manufacturer_menu_height; ?>px;"><?php echo $brand['name']; ?></span></div>
			</a>
		</li>
	<?php } ?>

	<span class="brand_custom_bottom"><?php echo $brandCustomBottom; ?></span>
	</ul>
	</span>
	</li>
<?php } ?>

<?php foreach ($custom_menu as $menu) { ?>
	<li class="custom_link_one top_cat">

	<?php if ($menu['href']) { ?>
		<a href="<?php echo $menu['href']; ?>">
			<?php echo $menu['name']; ?>
		</a>
	<?php } else { ?>
		<a><?php echo $menu['name']; ?></a>
	<?php } ?>

	<?php if ($menu['desc'] != null) { ?>
		<div class="children"><?php echo $menu['desc']; ?></div>
	<?php } ?>

	</li>
<?php } ?>

<?php if ($categories) { ?>
	</ul>
<?php } ?>
