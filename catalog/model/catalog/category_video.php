<?php
class ModelCatalogCategoryVideo extends Model {
	public function getCategory($category_id) {
		return $this->getCategories((int)$category_id, 'by_id');
	}
	
    public function getCategories($id = 0, $type = 'by_parent') {
        $cache_key = 'cat_video.cat.desc.cat.to.store.' . $this->config->get('config_language_id') . '.' . $this->config->get('config_store_id') . '.' . $id . '.' . $type;
        $categories = $this->cache->get($cache_key);

        if (!is_array($categories)) {
            static $data = null;
            $categories = array();

            if ($data === null) {
                $data = array();

                $sql = "SELECT * FROM " . DB_PREFIX . "category_video c NATURAL JOIN " . DB_PREFIX . "category_video_description cd NATURAL JOIN " . DB_PREFIX . "category_video_to_store c2s WHERE cd.language_id = '%d' AND c2s.store_id = '%d' AND c.category_video_status = '%d' ORDER BY c.category_video_parent_id, c.category_video_sort_order, cd.name";
                $query = $this->db->query(sprintf($sql, (int)$this->config->get('config_language_id'), (int)$this->config->get('config_store_id'), 1));

                foreach ($query->rows as $row) {
                    $data['by_id'][$row['category_video_id']] = $row;
                    $data['by_parent'][$row['category_video_parent_id']][] = $row;
                }
            }

            if (isset($data[$type][$id])) {
                $categories = $data[$type][$id];
            }

            $this->cache->set($cache_key, $categories);
        }

        return $categories;
    }

	public function treeCategory($category_id) {
		$cache_key = "tree.category.video." . $category_id;
		$treeCategory = $this->cache->get($cache_key);
		
		if ($treeCategory === false) {
			$treeCategory = array();
			$treeCategory[] = $category_id;

			for ( ; ; ) {
	    		$sql = "SELECT category_video_parent_id FROM " . DB_PREFIX . "category_video WHERE category_video_id = '%d' AND category_video_status = '%d'";
				$parent_id = $this->db->query(sprintf($sql, (int)$category_id, 1));
				
				if (isset($parent_id->row['category_video_parent_id']) && $parent_id->row['category_video_parent_id'] != 0) {
					$treeCategory[] = $parent_id->row['category_video_parent_id'];
					$category_id = $parent_id->row['category_video_parent_id'];
				} else {
		    		$this->cache->set($cache_key, $treeCategory);
					return $treeCategory;
				}
			}

			return 0;
		}

		return $treeCategory;
	}
}
?>