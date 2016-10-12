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
	if(isset($_POST['cx_id']) && is_numeric($_POST['cx_id'])){
		$cx_id = intval($_POST['cx_id']);
		$customer = $cms->loadCustomerById($cx_id);
		
		if(isset($_POST['or_tax']) && $_POST['or_tax']==1){
			$tax = 1;	
		}else{
			$tax = 0;	
		}
		//insert data to order db
		$insert_id = $cms->insertNewSale($customer['cx_id'],$customer['cx_name'],$customer['cx_address'],$customer['cx_telephone'],$tax);
		
		header('location:add_sale_step2.php?id='.$insert_id);
		exit();
		
	}else{
		
	if(isset($_POST['cx_name']) && strlen($_POST['cx_name'])>0){
		$values_array['cx_name'] = stripslashes($_POST['cx_name']);
	}else{
		$erorrs_array['cx_name'] = 'INVALID';
	}
	if(isset($_POST['cx_email']) && strlen($_POST['cx_email'])>0 && $cms->isValidEmail($_POST['cx_email'])){
		$values_array['cx_email'] = stripslashes($_POST['cx_email']);
	}else{
		$values_array['cx_email'] = '';
	}
	if(isset($_POST['cx_address']) && strlen($_POST['cx_address'])>0){
		$values_array['cx_address'] = stripslashes($_POST['cx_address']);
	}else{
		$values_array['cx_address'] = '';
	}
	if(isset($_POST['cx_telephone']) && strlen($_POST['cx_telephone'])>0){
		$values_array['cx_telephone'] = stripslashes($_POST['cx_telephone']);
	}else{
		$values_array['cx_telephone'] = '';
	}
	if(isset($_POST['or_tax']) && $_POST['or_tax']==1){
			$tax = 1;	
	}else{
			$tax = 0;	
	}
	if(empty($erorrs_array)){
		$form_error = FALSE;
		
			    $insert = $cms->insertNewCustomer($values_array['cx_name'],$values_array['cx_email'],$values_array['cx_address'],$values_array['cx_telephone']);
				
				$insert_id = $cms->insertNewSale($insert,$values_array['cx_name'],$values_array['cx_address'],$values_array['cx_telephone'],$tax);
		
				header('location:add_sale_step2.php?id='.$insert_id);
				exit();
		
		
		}
	}
	
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?PHP echo $cms->loadMetaValue('site_name');?> | Sales</title>
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
  <link rel="stylesheet" href="../../plugins/select2/select2.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker-bs3.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  
  <link rel="stylesheet" href="prism.css">
  <link rel="stylesheet" href="chosen.css">

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
        <?PHP  echo SALES;?>
        <small><?PHP echo ADD_SALE;?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> <?PHP  echo HOME;?></a></li>
        <li class="active"><?PHP  echo SALES;?></li>
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
              <h3 class="box-title"><?PHP echo ADD_SALE;?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="post" action="#">
              <div class="box-body">
              <div class="form-group">
                <label><?PHP echo SELECT_CUSTOMER;?></label>
                <select name="cx_name"  id="cx_name" style="width:100%;" data-placeholder="<?PHP echo SELECT_CUSTOMER;?>..." multiple tabindex="-1" >
                 <?PHP 
				 $customers = $cms->loadAllCustomers();
				 while($customer =  mysqli_fetch_array($customers, MYSQL_ASSOC)):
				 ?>
                 	<option value="<?PHP echo $customer['cx_id'];?>"><?PHP echo $customer['cx_name'];?>
                 <?PHP
				 endwhile;
				 ?>
                </select>
               <input type="hidden" id="cx_id" value="" name="cx_id">
               
                
              </div>
              <hr/>
              <h3 style="margin:auto; width:100px;"><?PHP  echo OR_TEXT ; ?></h3>
              <div class="form-group <?PHP if(isset($erorrs_array['cx_name'])){ echo 'has-error';}?>">
                  <label <?PHP if(isset($erorrs_array['cx_name'])){ echo 'for="inputError"';}?>><?PHP  echo CUSTOMER_NAME;?></label>
                  <input type="text" class="form-control"  placeholder="<?PHP  echo CUSTOMER_NAME;?>" name="cx_name" <?PHP if(isset($erorrs_array['cx_name'])){ echo 'id="inputError"';}?> value="<?PHP if(isset($values_array['cx_name'])){ echo $values_array['cx_name'];}?>">
                  <?PHP if(isset($erorrs_array['cx_name'])){ 
				  ?>
                  <span class="help-block"><?PHP  echo PLEASE_CHECK;?> : <?PHP  echo CUSTOMER_NAME;?></span>
                  <?PHP
				  
				  }?>
                </div>
                <div class="form-group <?PHP if(isset($erorrs_array['cx_email'])){ echo 'has-error';}?>">
                    <label <?PHP if(isset($erorrs_array['cx_email'])){ echo 'for="inputError"';}?>><?PHP echo EMAIL;?></label>
                  <input type="email" class="form-control"  placeholder="<?PHP echo EMAIL;?>" name="cx_email" <?PHP if(isset($erorrs_array['cx_email'])){ echo 'id="inputError"';}?> value="<?PHP if(isset($values_array['cx_email'])){ echo $values_array['cx_email'];}?>">
                  <?PHP if(isset($erorrs_array['cx_email'])){ 
				  ?>
                  <span class="help-block"><?PHP  echo PLEASE_CHECK;?> : <?PHP echo EMAIL;?></span>
                  <?PHP
				  
				  }?>
                </div>
                
               <div class="form-group <?PHP if(isset($erorrs_array['cx_address'])){ echo 'has-error';}?>">
                    <label <?PHP if(isset($erorrs_array['cx_address'])){ echo 'for="inputError"';}?>><?PHP echo ADDRESS;?></label>
                  <input type="text" class="form-control"  placeholder="<?PHP echo ADDRESS;?>" name="cx_address" <?PHP if(isset($erorrs_array['cx_address'])){ echo 'id="inputError"';}?> value="<?PHP if(isset($values_array['cx_address'])){ echo $values_array['cx_address'];}?>">
                  <?PHP if(isset($erorrs_array['cx_address'])){ 
				  ?>
                  <span class="help-block"><?PHP  echo PLEASE_CHECK;?> : <?PHP echo ADDRESS;?></span>
                  <?PHP
				  
				  }?>
                </div>
				<div class="form-group <?PHP if(isset($erorrs_array['cx_telephone'])){ echo 'has-error';}?>">
                    <label <?PHP if(isset($erorrs_array['cx_telephone'])){ echo 'for="inputError"';}?>><?PHP echo TELEPHONE;?></label>
                  <input type="text" class="form-control"  placeholder="<?PHP echo TELEPHONE;?>" name="cx_telephone" <?PHP if(isset($erorrs_array['cx_telephone'])){ echo 'id="inputError"';}?> value="<?PHP if(isset($values_array['cx_telephone'])){ echo $values_array['cx_telephone'];}?>">
                  <?PHP if(isset($erorrs_array['cx_telephone'])){ 
				  ?>
                  <span class="help-block"><?PHP  echo PLEASE_CHECK;?> : <?PHP echo TELEPHONE;?></span>
                  <?PHP
				  
				  }?>
                </div>
                
                <div class="col-sm-offset-2 col-sm-10">
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" name="or_tax" value="1"> <?PHP echo TAX_APPLICABLE;?>
                      </label>
                    </div>
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

<!-- Select2 -->
<script src="../../plugins/select2/select2.full.min.js"></script>

<!-- InputMask -->
<script src="../../plugins/input-mask/jquery.inputmask.js"></script>
<script src="../../plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="../../plugins/input-mask/jquery.inputmask.extensions.js"></script>
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
<script src="chosen.jquery.js" type="text/javascript"></script>
<script src="prism.js" type="text/javascript" charset="utf-8"></script>
<script>
$(function () {
	$(".select2").select2();
});
  $.widget.bridge('uibutton', $.ui.button);
</script>
<script type="text/javascript">
    var config = {
      '#cx_name'           : {}
    }
    for (var selector in config) {
      jQuery(selector).chosen(config[selector]);
    }
	jQuery('#cx_name').on('change', function() {
    		var drop_value = jQuery('#cx_name').val();
			jQuery('#cx_id').val(drop_value);
  });
  </script>
</body>
</html>
