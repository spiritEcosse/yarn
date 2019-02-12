<?php 
class ControllerCatalogProduct extends Controller {
	private $error = array(); 
    
  	public function index() {
		$this->load->language('catalog/product');
		$this->document->setTitle($this->language->get('heading_title'));
        $this->data['tab_filter'] = $this->language->get('tab_filter');
		$this->load->model('catalog/product');
		$this->getList();
  	}

  	public function insert() {
    	$this->load->language('catalog/product');
    	$this->document->setTitle($this->language->get('heading_title')); 
		$this->load->model('catalog/product');
		
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_product->addProduct($this->request->post);
	  		
			$this->session->data['success'] = $this->language->get('text_success');
	  		
	  		$url = $this->getUrl();
			
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, 'SSL'));
    	}
	
    	$this->getForm();
  	}
  	
  	public function update() {
    	$this->load->language('catalog/product');
    	$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('catalog/product');
		
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_product->editProduct($this->request->get['product_id'], $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$url = $this->getUrl();
			
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

    	$this->getForm();
  	}

  	public function delete() {
    	$this->load->language('catalog/product');
    	$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('catalog/product');
		
		if (isset($this->request->post['selected']) && $this->validateTotal()) {
			foreach ($this->request->post['selected'] as $product_id) {
				$this->model_catalog_product->deleteProduct($product_id);
	  		}

			$this->session->data['success'] = $this->language->get('text_success');
			
			$url = $this->getUrl();
			
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

    	$this->getList();
  	}

  	public function copy() {
    	$this->load->language('catalog/product');
    	$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('catalog/product');
		
		if (isset($this->request->post['selected']) && $this->validateTotal()) {
			foreach ($this->request->post['selected'] as $product_id) {
				$this->model_catalog_product->copyProduct($product_id);
	  		}
	  		
			$this->session->data['success'] = $this->language->get('text_success');
			$url = $this->getUrl();
			
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

    	$this->getList();
  	}
	
  	private function getList() {
  		$this->load->model('catalog/category');	
		$this->load->model('catalog/manufacturer');

		$this->data['categories'] = $this->model_catalog_category->getCategories(0);
		$m_sort = array( 'sort' => 'name', 'order' => 'ASC');
		$this->data['manufacturers'] = $this->model_catalog_manufacturer->getManufacturers( $m_sort );

  		$url = '';
  				
		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = null;
		}

		if (isset($this->request->get['filter_model'])) {
			$filter_model = $this->request->get['filter_model'];
		} else {
			$filter_model = null;
		}

		if (isset($this->request->get['filter_price'])) {
			$filter_price = $this->request->get['filter_price'];
		} else {
			$filter_price = null;
		}

		if (isset($this->request->get['filter_image'])) {
			$filter_image = $this->request->get['filter_image'];
		} else {
			$filter_image = null;
		}

		if (isset($this->request->get['filter_category_id'])) {
			$filter_category_id = $this->request->get['filter_category_id'];
		} else {
			$filter_category_id = null;
		}

		if (isset($this->request->get['filter_manufacturer'])) {
			$filter_manufacturer = $this->request->get['filter_manufacturer'];
		} else {
			$filter_manufacturer = null;
		}

		if (isset($this->request->get['filter_quantity'])) {
			$filter_quantity = $this->request->get['filter_quantity'];
		} else {
			$filter_quantity = null;
		}

		if (isset($this->request->get['filter_status'])) {
			$filter_status = $this->request->get['filter_status'];
		} else {
			$filter_status = null;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'p.date_added';
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
			$limit = $this->config->get('config_admin_limit');
		}

		$url = $this->getUrl();

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, 'SSL'),       		
      		'separator' => ' :: '
   		);
		
		$this->data['insert'] = $this->url->link('catalog/product/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['copy'] = $this->url->link('catalog/product/copy', 'token=' . $this->session->data['token'] . $url, 'SSL');	
		$this->data['switch'] = $this->url->link('catalog/product/switch_prod', 'token=' . $this->session->data['token'] . $url, 'SSL');	
		$this->data['delete'] = $this->url->link('catalog/product/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
    	
		$this->data['products'] = array();

		$data = array(
			'filter_name'	  => $filter_name, 
			'filter_model'	  => $filter_model,
			'filter_price'	  => $filter_price,
			'filter_image'	  => $filter_image,
			'filter_quantity' => $filter_quantity,
			'filter_status'   => $filter_status,
			'filter_category_id'	=> $filter_category_id,
			'filter_manufacturer'	=> $filter_manufacturer,
			'sort'            => $sort,
			'order'           => $order,
			'start'           => ($page - 1) * $limit,
			'limit'           => $limit
		);
		
		$this->load->model('tool/image');

		$product_total = $this->model_catalog_product->getTotalProducts($data);
		$results = $this->model_catalog_product->getProducts($data);
		
		foreach ($results as $result) {
			$action = array();
			$action[] = array(
				'text'	=> $this->language->get('text_edit'),
				'href'	=> $this->url->link('catalog/product/update', 'token=' . $this->session->data['token'] . '&product_id=' . $result['product_id'] . $url, 'SSL')
			);
			
			if ($result['image'] && file_exists(DIR_IMAGE . $result['image'])) {
				$image = $this->model_tool_image->resize($result['image'], 40, 40);
			} else {
				$image = $this->model_tool_image->resize('no_image.jpg', 40, 40);
			}
                        
			$special = false;
			
			$product_specials = $this->model_catalog_product->getProductSpecials($result['product_id']);
			
			foreach ($product_specials  as $product_special) {
				if (($product_special['date_start'] == '0000-00-00' || $product_special['date_start'] < date('Y-m-d')) && ($product_special['date_end'] == '0000-00-00' || $product_special['date_end'] > date('Y-m-d'))) {
					$special = $product_special['price'];
			
					break;
				}					
			}
			
			$category = $this->model_catalog_product->getProductCategoriesInfo( $result['product_id'] );		
			
      		$this->data['products'][] = array(
				'category' 			=> $category,
				'manufacturer' 		=> $result['manufacturer'],	
				'product_id' 		=> $result['product_id'],
				'name'       		=> $result['name'],
				'date_added' 		=> $result['date_added'],
				'model'      		=> $result['model'],
				'price'      		=> $result['price'],
				'price_status'		=> $result['price_status'],
				'special'    		=> $special,
				'image'      		=> $image,
				'quantity'   		=> $result['quantity'],
				'status'     		=> ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
				'selected'   		=> isset($this->request->post['selected']) && in_array($result['product_id'], $this->request->post['selected']),
				'action'     		=> $action,
				'href_view_prod'	=> 'http://' . $_SERVER['SERVER_NAME'] . '/index.php?route=product/product&product_id=' . $result['product_id']
			);
    	}
		
		$this->data['heading_title'] = $this->language->get('heading_title');		
		
		$this->data['text_enabled'] = $this->language->get('text_enabled');		
		$this->data['text_disabled'] = $this->language->get('text_disabled');		
		$this->data['text_no_results'] = $this->language->get('text_no_results');		
		$this->data['text_image_manager'] = $this->language->get('text_image_manager');
		$this->data['text_on'] = $this->language->get('text_on');
		$this->data['text_off'] = $this->language->get('text_off');
		
		$this->data['column_image'] = $this->language->get('column_image');		
		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_date_added'] = $this->language->get('column_date_added');		
		$this->data['column_model'] = $this->language->get('column_model');
		$this->data['column_category'] = $this->language->get('column_category');
		$this->data['column_manufacturer'] = $this->language->get('column_manufacturer');
		$this->data['column_price'] = $this->language->get('column_price');		
		$this->data['column_quantity'] = $this->language->get('column_quantity');		
		$this->data['column_status'] = $this->language->get('column_status');		
		$this->data['column_view_prod'] = $this->language->get('column_view_prod');		
		$this->data['on_page'] = $this->language->get('on_page');
		$this->data['column_action'] = $this->language->get('column_action');		
				
		$this->data['button_copy'] = $this->language->get('button_copy');		
		$this->data['button_insert'] = $this->language->get('button_insert');		
		$this->data['button_delete'] = $this->language->get('button_delete');		
		$this->data['button_filter'] = $this->language->get('button_filter');
		 
 		$this->data['token'] = $this->session->data['token'];
		
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_manufacturer'])) {
			$url .= '&filter_manufacturer=' . $this->request->get['filter_manufacturer'];
		}
		
		if (isset($this->request->get['filter_category_id'])) {
			$url .= '&filter_category_id=' . $this->request->get['filter_category_id'] . '&filter_sub_category=true';
		}

		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_price'])) {
			$url .= '&filter_price=' . $this->request->get['filter_price'];
		}
		
		if (isset($this->request->get['filter_quantity'])) {
			$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}
		
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (!isset($this->request->get['limit'])) {
			$this->data['limit'] = $this->language->get('text_all');
			$this->data['href_limit'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . '&limit=-1' . $url, 'SSL');
		} elseif (isset($this->request->get['limit']) && $this->request->get['limit'] == -1) {
			$this->data['limit'] = $this->config->get('config_admin_limit');
			$this->data['href_limit'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, 'SSL');
		}

		if (isset($this->request->get['limit'])) {
			$url .= '&limit=' . $this->request->get['limit'];
		}

		$this->data['sort_date_added'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . '&sort=p.date_added' . $url, 'SSL');
		$this->data['sort_name'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . '&sort=pd.name' . $url, 'SSL');
		$this->data['sort_model'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . '&sort=p.model' . $url, 'SSL');
		$this->data['sort_manufacturer'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . '&sort=p.manufacturer' . $url, 'SSL');
		$this->data['sort_category'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . '&sort=p.category' . $url, 'SSL');
		$this->data['sort_price'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . '&sort=p.price' . $url, 'SSL');
		$this->data['sort_quantity'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . '&sort=p.quantity' . $url, 'SSL');
		$this->data['sort_status'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . '&sort=p.status' . $url, 'SSL');
		$this->data['sort_order'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . '&sort=p.sort_order' . $url, 'SSL');

		if ($limit != -1) {
			$url = $this->getUrl();

			$pagination = new Pagination();
			$pagination->total = $product_total;
			$pagination->page = $page;
			$pagination->limit = $limit;
			$pagination->text = $this->language->get('text_pagination');
			$pagination->url = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			$this->data['pagination'] = $pagination->render();
		} else {
			$this->data['text_total_prod'] = $this->language->get('text_total_prod');
			$this->data['pagination'] = $product_total;
		}

		$this->data['filter_name'] = $filter_name;
		$this->data['filter_model'] = $filter_model;
		$this->data['filter_category_id'] = $filter_category_id;
		$this->data['filter_manufacturer'] = $filter_manufacturer;
		$this->data['filter_price'] = $filter_price;
		$this->data['filter_quantity'] = $filter_quantity;
		$this->data['filter_status'] = $filter_status;
		
		$this->data['sort'] = $sort;
		$this->data['order'] = $order;
                
		$this->template = 'catalog/product_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
  	}

  	private function getForm() {
        $this->load->model('catalog/category_fabric');
        $this->load->model('catalog/option');
        $this->load->model('catalog/filter');
        $this->load->model('catalog/product');
		$this->load->model('localisation/language');
		$this->load->model('setting/store');
		$this->load->model('tool/image');
		$this->load->model('catalog/manufacturer');
		$this->load->model('localisation/tax_class');
		$this->load->model('localisation/stock_status');
		$this->load->model('localisation/price_prefix');
		$this->load->model('localisation/price_after');
		$this->load->model('localisation/weight_class');
		$this->load->model('localisation/length_class');
		$this->load->model('catalog/option');
		$this->load->model('sale/customer_group');
		$this->load->model('catalog/download');
		$this->load->model('catalog/category');
		$this->load->model('design/layout');

    	$this->data['heading_title'] = $this->language->get('heading_title');
 		
    	$this->data['text_enabled'] = $this->language->get('text_enabled');
    	$this->data['text_disabled'] = $this->language->get('text_disabled');
    	$this->data['text_none'] = $this->language->get('text_none');
    	$this->data['text_yes'] = $this->language->get('text_yes');
    	$this->data['text_no'] = $this->language->get('text_no');
		$this->data['text_select_all'] = $this->language->get('text_select_all');
		$this->data['text_unselect_all'] = $this->language->get('text_unselect_all');
		$this->data['text_plus'] = $this->language->get('text_plus');
		$this->data['text_minus'] = $this->language->get('text_minus');
		$this->data['text_default'] = $this->language->get('text_default');
		$this->data['text_image_manager'] = $this->language->get('text_image_manager');
		$this->data['text_browse'] = $this->language->get('text_browse');
		$this->data['text_clear'] = $this->language->get('text_clear');
		$this->data['text_option'] = $this->language->get('text_option');
		$this->data['text_option_value'] = $this->language->get('text_option_value');
		$this->data['text_select'] = $this->language->get('text_select');
		$this->data['text_none'] = $this->language->get('text_none');
		$this->data['text_percent'] = $this->language->get('text_percent');
		$this->data['text_amount'] = $this->language->get('text_amount');
        $this->data['text_category'] = $this->language->get('text_category');
                
		$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['entry_meta_description'] = $this->language->get('entry_meta_description');
		$this->data['entry_meta_keyword'] = $this->language->get('entry_meta_keyword');
		$this->data['entry_description'] = $this->language->get('entry_description');
		$this->data['entry_store'] = $this->language->get('entry_store');
        $this->data['entry_fabric'] = $this->language->get('entry_fabric');
        
		$this->data['entry_keyword'] = $this->language->get('entry_keyword');
    	$this->data['entry_model'] = $this->language->get('entry_model');
		$this->data['entry_sku'] = $this->language->get('entry_sku');
		$this->data['entry_upc'] = $this->language->get('entry_upc');
		$this->data['entry_location'] = $this->language->get('entry_location');
		$this->data['entry_minimum'] = $this->language->get('entry_minimum');
		$this->data['entry_manufacturer'] = $this->language->get('entry_manufacturer');
    	$this->data['entry_shipping'] = $this->language->get('entry_shipping');
    	$this->data['entry_date_available'] = $this->language->get('entry_date_available');
    	$this->data['entry_quantity'] = $this->language->get('entry_quantity');
		$this->data['entry_stock_status'] = $this->language->get('entry_stock_status');
    	$this->data['entry_price'] = $this->language->get('entry_price');
        $this->data['entry_price_status'] = $this->language->get('entry_price_status');
        $this->data['entry_view_price'] = $this->language->get('entry_view_price');
        
		$this->data['entry_tax_class'] = $this->language->get('entry_tax_class');
		$this->data['entry_points'] = $this->language->get('entry_points');
		$this->data['entry_option_points'] = $this->language->get('entry_option_points');
		$this->data['entry_subtract'] = $this->language->get('entry_subtract');
    	$this->data['entry_weight_class'] = $this->language->get('entry_weight_class');
    	$this->data['entry_weight'] = $this->language->get('entry_weight');
		$this->data['entry_dimension'] = $this->language->get('entry_dimension');
		$this->data['entry_length'] = $this->language->get('entry_length');
    	$this->data['entry_image'] = $this->language->get('entry_image');
    	$this->data['entry_download'] = $this->language->get('entry_download');
    	$this->data['entry_category'] = $this->language->get('entry_category');
		$this->data['entry_related'] = $this->language->get('entry_related');
		$this->data['entry_attribute'] = $this->language->get('entry_attribute');
		$this->data['entry_text'] = $this->language->get('entry_text');
		$this->data['entry_option'] = $this->language->get('entry_option');
		$this->data['entry_option_value'] = $this->language->get('entry_option_value');
		$this->data['entry_required'] = $this->language->get('entry_required');
        $this->data['entry_category_fabric'] = $this->language->get('entry_category_fabric');
        $this->data['entry_add_fabric'] = $this->language->get('entry_add_fabric');
                
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_customer_group'] = $this->language->get('entry_customer_group');
		$this->data['entry_date_start'] = $this->language->get('entry_date_start');
		$this->data['entry_date_end'] = $this->language->get('entry_date_end');
		$this->data['entry_priority'] = $this->language->get('entry_priority');
		$this->data['entry_tag'] = $this->language->get('entry_tag');
		$this->data['entry_customer_group'] = $this->language->get('entry_customer_group');
		$this->data['entry_reward'] = $this->language->get('entry_reward');
		$this->data['entry_layout'] = $this->language->get('entry_layout');
		$this->data['entry_main_category'] = $this->language->get('entry_main_category');
		$this->data['entry_seo_title'] = $this->language->get('entry_seo_title');
		$this->data['entry_seo_h1'] = $this->language->get('entry_seo_h1');
				
    	$this->data['button_save'] = $this->language->get('button_save');
    	$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_add_attribute'] = $this->language->get('button_add_attribute');
		$this->data['button_add_option'] = $this->language->get('button_add_option');
		$this->data['button_add_product_tab'] = $this->language->get('button_add_product_tab');
		$this->data['button_add_option_value'] = $this->language->get('button_add_option_value');
		$this->data['button_add_discount'] = $this->language->get('button_add_discount');
		$this->data['button_add_special'] = $this->language->get('button_add_special');
		$this->data['button_add_image'] = $this->language->get('button_add_image');
		$this->data['button_remove'] = $this->language->get('button_remove');
		
    	$this->data['tab_general'] = $this->language->get('tab_general');
    	$this->data['tab_data'] = $this->language->get('tab_data');
        $this->data['tab_filter'] = $this->language->get('tab_filter');
		$this->data['tab_attribute'] = $this->language->get('tab_attribute');
		$this->data['tab_product_tab'] = $this->language->get('tab_product_tab');

		$this->data['tab_option'] = $this->language->get('tab_option');		
		$this->data['tab_discount'] = $this->language->get('tab_discount');
		$this->data['tab_special'] = $this->language->get('tab_special');
    	$this->data['tab_image'] = $this->language->get('tab_image');		
		$this->data['tab_links'] = $this->language->get('tab_links');
		$this->data['tab_reward'] = $this->language->get('tab_reward');
		$this->data['tab_design'] = $this->language->get('tab_design');
        $this->data['tab_fabric'] = $this->language->get('tab_fabric');
		$this->data['tab_price_fabric'] = $this->language->get('tab_price_fabric');
        $this->data['tab_options_table'] = $this->language->get('tab_options_table');

        if (isset($this->request->post['product_tab'])) {
			$this->data['product_tabs'] = $this->request->post['product_tab'];
		} elseif (isset($this->request->get['product_id'])) {
			$this->data['product_tabs'] = $this->model_catalog_product->getProductTabs($this->request->get['product_id']);
		} else {
			$this->data['product_tabs'] = array();
		}
		
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

 		if (isset($this->error['name'])) {
			$this->data['error_name'] = $this->error['name'];
		} else {
			$this->data['error_name'] = array();
		}

 		if (isset($this->error['meta_description'])) {
			$this->data['error_meta_description'] = $this->error['meta_description'];
		} else {
			$this->data['error_meta_description'] = array();
		}		
                
   		if (isset($this->error['description'])) {
			$this->data['error_description'] = $this->error['description'];
		} else {
			$this->data['error_description'] = array();
		}	
		
		if (isset($this->error['date_available'])) {
			$this->data['error_date_available'] = $this->error['date_available'];
		} else {
			$this->data['error_date_available'] = '';
		}	

		$url = $this->getUrl();

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
		
		if (!isset($this->request->get['product_id'])) {
			$this->data['action'] = $this->url->link('catalog/product/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('catalog/product/update', 'token=' . $this->session->data['token'] . '&product_id=' . $this->request->get['product_id'] . $url, 'SSL');
		}
                
		$this->data['cancel'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['product_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $product_info = $this->model_catalog_product->getProduct($this->request->get['product_id']);
        }
        
		$this->data['token'] = $this->session->data['token'];		
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		
		if (isset($this->request->get['product_id'])) {
			$this->data['options'] = $this->model_catalog_option->getOptions();
		} else {
			$this->data['options'] = array();
		}

		if (isset($this->request->post['product_description'])) {
			$this->data['product_description'] = $this->request->post['product_description'];
		} elseif (isset($this->request->get['product_id'])) {
			$this->data['product_description'] = $this->model_catalog_product->getProductDescriptions($this->request->get['product_id']);
		} else {
			$this->data['product_description'] = array();
		}
		
		if (isset($this->request->post['model'])) {
      		$this->data['model'] = $this->request->post['model'];
    	} elseif (!empty($product_info)) {
			$this->data['model'] = $product_info['model'];
		} else {
      		$this->data['model'] = '';
    	}

		if (isset($this->request->post['sku'])) {
      		$this->data['sku'] = $this->request->post['sku'];
    	} elseif (!empty($product_info)) {
			$this->data['sku'] = $product_info['sku'];
		} else {
      		$this->data['sku'] = '';
    	}
		
		if (isset($this->request->post['upc'])) {
      		$this->data['upc'] = $this->request->post['upc'];
    	} elseif (!empty($product_info)) {
			$this->data['upc'] = $product_info['upc'];
		} else {
      		$this->data['upc'] = '';
    	}
				
		if (isset($this->request->post['location'])) {
      		$this->data['location'] = $this->request->post['location'];
    	} elseif (!empty($product_info)) {
			$this->data['location'] = $product_info['location'];
		} else {
      		$this->data['location'] = '';
    	}
		
		$this->data['stores'] = $this->model_setting_store->getStores();
		
		if (isset($this->request->post['product_store'])) {
			$this->data['product_store'] = $this->request->post['product_store'];
		} elseif (isset($this->request->get['product_id'])) {
			$this->data['product_store'] = $this->model_catalog_product->getProductStores($this->request->get['product_id']);
		} else {
			$this->data['product_store'] = array(0);
		}	
		
		if (isset($this->request->post['keyword'])) {
			$this->data['keyword'] = $this->request->post['keyword'];
		} elseif (!empty($product_info)) {
			$this->data['keyword'] = $product_info['keyword'];
		} else {
			$this->data['keyword'] = '';
		}
		
		if (isset($this->request->post['product_tag'])) {
			$this->data['product_tag'] = $this->request->post['product_tag'];
		} elseif (isset($this->request->get['product_id'])) {
			$this->data['product_tag'] = $this->model_catalog_product->getProductTags($this->request->get['product_id']);
		} else {
			$this->data['product_tag'] = array();
		}
		
		if (isset($this->request->post['image'])) {
			$this->data['image'] = $this->request->post['image'];
		} elseif (!empty($product_info)) {
			$this->data['image'] = $product_info['image'];
		} else {
			$this->data['image'] = '';
		}
				
		if (isset($this->request->post['image']) && file_exists(DIR_IMAGE . $this->request->post['image'])) {
			$this->data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
		} elseif (!empty($product_info) && $product_info['image'] && file_exists(DIR_IMAGE . $product_info['image'])) {
			$this->data['thumb'] = $this->model_tool_image->resize($product_info['image'], 100, 100);
		} else {
			$this->data['thumb'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}
			
    	$this->data['manufacturers'] = $this->model_catalog_manufacturer->getManufacturers();

    	if (isset($this->request->post['manufacturer_id'])) {
      		$this->data['manufacturer_id'] = $this->request->post['manufacturer_id'];
		} elseif (!empty($product_info)) {
			$this->data['manufacturer_id'] = $product_info['manufacturer_id'];
		} else {
      		$this->data['manufacturer_id'] = 0;
    	} 
		
    	if (isset($this->request->post['shipping'])) {
      		$this->data['shipping'] = $this->request->post['shipping'];
    	} elseif (!empty($product_info)) {
      		$this->data['shipping'] = $product_info['shipping'];
    	} else {
			$this->data['shipping'] = 1;
		}
		
    	if (isset($this->request->post['price'])) {
      		$this->data['price'] = $this->request->post['price'];
    	} elseif (!empty($product_info)) {
			$this->data['price'] = $product_info['price'];
		} else {
      		$this->data['price'] = '';
    	}
        
        if (isset($this->request->post['price_status'])) {
      		$this->data['price_status'] = $this->request->post['price_status'];
    	} elseif (!empty($product_info)) {
			$this->data['price_status'] = $product_info['price_status'];
		}  else {
      		$this->data['price_status'] = 1;
    	}
		
		$this->data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();
    	
		if (isset($this->request->post['tax_class_id'])) {
      		$this->data['tax_class_id'] = $this->request->post['tax_class_id'];
    	} elseif (!empty($product_info)) {
			$this->data['tax_class_id'] = $product_info['tax_class_id'];
		} else {
      		$this->data['tax_class_id'] = 0;
    	}
		      	
		if (isset($this->request->post['date_available'])) {
       		$this->data['date_available'] = $this->request->post['date_available'];
		} elseif (!empty($product_info)) {
			$this->data['date_available'] = date('Y-m-d', strtotime($product_info['date_available']));
		} else {
			$this->data['date_available'] = date('Y-m-d', time() - 86400);
		}
											
    	if (isset($this->request->post['quantity'])) {
      		$this->data['quantity'] = $this->request->post['quantity'];
    	} elseif (!empty($product_info)) {
      		$this->data['quantity'] = $product_info['quantity'];
    	} else {
			$this->data['quantity'] = 1;
		}
		
		if (isset($this->request->post['minimum'])) {
      		$this->data['minimum'] = $this->request->post['minimum'];
    	} elseif (!empty($product_info)) {
      		$this->data['minimum'] = $product_info['minimum'];
    	} else {
			$this->data['minimum'] = 1;
		}
		
		if (isset($this->request->post['subtract'])) {
      		$this->data['subtract'] = $this->request->post['subtract'];
    	} elseif (!empty($product_info)) {
      		$this->data['subtract'] = $product_info['subtract'];
    	} else {
			$this->data['subtract'] = 1;
		}
		
		if (isset($this->request->post['sort_order'])) {
      		$this->data['sort_order'] = $this->request->post['sort_order'];
    	} elseif (!empty($product_info)) {
      		$this->data['sort_order'] = $product_info['sort_order'];
    	} else {
			$this->data['sort_order'] = 1;
		}

		$this->data['stock_statuses'] = $this->model_localisation_stock_status->getStockStatuses();
    	
		if (isset($this->request->post['stock_status_id'])) {
      		$this->data['stock_status_id'] = $this->request->post['stock_status_id'];
    	} elseif (!empty($product_info)) {
      		$this->data['stock_status_id'] = $product_info['stock_status_id'];
    	} else {
			$this->data['stock_status_id'] = $this->config->get('config_stock_status_id');
		}
		
		$this->data['price_prefixes'] = $this->model_localisation_price_prefix->getPricePrefixes();
		$this->data['price_afters'] = $this->model_localisation_price_after->getPriceAfters();
		
		if (isset($this->request->post['price_after_id'])) {
      		$this->data['price_after_id'] = $this->request->post['price_after_id'];
    	} elseif (!empty($product_info)) {
      		$this->data['price_after_id'] = $product_info['price_after_id'];
    	} else {
			$this->data['price_after_id'] = 0;
		}
		
		if (isset($this->request->post['price_prefix_id'])) {
      		$this->data['price_prefix_id'] = $this->request->post['price_prefix_id'];
    	} elseif (!empty($product_info)) {
      		$this->data['price_prefix_id'] = $product_info['price_prefix_id'];
    	} else {
			$this->data['price_prefix_id'] = 0;
		}

		if (isset($this->request->post['product_price'])) {
      		$this->data['product_price'] = $this->request->post['product_price'];
    	} elseif (isset($this->request->get['product_id'])) {
    		$this->data['product_price'] = $this->model_catalog_product->getProductPrice($this->request->get['product_id']);
		} else {
			$this->data['product_price'] = array();
		}

		if (isset($this->request->post['stock_status_id'])) {
      		$this->data['stock_status_id'] = $this->request->post['stock_status_id'];
    	} elseif (!empty($product_info)) {
      		$this->data['stock_status_id'] = $product_info['stock_status_id'];
    	} else {
			$this->data['stock_status_id'] = $this->config->get('config_stock_status_id');
		}

    	if (isset($this->request->post['status'])) {
      		$this->data['status'] = $this->request->post['status'];
    	} elseif (!empty($product_info)) {
			$this->data['status'] = $product_info['status'];
		} else {
      		$this->data['status'] = 1;
    	}
        
        if (!empty($product_info)) {
			$this->data['status_fabric'] = $product_info['status_fabric'];
		} else {
      		$this->data['status_fabric'] = FALSE;
    	}
        
    	if (isset($this->request->post['weight'])) {
      		$this->data['weight'] = $this->request->post['weight'];
		} elseif (!empty($product_info)) {
			$this->data['weight'] = $product_info['weight'];
    	} else {
      		$this->data['weight'] = '';
    	} 

		$this->data['weight_classes'] = $this->model_localisation_weight_class->getWeightClasses();
    	
		if (isset($this->request->post['weight_class_id'])) {
      		$this->data['weight_class_id'] = $this->request->post['weight_class_id'];
    	} elseif (!empty($product_info)) {
      		$this->data['weight_class_id'] = $product_info['weight_class_id'];
		} else {
      		$this->data['weight_class_id'] = $this->config->get('config_weight_class_id');
    	}
		
		if (isset($this->request->post['length'])) {
      		$this->data['length'] = $this->request->post['length'];
    	} elseif (!empty($product_info)) {
			$this->data['length'] = $product_info['length'];
		} else {
      		$this->data['length'] = '';
    	}
		
		if (isset($this->request->post['width'])) {
      		$this->data['width'] = $this->request->post['width'];
		} elseif (!empty($product_info)) {	
			$this->data['width'] = $product_info['width'];
    	} else {
      		$this->data['width'] = '';
    	}
		
		if (isset($this->request->post['height'])) {
      		$this->data['height'] = $this->request->post['height'];
		} elseif (!empty($product_info)) {
			$this->data['height'] = $product_info['height'];
    	} else {
      		$this->data['height'] = '';
    	}
		
		$this->data['length_classes'] = $this->model_localisation_length_class->getLengthClasses();
    	
		if (isset($this->request->post['length_class_id'])) {
      		$this->data['length_class_id'] = $this->request->post['length_class_id'];
    	} elseif (!empty($product_info)) {
      		$this->data['length_class_id'] = $product_info['length_class_id'];
    	} else {
      		$this->data['length_class_id'] = $this->config->get('config_length_class_id');
		}

		if (isset($this->request->post['product_attribute'])) {
			$this->data['product_attributes'] = $this->request->post['product_attribute'];
		} elseif (isset($this->request->get['product_id'])) {
			$this->data['product_attributes'] = $this->model_catalog_product->getProductAttributes($this->request->get['product_id']);
		} else {
			$this->data['product_attributes'] = array();
		}
		
        // $this->data['product_fabric_values'] = array();
        
        // if (isset($this->request->get['product_id'])) {
        //     $this->data['product_fabric_values'] = $this->model_catalog_product->getAllFabricByProduct($this->request->get['product_id']);
        // }
        		
        // $this->data['append_fabric'] = array();
        // $this->data['price_fabric_option'] = array();
        
		if (isset($this->request->post['product_option'])) {
			$product_options = $this->request->post['product_option'];
		} elseif (isset($this->request->get['product_id'])) {
			$product_options = $this->model_catalog_product->getProductOptions($this->request->get['product_id']);			
            
            // $data = $this->getOptionFabric($product_options, $this->request->get['product_id']);
            
            // $this->data['append_fabric'] = $data['option_to_fabric'];
            // $this->data['price_fabric_option'] = $data['price_fabric_option'];
        } else {
			$product_options = array();
		}
		
		$this->data['product_options'] = array();
		
		foreach ($product_options as $product_option) {
			if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {
				$product_option_value_data = array();
				
				foreach ($product_option['product_option_value'] as $product_option_value) {
					$product_option_value_data[] = array(
						'product_option_value_id' => $product_option_value['product_option_value_id'],
						'option_value_id'         => $product_option_value['option_value_id'],
						'quantity'                => $product_option_value['quantity'],
						'subtract'                => $product_option_value['subtract'],
						'price'                   => $product_option_value['price'],
						'price_prefix'            => $product_option_value['price_prefix'],
						'points'                  => $product_option_value['points'],
						'points_prefix'           => $product_option_value['points_prefix'],						
						'weight'                  => $product_option_value['weight'],
						'weight_prefix'           => $product_option_value['weight_prefix'],
						'sort_order'              => $product_option_value['sort_order']
					);						
				}
				
				$this->data['product_options'][$product_option['product_option_id']] = array(
					'product_option_id'    => $product_option['product_option_id'],
					'product_option_value' => $product_option_value_data,
					'option_id'            => $product_option['option_id'],
					'name'                 => $product_option['name'],
					'type'                 => $product_option['type'],
					'required'             => $product_option['required'],
                    // 'append_fabric'       => $product_option['append_fabric']
				);
			} else {
				$this->data['product_options'][$product_option['product_option_id']] = array(
					'product_option_id' => $product_option['product_option_id'],
					'option_id'         => $product_option['option_id'],
					'name'              => $product_option['name'],
					'type'              => $product_option['type'],
					'option_value'      => $product_option['option_value'],
					'required'          => $product_option['required']
				);
			}
		}
		
		$this->data['option_values'] = array();
		
		foreach ($product_options as $product_option) {
			if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {
				if (!isset($this->data['option_values'][$product_option['option_id']])) {
					$this->data['option_values'][$product_option['option_id']] = $this->model_catalog_option->getOptionValues($product_option['option_id']);
				}
			}
		}
        
        $this->data['product_table'] = array();

        if (isset($this->request->post['product_table'])) {
        	$this->data['product_table'] = $this->request->post['product_table'];
       	} elseif (isset($this->request->get['product_id'])) {
       		$this->data['product_table'] = $this->model_catalog_product->getProductTable($this->request->get['product_id']);
       		
       		if (isset($this->data['product_table']['table'])) {
	       		foreach ($this->data['product_table']['table'] as $key_table => $product_table) {
	       			foreach ($product_table['option_id'] as $key_table_option => $product_table_option) {
	       				foreach ($product_table_option['product_table_option_value'] as $key_table_option_value => $product_table_option_value) {
							if ($product_table_option_value['product_table_option_value_image'] && file_exists(DIR_IMAGE . $product_table_option_value['product_table_option_value_image'])) {
								$image = $product_table_option_value['product_table_option_value_image'];
							} else {
								$image = '';
							}
							
							$this->data['product_table']['table'][$key_table]['option_id'][$key_table_option]['product_table_option_value'][$key_table_option_value]['product_table_option_value_image'] = array(
								'image'      => $image,
								'thumb'      => $this->model_tool_image->resize($image, 100, 100)
							);
						}
	       			}
	       		}
	       	}
        } else {
        	$this->data['product_table'] = array();
        }
        
        if (isset($this->request->post['product_fabric'])) {
        	$this->data['product_fabric'] = $this->request->post['product_fabric'];
       	} elseif (isset($this->request->get['product_id'])) {
       		$this->data['product_fabric'] = $this->model_catalog_product->getProductFabricOption($this->request->get['product_id']);
        } else {
        	$this->data['product_fabric'] = array();
        }

		$this->data['customer_groups'] = $this->model_sale_customer_group->getCustomerGroups();
		
		if (isset($this->request->post['product_discount'])) {
			$this->data['product_discounts'] = $this->request->post['product_discount'];
		} elseif (isset($this->request->get['product_id'])) {
			$this->data['product_discounts'] = $this->model_catalog_product->getProductDiscounts($this->request->get['product_id']);
		} else {
			$this->data['product_discounts'] = array();
		}

		if (isset($this->request->post['product_special'])) {
			$this->data['product_specials'] = $this->request->post['product_special'];
		} elseif (isset($this->request->get['product_id'])) {
			$this->data['product_specials'] = $this->model_catalog_product->getProductSpecials($this->request->get['product_id']);
		} else {
			$this->data['product_specials'] = array();
		}
		
		if (isset($this->request->post['product_image'])) {
			$product_images = $this->request->post['product_image'];
		} elseif (isset($this->request->get['product_id'])) {
			$product_images = $this->model_catalog_product->getProductImages($this->request->get['product_id']);
		} else {
			$product_images = array();
		}
		
		$this->data['product_images'] = array();
		
		foreach ($product_images as $product_image) {
			if ($product_image['image'] && file_exists(DIR_IMAGE . $product_image['image'])) {
				$image = $product_image['image'];
			} else {
				$image = 'no_image.jpg';
			}
			
			$this->data['product_images'][] = array(
				'image'      => $image,
				'thumb'      => $this->model_tool_image->resize($image, 100, 100),
				'sort_order' => $product_image['sort_order']
			);
		}

		$this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		
		$this->data['downloads'] = $this->model_catalog_download->getDownloads();
		
		if (isset($this->request->post['product_download'])) {
			$this->data['product_download'] = $this->request->post['product_download'];
		} elseif (isset($this->request->get['product_id'])) {
			$this->data['product_download'] = $this->model_catalog_product->getProductDownloads($this->request->get['product_id']);
		} else {
			$this->data['product_download'] = array();
		}		
						
		$categories = $this->model_catalog_category->getAllCategories();

		$this->data['categories'] = $this->getAllCategories($categories);
		
		if (isset($this->request->post['main_category_id'])) {
			$this->data['main_category_id'] = $this->request->post['main_category_id'];
		} elseif (isset($product_info)) {
			$this->data['main_category_id'] = $this->model_catalog_product->getProductMainCategoryId($this->request->get['product_id']);
		} else {
			$this->data['main_category_id'] = 0;
		}
		
		if (isset($this->request->post['product_category'])) {
			$this->data['product_category'] = $this->request->post['product_category'];
		} elseif (isset($this->request->get['product_id'])) {
			$this->data['product_category'] = $this->model_catalog_product->getProductCategories($this->request->get['product_id']);
		} else {
			$this->data['product_category'] = array();
		}
        
		// if (isset($this->request->post['product_options_table'])) {
		// 	$this->data['product_options_table'] = $this->request->post['product_options_table'];
		// } elseif (isset($this->request->get['product_id'])) {
		// 	// $this->data['product_options_table'] = $this->model_catalog_product->getProductCategories($this->request->get['product_id']);
		// } else {
		// 	$this->data['product_options_table'] = array();
		// }
		
		if (isset($this->request->post['product_related'])) {
			$products = $this->request->post['product_related'];
		} elseif (isset($this->request->get['product_id'])) {		
			$products = $this->model_catalog_product->getProductRelated($this->request->get['product_id']);
		} else {
			$products = array();
		}
	
		$this->data['product_related'] = array();
		
		foreach ($products as $product_id) {
			$related_info = $this->model_catalog_product->getProduct($product_id);
			
			if ($related_info) {
				$this->data['product_related'][] = array(
					'product_id' => $related_info['product_id'],
					'name'       => $related_info['name']
				);
			}
		}

    	if (isset($this->request->post['points'])) {
      		$this->data['points'] = $this->request->post['points'];
    	} elseif (!empty($product_info)) {
			$this->data['points'] = $product_info['points'];
		} else {
      		$this->data['points'] = '';
    	}
						
		if (isset($this->request->post['product_reward'])) {
			$this->data['product_reward'] = $this->request->post['product_reward'];
		} elseif (isset($this->request->get['product_id'])) {
			$this->data['product_reward'] = $this->model_catalog_product->getProductRewards($this->request->get['product_id']);
		} else {
			$this->data['product_reward'] = array();
		}
        
        $category_options = array();
        
        if (isset($this->request->get['product_id'])) {
            $product_id=$this->request->get['product_id'];
        }
        
        $path_category = "";
        
        for ($i = 0; $i < count($this->data['product_category']); $i++) {
            if ($i!=count($this->data['product_category'])) {
              $path_category.=	$this->data['product_category'][$i]."_";
            } else {
              $path_category.=	$this->data['product_category'][$i];
            }
        }
        
        $this->data['category_options_error'] = "";
        
        if ($path_category != '') {
            $parts = explode('_', $path_category);

            $results = $this->model_catalog_filter->getOptionByCategoriesId($parts);

			if ($results) {
				foreach($results as $option) {
              		$category_options[] = array(
		                'option_id' 				=> $option['option_id'],
		                'name' 						=> $option['name'],
		                'category_option_values' 	=> $this->model_catalog_filter->getOptionValues($option['option_id'])
              		);
            	}
          } else {
            $this->data['category_options_error'].= 'Этой категории товаров не присвоен ни один фильтр';
          }
        } else {
        	$this->data['category_options_error'] .= 'Сначала выберите категорию товаров';
        }

        if (isset($this->request->get['product_id'])) {
            $product_id = $this->request->get['product_id'];
        } else {
            $product_id = 0;
        }
        
        $product_info = $this->model_catalog_product->getProductValues($product_id);
        
        if (isset($this->request->post['product_to_value_id'])) {
			$product_to_value_id = $this->request->post['product_to_value_id'];
        } elseif (isset($product_info)) {
            $product_to_value_id = $this->model_catalog_product->getProductValues($product_id);
        } else {
			$product_to_value_id = array();
        }

        $this->data['language_id'] = $this->config->get('config_language_id');
        $this->data['category_options'] = $category_options;
        $this->data['product_to_value_id'] = $product_to_value_id;

		if (isset($this->request->post['product_layout'])) {
			$this->data['product_layout'] = $this->request->post['product_layout'];
		} elseif (isset($this->request->get['product_id'])) {
			$this->data['product_layout'] = $this->model_catalog_product->getProductLayouts($this->request->get['product_id']);
		} else {
			$this->data['product_layout'] = array();
		}
                
		$this->data['category_fabric'] = $this->model_catalog_category_fabric->getCategoryFabric();
        		
		$this->data['layouts'] = $this->model_design_layout->getLayouts();
										
		$this->template = 'catalog/product_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
  	}
	
  	private function validateForm() {
    	if (!$this->user->hasPermission('modify', 'catalog/product')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}

    	foreach ($this->request->post['product_description'] as $language_id => $value) {
      		if ((utf8_strlen($value['name']) < 1) || (utf8_strlen($value['name']) > 255)) {
        		$this->error['name'][$language_id] = $this->language->get('error_name');
      		}
    	}
		
		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}
					
    	if (!$this->error) {
			return true;
    	}

      	return false;
  	}
  	
	private function validateTotal() {
    	if (!$this->user->hasPermission('modify', 'catalog/product')) {
      		$this->error['warning'] = $this->language->get('error_permission');  
    	}
		
		if (!$this->error) {
	  		return true;
		}

	  	return false;
  	}
	
	public function autocomplete() {
		$json = array();
		
		if (isset($this->request->get['filter_name']) || isset($this->request->get['filter_model']) || isset($this->request->get['filter_category_id'])) {
			$this->load->model('catalog/product');
			
			if (isset($this->request->get['filter_name'])) {
				$filter_name = $this->request->get['filter_name'];
			} else {
				$filter_name = '';
			}

			if (isset($this->request->get['filter_model'])) {
				$filter_model = $this->request->get['filter_model'];
			} else {
				$filter_model = '';
			}
			
			if (isset($this->request->get['filter_category_id'])) {
				$filter_category_id = $this->request->get['filter_category_id'];
			} else {
				$filter_category_id = '';
			}
			
			if (isset($this->request->get['filter_sub_category'])) {
				$filter_sub_category = $this->request->get['filter_sub_category'];
			} else {
				$filter_sub_category = '';
			}
			
			$data = array(
				'filter_name'         => $filter_name,
				'filter_model'        => $filter_model,
				'filter_category_id'  => $filter_category_id,
				'filter_sub_category' => $filter_sub_category,
				'start'               => 0,
				'limit'               => $this->config->get('config_admin_limit')
			);
			
			$results = $this->model_catalog_product->getProducts($data);
			
			foreach ($results as $result) {
				// $option_data = array();
				
				// $product_options = $this->model_catalog_product->getProductOptions($result['product_id']);	
				
				// foreach ($product_options as $product_option) {
				// 	if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {
				// 		$option_value_data = array();
					
				// 		foreach ($product_option['product_option_value'] as $product_option_value) {
				// 			$option_value_data[] = array(
				// 				'product_option_value_id' => $product_option_value['product_option_value_id'],
				// 				'option_value_id'         => $product_option_value['option_value_id'],
				// 				'name'                    => $product_option_value['name'],
				// 				'price'                   => (float)$product_option_value['price'] ? $this->currency->format($product_option_value['price'], $this->config->get('config_currency')) : false,
				// 				'price_prefix'            => $product_option_value['price_prefix']
				// 			);	
				// 		}
					
				// 		$option_data[] = array(
				// 			'product_option_id' => $product_option['product_option_id'],
				// 			'option_id'         => $product_option['option_id'],
				// 			'name'              => $product_option['name'],
				// 			'type'              => $product_option['type'],
				// 			'option_value'      => $option_value_data,
				// 			'required'          => $product_option['required'],
				// 		);	
				// 	} else {
				// 		$option_data[] = array(
				// 			'product_option_id' => $product_option['product_option_id'],
				// 			'option_id'         => $product_option['option_id'],
				// 			'name'              => $product_option['name'],
				// 			'type'              => $product_option['type'],
				// 			'option_value'      => $product_option['option_value'],
				// 			'required'          => $product_option['required'],
				// 		);				
				// 	}
				// }
				
				$json[] = array(
					'product_id' => $result['product_id'],
					'name'       => html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'),	
					'model'      => $result['model'],
					// 'option'     => $option_data,
					'price'      => $result['price']
				);	
			}
		}

		$this->response->setOutput(json_encode($json));
	}

	private function getAllCategories($categories, $parent_id = 0, $parent_name = '') {
		$output = array();

		if (array_key_exists($parent_id, $categories)) {
			if ($parent_name != '') {
				$parent_name .= $this->language->get('text_separator');
			}

			foreach ($categories[$parent_id] as $category) {
				$output[$category['category_id']] = array(
					'category_id' => $category['category_id'],
					'name'        => $parent_name . $category['name']
				);

				$output += $this->getAllCategories($categories, $category['category_id'], $parent_name . $category['name']);
			}
		}

		return $output;
	}

	public function getProduct() {
        $this->load->model('catalog/product');
        
        $manufacturer_id = $this->request->get['manufacturer_id'];
        
        $products = $this->model_catalog_product->getProductManufacturerId($manufacturer_id);
        
        $data_product = array();
        
        foreach ($products as $product) {
            $data_product[] = array('product_id' => $product['product_id'], 'name' => $product['name'], 'model' => $product['model']);
        }
        
        $result = array();
        
        if (count($data_product)) {
             $result = array('type' => 'success', 'data' => $data_product);
        } else {
            $result = array('type' => 'error', 'message' => "Данные по товарам не получены");
        }
        
        print json_encode($result);
        return;
    }

    public function getOptionValues() {
    	$this->load->model('catalog/option');
    	
    	$options_value = $this->model_catalog_option->getOptionValues($this->request->get['option_id']);
    	$option_desc = $this->model_catalog_option->getOptionDescriptions($this->request->get['option_id']);
    	
    	echo json_encode(array('options_value' => $options_value, 'option_desc' => $option_desc));
    }

    public function getUrl() {
    	$url = '';
		
		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_manufacturer'])) {
			$url .= '&filter_manufacturer=' . $this->request->get['filter_manufacturer'];
		}
		
		if (isset($this->request->get['filter_category_id'])) {
			$url .= '&filter_category_id=' . $this->request->get['filter_category_id'] . '&filter_sub_category=true';
		}

		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_sub_category'])) {
			$url .= '&filter_sub_category=' . $this->request->get['filter_sub_category'];
		}
		
		if (isset($this->request->get['filter_category_id'])) {
			$url .= '&filter_category_id=' . $this->request->get['filter_category_id'];
		}

		if (isset($this->request->get['filter_price'])) {
			$url .= '&filter_price=' . $this->request->get['filter_price'];
		}
		
		if (isset($this->request->get['filter_image'])) {
			$url .= '&filter_image=' . $this->request->get['filter_image'];
		}

		if (isset($this->request->get['filter_quantity'])) {
			$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
		}	
	
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}
		
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
		
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		
		if (isset($this->request->get['limit'])) {
			$url .= '&limit=' . $this->request->get['limit'];
		}

		return $url;
    }

    public function switch_prod() {
    	$this->load->language('catalog/product');
    	$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('catalog/product');
		
		if (isset($this->request->post['selected']) && isset($this->request->get['switch']) && $this->validateTotal()) {
			$this->model_catalog_product->switch_prod(array('products' => $this->request->post['selected'], 'status' => $this->request->get['switch']));
			
			$this->session->data['success'] = $this->language->get('text_success');
			$url = $this->getUrl();
			
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

    	$this->getList();
    }

    // public function getProductOptionValue() {
        // 	$this->load->model('catalog/product');
            
        //     $product_id = $this->request->get['product_id'];
        //     $option_horizont = $this->request->get['option_horizont'];
        //     $option_vertical = $this->request->get['option_vertical'];

        //     $option_value_horizont = $this->model_catalog_product->getOptionValue($product_id, $option_horizont);
        //     $option_value_vertical = $this->model_catalog_product->getOptionValue($product_id, $option_vertical);

        //     $data = array();
            
        //     if (count($option_value_horizont) > 0 && count($option_value_vertical) > 0) {
        //         $data = array('type' => 'success', 'option_value_horizont' => $option_value_horizont, 'option_value_vertical' => $option_value_vertical);
        //         $this->model_catalog_product->deleteProductOptionsPrice($product_id);
        //     } else {
        //         $data = array('type' => 'error', 'message' => "Данные не получены!");
        //     }
            
        //     print json_encode($data);
        //     return;
    // }

    // public function deletePriceOption() {
        //     $this->load->model('catalog/product');
            
        //     if (isset($this->request->get['product_id'])) {
        //         $product_id = $this->request->get['product_id'];
        //     } else {
        //         $result = array('type' => 'error', 'message' => "Не существует id товара!");
                
        //         print json_encode($result);
        //         return;
        //     }
            
        //     $product_option_value_id = $this->request->get['product_option_value_id'];
            
        //     $this->model_catalog_product->deletePriceOption($product_id, $product_option_value_id);
            
        //     $product_options = $this->model_catalog_product->getProductOptions($product_id);
        //     $data_option = $this->getOptionFabric($product_options, $product_id);
        //     $data_fabric = $this->model_catalog_product->getProductFabric($product_id);
            
        //     $result = array('type' => 'success', 'message' => 'Операция успешна', 'data_option' => $data_option, 'data_fabric' => $data_fabric);
            
        //     print json_encode($result);
        //     return;
    // }
    
    // public function deleteProductFabric() {
        //     $this->load->model('catalog/product');
            
        //     if (isset($this->request->get['product_id'])) {
        //         $product_id = $this->request->get['product_id'];
        //     } else {
        //         $result = array('type' => 'error', 'message' => "Не существует id товара!");
                
        //         print json_encode($result);
        //         return;
        //     }
            
        //     $fabric_id = $this->request->get['fabric_id'];
            
        //     $this->model_catalog_product->deleteProductFabric($product_id, $fabric_id);
            
        //     $product_fabrics = $this->model_catalog_product->getProductFabric($product_id);
        //     $result = array('type' => 'success', 'message' => "Категория удалена! Обновлен список категорий!", "data" => $product_fabrics);
            
        //     print json_encode($result);
        //     return;
    // }
    
    // public function saveFabric() {
        //     $this->load->model('catalog/product');
        //     $this->load->model('catalog/category_fabric');
            
        //     if (isset($this->request->get['product_id'])) {
        //         $product_id = $this->request->get['product_id'];
        //     } else {
        //         $result = array('type' => 'error', 'message' => "Не существует id товара!");
                
        //         print json_encode($result);
        //         return;
        //     }
            
        //     $fabric_id = $this->request->get['fabric_id'];
            
        //     $getFabricProduct = $this->model_catalog_product->getFabricProduct($product_id, $fabric_id);
        //     $fabric = $this->model_catalog_category_fabric->getFabricId($fabric_id);
            
        //     if ($getFabricProduct == FALSE) {
        //         $this->model_catalog_product->saveProductFabric($product_id, $fabric_id);
        //         $fabrics = $this->model_catalog_product->getProductFabric($product_id);
                
        //         $product_options = $this->model_catalog_product->getProductOptions($product_id);
        //         $data_option = $this->getOptionFabric($product_options, $product_id);
                
        //         $data = array('type' => 'success', 'message' => "Добавлена категория " . $fabric['name'], 'fabric_id' => $fabric['fabric_id'], 'name' => $fabric['name'], 'fabric' => $fabrics, 'data_option' => $data_option,);
        //     } else {
        //         $data = array('type' => 'error', 'message' => "Категория " . $fabric['name'] . " уже добавлена");
        //     }
            
        //     print json_encode($data);
        //     return;
    // }
    
    // public function copyProduct() {
        //     $this->load->model('catalog/product');
            
        //     if (isset($this->request->get['product_id'])) {
        //         $product_id = $this->request->get['product_id'];
        //     } else {
        //         $result = array('type' => 'error', 'message' => "Не существует id товара!");
                
        //         print json_encode($result);
        //         return;
        //     }
            
        //     $status_fabric = $this->model_catalog_product->getProductStatusFabric($product_id);
        //     $products = explode(",", $this->request->get['product']);
            
        //     $fabrics = $this->model_catalog_product->getAllFabricByProduct($product_id);
            
        //     foreach ($products as $product) {
        //         $this->model_catalog_product->status_fabric($status_fabric['status_fabric'], $product);
                
        //         $fabric_list = $this->model_catalog_product->getProductFabric($product);
                
        //         $this->model_catalog_product->deleteFabricValue($product);
                
        //         foreach ($fabric_list as $fabric) {
        //             $fabric_data = $this->model_catalog_product->getFabricProduct($product_id, $fabric['fabric_id']);
                    
        //             if (!$fabric_data) {
        //                 $this->model_catalog_product->deleteProductFabric($product, $fabric['fabric_id']);
        //             }
        //         }
                
        //         foreach ($fabrics as $fabric) {
        //             $fabric_data = $this->model_catalog_product->getFabricProduct($product, $fabric['fabric_id']);
                
        //             if (!$fabric_data) {
        //                 $this->model_catalog_product->saveProductFabric($product, $fabric['fabric_id']);
        //             }
                    
        //             foreach ($fabric['product_fabric_values'] as $fabric_value) {
        //                 $fabric_value['product_id'] = $product;
        //                 $this->model_catalog_product->saveProductFabricValue($fabric_value);
        //             }
        //         }
        //     }
                
        //     $result = array('type' => 'success', 'message' => "Операция успешна!");
        //     print json_encode($result);
        //     return;
    // }
    
    // public function savePrice() {
        //     $this->load->model('catalog/product');
            
        //     if (isset($this->request->get['product_id'])) {
        //         $product_id = $this->request->get['product_id'];
        //     } else {
        //         $result = array('type' => 'error', 'message' => "Не существует id товара!");
                
        //         print json_encode($result);
        //         return;
        //     }
            
        //     $price_data = explode(',', $this->request->get['price_data']);
        //     $fabric = explode(',', $this->request->get['fabric_id']);
            
        //     if (isset($this->request->get['product_option_value']) && isset($this->request->get['product_option_id'])) {
        //         $product_option_value = explode(",", $this->request->get['product_option_value']);
                
        //         $product_option_id = $this->request->get['product_option_id'];
        //     } else {
        //         $product_option_id = 0;
        //         $product_option_value = array();
        //     }
            
        //     $dublicate = array_count_values($product_option_value);
        //     $error = array();
            
        //     foreach ($dublicate as $key => $value) {
        //         if ($value > 1) {
        //             $name_option = $this->model_catalog_product->getOptionProduct($key);
        //             $error[] = "Опция '" . $name_option[0]['name'] . "' не должна повторяться.";
        //         }
        //     }
            
        //     if (count($error) > 0) {
        //         $error = implode("\n", $error);
                
        //         $result = array('type' => 'error', 'message' => $error);
        //         print json_encode($result);
        //         return;
        //     }
            
        //     $dataPrice = array(
        //             'product_id'        => $product_id,
        //             'product_option_id' => $product_option_id
        //     );
            
        //     $this->model_catalog_product->deletePriceFabricOption($dataPrice);
            
        //     $position = 0;
            
        //     foreach ($product_option_value as $product_option_value_id) {
        //         $dataPrice['product_option_value_id'] = $product_option_value_id;
                
        //         foreach ($fabric as $fabric_id) {
        //             $dataPrice['price']     = $price_data[$position];
        //             $dataPrice['fabric_id'] = $fabric_id;
                    
        //             $this->model_catalog_product->savePrice($dataPrice);
                    
        //             $position += 1;
        //         }
        //     }
            
        //     $position = 0;
            
        //     if (count($product_option_value) == 0) {
        //         $dataPrice['product_option_value_id'] = 0;
                
        //         foreach ($fabric as $fabric_id) {
        //             $dataPrice['price']     = $price_data[$position];
        //             $dataPrice['fabric_id'] = $fabric_id;
                    
        //             $this->model_catalog_product->savePrice($dataPrice);
                    
        //             $position += 1;
        //         }
        //     }
            
        //     $product_options = $this->model_catalog_product->getProductOptions($product_id);
        //     $data_option = $this->getOptionFabric($product_options, $product_id);
        //     $data_fabric = $this->model_catalog_product->getProductFabric($product_id);
            
        //     $result = array('type' => 'success', 'message' => 'Операция успешна!', 'data_option' => $data_option, 'data_fabric' => $data_fabric);
        //     print json_encode($result);
        //     return;
    // }
    
    // public function saveProductFabricValue() {
        //     $this->load->model('catalog/product');
        //     $this->load->model('catalog/category_fabric');
            
        //     if (isset($this->request->get['product_id'])) {
        //         $product_id = $this->request->get['product_id'];
        //     } else {
        //         $result = array('type' => 'error', 'message' => "Не существует id товара!");
                
        //         print json_encode($result);
        //         return;
        //     }
            
        //     $fabric_value = $this->request->get['fabric_value'];
        //     $fabric_id = $this->request->get['fabric_id'];
        //     $manufacturer_id = $this->request->get['manufacturer_id'];
            
        //     $fabrics = explode(",", $fabric_value);
            
        //     $this->model_catalog_product->deleteProductFabricValue($product_id, $fabric_id, $manufacturer_id);
            
        //     $data = array('product_id' => $product_id, 'fabric_id' => $fabric_id, 'manufacturer_id' => $manufacturer_id);
            
        //     foreach ($fabrics as $fabric_product_id) {
        //         $data['fabric_product_id'] = $fabric_product_id;
        //         $this->model_catalog_product->saveProductFabricValue($data);
        //     }
            
        //     $product_fabric_value = $this->model_catalog_product->getProductFabricValue($product_id, $fabric_id);
        //     $edit_fabric = $this->model_catalog_category_fabric->getFabricId($fabric_id);
            
        //     $result = array('type' => 'success', 'message' => "Список тканей по категории " . $edit_fabric['name'] . " обновлен", 'name' => $edit_fabric['name']);
            
        //     foreach ($product_fabric_value as $fabric) {
        //         $result['data'][] = array('name' => $fabric['name'], 'model' => $fabric['model']);
        //     }
            
        //     print json_encode($result);
        //     return;
    // }
    
    // public function deleteAllFabricByProduct() {
        //     $this->load->model('catalog/product');
            
        //     if (isset($this->request->get['product_id'])) {
        //         $product_id = $this->request->get['product_id'];
        //     } else {
        //         $result = array('type' => 'error', 'message' => "Не существует id товара!");
                
        //         print json_encode($result);
        //         return;
        //     }
            
        //     $this->model_catalog_product->deleteAllFabricByProduct($product_id);
            
        //     $result = array('type' => 'success', 'message' => 'Операция успешна! Перезагрузите страницу!');
            
        //     print json_encode($result);
        //     return;
    // }
    
    // public function update_status_fabric() {
        //     $this->load->model('catalog/product');
            
        //     if (isset($this->request->get['product_id'])) {
        //         $product_id = $this->request->get['product_id'];
        //     } else {
        //         $result = array('type' => 'error', 'message' => "Не существует id товара!");
                
        //         print json_encode($result);
        //         return;
        //     }
            
        //     $status_fabric = $this->request->get['status_fabric'];
            
        //     $this->model_catalog_product->status_fabric($status_fabric, $product_id);
            
        //     $result = array('type' => 'success', 'message' => 'Операция успешна! Перезагрузите страницу!');
            
        //     print json_encode($result);
        //     return;
    // }
    
    // public function getManufacturerByCategory() {
        //     $this->load->model('catalog/manufacturer');
            
        //     $category_id = $this->request->get['category_id'];
            
        //     $manufacturers = $this->model_catalog_manufacturer->getManufactByCategory($category_id);
            
        //     $data = array();
            
        //     if (count($manufacturers) > 0) {
        //         $data = array('type' => 'success', 'data' => $manufacturers);
        //     } else {
        //         $data = array('type' => 'error', 'message' => "Данные по производителям не получены!");
        //     }
            
        //     print json_encode($data);
        //     return;
    // }
    
    // public function getFabricByProduct() {
        //     $this->load->model('catalog/product');
            
        //     if (isset($this->request->get['product_id'])) {
        //         $product_id = $this->request->get['product_id'];
        //     } else {
        //         $result = array('type' => 'error', 'message' => "Не существует id товара!");
                
        //         print json_encode($result);
        //         return;
        //     }
            
        //     $fabrics = $this->model_catalog_product->getProductFabric($product_id);
            
        //     $data = array();
            
        //     if (count($fabrics) > 0) {
        //         $data = array('type' => 'success', 'data' => $fabrics);
        //     } else {
        //         $data = array('type' => 'error', 'message' => "У данного товара нет категории ткани.");
        //     }
            
        //     print json_encode($data);
        //     return;
    // }
    
    // public function getFabricValueByProduct() {
        //     $this->load->model('catalog/product');
            
        //     if (isset($this->request->get['product_id'])) {
        //         $product_id = $this->request->get['product_id'];
        //     } else {
        //         $result = array('type' => 'error', 'message' => "Не существует id товара!");
                
        //         print json_encode($result);
        //         return;
        //     }
            
        //     $manufacturer_id = $this->request->get['manufacturer_id'];
        //     $fabric_id = $this->request->get['fabric_id'];
            
        //     $data = $this->model_catalog_product->getProductManufacturerId($manufacturer_id);
        //     $fabric_product = $this->model_catalog_product->getProductFabricValue($product_id, $fabric_id);
            
        //     $position = 0;
        //     $fabric = array();
            
        //     foreach ($data as $data_fabric) {
        //         $fabric[$position] = array('product_id' => $data_fabric['product_id'], 'name' => $data_fabric['name'], "model" => $data_fabric['model']);
                
        //         foreach ($fabric_product as $fabric_checked) {
        //              if ($data_fabric['product_id'] == $fabric_checked['fabric_product_id']) {
        //                 $fabric[$position]['checked'] = 'checked';
        //              }
        //          }
                 
        //          $position += 1;
        //     }
            
        //     if ($fabric) {
        //          $result = array('type' => 'success', 'fabric' => $fabric);
        //     } else {
        //         $result = array('type' => 'error', 'message' => "Данные по тканям не получены");
        //     }
            
        //     print json_encode($result);
        //     return;
    // }
    
    // public function getFabricAdd($product_options) {
        //     $this->load->model('catalog/product');
            
        //     $option_to_fabric = array();
            
        //     foreach ($product_options as $product_option) {
        //         $product_option_value_fabric = array();
                
        //         if ($product_option['append_fabric']) {
        //             foreach ($product_option['product_option_value'] as $product_option_value) {
        //                 $result = $this->model_catalog_product->getOptionByFabric($product_option_value['product_option_value_id']);
                        
        //                 if ($result !== FALSE) {
        //                     $product_option_value_fabric[] = array(
        //                         'product_option_value_id'           => $product_option_value['product_option_value_id']
        //                     );
        //                 }
        //             }
                    
        //             $option_to_fabric = array(
        //                 'name'                          => $product_option['name'],
        //                 'product_option_id'             => $product_option['product_option_id'],
        //                 'product_option_value'          => $product_option['product_option_value'],
        //                 'product_option_value_fabric'   => $product_option_value_fabric
        //             );
        //         }
        //     }
            
        //     return $option_to_fabric;
    // }
    
    // public function getOptionFabric($product_options, $product_id) {
        //     $this->load->model('catalog/product');
            
        //     $price_fabric_option = array();
            
        //     $option_to_fabric = $this->getFabricAdd($product_options);
            
        //     if (isset($option_to_fabric['product_option_id'])) {
        //         foreach ($option_to_fabric['product_option_value_fabric'] as $product_option_value) {
        //             $price_fabric_option[] = array(
        //                 'priceData'                 => $this->model_catalog_product->getPriceFabric($product_id, $product_option_value['product_option_value_id']),
        //                 'product_option_value_id'   => $product_option_value['product_option_value_id']
        //             );
        //         }
        //     } else {
        //         $product_option_value_id = 0;
                
        //         $price_fabric_option[] = array(
        //             'priceData'                 => $this->model_catalog_product->getPriceFabric($product_id, $product_option_value_id),
        //             'product_option_value_id'   => $product_option_value_id
        //         );
        //     }
            
        //     $data = array(
        //         'option_to_fabric'      => $option_to_fabric,
        //         'price_fabric_option'   => $price_fabric_option
        //     );
            
        //     return $data;
    // }
    
    // public function removeOption() {
        //     $this->load->model('catalog/product');
            
        //     if (isset($this->request->get['product_id'])) {
        //         $product_id = $this->request->get['product_id'];
        //     } else {
        //         $result = array('type' => 'error', 'message' => "Не существует id товара!");
                
        //         print json_encode($result);
        //         return;
        //     }
            
        //     $product_option_id = $this->request->get['product_option_id'];

        //     $this->model_catalog_product->removeOption($product_id, $product_option_id);

        //     $product_options = $this->model_catalog_product->getProductOptions($product_id);
        //     $data_option = $this->getOptionFabric($product_options, $product_id);
        //     $data_fabric = $this->model_catalog_product->getProductFabric($product_id);
        //     $product_option_price = $this->model_catalog_product->getProductOptionsPrice($product_id);

        //     $result = array('type' => 'success', 'message' => 'Операция успешна!', 'data_option' => $data_option, 'data_fabric' => $data_fabric, 'product_option_price' => $product_option_price);
        //     print json_encode($result);
        //     return;
    // }
    
    // public function removeOptionValue() {
        //     $this->load->model('catalog/product');
            
        //     if (isset($this->request->get['product_id'])) {
        //         $product_id = $this->request->get['product_id'];
        //     } else {
        //         $result = array('type' => 'error', 'message' => "Не существует id товара!");
                
        //         print json_encode($result);
        //         return;
        //     }
            
        //     $product_option_id = $this->request->get['product_option_id'];
        //     $product_option_value_id = $this->request->get['product_option_value_id'];
            
        //     $this->model_catalog_product->removeOptionValue($product_id, $product_option_id, $product_option_value_id);
            
        //     $product_options = $this->model_catalog_product->getProductOptions($product_id);
        //     $data_option = $this->getOptionFabric($product_options, $product_id);
        //     $data_fabric = $this->model_catalog_product->getProductFabric($product_id);
        //     $product_option_price = $this->model_catalog_product->getProductOptionsPrice($product_id);

        //     $result = array('type' => 'success', 'message' => 'Операция успешна!', 'data_option' => $data_option, 'data_fabric' => $data_fabric, 'product_option_price' => $product_option_price);
        //     print json_encode($result);
        //     return;
    // }
    
    // public function optionFabric() {
        //     $this->load->model('catalog/product');
            
        //     if (isset($this->request->get['product_id'])) {
        //         $product_id = $this->request->get['product_id'];
        //     } else {
        //         $result = array('type' => 'error', 'message' => "Не существует id товара!");
                
        //         print json_encode($result);
        //         return;
        //     }
            
        //     $product_option_id = $this->request->get['product_option_id'];
        //     $value = $this->request->get['value'];
            
        //     $dataPrice = array(
        //         'product_id'        => $product_id,
        //         'product_option_id' => $product_option_id
        //     );
            
        //     $this->model_catalog_product->appendFabric($product_option_id, $value);
            
        //     if ((int)$value) {
        //         $dataPrice['product_option_id'] = 0;
        //     }
            
        //     $this->model_catalog_product->deletePriceFabricOption($dataPrice);
            
        //     $product_options = $this->model_catalog_product->getProductOptions($product_id);
        //     $data_option = $this->getOptionFabric($product_options, $product_id);
        //     $data_fabric = $this->model_catalog_product->getProductFabric($product_id);
            
        //     $result = array('type' => 'success', 'message' => 'Операция успешна!', 'data_option' => $data_option, 'data_fabric' => $data_fabric);
        //     print json_encode($result);
        //     return;
    // }
}
?>