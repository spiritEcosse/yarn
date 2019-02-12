<?php  
setlocale(LC_ALL,'ru_RU.utf8','ru_RU','rus');

class ControllerProductProduct extends Controller {
	private $error = array(); 
	
	public function index() {
        $this->language->load('product/product');
        $this->language->load('product/category');
		$this->load->model('catalog/category');
		$this->load->model('catalog/manufacturer');
		$this->load->model('catalog/product');
		$this->load->model('catalog/review');
		$this->load->model('tool/image');
		$this->load->model('catalog/GALKAGraboCount');
		$this->load->model('catalog/information');
		$this->addScriptSample();
		
		$this->totals($this->request->post);

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_catalog'),
            'href'      => $this->url->link('product/catalog'),
            'separator' => $this->language->get('text_separator')
        );

		$this->document->addScript('catalog/view/theme/' . $this->config->get('config_template') . '/js/cloud-zoom.1.0.2.min.js');	
		$this->document->addStyle('catalog/view/theme/' . $this->config->get('config_template') . '/js/cloud-zoom.css');

        $url = '';

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        if (isset($this->request->get['limit'])) {
            $url .= '&limit=' . $this->request->get['limit'];
        }

        if (isset($this->request->get['filterpro_special'])) {
            $url .= '&filterpro_special=' . $this->request->get['filterpro_special'];
        }

		if (isset($this->request->get['path'])) {
			$path = '';
				
			foreach (explode('_', $this->request->get['path']) as $path_id) {
				if (!$path) {
					$path = $path_id;
				} else {
					$path .= '_' . $path_id;
				}
				
				$category_info = $this->model_catalog_category->getCategory($path_id);
				
				if ($category_info) {
					$this->data['breadcrumbs'][] = array(
						'text'      => $category_info['name'],
						'href'      => $this->url->link('product/category', 'path=' . $path . $url),
                        'separator' => $this->language->get('text_separator')
					);
				}
			}
		}

        if (isset($this->request->get['product_id'])) {
			$product_id = $this->request->get['product_id'];
		} else {
			$product_id = 0;
		}
		
		$product_info = $this->model_catalog_product->getProduct($product_id);
		
		$this->data['product_info'] = $product_info;

		if ($product_info) {
			if (isset($this->request->get['path'])) {
				$url .= '&path=' . $this->request->get['path'];
			}

			$this->data['href_item'] = $this->url->link('product/product', $url . '&product_id=' . $this->request->get['product_id']);

			$this->data['breadcrumbs'][] = array(
				'text'      => $product_info['name'],
				'href'      => $this->url->link('product/product', $url . '&product_id=' . $this->request->get['product_id']),
				'separator' => $this->language->get('text_separator')
			);
			
			if ($product_info['seo_title']) {
				$this->document->setTitle($product_info['seo_title']);
			} else {
				$this->document->setTitle($product_info['name']);
			}
			
			$this->document->setDescription($product_info['meta_description']);
			$this->document->setKeywords($product_info['meta_keyword']);
			$this->document->addLink($this->url->link('product/product', 'product_id=' . $this->request->get['product_id']), 'canonical');
			
			$this->data['seo_h1'] = $product_info['seo_h1'];

			$this->data['heading_title'] = $product_info['name'];
			
			$this->data['entry_name'] = $this->language->get('entry_name');
			$this->data['entry_review'] = $this->language->get('entry_review');
			$this->data['entry_rating'] = $this->language->get('entry_rating');
			$this->data['entry_good'] = $this->language->get('entry_good');
			$this->data['entry_bad'] = $this->language->get('entry_bad');
			$this->data['entry_captcha'] = $this->language->get('entry_captcha');
			
			$this->data['button_upload'] = $this->language->get('button_upload');
			$this->data['tab_description'] = $this->language->get('tab_description');
			$this->data['tab_attribute'] = $this->language->get('tab_attribute');
			$this->data['tab_review'] = sprintf($this->language->get('tab_review'), $this->model_catalog_review->getTotalReviewsByProductId($this->request->get['product_id']));
			$this->data['tab_related'] = $this->language->get('tab_related');
			$this->data['tab_delivery'] = $this->language->get('tab_delivery');
                        
			$this->data['product_id'] = $this->request->get['product_id'];
			$this->data['manufacturer'] = $product_info['manufacturer'];
			$this->data['manufacturers'] = $this->url->link('product/manufacturer', 'manufacturer_id=' . $product_info['manufacturer_id']);
			$this->data['model'] = $product_info['product_id'];
            $this->data['price_status'] = $product_info['price_status'];

            $this->data['text_select'] = $this->language->get('text_select');
			$this->data['text_reward'] = $this->language->get('text_reward');
			$this->data['text_discount'] = $this->language->get('text_discount');
			$this->data['text_stock'] = $this->language->get('text_stock');
			$this->data['text_option'] = $this->language->get('text_option');
			$this->data['text_qty'] = $this->language->get('text_qty');
			$this->data['text_minimum'] = sprintf($this->language->get('text_minimum'), $product_info['minimum']);
			$this->data['text_or'] = $this->language->get('text_or');
			$this->data['text_write'] = $this->language->get('text_write');
			$this->data['text_note'] = $this->language->get('text_note');
			$this->data['text_share'] = $this->language->get('text_share');
            $this->data['text_wait'] = $this->language->get('text_wait');
            $this->data['text_vk'] = $this->language->get('text_vk');
            $this->data['text_classmates'] = $this->language->get('text_classmates');
            $this->data['text_facebook'] = $this->language->get('text_facebook');
            $this->data['text_info'] = $this->language->get('text_info');
            $this->data['text_users_selected'] = $this->language->get('text_users_selected');
            $this->data['text_welcome'] = sprintf($this->language->get('text_welcome'), $this->url->link('account/login', '', 'SSL'), $this->url->link('account/register', '', 'SSL'));
            $this->data['text_birthday'] = $this->language->get('text_birthday');
            $this->data['text_file_comment'] = $this->language->get('text_file_comment');
            $this->data['text_file_upload'] = $this->language->get('text_file_upload');
            $this->data['text_next'] = $this->language->get('text_next');
            $this->data['text_prev'] = $this->language->get('text_prev');

            $this->data['entry_comment'] = $this->language->get('entry_comment');
            $this->data['button_write'] = $this->language->get('button_write');

            $this->data['theme'] = $this->config->get('config_template');

            $this->getText();

            $this->data['price_after_name'] = '';

			$this->data['link_cart'] = $this->url->link('checkout/cart');

            if ($product_info['price_after_name'] != NULL) {
		        $this->data['price_after_name'] = $product_info['price_after_name'];
		    }
		    
		    $this->data['price_prefix_name'] = '';
		    
		    if ($product_info['price_prefix_name'] != NULL) { 
				$this->data['price_prefix_name'] = $product_info['price_prefix_name'];
			}

            if ($this->customer->isLogged()) {
                $this->data['text_login']     = $this->customer->getFirstName() . " " . $this->customer->getLastName();
                $this->data['captcha_status'] = false;
                $this->data['customer_id']    = $this->customer->getId();
            } else {
                $this->data['text_login']     = $this->language->get('text_anonymus');
                $this->data['captcha_status'] = true;
            }

			$this->data['reward'] = $product_info['reward'];
			$this->data['points'] = $product_info['points'];

            $next_prod = $this->model_catalog_product->getNextProd($product_id);
            $prev_prod = $this->model_catalog_product->getPrevProd($product_id);
            $this->data['next'] = $this->url->link('product/product', $url . '&product_id=' . $next_prod);
            $this->data['prev'] = $this->url->link('product/product', $url . '&product_id=' . $prev_prod);

            if ($product_info['quantity'] <= 0) {
				$this->data['stock'] = $product_info['stock_status'];
			} elseif ($this->config->get('config_stock_display')) {
				$this->data['stock'] = $product_info['quantity'];
			} else {
				$this->data['stock'] = $this->language->get('text_instock');
			}
			
			$this->data['stock'] = $product_info['stock_status'];
			$this->data['filters'] = array();
			$options = $this->model_catalog_product->getProductOptionsFilter($product_id);

			foreach ($options as $option) {
				$values = $this->model_catalog_product->getProductValuesFilter($product_id, $option['option_id']);
                $option_value = array();

				foreach ($values as $key => $value) {
					$option_value[] = $value['name'];
				}

				if (count($values) > 0) {
					$this->data['filters'][] = array(
						'option_id' => $option['option_id'],
						'option_name' => $option['name'],
						'values' => implode(", ", $option_value)
					);
				}
			}

			$this->data['startdate'] = $product_info['date_added'];
			$this->data['images'] = array();

            if ($product_info['image']) {
                $this->data['popup'] = $this->model_tool_image->resize($product_info['image'], $this->config->get('config_image_popup_width'), $this->config->get('config_image_popup_height'));
                $this->data['thumb'] = $this->model_tool_image->resize($product_info['image'], $this->config->get('config_image_thumb_width'), $this->config->get('config_image_thumb_height'));
                $this->data['smallimage'] = $this->model_tool_image->resize($product_info['image'],  $this->config->get('config_image_thumb_width'), $this->config->get('config_image_thumb_height'));

                $this->data['images'][] = array(
                    'popup' => $this->model_tool_image->resize($product_info['image'], $this->config->get('config_image_popup_width'), $this->config->get('config_image_popup_height')),
                    'thumb' => $this->model_tool_image->resize($product_info['image'], $this->config->get('config_image_additional_width'), $this->config->get('config_image_additional_height')),
                    'smallimage' => $this->model_tool_image->resize($product_info['image'],  $this->config->get('config_image_thumb_width'), $this->config->get('config_image_thumb_height')),
                    'thumb_replace' => $this->model_tool_image->resize($product_info['image'], $this->config->get('config_image_thumb_width'), $this->config->get('config_image_thumb_height'))
                );
            } else {
                $this->data['popup'] = '';
                $this->data['thumb'] = '';
            }

			$results = $this->model_catalog_product->getProductImages($this->request->get['product_id']);
			
			foreach ($results as $result) {
				$this->data['images'][] = array(
					'popup' => $this->model_tool_image->resize($result['image'], $this->config->get('config_image_popup_width'), $this->config->get('config_image_popup_height')),
					'thumb' => $this->model_tool_image->resize($result['image'], $this->config->get('config_image_additional_width'), $this->config->get('config_image_additional_height')),
					'smallimage' => $this->model_tool_image->resize($result['image'],  $this->config->get('config_image_thumb_width'), $this->config->get('config_image_thumb_height')),
                    'thumb_replace' => $this->model_tool_image->resize($result['image'], $this->config->get('config_image_thumb_width'), $this->config->get('config_image_thumb_height'))
                );
			}

            $this->data['special'] = false;
            $this->data['price'] = $this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax'));
            $special_price = false;

            if ((float)$product_info['special']) {
                $this->data['special'] = $this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax'));
                $special_price = $this->data['special'];
            } else if ((float)$product_info['discount']) {
                $special_price = $this->tax->calculate($product_info['discount'], $product_info['tax_class_id'], $this->config->get('config_tax'));
            }

            if ($special_price && $this->data['price']) {
                $this->data['special'] = $this->currency->format($special_price, $product_info['code'], 1);
                $this->data['sale'] = round(100 - (($special_price / $this->data['price']) * 100), 1);
            }

            if ($this->data['price']) {
                $this->data['price'] = $this->currency->format($this->data['price'], $product_info['code'], 1);
            }

			$special = $this->model_catalog_product->getProductSpecial($product_info['product_id']);
			$product_special_id = null;

			if ($special) {
				if ($special['date_start']) {
					$this->data['date_start'] = $special['date_start'];
				}

				if ($special['date_end']) {
					$this->data['special_date_end'] = $special['date_end'];
				}

				if ($special['product_special_id']) {
					$product_special_id = $special['product_special_id'];
				}
			}

			if ($this->config->get('config_tax')) {
				$this->data['tax'] = $this->currency->format((float)$product_info['special'] ? $product_info['special'] : $product_info['price'], $product_info['code'], 1);
			} else {
				$this->data['tax'] = false;
			}

            $specials_date = $this->model_catalog_GALKAGraboCount->getProductDiscountDates($product_info['product_id']);
            $discount_date = $this->model_catalog_GALKAGraboCount->getProductSpecialDates($product_info['product_id']);
			$specials_purchased = $this->model_catalog_GALKAGraboCount->getVouchersBought($product_info['product_id']);

			$this->data['quantity_start'] = $product_info['quantity'];

            $label_special = false;
            $label_discount = false;
            $special_date_end = false;
            $label_special_for_you = false;

            if ($this->config->get('GALKAControl_status') == 1 && $this->config->get('GALKAControl_countdown') == 1) {
                if ($specials_date['date_end']) {
                    $special_date_end = $specials_date['date_end'];
                    $label_special = true;
                } else if ($discount_date['date_end']) {
                    $special_date_end = $discount_date['date_end'];
                    $label_discount = true;
                }

                if ($special_date_end) {
                    list($year, $month, $day) = explode('-', $special_date_end);
                    $special_date_end = $year . ', ' . $month . ' - 1, ' . $day;
                }
            }

			$this->data['date_end'] = $special_date_end;
            $this->data['label_special'] = $label_special;
            $this->data['label_discount'] = $label_discount;
            $this->data['label_special_for_you'] = $label_special_for_you;
			$this->data['quantity_start'] =  $specials_purchased['quantity_purchased'];

			$this->data['discounts'] = array();

			$product_table = $this->model_catalog_product->getProductTable($this->request->get['product_id'], $product_special_id);
			$product_fabric = $this->model_catalog_product->getProductFabric($this->request->get['product_id']);
	        $table = $this->getTable($product_table, $product_fabric, $product_info['tax_class_id'], $this->config->get('config_tax'), $this->request->get['product_id'], $product_info);
			$description = html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8');

			if ($this->config->get('config_template') == 'default') {
				$descr_plaintext = $description;
	            $cut_start = strpos($descr_plaintext, '</table', 0);

	            $description_top = mb_strcut($descr_plaintext, 0, $cut_start, 'UTF-8');
	            $description_bottom = mb_strcut($descr_plaintext, $cut_start, strlen($descr_plaintext), 'UTF-8');
	            
	            $description = $description_top;
	            $description .= $table;
	            $description .= $description_bottom;
			} elseif ($this->config->get('config_template') == 'GALKA') {
				$this->data['table'] = $table;
			}

			$this->data['description'] = $description;

			if ($product_info['minimum']) {
				$this->data['minimum'] = $product_info['minimum'];
			} else {
				$this->data['minimum'] = MINIMUM;
			}
			
			$this->data['review_status'] = $this->config->get('config_review_status');
			$this->data['reviews'] = sprintf($this->language->get('text_reviews'), (int)$product_info['reviews']);
			$this->data['rating'] = (int)$product_info['rating'];
            $this->data['attribute_groups'] = $this->model_catalog_product->getProductAttributes($this->request->get['product_id']);
            
            $category_id = $this->model_catalog_category->getCategroyByProduct($product_info['product_id']);
            
			$path = $this->model_catalog_category->treeCategory($category_id);
			$path = array_reverse($path);
			$path = implode('_', $path);
			
            $this->data['link_base'] = false;
            
			if ($path) {
            	$this->data['link_base'] = $this->url->link('product/category', 'path=' . $path);
        	}
        	
            $this->data['tabs'] = false;
            
            foreach ($this->model_catalog_information->getCategories($category_id) as $result) {
                $result['description'] = html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8');
                
                if ($result['product']) {
                    $tabs_id = trim($result['title']);
                    $tabs_id = preg_replace("/\s+/", "-", $tabs_id);
                    
                    $this->data['tabs'][] = array(
                        'name'          => $result['title'],
                        'id'            => $this->translitIt($tabs_id),
                        'description'   => $result['description']
                    );
                }
            }
            
            for ( $i=1; $i< 6; $i++) {
				$this->data['product_tabs_' . $i] = array();
			}

			$product_tabs = $this->model_catalog_product->getProductTabs($this->request->get['product_id']);

			foreach ($product_tabs as $product_tab) {
				$this->data['product_tabs_' . $product_tab['position']][] = array(
					'tab_id' => $product_tab['tab_id'],
					'name'   => $product_tab['name'],
					'text'   => html_entity_decode($product_tab['text'], ENT_QUOTES, 'UTF-8')
				);
			}

			$results = $this->model_catalog_product->getProductRelated($this->request->get['product_id']);
			$products = array();

			foreach ($results as $value) {
				$products[] = $value['product_id'];
            }

            $this->data['page'] = 1;

            if (isset($this->request->get['page'])) {
                $this->data['page'] = $this->request->get['page'];
            }

            $this->data['sorting'] = 1;

            if (isset($this->request->get['sorting'])) {
                $this->data['sorting'] = $this->request->get['sorting'];
            }

            $setting = array('image_width' => $this->config->get('config_image_related_width'), 'image_height' => $this->config->get('config_image_related_height'));
			$data = array('products' => $products, 'setting' => $setting);
			$this->data['products'] = $this->getDataProducts($data);

			$this->data['tags'] = array();
					
			$results = $this->model_catalog_product->getProductTags($this->request->get['product_id']);
			
			foreach ($results as $result) {
				$this->data['tags'][] = array(
					'tag'  => $result['tag'],
                    'href' => $this->url->link('product/search', 'filter_name=' . $result['tag'])
				);
			}

            $this->load->model('design/layout');
            $modules = $this->config->get('GALKAalso_bought_module');

            if ($this->request->get['route'] == 'product/product' && isset($request_get['product_id'])) {
                $layout_id = $this->model_catalog_product->getProductLayoutId($request_get['product_id']);
            } else {
                $layout_id = $this->model_design_layout->getLayout($this->request->get['route']);
            }

            $module_data = array();

            foreach ($modules as $module) {
                if ($module['status'] && $module['position'] == 'column_right' && $module['layout_id'] == $layout_id) {
                    $module_data[] = array(
                        'code'       => 'GALKAalso_bought',
                        'setting'    => $module,
                        'sort_order' => $module['sort_order']
                    );
                }
            }

            $sort_order = array();

            foreach ($module_data as $key => $value) {
                $sort_order[$key] = $value['sort_order'];
            }

            array_multisort($sort_order, SORT_ASC, $module_data);
            $this->data['people_bought_products'] = array();

            foreach ($module_data as $module) {
                $products = $this->getChild('module/' . $module['code'], $module['setting']);

                if ($products) {
                    $this->data['people_bought_products'][] = $products;
                }
            }

            $this->data['discount_birthday'] = null;
            $this->data['warning_birthday_product'] = false;

            if (in_array($product_id, $this->config->get('discount_birthday_days_products'))) {
                $this->data['discount_birthday'] = $this->customer->getDiscountByDateBirthday();

                if ($this->data['discount_birthday'] != null) {
                    $total_cart = (int)$this->cart->getTotal();

                    if ($this->config->get('discount_birthday_total_price') > $total_cart) {
                        $this->data['warning_birthday_product'] = sprintf($this->language->get('warning_birthday_product'), $this->currency->format($this->config->get('discount_birthday_total_price'), $product_info['code'], 1));
                    }
                }
            }

            $this->data['options'] = array();

            foreach ($this->model_catalog_product->getProductOptions($this->request->get['product_id']) as $option) {
                if ($option['type'] == 'select' || $option['type'] == 'radio' || $option['type'] == 'checkbox' || $option['type'] == 'image') {
                    $option_value_data = array();

                    foreach ($option['option_value'] as $option_value) {
                        if (!$option_value['subtract']) {
                            $option_value_data[] = array(
                                'product_option_value_id' => $option_value['product_option_value_id'],
                                'option_value_id'         => $option_value['option_value_id'],
                                'name'                    => $option_value['name'],
                                'price'                   => (float)$option_value['price'] ? $this->currency->format($this->tax->calculate($option_value['price'], $product_info['tax_class_id'], $this->config->get('config_tax'))) : false,
                                'price_prefix'            => $option_value['price_prefix'],
                                'popup'                   => $this->model_tool_image->resize($option_value['image'], $this->config->get('config_image_popup_width'), $this->config->get('config_image_popup_height')),
                                'image'                   => $this->model_tool_image->resize($option_value['image'], 100, 100)
                            );
                        }
                    }

                    $this->data['options'][] = array(
                        'product_option_id' => $option['product_option_id'],
                        'option_id'         => $option['option_id'],
                        'name'              => $option['name'],
                        'type'              => $option['type'],
                        'option_value'      => $option_value_data,
                        'required'          => $option['required']
                    );
                } elseif ($option['type'] == 'text' || $option['type'] == 'textarea' || $option['type'] == 'file' || $option['type'] == 'date' || $option['type'] == 'datetime' || $option['type'] == 'time') {
                    $this->data['options'][] = array(
                        'product_option_id' => $option['product_option_id'],
                        'option_id'         => $option['option_id'],
                        'name'              => $option['name'],
                        'type'              => $option['type'],
                        'option_value'      => $option['option_value'],
                        'required'          => $option['required']
                    );
                }
            }

            $product_prices = $this->model_catalog_product->getProductPrice($this->request->get['product_id']);
			$this->data['product_prices'] = array();

			foreach ($product_prices as $product_price) {
				$this->data['product_prices'][] = array(
					'product_price' => $this->currency->format($this->tax->calculate($product_price['product_price'], $product_info['tax_class_id'], $this->config->get('config_tax')), $product_info['code'], 1),
					'name' => $product_price['name'],
					'product_price_id'	=> $product_price['product_price_id']
					);
			}

            $this->model_catalog_product->updateViewed($this->request->get['product_id']);
			$file = '/template/product/product.tpl';
		} else {
			$url = '';
			
			if (isset($this->request->get['path'])) {
				$url .= '&path=' . $this->request->get['path'];
			}

      		$this->data['breadcrumbs'][] = array(
        		'text'      => $this->language->get('text_error'),
				'href'      => $this->url->link('product/product', $url . '&product_id=' . $product_id),
        		'separator' => $this->language->get('text_separator')
      		);

      		$this->document->setTitle($this->language->get('text_error'));
      		$this->data['heading_title'] = $this->language->get('text_error');
      		$this->data['text_error'] = $this->language->get('text_error');
      		$this->data['button_continue'] = $this->language->get('button_continue');
      		$this->data['continue'] = $this->url->link('common/home');

			$file = '/template/error/not_found.tpl';
    	}

		$this->fileRender($file);
  	}
	
	public function review() {
    	$this->language->load('product/product');
		$this->language->load('module/fastorder');
		$this->load->model('catalog/review');

		$this->data['text_on'] = $this->language->get('text_on');
		$this->data['text_no_reviews'] = $this->language->get('text_no_reviews');

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}  
		
		$this->data['reviews'] = array();
		
		$review_total = $this->model_catalog_review->getTotalReviewsByProductId($this->request->get['product_id']);
		$results = $this->model_catalog_review->getReviewsByProductId($this->request->get['product_id'], ($page - 1) * 5, 5);
      		
		foreach ($results as $result) {
        	$this->data['reviews'][] = array(
        		'author'     => $result['author'],
				'text'       => $result['text'],
				'rating'     => (int)$result['rating'],
        		'reviews'    => sprintf($this->language->get('text_reviews'), (int)$review_total),
        		'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added']))
        	);
      	}			
			
		$pagination = new Pagination();
		$pagination->total = $review_total;
		$pagination->page = $page;
		$pagination->limit = 5; 
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('product/product/review', 'product_id=' . $this->request->get['product_id'] . '&page={page}');
			
		$this->data['pagination'] = $pagination->render();
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/review.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/product/review.tpl';
		} else {
			$this->template = 'default/template/product/review.tpl';
		}
		
		$this->response->setOutput($this->render());
	}

	public function captcha() {
		$this->load->library('captcha');
		
		$captcha = new Captcha();
		
		$this->session->data['captcha'] = $captcha->getCode();
		
		$captcha->showImage();
	}

	public function getDesc() {
	    if (isset($this->request->get['product_id'])) {
			$this->language->load('product/product');
	        $this->load->model('catalog/product');
	        
	        $product_id = $this->request->get['product_id'];
	        
	        $product = $this->model_catalog_product->getDesc($product_id);
	    	$this->data['name'] = $this->language->get('text_error');
	        $this->data['description'] = false;
	        
	        if ($product) {
		        $this->data['name'] = $product['name'];
		        $this->data['description'] = html_entity_decode($product['description'], ENT_QUOTES, 'UTF-8');
		    }

	        $this->template = 'default/template/product/desc_fabric.tpl';
	        $this->response->setOutput($this->render());
	    }
	}

	public function getFabricValue() {
	    if (isset($this->request->get['product_id']) && isset($this->request->get['option_value_id']) && isset($this->request->get['option_id'])) {
	        $option_id = $this->request->get['option_id'];
	        $option_value_id = $this->request->get['option_value_id'];
	        $product_id = $this->request->get['product_id'];

	        $this->data['fabric_id'] = $option_value_id;
	        $this->data['fabric_name'] = $this->request->get['fabric_name'];

	        $this->load->model('catalog/product');

	        $this->data['fabric_values'] = $this->model_catalog_product->getProductFabricValue($product_id, $option_id, $option_value_id);

	        $this->template = 'default/template/product/fabric.tpl';
	        $this->response->setOutput($this->render());
	    }
	}

	function translitIt($str) {
	    $tr = array(
	        "А" => "A", "Б" => "B", "В" => "V", "Г" => "G",
	        "Д" => "D", "Е" => "E", "Ж" => "J", "З" => "Z", "И" => "I",
	        "Й" => "Y", "К" => "K", "Л" => "L", "М" => "M", "Н" => "N",
	        "О" => "O", "П" => "P", "Р" => "R", "С" => "S", "Т" => "T",
	        "У" => "U", "Ф" => "F", "Х" => "H", "Ц" => "TS", "Ч" => "CH",
	        "Ш" => "SH", "Щ" => "SCH", "Ъ" => "", "Ы" => "YI", "Ь" => "",
	        "Э" => "E", "Ю" => "YU", "Я" => "YA", "а" => "a", "б" => "b",
	        "в" => "v", "г" => "g", "д" => "d", "е" => "e", "ж" => "j",
	        "з" => "z", "и" => "i", "й" => "y", "к" => "k", "л" => "l",
	        "м" => "m", "н" => "n", "о" => "o", "п" => "p", "р" => "r",
	        "с" => "s", "т" => "t", "у" => "u", "ф" => "f", "х" => "h",
	        "ц" => "ts", "ч" => "ch", "ш" => "sh", "щ" => "sch", "ъ" => "y",
	        "ы" => "yi", "ь" => "", "э" => "e", "ю" => "yu", "я" => "ya"
	    );
	    return strtr($str, $tr);
	}

	public function getTable($product_table, $product_fabric, $tax_class_id, $config_tax, $product_id, $product_info) {
		$cache = md5(http_build_query(array($product_id)));
		$key_cache = 'product.getTable.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $cache;
		$table = $this->cache->get($key_cache);

		if ($table === false) {
	    	$table = '';
	    	$link = 'return hs.htmlExpand(this, { outlineType:';
		    $link .= '"rounded-white", wrapperClassName: "draggable-header", objectType: "ajax", width: "auto", height: "auto"} )';
			$symbol = '';

			if ($this->currency->getSymbolLeft($product_info['code']) != '' || $this->currency->getSymbolRight($product_info['code']) != '') {
				$symbol = ', ';

				if ($this->currency->getSymbolLeft($product_info['code']) != '') {
	            	$symbol .= $this->currency->getSymbolLeft($product_info['code']);
	            } elseif ($this->currency->getSymbolRight($product_info['code']) != '') {
	            	$symbol .= $this->currency->getSymbolRight($product_info['code']);
	            }
	        }

			$temp_option = array();
			foreach ($product_fabric as $data_option) {
				$temp_option[] = $data_option['option_id'];
			}

	    	foreach ($product_table['table'] as $number_table => $value) {
	            $count_option = 0;
	            $main_option_id = 0;
	            $horizont = false;
	            $vertical = false;
	            $option_value_horizont_array = array();
	            $option_value_vertical_array = array();
	            $main_option = true;
	            $option_horizont_array = array();
	            
	            if ($value['product_table_name'] != '') {
	            	$table .= '<div class="table_name">' . $value['product_table_name'] . ': </div>';
	            }
	            
	            $table .= '<div class="wrapp_table"><table class="category">';
	            $table .= '<thead>';
	            $table .= '<tr>';

	            foreach ($value['option_id'] as $option_id => $option) {
	                $rowspan = '';
	                $position = 'horizont';

	                if ($option['vertical'] == 1) {
	                    $rowspan = 2;
	                    $position = 'vertical';

	                    if ($main_option == true) {
	                        $count_option = count($option['product_table_option_value']);
	                        $main_option_id = $option_id;
	                    }

	                    $vertical = true;
	                } else {
	                    $horizont = true;
	                }

	            	$table .= '<td class="center" rowspan="' . $rowspan . '"';

	            	if ($option['vertical'] == 0 && count($option['product_table_option_value']) != 0) {
	            		$table .= 'colspan="' . $product_table_option_value = count($option['product_table_option_value']) . '"';
	            		$product_table_option_value += 1;
	            	} else {
	                    if ($option['count_image']['count(*)'] != 0) {
		            		$table .= 'colspan = "2"';
		            	}
	            	}
	                
	                $table .= '>' . $option['name'] . '</td>';
	                $main_option = false;
	            }

	            if ($vertical == true && $horizont == false) {
	                $table .= '<td class="center" rowspan="2">Цена' . $symbol . '</td>';
	            }

	            $table .= '</tr><tr>';
				
	            foreach ($value['option_id'] as $option_id => $main_value) {
	                if ($main_value['vertical'] == 0) {
	                	$option_horizont_array[] = $option_id;

	                	if (count($main_value['product_table_option_value']) == 0) {
	                		$table .= '<td></td>';
	                	}
	                	
	                    foreach ($main_value['product_table_option_value'] as $product_table_option_value) {
	                        $option_value_horizont_array[] = $product_table_option_value['option_value_id'];
	                        
	                        $table .= '<td class="center" >';
	                        $key_option = array_search($option_id, $temp_option);
	                        
	                        $result = $this->model_catalog_product->getProductFabricValue($product_id, $option_id, $product_table_option_value['option_value_id']);
	                        
	                        if (count($result) != 0 && $key_option !== FALSE && in_array($product_table_option_value['option_value_id'], $product_fabric[$key_option]['product_fabric_option_value'])) {
				                $table .= "<a id='active_link' onclick='" . $link . "'";
				                $table .= "href='http://" . $_SERVER['SERVER_NAME'] . "/index.php?route=product/product/getFabricValue&option_id=" . $option_id . "&option_value_id=" . $product_table_option_value['option_value_id'] . "&product_id=" . $product_id . "&fabric_name=" . $product_table_option_value['name'] . "' >";
		                		$table .= $product_table_option_value['name'];
		                		$table .= "</a>";
		                	} else {
		                		$table .= $product_table_option_value['name'];
		                	}
		                	
	                        $table .= '</td>';
	                    }
	                }
				}
				
	            $table .= '</tr></thead><tbody>';
	            $class = 'even';
	            
	            $colspan_price = 1;

	            foreach ($value['option_id'] as $option_id => $option) {
	            	if (count($option['product_table_option_value']) != 0) {
	            		$colspan_price += count($option['product_table_option_value']);
	            	} else {
	                    if ($option['count_image']['count(*)'] != 0) {
		            		$colspan_price += 1;
		            	}
	            	}

	                if ($option['vertical'] == 0) {
	                	$horizont = true;
	            	}
	            }

	            if ($horizont == true) {
	            	$table .= '<tr><td class="center" colspan="' . $colspan_price . '">Цена' . $symbol . '</td></tr>';
	            }

	            for ($count = 0; $count < $count_option; $count++ ) {
	                $table .=  '<tr class="' . $class . '">';

	                foreach ($value['option_id'] as $option_id => $option) {
	                    if ($option['vertical'] == 1) {
	                    	$rowspan = 1;

	                		foreach ($value['option_id'] as $option_id => $product_table_option_horizont) {
		                    	foreach ($product_table_option_horizont['product_table_option_value'] as $product_table_option_value) {
			                    	if (isset($value['option_value_horizont'][$product_table_option_value['option_value_id']]['option_value_vertical'][$value['option_id'][$main_option_id]['product_table_option_value'][$count]['option_value_id']]['special_price']) && $value['option_value_horizont'][$product_table_option_value['option_value_id']]['option_value_vertical'][$value['option_id'][$main_option_id]['product_table_option_value'][$count]['option_value_id']]['special_price'] != 0) {
		                        		$rowspan = 2;
		                        		break;
		                        	}
		                    	}
		                    }

		                	if (isset($value['option_value_horizont'][0]['option_value_vertical'][$value['option_id'][$main_option_id]['product_table_option_value'][$count]['option_value_id']]['special_price']) && $value['option_value_horizont'][0]['option_value_vertical'][$value['option_id'][$main_option_id]['product_table_option_value'][$count]['option_value_id']]['special_price'] != 0) {
		                		$rowspan = 2;
		                	}

	                        $table .= '<td rowspan="' . $rowspan . '">';

	                        if (isset($option['product_table_option_value'][$count]) && $option['product_table_option_value'][$count]['product_table_option_value_image'] != '') {
								$table .= "<a href='" . $this->model_tool_image->resize($option['product_table_option_value'][$count]['product_table_option_value_image'], $this->config->get('config_image_popup_width'), $this->config->get('config_image_popup_height')) . "' onclick='return hs.expand(this)'>";
								$table .= '	<img src="';
								$table .= 	$this->model_tool_image->resize($option['product_table_option_value'][$count]['product_table_option_value_image'], $this->config->get('config_image_additional_width'), $this->config->get('config_image_additional_height'));
								$table .= '" alt="' . $option['product_table_option_value'][$count]['name'] . '" title="' . $option['product_table_option_value'][$count]['name'] . '" >';
								$table .= '</a>';
							}

	                    	if ($option['count_image']['count(*)'] != 0) {
	   	                    	$table .= '</td><td rowspan="' . $rowspan . '">';
	                        }

	                        if (isset($option['product_table_option_value'][$count])) {
	                            $option_value_vertical_array[] = $option['product_table_option_value'][$count]['option_value_id'];
	                            $table .= $option['product_table_option_value'][$count]['name'];
	                        } else {
	                        	$table .= '--';
	                        }

	                        $table .= '</td>';
	                    }
	                }
	                
	                foreach ($value['option_id'] as $option_id => $product_table_option_horizont) {
	                    if ($product_table_option_horizont['vertical'] == 0) {

	                    	if (count($product_table_option_horizont['product_table_option_value']) == 0) {
	                    		$table .= '<td></td>';
	                    	}
	                    	
	                        foreach ($product_table_option_horizont['product_table_option_value'] as $product_table_option_value) {
	                        	if (isset($value['option_value_horizont'][$product_table_option_value['option_value_id']]['option_value_vertical'][$value['option_id'][$main_option_id]['product_table_option_value'][$count]['option_value_id']]['price'])) {
		                        	$price = $value['option_value_horizont'][$product_table_option_value['option_value_id']]['option_value_vertical'][$value['option_id'][$main_option_id]['product_table_option_value'][$count]['option_value_id']]['price'];
		                        	$old_price = '';

		                        	if (isset($value['option_value_horizont'][$product_table_option_value['option_value_id']]['option_value_vertical'][$value['option_id'][$main_option_id]['product_table_option_value'][$count]['option_value_id']]['special_price']) && $value['option_value_horizont'][$product_table_option_value['option_value_id']]['option_value_vertical'][$value['option_id'][$main_option_id]['product_table_option_value'][$count]['option_value_id']]['special_price'] != 0) {
		                        		$old_price = 'old_price';
		                        	}

		                        	$table .= '<td class="price_table ' . $old_price . '">';

		                            if ($price != 0) {
			                            $table .= $this->currency->format($this->tax->calculate($price, $tax_class_id, $config_tax), '', '', false);
			                        } else {
		                        		$table .= '--';
			                        }
			                        
			                        $table .= '</td>';
			                    }
	                        }
	                    }
	                }

	                $special_true = false;

	                foreach ($product_table_option_horizont['product_table_option_value'] as $product_table_option_value) {
                    	if (isset($value['option_value_horizont'][$product_table_option_value['option_value_id']]['option_value_vertical'][$value['option_id'][$main_option_id]['product_table_option_value'][$count]['option_value_id']]['special_price']) && $value['option_value_horizont'][$product_table_option_value['option_value_id']]['option_value_vertical'][$value['option_id'][$main_option_id]['product_table_option_value'][$count]['option_value_id']]['special_price'] != 0) {
                			$table .= '</tr><tr class="' . $class . '">';
                			$special_true = true;
                    		break;
                    	}
                	}

                	if ($special_true == true) {
		                foreach ($value['option_id'] as $option_id => $product_table_option_horizont) {
		                    foreach ($product_table_option_horizont['product_table_option_value'] as $key => $product_table_option_value) {
		                    	if (isset($value['option_value_horizont'][$product_table_option_value['option_value_id']]['option_value_vertical'][$value['option_id'][$main_option_id]['product_table_option_value'][$count]['option_value_id']]['special_price'])) {
		                    		$special_price = $value['option_value_horizont'][$product_table_option_value['option_value_id']]['option_value_vertical'][$value['option_id'][$main_option_id]['product_table_option_value'][$count]['option_value_id']]['special_price'];
									$class_special_price = '';

									if ($special_price != 0) {
										$class_special_price = 'special_price';
									}

		                    		$table .= '<td class="' . $class_special_price . '">';

		                    		if ($special_price != 0) {
			                            $table .= $this->currency->format($this->tax->calculate($special_price, $tax_class_id, $config_tax), '', '', false);
			                        }
			                        
		                    		$table .= '</td>';
		                    	}
		                    }
						}
					}

	                if (count($option_value_horizont_array) == 0 && count($option_value_vertical_array) != 0 && count($option_horizont_array) == 0) {
	                	if (isset($value['option_value_horizont'][0]['option_value_vertical'][$value['option_id'][$main_option_id]['product_table_option_value'][$count]['option_value_id']]['price'])) {
		                	$price = $value['option_value_horizont'][0]['option_value_vertical'][$value['option_id'][$main_option_id]['product_table_option_value'][$count]['option_value_id']]['price'];
							$price_after_name = $value['option_value_horizont'][0]['option_value_vertical'][$value['option_id'][$main_option_id]['product_table_option_value'][$count]['option_value_id']]['price_after_name'];
							$price_prefix_name = $value['option_value_horizont'][0]['option_value_vertical'][$value['option_id'][$main_option_id]['product_table_option_value'][$count]['option_value_id']]['price_prefix_name'];
		                	
		                	$old_price = '';

                        	if (isset($value['option_value_horizont'][0]['option_value_vertical'][$value['option_id'][$main_option_id]['product_table_option_value'][$count]['option_value_id']]['special_price']) && $value['option_value_horizont'][0]['option_value_vertical'][$value['option_id'][$main_option_id]['product_table_option_value'][$count]['option_value_id']]['special_price'] != 0) {
                        		$old_price = 'old_price';
                        	}

		                	$table .= '<td class="price_table ' . $old_price . '">';

		                    if ($price != 0) {
		                    	if ($price_prefix_name != NULL) {
		                    		$table .= $price_prefix_name . ' ';
		                    	}

		                        $table .= $this->currency->format($this->tax->calculate($price, $tax_class_id, $config_tax), '', '', false);

		                        if ($price_after_name != NULL) {
		                    		$table .= ' ' . $price_after_name;
		                    	}
		                    } else {
		                    	$table .= '--';
		                    } 
		                    
		                    $table .= '</td>';
		                }

		                if (isset($value['option_value_horizont'][0]['option_value_vertical'][$value['option_id'][$main_option_id]['product_table_option_value'][$count]['option_value_id']]['special_price']) && $value['option_value_horizont'][0]['option_value_vertical'][$value['option_id'][$main_option_id]['product_table_option_value'][$count]['option_value_id']]['special_price'] != 0) {
		                	$table .= '<tr class="' . $class . '">';
		                	$special_price = $value['option_value_horizont'][0]['option_value_vertical'][$value['option_id'][$main_option_id]['product_table_option_value'][$count]['option_value_id']]['special_price'];
							$price_after_name = $value['option_value_horizont'][0]['option_value_vertical'][$value['option_id'][$main_option_id]['product_table_option_value'][$count]['option_value_id']]['price_after_name'];
							$price_prefix_name = $value['option_value_horizont'][0]['option_value_vertical'][$value['option_id'][$main_option_id]['product_table_option_value'][$count]['option_value_id']]['price_prefix_name'];
		                	$class_special_price = '';

							if ($special_price != 0) {
								$class_special_price = 'special_price';
							}

		                	$table .= '<td class="' . $class_special_price . '">';

		                    if ($special_price != 0) {
		                    	if ($price_prefix_name != NULL) {
		                    		$table .= $price_prefix_name . ' ';
		                    	}

		                        $table .= $this->currency->format($this->tax->calculate($special_price, $tax_class_id, $config_tax), '', '', false);

		                        if ($price_after_name != NULL) {
		                    		$table .= ' ' . $price_after_name;
		                    	}
		                    }
		                    
		                    $table .= '</td>';
		                	$table .= '</tr>';
		                }
	                }
					
					$table .= '</tr>';
	            	$class = ($class == 'even' ? 'odd' : 'even');
	            }

	            if ($count_option == 0 && count($option_value_horizont_array) > 0) {
	                $table .= '<tr class="' . $class . '">';
	                
	                foreach ($value['option_id'] as $option_id => $option_data) {
	                    if ($option_data['vertical'] == 0) {
	                        foreach ($option_data['product_table_option_value'] as $product_table_option_value) {
	                        	if (isset($value['option_value_horizont'][$product_table_option_value['option_value_id']]['option_value_vertical'][0]['price'])) {
		                        	$price = $value['option_value_horizont'][$product_table_option_value['option_value_id']]['option_value_vertical'][0]['price'];
		                        	$old_price = '';

	                        		if (isset($value['option_value_horizont'][$product_table_option_value['option_value_id']]['option_value_vertical'][0]['special_price']) && $value['option_value_horizont'][$product_table_option_value['option_value_id']]['option_value_vertical'][0]['special_price'] != 0) {
	                        			$old_price = 'old_price';
									}

		                            $table .= '<td class="price_table ' . $old_price . '">';
		                            
		                            if ($price != 0) {
			                            $table .= $this->currency->format($this->tax->calculate($price, $tax_class_id, $config_tax), '', '', false);
		                    		} else {
		                    			$table .= '--';
			                        }

			                        $table .= '</td>';
			                    }
	                        }
	                        
	                        if (count($option_data['product_table_option_value']) == 0) {
	                        	$table .= '<td></td>';
	                        }

	                        foreach ($option_data['product_table_option_value'] as $product_table_option_value) {
	                        	if (isset($value['option_value_horizont'][$product_table_option_value['option_value_id']]['option_value_vertical'][0]['special_price']) && $value['option_value_horizont'][$product_table_option_value['option_value_id']]['option_value_vertical'][0]['special_price'] != 0) {
	                        		$table .= "</tr><tr class='" . $class . "'>";
	                        		break;
	                        	}
	                        }

	                        foreach ($option_data['product_table_option_value'] as $product_table_option_value) {
	                        	if (isset($value['option_value_horizont'][$product_table_option_value['option_value_id']]['option_value_vertical'][0]['special_price']) && $value['option_value_horizont'][$product_table_option_value['option_value_id']]['option_value_vertical'][0]['special_price'] != 0) {
		                        	$special_price = $value['option_value_horizont'][$product_table_option_value['option_value_id']]['option_value_vertical'][0]['special_price'];
		                        	$class_special_price = '';

									if ($special_price != 0) {
										$class_special_price = 'special_price';
									}

				                	$table .= '<td class="' . $class_special_price . '">';
		                            
		                            if ($special_price != 0) {
			                            $table .= $this->currency->format($this->tax->calculate($special_price, $tax_class_id, $config_tax), '', '', false);
			                        }

			                        $table .= '</td>';
			                    }
	                        }
	                    }
	                }

	                $table .= '</tr>';
	            }
	            
	            $table .= '</tbody></table></div>';
	        }

			$this->cache->set($key_cache, $table);
	    }

        return $table;
    }

    public function comment() {
        $this->language->load('product/product');
        $this->language->load('record/record');
        $this->load->model('catalog/comment');
        $this->load->model('catalog/product');
        $this->load->model('tool/image');

        $this->data['entry_sorting']      = $this->language->get('entry_sorting');
        $this->data['text_sorting_desc']  = $this->language->get('text_sorting_desc');
        $this->data['text_sorting_asc']   = $this->language->get('text_sorting_asc');
        $this->data['text_rollup']        = $this->language->get('text_rollup');
        $this->data['text_rollup_down']   = $this->language->get('text_rollup_down');
        $this->data['text_no_comments']   = $this->language->get('text_no_comments');
        $this->data['text_reply_button']  = $this->language->get('text_reply_button');
        $this->data['text_edit_button']   = $this->language->get('text_edit_button');
        $this->data['text_delete_button'] = $this->language->get('text_delete_button');
        $this->data['text_file_upload'] = $this->language->get('text_file_upload');

        $this->load->model('catalog/blog');

        $this->data['record_comment'] = array(
            'status' => $this->config->get('config_review_status'),
            'status_reg' => $this->config->get('config_comment_status_reg'),
            'status_now' => $this->config->get('config_comment_status_now'),
            'rating' => $this->config->get('config_comment_rating'),
            'rating_num' => $this->config->get('config_comment_rating_num')
        );

        $page = 1;

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        }

        $this->data['page'] = $page;
        $this->data['sorting'] = 'desc';

        if (isset($this->request->get['sorting'])) {
            if ($this->request->get['sorting'] == 'none') {
                $this->data['sorting'] = 'desc';
            } else
                $this->data['sorting'] = $this->request->get['sorting'];
        }

        $this->data['comments']          = array();
        $comment_total                   = $this->model_catalog_product->getTotalCommentsByProductId($this->request->get['product_id']);
        $this->data['blog_num_comments'] = 10000000;

        $results = $this->model_catalog_product->getCommentsByProductId($this->request->get['product_id'], ($page - 1) * $this->data['blog_num_comments'], $this->data['blog_num_comments']);

        if ($this->customer->isLogged()) {
            $customer_id = $this->customer->getId();
        } else {
            $customer_id = -1;
        }

        $results_rates = $this->model_catalog_product->getRatesByProductdId($this->request->get['product_id'], $customer_id);

        if ($customer_id == -1) {
            $customer_id = false;
        }

        if (count($results) > 0) {
            function sdesc($a, $b) {
                return (strcmp($a['sorthex'], $b['sorthex']));
            }

            $resa = NULL;

            foreach ($results as $num => $res1) {
                $resa[$num] = $res1;

                if (isset($results_rates[$res1['comment_id']])) {
                    $resa[$num]['delta']            = $results_rates[$res1['comment_id']]['rate_delta'];
                    $resa[$num]['rate_count']       = $results_rates[$res1['comment_id']]['rate_count'];
                    $resa[$num]['rate_count_plus']  = $results_rates[$res1['comment_id']]['rate_delta_plus'];
                    $resa[$num]['rate_count_minus'] = $results_rates[$res1['comment_id']]['rate_delta_minus'];
                    $resa[$num]['customer_delta']   = $results_rates[$res1['comment_id']]['customer_delta'];
                } else {
                    $resa[$num]['customer_delta']   = 0;
                    $resa[$num]['delta']            = 0;
                    $resa[$num]['rate_count']       = 0;
                    $resa[$num]['rate_count_plus']  = 0;
                    $resa[$num]['rate_count_minus'] = 0;
                }

                $resa[$num]['hsort'] = '';
                $mmm = NULL;
                $kkk = '';
                $wh  = strlen($res1['sorthex']) / 4;

                for ($i = 0; $i < $wh; $i++) {
                    $mmm[$i] = str_pad(dechex(65535 - hexdec(substr($res1['sorthex'], $i * 4, 4))), 4, "F", STR_PAD_LEFT);
                    $sortmy  = substr($res1['sorthex'], $i * 4, 4);
                    $kkk     = $kkk . $sortmy;
                }

                $ssorthex = '';
                if (is_array($mmm)) {
                    foreach ($mmm as $num1 => $val) {
                        $ssorthex = $ssorthex . $val;
                    }
                }

                if ($this->data['sorting'] != 'asc') {
                    $resa[$num]['sorthex'] = $ssorthex;
                } else {
                    $resa[$num]['sorthex'] = $kkk;
                }

                $resa[$num]['hsort'] = $kkk;
            }

            $results = NULL;
            $results = $resa;
            uasort($results, 'sdesc');
            $i = 0;

            foreach ($results as $num => $result) {
                if (!isset($result['date_available'])) {
                    $result['date_available']=$result['date_added'];
                }

                if ($this->rdate($this->language->get('text_date')) == $this->rdate($this->language->get('text_date'), strtotime($result['date_available']))) {
                    $date_str = $this->language->get('text_today');
                } else {
                    $date_str = $this->language->get('text_date');
                }

                $date_added = $this->rdate($date_str . $this->language->get('text_hours'), strtotime($result['date_added']));

                $file_comment = '';
                $file_comment_popup = '';

                if ($result['file_comment'] != '' && file_exists(DIR_DOWNLOAD . $result['file_comment'])) {
                    $file_comment = $this->model_tool_image->resize($result['file_comment'], 100, 100, DIR_DOWNLOAD);
                    $file_comment_popup = $this->model_tool_image->resize($result['file_comment'], 500, 500, DIR_DOWNLOAD);
                }

                $this->data['comments'][] = array(
                    'comment_id' => $result['comment_id'],
                    'sorthex' => $result['sorthex'],
                    'customer_id' => $result['customer_id'],
                    'customer' => $customer_id,
                    'customer_delta' => $result['customer_delta'],
                    'file_comment' => $file_comment,
                    'file_comment_popup' => $file_comment_popup,
                    'level' => (strlen($result['sorthex']) / 4) - 1,
                    'parent_id' => $result['parent_id'],
                    'author' => $result['author'],
                    'text' => strip_tags($result['text']),
                    'rating' => (int) $result['rating'],
                    'hsort' => $result['hsort'],
                    'myarray' => $mmm,
                    'delta' => $result['delta'],
                    'rate_count' => $result['rate_count'],
                    'rate_count_plus' => $result['rate_count_plus'],
                    'rate_count_minus' => $result['rate_count_minus'],
                    'comments' => sprintf($this->language->get('text_comments'), (int) $comment_total),
                    'date_added' => $date_added
                );
                $i++;
            }
        }


        if (!function_exists('compare')) {
            function compare($a, $b) {
                if ($a['comment_id'] > $b['comment_id'])
                    return 1;
                if ($b['comment_id'] > $a['comment_id'])
                    return -1;
                return 0;
            }
        }

        if (!function_exists('compared')) {
            function compared($a, $b) {
                if ($a['comment_id'] > $b['comment_id'])
                    return -1;
                if ($b['comment_id'] > $a['comment_id'])
                    return 1;
                return 0;
            }
        }

        if (!function_exists('my_sort_div')) {
            function my_sort_div($data, $parent = 0, $sorting, $lev = -1) {
                $arr = $data[$parent];
                if ($sorting == 'asc') {
                    usort($arr, 'compare');
                }

                if ($sorting == 'desc') {
                    usort($arr, 'compared');
                }

                $lev = $lev + 1;

                for ($i = 0; $i < count($arr); $i++) {
                    $arr[$i]['level']               = $lev;
                    $z[]                            = $arr[$i];
                    $z[count($z) - 1]['flag_start'] = 1;
                    $z[count($z) - 1]['flag_end']   = 0;

                    if (isset($data[$arr[$i]['comment_id']])) {
                        $m = my_sort_div($data, $arr[$i]['comment_id'], $sorting, $lev);
                        $z = array_merge($z, $m);
                    }

                    if (isset($z[count($z) - 1]['flag_end'])) {
                        $z[count($z) - 1]['flag_end']++;
                    } else {
                        $z[count($z) - 1]['flag_end'] = 1;
                    }
                }

                return $z;
            }
        }

        $this->data['mycomments'] = array();

        if (count($this->data['comments']) > 0) {
            for ($i = 0, $c = count($this->data['comments']); $i < $c; $i++) {
                $new_arr[$this->data['comments'][$i]['parent_id']][] = $this->data['comments'][$i];
            }

            $mycomments = my_sort_div($new_arr, 0, $this->data['sorting']);
            $i = 0;

            foreach ($mycomments as $num => $result) {
                if (($i >= (($page - 1) * $this->data['blog_num_comments'])) && ($i < ((($page - 1) * $this->data['blog_num_comments']) + $this->data['blog_num_comments']))) {
                    $this->data['mycomments'][$i] = $result;
                }

                $i++;
            }
        }

        $this->data['comments']   = $this->data['mycomments'];
        $pagination               = new Pagination();
        $pagination->total        = $comment_total;
        $pagination->page         = $page;
        $pagination->limit        = $this->data['blog_num_comments'];
        $pagination->text         = $this->language->get('text_pagination');
        $pagination->url          = $this->url->link('product/product', '&path=&product_id=' . $this->request->get['product_id'] . '&sorting=' . $this->data['sorting'] . '&page={page}');
        $this->data['pagination'] = $pagination->render();

        if (isset($this->data['blog_design']['blog_template_comment']) && $this->data['blog_design']['blog_template_comment'] != '') {
            $template = $this->data['blog_design']['blog_template_comment'];
        } else {
            $template = 'comment.tpl';
        }

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/' . $template)) {
            $this->template = $this->config->get('config_template') . '/template/product/' . $template;
        } else {
            if (file_exists(DIR_TEMPLATE . 'default/template/product/' . $template)) {
                $this->template = 'default/template/product/' . $template;
            } else {
                $this->template = 'default/template/product/comment.tpl';
            }
        }

        $this->data['theme'] = $this->config->get('config_template');
        $this->response->setOutput($this->render());
    }

    public function write() {
        $json = array();
        $this->language->load('product/product');
        $this->language->load('record/record');
        $this->load->model('catalog/product');
        $product_id = 0;

        if (isset($this->request->get['product_id'])) {
            $product_id = $this->request->get['product_id'];
        }

        if (isset($this->request->get['parent'])) {
            if ($this->request->get['parent'] == '')
                $this->request->get['parent'] = 0;
        } else {
            $this->request->get['parent'] = 0;
        }

        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'p.sort_order';
        }

        if (isset($this->request->get['order'])) {
            $order = $this->request->get['order'];
        } else {
            $order = 'DESC';
        }

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }

        if (isset($this->request->get['limit'])) {
            $limit = $this->request->get['limit'];
        } else {
            $limit = $this->config->get('config_catalog_limit');
        }

        if ($this->customer->isLogged()) {
            $customer_group_id = $this->customer->getCustomerGroupId();
            $captcha_status    = false;
        } else {
            $customer_group_id = $this->config->get('config_customer_group_id');
            $captcha_status = true;
        }

        $record_comment  = array(
            'status' => $this->config->get('config_review_status'),
            'status_reg' => $this->config->get('config_comment_status_reg'),
            'status_now' => $this->config->get('config_comment_status_now'),
            'rating' => $this->config->get('config_comment_rating'),
            'rating_num' => $this->config->get('config_comment_rating_num')
        );

        $this->data['comment_status']                 = $record_comment['status'];
        $this->data['comment_status_reg']             = $record_comment['status_reg'];
        $this->data['comment_status_now']             = $record_comment['status_now'];
        $this->data['comment']                        = $record_comment;
        $this->request->post['comment']['status']     = $record_comment['status'];
        $this->request->post['comment']['status_reg'] = $record_comment['status_reg'];
        $this->request->post['comment']['status_now'] = $record_comment['status_now'];
        $this->request->post['status']                = $record_comment['status_now'];
        $this->load->model('catalog/comment');

        if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 33)) {
            $json['error'] = $this->language->get('error_name');
        }

        if ((utf8_strlen($this->request->post['text']) < 5) || (utf8_strlen($this->request->post['text']) > 1000)) {
            $json['error'] = $this->language->get('error_text');
        }

        if (!$this->request->post['rating']) {
            $json['error'] = $this->language->get('error_rating');
        }

        if ($record_comment['status_reg'] && !$this->customer->isLogged()) {
            $json['error'] = $this->language->get('error_reg');
        }

        if ($this->customer->isLogged()) {
            $json['login']       = $this->customer->getFirstName() . " " . $this->customer->getLastName();
            $json['customer_id'] = $this->data['customer_id'] = $this->customer->getId();
        } else {
            $json['login'] = $this->language->get('text_anonymus');
        }

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && !isset($json['error'])) {
            $comment_id = $this->model_catalog_product->addComment($this->request->get['product_id'], $this->request->post, $this->request->get);

            $subject = $this->language->get('text_new_comment');
            $link = $this->url->link('product/product', '&path=&product_id=' . $this->request->get['product_id']);
            $html = sprintf($this->language->get('text_new_comment_html'), $this->config->get('config_owner'), $link . '#comment-' . $comment_id);

            $mail = new Mail();
            $mail->protocol = $this->config->get('config_mail_protocol');
            $mail->parameter = $this->config->get('config_mail_parameter');
            $mail->hostname = $this->config->get('config_smtp_host');
            $mail->username = $this->config->get('config_smtp_username');
            $mail->password = $this->config->get('config_smtp_password');
            $mail->port = $this->config->get('config_smtp_port');
            $mail->timeout = $this->config->get('config_smtp_timeout');
            $mail->setTo($this->config->get('config_email'));
            $mail->setFrom($this->config->get('config_email'));
            $mail->setSender($this->config->get('config_name'));
            $mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
            $mail->setHtml(html_entity_decode($html, ENT_QUOTES, 'UTF-8'));
            $mail->send();

            $this->data['comment_count'] = $this->model_catalog_product->getTotalCommentsByProductId($product_id);
            $json['comment_count']       = $this->data['comment_count'];

            if ($record_comment['status_now']) {
                $json['success'] = $this->language->get('text_success_now');
            } else {
                $json['success'] = $this->language->get('text_success');
            }
        }

        $this->response->setOutput(json_encode($json));
    }

    public function captchadel() {
        $this->load->library('captcham');
        $captcha  = new Captcha();
        $filename = $captcha->root . '/image/cache/' . $this->session->data['captcha'] . '.jpg';
        if (file_exists($filename))
            unlink($filename);
        unset($captcha);
        return json_decode($filename);
    }

    public function captcham() {
        $this->load->library('captcham');
        $this->language->load('record/record');
        $this->data['entry_captcha']        = $this->language->get('entry_captcha');
        $this->data['entry_captcha_title']  = $this->language->get('entry_captcha_title');
        $this->data['entry_captcha_update'] = $this->language->get('entry_captcha_update');
        if ($this->customer->isLogged()) {
            $this->data['captcha_status'] = false;
        } else {
            $this->data['captcha_status']   = true;
            $captcha                        = new Captcha();
            $this->session->data['captcha'] = $captcha->getCode();
            $this->data['captcha_filename'] = $captcha->makeImage();
            $this->data['captcha_keys']     = "";
            for ($i = 0; $i < strlen($this->session->data['captcha']); $i++) {
                $k   = rand(0, 1);
                $pos = strpos($this->data['captcha_keys'], $this->session->data['captcha'][$i]);
                if ($pos === false) {
                    if ($k == 1)
                        $this->data['captcha_keys'] = $this->data['captcha_keys'] . $this->session->data['captcha'][$i];
                    else
                        $this->data['captcha_keys'] = $this->session->data['captcha'][$i] . $this->data['captcha_keys'];
                }
            }
        }
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/record/captcha.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/record/captcha.tpl';
        } else {
            $this->template = 'default/template/record/captcha.tpl';
        }
        $this->data['theme'] = $this->config->get('config_template');
        $this->response->setOutput($this->render());
    }

    public function comments_vote() {
        $json             = array();
        $json['messages'] = 'ok';

        $this->language->load('record/record');
        $this->load->model('catalog/record');

        if (isset($this->request->post['comment_id'])) {
            $comment_id = $this->request->post['comment_id'];
        } else {
            $comment_id = 0;
        }

        if (isset($this->request->post['delta'])) {
            $delta = $this->request->post['delta'];
            if ($delta > 1) {
                $delta = 1;
            }
            if ($delta < -1) {
                $delta = -1;
            }
        } else {
            $delta = 0;
        }

        if ($this->customer->isLogged()) {
            $customer_id = $this->customer->getId();
        } else {
            $customer_id = false;
        }

        $json['customer_id']       = $customer_id;
        $this->data['comment_id']  = $comment_id;
        $this->data['customer_id'] = $customer_id;
        $this->data['delta']       = $delta;

        $this->load->model('catalog/product');
        $product_info = $this->model_catalog_product->getProductbyComment($this->data);

        if (isset($product_info['product_id']) && $product_info['product_id']!='') {
            $this->data['product_id'] = $product_info['product_id'];
        } else {
            $this->data['product_id']='';
        }

        $check_rate 	= $this->model_catalog_product->checkRate($this->data);
        $check_rate_num = $this->model_catalog_product->checkRateNum($this->data);

        $rating_num = 10000;

        if ($this->config->get('config_comment_rating_num')) {
            $rating_num = $this->config->get('config_comment_rating_num');
        }

        $voted_num = $rating_num - 1;

        if (isset($check_rate_num['rating_num']) && $check_rate_num['rating_num']!='') {
            $voted_num = $check_rate_num['rating_num'];
        }

        if ((count($check_rate) < 1) && $customer_id && ($voted_num < $rating_num)) {
            $this->model_catalog_product->addRate($this->data);
            $rate_info       = $this->model_catalog_product->getRatesByCommentId($comment_id);
            $json['success'] = $rate_info[0];
            $plus            = "";

            if ($json['success']['rate_delta'] > 0)    $plus = "+";

            $json['success']['rate_delta'] = sprintf($plus."%d", $json['success']['rate_delta']);

        } else {
            return $this->response->setOutput(json_encode($json));
        }

        return $this->response->setOutput(json_encode($json));
    }


    public function upload() {
        $this->language->load('record/record');
        $json = array();

        $filename = basename(html_entity_decode($this->request->files['file']['name'], ENT_QUOTES, 'UTF-8'));

        if ((strlen($filename) < 3) || (strlen($filename) > 128)) {
            $json['error'] = $this->language->get('error_filename');
        }

        $allowed   = array();
        $filetypes = explode(',', $this->config->get('config_upload_allowed'));

        foreach ($filetypes as $filetype) {
            $allowed[] = trim($filetype);
        }

        if (!in_array(substr(strrchr($filename, '.'), 1), $allowed)) {
            $json['error'] = $this->language->get('error_filetype');
        }

        if ($this->request->files['file']['error'] != UPLOAD_ERR_OK) {
            $json['error'] = $this->language->get('error_upload_' . $this->request->files['file']['error']);
        }

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && !isset($json['error'])) {
            if (is_uploaded_file($this->request->files['file']['tmp_name']) && file_exists($this->request->files['file']['tmp_name'])) {
                $file = basename($filename) . '.' . md5(rand());
                $this->load->library('encryption');

                $encryption   = new Encryption($this->config->get('config_encryption'));
                $json['file'] = $file;
                $json['file_show'] = $this->request->files['file']['name'];
                move_uploaded_file($this->request->files['file']['tmp_name'], DIR_DOWNLOAD . $file);
            }

            $json['success'] = $this->language->get('text_upload');
        }

        $this->response->setOutput(json_encode($json));
    }
}
?>