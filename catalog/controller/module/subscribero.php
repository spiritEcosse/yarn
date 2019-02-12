<?php  
class ControllerModuleSubscribero extends Controller {
	protected function index() {
		$this->language->load('module/subscribero');
		
    	$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['text_email'] = $this->language->get('text_email');
    	
		$this->data['entry_email'] = $this->language->get('entry_email');
		$this->data['entry_subscribe_text'] = $this->language->get('entry_subscribe_text');
		$this->data['entry_policy_text'] = $this->language->get('entry_policy_text');
		
		$this->data['button_join'] = $this->language->get('button_join');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/subscribero.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/subscribero.tpl';
		} else {
			$this->template = 'default/template/module/subscribero.tpl';
		}
		
		$this->render();
	}
	
	public function validate() {
		$this->language->load('module/subscribero');
		
		$json = array();
		
		if ((strlen($this->request->post['email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['email'])) {
			$json['error']['warning'] = $this->language->get('error_email');
		} elseif (strlen($this->request->post['email']) < 3) {
			$json['error']['warning'] = $this->language->get('error_message');
		}
		
		if(!$json) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE email = '" . $this->db->escape($this->request->post['email']) . "'");
			
			if ($query->num_rows) {
				$query = $this->db->query("SELECT newsletter FROM " . DB_PREFIX . "customer WHERE email = '" . $this->db->escape($this->request->post['email']) . "'");
				
				if ($query->row['newsletter']) {
					$this->db->query("UPDATE " . DB_PREFIX . "customer SET newsletter = '0' WHERE email = '" . $this->db->escape($this->request->post['email']) . "'");
					
					$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "subscribero WHERE email = '" . $this->db->escape($this->request->post['email']) . "'");
					
					if ($query->num_rows) {
						$this->db->query("DELETE FROM " . DB_PREFIX . "subscribero WHERE email = '" . $this->db->escape($this->request->post['email']) . "'");
					}
					
					$json['success'] = $this->language->get('text_unsubscribe');
				} else {
					$this->db->query("UPDATE " . DB_PREFIX . "customer SET newsletter = '1' WHERE email = '" . $this->db->escape($this->request->post['email']) . "'");
					
					$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "subscribero WHERE email = '" . $this->db->escape($this->request->post['email']) . "'");
					
					if ($query->num_rows) {
						$this->db->query("DELETE FROM " . DB_PREFIX . "subscribero WHERE email = '" . $this->db->escape($this->request->post['email']) . "'");
					}
					
					$json['success'] = $this->language->get('text_subscribe');
				}
			} else {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "subscribero WHERE email = '" . $this->db->escape($this->request->post['email']) . "'");
				
				if ($query->num_rows) {
					$this->db->query("DELETE FROM " . DB_PREFIX . "subscribero WHERE email = '" . $this->db->escape($this->request->post['email']) . "'");
					
					$json['success'] = $this->language->get('text_unsubscribe');
				} else {
					$this->db->query("INSERT INTO " . DB_PREFIX . "subscribero SET email = '" . $this->db->escape($this->request->post['email']) . "'");
					
					$json['success'] = $this->language->get('text_subscribe');
				}
			}
		}
		
		$this->response->setOutput(json_encode($json));	
	}
}
?>