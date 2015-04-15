<?php

require_once('api/Simpla.php');


############################################
# Class Category - Edit the good gategory
############################################
class CategoryAdmin extends Simpla
{
  private	$allowed_image_extentions = array('png', 'gif', 'jpg', 'jpeg', 'ico');
  
  function fetch()
  {
		$category = new stdClass;
		if($this->request->method('post'))
		{
			$category->id = $this->request->post('id', 'integer');
			$category->parent_id = $this->request->post('parent_id', 'integer');
			$category->name = $this->request->post('name');
			$category->visible = $this->request->post('visible', 'boolean');

			$category->url = $this->request->post('url', 'string');
			$category->meta_title = $this->request->post('meta_title');
			$category->meta_keywords = $this->request->post('meta_keywords');
			$category->meta_description = $this->request->post('meta_description');
            $category->increase_price = $this->request->post('increase_price');
			$category->description = $this->request->post('description');

            //Изменение цены товаров в категории
            $category_id = $this->request->post('id', 'integer');
            $product_category = $this->categories->get_category(intval($category_id));
            $increase_price = $this->request->post('increase_price');
            $type = $this->request->post('method_increase_price');
            if (!empty($increase_price) && !empty($product_category)) {
                $variants = array();
                $query = $this->db->placehold('select id from __products p INNER JOIN __products_categories pc ON pc.product_id = p.id AND pc.category_id in(?@)', $product_category->children);
                $this->db->query($query);
                $p_ids = $this->db->results('id');
                if (empty($p_ids)) {
                    $this->design->assign('message_price_error', 'empty_products');
                } elseif ($type == 'percentage') {
                    if ($increase_price == -100) {
                        $this->design->assign('message_price_error', '100_percent');
                    } else {
                        $coef = (float)$increase_price/100+1;
                        $this->db->query("UPDATE __variants SET price=price*?, compare_price=compare_price*? where product_id in(?@)", $coef, $coef, $p_ids);
                        $this->design->assign('message_price_success', 'updated');
                    }
                } else {
                    $increase_price = (float)$increase_price;
                    $this->db->query("UPDATE __variants SET price=price+? where product_id in(?@)", $increase_price, $p_ids);
                    $this->db->query("UPDATE __variants SET compare_price=compare_price+? where product_id in(?@) and compare_price>0", $increase_price, $p_ids);
                    $this->design->assign('message_price_success', 'updated');
                }
            }







                // Не допустить одинаковые URL разделов.
			if(($c = $this->categories->get_category($category->url)) && $c->id!=$category->id)
			{			
				$this->design->assign('message_error', 'url_exists');
			}
			else
			{
				if(empty($category->id))
				{
	  				$category->id = $this->categories->add_category($category);
					$this->design->assign('message_success', 'added');
	  			}
  	    		else
  	    		{
  	    			$this->categories->update_category($category->id, $category);
					$this->design->assign('message_success', 'updated');
  	    		}
  	    		// Удаление изображения
  	    		if($this->request->post('delete_image'))
  	    		{
  	    			$this->categories->delete_image($category->id);
  	    		}
  	    		// Загрузка изображения
  	    		$image = $this->request->files('image');
  	    		if(!empty($image['name']) && in_array(strtolower(pathinfo($image['name'], PATHINFO_EXTENSION)), $this->allowed_image_extentions))
  	    		{
  	    			$this->categories->delete_image($category->id);
  	    			move_uploaded_file($image['tmp_name'], $this->root_dir.$this->config->categories_images_dir.$image['name']);
  	    			$this->categories->update_category($category->id, array('image'=>$image['name']));
  	    		}
  	    		$category = $this->categories->get_category(intval($category->id));
			}
		}
		else
		{
			$category->id = $this->request->get('id', 'integer');
			$category = $this->categories->get_category($category->id);
		}
		

		$categories = $this->categories->get_categories_tree();

		$this->design->assign('category', $category);
		$this->design->assign('categories', $categories);
		return  $this->design->fetch('category.tpl');
	}
}