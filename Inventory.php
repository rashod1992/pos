<?php



require('Models.php');

if (mysqli_connect_errno()) {

    printf("Connect failed: %s\n", mysqli_connect_error());

    exit();

}

class Inventory extends Models{

    

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



    public function insertNewProduct($pro_name,$pro_price){

        

        $mysqli = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        $pro_name = mysqli_real_escape_string($mysqli,$pro_name);
        $pro_price = mysqli_real_escape_string($mysqli,$pro_price);


        $sql_string = "INSERT INTO pos_products (pr_name,pr_unit_price) "

                . "VALUES ('".$pro_name."','".$pro_price."')";

        $query = mysqli_query($mysqli,$sql_string);

		

	return $query;

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
	public function getTotalProductsCount(){

        

        $mysqli = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);


        $sql_string = "SELECT COUNT(*) AS count FROM pos_products WHERE pr_active = 1";

        $query = mysqli_query($mysqli,$sql_string);

		$result = mysqli_fetch_array($query);	

		return $result;

    }
	public function loadProductsPaging($offset,$limit){

        

        $mysqli = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
		$offset = mysqli_real_escape_string($mysqli,$offset);
        $limit = mysqli_real_escape_string($mysqli,$limit);

        $sql_string = "SELECT * FROM pos_products WHERE pr_active = 1 LIMIT ".$offset.",".$limit."";

        $query = mysqli_query($mysqli,$sql_string);

		return  $query;

    }
	public function getProductSearch($search){

        

        $mysqli = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
		$search = mysqli_real_escape_string($mysqli,$search);


        $sql_string = "SELECT * FROM pos_products WHERE pr_name LIKE '%".$search."%'";

        $query = mysqli_query($mysqli,$sql_string);

		return  $query;

    }
	public function deleteProduct($pro_id){

        

        $mysqli = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
		$pro_id = mysqli_real_escape_string($mysqli,$pro_id);


        $sql_string = "DELETE FROM pos_products WHERE pr_id = '".$pro_id."'";

        $query = mysqli_query($mysqli,$sql_string);

		return  $query;

    }

}

