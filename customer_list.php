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
if(isset($_SESSION['user_lang'])){
    if($_SESSION['user_lang']==1){
        include 'english.php';
    }else{
        include 'sinhala.php';
    }
}else{
    include 'english.php';
}

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?PHP echo $cms->loadMetaValue('site_name');?> | Customer List</title>
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
        <?PHP  echo CUSTOMERS;?>
        <small><?PHP  echo CUSTOMER_LIST;?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> <?PHP  echo HOME;?></a></li>
        <li class="active"><?PHP  echo CUSTOMERS;?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
     
      <!-- /.row -->
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><?PHP  echo CUSTOMER_LIST;?></h3>

              <div class="box-tools">
              <form action="" method="post" style="width: 200px;"> 
                <div class="input-group input-group-sm" style="width: 200px;">
                
                  <input type="text" name="table_search" class="form-control pull-right" placeholder="<?PHP echo SEARCH?>">

                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                  </div>
                 
                </div>
                 </form>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tbody><tr>
                  <th><?PHP echo ID?></th>
                  <th><?PHP echo CUSTOMER_NAME;?></th>
                  <th><?PHP echo ADDRESS?></th>
                  <th><?PHP echo TELEPHONE?></th>
                  <th><?PHP echo EMAIL?></th>
                  <th><?PHP echo EDIT?></th>
                  <th><?PHP echo DELETE?></th>
                  
                </tr>
                
                <?PHP
				  if(isset($_POST['table_search'])){
					  $products = $cms->getCustomerSearch($_POST['table_search']);
				  }else{
					  	$rec_limit = 10;
						$count = $cms->getTotalCustomerCount();
						if( isset($_GET{'page'} ) ) {
							$page = $_GET{'page'} + 1;
							$offset = $rec_limit * $page ;
						 }else {
							$page = 0;
							$offset = 0;
						 }
						 $left_rec = $count - ($page * $rec_limit); 
						 $products = $cms->loadCustomersPaging($offset,$rec_limit);
				  }
				?>
                <?PHP 
					while($product =  mysqli_fetch_array($products, MYSQL_ASSOC)):
					?>
                    <tr>
                  <td><?PHP echo $product['cx_id'];?></td>
                  <td><?PHP echo $product['cx_name'];?></td>
                  <td><?PHP echo $product['cx_address'];?></td>
                  <td><?PHP echo $product['cx_telephone'];?></td>
                  <td><?PHP echo $product['cx_email'];?></td>
                  <td><a href="add_customer.php?cx_id=<?PHP echo $product['cx_id'];?>" class="btn btn-block btn-primary"><i class="fa fa-fw fa-edit"></i> <?PHP echo EDIT?></a></td>
                  <td><a href="delete_customer.php?cx_id=<?PHP echo $product['cx_id'];?>" class="btn btn-block btn-danger"><i class="fa fa-fw fa-remove"></i> <?PHP echo DELETE?></a></td>
                </tr>
                    <?PHP
					endwhile;
				?>
                
                
              </tbody></table>
              <div style="width:25%; padding-top:30px; float:left;">
              <?PHP 
			  if(!isset($_POST['table_search'])){
				  if( $page > 0 ) {
					$last = $page - 2;
					echo "<a href = \"customer_list.php?page=$last\" class=\"btn btn-block btn-default\" style='width:50%; float:left;'> <i class=\"fa fa-fw fa-fast-backward\"></i> Last 10 Records</a>";
					echo "<a href = \"customer_list.php?page=$page\" class=\"btn btn-block btn-default\" style='width:50%; float:left;'> <i class=\"fa fa-fw fa-fast-forward\"></i> Next 10 Records</a>";
				 }else if( $page == 0 ) {
					echo "<a href = \"customer_list.php?page=$page\" class=\"btn btn-block btn-default\" style='width:50%; float:left;'><i class=\"fa fa-fw fa-fast-forward\"></i> Next 10 Records</a>";
				 }else if( $left_rec < $rec_limit ) {
					$last = $page - 2;
					echo "<a href = \"customer_list.php?page=$last\" class=\"btn btn-block btn-default\" style='width:50%; float:left;'> <i class=\"fa fa-fw fa-fast-backward\"></i> Last 10 Records</a>";
				 }
			  }
			  
			  ?>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
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
