<?php
class ModelCatalogFurnitureOrderCategory extends Model {
	public function addCategory($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "furniture_order_category SET parent_id = '" . (int)$data['parent_id'] . "', `top` = '" . (isset($data['top']) ? (int)$data['top'] : 0) . "', `column` = '" . (int)$data['column'] . "', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', date_modified = NOW(), date_added = NOW()");
	
		$furniture_order_category_id = $this->db->getLastId();
		
		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "furniture_order_category SET image = '" . $this->db->escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "' WHERE furniture_order_category_id = '" . (int)$furniture_order_category_id . "'");
		}
		
		foreach ($data['furniture_order_category_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "furniture_order_category_description SET furniture_order_category_id = '" . (int)$furniture_order_category_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', description = '" . $this->db->escape($value['description']) . "', seo_title = '" . $this->db->escape($value['seo_title']) . "', seo_h1 = '" . $this->db->escape($value['seo_h1']) . "'");
		}
		
		if (isset($data['furniture_order_category_store'])) {
			foreach ($data['furniture_order_category_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "furniture_order_category_to_store SET furniture_order_category_id = '" . (int)$furniture_order_category_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		if (isset($data['furniture_order_category_layout'])) {
			foreach ($data['furniture_order_category_layout'] as $store_id => $layout) {
				if ($layout['layout_id']) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "furniture_order_category_to_layout SET furniture_order_category_id = '" . (int)$furniture_order_category_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout['layout_id'] . "'");
				}
			}
		}
						
		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'furniture_order_category_id=" . (int)$furniture_order_category_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}
		
		if (isset($data['furniture_order_category_image'])) {
			foreach ($data['furniture_order_category_image'] as 
				$furniture_order_category_image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "furniture_order_category_image SET furniture_order_category_id = '" . (int)$furniture_order_category_id . "', image = '" . $this->db->escape(html_entity_decode($furniture_order_category_image['image'], ENT_QUOTES, 'UTF-8')) . "', sort_order = '" . (int)$furniture_order_category_image['sort_order'] . "'");
			}
		}

		$this->cache->delete('furniture_order_category');
	}
	
	public function editCategory($furniture_order_category_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "furniture_order_category SET parent_id = '" . (int)$data['parent_id'] . "', `top` = '" . (isset($data['top']) ? (int)$data['top'] : 0) . "', `column` = '" . (int)$data['column'] . "', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', date_modified = NOW() WHERE furniture_order_category_id = '" . (int)$furniture_order_category_id . "'");

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "furniture_order_category SET image = '" . $this->db->escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "' WHERE furniture_order_category_id = '" . (int)$furniture_order_category_id . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "furniture_order_category_description WHERE furniture_order_category_id = '" . (int)$furniture_order_category_id . "'");

		foreach ($data['furniture_order_category_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "furniture_order_category_description SET furniture_order_category_id = '" . (int)$furniture_order_category_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', description = '" . $this->db->escape($value['description']) . "', seo_title = '" . $this->db->escape($value['seo_title']) . "', seo_h1 = '" . $this->db->escape($value['seo_h1']) . "'");
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "furniture_order_category_to_store WHERE furniture_order_category_id = '" . (int)$furniture_order_category_id . "'");
		
		if (isset($data['furniture_order_category_store'])) {		
			foreach ($data['furniture_order_category_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "furniture_order_category_to_store SET furniture_order_category_id = '" . (int)$furniture_order_category_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "furniture_order_category_to_layout WHERE furniture_order_category_id = '" . (int)$furniture_order_category_id . "'");

		if (isset($data['furniture_order_category_layout'])) {
			foreach ($data['furniture_order_category_layout'] as $store_id => $layout) {
				if ($layout['layout_id']) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "furniture_order_category_to_layout SET furniture_order_category_id = '" . (int)$furniture_order_category_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout['layout_id'] . "'");
				}
			}
		}
						
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'furniture_order_category_id=" . (int)$furniture_order_category_id. "'");
		
		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'furniture_order_category_id=" . (int)$furniture_order_category_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "furniture_order_category_image WHERE furniture_order_category_id = '" . (int)$furniture_order_category_id . "'");

		if (isset($data['furniture_order_category_image'])) {
			foreach ($data['furniture_order_category_image'] as 
				$furniture_order_category_image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "furniture_order_category_image SET furniture_order_category_id = '" . (int)$furniture_order_category_id . "', image = '" . $this->db->escape(html_entity_decode($furniture_order_category_image['image'], ENT_QUOTES, 'UTF-8')) . "', sort_order = '" . (int)$furniture_order_category_image['sort_order'] . "'");
			}
		}

		$this->cache->delete('furniture_order_category');
	}
	
	public function getCategoryImages($furniture_order_category_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "furniture_order_category_image WHERE furniture_order_category_id = '" . (int)$furniture_order_category_id . "'");
		
		return $query->rows;
	}

	public function deleteCategory($furniture_order_category_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "furniture_order_category WHERE furniture_order_category_id = '" . (int)$furniture_order_category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "furniture_order_category_description WHERE furniture_order_category_id = '" . (int)$furniture_order_category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "furniture_order_category_to_store WHERE furniture_order_category_id = '" . (int)$furniture_order_category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "furniture_order_category_to_layout WHERE furniture_order_category_id = '" . (int)$furniture_order_category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'furniture_order_category_id=" . (int)$furniture_order_category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "furniture_order_category_image WHERE furniture_order_category_id = '" . (int)$furniture_order_category_id . "'");
		
		$query = $this->db->query("SELECT furniture_order_category_id FROM " . DB_PREFIX . "furniture_order_category WHERE parent_id = '" . (int)$furniture_order_category_id . "'");
		
		foreach ($query->rows as $result) {
			$this->deletefurniture_order_category($result['furniture_order_category_id']);
		}
		
		$this->cache->delete('furniture_order_category');
	} 

	public function getCategory($furniture_order_category_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'furniture_order_category_id=" . (int)$furniture_order_category_id . "') AS keyword FROM " . DB_PREFIX . "furniture_order_category WHERE furniture_order_category_id = '" . (int)$furniture_order_category_id . "'");
		
		return $query->row;
	} 
	
	public function getCategories($parent_id = 0) {
		$furniture_order_category_data = $this->cache->get('furniture_order_category.' . (int)$this->config->get('config_language_id') . '.' . (int)$parent_id);
	
		if (!$furniture_order_category_data) {
			$furniture_order_category_data = array();
		
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "furniture_order_category c LEFT JOIN " . DB_PREFIX . "furniture_order_category_description cd ON (c.furniture_order_category_id = cd.furniture_order_category_id) WHERE c.parent_id = '" . (int)$parent_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY c.sort_order, cd.name ASC");
		
			foreach ($query->rows as $result) {
				$furniture_order_category_data[] = array(
					'furniture_order_category_id' => $result['furniture_order_category_id'],
					'name'        => $this->getPath($result['furniture_order_category_id'], $this->config->get('config_language_id')),
					'status'  	  => $result['status'],
					'sort_order'  => $result['sort_order']
				);
			
				$furniture_order_category_data = array_merge($furniture_order_category_data, $this->getCategories($result['furniture_order_category_id']));
			}	
	
			$this->cache->set('furniture_order_category.' . (int)$this->config->get('config_language_id') . '.' . (int)$parent_id, $furniture_order_category_data);
		}
		
		return $furniture_order_category_data;
	}
	
	public function getPath($furniture_order_category_id) {
		$query = $this->db->query("SELECT name, parent_id FROM " . DB_PREFIX . "furniture_order_category c LEFT JOIN " . DB_PREFIX . "furniture_order_category_description cd ON (c.furniture_order_category_id = cd.furniture_order_category_id) WHERE c.furniture_order_category_id = '" . (int)$furniture_order_category_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY c.sort_order, cd.name ASC");
		
		if ($query->row['parent_id']) {
			return $this->getPath($query->row['parent_id'], $this->config->get('config_language_id')) . $this->language->get('text_separator') . $query->row['name'];
		} else {
			return $query->row['name'];
		}
	}
	
	public function getCategoryDescriptions($furniture_order_category_id) {
		$furniture_order_category_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "furniture_order_category_description WHERE furniture_order_category_id = '" . (int)$furniture_order_category_id . "'");
		
		foreach ($query->rows as $result) {
			$furniture_order_category_description_data[$result['language_id']] = array(
				'seo_title'        => $result['seo_title'],
				'seo_h1'           => $result['seo_h1'],
				'name'             => $result['name'],
				'meta_keyword'     => $result['meta_keyword'],
				'meta_description' => $result['meta_description'],
				'description'      => $result['description']
			);
		}
		
		return $furniture_order_category_description_data;
	}	
	
	public function getCategoryStores($furniture_order_category_id) {
		$furniture_order_category_store_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "furniture_order_category_to_store WHERE furniture_order_category_id = '" . (int)$furniture_order_category_id . "'");

		foreach ($query->rows as $result) {
			$furniture_order_category_store_data[] = $result['store_id'];
		}
		
		return $furniture_order_category_store_data;
	}

	public function getCategoryLayouts($furniture_order_category_id) {
		$furniture_order_category_layout_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "furniture_order_category_to_layout WHERE furniture_order_category_id = '" . (int)$furniture_order_category_id . "'");
		
		foreach ($query->rows as $result) {
			$furniture_order_category_layout_data[$result['store_id']] = $result['layout_id'];
		}
		
		return $furniture_order_category_layout_data;
	}
		
	public function getTotalCategories() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "furniture_order_category");
		
		return $query->row['total'];
	}	
		
	public function getTotalCategoriesByImageId($image_id) {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "furniture_order_category WHERE image_id = '" . (int)$image_id . "'");
		
		return $query->row['total'];
	}

	public function getTotalCategoriesByLayoutId($layout_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "furniture_order_category_to_layout WHERE layout_id = '" . (int)$layout_id . "'");

		return $query->row['total'];
	}		

	public function getCategoriesByParentId($parent_id = 0) {
		$query = $this->db->query("SELECT *, (SELECT COUNT(parent_id) FROM " . DB_PREFIX . "furniture_order_category WHERE parent_id = c.furniture_order_category_id) AS children FROM " . DB_PREFIX . "furniture_order_category c LEFT JOIN " . DB_PREFIX . "furniture_order_category_description cd ON (c.furniture_order_category_id = cd.furniture_order_category_id) WHERE c.parent_id = '" . (int)$parent_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY c.sort_order, cd.name");
		
		return $query->rows;
	}

	public function getAllCategories() {
		$furniture_order_category_data = $this->cache->get('furniture_order_category.all.' . $this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id'));

		if (!$furniture_order_category_data || !is_array($furniture_order_category_data)) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "furniture_order_category c LEFT JOIN " . DB_PREFIX . "furniture_order_category_description cd ON (c.furniture_order_category_id = cd.furniture_order_category_id) LEFT JOIN " . DB_PREFIX . "furniture_order_category_to_store c2s ON (c.furniture_order_category_id = c2s.furniture_order_category_id) WHERE cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "'  ORDER BY c.parent_id, c.sort_order, cd.name");

			$furniture_order_category_data = array();
			foreach ($query->rows as $row) {
				$furniture_order_category_data[$row['parent_id']][$row['furniture_order_category_id']] = $row;
			}

			$this->cache->set('furniture_order_category.all.' . $this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id'), $furniture_order_category_data);
		}

		return $furniture_order_category_data;
	}
}
?>