<?php
class ControllerCheckoutCheckout extends Controller {
	private $error = array();

	public function index() {
		$this->language->load('checkout/checkout');
		$this->load->model('tool/image');
        $this->load->model('localisation/zone');
        $this->load->model('localisation/country');
        $this->load->model('localisation/depart');
        $this->load->model('localisation/city');

		$this->data['text_checkout_option'] = $this->config->get('text_checkout_option');
		$this->data['text_checkout_account'] = $this->config->get('text_checkout_account');
		$this->data['text_checkout_payment_address'] = $this->config->get('text_checkout_payment_address');
		$this->data['text_checkout_payment_method'] = $this->config->get('text_checkout_payment_method');
        $this->data['text_checkout_confirm'] = $this->config->get('text_checkout_confirm');
        $this->data['text_none'] = ' --- Не выбрано --- ';
        $this->data['text_birthday'] = $this->language->get('text_birthday');
        $this->data['text_modify'] = $this->language->get('text_modify');

        $this->data['zones'] = array();
        $country_id = false;

        if ($this->config->get('novaposhta_status')) {
            $country_id = $this->model_localisation_country->getCountryByNovaPochta();

            if ($country_id) {
                $this->data['zones'] = $this->model_localisation_zone->getZonesByCountryId($country_id['country_id']);
            }
        }

        if ($this->config->get('novaposhta_status') == 0 || empty($this->data['zones'])) {
            unset($this->session->data['zone_price']);
            unset($this->session->data['nova_pochta']);
        }

        $this->data['zone_id'] = 0;
        $this->data['city_id'] = 0;
        $this->data['depart_id'] = 0;
        $this->data['cities'] = array();
        $this->data['departs'] = array();

        if (isset($this->session->data['zone_id'])) {
            $this->data['zone_id'] = $this->session->data['zone_id'];
            $this->data['cities'] = $this->model_localisation_city->getCitiesByZoneId($this->session->data['zone_id']);

            if ($this->config->get('novaposhta_status') || ($this->customer->isLogged() && $country_id && $this->session->data['shipping_country_id'] == $country_id['country_id'])) {
                $this->session->data['nova_pochta'] = true;
            }

            if (isset($this->session->data['city_id'])) {
                $this->data['city_id'] = $this->session->data['city_id'];
                $this->data['departs'] = $this->model_localisation_depart->getDepartsByCityId($this->session->data['city_id']);

                if (isset($this->session->data['depart_id'])) {
                    $this->data['depart_id'] = $this->session->data['depart_id'];
                }
            }
        }

        if (isset($this->request->post['firstname'])) {
            $this->session->data['firstname'] = $this->request->post['firstname'];
        }

        if (isset($this->request->post['lastname'])) {
            $this->session->data['lastname'] = $this->request->post['lastname'];
        }

        if (isset($this->request->post['email'])) {
            $this->session->data['email'] = $this->request->post['email'];
        }

        if (isset($this->request->post['telephone'])) {
            $this->session->data['telephone'] = $this->request->post['telephone'];
        }

        if (isset($this->request->post['comment'])) {
            $this->session->data['comment'] = $this->request->post['comment'];
        }

        if (isset($this->request->post['address_1'])) {
            $this->session->data['address_1'] = $this->request->post['address_1'];
        }

		////////redirect block
		if ((!$this->cart->hasProducts() && (!isset($this->session->data['vouchers']) || !$this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {
			$this->redirect($this->url->link('checkout/cart'));
		}

		$products = $this->cart->getProducts();

		foreach($products as $product) {
			$product_total = 0;

			foreach($products as $product_2) {
				if($product_2['product_id'] == $product['product_id']) {
					$product_total += $product_2['quantity'];
				}
			}

			if($product['minimum'] > $product_total) {
				$this->redirect($this->url->link('checkout/cart'));
			}
		}

		/////////products data
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

		/////////////// Gift Voucher
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

		////////shipping
		$shipping_address = array('country_id' => 0, 'zone_id' => 0);

		if($this->customer->isLogged() && isset($this->session->data['shipping_address_id'])) {
			$this->load->model('account/address');

			$shipping_address = $this->model_account_address->getAddress($this->session->data['shipping_address_id']);
		}

		$this->load->model('setting/extension');

		if(!isset($this->session->data['shipping_methods'])) {
			$quote_data = array();

			$results = $this->model_setting_extension->getExtensions('shipping');

			foreach($results as $result) {
				if($this->config->get($result['code'] . '_status') == 1) {
					$this->load->model('shipping/' . $result['code']);

					$quote = $this->{'model_shipping_' . $result['code']}->getQuote($shipping_address);

					if($quote) {
						$quote_data[$result['code']] = array(
							'title' => $quote['title'],
							'quote' => $quote['quote'],
							'sort_order' => $quote['sort_order'],
							'error' => $quote['error']
						);
					}
                }
			}

			$sort_order = array();

			foreach($quote_data as $key => $value) {
				$sort_order[$key] = $value['sort_order'];
			}

			array_multisort($sort_order, SORT_ASC, $quote_data);

			$this->session->data['shipping_methods'] = $quote_data;
		}

		if (isset($this->session->data['shipping_methods']) && count($this->session->data['shipping_methods'])>0) {
			$this->data['shipping_methods'] = $this->session->data['shipping_methods'];
			if (!isset($this->session->data['shipping_method']['code'])) {
				$method_keys = array_keys($this->session->data['shipping_methods']);
				$first_method = array_shift($method_keys);
				$this->session->data['shipping_method'] = $this->session->data['shipping_methods'][$first_method]['quote'][$first_method];
			}
			$this->data['code'] = $this->session->data['shipping_method']['code'];
		} else {
			$this->data['shipping_methods'] = array();
			$this->data['code'] = '';
		}

        ////////totals data
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

        ////////do checkout
		if(($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			if(isset($this->request->post['shipping_method'])) {
				$shipping = explode('.', $this->request->post['shipping_method']);
				$this->session->data['shipping_method'] = $this->session->data['shipping_methods'][$shipping[0]]['quote'][$shipping[1]];
			}

			$data = array();

			$data['invoice_prefix'] = $this->config->get('config_invoice_prefix');
			$data['store_id'] = $this->config->get('config_store_id');
			$data['store_name'] = $this->config->get('config_name');

			if($data['store_id']) {
				$data['store_url'] = $this->config->get('config_url');
			} else {
				$data['store_url'] = HTTP_SERVER;
			}
			$data['customer_id'] = 0;
			$data['customer_group_id'] = $this->config->get('config_customer_group_id');

			if($this->customer->isLogged()) {
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
			$data['shipping_address_1'] = $this->request->post['address_1'];

			$data['payment_company'] = "";
			$data['shipping_company'] = "";
			$data['payment_address_2'] = "";
			$data['payment_city'] = "";
			$data['payment_postcode'] = "";
			$data['payment_zone'] = "";
			$data['payment_zone_id'] = "";
			$data['payment_country'] = "";
			$data['payment_country_id'] = "";
			$data['payment_address_format'] = "";

			$data['shipping_firstname'] = $this->request->post['firstname'];
			$data['shipping_lastname'] = $this->request->post['lastname'];
			$data['shipping_address_2'] = "";

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

			$data['shipping_zone_id'] = '';
			$data['shipping_country'] = "";
            $data['shipping_country_id'] = "";

            if ($country_id && isset($this->session->data['nova_pochta'])) {
                $data['shipping_country'] = $country_id['name'];
            }

            $data['payment_company_id'] = "";
            $data['payment_tax_id'] = "";
			$data['payment_code'] = "";
			$data['shipping_code'] = "";

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

			if(isset($this->session->data['shipping_method']['title'])) {
				$data['shipping_method'] = $this->session->data['shipping_method']['title'];
			} else {
				$data['shipping_method'] = '';
			}
			$data['payment_method'] = '';

			$data['shipping_address_format'] = '{firstname} {lastname} {address_1}';

			$data['products'] = $product_data;
			$data['vouchers'] = $voucher_data;

			$data['totals'] = $total_data;
			$data['comment'] = $this->request->post['comment'];
			$data['total'] = $total;
			//$data['reward'] = $this->cart->getTotalRewardPoints();

			if(isset($this->request->cookie['tracking'])) {
				$this->load->model('affiliate/affiliate');

				$affiliate_info = $this->model_affiliate_affiliate->getAffiliateByCode($this->request->cookie['tracking']);

				if($affiliate_info) {
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

			$this->load->model('checkout/order');
			$order_id = $this->model_checkout_order->addOrder($data);
			$this->model_checkout_order->confirm($order_id, $this->config->get('config_order_status_id'));

            if (in_array($this->customer->getGift(), $products_id)) {
                $this->customer->setGift('');
                $this->customer->setDateGetGift(date("Y-m-d"));
            }

			$this->cart->clear();
			unset($this->session->data['shipping_method']);
			unset($this->session->data['shipping_methods']);
			unset($this->session->data['payment_method']);
			unset($this->session->data['payment_methods']);
			unset($this->session->data['guest']);
			unset($this->session->data['comment']);
			unset($this->session->data['order_id']);
			unset($this->session->data['coupon']);
			unset($this->session->data['reward']);
			unset($this->session->data['voucher']);
            unset($this->session->data['vouchers']);

			$json["status"] = "success";
			$json["redirect"] = $this->url->link('checkout/success');
			$this->response->setOutput(json_encode($json));
			return;
		}

		////////breadcrumbs block
		$this->breadcrumbs();

		$this->data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_cart'),
			'href' => $this->url->link('checkout/cart'),
			'separator' => $this->language->get('text_separator')
		);

		$this->data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('checkout/checkout', '', 'SSL'),
			'separator' => $this->language->get('text_separator')
		);

		////////language block
		$this->document->setTitle($this->language->get('heading_title'));
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['entry_telephone'] = $this->language->get('entry_telephone');
		$this->data['entry_email'] = $this->language->get('entry_email');
		$this->data['entry_company'] = $this->language->get('entry_company');
		$this->data['entry_comment'] = $this->language->get('entry_comment');
		$this->data['entry_address_1'] = $this->language->get('entry_address_1');

		$this->data['button_confirm'] = $this->language->get('button_confirm');
		$this->data['button_continue'] = $this->language->get('button_continue');

		$this->data['text_shipping_method'] = $this->language->get('text_shipping_method');

		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_foto'] = $this->language->get('column_foto');
		$this->data['column_model'] = $this->language->get('column_model');
		$this->data['column_quantity'] = $this->language->get('column_quantity');
		$this->data['column_price'] = $this->language->get('column_price');
		$this->data['column_total'] = $this->language->get('column_total');

		$this->data['total_data'] = $this->getTotalHtml($total_data);

		$this->data['products'] = $product_data;
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

		if($this->error) {
			$json['errors'] = $this->error;
			$this->response->setOutput(json_encode($json));
			return;
		}

		$this->data['firstname'] = "";
		$this->data['lastname'] = "";
		$this->data['email'] = "";
		$this->data['telephone'] = "";
		$this->data['company'] = "";
		$this->data['address_1'] = "";

		if ($this->customer->isLogged()) {
			$this->data['firstname'] = $this->customer->getFirstName();
			$this->data['lastname'] = $this->customer->getLastName();
			$this->data['email'] = $this->customer->getEmail();
			$this->data['telephone'] = $this->customer->getTelephone();
			$this->data['fax'] = $this->customer->getFax();

			$this->load->model('account/address');
			$address = $this->model_account_address->getAddress($this->session->data['shipping_address_id']);
			$this->data['company'] = $address['company'];
			$this->data['address_1'] = $address['address_1'];
		}

		if (isset($this->session->data['firstname'])) {
			$this->data['firstname'] = $this->session->data['firstname'];
		}

		if (isset($this->session->data['lastname'])) {
			$this->data['lastname'] = $this->session->data['lastname'];
		}

		if (isset($this->session->data['email'])) {
			$this->data['email'] = $this->session->data['email'];
		}

		if( isset($this->session->data['telephone'])) {
			$this->data['telephone'] = $this->session->data['telephone'];
		}

		$this->data['comment'] = "";

		if (isset($this->session->data['comment'])) {
			$this->data['comment'] = $this->session->data['comment'];
		}

		$this->data['entry_firstname'] = $this->language->get('entry_firstname');
		$this->data['entry_lastname'] = $this->language->get('entry_lastname');

		if (isset($this->session->data['address_1'])) {
			$this->data['address_1'] = $this->session->data['address_1'];
		}

		$this->fileRender('/template/checkout/checkout.tpl');
	}

	public function change_shipping() {
		$json = array();

		if(isset($this->request->post['shipping_method'])) {
			$shipping = explode('.', $this->request->post['shipping_method']);
			$this->session->data['shipping_method'] = $this->session->data['shipping_methods'][$shipping[0]]['quote'][$shipping[1]];
		}

		$json['totals_data'] = $this->getTotalHtml();
		$this->response->setOutput(json_encode($json));
	}

	public function validate() {
        $this->language->load('checkout/checkout');

        if((utf8_strlen($this->request->post['firstname']) < 1) || (utf8_strlen($this->request->post['firstname']) > 64)) {
			$this->error['firstname'] = $this->language->get('error_firstname');
		}

		if((utf8_strlen($this->request->post['lastname']) < 1) || (utf8_strlen($this->request->post['lastname']) > 64)) {
			$this->error['lastname'] = $this->language->get('error_lastname');
		}

		if((utf8_strlen($this->request->post['address_1']) < 3) || (utf8_strlen($this->request->post['address_1']) > 128)) {
			$this->error['address_1'] = $this->language->get('error_address_1');
		}

		if((utf8_strlen($this->request->post['email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['email'])) {
			$this->error['email'] = $this->language->get('error_email');
		}

		if((utf8_strlen($this->request->post['telephone']) < 3) || (utf8_strlen($this->request->post['telephone']) > 32)) {
			$this->error['telephone'] = $this->language->get('error_telephone');
		}

        if (isset($this->request->post['zone_id']) && $this->request->post['zone_id'] != 0) {
            if ($this->request->post['city_id'] == 0) {
                $this->error['city_id'] = $this->language->get('text_error_city');
            }

            if ($this->request->post['depart_id'] == 0) {
                $this->error['depart_id'] = $this->language->get('text_error_depart');
            }
        }

        $json['errors'] = '';

        if ($this->error) {
            $json['errors'] = $this->error;
        }

        return $this->response->setOutput(json_encode($json));
    }

    public function zone() {
        unset($this->session->data['zone_price']);
        unset($this->session->data['nova_pochta']);
        unset($this->session->data['zone_id']);

        if ($this->request->get['zone_id'] != 0) {
            $this->session->data['nova_pochta'] = true;
            $this->session->data['zone_id'] = $this->request->get['zone_id'];
        }

        $json = array();

        $this->load->model('localisation/zone');

        $zone_info = $this->model_localisation_zone->getZone($this->request->get['zone_id']);

        if ($zone_info) {
            $this->load->model('localisation/city');

            if ($zone_info['zone_price'] != 0) {
                $this->session->data['zone_price'] = $zone_info['zone_price'];
            }

            $json = array(
                'zone_id'   => $zone_info['zone_id'],
                'name'      => $zone_info['name'],
                'city'      => $this->model_localisation_city->getCitiesByZoneId($this->request->get['zone_id']),
                'status'    => $zone_info['status']
            );
        }

        $shipping_address = array('country_id' => 0, 'zone_id' => 0);

        if($this->customer->isLogged() && isset($this->session->data['shipping_address_id'])) {
            $this->load->model('account/address');

            $shipping_address = $this->model_account_address->getAddress($this->session->data['shipping_address_id']);
        }

        $this->load->model('setting/extension');
        $quote_data = array();
        $results = $this->model_setting_extension->getExtensions('shipping');

        foreach($results as $result) {
            if($this->config->get($result['code'] . '_status') == 1) {
                $this->load->model('shipping/' . $result['code']);

                $quote = $this->{'model_shipping_' . $result['code']}->getQuote($shipping_address);

                if($quote) {
                    $quote_data[$result['code']] = array(
                        'title' => $quote['title'],
                        'quote' => $quote['quote'],
                        'sort_order' => $quote['sort_order'],
                        'error' => $quote['error']
                    );
                }
            }
        }

        $sort_order = array();

        foreach($quote_data as $key => $value) {
            $sort_order[$key] = $value['sort_order'];
        }

        array_multisort($sort_order, SORT_ASC, $quote_data);

        $this->session->data['shipping_methods'] = $quote_data;

        if (isset($this->session->data['shipping_methods']) && count($this->session->data['shipping_methods'])>0) {
            $this->data['shipping_methods'] = $this->session->data['shipping_methods'];
            if (!isset($this->session->data['shipping_method']['code'])) {
                $method_keys = array_keys($this->session->data['shipping_methods']);
                $first_method = array_shift($method_keys);
                $this->session->data['shipping_method'] = $this->session->data['shipping_methods'][$first_method]['quote'][$first_method];
            }
        }

        $this->response->setOutput(json_encode($json));
    }

    public function city() {
        $json = array();
        unset($this->session->data['city_id']);

        if ($this->request->get['city_id'] != 0) {
            $this->session->data['city_id'] = $this->request->get['city_id'];
        }

        $this->load->model('localisation/city');
        $city_info = $this->model_localisation_city->getCity($this->request->get['city_id']);

        if ($city_info) {
            $this->load->model('localisation/depart');

            if ($city_info['zone_price'] != 0) {
                $this->session->data['zone_price'] = $city_info['zone_price'];
            }

            $json = array(
                'city_id'   => $city_info['city_id'],
                'name'      => $city_info['name'],
                'depart'    => $this->model_localisation_depart->getDepartsByCityId($this->request->get['city_id']),
                'status'    => $city_info['status']
            );
        }

        $this->response->setOutput(json_encode($json));
    }

    public function depart() {
        unset($this->session->data['depart_id']);

        if ($this->request->get['depart_id'] != 0) {
            $this->session->data['depart_id'] = $this->request->get['depart_id'];
        }

        $total_data = $this->total_data();
        $total_data = $this->getTotalHtml($total_data);
        $this->response->setOutput($total_data);
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