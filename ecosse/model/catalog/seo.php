<?php
class ModelCatalogSeo extends Model {
    public function getKeyword($query) {
        $query = $this->db->query("SELECT * from " . DB_PREFIX . "url_alias WHERE query = '" . $query . "' ");

        if ($query->row) {
            return $query->row['keyword'];
        }

        return '';
    }

    public function editSeo($data) {
        $this->db->query("DELETE from " . DB_PREFIX . "url_alias WHERE query in('product/catalog', 'product/special', 'product/discount', 'information/contact', 'product/list', 'information/sitemap', 'checkout/cart', 'account/login', 'account/register', 'account/wishlist', 'product/compare', 'product/sale', 'information/list_category_article') ");

        $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'product/catalog', keyword = '" . $this->db->escape($data['catalog']) . "'");
        $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'product/special', keyword = '" . $this->db->escape($data['special']) . "'");
        $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'product/discount', keyword = '" . $this->db->escape($data['discount']) . "'");
        $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'information/contact', keyword = '" . $this->db->escape($data['contacts']) . "'");
        $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'product/list', keyword = '" . $this->db->escape($data['catalog_video']) . "'");
        $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'information/sitemap', keyword = '" . $this->db->escape($data['information_sitemap']) . "'");
        $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'checkout/cart', keyword = '" . $this->db->escape($data['checkout_cart']) . "'");
        $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'account/login', keyword = '" . $this->db->escape($data['account_login']) . "'");
        $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'account/register', keyword = '" . $this->db->escape($data['account_register']) . "'");
        $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'account/wishlist', keyword = '" . $this->db->escape($data['account_wishlist']) . "'");
        $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'product/compare', keyword = '" . $this->db->escape($data['product_compare']) . "'");
        $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'product/sale', keyword = '" . $this->db->escape($data['product_sale']) . "'");
        $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'information/list_category_article', keyword = '" . $this->db->escape($data['list_category_article']) . "'");
    }
}
?>
