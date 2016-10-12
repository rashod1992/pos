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

if(isset($_GET['pro_id']) && is_numeric($_GET['pro_id'])){
	$product_id = intval($_GET['pro_id']);
}else{
	echo "Invalid Product Id";
	exit();	
}
if(!empty($_POST)){
    if(isset($_POST['quantity']) && strlen($_POST['quantity'])>0 && is_numeric($_POST['quantity'])){
		$values_array['quantity'] = stripslashes($_POST['quantity']);
	}else{
		$erorrs_array['quantity'] = 'INVALID';
    }
    if(empty($erorrs_array)){
        $product = $cms->loadProductById($product_id);
        if(isset($_POST['do_action'])){
            if($_POST['do_action']=='+'){
                $quantity = $product['pr_quantity'] + $values_array['quantity'];
            }elseif($_POST['do_action']=='-'){
                $quantity = $product['pr_quantity'] - $values_array['quantity'];
            }else{
                $quantity = $product['pr_quantity'];
            }
            
        }else{
            $quantity = $product['pr_quantity'];
        }
        
        
        $cms->updateQuantity($product_id, $quantity);
        $form_error = FALSE;
    }else{
        $form_error = TRUE;
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
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/iCheck/flat/blue.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="plugins/morris/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="plugins/jvectormap/jquery-jvectormap-1.2.2.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker-bs3.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
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
        <small><?PHP echo ADD_QUANTITY;?></small>
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
              <h3 class="box-title"><?PHP echo ADD_QUANTITY;?></h3>
            </div>
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
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="#" method="post">
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1"><?PHP  echo PRODUCT_NAME;?></label>
                 	<?PHP  $product = $cms->loadProductById($product_id);
					echo $product['pr_name']?>
                </div>
                  <div class="form-group">
                  <label><?PHP  echo ACTION;?></label>
                  <select class="form-control" name="do_action">
                      <option value="+"><?PHP  echo ADD;?></option>
                      <option value="-"><?PHP  echo SUBSTRACT;?></option>
                    
                  </select>
                </div>
                <div class="form-group <?PHP if(isset($erorrs_array['quantity'])){ echo 'has-error';}?>">
                  <label <?PHP if(isset($erorrs_array['quantity'])){ echo 'for="inputError"';}?>><?PHP echo ADD_QUANTITY;?></label>
                  <input type="text" class="form-control"  placeholder="<?PHP echo ADD_QUANTITY;?>" name="quantity" <?PHP if(isset($erorrs_array['quantity'])){
                      echo 'id="inputError"';}?> value="<?PHP if(isset($values_array['quantity'])){ echo $values_array['quantity'];}?>">
                  <?PHP if(isset($erorrs_array['quantity'])){ 
				  ?>
                  <span class="help-block"><?PHP  echo PLEASE_CHECK;?> : <?PHP echo ADD_QUANTITY;?></span>
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
