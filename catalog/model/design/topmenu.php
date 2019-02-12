<?php
class ModelDesignTopmenu extends Model {
	public function getMenu() {
		$cache_key = 'get.menu.top';
		$category = $this->cache->get($cache_key);
		$this->load->model('tool/image');

		if ($category === false) {
			$this->load->model('catalog/category');
			$category = array();
	        $parent_id = 0;

			$top_cats = $this->model_catalog_category->getCategories($parent_id);

			foreach ($top_cats as $top_cat)	{
				$category[] = array(
					'name'     		=> $top_cat['name'],
					'color_text'	=> $top_cat['color_text'],
					'drop_down'		=> $top_cat['drop_down'],
					'category_id'	=> $top_cat['category_id'],
					'image'    		=> $top_cat['image'],
					'description'   => html_entity_decode($top_cat['description'], ENT_QUOTES, 'UTF-8'),
					'children' 		=> $this->getCategoryTree($top_cat['category_id']),
					'column'   		=> $top_cat['column'] ? $top_cat['column'] : 1,
					'href'     		=> $this->url->link('product/category', 'path=' . $top_cat['category_id'])
				);
			}
			
			$this->cache->set($cache_key, $category);
		}

		return $category;
	}

	public function getCategoryTree($parent_id) {
		$cache_key = 'get.cat.tree.' . $parent_id;
		$category_data = $this->cache->get($cache_key);
		
		if ($category_data === false) {
			$this->load->model('catalog/product');

			$category_data = array();
			$categories = $this->model_catalog_category->getCategories((int)$parent_id);
			
			foreach ($categories as $category) {
				$parent_id = $category['category_id'];
				$category_path = $this->model_catalog_category->treeCategory($parent_id);
				$category_path = implode('_', array_reverse($category_path));

				$category_data[] = array(
					'href' 			=> $this->url->link('product/category', 'path=' . $category_path),
					'name' 			=> $category['name'],
					'category_id' 	=> $category['category_id'],
					'image'    		=> $this->model_tool_image->resize($category['image'], $this->config->get('config_image_category_menu_width'), $this->config->get('config_image_category_menu_height')),
					'children' 		=> $this->getCategoryTree($parent_id)
				);
			}
			
			$this->cache->set($cache_key, $category_data);
		}
		
		return $category_data;
	}

    public function getMenuCatVideo() {
        $cache_key = 'get.cat.video.menu.top';
        $category = $this->cache->get($cache_key);

        if ($category === false) {
            $this->load->model('catalog/category_video');
            $category = array();
            $parent_id = 0;

            $top_cats = $this->model_catalog_category_video->getCategories($parent_id);

            foreach ($top_cats as $top_cat)	{
                $category[] = array(
                    'name'     		=> $top_cat['name'],
                    'category_video_id'	=> $top_cat['category_video_id'],
                    'children' 		=> $this->getCategoryVideoTree($top_cat['category_video_id']),
                    'href'     		=> $this->url->link('product/catvideo', 'road=' . $top_cat['category_video_id'])
                );
            }

            $this->cache->set($cache_key, $category);
        }

        return $category;
    }

	public function getCategoryVideoTree($parent_id) {
		$cache_key = 'get.cat.video.tree.' . $parent_id;
		$category_data = $this->cache->get($cache_key);

		if ($category_data === false) {
			$category_data = array();
			$categories = $this->model_catalog_category_video->getCategories((int)$parent_id);

			foreach ($categories as $category) {
				$parent_id = $category['category_video_id'];
				$category_path = $this->model_catalog_category_video->treeCategory($parent_id);
				$category_path = implode('_', array_reverse($category_path));

				$category_data[] = array(
					'href' 			=> $this->url->link('product/catvideo', 'road=' . $category_path),
					'name' 			=> $category['name'],
					'category_video_id' 	=> $category['category_video_id'],
					'children' 		=> $this->getCategoryVideoTree($parent_id)
				);
			}

			$this->cache->set($cache_key, $category_data);
		}

		return $category_data;
	}

	public function getMenuCategoryArticle() {
		$cache_key = 'get.category.article';
		$category = $this->cache->get($cache_key);

		if ($category === false) {
			$this->load->model('catalog/category_article');
			$category = array();
			$parent_id = 0;

			$top_cats = $this->model_catalog_category_article->getCategories($parent_id);

			foreach ($top_cats as $top_cat)	{
				$category[] = array(
					'name'     		=> $top_cat['name'],
					'category_article_id'	=> $top_cat['category_article_id'],
					'children' 		=> $this->getCategoryArticleTree($top_cat['category_article_id']),
					'href'     		=> $this->url->link('information/category_article', 'category_article_id=' . $top_cat['category_article_id'])
				);
			}

			$this->cache->set($cache_key, $category);
		}

		return $category;
	}

	public function getCategoryArticleTree($parent_id) {
		$cache_key = 'get.category.article.tree.' . $parent_id;
		$category_data = $this->cache->get($cache_key);

		if ($category_data === false) {
			$category_data = array();
			$categories = $this->model_catalog_category_article->getCategories((int)$parent_id);

			foreach ($categories as $category) {
				$parent_id = $category['category_article_id'];
				$category_path = $this->model_catalog_category_article->treeCategory($parent_id);
				$category_path = implode('_', array_reverse($category_path));

				$category_data[] = array(
					'href' 			=> $this->url->link('information/category_article', 'category_article_id=' . $category_path),
					'name' 			=> $category['name'],
					'category_article_id' 	=> $category['category_article_id'],
					'children' 		=> $this->getCategoryArticleTree($parent_id)
				);
			}

			$this->cache->set($cache_key, $category_data);
		}

		return $category_data;
	}
}

?>