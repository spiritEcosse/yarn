<?php
class ControllerCatalogBlog extends Controller
{
	private $error = array();
	public function index()
	{
		$this->load->language('catalog/blog');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('catalog/blog');
		$this->getList();
	}
	public function insert()
	{
		$this->load->language('catalog/blog');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('catalog/blog');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_blog->addBlog($this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');
			$this->redirect($this->url->link('catalog/blog', 'token=' . $this->session->data['token'], 'SSL'));
		}
		$this->getForm();
	}
	public function update()
	{
		$this->load->language('catalog/blog');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('catalog/blog');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_blog->editBlog($this->request->get['blog_id'], $this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');
			$this->redirect($this->url->link('catalog/blog', 'token=' . $this->session->data['token'], 'SSL'));
		}
		$this->getForm();
	}
	public function delete()
	{
		$this->load->language('catalog/blog');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('catalog/blog');
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $blog_id) {
				$this->model_catalog_blog->deleteBlog($blog_id);
			}
			$this->session->data['success'] = $this->language->get('text_success');
			$this->redirect($this->url->link('catalog/blog', 'token=' . $this->session->data['token'], 'SSL'));
		}
		$this->getList();
	}
	private function getList()
	{
		$this->data['url_back']      = $this->url->link('module/blog', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_back_text'] = $this->language->get('url_back_text');
		$this->data['breadcrumbs']   = array();
		$this->data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);
		$this->data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('catalog/blog', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);
		$this->data['insert']        = $this->url->link('catalog/blog/insert', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['delete']        = $this->url->link('catalog/blog/delete', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['categories']    = array();
		$results                     = $this->model_catalog_blog->getCategories(0);
		foreach ($results as $result) {
			$action                     = array();
			$action[]                   = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('catalog/blog/update', 'token=' . $this->session->data['token'] . '&blog_id=' . $result['blog_id'], 'SSL')
			);
			$this->data['categories'][] = array(
				'blog_id' => $result['blog_id'],
				'name' => $result['name'],
				'sort_order' => $result['sort_order'],
				'selected' => isset($this->request->post['selected']) && in_array($result['blog_id'], $this->request->post['selected']),
				'action' => $action
			);
		}
		$this->data['heading_title']     = $this->language->get('heading_title');
		$this->data['text_no_results']   = $this->language->get('text_no_results');
		$this->data['column_name']       = $this->language->get('column_name');
		$this->data['column_sort_order'] = $this->language->get('column_sort_order');
		$this->data['column_action']     = $this->language->get('column_action');
		$this->data['button_insert']     = $this->language->get('button_insert');
		$this->data['button_delete']     = $this->language->get('button_delete');
		$this->data['url_blog']          = $this->url->link('catalog/blog', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_record']        = $this->url->link('catalog/record', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_comment']       = $this->url->link('catalog/comment', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_blog_text']     = $this->language->get('url_blog_text');
		$this->data['url_record_text']   = $this->language->get('url_record_text');
		$this->data['url_comment_text']  = $this->language->get('url_comment_text');
		$this->data['url_create_text']   = $this->language->get('url_create_text');
		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
		$this->template = 'catalog/blog_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
		$this->response->setOutput($this->render());
	}
	private function getForm()
	{
		$this->data['heading_title']              = $this->language->get('heading_title');
		$this->data['url_back_text']              = $this->language->get('url_back_text');
		$this->data['text_none']                  = $this->language->get('text_none');
		$this->data['text_default']               = $this->language->get('text_default');
		$this->data['text_image_manager']         = $this->language->get('text_image_manager');
		$this->data['text_browse']                = $this->language->get('text_browse');
		$this->data['text_clear']                 = $this->language->get('text_clear');
		$this->data['text_enabled']               = $this->language->get('text_enabled');
		$this->data['text_disabled']              = $this->language->get('text_disabled');
		$this->data['text_percent']               = $this->language->get('text_percent');
		$this->data['text_amount']                = $this->language->get('text_amount');
		$this->data['text_yes']                   = $this->language->get('text_yes');
		$this->data['text_no']                    = $this->language->get('text_no');
		$this->data['entry_name']                 = $this->language->get('entry_name');
        $this->data['entry_customer_group'] = $this->language->get('entry_customer_group');
		$this->data['entry_short_path']           = $this->language->get('entry_short_path');
		$this->data['entry_meta_keyword']         = $this->language->get('entry_meta_keyword');
		$this->data['entry_meta_description']     = $this->language->get('entry_meta_description');
		$this->data['entry_description']          = $this->language->get('entry_description');
		$this->data['entry_store']                = $this->language->get('entry_store');
		$this->data['entry_keyword']              = $this->language->get('entry_keyword');
		$this->data['entry_parent']               = $this->language->get('entry_parent');
		$this->data['entry_image']                = $this->language->get('entry_image');
		$this->data['entry_top']                  = $this->language->get('entry_top');
		$this->data['entry_column']               = $this->language->get('entry_column');
		$this->data['entry_sort_order']           = $this->language->get('entry_sort_order');
		$this->data['entry_status']               = $this->language->get('entry_status');
		$this->data['entry_layout']               = $this->language->get('entry_layout');
		$this->data['button_save']                = $this->language->get('button_save');
		$this->data['button_cancel']              = $this->language->get('button_cancel');
		$this->data['tab_general']                = $this->language->get('tab_general');
		$this->data['tab_data']                   = $this->language->get('tab_data');
		$this->data['tab_design']                 = $this->language->get('tab_design');
		$this->data['tab_options']                = $this->language->get('tab_options');
		$this->data['url_back']                   = $this->url->link('module/blog', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_blog']                   = $this->url->link('catalog/blog', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_record']                 = $this->url->link('catalog/record', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_comment']                = $this->url->link('catalog/comment', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_blog_text']              = $this->language->get('url_blog_text');
		$this->data['url_record_text']            = $this->language->get('url_record_text');
		$this->data['url_comment_text']           = $this->language->get('url_comment_text');
		$this->data['url_create_text']            = $this->language->get('url_create_text');
		$this->data['entry_what']                 = $this->language->get('entry_what');
		$this->data['entry_small_dim']            = $this->language->get('entry_small_dim');
		$this->data['entry_big_dim']              = $this->language->get('entry_big_dim');
		$this->data['entry_blog_num_comments']    = $this->language->get('entry_blog_num_comments');
		$this->data['entry_blog_num_records']     = $this->language->get('entry_blog_num_records');
		$this->data['entry_blog_num_desc']        = $this->language->get('entry_blog_num_desc');
		$this->data['entry_blog_num_desc_words']  = $this->language->get('entry_blog_num_desc_words');
		$this->data['entry_blog_num_desc_pred']   = $this->language->get('entry_blog_num_desc_pred');
		$this->data['entry_blog_template']        = $this->language->get('entry_blog_template');
		$this->data['entry_blog_template_record'] = $this->language->get('entry_blog_template_record');
		$this->data['entry_devider']              = $this->language->get('entry_devider');
		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		if (isset($this->error['name'])) {
			$this->data['error_name'] = $this->error['name'];
		} else {
			$this->data['error_name'] = array();
		}
		$this->data['breadcrumbs']   = array();
		$this->data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);
		$this->data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('catalog/blog', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);
		if (!isset($this->request->get['blog_id'])) {
			$this->data['action'] = $this->url->link('catalog/blog/insert', 'token=' . $this->session->data['token'], 'SSL');
		} else {
			$this->data['action'] = $this->url->link('catalog/blog/update', 'token=' . $this->session->data['token'] . '&blog_id=' . $this->request->get['blog_id'], 'SSL');
		}
		$this->data['cancel'] = $this->url->link('catalog/blog', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['token']  = $this->session->data['token'];
		if (isset($this->request->get['blog_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$blog_info = $this->model_catalog_blog->getBlog($this->request->get['blog_id']);
		}
		$this->load->model('localisation/language');
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		if (isset($this->request->post['blog_description'])) {
			$this->data['blog_description'] = $this->request->post['blog_description'];
		} elseif (isset($this->request->get['blog_id'])) {
			$this->data['blog_description'] = $this->model_catalog_blog->getBlogDescriptions($this->request->get['blog_id']);
		} else {
			$this->data['blog_description'] = array();
		}
		$categories = $this->model_catalog_blog->getCategories(0);
		if (!empty($blog_info)) {
			foreach ($categories as $key => $blog) {
				if ($blog['blog_id'] == $blog_info['blog_id']) {
					unset($categories[$key]);
				}
			}
		}
		$this->data['categories'] = $categories;
		if (isset($this->request->post['parent_id'])) {
			$this->data['parent_id'] = $this->request->post['parent_id'];
		} elseif (!empty($blog_info)) {
			$this->data['parent_id'] = $blog_info['parent_id'];
		} else {
			$this->data['parent_id'] = 0;
		}
		$this->load->model('setting/store');
		$this->data['stores'] = $this->model_setting_store->getStores();
		if (isset($this->request->post['blog_store'])) {
			$this->data['blog_store'] = $this->request->post['blog_store'];
		} elseif (isset($this->request->get['blog_id'])) {
			$this->data['blog_store'] = $this->model_catalog_blog->getBlogStores($this->request->get['blog_id']);
		} else {
			$this->data['blog_store'] = array(
				0
			);
		}
		if (isset($this->request->post['keyword'])) {
			$this->data['keyword'] = $this->request->post['keyword'];
		} elseif (!empty($blog_info)) {
			$this->data['keyword'] = $blog_info['keyword'];
		} else {
			$this->data['keyword'] = '';
		}
		if (isset($this->request->post['image'])) {
			$this->data['image'] = $this->request->post['image'];
		} elseif (!empty($blog_info)) {
			$this->data['image'] = $blog_info['image'];
		} else {
			$this->data['image'] = '';
		}
		$this->load->model('tool/image');
		if (!empty($blog_info) && $blog_info['image'] && file_exists(DIR_IMAGE . $blog_info['image'])) {
			$this->data['thumb'] = $this->model_tool_image->resize($blog_info['image'], 100, 100);
		} else {
			$this->data['thumb'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}
		$this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		if (isset($this->request->post['top'])) {
			$this->data['top'] = $this->request->post['top'];
		} elseif (!empty($blog_info)) {
			$this->data['top'] = $blog_info['top'];
		} else {
			$this->data['top'] = 0;
		}
		if (isset($this->request->post['column'])) {
			$this->data['column'] = $this->request->post['column'];
		} elseif (!empty($blog_info)) {
			$this->data['column'] = $blog_info['column'];
		} else {
			$this->data['column'] = 1;
		}
		if (isset($this->request->post['sort_order'])) {
			$this->data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($blog_info)) {
			$this->data['sort_order'] = $blog_info['sort_order'];
		} else {
			$this->data['sort_order'] = '';
		}
		if (isset($this->request->post['status'])) {
			$this->data['status'] = $this->request->post['status'];
		} elseif (!empty($blog_info)) {
			$this->data['status'] = $blog_info['status'];
		} else {
			$this->data['status'] = 1;
		}
        $this->load->model('sale/customer_group');
		$this->data['customer_groups'] = $this->model_sale_customer_group->getCustomerGroups();
		if (isset($this->request->post['customer_group_id'])) {
			$this->data['customer_group_id'] = $this->request->post['customer_group_id'];
		} elseif (!empty($blog_info) && isset($blog_info['customer_group_id'])) {

			$this->data['customer_group_id'] = $blog_info['customer_group_id'];
		} else {
			$this->data['customer_group_id'] = (int)$this->config->get('config_customer_group_id');
		}
		if (isset($this->request->post['blog_design'])) {
			$this->data['blog_design'] = $this->request->post['blog_design'];
		} elseif (!empty($blog_info)) {
			if (isset($blog_info['design']))
				$this->data['blog_design'] = unserialize($blog_info['design']);
			else
				$this->data['blog_design'] = Array();
		} else {
			$this->data['blog_design'] = Array();
		}
		if (isset($this->request->post['blog_layout'])) {
			$this->data['blog_layout'] = $this->request->post['blog_layout'];
		} elseif (isset($this->request->get['blog_id'])) {
			$this->data['blog_layout'] = $this->model_catalog_blog->getBlogLayouts($this->request->get['blog_id']);
		} else {
			$this->data['blog_layout'] = array();
		}
		$this->load->model('design/layout');
		$this->data['layouts'] = $this->model_design_layout->getLayouts();
		$this->template        = 'catalog/blog_form.tpl';
		$this->children        = array(
			'common/header',
			'common/footer'
		);
		$this->response->setOutput($this->render());
	}
	private function validateForm()
	{
		if (!$this->user->hasPermission('modify', 'catalog/blog')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		foreach ($this->request->post['blog_description'] as $language_id => $value) {
			if ((utf8_strlen($value['name']) < 2) || (utf8_strlen($value['name']) > 255)) {
				$this->error['name'][$language_id] = $this->language->get('error_name');
			}
		}
		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
	private function validateDelete()
	{
		if (!$this->user->hasPermission('modify', 'catalog/blog')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
	public function browser()
	{
		$bra = 'ie';
		if (stristr($_SERVER['HTTP_USER_AGENT'], 'Firefox'))
			$bra = 'firefox';
		elseif (stristr($_SERVER['HTTP_USER_AGENT'], 'Chrome'))
			$bra = 'chrome';
		elseif (stristr($_SERVER['HTTP_USER_AGENT'], 'Safari'))
			$bra = 'safari';
		elseif (stristr($_SERVER['HTTP_USER_AGENT'], 'Opera'))
			$bra = 'opera';
		elseif (stristr($_SERVER['HTTP_USER_AGENT'], 'MSIE 6.0'))
			$bra = 'ieO';
		elseif (stristr($_SERVER['HTTP_USER_AGENT'], 'MSIE 7.0'))
			$bra = 'ieO';
		elseif (stristr($_SERVER['HTTP_USER_AGENT'], 'MSIE 8.0'))
			$bra = 'ieO';
		return $bra;
	}
	public function createTables()
	{
		$sql[0]  = "
CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "blog` (
  `blog_id` int(11) NOT NULL AUTO_INCREMENT,
  `image` varchar(255) COLLATE utf8_general_ci DEFAULT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `top` tinyint(1) NOT NULL,
  `column` int(3) NOT NULL,
  `sort_order` int(3) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`blog_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1;
";
		$sql[1]  = "
CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "blog_description` (
  `blog_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `description` text COLLATE utf8_general_ci NOT NULL,
  `meta_description` varchar(255) COLLATE utf8_general_ci NOT NULL,
  `meta_keyword` varchar(255) COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`blog_id`,`language_id`),
  KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
";
		$sql[2]  = "
CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "blog_to_layout` (
  `blog_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `layout_id` int(11) NOT NULL,
  PRIMARY KEY (`blog_id`,`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
";
		$sql[3]  = "
CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "blog_to_store` (
  `blog_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  PRIMARY KEY (`blog_id`,`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
";
		$sql[4]  = "
CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "comment` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `record_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `author` varchar(64) COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `text` text COLLATE utf8_general_ci NOT NULL,
  `rating` int(1) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`comment_id`),
  KEY `record_id` (`record_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1 ;
";
		$sql[5]  = "
CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "record` (
  `record_id` int(11) NOT NULL AUTO_INCREMENT,
  `model` varchar(64) COLLATE utf8_general_ci NOT NULL,
  `sku` varchar(64) COLLATE utf8_general_ci NOT NULL,
  `upc` varchar(12) COLLATE utf8_general_ci NOT NULL,
  `location` varchar(128) COLLATE utf8_general_ci NOT NULL,
  `quantity` int(4) NOT NULL DEFAULT '0',
  `stock_status_id` int(11) NOT NULL,
  `image` varchar(255) COLLATE utf8_general_ci DEFAULT NULL,
  `manufacturer_id` int(11) NOT NULL,
  `shipping` tinyint(1) NOT NULL DEFAULT '1',
  `price` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `points` int(8) NOT NULL DEFAULT '0',
  `tax_class_id` int(11) NOT NULL,
  `date_available` date NOT NULL,
  `weight` decimal(5,2) NOT NULL DEFAULT '0.00',
  `weight_class_id` int(11) NOT NULL DEFAULT '0',
  `length` decimal(5,2) NOT NULL DEFAULT '0.00',
  `width` decimal(5,2) NOT NULL DEFAULT '0.00',
  `height` decimal(5,2) NOT NULL DEFAULT '0.00',
  `length_class_id` int(11) NOT NULL DEFAULT '0',
  `subtract` tinyint(1) NOT NULL DEFAULT '1',
  `minimum` int(11) NOT NULL DEFAULT '1',
  `sort_order` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
   `comment` text COLLATE utf8_general_ci NOT NULL,
  `comment_status` tinyint(1) NOT NULL,
  `comment_status_reg` tinyint(1) NOT NULL,
  `comment_status_now` tinyint(1) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `viewed` int(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`record_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1 ;
";
		$sql[6]  = "
CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "record_attribute` (
  `record_id` int(11) NOT NULL,
  `attribute_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `text` text COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`record_id`,`attribute_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
";
		$sql[7]  = "
CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "record_description` (
  `record_id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_general_ci NOT NULL,
  `description` text COLLATE utf8_general_ci NOT NULL,
  `meta_description` varchar(255) COLLATE utf8_general_ci NOT NULL,
  `meta_keyword` varchar(255) COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`record_id`,`language_id`),
  KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1 ;
";
		$sql[8]  = "
CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "record_discount` (
  `record_discount_id` int(11) NOT NULL AUTO_INCREMENT,
  `record_id` int(11) NOT NULL,
  `customer_group_id` int(11) NOT NULL,
  `quantity` int(4) NOT NULL DEFAULT '0',
  `priority` int(5) NOT NULL DEFAULT '1',
  `price` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `date_start` date NOT NULL DEFAULT '0000-00-00',
  `date_end` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`record_discount_id`),
  KEY `record_id` (`record_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1 ;
";
		$sql[9]  = "
CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "record_image` (
  `record_image_id` int(11) NOT NULL AUTO_INCREMENT,
  `record_id` int(11) NOT NULL,
  `image` varchar(255) COLLATE utf8_general_ci DEFAULT NULL,
  `sort_order` int(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`record_image_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1 ;
";
		$sql[10] = "
CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "record_option` (
  `record_option_id` int(11) NOT NULL AUTO_INCREMENT,
  `record_id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL,
  `option_value` text COLLATE utf8_general_ci NOT NULL,
  `required` tinyint(1) NOT NULL,
  PRIMARY KEY (`record_option_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1 ;
";
		$sql[11] = "
CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "record_option_value` (
  `record_option_value_id` int(11) NOT NULL AUTO_INCREMENT,
  `record_option_id` int(11) NOT NULL,
  `record_id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL,
  `option_value_id` int(11) NOT NULL,
  `quantity` int(3) NOT NULL,
  `subtract` tinyint(1) NOT NULL,
  `price` decimal(15,4) NOT NULL,
  `price_prefix` varchar(1) COLLATE utf8_general_ci NOT NULL,
  `points` int(8) NOT NULL,
  `points_prefix` varchar(1) COLLATE utf8_general_ci NOT NULL,
  `weight` decimal(15,8) NOT NULL,
  `weight_prefix` varchar(1) COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`record_option_value_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1 ;
";
		$sql[12] = "
CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "record_related` (
  `record_id` int(11) NOT NULL,
  `related_id` int(11) NOT NULL,
  PRIMARY KEY (`record_id`,`related_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
";
		$sql[13] = "
CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "record_reward` (
  `record_reward_id` int(11) NOT NULL AUTO_INCREMENT,
  `record_id` int(11) NOT NULL DEFAULT '0',
  `customer_group_id` int(11) NOT NULL DEFAULT '0',
  `points` int(8) NOT NULL DEFAULT '0',
  PRIMARY KEY (`record_reward_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1 ;
";
		$sql[14] = "
CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "record_special` (
  `record_special_id` int(11) NOT NULL AUTO_INCREMENT,
  `record_id` int(11) NOT NULL,
  `customer_group_id` int(11) NOT NULL,
  `priority` int(5) NOT NULL DEFAULT '1',
  `price` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `date_start` date NOT NULL DEFAULT '0000-00-00',
  `date_end` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`record_special_id`),
  KEY `record_id` (`record_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1 ;
";
		$sql[15] = "
CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "record_tag` (
  `record_tag_id` int(11) NOT NULL AUTO_INCREMENT,
  `record_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `tag` varchar(32) COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`record_tag_id`),
  KEY `record_id` (`record_id`),
  KEY `language_id` (`language_id`),
  KEY `tag` (`tag`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1 ;
";
		$sql[16] = "
CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "record_to_blog` (
  `record_id` int(11) NOT NULL,
  `blog_id` int(11) NOT NULL,
  PRIMARY KEY (`record_id`,`blog_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
";
		$sql[17] = "
CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "record_to_download` (
  `record_id` int(11) NOT NULL,
  `download_id` int(11) NOT NULL,
  PRIMARY KEY (`record_id`,`download_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
";
		$sql[18] = "
CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "record_to_layout` (
  `record_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `layout_id` int(11) NOT NULL,
  PRIMARY KEY (`record_id`,`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
";
		$sql[19] = "
CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "record_to_store` (
  `record_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`record_id`,`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
";
		$sql[20] = "
CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "rate_comment` (
  `comment_id` int(11) unsigned NOT NULL,
  `customer_id` int(11) unsigned NOT NULL,
  `delta` float(9,3) DEFAULT '0.000',
  KEY `comment_id` (`comment_id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;
";
		$sql[21] = "
CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "record_product_related` (
  `record_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  PRIMARY KEY (`record_id`,`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
";
		$sql[22] = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "url_alias_blog` (
  `url_alias_id` int(11) NOT NULL AUTO_INCREMENT,
  `query` varchar(255) NOT NULL,
  `keyword` varchar(255) NOT NULL,
  PRIMARY KEY (`url_alias_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";

		$this->load->model('localisation/language');
		$languages = $this->model_localisation_language->getLanguages();

		foreach ($sql as $qsql) {
			$query = $this->db->query($qsql);
		}
		$r = mysql_query("SELECT `sorthex` FROM `" . DB_PREFIX . "comment` WHERE 0");
		if (!$r) {
			$msql  = "ALTER TABLE `" . DB_PREFIX . "comment` ADD `sorthex` VARCHAR( 255 ) CHARACTER SET ascii COLLATE ascii_bin NOT NULL AFTER `rating`";
			$query = $this->db->query($msql);
		}
		$r = mysql_query("SELECT `parent_id` FROM `" . DB_PREFIX . "comment` WHERE 0");
		if (!$r) {
			$msql  = "ALTER TABLE `" . DB_PREFIX . "comment` ADD `parent_id` INT(11) NOT NULL AFTER `record_id`";
			$query = $this->db->query($msql);
		}
		$r = mysql_query("SELECT `comment` FROM `" . DB_PREFIX . "record` WHERE 0");
		if (!$r) {
			$msql  = "ALTER TABLE `" . DB_PREFIX . "record` ADD `comment`  text COLLATE utf8_general_ci NOT NULL AFTER `status`";
			$query = $this->db->query($msql);
		}
		$r = mysql_query("SELECT `date_end` FROM `" . DB_PREFIX . "record` WHERE 0");
		if (!$r) {
			$msql  = "ALTER TABLE `" . DB_PREFIX . "record` ADD `date_end` DATETIME NOT NULL DEFAULT '2030-11-11 00:00:00' AFTER `date_available`";
			$query = $this->db->query($msql);
		}
		$r = mysql_query("SELECT `date_available` FROM `" . DB_PREFIX . "record` WHERE 0");
		if ($r) {
			$msql  = "ALTER TABLE `" . DB_PREFIX . "record` CHANGE `date_available` `date_available` DATETIME NOT NULL";
			$query = $this->db->query($msql);
		}
		$r = mysql_query("SELECT `sdescription` FROM `" . DB_PREFIX . "record_description` WHERE 0");
		if (!$r) {
			$msql  = "ALTER TABLE `" . DB_PREFIX . "record_description` ADD `sdescription` text COLLATE utf8_general_ci NOT NULL AFTER `name`";
			$query = $this->db->query($msql);
		}
		$r = mysql_query("SELECT `design` FROM `" . DB_PREFIX . "blog` WHERE 0");
		if (!$r) {
			$msql  = "ALTER TABLE `" . DB_PREFIX . "blog` ADD `design` text COLLATE utf8_general_ci NOT NULL AFTER `image`";
			$query = $this->db->query($msql);
		}

		$r = mysql_query("SELECT `customer_group_id` FROM `" . DB_PREFIX . "blog` WHERE 0");
		if (!$r) {
			$msql  = "ALTER TABLE `" . DB_PREFIX . "blog` ADD `customer_group_id` INT(2) NOT NULL AFTER `status`";
			$query = $this->db->query($msql);
			$msql  = "UPDATE `" . DB_PREFIX . "blog` SET `customer_group_id`=".(int)$this->config->get('config_customer_group_id')." ";
			$query = $this->db->query($msql);
		}

		$r = mysql_query("SELECT `customer_group_id` FROM `" . DB_PREFIX . "record` WHERE 0");
		if (!$r) {
			$msql  = "ALTER TABLE `" . DB_PREFIX . "record` ADD `customer_group_id` INT(2) NOT NULL AFTER `status`";
			$query = $this->db->query($msql);
			$msql  = "UPDATE `" . DB_PREFIX . "record` SET `customer_group_id`=".(int)$this->config->get('config_customer_group_id')." ";
			$query = $this->db->query($msql);
		}

		$msql  = "SELECT * FROM `" . DB_PREFIX . "layout` WHERE `name`='Blog';";
		$query = $this->db->query($msql);
		if (count($query->rows) <= 0) {
			$msql  = "INSERT INTO `" . DB_PREFIX . "layout` (`name`) VALUES  ('Blog');";
			$query = $this->db->query($msql);
			$msql  = "INSERT INTO `" . DB_PREFIX . "layout_route` (`route`, `layout_id`) VALUES  ('record/blog'," . mysql_insert_id() . ");";
			$query = $this->db->query($msql);
		}
		$msql  = "SELECT * FROM `" . DB_PREFIX . "layout` WHERE `name`='not_found';";
		$query = $this->db->query($msql);
		if (count($query->rows) <= 0) {
			$msql  = "INSERT INTO `" . DB_PREFIX . "layout` (`name`) VALUES  ('not_found');";
			$query = $this->db->query($msql);
			$not_found_id = mysql_insert_id();
			$msql  = "INSERT INTO `" . DB_PREFIX . "layout_route` (`route`, `layout_id`) VALUES  ('error/not_found'," .$not_found_id . ");";
			$query = $this->db->query($msql);
		}
		$msql  = "SELECT * FROM `" . DB_PREFIX . "layout` WHERE `name`='Record';";
		$query = $this->db->query($msql);
		if (count($query->rows) <= 0) {
			$msql  = "INSERT INTO `" . DB_PREFIX . "layout` (`name`) VALUES  ('Record');";
			$query = $this->db->query($msql);
			$msql  = "INSERT INTO `" . DB_PREFIX . "layout_route` (`route`, `layout_id`) VALUES  ('record/record'," . mysql_insert_id() . ");";
			$query = $this->db->query($msql);
		}
		$msql  = "SELECT * FROM `" . DB_PREFIX . "blog` LIMIT 1;";
		$query = $this->db->query($msql);
		if (count($query->rows) <= 0) {
			$msql  = "INSERT INTO `" . DB_PREFIX . "blog` (`blog_id`, `image`, `parent_id`, `top`, `column`, `sort_order`, `status`, `customer_group_id`, `date_added`, `date_modified`)
			VALUES (1, 'a:12:{s:10:\"blog_small\";a:2:{s:5:\"width\";s:0:\"\";s:6:\"height\";s:0:\"\";}s:8:\"blog_big\";a:2:{s:5:\"width\";s:0:\"\";s:6:\"height\";s:0:\"\";}s:16:\"blog_num_records\";s:0:\"\";s:17:\"blog_num_comments\";s:0:\"\";s:13:\"blog_num_desc\";s:0:\"\";s:19:\"blog_num_desc_words\";s:0:\"\";s:18:\"blog_num_desc_pred\";s:0:\"\";s:13:\"blog_template\";s:0:\"\";s:20:\"blog_template_record\";s:0:\"\";s:21:\"blog_template_comment\";s:0:\"\";s:12:\"blog_devider\";s:1:\"1\";s:15:\"blog_short_path\";s:1:\"0\";}', 0, 0, 0, 1, 1, ".(int)$this->config->get('config_customer_group_id').", '2012-10-11 22:58:43', '2012-10-12 01:32:26')
			";
			$query = $this->db->query($msql);

            foreach ($languages as $language) {
				$msql  = "INSERT INTO `" . DB_PREFIX . "blog_description` (`blog_id`, `language_id`, `name`, `description`, `meta_description`, `meta_keyword`)
				VALUES (1, ".$language['language_id'].", 'News', '', 'News', 'News')";
				$query = $this->db->query($msql);
             }




			$msql  = "INSERT INTO `" . DB_PREFIX . "blog_to_store` (`blog_id`, `store_id`) VALUES (1, 0);";
			$query = $this->db->query($msql);
			$msql  = "INSERT INTO `" . DB_PREFIX . "url_alias_blog` (`query`, `keyword`) VALUES  ('blog_id=1', 'first_blog')";
			$query = $this->db->query($msql);
			$msql  = "SELECT * FROM `" . DB_PREFIX . "record` WHERE `record_id`='1';";
			$query = $this->db->query($msql);
			if (count($query->rows) <= 0) {
				$msql  = "INSERT INTO `" . DB_PREFIX . "record` (`record_id`, `model`, `sku`, `upc`, `location`, `quantity`, `stock_status_id`, `image`, `manufacturer_id`, `shipping`, `price`, `points`, `tax_class_id`, `date_available`, `date_end`, `weight`, `weight_class_id`, `length`, `width`, `height`, `length_class_id`, `subtract`, `minimum`, `sort_order`, `status`, `comment`, `comment_status`, `comment_status_reg`, `comment_status_now`, `date_added`, `date_modified`, `viewed`, `customer_group_id`)
				VALUES (1, '', '', '', '', 0, 0, 'data/logo.png', 0, 1, 0.0000, 0, 0, '2012-10-10 23:58:47', '2030-11-11 00:00:00', 0.00, 0, 0.00, 0.00, 0.00, 0, 1, 1, 1, 1, 0x613a343a7b733a363a22737461747573223b733a313a2231223b733a31303a227374617475735f726567223b733a313a2230223b733a31303a227374617475735f6e6f77223b733a313a2230223b733a363a22726174696e67223b733a313a2231223b7d, 0, 0, 0, '2012-10-11 22:59:25', '2012-10-12 01:33:59', 2, ".(int)$this->config->get('config_customer_group_id').");";
				$query = $this->db->query($msql);
				$msql  = "INSERT INTO `" . DB_PREFIX . "record_description` (`record_id`, `language_id`, `name`, `description`, `meta_description`, `meta_keyword`) VALUES (1, 1, 'We started a blog.', 0x266c743b702667743b0d0a09266c743b7370616e20636c6173733d2671756f743b73686f72745f746578742671756f743b2069643d2671756f743b726573756c745f626f782671756f743b206c616e673d2671756f743b656e2671756f743b20746162696e6465783d2671756f743b2d312671756f743b2667743b266c743b7370616e20636c6173733d2671756f743b6870732671756f743b2667743b57652073746172746564266c743b2f7370616e2667743b20266c743b7370616e20636c6173733d2671756f743b6870732671756f743b2667743b6120626c6f672e266c743b2f7370616e2667743b266c743b2f7370616e2667743b266c743b2f702667743b0d0a, 'We started a blog.', 'We started a blog.');";
				$query = $this->db->query($msql);
				$msql  = "INSERT INTO `" . DB_PREFIX . "record_to_blog` (`record_id`, `blog_id`) VALUES (1, 1);";
				$query = $this->db->query($msql);
				$msql  = "INSERT INTO `" . DB_PREFIX . "record_to_store` (`record_id`, `store_id`) VALUES (1, 0);";
				$query = $this->db->query($msql);
				$msql  = "INSERT INTO `" . DB_PREFIX . "url_alias_blog` (`query`, `keyword`) VALUES  ('record_id=1', 'first_record')";
				$query = $this->db->query($msql);
			}
		}
		$msql  = "SELECT * FROM `" . DB_PREFIX . "setting` WHERE `group`='blog';";
		$query = $this->db->query($msql);
		if (count($query->rows) <= 0) {


        if (!isset($not_found_id)) {
			$msql  = "SELECT * FROM `" . DB_PREFIX . "layout` WHERE `name`='not_found';";
			$query = $this->db->query($msql);
			if (count($query->rows) > 0) {
				$not_found_id = $query->row['layout_id'];
			}
		}


		 $ar = Array
		(
		    '0' => Array
		        (
		            'layout_id' => 1,
		            'position' => 'content_top',
		            'status' => 1,
		            'what' => 'what_hook',
		            'sort_order' => 0
		        ),

		    '1' => Array
		        (
		            'layout_id' => $not_found_id,
		            'position' => 'content_top',
		            'status' => 1,
		            'what' => 'what_hook',
		            'sort_order' => 0
		        )

		);

		$blog_nodule_setting = serialize($ar);

			$msql  = "INSERT INTO `" . DB_PREFIX . "setting` ( `store_id`, `group`, `key`, `value`, `serialized`) VALUES
( 0, 'blog', 'blog_num_comments', '20', 0),
( 0, 'blog', 'blog_num_desc', '', 0),
( 0, 'blog', 'blog_num_desc_words', '', 0),
( 0, 'blog', 'blog_num_desc_pred', '1', 0),
( 0, 'blog', 'blog_module', '".$blog_nodule_setting."', 1),
( 0, 'blog', 'mylist-what', 'blogs', 0),
( 0, 'blog', 'mylist', 'a:3:{i:2;a:5:{s:4:\"type\";s:5:\"blogs\";s:17:\"title_list_latest\";a:2:{i:1;s:4:\"Blog\";i:2;s:0:\"\";}s:6:\"avatar\";a:2:{s:5:\"width\";s:2:\"50\";s:6:\"height\";s:2:\"50\";}s:8:\"template\";s:0:\"\";s:5:\"blogs\";a:1:{i:0;s:1:\"1\";}}i:1;a:4:{s:4:\"type\";s:8:\"blogsall\";s:17:\"title_list_latest\";a:2:{i:1;s:5:\"Blogs\";i:2;s:0:\"\";}s:6:\"avatar\";a:2:{s:5:\"width\";s:2:\"50\";s:6:\"height\";s:2:\"50\";}s:8:\"template\";s:0:\"\";}i:3;a:10:{s:4:\"type\";s:6:\"latest\";s:17:\"title_list_latest\";a:2:{i:1;s:4:\"Last\";i:2;s:0:\"\";}s:6:\"avatar\";a:2:{s:5:\"width\";s:2:\"50\";s:6:\"height\";s:2:\"50\";}s:8:\"template\";s:0:\"\";s:15:\"number_per_blog\";s:1:\"5\";s:12:\"desc_symbols\";s:0:\"\";s:10:\"desc_words\";s:0:\"\";s:9:\"desc_pred\";s:1:\"1\";s:5:\"order\";s:6:\"latest\";s:5:\"blogs\";a:1:{i:0;s:1:\"1\";}}}', 1),
( 0, 'blog', 'blog_num_records', '20', 0),
( 0, 'blog', 'blog_small', 'a:2:{s:5:\"width\";s:3:\"150\";s:6:\"height\";s:3:\"150\";}', 1),
( 0, 'blog', 'blog_big', 'a:2:{s:5:\"width\";s:0:\"\";s:6:\"height\";s:0:\"\";}', 1);
	";
			$query = $this->db->query($msql);
		}
		$msql  = "SELECT * FROM `" . DB_PREFIX . "url_alias` WHERE `query` LIKE 'blog_id=%';";
		$query = $this->db->query($msql);
		if (count($query->rows) > 0) {
			foreach ($query->rows as $blog_id) {
				$msql    = "SELECT * FROM `" . DB_PREFIX . "url_alias_blog` WHERE `query`='" . $blog_id['query'] . "'";
				$query_1 = $this->db->query($msql);
				if (count($query_1->rows) <= 0) {
					$msql    = "INSERT INTO `" . DB_PREFIX . "url_alias_blog` (`query`, `keyword`) VALUES  ('" . $blog_id['query'] . "', '" . $blog_id['keyword'] . "')";
					$query_2 = $this->db->query($msql);
				}
				$msql    = "DELETE FROM `" . DB_PREFIX . "url_alias` WHERE query ='" . $blog_id['query'] . "'";
				$query_3 = $this->db->query($msql);
			}
		}
		$msql  = "SELECT * FROM `" . DB_PREFIX . "url_alias` WHERE `query` LIKE 'record_id=%';";
		$query = $this->db->query($msql);
		if (count($query->rows) > 0) {
			foreach ($query->rows as $blog_id) {
				$msql    = "SELECT * FROM `" . DB_PREFIX . "url_alias_blog` WHERE `query`='" . $blog_id['query'] . "'";
				$query_1 = $this->db->query($msql);
				if (count($query_1->rows) <= 0) {
					$msql    = "INSERT INTO `" . DB_PREFIX . "url_alias_blog` (`query`, `keyword`) VALUES  ('" . $blog_id['query'] . "', '" . $blog_id['keyword'] . "')";
					$query_2 = $this->db->query($msql);
				}
				$msql    = "DELETE FROM `" . DB_PREFIX . "url_alias` WHERE query ='" . $blog_id['query'] . "'";
				$query_3 = $this->db->query($msql);
			}
		}
		$this->load->language('catalog/blog');
		$html = $this->language->get('ok_create_tables');
		$this->response->setOutput($html);
	}
}
?>