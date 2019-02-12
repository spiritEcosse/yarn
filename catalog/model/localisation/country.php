<?php
class ModelLocalisationCountry extends Model {
	public function getCountry($country_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "country WHERE country_id = '" . (int)$country_id . "' AND status = '1'");
		
		return $query->row;
	}

    public function getCountryByNovaPochta() {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "country WHERE status = '1' and nova_pochta = '1' ");
        return $query->row;
    }

    public function getCountries() {
		$country_data = $this->cache->get('country.status');
		
		if (!$country_data) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "country WHERE status = '1' ORDER BY nova_pochta DESC, name ASC");
	
			$country_data = $query->rows;
		
			$this->cache->set('country.status', $country_data);
		}

		return $country_data;
	}
}
?>