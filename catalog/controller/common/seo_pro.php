<?php
class ControllerCommonSeoPro extends Controller {
	public function index() {
		// Add rewrite to url class
		if ($this->config->get('config_seo_url')) {
			$this->url->addRewrite($this);
		} else {
			return;
		}

		// Decode URL
		if (!isset($this->request->get['_route_'])) {
			$this->validate();
		} else {
			$route = $this->request->get['_route_'];
			unset($this->request->get['_route_']);
			$parts = explode('/', trim(utf8_strtolower($route), '/'));
			list($last_part) = explode('.', array_pop($parts));
			array_push($parts, $last_part);

			$keyword_in = array_map(array($this->db, 'escape'), $parts);
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE keyword IN ('" . implode("', '", $keyword_in) . "')");

			if ($query->num_rows == sizeof($parts)) {
				$queries = array();
				foreach ($query->rows as $row) {
					$queries[utf8_strtolower($row['keyword'])] = $row['query'];
				}

				reset($parts);
				foreach ($parts as $part) {
					$url = explode('=', $queries[$part], 2);

					if ($url[0] == 'category_id') {
                        if (!isset($this->request->get['path'])) {
                            $this->request->get['path'] = $url[1];
                        } else {
                            $this->request->get['path'] .= '_' . $url[1];
                        }
                    } else if ($url[0] == 'category_video_id') {
                        if (!isset($this->request->get['road'])) {
                            $this->request->get['road'] = $url[1];
                        } else {
                            $this->request->get['road'] .= '_' . $url[1];
                        }
					} else if ($url[0] == 'category_article_id') {
						if (!isset($this->request->get['category_article_id'])) {
							$this->request->get['category_article_id'] = $url[1];
						} else {
							$this->request->get['category_article_id'] .= '_' . $url[1];
						}
                    } else if ($url[0] == 'product/catalog') {
                        $this->request->get['catalog'] = $url[0];
                    } else if ($url[0] == 'product/special') {
                        $this->request->get['special'] = $url[0];
                    } else if ($url[0] == 'product/discount') {
                        $this->request->get['discount'] = $url[0];
                    } else if ($url[0] == 'information/contact') {
                        $this->request->get['contact'] = $url[0];
					} else if ($url[0] == 'information/sitemap') {
						$this->request->get['sitemap'] = $url[0];
					} else if ($url[0] == 'product/list') {
						$this->request->get['video'] = $url[0];
					} else if ($url[0] == 'checkout/cart') {
						$this->request->get['cart'] = $url[0];
					} else if ($url[0] == 'account/login') {
						$this->request->get['login'] = $url[0];
					} else if ($url[0] == 'account/register') {
						$this->request->get['register'] = $url[0];
					} else if ($url[0] == 'account/wishlist') {
						$this->request->get['wishlist'] = $url[0];
					} else if ($url[0] == 'product/compare') {
						$this->request->get['compare'] = $url[0];
					} else if ($url[0] == 'product/sale') {
						$this->request->get['sale'] = $url[0];
					} else if ($url[0] == 'information/list_category_article') {
						$this->request->get['list_category_article'] = $url[0];
					} else if (isset($url[1])) {
						$this->request->get[$url[0]] = $url[1];
					}
				}
			} else {
				$this->request->get['route'] = 'error/not_found';
			}

			if (isset($this->request->get['product_id'])) {
				$this->request->get['route'] = 'product/product';
				if (!isset($this->request->get['path'])) {
					$path = $this->getPathByProduct($this->request->get['product_id']);
					if ($path) $this->request->get['path'] = $path;
				}
			} elseif (isset($this->request->get['path'])) {
				$this->request->get['route'] = 'product/category';
            } elseif (isset($this->request->get['road'])) {
                $this->request->get['route'] = 'product/catvideo';
			} elseif (isset($this->request->get['category_article_id'])) {
				$this->request->get['route'] = 'information/category_article';
			} elseif (isset($this->request->get['manufacturer_id'])) {
				$this->request->get['route'] = 'product/manufacturer';
			} elseif (isset($this->request->get['information_id'])) {
				$this->request->get['route'] = 'information/information';
            } elseif (isset($this->request->get['catalog'])) {
                $this->request->get['route'] = 'product/catalog';
            } elseif (isset($this->request->get['special'])) {
                $this->request->get['route'] = 'product/special';
            } elseif (isset($this->request->get['discount'])) {
                $this->request->get['route'] = 'product/discount';
            }  elseif (isset($this->request->get['contact'])) {
                $this->request->get['route'] = 'information/contact';
            } elseif (isset($this->request->get['sitemap'])) {
				$this->request->get['route'] = 'information/sitemap';
			} elseif (isset($this->request->get['video'])) {
				$this->request->get['route'] = 'product/list';
			} elseif (isset($this->request->get['cart'])) {
				$this->request->get['route'] = 'checkout/cart';
			} elseif (isset($this->request->get['login'])) {
				$this->request->get['route'] = 'account/login';
			} elseif (isset($this->request->get['register'])) {
				$this->request->get['route'] = 'account/register';
			} elseif (isset($this->request->get['wishlist'])) {
				$this->request->get['route'] = 'account/wishlist';
			} elseif (isset($this->request->get['compare'])) {
				$this->request->get['route'] = 'product/compare';
			} elseif (isset($this->request->get['sale'])) {
				$this->request->get['route'] = 'product/sale';
			} elseif (isset($this->request->get['list_category_article'])) {
				$this->request->get['route'] = 'information/list_category_article';
			}

            $this->validate();

			if (isset($this->request->get['route'])) {
                return $this->forward($this->request->get['route']);
			}
		}
	}

	public function rewrite($link) {
		if (!$this->config->get('config_seo_url')) {
            return $link;
        }

		$seo_url = '';

		$component = parse_url(str_replace('&amp;', '&', $link));

		$data = array();
		parse_str($component['query'], $data);

		$route = $data['route'];
		unset($data['route']);

		switch ($route) {
            case 'product/category':
                if (isset($data['path'])) {
                    $category = explode('_', $data['path']);
                    $category = end($category);
                    $data['path'] = $this->getPathByCategory($category);
                    if (!$data['path']) {
                        return $link;
                    }
                }
                break;

			case 'product/product':
				if (isset($data['product_id'])) {
					if ($this->config->get('config_seo_url_include_path')) {
						$data['path'] = $this->getPathByProduct($data['product_id']);

                        if (!$data['path']) {
                            return $link;
                        }
					}

                    if (isset($tmp['tracking'])) {
						$data['tracking'] = $tmp['tracking'];
					}
				}
				break;

            case 'product/catvideo':
                if (isset($data['road'])) {
                    $category = explode('_', $data['road']);
                    $category = end($category);
                    $data['road'] = $this->getPathByCategoryVideo($category);

                    if (!$data['road']) {
                        return $link;
                    }
                }
                break;

			case 'information/category_article':
				if (isset($data['category_article_id'])) {
					$category = explode('_', $data['category_article_id']);
					$category = end($category);
					$data['category_article_id'] = $this->getPathByCategoryArticle($category);

					if (!$data['category_article_id']) {
						return $link;
					}
				}
				break;
            case 'product/catalog':
                $data['catalog'] = true;
                break;

            case 'product/discount':
                $data['discount'] = true;
                break;

            case 'information/contact':
                $data['contact'] = true;
                break;

            case 'product/special':
                $data['special'] = true;
                break;

			case 'product/list':
				$data['video'] = true;
				break;

			case 'information/sitemap':
				$data['sitemap'] = true;
				break;

			case 'checkout/cart':
				$data['cart'] = true;
				break;

			case 'account/login':
				$data['login'] = true;
				break;

			case 'account/register':
				$data['register'] = true;
				break;

			case 'account/wishlist':
				$data['wishlist'] = true;
				break;

			case 'product/compare':
				$data['compare'] = true;
				break;

			case 'product/sale':
				$data['sale'] = true;
				break;

			case 'information/list_category_article':
				$data['list_category_article'] = true;
				break;

			case 'product/product/review':
			case 'information/information/info':
				return $link;
				break;

			default:
				break;
		}

        if ($component['scheme'] == 'https') {
			$link = $this->config->get('config_ssl');
		} else {
			$link = $this->config->get('config_url');
		}

		$link .= 'index.php?route=' . $route;

		if (count($data)) {
            $link .= '&amp;' . urldecode(http_build_query($data, '', '&amp;'));
		}

		$queries = array();
		foreach ($data as $key => $value) {
			switch ($key) {
                case 'path':
                    $categories = explode('_', $value);

                    foreach ($categories as $category) {
                        $queries[] = 'category_id=' . $category;
                    }

                    unset($data[$key]);
                    break;

				case 'product_id':
				case 'manufacturer_id':
				case 'category_id':
				case 'information_id':
					$queries[] = $key . '=' . $value;
                    unset($data[$key]);
					break;

                case 'road':
                    $categories = explode('_', $value);

                    foreach ($categories as $category) {
                        $queries[] = 'category_video_id=' . $category;
                    }

                    unset($data[$key]);
                    break;

				case 'category_article_id':
					$categories = explode('_', $value);

					foreach ($categories as $category) {
						$queries[] = 'category_article_id=' . $category;
					}

					unset($data[$key]);
					break;

                case 'catalog':
                    $queries[] = 'product/catalog';

                    unset($data[$key]);
                    break;

                case 'special':
                    $queries[] = 'product/special';

                    unset($data[$key]);
                    break;

                case 'discount':
                    $queries[] = 'product/discount';

                    unset($data[$key]);
                    break;

                case 'contact':
                    $queries[] = 'information/contact';

                    unset($data[$key]);
                    break;

				case 'video':
					$queries[] = 'product/list';

					unset($data[$key]);
					break;

				case 'sitemap':
					$queries[] = 'information/sitemap';

					unset($data[$key]);
					break;

				case 'cart':
					$queries[] = 'checkout/cart';

					unset($data[$key]);
					break;

				case 'login':
					$queries[] = 'account/login';

					unset($data[$key]);
					break;

				case 'wishlist':
					$queries[] = 'account/wishlist';

					unset($data[$key]);
					break;

				case 'register':
					$queries[] = 'account/register';

					unset($data[$key]);
					break;

				case 'compare':
					$queries[] = 'product/compare';

					unset($data[$key]);
					break;

				case 'sale':
					$queries[] = 'product/sale';

					unset($data[$key]);
					break;

				case 'list_category_article':
					$queries[] = 'information/list_category_article';

					unset($data[$key]);
					break;

				default:
                    break;
			}
		}

		if (!empty($queries)) {
			$query_in = array_map(array($this->db, 'escape'), $queries);
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE `query` IN ('" . implode("', '", $query_in) . "')");

			if ($query->num_rows == count($queries)) {
				$aliases = array();
				foreach ($query->rows as $row) {
					$aliases[$row['query']] = $row['keyword'];
				}

				foreach ($queries as $query) {
					$seo_url .= '/' . rawurlencode($aliases[$query]);
                }
			}
        }

		if ($seo_url == '') {
            $link = str_replace('&amp;', '&', $link);
            $link = str_replace('index.php?route=common/home', '', $link);
            return $link;
        }

        $seo_url = trim($seo_url, '/');

		if ($component['scheme'] == 'https') {
			$seo_url = $this->config->get('config_ssl') . $seo_url;
		} else {
			$seo_url = $this->config->get('config_url') . $seo_url;
		}

        if (isset($postfix)) {
			$seo_url .= trim($this->config->get('config_seo_url_postfix'));
        } else {
			$seo_url .= '/';
		}

        if (count($data)) {
			$seo_url .= '?' . urldecode(http_build_query($data, '', '&amp;'));
		}

        return $seo_url;
	}

	private function getPathByProduct($product_id) {
		$product_id = (int)$product_id;
		if ($product_id < 1) return false;

		static $path = null;
		if (!is_array($path)) {
			$path = $this->cache->get('product.seopath');
			if (!is_array($path)) $path = array();
		}

		if (!isset($path[$product_id])) {
			$query = $this->db->query("SELECT category_id FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . $product_id . "' ORDER BY main_category DESC LIMIT 1");

			$path[$product_id] = $this->getPathByCategory($query->num_rows ? (int)$query->row['category_id'] : 0);

			$this->cache->set('product.seopath', $path);
		}

		return $path[$product_id];
	}

	private function getPathByCategory($category_id) {
		$category_id = (int)$category_id;
		if ($category_id < 1) return false;

		static $path = null;
		if (!is_array($path)) {
			$path = $this->cache->get('category.seopath');
			if (!is_array($path)) $path = array();
		}

		if (!isset($path[$category_id])) {
			$max_level = 10;

			$sql = "SELECT CONCAT_WS('_'";
			for ($i = $max_level-1; $i >= 0; --$i) {
				$sql .= ",t$i.category_id";
			}
			$sql .= ") AS path FROM " . DB_PREFIX . "category t0";
			for ($i = 1; $i < $max_level; ++$i) {
				$sql .= " LEFT JOIN " . DB_PREFIX . "category t$i ON (t$i.category_id = t" . ($i-1) . ".parent_id)";
			}
			$sql .= " WHERE t0.category_id = '" . $category_id . "'";

			$query = $this->db->query($sql);

			$path[$category_id] = $query->num_rows ? $query->row['path'] : false;

			$this->cache->set('category.seopath', $path);
		}

		return $path[$category_id];
	}

    private function getPathByCategoryVideo($category_id) {
        $category_id = (int)$category_id;
        if ($category_id < 1) return false;

        static $road = null;

        if (!is_array($road)) {
            $road = $this->cache->get('category.video.seopath');

            if (!is_array($road)) {
                $road = array();
            }
        }

        if (!isset($road[$category_id])) {
            $max_level = 10;

            $sql = "SELECT CONCAT_WS('_'";
            for ($i = $max_level-1; $i >= 0; --$i) {
                $sql .= ",t$i.category_video_id";
            }
            $sql .= ") AS road FROM " . DB_PREFIX . "category_video t0";
            for ($i = 1; $i < $max_level; ++$i) {
                $sql .= " LEFT JOIN " . DB_PREFIX . "category_video t$i ON (t$i.category_video_id = t" . ($i-1) . ".category_video_parent_id)";
            }
            $sql .= " WHERE t0.category_video_id = '" . $category_id . "'";

            $query = $this->db->query($sql);

            $road[$category_id] = $query->num_rows ? $query->row['road'] : false;

            $this->cache->set('category.seopath', $road);
        }

        return $road[$category_id];
    }

	private function getPathByCategoryArticle($category_id) {
		$category_id = (int)$category_id;
		if ($category_id < 1) return false;

		static $road = null;

		if (!is_array($road)) {
			$road = $this->cache->get('category.article.seopath');

			if (!is_array($road)) {
				$road = array();
			}
		}

		if (!isset($road[$category_id])) {
			$max_level = 10;

			$sql = "SELECT CONCAT_WS('_'";
			for ($i = $max_level-1; $i >= 0; --$i) {
				$sql .= ",t$i.category_article_id";
			}
			$sql .= ") AS road FROM " . DB_PREFIX . "category_article t0";
			for ($i = 1; $i < $max_level; ++$i) {
				$sql .= " LEFT JOIN " . DB_PREFIX . "category_article t$i ON (t$i.category_article_id = t" . ($i-1) . ".category_article_parent_id)";
			}
			$sql .= " WHERE t0.category_article_id = '" . $category_id . "'";

			$query = $this->db->query($sql);

			$road[$category_id] = $query->num_rows ? $query->row['road'] : false;

			$this->cache->set('category.article.seopath', $road);
		}

		return $road[$category_id];
	}

	private function validate() {
		if (empty($this->request->get['route']) || $this->request->get['route'] == 'error/not_found') {
			return;
		}

		if (isset($this->request->server['HTTP_X_REQUESTED_WITH']) && strtolower($this->request->server['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			return;
		}

		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$url = str_replace('&amp;', '&', $this->config->get('config_ssl') . ltrim($this->request->server['REQUEST_URI'], '/'));
			$seo = str_replace('&amp;', '&', $this->url->link($this->request->get['route'], $this->getQueryString(array('route')), 'SSL'));
		} else {
			$url = str_replace('&amp;', '&', $this->config->get('config_url') . ltrim($this->request->server['REQUEST_URI'], '/'));
			$seo = str_replace('&amp;', '&', $this->url->link($this->request->get['route'], $this->getQueryString(array('route')), 'NONSSL'));
		}

		if (rawurldecode($url) != rawurldecode($seo)) {
			header($this->request->server['SERVER_PROTOCOL'] . ' 301 Moved Permanently');

			$this->response->redirect($seo);
		}
	}

	private function getQueryString($exclude = array()) {
		if (!is_array($exclude)) {
			$exclude = array();
		}

		return urldecode(http_build_query(array_diff_key($this->request->get, array_flip($exclude))));
	}
}
?>