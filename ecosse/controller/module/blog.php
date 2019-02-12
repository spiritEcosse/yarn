<?php
class ControllerModuleBlog extends Controller
{
	private $error = array();
	public function index()
	{
		$this->data['blog_version'] = '4.6 (Commercial)';
		$this->load->language('module/blog');
		$this->document->setTitle(strip_tags($this->language->get('heading_title')));
		$this->load->model('setting/setting');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('blog', $this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');
			$this->redirect($this->url->link('module/blog', 'token=' . $this->session->data['token'], 'SSL'));
		}
		$this->data['heading_title']              = $this->language->get('heading_title');
		$this->data['text_enabled']               = $this->language->get('text_enabled');
		$this->data['text_disabled']              = $this->language->get('text_disabled');
		$this->data['text_content_top']           = $this->language->get('text_content_top');
		$this->data['text_content_bottom']        = $this->language->get('text_content_bottom');
		$this->data['text_column_left']           = $this->language->get('text_column_left');
		$this->data['text_column_right']          = $this->language->get('text_column_right');
		$this->data['text_what_blog']             = $this->language->get('text_what_blog');
		$this->data['text_what_list']             = $this->language->get('text_what_list');
		$this->data['text_what_all']              = $this->language->get('text_what_all');
		$this->data['text_what_hook']             = $this->language->get('text_what_hook');
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
		$this->data['tab_general']                = $this->language->get('tab_general');
		$this->data['tab_list']                   = $this->language->get('tab_list');
		$this->data['entry_layout']               = $this->language->get('entry_layout');
		$this->data['entry_position']             = $this->language->get('entry_position');
		$this->data['entry_status']               = $this->language->get('entry_status');
		$this->data['entry_sort_order']           = $this->language->get('entry_sort_order');
		$this->data['button_save']                = $this->language->get('button_save');
		$this->data['button_cancel']              = $this->language->get('button_cancel');
		$this->data['button_add_module']          = $this->language->get('button_add_module');
		$this->data['button_remove']              = $this->language->get('button_remove');
		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		$this->data['breadcrumbs']   = array();
		$this->data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);
		$this->data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);
		$this->data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('module/blog', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' / '
		);
		if (isset($this->request->post['blog_num_records'])) {
			$this->data['blog_num_records'] = $this->request->post['blog_num_records'];
		} else {
			$this->data['blog_num_records'] = $this->config->get('blog_num_records');
		}
		if (isset($this->request->post['blog_num_comments'])) {
			$this->data['blog_num_comments'] = $this->request->post['blog_num_comments'];
		} else {
			$this->data['blog_num_comments'] = $this->config->get('blog_num_comments');
		}
		if (isset($this->request->post['blog_num_desc'])) {
			$this->data['blog_num_desc'] = $this->request->post['blog_num_desc'];
		} else {
			$this->data['blog_num_desc'] = $this->config->get('blog_num_desc');
		}
		if (isset($this->request->post['blog_num_desc_words'])) {
			$this->data['blog_num_desc_words'] = $this->request->post['blog_num_desc_words'];
		} else {
			$this->data['blog_num_desc_words'] = $this->config->get('blog_num_desc_words');
		}
		if (isset($this->request->post['blog_num_desc_pred'])) {
			$this->data['blog_num_desc_pred'] = $this->request->post['blog_num_desc'];
		} else {
			$this->data['blog_num_desc_pred'] = $this->config->get('blog_num_desc_pred');
		}
		if (isset($this->request->post['blog_small'])) {
			$this->data['blog_small'] = $this->request->post['blog_small'];
		} else {
			$this->data['blog_small'] = $this->config->get('blog_small');
		}
		if (isset($this->request->post['blog_big'])) {
			$this->data['blog_big'] = $this->request->post['blog_big'];
		} else {
			$this->data['blog_big'] = $this->config->get('blog_big');
		}
		if (isset($_POST['mylist'])) {
			$this->data['mylist'] = $this->request->post['mylist'];
		} else {
			$this->data['mylist'] = $this->config->get('mylist');
		}
		if (count($this->data['mylist']) > 0) {
			ksort($this->data['mylist']);
		}
		$this->data['modules'] = array();
		if (isset($this->request->post['blog_module'])) {
			$this->data['modules'] = $this->request->post['blog_module'];
		} elseif ($this->config->get('blog_module')) {
			$this->data['modules'] = $this->config->get('blog_module');
		}
		$this->data['token']            = $this->session->data['token'];
		$this->data['url_blog']         = $this->url->link('catalog/blog', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_record']       = $this->url->link('catalog/record', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_comment']      = $this->url->link('catalog/comment', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_create']       = $this->url->link('catalog/blog/createtables', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_modules']      = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_modules_text'] = $this->language->get('url_modules_text');
		$this->data['url_blog_text']    = $this->language->get('url_blog_text');
		$this->data['url_record_text']  = $this->language->get('url_record_text');
		$this->data['url_comment_text'] = $this->language->get('url_comment_text');
		$this->data['url_create_text']  = $this->language->get('url_create_text');
		$this->data['action']           = $this->url->link('module/blog', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['cancel']           = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		$this->load->model('design/layout');
		$this->data['layouts'] = $this->model_design_layout->getLayouts();
		$this->template        = 'module/blog.tpl';
		$this->children        = array(
			'common/header',
			'common/footer'
		);
		$this->response->setOutput($this->render());
	}
	private function validate()
	{
		if (!$this->user->hasPermission('modify', 'module/blog')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
	public function ajax_list()
	{
		$this->data['token'] = $this->session->data['token'];
		$this->load->language('module/blog');
		$this->data['entry_avatar_dim'] = $this->language->get('entry_avatar_dim');
		$this->load->model('catalog/blog');
		$this->load->model('localisation/language');
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		if (isset($this->request->post['list'])) {
			$str  = base64_decode($this->request->post['list']);
			$list = unserialize($str);
		} else {
			$list = Array();
		}
		if (isset($this->request->post['num'])) {
			$num = $this->request->post['num'];
		}
		$this->data['mylist'][$num] = $list;
		if (isset($this->request->post['type'])) {
			$this->data['mylist'][$num]['type'] = $this->request->post['type'];
		} else {
		}
		if ($this->data['mylist'][$num]['type'] == 'blogs') {
			$this->data['categories'] = $this->model_catalog_blog->getCategories(0);
			if (isset($this->request->post['record_blog'])) {
				$this->data['record_blog'] = $this->request->post['record_blog'];
			} elseif (isset($this->request->get['record_id'])) {
				$this->data['record_blog'] = $this->model_catalog_record->getRecordCategories($this->request->get['record_id']);
			} else {
				$this->data['record_blog'] = array();
			}
			$this->template = 'module/blog_list_blogs.tpl';
		}
		if ($this->data['mylist'][$num]['type'] == 'blogsall') {
			$this->template = 'module/blog_list_blogsall.tpl';
		}
		if ($this->data['mylist'][$num]['type'] == 'html') {
			$this->template = 'module/blog_list_html.tpl';
		}
		if ($this->data['mylist'][$num]['type'] == 'latest') {
			$this->data['categories'] = $this->model_catalog_blog->getCategories(0);
			if (isset($this->request->post['record_blog'])) {
				$this->data['record_blog'] = $this->request->post['record_blog'];
			} elseif (isset($this->request->get['record_id'])) {
				$this->data['record_blog'] = $this->model_catalog_record->getRecordCategories($this->request->get['record_id']);
			} else {
				$this->data['record_blog'] = array();
			}
			$this->template = 'module/blog_list_latest.tpl';
		}
		if ($this->data['mylist'][$num]['type'] == 'records') {
			if (isset($this->request->post['mylist'][$num]['related'])) {
				$this->data['mylist'][$num]['related'] = $this->request->post['mylist'][$num]['related'];
			} else {
				if (!isset($this->data['mylist'][$num]['related']))
					$this->data['mylist'][$num]['related'] = array();
			}
			$this->load->model('catalog/record');
			$this->data['related'] = Array();
			if (isset($this->data['mylist'][$num]['related']) && !empty($this->data['mylist'][$num]['related'])){
			 foreach ($this->data['mylist'][$num]['related'] as $record_id) {
				$this->data['related'][] = $this->model_catalog_record->getRecord($record_id);
			 }
			}
			$this->template = 'module/blog_list_records.tpl';
		}
		if ($this->data['mylist'][$num]['type'] == 'related') {
			$this->template = 'module/blog_list_related.tpl';
		}
		$this->response->setOutput($this->render());
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
}
?>