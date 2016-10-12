<?PHP
include 'config/config.php';
include("Controllers/InventoryController.php");
include("Models/Inventory.php");

$cms = new InventoryController($_GET);

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
if(isset($_GET['pro_id']) && is_numeric($_GET['pro_id'])){
	$cms->deleteProduct($_GET['pro_id']);
	header('location:products_list.php?delete=TRUE');
	exit();
}else{
	header('location:products_list.php?delete=FALSE');
	exit();	
}
?>

