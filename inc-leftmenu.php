 <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
            <img src="img/user.png" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?PHP echo $user['user_full_name'];?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header"><?PHP echo MAIN_NAVIGATION;?></li>
        <li class="active treeview">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span><?PHP echo INVENTORY;?></span> <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li class="active"><a href="add_products.php"><i class="fa fa-circle-o"></i> <?PHP echo ADD_PRODUCTS;?></a></li>
            <li><a href="products_list.php"><i class="fa fa-circle-o"></i> <?PHP echo PRODUCTS_LIST;?></a></li>
           
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span><?PHP echo HUMAN_RESOURCES;?></span> <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li class="active"><a href="add_employee.php"><i class="fa fa-circle-o"></i> <?PHP echo ADD_EMPLOYEE;?></a></li>
            <li class="active"><a href="employee_list.php"><i class="fa fa-circle-o"></i> <?PHP echo EMPLOYEE_LIST;?></a></li>
           
          </ul>
        </li>
         <li class="treeview">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span><?PHP echo CUSTOMERS;?></span> <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li class="active"><a href="add_customer.php"><i class="fa fa-circle-o"></i> <?PHP echo ADD_CUSTOMERS;?></a></li>
            <li><a href="customer_list.php"><i class="fa fa-circle-o"></i> <?PHP echo CUSTOMER_LIST;?></a></li>
           
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span><?PHP echo SALES;?></span> <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li class="active"><a href="add_sale.php"><i class="fa fa-circle-o"></i> <?PHP echo ADD_SALE;?></a></li>
            <li><a href="sales_list.php"><i class="fa fa-circle-o"></i> <?PHP echo SALES_LIST;?></a></li>
           
          </ul>
        </li>
       
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
