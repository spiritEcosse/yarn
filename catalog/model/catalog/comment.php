<?php
class ModelCatalogComment extends Model
{
	public function addComment($record_id, $data, $data_get) {
		if (isset($data_get['parent'])) {
			$parent_id = $data_get['parent'];
		} else {
			$parent_id = 0;
		}
		$sql   = "
		SELECT r.*, p.*, pp.sorthex as sorthex_parent
		FROM " . DB_PREFIX . "comment r
		LEFT JOIN " . DB_PREFIX . "record p ON (r.record_id = p.record_id)
		LEFT JOIN " . DB_PREFIX . "record_description pd ON (p.record_id = pd.record_id)
		LEFT JOIN " . DB_PREFIX . "comment pp ON (r.parent_id = pp.comment_id)
		WHERE p.record_id = '" . (int) $record_id . "'
		AND r.parent_id = '" . (int) $parent_id . "'
		AND pd.language_id = '" . (int) $this->config->get('config_language_id') . "'
		ORDER BY r.sorthex DESC
		LIMIT 1";
		$query = $this->db->query($sql);
		if (count($query->rows) > 0) {
			foreach ($query->rows as $comment) {
				$sorthex        = $comment['sorthex'];
				$sorthex_parent = $comment['sorthex_parent'];
				$sorthex        = substr($sorthex, strlen($sorthex_parent), 4);
			}
			$sorthex = $sorthex_parent . (str_pad(dechex($sortdec = hexdec($sorthex) + 1), 4, "0", STR_PAD_LEFT));
		} else {
			if ($parent_id == 0) {
				$sorthex = '0000';
			} else {
				$queryparent = $this->db->query("
				SELECT c.sorthex
				FROM " . DB_PREFIX . "comment c
				WHERE c.comment_id = '" . (int) $parent_id . "'
				ORDER BY c.sorthex DESC
				LIMIT 1");
				if (count($queryparent->rows) > 0) {
					foreach ($queryparent->rows as $parent) {
						$sorthex = $parent['sorthex'];
					}
					$sorthex = $sorthex . "0000";
				}
			}
		}
		$this->db->query("INSERT INTO " . DB_PREFIX . "comment SET
		author = '" . $this->db->escape($data['name']) . "',
		customer_id = '" . (int) $this->customer->getId() . "',
		record_id = '" . (int) $record_id . "',
		sorthex   = '" . $sorthex . "',
		parent_id = '" . (int) $parent_id . "',
		text = '" . $this->db->escape(strip_tags($data['text'])) . "',
		status = '" . $this->db->escape(strip_tags($data['status'])) . "',
		rating = '" . (int) $data['rating'] . "', date_added = NOW()");
	}

    public function checkRate($data = array())
	{
		$sql   = "SELECT * FROM  " . DB_PREFIX . "rate_comment rc
		WHERE
		customer_id = '" . $data['customer_id'] . "'
		AND
		comment_id = '" . $data['comment_id'] . "'
		LIMIT 1";
		$query = $this->db->query($sql);
		return $query->rows;
	}


	public function checkRateNum($data = array())
	{
		$sql   = "SELECT *,
        COUNT(c.record_id) as rating_num
		FROM  " . DB_PREFIX . "comment c
		LEFT JOIN " . DB_PREFIX . "rate_comment rc ON (rc.comment_id = c.comment_id)
		WHERE
		rc.customer_id = '" . $data['customer_id'] . "'
		AND
		c.record_id = '" . $data['record_id'] . "'
		GROUP BY c.record_id
		LIMIT 1";
		$query = $this->db->query($sql);
		$query->row['sql'] = $sql;
		return $query->row;
	}


	public function getRecordbyComment($data = array())
	{
		$sql   = "SELECT c.record_id as record_id
		FROM  " . DB_PREFIX . "comment c
		WHERE
		c.comment_id = '" . $data['comment_id'] . "'
		LIMIT 1";
		$query = $this->db->query($sql);

  	    $query->row['sql'] = $sql;

		return $query->row;

	}


	public function addRate($data = array())
	{
		$sql   = "INSERT INTO " . DB_PREFIX . "rate_comment SET
		customer_id = '" . $data['customer_id'] . "',
		comment_id = '" . $data['comment_id'] . "',
		delta = '" . $data['delta'] . "' ";
		$query = $this->db->query($sql);
		return $sql;
	}
	public function getCommentsByRecordId($record_id, $start = 0, $limit = 20)
	{
		$sql   = "
		SELECT r.*, p.record_id, pd.name, p.price, p.image, r.date_added,  (r.sorthex) as hsort
		FROM " . DB_PREFIX . "comment r
		LEFT JOIN " . DB_PREFIX . "record p ON (r.record_id = p.record_id)
		LEFT JOIN " . DB_PREFIX . "record_description pd ON (p.record_id = pd.record_id)
		WHERE p.record_id = '" . (int) $record_id . "'
		AND p.date_available <= NOW()
		AND p.status = '1'
		AND r.status = '1'
		AND pd.language_id = '" . (int) $this->config->get('config_language_id') . "'
		";
		$query = $this->db->query($sql);
		return $query->rows;
	}
	public function getRatesByRecordId($record_id, $customer_id)
	{
		$sql   = "
			  SELECT
				rc.*,
				rc.comment_id as cid,
                IF ((SELECT urc.delta  FROM " . DB_PREFIX . "rate_comment urc WHERE urc.customer_id = '" . $customer_id . "' AND urc.comment_id = rc.comment_id)  < 0, -1 ,  IF ((SELECT urc.delta  FROM " . DB_PREFIX . "rate_comment urc WHERE urc.customer_id = '" . $customer_id . "' AND urc.comment_id = rc.comment_id)  > 0, 1 ,  0 ) ) as customer_delta ,
      			COUNT(rc.comment_id) as rate_count,
				SUM(rc.delta) as rate_delta,
				SUM(rc.delta > 0) as rate_delta_plus,
				SUM(rc.delta < 0) as rate_delta_minus
			   FROM
			     " . DB_PREFIX . "rate_comment rc
			   LEFT JOIN " . DB_PREFIX . "comment c on (rc.comment_id = c.comment_id)
			   LEFT JOIN " . DB_PREFIX . "record r on (r.record_id = c.record_id)
			   LEFT JOIN " . DB_PREFIX . "record_description pd ON (r.record_id = pd.record_id)
				   WHERE
			     r.record_id= " . (int) $record_id . "
				AND r.date_available <= NOW()
				AND r.status = '1'
				AND c.status = '1'

				AND pd.language_id = '" . (int) $this->config->get('config_language_id') . "'
			    GROUP BY rc.comment_id
			   ";
		$query = $this->db->query($sql);
		if (count($query->rows) > 0) {
			foreach ($query->rows as $rates) {
				$rate[$rates['cid']] = $rates;
			}
			return $rate;
		}
	}
	public function getRatesByCommentId($comment_id)
	{
		$sql   = "
			  SELECT
				rc.*,
				rc.comment_id as cid,
				COUNT(rc.comment_id) as rate_count,
				SUM(rc.delta) as rate_delta,
				SUM(rc.delta > 0) as rate_delta_plus,
				SUM(rc.delta < 0) as rate_delta_minus
			   FROM
			     " . DB_PREFIX . "rate_comment rc
			   WHERE
			     rc.comment_id= " . (int) $comment_id . "
			    GROUP BY rc.comment_id
			   ";
		$query = $this->db->query($sql);

		if (count($query->rows) > 0) {
			foreach ($query->rows as $rates) {
				$rate[$rates['cid']] = $rates;
			}
		}
		return $query->rows;
	}
	public function getAverageRating($record_id)
	{
		$query = $this->db->query("SELECT AVG(rating) AS total FROM " . DB_PREFIX . "comment
		WHERE status = '1' AND record_id = '" . (int) $record_id . "' GROUP BY record_id");
		if (isset($query->row['total'])) {
			return (int) $query->row['total'];
		} else {
			return 0;
		}
	}
	public function getTotalComments()
	{
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "comment r
		LEFT JOIN " . DB_PREFIX . "record p ON (r.record_id = p.record_id)
		WHERE p.date_available <= NOW() AND p.status = '1' AND r.status = '1'");
		return $query->row['total'];
	}
	public function getTotalCommentsByRecordId($record_id)
	{
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "comment r
		LEFT JOIN " . DB_PREFIX . "record p ON (r.record_id = p.record_id)
		LEFT JOIN " . DB_PREFIX . "record_description pd ON (p.record_id = pd.record_id)
		WHERE p.record_id = '" . (int) $record_id . "' AND p.date_available <= NOW() AND p.status = '1' AND r.status = '1'
		AND pd.language_id = '" . (int) $this->config->get('config_language_id') . "'");
		return $query->row['total'];
	}
}
?>