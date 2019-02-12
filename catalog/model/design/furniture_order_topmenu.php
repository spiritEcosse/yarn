<?php
class ModelDesignFurnitureOrderTopmenu extends Model {
    public function getMenu() {
        $this->load->model('catalog/furniture_order_category');
        
        $parent_id = 0;
        
		if (isset($this->request->get['furniture_order_category'])) {
			$parts = explode('_', (string)$this->request->get['furniture_order_category']);
		} else {
			$parts = array();
		}
		
		$top_cats = $this->model_catalog_furniture_order_category->getCategoryDescription($parent_id);
		$category = "<ul class=\"sf-menu\">\n";
        
		foreach ($top_cats as $top_cat)	{
	        $href   = $this->url->link('product/furniture_order_category', 'furniture_order_category=' . $top_cat['furniture_order_category_id']);
	        $class   = in_array($top_cat['furniture_order_category_id'], $parts) ?  " class=\"topactive\"" : "";
	        
	        $category .= "<li>\n<a href=\"" . $href . "\"" . $class . ">" . $top_cat['name'] . "</a>\n";
	        $category .= $this->getCategoryTree($top_cat['furniture_order_category_id']) . "\n</li>\n";
		}
        
		return $category . "\n</ul>\n";
	}
        
    public function getCategoryTree($parent_id) {
		$this->load->model('catalog/product');
                
		$category_data = "";
		$categories = $this->model_catalog_furniture_order_category->getCategoryDescription((int)$parent_id);
                
		foreach ($categories as $category) {
			$name = $category['name'];
                        
			$category_path = $this->model_catalog_furniture_order_category->treeCategory($category['furniture_order_category_id']);
		        $category_path = array_reverse($category_path);
			$category_path = implode('_', $category_path);
                        
			$href = $this->url->link('product/furniture_order_category', 'furniture_order_category=' . $category_path);
			$class = "";
            $parent = $this->getCategoryTree($category['furniture_order_category_id']);

            if ($parent) {
                $class = $class ? " class=\"activeparent\"" : " class=\"parent\"";
			}
                        
			$category_data .= "<li>\n<a href=\"" . $href . "\"" . $class . ">" . $name . "</a>".$parent."\n</li>\n";
		}
                
		return strlen($category_data) ? "<ul>\n" . $category_data . "\n</ul>\n" : "";
	}
}

?>