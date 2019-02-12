<?php
class ModelCatalogVideo extends Model {
    public function getVideo($video_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "video WHERE video_id = '" . (int)$video_id . "' ");
        return $query->row;
    }

    public function editVideo($video_id, $data) {
        $this->db->query("UPDATE " . DB_PREFIX . "video SET video_description = '" . $data['video_description'] . "', name='"  . $data['name'] . "', video_link='"  . $data['video_link'] . "', sort_order='"  . $data['sort_order'] . "', video_status = '" . $data['video_status'] . "' WHERE video_id = '" . (int)$video_id . "' ");

        $this->addCategoryVideo($data, $video_id);
    }

    public function addVideo($data) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "video SET video_description = '" . $data['video_description'] . "', name='"  . $data['name'] . "', video_link='"  . $data['video_link'] . "', sort_order='"  . $data['sort_order'] . "', video_status = '" . $data['video_status'] . "', video_date_added = NOW() ");
        $video_id = $this->db->getLastId();
        $this->addCategoryVideo($data, $video_id);
    }

    public function addCategoryVideo($data, $video_id) {
        $this->db->query("DELETE FROM " . DB_PREFIX . "video_to_category WHERE video_id = '" . (int)$video_id . "'");

        if (isset($data['video_category'])) {
            $this->db->query("DELETE FROM " . DB_PREFIX . "video_to_category WHERE video_id = '" . (int)$video_id . "' AND category_video_id = '" . (int)$data['main_category_video_id'] . "'");

            foreach ($data['video_category'] as $category_video_id) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "video_to_category SET video_id = '" . (int)$video_id . "', category_video_id = '" . (int)$category_video_id . "'");
            }
        }

        if (isset($data['main_category_video_id']) && $data['main_category_video_id'] > 0) {
            $this->db->query("DELETE FROM " . DB_PREFIX . "video_to_category WHERE video_id = '" . (int)$video_id . "' AND category_video_id = '" . (int)$data['main_category_video_id'] . "'");
            $this->db->query("INSERT INTO " . DB_PREFIX . "video_to_category SET video_id = '" . (int)$video_id . "', category_video_id = '" . (int)$data['main_category_video_id'] . "', main_category = 1");
            $this->getVideoMainCategoryId($video_id);

        } elseif (isset($data['video_category'][0])) {
            $this->db->query("UPDATE " . DB_PREFIX . "video_to_category SET main_category = 1 WHERE video_id = '" . (int)$video_id . "' AND category_video_id = '" . (int)$data['video_category'][0] . "'");
        }
    }

    public function deleteVideo($video_id) {
        $this->db->query("DELETE FROM " . DB_PREFIX . "video WHERE video_id = '" . (int)$video_id . "'  ");
    }

    public function getVideoCategories($video_id) {
        $video_category_data = array();

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "video_to_category WHERE video_id = '" . (int)$video_id . "'");

        foreach ($query->rows as $result) {
            $video_category_data[] = $result['category_video_id'];
        }

        return $video_category_data;
    }

    public function getVideoMainCategoryId($video_id) {
        $query = $this->db->query("SELECT category_video_id FROM " . DB_PREFIX . "video_to_category WHERE video_id = '" . (int)$video_id . "' AND main_category = '1' LIMIT 1");

        return ($query->num_rows ? (int)$query->row['category_video_id'] : 0);
    }

    public function getVideos($data) {
        $sql = "SELECT * FROM " . DB_PREFIX . "video ORDER BY " . $data['sort'] . " " . $data['order'];
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getTotalVideos() {
        $query = $this->db->query("SELECT count(*) as count FROM " . DB_PREFIX . "video");
        return $query->row['count'];
    }

    public function copyVideo($video_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "video WHERE video_id = '" . (int)$video_id . "' ");

        if ($query->num_rows) {
            $data = array();

            $data = $query->row;
            $data['video_status'] = '0';
            $data['sort_order'] += 1;

            $data['video_category'] = $this->getVideoCategories($video_id);
            $data['main_category_video_id'] = $this->getVideoMainCategoryId($video_id);
            $this->addVideo($data);
        }
    }
}
?>
