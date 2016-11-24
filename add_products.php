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
if(isset($_SESSION['user_lang'])){
    if($_SESSION['user_lang']==1){
        include 'english.php';
    }else{
        include 'sinhala.php';
    }
}else{
    include 'english.php';
}
$values_array = array();
$erorrs_array = array();
if(!empty($_POST)){
	if(isset($_POST['product_name']) && strlen($_POST['product_name'])>0){
		$values_array['product_name'] = stripslashes($_POST['product_name']);
	}else{
		$erorrs_array['product_name'] = 'INVALID';
	}
	if(isset($_POST['product_value']) && strlen($_POST['product_value'])>0 && is_numeric($_POST['product_value'])){
		$values_array['product_value'] = stripslashes($_POST['product_value']);
	}else{
		$erorrs_array['product_value'] = 'INVALID';
	}
	
	if(empty($erorrs_array)){
		
		$form_error = FALSE;
		if(isset($_GET['pro_id']) && is_numeric($_GET['pro_id'])){
			$cms->updateProduct($values_array['product_name'],$values_array['product_value'],$_GET['pro_id']);
		}else{
			$cms->insertNewProduct($values_array['product_name'],$values_array['product_value']);
		}
		
		
		
	}else{
		
		$form_error = TRUE;	
	}
	
}else{
	if(isset($_GET['pro_id']) && is_numeric($_GET['pro_id'])){
		$product_info = $cms->loadProductById($_GET['pro_id']);
		$values_array['product_name'] = $product_info['pr_name'];
		$values_array['product_value'] = $product_info['pr_unit_price'];
	}
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?PHP echo $cms->loadMetaValue('site_name');?> | Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <?PHP include 'inc-head.php';?>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
<?PHP include('inc-headmenu.php');?>
  
  <!-- Left side column. contains the logo and sidebar -->
<?PHP include('inc-leftmenu.php');?>
 

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?PHP  echo INVENTORY;?>
        <small><?PHP  echo ADD_PRODUCTS;?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> <?PHP  echo HOME;?></a></li>
        <li class="active"><?PHP  echo INVENTORY;?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
     
      <!-- /.row -->
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <div class="col-md-8">
       <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"><?PHP  echo ADD_PRODUCTS;?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            
            <?PHP if(isset($form_error) && $form_error==TRUE){?>
            	<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
               <?PHP echo ERORR_PROCEED;?>
              </div>
            <?PHP }elseif(isset($form_error) && $form_error==FALSE){?>
            	<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Alert!</h4>
                <?PHP echo PRODUCT_SAVED;?>
              </div>
            <?PHP }?>
            <form role="form" action="" method="post">
              <div class="box-body">
                <div class="form-group <?PHP if(isset($erorrs_array['product_name'])){ echo 'has-error';}?>">
                  <label <?PHP if(isset($erorrs_array['product_name'])){ echo 'for="inputError"';}?>><?PHP  echo PRODUCT_NAME;?></label>
                  <input type="text" class="form-control"  placeholder="<?PHP  echo PRODUCT_NAME;?>" name="product_name" <?PHP if(isset($erorrs_array['product_name'])){ echo 'id="inputError"';}?> value="<?PHP if(isset($values_array['product_name'])){ echo $values_array['product_name'];}?>">
                  <?PHP if(isset($erorrs_array['product_name'])){ 
				  ?>
                  <span class="help-block"><?PHP  echo PLEASE_CHECK;?> : <?PHP  echo PRODUCT_NAME;?></span>
                  <?PHP
				  
				  }?>
                </div>
                <div class="form-group <?PHP if(isset($erorrs_array['product_value'])){ echo 'has-error';}?>">
                  <label <?PHP if(isset($erorrs_array['product_value'])){ echo 'for="inputError"';}?>><?PHP  echo UNIT_PRICE;?></label>
                  <input type="text" class="form-control"  placeholder="<?PHP  echo UNIT_PRICE;?>" name="product_value" <?PHP if(isset($erorrs_array['product_value'])){ echo 'id="inputError"';}?> value="<?PHP if(isset($values_array['product_value'])){ echo $values_array['product_value'];}?>">
                  <?PHP if(isset($erorrs_array['product_value'])){ 
				  ?>
                  <span class="help-block"><?PHP  echo PLEASE_CHECK;?> : <?PHP  echo UNIT_PRICE;?></span>
                  <?PHP
				  
				  }?>
                </div>
                
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
          </div>
        </div>
        <!-- right col -->
      </div>
      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?PHP include('inc-footer.php');?>
  

  <!-- Control Sidebar -->
  <?PHP include('inc-sidebar.php');?>
  
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.0 -->
<script src="plugins/jQuery/jQuery-2.2.0.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="plugins/morris/morris.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/knob/jquery.knob.js"></script>
<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>
