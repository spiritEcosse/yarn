<?php
class ControllerRecordRecord extends Controller {
	private $error = array();

	public function index() {
		$this->load->model('tool/image');
		$this->load->model('catalog/record');
		$this->load->model('catalog/blog');
		$this->load->model('catalog/comment');
		$this->language->load('record/record');

		$this->totals($this->request->post);
		$this->data['imagebox'] = 'colorbox';

		if (isset($this->request->get['record_id'])) {
			$record_id = $this->request->get['record_id'];
			$blog_info = $this->model_catalog_blog->getPathByrecord($record_id);
			$this->request->get['blog_id'] = $blog_info['path'];
		}

		if (isset($this->request->get['blog_id'])) {
			$path = '';

			foreach (explode('_', $this->request->get['blog_id']) as $path_id) {
				if (!$path) {
					$path = $path_id;
				} else {
					$path .= '_' . $path_id;
				}

				$path_id."->".$this->request->get['blog_id'];
				$blog_info = $this->model_catalog_blog->getBlog($path_id);

				if ($blog_info) {
					$this->data['breadcrumbs'][] = array(
						'text' => $blog_info['name'],
						'href' => $this->url->link('record/blog', 'blog_id=' . $path),
						'separator' => $this->language->get('text_separator')
					);
				}
			}
		} else {
			$path = '';
		}

		$this->data['href'] = $this->url->link('record/record', 'record_id=' . $this->request->get['record_id']);
		$this->data['blog_design'] = Array();

		if (isset($blog_info['design']) && $blog_info['design'] != '') {
			$this->data['blog_design'] = unserialize($blog_info['design']);
		}

		$record_id = 0;

		if (isset($this->request->get['record_id'])) {
			$record_id = $this->request->get['record_id'];
		}

		$record_info = $this->model_catalog_record->getRecord($record_id);

		$url = '';

		if (isset($this->request->get['manufacturer_id'])) {
			$url .= '&manufacturer_id=' . $this->request->get['manufacturer_id'];
		}

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}

		if (isset($this->request->get['filter_tag'])) {
			$url .= '&filter_tag=' . $this->request->get['filter_tag'];
		}

		if (isset($this->request->get['filter_description'])) {
			$url .= '&filter_description=' . $this->request->get['filter_description'];
		}

		if (isset($this->request->get['filter_blog_id'])) {
			$url .= '&filter_blog_id=' . $this->request->get['filter_blog_id'];
		}

		if ($record_info) {
			if (isset($this->request->get['blog_id'])) {
				$url .= '&blog_id=' . $this->request->get['blog_id'];
			}

			$this->data['breadcrumbs'][] = array(
				'text' => $record_info['name'],
				'href' => $this->url->link('record/record', '&record_id=' . $this->request->get['record_id']),
				'separator' => $this->language->get('text_separator')
			);

			$this->document->setTitle($record_info['name']);
			$this->document->setDescription($record_info['meta_description']);
			$this->document->setKeywords($record_info['meta_keyword']);
			$this->document->addLink($this->url->link('record/record', 'record_id=' . $this->request->get['record_id']), 'canonical');
			$this->data['heading_title'] = $record_info['name'];

			$this->data['text_welcome']         = sprintf($this->language->get('text_welcome'), $this->url->link('account/login', '', 'SSL'), $this->url->link('account/register', '', 'SSL'));
			$this->data['text_select']          = $this->language->get('text_select');
			$this->data['text_manufacturer']    = $this->language->get('text_manufacturer');
			$this->data['text_model']           = $this->language->get('text_model');
			$this->data['text_reward']          = $this->language->get('text_reward');
			$this->data['text_points']          = $this->language->get('text_points');
			$this->data['text_discount']        = $this->language->get('text_discount');
			$this->data['text_stock']           = $this->language->get('text_stock');
			$this->data['text_price']           = $this->language->get('text_price');
			$this->data['text_tax']             = $this->language->get('text_tax');
			$this->data['text_discount']        = $this->language->get('text_discount');
			$this->data['text_option']          = $this->language->get('text_option');
			$this->data['text_qty']             = $this->language->get('text_qty');
			$this->data['text_minimum']         = sprintf($this->language->get('text_minimum'), $record_info['minimum']);
			$this->data['text_or']              = $this->language->get('text_or');
			$this->data['text_write']           = $this->language->get('text_write');
			$this->data['text_note']            = $this->language->get('text_note');
			$this->data['text_share']           = $this->language->get('text_share');
			$this->data['text_wait']            = $this->language->get('text_wait');
			$this->data['text_tags']            = $this->language->get('text_tags');
			$this->data['text_viewed']          = $this->language->get('text_viewed');
			$this->data['entry_name']           = $this->language->get('entry_name');
			$this->data['entry_comment']        = $this->language->get('entry_comment');
			$this->data['entry_rating']         = $this->language->get('entry_rating');
			$this->data['entry_good']           = $this->language->get('entry_good');
			$this->data['entry_bad']            = $this->language->get('entry_bad');
			$this->data['entry_captcha']        = $this->language->get('entry_captcha');
			$this->data['entry_captcha_title']  = $this->language->get('entry_captcha_title');
			$this->data['entry_captcha_update'] = $this->language->get('entry_captcha_update');
			$this->data['button_cart']          = $this->language->get('button_cart');
			$this->data['button_wishlist']      = $this->language->get('button_wishlist');
			$this->data['button_compare']       = $this->language->get('button_compare');
			$this->data['button_upload']        = $this->language->get('button_upload');
			$this->data['button_write']         = $this->language->get('button_write');
			$this->data['tab_description']     = $this->language->get('tab_description');
			$this->data['tab_attribute']       = $this->language->get('tab_attribute');
			$this->data['tab_advertising']     = $this->language->get('tab_advertising');
			$this->data['comment_count']       = $this->model_catalog_comment->getTotalCommentsByRecordId($this->request->get['record_id']);
			$this->data['tab_comment']         = $this->language->get('tab_comment');
			$this->data['tab_images']          = $this->language->get('tab_images');
			$this->data['tab_related']         = $this->language->get('tab_related');
			$this->data['tab_product_related'] = $this->language->get('tab_product_related');
			$this->data['record_id']           = $this->request->get['record_id'];
			$this->data['manufacturer']        = $record_info['manufacturer'];
			$this->data['manufacturers']       = $this->url->link('record/manufacturer/record', 'manufacturer_id=' . $record_info['manufacturer_id']);
			$this->data['model']               = $record_info['model'];
			$this->data['reward']              = $record_info['reward'];
			$this->data['points']              = $record_info['points'];
			$this->getText();

			if ($record_info['quantity'] <= 0) {
				$this->data['stock'] = $record_info['stock_status'];
			} elseif ($this->config->get('config_stock_display')) {
				$this->data['stock'] = $record_info['quantity'];
			} else {
				$this->data['stock'] = $this->language->get('text_instock');
			}

			$settings = $this->model_setting_setting->getSetting('blog');

			if ($record_info['image']) {
				$this->data['popup'] = $this->model_tool_image->resize($record_info['image'], $this->config->get('config_image_popup_width'), $this->config->get('config_image_popup_height'));
				$this->data['thumb'] = $this->model_tool_image->resize($record_info['image'], $settings['blog_big']['width'], $settings['blog_big']['height']);
			} else {
				$this->data['popup'] = false;
				$this->data['thumb'] = false;
			}

			$this->data['images'] = array();
			$results = $this->model_catalog_record->getRecordImages($this->request->get['record_id']);

			foreach ($results as $result) {
				$this->data['images'][] = array(
					'popup' => $this->model_tool_image->resize($result['image'], $this->config->get('config_image_popup_width'), $this->config->get('config_image_popup_height')),
					'thumb' => $this->model_tool_image->resize($result['image'], $this->config->get('config_image_related_width'), $this->config->get('config_image_related_height')),
				);
			}

			if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
				$this->data['price'] = $this->currency->format($this->tax->calculate($record_info['price'], $record_info['tax_class_id'], $this->config->get('config_tax')), $record_info['code'], 1);
			} else {
				$this->data['price'] = false;
			}

			if ((float) $record_info['special']) {
				$this->data['special'] = $this->currency->format($this->tax->calculate($record_info['special'], $record_info['tax_class_id'], $this->config->get('config_tax')), $record_info['code'], 1);
			} else {
				$this->data['special'] = false;
			}

			if ($this->config->get('config_tax')) {
				$this->data['tax'] = $this->currency->format((float) $record_info['special'] ? $record_info['special'] : $record_info['price'], $record_info['code'], 1);
			} else {
				$this->data['tax'] = false;
			}

			$this->data['options'] = array();

			foreach ($this->model_catalog_record->getRecordOptions($this->request->get['record_id']) as $option) {
				if ($option['type'] == 'select' || $option['type'] == 'radio' || $option['type'] == 'checkbox' || $option['type'] == 'image') {
					$option_value_data = array();
					foreach ($option['option_value'] as $option_value) {
						if (!$option_value['subtract'] || ($option_value['quantity'] > 0)) {
							$option_value_data[] = array(
								'record_option_value_id' => $option_value['record_option_value_id'],
								'option_value_id' => $option_value['option_value_id'],
								'name' => $option_value['name'],
								'image' => $this->model_tool_image->resize($option_value['image'], 50, 50),
								'price' => (float) $option_value['price'] ? $this->currency->format($this->tax->calculate($option_value['price'], $record_info['tax_class_id'], $this->config->get('config_tax'))) : false,
								'price_prefix' => $option_value['price_prefix']
							);
						}
					}

					$this->data['options'][] = array(
						'record_option_id' => $option['record_option_id'],
						'option_id' => $option['option_id'],
						'name' => $option['name'],
						'type' => $option['type'],
						'option_value' => $option_value_data,
						'required' => $option['required']
					);
				} elseif ($option['type'] == 'text' || $option['type'] == 'textarea' || $option['type'] == 'file' || $option['type'] == 'date' || $option['type'] == 'datetime' || $option['type'] == 'time') {
					$this->data['options'][] = array(
						'record_option_id' => $option['record_option_id'],
						'option_id' => $option['option_id'],
						'name' => $option['name'],
						'type' => $option['type'],
						'option_value' => $option['option_value'],
						'required' => $option['required']
					);
				}
			}

			if ($record_info['minimum']) {
				$this->data['minimum'] = $record_info['minimum'];
			} else {
				$this->data['minimum'] = MINIMUM;
			}

			// $this->data['text_comments']  = sprintf($this->language->get('text_comments'), (int) $record_info['comments']);
			$this->data['comments']       = (int)$record_info['comments'];
			$record_comment               = unserialize($record_info['comment']);
			$this->data['record_comment'] = $record_comment;
			$this->data['comment_status'] = $record_comment['status'];

			if ($this->customer->isLogged()) {
				$this->data['text_login']     = $this->customer->getFirstName() . " " . $this->customer->getLastName();
				$this->data['captcha_status'] = false;
				$this->data['customer_id']    = $this->customer->getId();
			} else {
				$this->data['text_login']     = $this->language->get('text_anonymus');
				$this->data['captcha_status'] = true;
			}

			$this->data['viewed'] = $record_info['viewed'];

			if (!isset($record_info['date_available'])) {
				$record_info['date_available'] = $record_info['date_added'];
			}

			if ($this->rdate($this->language->get('text_date')) == $this->rdate($this->language->get('text_date'), strtotime($record_info['date_available']))) {
				$date_str = $this->language->get('text_today');
			} else {
				$date_str = $this->language->get('text_date');
			}

			$date_added                     = $this->rdate($date_str . $this->language->get('text_hours'), strtotime($record_info['date_available']));
			$this->data['date_added']       = $date_added;
			$this->data['date_added_dict']	= date("c", strtotime($record_info['date_available']));
			$this->data['rating']           = (int)$record_info['rating'];
			$this->data['description']      = html_entity_decode($record_info['description'], ENT_QUOTES, 'UTF-8');
			$this->data['attribute_groups'] = $this->model_catalog_record->getRecordAttributes($this->request->get['record_id']);
			$product_data = $this->model_catalog_record->getProductRelated($this->request->get['record_id']);
			$products = array();

			foreach ($product_data as $product) {
				$products[] = $product['product_id'];
			}

			$this->data['products'] = $this->getDataProducts(array('products' => $products));
			$this->data['records'] = array();
			$results = $this->model_catalog_record->getRecordRelated($this->request->get['record_id']);

			foreach ($results as $result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_related_width'), $this->config->get('config_image_related_height'));
				} else {
					$image = false;
				}

				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$price = false;
				}

				if ((float) $result['special']) {
					$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$special = false;
				}

				if ($result['comment']) {
					$rating = (int) $result['rating'];
				} else {
					$rating = false;
				}

				$record_comment_info     = unserialize($result['comment']);
				$this->data['records'][] = array(
					'record_id' => $result['record_id'],
					'thumb' => $image,
					'name' => $result['name'],
					'viewed' => $result['viewed'],
					'rating' => $rating,
					'comment_status' => $record_comment_info['status'],
					'comments' => sprintf($this->language->get('text_comments'), (int) $result['comments']),
					'href' => $this->url->link('record/record', 'record_id=' . $result['record_id'])
				);
			}

			$this->data['tags'] = array();
			$results = $this->model_catalog_record->getRecordTags($this->request->get['record_id']);
			
			foreach ($results as $result) {
				$this->data['tags'][] = array(
					'tag' => trim($result['tag']),
					'href' => HTTP_SERVER . 'index.php?route=product/search#filterpro_filter_name=' . $result['tag']
				);
			}
			
			$this->data['theme'] = $this->config->get('config_template');

			$this->model_catalog_record->updateViewed($this->request->get['record_id']);

			if (isset($this->data['blog_design']['blog_template_record']) && $this->data['blog_design']['blog_template_record'] != '') {
				$template = $this->data['blog_design']['blog_template_record'];
			} else {
				$template = 'record.tpl';
			}

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/record/' . $template)) {
				$this->template = $this->config->get('config_template') . '/template/record/' . $template;
			} else {
				if (file_exists(DIR_TEMPLATE . 'default/template/record/' . $template)) {
					$this->template = 'default/template/record/' . $template;
				} else {
					$this->template = 'default/template/record/record.tpl';
				}
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
		} else {
			$this->data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_error'),
				'href' => $this->url->link('record/record', $url . '&record_id=' . $record_id),
				'separator' => $this->language->get('text_separator')
			);

			$this->document->setTitle($this->language->get('text_error'));
			$this->data['heading_title'] = $this->language->get('text_error');
			$this->data['text_error']    = $this->language->get('text_error');
			$this->data['button_write']  = $this->language->get('button_write');
			$this->data['continue']      = $this->url->link('common/home');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/error/not_found.tpl';
			} else {
				$this->template = 'default/template/error/not_found.tpl';
			}

			$this->children = array(
				'common/column_left',
				'common/column_right',
				'common/content_top',
				'common/content_bottom',
				'common/footer',
				'common/header'
			);

			return ($this->render());
		}
	}

	public function comment() {
		$this->language->load('record/record');
		$this->load->model('catalog/comment');
		$this->data['entry_sorting']      = $this->language->get('entry_sorting');
		$this->data['text_sorting_desc']  = $this->language->get('text_sorting_desc');
		$this->data['text_sorting_asc']   = $this->language->get('text_sorting_asc');
		$this->data['text_rollup']        = $this->language->get('text_rollup');
		$this->data['text_rollup_down']   = $this->language->get('text_rollup_down');
		$this->data['text_no_comments']   = $this->language->get('text_no_comments');
		$this->data['text_reply_button']  = $this->language->get('text_reply_button');
		$this->data['text_edit_button']   = $this->language->get('text_edit_button');
		$this->data['text_delete_button'] = $this->language->get('text_delete_button');
		$this->load->model('catalog/record');
		$record_info = $this->model_catalog_record->getRecord($this->request->get['record_id']);

		$this->load->model('catalog/blog');
		$b_path    = $this->model_catalog_blog->getPathByrecord($this->request->get['record_id']);
		$blog_path = $b_path['path'];
		if (isset($blog_path)) {
			if (strpos($blog_path, '_') !== false) {
				$abid    = explode('_', $blog_path);
				$blog_id = $abid[count($abid) - 1];
			} else {
				$blog_id = (int) $blog_path;
			}
			$blog_id = (int) $blog_id;
		}
		$blog_info = $this->model_catalog_blog->getBlog($blog_id);
		if (isset($blog_info['design']) && $blog_info['design'] != '') {
			$this->data['blog_design'] = unserialize($blog_info['design']);
		} else {
			$this->data['blog_design'] = Array();
		}
		$record_comment               = unserialize($record_info['comment']);

		$this->data['record_comment'] = $record_comment;
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		$this->data['page'] = $page;
		if (isset($this->request->get['sorting'])) {
			if ($this->request->get['sorting'] == 'none') {
				$this->data['sorting'] = 'desc';
			} else
				$this->data['sorting'] = $this->request->get['sorting'];
		} else {
			$this->data['sorting'] = 'desc';
		}
		$this->data['comments']          = array();
		$comment_total                   = $this->model_catalog_comment->getTotalCommentsByRecordId($this->request->get['record_id']);
		$this->data['blog_num_comments'] = $this->config->get('blog_num_comments');
		if ($this->data['blog_num_comments'] == '')
			$this->data['blog_num_comments'] = 10;
		$results = $this->model_catalog_comment->getCommentsByRecordId($this->request->get['record_id'], ($page - 1) * $this->data['blog_num_comments'], $this->data['blog_num_comments']);
		if ($this->customer->isLogged()) {
			$customer_id = $this->customer->getId();
		} else {
			$customer_id = -1;
		}
		$results_rates = $this->model_catalog_comment->getRatesByRecordId($this->request->get['record_id'], $customer_id);
		if ($customer_id == -1)
			$customer_id = false;
		if (count($results) > 0) {
			function sdesc($a, $b)
			{
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
				$mmm                 = NULL;
				$kkk                 = '';
				$wh                  = strlen($res1['sorthex']) / 4;
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
			{
				if (!isset($result['date_available'])) $result['date_available']=$result['date_added'];
					if ($this->rdate($this->language->get('text_date')) == $this->rdate($this->language->get('text_date'), strtotime($result['date_available']))) {
						$date_str = $this->language->get('text_today');
					} else {
						$date_str = $this->language->get('text_date');
					}
					$date_added               = $this->rdate($date_str . $this->language->get('text_hours'), strtotime($result['date_added']));
					$this->data['comments'][] = array(
						'comment_id' => $result['comment_id'],
						'sorthex' => $result['sorthex'],
						'customer_id' => $result['customer_id'],
						'customer' => $customer_id,
						'customer_delta' => $result['customer_delta'],
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
				}
				$i++;
			}
		}
		if (!function_exists('compare')) {
			function compare($a, $b)
			{
				if ($a['comment_id'] > $b['comment_id'])
					return 1;
				if ($b['comment_id'] > $a['comment_id'])
					return -1;
				return 0;
			}
		}
		if (!function_exists('compared')) {
			function compared($a, $b)
			{
				if ($a['comment_id'] > $b['comment_id'])
					return -1;
				if ($b['comment_id'] > $a['comment_id'])
					return 1;
				return 0;
			}
		}
		if (!function_exists('my_sort_div')) {
			function my_sort_div($data, $parent = 0, $sorting, $lev = -1)
			{
				$arr = $data[$parent];
				if ($sorting == 'asc')
					usort($arr, 'compare');
				if ($sorting == 'desc')
					usort($arr, 'compared');
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
					if (isset($z[count($z) - 1]['flag_end']))
						$z[count($z) - 1]['flag_end']++;
					else
						$z[count($z) - 1]['flag_end'] = 1;
				}
				return $z;
			}
		}
		if (count($this->data['comments']) > 0) {
			for ($i = 0, $c = count($this->data['comments']); $i < $c; $i++) {
				$new_arr[$this->data['comments'][$i]['parent_id']][] = $this->data['comments'][$i];
			}
			$mycomments = my_sort_div($new_arr, 0, $this->data['sorting']);
			$i          = 0;
			foreach ($mycomments as $num => $result) {
				if (($i >= (($page - 1) * $this->data['blog_num_comments'])) && ($i < ((($page - 1) * $this->data['blog_num_comments']) + $this->data['blog_num_comments']))) {
					$this->data['mycomments'][$i] = $result;
				}
				$i++;
			}
		} else {
			$this->data['mycomments'] = Array();
		}
		$this->data['comments']   = $this->data['mycomments'];
		$pagination               = new Pagination();
		$pagination->total        = $comment_total;
		$pagination->page         = $page;
		$pagination->limit        = $this->data['blog_num_comments'];
		$pagination->text         = $this->language->get('text_pagination');
		$pagination->url          = $this->url->link('record/record/comment', 'record_id=' . $this->request->get['record_id'] . '&sorting=' . $this->data['sorting'] . '&page={page}');
		$this->data['pagination'] = $pagination->render();
		if (isset($this->data['blog_design']['blog_template_comment']) && $this->data['blog_design']['blog_template_comment'] != '') {
			$template = $this->data['blog_design']['blog_template_comment'];
		} else {
			$template = 'comment.tpl';
		}
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/record/' . $template)) {
			$this->template = $this->config->get('config_template') . '/template/record/' . $template;
		} else {
			if (file_exists(DIR_TEMPLATE . 'default/template/record/' . $template)) {
				$this->template = 'default/template/record/' . $template;
			} else {
				$this->template = 'default/template/record/comment.tpl';
			}
		}
		$this->data['theme'] = $this->config->get('config_template');
		$this->response->setOutput($this->render());
	}

	public function write() {
		$json = array();
		$this->language->load('record/record');
		$this->load->model('catalog/record');
		if (isset($this->request->get['record_id'])) {
			$record_id = $this->request->get['record_id'];
		} else {
			$record_id = 0;
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
			$captcha_status    = true;
		}
		$record_blog = $this->model_catalog_record->getRecordCategories($record_id);
		if (isset($record_blog) && count($record_blog) > 0) {
			foreach ($record_blog as $k => $blog_id) {
				$data  = array(
					'filter_blog_id' => $blog_id,
					'sort' => $sort,
					'order' => $order,
					'start' => ($page - 1) * $limit,
					'limit' => $limit
				);
				$cache = md5(http_build_query($data));
				$key   = 'record.' . (int) $this->config->get('config_language_id') . '.' . (int) $this->config->get('config_store_id') . '.' . (int) $customer_group_id . '.' . $cache;
				$this->cache->delete($key);
			}
		}

		$record_info                                  = $this->model_catalog_record->getRecord($record_id);
		$record_comment                               = unserialize($record_info['comment']);
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
		if (!isset($this->session->data['captcha']) || (strtolower($this->session->data['captcha']) != strtolower($this->request->post['captcha']))) {
			if ($captcha_status) {
				$json['error'] = $this->language->get('error_captcha');
			}
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
			$this->model_catalog_comment->addComment($this->request->get['record_id'], $this->request->post, $this->request->get);
			$this->data['comment_count'] = $this->model_catalog_comment->getTotalCommentsByRecordId($record_id);
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

		$this->load->model('catalog/comment');
		$record_info = $this->model_catalog_comment->getRecordbyComment($this->data);

        if (isset($record_info['record_id']) && $record_info['record_id']!='') {
        	$this->data['record_id'] = $record_info['record_id'];
        } else {
            $this->data['record_id']='';
        }

        $check_rate 	= $this->model_catalog_comment->checkRate($this->data);
        $check_rate_num = $this->model_catalog_comment->checkRateNum($this->data);

		$rating_num = 0;

		if (isset($this->data['record_id']) && $this->data['record_id']!='') {
			$this->load->model('catalog/record');
			$record_info = $this->model_catalog_record->getRecord($this->data['record_id']);

	        if (isset($record_info) && $record_info) {
	        	if (isset($record_info['comment']) &&  $record_info['comment']!='') {
	            	$record_settings = unserialize($record_info['comment']);

					if (isset($record_settings['rating_num']) &&  $record_settings['rating_num']!='') {
						$rating_num =  $record_settings['rating_num'];
					} else {
						$rating_num = 10000;
					}
	          	}
	        }
        }

        if (isset($check_rate_num['rating_num']) && $check_rate_num['rating_num']!='') {
          $voted_num = $check_rate_num['rating_num'];
        } else {
          $voted_num = $rating_num - 1;
        }

		if ((count($check_rate) < 1) && $customer_id && ($voted_num < $rating_num)) {
			$this->model_catalog_comment->addRate($this->data);
			$rate_info       = $this->model_catalog_comment->getRatesByCommentId($comment_id);
			$json['success'] = $rate_info[0];
			$plus            = "";

			if ($json['success']['rate_delta'] > 0)    $plus = "+";

			$json['success']['rate_delta'] = sprintf($plus."%d", $json['success']['rate_delta']);

		} else {
		 		//			 $json['success']['rate_delta'] =2;
			return $this->response->setOutput(json_encode($json));

			if ($customer_id) {
				$json['messages'] = '';
				$json['success']  = $this->language->get('text_voted');
			} else {
				$json['messages'] = '';
				$json['success']  = $this->language->get('text_vote_reg');
			}
		}

		return $this->response->setOutput(json_encode($json));
	}

	public function upload() {
		$this->language->load('record/record');
		$json = array();
		if (!empty($this->request->files['file']['name'])) {
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
		} else {
			$json['error'] = $this->language->get('error_upload');
		}
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && !isset($json['error'])) {
			if (is_uploaded_file($this->request->files['file']['tmp_name']) && file_exists($this->request->files['file']['tmp_name'])) {
				$file = basename($filename) . '.' . md5(rand());
				$this->load->library('encryption');
				$encryption   = new Encryption($this->config->get('config_encryption'));
				$json['file'] = $encryption->encrypt($file);
				move_uploaded_file($this->request->files['file']['tmp_name'], DIR_DOWNLOAD . $file);
			}
			$json['success'] = $this->language->get('text_upload');
		}
		$this->response->setOutput(json_encode($json));
	}
}
?>