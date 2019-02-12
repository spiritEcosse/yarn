<?php
class ModelLocalisationNovaPochta extends Model {
    public function addDepart($data) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "depart SET name = '" . $this->db->escape($data['title_depart']) . "', city_id = '" . (int)$data['city_id'] . "', status = '" . (int)$data['status_depart'] . "'");
        $this->cache->delete('depart');
    }

    public function editDepart($depart_id, $data) {
        $this->db->query("UPDATE " . DB_PREFIX . "depart SET name = '" . $this->db->escape($data['title_depart']) . "', city_id = '" . (int)$data['city_id'] . "', status = '" . (int)$data['status_depart'] . "' WHERE depart_id = '" . (int)$depart_id . "'");
        $this->cache->delete('depart');
    }

    public function deleteDepart($depart_id) {
        $this->db->query("DELETE FROM " . DB_PREFIX . "depart WHERE depart_id = '" . (int)$depart_id . "'");
        $this->cache->delete('depart');
    }

    public function getDepart($depart_id) {
        $query = $this->db->query("SELECT *, city.name as title_city, depart.name as title_depart, z.name as title_zone, co.name as title_country, depart.status as status_depart FROM " . DB_PREFIX . "depart depart INNER JOIN " . DB_PREFIX . "city city ON (city.city_id = depart.city_id) INNER JOIN " . DB_PREFIX . "zone z ON(z.zone_id=city.zone_id) INNER JOIN " . DB_PREFIX . "country co ON (z.country_id = co.country_id) WHERE depart_id = '" . (int)$depart_id . "'");
        return $query->row;
    }

    public function getDeparts($data = array()) {
        if ($data) {
            $sql = "SELECT *, city.name as title_city, depart.name as title_depart, z.name as title_zone, co.name as title_country, depart.status as status_depart FROM " . DB_PREFIX . "depart depart INNER JOIN " . DB_PREFIX . "city city ON (city.city_id = depart.city_id) INNER JOIN " . DB_PREFIX . "zone z ON(z.zone_id=city.zone_id) INNER JOIN " . DB_PREFIX . "country co ON (z.country_id = co.country_id)";

            $sort_data = array(
                'title_country',
                'title_zone',
                'title_city',
                'title_depart',
            );

            if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
                $sql .= " ORDER BY " . $data['sort'];
            } else {
                $sql .= " ORDER BY title_depart";
            }

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
            $depart_data = $this->cache->get('depart');

            if (!$depart_data) {
                $query = $this->db->query("SELECT *, city.name as title_city, depart.name as title_depart, z.name as title_zone, co.name as title_country FROM " . DB_PREFIX . "depart depart INNER JOIN " . DB_PREFIX . "city city ON (city.city_id = depart.city_id) INNER JOIN " . DB_PREFIX . "zone z ON(z.zone_id=city.zone_id) INNER JOIN " . DB_PREFIX . "country co ON (z.country_id = co.country_id) ORDER BY title_depart ASC");
                $depart_data = $query->rows;
                $this->cache->set('depart', $depart_data);
            }

            return $depart_data;
        }
    }

    public function getTotalDepart() {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "depart depart INNER JOIN " . DB_PREFIX . "city city ON (city.city_id = depart.city_id) INNER JOIN " . DB_PREFIX . "zone z ON(z.zone_id=city.zone_id) INNER JOIN " . DB_PREFIX . "country co ON (z.country_id = co.country_id)");
        return $query->row['total'];
    }
}
?>