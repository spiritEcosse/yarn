<?php
class ControllerCommonSeoBlog extends Controller
{
	private $blog_design = Array();
	public function index()
	{
		if ($this->config->get('config_seo_url')) {
			$this->url->addRewrite($this);
		}

		if (isset($_GET['_route_']))
			 $this->request->get['_route_'] = $_GET['_route_'];
		if (isset($_GET['route']))
			$this->request->get['route'] = $_GET['route'];

		$this->flag = 'none';


		if ((isset($this->request->get['route']) && $this->request->get['route'] == 'record/search') || (isset($this->request->get['_route_']) && $this->request->get['_route_'] == 'record/search')) {
			$this->request->get['route'] = 'record/search';
			$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . '/1.1 200 OK');
			return $this->flag = "search";
		}
		if (isset($this->request->get['record_id'])) {
			$this->request->get['route']   = 'record/record';
			$this->request->get['blog_id'] = $this->getPathByRecord($this->request->get['record_id']);
			$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . '/1.1 200 OK');
			return $this->flag = 'record';
		}
		if (isset($this->request->get['blog_id'])) {
			$this->request->get['route']   = 'record/blog';
			$this->request->get['blog_id'] = $this->getPathByBlog($this->request->get['blog_id']);
			$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . '/1.1 200 OK');
			return $this->flag = 'blog';
		}
		if (isset($this->request->get['_route_'])) {
			$this->load->model('design/bloglayout');
			$this->data['layouts'] = $this->model_design_bloglayout->getLayouts();
			$route                 = $this->request->get['_route_'];
			$parts                 = explode('/', trim($route, '/'));
			if (isset($this->request->get['record_id']) && $this->request->get['record_id'] != '') {
				array_push($parts, 'record_id=' . $this->request->get['record_id']);
			}

			foreach ($parts as $part) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias_blog WHERE keyword = '" . $this->db->escape($part) . "'");
				if (!$query->num_rows && isset($this->request->get['record_id']) && $this->request->get['record_id'] != '') {
					$query->num_rows     = 1;
					$query->row['query'] = 'record_id=' . $this->request->get['record_id'];
				}
				if ($query->num_rows) {
					$url = explode('=', $query->row['query']);
					if ($url[0] == 'record_id') {
						$this->request->get['record_id'] = $url[1];
						$path                            = $this->getPathByRecord($this->request->get['record_id']);
						if ($path)
							$this->request->get['path'] = $path;
						$this->flag = 'record';
						$layout     = 0;
						foreach ($this->data['layouts'] as $num => $lay) {
							if ($lay['name'] == 'Record')
								$layout = $lay['layout_id'];
						}
						// $this->config->set("config_layout_id", $layout);
					} else {
						if ($url[0] == 'blog_id') {
							$this->flag = 'blog';
							$layout     = 0;
							foreach ($this->data['layouts'] as $num => $lay) {
								if ($lay['name'] == 'Blog')
									$layout = $lay['layout_id'];
							}
							// $this->config->set("config_layout_id", $layout);
							if (!isset($this->request->get['blog_id'])) {
								$this->request->get['blog_id'] = $url[1];
							} else {
								$this->request->get['blog_id'] .= '_' . $url[1];
							}
						}
					}
					if ($url[0] == 'record/search') {
						$this->flag = 'search';
						$layout     = 0;
						foreach ($this->data['layouts'] as $num => $lay) {
							if ($lay['name'] == 'Search_Record')
								$layout = $lay['layout_id'];
						}
						// $this->config->set("config_layout_id", $layout);
						if (!isset($this->request->get['record/search'])) {
							$this->request->get['route'] = 'record/search';
						} else {
							$this->request->get['route'] = 'record/search';
						}
					}
					if ($url[0] == 'route') {
						$this->request->get['route'] = $url[1];
					}
				} else {
				}
			}

			if (isset($this->request->get['record_id'])) {
				$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . '/1.1 200 OK');
				$this->request->get['route'] = 'record/record';
			} elseif (isset($this->request->get['blog_id'])) {
				$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . '/1.1 200 OK');
				$this->request->get['route'] = 'record/blog';
			} elseif (isset($this->request->get['record/search'])) {
				$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . '/1.1 200 OK');
				$this->request->get['route'] = 'record/search';
			}

			if (isset($this->request->get['route'])) {
				$this->request->get['_route_'] = $this->request->get['route'];
			}

			return $this->flag;
		}
	}
	public function rewrite($link)
	{
		if ($this->config->get('config_seo_url')) {
			$url_data = parse_url(str_replace('&amp;', '&', $link));
			$url      = '';
			$data     = array();
			if (isset($url_data['query'])) {
				parse_str($url_data['query'], $data);
			}
			foreach ($data as $name) {
				if ($name != 'record_id' && $name != 'route' && $name != 'blog_id') {
					unset($data[$name]);
				}
			}
			reset($data);
			if (isset($data['record_id'])) {
				$record_id = $data['record_id'];
				if ($this->config->get('config_seo_url')) {
					$path = $this->getPathByRecord($record_id);
				}
				$data['path'] = $path;
			}
			$flag_record = false;
			foreach ($data as $key => $value) {
				if (isset($data['route'])) {
					if ($key == 'blog_id') {
						$path = $this->getPathByBlog($value);
					}
					if ($key == 'path') {
						$categories = explode('_', $value);
						$new        = array_reverse($categories);
						foreach ($new as $category) {
							$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias_blog WHERE `query` = 'blog_id=" . (int) $category . "'");
							if ($query->num_rows) {
								$url = '/' . $query->row['keyword'] . $url;
							}
						}
						unset($data[$key]);
					}
					if (($data['route'] == 'record/record' && $key == 'record_id')) {
						$flag_record = true;
						$query       = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias_blog WHERE `query` = '" . $this->db->escape($key . '=' . (int) $value) . "'");
						if ($query->num_rows) {
							$url = '/' . $query->row['keyword'];
							unset($data[$key]);
						}
					} elseif ($key == 'blog_id' && !$flag_record) {
						$categories = explode('_', $value);
						if (count($categories) == 1) {
							$path       = $this->getPathByBlog($categories[0]);
							$categories = explode('_', $path);
						}
						foreach ($categories as $category) {
							$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias_blog WHERE `query` = 'blog_id=" . (int) $category . "'");
							if ($query->num_rows) {
								$url .= '/' . $query->row['keyword'];
							}
						}
						unset($data[$key]);
					}
					if ($flag_record && $key == 'blog_id') {
						unset($data[$key]);
					} else {
						if ($url == '') {
							$sql   = "SELECT * FROM " . DB_PREFIX . "url_alias_blog WHERE `query` = '" . $this->db->escape($key . '=' . $value) . "'";
							$query = $this->db->query($sql);
							if ($query->num_rows) {
								$url .= '/' . $query->row['keyword'];
							}
						}
					}
				}
			}
			if ($url) {
				unset($data['route']);
				$query = '';
				if ($data) {
					foreach ($data as $key => $value) {
						$query .= '&' . $key . '=' . $value;
					}
					if ($query) {
						$query = '?' . trim($query, '&');
					}
				}
				if (isset($this->blog_design['blog_devider']) && $this->blog_design['blog_devider'] == 1) {
					if (strpos($url, '.html') !== false) {
						$devider = "";
					} else {
						$devider = "/";
					}
				} else {
					$devider = "";
				}
				return $url_data['scheme'] . '://' . $url_data['host'] . (isset($url_data['port']) ? ':' . $url_data['port'] : '') . str_replace('/index.php', '', $url_data['path']) . $url . $devider . $query;
			} else {
				return $link;
			}
		} else {
			return $link;
		}
	}
	private function getPathByRecord($record_id)
	{
		if (strpos($record_id, '_') !== false) {
			$abid      = explode('_', $record_id);
			$record_id = $abid[count($abid) - 1];
		}
		$record_id = (int) $record_id;
		if ($record_id < 1)
			return false;
		static $path = null;
		if (!is_array($path)) {
			$path = $this->cache->get('record.seopath');
			if (!is_array($path))
				$path = array();
		}
		if (!isset($path[$record_id])) {
			$query            = $this->db->query("SELECT blog_id FROM " . DB_PREFIX . "record_to_blog WHERE record_id = '" . $record_id . "' ORDER BY blog_id DESC LIMIT 1");
			$path[$record_id] = $this->getPathByBlog($query->num_rows ? (int) $query->row['blog_id'] : 0);
			$this->load->model('catalog/blog');
			if (strpos($path[$record_id], '_') !== false) {
				$abid    = explode('_', $path[$record_id]);
				$blog_id = $abid[count($abid) - 1];
			} else {
				$blog_id = (int) $path[$record_id];
			}
			$blog_id   = (int) $blog_id;
			$blog_info = $this->model_catalog_blog->getBlog($blog_id);
			if (isset($blog_info['design']) && $blog_info['design'] != '') {
				$this->blog_design = unserialize($blog_info['design']);
			} else {
				$this->blog_design = Array();
			}
			if (isset($this->blog_design['blog_short_path']) && $this->blog_design['blog_short_path'] == 1)
				$path[$record_id] = '';
			$this->cache->set('record.seopath', $path);
		}
		return $path[$record_id];
	}
	private function getPathByBlog($blog_id)
	{
		if (strpos($blog_id, '_') !== false) {
			$abid    = explode('_', $blog_id);
			$blog_id = $abid[count($abid) - 1];
		}
		$blog_id = (int) $blog_id;
		if ($blog_id < 1)
			return false;
		static $path = null;
		$this->load->model('catalog/blog');
		$blog_info = $this->model_catalog_blog->getBlog($blog_id);
		if (isset($blog_info['design']) && $blog_info['design'] != '') {
			$this->blog_design = unserialize($blog_info['design']);
		} else {
			$this->blog_design = Array();
		}
		if (!is_array($path)) {
			$path = $this->cache->get('blog.seopath');
			if (!is_array($path))
				$path = array();
		}
		if (!isset($path[$blog_id])) {
			$max_level = 10;
			$sql       = "SELECT CONCAT_WS('_'";
			for ($i = $max_level - 1; $i >= 0; --$i) {
				$sql .= ",t$i.blog_id";
			}
			$sql .= ") AS path FROM " . DB_PREFIX . "blog t0";
			for ($i = 1; $i < $max_level; ++$i) {
				$sql .= " LEFT JOIN " . DB_PREFIX . "blog t$i ON (t$i.blog_id = t" . ($i - 1) . ".parent_id)";
			}
			$sql .= " WHERE t0.blog_id = '" . $blog_id . "'";
			$query          = $this->db->query($sql);
			$path[$blog_id] = $query->num_rows ? $query->row['path'] : false;
			$this->cache->set('blog.seopath', $path);
		}
		return $path[$blog_id];
	}
}
?>