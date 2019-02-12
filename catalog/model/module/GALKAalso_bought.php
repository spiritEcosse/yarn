<?php
class ModelModuleGalkaAlsoBought extends Model {
	public function getAlsoBoughtProducts($data) {
		
		$cache = md5(http_build_query($data));
		
		$alsob_cache_file = glob(DIR_CACHE . 'cache.GALKAalso_bought_product.' . (int)$data['filter_product_id']. '.' . $cache . '.*' );
		
		if ($alsob_cache_file) {
			$file = $alsob_cache_file[0];
			$time = substr(strrchr($file, '.'), 1);
			
			if (time() - ($time - 3600) > $data['dc_period'] ) {
				if (file_exists($file)) {
					unlink($file);
					clearstatcache();
				}
			}
		}
		
		$product_data = $this->cache->get('GALKAalso_bought_product.' . (int)$data['filter_product_id'] . '.' . $cache);

		if (!$product_data) {
			$orders_ids = '';
		
			$sql = "SELECT GROUP_CONCAT( DISTINCT op.order_id ORDER BY op.order_id DESC SEPARATOR  ',' ) AS group_orders
					FROM  `" . DB_PREFIX . "order_product` op
					LEFT JOIN  `" . DB_PREFIX . "order` o ON ( op.order_id = o.order_id )
					";

			$query = $this->db->query($sql);

			if ($query->row['group_orders'] != "") {
				$orders_ids = $query->row['group_orders'];
				
				$sql = "SELECT op.product_id, SUM(op.quantity) as no_sells FROM " . DB_PREFIX . "order_product op   
						WHERE op.product_id !='" . (int)$data['filter_product_id'] . "'  
						GROUP BY op.product_id";
				
				$sort_data = array(
					'no_sells',
					'op.order_id',
					'op.quantity',
					'op.total'
				);	
				
				if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
					$sql .= " ORDER BY " . $data['sort'];
				} else {
					$sql .= " ORDER BY op.order_id";	
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
				$product_data = $query->rows;
				$this->cache->set('GALKAalso_bought_product.' . (int)$data['filter_product_id'] . '.' . $cache, $product_data);
			}
		}
		
		return $product_data;
	}
}
?>