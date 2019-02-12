<?php 
class ControllerCatalogSeo extends Controller {
	private $error = array();
   
  	public function index() {
		$this->load->language('catalog/seo');
        $this->load->model('catalog/seo');

        $this->document->setTitle($this->language->get('heading_title'));

    	$this->getForm();
  	}

    public function save() {
        $this->load->model('catalog/seo');
        $this->load->language('catalog/seo');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_catalog_seo->editSeo($this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');
            $this->redirect($this->url->link('catalog/seo', 'token=' . $this->session->data['token'], 'SSL'));
        }

        $this->getForm();
    }

  	private function getForm() {
     	$this->data['heading_title'] = $this->language->get('heading_title');

        $this->data['text_catalog'] = $this->language->get('text_catalog');
        $this->data['text_special'] = $this->language->get('text_special');
        $this->data['text_discount'] = $this->language->get('text_discount');
        $this->data['text_contacts'] = $this->language->get('text_contacts');
        $this->data['success'] = '';

        if (isset($this->session->data['success'])) {
            $this->data['success'] = $this->session->data['success'];
            unset($this->session->data['success']);
        }

    	$this->data['button_save'] = $this->language->get('button_save');
    	$this->data['button_cancel'] = $this->language->get('button_cancel');

        $this->data['cancel'] = $this->url->link('catalog/seo', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['action'] = $this->url->link('catalog/seo/save', 'token=' . $this->session->data['token'], 'SSL');

        if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

        if (isset($this->error['product_catalog'])) {
            $this->data['error_product_catalog'] = $this->error['product_catalog'];
        } else {
            $this->data['error_product_catalog'] = '';
        }

        if (isset($this->error['product_special'])) {
            $this->data['error_product_special'] = $this->error['product_special'];
        } else {
            $this->data['error_product_special'] = '';
        }

        if (isset($this->error['product_discount'])) {
            $this->data['error_product_discount'] = $this->error['product_discount'];
        } else {
            $this->data['error_product_discount'] = '';
        }

        if (isset($this->error['information_contact'])) {
            $this->data['error_information_contact'] = $this->error['information_contact'];
        } else {
            $this->data['error_information_contact'] = '';
        }

        if (isset($this->error['catalog_video'])) {
            $this->data['error_catalog_video'] = $this->error['catalog_video'];
        } else {
            $this->data['error_catalog_video'] = '';
        }

        if (isset($this->error['information_sitemap'])) {
            $this->data['error_information_sitemap'] = $this->error['information_sitemap'];
        } else {
            $this->data['error_information_sitemap'] = '';
        }

        if (isset($this->error['checkout_cart'])) {
            $this->data['error_checkout_cart'] = $this->error['checkout_cart'];
        } else {
            $this->data['error_checkout_cart'] = '';
        }

        if (isset($this->error['account_login'])) {
            $this->data['error_account_login'] = $this->error['account_login'];
        } else {
            $this->data['error_account_login'] = '';
        }

        if (isset($this->error['account_register'])) {
            $this->data['error_account_register'] = $this->error['account_register'];
        } else {
            $this->data['error_account_register'] = '';
        }

        if (isset($this->error['account_wishlist'])) {
            $this->data['error_account_wishlist'] = $this->error['account_wishlist'];
        } else {
            $this->data['error_account_wishlist'] = '';
        }

        if (isset($this->error['product_compare'])) {
            $this->data['error_product_compare'] = $this->error['product_compare'];
        } else {
            $this->data['error_product_compare'] = '';
        }

        if (isset($this->error['product_sale'])) {
            $this->data['error_product_sale'] = $this->error['product_sale'];
        } else {
            $this->data['error_product_sale'] = '';
        }

        if (isset($this->error['list_category_article'])) {
            $this->data['error_list_category_article'] = $this->error['list_category_article'];
        } else {
            $this->data['error_list_category_article'] = '';
        }

        $this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('catalog/seo', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

        if (isset($this->request->post['catalog'])) {
            $this->data['catalog'] = $this->request->post['catalog'];
        } else {
            $this->data['catalog'] = $this->model_catalog_seo->getKeyword('product/catalog');
        }

        if (isset($this->request->post['special'])) {
            $this->data['special'] = $this->request->post['special'];
        } else {
            $this->data['special'] = $this->model_catalog_seo->getKeyword('product/special');
        }

        if (isset($this->request->post['discount'])) {
            $this->data['discount'] = $this->request->post['discount'];
        } else {
            $this->data['discount'] = $this->model_catalog_seo->getKeyword('product/discount');
        }

        if (isset($this->request->post['contacts'])) {
            $this->data['contacts'] = $this->request->post['contacts'];
        } else {
            $this->data['contacts'] = $this->model_catalog_seo->getKeyword('information/contact');
        }

        if (isset($this->request->post['catalog_video'])) {
            $this->data['catalog_video'] = $this->request->post['catalog_video'];
        } else {
            $this->data['catalog_video'] = $this->model_catalog_seo->getKeyword('product/list');
        }

        if (isset($this->request->post['information_sitemap'])) {
            $this->data['information_sitemap'] = $this->request->post['information_sitemap'];
        } else {
            $this->data['information_sitemap'] = $this->model_catalog_seo->getKeyword('information/sitemap');
        }

        if (isset($this->request->post['checkout_cart'])) {
            $this->data['checkout_cart'] = $this->request->post['checkout_cart'];
        } else {
            $this->data['checkout_cart'] = $this->model_catalog_seo->getKeyword('checkout/cart');
        }

        if (isset($this->request->post['account_login'])) {
            $this->data['account_login'] = $this->request->post['account_login'];
        } else {
            $this->data['account_login'] = $this->model_catalog_seo->getKeyword('account/login');
        }

        if (isset($this->request->post['account_register'])) {
            $this->data['account_register'] = $this->request->post['account_register'];
        } else {
            $this->data['account_register'] = $this->model_catalog_seo->getKeyword('account/register');
        }

        if (isset($this->request->post['account_wishlist'])) {
            $this->data['account_wishlist'] = $this->request->post['account_wishlist'];
        } else {
            $this->data['account_wishlist'] = $this->model_catalog_seo->getKeyword('account/wishlist');
        }

        if (isset($this->request->post['product_compare'])) {
            $this->data['product_compare'] = $this->request->post['product_compare'];
        } else {
            $this->data['product_compare'] = $this->model_catalog_seo->getKeyword('product/compare');
        }

        if (isset($this->request->post['product_sale'])) {
            $this->data['product_sale'] = $this->request->post['product_sale'];
        } else {
            $this->data['product_sale'] = $this->model_catalog_seo->getKeyword('product/sale');
        }

        if (isset($this->request->post['list_category_article'])) {
            $this->data['list_category_article'] = $this->request->post['list_category_article'];
        } else {
            $this->data['list_category_article'] = $this->model_catalog_seo->getKeyword('information/list_category_article');
        }

		$this->template = 'catalog/seo.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());	
  	}
  	
	private function validateForm() {
        $this->load->model('catalog/seo');

        if (!$this->user->hasPermission('modify', 'catalog/seo')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}

        if ($this->model_catalog_seo->getSeoAllRows('product/catalog',$this->request->post['catalog']) > 0) {
            $this->error['product_catalog'] = $this->language->get('error_link');
        }

        if ($this->model_catalog_seo->getSeoAllRows('product/special',$this->request->post['special']) > 0) {
            $this->error['product_special'] = $this->language->get('error_link');
        }

        if ($this->model_catalog_seo->getSeoAllRows('product/discount',$this->request->post['discount']) > 0) {
            $this->error['product_discount'] = $this->language->get('error_link');
        }

        if ($this->model_catalog_seo->getSeoAllRows('information/contact',$this->request->post['contacts']) > 0) {
            $this->error['information_contact'] = $this->language->get('error_link');
        }

        if ($this->model_catalog_seo->getSeoAllRows('product/list',$this->request->post['catalog_video']) > 0) {
            $this->error['catalog_video'] = $this->language->get('error_link');
        }

        if ($this->model_catalog_seo->getSeoAllRows('information/sitemap',$this->request->post['information_sitemap']) > 0) {
            $this->error['information_sitemap'] = $this->language->get('error_link');
        }

        if ($this->model_catalog_seo->getSeoAllRows('checkout/cart',$this->request->post['checkout_cart']) > 0) {
            $this->error['checkout_cart'] = $this->language->get('error_link');
        }

        if ($this->model_catalog_seo->getSeoAllRows('account/login',$this->request->post['account_login']) > 0) {
            $this->error['account_login'] = $this->language->get('error_link');
        }

        if ($this->model_catalog_seo->getSeoAllRows('account/register',$this->request->post['account_register']) > 0) {
            $this->error['account_register'] = $this->language->get('error_link');
        }

        if ($this->model_catalog_seo->getSeoAllRows('account/wishlist',$this->request->post['account_wishlist']) > 0) {
            $this->error['account_wishlist'] = $this->language->get('error_link');
        }

        if ($this->model_catalog_seo->getSeoAllRows('product/compare',$this->request->post['product_compare']) > 0) {
            $this->error['product_compare'] = $this->language->get('error_link');
        }

        if ($this->model_catalog_seo->getSeoAllRows('product/sale',$this->request->post['product_sale']) > 0) {
            $this->error['product_sale'] = $this->language->get('error_link');
        }

        if ($this->model_catalog_seo->getSeoAllRows('information/list_category_article',$this->request->post['list_category_article']) > 0) {
            $this->error['list_category_article'] = $this->language->get('error_link');
        }

        if ($this->error && !isset($this->error['warning'])) {
            $this->error['warning'] = $this->language->get('error_form');
        }

		if (!$this->error) {
	  		return true;
		} else {
	  		return false;
		}
  	}
}