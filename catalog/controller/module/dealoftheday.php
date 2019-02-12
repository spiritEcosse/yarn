<?php
class ControllerModuledealoftheday extends Controller {
	protected function index($setting) {
		$this->language->load('module/dealoftheday'); 
		$this->load->model('catalog/product'); 
		$this->load->model('catalog/GALKAGraboCount');
		$this->load->model('tool/image');
      	$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['button_cart'] = $this->language->get('button_cart');

		$this->language->load('GALKA_custom/GALKA');

		$this->data['text_wish'] = $this->language->get('text_wish');
		$this->data['text_compare'] = $this->language->get('text_compare');
		$this->data['text_sale'] = $this->language->get('text_sale');
		$this->data['text_save'] = $this->language->get('text_save');
		$this->data['text_new_prod'] = $this->language->get('text_new_prod');
		$this->data['text_left'] = $this->language->get('text_left');
		$this->data['text_purchased'] = $this->language->get('text_purchased');
		$this->data['text_limited'] = $this->language->get('text_limited');
		$this->data['text_only'] = $this->language->get('text_only');
		$this->data['text_old_price'] = $this->language->get('text_old_price');
		$this->data['text_deal_price'] = $this->language->get('text_deal_price');
		$this->data['text_saving'] = $this->language->get('text_saving');
		$this->data['text_buy'] = $this->language->get('text_buy');

		$this->data['setting'] = $setting;
		$this->data['products'] = array();

		$products = explode(',', $this->config->get('dealoftheday_product'));		

		if (empty($setting['limit'])) {
			$setting['limit'] = 5;
		}
		
		$products = array_slice($products, 0, (int)$setting['limit']);
		
		foreach ($products as $product_id) {
			$product_info = $this->model_catalog_product->getProduct($product_id);
			$category_id = false;
			$category_path = false;
			
			if ($product_info) {
				if ($product_info['image']) {
					$image = $this->model_tool_image->resize($product_info['image'], $setting['image_width'], $setting['image_height']);
					$image_big = $this->model_tool_image->resize($product_info['image'],  ($this->config->get('config_image_product_width') * 2), ($this->config->get('config_image_product_height') * 2));
				} else {
					$image = false;
				}

				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')), $product_info['code'], 1);
				} else {
					$price = false;
				}
						
				if ((float)$product_info['special']) {
					$special = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')), $product_info['code'], 1);
				} else {
					$special = false;
				}
				
				$specials_date = $this->model_catalog_GALKAGraboCount->getProductDiscountDates($product_info['product_id']);
				// $specials_purchased = $this->model_catalog_GALKAGraboCount->getVouchersBought($product_info['product_id']);
				
				$this->data['quantity_start'] = false;
				$this->data['quantity_left'] = false;
				// $this->data['quantity_start'] = $product_info['quantity'];
				// $this->data['quantity_left'] = $specials_purchased['quantity_purchased'];
				
				if ($specials_date['date_end']) {				
					list($year, $month,$day) = explode('-',$specials_date['date_end']);
					$stringDate = $year.', '.$month.' - 1, '.$day;
				} else {
					$stringDate = 0;
				}

				$this->data['quantity'] = $product_info['quantity'];
				
				if ($this->config->get('config_review_status')) {
					$rating = $product_info['rating'];
				} else {
					$rating = false;
				}
				
				if ( $product_info['product_id'] ) {
					$category_id = $this->model_catalog_category->getCategroyByProduct($product_info['product_id']);
				}

				if ( $category_id ) {
					$category_path = $this->model_catalog_category->treeCategory($category_id);
				}
				
				if ( $category_path ) {
					$category_path = array_reverse($category_path);
					$category_path = implode('_', $category_path);
					$category_path = '&path=' . $category_path;
				} else {
					$category_path = '';
				}

				$this->data['products'][] = array(
					'product_id' 	=> $product_info['product_id'],
					'thumb'   	 	=> $image,
					'big_feature'   => $image_big,
					'startdate'    	=> $product_info['date_added'],
					'name'    	 	=> $product_info['name'],
					'description' 	=> mb_substr(strip_tags(html_entity_decode($product_info['description'])), 0, 160, 'UTF-8') . '...',
					'date_end'  	=> $stringDate,
					'quantity' 		=> $product_info['quantity'],
					'price'   	 	=> $price,
					'special' 	 	=> $special,
					'rating'     	=> $rating,
					'reviews'    	=> sprintf($this->language->get('text_reviews'), (int)$product_info['reviews']),
					'href'    	 	=> $this->url->link('product/product', $category_path . '&product_id=' . $product_info['product_id']),
				);
			}
		}

		$this->fileRenderModule('/template/module/dealoftheday.tpl');
	}
}
?>