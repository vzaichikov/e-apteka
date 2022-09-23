<?php
class ModelCatalogViewed extends Model {

	public function getTotalViewed(){
		if(!empty($_COOKIE['viewed_products']))
		{			
			return count(explode(',', $_COOKIE['viewed_products']));					
			
		} else return 0;
	}
	
	public function addToViewed($product_id){
		
	
		$expire = time()+60*60*24*30;
		
		if(!empty($_COOKIE['viewed_products']))
		{
			$viewed_products = explode(',', $_COOKIE['viewed_products']);
							
			if (count($viewed_products) > 8){
				unset($_COOKIE['viewed_products']);
				setcookie('viewed_products', '', time()-3600,'/');
				setcookie("viewed_products", '', $expire, "/");
			}
			
			if(($exists = array_search($product_id, $viewed_products)) !== false){			
				unset($viewed_products[$exists]);
			}
			
			array_unshift($viewed_products, $product_id);
			if (count($viewed_products) >= 7){
					array_pop($viewed_products);
			}		
			
			$cookie_val = implode(',', $viewed_products);
			setcookie("viewed_products", $cookie_val, $expire, "/");			
		} else {
			setcookie("viewed_products", $product_id, $expire, "/");				
		}
		
	}
	
	public function getListViewed($limit = 24){
		if(!empty($_COOKIE['viewed_products']))
		{			
			$a =  explode(',', $_COOKIE['viewed_products']);	
			return	array_slice($a, 0, $limit);			
			
		} else return false; 
	}
}