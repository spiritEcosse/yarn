<?php
class ModelCatalogArticle extends Model {
    public function getarticle($article_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "article WHERE article_id = '" . (int)$article_id . "' ");
        return $query->row;
    }

    public function editarticle($article_id, $data) {
        $this->db->query("UPDATE " . DB_PREFIX . "article SET article_description = '" . $data['article_description'] . "', name='"  . $data['name'] . "', article_link='"  . $data['article_link'] . "', sort_order='"  . $data['sort_order'] . "', article_status = '" . $data['article_status'] . "' WHERE article_id = '" . (int)$article_id . "' ");

        $this->addCategoryarticle($data, $article_id);
    }

    public function addarticle($data) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "article SET article_description = '" . $data['article_description'] . "', name='"  . $data['name'] . "', article_link='"  . $data['article_link'] . "', sort_order='"  . $data['sort_order'] . "', article_status = '" . $data['article_status'] . "', article_date_added = NOW() ");
        $article_id = $this->db->getLastId();
        $this->addCategoryarticle($data, $article_id);
    }

    public function addCategoryarticle($data, $article_id) {
        $this->db->query("DELETE FROM " . DB_PREFIX . "article_to_category WHERE article_id = '" . (int)$article_id . "'");

        if (isset($data['article_category'])) {
            $this->db->query("DELETE FROM " . DB_PREFIX . "article_to_category WHERE article_id = '" . (int)$article_id . "' AND category_article_id = '" . (int)$data['main_category_article_id'] . "'");

            foreach ($data['article_category'] as $category_article_id) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "article_to_category SET article_id = '" . (int)$article_id . "', category_article_id = '" . (int)$category_article_id . "'");
            }
        }

        if (isset($data['main_category_article_id']) && $data['main_category_article_id'] > 0) {
            $this->db->query("DELETE FROM " . DB_PREFIX . "article_to_category WHERE article_id = '" . (int)$article_id . "' AND category_article_id = '" . (int)$data['main_category_article_id'] . "'");
            $this->db->query("INSERT INTO " . DB_PREFIX . "article_to_category SET article_id = '" . (int)$article_id . "', category_article_id = '" . (int)$data['main_category_article_id'] . "', main_category = 1");
            $this->getarticleMainCategoryId($article_id);

        } elseif (isset($data['article_category'][0])) {
            $this->db->query("UPDATE " . DB_PREFIX . "article_to_category SET main_category = 1 WHERE article_id = '" . (int)$article_id . "' AND category_article_id = '" . (int)$data['article_category'][0] . "'");
        }
    }

    public function deletearticle($article_id) {
        $this->db->query("DELETE FROM " . DB_PREFIX . "article WHERE article_id = '" . (int)$article_id . "'  ");
    }

    public function getarticleCategories($article_id) {
        $article_category_data = array();

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "article_to_category WHERE article_id = '" . (int)$article_id . "'");

        foreach ($query->rows as $result) {
            $article_category_data[] = $result['category_article_id'];
        }

        return $article_category_data;
    }

    public function getarticleMainCategoryId($article_id) {
        $query = $this->db->query("SELECT category_article_id FROM " . DB_PREFIX . "article_to_category WHERE article_id = '" . (int)$article_id . "' AND main_category = '1' LIMIT 1");

        return ($query->num_rows ? (int)$query->row['category_article_id'] : 0);
    }

    public function getarticles($data) {
        $sql = "SELECT * FROM " . DB_PREFIX . "article ORDER BY " . $data['sort'] . " " . $data['order'];
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getTotalarticles() {
        $query = $this->db->query("SELECT count(*) as count FROM " . DB_PREFIX . "article");
        return $query->row['count'];
    }

    public function copyarticle($article_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "article WHERE article_id = '" . (int)$article_id . "' ");

        if ($query->num_rows) {
            $data = array();

            $data = $query->row;
            $data['article_status'] = '0';
            $data['sort_order'] += 1;

            $data['article_category'] = $this->getarticleCategories($article_id);
            $data['main_category_article_id'] = $this->getarticleMainCategoryId($article_id);
            $this->addarticle($data);
        }
    }
}
?>
