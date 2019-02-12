<?php
class ModelCatalogProduct extends Model {
	public function updateViewed($product_id) {
		$sql = "UPDATE " . DB_PREFIX . "product SET viewed = (viewed + 1) WHERE product_id = '%d'";
		$this->db->query(sprintf($sql, (int)$product_id));
	}
	
	public function getProduct($product_id) {
		if ($this->customer->isLogged()) {
			$customer_group_id = $this->customer->getCustomerGroupId();
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}

		$cache_key = 'product.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . (int)$customer_group_id . '.' . (int)$product_id;
		$data_product = $this->cache->get($cache_key);

		if ( $data_product === false ) {
			$args = array(
				(int)$customer_group_id, 
				'0000-00-00',
				'0000-00-00',
				(int)$customer_group_id,
				'0000-00-00',
				'0000-00-00',
				(int)$customer_group_id,
				(int)$this->config->get('config_language_id'),
				(int)$this->config->get('config_language_id'),
				(int)$this->config->get('config_language_id'),
				1,
				1,
				(int)$product_id,
				(int)$this->config->get('config_language_id'),
				1,
				(int)$this->config->get('config_store_id')
			);
			
			$sql = "SELECT DISTINCT *, pd.name AS name, p.image, m.name AS manufacturer, pr_af.name AS price_after_name, pr_pr.name AS price_prefix_name, p.price as price, p.product_id as product_id,
				(SELECT price FROM " . DB_PREFIX . "product_discount pd2 WHERE pd2.product_id = p.product_id AND pd2.customer_group_id = '%d' AND ((pd2.date_start = '%s' OR pd2.date_start < NOW()) AND (pd2.date_end = '%s' OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1) AS discount,
				(SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '%d' AND ((ps.date_start = '%s' OR ps.date_start < NOW()) AND (ps.date_end = '%s' OR ps.date_end > NOW())) ORDER BY ps.product_special_id DESC LIMIT 1) AS special, 
				(SELECT points FROM " . DB_PREFIX . "product_reward pr WHERE pr.product_id = p.product_id AND customer_group_id = '%d') AS reward, 
				(SELECT ss.name FROM " . DB_PREFIX . "stock_status ss WHERE ss.stock_status_id = p.stock_status_id AND ss.language_id = '%d') AS stock_status,
				(SELECT wcd.unit FROM " . DB_PREFIX . "weight_class_description wcd WHERE p.weight_class_id = wcd.weight_class_id AND wcd.language_id = '%d') AS weight_class, 
				(SELECT lcd.unit FROM " . DB_PREFIX . "length_class_description lcd WHERE p.length_class_id = lcd.length_class_id AND lcd.language_id = '%d') AS length_class, 
				(SELECT AVG(rating) AS total FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = p.product_id AND r1.status = '%d' GROUP BY r1.product_id) AS rating, 
				(SELECT COUNT(*) AS total FROM " . DB_PREFIX . "review r2 WHERE r2.product_id = p.product_id AND r2.status = '%d' GROUP BY r2.product_id) AS reviews, p.sort_order
                FROM " . DB_PREFIX . "product p
				LEFT JOIN " . DB_PREFIX . "product_description pd ON(p.product_id = pd.product_id)
				LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON(p.product_id = p2s.product_id) 
				LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id)
                LEFT JOIN " . DB_PREFIX . "currency cur ON (m.currency_id = cur.currency_id)
                LEFT JOIN " . DB_PREFIX . "price_after pr_af ON (p.price_after_id = pr_af.price_after_id)
                LEFT JOIN " . DB_PREFIX . "price_prefix pr_pr ON (p.price_prefix_id = pr_pr.price_prefix_id)
                WHERE p.product_id = '%d' AND pd.language_id = '%d' AND p.status = '%d' AND p.date_available <= NOW() AND p2s.store_id = '%d'";

			$query = $this->db->query(vsprintf($sql, $args));

			if ($query->num_rows) {
				$query->row['reviews']	= $query->row['reviews'] ? $query->row['reviews'] : 0;
				$query->row['rating']	= round($query->row['rating']);
				$data_product = $query->row;
			} else {
				$data_product = false;
			}

			$this->cache->set($cache_key, $data_product);
		}

		return $data_product;
	}
	
	public function getProductSpecial($product_id) {
		if ($this->customer->isLogged()) {
			$customer_group_id = $this->customer->getCustomerGroupId();
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}

		$sql = "SELECT * FROM " . DB_PREFIX . "product_special ps WHERE product_id = '%d'  AND ps.customer_group_id = '%d' AND ((ps.date_start = '%s' OR ps.date_start < NOW()) AND (ps.date_end = '%s' OR ps.date_end > NOW())) ORDER BY ps.product_special_id DESC";
		$query = $this->db->query(sprintf($sql, (int)$product_id, (int)$customer_group_id, '0000-00-00', '0000-00-00'));
		return $query->row;
	}

	public function getProducts($data = array(), $filter = 0) {
		$this->load->model('catalog/category');

		if ($this->customer->isLogged()) {
			$customer_group_id = $this->customer->getCustomerGroupId();
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}
		
		$cache = md5(http_build_query($data));
		$cache_key = 'products.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . (int)$customer_group_id . '.' . $cache . '.' . $filter;
		$product_data = $this->cache->get($cache_key);
		
		if ( $product_data === false ) {
			if (isset($data['products']) == false) {
				$property_data = array();

				if (isset($data["sort"]) && $data["sort"] == "rating") {
					$property_data[] = 1;
				}
				
				if (isset($data["filter_special"]) && $data["filter_special"] == "special") {
					$property_data[] = (int)$customer_group_id;
					$property_data[] = '0000-00-00';
					$property_data[] = '0000-00-00';
					$property_data[] = (int)$customer_group_id;
					$property_data[] = '0000-00-00';
					$property_data[] = '0000-00-00';
				}

				if (isset($data['innertable']) && $data['innertable'] == true) {
					$property_data[] = (int)$customer_group_id;
					$property_data[] = '0000-00-00';
					$property_data[] = '0000-00-00';
					$property_data[] = (int)$customer_group_id;
					$property_data[] = '0000-00-00';
					$property_data[] = '0000-00-00';
				}

				$property_data[] = (int)$this->config->get('config_language_id');
				$property_data[] = 1;
				$property_data[] = (int)$this->config->get('config_store_id');

				$sql = '';

				if (isset($data['innertable']) && $data['innertable'] == true) {
					$sql .= "SELECT product_id FROM (";
				}
				
				$sql .= "SELECT DISTINCT p.product_id, pd.name as pd_name, p.model, p.price, p.sort_order, p.date_added, p.quantity, p.viewed ";

				if (isset($data['bestseller']) && $data['bestseller'] == true) {
					$sql .= ", o.date_added as order_date_added";
				}

				if (isset($data["sort"]) && $data["sort"] == "rating") {
					$sql .= ", (SELECT AVG(rating) AS total FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = p.product_id AND r1.status = '%d' GROUP BY r1.product_id) AS rating ";
				}

				if (isset($data["filter_special"]) && $data["filter_special"] == "special") {
					$sql .= ", (SELECT price FROM " . DB_PREFIX . "product_discount pd2 WHERE pd2.product_id = p.product_id AND pd2.customer_group_id = '%d' AND ((pd2.date_start = '%s' OR pd2.date_start < NOW()) AND (pd2.date_end = '%s' OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1) AS discount, ";
					$sql .= " (SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '%d' AND ((ps.date_start = '%s' OR ps.date_start < NOW()) AND (ps.date_end = '%s' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special ";
				}

				if (isset($data['innertable']) && $data['innertable'] == true) {
					$sql .= ", coalesce((SELECT price FROM " . DB_PREFIX . "product_discount pd2 WHERE pd2.product_id = p.product_id AND pd2.customer_group_id = '%d' AND ((pd2.date_start = '%s' OR pd2.date_start < NOW()) AND (pd2.date_end = '%s' OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1),
						(SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '%d' AND ((ps.date_start = '%s' OR ps.date_start < NOW()) AND (ps.date_end = '%s' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1), 
						p.price
						) as realprice ";
				}

				$sql .= " FROM " . DB_PREFIX . "product p ";
				
				if (isset($data['bestseller']) && $data['bestseller'] == true) {
					$sql .= " LEFT JOIN " . DB_PREFIX . "order_product op ON (op.product_id = p.product_id) LEFT JOIN `" . DB_PREFIX . "order` o ON (op.order_id = o.order_id)"; 
				}

				if (isset($data['special']) && $data['special'] == true) {
					$sql .= " LEFT JOIN " . DB_PREFIX . "product_special ps ON(ps.product_id = p.product_id) ";
				}

                if (isset($data['discount']) && $data['discount'] == true) {
                    $sql .= " LEFT JOIN " . DB_PREFIX . "product_discount pd2 ON(pd2.product_id = p.product_id) ";
                }

                if (isset($data['filter_name']) && !empty($data['filter_name'])) {
                    $sql .= 'LEFT JOIN ' . DB_PREFIX . 'product_option_value AS pov ON pov.product_id = p.product_id ';
                    $sql .= 'LEFT JOIN ' . DB_PREFIX . 'option_value_description AS ovd ON pov.option_value_id = ovd.option_value_id ';
                }

				$sql .= " LEFT JOIN " . DB_PREFIX . "product_description pd ON(p.product_id = pd.product_id)
				LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON(p.product_id = p2s.product_id)"; 
				
				if (isset($data['filter_tag']) && !empty($data['filter_tag'])) {
					$sql .= " LEFT JOIN " . DB_PREFIX . "product_tag pt ON(p.product_id = pt.product_id)";			
				}
				
				if (isset($data['filter_category_id']) && $data['filter_category_id'] != null) {
					$sql .= " LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON(p.product_id = p2c.product_id)";			
				}
				
				$sql .= " WHERE pd.language_id = '%d' AND p.status = '%d' AND p.date_available <= NOW() AND p2s.store_id = '%d'";

				if (isset($data['bestseller']) && $data['bestseller'] == true) {
					$property_data[] = 0;
					$sql .= " AND o.order_status_id > '%d' "; 
				}

				$innertable = false;

				if (isset($data['innertable'])) {
					$innertable = $data['innertable'];
				}

				$data_query = $this->filterSearch($data, $filter, $innertable);
				$sql .= " " . $data_query['sql'];
				
				$property_data = array_merge($property_data, $data_query['values']);

				$sort_data = array(
					'pd.name'		=> 'pd_name',
					'p.model' 		=> 'model',
					'p.quantity' 	=> 'quantity',
					'p.price' 		=> 'realprice',
					'p.sort_order'	=> 'sort_order',
					'p.date_added' 	=> 'date_added',
					'p.viewed'		=> 'viewed',
					'special'		=> 'special',
					'rating' 		=> 'rating',
					'o.date_added'	=> 'order_date_added'
				);
				
				$sql .= " ORDER BY ";
				
				if (isset($data['filter_special']) && $data['filter_special'] == 'special') {
					$sql .= " (CASE WHEN special IS NOT NULL THEN special WHEN discount IS NOT NULL THEN discount END) DESC, ";
				}
				
				if (isset($data['sort']) && array_key_exists($data['sort'], $sort_data)) {
					$data['sort'] = $sort_data[$data['sort']];

					if ($data['sort'] == 'pd_name' || $data['sort'] == 'model') {
						$sql .= " LCASE(" . $data['sort'] . ")";
					} else {
						$sql .= $data['sort'];
					}
				} else {
					$sql .= " sort_order";
				}

				if (isset($data['order']) && ($data['order'] == 'DESC')) {
					$sql .= " DESC, LCASE(pd_name) DESC";
				} else {
					$sql .= " ASC, LCASE(pd_name) ASC";
				}

				if (isset($data['start']) || isset($data['limit'])) {
					if ($data['start'] < 0) {
						$data['start'] = 0;
					}

					if ($data['limit'] < 1) {
						$data['limit'] = 20;
					}

					$property_data[] = (int)$data['start'];
					$property_data[] = (int)$data['limit'];
					$sql .= " LIMIT %d, %d";
				}

				$query = $this->db->query(vsprintf($sql, $property_data));
                $products = $query->rows;
			} else {
				$products = array();

				foreach ($data['products'] as $product_id) {
					$products[]['product_id'] = $product_id;
				}
			}

			$product_data = array();

			foreach ($products as $product) {
                $product_data[$product['product_id']] = $this->getProduct($product['product_id']);
			}

			$this->cache->set($cache_key, $product_data);
		}

		return $product_data;
	}
	
	public function getTotalProducts($data = array(), $filter = 0) {
		if ($this->customer->isLogged()) {
			$customer_group_id = $this->customer->getCustomerGroupId();
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}

		$cache = md5(http_build_query($data));
		$cache_key = 'product.prod_decs.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $cache . '.' . $filter . '' . $customer_group_id;
		$total = $this->cache->get($cache_key);
		
		if ( $total === false ) {
			$this->load->model('catalog/category');
			$property_data = array();
			$property_data[] = (int)$customer_group_id;
			$property_data[] = '0000-00-00';
			$property_data[] = '0000-00-00';
			$property_data[] = (int)$customer_group_id;
			$property_data[] = '0000-00-00';
			$property_data[] = '0000-00-00';
            $sql = '';

			$sql = " SELECT COUNT(*) AS total FROM
				(SELECT DISTINCT p.product_id,
				coalesce((SELECT price FROM " . DB_PREFIX . "product_discount pd2 WHERE pd2.product_id = p.product_id AND pd2.customer_group_id = '%d' AND ((pd2.date_start = '%s' OR pd2.date_start < NOW()) AND (pd2.date_end = '%s' OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1),
						(SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '%d' AND ((ps.date_start = '%s' OR ps.date_start < NOW()) AND (ps.date_end = '%s' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1),
						p.price
				) as realprice ";
			$sql .= " FROM " . DB_PREFIX . "product p ";

			if (isset($data['special']) && $data['special'] == true) {
				$sql .= " LEFT JOIN " . DB_PREFIX . "product_special ps ON(ps.product_id = p.product_id) ";
			}

            if (isset($data['discount']) && $data['discount'] == true) {
                $sql .= " LEFT JOIN " . DB_PREFIX . "product_discount pd2 ON(pd2.product_id = p.product_id) ";
            }

            if (isset($data['filter_name']) && !empty($data['filter_name'])) {
                $sql .= 'LEFT JOIN ' . DB_PREFIX . 'product_option_value AS pov ON pov.product_id = p.product_id ';
                $sql .= 'LEFT JOIN ' . DB_PREFIX . 'option_value_description AS ovd ON pov.option_value_id = ovd.option_value_id ';
            }

			$sql .= "LEFT JOIN " . DB_PREFIX . "product_description pd ON(p.product_id = pd.product_id)
				LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON(p.product_id = p2s.product_id)";

			if (isset($data['filter_category_id']) && $data['filter_category_id'] != null) {
				$sql .= " LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON(p.product_id = p2c.product_id)";
			}

			if (isset($data['filter_tag']) && !empty($data['filter_tag'])) {
				$sql .= " LEFT JOIN " . DB_PREFIX . "product_tag pt ON(p.product_id = pt.product_id)";
			}

			$sql .= " WHERE pd.language_id = '%d' AND p.status = '%d' AND p.date_available <= NOW() AND p2s.store_id = '%d'";
			$property_data[] = (int)$this->config->get('config_language_id');
			$property_data[] = 1;
			$property_data[] = (int)$this->config->get('config_store_id');

			$innertable = false;

			if (isset($data['innertable'])) {
				$innertable = $data['innertable'];
			}

			$data_query = $this->filterSearch($data, $filter, $innertable);
			$sql .= " " . $data_query['sql'];

			$property_data = array_merge($property_data, $data_query['values']);
            $query = $this->db->query(vsprintf($sql, $property_data));
			$total = $query->row['total'];
			$this->cache->set($cache_key, $total);
		}

		return $total;
	}

	public function getProductSpecials($data = array()) {
		if ($this->customer->isLogged()) {
			$customer_group_id = $this->customer->getCustomerGroupId();
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}

		$cache = md5(http_build_query($data));
		$cache_key = 'product.specials.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . (int)$customer_group_id . '.' . $cache;
		$product_data = $this->cache->get($cache_key);
		
		if ( $product_data === false ) {
			$args = array(1, 1, (int)$this->config->get('config_store_id'), (int)$customer_group_id, '0000-00-00', '0000-00-00');
			$sql = "SELECT DISTINCT ps.product_id, pr_af.name AS price_after_name, pr_pr.name AS price_prefix_name,
			(SELECT AVG(rating) FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = ps.product_id AND r1.status = '%d' GROUP BY r1.product_id) AS rating 
			FROM " . DB_PREFIX . "product_special ps 
			LEFT JOIN " . DB_PREFIX . "product p ON (ps.product_id = p.product_id) 
			LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) 
			LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) 
			LEFT JOIN " . DB_PREFIX . "price_after pr_af ON (p.price_after_id = pr_af.price_after_id) 
			LEFT JOIN " . DB_PREFIX . "price_prefix pr_pr ON (p.price_prefix_id = pr_pr.price_prefix_id) 
			WHERE p.status = '%d' 
			AND p.date_available <= NOW() 
			AND p2s.store_id = '%d' 
			AND ps.customer_group_id = '%d' 
			AND ((ps.date_start = '%s' OR ps.date_start < NOW()) 
			AND (ps.date_end = '%s' OR ps.date_end > NOW())) GROUP BY ps.product_id";

			$sort_data = array(
				'pd.name',
				'p.model',
				'ps.price',
				'rating',
				'p.sort_order'
			);
			
			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$args[] = $data['sort'];

				if ($data['sort'] == 'pd.name' || $data['sort'] == 'p.model') {
					$sql .= " ORDER BY LCASE('%s')";
				} else {
					$sql .= " ORDER BY '%s'";
				}
			} else {
				$sql .= " ORDER BY p.sort_order";	
			}
			
			if (isset($data['order']) && ($data['order'] == 'DESC')) {
				$sql .= " DESC, LCASE(pd.name) DESC";
			} else {
				$sql .= " ASC, LCASE(pd.name) ASC";
			}
		
			if (isset($data['start']) || isset($data['limit'])) {
				if ($data['start'] < 0) {
					$data['start'] = 0;
				}				

				if ($data['limit'] < 1) {
					$data['limit'] = 20;
				}	
				
				$args[] = (int)$data['start'];
				$args[] = (int)$data['limit'];
				$sql .= " LIMIT %d, %d";
			}

			$query = $this->db->query(vsprintf($sql, $args));
			$product_data = array();
			
			foreach ($query->rows as $result) {
				$product_data[$result['product_id']] = $this->getProduct($result['product_id']);
			}

			$this->cache->set($cache_key, $product_data);
		}

		return $product_data;
	}
		
	public function getLatestProducts($limit) {
		if ($this->customer->isLogged()) {
			$customer_group_id = $this->customer->getCustomerGroupId();
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}	
		
		$cache_key = 'product.latest.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $customer_group_id . '.' . (int)$limit;
		$product_data = $this->cache->get($cache_key);
		
		if ($product_data === false) {
			$args = array(1, (int)$this->config->get('config_store_id'), (int)$limit);
			$sql = "SELECT p.product_id FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p.status = '%d' AND p.date_available <= NOW() AND p2s.store_id = '%d' ORDER BY p.date_added DESC LIMIT %d";
			$query = $this->db->query(vsprintf($sql, $args));
		 	
			foreach ($query->rows as $result) {
				$product_data[$result['product_id']] = $this->getProduct($result['product_id']);
			}
			
			$this->cache->set($cache_key, $product_data);
		}
		
		return $product_data;
	}
	
	public function getPopularProducts($limit) {
		$cache_key = 'product.popular.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . (int)$limit;
		$product_data = $this->cache->get($cache_key);

		if ($product_data === false) {
			$product_data = array();
			
			$args = array(1, (int)$this->config->get('config_store_id'), (int)$limit);			
			$sql = "SELECT p.product_id FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p.status = '%d' AND p.date_available <= NOW() AND p2s.store_id = '%d' ORDER BY p.viewed, p.date_added DESC LIMIT %d";
			$query = $this->db->query(vsprintf($sql, $args));
			
			foreach ($query->rows as $result) { 		
				$product_data[$result['product_id']] = $this->getProduct($result['product_id']);
			}

			$this->cache->set($cache_key, $product_data);
		}

		return $product_data;
	}

	public function getBestSellerProducts($limit) {
		if ($this->customer->isLogged()) {
			$customer_group_id = $this->customer->getCustomerGroupId();
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}	
		
		$cache_key = 'product.bestseller.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id'). '.' . $customer_group_id . '.' . (int)$limit;
		$product_data = $this->cache->get($cache_key);

		if ($product_data === false) {
			$product_data = array();
			
			$args = array(0, 1, (int)$this->config->get('config_store_id'), (int)$limit);
			$sql = "SELECT op.product_id, COUNT(*) AS total, pr_af.name AS price_after_name, pr_pr.name AS price_prefix_name
				FROM " . DB_PREFIX . "order_product op 
				LEFT JOIN `" . DB_PREFIX . "order` o ON (op.order_id = o.order_id) 
				LEFT JOIN `" . DB_PREFIX . "product` p ON (op.product_id = p.product_id) 
				LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) 
				LEFT JOIN " . DB_PREFIX . "price_after pr_af ON (p.price_after_id = pr_af.price_after_id) 
				LEFT JOIN " . DB_PREFIX . "price_prefix pr_pr ON (p.price_prefix_id = pr_pr.price_prefix_id) 
				WHERE o.order_status_id > '%d' 
				AND p.status = '%d' 
				AND p.date_available <= NOW() 
				AND p2s.store_id = '%d' GROUP BY op.product_id ORDER BY total DESC LIMIT %d";
			$query = $this->db->query(vsprintf($sql, $args));

			foreach ($query->rows as $result) { 		
				$product_data[$result['product_id']] = $this->getProduct($result['product_id']);
			}
			
			$this->cache->set($cache_key, $product_data);
		}
		
		return $product_data;
	}
	
	public function getProductAttributes($product_id) {
		$cache_key = 'product.attributes.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . (int)$product_id;
		$product_attribute_group_data = $this->cache->get($cache_key);

		if ($product_attribute_group_data === false) {
			$product_attribute_group_data = array();
			
			$args = array((int)$product_id, (int)$this->config->get('config_language_id'));
			$sql = "SELECT ag.attribute_group_id, agd.name FROM " . DB_PREFIX . "product_attribute pa LEFT JOIN " . DB_PREFIX . "attribute a ON (pa.attribute_id = a.attribute_id) LEFT JOIN " . DB_PREFIX . "attribute_group ag ON (a.attribute_group_id = ag.attribute_group_id) LEFT JOIN " . DB_PREFIX . "attribute_group_description agd ON (ag.attribute_group_id = agd.attribute_group_id) WHERE pa.product_id = '%d' AND agd.language_id = '%d' GROUP BY ag.attribute_group_id ORDER BY ag.sort_order, agd.name";
			$product_attribute_group_query = $this->db->query(vsprintf($sql, $args));
			
			foreach ($product_attribute_group_query->rows as $product_attribute_group) {
				$product_attribute_data = array();
				
				$args = array((int)$product_id, (int)$product_attribute_group['attribute_group_id'], (int)$this->config->get('config_language_id'), (int)$this->config->get('config_language_id'));
				$sql = "SELECT a.attribute_id, ad.name, pa.text FROM " . DB_PREFIX . "product_attribute pa LEFT JOIN " . DB_PREFIX . "attribute a ON (pa.attribute_id = a.attribute_id) LEFT JOIN " . DB_PREFIX . "attribute_description ad ON (a.attribute_id = ad.attribute_id) WHERE pa.product_id = '%d' AND a.attribute_group_id = '%d' AND ad.language_id = '%d' AND pa.language_id = '%d' ORDER BY a.sort_order, ad.name";
				$product_attribute_query = $this->db->query(vsprintf($sql, $args));
				
				foreach ($product_attribute_query->rows as $product_attribute) {
					$product_attribute_data[] = array(
						'attribute_id' => $product_attribute['attribute_id'],
						'name'         => $product_attribute['name'],
						'text'         => $product_attribute['text']		 	
					);
				}
				
				$product_attribute_group_data[] = array(
					'attribute_group_id' => $product_attribute_group['attribute_group_id'],
					'name'               => $product_attribute_group['name'],
					'attribute'          => $product_attribute_data
				);			
			}

			$this->cache->set($cache_key, $product_attribute_group_data);
		}

		return $product_attribute_group_data;
	}
	
    public function getProductOptions($product_id) {
    	$cache_key = 'product.options.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . (int)$product_id;
		$product_option_data = $this->cache->get($cache_key);
		
		if ($product_option_data === false) {
			$product_option_data = array();

			$args = array((int)$product_id, (int)$this->config->get('config_language_id'));
			$sql = "SELECT * FROM " . DB_PREFIX . "product_option po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id) WHERE po.product_id = '%d' AND od.language_id = '%d' ORDER BY o.sort_order";
			$product_option_query = $this->db->query(vsprintf($sql, $args));
			
			foreach ($product_option_query->rows as $product_option) {
				if ( $product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {
					$product_option_value_data = array();
					
					$args = array((int)$product_id, (int)$product_option['product_option_id'], (int)$this->config->get('config_language_id'));
					$sql = "SELECT * FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_id = '%d' AND pov.product_option_id = '%d' AND ovd.language_id = '%d' ORDER BY pov.product_sort_order, ov.sort_order";
					$product_option_value_query = $this->db->query(vsprintf($sql, $args));
					
					foreach ($product_option_value_query->rows as $product_option_value) {
						$product_option_value_data[] = array(
							'product_option_value_id' => $product_option_value['product_option_value_id'],
							'option_value_id'         => $product_option_value['option_value_id'],
							'name'                    => $product_option_value['name'],
							'image'                   => $product_option_value['image'],
							'quantity'                => $product_option_value['quantity'],
							'subtract'                => $product_option_value['subtract'],
							'price'                   => $product_option_value['price'],
							'price_prefix'            => $product_option_value['price_prefix'],
							'weight'                  => $product_option_value['weight'],
							'weight_prefix'           => $product_option_value['weight_prefix'],
							'sort_order'              => $product_option_value['product_sort_order']
						);
					}
										
					$product_option_data[] = array(
						'product_option_id' => $product_option['product_option_id'],
						'option_id'         => $product_option['option_id'],
						'name'              => $product_option['name'],
						'type'              => $product_option['type'],
						'option_value'      => $product_option_value_data,
						'required'          => $product_option['required'],
						'append_fabric'    => $product_option['append_fabric']
					);
				} else {
					$product_option_data[] = array(
						'product_option_id' => $product_option['product_option_id'],
						'option_id'         => $product_option['option_id'],
						'name'              => $product_option['name'],
						'type'              => $product_option['type'],
						'option_value'      => $product_option['option_value'],
						'required'          => $product_option['required'],
						'append_fabric'    => $product_option['append_fabric']
					);				
				}
	      	}

			$this->cache->set($cache_key, $product_option_data);
		}

		return $product_option_data;
	}
	
	public function getProductDiscounts($product_id) {
		if ($this->customer->isLogged()) {
			$customer_group_id = $this->customer->getCustomerGroupId();
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}	
		
		$cache_key = 'product.discounts.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $customer_group_id . '.' . (int)$product_id;
		$discounts = $this->cache->get($cache_key);

		if ($discounts === false) {
			$args = array((int)$product_id, (int)$customer_group_id, '0000-00-00', '0000-00-00', 1);
			$sql = "SELECT * FROM " . DB_PREFIX . "product_discount WHERE product_id = '%d' AND customer_group_id = '%d' AND ((date_start = '%s' OR date_start < NOW()) AND (date_end = '%s' OR date_end > NOW())) ORDER BY quantity ASC, priority ASC, price ASC LIMIT %d";
			$query = $this->db->query(vsprintf($sql, $args));
			$discounts = $query->row;
			$this->cache->set($cache_key, $discounts);
		}

		return $discounts;		
	}

	public function getProductImages($product_id) {
		$cache_key = 'product.images.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . (int)$product_id;
		$images = $this->cache->get($cache_key);

		if ($images === false) {
			$sql = "SELECT * FROM " . DB_PREFIX . "product_image WHERE product_id = '%d' ORDER BY sort_order ASC";
			$query = $this->db->query(sprintf($sql, (int)$product_id));
			$images = $query->rows;
			$this->cache->set($cache_key, $images);
		}

		return $images;
	}

	public function getProductRelated($product_id) {
		$cache_key = 'product.related.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . (int)$product_id;
		$product_data = $this->cache->get($cache_key);

		if ($product_data === false) {
			$product_data = array();

			$args = array((int)$product_id, 1, (int)$this->config->get('config_store_id'));
			$sql = "SELECT * FROM " . DB_PREFIX . "product_related pr LEFT JOIN " . DB_PREFIX . "product p ON (pr.related_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE pr.product_id = '%d' AND p.status = '%d' AND p.date_available <= NOW() AND p2s.store_id = '%d'";
			$query = $this->db->query(vsprintf($sql, $args));

			foreach ($query->rows as $result) {
				$product_data[$result['related_id']] = $this->getProduct($result['related_id']);
			}

			$this->cache->set($cache_key, $product_data);
		}

		return $product_data;
	}
		
	public function getProductTags($product_id) {
		$cache_key = 'product.tags.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . (int)$product_id;
		$product_data = $this->cache->get($cache_key);

		if ($product_data === false) {
			$args = array((int)$product_id, (int)$this->config->get('config_language_id'));
			$sql = "SELECT * FROM " . DB_PREFIX . "product_tag WHERE product_id = '%d' AND language_id = '%d'";
			$query = $this->db->query(vsprintf($sql, $args));

			$product_data = $query->rows;
			$this->cache->set($cache_key, $product_data);
		}

		return $product_data;
	}
	
	public function getProductLayoutId($product_id) {
		$cache_key = 'product.layoutid.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . (int)$product_id;
		$product_data = $this->cache->get($cache_key);

		if ($product_data === false) {
			$args = array((int)$product_id, (int)$this->config->get('config_store_id'));
			$sql = "SELECT * FROM " . DB_PREFIX . "product_to_layout WHERE product_id = '%d' AND store_id = '%d'";
			$query = $this->db->query(vsprintf($sql, $args));
			
			if ($query->num_rows) {
				$product_data = $query->row['layout_id'];
			} else {
				$product_data = $this->config->get('config_layout_product');
			}

			$this->cache->set($cache_key, $product_data);
		}

		return $product_data;
	}
	
	public function getCategories($product_id) {
		$cache_key = 'prod.categories.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $product_id;
		$categories	= $this->cache->get($cache_key);

		if ($categories === false) {
			$sql = "SELECT * FROM " . DB_PREFIX . "product_to_category WHERE product_id = '%d'";
			$query = $this->db->query(sprintf($sql, (int)$product_id));
			$categories = $query->rows;
			$this->cache->set($cache_key, $categories);
		}

		return $categories;
	}
    
	public function getTotalProductSpecials() {
		if ($this->customer->isLogged()) {
			$customer_group_id = $this->customer->getCustomerGroupId();
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}
		
		$cache_key = 'products.special.total.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $customer_group_id;
		$total = $this->cache->get($cache_key);
		
		if ( $total === false ) {
			$args = array(1, (int)$this->config->get('config_store_id'), (int)$customer_group_id, '0000-00-00', '0000-00-00');
			$sql = "SELECT COUNT(DISTINCT ps.product_id) AS total FROM " . DB_PREFIX . "product_special ps LEFT JOIN " . DB_PREFIX . "product p ON (ps.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p.status = '%d' AND p.date_available <= NOW() AND p2s.store_id = '%d' AND ps.customer_group_id = '%d' AND ((ps.date_start = '%s' OR ps.date_start < NOW()) AND (ps.date_end = '%s' OR ps.date_end > NOW()))";
			$query = $this->db->query(vsprintf($sql, $args));
			
			if (isset($query->row['total'])) {
				$total = $query->row['total'];
			} else {
				$total = 0;
			}

			$this->cache->set($cache_key, $total);
		}

		return $total;
	}
    
    // public function getOptionByFabric($product_option_value_id) {
    //     $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_fabric_option_price WHERE product_option_value_id='" . (int)$product_option_value_id . "'");
        
    //     return $query->rows;
    // }
    
    // public function getPriceFabric($product_id, $product_option_value_id) {
    //     $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_fabric_option_price WHERE product_id='" . (int)$product_id . "' AND product_option_value_id='" . (int)$product_option_value_id . "'");
        
    //     return $query->rows;
    // }
    
    // public function getProductFabric($product_id) {
    //     $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_fabric_option NATURAL JOIN " . DB_PREFIX . " WHERE product_id = '" . (int)$product_id . "' ORDER BY sort_order");
        
    //     return $query->rows;
    // }
    public function getProductFabric($product_id) {
    	$cache_key = 'product_fabric_option.' . $product_id;
    	$data = $this->cache->get($cache_key);

    	if ($data === false ) {
	    	$data = array();
	    	$sql = "SELECT * FROM " . DB_PREFIX . "product_fabric_option NATURAL JOIN " . DB_PREFIX . "option_description WHERE product_id = '%d' ORDER BY product_fabric_option_id";
			$product_fabric_options = $this->db->query(sprintf($sql, (int)$product_id));

			foreach ($product_fabric_options->rows as $product_fabric_option) {
				$sql = "SELECT * FROM " . DB_PREFIX . "product_fabric_option_value NATURAL JOIN " . DB_PREFIX . "option_value_description WHERE product_fabric_option_id = '%d' ORDER BY product_fabric_option_value_id";
				$product_fabric_option_values = $this->db->query(sprintf($sql, (int)$product_fabric_option['product_fabric_option_id']));
				$data_product_fabric_option_value = array();

				foreach ($product_fabric_option_values->rows as $product_fabric_option_value) {
					$data_product_fabric_option_value[] = $product_fabric_option_value['option_value_id'];
				}
				
				$data[] = array(
					'option_id' => $product_fabric_option['option_id'],
					'product_fabric_option_value' 	=> $data_product_fabric_option_value,
				);
			}

    		$this->cache->set($cache_key, $data);
		}

		return $data;
    }
    
    public function getProductFabricValue($product_id, $option_id, $option_value_id) {
    	$cache_key = 'get.product.fabric.value.' . $product_id . '.' . $option_id . '.' . $option_value_id;
    	$data = $this->cache->get($cache_key);

    	if ( $data === false ) {
    		$sql = "SELECT t3.*, t4.name as product_name, t6.name as manufacturer_name, t4.description as description FROM " . DB_PREFIX . "product_fabric_option as t1 NATURAL JOIN " . DB_PREFIX . "product_fabric_option_value as t2 JOIN " . DB_PREFIX . "product_fabric_option_value_product as t3 NATURAL JOIN " . DB_PREFIX . "product_description AS t4 NATURAL JOIN " . DB_PREFIX . "product AS t5 ON(t2.product_fabric_option_value_id = t3.product_fabric_option_value_id) JOIN " . DB_PREFIX . "manufacturer AS t6 ON(t5.manufacturer_id=t6.manufacturer_id) WHERE t1.product_id = '%d' AND t1.option_id = '%d' AND t2.option_value_id = '%d' ";
	        $query = $this->db->query(sprintf($sql, (int)$product_id, (int)$option_id, (int)$option_value_id));
	    	$data = $query->rows;
	    	$this->cache->set($cache_key, $data);
	    }

        return $data;
    }
    
    public function getDesc($product_id) {
    	$cache_key = 'get.desc.' . $product_id;
    	$data = $this->cache->get($cache_key);

    	if ( $data === false ) {
    		$sql = "SELECT * FROM " . DB_PREFIX . "product_description WHERE product_id='%d' ";
        	$query = $this->db->query(sprintf($sql, (int)$product_id));
    		$data = $query->row;
    		$this->cache->set($cache_key, $data);
        }

        return $data;
    }
    
    public function getProductTable($product_id, $product_special_id) {
    	$cache_key = 'product_table.' . $product_id; 
    	$product_table = $this->cache->get($cache_key);

    	if ( $product_table === false ) {
    		$sql = "SELECT * FROM " . DB_PREFIX . "product_table WHERE product_id = '%d' ORDER BY product_table_sort";
			$tables = $this->db->query(sprintf($sql, (int)$product_id));
			$product_table['table'] = array();
			
			foreach ($tables->rows as $table) {
				$product_table['table'][$table['number_table']]['product_table_id'] = $table['product_table_id'];
				$product_table['table'][$table['number_table']]['product_table_sort'] = $table['product_table_sort'];
				$product_table['table'][$table['number_table']]['product_table_name'] = $table['product_table_name'];
				
				$sql = "SELECT * FROM " . DB_PREFIX . "product_table_option AS t1 NATURAL JOIN " . DB_PREFIX . "option_description AS t2 WHERE t1.product_table_id = '%d' ORDER BY t1.vertical DESC, t1.product_table_option_id";
				$options = $this->db->query(sprintf($sql, (int)$table['product_table_id']));
				$product_table['table'][$table['number_table']]['option_id'] = array();

				foreach ($options->rows as $option) {
					$sql = "SELECT count(*) FROM " . DB_PREFIX . "product_table_option_value WHERE product_table_option_id = '%d' AND product_table_option_value_image != '' ";
					$count_image = $this->db->query(sprintf($sql, (int)$option['product_table_option_id']));

					$product_table['table'][$table['number_table']]['option_id'][$option['option_id']]['vertical'] = $option['vertical'];
					$product_table['table'][$table['number_table']]['option_id'][$option['option_id']]['count_image'] = $count_image->row;
					$product_table['table'][$table['number_table']]['option_id'][$option['option_id']]['product_table_option_id'] = $option['product_table_option_id'];
					$product_table['table'][$table['number_table']]['option_id'][$option['option_id']]['name'] = $option['name'];
					
					$sql = "SELECT * FROM " . DB_PREFIX . "option_value_description AS t1 NATURAL JOIN " . DB_PREFIX . "option_value AS t2 WHERE t1.option_id = '%d' ORDER BY t2.sort_order";
					$option_values = $this->db->query(sprintf($sql, (int)$option['option_id']));
					$product_table['table'][$table['number_table']]['option_id'][$option['option_id']]['option_value'] = $option_values->rows;
					
					$sql = "SELECT * FROM " . DB_PREFIX . "product_table_option_value AS t1 NATURAL JOIN " . DB_PREFIX . "option_value_description AS t2 NATURAL JOIN " . DB_PREFIX . "option_value AS t3 WHERE t1.product_table_option_id = '%d' ORDER BY t1.product_table_option_value_sort, product_table_option_value_id";
					$product_option_values = $this->db->query(sprintf($sql, (int)$option['product_table_option_id']));
					$product_table['table'][$table['number_table']]['option_id'][$option['option_id']]['product_table_option_value'] = array();
					
					foreach ($product_option_values->rows as $key => $product_option_value) {
						$product_table['table'][$table['number_table']]['option_id'][$option['option_id']]['product_table_option_value'][$key]['name'] = $product_option_value['name'];
						$product_table['table'][$table['number_table']]['option_id'][$option['option_id']]['product_table_option_value'][$key]['option_value_id'] = $product_option_value['option_value_id'];
						$product_table['table'][$table['number_table']]['option_id'][$option['option_id']]['product_table_option_value'][$key]['product_table_option_value_image'] = $product_option_value['product_table_option_value_image'];
					}
				}

				$sql = "SELECT DISTINCT * FROM " . DB_PREFIX . "product_table_option_value_price WHERE product_table_id = '%d' GROUP BY option_value_horizont";
				$price = $this->db->query(sprintf($sql, (int)$table['product_table_id']));
				$product_table['table'][$table['number_table']]['option_value_horizont'] = array();
				
				foreach ($price->rows as $horizont) {
					$sql = "SELECT t1.*, t2.name AS price_after_name, t3.name AS price_prefix_name FROM " . DB_PREFIX . "product_table_option_value_price AS t1 NATURAL LEFT JOIN " . DB_PREFIX . "price_prefix AS t3 LEFT JOIN " . DB_PREFIX . "price_after AS t2 ON (t1.price_after_id = t2.price_after_id) WHERE t1.product_table_id = '%d' AND option_value_horizont = '%d'";
					$price_vertical = $this->db->query(sprintf($sql, (int)$table['product_table_id'], (int)$horizont['option_value_horizont']));
					
					$price = array();
					$id = array();

					foreach ($price_vertical->rows as $vertical) {
						$sql = "SELECT * FROM " . DB_PREFIX . "product_table_option_value_price_special as t1 NATURAL JOIN " . DB_PREFIX . "product_special as t2 WHERE product_table_option_value_price_id='%d' AND t2.product_special_id = '%d' AND (t2.date_start = '%s' OR t2.date_start < NOW()) AND (t2.date_end = '%s' OR t2.date_end > NOW()) ORDER BY t1.product_table_option_value_price_special_id DESC";
						$result = $this->db->query(sprintf($sql, $vertical['product_table_option_value_price_id'], (int)$product_special_id, "0000-00-00", "0000-00-00"));

						$product_table['table'][$table['number_table']]['option_value_horizont'][$horizont['option_value_horizont']]['option_value_vertical'][$vertical['option_value_vertical']]['price'] = $vertical['price'];
						$product_table['table'][$table['number_table']]['option_value_horizont'][$horizont['option_value_horizont']]['option_value_vertical'][$vertical['option_value_vertical']]['product_table_option_value_price_id'] = $vertical['product_table_option_value_price_id'];	
						$product_table['table'][$table['number_table']]['option_value_horizont'][$horizont['option_value_horizont']]['option_value_vertical'][$vertical['option_value_vertical']]['price_prefix_name'] = $vertical['price_prefix_name'];	
						$product_table['table'][$table['number_table']]['option_value_horizont'][$horizont['option_value_horizont']]['option_value_vertical'][$vertical['option_value_vertical']]['price_after_name'] = $vertical['price_after_name'];

						if (isset($result->row['table_price_special'])) {
							$product_table['table'][$table['number_table']]['option_value_horizont'][$horizont['option_value_horizont']]['option_value_vertical'][$vertical['option_value_vertical']]['special_price'] = $result->row['table_price_special'];
						} else {
							$product_table['table'][$table['number_table']]['option_value_horizont'][$horizont['option_value_horizont']]['option_value_vertical'][$vertical['option_value_vertical']]['special_price'] = 0;
						}
					}
				}
			}

    		$this->cache->set($cache_key, $product_table);
		}

		return $product_table;
	}
	
	public function ajaxSearch($parts) {
		$add = '';
		$property_data = array();

		$sql  = 'SELECT pd.product_id, pd.name, p.model FROM ' . DB_PREFIX . 'product_description AS pd ';
		$sql .= 'LEFT JOIN ' . DB_PREFIX . 'product AS p ON p.product_id = pd.product_id ';
        $sql .= 'LEFT JOIN ' . DB_PREFIX . 'product_to_store AS p2s ON p2s.product_id = pd.product_id ';
        $sql .= 'LEFT JOIN ' . DB_PREFIX . 'product_option_value AS pov ON pov.product_id = p.product_id ';
        $sql .= 'LEFT JOIN ' . DB_PREFIX . 'option_value_description AS ovd ON pov.option_value_id = ovd.option_value_id ';

		foreach ( $parts as $part ) {
			$property_data[] = '%' . $this->db->escape(utf8_strtolower($part)) . '%';
			$add .= ' AND (LOWER(pd.name) LIKE "%s" ';
            $property_data[] = (int)$part;
            $add .= ' OR p.product_id = "%d" ';
            $property_data[] = '%' . $this->db->escape(utf8_strtolower($part)) . '%';
            $add .= ' OR LOWER(ovd.name) LIKE "%s" )';
		}

		$add = substr( $add, 4 );
		$property_data[] = 1;

		$sql .= 'WHERE ' . $add . ' AND p.status = "%d" ';
		$property_data[] = (int)$this->config->get('config_language_id');
		$property_data[] = (int)$this->config->get('config_store_id');
		$sql .= 'AND pd.language_id = "%d"';
		$sql .= ' AND p2s.store_id = "%d"'; 
		$sql .= 'GROUP BY p.product_id ORDER BY p.sort_order ASC, LOWER(pd.name) ASC, LOWER(p.model) ASC';
		$property_data[] = 40;
		$sql .= ' LIMIT %d';

		$products = $this->db->query(vsprintf($sql, $property_data));

		if (isset($products->rows)) {
			$products = $products->rows;
		} else {
			$products = $products->row;
		}

		return $products;
	}

    public function getPriceLimits($data) {
        if ($this->customer->isLogged()) {
            $customer_group_id = $this->customer->getCustomerGroupId();
        } else {
            $customer_group_id = $this->config->get('config_customer_group_id');
        }

        $property_data = array();
        $property_data[] = (int)$customer_group_id;
        $property_data[] = 1;
        $property_data[] = "0000-00-00";
        $property_data[] = "0000-00-00";
        $property_data[] = 1;
        $property_data[] = (int)$customer_group_id;
        $property_data[] = "0000-00-00";
        $property_data[] = "0000-00-00";
        $property_data[] = 1;
        $property_data[] = (int)$customer_group_id;
        $property_data[] = 1;
        $property_data[] = "0000-00-00";
        $property_data[] = "0000-00-00";
        $property_data[] = 1;
        $property_data[] = (int)$customer_group_id;
        $property_data[] = "0000-00-00";
        $property_data[] = "0000-00-00";
        $property_data[] = 1;

        $coalesce = "coalesce((SELECT price FROM " . DB_PREFIX . "product_discount pd2 WHERE pd2.product_id = p.product_id AND pd2.customer_group_id = '%d' AND pd2.quantity = '%d' AND ((pd2.date_start = '%s' OR pd2.date_start < NOW()) AND (pd2.date_end = '%s' OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT %d), " .
            "(SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '%d' AND ((ps.date_start = '%s' OR ps.date_start < NOW()) AND (ps.date_end = '%s' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT %d), " .
            "p.price)";

        $sql = "SELECT max(" . $coalesce . ") AS max_price, min(" . $coalesce . ") AS min_price
				FROM " . DB_PREFIX . "product p
			   	LEFT JOIN " . DB_PREFIX . "product_option_value pov ON (pov.product_id=p.product_id)";

        if ($data['filter_category_id'] != null) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p2c.product_id=p.product_id)";
        }

        if (isset($data['special']) && $data['special'] == true) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "product_special ps ON(ps.product_id = p.product_id) ";
        }

        if (isset($data['discount']) && $data['discount'] == true) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "product_discount pd2 ON(pd2.product_id = p.product_id) ";
        }

        if (isset($data['filter_name']) && !empty($data['filter_name'])) {
            $sql .= 'LEFT JOIN ' . DB_PREFIX . 'option_value_description AS ovd ON pov.option_value_id = ovd.option_value_id ';
        }

        $sql .= "LEFT JOIN " . DB_PREFIX . "product_description pd ON(p.product_id = pd.product_id)
			LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON(p.product_id = p2s.product_id)";

        if (!empty($data['filter_tag'])) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "product_tag pt ON(p.product_id = pt.product_id)";
        }

        $property_data[] = 1;
        $property_data[] = (int)$this->config->get('config_language_id');
        $property_data[] = (int)$this->config->get('config_store_id');

        $sql .= " WHERE p.status = '%d' AND pd.language_id = '%d' AND p.date_available <= NOW() AND p2s.store_id = '%d'";

        $data_query = $this->filterSearch($data);
        $sql .= " " . $data_query['sql'];

        $property_data = array_merge($property_data, $data_query['values']);
        $query = $this->db->query(vsprintf($sql, $property_data));


        return $query->row;
    }

	public function filterSearch($data, $filter = 0, $innertable = false) {
		$sql = '';
		$property_data = array();
		
		if (isset($data['special']) && $data['special'] == true) {
			$property_data[] = "0000-00-00";
			$property_data[] = "0000-00-00";

			$sql .= "AND ((ps.date_start = '%s' OR ps.date_start < NOW()) AND (ps.date_end = '%s' OR ps.date_end > NOW()))";
		}

        if (isset($data['discount']) && $data['discount'] == true) {
            $property_data[] = "0000-00-00";
            $property_data[] = "0000-00-00";

            $sql .= "AND ((pd2.date_start = '%s' OR pd2.date_start < NOW()) AND (pd2.date_end = '%s' OR pd2.date_end > NOW()))";
        }

		if (isset($data['filter_name']) && !empty($data['filter_name'])) {
			$words = explode(' ', trim(preg_replace('/\s\s+/', ' ', $data['filter_name'])));

			if (isset($data['filter_tag']) && !empty($data['filter_tag'])) {
				$filter_tag_words = explode(' ', trim(preg_replace('/\s\s+/', ' ', $data['filter_tag'])));
			}

			foreach ($words as $key => $word) {
				$property_data[] = '%' . $this->db->escape(utf8_strtolower($word)) . '%';
				$sql .= " AND (LCASE(pd.name) LIKE '%s'";

                $property_data[] = '%' . $this->db->escape(utf8_strtolower($word)) . '%';
                $sql .= " OR LCASE(ovd.name) LIKE '%s' ";

				if (isset($data['filter_description']) && $data['filter_description'] != null) {
					$property_data[] = '%' . $this->db->escape(utf8_strtolower($word)) . '%';
					$sql .= " OR LCASE(pd.description) LIKE '%s'";
				}

				if (isset($filter_tag_words[$key])) {
					$property_data[] = '%' . $this->db->escape(utf8_strtolower($filter_tag_words[$key])) . '%';
					$sql .= " OR LCASE(pt.tag) LIKE '%s'";
				}

                $property_data[] = (int)$word;
                $sql .= ' OR p.product_id = "%d" )';
            }
		}

		if (isset($data['filter_category_id']) && $data['filter_category_id'] != null) {
			if (isset($data['filter_sub_category']) && $data['filter_sub_category'] != null) {
				$implode_data = array();
				
				$property_data[] = (int)$data['filter_category_id'];
				$implode_data[] = "p2c.category_id = '%d'";
				
				$categories = $this->model_catalog_category->getCategoriesByParentId($data['filter_category_id']);
				
				foreach ($categories as $category_id) {
					$property_data[] = (int)$category_id;
					$implode_data[] = "p2c.category_id = '%d'";
				}
				
				$sql .= " AND (" . implode(' OR ', $implode_data) . ")";			
			} else {
				$property_data[] = (int)$data['filter_category_id'];
				$sql .= " AND p2c.category_id = '%d'";
			}
		}
		
		if (isset($data['filter_manufacturer_id']) && !empty($data['filter_manufacturer_id'])) {
			$property_data[] = (int)$data['filter_manufacturer_id'];
			$sql .= " AND p.manufacturer_id = '%d'";
		}

		if ($filter != 0) {
			foreach (explode(';', $filter) as $option) {
				$values = explode('=', $option);
				$datatotal = array();

				if (isset($values[1])) {
					foreach (explode(',', $values[1]) as $value_id) {
						$product_to_value = "SELECT product_id FROM " . DB_PREFIX . "product_to_value WHERE value_id='%d'";
						$query = $this->db->query(sprintf($product_to_value, (int)$value_id));
						
						if ($query->rows) {
							foreach($query->rows as $row) {
								$property_data[] = (int)$row['product_id'];
								$datatotal[] = '%d';
							}
						} else {
							unset($datatotal);
						}
					}
				}
				
				if (!empty($datatotal)) {
					$sql .= " AND p.product_id IN (" . implode(",", $datatotal) . ")";
				}
			}
		}

		if ($innertable == true) {
			$sql .= ' ) as innertable';
		}

		if ($innertable == true && (isset($data['min_price']) || isset($data['max_price']))) {
			$sql .= " WHERE ";
			$min_price = false;

			if (isset($data['min_price']) && $data['min_price'] >= 0) {
				$property_data[] = (int)$data['min_price'];
				$sql .= " realprice >= '%d'";
				$min_price = true;
			}

			if (isset($data['max_price']) && $data['max_price'] > 0) {
				$property_data[] = (int)$data['max_price'];

				if ($min_price == true) {
					$sql .= " AND ";
				}

				$sql .= " realprice <= '%d'";
			}
		}

		$data_query = array('sql' => $sql, 'values' => $property_data);

		return $data_query;
	}

	public function getProductTabs($product_id) {
		$product_tab_data = array();
		$product_tab_query = $this->db->query("SELECT t.tab_id, td.name, pt.text, t.position, t.show_empty FROM " . DB_PREFIX . "product_tab pt LEFT JOIN " . DB_PREFIX . "tab t ON (pt.tab_id = t.tab_id) LEFT JOIN " . DB_PREFIX . "tab_description td ON (t.tab_id = td.tab_id) WHERE pt.product_id = '" . (int)$product_id . "' AND td.language_id = '" . (int)$this->config->get('config_language_id') . "' AND pt.language_id = '" . (int)$this->config->get('config_language_id') . "' AND t.status = '1' AND ( t.show_empty = '1' OR NOT pt.text REGEXP '^[[:space:]]*$' ) ORDER BY t.position, t.sort_order, td.name");
		
		foreach ($product_tab_query->rows as $product_tab) {
			$product_tab_data[] = array(
				'tab_id' 				=> $product_tab['tab_id'],
				'name'      		=> $product_tab['name'],
				'text'      		=> $product_tab['text'],
				'position' 			=> $product_tab['position']
			);
		}
		
		return $product_tab_data;
	}
	
	public function getProductPrice($product_id) {
		$sql = "SELECT * FROM " . DB_PREFIX . "product_price NATURAL JOIN " . DB_PREFIX . "price_prefix WHERE product_id = '" . (int)$product_id . "'";
		$query = $this->db->query(sprintf($sql, $product_id));
		return $query->rows;
	}
	
	public function getProductOptionsFilter($product_id) {
		$sql = "SELECT p2v.*, cod.name FROM " . DB_PREFIX . "product_to_value p2v NATURAL JOIN " . DB_PREFIX . "category_option_description cod NATURAL JOIN category_option WHERE p2v.product_id = '%d' AND status='%d' GROUP BY option_id ORDER BY sort_order ";
		$query = $this->db->query(sprintf($sql, $product_id, 1));
		return $query->rows;
	}

    public function getCommentsByProductId($product_id, $start = 0, $limit = 20) {
        $sql   = "
		SELECT r.*, p.product_id, pd.name, p.price, p.image, r.date_added,  (r.sorthex) as hsort
		FROM " . DB_PREFIX . "product_comment r
		LEFT JOIN " . DB_PREFIX . "product p ON (r.product_id = p.product_id)
		LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id)
		WHERE p.product_id = '" . (int) $product_id . "'
		AND p.date_available <= NOW()
		AND p.status = '1'
		AND r.status = '1'
		AND pd.language_id = '" . (int) $this->config->get('config_language_id') . "' ";
        $query = $this->db->query($sql);

        return $query->rows;
    }

    public function getTotalCommentsByProductId($product_id) {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product_comment r
		LEFT JOIN " . DB_PREFIX . "product p ON (r.product_id = p.product_id)
		LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id)
		WHERE p.product_id = '" . (int) $product_id . "' AND p.date_available <= NOW() AND p.status = '1' AND r.status = '1'
		AND pd.language_id = '" . (int) $this->config->get('config_language_id') . "'");

        return $query->row['total'];
    }

    public function getRatesByProductdId($product_id, $customer_id) {
        $sql   = "
			  SELECT
				rc.*,
				rc.comment_id as cid,
                IF ((SELECT urc.delta  FROM " . DB_PREFIX . "product_rate_comment urc WHERE urc.customer_id = '" . $customer_id . "' AND urc.comment_id = rc.comment_id)  < 0, -1 ,  IF ((SELECT urc.delta  FROM " . DB_PREFIX . "product_rate_comment urc WHERE urc.customer_id = '" . $customer_id . "' AND urc.comment_id = rc.comment_id)  > 0, 1 ,  0 ) ) as customer_delta ,
      			COUNT(rc.comment_id) as rate_count,
				SUM(rc.delta) as rate_delta,
				SUM(rc.delta > 0) as rate_delta_plus,
				SUM(rc.delta < 0) as rate_delta_minus
			   FROM
			     " . DB_PREFIX . "product_rate_comment rc
			   LEFT JOIN " . DB_PREFIX . "product_comment c on (rc.comment_id = c.comment_id)
			   LEFT JOIN " . DB_PREFIX . "product r on (r.product_id = c.product_id)
			   LEFT JOIN " . DB_PREFIX . "product_description pd ON (r.product_id = pd.product_id)
				   WHERE
			     r.product_id= " . (int) $product_id . "
				AND r.date_available <= NOW()
				AND r.status = '1'
				AND c.status = '1'

				AND pd.language_id = '" . (int) $this->config->get('config_language_id') . "'
			    GROUP BY rc.comment_id ";
        $query = $this->db->query($sql);

        if (count($query->rows) > 0) {
            foreach ($query->rows as $rates) {
                $rate[$rates['cid']] = $rates;
            }

            return $rate;
        }
    }

    public function addComment($product_id, $data, $data_get) {
        $parent_id = 0;

        if (isset($data_get['parent'])) {
            $parent_id = $data_get['parent'];
        }

        $sql   = "
		SELECT r.*, p.*, pp.sorthex as sorthex_parent
		FROM " . DB_PREFIX . "product_comment r
		LEFT JOIN " . DB_PREFIX . "product p ON (r.product_id = p.product_id)
		LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id)
		LEFT JOIN " . DB_PREFIX . "product_comment pp ON (r.parent_id = pp.comment_id)
		WHERE p.product_id = '" . (int) $product_id . "'
		AND r.parent_id = '" . (int) $parent_id . "'
		AND pd.language_id = '" . (int) $this->config->get('config_language_id') . "'
		ORDER BY r.sorthex DESC
		LIMIT 1";
        $query = $this->db->query($sql);

        if (count($query->rows) > 0) {
            foreach ($query->rows as $comment) {
                $sorthex        = $comment['sorthex'];
                $sorthex_parent = $comment['sorthex_parent'];
                $sorthex        = substr($sorthex, strlen($sorthex_parent), 4);
            }

            $sorthex = $sorthex_parent . (str_pad(dechex($sortdec = hexdec($sorthex) + 1), 4, "0", STR_PAD_LEFT));
        } else {
            if ($parent_id == 0) {
                $sorthex = '0000';
            } else {
                $queryparent = $this->db->query("
				SELECT c.sorthex
				FROM " . DB_PREFIX . "product_comment c
				WHERE c.comment_id = '" . (int) $parent_id . "'
				ORDER BY c.sorthex DESC
				LIMIT 1");
                if (count($queryparent->rows) > 0) {
                    foreach ($queryparent->rows as $parent) {
                        $sorthex = $parent['sorthex'];
                    }
                    $sorthex = $sorthex . "0000";
                }
            }
        }

        $this->db->query("INSERT INTO " . DB_PREFIX . "product_comment SET
		author = '" . $this->db->escape($data['name']) . "',
		customer_id = '" . (int) $this->customer->getId() . "',
		product_id = '" . (int) $product_id . "',
		sorthex   = '" . $sorthex . "',
		parent_id = '" . (int) $parent_id . "',
		text = '" . $this->db->escape(strip_tags($data['text'])) . "',
		status = '" . $this->db->escape(strip_tags($data['status'])) . "',
		rating = '" . (int) $data['rating'] . "',
		date_added = NOW(),
		file_comment = '" . $data['file_comment'] . "'
		");

        return $this->db->getLastId();
    }

    public function getProductbyComment($data = array()) {
        $sql   = "SELECT c.product_id as product_id
		FROM  " . DB_PREFIX . "product_comment c
		WHERE
		c.comment_id = '" . $data['comment_id'] . "'
		LIMIT 1";
        $query = $this->db->query($sql);
        $query->row['sql'] = $sql;

        return $query->row;
    }

    public function checkRate($data = array()) {
        $sql = "SELECT * FROM  " . DB_PREFIX . "product_rate_comment rc
		WHERE customer_id = '" . $data['customer_id'] . "' AND comment_id = '" . $data['comment_id'] . "' LIMIT 1";
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function checkRateNum($data = array()) {
        $sql   = "SELECT *,
        COUNT(c.product_id) as rating_num
		FROM  " . DB_PREFIX . "product_comment c LEFT JOIN " . DB_PREFIX . "product_rate_comment rc ON (rc.comment_id = c.comment_id)
		WHERE rc.customer_id = '" . $data['customer_id'] . "' AND c.product_id = '" . $data['product_id'] . "'
		GROUP BY c.product_id LIMIT 1";
        $query = $this->db->query($sql);
        $query->row['sql'] = $sql;

        return $query->row;
    }

    public function addRate($data = array()) {
        $sql   = "INSERT INTO " . DB_PREFIX . "product_rate_comment SET
		customer_id = '" . $data['customer_id'] . "',
		comment_id = '" . $data['comment_id'] . "',
		delta = '" . $data['delta'] . "' ";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getRatesByCommentId($comment_id) {
        $sql   = "
			  SELECT
				rc.*,
				rc.comment_id as cid,
				COUNT(rc.comment_id) as rate_count,
				SUM(rc.delta) as rate_delta,
				SUM(rc.delta > 0) as rate_delta_plus,
				SUM(rc.delta < 0) as rate_delta_minus
			   FROM
			     " . DB_PREFIX . "product_rate_comment rc
			   WHERE
			     rc.comment_id= " . (int) $comment_id . "
			    GROUP BY rc.comment_id
			   ";
        $query = $this->db->query($sql);

        if (count($query->rows) > 0) {
            foreach ($query->rows as $rates) {
                $rate[$rates['cid']] = $rates;
            }
        }
        return $query->rows;
    }

    public function getNextProd($product_id) {
        $sql = "SELECT min(product_id) as product_id FROM " . DB_PREFIX . "product WHERE product_id > $product_id ";
        $query = $this->db->query($sql);

        if ($query->row['product_id'] == null) {
            $sql = "SELECT min(product_id) as product_id FROM " . DB_PREFIX . "product";
            $query = $this->db->query($sql);
        }

        return $query->row['product_id'];
    }

    public function getPrevProd($product_id) {
        $sql = "SELECT max(product_id) as product_id FROM " . DB_PREFIX . "product WHERE product_id < $product_id ";
        $query = $this->db->query($sql);

        if ($query->row['product_id'] == null) {
            $sql = "SELECT max(product_id) as product_id FROM " . DB_PREFIX . "product ";
            $query = $this->db->query($sql);
        }

        return $query->row['product_id'];
    }
}
?>
