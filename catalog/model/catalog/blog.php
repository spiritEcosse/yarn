<?php
class ModelCatalogBlog extends Model {
	public function getBlog($blog_id) {
        if ($this->customer->isLogged()) {
			$customer_query = " AND (c.customer_group_id = '".(int)$this->customer->getCustomerGroupId()."' OR c.customer_group_id = '".(int)$this->config->get('config_customer_group_id')."')";
		} else {
			$customer_query = " AND c.customer_group_id = '".(int)$this->config->get('config_customer_group_id')."'";
		}

		$row = $this->cache->get('blog.blogi');
		if (!isset($row[$blog_id])) {
			$query         = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "blog c
			LEFT JOIN " . DB_PREFIX . "blog_description cd ON (c.blog_id = cd.blog_id)
			LEFT JOIN " . DB_PREFIX . "blog_to_store c2s ON (c.blog_id = c2s.blog_id)
			WHERE c.blog_id = '" . (int) $blog_id . "' AND cd.language_id = '" . (int) $this->config->get('config_language_id') . "' AND c2s.store_id = '" . (int) $this->config->get('config_store_id') . "'
			AND c.status = '1'
			".$customer_query."
			");
			$row[$blog_id] = $query->row;
			$this->cache->set('blog.blogi', $row[$blog_id]);
		}

		return $row[$blog_id];
	}

	public function getBlogies($parent_id = 0) {
        if ($this->customer->isLogged()) {
			$customer_query = " AND (c.customer_group_id = '".(int)$this->customer->getCustomerGroupId()."' OR c.customer_group_id = '".(int)$this->config->get('config_customer_group_id')."')";
		} else {
			$customer_query = " AND c.customer_group_id = '".(int)$this->config->get('config_customer_group_id')."'";
		}
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog c LEFT JOIN " . DB_PREFIX . "blog_description cd ON (c.blog_id = cd.blog_id) LEFT JOIN " . DB_PREFIX . "blog_to_store c2s ON (c.blog_id = c2s.blog_id) WHERE c.parent_id = '" . (int) $parent_id . "' AND cd.language_id = '" . (int) $this->config->get('config_language_id') . "' AND c2s.store_id = '" . (int) $this->config->get('config_store_id') . "'  AND c.status = '1' " . $customer_query . " ORDER BY c.sort_order, LCASE(cd.name)");
		return $query->rows;
	}
	
	public function getBlogs() {
        if ($this->customer->isLogged()) {
			$customer_query = " AND (c.customer_group_id = '".(int)$this->customer->getCustomerGroupId()."' OR c.customer_group_id = '".(int)$this->config->get('config_customer_group_id')."')";
		} else {
			$customer_query = " AND c.customer_group_id = '".(int)$this->config->get('config_customer_group_id')."'";
		}

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog c LEFT JOIN " . DB_PREFIX . "blog_description cd ON (c.blog_id = cd.blog_id) LEFT JOIN " . DB_PREFIX . "blog_to_store c2s ON (c.blog_id = c2s.blog_id) WHERE cd.language_id = '" . (int) $this->config->get('config_language_id') . "' AND c2s.store_id = '" . (int) $this->config->get('config_store_id') . "'  AND c.status = '1' " . $customer_query . " ORDER BY c.sort_order, LCASE(cd.name)");
		return $query->rows;
	}

	public function getPathByrecord($record_id) {
		$record_id = (int)$record_id;

		if ($record_id < 1) {
			return false;
		}
		
		static $path = null;
		
		if (!is_array($path)) {
			$path = $this->cache->get('record.blogs');
			
			if (!is_array($path)) {
				$path = array();
			}
		}
		
		if (!isset($path[$record_id])) {
			$query = $this->db->query("SELECT blog_id FROM " . DB_PREFIX . "record_to_blog WHERE record_id = '" . $record_id . "' ORDER BY blog_id DESC LIMIT 1");
			$path[$record_id] = $this->getPathByblog($query->num_rows ? (int) $query->row['blog_id'] : 0);
			$this->cache->set('record.blogs', $path);
		}
		
		return $path[$record_id];
	}
	
	public function getPathByBlog($blog_id) {
		if (strpos($blog_id, '_') !== false) {
			$abid    = explode('_', $blog_id);
			$blog_id = $abid[count($abid) - 1];
		}
		$blog_id = (int) $blog_id;
		if ($blog_id < 1)
			return false;
		static $path = null;
		if (!is_array($path)) {
			$path = $this->cache->get('blog.blogs');
			if (!is_array($path))
				$path = array();
		}
		if (!isset($path[$blog_id])) {
			$max_level = 10;
			$sql       = "SELECT td.name as name, CONCAT_WS('_'";
			for ($i = $max_level - 1; $i >= 0; --$i) {
				$sql .= ",t$i.blog_id";
			}
			$sql .= ") AS path FROM " . DB_PREFIX . "blog t0";
			for ($i = 1; $i < $max_level; ++$i) {
				$sql .= " LEFT JOIN " . DB_PREFIX . "blog t$i ON (t$i.blog_id = t" . ($i - 1) . ".parent_id)";
			}
			$sql .= "LEFT JOIN " . DB_PREFIX . "blog_description td ON ( td.blog_id = t0.blog_id )";
			$sql .= " WHERE t0.blog_id = '" . $blog_id . "'";
			$query                  = $this->db->query($sql);
			$path[$blog_id]['path'] = $query->num_rows ? $query->row['path'] : false;
			$path[$blog_id]['name'] = $query->num_rows ? $query->row['name'] : false;
			$this->cache->set('blog.blogs', $path);
		}
		return $path[$blog_id];
	}
	
	public function getBlogiesByParentId($blog_id) {
		$blog_data  = array();
		$blog_query = $this->db->query("SELECT blog_id FROM " . DB_PREFIX . "blog WHERE parent_id = '" . (int) $blog_id . "'");
		foreach ($blog_query->rows as $blog) {
			$blog_data[] = $blog['blog_id'];
			$children    = $this->getBlogiesByParentId($blog['blog_id']);
			if ($children) {
				$blog_data = array_merge($children, $blog_data);
			}
		}
		return $blog_data;
	}
	public function getBlogLayoutId($blog_id)
	{
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog_to_layout WHERE blog_id = '" . (int) $blog_id . "' AND store_id = '" . (int) $this->config->get('config_store_id') . "'");
		if ($query->num_rows) {
			return $query->row['layout_id'];
		} else {
			return $this->config->get('config_layout_blog');
		}
	}
	public function getTotalBlogiesByBlogId($parent_id = 0)
	{
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "blog c LEFT JOIN " . DB_PREFIX . "blog_to_store c2s ON (c.blog_id = c2s.blog_id) WHERE c.parent_id = '" . (int) $parent_id . "' AND c2s.store_id = '" . (int) $this->config->get('config_store_id') . "' AND c.status = '1'");
		return $query->row['total'];
	}
}
?>