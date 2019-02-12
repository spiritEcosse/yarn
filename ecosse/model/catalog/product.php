<?php
class ModelCatalogProduct extends Model {
	public function addProduct($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "product SET price_after_id='" . (int)$data['price_after_id'] . "', price_prefix_id='" . (int)$data['price_prefix_id'] . "',  price_status='" . $data['price_status'] . "', model = '" . $this->db->escape($data['model']) . "', sku = '" . $this->db->escape($data['sku']) . "', upc = '" . $this->db->escape($data['upc']) . "', location = '" . $this->db->escape($data['location']) . "', quantity = '" . (int)$data['quantity'] . "', minimum = '" . (int)$data['minimum'] . "', subtract = '" . (int)$data['subtract'] . "', stock_status_id = '" . (int)$data['stock_status_id'] . "', date_available = '" . $this->db->escape($data['date_available']) . "', manufacturer_id = '" . (int)$data['manufacturer_id'] . "', shipping = '" . (int)$data['shipping'] . "', price = '" . (float)$data['price'] . "', points = '" . (int)$data['points'] . "', weight = '" . (float)$data['weight'] . "', weight_class_id = '" . (int)$data['weight_class_id'] . "', length = '" . (float)$data['length'] . "', width = '" . (float)$data['width'] . "', height = '" . (float)$data['height'] . "', length_class_id = '" . (int)$data['length_class_id'] . "', status = '" . (int)$data['status'] . "', tax_class_id = '" . $this->db->escape($data['tax_class_id']) . "', sort_order = '" . (int)$data['sort_order'] . "', date_added = NOW()");
		
		$product_id = $this->db->getLastId();
		
		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "product SET image = '" . $this->db->escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "' WHERE product_id = '" . (int)$product_id . "'");
		}

        if (isset($data['product_description'])) {
            foreach ($data['product_description'] as $language_id => $value) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "product_description SET product_id = '" . (int)$product_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', description = '" . $this->db->escape($value['description']) . "', seo_title = '" . $this->db->escape($value['seo_title']) . "', seo_h1 = '" . $this->db->escape($value['seo_h1']) . "'");
            }
        }

		if (isset($data['product_store'])) {
			foreach ($data['product_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_store SET product_id = '" . (int)$product_id . "', store_id = '" . (int)$store_id . "'");
			}
		}
        
		if (isset($data['product_attribute'])) {
			foreach ($data['product_attribute'] as $product_attribute) {
				if ($product_attribute['attribute_id']) {
					$this->db->query("DELETE FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product_id . "' AND attribute_id = '" . (int)$product_attribute['attribute_id'] . "'");
					
					foreach ($product_attribute['product_attribute_description'] as $language_id => $product_attribute_description) {				
						$this->db->query("INSERT INTO " . DB_PREFIX . "product_attribute SET product_id = '" . (int)$product_id . "', attribute_id = '" . (int)$product_attribute['attribute_id'] . "', language_id = '" . (int)$language_id . "', text = '" .  $this->db->escape($product_attribute_description['text']) . "'");
					}
				}
			}
		}
        
		if (isset($data['product_tab'])) {
			foreach ($data['product_tab'] as $product_tab) {
				if ($product_tab['tab_id']) {
					$this->db->query("DELETE FROM " . DB_PREFIX . "product_tab WHERE product_id = '" . (int)$product_id . "' AND tab_id = '" . (int)$product_tab['tab_id'] . "'");

					foreach ($product_tab['product_tab_description'] as $language_id => $product_tab_description) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "product_tab SET product_id = '" . (int)$product_id . "', tab_id = '" . (int)$product_tab['tab_id'] . "', language_id = '" . (int)$language_id . "', text = '" .  $this->db->escape($product_tab_description['text']) . "'");
					}
				}
			}
		}

		if (isset($data['product_option'])) {
			foreach ($data['product_option'] as $product_option) {
				if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {
					$this->db->query("INSERT INTO " . DB_PREFIX . "product_option SET product_id = '" . (int)$product_id . "', option_id = '" . (int)$product_option['option_id'] . "', required = '" . (int)$product_option['required'] . "'");
				
					$product_option_id = $this->db->getLastId();
                    
					if (isset($product_option['product_option_value'])) {
						foreach ($product_option['product_option_value'] as $product_option_value) {
							$this->db->query("INSERT INTO " . DB_PREFIX . "product_option_value SET product_option_id = '" . (int)$product_option_id . "', product_id = '" . (int)$product_id . "', option_id = '" . (int)$product_option['option_id'] . "', option_value_id = '" . (int)$product_option_value['option_value_id'] . "', quantity = '" . (int)$product_option_value['quantity'] . "', subtract = '" . (int)$product_option_value['subtract'] . "', price = '" . (float)$product_option_value['price'] . "', price_prefix = '" . $this->db->escape($product_option_value['price_prefix']) . "', points = '" . (int)$product_option_value['points'] . "', points_prefix = '" . $this->db->escape($product_option_value['points_prefix']) . "', weight = '" . (float)$product_option_value['weight'] . "', weight_prefix = '" . $this->db->escape($product_option_value['weight_prefix']) . "', product_sort_order = '" . (int)$product_option_value['sort_order'] . "'");
						}
					}
				} else {
					$this->db->query("INSERT INTO " . DB_PREFIX . "product_option SET product_id = '" . (int)$product_id . "', option_id = '" . (int)$product_option['option_id'] . "', option_value = '" . $this->db->escape($product_option['option_value']) . "', required = '" . (int)$product_option['required'] . "'");
				}
			}
		}

		if (isset($data['product_discount'])) {
			foreach ($data['product_discount'] as $product_discount) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_discount SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$product_discount['customer_group_id'] . "', quantity = '" . (int)$product_discount['quantity'] . "', priority = '" . (int)$product_discount['priority'] . "', price = '" . (float)$product_discount['price'] . "', date_start = '" . $this->db->escape($product_discount['date_start']) . "', date_end = '" . $this->db->escape($product_discount['date_end']) . "'");
			}
		}
        
        if (isset($data['product_to_value_id'])) {
			foreach ($data['product_to_value_id'] as $option_id => $values) {
				foreach ($values as $value_id) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_value SET product_id = '" . (int)$product_id . "', option_id = '" . (int)$option_id . "', value_id = '" . (int)$value_id . "'");
				}
			}
		}

		if (isset($data['product_special'])) {
			foreach ($data['product_special'] as $product_special) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_special SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$product_special['customer_group_id'] . "', priority = '" . (int)$product_special['priority'] . "', price = '" . (float)$product_special['price'] . "', date_start = '" . $this->db->escape($product_special['date_start']) . "', date_end = '" . $this->db->escape($product_special['date_end']) . "'");
			}
		}
		
		if (isset($data['product_image'])) {
			foreach ($data['product_image'] as $product_image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_image SET product_id = '" . (int)$product_id . "', image = '" . $this->db->escape(html_entity_decode($product_image['image'], ENT_QUOTES, 'UTF-8')) . "', sort_order = '" . (int)$product_image['sort_order'] . "'");
			}
		}
		
		if (isset($data['product_download'])) {
			foreach ($data['product_download'] as $download_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_download SET product_id = '" . (int)$product_id . "', download_id = '" . (int)$download_id . "'");
			}
		}
		
		if (isset($data['product_category'])) {
			foreach ($data['product_category'] as $category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_category SET product_id = '" . (int)$product_id . "', category_id = '" . (int)$category_id . "'");
			}
		}
		
		if (isset($data['main_category_id']) && $data['main_category_id'] > 0) {
			$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "' AND category_id = '" . (int)$data['main_category_id'] . "'");
			$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_category SET product_id = '" . (int)$product_id . "', category_id = '" . (int)$data['main_category_id'] . "', main_category = 1");
		} elseif (isset($data['product_category'][0])) {
			$this->db->query("UPDATE " . DB_PREFIX . "product_to_category SET main_category = 1 WHERE product_id = '" . (int)$product_id . "' AND category_id = '" . (int)$data['product_category'][0] . "'");
		}

		if (isset($data['product_related'])) {
			foreach ($data['product_related'] as $related_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$product_id . "' AND related_id = '" . (int)$related_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_related SET product_id = '" . (int)$product_id . "', related_id = '" . (int)$related_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$related_id . "' AND related_id = '" . (int)$product_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_related SET product_id = '" . (int)$related_id . "', related_id = '" . (int)$product_id . "'");
			}
		}

		if (isset($data['product_reward'])) {
			foreach ($data['product_reward'] as $customer_group_id => $product_reward) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_reward SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$customer_group_id . "', points = '" . (int)$product_reward['points'] . "'");
			}
		}

		if (isset($data['product_layout'])) {
			foreach ($data['product_layout'] as $store_id => $layout) {
				if ($layout['layout_id']) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_layout SET product_id = '" . (int)$product_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout['layout_id'] . "'");
				}
			}
		}

        if (isset($data['product_tag'])) {
            foreach ($data['product_tag'] as $language_id => $value) {
                if ($value) {
                    $tags = explode(',', $value);

                    foreach ($tags as $tag) {
                        $this->db->query("INSERT INTO " . DB_PREFIX . "product_tag SET product_id = '" . (int)$product_id . "', language_id = '" . (int)$language_id . "', tag = '" . $this->db->escape(trim($tag)) . "'");
                    }
                }
            }
        }

		if (isset($data['product_table'])) {
			$this->insertProductTable($data['product_table'], $product_id);
		}

		if (isset($data['product_fabric'])) {
			$this->insertProductFabric($data['product_fabric'], $product_id);
		}

		if (isset($data['product_copy'])) {
			$this->changeProductFabric($data['product_copy'], $product_id);
		}
		
		if (isset($data['product_price'])) {
			$this->insertProductPrice($data['product_price'], $product_id);
		}
		
		if (isset($data['product_copy_table']) && isset($data['product_table_number'])) {
			$this->productCopyTable($data['product_copy_table'], $data['product_table_number'], (int)$product_id);
		}

		if (isset($data['product_copy_related'])) {
			$this->productCopyRelated($data['product_copy_related'], $data['product_related']);
		}

		if (isset($data['product_copy_category'])) {
			$this->productCopyCategory($data);
		}

		if (isset($data['keyword']) && $data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'product_id=" . (int)$product_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('product');

        return $product_id;
	}
	
	public function editProduct($product_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "product SET price_after_id='" . (int)$data['price_after_id'] . "', price_prefix_id='" . (int)$data['price_prefix_id'] . "', price_status='" . $data['price_status'] . "', model = '" . $this->db->escape($data['model']) . "', sku = '" . $this->db->escape($data['sku']) . "', upc = '" . $this->db->escape($data['upc']) . "', location = '" . $this->db->escape($data['location']) . "', quantity = '" . (int)$data['quantity'] . "', minimum = '" . (int)$data['minimum'] . "', subtract = '" . (int)$data['subtract'] . "', stock_status_id = '" . (int)$data['stock_status_id'] . "', date_available = '" . $this->db->escape($data['date_available']) . "', manufacturer_id = '" . (int)$data['manufacturer_id'] . "', shipping = '" . (int)$data['shipping'] . "', price = '" . (float)$data['price'] . "', points = '" . (int)$data['points'] . "', weight = '" . (float)$data['weight'] . "', weight_class_id = '" . (int)$data['weight_class_id'] . "', length = '" . (float)$data['length'] . "', width = '" . (float)$data['width'] . "', height = '" . (float)$data['height'] . "', length_class_id = '" . (int)$data['length_class_id'] . "', status = '" . (int)$data['status'] . "', tax_class_id = '" . $this->db->escape($data['tax_class_id']) . "', sort_order = '" . (int)$data['sort_order'] . "', date_modified = NOW() WHERE product_id = '" . (int)$product_id . "'");

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "product SET image = '" . $this->db->escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "' WHERE product_id = '" . (int)$product_id . "'");
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_description WHERE product_id = '" . (int)$product_id . "'");
		
		foreach ($data['product_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "product_description SET product_id = '" . (int)$product_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', description = '" . $this->db->escape($value['description']) . "', seo_title = '" . $this->db->escape($value['seo_title']) . "', seo_h1 = '" . $this->db->escape($value['seo_h1']) . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_store WHERE product_id = '" . (int)$product_id . "'");

		if (isset($data['product_store'])) {
			foreach ($data['product_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_store SET product_id = '" . (int)$product_id . "', store_id = '" . (int)$store_id . "'");
			}
		}
	
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product_id . "'");

		if (!empty($data['product_attribute'])) {
			foreach ($data['product_attribute'] as $product_attribute) {
				if ($product_attribute['attribute_id']) {
					$this->db->query("DELETE FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product_id . "' AND attribute_id = '" . (int)$product_attribute['attribute_id'] . "'");
					
					foreach ($product_attribute['product_attribute_description'] as $language_id => $product_attribute_description) {				
						$this->db->query("INSERT INTO " . DB_PREFIX . "product_attribute SET product_id = '" . (int)$product_id . "', attribute_id = '" . (int)$product_attribute['attribute_id'] . "', language_id = '" . (int)$language_id . "', text = '" .  $this->db->escape($product_attribute_description['text']) . "'");
					}
				}
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_tab WHERE product_id = '" . (int)$product_id . "'");

		if (!empty($data['product_tab'])) {
			foreach ($data['product_tab'] as $product_tab) {
				if ($product_tab['tab_id']) {
					$this->db->query("DELETE FROM " . DB_PREFIX . "product_tab WHERE product_id = '" . (int)$product_id . "' AND tab_id = '" . (int)$product_tab['tab_id'] . "'");

					foreach ($product_tab['product_tab_description'] as $language_id => $product_tab_description) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "product_tab SET product_id = '" . (int)$product_id . "', tab_id = '" . (int)$product_tab['tab_id'] . "', language_id = '" . (int)$language_id . "', text = '" .  $this->db->escape($product_tab_description['text']) . "'");
					}
				}
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_option WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_option_value WHERE product_id = '" . (int)$product_id . "'");
		
		if (isset($data['product_option'])) {
			foreach ($data['product_option'] as $product_option) {
				if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {
					$this->db->query("INSERT INTO " . DB_PREFIX . "product_option SET product_option_id = '" . (int)$product_option['product_option_id'] . "', product_id = '" . (int)$product_id . "', option_id = '" . (int)$product_option['option_id'] . "', required = '" . (int)$product_option['required'] . "'");
					
					$product_option_id = $this->db->getLastId();
					
					if (isset($product_option['product_option_value'])) {
						foreach ($product_option['product_option_value'] as $product_option_value) {
							$this->db->query("INSERT INTO " . DB_PREFIX . "product_option_value SET product_option_value_id = '" . (int)$product_option_value['product_option_value_id'] . "', product_option_id = '" . (int)$product_option_id . "', product_id = '" . (int)$product_id . "', option_id = '" . (int)$product_option['option_id'] . "', option_value_id = '" . (int)$product_option_value['option_value_id'] . "', quantity = '" . (int)$product_option_value['quantity'] . "', subtract = '" . (int)$product_option_value['subtract'] . "', price = '" . (float)$product_option_value['price'] . "', price_prefix = '" . $this->db->escape($product_option_value['price_prefix']) . "', points = '" . (int)$product_option_value['points'] . "', points_prefix = '" . $this->db->escape($product_option_value['points_prefix']) . "', weight = '" . (float)$product_option_value['weight'] . "', weight_prefix = '" . $this->db->escape($product_option_value['weight_prefix']) . "', product_sort_order = '" . (int)$product_option_value['sort_order'] . "'");
						}
					}
				} else {
					$this->db->query("INSERT INTO " . DB_PREFIX . "product_option SET product_option_id = '" . (int)$product_option['product_option_id'] . "', product_id = '" . (int)$product_id . "', option_id = '" . (int)$product_option['option_id'] . "', option_value = '" . $this->db->escape($product_option['option_value']) . "', required = '" . (int)$product_option['required'] . "'");
				}					
			}
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product_id . "'");
		
		if (isset($data['product_discount'])) {
			foreach ($data['product_discount'] as $product_discount) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_discount SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$product_discount['customer_group_id'] . "', quantity = '" . (int)$product_discount['quantity'] . "', priority = '" . (int)$product_discount['priority'] . "', price = '" . (float)$product_discount['price'] . "', date_start = '" . $this->db->escape($product_discount['date_start']) . "', date_end = '" . $this->db->escape($product_discount['date_end']) . "'");
			}
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_value WHERE product_id = '" . (int)$product_id . "'");

		if (isset($data['product_to_value_id'])) {
			foreach ($data['product_to_value_id'] as $option_id => $values) {
				foreach ($values as $value_id) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_value SET product_id = '" . (int)$product_id . "', option_id = '" . (int)$option_id . "', value_id = '" . (int)$value_id . "'");
				}
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product_id . "'");	
		$query = "DELETE t3 FROM " . DB_PREFIX . "product_table AS t1 NATURAL LEFT JOIN " . DB_PREFIX . "product_table_option_value_price AS t2 NATURAL LEFT JOIN " . DB_PREFIX . "product_table_option_value_price_special AS t3 WHERE t1.product_id = '" . (int)$product_id . "'";

		if (isset($data['product_special'])) {

			$product_special_id = array();

			foreach ($data['product_special'] as $product_special) {
                if (isset($product_special['product_special_id'])) {
                    $product_special_id[] = $product_special['product_special_id'];
                }

				$sql = "INSERT INTO " . DB_PREFIX . "product_special SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$product_special['customer_group_id'] . "', priority = '" . (int)$product_special['priority'] . "', price = '" . (float)$product_special['price'] . "', date_start = '" . $this->db->escape($product_special['date_start']) . "', date_end = '" . $this->db->escape($product_special['date_end']) . "'";

				if (isset($product_special['product_special_id'])) {
					$sql .= ", product_special_id='" . $product_special['product_special_id'] . "'";
				}

				$this->db->query($sql);
			}

			$query .= "AND t3.product_special_id";

            if ($product_special_id) {
                $query .= " NOT IN (" . implode(',', $product_special_id) . ")";
            }
		}

		$this->db->query($query);
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int)$product_id . "'");
		
		if (isset($data['product_image'])) {
			foreach ($data['product_image'] as $product_image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_image SET product_id = '" . (int)$product_id . "', image = '" . $this->db->escape(html_entity_decode($product_image['image'], ENT_QUOTES, 'UTF-8')) . "', sort_order = '" . (int)$product_image['sort_order'] . "'");
			}
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_download WHERE product_id = '" . (int)$product_id . "'");
		
		if (isset($data['product_download'])) {
			foreach ($data['product_download'] as $download_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_download SET product_id = '" . (int)$product_id . "', download_id = '" . (int)$download_id . "'");
			}
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "'");
		
		if (isset($data['product_category'])) {
			foreach ($data['product_category'] as $category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_category SET product_id = '" . (int)$product_id . "', category_id = '" . (int)$category_id . "'");
			}		
		}

		if (isset($data['main_category_id']) && $data['main_category_id'] > 0) {
			$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "' AND category_id = '" . (int)$data['main_category_id'] . "'");
			$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_category SET product_id = '" . (int)$product_id . "', category_id = '" . (int)$data['main_category_id'] . "', main_category = 1");
		} elseif (isset($data['product_category'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "product_to_category SET main_category = 1 WHERE product_id = '" . (int)$product_id . "' AND category_id = '" . (int)$data['product_category'][0] . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE related_id = '" . (int)$product_id . "'");

		if (isset($data['product_related'])) {
			foreach ($data['product_related'] as $related_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$product_id . "' AND related_id = '" . (int)$related_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_related SET product_id = '" . (int)$product_id . "', related_id = '" . (int)$related_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$related_id . "' AND related_id = '" . (int)$product_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_related SET product_id = '" . (int)$related_id . "', related_id = '" . (int)$product_id . "'");
			}
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_reward WHERE product_id = '" . (int)$product_id . "'");

		if (isset($data['product_reward'])) {
			foreach ($data['product_reward'] as $customer_group_id => $value) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_reward SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$customer_group_id . "', points = '" . (int)$value['points'] . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_layout WHERE product_id = '" . (int)$product_id . "'");

		if (isset($data['product_layout'])) {
			foreach ($data['product_layout'] as $store_id => $layout) {
				if ($layout['layout_id']) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_layout SET product_id = '" . (int)$product_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout['layout_id'] . "'");
				}
			}
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_tag WHERE product_id = '" . (int)$product_id. "'");
		
		foreach ($data['product_tag'] as $language_id => $value) {
			if ($value) {
				$tags = explode(',', $value);
			
				foreach ($tags as $tag) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "product_tag SET product_id = '" . (int)$product_id . "', language_id = '" . (int)$language_id . "', tag = '" . $this->db->escape(trim($tag)) . "'");
				}
			}
		}
		
		// if (isset($data['product_option_price'])) {
		// 	$this->db->query("DELETE FROM " . DB_PREFIX . "product_options_price WHERE product_id = '" . (int)$product_id. "'");

		// 	foreach ($data['product_option_price'] as $key_vertical => $option_vertical) {
		// 		foreach ($option_vertical as $key_horizont => $option_horizont) {
		// 			$this->db->query("INSERT INTO " . DB_PREFIX . "product_options_price SET product_options_price_id = '" . (int)$option_horizont['product_options_price_id'] . "', product_id = '" . (int)$product_id . "', option_vertical = '" . (int)$key_vertical . "', option_horizont = '" . (int)$key_horizont . "', price = '" . (int)$option_horizont['price'] . "'");
		// 		}
		// 	}
		// }
		
		$this->db->query("DELETE t2, t3 FROM " . DB_PREFIX . "product_table AS t1 NATURAL LEFT JOIN " . DB_PREFIX . "product_table_option AS t2 NATURAL LEFT JOIN " . DB_PREFIX . "product_table_option_value AS t3 WHERE t1.product_id = '" . (int)$product_id. "'");
		$this->db->query("DELETE t1, t2 FROM " . DB_PREFIX . "product_table AS t1 NATURAL LEFT JOIN " . DB_PREFIX . "product_table_option_value_price AS t2 WHERE t1.product_id = '" . (int)$product_id . "'");
		
		if (isset($data['product_table'])) {
			$this->insertProductTable($data['product_table'], $product_id);
		}

		$this->db->query("DELETE t1, t2, t3 FROM " . DB_PREFIX . "product_fabric_option AS t1 NATURAL LEFT JOIN " . DB_PREFIX . "product_fabric_option_value AS t2 LEFT JOIN " . DB_PREFIX . "product_fabric_option_value_product AS t3 ON (t2.product_fabric_option_value_id = t3.product_fabric_option_value_id) WHERE t1.product_id = '" . (int)$product_id . "'");
		
		if (isset($data['product_fabric'])) {
			$this->insertProductFabric($data['product_fabric'], $product_id);
		}
		
		if (isset($data['product_copy'])) {
			$this->changeProductFabric($data['product_copy'], $product_id);
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_price WHERE product_id = '" . (int)$product_id ."' ");

		if (isset($data['product_price'])) {
			$this->insertProductPrice($data['product_price'], $product_id);
		}

		if (isset($data['product_copy_table']) && isset($data['product_table_number'])) {
			$this->productCopyTable($data['product_copy_table'], $data['product_table_number'], (int)$product_id);
		}

		if (isset($data['product_copy_related'])) {
			$this->productCopyRelated($data['product_copy_related'], $data);
		}

		if (isset($data['product_copy_category'])) {
			$this->productCopyCategory($data);
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'product_id=" . (int)$product_id. "'");
		
		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'product_id=" . (int)$product_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}
		
		$this->cache->delete('product');
	}
	
	public function copyProduct($product_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE p.product_id = '" . (int)$product_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		if ($query->num_rows) {
			$data = array();
			
			$data = $query->row;
			
			$data['keyword'] = '';
                        
			$data['status'] = '0';
			
			$data = array_merge($data, array('product_attribute'    => $this->getProductAttributes($product_id)));
			$data = array_merge($data, array('product_tab' 			=> $this->getProductTabs($product_id)));
			$data = array_merge($data, array('product_description'  => $this->getProductDescriptions($product_id)));			
			$data = array_merge($data, array('product_discount'     => $this->getProductDiscounts($product_id)));
			$data = array_merge($data, array('product_to_value_id' 	=> $this->getProductValuesCopy($product_id)));
            $data = array_merge($data, array('product_image'        => $this->getProductImages($product_id)));
			
			$data = array_merge($data, array('product_option'    => $this->getProductOptions($product_id)));
			$data = array_merge($data, array('product_related'   => $this->getProductRelated($product_id)));
			$data = array_merge($data, array('product_reward'    => $this->getProductRewards($product_id)));
			$data = array_merge($data, array('product_special'   => $this->getProductSpecials($product_id)));
			$data = array_merge($data, array('product_tag'       => $this->getProductTags($product_id)));
			$data = array_merge($data, array('product_category'  => $this->getProductCategories($product_id)));
			$data = array_merge($data, array('product_download'  => $this->getProductDownloads($product_id)));
			$data = array_merge($data, array('product_layout'    => $this->getProductLayouts($product_id)));
			$data = array_merge($data, array('product_store'     => $this->getProductStores($product_id)));
            $data = array_merge($data, array('product_table'	=> $this->getProductTableCopy($product_id)));
            $data = array_merge($data, array('product_fabric'	=> $this->getProductFabricOptionCopy($product_id)));
            $data = array_merge($data, array('product_price'	=> $this->getProductPriceCopy($product_id)));
			$this->addProduct($data);
		}
	}
	
	public function deleteProduct($product_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "product WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_description WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_option WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_option_value WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE related_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_reward WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_tag WHERE product_id='" . (int)$product_id. "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_download WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_layout WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_store WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "review WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_tab WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_price WHERE product_id = '" . (int)$product_id . "'");
        
        if ($this->config->get('discount_birthday_days_products')) {
            foreach ($this->config->get('discount_birthday_days_products') as $config_product_id) {
                if (in_array($product_id, $this->config->get('discount_birthday_days_products'))) {
                    unset($this->config->get('discount_birthday_days_products')[$product_id]);
                }
            }
        }
        
        $this->db->query("DELETE FROM " . DB_PREFIX . "product_to_value WHERE product_id = '" . (int)$product_id . "'");
        $this->db->query("DELETE t2, t3 FROM " . DB_PREFIX . "product_table AS t1 NATURAL LEFT JOIN " . DB_PREFIX . "product_table_option AS t2 NATURAL LEFT JOIN " . DB_PREFIX . "product_table_option_value AS t3 WHERE t1.product_id = '" . (int)$product_id. "'");
		$this->db->query("DELETE t1, t2, t3 FROM " . DB_PREFIX . "product_table AS t1 NATURAL LEFT JOIN " . DB_PREFIX . "product_table_option_value_price AS t2 NATURAL LEFT JOIN " . DB_PREFIX . "product_table_option_value_price_special AS t3 WHERE t1.product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE t1, t2, t3 FROM " . DB_PREFIX . "product_fabric_option AS t1 NATURAL LEFT JOIN " . DB_PREFIX . "product_fabric_option_value AS t2 LEFT JOIN " . DB_PREFIX . "product_fabric_option_value_product AS t3 ON (t2.product_fabric_option_value_id = t3.product_fabric_option_value_id) WHERE t1.product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_fabric_option_value_product WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'product_id=" . (int)$product_id. "'");
		
		$this->cache->delete('product');
	}

	public function getProduct($product_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'product_id=" . (int)$product_id . "') AS keyword FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE p.product_id = '" . (int)$product_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
				
		return $query->row;
	}
	
	public function getProducts($data = array()) {
		if ($data) {
			$sql = "SELECT p.*,pd.*, m.name as manufacturer FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "manufacturer m ON ( p.manufacturer_id = m.manufacturer_id )";
			// $sql = "SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id)";

			if (!empty($data['filter_category_id'])) {
				$sql .= " LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id)";			
			}
					
			$sql .= " WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'"; 
			
			if (!empty($data['filter_name'])) {
				$sql .= " AND LCASE(pd.name) LIKE '%" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%'";
			}

			if (!empty($data['filter_model'])) {
				$sql .= " AND LCASE(p.model) LIKE '" . $this->db->escape(utf8_strtolower($data['filter_model'])) . "%'";
			}
			
			if (!empty($data['filter_price'])) {
				$sql .= " AND p.price LIKE '" . $this->db->escape($data['filter_price']) . "%'";
			}
			
			if (isset($data['filter_quantity']) && !is_null($data['filter_quantity'])) {
				$sql .= " AND p.quantity = '" . $this->db->escape($data['filter_quantity']) . "'";
			}
			
			if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
				$sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
			}
					
			if (!empty($data['filter_category_id'])) {
				if (!empty($data['filter_sub_category'])) {
					$implode_data = array();
					
					$implode_data[] = "category_id = '" . (int)$data['filter_category_id'] . "'";
					
					$this->load->model('catalog/category');
					
					$categories = $this->model_catalog_category->getCategories($data['filter_category_id']);
					
					foreach ($categories as $category) {
						$implode_data[] = "p2c.category_id = '" . (int)$category['category_id'] . "'";
					}
					
					$sql .= " AND (" . implode(' OR ', $implode_data) . ")";			
				} else {
					$sql .= " AND p2c.category_id = '" . (int)$data['filter_category_id'] . "'";
				}
			}
			
			if (isset($data['filter_manufacturer']) && !is_null($data['filter_manufacturer'])) {
				$sql .= " AND p.manufacturer_id = '" . (int)$data['filter_manufacturer'] . "'";
			}

			$sql .= " GROUP BY p.product_id";
						
			$sort_data = array(
				'pd.name',
				'p.model',
				'p.price',
				'p.quantity',
				'p.status',
				'p.sort_order',
				'p.date_added'
			);	
			
			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];	
			} else {
				$sql .= " ORDER BY p.date_added";	
			}
			
			if (isset($data['order']) && ($data['order'] == 'DESC')) {
				$sql .= " DESC";
			} else {
				$sql .= " ASC";
			}
			
			if (isset($data['limit']) && $data['limit'] != -1 && isset($data['start'])) {
				if ($data['start'] < 0) {
					$data['start'] = 0;
				}

				if ($data['limit'] < 1) {
					$data['limit'] = 20;
				}	
				
				$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
			}

			$query = $this->db->query($sql);
			
			return $query->rows;
		} else {
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY pd.name ASC");
            $product_data = $query->rows;

			return $product_data;
		}
	}
	
	public function getTotalProducts($data = array()) {
		$sql = "SELECT COUNT(DISTINCT p.product_id) AS total FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id)";

		if (!empty($data['filter_category_id'])) {
			$sql .= " LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id)";			
		}
		 
		$sql .= " WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
		 			
		if (!empty($data['filter_name'])) {
			$sql .= " AND LCASE(pd.name) LIKE '%" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%'";
		}

		if (!empty($data['filter_model'])) {
			$sql .= " AND LCASE(p.model) LIKE '" . $this->db->escape(utf8_strtolower($data['filter_model'])) . "%'";
		}
		
		if (!empty($data['filter_price'])) {
			$sql .= " AND p.price LIKE '" . $this->db->escape($data['filter_price']) . "%'";
		}
		
		if (isset($data['filter_quantity']) && !is_null($data['filter_quantity'])) {
			$sql .= " AND p.quantity = '" . $this->db->escape($data['filter_quantity']) . "'";
		}
		
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
		}

		if (!empty($data['filter_category_id'])) {
			if (!empty($data['filter_sub_category'])) {
				$implode_data = array();
				
				$implode_data[] = "p2c.category_id = '" . (int)$data['filter_category_id'] . "'";
				
				$this->load->model('catalog/category');
				
				$categories = $this->model_catalog_category->getCategories($data['filter_category_id']);
				
				foreach ($categories as $category) {
					$implode_data[] = "p2c.category_id = '" . (int)$category['category_id'] . "'";
				}
				
				$sql .= " AND (" . implode(' OR ', $implode_data) . ")";			
			} else {
				$sql .= " AND p2c.category_id = '" . (int)$data['filter_category_id'] . "'";
			}
		}
		
		if (isset($data['filter_manufacturer']) && !is_null($data['filter_manufacturer'])) {
			$sql .= " AND p.manufacturer_id = '" . (int)$data['filter_manufacturer'] . "'";
		}
		
		$query = $this->db->query($sql);
		
		return $query->row['total'];
	}

	public function getProductsByCategoryId($category_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p2c.category_id = '" . (int)$category_id . "' ORDER BY pd.name ASC");
								  
		return $query->rows;
	} 
	
	public function getProductDescriptions($product_id) {
		$product_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_description WHERE product_id = '" . (int)$product_id . "'");
		
		foreach ($query->rows as $result) {
			$product_description_data[$result['language_id']] = array(
				'seo_title'        => $result['seo_title'],
				'seo_h1'           => $result['seo_h1'],
				'name'             => $result['name'],
				'description'      => $result['description'],
				'meta_keyword'     => $result['meta_keyword'],
				'meta_description' => $result['meta_description']
			);
		}
		
		return $product_description_data;
	}

	public function getProductAttributes($product_id) {
		$product_attribute_data = array();
		
		$product_attribute_query = $this->db->query("SELECT pa.attribute_id, ad.name FROM " . DB_PREFIX . "product_attribute pa LEFT JOIN " . DB_PREFIX . "attribute a ON (pa.attribute_id = a.attribute_id) LEFT JOIN " . DB_PREFIX . "attribute_description ad ON (a.attribute_id = ad.attribute_id) WHERE pa.product_id = '" . (int)$product_id . "' AND ad.language_id = '" . (int)$this->config->get('config_language_id') . "' GROUP BY pa.attribute_id");
		
		foreach ($product_attribute_query->rows as $product_attribute) {
			$product_attribute_description_data = array();
			
			$product_attribute_description_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product_id . "' AND attribute_id = '" . (int)$product_attribute['attribute_id'] . "'");
			
			foreach ($product_attribute_description_query->rows as $product_attribute_description) {
				$product_attribute_description_data[$product_attribute_description['language_id']] = array('text' => $product_attribute_description['text']);
			}
			
			$product_attribute_data[] = array(
				'attribute_id'                  => $product_attribute['attribute_id'],
				'name'                          => $product_attribute['name'],
				'product_attribute_description' => $product_attribute_description_data
			);
		}
		
		return $product_attribute_data;
	}

    public function getOptionProduct($product_option_value) {
        $query = $this->db->query("SELECT * FROM product_option_value t1 INNER JOIN option_value_description t2 WHERE t1.product_option_value_id='" . (int)$product_option_value . "' AND t1.option_value_id=t2.option_value_id");
        
        return $query->rows;
    }
    
	public function getProductOptions($product_id) {
		$product_option_data = array();
		
		$product_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id) WHERE po.product_id = '" . (int)$product_id . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY o.sort_order");
		
		foreach ($product_option_query->rows as $product_option) {
			if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {
				$product_option_value_data = array();	
				
				$product_option_value_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_option_id = '" . (int)$product_option['product_option_id'] . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY pov.product_sort_order, ov.sort_order, ovd.name = 0, -ovd.name, ovd.name");

				foreach ($product_option_value_query->rows as $product_option_value) {
					$product_option_value_data[] = array(
						'product_option_value_id' => $product_option_value['product_option_value_id'],
						'option_value_id'         => $product_option_value['option_value_id'],
						'name'                    => $product_option_value['name'],
						'image'                   => $product_option_value['image'],
						'quantity'                => $product_option_value['quantity'],
						'subtract'                => $product_option_value['subtract'],
						'price'                   => $product_option_value['price'],
						'price_prefix'            => $product_option_value['price_prefix'],
						'points'                  => $product_option_value['points'],
						'points_prefix'           => $product_option_value['points_prefix'],						
						'weight'                  => $product_option_value['weight'],
						'weight_prefix'           => $product_option_value['weight_prefix'],
                        'sort_order'              => $product_option_value['product_sort_order']
					);
				}
				
				$product_option_data[] = array(
					'product_option_id'    => $product_option['product_option_id'],
					'option_id'            => $product_option['option_id'],
					'name'                 => $product_option['name'],
					'type'                 => $product_option['type'],
					'product_option_value' => $product_option_value_data,
					'required'             => $product_option['required'],
				);				
			} else {
				$product_option_data[] = array(
					'product_option_id' => $product_option['product_option_id'],
					'option_id'         => $product_option['option_id'],
					'name'              => $product_option['name'],
					'type'              => $product_option['type'],
					'option_value'      => $product_option['option_value'],
					'required'          => $product_option['required'],
				);				
			}
		}	
		
		return $product_option_data;
	}

	public function getProductImages($product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int)$product_id . "'");
		
		return $query->rows;
	}
	
	public function getProductDiscounts($product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product_id . "' ORDER BY quantity, priority, price");
		
		return $query->rows;
	}
	
	public function getProductSpecials($product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product_id . "' ORDER BY priority, price");
		
		return $query->rows;
	}
	
	public function getProductRewards($product_id) {
		$product_reward_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_reward WHERE product_id = '" . (int)$product_id . "'");
		
		foreach ($query->rows as $result) {
			$product_reward_data[$result['customer_group_id']] = array('points' => $result['points']);
		}
		
		return $product_reward_data;
	}
		
	public function getProductDownloads($product_id) {
		$product_download_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_download WHERE product_id = '" . (int)$product_id . "'");
		
		foreach ($query->rows as $result) {
			$product_download_data[] = $result['download_id'];
		}
		
		return $product_download_data;
	}

	public function getProductStores($product_id) {
		$product_store_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_store WHERE product_id = '" . (int)$product_id . "'");

		foreach ($query->rows as $result) {
			$product_store_data[] = $result['store_id'];
		}
		
		return $product_store_data;
	}

	public function getProductLayouts($product_id) {
		$product_layout_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_layout WHERE product_id = '" . (int)$product_id . "'");
		
		foreach ($query->rows as $result) {
			$product_layout_data[$result['store_id']] = $result['layout_id'];
		}
		
		return $product_layout_data;
	}
	
	public function getProductCategoriesInfo($product_id) {			
		$product_category_data = array();
		$query = $this->db->query("SELECT c.*, cd.name FROM " . DB_PREFIX . "product_to_category c INNER JOIN " . DB_PREFIX . "category_description cd ON c.category_id = cd.category_id WHERE product_id = '" . (int)$product_id . "'");

		foreach ($query->rows as $result) {
			$path = $this->model_catalog_category->getPath( $result['category_id'] );
			$product_category_data[] = array(
				'id' => $result['category_id'], 
				'name' => $result['name'],
				'path' => $path
				);
		}
		
		return $product_category_data;
	}

	public function getProductCategories($product_id) {
		$product_category_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "'");
		
		foreach ($query->rows as $result) {
			$product_category_data[] = $result['category_id'];
		}

		return $product_category_data;
	}
	
	public function getProductRelated($product_id) {
		$product_related_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$product_id . "'");
		
		foreach ($query->rows as $result) {
			$product_related_data[] = $result['related_id'];
		}
		
		return $product_related_data;
	}
	
	public function getProductTags($product_id) {
		$product_tag_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_tag WHERE product_id = '" . (int)$product_id . "'");
		
		$tag_data = array();
		
		foreach ($query->rows as $result) {
			$tag_data[$result['language_id']][] = $result['tag'];
		}
		
		foreach ($tag_data as $language => $tags) {
			$product_tag_data[$language] = implode(',', $tags);
		}
		
		return $product_tag_data;
	}
	
	public function getTotalProductsByTaxClassId($tax_class_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product WHERE tax_class_id = '" . (int)$tax_class_id . "'");
                
		return $query->row['total'];
	}
		
	public function getTotalProductsByStockStatusId($stock_status_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product WHERE stock_status_id = '" . (int)$stock_status_id . "'");

		return $query->row['total'];
	}
	
	public function getTotalProductsByPricePrefixId($price_prefix_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product_table NATURAL JOIN " . DB_PREFIX . "product_table_option_value_price WHERE price_prefix_id='" . (int)$price_prefix_id . "' group by product_id");
		$count_product = $query->num_rows;

		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product WHERE price_prefix_id = '" . (int)$price_prefix_id . "'");

		if ($query->row['total'] != 0) {
			$count_product = $query->row['total'];
		}

		return $count_product;
	}

	public function getTotalProductsByPriceAfterId($price_after_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product_table NATURAL JOIN " . DB_PREFIX . "product_table_option_value_price WHERE price_after_id='" . (int)$price_after_id . "' group by product_id");
		$count_product = $query->num_rows;
		
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product WHERE price_after_id = '" . (int)$price_after_id . "'");

		if ($query->row['total'] != 0) {
			$count_product = $query->row['total'];
		}

		return $count_product;
	}

	public function getTotalProductsByWeightClassId($weight_class_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product WHERE weight_class_id = '" . (int)$weight_class_id . "'");

		return $query->row['total'];
	}
	
	public function getTotalProductsByLengthClassId($length_class_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product WHERE length_class_id = '" . (int)$length_class_id . "'");

		return $query->row['total'];
	}

	public function getTotalProductsByDownloadId($download_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product_to_download WHERE download_id = '" . (int)$download_id . "'");
		
		return $query->row['total'];
	}
	
	public function getTotalProductsByManufacturerId($manufacturer_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");

		return $query->row['total'];
	}
    
    public function getProductManufacturerId($manufacturer_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product NATURAL JOIN " . DB_PREFIX . "product_description WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");
        
        return $query->rows;
    }
    
	public function getTotalProductsByAttributeId($attribute_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product_attribute WHERE attribute_id = '" . (int)$attribute_id . "'");

		return $query->row['total'];
	}	
	
	public function getTotalProductsByTabId($tab_id) {
		$query = $this->db->query("SELECT COUNT(DISTINCT product_id) AS total FROM " . DB_PREFIX . "product_tab WHERE tab_id = '" . (int)$tab_id . "'");

		return $query->row['total'];
	}
	
	public function getTotalProductsByOptionId($option_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product_option WHERE option_id = '" . (int)$option_id . "'");

		return $query->row['total'];
	}
	
	public function getProductTabs($product_id) {
		$product_tab_data = array();
		$product_tab_query = $this->db->query("SELECT t.tab_id, td.name FROM " . DB_PREFIX . "product_tab pt LEFT JOIN " . DB_PREFIX . "tab t ON (pt.tab_id = t.tab_id) LEFT JOIN " . DB_PREFIX . "tab_description td ON (t.tab_id = td.tab_id) WHERE pt.product_id = '" . (int)$product_id . "' AND td.language_id = '" . (int)$this->config->get('config_language_id') . "' GROUP BY pt.tab_id");

		foreach ($product_tab_query->rows as $product_tab) {

			$product_tab_description_data = array();
			$product_tab_description_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_tab WHERE product_id = '" . (int)$product_id . "' AND tab_id = '" . (int)$product_tab['tab_id'] . "'");

			foreach ($product_tab_description_query->rows as $product_tab_description) {
				$product_tab_description_data[$product_tab_description['language_id']] = array('text' => $product_tab_description['text']);
			}

			$product_tab_data[] = array(
				'tab_id' 									=> $product_tab['tab_id'],
				'name'         						=> $product_tab['name'],
				'product_tab_description' => $product_tab_description_data
			);

		}
		return $product_tab_data;
	}

	public function getTotalProductsByLayoutId($layout_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product_to_layout WHERE layout_id = '" . (int)$layout_id . "'");

		return $query->row['total'];
	}
    
    public function getProductValuesCopy($product_id) {
		$options = $this->getProductOptionsFilter($product_id);
		$filters = array();

		foreach ($options as $option) {
			$values = $this->getProductValuesFilter($product_id, $option['option_id']);
			$data_value_id = array();

			foreach ($values as $value_id) {
				$data_value_id[] = $value_id['value_id'];
			}

			$filters[$option['option_id']] = $data_value_id;
		}
		
		return $filters;
	}

    public function getProductValues($product_id) {
		$values_id = array();
                
		$query = $this->db->query("SELECT p2v.value_id AS value_id FROM " . DB_PREFIX . "product_to_value p2v WHERE p2v.product_id = '" . (int)$product_id . "'");

		foreach ($query->rows as $result) {
			$values_id[] = $result['value_id'];
		}
        
		return $values_id;
	}

    // public function deleteProductFabric($product_id, $fabric_id) {
    //     $this->db->query("DELETE FROM " . DB_PREFIX . "product_fabric_value WHERE product_id = '" . (int)$product_id . "' AND fabric_id = '" . (int)$fabric_id . "'");
    //     $this->db->query("DELETE FROM " . DB_PREFIX . "product_fabric WHERE product_id = '" . (int)$product_id . "' AND fabric_id = '" . (int)$fabric_id . "'");
    //     $this->db->query("DELETE FROM " . DB_PREFIX . "product_fabric_option_price WHERE product_id = '" . (int)$product_id . "' AND fabric_id = '" . (int)$fabric_id . "'");
    // }
    
    // public function deleteProductFabricValue($product_id, $fabric_id, $manufacturer_id) {
    //     $this->db->query("DELETE FROM " . DB_PREFIX . "product_fabric_value WHERE product_id = '" . (int)$product_id . "' AND manufacturer_id = '" . (int)$manufacturer_id . "' AND fabric_id = '" . (int)$fabric_id . "'");
    // }
    
    // public function deleteFabricValue($product_id) {
    //     $this->db->query("DELETE FROM " . DB_PREFIX . "product_fabric_value WHERE product_id = '" . (int)$product_id . "'");
    // }
    
    // public function deleteAllFabricByProduct($product_id) {
    //     $this->db->query("DELETE FROM " . DB_PREFIX . "product_fabric_value WHERE product_id = '" . (int)$product_id . "'");
    //     $this->db->query("DELETE FROM " . DB_PREFIX . "product_fabric WHERE product_id = '" . (int)$product_id . "'");
    //     $this->db->query("DELETE FROM " . DB_PREFIX . "product_fabric_option_price WHERE product_id = '" . (int)$product_id . "'");
    // }
    
    // public function getProductStatusFabric($product_id) {
    //     $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product WHERE product_id = '" . $product_id . "'");
        
    //     return $query->row;
    // }
    
    // public function status_fabric($status_fabric, $product_id) {
    //     $this->db->query("UPDATE " . DB_PREFIX . "product SET status_fabric='" . (int)$status_fabric . "' WHERE product_id='" . (int)$product_id . "'");
    // }
    

    // public function appendFabric($product_option_id, $value) {
    //     $this->db->query("UPDATE " . DB_PREFIX . "product_option SET append_fabric='" . (int)$value . "' WHERE product_option_id = '" . $product_option_id . "'");
    // }
    // public function getFabricProduct($product_id, $fabric_id) {
    //     $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_fabric WHERE product_id = '" . (int)$product_id . "' AND fabric_id = '" . (int)$fabric_id . "'");
        
    //     return $query->row;
    // }
    
    // public function getProductFabric($product_id) {
    //     $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "fabric NATURAL JOIN " . DB_PREFIX . "product_fabric WHERE product_id = '" . (int)$product_id . "' ORDER BY sort_order");
        
    //     return $query->rows;
    // }
    
    // public function getProductFabricValue($product_id, $fabric_id) {
    //     $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product NATURAL JOIN " . DB_PREFIX . "product_description t1 INNER JOIN " . DB_PREFIX . "product_fabric_value t2 ON (t2.fabric_product_id = t1.product_id) AND fabric_id = '" . (int)$fabric_id . "' AND t2.product_id = '" . (int)$product_id . "'");
        
    //     return $query->rows;
    // }
    
    // public function saveProductFabric($product_id, $fabric_id) {
    //     $this->db->query("INSERT INTO " . DB_PREFIX . "product_fabric SET fabric_id = '" . (int)$fabric_id . "', product_id = '" . (int)$product_id . "'");
    // }
    
    // public function saveProductFabricValue($data) {
    //    $this->db->query("INSERT INTO " . DB_PREFIX . "product_fabric_value SET product_id='" . (int)$data['product_id'] . "', fabric_id='" . (int)$data['fabric_id'] . "', manufacturer_id = '" . (int)$data['manufacturer_id'] . "', fabric_product_id= '" . (int)$data['fabric_product_id'] . "'");
    // }
    
    // public function getAllFabricByProduct($product_id) {
    //     $product_fabrics = $this->getProductFabric($product_id);
    //     $data_fabric = array();
        
    //     foreach ($product_fabrics as $product_fabric) {
    //         $product_fabric_values = $this->getProductFabricValue($product_id, $product_fabric['fabric_id']);
            
    //         $data_fabric[] = array(
    //             'fabric_id'             => $product_fabric['fabric_id'],
    //             'name'                  => $product_fabric['name'],
    //             'product_fabric_values' => $product_fabric_values
    //         );
    //     }
        
    //     return $data_fabric;
    // }
    
    // public function deletePriceFabricOption($dataPrice) {
    //     $this->db->query("DELETE FROM " . DB_PREFIX . "product_fabric_option_price WHERE product_id='" . (int)$dataPrice['product_id'] . "' AND product_option_id = '" . (int)$dataPrice['product_option_id'] . "'");
    // }
    
    // public function savePrice($dataPrice) {
    //     $this->db->query("INSERT INTO " . DB_PREFIX . "product_fabric_option_price SET product_id='" . (int)$dataPrice['product_id'] . "', price='" . (int)$dataPrice['price'] . "', fabric_id='" . (int)$dataPrice['fabric_id'] . "', product_option_id = '" . (int)$dataPrice['product_option_id'] . "', product_option_value_id='" . (int)$dataPrice['product_option_value_id'] . "'");
    // }
    
    // public function getPriceFabric($product_id, $product_option_value_id) {
    //     $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_fabric_option_price WHERE product_id='" . (int)$product_id . "' AND product_option_value_id='" . (int)$product_option_value_id . "'");
        
    //     return $query->rows;
    // }
    
    // public function getProductFabricOptionPrice($product_id) {
    //     $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_fabric_option_price WHERE product_id = '" . (int)$product_id . "'");
    
    //     return $query->rows;
    // }
    
    // public function deletePriceOption($product_id, $product_option_value_id) {
    //     $this->db->query("DELETE FROM " . DB_PREFIX . "product_fabric_option_price WHERE product_option_value_id='" . (int)$product_option_value_id . "' AND product_id='" . (int)$product_id . "'");
    // }
	
    // public function removeOption($product_id, $product_option_id) {
    //     $this->db->query("DELETE FROM " . DB_PREFIX . "product_option WHERE product_id = '" . (int)$product_id . "' AND product_option_id = '" . (int)$product_option_id . "'");
    //     $this->db->query("DELETE FROM " . DB_PREFIX . "product_option_value WHERE product_id = '" . (int)$product_id . "' AND product_option_id = '" . (int)$product_option_id . "'");
    //     $this->db->query("DELETE FROM " . DB_PREFIX . "product_fabric_option_price WHERE product_id = '" . (int)$product_id . "' AND product_option_id = '" . (int)$product_option_id . "'");
    //     $this->db->query("DELETE " . DB_PREFIX . "t1, " . DB_PREFIX . "t2 FROM " . DB_PREFIX . "product_options_price t1 INNER JOIN " . DB_PREFIX . "product_option_value t2 ON(option_horizont = product_option_value_id) WHERE t2.product_id = '" . (int)$product_id . "' AND product_option_id = '" . (int)$product_option_id . "'");
    //     $this->db->query("DELETE " . DB_PREFIX . "t1, " . DB_PREFIX . "t2 FROM " . DB_PREFIX . "product_options_price t1 INNER JOIN " . DB_PREFIX . "product_option_value t2 ON(option_vertical = product_option_value_id) WHERE t2.product_id = '" . (int)$product_id . "' AND product_option_id = '" . (int)$product_option_id . "'");
    // }
    
    // public function removeOptionValue($product_id, $product_option_id, $product_option_value_id) {
    //     $this->db->query("DELETE FROM " . DB_PREFIX . "product_option_value WHERE product_id = '" . (int)$product_id . "' AND product_option_id = '" . (int)$product_option_id . "' AND product_option_value_id = '" . $product_option_value_id . "'");
    //     $this->db->query("DELETE FROM " . DB_PREFIX . "product_fabric_option_price WHERE product_id = '" . (int)$product_id . "' AND product_option_id = '" . (int)$product_option_id . "' AND product_option_value_id = '" . $product_option_value_id . "'");
    //     $this->db->query("DELETE FROM " . DB_PREFIX . "product_options_price WHERE product_id = '" . (int)$product_id . "' AND option_vertical = '" . (int)$product_option_value_id . "'");
    //     $this->db->query("DELETE FROM " . DB_PREFIX . "product_options_price WHERE product_id = '" . (int)$product_id . "' AND option_horizont = '" . (int)$product_option_value_id . "'");
    // }
	
	// public function deleteProductOptionsPrice($product_id) {
	// 	$this->db->query("DELETE FROM " . DB_PREFIX . "product_options_price WHERE product_id = '" . (int)$product_id . "'");
	// }
	
	// public function getOptionValue($product_id, $product_option_id) {
	// 	$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value NATURAL JOIN option_value_description NATURAL JOIN option_value WHERE product_id = '" . (int)$product_id . "' and product_option_id = '" . (int)$product_option_id. "' ORDER BY product_sort_order");

 //        return $query->rows;
	// }

	// public function getProductOptionsPriceCopy($product_id) {
	// 	$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_options_price WHERE product_id = '" . (int)$product_id . "'");

	// 	return $query->rows;
	// }

	// public function getProductOptionPrice($product_id) {
	// 	$product_option = array();

	// 	$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "option_description  NATURAL JOIN " . DB_PREFIX . "product_option_value INNER JOIN " . DB_PREFIX . "product_options_price ON(option_vertical = product_option_value_id) WHERE product_option_value.product_id = '" . (int)$product_id . "' GROUP BY product_option_id");
		
	// 	$product_option['name_option_vertical'] = $query->row;

	// 	$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "option_description  NATURAL JOIN " . DB_PREFIX . "product_option_value INNER JOIN " . DB_PREFIX . "product_options_price ON(option_horizont = product_option_value_id) WHERE product_option_value.product_id = '" . (int)$product_id . "' GROUP BY product_option_id");
		
	// 	$product_option['name_option_horizont'] = $query->row;

	// 	return $product_option;
	// }

	// public function getProductOptionsPrice($product_id) {
	// 	$product_option_price['otpions_price'] = $this->getProductOptionsPriceCopy($product_id);
		
	// 	$name_option = $this->getProductOptionPrice($product_id);
	// 	$product_option_price['name_option_vertical'] = $name_option['name_option_vertical'];
	// 	$product_option_price['name_option_horizont'] = $name_option['name_option_horizont'];

	// 	$product_option_price['option_horizont'] = array();

	// 	if ($name_option['name_option_horizont']) {
	// 		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "option_value_description NATURAL JOIN " . DB_PREFIX . "product_option_value LEFT JOIN " . DB_PREFIX . "product_options_price on(option_horizont = product_option_value_id) WHERE product_option_value.product_id = '" . (int)$product_id . "' and product_option_value.product_option_id = '" . (int)$name_option['name_option_horizont']['product_option_id'] . "' GROUP BY product_option_value_id ORDER BY product_sort_order");
			
	// 		$product_option_price['option_horizont'] = $query->rows;
	// 	}

	// 	$product_option_price['option_vertical'] = array();

	// 	if ($name_option['name_option_vertical']) {
	// 		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "option_value_description NATURAL JOIN " . DB_PREFIX . "product_option_value LEFT JOIN " . DB_PREFIX . "product_options_price on(option_vertical = product_option_value_id) WHERE product_option_value.product_id = '" . (int)$product_id . "' and product_option_value.product_option_id = '" . (int)$name_option['name_option_vertical']['product_option_id'] . "' GROUP BY product_option_value_id ORDER BY product_sort_order");
			
	// 		$product_option_price['option_vertical'] = $query->rows;
	// 	}

	// 	$data_option_vertical = array();

	// 	foreach ($product_option_price['option_vertical'] as $key => $option_vertical) {
	// 		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "option_value_description NATURAL JOIN " . DB_PREFIX . "product_option_value INNER JOIN " . DB_PREFIX . "product_options_price on(option_horizont = product_option_value_id) WHERE product_option_value.product_id = '" . (int)$product_id . "' and product_options_price.option_vertical = '" . (int)$option_vertical['option_vertical'] . "' GROUP BY product_option_value_id ORDER BY product_sort_order");

	// 		$data_option_vertical[$key]['vertical'] = $option_vertical;
	// 		$data_option_vertical[$key]['data'] = $query->rows;
	// 	}

	// 	$product_option_price['option_vertical'] = $data_option_vertical;
		
	// 	return $product_option_price;
	// }
	
	
	
	
	
	public function getProductTableCopy($product_id, $table_numbers = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "product_table WHERE product_id = '" . (int)$product_id . "'";

		if (count($table_numbers) > 0) {
			$sql .= " AND number_table IN(" . implode(', ', $table_numbers) . ") ";
		}

		$sql .= " ORDER BY product_table_sort";
		$tables = $this->db->query($sql);
		$product_table = array();
		
		foreach ($tables->rows as $table) {
			$options = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_table_option AS t1 WHERE t1.product_table_id = '" . (int)$table['product_table_id'] . "' ORDER BY t1.vertical DESC, t1.product_table_option_id");
			$data_option = array();

			foreach ($options->rows as $option) {
				$product_option_values = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_table_option_value AS t1 WHERE t1.product_table_option_id = '" . (int)$option['product_table_option_id'] . "' ORDER BY t1.product_table_option_value_id");
				$data_option_value = array();
				
				foreach ($product_option_values->rows as $key => $product_option_value) {
					$data_option_value[$key] = array(
						'product_table_option_value_id' 	=> '',
						'option_value_id' 					=> $product_option_value['option_value_id'],
						'product_table_option_value_image' 	=> $product_option_value['product_table_option_value_image'],
						'product_table_option_value_sort' 	=> $product_option_value['product_table_option_value_sort']
					);
				}
				
				$data_option[$option['option_id']] = array(
					'vertical' 						=> $option['vertical'],
					'product_table_option_id' 		=> '',
					'product_table_option_value' 	=> $data_option_value
				);
			}

			$price = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "product_table_option_value_price WHERE product_table_id = '" . (int)$table['product_table_id'] . "' GROUP BY option_value_horizont");
			$option_value_horizont = array();

			foreach ($price->rows as $horizont) {
				$price_vertical = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_table_option_value_price AS t1 WHERE t1.product_table_id = '" . (int)$table['product_table_id'] . "' AND option_value_horizont = '" . (int)$horizont['option_value_horizont'] . "'");
				$option_value_vertical = array();

				foreach ($price_vertical->rows as $vertical) {
					$option_value_vertical[$vertical['option_value_vertical']] = array(
						'price' 								=> $vertical['price'],
						'price_after_id' 						=> $vertical['price_after_id'],
						'price_prefix_id' 						=> $vertical['price_prefix_id'],
						'product_table_option_value_price_id' 	=> ''
					);
				}
				
				$option_value_horizont[$horizont['option_value_horizont']] = array(
					'option_value_vertical' => $option_value_vertical
				);
			}

			$product_table['table'][$table['number_table']] = array(
				'product_table_name' 	=> $table['product_table_name'],
				'product_table_id' 		=> '',
				'product_table_sort' 	=> $table['product_table_sort'],
				'type_table' 			=> $table['type_table'],
				'option_id' 			=> $data_option,
				'option_value_horizont' => $option_value_horizont
			);
		}

		return $product_table;
	}

	public function getProductTable($product_id) {
		$tables = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_table WHERE product_id = '" . (int)$product_id . "' ORDER BY product_table_sort");
		$product_table = array();
		
		foreach ($tables->rows as $table) {
			$options = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_table_option AS t1 NATURAL JOIN " . DB_PREFIX . "option_description AS t2 WHERE t1.product_table_id = '" . (int)$table['product_table_id'] . "' ORDER BY t1.vertical DESC, t1.product_table_option_id");
			$data_option = array();

			foreach ($options->rows as $option) {
				$product_option_values = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_table_option_value AS t1 NATURAL JOIN " . DB_PREFIX . "option_value AS t2 WHERE t1.product_table_option_id = '" . (int)$option['product_table_option_id'] . "' ORDER BY t1.product_table_option_value_sort, product_table_option_value_id");
				$data_option_value = array();
				
				foreach ($product_option_values->rows as $key => $product_option_value) {
					$data_option_value[$key] = array(
						'product_table_option_value_id' 	=> $product_option_value['product_table_option_value_id'],
						'option_value_id' 					=> $product_option_value['option_value_id'],
						'product_table_option_value_image' 	=> $product_option_value['product_table_option_value_image'],
						'product_table_option_value_sort' 	=> $product_option_value['product_table_option_value_sort']
					);
				}

				$option_values = $this->db->query("SELECT * FROM " . DB_PREFIX . "option_value_description AS t1 NATURAL JOIN " . DB_PREFIX . "option_value AS t2 WHERE t1.option_id = '" . (int)$option['option_id'] . "' ORDER BY t1.name, t2.sort_order");

				$data_option[$option['option_id']] = array(
					'vertical' 						=> $option['vertical'],
					'product_table_option_id' 		=> $option['product_table_option_id'],
					'name' 							=> $option['name'],
					'option_value' 					=> $option_values->rows,
					'product_table_option_value' 	=> $data_option_value
				);
			}

			$price = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "product_table_option_value_price WHERE product_table_id = '" . (int)$table['product_table_id'] . "' GROUP BY option_value_horizont");
			$option_value_horizont = array();

			foreach ($price->rows as $horizont) {
				$price_vertical = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_table_option_value_price AS t1 WHERE t1.product_table_id = '" . (int)$table['product_table_id'] . "' AND option_value_horizont = '" . (int)$horizont['option_value_horizont'] . "'");
				$option_value_vertical = array();

				foreach ($price_vertical->rows as $vertical) {
					// $data_special = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_table_option_value_price_special NATURAL JOIN " . DB_PREFIX . "product_special WHERE product_table_option_value_price_id = '" . (int)$vertical['product_table_option_value_price_id'] . "' ORDER BY product_table_option_value_price_special_id");

					$option_value_vertical[$vertical['option_value_vertical']] = array(
						'price' 								=> $vertical['price'],
						'price_after_id' 						=> $vertical['price_after_id'],
						'price_prefix_id' 						=> $vertical['price_prefix_id'],
						'product_table_option_value_price_id' 	=> $vertical['product_table_option_value_price_id'],
						// 'product_table_option_value_price_special' => $data_special->rows,
					);
				}

				$option_value_horizont[$horizont['option_value_horizont']] = array(
					'option_value_vertical' => $option_value_vertical
				);
			}

			$product_table['table'][$table['number_table']] = array(
				'product_table_id' 		=> $table['product_table_id'],
				'product_table_name'	=> $table['product_table_name'],
				'product_table_sort'	=> $table['product_table_sort'],
				'type_table'			=> $table['type_table'],
				'option_id' 			=> $data_option,
				'option_value_horizont' => $option_value_horizont
			);
		}
		
		return $product_table;
	}
	
	public function insertProductTable($product_table, $product_id) {
        if (isset($product_table['table'])) {
            foreach ($product_table['table'] as $key => $value_main) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "product_table (product_table_id, product_id, number_table, product_table_sort, product_table_name, type_table) VALUES(" . (int)$value_main['product_table_id'] . ", " . (int)$product_id . ", " . (int)$key . ", " . (int)$value_main['product_table_sort'] . ", '" . $value_main['product_table_name'] . "', '" . (int)$value_main['type_table'] . "')");
                $product_table_id = $this->db->getLastId();
                $exeption_option_value = array();
                $exeption_option_value_horizont = array();

                if (isset($value_main['option_id'])) {
                    $count = 1;

                    foreach ($value_main['option_id'] as $key => $value) {
                        $this->db->query("INSERT INTO " . DB_PREFIX . "product_table_option (product_table_option_id, option_id, product_table_id, vertical) VALUES(" . (int)$value['product_table_option_id'] . ", " . (int)$key . ", " . (int)$product_table_id . ", " . (int)$value['vertical'] . ")");
                        $product_table_option_id = $this->db->getLastId();
                        $vertical = $value['vertical'];

                        if (isset($value['product_table_option_value'])) {
                            foreach ($value['product_table_option_value'] as $value) {
                                if ($count == 1 || $vertical == 0) {
                                    if (in_array($value['option_value_id'], $exeption_option_value) == false) {
                                        $exeption_option_value[] = $value['option_value_id'];

                                        $product_table_option_value_image = '';

                                        if (isset($value['product_table_option_value_image'])) {
                                            $product_table_option_value_image = $value['product_table_option_value_image'];
                                        }

                                        if ($value['option_value_id'] != 0) {
                                            $this->db->query("INSERT INTO " . DB_PREFIX . "product_table_option_value (product_table_option_value_id, option_value_id, product_table_option_id, product_table_option_value_sort, product_table_option_value_image) VALUES(" . (int)$value['product_table_option_value_id'] . ", " . (int)$value['option_value_id'] . ", " . (int)$product_table_option_id . ", " . (int)$value['product_table_option_value_sort'] . ", '" . $product_table_option_value_image . "')");
                                        }
                                    }
                                } else {
                                    $exeption_option_value[] = $value['option_value_id'];

                                    if ($value['option_value_id'] != 0) {
                                        $this->db->query("INSERT INTO " . DB_PREFIX . "product_table_option_value (product_table_option_value_id, option_value_id, product_table_option_id, product_table_option_value_sort) VALUES(" . (int)$value['product_table_option_value_id'] . ", " . (int)$value['option_value_id'] . ", " . (int)$product_table_option_id . ", " . (int)$value['product_table_option_value_sort'] . ")");
                                    }
                                }
                            }
                        }
                        $count += 1;
                    }
                }

                if (isset($value_main['option_value_horizont'])) {
                    foreach ($value_main['option_value_horizont'] as $key => $value) {
                        $option_value_horizont = $key;

                        foreach ($value['option_value_vertical'] as $key => $value) {
                            if ($value['price'] == '') {
                                $value['price'] = 0;
                            }

                            $option_value_vertical = $key;
                            $price_after_id = 0;

                            if (isset($value['price_after_id'])) {
                                $price_after_id = $value['price_after_id'];
                            }

                            $price_prefix_id = 0;

                            if (isset($value['price_prefix_id'])) {
                                $price_prefix_id = $value['price_prefix_id'];
                            }

                            if (in_array($option_value_vertical, $exeption_option_value) == true && in_array($option_value_horizont, $exeption_option_value) || $option_value_horizont == 0 || $option_value_vertical == 0) {
                                $this->db->query("INSERT INTO " . DB_PREFIX . "product_table_option_value_price (product_table_option_value_price_id, product_table_id, option_value_horizont, option_value_vertical, price, price_after_id, price_prefix_id) VALUES(" . (int)$value['product_table_option_value_price_id'] . ", " . (int)$product_table_id . ", " . (int)$option_value_horizont . ", " . (int)$option_value_vertical . ", " . round((float)$value['price']) . ", " . (int)$price_after_id . ", " . (int)$price_prefix_id . ")");
                            }
                        }
                    }
                }
            }
        }
	}

	public function getProductFabricOptionCopy($product_id) {
		$data = array();

		$product_fabric_options = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_fabric_option NATURAL JOIN " . DB_PREFIX . "option_description WHERE product_id = '" . (int)$product_id . "' ORDER BY product_fabric_option_id");

		foreach ($product_fabric_options->rows as $product_fabric_option) {
			$product_fabric_option_values = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_fabric_option_value WHERE product_fabric_option_id = '" . (int)$product_fabric_option['product_fabric_option_id'] . "' ORDER BY product_fabric_option_value_id");
			$data_option_value = array();

			foreach ($product_fabric_option_values->rows as $product_fabric_option_value) {
				$data_option_value_products = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_fabric_option_value_product WHERE product_fabric_option_value_id = '" . (int)$product_fabric_option_value['product_fabric_option_value_id'] . "' ORDER BY product_fabric_option_value_product_id");
				$data_fabric_product = array();

				foreach ($data_option_value_products->rows as $data_option_value_product) {
					$data_fabric_product[] = array(
						'product_id' => $data_option_value_product['product_id'],
						'product_fabric_option_value_product_id' => ''
					);
				}

				$data_option_value[] = array(
					'option_value_id' => $product_fabric_option_value['option_value_id'],
					'product_fabric_option_value_id' => '', 
					'product_fabric_option_value_product' => $data_fabric_product
				);
			}

			$data[] = array(
				'option_id' => $product_fabric_option['option_id'],
				'product_fabric_option_id' 		=> '',
				'product_fabric_option_value' 	=> $data_option_value,
			);
		}

		return $data;
	}

	public function getOtherProductFabricOptionCopy($product_id) {
		$data = array();

		$product_fabric_options = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_fabric_option NATURAL JOIN " . DB_PREFIX . "option_description WHERE product_id = '" . (int)$product_id . "' ORDER BY product_fabric_option_id");

		foreach ($product_fabric_options->rows as $product_fabric_option) {
			$product_fabric_option_values = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_fabric_option_value WHERE product_fabric_option_id = '" . (int)$product_fabric_option['product_fabric_option_id'] . "' ORDER BY product_fabric_option_value_id");
			$data_option_value = array();

			foreach ($product_fabric_option_values->rows as $product_fabric_option_value) {
				$data_option_value_products = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_fabric_option_value_product WHERE product_fabric_option_value_id = '" . (int)$product_fabric_option_value['product_fabric_option_value_id'] . "' ORDER BY product_fabric_option_value_product_id");
				$data_fabric_product = array();

				foreach ($data_option_value_products->rows as $data_option_value_product) {
					$data_fabric_product[] = array(
						'product_id' => $data_option_value_product['product_id'],
						'product_fabric_option_value_product_id' => $data_option_value_product['product_fabric_option_value_product_id']
					);
				}

				$data_option_value[] = array(
					'option_value_id' => $product_fabric_option_value['option_value_id'],
					'product_fabric_option_value_id' => $product_fabric_option_value['product_fabric_option_value_id'],
					'product_fabric_option_value_product' => $data_fabric_product
				);
			}

			$data[] = array(
				'option_id' => $product_fabric_option['option_id'],
				'product_fabric_option_id' 		=> $product_fabric_option['product_fabric_option_id'],
				'product_fabric_option_value' 	=> $data_option_value,
			);
		}

		return $data;
	}

	public function getProductFabricOption($product_id) {
		$data = array();

		$product_fabric_options = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_fabric_option NATURAL JOIN " . DB_PREFIX . "option_description WHERE product_id = '" . (int)$product_id . "' ORDER BY product_fabric_option_id");

		foreach ($product_fabric_options->rows as $product_fabric_option) {
			$product_fabric_option_values = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_fabric_option_value NATURAL JOIN " . DB_PREFIX . "option_value_description WHERE product_fabric_option_id = '" . (int)$product_fabric_option['product_fabric_option_id'] . "' ORDER BY product_fabric_option_value_id");
			$option_values = $this->db->query("SELECT * FROM " . DB_PREFIX . "option_value AS t1 NATURAL JOIN " . DB_PREFIX . "option_value_description AS t2 WHERE t1.option_id = '" . (int)$product_fabric_option['option_id'] . "' ORDER BY t1.sort_order");
			$data_product_fabric_option_value = array();

			foreach ($product_fabric_option_values->rows as $product_fabric_option_value) {
				$data_product_option_value_products = $this->db->query("SELECT t1.*, model, name FROM " . DB_PREFIX . "product_fabric_option_value_product AS t1 NATURAL JOIN " . DB_PREFIX . "product AS t2 NATURAL JOIN " . DB_PREFIX . "product_description AS t3 WHERE t1.product_fabric_option_value_id = '" . (int)$product_fabric_option_value['product_fabric_option_value_id'] . "' ORDER BY t1.product_fabric_option_value_product_id");

				$data_product_fabric_option_value[] = array(
					'option_value_id' => $product_fabric_option_value['option_value_id'],
					'name' => $product_fabric_option_value['name'],
					'product_fabric_option_value_id' => $product_fabric_option_value['product_fabric_option_value_id'], 
					'product_fabric_option_value_product' => $data_product_option_value_products->rows
				);
			}

			$data[] = array(
				'option_id' => $product_fabric_option['option_id'],
				'name' => $product_fabric_option['name'],
				'product_fabric_option_id' 		=> $product_fabric_option['product_fabric_option_id'],
				'product_fabric_option_value' 	=> $data_product_fabric_option_value,
				'option_values' 				=> $option_values->rows
			);
		}

		return $data;
	}
	
	public function insertProductFabric($product_fabric, $product_id) {
		foreach ($product_fabric as $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "product_fabric_option (product_fabric_option_id, product_id, option_id) VALUES(" . (int)$value['product_fabric_option_id'] . ", " . (int)$product_id . ", " . (int)$value['option_id'] . ")");
			$product_fabric_option_id = $this->db->getLastId();

			if (isset($value['product_fabric_option_value'])) {
				foreach ($value['product_fabric_option_value'] as $value) {
					
					$this->db->query("INSERT INTO " . DB_PREFIX . "product_fabric_option_value (product_fabric_option_value_id, product_fabric_option_id, option_value_id) VALUES(" . (int)$value['product_fabric_option_value_id'] . ", " . (int)$product_fabric_option_id . ", " . (int)$value['option_value_id'] . ")");
					$product_fabric_option_value_id = $this->db->getLastId();
					
					if (isset($value['product_fabric_option_value_product'])) {
						foreach ($value['product_fabric_option_value_product'] as $value) {
							$this->db->query("INSERT INTO " . DB_PREFIX . "product_fabric_option_value_product (product_fabric_option_value_product_id, product_fabric_option_value_id, product_id) VALUES(" . (int)$value['product_fabric_option_value_product_id'] . ", " . (int)$product_fabric_option_value_id . ", " . (int)$value['product_id'] . ")");
						}
					}
				}
			}
		}
	}

	public function changeProductFabric($product_copy, $product_id) {
		$this_product = $this->getProductFabricOptionCopy($product_id);

		foreach ($product_copy as $product) {
			$other_product = $this->getOtherProductFabricOptionCopy($product);
			$this->db->query("DELETE t1, t2, t3 FROM " . DB_PREFIX . "product_fabric_option AS t1 NATURAL LEFT JOIN " . DB_PREFIX . "product_fabric_option_value AS t2 LEFT JOIN " . DB_PREFIX . "product_fabric_option_value_product AS t3 ON (t2.product_fabric_option_value_id = t3.product_fabric_option_value_id) WHERE t1.product_id = '" . (int)$product . "'");
			$new_product = array();
			$temp_option = array();
			
			foreach ($other_product as $key => $option) {
				$temp_option[$key] = $option['option_id'];
			}
			
			foreach ($this_product as $fabric_option) {
				$key_option = array_search($fabric_option['option_id'], $temp_option);
				
				if ($key_option !== false) {
					$temp_option_value = array();
					$new_product[$key_option] = $other_product[$key_option];
					$new_product[$key_option]['product_fabric_option_value'] = array();
					
					foreach ($other_product[$key_option]['product_fabric_option_value'] as $key => $option_value) {
						$temp_option_value[$key] = $option_value['option_value_id'];
					}
					
					foreach ($fabric_option['product_fabric_option_value'] as $fabric_option_value) {
						$key_option_value = array_search($fabric_option_value['option_value_id'], $temp_option_value);
						
						if ($key_option_value !== false) {
							$temp_option_value_product = array();
							$new_product[$key_option]['product_fabric_option_value'][$key_option_value] = $other_product[$key_option]['product_fabric_option_value'][$key_option_value];
							$new_product[$key_option]['product_fabric_option_value'][$key_option_value]['product_fabric_option_value_product'] = array();
							
							foreach ($other_product[$key_option]['product_fabric_option_value'][$key_option_value]['product_fabric_option_value_product'] as $key => $fabric_product) {
								$temp_option_value_product[$key] = $fabric_product['product_id'];
							}

							foreach ($fabric_option_value['product_fabric_option_value_product'] as $fabric_product) {
								$key_option_value_product = array_search($fabric_product['product_id'], $temp_option_value_product);
								
								if ($key_option_value_product !== false) {
									$new_product[$key_option]['product_fabric_option_value'][$key_option_value]['product_fabric_option_value_product'][] = $other_product[$key_option]['product_fabric_option_value'][$key_option_value]['product_fabric_option_value_product'][$key_option_value_product];
								} else {
									$new_product[$key_option]['product_fabric_option_value'][$key_option_value]['product_fabric_option_value_product'][] = $fabric_product;
								}
							}
						} else {
							$new_product[$key_option]['product_fabric_option_value'][] = $fabric_option_value;
						}
					}
				} else {
					$new_product[] = $fabric_option;
				}
			}

			$this->insertProductFabric($new_product, $product);
		}
	}

	public function getProductByProductId($products = array()) {
		$symbols = array();
		
		foreach ($products as $product) {
			$symbols[] = '%d';
		}
		
		$sql = "SELECT * FROM " . DB_PREFIX . "product NATURAL JOIN " . DB_PREFIX . "product_description WHERE product_id IN(" . implode(', ', $symbols) . ")";
		$result = $this->db->query(vsprintf($sql, $products));

		return $result->rows;
	}

	public function switch_prod($data) {
		$symbols = array();
		$property_data[] = $data['status'];
		
		foreach ($data['products'] as $product) {
			$symbols[] = '%d';
			$property_data[] = $product;
		}

		$sql = "UPDATE " . DB_PREFIX . "product SET status = '%d' WHERE product_id IN(" . implode(', ', $symbols) . ")";
		$this->db->query(vsprintf($sql, $property_data));
	}

	public function getProductPrice($product_id) {
		$sql = "SELECT * FROM " . DB_PREFIX . "product_price NATURAL JOIN " . DB_PREFIX . "price_prefix WHERE product_id = '" . (int)$product_id . "'";
		$query = $this->db->query(sprintf($sql, $product_id));
		return $query->rows;
	}

	public function productCopyTable($products, $table_numbers, $product_id) {
		$tables = $this->getProductTableCopy($product_id, $table_numbers);

		foreach ($products as $product_id) {
			$this->insertProductTable($tables, $product_id);
		}
	}

	public function insertProductPrice($product_price, $product_id) {
		foreach ($product_price['price_prefix_id'] as $key => $prefix_id) {
			if ($product_price['product_price'][$key] != '' && $prefix_id != 0) {
				$sql = "INSERT INTO " . DB_PREFIX . "product_price SET product_price='" . (float)$product_price['product_price'][$key] . "', product_id = '" . (int)$product_id . "', price_prefix_id= '" . (int)$prefix_id . "'";

				if (isset($product_price['product_price_id'][$key])) {
					$sql .= " , product_price_id = '" . (int)$product_price['product_price_id'][$key] . "' ";
				}

				$this->db->query($sql);
			}
		}
	}

	public function getProductPriceCopy($product_id) {
		$prices = $this->getProductPrice($product_id);
		$result['price_prefix_id'] = array();
		$result['product_price'] = array();

		foreach ($prices as $price) {
			$result['product_price'][] = $price['product_price'];
			$result['price_prefix_id'][] = $price['price_prefix_id'];
		}

		return $result;
	}

	public function getProductMainCategoryId($product_id) {
		$query = $this->db->query("SELECT category_id FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "' AND main_category = '1' LIMIT 1");

		return ($query->num_rows ? (int)$query->row['category_id'] : 0);
	}

	public function productCopyRelated($product_copy, $data) {
		foreach ($product_copy as $product_id) {
			$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$product_id . "'");

			if (isset($data['product_related'])) {
				foreach ($data['product_related'] as $related_id) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "product_related SET product_id='" . (int)$product_id . "', related_id='" . (int)$related_id . "'");
					$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE related_id='" . (int)$product_id . "' AND product_id='" . (int)$related_id . "'");
					$this->db->query("INSERT INTO " . DB_PREFIX . "product_related SET related_id='" . (int)$product_id . "', product_id='" . (int)$related_id . "'");
				}
			}
		}
	}

	public function productCopyCategory($data) {
		foreach ($data['product_copy_category'] as $product_id) {
			$this->db->query('DELETE FROM ' .  DB_PREFIX . 'product_to_category WHERE product_id = "' . (int)$product_id . '" ');
		}

		if (isset($data['product_category'])) {
			foreach ($data['product_copy_category'] as $product_id) {
				foreach ($data['product_category'] as $category_id) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_category SET product_id = '" . (int)$product_id . "', category_id = '" . (int)$category_id . "'");
				}
			}
		}

		if (isset($data['main_category_id']) && $data['main_category_id'] > 0) {
			foreach ($data['product_copy_category'] as $product_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "' AND category_id = '" . (int)$data['main_category_id'] . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_category SET product_id = '" . (int)$product_id . "', category_id = '" . (int)$data['main_category_id'] . "', main_category = 1");
			}
		} elseif (isset($data['product_category'][0])) {
			foreach ($data['product_copy_category'] as $product_id) {
				$this->db->query("UPDATE " . DB_PREFIX . "product_to_category SET main_category = 1 WHERE product_id = '" . (int)$product_id . "' AND category_id = '" . (int)$data['product_category'][0] . "'");
			}
		}
	}

    public function delProductTable($product_id) {
        $this->db->query("DELETE t2, t3 FROM " . DB_PREFIX . "product_table AS t1 NATURAL LEFT JOIN " . DB_PREFIX . "product_table_option AS t2 NATURAL LEFT JOIN " . DB_PREFIX . "product_table_option_value AS t3 WHERE t1.product_id = '" . (int)$product_id. "'");
        $this->db->query("DELETE t1, t2, t3 FROM " . DB_PREFIX . "product_table AS t1 NATURAL LEFT JOIN " . DB_PREFIX . "product_table_option_value_price AS t2 NATURAL LEFT JOIN " . DB_PREFIX . "product_table_option_value_price_special AS t3 WHERE t1.product_id = '" . (int)$product_id . "'");
    }

    public function updateProductPrice($product_id, $main_price) {
        $this->db->query("UPDATE " . DB_PREFIX . "product SET price='" . (float)$main_price . "' WHERE product_id='" . (int)$product_id . "' ");
    }

    public function addProductSeo($product_id, $seo) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'product_id=" . (int)$product_id . "', keyword = '" . $this->db->escape($seo) . "'");
    }

    public function repeatSeo($product_id, $seo) {
        $result = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE query not in ('product_id=" . (int)$product_id . "') AND keyword = '" . $this->db->escape($seo) . "' ");
        return $result->row;
    }

    public function selectProductSeo($product_id) {
        $result = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE query = 'product_id=" . (int)$product_id . "' ");
        return $result->row;
    }

    public function getProdManuf($product_id) {
        $result = $this->db->query("SELECT * FROM " . DB_PREFIX . "product p JOIN manufacturer man ON(p.manufacturer_id = man.manufacturer_id) WHERE p.product_id=" . (int)$product_id . " ");
        return $result->row;
    }

    public function updateProductPrefix($product_id , $price_prefix_id) {
        $this->db->query("UPDATE " . DB_PREFIX . "product SET price_prefix_id ='" . $price_prefix_id . "' WHERE product_id='" . (int)$product_id . "' ");
    }

    public function updateProductAfter($product_id , $price_after_id) {
        $this->db->query("UPDATE " . DB_PREFIX . "product SET price_after_id ='" . $price_after_id . "' WHERE product_id='" . (int)$product_id . "' ");
    }

    public function addProductPrice($product_id, $price_prefix_id, $price) {
        $sql = "INSERT INTO " . DB_PREFIX . "product_price SET product_price='" . (float)$price . "', product_id = '" . (int)$product_id . "', price_prefix_id= '" . (int)$price_prefix_id . "'";
        $this->db->query($sql);
    }

    public function deleteProductPrice($product_id) {
        $this->db->query("DELETE FROM " . DB_PREFIX . "product_price WHERE product_id = '" . (int)$product_id . "'");
    }
}
?>