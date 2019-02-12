<?php
/*------------------------------------------------------------------------
//-----------------------------------------------------
// Also Bought Module for GALKA Premium theme by Dimitar Koev 
// Copyright (C) 2012 Dimitar Koev. All Rights Reserved!
// Author: Dimitar Koev
// Author websites: http://www.althemist.com  /  http://www.dimitarkoev.com
// @license - Copyrighted Commercial Software                           
// support@althemist.com                         
//-----------------------------------------------------
-------------------------------------------------------------------------*/

class ControllerModuleGalkaAlsoBought extends Controller {
	private $error = array(); 
	
	public function index() {   
		$this->load->language('module/GALKAalso_bought');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
		$this->document->addStyle('view/stylesheet/css/GALKAControl.css');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('GALKAalso_bought', $this->request->post);		
			
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}
				
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_heading_title'] = $this->language->get('text_heading_title');
		$this->data['text_delete_cache'] = $this->language->get('text_delete_cache');
		$this->data['text_hours'] = $this->language->get('text_hours');
		
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		$this->data['text_content_top'] = $this->language->get('text_content_top');
		$this->data['text_content_bottom'] = $this->language->get('text_content_bottom');		
		$this->data['text_column_left'] = $this->language->get('text_column_left');
		$this->data['text_column_right'] = $this->language->get('text_column_right');
		$this->data['text_sale'] = $this->language->get('text_sale');
		
		
		$this->data['entry_limit'] = $this->language->get('entry_limit');
		$this->data['entry_image'] = $this->language->get('entry_image');
		$this->data['entry_sort']  = $this->language->get('entry_sort');
		$this->data['entry_layout'] = $this->language->get('entry_layout');
		$this->data['entry_position'] = $this->language->get('entry_position');
		$this->data['entry_order_status']  = $this->language->get('entry_order_status');
		$this->data['entry_order_status_operand']  = $this->language->get('entry_order_status_operand');
		$this->data['entry_show_add_to_cart_button']  = $this->language->get('entry_show_add_to_cart_button');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_add_module'] = $this->language->get('button_add_module');
		$this->data['button_remove'] = $this->language->get('button_remove');
		
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		if (isset($this->error['image'])) {
			$this->data['error_image'] = $this->error['image'];
		} else {
			$this->data['error_image'] = array();
		}
		
		if (isset($this->error['dc_period'])) {
			$this->data['error_dc_period'] = $this->error['dc_period'];
		} else {
			$this->data['error_dc_period'] = '';
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
			'href'      => $this->url->link('module/GALKAalso_bought', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = $this->url->link('module/GALKAalso_bought', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		$this->load->model('localisation/language');
		$languages = $this->model_localisation_language->getLanguages();
		$this->data['languages'] = $languages;
		
		foreach($languages as $language){
			$key = 'GALKAalso_bought_heading_title_' . $language['language_id'];
			if (isset($this->request->post[$key])){
				$this->data['box_heading_title'][$language['language_id']] = $this->request->post[$key]; 
			} elseif ( $this->config->get($key) ){
				$this->data['box_heading_title'][$language['language_id']] = $this->config->get($key); 
			} else {
				$this->data['box_heading_title'][$language['language_id']] = ' ';
			}
		}
		
		if (isset($this->request->post['GALKAalso_bought_dc_period'])){
			$this->data['GALKAalso_bought_dc_period'] = $this->request->post['GALKAalso_bought_dc_period'];
		} elseif ($this->config->get('GALKAalso_bought_dc_period')) {
			$this->data['GALKAalso_bought_dc_period'] = $this->config->get('GALKAalso_bought_dc_period');
		} else {
			$this->data['GALKAalso_bought_dc_period'] = 8;
		}
		
		
		$this->data['modules'] = array();
		
		if (isset($this->request->post['GALKAalso_bought_module'])) {
			$this->data['modules'] = $this->request->post['GALKAalso_bought_module'];
		} elseif ($this->config->get('GALKAalso_bought_module')) { 
			$this->data['modules'] = $this->config->get('GALKAalso_bought_module');
		}				
				
		$this->load->model('design/layout');
		
		$this->data['layouts'] = $this->model_design_layout->getLayouts();
		
		$this->load->model('module/GALKAalso_bought');
		
		$this->data['orders_statuses'] = $this->model_module_GALKAalso_bought->getOrderStatuses();

		$this->template = 'module/GALKAalso_bought.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/GALKAalso_bought')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (isset($this->request->post['GALKAalso_bought_module'])) {
			foreach ($this->request->post['GALKAalso_bought_module'] as $key => $value) {
				if (!$value['image_width'] || !$value['image_height']) {
					$this->error['image'][$key] = $this->language->get('error_image');
				}
			}
		}

		if (!is_numeric($this->request->post['GALKAalso_bought_dc_period'])){
			$this->error['dc_period'] = $this->language->get('error_dc_period');
		}	
				
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
?>