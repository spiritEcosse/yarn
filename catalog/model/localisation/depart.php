<?php
class ModelLocalisationDepart extends Model {
    public function getDepart($depart_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "depart WHERE depart_id = '" . (int)$depart_id . "'");

		return $query->row;
    }

    public function getDeparts($data = array()) {
        $depart_data = $this->cache->get('depart.status');

		if (!$depart_data) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "depart WHERE status = '1' ORDER BY name ASC");

			$depart_data = $query->rows;

			$this->cache->set('depart.status', $depart_data);
		}

		return $depart_data;
    }

    public function getDepartsByCityId($city_id) {
		$depart_data = $this->cache->get('depart.' . (int)$city_id);

		if (!$depart_data) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "depart WHERE city_id = '" . (int)$city_id . "' AND status = '1' ORDER BY name");

			$depart_data = $query->rows;

			$this->cache->set('depart.' . (int)$city_id, $depart_data);
		}

		return $depart_data;
	}
}
?>