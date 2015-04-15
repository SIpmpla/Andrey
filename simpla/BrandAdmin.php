<?php

require_once('api/Simpla.php');


############################################
# Class Category - Edit the good gategory
############################################
class BrandAdmin extends Simpla
{
  private $allowed_image_extentions = array('png', 'gif', 'jpg', 'jpeg', 'ico');

  function fetch()
  {
	  	$brand = new stdClass;
        if($this->request->method('post')) {
            /*change_price_group*/
            $brand_id = $this->request->post('id', 'integer');
            $value = $this->request->post('change_price');
            print_r($value);
            $type = $this->request->post('change_type');
            if (!empty($value) && !empty($brand_id)) {
                $variants = array();
                $q = $this->db->placehold('select id from __products p where brand_id=?', $brand_id);
                $this->db->query($q);
                $p_ids = $this->db->results('id');
                if (empty($p_ids)) {
                    $this->design->assign('message_price_error', 'empty_products');
                } elseif ($type == 'percentage') {
                    if ($value <= -100) {
                        $this->design->assign('message_price_error', '100_percent');
                    } else {
                        $coef = (float)$value/100+1;
                        $this->db->query("UPDATE __variants SET price=price*?, compare_price=compare_price*? where product_id in(?@)", $coef, $coef, $p_ids);
                        $this->design->assign('message_price_success', 'updated');
                    }
                } else {
                    $value = (float)$value;
                    $this->db->query("UPDATE __variants SET price=price+? where product_id in(?@)", $value, $p_ids);
                    $this->db->query("UPDATE __variants SET compare_price=compare_price+? where product_id in(?@) and compare_price>0", $value, $p_ids);
                    $this->design->assign('message_price_success', 'updated');
                }
            }
            /*/change_price_group*/
			$brand->id = $this->request->post('id', 'integer');
			$brand->name = $this->request->post('name');
			$brand->description = $this->request->post('description');

			$brand->url = $this->request->post('url', 'string');
			$brand->meta_title = $this->request->post('meta_title');
			$brand->meta_keywords = $this->request->post('meta_keywords');
			$brand->meta_description = $this->request->post('meta_description');
			
			// Не допустить одинаковые URL разделов.
			if(($c = $this->brands->get_brand($brand->url)) && $c->id!=$brand->id)
			{			
				$this->design->assign('message_error', 'url_exists');
			}
			else
			{
				if(empty($brand->id))
				{
	  				$brand->id = $this->brands->add_brand($brand);
					$this->design->assign('message_success', 'added');
	  			}
  	    		else
  	    		{
  	    			$this->brands->update_brand($brand->id, $brand);
					$this->design->assign('message_success', 'updated');
  	    		}	
  	    		// Удаление изображения
  	    		if($this->request->post('delete_image'))
  	    		{
  	    			$this->brands->delete_image($brand->id);
  	    		}
  	    		// Загрузка изображения
  	    		$image = $this->request->files('image');
  	    		if(!empty($image['name']) && in_array(strtolower(pathinfo($image['name'], PATHINFO_EXTENSION)), $this->allowed_image_extentions))
  	    		{
  	    			$this->brands->delete_image($brand->id);   	    			
  	    			move_uploaded_file($image['tmp_name'], $this->root_dir.$this->config->brands_images_dir.$image['name']);
  	    			$this->brands->update_brand($brand->id, array('image'=>$image['name']));
  	    		}
	  			$brand = $this->brands->get_brand($brand->id);
			}
		}
		else
		{
			$brand->id = $this->request->get('id', 'integer');
			$brand = $this->brands->get_brand($brand->id);
		}
		
 		$this->design->assign('brand', $brand);
		return  $this->design->fetch('brand.tpl');
	}
}