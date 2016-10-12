<?php

require('MainController.php');

//include_once('../Helpers/PHPMailer_5.2.4/class.phpmailer.php');

class InventoryController extends MainController{

    
    public function loadMetaValue($meta_key){
        $api = new Inventory;

        $info = $api->loadMetaValue($meta_key);
        if(count($info)>0){
            $info = $info['meta_value'];
        }else{
            $info = "";
        }
        return $info;
        
    }
    

    public  function loaduserBySid(){

        

        $api = new Inventory;

        $info = $api->loaduserBySid();

        return $info;

        

    }

    public function create_slug($string){

        $slug=preg_replace('/[^A-Za-z0-9-]+/', '-', $string);

        return $slug.time();

    }

    public function insertNewProduct($pro_name,$pro_price){
		 $api = new Inventory;
		  $info = $api->insertNewProduct($pro_name,$pro_price);

        return $info;
	}

	public function loadProductById($id){
		$api = new Inventory;
		$info = $api->loadProductById($id);
		return $info;
  
	}
	
    public function updateProduct($pro_name,$pro_price,$pro_id){
		 $api = new Inventory;
		  $info = $api->updateProduct($pro_name,$pro_price,$pro_id);

        return $info;
	}
	public function getTotalProductsCount(){
		 $api = new Inventory;
		 $info = $api->getTotalProductsCount();
		  return $info['count'];
	}
	
	public function loadProductsPaging($offset,$limit){
		 $api = new Inventory;
		 $info = $api->loadProductsPaging($offset,$limit);

         return $info;
	}
	public function getProductSearch($search){
		 $api = new Inventory;
		 $info = $api->getProductSearch($search);
		 return $info;
	}
	public function deleteProduct($pro_id){
		 $api = new Inventory;
		 $info = $api->deleteProduct($pro_id);
		 return $info;
	}
        public function updateQuantity($pro_id,$quntity){
		 $api = new Inventory;
		 $info = $api->updateQuantity($pro_id,$quntity);
		 return $info;
	}
}



