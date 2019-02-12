<?php 
class ControllerInformationContact extends Controller {
	private $error = array(); 
	    
  	public function index() {
		$this->language->load('information/contact');
		$this->language->load('GALKA_custom/GALKA');

    	$this->document->setTitle($this->language->get('heading_title'));  
	 
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$mail = new Mail();
			$mail->protocol = $this->config->get('config_mail_protocol');
			$mail->parameter = $this->config->get('config_mail_parameter');
			$mail->hostname = $this->config->get('config_smtp_host');
			$mail->username = $this->config->get('config_smtp_username');
			$mail->password = $this->config->get('config_smtp_password');
			$mail->port = $this->config->get('config_smtp_port');
			$mail->timeout = $this->config->get('config_smtp_timeout');				
			$mail->setTo($this->config->get('config_email'));
	  		$mail->setFrom($this->request->post['email']);
	  		$mail->setSender($this->request->post['name']);
	  		$mail->setSubject(html_entity_decode(sprintf($this->language->get('email_subject'), $this->request->post['name']), ENT_QUOTES, 'UTF-8'));
	  		$mail->setText(strip_tags(html_entity_decode($this->request->post['enquiry'], ENT_QUOTES, 'UTF-8')));
      		$mail->send();

	  		$this->redirect($this->url->link('information/contact/success'));
    	}

		$this->breadcrumbs();

      	$this->data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('information/contact'),
        	'separator' => $this->language->get('text_separator')
      	);	
			
    	$this->data['heading_title'] = $this->language->get('heading_title');

    	$this->data['text_location'] = $this->language->get('text_location');
		$this->data['text_contact'] = $this->language->get('text_contact');
		$this->data['text_address'] = $this->language->get('text_address');
    	$this->data['text_telephone'] = $this->language->get('text_telephone');
        $this->data['text_skype'] = $this->language->get('text_skype');
    	$this->data['text_email'] = $this->language->get('text_email');
        $this->data['text_fax'] = $this->language->get('text_fax');
        $this->data['text_toggle'] = $this->language->get('text_toggle');
		$this->data['text_question'] = $this->language->get('text_question');
		$this->data['text_facebook'] = $this->language->get('text_facebook');
		$this->data['text_twitter'] = $this->language->get('text_twitter');
		$this->data['text_payment'] = $this->language->get('text_payment');
		$this->data['text_skype_click'] = $this->language->get('text_skype_click');
		$this->data['text_hours'] = $this->language->get('text_hours');
		$this->data['text_map_get_directions'] = $this->language->get('text_map_get_directions');
		$this->data['text_map_route'] = $this->language->get('text_map_route');
		$this->data['text_map_address'] = $this->language->get('text_map_address');
		
    	$this->data['entry_name'] = $this->language->get('entry_name');
    	$this->data['entry_email'] = $this->language->get('entry_email');
    	$this->data['entry_enquiry'] = $this->language->get('entry_enquiry');
		$this->data['entry_captcha'] = $this->language->get('entry_captcha');

		if (isset($this->error['name'])) {
    		$this->data['error_name'] = $this->error['name'];
		} else {
			$this->data['error_name'] = '';
		}
		
		if (isset($this->error['email'])) {
			$this->data['error_email'] = $this->error['email'];
		} else {
			$this->data['error_email'] = '';
		}		
		
		if (isset($this->error['enquiry'])) {
			$this->data['error_enquiry'] = $this->error['enquiry'];
		} else {
			$this->data['error_enquiry'] = '';
		}

    	$this->data['button_continue'] = $this->language->get('button_continue');
    
		$this->data['action'] = $this->url->link('information/contact');
		$this->data['store'] = $this->config->get('config_name');
    	$this->data['address'] = nl2br($this->config->get('config_address'));
    	$this->data['telephone'] = explode(',', $this->config->get('config_telephone'));
    	$this->data['email'] = $this->config->get('config_mail');
        $this->data['email_shop'] = $this->config->get('config_email');
        $this->data['skype'] = $this->config->get('config_skype');
        
        $this->data['fax'] = $this->config->get('config_fax');
    	
		if (isset($this->request->post['name'])) {
			$this->data['name'] = $this->request->post['name'];
		} else {
			$this->data['name'] = $this->customer->getFirstName();
		}

		if (isset($this->request->post['email'])) {
			$this->data['email'] = $this->request->post['email'];
		} else {
			$this->data['email'] = $this->customer->getEmail();
		}
		
		if (isset($this->request->post['enquiry'])) {
			$this->data['enquiry'] = $this->request->post['enquiry'];
		} else {
			$this->data['enquiry'] = '';
		}

    	$this->fileRender('/template/information/contact.tpl');
  	}

  	public function success() {
		$this->language->load('information/contact');

		$this->document->setTitle($this->language->get('heading_title')); 
		$this->breadcrumbs();

      	$this->data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('information/contact'),
        	'separator' => $this->language->get('text_separator')
      	);	
		
    	$this->data['heading_title'] = $this->language->get('heading_title');
    	$this->data['text_message'] = $this->language->get('text_message');
    	$this->data['button_continue'] = $this->language->get('button_continue');
    	$this->data['continue'] = $this->url->link('common/home');

    	$this->fileRender('/template/common/success.tpl');
	}
	
  	private function validate() {
    	if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 32)) {
      		$this->error['name'] = $this->language->get('error_name');
    	}

    	if (!preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['email'])) {
      		$this->error['email'] = $this->language->get('error_email');
    	}

    	if ((utf8_strlen($this->request->post['enquiry']) < 10) || (utf8_strlen($this->request->post['enquiry']) > 3000)) {
      		$this->error['enquiry'] = $this->language->get('error_enquiry');
    	}
		
		if (!$this->error) {
	  		return true;
		}

	  	return false;
  	}

	public function captcha() {
		$this->load->library('captcha');
		
		$captcha = new Captcha();
		$this->session->data['captcha'] = $captcha->getCode();
		$captcha->showImage();
	}	
}
?>
