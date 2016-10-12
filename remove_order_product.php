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
if(isset($_GET['pr_id']) && is_numeric($_GET['pr_id']) && isset($_GET['order_id']) && is_numeric($_GET['order_id'])){
	$product = intval($_GET['pr_id']);
	$order_id  = intval($_GET['order_id']);
	
	$product_info  = $cms->loadOrderProductById($product);
	$order = $cms->loadOrderById($order_id);
	//remove the product
	$cms->removeProductFromOrder($product);
	//update Order Values
	$final_total = $order['or_total_amount'] - $product_info['pro_amount'];
	$cms->updateCartValue($final_total,$order_id);

	header('location:add_sale_step2.php?id='.$order_id);
	exit();
	
}else{
	echo "Invalid Request, And You are lost";
	exit();
}
?>
