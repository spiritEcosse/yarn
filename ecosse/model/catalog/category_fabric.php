<?php
class ModelCatalogCategoryFabric extends Model {
	public function getCategoryFabric() {
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "fabric order by sort_order");
            return $query->rows;
        }
        
        public function delete($fabric_id) {
            $this->db->query("DELETE FROM " . DB_PREFIX . "fabric WHERE fabric_id='" . (int)$fabric_id . "'");
            $this->db->query("DELETE FROM " . DB_PREFIX . "product_fabric WHERE fabric_id = '" . (int)$fabric_id . "'");
            $this->db->query("DELETE FROM " . DB_PREFIX . "product_fabric_value WHERE fabric_id = '" . (int)$fabric_id . "'");
        }
        
        public function editCategoryFabric($data) {
            $this->db->query("DELETE FROM " . DB_PREFIX . "fabric");
            
            foreach ($data['category_fabric'] as $fabric) {
                $sql = "INSERT INTO " . DB_PREFIX . "fabric SET name='" . $fabric['name'] . "', sort_order='" . (int)$fabric['sort_order'] . "'";
                
                if ($fabric['fabric_id'] !== FALSE) {
                    $sql .= ", fabric_id='" . (int)$fabric['fabric_id'] . "'";
                }
                
                $this->db->query($sql);
            }
        }
        
        public function getFabricId($fabric_id) {
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "fabric WHERE fabric_id='" . (int)$fabric_id . "'");
            return $query->row;
        }
}

?>