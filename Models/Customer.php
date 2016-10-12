<?php
require('Models.php');

if (mysqli_connect_errno()) {

    printf("Connect failed: %s\n", mysqli_connect_error());

    exit();

}

class Customer extends Models{


    protected $connection;


    public function __construct()

    {


    }

	

	public function setDb($connection)

    {

        $this->connection = $connection;

    }

    public function loaduserBySid(){

        

        $mysqli = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        $sid = mysqli_real_escape_string($mysqli,$_SESSION['sid']);

        $sql_string = "SELECT * FROM pos_users WHERE user_sid = '".$sid."'";

        $query = mysqli_query($mysqli,$sql_string);

		$result = mysqli_fetch_array($query);	

		return $result;

    }

    

    

   public function loadMetaValue($meta_key){
    
        $mysqli = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        $meta_key = mysqli_real_escape_string($mysqli,$meta_key);

        $sql_string = "SELECT * FROM pos_site_meta WHERE meta_key ='".$meta_key."'";
        $query = mysqli_query($mysqli,$sql_string);
        $result = mysqli_fetch_array($query);	

		return $result;
        
    }

	public function insertNewCustomer($cx_name,$cx_email,$cx_address,$cx_tp){

			
	
			$mysqli = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
	
			$cx_name = mysqli_real_escape_string($mysqli,$cx_name);
			$cx_email = mysqli_real_escape_string($mysqli,$cx_email);
			$cx_address = mysqli_real_escape_string($mysqli,$cx_address);
			$cx_tp = mysqli_real_escape_string($mysqli,$cx_tp);
	
	
			$sql_string = "INSERT INTO pos_customers (cx_name,cx_address,cx_telephone,cx_email) VALUES ('".$cx_name."','".$cx_address."','".$cx_tp."','".$cx_email."')";
	
			$query = mysqli_query($mysqli,$sql_string);
			$query = mysqli_insert_id($mysqli);
			
	
		return $query;

    }
	 public function updateCustomer($cx_name,$cx_email,$cx_address,$cx_tp,$cx_id){

        $mysqli = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        $cx_name = mysqli_real_escape_string($mysqli,$cx_name);
        $cx_email = mysqli_real_escape_string($mysqli,$cx_email);
		$cx_address = mysqli_real_escape_string($mysqli,$cx_address);
		$cx_tp = mysqli_real_escape_string($mysqli,$cx_tp);
		$cx_id = mysqli_real_escape_string($mysqli,$cx_id);

        $sql_string = "UPDATE pos_customers SET cx_name='".$cx_name."',cx_address='".$cx_address."',cx_telephone='".$cx_tp."',cx_email='".$cx_email."' WHERE cx_id = '".$cx_id."'";

        $query = mysqli_query($mysqli,$sql_string);

		return $query;

    }
 	public function loadCustomerById($id){

        $mysqli = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        $id = mysqli_real_escape_string($mysqli,$id);

        $sql_string = "SELECT * FROM pos_customers WHERE cx_id = '".$id."'";
        $query = mysqli_query($mysqli,$sql_string);
		$result = mysqli_fetch_array($query);	

		return $result;

    }
	public function getCustomerSearch($search){

        

        $mysqli = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
		$search = mysqli_real_escape_string($mysqli,$search);


        $sql_string = "SELECT * FROM pos_customers WHERE cx_name LIKE '%".$search."%' OR cx_address = '".$search."'";

        $query = mysqli_query($mysqli,$sql_string);

		return  $query;

    }
	public function getTotalCustomerCount(){

        

        $mysqli = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);


        $sql_string = "SELECT COUNT(*) AS count FROM pos_customers";

        $query = mysqli_query($mysqli,$sql_string);

		$result = mysqli_fetch_array($query);	

		return $result;

    }
	public function loadCustomersPaging($offset,$limit){

        

        $mysqli = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
		$offset = mysqli_real_escape_string($mysqli,$offset);
        $limit = mysqli_real_escape_string($mysqli,$limit);

        $sql_string = "SELECT * FROM pos_customers  LIMIT ".$offset.",".$limit."";

        $query = mysqli_query($mysqli,$sql_string);

		return  $query;

    }
	public function deleteCustomer($pro_id){

        

        $mysqli = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
		$pro_id = mysqli_real_escape_string($mysqli,$pro_id);


        $sql_string = "DELETE FROM pos_customers WHERE cx_id = '".$pro_id."'";

        $query = mysqli_query($mysqli,$sql_string);

		return  $query;

    }

}

