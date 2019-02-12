<?php
class ModelCatalogSeoBlog extends Controller {
	public function index() {
		// Add rewrite to url class
		if ($this->config->get('config_seo_url')) {
			$this->url->addRewrite($this);
		}
 		// Decode URL
		if (isset($this->request->get['_route_'])) {
			$parts = explode('/', $this->request->get['_route_']);

			foreach ($parts as $part) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE keyword = '" . $this->db->escape($part) . "'");

				if ($query->num_rows) {
					$url = explode('=', $query->row['query']);


					if ($url[0] == 'record_id') {
						$this->request->get['record_id'] = $url[1];
					}

					if ($url[0] == 'blog_id') {
						if (!isset($this->request->get['blog_id'])) {
							$this->request->get['blog_id'] = $url[1];
						} else {
							$this->request->get['blog_id'] .= '_' . $url[1];
						}
					}

				} else {
					$this->request->get['route'] = 'error/not_found';
				}
			}


			if (isset($this->request->get['record_id'])) {
				$this->request->get['route'] = 'record/record';
			} elseif (isset($this->request->get['blog_id'])) {
				$this->request->get['route'] = 'record/blog';
			}

			if (isset($this->request->get['route'])) {
				return $this->forward($this->request->get['route']);
			}
		}
	}

	public function rewrite($link) {
		if ($this->config->get('config_seo_url')) {
			$url_data = parse_url(str_replace('&amp;', '&', $link));

			$url = '';

			$data = array();

			if (isset($url_data['query'])) {

			parse_str($url_data['query'], $data);

			foreach ($data as $key => $value) {
				if (isset($data['route']))
				{
					if (($data['route'] == 'record/record' && $key == 'record_id') )
					{
						$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE `query` = '" . $this->db->escape($key . '=' . (int)$value) . "'");

						if ($query->num_rows) {
							$url .= '/' . $query->row['keyword'];

							unset($data[$key]);
						}
					} elseif ($key == 'blog_id') {
						$categories = explode('_', $value);

						foreach ($categories as $category) {
							$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE `query` = 'blog_id=" . (int)$category . "'");

							if ($query->num_rows) {
								$url .= '/' . $query->row['keyword'];
							}
						}

						unset($data[$key]);
					}




				}







			}
            }
			if ($url) {				//echo $url."<br>";
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

				return $url_data['scheme'] . '://' . $url_data['host'] . (isset($url_data['port']) ? ':' . $url_data['port'] : '') . str_replace('/index.php', '', $url_data['path']) . $url . $query;
			} else {
				return $link;
			}
		} else {
			return $link;
		}
	}
}
?>