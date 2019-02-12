<?php
class ModelCatalogArticle extends Model {
    public function getarticlesByCategory($data) {
        $property_data = array();
        $property_data[] = 1;
        $property_data[] = (int)$data['category_article_id'];
        $property_data[] = 1;

        $sql = "SELECT * FROM " . DB_PREFIX . "article v NATURAL JOIN " . DB_PREFIX . "article_to_category v2c
        NATURAL JOIN " . DB_PREFIX . "category_article cv WHERE cv.category_article_status = '%d' and v2c.category_article_id = '%d' and v.article_status = '%d' ";

        $sort_data = array(
            'v_name'		=> 'v.name',
            'v_sort_order'	=> 'v.sort_order',
            'v_article_date_added' => 'v.article_date_added'
        );

        $sql .= " ORDER BY ";

        if (isset($data['sort']) && array_key_exists($data['sort'], $sort_data)) {
            $data['sort'] = $sort_data[$data['sort']];

            if ($data['sort'] == 'v_name') {
                $sql .= " LCASE(" . $data['sort'] . ")";
            } else {
                $sql .= $data['sort'];
            }
        } else {
            $sql .= " sort_order";
        }

        if (isset($data['order']) && ($data['order'] == 'DESC')) {
            $sql .= " DESC, LCASE(v.name) DESC";
        } else {
            $sql .= " ASC, LCASE(v.name) ASC";
        }

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }

            $property_data[] = (int)$data['start'];
            $property_data[] = (int)$data['limit'];
            $sql .= " LIMIT %d, %d";
        }

        $query =  $this->db->query(vsprintf($sql, $property_data));
        return $query->rows;
    }

    public function getTotalarticles($data) {
        $sql = "SELECT count(*) as count FROM " . DB_PREFIX . "article v NATURAL JOIN " . DB_PREFIX . "article_to_category v2c NATURAL JOIN " . DB_PREFIX . "category_article cv WHERE cv.category_article_status = '1' and v2c.category_article_id = '" . (int)$data['category_article_id'] . "' and v.article_status = '1' ";

        $query =  $this->db->query($sql);
        return $query->row['count'];
    }

    public function getarticles() {
        $status = 1;
        $sql = "SELECT * FROM " . DB_PREFIX . "article v WHERE v.article_status = '%d' ";

        $query = $this->db->query(sprintf($sql, $status));
        return $query->rows;
    }
}
?>