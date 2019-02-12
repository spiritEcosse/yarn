<?php 
class ModelModuleGalkaAlsoBought extends Model {

	public function getOrderStatuses($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "order_status 
				WHERE language_id = '" . (int)$this->config->get('config_language_id') . "' 
				ORDER BY order_status_id ASC";	
			
		$query = $this->db->query($sql);
		
		return $query->rows;
	}
}
?>