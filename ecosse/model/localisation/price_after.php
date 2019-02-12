<?php 
class ModelLocalisationPriceAfter extends Model {
	public function addPriceAfter($data) {
		foreach ($data['price_after'] as $language_id => $value) {
			if (isset($price_after_id)) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "price_after SET price_after_id = '" . (int)$price_after_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
			} else {
				$this->db->query("INSERT INTO " . DB_PREFIX . "price_after SET language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
				
				$price_after_id = $this->db->getLastId();
			}
		}
		
		$this->cache->delete('price_after');
	}
	
	public function editPriceAfter($price_after_id, $data) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "price_after WHERE price_after_id = '" . (int)$price_after_id . "'");

		foreach ($data['price_after'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "price_after SET price_after_id = '" . (int)$price_after_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}
		
		$this->cache->delete('price_after');
	}
	
	public function deletePriceAfter($price_after_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "price_after WHERE price_after_id = '" . (int)$price_after_id . "'");
	
		$this->cache->delete('price_after');
	}
	
	public function getPriceAfter($price_after_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "price_after WHERE price_after_id = '" . (int)$price_after_id . "' AND language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		return $query->row;
	}
	
	public function getPriceAfters($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "price_after WHERE language_id = '" . (int)$this->config->get('config_language_id') . "'";
      		
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
			$price_after_data = $this->cache->get('price_after.' . (int)$this->config->get('config_language_id'));
		
			if (!$price_after_data) {
				$query = $this->db->query("SELECT price_after_id, name FROM " . DB_PREFIX . "price_after WHERE language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY name");
	
				$price_after_data = $query->rows;
			
				$this->cache->set('price_after.' . (int)$this->config->get('config_language_id'), $price_after_data);
			}	
	
			return $price_after_data;			
		}
	}
	
	public function getPriceAfterDescriptions($price_after_id) {
		$price_after_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "price_after WHERE price_after_id = '" . (int)$price_after_id . "'");
		
		foreach ($query->rows as $result) {
			$price_after_data[$result['language_id']] = array('name' => $result['name']);
		}
		
		return $price_after_data;
	}
	
	public function getTotalPriceAfters() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "price_after WHERE language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		return $query->row['total'];
	}

    public function getAfterByName($name) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "price_after WHERE name='" . $name . "' AND language_id = '" . (int)$this->config->get('config_language_id') . "'");
        return $query->row;
    }
}
?>