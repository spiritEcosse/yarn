<?php
abstract class Controller {
	protected $registry;	
	protected $id;
	protected $layout;
	protected $template;
	protected $children = array();
	protected $data = array();
	protected $output;
	private $number_tax = 1;
	
	public function __construct($registry) {
		$this->registry = $registry;
	}
	
	public function __get($key) {
		return $this->registry->get($key);
	}
	
	public function __set($key, $value) {
		$this->registry->set($key, $value);
	}
			
	protected function forward($route, $args = array()) {
		return new Action($route, $args);
	}

	protected function redirect($url, $status = 302) {
		header('Status: ' . $status);
		header('Location: ' . str_replace(array('&amp;', "\n", "\r"), array('&', '', ''), $url));
		exit();				
	}
	
	protected function getChild($child, $args = array()) {
		$action = new Action($child, $args);
		$file = $action->getFile();
		$class = $action->getClass();
		$method = $action->getMethod();
		
		global $vqmod;
		$file = $vqmod->modCheck($file);

		if (file_exists($file)) {
			require_once($file);

			$controller = new $class($this->registry);
			
			$controller->$method($args);

			return $controller->output;
		} else {
			trigger_error('Error: Could not load controller ' . $child . '!');
			exit();					
		}		
	}
	
	protected function render() {
		foreach ($this->children as $child) {
			$this->data[basename($child)] = $this->getChild($child);
		}

		global $vqmod;
		$file = $vqmod->modCheck(DIR_TEMPLATE . $this->template);

		if (file_exists($file)) {
			extract($this->data);
			
      		ob_start();
      		
      		require($file);
	  		$this->output = ob_get_contents();

      		ob_end_clean();
      		
			return $this->output;
    	} else {
			trigger_error('Error: Could not load template ' . $file . '!');
			exit();				
    	}
	}
	
	protected function breadcrumbs() {
		$this->data['breadcrumbs'] 	= array();

		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),
       		'separator' => false
   		);
	}
	
	protected function totals($data_post_request, $setting = false) {
		$this->load->model('setting/setting');
		$this->breadcrumbs();

		$plus_minus_quantity = $this->model_setting_setting->getSetting('plus_minus_quantity', $data_post_request);

		if (!empty($plus_minus_quantity)) {
			$this->data['plus_minus_quantity'] = $plus_minus_quantity['plus_minus_quantity_module']['1']['enable_on_views']['category'];
		}
		
		if ($setting !== false && isset($setting['image_height'])) {
			$this->data['height'] = 230 + $setting['image_height'];
		}
	}

	protected function getText() {
		$this->language->load('product/category');
		$this->language->load('module/fastorder');
		$this->language->load('GALKA_custom/GALKA');
		$this->language->load('module/filterpro');
    	$this->language->load('product/search');

		$this->data['text_refine'] 			= $this->language->get('text_refine');
		$this->data['text_empty'] 			= $this->language->get('text_empty');			
		$this->data['text_quantity']		= $this->language->get('text_quantity');
		$this->data['text_manufacturer'] 	= $this->language->get('text_manufacturer');
		$this->data['text_model'] 			= $this->language->get('text_model');
		$this->data['text_price'] 			= $this->language->get('text_price');
		$this->data['text_tax'] 			= $this->language->get('text_tax');
		$this->data['text_points'] 			= $this->language->get('text_points');
		$this->data['text_compare'] 		= sprintf($this->language->get('text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));
		$this->data['text_display'] 		= $this->language->get('text_display');
		$this->data['text_list'] 			= $this->language->get('text_list');
		$this->data['text_grid'] 			= $this->language->get('text_grid');
		$this->data['text_sort'] 			= $this->language->get('text_sort');
		$this->data['text_limit'] 			= $this->language->get('text_limit');
		$this->data['text_fastorder'] 		= $this->language->get('text_fastorder');
		$this->data['text_wish'] 			= $this->language->get('text_wish');
		$this->data['text_sale'] 			= $this->language->get('text_sale');
		$this->data['text_save'] 			= $this->language->get('text_save');
		$this->data['text_new_prod'] 		= $this->language->get('text_new_prod');
		$this->data['text_left'] 			= $this->language->get('text_left');
		$this->data['text_purchased'] 		= $this->language->get('text_purchased');
		$this->data['text_limited'] 		= $this->language->get('text_limited');
		$this->data['text_shop_by_price'] 	= $this->language->get('text_shop_by_price');
		$this->data['text_price_range'] 	= $this->language->get('text_price_range');
		$this->data['text_manufacturers'] 	= $this->language->get('text_manufacturers');
		$this->data['text_tags'] 			= $this->language->get('text_tags');
		$this->data['text_categories'] 		= $this->language->get('text_categories');
		$this->data['text_attributes'] 		= $this->language->get('text_attributes');
		$this->data['text_all'] 			= $this->language->get('text_all');
		$this->data['text_critea'] 			= $this->language->get('text_critea');
    	$this->data['text_search'] 			= $this->language->get('text_search');
		$this->data['text_keyword'] 		= $this->language->get('text_keyword');
		$this->data['text_category'] 		= $this->language->get('text_category');
		$this->data['text_sub_category'] 	= $this->language->get('text_sub_category');
		$this->data['text_general_info'] 	= $this->language->get('text_general_info');
		$this->data['text_only'] 			= $this->language->get('text_only');
        $this->data['tab_attribute'] 		= $this->language->get('tab_attribute');
        $this->data['text_discount'] 		= $this->language->get('text_discount');
        $this->data['text_for_you'] 		= $this->language->get('text_for_you');

		$this->data['button_cart'] 			= $this->language->get('button_cart');
		$this->data['button_wishlist'] 		= $this->language->get('button_wishlist');
		$this->data['button_compare'] 		= $this->language->get('button_compare');
		$this->data['button_continue'] 		= $this->language->get('button_continue');
    	$this->data['button_search'] 		= $this->language->get('button_search');

		$this->data['entry_search'] 		= $this->language->get('entry_search');
    	$this->data['entry_description'] 	= $this->language->get('entry_description');

		$this->data['clear_filter'] 		= $this->language->get('clear_filter');
		$this->data['text_instock'] 		= $this->language->get('text_instock');

		$this->data['symbol_right'] 		= $this->currency->getSymbolRight();
		$this->data['symbol_left'] 			= $this->currency->getSymbolLeft();

		$this->data['continue'] 			= $this->url->link('common/home');
		$this->data['compare'] 				= $this->url->link('product/compare');
	}
	
	protected function buildSort($dataUrl) {
		$this->data['sorts'] = array();

		$sortOrder = array(
            array('sort' => 'p.date_added', 'order' => 'DESC', 'text' => 'text_date_added'),
            array('sort' => 'p.sort_order', 'order' => 'ASC', 'text' => 'text_default'),
            array('sort' => 'pd.name', 'order' => 'ASC', 'text' => 'text_name_asc'),
            array('sort' => 'pd.name', 'order' => 'DESC', 'text' => 'text_name_desc'),
			array('sort' => 'p.price', 'order' => 'ASC', 'text' => 'text_price_asc'),
			array('sort' => 'p.price', 'order' => 'DESC', 'text' => 'text_price_desc'),
			array('sort' => 'p.model', 'order' => 'ASC', 'text' => 'text_model_asc'),
			array('sort' => 'p.model', 'order' => 'DESC', 'text' => 'text_model_desc'),
			array('sort' => 'p.viewed', 'order' => 'DESC', 'text' => 'text_popular'),
		);
		
		if ($this->config->get('config_review_status')) {
			$sortOrder[] = array('sort' => 'rating', 'order' => 'ASC', 'text' => 'text_rating_asc');
			$sortOrder[] = array('sort' => 'rating', 'order' => 'DESC', 'text' => 'text_rating_desc');
		}
		
		$startUrl = '';
		
		if (isset($dataUrl['path'])) {
			$startUrl = $dataUrl['path'];
		}

		foreach ($sortOrder as $array) {
			$this->data['sorts'][] = array(
				'text'  => $this->language->get($array['text']),
				'value' => $array['sort'] . '-' . $array['order'],
				'href'  => $this->url->link($dataUrl['route'], $startUrl . "&sort=" . $array['sort'] . "&order=" . $array['order'] . $dataUrl['url'])
            );
		}
	}

    protected function buildUrl($data_get) {
        $url = '';

        if (isset($data_get['page'])) {
            $url = '&page=' . $data_get['page'];
        }

        if (isset($data_get['sort'])) {
            $url .= '&sort=' . $data_get['sort'];
        }

        if (isset($data_get['order'])) {
            $url .= '&order=' . $data_get['order'];
        }

        if (isset($data_get['filter'])) {
            $url .= '&filter=' . $data_get['filter'];
        }

        if (isset($data_get['limit'])) {
            $url .= '&limit=' . $data_get['limit'];
        }

        return $url;
    }

	protected function buildLimit($dataUrl) {
		$this->data['limits'] = array();
		$startUrl = '';

		if (isset($dataUrl['path'])) {
			$startUrl = $dataUrl['path'];
		}

		for ($count = $this->config->get('config_catalog_limit'); $count <= 100; $count += 24) {
			$this->data['limits'][] = array(
				'text'  => $count,
				'value' => $count,
				'href'  => $this->url->link($dataUrl['route'], $startUrl . '&limit=' . $count. $dataUrl['url'])
			);
		}
	}

    protected function buildSortVideo($dataUrl) {
        $this->data['sorts'] = array();

        $sortOrder = array(
            array('sort' => 'v_sort_order', 'order' => 'ASC', 'text' => 'text_default'),
            array('sort' => 'v_name', 'order' => 'ASC', 'text' => 'text_name_asc'),
            array('sort' => 'v_name', 'order' => 'DESC', 'text' => 'text_name_desc'),
            array('sort' => 'v_video_date_added', 'order' => 'DESC', 'text' => 'text_date_added'),
        );

        $startUrl = '';

        if (isset($dataUrl['road'])) {
            $startUrl = $dataUrl['road'];
        }

        foreach ($sortOrder as $array) {
            $this->data['sorts'][] = array(
                'text'  => $this->language->get($array['text']),
                'value' => $array['sort'] . '-' . $array['order'],
                'href'  => $this->url->link($dataUrl['route'], $startUrl . "&sort=" . $array['sort'] . "&order=" . $array['order'] . $dataUrl['url'])
            );
        }
    }

    protected function buildLimitVideo($dataUrl) {
        $this->data['limits'] = array();
        $startUrl = '';

        if (isset($dataUrl['road'])) {
            $startUrl = $dataUrl['road'];
        }

        for ($count = $this->config->get('config_category_video_limit'); $count <= 50; $count += 10) {
            $this->data['limits'][] = array(
                'text'  => $count,
                'value' => $count,
                'href'  => $this->url->link($dataUrl['route'], $startUrl . '&limit=' . $count. $dataUrl['url'])
            );
        }
    }

	protected function fileRender($file) {
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . $file)) {
			$this->template = $this->config->get('config_template') . $file;
		} else {
			$this->template = 'default' . $file;
		}
		
		$this->children = array(
			'common/column_left',
			'common/column_right',
			'common/content_top',
			'common/content_bottom',
			'common/footer',
			'common/header'
		);
		
		$this->response->setOutput($this->render());
	}

	protected function fileRenderModule($file) {
		$file = $this->config->get('config_template') . $file;
		
		if (file_exists(DIR_TEMPLATE . $file)) {
			$this->template = $file;
		} else {
			$this->template = 'default' . $file;
		}
		
		$this->render();
	}

	protected function getFilterPro() {
		$filterpro_setting = $this->config->get('filterpro_setting');

		$this->data['price_slider'] = $filterpro_setting['price_slider'];
		$this->data['attr_group'] = $filterpro_setting['attr_group'];
		$this->data['instock_checked'] = isset($filterpro_setting['instock_checked']) ? 1 : 0;
		$this->data['instock_visible'] = isset($filterpro_setting['instock_visible']) ? 1 : 0;
	}

	public function rdate($param, $time = 0) {
		$this->language->load('record/blog');
		if (intval($time) == 0) {
			$time = time();
		}
		
		$MonthNames = array(
			$this->language->get('text_january'),
			$this->language->get('text_february'),
			$this->language->get('text_march'),
			$this->language->get('text_april'),
			$this->language->get('text_may'),
			$this->language->get('text_june'),
			$this->language->get('text_july'),
			$this->language->get('text_august'),
			$this->language->get('text_september'),
			$this->language->get('text_october'),
			$this->language->get('text_november'),
			$this->language->get('text_december')
		);

		if (strpos($param, 'M') === false) {
			return date($param, $time);
		} else {
			$str_begin  = date(mb_substr($param, 0, mb_strpos($param, 'M')), $time);
			$str_middle = $MonthNames[date('n', $time) - 1];
			$str_end    = date(mb_substr($param, mb_strpos($param, 'M') + 1, mb_strlen($param)), $time);
			$str_date   = $str_begin . $str_middle . $str_end;
			return $str_date;
		}
	}

	public function browser() {
		$bra = 'ie';
		if (stristr($_SERVER['HTTP_USER_AGENT'], 'Firefox'))
			$bra = 'firefox';
		elseif (stristr($_SERVER['HTTP_USER_AGENT'], 'Chrome'))
			$bra = 'chrome';
		elseif (stristr($_SERVER['HTTP_USER_AGENT'], 'Safari'))
			$bra = 'safari';
		elseif (stristr($_SERVER['HTTP_USER_AGENT'], 'Opera'))
			$bra = 'opera';
		elseif (stristr($_SERVER['HTTP_USER_AGENT'], 'MSIE 6.0'))
			$bra = 'ieO';
		elseif (stristr($_SERVER['HTTP_USER_AGENT'], 'MSIE 7.0'))
			$bra = 'ieO';
		elseif (stristr($_SERVER['HTTP_USER_AGENT'], 'MSIE 8.0'))
			$bra = 'ieO';
		return $bra;
	}
	
	protected function addScriptSample() {
        $path = 'catalog/view/javascript/';
        $path_template = 'catalog/view/theme/' . $this->config->get('config_template') . '/';
        
		$files_script[] = $path . 'jquery/jquery.tmpl.min.js';
        $files_script[] = $path . 'jquery/jquery.deserialize.min.js';
        $files_script[] = $path . 'jquery/jquery.loadmask.min.js';
        $files_script[] = $path . 'jquery/jquery.total-storage.min.js';

        foreach ($files_script as $file_script) {
            $this->document->addScript($file_script);
        }

        $files_style[] = $path_template . 'stylesheet/filterpro.css';
        $files_style[] = $path_template . 'stylesheet/jquery.loadmask.css';

        foreach ($files_style as $file_style) {
            $this->document->addStyle($file_style);
        }
	}
	
	protected function getColumn($request_get, $position) {
        $this->load->model('design/layout');
        $this->load->model('catalog/category');
        $this->load->model('catalog/product');
        $this->load->model('catalog/information');
        $this->load->model('setting/extension');

        $route = 'common/home';
        $layout_id = 0;

        if (isset($request_get['route'])) {
            $route = (string)$request_get['route'];
        }

        if ($route == 'product/category' && isset($request_get['path'])) {
            $path = explode('_', (string)$request_get['path']);

            $layout_id = $this->model_catalog_category->getCategoryLayoutId(end($path));
        }

        if ($route == 'product/product' && isset($request_get['product_id'])) {
            $layout_id = $this->model_catalog_product->getProductLayoutId($request_get['product_id']);
        }

        if ($route == 'information/information' && isset($request_get['information_id'])) {
            $layout_id = $this->model_catalog_information->getInformationLayoutId($request_get['information_id']);
        }

        if (!$layout_id) {
            $layout_id = $this->model_design_layout->getLayout($route);
        }

        $module_data = array();
        $extensions = $this->model_setting_extension->getExtensions('module');

        foreach ($extensions as $extension) {
            $modules = $this->config->get($extension['code'] . '_module');

            if ($modules) {
                foreach ($modules as $module) {
                    if ($module['layout_id'] == $layout_id && $module['position'] == $position && isset($module['status']) && $module['status']) {
                        $module_data[] = array(
                            'code'       => $extension['code'],
                            'setting'    => $module,
                            'sort_order' => $module['sort_order']
                        );
                    }
                }
            }
        }

        $layout_id = $this->config->get('config_layout_id');

        foreach ($extensions as $extension) {
            $modules = $this->config->get($extension['code'] . '_module');

            if ($modules) {
                foreach ($modules as $module) {
                    if ($module['layout_id'] == $layout_id && $module['position'] == $position && isset($module['status']) && $module['status']) {
                        $module_data[] = array(
                            'code'       => $extension['code'],
                            'setting'    => $module,
                            'sort_order' => $module['sort_order']
                        );
                    }
                }
            }
        }

        $sort_order = array();

        foreach ($module_data as $key => $value) {
            $sort_order[$key] = $value['sort_order'];
        }

        array_multisort($sort_order, SORT_ASC, $module_data);
        $cache_modules = array();

        foreach ($module_data as $module) {
            $module = $this->getChild('module/' . $module['code'], $module['setting']);

            if ($module) {
                $cache_modules[] = $module;
            }
        }

		$this->data['modules'] = $cache_modules;
		$file = '/template/common/' . $position . '.tpl';
		$this->fileRenderModule($file);
	}

    public function getDataOfGetQuery($data_post) {
        $filterpro_setting = $this->config->get('filterpro_setting');

        $attr_slider = isset($data_post['attr_slider']) ? $data_post['attr_slider'] : false;
        $category_id = null;
        $filter_sub_category = null;
        $filter_description = null;
        $filter_name = '';
        $filter_tag = '';
        $filter = 0;
        $limit = $this->config->get('config_catalog_limit');
        $manufacturer_id = null;
        $max_price = 0;
        $min_price = 0;
        $order = 'DESC';
        $page = 1;
        $sort = 'p.date_added';
        $special = false;
        $discount = false;
        $filter_total = null;
        $filterpro_special = null;
        $data_post['user_price'] = 1;
        $data_post['filter_total'] = 1;

        if ((float)$filterpro_setting['tax'] > 0) {
            $this->number_tax = 1 + (float)$filterpro_setting['tax'] / 100;
        }

        if (isset($data_post['path'])) {
            $parts = explode('_', $data_post['path']);
            $category_id = array_pop($parts);
        }

        if (isset($data_post['manufacturer_id'])) {
            $manufacturer_id = $data_post['manufacturer_id'];
        }

        if (isset($data_post['route']) && $data_post['route'] == 'product/special') {
            $special = true;
        }

        if (isset($data_post['route']) && $data_post['route'] == 'product/discount') {
            $discount = true;
        }

        if (isset($data_post['filter_name'])) {
            $filter_name = $data_post['filter_name'];
        }

        if (isset($data_post['filter_category_id'])) {
            $category_id = $data_post['filter_category_id'];
        }

        if (isset($data_post['filter_tag'])) {
            $filter_tag = $data_post['filter_tag'];
        } elseif (isset($data_post['filter_name'])) {
            $filter_tag = $data_post['filter_name'];
        }

        if (isset($data_post['filter_sub_category'])) {
            $filter_sub_category = $data_post['filter_sub_category'];
        }

        if (isset($data_post['filter_description'])) {
            $filter_description = $data_post['filter_description'];
        }

        if (isset($data_post['page'])) {
            $page = (int)$data_post['page'];
        }

        if (isset($data_post['sort'])) {
            $sort = $data_post['sort'];
        }

        if (isset($data_post['order'])) {
            $order = $data_post['order'];
        }

        if (isset($data_post['filter'])) {
            $filter = $data_post['filter'];
            $result = $this->model_catalog_filter->getAliasFromFilter($filter);

            if ($result) {
                $filter = str_replace('filter=', '', $result['query']);
            }
        }

        if (isset($data_post['limit'])) {
            $limit = $data_post['limit'];
        }

        if (isset($data_post['filterpro_special'])) {
            $filterpro_special = $data_post['filterpro_special'];
        }

        if (isset($data_post['min_price'])) {
            $min_price = $data_post['min_price'];
        }

        if (isset($data_post['max_price'])) {
            $max_price = $data_post['max_price'];
        }

        $data = array(
            'attr_slider' 			=> $attr_slider,
            'filter_category_id' 	=> $category_id,
            'filter_sub_category'	=> $filter_sub_category,
            'filter_manufacturer_id'=> $manufacturer_id,
            'filter'				=> $filter,
            'filter_name'			=> $filter_name,
            'filter_tag'			=> $filter_tag,
            'filter_description'	=> $filter_description,
            'filter_special'		=> $filterpro_special,
            'innertable'			=> true,
            'limit' 				=> $limit,
            'min_price'				=> $min_price / $this->number_tax,
            'max_price' 			=> $max_price / $this->number_tax,
            'order' 				=> $order,
            'special'				=> $special,
            'discount'				=> $discount,
            'sort' 					=> $sort,
            'start' 				=> ($page - 1) * $limit,
            'page'                  => $page
        );

        return $data;
    }

	protected function parentSample($data_post) {
        $dataUrl['route'] = '';
        $dataUrl['path'] = '';

        if (isset($data_post['route'])) {
            $dataUrl['route'] = $data_post['route'];
        }

        if (isset($data_post['path_specify'])) {
            $dataUrl['path'] = $data_post['path_specify'];
        }

        $this->data['clear_filter_link'] = $this->url->link($dataUrl['route'], $dataUrl['path']);

        $url = '';

        if (isset($data_post['filter_name'])) {
            $url .= '&filter_name=' . $data_post['filter_name'];
        }

        if (isset($data_post['filter_tag'])) {
            $url .= '&filter_tag=' . $data_post['filter_tag'];
        }

        if (isset($data_post['filter_description'])) {
            $url .= '&filter_description=' . $data_post['filter_description'];
        }

        if (isset($data_post['filter_category_id'])) {
            $url .= '&filter_category_id=' . $data_post['filter_category_id'];
        }

        if (isset($data_post['filter_sub_category'])) {
            $url .= '&filter_sub_category=' . $data_post['filter_sub_category'];
        }

        if (isset($data_post['filter'])) {
            $url .= '&filter=' . $data_post['filter'];
        }

        if (isset($data_post['sort'])) {
            $url .= '&sort=' . $data_post['sort'];
        }

        if (isset($data_post['order'])) {
            $url .= '&order=' . $data_post['order'];
        }

        if (isset($data_post['limit'])) {
            $url .= '&limit=' . $data_post['limit'];
        }

        if (isset($data_post['min_price'])) {
            $url .= '&min_price=' . $data_post['min_price'];
        }

        if (isset($data_post['max_price'])) {
            $url .= '&max_price=' . $data_post['max_price'];
        }

        $this->data['special'] = $this->url->link($dataUrl['route'], $dataUrl['path'] . $url . '&filterpro_special=special');

        if (isset($data_post['filterpro_special'])) {
            $url .= '&filterpro_special=' . $data_post['filterpro_special'];
        }

        if (isset($data_post['page'])) {
            $url .= '&page=' . $data_post['page'];
        }

        $product_url = $url;

        if (isset($data_post['sort'])) {
            $sort = $data_post['sort'];
        } else {
            $sort = 'p.date_added';
        }

        if (isset($data_post['order'])) {
            $order = $data_post['order'];
        } else {
            $order = 'DESC';
        }

        if (isset($data_post['limit'])) {
            $limit = $data_post['limit'];
        } else {
            $limit = $this->config->get('config_catalog_limit');
        }

        $this->data['sort'] = $sort;
        $this->data['order'] = $order;
        $this->data['limit'] = $limit;

        $url = '';

        if (isset($data_post['filter_name'])) {
            $url .= '&filter_name=' . $data_post['filter_name'];
        }

        if (isset($data_post['filter_tag'])) {
            $url .= '&filter_tag=' . $data_post['filter_tag'];
        }

        if (isset($data_post['filter_description'])) {
            $url .= '&filter_description=' . $data_post['filter_description'];
        }

        if (isset($data_post['filter_category_id'])) {
            $url .= '&filter_category_id=' . $data_post['filter_category_id'];
        }

        if (isset($data_post['filter_sub_category'])) {
            $url .= '&filter_sub_category=' . $data_post['filter_sub_category'];
        }

        if (isset($data_post['filter'])) {
            $url .= '&filter=' . $data_post['filter'];
        }

        if (isset($data_post['limit'])) {
            $url .= '&limit=' . $data_post['limit'];
        }

        if (isset($data_post['filterpro_special'])) {
            $url .= '&filterpro_special=' . $data_post['filterpro_special'];
        }

        if (isset($data_post['min_price'])) {
            $url .= '&min_price=' . $data_post['min_price'];
        }

        if (isset($data_post['max_price'])) {
            $url .= '&max_price=' . $data_post['max_price'];
        }

        $dataUrl['url'] = $url;
        $this->buildSort($dataUrl);

        $url = '';

        if (isset($data_post['filter_name'])) {
            $url .= '&filter_name=' . $data_post['filter_name'];
        }

        if (isset($data_post['filter_tag'])) {
            $url .= '&filter_tag=' . $data_post['filter_tag'];
        }

        if (isset($data_post['filter_description'])) {
            $url .= '&filter_description=' . $data_post['filter_description'];
        }

        if (isset($data_post['filter_category_id'])) {
            $url .= '&filter_category_id=' . $data_post['filter_category_id'];
        }

        if (isset($data_post['filter_sub_category'])) {
            $url .= '&filter_sub_category=' . $data_post['filter_sub_category'];
        }

        if (isset($data_post['filter'])) {
            $url .= '&filter=' . $data_post['filter'];
        }

        if (isset($data_post['sort'])) {
            $url .= '&sort=' . $data_post['sort'];
        }

        if (isset($data_post['order'])) {
            $url .= '&order=' . $data_post['order'];
        }

        if (isset($data_post['filterpro_special'])) {
            $url .= '&filterpro_special=' . $data_post['filterpro_special'];
        }

        if (isset($data_post['min_price'])) {
            $url .= '&min_price=' . $data_post['min_price'];
        }

        if (isset($data_post['max_price'])) {
            $url .= '&max_price=' . $data_post['max_price'];
        }

        $dataUrl['url'] = $url;
        $this->buildLimit($dataUrl);

        $url = '';

        if (isset($data_post['filter_name'])) {
            $url .= '&filter_name=' . $data_post['filter_name'];
        }

        if (isset($data_post['filter_tag'])) {
            $url .= '&filter_tag=' . $data_post['filter_tag'];
        }

        if (isset($data_post['filter_description'])) {
            $url .= '&filter_description=' . $data_post['filter_description'];
        }

        if (isset($data_post['filter_category_id'])) {
            $url .= '&filter_category_id=' . $data_post['filter_category_id'];
        }

        if (isset($data_post['filter_sub_category'])) {
            $url .= '&filter_sub_category=' . $data_post['filter_sub_category'];
        }

        if (isset($data_post['sort'])) {
            $url .= '&sort=' . $data_post['sort'];
        }

        if (isset($data_post['order'])) {
            $url .= '&order=' . $data_post['order'];
        }

        if (isset($data_post['filterpro_special'])) {
            $url .= '&filterpro_special=' . $data_post['filterpro_special'];
        }

        if (isset($data_post['limit'])) {
            $url .= '&limit=' . $data_post['limit'];
        }

        if (isset($data_post['filter'])) {
            $url .= '&filter=' . $data_post['filter'];
        }

        $url =  $dataUrl['path'] . $url;
        $this->data['url_minus_price'] = $this->url->link($dataUrl['route'], $url);

        $this->getFilterPro();

        $cache = md5(http_build_query($data_post));
		$key_cache = 'filterpro.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $cache;
        $common_data = $this->cache->get($key_cache);
		
		if ($common_data === false) {
			$this->load->model('design/layout');
			$this->load->model('catalog/category');
			$this->load->model('catalog/product');
			$this->load->model('catalog/information');
            $this->load->model('catalog/filter');
            $records_total = array();

			$this->language->load('module/filterpro');

            $data = $this->getDataOfGetQuery($data_post);
            $min_price = $data['min_price'];
            $max_price = $data['max_price'];

            $priceLimits = $this->model_catalog_product->getPriceLimits($data);
            $bd_min_price = $priceLimits['min_price'];
            $bd_max_price = $priceLimits['max_price'];

            $data['min_price'] = $bd_min_price;
            $data['max_price'] = $bd_max_price;
            $data['bd_min_price'] = $bd_min_price;
            $data['bd_max_price'] = $bd_max_price;
            $data['product_url'] = $product_url;

            if ($min_price > 0) {
                $data['min_price'] = $min_price;
            }

            if ($max_price > 0) {
                $data['max_price'] = $max_price;
            }

            $products = $this->getDataProducts($data);
            $product_total = $this->model_catalog_product->getTotalProducts($data, $data['filter']);

            $min_price = (int)$data['min_price'];
			$max_price = (int)$data['max_price'];

            $url = '';

            if (isset($data_post['filter_name'])) {
                $url .= '&filter_name=' . $data_post['filter_name'];
            }

            if (isset($data_post['filter_tag'])) {
                $url .= '&filter_tag=' . $data_post['filter_tag'];
            }

            if (isset($data_post['filter_description'])) {
                $url .= '&filter_description=' . $data_post['filter_description'];
            }

            if (isset($data_post['filter_category_id'])) {
                $url .= '&filter_category_id=' . $data_post['filter_category_id'];
            }

            if (isset($data_post['filter_sub_category'])) {
                $url .= '&filter_sub_category=' . $data_post['filter_sub_category'];
            }

            if (isset($data_post['filter'])) {
                $url .= '&filter=' . $data_post['filter'];
            }

            if (isset($data_post['sort'])) {
                $url .= '&sort=' . $data_post['sort'];
            }

            if (isset($data_post['order'])) {
                $url .= '&order=' . $data_post['order'];
            }

            if (isset($data_post['limit'])) {
                $url .= '&limit=' . $data_post['limit'];
            }

            if (isset($data_post['filterpro_special'])) {
                $url .= '&filterpro_special=' . $data_post['filterpro_special'];
            }

            if (isset($data_post['min_price'])) {
                $url .= '&min_price=' . $data_post['min_price'];
            }

            if (isset($data_post['max_price'])) {
                $url .= '&max_price=' . $data_post['max_price'];
            }

			$pagination = new Pagination();
			$pagination->total = $product_total;
			$pagination->page = $data['page'];
			$pagination->limit = $limit;
			$pagination->text = $this->language->get('text_pagination');
			$pagination->url = $this->url->link($dataUrl['route'], $dataUrl['path'] . $url . '&page={page}');

            $common_data['products'] = $products;
            $common_data['product_total'] = $product_total;
            $common_data['min_price'] = $min_price;
            $common_data['bd_min_price'] = $data['bd_min_price'];
            $common_data['max_price'] = $max_price;
            $common_data['bd_max_price'] = $data['bd_max_price'];
            $common_data['pagination'] = $pagination->render();
            $common_data['records'] = $records_total;

			$this->cache->set($key_cache, $common_data);
		}

        $this->data['products'] = $common_data['products'];
        $this->data['product_total'] = $common_data['product_total'];
        $this->data['min_price'] = $common_data['min_price'];
        $this->data['bd_min_price'] = $common_data['bd_min_price'];
        $this->data['max_price'] = $common_data['max_price'];
        $this->data['bd_max_price'] = $common_data['bd_max_price'];
        $this->data['pagination'] = $common_data['pagination'];
        $this->data['records'] = $common_data['records'];
    }

	protected function getDataProducts($data) {
		$this->load->model('catalog/product');
		$this->load->model('catalog/GALKAGraboCount');
		$this->load->model('tool/image');
		$this->load->model('catalog/category');
		$filter = 0;

		if (isset($data['filter'])) {
			$filter = $data['filter'];
		}

		$results = $this->model_catalog_product->getProducts($data, $filter);
		$products = array();
		
		foreach ($results as $key => $result) {
			if ($result) {
                $category_id = false;
                $category_path = false;
                $image = false;
                $new_prod = false;
                $price = false;
                $price_after = '';
                $price_prefix = '';
                $special_price = false;
                $rating = false;
                $sale = null;
                $special = false;
                $discount = false;
                $special_date_end = false;
                $label_special = false;
                $label_special_for_you = false;
                $label_discount = false;
                $tax = false;
                $year = false;
                $month = false;
                $day = false;
                $height_div = 0;
                $weight = false;
                $length = false;
                $width = false;
                $height = false;
                $manufacturer = '';
                $route = false;

                if ($result['image']) {
                    $width = $this->config->get('config_image_product_width');
                    $height = $this->config->get('config_image_product_height');

                    if (isset($data['setting'])) {
                        $width = $data['setting']['image_width'];
                        $height = $data['setting']['image_height'];
                    }

                    $image = $this->model_tool_image->resize($result['image'], $width, $height);
                }

                if ($result['product_id']) {
                    $category_id = $this->model_catalog_category->getCategroyByProduct($result['product_id']);
                }

                if ($result['manufacturer'] != null) {
                    $manufacturer = $result['manufacturer'];
                }

                if ($category_id) {
                    $category_path = $this->model_catalog_category->treeCategory($category_id);
                }

                if ($category_path) {
                    $category_path = array_reverse($category_path);
                    $category_path = implode('_', $category_path);
                    $category_path = '&path=' . $category_path;
                } else {
                    $category_path = '';
                }

                if ($this->config->get('config_tax')) {
                    $tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price'], $result['code'], 1);
                }

                if ($this->config->get('config_review_status')) {
                    $rating = (int)$result['rating'];
                }

                $specials_date = $this->model_catalog_GALKAGraboCount->getProductDiscountDates($result['product_id']);
                $discount_date = $this->model_catalog_GALKAGraboCount->getProductSpecialDates($result['product_id']);
                $specials_purchased = $this->model_catalog_GALKAGraboCount->getVouchersBought($result['product_id']);

                $this->data['quantity_start'] = $result['quantity'];
                $this->data['quantity_left'] = $result['quantity'] - $specials_purchased['quantity_purchased'];

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

                if ($result['price_prefix_name'] != NULL) {
                    $price_prefix = $result['price_prefix_name'];
                }

                if ($result['price_after_name'] != NULL) {
                    $price_after = $result['price_after_name'];
                }

                $startDate1 = strtotime(mb_substr($result['date_added'], 0, 10));
                $endDate2 = strtotime(date("Y-m-d"));
                $days = ceil(($endDate2 / 86400)) - ceil(($startDate1 / 86400));

                if ($this->config->get('GALKAControl_status') == 1) {
                    $numeroNew = $this->config->get('GALKAControl_new_label');
                }

                if ($days < $numeroNew) {
                    $new_prod = true;
                }

                if ((float)$result['price']) {
                    $price = $this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax'));
                }

                if ((float)$result['special']) {
                    $special = $this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax'));
                    $special_price = $special;
                } else if ((float)$result['discount']) {
                    $special_price = $this->tax->calculate($result['discount'], $result['tax_class_id'], $this->config->get('config_tax'));
                }

                if ($special_price && $price) {
                    $special = $this->currency->format($special_price, $result['code'], 1);
                    $sale = round(100 - (($special_price / $price) * 100), 1);
                }

                if ($price) {
                    $price = $this->currency->format($price, $result['code'], 1);
                }

				if (isset($this->data['height']) && isset($data['setting']['position']) && ($data['setting']['position'] == 'column_left' || $data['setting']['position'] == 'column_right')) {
					$height_div = $this->data['height'];

					if ($special !== false && $new_prod !== false) {
						$height_div += 25;
					} elseif ($new_prod !== false && $special == false) {
						$height_div += 10;
					} elseif ($new_prod == false && $special !== false) {
						$height_div += 30;
					}
				} else {
					$height_div = 335;

					if ($result['price_status'] != 0 && $price != false) {
						$height_div += 155;
					}
				}

				if (isset($data['setting']['weight']) && $data['setting']['weight'] == true) {
					$weight = $this->weight->format($result['weight'], $result['weight_class_id']);
				}

				if (isset($data['setting']['length']) && $data['setting']['length'] == true) {
					$length = $this->length->format($result['length'], $result['length_class_id']);
				}

				if (isset($data['setting']['width']) && $data['setting']['width'] == true) {
					$width = $this->length->format($result['width'], $result['length_class_id']);
				}

				if (isset($data['setting']['weight']) && $data['setting']['height'] == true) {
					$height = $this->length->format($result['height'], $result['length_class_id']);
				}

				$description = html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8');

				if (empty($description) == false) {
					$description = strip_tags($description);
					$description = mb_substr($description, 0, 500, 'UTF-8');
				}

				if (isset($data['setting']['route'])) {
					$route = $data['setting']['route'];
				}

                if (!isset($data['product_url'])) {
                    $data['product_url'] = '';
                }

                $products[] = array(
					'availability'		=> $result['stock_status'],
					'day'				=> $day,
					'special_date_end'  => $special_date_end,
                    'label_special'     => $label_special,
                    'label_discount'    => $label_discount,
                    'label_special_for_you' => $label_special_for_you,
					'description' 		=> $description,
					'href'				=> $this->url->link('product/product', $category_path . $data['product_url'] . '&product_id=' . $result['product_id']),
					'height_div'		=> $height_div,
                    'model'       		=> $result['product_id'],
                    'month'				=> $month,
                    'manufacturer'		=> $manufacturer,
                    'name'        		=> $result['name'],
                    'new_prod'			=> $new_prod,
					'product_id'  		=> $result['product_id'],
					'price'       		=> $price,
					'price_after'		=> $price_after,
					'price_prefix'		=> $price_prefix,
	                'price_status'		=> $result['price_status'],
					'quantity' 			=> $result['quantity'],
					'quantity_start' 	=> $specials_purchased['quantity_purchased'],
					'rating'      		=> $result['rating'],
					'reviews'     		=> sprintf($this->language->get('text_reviews'), (int)$result['reviews']),
                    'sale'				=> $sale,
					'special'     		=> $special,
					'startdate'    	 	=> $result['date_added'],
					'tax'         		=> $tax,
					'thumb'       		=> $image,
					'year'				=> $year,
					'weight'       		=> $weight,
					'length'       		=> $length,
					'width'        		=> $width,
					'height'       		=> $height,
					'remove'       		=> $this->url->link($route, 'remove=' . $result['product_id']),
				);
            } elseif (isset($data['setting']['class'])) {
				unset($this->session->data[$data['setting']['class']][$key]);
			}
		}

        $products = $this->getFilter($products);

        return $products;
	}

	protected function getFilter($products) {
		foreach ($products as $key => $product) {
            $options = $this->model_catalog_product->getProductOptionsFilter($product['product_id']);

			foreach ($options as $option) {
				$values = $this->model_catalog_product->getProductValuesFilter($product['product_id'], $option['option_id']);

				if (count($values) > 0) {
					$products[$key]['filters'][$option['option_id']] = array(
						'option_id' => $option['option_id'],
						'option_name' => $option['name'],
						'values' => $values
					);
				}
			}
		}

		return $products;
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

    public function getFilterURLParams($filter = 0, $option_id, $value_id, $variable = '') {
        // При изменении этих параметров, нужно будет поменять соответсвенно их в других файлах. Менять их не советую.

        $sep_par = ';'; // разделитель пар опций -> значений: opt1=val1,val2,val3;opt2=val1,val2,val3 ...
        $sep_opt = '='; // разделитель внутри пары опция -> значения: opt1=val1,val2,val3 ...
        $sep_val = ','; // разделитель для параметров опции: val1,val2,val3 ...

        if ($filter) {
            $matches = explode($sep_par, $filter);

            $options = array();
            $values = array();
            $parts = array();

            foreach ($matches as $option) {
                $data = explode($sep_opt, $option);
                $parts[] = $option;
                $options[] = $data[0];

                if (isset($data[1])) {
                    $values[] = explode($sep_val, $data[1]);
                }
            }

            if (in_array($option_id, $options)) { // если эта опция уже есть в запросе, то мы не добавляем её

                $key = array_keys($options, $option_id); // вычисляем ключ массива для дальнейшей работы с именно этой опцией

                if (in_array($value_id, $values[$key[0]])) { // если это значение уже есть в запросе
                    if (count($values[$key[0]]) == 1) { // и если оно единственное
                        if (count($matches) == 1) { // еще и с единственной опцией, то удаляем из запроса весь фильтр
                            $out = '';
                        } else { // если опция не одна, удаляем только эту опцию с её параметром
                            $out = '&' . $variable . '=' . str_replace((array_search($parts[$key[0]], $parts) ? $sep_par . $parts[$key[0]] : $parts[$key[0]] . $sep_par), '', $filter);
                        }
                    } else { // если значений несколько, удаляем это значение, оставляя другие с опцией
                        $out = '&' . $variable . '=' . str_replace($parts[$key[0]], $options[$key[0]] . $sep_opt . str_replace((array_search($value_id, $values[$key[0]]) ? $sep_val . $value_id : $value_id . $sep_val), '', implode($sep_val, $values[$key[0]])), $filter);
                    }
                } else { // если значения нет в запросе, то добавляем его к значениям этой опции
                    $out = '&' . $variable . '=' . str_replace($parts[$key[0]], $options[$key[0]] . $sep_opt . implode($sep_val, $values[$key[0]]) . (count($values[$key[0]]) ? $sep_val : '') . $value_id, $filter);
                }
            } else { // если этой опции нет в запросе
                $out = '&' . $variable . '=' . $filter . $sep_par . $option_id . $sep_opt . $value_id;
            }
        } else { // если в запросе вообще нет переменной filter
            $out = '&' . $variable . '=' . $option_id . $sep_opt . $value_id;
        }

        return $out; // фух.
    }

    public function reset_cache() {
        if (CACHE_DRIVER == 'memcached') {
            $mc = new Memcache;

            if ($mc->pconnect(MEMCACHE_HOSTNAME, MEMCACHE_PORT)) {
                $mc->flush();
                $this->memcache = $mc;
                $this->ismemcache = true;
            }
        }
    }

    protected function getTotalHtml($total_data = array()) {
        if(count($total_data) == 0) {
            $total = 0;
            $taxes = $this->cart->getTaxes();
            $sort_order = array();

            $this->load->model('setting/extension');
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
        }

        $total_template = new Template();
        $total_template->data['totals'] = $total_data;
        $template_path = $this->config->get('config_template') . '/template/checkout/total_data.tpl';

        if (file_exists(DIR_TEMPLATE . '/template/checkout/total_data.tpl')) {
            $template_path = '/template/checkout/total_data.tpl';
        }

        return $total_template->fetch($template_path);
    }
}
?>