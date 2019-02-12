<?php
class ModelCatalogCategoryVideo extends Model {
	public function addCategory($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "category_video SET category_video_parent_id = '" . (int)$data['category_video_parent_id'] . "', `column` = '" . (int)$data['column'] . "', category_video_sort_order = '" . (int)$data['category_video_sort_order'] . "', category_video_status = '" . (int)$data['category_video_status'] . "', date_modified = NOW(), date_added = NOW(), drop_down='" . $data['drop_down'] . "'");
	
		$category_video_id = $this->db->getLastId();
		
		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "category_video SET image = '" . $this->db->escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "' WHERE category_video_id = '" . (int)$category_video_id . "'");
		}
		
		foreach ($data['category_video_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "category_video_description SET category_video_id = '" . (int)$category_video_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', description = '" . $this->db->escape($value['description']) . "', seo_title = '" . $this->db->escape($value['seo_title']) . "', seo_h1 = '" . $this->db->escape($value['seo_h1']) . "'");
		}
		
		if (isset($data['category_video_store'])) {
			foreach ($data['category_video_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "category_video_to_store SET category_video_id = '" . (int)$category_video_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		if (isset($data['category_video_layout'])) {
			foreach ($data['category_video_layout'] as $store_id => $layout) {
				if ($layout['layout_id']) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "category_video_to_layout SET category_video_id = '" . (int)$category_video_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout['layout_id'] . "'");
				}
			}
		}
						
		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'category_video_id=" . (int)$category_video_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}
		
		$this->cache->delete('category_video');
	}
	
	public function editCategory($category_video_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "category_video SET category_video_parent_id = '" . (int)$data['category_video_parent_id'] . "', `column` = '" . (int)$data['column'] . "', category_video_sort_order = '" . (int)$data['category_video_sort_order'] . "', category_video_status = '" . (int)$data['category_video_status'] . "', date_modified = NOW(), drop_down='" . $data['drop_down'] . "' WHERE category_video_id = '" . (int)$category_video_id . "'");

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "category_video SET image = '" . $this->db->escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "' WHERE category_video_id = '" . (int)$category_video_id . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "category_video_description WHERE category_video_id = '" . (int)$category_video_id . "'");

		foreach ($data['category_video_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "category_video_description SET category_video_id = '" . (int)$category_video_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', description = '" . $this->db->escape($value['description']) . "', seo_title = '" . $this->db->escape($value['seo_title']) . "', seo_h1 = '" . $this->db->escape($value['seo_h1']) . "'");
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "category_video_to_store WHERE category_video_id = '" . (int)$category_video_id . "'");
		
		if (isset($data['category_video_store'])) {
			foreach ($data['category_video_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "category_video_to_store SET category_video_id = '" . (int)$category_video_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "category_video_to_layout WHERE category_video_id = '" . (int)$category_video_id . "'");

		if (isset($data['category_video_layout'])) {
			foreach ($data['category_video_layout'] as $store_id => $layout) {
				if ($layout['layout_id']) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "category_video_to_layout SET category_video_id = '" . (int)$category_video_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout['layout_id'] . "'");
				}
			}
		}
						
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'category_video_id=" . (int)$category_video_id. "'");
		
		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'category_video_id=" . (int)$category_video_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}
		
		$this->cache->delete('category_video');
	}
	
	public function deleteCategory($category_video_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "category_video WHERE category_video_id = '" . (int)$category_video_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "category_video_description WHERE category_video_id = '" . (int)$category_video_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "category_video_to_store WHERE category_video_id = '" . (int)$category_video_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "category_video_to_layout WHERE category_video_id = '" . (int)$category_video_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "video_to_category WHERE category_video_id = '" . (int)$category_video_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'category_video_id=" . (int)$category_video_id . "'");
		
		$query = $this->db->query("SELECT category_video_id FROM " . DB_PREFIX . "category_video WHERE category_video_parent_id = '" . (int)$category_video_id . "'");

		foreach ($query->rows as $result) {
			$this->deleteCategory($result['category_video_id']);
		}
		
		$this->cache->delete('category_video');
	} 

	public function getCategory($category_video_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'category_video_id=" . (int)$category_video_id . "') AS keyword FROM " . DB_PREFIX . "category_video WHERE category_video_id = '" . (int)$category_video_id . "'");
		
		return $query->row;
	} 
	
	public function getCategories($category_video_parent_id = 0) {
		$category_video_data = $this->cache->get('category_video.' . (int)$this->config->get('config_language_id') . '.' . (int)$category_video_parent_id);
	
		if (!$category_video_data) {
			$category_video_data = array();
		
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_video c LEFT JOIN " . DB_PREFIX . "category_video_description cd ON (c.category_video_id = cd.category_video_id) WHERE c.category_video_parent_id = '" . (int)$category_video_parent_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY c.category_video_sort_order, cd.name ASC");
		
			foreach ($query->rows as $result) {
				$category_video_data[] = array(
					'category_video_id' => $result['category_video_id'],
					'name'        => $this->getPath($result['category_video_id'], $this->config->get('config_language_id')),
					'category_video_status'  	  => $result['category_video_status'],
					'category_video_sort_order'  => $result['category_video_sort_order']
				);
			
				$category_video_data = array_merge($category_video_data, $this->getCategories($result['category_video_id']));
			}	
	
			$this->cache->set('category_video.' . (int)$this->config->get('config_language_id') . '.' . (int)$category_video_parent_id, $category_video_data);
		}
		
		return $category_video_data;
	}
	
	public function getPath($category_video_id) {
		$query = $this->db->query("SELECT name, category_video_parent_id FROM " . DB_PREFIX . "category_video c LEFT JOIN " . DB_PREFIX . "category_video_description cd ON (c.category_video_id = cd.category_video_id) WHERE c.category_video_id = '" . (int)$category_video_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY c.category_video_sort_order, cd.name ASC");
		
		if ($query->row['category_video_parent_id']) {
			return $this->getPath($query->row['category_video_parent_id'], $this->config->get('config_language_id')) . $this->language->get('text_separator') . $query->row['name'];
		} else {
			return $query->row['name'];
		}
	}
	
	public function getCategoryDescriptions($category_video_id) {
		$category_video_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_video_description WHERE category_video_id = '" . (int)$category_video_id . "'");
		
		foreach ($query->rows as $result) {
			$category_video_description_data[$result['language_id']] = array(
				'seo_title'        => $result['seo_title'],
				'seo_h1'           => $result['seo_h1'],
				'name'             => $result['name'],
				'meta_keyword'     => $result['meta_keyword'],
				'meta_description' => $result['meta_description'],
				'description'      => $result['description']
			);
		}
		
		return $category_video_description_data;
	}	
	
	public function getCategoryStores($category_video_id) {
		$category_video_store_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_video_to_store WHERE category_video_id = '" . (int)$category_video_id . "'");

		foreach ($query->rows as $result) {
			$category_video_store_data[] = $result['store_id'];
		}
		
		return $category_video_store_data;
	}

	public function getCategoryLayouts($category_video_id) {
		$category_video_layout_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_video_to_layout WHERE category_video_id = '" . (int)$category_video_id . "'");
		
		foreach ($query->rows as $result) {
			$category_video_layout_data[$result['store_id']] = $result['layout_id'];
		}
		
		return $category_video_layout_data;
	}
		
	public function getTotalCategories() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "category_video");
		
		return $query->row['total'];
	}	
		
	public function getTotalCategoriesByImageId($image_id) {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "category_video WHERE image_id = '" . (int)$image_id . "'");
		
		return $query->row['total'];
	}

	public function getTotalCategoriesByLayoutId($layout_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "category_video_to_layout WHERE layout_id = '" . (int)$layout_id . "'");

		return $query->row['total'];
	}		

	public function getCategoriesByParentId($category_video_parent_id = 0) {
		$query = $this->db->query("SELECT *, (SELECT COUNT(category_video_parent_id) FROM " . DB_PREFIX . "category_video WHERE category_video_parent_id = c.category_video_id) AS children FROM " . DB_PREFIX . "category_video c LEFT JOIN " . DB_PREFIX . "category_video_description cd ON (c.category_video_id = cd.category_video_id) WHERE c.category_video_parent_id = '" . (int)$category_video_parent_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY c.category_video_sort_order, cd.name");
		
		return $query->rows;
	}

	public function getAllCategories() {
		$category_video_data = $this->cache->get('category_video.all.' . $this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id'));

		if (!$category_video_data || !is_array($category_video_data)) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_video c LEFT JOIN " . DB_PREFIX . "category_video_description cd ON (c.category_video_id = cd.category_video_id) LEFT JOIN " . DB_PREFIX . "category_video_to_store c2s ON (c.category_video_id = c2s.category_video_id) WHERE cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "'  ORDER BY c.category_video_parent_id, c.category_video_sort_order, cd.name");

			$category_video_data = array();
			foreach ($query->rows as $row) {
				$category_video_data[$row['category_video_parent_id']][$row['category_video_id']] = $row;
			}

			$this->cache->set('category_video.all.' . $this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id'), $category_video_data);
		}

		return $category_video_data;
	}
}
?>