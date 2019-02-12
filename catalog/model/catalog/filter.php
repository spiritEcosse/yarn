<?php

class ModelCatalogFilter extends Model {

    public function filterGetOption($data = array()) {
        $this->load->model('catalog/product');
        $property_data = array();

        $property_data[] = 1;
        $property_data[] = $this->config->get('config_language_id');

        $sql = "SELECT cod.name, cod.option_id FROM " . DB_PREFIX . "product_to_value pv NATURAL JOIN " . DB_PREFIX . "product p";

        if ($data['special'] == true) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "product_special ps ON(ps.product_id = p.product_id) ";
        }

        if (!empty($data['filter_name'])) {
            $sql .= " NATURAL JOIN " . DB_PREFIX . "product_description pd LEFT JOIN " . DB_PREFIX . "product_tag pt ON(pd.product_id = pt.product_id)";
        }

        $sql .= " INNER JOIN " . DB_PREFIX . "category_option co ON(co.option_id = pv.option_id) INNER JOIN " . DB_PREFIX . "category_option_description cod ON(cod.option_id = co.option_id)";

        if (isset($data['filter_category_id']) && $data['filter_category_id'] != null) {
            $sql .= " INNER JOIN " . DB_PREFIX . "product_to_category p2c ON(p.product_id = p2c.product_id) INNER JOIN " . DB_PREFIX . "category_option_to_category cotc ON(cod.option_id = cotc.option_id)";
        }

        if (isset($data['filter_name']) && !empty($data['filter_name'])) {
            $sql .= 'LEFT JOIN ' . DB_PREFIX . 'product_option_value AS pov ON pov.product_id = p.product_id ';
            $sql .= 'LEFT JOIN ' . DB_PREFIX . 'option_value_description AS ovd ON pov.option_value_id = ovd.option_value_id ';
        }

        $sql .= " WHERE co.status = '%d' AND cod.language_id = '%d'";

        if (isset($data['filter_category_id']) && $data['filter_category_id'] != null) {
            $property_data[] = (int)$data['filter_category_id'];
            $sql .= " AND cotc.category_id = '%d'";
        }

        $data_query = $this->model_catalog_product->filterSearch($data);
        $property_data = array_merge($property_data, $data_query['values']);
        $sql .= " " . $data_query['sql'];
        $sql .= " GROUP BY pv.option_id ORDER BY co.sort_order";
        $query = $this->db->query(vsprintf($sql, $property_data));

        $result = $query->rows;
        return $result;
    }

    public function filterGetOptionValue($data = array(), $option_id) {
        $this->load->model('catalog/product');
        $property_data = array();
        $property_data[] = (int)$option_id;
        $property_data[] = (int)$this->config->get('config_language_id');

        $sql = "SELECT covd.name, covd.value_id, covd.option_id FROM " . DB_PREFIX . "product_to_value pv NATURAL JOIN " . DB_PREFIX . "product p";

        if ($data['special'] == true) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "product_special ps ON(ps.product_id = p.product_id) ";
        }

        if (!empty($data['filter_name'])) {
            $sql .= " NATURAL JOIN " . DB_PREFIX . "product_description pd LEFT JOIN " . DB_PREFIX . "product_tag pt ON(pd.product_id = pt.product_id)";
        }

        $sql .= " INNER JOIN " . DB_PREFIX . "category_option_value_description covd ON(covd.value_id = pv.value_id)";

        if (isset($data['filter_category_id']) && $data['filter_category_id'] != null) {
            $sql .= " INNER JOIN " . DB_PREFIX . "product_to_category p2c ON(p.product_id = p2c.product_id) INNER JOIN " . DB_PREFIX . "category_option_to_category cotc ON(covd.option_id = cotc.option_id)";
        }

        if (isset($data['filter_name']) && !empty($data['filter_name'])) {
            $sql .= 'LEFT JOIN ' . DB_PREFIX . 'product_option_value AS pov ON pov.product_id = p.product_id ';
            $sql .= 'LEFT JOIN ' . DB_PREFIX . 'option_value_description AS ovd ON pov.option_value_id = ovd.option_value_id ';
        }

        $sql .= " WHERE covd.option_id = '%d' AND covd.language_id = '%d'";

        if (isset($data['filter_category_id']) && $data['filter_category_id'] != null) {
            $property_data[] = (int)$data['filter_category_id'];
            $sql .= " AND cotc.category_id = '%d'";
        }

        $data_query = $this->model_catalog_product->filterSearch($data);
        $property_data = array_merge($property_data, $data_query['values']);
        $sql .= " " . $data_query['sql'];

        $sql .= " GROUP BY covd.value_id ORDER BY covd.name = 0, -covd.name, covd.name";
        $query = $this->db->query(vsprintf($sql, $property_data));

        $result = $query->rows;
        return $result;
    }

    public function getOptionValuesByProductId($product_id, $option_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_option_value cov LEFT JOIN " . DB_PREFIX . "category_option_value_description covd ON (cov.value_id = covd.value_id) LEFT JOIN " . DB_PREFIX . "product_to_value p2v ON (cov.value_id = p2v.value_id) WHERE p2v.product_id = '" . (int)$product_id . "' AND cov.option_id = '" . (int)$option_id . "' AND covd.language_id = '" . (int)$this->config->get('config_language_id') . "' GROUP BY cov.value_id");

        return $query->rows;
    }

    public function getOptionValues($option_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_option_value cov JOIN " . DB_PREFIX . "category_option_value_description covd ON (cov.value_id = covd.value_id) WHERE cov.option_id = '" . (int)$option_id . "' AND covd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

        return $query->rows;
    }

    public function getTotalCategoryValueProducts($category_id, $value_id) {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product_to_category p2c LEFT JOIN " . DB_PREFIX . "product p ON (p2c.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_to_value p2v ON (p.product_id = p2v.product_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2c.category_id = '" . (int)$category_id . "' AND p2v.value_id = '" . (int)$value_id . "'");

        return $query->row['total'];
    }

    public function getAliasFromFilterByQuery($query) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE query = 'filter=" . $query . "' ");
        return $query->row;
    }

    public function getAliasFromFilter($keyword) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE keyword = '" . $this->db->escape($keyword) . "' ");
        return $query->row;
    }
}

?>