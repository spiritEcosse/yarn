<?php 
class ModelLocalisationPricePrefix extends Model {
	public function addPricePrefix($data) {
		foreach ($data['price_prefix'] as $language_id => $value) {
			if (isset($price_prefix_id)) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "price_prefix SET price_prefix_id = '" . (int)$price_prefix_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
			} else {
				$this->db->query("INSERT INTO " . DB_PREFIX . "price_prefix SET language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
				
				$price_prefix_id = $this->db->getLastId();
			}
		}
		
		$this->cache->delete('price_prefix');
	}

	public function editPricePrefix($price_prefix_id, $data) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "price_prefix WHERE price_prefix_id = '" . (int)$price_prefix_id . "'");

		foreach ($data['price_prefix'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "price_prefix SET price_prefix_id = '" . (int)$price_prefix_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}
		
		$this->cache->delete('price_prefix');
	}
	
	public function deletePricePrefix($price_prefix_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "price_prefix WHERE price_prefix_id = '" . (int)$price_prefix_id . "'");
	
		$this->cache->delete('price_prefix');
	}
	
	public function getPricePrefix($price_prefix_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "price_prefix WHERE price_prefix_id = '" . (int)$price_prefix_id . "' AND language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		return $query->row;
	}
	
	public function getPricePrefixes($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "price_prefix WHERE language_id = '" . (int)$this->config->get('config_language_id') . "'";
      		
			$sql .= " ORDER BY name";	
			
			if (isset($data['order']) && ($data['order'] == 'DESC')) {
				$sql .= " DESC";
			} else {
				$sql .= " ASC";
			}
			
			if (isset($data['start']) || isset($data['limit'])) {
				if ($data['start'] < 0) {
					$data['start'] = 0;
				}					
	
				if ($data['limit'] < 1) {
					$data['limit'] = 20;
				}	
			
				$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
			}			
			
			$query = $this->db->query($sql);
		
			return $query->rows;
		} else {
			$price_prefix_data = $this->cache->get('price_prefix.' . (int)$this->config->get('config_language_id'));
		
			if (!$price_prefix_data) {
				$query = $this->db->query("SELECT price_prefix_id, name FROM " . DB_PREFIX . "price_prefix WHERE language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY name");
	
				$price_prefix_data = $query->rows;
			
				$this->cache->set('price_prefix.' . (int)$this->config->get('config_language_id'), $price_prefix_data);
			}	
	
			return $price_prefix_data;			
		}
	}
	
	public function getPricePrefixDescriptions($price_prefix_id) {
		$price_prefix_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "price_prefix WHERE price_prefix_id = '" . (int)$price_prefix_id . "'");
		
		foreach ($query->rows as $result) {
			$price_prefix_data[$result['language_id']] = array('name' => $result['name']);
		}
		
		return $price_prefix_data;
	}
	
	public function getTotalPricePrefixes() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "price_prefix WHERE language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		return $query->row['total'];
	}

    public function getPrefixByName($name) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "price_prefix WHERE name='" . $name . "' AND language_id = '" . (int)$this->config->get('config_language_id') . "'");
        return $query->row;
    }
}
?>