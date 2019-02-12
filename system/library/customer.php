<?php
class Customer {
	private $customer_id;
	private $firstname;
	private $lastname;
	private $email;
	private $telephone;
	private $fax;
	private $newsletter;
	private $customer_group_id;
    private $address_id;
    private $date_birthday;
    private $gift;
    private $date_get_gift;
    private $date_add_cart;

  	public function __construct($registry) {
		$this->config = $registry->get('config');
		$this->db = $registry->get('db');
		$this->request = $registry->get('request');
		$this->session = $registry->get('session');
				
		if (isset($this->session->data['customer_id'])) { 
			$customer_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int)$this->session->data['customer_id'] . "' AND status = '1'");
			
			if ($customer_query->num_rows) {
				$this->customer_id = $customer_query->row['customer_id'];
				$this->firstname = $customer_query->row['firstname'];
				$this->lastname = $customer_query->row['lastname'];
				$this->email = $customer_query->row['email'];
				$this->telephone = $customer_query->row['telephone'];
				$this->fax = $customer_query->row['fax'];
				$this->newsletter = $customer_query->row['newsletter'];
				$this->customer_group_id = $customer_query->row['customer_group_id'];
                $this->address_id = $customer_query->row['address_id'];
                $this->date_birthday = $customer_query->row['date_birthday'];
                $this->gift = $customer_query->row['gift'];
                $this->date_get_gift = $customer_query->row['date_get_gift'];
                $this->date_add_cart = $customer_query->row['date_add_cart'];

      			$this->db->query("UPDATE " . DB_PREFIX . "customer SET cart = '" . $this->db->escape(isset($this->session->data['cart']) ? serialize($this->session->data['cart']) : '') . "', wishlist = '" . $this->db->escape(isset($this->session->data['wishlist']) ? serialize($this->session->data['wishlist']) : '') . "', ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "' WHERE customer_id = '" . (int)$this->customer_id . "'");
			
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer_ip WHERE customer_id = '" . (int)$this->session->data['customer_id'] . "' AND ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "'");
				
				if (!$query->num_rows) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "customer_ip SET customer_id = '" . (int)$this->session->data['customer_id'] . "', ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "', date_added = NOW()");
				}
			} else {
				$this->logout();
			}
  		}
	}

  	public function login($email, $password, $override = false) {
		if ($override) {
			$customer_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer where LOWER(email) = '" . $this->db->escape(strtolower($email)) . "' AND status = '1'");
		} else {
			$customer_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE LOWER(email) = '" . $this->db->escape(strtolower($email)) . "' AND password = '" . $this->db->escape(md5($password)) . "' AND status = '1' AND approved = '1'");
		}
		
		if ($customer_query->num_rows) {
			$this->session->data['customer_id'] = $customer_query->row['customer_id'];	
		    
			if ($customer_query->row['cart'] && is_string($customer_query->row['cart'])) {
				$cart = unserialize($customer_query->row['cart']);
				
				foreach ($cart as $key => $value) {
					if (!array_key_exists($key, $this->session->data['cart'])) {
						$this->session->data['cart'][$key] = $value;
					} else {
						$this->session->data['cart'][$key] += $value;
					}
				}			
			}

			if ($customer_query->row['wishlist'] && is_string($customer_query->row['wishlist'])) {
				if (!isset($this->session->data['wishlist'])) {
					$this->session->data['wishlist'] = array();
				}
								
				$wishlist = unserialize($customer_query->row['wishlist']);
			
				foreach ($wishlist as $product_id) {
					if (!in_array($product_id, $this->session->data['wishlist'])) {
						$this->session->data['wishlist'][] = $product_id;
					}
				}			
			}

			$this->customer_id = $customer_query->row['customer_id'];
			$this->firstname = $customer_query->row['firstname'];
			$this->lastname = $customer_query->row['lastname'];
			$this->email = $customer_query->row['email'];
			$this->telephone = $customer_query->row['telephone'];
			$this->fax = $customer_query->row['fax'];
			$this->newsletter = $customer_query->row['newsletter'];
			$this->customer_group_id = $customer_query->row['customer_group_id'];
			$this->address_id = $customer_query->row['address_id'];
            $this->gift = $customer_query->row['gift'];

            $this->db->query("UPDATE " . DB_PREFIX . "customer SET ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "' WHERE customer_id = '" . (int)$this->customer_id . "'");
			
	  		return true;
    	} else {
      		return false;
    	}
  	}

	public function logout() {
		$this->db->query("UPDATE " . DB_PREFIX . "customer SET cart = '" . $this->db->escape(isset($this->session->data['cart']) ? serialize($this->session->data['cart']) : '') . "', wishlist = '" . $this->db->escape(isset($this->session->data['wishlist']) ? serialize($this->session->data['wishlist']) : '') . "' WHERE customer_id = '" . (int)$this->customer_id . "'");
		
		unset($this->session->data['customer_id']);

		$this->customer_id = '';
		$this->firstname = '';
		$this->lastname = '';
		$this->email = '';
		$this->telephone = '';
		$this->fax = '';
		$this->newsletter = '';
		$this->customer_group_id = '';
		$this->address_id = '';
  	}
  
  	public function isLogged() {
    	return $this->customer_id;
  	}

  	public function getId() {
    	return $this->customer_id;
  	}

    public function setGift($gift) {
        $sql = "UPDATE " . DB_PREFIX . "customer SET gift = '%s' WHERE customer_id = '%d' ";
        $this->db->query(sprintf($sql, $gift, $this->customer_id));
        $this->gift = $gift;
    }

    public function getDateCartAdd() {
        return $this->date_add_cart;
    }

    public function setDateCartAdd($date_add_cart) {
        $sql = "UPDATE " . DB_PREFIX . "customer SET date_add_cart = '%s' WHERE customer_id = '%d' ";
        $this->db->query(sprintf($sql, $date_add_cart, $this->customer_id));
        $this->date_add_cart = $date_add_cart;
    }

    public function getGift() {
        return $this->gift;
    }

    public function setDateGetGift($date_get_gift) {
        $sql = "UPDATE " . DB_PREFIX . "customer SET date_get_gift = '%s' WHERE customer_id = '%d' ";
        $this->db->query(sprintf($sql, $date_get_gift, $this->customer_id));
        $this->date_get_gift = $date_get_gift;
    }

    public function getDateGetGift() {
        return $this->date_get_gift;
    }

  	public function getFirstName() {
		return $this->firstname;
  	}
  
  	public function getLastName() {
		return $this->lastname;
  	}
  
  	public function getEmail() {
		return $this->email;
  	}
  
  	public function getTelephone() {
		return $this->telephone;
  	}
  
  	public function getFax() {
		return $this->fax;
  	}
	
  	public function getNewsletter() {
		return $this->newsletter;	
  	}

  	public function getCustomerGroupId() {
		return $this->customer_group_id;	
  	}
	
  	public function getAddressId() {
		return $this->address_id;	
  	}

    public function getDateBirthday() {
        return $this->date_birthday;
    }

  	public function getBalance() {
		$query = $this->db->query("SELECT SUM(amount) AS total FROM " . DB_PREFIX . "customer_transaction WHERE customer_id = '" . (int)$this->customer_id . "'");
	
		return $query->row['total'];
  	}	
		
  	public function getRewardPoints() {
		$query = $this->db->query("SELECT SUM(points) AS total FROM " . DB_PREFIX . "customer_reward WHERE customer_id = '" . (int)$this->customer_id . "'");
	
		return $query->row['total'];
  	}

    public function getDiscountByDateBirthday() {
        return $this->getDate($this->isLogged(), $this->getDateBirthday(), $this->gift, $this->date_get_gift);
    }

    public function getDate($logged, $date_birthday, $gift, $date_get_gift) {
        if ($this->config->get('discount_birthday_enable') && $logged && $date_birthday != '0000-00-00' && count($this->config->get('discount_birthday_days_products')) > 0 && $this->config->get('birthday_description') && $gift == '') {
            list($year, $month, $day) = explode('-', $date_birthday);
            $this_year_birthday = date("Y") . '-' . $month . '-' . $day;
            $this_year_birthday = new DateTime($this_year_birthday);

            $date_birthday_start = new DateTime($this_year_birthday->format('Y-m-d'));
            $date_birthday_start->sub(new DateInterval('P' . $this->config->get('discount_birthday_days')  . 'D'));
            $date_birthday_end = new DateTime($this_year_birthday->format('Y-m-d'));
            $date_birthday_end->add(new DateInterval('P' . $this->config->get('discount_birthday_days')  . 'D'));

            $date_get_gift = new DateTime($date_get_gift);

            if ($date_get_gift > $date_birthday_start && $date_birthday_end > $date_get_gift) {
                return null;
            }

            $today = new DateTime(date("Y-m-d"));
            $interval = $this_year_birthday->diff($today);
            $days = $interval->format('%R%a');

            if (abs($days) <= $this->config->get('discount_birthday_days')) {
                if ($days > 0) {
                    $add_days = $this->config->get('discount_birthday_days') - abs($days);
                    $date_end = $today->add(new DateInterval('P' . $add_days . 'D'));
                } else {
                    $add_days = $this->config->get('discount_birthday_days') + abs($days);
                    $date_end = $today->add(new DateInterval('P' . $add_days  . 'D'));
                }

                return $date_end->format('Y-m-d');
            }
        }
    }

    public function validDateCartAdd($date_add_cart) {
        if ($date_add_cart != '0000-00-00 00:00:00') {
            $date_add_cart = new DateTime($date_add_cart);
            $today = new DateTime(date("Y-m-d H:i:s"));
            $diff = $today->diff($date_add_cart);
            $hours = $diff->h;
            $hours = $hours + ($diff->days*24);

            $config_hour = 10;

            if ((int)$this->config->get('hour_interval') > 0) {
                $config_hour = $this->config->get('hour_interval');
            }

            return $hours >= $config_hour;
        }

        return false;
    }
}
?>