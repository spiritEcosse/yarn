<?php
class ControllerRecordBlog extends Controller {
	public function index() {
		$this->getChild('common/seoblog');
		$this->language->load('record/blog');
		$this->load->model('catalog/blog');
		$this->load->model('catalog/record');
		$this->load->model('tool/image');

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
			if ($this->config->get('blog_num_records') != '') {
				$limit = $this->config->get('blog_num_records');
			} else {
				$limit = $this->config->get('config_catalog_limit');
				$this->config->set('blog_num_records', $limit);
			}
		}

		$this->breadcrumbs();

		if (isset($this->request->get['blog_id'])) {
			$path  = '';
			$parts = explode('_', (string) $this->request->get['blog_id']);

			foreach ($parts as $path_id) {
				if (!$path) {
					$path = $path_id;
				} else {
					$path .= '_' . $path_id;
				}
				$blog_info = $this->model_catalog_blog->getBlog($path_id);
				if ($blog_info) {
					$this->data['breadcrumbs'][] = array(
						'text' => $blog_info['name'],
						'href' => $this->url->link('record/blog', 'blog_id=' . $path),
						'separator' => $this->language->get('text_separator')
					);
				}
			}
			$blog_id = array_pop($parts);
		} else {
			$blog_id = 0;
		}

		$this->data['imagebox'] = 'colorbox';
		$blog_info = $this->model_catalog_blog->getBlog($blog_id);

		if ($blog_info) {
			$this->document->setTitle($blog_info['name']);
			$this->document->setDescription($blog_info['meta_description']);
			$this->document->setKeywords($blog_info['meta_keyword']);
			$this->data['heading_title']     = $blog_info['name'];
			$this->data['blog_href']         = $this->url->link('record/blog', 'blog_id=' . $blog_id);
			$this->data['text_refine']       = $this->language->get('text_refine');
			$this->data['text_empty']        = $this->language->get('text_empty');
			$this->data['text_quantity']     = $this->language->get('text_quantity');
			$this->data['text_manufacturer'] = $this->language->get('text_manufacturer');
			$this->data['text_model']        = $this->language->get('text_model');
			$this->data['text_price']        = $this->language->get('text_price');
			$this->data['text_tax']          = $this->language->get('text_tax');
			$this->data['text_points']       = $this->language->get('text_points');
			$this->data['text_compare']      = sprintf($this->language->get('text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));
			$this->data['text_display']      = $this->language->get('text_display');
			$this->data['text_list']         = $this->language->get('text_list');
			$this->data['text_grid']         = $this->language->get('text_grid');
			$this->data['text_sort']         = $this->language->get('text_sort');
			$this->data['text_limit']        = $this->language->get('text_limit');
			$this->data['text_comments']     = $this->language->get('text_comments');
			$this->data['text_viewed']       = $this->language->get('text_viewed');
			$this->data['button_cart']       = $this->language->get('button_cart');
			$this->data['button_wishlist']   = $this->language->get('button_wishlist');
			$this->data['button_compare']    = $this->language->get('button_compare');
			$this->data['button_continue']   = $this->language->get('button_continue');

			if ($blog_info['design'] != '') {
				$this->data['blog_design'] = unserialize($blog_info['design']);
			} else {
				$this->data['blog_design'] = Array();
			}

			if ($blog_info['image']) {
				if (isset($this->data['blog_design']['blog_big']) && $this->data['blog_design']['blog_big']['width'] != '' && $this->data['blog_design']['blog_big']['height'] != '') {
					$dimensions = $this->data['blog_design']['blog_big'];
				} else {
					$dimensions = $this->config->get('blog_big');
				}

				if ($dimensions['width'] == '') {
					$dimensions['width'] = 300;
				}

				if ($dimensions['height'] == '') {
					$dimensions['height'] = 200;
				}

				$this->data['thumb'] = $this->model_tool_image->resize($blog_info['image'], $dimensions['width'], $dimensions['height']);
			} else {
				$this->data['thumb'] = '';
			}

			if ($blog_info['description']) {
				$this->data['description'] = html_entity_decode($blog_info['description'], ENT_QUOTES, 'UTF-8');
			} else {
				$this->data['description'] = false;
			}
			
			if (isset($blog_info['sdescription']) && $blog_info['sdescription'] != '') {
				$this->data['sdescription'] = html_entity_decode($blog_info['sdescription'], ENT_QUOTES, 'UTF-8');
			} else {
				$this->data['sdescription'] = false;
			}
			
			$this->data['compare'] = $this->url->link('record/compare');
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

			$this->data['categories'] = array();
			$results = $this->model_catalog_blog->getBlogies($blog_id);

			foreach ($results as $result) {
				$data = array(
					'filter_blog_id' => $result['blog_id'],
					'filter_sub_blog' => true
				);

				$record_total = $this->model_catalog_record->getTotalRecords($data);

				if ($result['image']) {
					if (isset($this->data['blog_design']['blog_small']) && $this->data['blog_design']['blog_small']['width'] != '' && $this->data['blog_design']['blog_small']['height'] != '') {
						$dimensions = $this->data['blog_design']['blog_small'];
					} else {
						$dimensions = $this->config->get('blog_small');
					}

					if ($dimensions['width'] == '') {
						if ($this->config->get('config_image_category_width') != '') {
							$dimensions['width'] = $this->config->get('config_image_category_width');
						} else {
							$dimensions['width'] = 100;
						}
					}

					if ($dimensions['height'] == '') {
						if ($this->config->get('config_image_category_height') != '') {
							$dimensions['height'] = $this->config->get('config_image_category_height');
						} else {
							$dimensions['height'] = 100;
						}
					}
					$image = $this->model_tool_image->resize($result['image'], $dimensions['width'], $dimensions['height']);
				} else {
					$image = '';
				}

				$this->data['categories'][] = array(
					'name' => $result['name'],
					'meta_description' => $result['meta_description'],
					'total' => $record_total,
					'thumb' => $image,
					'href' => $this->url->link('record/blog', 'blog_id=' . $this->request->get['blog_id'] . '_' . $result['blog_id'] . $url)
				);
			}

			if (isset($this->data['blog_design']['blog_num_records']) && $this->data['blog_design']['blog_num_records'] != '' && !isset($this->request->get['limit'])) {
				$limit = $this->data['blog_design']['blog_num_records'];
			}

			$this->data['records'] = array();
			$data = array(
				'filter_blog_id' => $blog_id,
				'sort' => $sort,
				'order' => $order,
				'start' => ($page - 1) * $limit,
				'limit' => $limit
			);

			$record_total = $this->model_catalog_record->getTotalRecords($data);
			$results = $this->model_catalog_record->getRecords($data);

			foreach ($results as $result) {
				if ($result['image']) {
					if (isset($this->data['blog_design']['blog_small']) && $this->data['blog_design']['blog_small']['width'] != '' && $this->data['blog_design']['blog_small']['height'] != '') {
						$dimensions = $this->data['blog_design']['blog_small'];
					} else {
						$dimensions = $this->config->get('blog_small');
					}

					if ($dimensions['width'] == '') {
						$dimensions['width'] = 300;
					}

					if ($dimensions['height'] == '') {
						$dimensions['height'] = 200;
					}

					$image = $this->model_tool_image->resize($result['image'], $dimensions['width'], $dimensions['height']);
				} else {
					$image = false;
				}

				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')), $result['code'], 1);
				} else {
					$price = false;
				}

				if ((float) $result['special']) {
					$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')), $result['code'], 1);
				} else {
					$special = false;
				}

				if ($this->config->get('config_tax')) {
					$tax = $this->currency->format((float) $result['special'] ? $result['special'] : $result['price'], $result['code'], 1);
				} else {
					$tax = false;
				}

				if ($this->config->get('config_comment_status')) {
					$rating = (int) $result['rating'];
				} else {
					$rating = false;
				}

				if (!isset($result['sdescription'])) {
					$result['sdescription'] = '';
				}

				if ($result['description'] && $result['sdescription'] == '') {
					$flag_desc = 'pred';
					$amount    = 1;

					if (isset($this->data['blog_design']['blog_num_desc'])) {
						$this->data['blog_num_desc'] = $this->data['blog_design']['blog_num_desc'];
					} else {
						$this->data['blog_num_desc'] = $this->config->get('blog_num_desc');
					}

					if ($this->data['blog_num_desc'] == '') {
						$this->data['blog_num_desc'] = 50;
					} else {
						$amount    = $this->data['blog_num_desc'];
						$flag_desc = 'symbols';
					}

					if (isset($this->data['blog_design']['blog_num_desc_words'])) {
						$this->data['blog_num_desc_words'] = $this->data['blog_design']['blog_num_desc_words'];
					} else {
						$this->data['blog_num_desc_words'] = $this->config->get('blog_num_desc_words');
					}

					if ($this->data['blog_num_desc_words'] == '') {
						$this->data['blog_num_desc_words'] = 10;
					} else {
						$amount    = $this->data['blog_num_desc_words'];
						$flag_desc = 'words';
					}

					if (isset($this->data['blog_design']['blog_num_desc_pred'])) {
						$this->data['blog_num_desc_pred'] = $this->data['blog_design']['blog_num_desc_pred'];
					} else {
						$this->data['blog_num_desc_pred'] = $this->config->get('blog_num_desc_pred');
					}

					if ($this->data['blog_num_desc_pred'] == '') {
						$this->data['blog_num_desc_pred'] = 3;
					} else {
						$amount    = $this->data['blog_num_desc_pred'];
						$flag_desc = 'pred';
					}

					switch ($flag_desc) {
						case 'symbols':
							$pattern = ('/((.*?)\S){0,' . $amount . '}/isu');
							preg_match_all($pattern, strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), $out);
							$description = $out[0][0];
							break;
						case 'words':
							$pattern = ('/((.*?)\x20){0,' . $amount . '}/isu');
							preg_match_all($pattern, strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), $out);
							$description = $out[0][0];
							break;
						case 'pred':
							$pattern = ('/((.*?)\.){0,' . $amount . '}/isu');
							preg_match_all($pattern, strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), $out);
							$description = $out[0][0];
							break;
					}
				} else {
					$description = false;
				}

				if (isset($result['sdescription']) && $result['sdescription'] != '') {
					$description = html_entity_decode($result['sdescription'], ENT_QUOTES, 'UTF-8');
				}

				if ($this->rdate($this->language->get('text_date')) == $this->rdate($this->language->get('text_date'), strtotime($result['date_available']))) {
					$date_str = $this->language->get('text_today');
				} else {
					$date_str = $this->language->get('text_date');
				}

				$date_available = $this->rdate($date_str . $this->language->get('text_hours'), strtotime($result['date_available']));
				$blog_href = $this->model_catalog_blog->getPathByrecord($result['record_id']);
				$popup = '/image/' . $result['image'];

				$this->data['records'][] = array(
					'record_id' => $result['record_id'],
					'thumb' => $image,
					'popup' => $popup,
					'name' => $result['name'],
					'description' => $description,
					'attribute_groups' => $this->model_catalog_record->getRecordAttributes($result['record_id']),
					'rating' => $result['rating'],
					'date_added' => $result['date_added'],
					'date_available' => $date_available,
					'date_end' => $result['date_end'],
					'viewed' => $result['viewed'],
					'comments' => (int) $result['comments'],
					'href' => $this->url->link('record/record', 'record_id=' . $result['record_id'] . '&blog_id=' . $blog_href['path']),
					'blog_href' => $this->url->link('record/blog', 'blog_id=' . $blog_href['path']),
					'blog_name' => $blog_href['name']
				);
			}
			
			$url = '';

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$this->data['sorts']   = array();
			$this->data['sorts'][] = array(
				'text' => $this->language->get('text_default'),
				'value' => 'p.sort_order-ASC',
				'href' => $this->url->link('record/blog', 'blog_id=' . $this->request->get['blog_id'] . '&sort=p.sort_order&order=ASC' . $url)
			);

			$this->data['sorts'][] = array(
				'text' => $this->language->get('text_date_added_desc'),
				'value' => 'p.date_added-DESC',
				'href' => $this->url->link('record/blog', 'blog_id=' . $this->request->get['blog_id'] . '&sort=p.date_added&order=DESC' . $url)
			);

			$this->data['sorts'][] = array(
				'text' => $this->language->get('text_date_added_asc'),
				'value' => 'p.date_added-ASC',
				'href' => $this->url->link('record/blog', 'blog_id=' . $this->request->get['blog_id'] . '&sort=p.date_added&order=ASC' . $url)
			);

			$this->data['sorts'][] = array(
				'text' => $this->language->get('text_name_asc'),
				'value' => 'pd.name-ASC',
				'href' => $this->url->link('record/blog', 'blog_id=' . $this->request->get['blog_id'] . '&sort=pd.name&order=ASC' . $url)
			);

			$this->data['sorts'][] = array(
				'text' => $this->language->get('text_name_desc'),
				'value' => 'pd.name-DESC',
				'href' => $this->url->link('record/blog', 'blog_id=' . $this->request->get['blog_id'] . '&sort=pd.name&order=DESC' . $url)
			);

			$this->data['sorts'][] = array(
				'text' => $this->language->get('text_rating_desc'),
				'value' => 'rating-DESC',
				'href' => $this->url->link('record/blog', 'blog_id=' . $this->request->get['blog_id'] . '&sort=rating&order=DESC' . $url)
			);

			$this->data['sorts'][] = array(
				'text' => $this->language->get('text_rating_asc'),
				'value' => 'rating-ASC',
				'href' => $this->url->link('record/blog', 'blog_id=' . $this->request->get['blog_id'] . '&sort=rating&order=ASC' . $url)
			);

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			$this->data['limits']   = array();
			$this->data['limits'][] = array(
				'text' => $limit,
				'value' => $limit,
				'href' => $this->url->link('record/blog', 'blog_id=' . $this->request->get['blog_id'] . $url . '&limit=' . $limit)
			);

			$this->data['limits'][] = array(
				'text' => 25,
				'value' => 25,
				'href' => $this->url->link('record/blog', 'blog_id=' . $this->request->get['blog_id'] . $url . '&limit=25')
			);

			$this->data['limits'][] = array(
				'text' => 50,
				'value' => 50,
				'href' => $this->url->link('record/blog', 'blog_id=' . $this->request->get['blog_id'] . $url . '&limit=50')
			);

			$this->data['limits'][] = array(
				'text' => 75,
				'value' => 75,
				'href' => $this->url->link('record/blog', 'blog_id=' . $this->request->get['blog_id'] . $url . '&limit=75')
			);

			$this->data['limits'][] = array(
				'text' => 100,
				'value' => 100,
				'href' => $this->url->link('record/blog', 'blog_id=' . $this->request->get['blog_id'] . $url . '&limit=100')
			);

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

			$pagination               = new Pagination();
			$pagination->total        = $record_total;
			$pagination->page         = $page;
			$pagination->limit        = $limit;
			$pagination->text         = $this->language->get('text_pagination');
			$pagination->url          = $this->url->link('record/blog', 'blog_id=' . $this->request->get['blog_id'] . $url . '&page={page}');
			$this->data['pagination'] = $pagination->render();
			$this->data['sort']       = $sort;
			$this->data['order']      = $order;
			$this->data['limit']      = $limit;
			$this->data['continue']   = $this->url->link('common/home');

			if (isset($this->data['blog_design']['blog_template']) && $this->data['blog_design']['blog_template'] != '') {
				$template = $this->data['blog_design']['blog_template'];
			} else {
				$template = 'blog.tpl';
			}
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/record/' . $template)) {
				$this->template = $this->config->get('config_template') . '/template/record/' . $template;
			} else {
				if (file_exists(DIR_TEMPLATE . 'default/template/record/' . $template)) {
					$this->template = 'default/template/record/' . $template;
				} else {
					$this->template = 'default/template/record/blog.tpl';
				}
			}
			$this->children      = array(
				'common/column_left',
				'common/column_right',
				'common/content_top',
				'common/content_bottom',
				'common/footer',
				'common/header'
			);
		    /*
			if (isset($this->request->get['route'])) {
					$route = $this->request->get['route'];
				} else {
					$route = 'common/home';
				}
		       	$this->load->model('catalog/category');
				$this->load->model('catalog/product');
				$this->load->model('catalog/information');
				$this->load->model('design/bloglayout');
				$layout_id = false;

				if ($route == 'product/category' && isset($this->request->get['path'])) {
					$path = explode('_', (string)$this->request->get['path']);

					$layout_id = $this->model_catalog_category->getCategoryLayoutId(end($path));
				}

				if ($route == 'product/product' && isset($this->request->get['product_id'])) {
					$layout_id = $this->model_catalog_product->getProductLayoutId($this->request->get['product_id']);
				}

				if ($route == 'information/information' && isset($this->request->get['information_id'])) {
					$layout_id = $this->model_catalog_information->getInformationLayoutId($this->request->get['information_id']);
				}

				if ($route == 'record/blog' && isset($this->request->get['blog_id'])) {
					$path = explode('_', (string)$this->request->get['blog_id']);

					$layout_id = $this->model_design_bloglayout->getBlogLayoutId(end($path));
				}

				if ($route == 'record/record' && isset($this->request->get['record_id'])) {
					$layout_id = $this->model_design_bloglayout->getRecordLayoutId($this->request->get['record_id']);
				}

				if (!$layout_id) {
					$layout_id = $this->model_design_layout->getLayout($route);
				}

				if (!$layout_id) {
					$layout_id = $this->config->get('config_layout_id');
				}

				$this->config->set('config_layout_id', $layout_id);
		        $this->request->get['route']='';
		        */


			$this->data['theme'] = $this->config->get('config_template');
			$this->response->setOutput($this->render());
		} else {
			$url = '';
			if (isset($this->request->get['blog_id'])) {
				$url .= '&blog_id=' . $this->request->get['blog_id'];
			}
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}
			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}
			$this->data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_error'),
				'href' => $this->url->link('record/blog', $url),
				'separator' => $this->language->get('text_separator')
			);
			$this->document->setTitle($this->language->get('text_error'));
			$this->data['heading_title']   = $this->language->get('text_error');
			$this->data['text_error']      = $this->language->get('text_error');
			$this->data['button_continue'] = $this->language->get('button_continue');
			$this->data['continue']        = $this->url->link('common/home');

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
}
?>