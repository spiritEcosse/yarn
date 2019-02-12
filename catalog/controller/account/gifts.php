<?php 
class ControllerAccountGifts extends Controller {
	public function index() {
        $discount_birthday = null;

        if ($this->config->get('discount_birthday_enable') == 1) {
            $discount_birthday = $this->customer->getDiscountByDateBirthday();
        }

        $module['setting'] = array();

        $module['setting']['logged'] = $this->customer->isLogged();
        $module['setting']['first_name'] = $this->customer->getFirstName();
        $module['setting']['last_name'] = $this->customer->getLastName();
        $module['setting']['discount_birthday'] = $this->customer->getDiscountByDateBirthday();

        $this->data['birthday'] = $this->getChild('account/birthday', $module['setting']);

		if (!$this->customer->isLogged() || $discount_birthday == NULL || $this->data['birthday'] == false) {
	  		$this->session->data['redirect'] = $this->url->link('account/account', '', 'SSL');

	  		$this->redirect($this->url->link('account/login', '', 'SSL'));
    	} else {
            $this->data['first_name'] = $this->customer->getFirstName();
            $this->data['last_name'] = $this->customer->getLastName();
        }

        $this->load->model('catalog/product');
        $this->load->model('catalog/category');

		$this->language->load('account/gifts');
		$this->document->setTitle($this->language->get('heading_title'));

      	$this->breadcrumbs();

      	$this->data['breadcrumbs'][] = array(       	
        	'text'      => $this->language->get('text_account'),
			'href'      => $this->url->link('account/account', '', 'SSL'),
        	'separator' => $this->language->get('text_separator')
      	);
		
		if (isset($this->session->data['success'])) {
    		$this->data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
		
    	$this->data['heading_title'] = $this->language->get('heading_title');

    	$this->data['text_my_account'] = $this->language->get('text_my_account');
		$this->data['text_my_orders'] = $this->language->get('text_my_orders');
		$this->data['text_my_newsletter'] = $this->language->get('text_my_newsletter');
    	$this->data['text_edit'] = $this->language->get('text_edit');
    	$this->data['text_password'] = $this->language->get('text_password');
    	$this->data['text_address'] = $this->language->get('text_address');
		$this->data['text_wishlist'] = $this->language->get('text_wishlist');
    	$this->data['text_order'] = $this->language->get('text_order');
    	$this->data['text_download'] = $this->language->get('text_download');
		$this->data['text_reward'] = $this->language->get('text_reward');
		$this->data['text_return'] = $this->language->get('text_return');
		$this->data['text_transaction'] = $this->language->get('text_transaction');
		$this->data['text_newsletter'] = $this->language->get('text_newsletter');

    	$this->data['edit'] = $this->url->link('account/edit', '', 'SSL');
    	$this->data['password'] = $this->url->link('account/password', '', 'SSL');
		$this->data['address'] = $this->url->link('account/address', '', 'SSL');
		$this->data['wishlist'] = $this->url->link('account/wishlist');
    	$this->data['order'] = $this->url->link('account/order', '', 'SSL');
    	$this->data['download'] = $this->url->link('account/download', '', 'SSL');
		$this->data['return'] = $this->url->link('account/return', '', 'SSL');
		$this->data['transaction'] = $this->url->link('account/transaction', '', 'SSL');
		$this->data['newsletter'] = $this->url->link('account/newsletter', '', 'SSL');

        if ($this->config->get('reward_status')) {
			$this->data['reward'] = $this->url->link('account/reward', '', 'SSL');
		} else {
			$this->data['reward'] = '';
		}
		
		$this->fileRender('/template/account/gifts.tpl');
  	}
}
?>