<?PHP
include 'config/config.php';
include("Controllers/EmployeeController.php");
include("Models/Employee.php");

$cms = new EmployeeController($_GET);

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
	if(isset($_POST['name']) && strlen($_POST['name'])>0){
		$values_array['name'] = stripslashes($_POST['name']);
	}else{
		$erorrs_array['name'] = 'INVALID';
	}
	if(isset($_POST['email']) && strlen($_POST['email'])>0){
		$values_array['email'] = stripslashes($_POST['email']);
	}else{
		$values_array['email'] = '';
	}
	if(isset($_POST['nic']) && strlen($_POST['nic'])>0){
		$values_array['nic'] = stripslashes($_POST['nic']);
	}else{
		$values_array['nic'] = '';
	}
	if(isset($_POST['birthday']) && strlen($_POST['birthday'])>0){
		$values_array['birthday'] = stripslashes($_POST['birthday']);
	}else{
		$values_array['birthday'] = '';
	}
	if(isset($_POST['gender']) && strlen($_POST['gender'])>0){
		$values_array['gender'] = stripslashes($_POST['gender']);
	}else{
		$erorrs_array['gender'] = 'INVALID';
	}
	if(isset($_POST['basic_salary']) && strlen($_POST['basic_salary'])>0){
		$values_array['basic_salary'] = stripslashes($_POST['basic_salary']);
	}else{
		$erorrs_array['basic_salary'] = 'INVALID';
	}
	if(empty($erorrs_array)){
		$form_error = FALSE;
		if(isset($_GET['em_id']) && is_numeric($_GET['em_id'])){
				$em_id = intval($_GET['em_id']);
				$cms->updateEmployee($values_array['name'],$values_array['email'],$values_array['nic'],$values_array['birthday'],$values_array['gender'],$values_array['basic_salary'],$em_id);
		}else{
			    $cms->insertNewEmployee($values_array['name'],$values_array['email'],$values_array['nic'],$values_array['birthday'],$values_array['gender'],$values_array['basic_salary']);
		}
	}
}else{
	if(isset($_GET['em_id']) && is_numeric($_GET['em_id'])){
		$em_id = intval($_GET['em_id']);
		$employee = $cms->loadEmployeeById($em_id);
		$values_array['name'] = $employee['em_name'];
		$values_array['email'] = $employee['em_email'];
		$values_array['nic'] = $employee['em_nic'];
		$values_array['birthday'] = $employee['em_birthday'];
		$values_array['gender'] = $employee['em_gender'];
		$values_array['basic_salary'] = $employee['em_salary'];
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
        <?PHP echo HUMAN_RESOURCES;?>
        <small><?PHP echo ADD_EMPLOYEE;?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> <?PHP  echo HOME;?></a></li>
        <li class="active"><?PHP echo HUMAN_RESOURCES;?></li>
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
              <h3 class="box-title"><?PHP echo ADD_EMPLOYEE;?></h3>
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
                <?PHP echo EMPLOYEE_SAVED;?>
              </div>
            <?PHP }?>
            <form role="form" method="post" action="#">
              <div class="box-body">
              <div class="form-group <?PHP if(isset($erorrs_array['name'])){ echo 'has-error';}?>">
                  <label <?PHP if(isset($erorrs_array['name'])){ echo 'for="inputError"';}?>><?PHP  echo NAME;?></label>
                  <input type="text" class="form-control"  placeholder="<?PHP  echo NAME;?>" name="name" <?PHP if(isset($erorrs_array['name'])){ echo 'id="inputError"';}?> value="<?PHP if(isset($values_array['name'])){ echo $values_array['name'];}?>">
                  <?PHP if(isset($erorrs_array['name'])){ 
				  ?>
                  <span class="help-block"><?PHP  echo PLEASE_CHECK;?> : <?PHP  echo NAME;?></span>
                  <?PHP
				  
				  }?>
                </div>
                <div class="form-group <?PHP if(isset($erorrs_array['email'])){ echo 'has-error';}?>">
                  <label <?PHP if(isset($erorrs_array['email'])){ echo 'for="inputError"';}?>><?PHP  echo EMAIL;?></label>
                  <input type="text" class="form-control"  placeholder="<?PHP  echo EMAIL;?>" name="email" <?PHP if(isset($erorrs_array['email'])){ echo 'id="inputError"';}?> value="<?PHP if(isset($values_array['email'])){ echo $values_array['email'];}?>">
                  <?PHP if(isset($erorrs_array['email'])){ 
				  ?>
                  <span class="help-block"><?PHP  echo PLEASE_CHECK;?> : <?PHP  echo EMAIL;?></span>
                  <?PHP
				  
				  }?>
                </div>
                <div class="form-group <?PHP if(isset($erorrs_array['nic'])){ echo 'has-error';}?>">
                  <label <?PHP if(isset($erorrs_array['nic'])){ echo 'for="inputError"';}?>><?PHP  echo NIC ;?></label>
                  <input type="text" class="form-control"  placeholder="<?PHP  echo NIC;?>" name="nic" <?PHP if(isset($erorrs_array['nic'])){ echo 'id="inputError"';}?> value="<?PHP if(isset($values_array['nic'])){ echo $values_array['nic'];}?>">
                  <?PHP if(isset($erorrs_array['nic'])){ 
				  ?>
                  <span class="help-block"><?PHP  echo PLEASE_CHECK;?> : <?PHP  echo NIC;?></span>
                  <?PHP
				  
				  }?>
                </div>
                <div class="form-group <?PHP if(isset($erorrs_array['birthday'])){ echo 'has-error';}?>">
                  <label <?PHP if(isset($erorrs_array['birthday'])){ echo 'for="inputError"';}?>><?PHP  echo BIRTHDAY ;?></label>
                  <input type="text" class="form-control"  placeholder="<?PHP  echo BIRTHDAY;?>" name="birthday" <?PHP if(isset($erorrs_array['birthday'])){ echo 'id="inputError"';}?> value="<?PHP if(isset($values_array['birthday'])){ echo $values_array['birthday'];}?>">
                  <?PHP if(isset($erorrs_array['birthday'])){ 
				  ?>
                  <span class="help-block"><?PHP  echo PLEASE_CHECK;?> : <?PHP  echo BIRTHDAY;?></span>
                  <?PHP
				  
				  }?>
                </div>
                <div class="form-group">
                  <label><?PHP  echo GENDER;?></label>
                  <select class="form-control" name="gender">
                      <option value="M" <?PHP if(isset($values_array['gender']) && $values_array['gender']=='M'){echo "selected";}?>)><?PHP  echo MALE;?></option>
                      <option value="F" <?PHP if(isset($values_array['gender']) && $values_array['gender']=='F'){echo "selected";}?>><?PHP  echo FEMALE;?></option>
                    
                  </select>
                </div>
                 <div class="form-group <?PHP if(isset($erorrs_array['basic_salary'])){ echo 'has-error';}?>">
                  <label <?PHP if(isset($erorrs_array['basic_salary'])){ echo 'for="inputError"';}?>><?PHP  echo BASIC_SALARY ;?></label>
                  <input type="text" class="form-control"  placeholder="<?PHP  echo BASIC_SALARY;?>" name="basic_salary" <?PHP if(isset($erorrs_array['basic_salary'])){ echo 'id="inputError"';}?> value="<?PHP if(isset($values_array['basic_salary'])){ echo $values_array['basic_salary'];}?>">
                  <?PHP if(isset($erorrs_array['basic_salary'])){ 
				  ?>
                  <span class="help-block"><?PHP  echo PLEASE_CHECK;?> : <?PHP  echo BASIC_SALARY;?></span>
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
