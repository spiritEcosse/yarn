<?php
abstract class Model {
	protected $registry;
	
	public function __construct($registry) {
		$this->registry = $registry;
	}
	
	public function __get($key) {
		return $this->registry->get($key);
	}
	
	public function __set($key, $value) {
		$this->registry->set($key, $value);
	}
	
	public function getProductOptionsFilter($product_id) {
		$sql = "SELECT p2v.*, cod.name FROM " . DB_PREFIX . "product_to_value p2v NATURAL JOIN " . DB_PREFIX . "category_option_description cod WHERE p2v.product_id = '%d' GROUP BY option_id";
		$query = $this->db->query(sprintf($sql, $product_id));
		return $query->rows;
	}

	public function getProductValuesFilter($product_id, $option_id) {
		$sql = "SELECT p2v.*, covd.name, covd.image_option FROM " . DB_PREFIX . "product_to_value p2v INNER JOIN " . DB_PREFIX . "category_option_value_description covd ON(p2v.value_id = covd.value_id) WHERE p2v.product_id = '%d' AND p2v.option_id = '%d'";
		$query = $this->db->query(sprintf($sql, $product_id, $option_id));
		return $query->rows;
	}

    function translitIt($str) {
        $tr = array(
            "А" => "A", "Б" => "B", "В" => "V", "Г" => "G",
            "Д" => "D", "Е" => "E", "Ж" => "J", "З" => "Z", "И" => "I",
            "Й" => "Y", "К" => "K", "Л" => "L", "М" => "M", "Н" => "N",
            "О" => "O", "П" => "P", "Р" => "R", "С" => "S", "Т" => "T",
            "У" => "U", "Ф" => "F", "Х" => "H", "Ц" => "TS", "Ч" => "CH",
            "Ш" => "SH", "Щ" => "SCH", "Ъ" => "", "Ы" => "YI", "Ь" => "",
            "Э" => "E", "Ю" => "YU", "Я" => "YA", "а" => "a", "б" => "b",
            "в" => "v", "г" => "g", "д" => "d", "е" => "e", "ж" => "j",
            "з" => "z", "и" => "i", "й" => "y", "к" => "k", "л" => "l",
            "м" => "m", "н" => "n", "о" => "o", "п" => "p", "р" => "r",
            "с" => "s", "т" => "t", "у" => "u", "ф" => "f", "х" => "h",
            "ц" => "ts", "ч" => "ch", "ш" => "sh", "щ" => "sch", "ъ" => "y",
            "ы" => "yi", "ь" => "", "э" => "e", "ю" => "yu", "я" => "ya"
        );
        return strtr($str, $tr);
    }

    public function getSeoAllRows($query, $keyword) {
        $sql = "SELECT count(*) as count from " . DB_PREFIX . "url_alias WHERE query not in ('" . $query . "') and keyword = '" . $keyword . "' ";
        $query = $this->db->query($sql);

        return $query->row['count'];
    }
}
?>