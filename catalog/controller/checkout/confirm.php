<?php 
class ControllerCheckoutConfirm extends Controller { 
	public function index() {
		$redirect = '';
        $this->language->load('checkout/checkout');
        $this->load->model('tool/image');
        $this->load->model('localisation/zone');
        $this->load->model('localisation/country');
        $this->load->model('localisation/depart');
        $this->load->model('localisation/city');

		if ($this->cart->hasShipping()) {
			// Validate if shipping address has been set.		
			$this->load->model('account/address');
	
			if ($this->customer->isLogged() && isset($this->session->data['shipping_address_id'])) {					
				$shipping_address = $this->model_account_address->getAddress($this->session->data['shipping_address_id']);		
			} else {
				$shipping_address = true;
			}
			
			if (empty($shipping_address)) {
				$redirect = $this->url->link('checkout/checkout', '', 'SSL');
			}

			// Validate if shipping method has been set.
			if (!isset($this->session->data['shipping_method'])) {
				$redirect = $this->url->link('checkout/checkout', '', 'SSL');
			}
		} else {
			unset($this->session->data['shipping_method']);
			unset($this->session->data['shipping_methods']);
		}
		
		// Validate if payment address has been set.
		$this->load->model('account/address');
		
		if ($this->customer->isLogged() && isset($this->session->data['payment_address_id'])) {
			$payment_address = $this->model_account_address->getAddress($this->session->data['payment_address_id']);		
		} else {
			$payment_address = true;
		}	

		if (empty($payment_address)) {
			$redirect = $this->url->link('checkout/checkout', '', 'SSL');
		}
		
		// Validate if payment method has been set.	
		if (!isset($this->session->data['payment_method'])) {
			$redirect = $this->url->link('checkout/checkout', '', 'SSL');
		}
					
		// Validate cart has products and has stock.	
		if ((!$this->cart->hasProducts() && empty($this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {
			$redirect = $this->url->link('checkout/cart');				
		}	
		
		// Validate minimum quantity requirments.			
		$products = $this->cart->getProducts();
				
		foreach ($products as $product) {
			$product_total = 0;
				
			foreach ($products as $product_2) {
				if ($product_2['product_id'] == $product['product_id']) {
					$product_total += $product_2['quantity'];
				}
			}		
			
			if ($product['minimum'] > $product_total) {
				$redirect = $this->url->link('checkout/cart');
				
				break;
			}				
		}
						
		if (!$redirect) {
			$total_data = array();
			$total = 0;
			$taxes = $this->cart->getTaxes();
			 
			$this->load->model('setting/extension');
			
			$sort_order = array(); 
			
			$results = $this->model_setting_extension->getExtensions('total');
			
			foreach ($results as $key => $value) {
				$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
			}
			
			array_multisort($sort_order, SORT_ASC, $results);
			
			foreach ($results as $result) {
				if ($this->config->get($result['code'] . '_status')) {
					$this->load->model('total/' . $result['code']);
		
					$this->{'model_total_' . $result['code']}->getTotal($total_data, $total, $taxes);
				}
			}
			
			$sort_order = array(); 
		  
			foreach ($total_data as $key => $value) {
				$sort_order[$key] = $value['sort_order'];
			}
	
			array_multisort($sort_order, SORT_ASC, $total_data);
	        $this->data['total_data'] = $total_data;

			$this->language->load('checkout/checkout');
			
			$data = array();
			
			$data['invoice_prefix'] = $this->config->get('config_invoice_prefix');
			$data['store_id'] = $this->config->get('config_store_id');
			$data['store_name'] = $this->config->get('config_name');
			
			if ($data['store_id']) {
				$data['store_url'] = $this->config->get('config_url');		
			} else {
				$data['store_url'] = HTTP_SERVER;	
			}

            $data['customer_id'] = 0;
            $data['customer_group_id'] = $this->config->get('config_customer_group_id');

            if ($this->customer->isLogged()) {
				$data['customer_id'] = $this->customer->getId();
				$data['customer_group_id'] = $this->customer->getCustomerGroupId();
			}

            $data['country_id'] = '';
            $data['firstname'] = $this->request->post['firstname'];
            $data['lastname'] = $this->request->post['lastname'];
            $data['email'] = $this->request->post['email'];
            $data['telephone'] = $this->request->post['telephone'];
            $data['zone_id'] = $this->request->post['zone_id'];
            $data['city_id'] = $this->request->post['city_id'];
            $data['depart_id'] = $this->request->post['depart_id'];
            $data['fax'] = "";

			$data['payment_firstname'] = $this->request->post['firstname'];
			$data['payment_lastname'] = $this->request->post['lastname'];
            $data['payment_address_1'] = $this->request->post['address_1'];
            $data['payment_address_2'] = "";
            $data['comment'] = $this->request->post['comment'];
			$data['payment_city'] = '';
            $data['payment_company'] = "";
            $data['payment_postcode'] = '';
            $data['payment_code'] = '';
            $data['payment_method'] = '';
            $data['payment_zone'] = '';
			$data['payment_zone_id'] = '';
			$data['payment_country'] = '';
			$data['payment_country_id'] = '';
			$data['payment_address_format'] = '';
            $data['payment_company_id'] = "";
            $data['payment_tax_id'] = "";

            if (isset($this->session->data['payment_method']['title'])) {
				$data['payment_method'] = $this->session->data['payment_method']['title'];
			}
			
			if (isset($this->session->data['payment_method']['code'])) {
				$data['payment_code'] = $this->session->data['payment_method']['code'];
			}

            $data['shipping_firstname'] = $this->request->post['firstname'];
            $data['shipping_lastname'] = $this->request->post['lastname'];
            $data['shipping_company'] = '';
            $data['shipping_address_1'] = $this->request->post['address_1'];
            $data['shipping_address_2'] = '';
            $data['shipping_city'] = '';
            $data['shipping_postcode'] = '';
            $data['shipping_zone'] = '';
            $data['shipping_zone_id'] = '';
            $data['shipping_country'] = '';
            $data['shipping_country_id'] = '';
            $data['shipping_address_format'] = '';
            $data['shipping_method'] = '';
            $data['shipping_code'] = '';

            if (isset($this->session->data['shipping_method']['title'])) {
                $data['shipping_method'] = $this->session->data['shipping_method']['title'];
            }

            if (isset($this->session->data['shipping_method']['code'])) {
                $data['shipping_code'] = $this->session->data['shipping_method']['code'];
            }

            $product_data = array();
            $products_id = array();

            foreach ($this->cart->getProducts() as $key => $product) {
                $option_data = array();
                $image = false;
                $category_id = false;
                $category_path = false;

                foreach ($product['option'] as $option) {
                    if ($option['type'] != 'file') {
                        $value = $option['option_value'];
                    } else {
                        $value = $this->encryption->decrypt($option['option_value']);
                    }

                    $option_data[] = array(
                        'product_option_id'       => $option['product_option_id'],
                        'product_option_value_id' => $option['product_option_value_id'],
                        'option_id'               => $option['option_id'],
                        'option_value_id'         => $option['option_value_id'],
                        'name'                    => $option['name'],
                        'value'                   => $value,
                        'type'                    => $option['type']
                    );
                }

                $products_id[] = $key;

                if ($product['image']) {
                    $image = $this->model_tool_image->resize($product['image'], $this->config->get('config_image_cart_width'), $this->config->get('config_image_cart_height'));
                }

                if ( $product['product_id'] ) {
                    $this->load->model('catalog/category');
                    $category_id = $this->model_catalog_category->getCategroyByProduct($product['product_id']);
                }

                if ( $category_id ) {
                    $category_path = $this->model_catalog_category->treeCategory($category_id);
                }

                if ( $category_path ) {
                    $category_path = array_reverse($category_path);
                    $category_path = implode('_', $category_path);
                }

                $old_price = $this->currency->format($product['old_price'], $product['code'], 1);
                $old_price_total = $this->currency->format($product['old_price_total'], $product['code'], 1);

                $product_data[] = array(
                    'product_id' => $product['product_id'],
                    'href'     => $this->url->link('product/product', '&path=' . $category_path . '&product_id=' . $product['product_id']),
                    'name'       => $product['name'],
                    'image'      => $image,
                    'model'      => $product['model'],
                    'option'     => $option_data,
                    'old_price' => $old_price,
                    'diff_price' => $product['diff_price'],
                    'gift'     => $product['gift'],
                    'old_price_total' => $old_price_total,
                    'sale'      => $product['sale'],
                    'download'   => $product['download'],
                    'prefix_name' => $product['prefix_name'],
                    'product_price'	=> $product['product_price'],
                    'quantity'   => $product['quantity'],
                    'subtract'   => $product['subtract'],
                    'code'		 => $product['code'],
                    'value'		 => sprintf($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax'))),
                    'total_value'=> sprintf($this->tax->calculate($product['total'], $product['tax_class_id'], $this->config->get('config_tax'))),
                    'price'      => $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')), $product['code'], 1),
                    'total'      => $this->currency->format($this->tax->calculate($product['total'], $product['tax_class_id'], $this->config->get('config_tax')), $product['code'], 1),
                    'tax'        => $this->tax->getTax($product['price'], $product['tax_class_id']),
                    'reward'     => $product['reward']
                );
            }
			
			// Gift Voucher
			$voucher_data = array();
			
			if (!empty($this->session->data['vouchers'])) {
				foreach ($this->session->data['vouchers'] as $voucher) {
					$voucher_data[] = array(
						'description'      => $voucher['description'],
						'code'             => substr(md5(mt_rand()), 0, 10),
						'to_name'          => $voucher['to_name'],
						'to_email'         => $voucher['to_email'],
						'from_name'        => $voucher['from_name'],
						'from_email'       => $voucher['from_email'],
						'voucher_theme_id' => $voucher['voucher_theme_id'],
						'message'          => $voucher['message'],						
						'amount'           => $voucher['amount']
					);
				}
			}  
						
			$data['products'] = $product_data;
			$data['vouchers'] = $voucher_data;
			$data['totals'] = $total_data;
			$data['total'] = $total;
			
			if (isset($this->request->cookie['tracking'])) {
				$this->load->model('affiliate/affiliate');
				
				$affiliate_info = $this->model_affiliate_affiliate->getAffiliateByCode($this->request->cookie['tracking']);
				
				if ($affiliate_info) {
					$data['affiliate_id'] = $affiliate_info['affiliate_id']; 
					$data['commission'] = ($total / 100) * $affiliate_info['commission']; 
				} else {
					$data['affiliate_id'] = 0;
					$data['commission'] = 0;
				}
			} else {
				$data['affiliate_id'] = 0;
				$data['commission'] = 0;
			}
			
			$data['language_id'] = $this->config->get('config_language_id');
			$data['currency_id'] = $this->currency->getId();
			$data['currency_code'] = $this->currency->getCode();

			$data['currency_value'] = $this->currency->getValue($this->currency->getCode());
			$data['ip'] = $this->request->server['REMOTE_ADDR'];
			
			if (!empty($this->request->server['HTTP_X_FORWARDED_FOR'])) {
				$data['forwarded_ip'] = $this->request->server['HTTP_X_FORWARDED_FOR'];	
			} elseif(!empty($this->request->server['HTTP_CLIENT_IP'])) {
				$data['forwarded_ip'] = $this->request->server['HTTP_CLIENT_IP'];	
			} else {
				$data['forwarded_ip'] = '';
			}
			
			if (isset($this->request->server['HTTP_USER_AGENT'])) {
				$data['user_agent'] = $this->request->server['HTTP_USER_AGENT'];	
			} else {
				$data['user_agent'] = '';
			}
			
			if (isset($this->request->server['HTTP_ACCEPT_LANGUAGE'])) {
				$data['accept_language'] = $this->request->server['HTTP_ACCEPT_LANGUAGE'];	
			} else {
				$data['accept_language'] = '';
			}

            $data['shipping_depart'] = "";

            if (isset($this->session->data['depart_id'])) {
                $depart = $this->model_localisation_depart->getDepart($this->session->data['depart_id']);
                $data['shipping_depart'] = $depart['name'];
            }

			$this->load->model('checkout/order');
			
			$this->session->data['order_id'] = $this->model_checkout_order->addOrder($data);
			
			$this->data['column_name'] = $this->language->get('column_name');
			$this->data['column_model'] = $this->language->get('column_model');
			$this->data['column_quantity'] = $this->language->get('column_quantity');
			$this->data['column_price'] = $this->language->get('column_price');
			$this->data['column_total'] = $this->language->get('column_total');
            $this->data['column_foto'] = $this->language->get('column_foto');
            $this->data['text_birthday'] = $this->language->get('text_birthday');

            $this->data['products'] = $product_data;

            $data['shipping_depart'] = "";

            if ($this->request->post['depart_id']) {
                $depart = $this->model_localisation_depart->getDepart($this->request->post['depart_id']);
                $data['shipping_depart'] = $depart['name'];
            }

            $data['shipping_city'] = "";

            if ($this->request->post['city_id']) {
                $city = $this->model_localisation_city->getCity($this->request->post['city_id']);
                $data['shipping_city'] = $city['name'];
            }

            $data['shipping_postcode'] = "";
            $data['shipping_zone'] = '';

            if ($this->request->post['zone_id']) {
                $zone = $this->model_localisation_zone->getZone($this->request->post['zone_id']);
                $data['shipping_zone'] = $zone['name'];
            }

			// Gift Voucher
			    $this->data['vouchers'] = array();
			
			if (!empty($this->session->data['vouchers'])) {
				foreach ($this->session->data['vouchers'] as $voucher) {
					$this->data['vouchers'][] = array(
						'description' => $voucher['description'],
						'amount'      => $this->currency->format($voucher['amount'])
					);
				}
			}  

            $this->data['total_data'] = $this->getTotalHtml($total_data);
            $this->data['payment'] = $this->getChild('payment/' . $this->session->data['payment_method']['code']);
		} else {
			$this->data['redirect'] = $redirect;
		}
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/confirm.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/checkout/confirm.tpl';
		} else {
			$this->template = 'default/template/checkout/confirm.tpl';
		}
		
		$this->response->setOutput($this->render());	
  	}

    public function total_data() {
        $this->load->model('setting/extension');

        ////////totals data
        $total_data = array();
        $total = 0;
        $taxes = $this->cart->getTaxes();
        $sort_order = array();

        $results = $this->model_setting_extension->getExtensions('total');

        foreach($results as $key => $value) {
            $sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
        }

        array_multisort($sort_order, SORT_ASC, $results);

        foreach($results as $result) {
            if($this->config->get($result['code'] . '_status')) {
                $this->load->model('total/' . $result['code']);

                $this->{'model_total_' . $result['code']}->getTotal($total_data, $total, $taxes);
            }
        }

        $sort_order = array();
        foreach($total_data as $key => $value) {
            $sort_order[$key] = $value['sort_order'];
        }

        array_multisort($sort_order, SORT_ASC, $total_data);
        return $total_data;
    }
}
?>