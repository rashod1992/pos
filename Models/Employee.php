<?php



require('Models.php');

if (mysqli_connect_errno()) {

    printf("Connect failed: %s\n", mysqli_connect_error());

    exit();

}

class Employee extends Models{

    

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

	public function loadProductById($id){

        $mysqli = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        $id = mysqli_real_escape_string($mysqli,$id);

        $sql_string = "SELECT * FROM pos_products WHERE pr_id = '".$id."'";
        $query = mysqli_query($mysqli,$sql_string);
		$result = mysqli_fetch_array($query);	

		return $result;

    }
	
	
    public function updateProduct($pro_name,$pro_price,$pro_id){

        $mysqli = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        $pro_name = mysqli_real_escape_string($mysqli,$pro_name);
        $pro_price = mysqli_real_escape_string($mysqli,$pro_price);
		$pro_id = mysqli_real_escape_string($mysqli,$pro_id);

        $sql_string = "UPDATE pos_products SET pr_name='".$pro_name."',pr_unit_price='".$pro_price."' WHERE pr_id = '".$pro_id."'";

        $query = mysqli_query($mysqli,$sql_string);

		return $query;

    }
	public function deleteProduct($pro_id){

        

        $mysqli = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
		$pro_id = mysqli_real_escape_string($mysqli,$pro_id);


        $sql_string = "DELETE FROM pos_products WHERE pr_id = '".$pro_id."'";

        $query = mysqli_query($mysqli,$sql_string);

		return  $query;

    }
   
	 public function insertNewEmployee($name,$email,$nic,$birthday,$gender,$salary){

        

        $mysqli = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        $name = mysqli_real_escape_string($mysqli,$name);
        $email = mysqli_real_escape_string($mysqli,$email);
		$nic = mysqli_real_escape_string($mysqli,$nic);
        $birthday = mysqli_real_escape_string($mysqli,$birthday);
		$gender = mysqli_real_escape_string($mysqli,$gender);
        $salary = mysqli_real_escape_string($mysqli,$salary);


        $sql_string = "INSERT INTO pos_employee (em_name,em_email,em_nic,em_birthday,em_gender,em_salary) "

                . "VALUES ('".$name."','".$email."','".$nic."','".$birthday."','".$gender."','".$salary."')";

        $query = mysqli_query($mysqli,$sql_string);

		

	return $query;

    }
	 public function updateEmployee($name,$email,$nic,$birthday,$gender,$salary,$em_id){

        $mysqli = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        
        $name = mysqli_real_escape_string($mysqli,$name);
		$email = mysqli_real_escape_string($mysqli,$email);
		$nic = mysqli_real_escape_string($mysqli,$nic);
		$birthday = mysqli_real_escape_string($mysqli,$birthday);
		$gender = mysqli_real_escape_string($mysqli,$gender);
		$salary = mysqli_real_escape_string($mysqli,$salary);
		$em_id = mysqli_real_escape_string($mysqli,$em_id);

        $sql_string = "UPDATE pos_employee SET em_name='".$name."',em_email='".$email."',em_nic='".$nic."',em_birthday='".$birthday."',em_gender='".$gender."',em_salary='".$salary."'
						 WHERE em_id = '".$em_id."'";

        $query = mysqli_query($mysqli,$sql_string);

		return $query;

    }
	public function loadEmployeeById($id){

        $mysqli = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        $id = mysqli_real_escape_string($mysqli,$id);

        $sql_string = "SELECT * FROM pos_employee WHERE em_id = '".$id."'";
        $query = mysqli_query($mysqli,$sql_string);
		$result = mysqli_fetch_array($query);	

		return $result;

    }
	public function getTotalEmployeeCount(){

        

        $mysqli = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);


        $sql_string = "SELECT COUNT(*) AS count FROM pos_employee";

        $query = mysqli_query($mysqli,$sql_string);

		$result = mysqli_fetch_array($query);	

		return $result;

    }
	public function loadEmployeePaging($offset,$limit){

        

        $mysqli = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
		$offset = mysqli_real_escape_string($mysqli,$offset);
        $limit = mysqli_real_escape_string($mysqli,$limit);

        $sql_string = "SELECT * FROM pos_employee LIMIT ".$offset.",".$limit."";

        $query = mysqli_query($mysqli,$sql_string);

		return  $query;

    }
	public function getEmployeeSearch($search){

        

        $mysqli = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
		$search = mysqli_real_escape_string($mysqli,$search);


        $sql_string = "SELECT * FROM pos_employee WHERE em_name LIKE '%".$search."%'";

        $query = mysqli_query($mysqli,$sql_string);

		return  $query;

    }

}

