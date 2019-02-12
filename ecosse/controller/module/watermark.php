<?php
class ControllerModuleWatermark extends Controller {
	private $error = array(); 
	
	public function index() {   
		$this->load->language('module/watermark');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {			
			$this->model_setting_setting->editSetting('watermark', $this->request->post);		
			$this->delete_dir();
			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}
				
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_content_top'] = $this->language->get('text_content_top');
		$this->data['text_content_bottom'] = $this->language->get('text_content_bottom');		
		$this->data['text_column_left'] = $this->language->get('text_column_left');
		$this->data['text_column_right'] = $this->language->get('text_column_right');
		$this->data['text_image_manager'] = $this->language->get('text_image_manager');
		$this->data['entry_product'] = $this->language->get('entry_product');
		$this->data['entry_image'] = $this->language->get('entry_image');
		$this->data['entry_layout'] = $this->language->get('entry_layout');
		$this->data['entry_position'] = $this->language->get('entry_position');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		
		$this->data['entry_watermark'] = $this->language->get('entry_watermark');
		$this->data['entry_watermark_pos'] = $this->language->get('entry_watermark_pos');
		
		$this->data['entry_ext_options'] = $this->language->get('entry_ext_options');
		$this->data['entry_ex_text'] = $this->language->get('entry_ex_text');
		$this->data['entry_rotate_text'] = $this->language->get('entry_rotate_text');		
		$this->data['entry_scalex'] = $this->language->get('entry_scalex');
		$this->data['entry_scaley'] = $this->language->get('entry_scaley');
		$this->data['entry_text_color'] = $this->language->get('entry_text_color');
		$this->data['entry_text_opacity'] = $this->language->get('entry_text_opacity');
		$this->data['entry_text_opacity_desc'] = $this->language->get('entry_text_opacity_desc');
		
		$this->data['entry_ext_folder'] = $this->language->get('entry_ext_folder');
		$this->data['entry_ext_folder_desc'] = $this->language->get('entry_ext_folder_desc');
		
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_generatew'] = $this->language->get('button_generatew');
		$this->data['button_add_module'] = $this->language->get('button_add_module');
		$this->data['button_remove'] = $this->language->get('button_remove');
		
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/watermark', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = $this->url->link('module/watermark', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['generatew'] = $this->url->link('module/watermark/delete_dir', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['token'] = $this->session->data['token'];

		if (isset($this->request->post['watermark_product'])) {
			$this->data['watermark_product'] = $this->request->post['watermark_product'];
		} else {
			$this->data['watermark_product'] = $this->config->get('watermark_product');
		}	
		
		$this->load->model('tool/image');
		
		//Watermark
		if (isset($this->request->post['config_use_extended'])) {
			$this->data['config_use_extended'] = $this->request->post['config_use_extended'];
		} else {
			$this->data['config_use_extended'] = $this->config->get('config_use_extended');			
		}
		
		if (isset($this->request->post['config_water_text'])) {
			$this->data['config_water_text'] = $this->request->post['config_water_text'];
		} else {
			$this->data['config_water_text'] = $this->config->get('config_water_text');			
		}
		
		if (isset($this->request->post['config_image_rotate'])) {
			$this->data['config_image_rotate'] = $this->request->post['config_image_rotate'];
		} else {
			$this->data['config_image_rotate'] = $this->config->get('config_image_rotate');			
		}
		
		if (isset($this->request->post['config_scalex'])) {
			$this->data['config_scalex'] = $this->request->post['config_scalex'];
		} else {
			$this->data['config_scalex'] = $this->config->get('config_scalex');			
		}
		
		if (isset($this->request->post['config_scaley'])) {
			$this->data['config_scaley'] = $this->request->post['config_scaley'];
		} else {
			$this->data['config_scaley'] = $this->config->get('config_scaley');			
		}
		
		if (isset($this->request->post['config_text_color'])) {
			$this->data['config_text_color'] = $this->request->post['config_text_color'];
		} else {
			$this->data['config_text_color'] = $this->config->get('config_text_color');			
		}
		
		if (isset($this->request->post['config_opacity'])) {
			$this->data['config_opacity'] = $this->request->post['config_opacity'];
		} else {
			$this->data['config_opacity'] = $this->config->get('config_opacity');			
		}
	
		if (isset($this->request->post['config_watermark_pos'])) {
			$this->data['config_watermark_pos'] = $this->request->post['config_watermark_pos'];
		} else {
			$this->data['config_watermark_pos'] = $this->config->get('config_watermark_pos');			
		}
		
		if (isset($this->request->post['config_watermark'])) {
			$this->data['config_watermark'] = $this->request->post['config_watermark'];
		} else {
			$this->data['config_watermark'] = $this->config->get('config_watermark');			
		}
		
		if ($this->config->get('config_watermark') && file_exists(DIR_IMAGE . $this->config->get('config_watermark')) && is_file(DIR_IMAGE . $this->config->get('config_watermark'))) {
			$this->data['watermark'] = $this->model_tool_image->resize($this->config->get('config_watermark'), 100, 100);		
		} else {
			$this->data['watermark'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}
		//end		
		
		if (isset($this->request->post['config_excepted'])) {
			$this->data['config_excepted'] = $this->request->post['config_excepted'];
		} else {
			$this->data['config_excepted'] = $this->config->get('config_excepted');
		}
		
		$directories = glob(DIR_IMAGE . 'data/*', GLOB_ONLYDIR);
		
		foreach ($directories as $directory) {
			$this->data['excepteds'][] = basename($directory);
		}

		$this->template = 'module/watermark.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
				
		$this->response->setOutput($this->render());
	}

  	public function delete_dir() {
		$path = rtrim(DIR_IMAGE . 'cache/data/');
			
			if (is_file($path)) {
				unlink($path);
			} elseif (is_dir($path)) {
				$this->recursiveDelete($path);
			}
  	}
		
	protected function recursiveDelete($directory) {
		if (is_dir($directory)) {
			$handle = opendir($directory);
		}
		
		if (!$handle) {
			return FALSE;
		}
		
		while (false !== ($file = readdir($handle))) {
			if ($file != '.' && $file != '..') {
				if (!is_dir($directory . '/' . $file)) {
					unlink($directory . '/' . $file);
				} else {
					$this->recursiveDelete($directory . '/' . $file);
				}
			}
		}
		
		closedir($handle);
		
		rmdir($directory);
		
		return TRUE;
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/watermark')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (isset($this->request->post['config_use_extended']) == 'on') {
		if (strlen(utf8_decode($this->request->post['config_water_text'])) < 1) {
			$this->error['text'] = $this->language->get('error_text');
		}
		
		}else{
		}
		if (!$this->error) {
			return TRUE;
		} else {
			if (!isset($this->error['warning'])) {
				$this->error['warning'] = $this->language->get('error_text');
			}
			return FALSE;
		}
	}

}
?>