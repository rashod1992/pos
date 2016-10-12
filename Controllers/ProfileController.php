<?php
require('MainController.php');

//include_once('../Helpers/PHPMailer_5.2.4/class.phpmailer.php');

class CustomerController extends MainController{

    
    public function loadMetaValue($meta_key){
        $api = new Customer;

        $info = $api->loadMetaValue($meta_key);
        if(count($info)>0){
            $info = $info['meta_value'];
        }else{
            $info = "";
        }
        return $info;
        
    }
    

    public  function loaduserBySid(){

        

        $api = new Customer;

        $info = $api->loaduserBySid();

        return $info;

        

    }

    public function create_slug($string){

        $slug=preg_replace('/[^A-Za-z0-9-]+/', '-', $string);

        return $slug.time();

    }
	 public function insertNewCustomer($cx_name,$cx_email,$cx_address,$cx_tp){
		 $api = new Customer;
		  $info = $api->insertNewCustomer($cx_name,$cx_email,$cx_address,$cx_tp);

        return $info;
	}
	 public function updateCustomer($cx_name,$cx_email,$cx_address,$cx_tp,$cx_id){
		 $api = new Customer;
		  $info = $api->updateCustomer($cx_name,$cx_email,$cx_address,$cx_tp,$cx_id);

        return $info;
	}
	public function loadCustomerById($id){
		$api = new Customer;
		$info = $api->loadCustomerById($id);
		return $info;
  
	}
	public function getCustomerSearch($search){
		 $api =new Customer;
		 $info = $api->getCustomerSearch($search);
		 return $info;
	}
	public function getTotalCustomerCount(){
		  $api = new Customer;
		  $info = $api->getTotalCustomerCount();
		  return $info['count'];
	}
	public function loadCustomersPaging($offset,$limit){
		 $api =new Customer;
		 $info = $api->loadCustomersPaging($offset,$limit);

         return $info;
	}
	public function deleteCustomer($pro_id){
		 $api =new Customer;
		 $info = $api->deleteCustomer($pro_id);
		 return $info;
	}

}



