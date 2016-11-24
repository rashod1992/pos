<?php

require('MainController.php');

//include_once('../Helpers/PHPMailer_5.2.4/class.phpmailer.php');

class SalesController extends MainController{

    
    public function loadMetaValue($meta_key){
        $api = new Sales;

        $info = $api->loadMetaValue($meta_key);
        if(count($info)>0){
            $info = $info['meta_value'];
        }else{
            $info = "";
        }
        return $info;
        
    }
    

    public  function loaduserBySid(){

        

        $api = new Sales;

        $info = $api->loaduserBySid();

        return $info;

        

    }

    public function create_slug($string){

        $slug=preg_replace('/[^A-Za-z0-9-]+/', '-', $string);

        return $slug.time();

    }
	public function loadAllCustomers(){
		$api = new Sales;
		$info = $api->loadAllCustomers();

        return $info;
	}
	public function loadCustomerById($cx_id){
		$api = new Sales;
		$info = $api->loadCustomerById($cx_id);

        return $info;
	}
	public function insertNewSale($cx_id,$cx_name,$cx_address,$cx_telephone,$tax){
		$api = new Sales;
		$info = $api->insertNewSale($cx_id,$cx_name,$cx_address,$cx_telephone,$tax);

        return $info;
	}
	  public function insertNewCustomer($cx_name,$cx_email,$cx_address,$cx_tp){
		 $api = new Sales;
		  $info = $api->insertNewCustomer($cx_name,$cx_email,$cx_address,$cx_tp);

        return $info;
	}
	public function loadOrderById($id){
		$api = new Sales;
		$info = $api->loadOrderById($id);

        return $info;
	}
	public function loadAllProducts(){
		$api = new Sales;
		$info = $api->loadAllProducts();

        return $info;
	}
	public function loadProductById($id){
		$api = new Sales;
		$info = $api->loadProductById($id);

        return $info;
	}
	public function addOrderProducts($pr_id,$order_id,$amount,$quantity){
		$api = new Sales;
		$info = $api->addOrderProducts($pr_id,$order_id,$amount,$quantity);

        return $info;
	}
	public function updateCartValue($value,$cart_id){
		$api = new Sales;
		$info = $api-> updateCartValue($value,$cart_id);

        return $info;
	}
	public function loadOrderProducts($order_id){
		$api = new Sales;
		$info = $api->loadOrderProducts($order_id);

        return $info;
	}
	public function loadOrderProductById($id){
		$api = new Sales;
		$info = $api->loadOrderProductById($id);

        return $info;
	}
	public function removeProductFromOrder($id){
		$api = new Sales;
		$info = $api->removeProductFromOrder($id);

        return $info;
	}
	public function updateOrderQunatity($product_id,$value){
		$api = new Sales;
		$info = $api->updateOrderQunatity($product_id,$value);

        return $info;
	}
	public function updateOrderStatus($id,$tax,$total){
		$api = new Sales;
		$info = $api->updateOrderStatus($id,$tax,$total);

        return $info;
	}
        public function getSalesSearch($search){
		 $api =new Sales;
		 $info = $api->getSalesSearch($search);
		 return $info;
	}
        public function getTotalSalesCount(){
		  $api =new Sales;
		  $info = $api->getTotalSalesCount();
		  return $info['count'];
	}
        public function loadSalesPaging($offset,$limit){
		 $api =new Sales;
		 $info = $api->loadSalesPaging($offset,$limit);

                return $info;
	}
        public function add_discount($discount,$total,$order){
                 $api = new Sales;
		 $info = $api->add_discount($discount,$total,$order);

                return $info;
        }
        public function load_Custom_fields(){
                 $api = new Sales;
		 $info = $api->load_Custom_fields();

                return $info;
        }
        public function get_custom_value($order_id,$custom_id){
                 $api = new Sales;
		 $info = $api->get_custom_value($order_id,$custom_id);

                return $info;
        }
        public function update_custom_value($value,$value_id){
                 $api = new Sales;
		 $info = $api->update_custom_value($value,$value_id);

                return $info;
        }
        public function loadSingleCustomField($custom_id){
                $api = new Sales;
		 $info = $api->loadSingleCustomField($custom_id);

                return $info;
        }
        public function InsertCustomValue($value,$custom_id,$order_id){
                 $api = new Sales;
		 $info = $api->InsertCustomValue($value,$custom_id,$order_id);

                return $info;
        }
        public function addOtherProduct($product_name,$unitprice){
                 $api = new Sales;
		 		$info = $api->addOtherProduct($product_name,$unitprice);
                return $info;
        }
}



