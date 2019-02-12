<?php 
class ControllerAccountSuccess extends Controller {  
	public function index() {
    	$this->language->load('account/success');
  
    	$this->document->setTitle($this->language->get('heading_title'));
    	
      	$this->breadcrumbs();
      	
      	$this->data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_account'),
			'href'      => $this->url->link('account/account', '', 'SSL'),
        	'separator' => $this->language->get('text_separator')
      	);
      	
      	$this->data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_success'),
			'href'      => $this->url->link('account/success'),
        	'separator' => $this->language->get('text_separator')
      	);

        $this->data['heading_title'] = $this->language->get('heading_title');
        $this->data['text_come_back'] = $this->language->get('text_come_back');

		$this->load->model('account/customer_group');
		
		$customer_group = $this->model_account_customer_group->getCustomerGroup($this->customer->getCustomerGroupId());

		if ($customer_group && !$customer_group['approval']) {
    		$this->data['text_message'] = sprintf($this->language->get('text_message'), $this->url->link('information/contact'));
		} else {
			$this->data['text_message'] = sprintf($this->language->get('text_approval'), $this->config->get('config_name'), $this->url->link('information/contact'));
		}
		
    	$this->data['button_continue'] = $this->language->get('button_continue');
		
		if ($this->cart->hasProducts()) {
			$this->data['continue'] = $this->url->link('checkout/cart', '', 'SSL');
		} else {
			$this->data['continue'] = $this->url->link('account/account', '', 'SSL');
		}

        if (isset($this->session->data['last_url'])) {
            $this->data['come_back'] = $this->session->data['last_url'];
        } else {
            $this->data['come_back'] = false;
        }

		$this->fileRender('/template/common/success.tpl');
  	}
}
?>