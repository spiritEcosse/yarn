<?php
class ControllerExtensionSubscribero extends Controller {
	private $error = array();
	
	public function index() {
		$this->language->load('extension/subscribero');
		
		$this->document->setTitle($this->language->get('heading_title'));
		
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else { 
			$page = 1;
		}
		
		$url = '';
		
		if (isset($this->request->post['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		
		if (isset($this->request->post['filter_email'])) {
			$url .= '&filter_email=' . $this->request->get['filter_email'];
		}
		
		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('extension/subscribero', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
		
		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		if (isset($this->session->data['warning'])) {
			$this->data['error_warning'] = $this->session->data['warning'];
		
			unset($this->session->data['warning']);
		} else {
			$this->data['error_warning'] = '';
		}
		
		$data = array(
			'page' => $page,
			'limit' => $this->config->get('config_admin_limit'),
			'start' => $this->config->get('config_admin_limit') * ($page - 1),
		);
		
		$url = '';
		
		if (isset($this->request->post['filter_email'])) {
			$url .= '&filter_email=' . $this->request->get['filter_email'];
		}
		
		$total = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "subscribero WHERE email is not null");
		
		$pagination = new Pagination();
		$pagination->total = $total->row['total'];
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('extension/subscribero', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
		
		$this->data['pagination'] = $pagination->render();
		
		$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['column_email'] = $this->language->get('column_email');
		
		$this->data['text_empty'] = $this->language->get('text_empty');
		
		$this->data['button_delete'] = $this->language->get('button_delete');
		$this->data['button_filter'] = $this->language->get('button_filter');
		
		if (isset($this->request->get['filter_email'])) {
			$this->data['filter_email'] = $this->request->get['filter_email'];
		} else {
			$this->data['filter_email'] = '';
		}
		
		$this->data['token'] = $this->session->data['token'];
		
		$this->data['delete'] = $this->url->link('extension/subscribero/delete', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['subscriberos'] = array();
		
		$sql = "SELECT * FROM " . DB_PREFIX . "subscribero";
		
		if (isset($this->request->get['filter_email'])) {
			$sql .= " WHERE email = '" . $this->db->escape($this->request->get['filter_email']) . "'";
		}
		
		$sql .= " ORDER BY email ASC";
		
		if (!empty($data['limit'])) {
			if ($data['limit'] < 0) {
				$limit = 20;
			} else {
				$limit = $data['limit'];
			}
		} else {
			$limit = 20;
		}
		
		if (!empty($data['start'])) {
			if ($data['start'] < 0) {
				$start = 0;
			} else {
				$start = $data['start'];
			}
		} else {
			$start = 0;
		}
		
		$sql .= " LIMIT " . $start . ", " . $limit;
		
		$subscriberos = $this->db->query($sql);
		
		foreach ($subscriberos->rows as $subscribero) {
			$this->data['subscriberos'][] = array (
				'email' => $subscribero['email'],
				'selected' => isset($this->request->post['selected']) && in_array($subscribero['email'], $this->request->post['selected']),
			);
		}
		
		$this->template = 'extension/subscribero.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());		
	}
	
	public function delete() {
    	$this->language->load('extension/subscribero');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $email) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "subscribero WHERE email = '" . $this->db->escape($email) . "'");
	  		}

			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->redirect($this->url->link('extension/subscribero', 'token=' . $this->session->data['token'], 'SSL'));
		} else {
			$this->session->data['warning'] = $this->language->get('error_warning');
			
			$this->redirect($this->url->link('extension/subscribero', 'token=' . $this->session->data['token'], 'SSL'));
		}
  	}
	
	private function validateDelete() {
    	if (!$this->user->hasPermission('modify', 'extension/subscribero')) {
      		$this->error['warning'] = $this->language->get('error_warning');  
    	}
		
		if (!$this->error) {
	  		return true;
		} else {
	  		return false;
		}
  	}
}
?>