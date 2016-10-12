<?php

require('MainController.php');

//include_once('../Helpers/PHPMailer_5.2.4/class.phpmailer.php');

class EmployeeController extends MainController{

    
    public function loadMetaValue($meta_key){
        $api = new Employee;

        $info = $api->loadMetaValue($meta_key);
        if(count($info)>0){
            $info = $info['meta_value'];
        }else{
            $info = "";
        }
        return $info;
        
    }
    

    public  function loaduserBySid(){

        

        $api = new Employee;

        $info = $api->loaduserBySid();

        return $info;

        

    }

    public function create_slug($string){

        $slug=preg_replace('/[^A-Za-z0-9-]+/', '-', $string);

        return $slug.time();

    }

  
	
	public function deleteProduct($pro_id){
		 $api = new Employee;
		 $info = $api->deleteProduct($pro_id);
		 return $info;
	}
        public function updateQuantity($pro_id,$quntity){
		 $api = new Employee;
		 $info = $api->updateQuantity($pro_id,$quntity);
		 return $info;
	}
	 public function insertNewEmployee($name,$email,$nic,$birthday,$gender,$salary){
		 $api = new Employee;
		  $info = $api->insertNewEmployee($name,$email,$nic,$birthday,$gender,$salary);

        return $info;
	}
	public function updateEmployee($name,$email,$nic,$birthday,$gender,$salary,$em_id){
		 $api = new Employee;
		  $info = $api->updateEmployee($name,$email,$nic,$birthday,$gender,$salary,$em_id);

        return $info;
	}
	public function loadEmployeeById($id){
		$api = new Employee;
		$info = $api->loadEmployeeById($id);
		return $info;
  
	}
	public function getTotalEmployeeCount(){
		 $api = new Employee;
		 $info = $api->getTotalEmployeeCount();
		  return $info['count'];
	}
	 
	public function loadEmployeePaging($offset,$limit){
		 $api = new Employee;
		 $info = $api->loadEmployeePaging($offset,$limit);

         return $info;
	}
	public function getEmployeeSearch($search){
		 $api = new Employee;
		 $info = $api->getEmployeeSearch($search);
		 return $info;
	}
	
}



