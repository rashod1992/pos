<?php



require('Models.php');

if (mysqli_connect_errno()) {

    printf("Connect failed: %s\n", mysqli_connect_error());

    exit();

}

class Sales extends Models{


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
 	public function loadAllCustomers(){

        $mysqli = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);


        $sql_string = "SELECT * FROM pos_customers ORDER BY cx_name";
        $query = mysqli_query($mysqli,$sql_string);
		

		return $query;

    }
	public function loadCustomerById($cx_id){

        

        $mysqli = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
		$cx_id = mysqli_real_escape_string($mysqli,$cx_id);


        $sql_string = "SELECT *  FROM pos_customers WHERE cx_id = '".$cx_id."'";

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
	public function insertNewSale($cx_id,$cx_name,$cx_address,$cx_telephone,$tax){

			
	
			$mysqli = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
			
			$cx_id = mysqli_real_escape_string($mysqli,$cx_id);
			$cx_name = mysqli_real_escape_string($mysqli,$cx_name);
			$cx_address = mysqli_real_escape_string($mysqli,$cx_address);
			$cx_telephone = mysqli_real_escape_string($mysqli,$cx_telephone);
			$tax = mysqli_real_escape_string($mysqli,$tax);
	
	
			$sql_string = "INSERT INTO pos_orders (or_customer_id,or_customer_name,or_customer_address,or_customer_telephone,or_tax) VALUES ('".$cx_id."','".$cx_name."','".$cx_address."','".$cx_telephone."','".$tax."')";
	
			$query = mysqli_query($mysqli,$sql_string);
			$insert_id = mysqli_insert_id($mysqli);
	
			
	
		return $insert_id;

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
	public function loadOrderById($id){

        

        $mysqli = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
		$id = mysqli_real_escape_string($mysqli,$id);


        $sql_string = "SELECT *  FROM pos_orders WHERE or_id = '".$id."'";

        $query = mysqli_query($mysqli,$sql_string);

		$result = mysqli_fetch_array($query);	

		return $result;

    }
	public function loadAllProducts(){

        $mysqli = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);


        $sql_string = "SELECT * FROM pos_products ORDER BY pr_name";
        $query = mysqli_query($mysqli,$sql_string);
		

		return $query;

    }
	public function loadProductById($id){

        

        $mysqli = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
		$id = mysqli_real_escape_string($mysqli,$id);


        $sql_string = "SELECT *  FROM pos_products WHERE pr_id = '".$id."'";

        $query = mysqli_query($mysqli,$sql_string);

		$result = mysqli_fetch_array($query);	

		return $result;

    }
		public function addOrderProducts($pr_id,$order_id,$amount,$quantity){

			
	
			$mysqli = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
	
			$pr_id = mysqli_real_escape_string($mysqli,$pr_id);
			$order_id = mysqli_real_escape_string($mysqli,$order_id);
			$amount = mysqli_real_escape_string($mysqli,$amount);
			$quantity = mysqli_real_escape_string($mysqli,$quantity);
	
	
			$sql_string = "INSERT INTO pos_order_products (pro_product_id,pro_order_id,pro_amount,pro_quantity) VALUES ('".$pr_id."','".$order_id."','".$amount."','".$quantity."')";
	
			$query = mysqli_query($mysqli,$sql_string);
			$query = mysqli_insert_id($mysqli);
			
	
		return $query;

    }
	public function updateCartValue($value,$cart_id){

        $mysqli = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        $value = mysqli_real_escape_string($mysqli,$value);
        $cart_id = mysqli_real_escape_string($mysqli,$cart_id);
		

        $sql_string = "UPDATE pos_orders SET or_total_amount='".$value."' WHERE or_id = '".$cart_id."'";

        $query = mysqli_query($mysqli,$sql_string);

		return $query;

    }
	public function loadOrderProducts($order_id){

        

        $mysqli = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
		$order_id = mysqli_real_escape_string($mysqli,$order_id);


        $sql_string = "SELECT *  FROM pos_order_products,pos_products WHERE pos_order_products.pro_product_id = pos_products.pr_id AND  pos_order_products.pro_order_id = '".$order_id."'";

        $query = mysqli_query($mysqli,$sql_string);

		

		return $query;

    }
	public function loadOrderProductById($id){

        

        $mysqli = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
		$id = mysqli_real_escape_string($mysqli,$id);


        $sql_string = "SELECT *  FROM pos_order_products WHERE pro_id = '".$id."'";

        $query = mysqli_query($mysqli,$sql_string);

		$result = mysqli_fetch_array($query);	

		return $result;

    }
	public function removeProductFromOrder($id){

        

        $mysqli = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
		$id = mysqli_real_escape_string($mysqli,$id);


        $sql_string = "DELETE  FROM pos_order_products WHERE pro_id = '".$id."'";

        $query = mysqli_query($mysqli,$sql_string);


		return $query;

    }
	public function updateOrderQunatity($product_id,$value){

        $mysqli = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        $product_id = mysqli_real_escape_string($mysqli,$product_id);
        $value = mysqli_real_escape_string($mysqli,$value);
		

        $sql_string = "UPDATE pos_products SET pr_quantity='".$value."' WHERE pr_id = '".$product_id."'";

        $query = mysqli_query($mysqli,$sql_string);

		return $query;

    }
	public function updateOrderStatus($id,$tax,$total){

        $mysqli = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        $id = mysqli_real_escape_string($mysqli,$id);
        $tax = mysqli_real_escape_string($mysqli,$tax);
        $total = mysqli_real_escape_string($mysqli,$total);
		

        $sql_string = "UPDATE pos_orders SET or_status='2',or_tax_amount='".$tax."',or_final_total='".$total."' WHERE or_id = '".$id."'";

        $query = mysqli_query($mysqli,$sql_string);

		return $query;

    }
    public function getSalesSearch($search){

        

        $mysqli = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
		$search = mysqli_real_escape_string($mysqli,$search);


        $sql_string = "SELECT * FROM pos_orders WHERE or_customer_name LIKE '%".$search."%' OR or_customer_name = '".$search."'";

        $query = mysqli_query($mysqli,$sql_string);

		return  $query;

    }
    public function getTotalSalesCount(){

        

        $mysqli = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);


        $sql_string = "SELECT COUNT(*) AS count FROM pos_orders";

        $query = mysqli_query($mysqli,$sql_string);

		$result = mysqli_fetch_array($query);	

		return $result;

    }
    public function loadSalesPaging($offset,$limit){

        

        $mysqli = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
		$offset = mysqli_real_escape_string($mysqli,$offset);
        $limit = mysqli_real_escape_string($mysqli,$limit);

        $sql_string = "SELECT * FROM pos_orders ORDER BY or_id DESC LIMIT ".$offset.",".$limit." ";

        $query = mysqli_query($mysqli,$sql_string);

	return  $query;

    }
    public function add_discount($discount,$total,$order){

        $mysqli = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        $discount = mysqli_real_escape_string($mysqli,$discount);
        $total = mysqli_real_escape_string($mysqli,$total);
        $order = mysqli_real_escape_string($mysqli,$order);
		

        $sql_string = "UPDATE pos_orders SET or_discount ='".$discount."', or_total_amount='".$total."' WHERE or_id = '".$order."'";

        $query = mysqli_query($mysqli,$sql_string);

		return $query;

    }
		public function addOtherProduct($product_name,$unitprice){

			
	
			$mysqli = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
	
			$product_name = mysqli_real_escape_string($mysqli,$product_name);
			$unitprice = mysqli_real_escape_string($mysqli,$unitprice);
	
	
			$sql_string = "INSERT INTO pos_products (pr_name,pr_unit_price,pr_quantity,pr_active) VALUES ('".$product_name."','".$unitprice."','1000','2')";
	
			$query = mysqli_query($mysqli,$sql_string);
			$query = mysqli_insert_id($mysqli);
			
	
		return $query;

    }

}

