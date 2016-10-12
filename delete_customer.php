<?PHP
include 'config/config.php';
include("Controllers/CustomerController.php");
include("Models/Customer.php");

$cms = new CustomerController($_GET);

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
if(isset($_GET['cx_id']) && is_numeric($_GET['cx_id'])){
	$cms->deleteCustomer($_GET['cx_id']);
	header('location:customer_list.php?delete=TRUE');
	exit();
}else{
	header('location:customer_list.php?delete=FALSE');
	exit();	
}
?>

