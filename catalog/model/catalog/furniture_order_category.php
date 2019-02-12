<?php
class ModelCatalogFurnitureOrderCategory extends Model {
	public function getCategory($furniture_order_category_id) {
		return $this->getCategories((int)$furniture_order_category_id, 'by_id');
	}
        
    public function getCategories($id = 0, $type = 'by_parent') {
		static $data = null;
        
		if ($data === null) {
			$data = array();
            
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "furniture_order_category c LEFT JOIN " . DB_PREFIX . "furniture_order_category_description cd ON (c.furniture_order_category_id = cd.furniture_order_category_id) LEFT JOIN " . DB_PREFIX . "furniture_order_category_to_store c2s ON (c.furniture_order_category_id = c2s.furniture_order_category_id) WHERE cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND c.status = '1' ORDER BY c.parent_id, c.sort_order, cd.name");
                        
			foreach ($query->rows as $row) {
				$data['by_id'][$row['furniture_order_category_id']] = $row;
				$data['by_parent'][$row['parent_id']][] = $row;
			}
		}
                
		return ((isset($data[$type]) && isset($data[$type][$id])) ? $data[$type][$id] : array());
	}
	
	public function getCategoryImages($furniture_order_category_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "furniture_order_category_image WHERE furniture_order_category_id = '" . (int)$furniture_order_category_id . "'");
		
		return $query->rows;
	}
	
	public function treeCategory($furniture_order_category_id) {
		$treefurniture_order_category = array();
		$treefurniture_order_category[] = $furniture_order_category_id;

		for ( ; ; ) {
		  $parent_id = $this->db->query("SELECT parent_id FROM " . DB_PREFIX . " furniture_order_category where furniture_order_category_id='" . $furniture_order_category_id . "'");
		  $treefurniture_order_category[] = $parent_id->row['parent_id'];
		  $furniture_order_category_id = $parent_id->row['parent_id'];
		  if ( $parent_id->row['parent_id'] == 0 ) {
		    return $treefurniture_order_category;
		  }
		}
		return 0;
	}
	
	// public function getCategroyByProduct($product_id) {
	// 	$furniture_order_category_id = $this->db->query("SELECT * FROM " . DB_PREFIX . " product_to_furniture_order_category where product_id=
	// 	'" . $product_id. "' and main_furniture_order_category='1'");
	// 	if ( isset($furniture_order_category_id->row['furniture_order_category_id']) ) {
	// 	      return $furniture_order_category_id->row['furniture_order_category_id'];
	// 	} else {
	// 	      return 0;
	// 	}
	// }

	public function getOptionsByCategory($furniture_order_category_id) {
		$options_id = $this->db->query("SELECT option_id FROM " . DB_PREFIX . " furniture_order_category_option_to_furniture_order_category where 
		furniture_order_category_id='" . $furniture_order_category_id . "'");
		if ( isset($options_id->row['option_id']) ) {
		      return $options_id->row['option_id'];
		}
		return 0;
	}

	public function getCategoriesByParentId($furniture_order_category_id) {
		$furniture_order_category_data = array();

		$categories = $this->getCategories((int)$furniture_order_category_id);

		foreach ($categories as $furniture_order_category) {
			$furniture_order_category_data[] = $furniture_order_category['furniture_order_category_id'];

			$children = $this->getCategoriesByParentId($furniture_order_category['furniture_order_category_id']);

			if ($children) {
				$furniture_order_category_data = array_merge($children, $furniture_order_category_data);
			}
		}

		return $furniture_order_category_data;
	}

	public function getCategoryLayoutId($furniture_order_category_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "furniture_order_category_to_layout WHERE furniture_order_category_id = '" . (int)$furniture_order_category_id . "' AND store_id = '" . (int)$this->config->get('config_store_id') . "'");

		if ($query->num_rows) {
			return $query->row['layout_id'];
		} else {
			return $this->config->get('config_layout_furniture_order_category');
		}
	}

	public function getTotalCategoriesByCategoryId($parent_id = 0) {
		return count($this->getCategories((int)$parent_id));
	}
        
        public function getCategoryDescription($parent_id) {
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "furniture_order_category NATURAL JOIN " . DB_PREFIX . "furniture_order_category_description WHERE parent_id = '" . (int)$parent_id . "' AND status = '1' ORDER BY parent_id, sort_order, name");
            
            return $query->rows;
        }
}
?>