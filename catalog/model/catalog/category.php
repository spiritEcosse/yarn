<?php
class ModelCatalogCategory extends Model {
	public function getCategory($category_id) {
		return $this->getCategories((int)$category_id, 'by_id');
	}
	
    public function getCategoryDescription($parent_id) {
    	$cache_key = 'cat.cat.desc.' . $parent_id;
    	$data = $this->cache->get($cache_key);
    	
    	if (!is_array($data)) {
    		$sql = "SELECT * FROM " . DB_PREFIX . "category NATURAL JOIN " . DB_PREFIX . "category_description WHERE parent_id = '%d' AND status = '%d' ORDER BY parent_id, sort_order, name";
        	$query = $this->db->query(sprintf($sql, (int)$parent_id, 1));
      		$data = $query->rows;
      		$this->cache->set($cache_key, $data);
        }
        
        return $data;
    }
    
	public function getCategories($id = 0, $type = 'by_parent') {
		$cache_key = 'cat.cat.desc.cat.to.store.' . $this->config->get('config_language_id') . '.' . $this->config->get('config_store_id') . '.' . $id . '.' . $type;
	    $categories = $this->cache->get($cache_key);
		
		if (!is_array($categories)) {
			static $data = null;
			$categories = array();

			if ($data === null) {
				$data = array();

				$sql = "SELECT * FROM " . DB_PREFIX . "category c NATURAL JOIN " . DB_PREFIX . "category_description cd NATURAL JOIN " . DB_PREFIX . "category_to_store c2s WHERE cd.language_id = '%d' AND c2s.store_id = '%d' AND c.status = '%d' ORDER BY c.parent_id, c.sort_order, cd.name";
				$query = $this->db->query(sprintf($sql, (int)$this->config->get('config_language_id'), (int)$this->config->get('config_store_id'), 1));

				foreach ($query->rows as $row) {
					$data['by_id'][$row['category_id']] = $row;
					$data['by_parent'][$row['parent_id']][] = $row;
				}
			}

			if (isset($data[$type][$id])) {
				$categories = $data[$type][$id];				
			}

	    	$this->cache->set($cache_key, $categories);
		}

		return $categories;
	}
	
	public function treeCategory($category_id) {
		$cache_key = "tree.category." . $category_id;
		$treeCategory = $this->cache->get($cache_key);
		
		if ($treeCategory === false) {
			$treeCategory = array();
			$treeCategory[] = $category_id;

			for ( ; ; ) {
	    		$sql = "SELECT parent_id FROM " . DB_PREFIX . "category WHERE category_id='%d' AND status = '%d'";
				$parent_id = $this->db->query(sprintf($sql, (int)$category_id, 1));
				
				if (isset($parent_id->row['parent_id']) && $parent_id->row['parent_id'] != 0) {
					$treeCategory[] = $parent_id->row['parent_id'];
					$category_id = $parent_id->row['parent_id'];
				} else {
		    		$this->cache->set($cache_key, $treeCategory);
					return $treeCategory;
				}
			}

			return 0;
		}

		return $treeCategory;
	}
	
	public function getCategroyByProduct($product_id) {
		$cache_key = "prod_to_cat." . $product_id;
	    $category_id = $this->cache->get($cache_key);

	    if ($category_id === false) {
	    	$sql = "SELECT * FROM " . DB_PREFIX . "product_to_category WHERE product_id = '%d' and main_category='%d'";
			$category_id = $this->db->query(sprintf($sql, (int)$product_id, 1));
				
			if (isset($category_id->row['category_id'])) {
				$category_id = $category_id->row['category_id'];
			} else {
				$category_id = 0;
			}

	    	$this->cache->set($cache_key, $category_id);
		}

		return $category_id;
	}
	
	public function getOptionsByCategory($category_id) {
		$cache_key = "cat.opt.to.cat." . $category_id;
	    $option_id = $this->cache->get($cache_key);
	    
		if ($option_id === false) {
			$sql = "SELECT option_id FROM " . DB_PREFIX . "category_option_to_category WHERE category_id='%d'";
			$option_id = $this->db->query(sprintf($sql, (int)$category_id));
			
			if ( isset($option_id->row['option_id']) ) {
			    $option_id = $option_id->row['option_id'];
			} else {
				$option_id = 0;
			}

	    	$this->cache->set($cache_key, $option_id);
		}

		return $option_id;
	}

	public function getCategoriesByParentId($category_id) {
		$cache_key = "get.cat.by.parent." . $category_id;
	    $category_data = $this->cache->get($cache_key);

	    if ($category_data === false) {
			$category_data = array();
			$categories = $this->getCategories((int)$category_id);
			
			foreach ($categories as $category) {
				$category_data[] = $category['category_id'];

				$children = $this->getCategoriesByParentId($category['category_id']);

				if ($children) {
					$category_data = array_merge($children, $category_data);
				}
			}
			
	    	$this->cache->set($cache_key, $category_data);
	    }
	    
		return $category_data;
	}

	public function getCategoryLayoutId($category_id) {
		$cache_key = "cat.to.layout." . $category_id . '.' . $this->config->get('config_store_id');
	    $layout = $this->cache->get($cache_key);
	    
	    if ( $layout === false ) {
	    	$sql = "SELECT * FROM " . DB_PREFIX . "category_to_layout WHERE category_id = '%d' AND store_id = '%d'";
			$query = $this->db->query(sprintf($sql, (int)$category_id, (int)$this->config->get('config_store_id')));

			if ($query->num_rows) {
				$layout = $query->row['layout_id'];
			} else {
				$layout = $this->config->get('config_layout_category');
			}

	    	$this->cache->set($cache_key, $layout);
		}

		return $layout;
	}

	public function getTotalCategoriesByCategoryId($parent_id = 0) {
		return count($this->getCategories((int)$parent_id));
	}
}
?>