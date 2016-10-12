<?PHP
include 'config/config.php';
include("Controllers/SalesController.php");
include("Models/Sales.php");

$cms = new SalesController($_GET);

if(isset($_SESSION['sid'])){
    $user = $cms->loaduserBySid();
    if($user==NULL){
        header('location:index.php');
        exit();
    }
}else{
    header('location:index.php');
    exit();
    
}
if( isset($_GET['id']) && is_numeric($_GET['id'])){
	
	$order_id  = intval($_GET['id']);
	$products = $cms->loadOrderProducts($order_id);
			while($product =  mysqli_fetch_array($products, MYSQL_ASSOC)):
				//update product qunatity
				$qunatity = $product['pr_quantity'] - $product['pro_quantity'];
				$cms->updateOrderQunatity($product['pro_product_id'],$qunatity);
			endwhile;
			
			//update order status
                       $order_info = $cms->loadOrderById($order_id);
                       if($order_info['or_tax']==1){
                           $tax_amount = $cms->loadMetaValue('site_tax');
                           $tax_value = ($order_info['or_total_amount'] / 100) * $tax_amount;
                           
                           $sub_total = $order_info['or_total_amount']+$tax_value;
                           
                       }else{
                           $tax_value = 0;
                           $sub_total = $order_info['or_total_amount'];
                       }
			$cms->updateOrderStatus($order_id,$tax_value,$sub_total);
         
	header('location:add_sale_step2.php?id='.$order_id);
	exit();
	
}else{
	echo "Invalid Request, And You are lost";
	exit();
}
?>
