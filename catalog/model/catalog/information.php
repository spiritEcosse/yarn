<?php
class ModelCatalogInformation extends Model {
	public function getInformation($information_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "information i LEFT JOIN " . DB_PREFIX . "information_description id ON (i.information_id = id.information_id) LEFT JOIN " . DB_PREFIX . "information_to_store i2s ON (i.information_id = i2s.information_id) WHERE i.information_id = '" . (int)$information_id . "' AND id.language_id = '" . (int)$this->config->get('config_language_id') . "' AND i2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND i.status = '1'");
	
		return $query->row;
	}
	
	public function getInformations() {
		$cache_key = 'info.all';
		$informations = $this->cache->get($cache_key);

		if ($informations === false) {
			$sql = "SELECT * FROM " . DB_PREFIX . "information i NATURAL JOIN " . DB_PREFIX . "information_description id NATURAL JOIN " . DB_PREFIX . "information_to_store i2s WHERE id.language_id = '%d' AND i2s.store_id = '%d' AND i.status = '%d' AND i.sort_order <> '-1' ORDER BY i.sort_order, LCASE(id.title) ASC";
			$query = $this->db->query(sprintf($sql, (int)$this->config->get('config_language_id'), (int)$this->config->get('config_store_id'), 1));
			$informations = $query->rows;
			$this->cache->set($cache_key, $informations);
		}
		
		return $informations;
	}
	
	public function getInformationLayoutId($information_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "information_to_layout WHERE information_id = '" . (int)$information_id . "' AND store_id = '" . (int)$this->config->get('config_store_id') . "'");
		
		if ($query->num_rows) {
			return $query->row['layout_id'];
		} else {
			return $this->config->get('config_layout_information');
		}
	}

    public function getCategories($category_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "information_description, 
            " . DB_PREFIX . " information,
            " . DB_PREFIX . "information_to_category
            WHERE information_to_category.category_id='" . $category_id . "' and
            information_description.information_id=information.information_id
            and
            information_description.information_id=information_to_category.information_id");
        
        return $query->rows;
    }
}
?>