<?php

class ModelCatalogProductPrice extends Model {
    public function updatePrice($product_id, $factor, $type, $type_table, $fix_number, $product_special) {
        $operation = '-';
        
        if ($type == 1) {
            $operation = '+';
        }
        
        if ($factor != null) {
            $sql = " * (1 $operation $factor)";
        } elseif ($fix_number != null) {
            $sql = " $operation $fix_number";
        }
        
        if ($product_special['special'] == 1) {
            $data = $this->db->query("SELECT price " . $sql . " as price_new FROM " . DB_PREFIX . "product WHERE product_id='" . (int)$product_id . "' ");
            $query = "INSERT INTO " . DB_PREFIX . "product_special SET priority='0', price='" . round((float)$data->row['price_new']) . "', product_id='" . (int)$product_id . "', customer_group_id='1', date_start='" . $product_special['date_start'] . "', date_end='" . $product_special['date_end'] . "'";
            $this->db->query($query);
            $product_special_id = $this->db->getLastId();

            $query = "SELECT price " . $sql . " as price_new, product_table_option_value_price_id FROM " . DB_PREFIX . "product_table NATURAL JOIN " . DB_PREFIX . "product_table_option_value_price WHERE product_id = '" . (int)$product_id . "'";

            if ($type_table != 2) {
                $query .= " AND type_table = '" . (int)$type_table . "' ";
            }

            $data = $this->db->query($query);

            foreach ($data->rows as $value) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "product_table_option_value_price_special SET product_table_option_value_price_id='" . (int)$value['product_table_option_value_price_id'] . "', product_special_id='" . (int)$product_special_id . "', table_price_special='" . round((float)$value['price_new']) . "'");
            }
        } else {
            $this->db->query("UPDATE " . DB_PREFIX . "product SET price=round(price " . $sql . ") WHERE product_id='" . (int)$product_id . "'");
            // $this->db->query("UPDATE " . DB_PREFIX . "product_option_value SET price=price * (1 " . $operation . " " . $factor . ") WHERE product_id='" . (int)$product_id . "'");
            $this->db->query("UPDATE " . DB_PREFIX . "product_price SET product_price=round(product_price " . $sql . ") WHERE product_id='" . (int)$product_id . "'");
            $query = "SELECT * FROM " . DB_PREFIX . "product_table NATURAL JOIN " . DB_PREFIX . "product_table_option_value_price WHERE product_id = '" . (int)$product_id . "' ";
            
            if ($type_table != 2) {
                $query .= " AND type_table = '" . (int)$type_table . "' ";
            }
            
            $query .= " group by product_table_id";
        	$data = $this->db->query($query);
        	
        	foreach ($data->rows as $value) {
            	$this->db->query("UPDATE " . DB_PREFIX . "product_table_option_value_price SET price=round(price " . $sql . ") WHERE product_table_id='" . (int)$value['product_table_id'] . "'");
        	}
        }
    }
}

?>
