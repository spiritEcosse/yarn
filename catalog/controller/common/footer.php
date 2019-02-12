<?php  
class ControllerCommonFooter extends Controller {
	protected function index() {
		$this->language->load('common/footer');
		$this->load->model('catalog/information');
		$this->load->model('design/layout');
		$this->load->model('catalog/category');
		$this->load->model('catalog/product');
		$this->load->model('setting/extension');

		$this->data['text_information'] = $this->language->get('text_information');
		$this->data['text_service'] = $this->language->get('text_service');
		$this->data['text_extra'] = $this->language->get('text_extra');
		$this->data['text_contact'] = $this->language->get('text_contact');

		$this->data['text_return'] = $this->language->get('text_return');
    	$this->data['text_sitemap'] = $this->language->get('text_sitemap');
		$this->data['text_manufacturer'] = $this->language->get('text_manufacturer');
		$this->data['text_voucher'] = $this->language->get('text_voucher');
		$this->data['text_affiliate'] = $this->language->get('text_affiliate');
        $this->data['text_special'] = $this->language->get('text_special');
        $this->data['text_discount'] = $this->language->get('text_discount');
        $this->data['text_sale'] = $this->language->get('text_sale');
		$this->data['text_account'] = $this->language->get('text_account');
		$this->data['text_order'] = $this->language->get('text_order');
		$this->data['text_wishlist'] = $this->language->get('text_wishlist');
		$this->data['text_newsletter'] = sprintf($this->language->get('text_newsletter'), $_SERVER['HTTP_HOST']);
        $this->data['text_social'] = $this->language->get('text_social');
        $this->data['text_security'] = $this->language->get('text_security');
        $this->data['text_security_desc'] = $this->language->get('text_security_desc');

		$this->data['text_home'] = $this->language->get('text_home');
		$this->data['text_wishlist'] = sprintf($this->language->get('text_wishlist'), (isset($this->session->data['wishlist']) ? count($this->session->data['wishlist']) : 0));
		$this->data['text_compare'] = sprintf($this->language->get('text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));
		$this->data['text_shopping_cart'] = $this->language->get('text_shopping_cart');
		$this->data['text_account'] = $this->language->get('text_account');
    	$this->data['text_checkout'] = $this->language->get('text_checkout');
    	
    	$this->language->load('GALKA_custom/GALKA');
    	
		$this->data['text_toggle'] = $this->language->get('text_toggle');
		$this->data['text_question'] = $this->language->get('text_question');
		$this->data['text_facebook'] = $this->language->get('text_facebook');
		$this->data['text_twitter'] = $this->language->get('text_twitter');
		$this->data['text_twitter_follow'] = $this->language->get('text_twitter_follow');
		$this->data['text_payment'] = $this->language->get('text_payment');
        $this->data['text_skype_click'] = $this->language->get('text_skype_click');
        $this->data['text_share'] = $this->language->get('text_share');
        $this->data['text_payment_and_delivery'] = $this->language->get('text_payment_and_delivery');

		$this->data['home'] = $this->url->link('common/home');
		$this->data['wishlist'] = $this->url->link('account/wishlist');
		$this->data['compare'] = $this->url->link('product/compare');
		$this->data['account'] = $this->url->link('account/account', '', 'SSL');
		$this->data['shopping_cart'] = $this->url->link('checkout/cart');
		$this->data['checkout'] = $this->url->link('checkout/checkout', '', 'SSL');
		$this->data['contact'] = $this->url->link('information/contact');
		$this->data['return'] = $this->url->link('account/return/insert', '', 'SSL');
    	$this->data['sitemap'] = $this->url->link('information/sitemap');
		$this->data['manufacturer'] = $this->url->link('product/manufacturer');
		$this->data['voucher'] = $this->url->link('account/voucher', '', 'SSL');
		$this->data['affiliate'] = $this->url->link('affiliate/account', '', 'SSL');
        $this->data['special'] = $this->url->link('product/special');
        $this->data['discount'] = $this->url->link('product/discount');
        $this->data['sale'] = $this->url->link('product/sale');
		$this->data['account'] = $this->url->link('account/account', '', 'SSL');
		$this->data['order'] = $this->url->link('account/order', '', 'SSL');
		$this->data['wishlist'] = $this->url->link('account/wishlist', '', 'SSL');
		$this->data['newsletter'] = $this->url->link('account/newsletter', '', 'SSL');

		$this->data['informations'] = array();
        $this->data['supports'] = array();

		foreach ($this->model_catalog_information->getInformations() as $result) {
			if ($result['info'] == 1) {
				$this->data['informations'][] = array(
					'title' => $result['title'],
					'href'  => $this->url->link('information/information', 'information_id=' . $result['information_id'])
				);
			}

            if ($result['support'] == 1) {
                $this->data['supports'][] = array(
                    'title' => $result['title'],
                    'href'  => $this->url->link('information/information', 'information_id=' . $result['information_id'])
                );
            }
    	}

        $text_contact = $this->language->get('text_contact');

        if ($this->config->get('text_contact')) {
            $text_contact = $this->config->get('text_contact');
        }

        if (isset($this->data['informations'][1])) {
            $inform = $this->data['informations'][1];

            $this->data['informations'][1] = array(
                'title' => $text_contact,
                'href'  => $this->url->link('information/contact')
            );

            $this->data['informations'][] = $inform;
        } else {
            $this->data['informations'][] = array(
                'title' => $text_contact,
                'href'  => $this->url->link('information/contact')
            );
        }

		$this->data['powered'] = sprintf($this->language->get('text_powered'), $this->config->get('config_name'), date('Y', time()));
		
		if ($this->config->get('config_customer_online')) {
			$this->load->model('tool/online');
			$referer = '';
			$ip = ''; 
			$url = '';
			
			if (isset($this->request->server['REMOTE_ADDR'])) {
				$ip = $this->request->server['REMOTE_ADDR'];	
			}
			
			if (isset($this->request->server['HTTP_HOST']) && isset($this->request->server['REQUEST_URI'])) {
				$url = 'http://' . $this->request->server['HTTP_HOST'] . $this->request->server['REQUEST_URI'];	
			}
			
			if (isset($this->request->server['HTTP_REFERER'])) {
				$referer = $this->request->server['HTTP_REFERER'];	
			}
								
			$this->model_tool_online->whosonline($ip, $this->customer->getId(), $url, $referer);
		}
		
		$this->children = array(
			'common/content_footer'
		);
		
		$this->fileRenderModule('/template/common/footer.tpl');
	}
}
?>