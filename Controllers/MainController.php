<?PHP
require("db.php");
abstract class MainController{
	
		public function connectdb(){
			$db = new Db();
			$this->connection = $db->connectDb(array( "DB_USERNAME"=>DB_USERNAME, "DB_PASSWORD"=>DB_PASSWORD, "DB_NAME"=>DB_NAME, "DB_HOST"=>DB_HOST )); 
        
       		return $this->connection;
		}
		
		public function connectmysqli(){
			$this->connection2 = new mysqli(DB_HOST,DB_USERNAME, DB_PASSWORD, DB_NAME);
			return $this->connection;
		}
		
		public function isValidEmail($email)
	{
		$isValid = true;
		$atIndex = strrpos($email, "@");
		$tld = strchr($email,'.');
		
		if (is_bool($atIndex) && !$atIndex){
			$isValid = false;
		}
		else{
			$domain = substr($email, $atIndex+1);
			$local = substr($email, 0, $atIndex);
			$localLen = strlen($local);
			$domainLen = strlen($domain);
		  if ($localLen < 1 || $localLen > 64){
			 // local part length exceeded
			 $isValid = false;
		  }
		  else if ($domainLen < 1 || $domainLen > 255){
			 // domain part length exceeded
			 $isValid = false;
		  }
		  else if ($local[0] == '.' || $local[$localLen-1] == '.'){
			 // local part starts or ends with '.'
			 $isValid = false;
		  }
		  else if (preg_match('/\\.\\./', $local)){
			 // local part has two consecutive dots
			 $isValid = false;
		  }
		  else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain)){
			 // character not valid in domain part
			 $isValid = false;
		  }
		  else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain)){
			 // character not valid in domain part
			 $isValid = false;
		  }		  
		  else if (preg_match('/\\.\\./', $domain)){
			 // domain part has two consecutive dots
			 $isValid = false;
			 
		  }
		  else if(!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/',
					str_replace("\\\\","",$local))){
			 // character not valid in local part unless 
			 // local part is quoted
			 if (!preg_match('/^"(\\\\"|[^"])+"$/',
				 str_replace("\\\\","",$local))){
				$isValid = false;
			 }
		  }
	   }
	   return $isValid;
	}
		public function validateData($value_id,$type,$req=0,&$values,&$errors){
			
			if($type=="TEXT"){
				if(isset($_POST[$value_id]) && strlen($_POST[$value_id])>0){
					
						$values[$value_id]['value'] = $_POST[$value_id];
						return $values;
					
				}else{
					if($req==1){
						$errors[$value_id]['value'] = 'NOT SET';
						return $errors;
					}else{
						$values[$value_id]['value'] = "";
						return $values;
					}

				}
			}elseif($type=="EMAIL"){
				if(isset($_POST[$value_id]) && strlen($_POST[$value_id])>0){
					
					if($this->isValidEmail($_POST[$value_id])){
						$values[$value_id]['value'] = $_POST[$value_id];
						return $values;
					}else{
						$errors[$value_id]['value'] = 'INVALID EMAIL';
						return $errors;
					}
					
				}else{
					if($req==1){
						$errors[$value_id]['value'] = 'NOT SET';
						return $errors;
						
					}else{
						$values[$value_id]['value'] = "";
						return $values;
					}

				}
				
			}
			
			
			
		}
		public function viewErorrMsg(&$erorrs,$erorr_id,$value_id){
			
			if(isset($erorrs[$erorr_id]['value'])){
				
				if($erorrs[$erorr_id]['value']=="NOT SET"){
					
					echo "<div class='errorsmall'>Please enter ".$value_id."</div>";	
				}elseif($erorrs[$erorr_id]['value']=="INVALID EMAIL"){
					echo "<div class='errorsmall'>Please enter a valid email address</div>";	
				}elseif($erorrs[$erorr_id]['value']=="INUSE"){
					
					echo "<div class='errorsmall'>This Email address is already in use.</div>";
				}elseif($erorrs[$erorr_id]['value']=="INVALID"){
					echo "<div class='errorsmall'>Invalid ".$value_id."</div>";
				}elseif($erorrs[$erorr_id]['value']=="BLOCKED"){
					
					echo "<div class='errorsmall'>This Email service is blocked.Please use a another email.</div>";
				}
			}
			
		}
		public function viewValue(&$values,$value_id){
			
			if(isset($values[$value_id]['value'])){
				echo $values[$value_id]['value'];
			}else{
				echo "";
			}
			
		}
  
}
?>