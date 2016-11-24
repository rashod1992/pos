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
if(isset($_GET['id']) && is_numeric($_GET['id'])){
	$order_id = intval($_GET['id']);
	$order = $cms->loadOrderById($order_id);
}else{
	header('location:add_sale.php');
    exit();
}

$values_array = array();
$erorrs_array = array();
if(!empty($_POST)){
	
    if(isset($_POST['discount'])){
        $discount = intval($_POST['discount']);
        if($discount>0){
            $deduct = ($order['or_final_total']/100)*$discount;
            $total = $order['or_final_total'] - $deduct;
        }else{
            $deduct = 0;
            $total = $order['or_final_total'];
        }
        
        $cms->add_discount($deduct, $total, $order_id);
        $order = $cms->loadOrderById($order_id);
        
    }else{
		if(isset($_POST['form_type']) && $_POST['form_type']=='other'){
				if(isset($_POST['action']) && strlen($_POST['action'])>0)	{
					$action = $_POST['action'];
				}else{
					$other_form = "INVALID";
				}
				if(isset($_POST['product']) && strlen($_POST['product'])>0)	{
					$action = $_POST['product'];
				}else{
					$other_form = "INVALID";
				}
				if(isset($_POST['price']) && strlen($_POST['price'])>0)	{
					$action = $_POST['price'];
				}else{
					$other_form = "INVALID";
				}
				if(isset($_POST['quantity']) && is_numeric($_POST['quantity'])){
					$quantity_other = $_POST['quantity'];
				}else{
					$quantity_other = 1;
				}
				
				
				if(!isset($other_form)){
					//first we add a type of a product 
					if($_POST['action']=='+'){
						$unitprice = $_POST['price'];
					}else{
						$unitprice = -$_POST['price'];
					}
				$other_price = $unitprice * $quantity_other;	
					
					$insert_id = $cms->addOtherProduct($_POST['product'],$unitprice);
					
					//add the product to the order
					$cms->addOrderProducts($insert_id,$order_id,$other_price,$quantity_other);
					
					//update the cart value
					
					$total_amount = $order['or_total_amount'] + $other_price;
					$cms->updateCartValue($total_amount,$order_id);
					
					
				}
			}else{
		
							if(isset($_POST['cx_id']) && is_numeric($_POST['cx_id'])){
								$pro_id = intval($_POST['cx_id']);
								$product_info = $cms->loadProductById($pro_id);
							}else{
								$erorrs_array['cx_id'] = 'INVALID';
							}
							if(isset($_POST['or_quantity']) && is_numeric($_POST['or_quantity'])){
								if(isset($product_info)){
									if($_POST['or_quantity']<=$product_info['pr_quantity']){
                                                                                
                                                                            if(isset($_POST['or_special_price']) && is_numeric($_POST['or_special_price']) && $_POST['or_special_price']>0){
                                                                                $product_amount = $_POST['or_special_price'] * $_POST['or_quantity'];
                                                                            }else{
                                                                                $product_amount = $product_info['pr_unit_price'] * $_POST['or_quantity'];
                                                                            }
										
										$cms->addOrderProducts($pro_id,$order_id,$product_amount,$_POST['or_quantity']);
										
										//update cart value
										$total_amount = $order['or_total_amount'] + $product_amount;
										$cms->updateCartValue($total_amount,$order_id);
										
									}else{
										$erorrs_array['or_quantity'] = 'OVER';
									}
								}else{
									$erorrs_array['cx_id'] = 'INVALID';
								}
							}else{
								$erorrs_array['or_quantity'] = 'INVALID';
							}
			}
    }
	
	//adding other products 
	
	
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
  <link rel="stylesheet" href="dist/css/AdminLTE.css">
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
<?PHP if($order['or_status']==1){?>
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
                <label><?PHP echo PRODUCT_NAME;?></label>
                <select name="cx_name"  id="cx_name" style="width:100%;" data-placeholder="<?PHP echo PRODUCT_NAME;?>..." multiple tabindex="-1" >
                 <?PHP 
				 $customers = $cms->loadAllProducts();
				 while($customer =  mysqli_fetch_array($customers, MYSQL_ASSOC)):
				 ?>
                 	<option value="<?PHP echo $customer['pr_id'];?>"><?PHP echo $customer['pr_name'];?>
                 <?PHP
				 endwhile;
				 ?>
                </select>
               <input type="hidden" id="cx_id" value="" name="cx_id">
                
              </div>
              <div class="form-group <?PHP if(isset($erorrs_array['or_quantity'])){ echo 'has-error';}?>">
                  <label <?PHP if(isset($erorrs_array['or_quantity'])){ echo 'for="inputError"';}?>><?PHP  echo QUANTITY;?></label>
                  <input type="text" class="form-control"  placeholder="<?PHP  echo QUANTITY;?>" name="or_quantity" <?PHP if(isset($erorrs_array['or_quantity'])){ echo 'id="inputError"';}?> value="<?PHP if(isset($values_array['or_quantity'])){ echo $values_array['or_quantity'];}?>">
                  <?PHP if(isset($erorrs_array['or_quantity'])){ 
				  ?>
                  <span class="help-block"><?PHP  echo PLEASE_CHECK;?> : <?PHP  echo QUANTITY;?></span>
                  <?PHP
				  
				  }?>

              </div>
              <div class="form-group <?PHP if(isset($erorrs_array['or_special_price'])){ echo 'has-error';}?>">
                  <label <?PHP if(isset($erorrs_array['or_special_price'])){ echo 'for="inputError"';}?>><?PHP  echo SPECIAL_PRICE;?></label>
                  <input type="text" class="form-control"  placeholder="<?PHP  echo SPECIAL_PRICE;?>" name="or_special_price" <?PHP if(isset($erorrs_array['or_special_price'])){ echo 'id="inputError"';}?> value="<?PHP if(isset($values_array['or_special_price'])){ echo $values_array['or_special_price'];}?>">
                  <?PHP if(isset($erorrs_array['or_special_price'])){ 
				  ?>
                  <span class="help-block"><?PHP  echo PLEASE_CHECK;?> : <?PHP  echo SPECIAL_PRICE;?></span>
                  <?PHP
				  
				  }?>

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
    <?PHP }else{?>
    <?PHP if($order['or_discount']==NULL){?>
    <section class="content">
      <!-- Small boxes (Stat box) -->
     
      <!-- /.row -->
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <div class="col-md-8">
            
       <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"><?PHP echo ADD_DISCOUNTT;?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            
            <form role="form" method="post" action="#">
              <div class="box-body">
              <div class="form-group">
                <label><?PHP echo DISCOUNTT;?></label>
                <input type="text" class="form-control"  placeholder="<?PHP  echo DISCOUNTT;?>" name="discount" <?PHP if(isset($erorrs_array['discount'])){ echo 'id="inputError"';}?> value="<?PHP if(isset($values_array['discount'])){ echo $values_array['discount'];}else{ echo "0";}?>">
               
                
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
    <?PHP }?>
    <?PHP }?>
    <section class="invoice">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
           <img src="img/logo.png">
            <small class="pull-right">Date: <strong><?PHP echo date('Y-m-d');?></strong><br/>
   			Hotline : <strong>07773133397</strong><br/>
            TP : <strong>0112408413</strong><br/>
            Email : <strong>ariyarathnasuppliers@gmail.com</strong><br/>
            WL# : <strong>TDL/B/CoL/013</strong><br/>
           
            
            </small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
          From
          <address>
          <b><?PHP echo $cms->loadMetaValue('site_name');?></b><br/>
            <?PHP echo str_replace(",","<br/>",$cms->loadMetaValue('cx_address'));?>
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          To
          <address>
          <b><?PHP echo $order['or_customer_name'];?></b><br/>
            <?PHP echo str_replace(",","<br/>",$order['or_customer_address']);?><br/>
            <?PHP echo $order['or_customer_telephone'];?>
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          <b>
          <?PHP if($order['or_tax']==1){
			 echo "Tax-"; 
		  }?>
          Invoice <?PHP echo $order['or_id'];?></b><br>
          <br>
          <b>Order ID:</b> <?PHP echo $order['or_id'];?><br>
          <b>Payment Due:</b> <?PHP echo $order['or_date'];?><br>
          <b>Account:</b> <?PHP echo $order['or_customer_id'];?>
          <?PHP
            $custom_fiealds = $cms->load_Custom_fields();
            foreach($custom_fiealds as $custom){
                ?>
          <div class="custom-<?PHP echo $custom['cu_id']; ?>">
              <div class="custom-value-<?PHP echo $custom['cu_id']; ?>"></div>
              
              <?PHP if($order['or_status']==1){
                  $customvalue = $cms->get_custom_value($order['or_id'],$custom['cu_id']);

                  if($customvalue!=NULL){
                      $value_custom = $customvalue['va_value'];
                  }else{
                      $value_custom = "";
                  }
                  ?>
              <b><?PHP echo $custom['cu_name'];?></b> : <input type="text" id="custom-field-<?PHP echo $custom['cu_id']; ?>" value="<?PHP echo $value_custom;?>">
              <input type="button" id="custom-but-<?PHP echo $custom['cu_id']; ?>" onclick="addcustomvalue(<?PHP echo $custom['cu_id']; ?>,<?PHP echo $order_id;?>)" value="add">
              <?PHP }else{
                  $customvalue = $cms->get_custom_value($order['or_id'],$custom['cu_id']);
                  if($customvalue!=NULL){
                  ?>
              <b><?PHP echo $custom['cu_name'];?></b> :<?PHP echo $customvalue['va_value'];?>
              <?PHP
                  }
              }?>
          </div>
                
                <?PHP
            }
            ?>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
          <table class="table table-striped">
            <thead>
            <tr>
              <th>Qty</th>
              <th>Product</th>
              <th>Unit Price</th>
              <th>Subtotal</th>
            </tr>
            </thead>
            <tbody>
            <?PHP
			$products = $cms->loadOrderProducts($order_id);
			while($product =  mysqli_fetch_array($products, MYSQL_ASSOC)):
			?>
            <tr>
              <td><?PHP echo $product['pro_quantity'];?></td>
              <td><?PHP echo $product['pr_name'];?></td>
              <?PHP 
              $unit_price = $product['pro_amount'] / $product['pro_quantity'];
              ?>
              <td>Rs.<?PHP echo number_format($unit_price,2);?></td>
              <td>Rs.<?PHP echo number_format($product['pro_amount'],2);?> 
                  <?PHP if($order['or_status']==1){?>
                  <a href="remove_order_product.php?pr_id=<?PHP echo $product['pro_id'];?>&order_id=<?PHP echo $order_id;?>"><i class="fa fa-fw fa-remove"></i></a></td>
                  <?PHP }?>
            </tr>
            <?PHP 
			endwhile;
			?>
            
            </tbody>
          </table>
          <?PHP if($order['or_status']==1){?>
          <table class="table table-striped">
          <h3><?PHP echo OTHER_PRODUCTS;?></h3>
            <thead>
            <tr>
              <th><?PHP echo ACTION;?></th>
              <th><?PHP echo PRODUCT_NAME;?></th>
              <th><?PHP echo ADD_QUANTITY;?></th>
              <th><?PHP echo UNIT_PRICE;?></th>
              <th></th>
            </tr>
            </thead>
            <tbody>
            <form action="" method="post">
          <tr>
              <td><select name="action" required/>
              	<option><?PHP echo ACTION;?></option>
              	<option value="+"><?PHP echo ADD;?></option>
                <option value="-"><?PHP echo SUBSTRACT;?></option>
              </select></td>
              <td><input type="text" name="product" placeholder="<?PHP echo PRODUCT_NAME;?>" required/></td>
              <td><input type="text" name="quantity" placeholder="<?PHP echo  ADD_QUANTITY;?>" value="1" required/></td>
              <td>Rs.<input type="text" name="price" placeholder="<?PHP echo UNIT_PRICE;?>" required/></td>
              <td>
              <input type="hidden" name="form_type" value="other">
              <button type="submit" class="btn btn-primary">Submit</button>
                  </td>
            </tr>
           </form>
            </tbody>
          </table>
           <?PHP }?>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row">
        <!-- accepted payments column -->
        <div class="col-xs-6">
         

          <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
           Thank You for doing business with us.
          </p>
          <br/>
          <br/>
          .................................................................<br/>
          (signature)
          
        </div>
        <!-- /.col -->
        <?PHP 
        $order = $cms->loadOrderById($order_id);
        ?>
        <div class="col-xs-6">
          <p class="lead">Amount Due <?PHP echo $order['or_date'];?></p>

          <div class="table-responsive">
            <table class="table">
              <tbody><tr>
                <th style="width:50%">Subtotal:</th>
                <td>Rs.<?PHP echo number_format($order['or_total_amount'],2);?></td>
              </tr>
              <?PHP if($order['or_tax']==1){
				  $tax_amount = $cms->loadMetaValue('site_tax');
				  $tax = ($order['or_total_amount'] / 100) * $tax_amount;
				  ?>
              <tr>
                <th>Tax (<?PHP echo $tax_amount ?>%)</th>
                <?PHP if($order['or_tax_amount']!=NULL){
                    $tax = $order['or_tax_amount'];
                 }?>
                <td>Rs.<?PHP echo number_format($tax,2);?></td>
              </tr>
              <?PHP }else{
				  $tax = 0;
			  }?>
             
              <?PHP if($order['or_discount']!=NULL){?>
                <?PHP if($order['or_discount']!=0){?>
                        <tr>
                <th>Discount:</th>
                <td>Rs.<?PHP
                                $discount = $order['or_discount'];
				echo number_format($order['or_discount'],2);
				?>
				</td>
              </tr>
                <?PHP }else{
                    $discount = 0;
                }
?>
              <?PHP }else{
                  $discount = 0;
              }
?>
              <tr>
                <th>Total:</th>
                <td>Rs.
                <?PHP if($order['or_status']==2){
                    echo number_format($order['or_total_amount'],2);
                 }else{
                    
                $total_sum = ($order['or_total_amount'] + $tax);
				echo number_format($total_sum,2);
                                
                 }
				?>
                
				</td>
              </tr>
            </tbody></table>
          </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- this row will not appear when printing -->
      <div class="row no-print">
        <div class="col-xs-12">
          <?PHP if($order['or_status']==1){?>
			<a href="finish_bill.php?id=<?PHP echo $order_id;?>" class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-download"></i> Finish Bill</a>
          <?PHP }?>
        </div>
      </div>
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
  <script>
      function addcustomvalue(cust_id,order_id){
          
          var custom_value = $("#custom-field-"+cust_id).val();
          var ajaxurl = "add_cutom_value.php";
          $.post(ajaxurl, {
					order_id: order_id,
					cust_id: cust_id,
					custom_value : custom_value
			}, function(data) {
					
					$(".custom-value-"+cust_id).html(data);
                                        $("#custom-but-"+cust_id).prop('value', 'update');
				
			});

          
      }
  </script>
</body>
</html>
