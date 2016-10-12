<?php



require('Models.php');

if (mysqli_connect_errno()) {

    printf("Connect failed: %s\n", mysqli_connect_error());

    exit();

}

class Home extends Models{

    

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

    public function loadBrandByID($id){

        

        $mysqli = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        $id = mysqli_real_escape_string($mysqli,$id);

        

        $sql_string = "SELECT * FROM fa_brands WHERE brand_id = '".$id."'";

        $query = mysqli_query($mysqli,$sql_string);

	$result = mysqli_fetch_array($query);	

	return $result;

    }
    public function loadNewsByID($id){

        

        $mysqli = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        $id = mysqli_real_escape_string($mysqli,$id);

        

        $sql_string = "SELECT * FROM fa_news WHERE news_id = '".$id."'";

        $query = mysqli_query($mysqli,$sql_string);

	$result = mysqli_fetch_array($query);	

	return $result;

    }

    

    public function updateBrand($name,$image1,$image2,$description,$link,$id){

        

        $mysqli = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        $name = mysqli_real_escape_string($mysqli,$name);

        $image1 = mysqli_real_escape_string($mysqli,$image1);

        $image2 = mysqli_real_escape_string($mysqli,$image2);

        $description = mysqli_real_escape_string($mysqli,$description);

        $link = mysqli_real_escape_string($mysqli,$link);

        $id = mysqli_real_escape_string($mysqli,$id);

        

        

        

        $sql_string = "UPDATE fa_brands SET brand_name='".$name."',brand_image='".$image1."'"

                . ",brand_image2='".$image2."',brand_description='".$description."',brand_link='".$link."' WHERE brand_id ='".$id."'";

        //echo $sql_string;

        $query = mysqli_query($mysqli,$sql_string);

		

	return $query;

    }

    public function loadBrandList(){

        $mysqli = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        $sql_string = "SELECT * FROM fa_brands ORDER BY brand_name";

        $query = mysqli_query($mysqli,$sql_string);

	//$result = mysqli_fetch_array($query);	

	return $query;

    }
    
    public function ordersCount(){
        
         $mysqli = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        $sql_string = "SELECT COUNT(*) AS count FROM pos_orders WHERE or_status = 2";

        $query = mysqli_query($mysqli,$sql_string);

	$result = mysqli_fetch_array($query);	

	return $result;
    }
    
    public function ordersTotalValue(){
        
         $mysqli = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        $sql_string = "SELECT SUM(or_final_total) AS count FROM pos_orders WHERE or_status = 2";

        $query = mysqli_query($mysqli,$sql_string);

	$result = mysqli_fetch_array($query);	

	return $result;
    }
	 public function customersCount(){
        
         $mysqli = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        $sql_string = "SELECT COUNT(*) AS count FROM pos_customers";

        $query = mysqli_query($mysqli,$sql_string);

		$result = mysqli_fetch_array($query);	
	
		return $result;
    }
    

}

