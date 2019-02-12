<?php
class ModelDesignBanner extends Model {	
	public function getBanner($banner_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "banner_image bi LEFT JOIN " . DB_PREFIX . "banner_image_description bid ON (bi.banner_image_id  = bid.banner_image_id) WHERE bi.banner_id = '" . (int)$banner_id . "' AND bid.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		return $query->rows;
	}

	public function getBannerName($banner_id) {
		$data = array();
		$data[] = $banner_id;
		$data[] = 1;

		$sql = "SELECT * FROM " . DB_PREFIX . "banner WHERE banner_id = '%d' AND status = '%d' ";
		$query = $this->db->query(vsprintf($sql, $data));
		return $query->row;
	}
}
?>