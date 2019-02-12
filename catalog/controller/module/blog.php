<?php
class ControllerModuleBlog extends Controller {
	protected function index($arg) {
		if ($this->config->get("seoblog") != 1) {
			$this->getChild('common/seoblog');
			$this->config->set("seoblog", 1);

			if ($this->flag == 'search') {
				if ($this->config->get("blogwork") != 1) {
					$this->config->set("blogwork", 1);
					$this->response->setOutput($this->getChild('record/search'));
					$this->response->output();
					$this->config->set("blogwork", 0);
					exit();
				}
			}
			
			if ($this->flag == 'record') {
				if ($this->config->get("blogwork") != 1) {
					$this->config->set("blogwork", 1);
					$this->response->setOutput($this->getChild('record/record'));
					$this->response->output();
					$this->config->set("blogwork", 0);
					exit();
				}
			}

			if ($this->flag == 'blog') {
				if ($this->config->get("blogwork") != 1) {
					$this->config->set("blogwork", 1);
					$this->response->setOutput($this->getChild('record/blog'));
					$this->response->output();
					$this->config->set("blogwork", 0);
					exit();
				}
			}
		}
		
 		$position_block = $arg['position'];
		$this->language->load('module/blog');
		$template = '/template/module/blog.tpl';
		if (isset($this->request->get['blog_id'])) {
			$parts                   = explode('_', (string) $this->request->get['blog_id']);
			$this->data['blog_path'] = $this->request->get['blog_id'];
		} else {
			$parts                   = array();
			$this->data['blog_path'] = 0;
		}
		if (isset($parts[0])) {
			$this->data['blog_id'] = $parts[0];
		} else {
			$this->data['blog_id'] = 0;
		}
		if (isset($parts[1])) {
			$this->data['child_id'] = $parts[1];
		} else {
			$this->data['child_id'] = 0;
		}

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

		// $this->config->set('config_layout_id', $layout_id);

		if (!$this->registry->has('blog_position_' . $position_block)) {
			$this->registry->set('blog_position_' . $position_block, 0);
		} else {
			$pos = $this->registry->get('blog_position_' . $position_block);
			$this->registry->set('blog_position_' . $position_block, $pos + 1);
		}

		$position                = $this->registry->get('blog_position_' . $position_block);
		$this->data['position']  = $position;
		$this->data['layout_id'] = $layout_id;
		$module_data             = array();
		$this->load->model('setting/extension');
		$extensions = $this->model_setting_extension->getExtensions('module');

		foreach ($extensions as $extension) {
			$modules = $this->config->get($extension['code'] . '_module');

			if ($modules) {
				foreach ($modules as $module) {
					if ($module['layout_id'] == $layout_id && $extension['code'] == 'blog' && $module['position'] == $position_block && $module['status']) {
						$module_data[] = array(
							'code' => $extension['code'],
							'setting' => $module,
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
					if ($module['layout_id'] == $layout_id && $extension['code'] == 'blog' && $module['position'] == $position_block && $module['status']) {
						$module_data[] = array(
							'code' => $extension['code'],
							'setting' => $module,
							'sort_order' => $module['sort_order']
						);
					}
				}
			}
		}
		
		if (!function_exists('commd')) {
			function commd($a, $b) {
				if ($a['sort_order'] == '') {
					$a['sort_order'] = 1000;
				}

				if ($b['sort_order'] == '') {
					$b['sort_order'] = 1000;
				}

				if ($a['sort_order'] > $b['sort_order']) {
					return 1;
				}

				return -1;
			}
		}

		usort($module_data, 'commd');

		$type                        = "none";
		$this->data['heading_title'] = '';
		$this->data['myblogs']       = Array();
		$this->data['mylist']        = $this->config->get('mylist');

		if (!isset($module_data[$position]) ) {
		  	$this->registry->set('blog_position_' . $position_block, 0);
		  	$position = 0;
		}

		if (isset($module_data[$position]['setting']['what']) && $module_data[$position]['setting']['what'] != 'what_hook') {
			$type = $this->data['mylist'][$module_data[$position]['setting']['what']]['type'];
		}

		if (isset($module_data[$position]['setting']['what']) && $module_data[$position]['setting']['what'] == 'what_hook') {
			$type = "hook";
		}

		if (isset($module_data[$position]['setting']['what']) && isset($this->data['mylist'][$module_data[$position]['setting']['what']])) {
			$thislist = $this->data['mylist'][$module_data[$position]['setting']['what']];
		} else {
			$thislist = null;
		}

		if (!empty($module_data) && ($type == 'blogsall' || $type == 'blogs')) {
			$this->data['heading_title'] = $this->data['mylist'][$module_data[$position]['setting']['what']]['title_list_latest'][$this->config->get('config_language_id')];
			$this->load->model('catalog/blog');
			$this->load->model('catalog/record');
			$this->data['blogies'] = array();
			if ($type == 'blogs' || $type == 'blogsall') {
				$this->data['blog_link'] = $this->url->link('record/blog', 'blog_id=' . $this->data['blog_path']);
				if ($type == 'blogs' && isset($this->data['mylist'][$module_data[$position]['setting']['what']]['blogs'])) {
					foreach ($this->data['mylist'][$module_data[$position]['setting']['what']]['blogs'] as $num => $blog_id) {
						$blogies[] = $this->model_catalog_blog->getBlog($blog_id);
					}
				}
				if ($type == 'blogsall') {
					$blogies = $this->model_catalog_blog->getBlogs();
				}
				if (isset($blogies) && count($blogies) > 0) {
					foreach ($blogies as $blog) {
						if (isset($blog['blog_id'])) {
							$blog_info = $this->model_catalog_blog->getBlog($blog['blog_id']);
							$this->load->model('tool/image');
							if ($blog_info) {
								if ($blog_info['image']) {
									if (isset($thislist['avatar']['width']) && isset($thislist['avatar']['height']) && $thislist['avatar']['width'] != "" && $thislist['avatar']['height'] != "") {
										$thumb = $this->model_tool_image->resize($blog_info['image'], $thislist['avatar']['width'], $thislist['avatar']['height'], 1);
									} else {
										$thumb = $this->model_tool_image->resize($blog_info['image'], 150, 150, 1);
									}
								} else {
									$thumb = '';
								}
							} else {
								$thumb = '';
							}
							$data                  = array(
								'filter_blog_id' => $blog['blog_id'],
								'filter_sub_blog' => false
							);
							$record_total          = $this->model_catalog_record->getTotalRecords($data);
							$blog_href             = $this->model_catalog_blog->getPathByblog($blog['blog_id']);
							$this->data['blogs'][] = array(
								'blog_id' => $blog['blog_id'],
								'parent_id' => $blog['parent_id'],
								'sort' => $blog['sort_order'],
								'name' => $blog['name'],
								'count' => $record_total,
								'meta' => $blog['meta_description'],
								'thumb' => $thumb,
								'href' => $this->url->link('record/blog', 'blog_id=' . $blog_href['path']),
								'path' => $blog_href['path'],
								'display' => true,
								'active' => 'none'
							);
						}
					}
				}

				if (!function_exists('compare')) {
					function compare($a, $b)
					{
						if ($a['sort'] > $b['sort'])
							return 1;
						if ($b['sort'] > $a['sort'])
							return -1;
						return 0;
					}
				}
				if (!function_exists('my_sort_div')) {
					function my_sort_div($data, $parent = 0, $lev = -1)
					{
						$arr = $data[$parent];
						usort($arr, 'compare');
						$lev = $lev + 1;
						for ($i = 0; $i < count($arr); $i++) {
							$arr[$i]['level']               = $lev;
							$z[]                            = $arr[$i];
							$z[count($z) - 1]['flag_start'] = 1;
							$z[count($z) - 1]['flag_end']   = 0;
							if (isset($data[$arr[$i]['blog_id']])) {
								$m = my_sort_div($data, $arr[$i]['blog_id'], $lev);
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
				if (isset($this->data['blogs']) && count($this->data['blogs'])>0) {

				$aparent = Array();
				$ablog   = Array();
				foreach ($this->data['blogs'] as $num => $data) {
					$aparent[$data['parent_id']] = true;
					$ablog[$data['blog_id']]     = true;
				}
				reset($this->data['blogs']);
				foreach ($this->data['blogs'] as $num => $data) {
					if (!isset($ablog[$data['parent_id']])) {
						$this->data['blogs'][$num]['parent_id'] = 0;
					}
				}
				reset($this->data['blogs']);
				for ($i = 0, $c = count($this->data['blogs']); $i < $c; $i++) {
					$new_arr[$this->data['blogs'][$i]['parent_id']][] = $this->data['blogs'][$i];
				}

				$this->data['new_arr'] = $new_arr;
				$this->data['myblogs'] = my_sort_div($new_arr, 0);
				$lv                    = 0;
				$alv                   = 0;
				foreach ($this->data['myblogs'] as $num => $mblogs) {
					$path_parts = explode('_', (string) $this->data['blog_path']);
					$blog_parts = explode('_', (string) $mblogs['path']);
					$iarr       = array_intersect($path_parts, $blog_parts);
					$active     = 'none';
					$display    = false;
					if (count($iarr) == 0) {
						$active = 'none';
						if ($mblogs['level'] == 0) {
							$display = true;
						}
					}
					if ($mblogs['level'] == $alv) {
						$display = true;
					} else {
						$alv = 0;
					}
					if (count($iarr) == count($path_parts) && count($iarr) == count($blog_parts)) {
						$display = true;
						$active  = 'active';
						$alv     = $mblogs['level'] + 1;
					}
					if ((count($iarr) > 0) && ($mblogs['level'] <= count($iarr)) && $active != 'active') {
						$display = true;
						if ($mblogs['level'] != count($iarr)) {
							$active = 'pass';
							$lv     = $mblogs['level'] + 1;
						}
					}
					if ($display) {
						$display = true;
					} else {
						if ($mblogs['level'] > $lv) {
							$lv      = 0;
							$display = false;
						}
					}
					$this->data['myblogs'][$num]['active']  = $active;
					$this->data['myblogs'][$num]['display'] = $display;
				}

				}
				if (isset($thislist['template']) && $thislist['template'] != '') {
					$template = '/template/module/' . $thislist['template'];
				} else {
					$template = '/template/module/blog.tpl';
				}
			}
		}

		if (!empty($module_data) && ($type == 'latest' || $type == 'records')) {
			$this->data = "";
			$this->data = $this->getBlogsRecords($thislist, $type);
			if (isset($thislist['template']) && $thislist['template'] != '') {
				$template = '/template/module/' . $thislist['template'];
			} else {
				if ($type == 'latest') {
					$template = '/template/module/blog_latest.tpl';
				}
				if ($type == 'records') {
					$template = '/template/module/blog_records.tpl';
				}
			}
		}

		if (!empty($module_data) && $type == 'html') {
			$this->data['html']          = html_entity_decode($this->data['mylist'][$module_data[$position]['setting']['what']]['html'][$this->config->get('config_language_id')], ENT_QUOTES, 'UTF-8');
			$this->data['heading_title'] = $this->data['mylist'][$module_data[$position]['setting']['what']]['title_list_latest'][$this->config->get('config_language_id')];
			if (isset($thislist['template']) && $thislist['template'] != '') {
				$template = '/template/module/' . $thislist['template'];
			} else {
				$template = '/template/module/blog_html.tpl';
			}
		}

		if (!empty($module_data) && $type == 'hook') {
			if (isset($thislist['template']) && $thislist['template'] != '') {
				$template = '/template/module/' . $thislist['template'];
			} else {
				$template = '/template/module/blog_hook.tpl';
			}
		}

		if (!empty($module_data) && $type != '') {
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . $template)) {
				$this->template = $this->config->get('config_template') . $template;
			} else {
				$this->template = 'default' . $template;
			}
			$this->data['theme'] = $this->config->get('config_template');

			$this->render();
		}
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

	private function getBlogsRecords($thislist, $type = 'latest') {
		$this->language->load('record/blog');
		$this->load->model('catalog/record');
		$this->load->model('tool/image');
		$this->data['text_comments'] = $this->language->get('text_comments');
		$this->data['text_viewed']   = $this->language->get('text_viewed');
		if (isset($thislist['title_list_latest'][$this->config->get('config_language_id')]) && $thislist['title_list_latest'][$this->config->get('config_language_id')] != '') {
			$this->data['heading_title'] = $thislist['title_list_latest'][$this->config->get('config_language_id')];
		} else {
			$this->data['heading_title'] = '';
		}
		if (isset($thislist['number_per_blog']) && $thislist['number_per_blog'] != '') {
			$limit = $thislist['number_per_blog'];
		} else {
			$limit = 5;
		}
		if (isset($thislist['order']) && $thislist['order'] != '') {
			$sort = $thislist['order'];
		} else {
			$sort = 'latest';
		}
		if (isset($thislist['blogs'])) {
			$this->data['blogs'] = $thislist['blogs'];
		} else {
			$this->data['blogs'] = 0;
		}
		if (isset($thislist['related'])) {
			$this->data['related'] = $thislist['related'];
		} else {
			$this->data['related'] = Array();
		}
		$amount                = 0;
		$order                 = 'DESC';
		$this->data['records'] = array();
		$data                  = array(
			'filter_blogs' => $this->data['blogs'],
			'sort' => $sort,
			'order' => $order,
			'start' => 0,
			'limit' => $limit
		);
		$results               = false;
		if ($type == 'latest') {
			$results = $this->model_catalog_record->getBlogsRecords($data);
		}
		if ($type == 'records') {

           if (isset($this->data['related']) && !empty($this->data['related']) ) {
				foreach ($this->data['related'] as $related_id) {
					$results[$related_id] = $this->model_catalog_record->getRecord($related_id);
				}
			}
		}



		if ($results) {
			foreach ($results as $result) {

			if ($result!='') {
				if ($result['image']) {
					$dimensions = $thislist['avatar'];
					if ($dimensions['width'] == '')
						$dimensions['width'] = 200;
					if ($dimensions['height'] == '')
						$dimensions['height'] = 100;
					$image = $this->model_tool_image->resize($result['image'], $dimensions['width'], $dimensions['height']);
				} else {
					$image = false;
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
					$flag_desc                   = 'pred';
					$this->data['blog_num_desc'] = $thislist['desc_symbols'];
					if ($this->data['blog_num_desc'] == '') {
						$this->data['blog_num_desc'] = 50;
					} else {
						$amount    = $this->data['blog_num_desc'];
						$flag_desc = 'symbols';
					}
					$this->data['blog_num_desc_words'] = $thislist['desc_words'];
					if ($this->data['blog_num_desc_words'] == '') {
						$this->data['blog_num_desc_words'] = 10;
					} else {
						$amount    = $this->data['blog_num_desc_words'];
						$flag_desc = 'words';
					}
					$this->data['blog_num_desc_pred'] = $thislist['desc_pred'];
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
				$this->load->model('catalog/blog');
				$blog_href = $this->model_catalog_blog->getPathByrecord($result['record_id']);
				if (strpos($blog_href['path'], '_') !== false) {
					$abid    = explode('_', $blog_href['path']);
					$blog_id = $abid[count($abid) - 1];
				} else {
					$blog_id = (int) $blog_href['path'];
				}
				$blog_id                 = (int) $blog_id;
				$this->data['records'][] = array(
					'record_id' => $result['record_id'],
					'thumb' => $image,
					'name' => $result['name'],
					'description' => $description,
					'rating' => $result['rating'],
					'date_added' => $result['date_added'],
					'date_available' => $date_available,
					'date_end' => $result['date_end'],
					'viewed' => $result['viewed'],
					'comments' => (int) $result['comments'],
					'href' => $this->url->link('record/record', 'record_id=' . $result['record_id']),
					'blog_id' => $blog_id,
					'blog_href' => $this->url->link('record/blog', 'blog_id=' . $blog_href['path']),
					'blog_name' => $blog_href['name']
				);
			}
		  }
		}
		return $this->data;
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
}
?>