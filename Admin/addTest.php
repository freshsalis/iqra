<?php
/**
 * Created by PhpStorm.
 * User: freshsalis
 * Date: 12/11/2017
 * Time: 1:42 PM
 */
session_start();

if (!$_SESSION['adminId']) {
    header('Location:adminLogin.php');
}
    include 'asset/classes/Test.php';
    include 'asset/classes/Student.php';
    include 'asset/classes/User.php';
    $userid= $_SESSION['adminId'];
    $pre = $_SESSION['pre'];
    $user = new User();

    $class = new _Class();
    $test = new Test();
    $student = new Student();
    $idm =0;
    if(isset($_GET['id']))
        $idm = $_GET['id'];

    // echo $user->getHeader();
?>
    <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>Test Master || Admin</title>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <!-- Bootstrap 3.3.2 -->
            <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
            <!-- Google Font: Source Sans Pro -->
            <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
            <!-- Font Awesome -->
            <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
            <!-- daterange picker -->
            <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
            <!-- Select2 -->
            
           <!-- Theme style -->
            <link href="dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
            <!-- AdminLTE Skins. Choose a skin from the css/skins
                 folder instead of downloading all of them to reduce the load. -->
            <link href="dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />


        </head>
        <body class="skin-green">
        <div class="wrapper">
        
            <header class="main-header">
                <!-- Logo -->
                <a href="index.php" class="logo"><b>TEST</b> Master</a>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top" role="navigation">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                    </a>
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <!-- User Account: style can be found in dropdown.less -->
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="dist/img/staffb.jpg" class="user-image" alt="User Image"/>
                                    <span class="hidden-xs">  <?php echo $user->getAdmin($_SESSION['adminId'])?></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header">
                                        <img src="dist/img/staffb.jpg" class="img-circle" alt="User Image" />
                                        <p>
                                            <?php echo $user->getAdmin($_SESSION['adminId'])?> - Exams Officer
                                        </p>
                                    </li>
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <a href="#"  data-toggle="modal" data-target="#myModal" data-whatever="@mdo" class="btn btn-default btn-flat">Change password</a>
                                        </div>
                                        <div class="pull-right">
                                            <a href="logout.php" class="btn btn-default btn-flat">Sign out</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
        
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <?php echo $user ->getUserMenu($pre); ?>

        <!-- /.sidebar -->
    </aside>

<!-- Right side column. Contains the navbar and content of the page -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Exam<small>Module</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Exam</li>
            <li class="active">Add Exam</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
           
            <div class="col-md-12">

                <div class="box box-primary">
                    <!-- /.box-header -->
                    <?php
                    echo $test ->getTestForm();
                    ?>

                </div><!-- /. box -->

            </div><!-- /. box -->
        </div><!-- /.col -->
</div><!-- /.row -->
</section><!-- /.content -->

<!-- Main content -->
</div><!-- /.content-wrapper -->
<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <b>Version</b> 2.0
    </div>
    <strong>Copyright &copy; 2022 <a href="#">Test Master</a>.</strong> All rights reserved.
</footer>
</div><!-- ./wrapper -->

<?php
echo $user->getPasswordModal($userid);
?>
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- InputMask -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/inputmask/jquery.inputmask.min.js"></script>
<!-- date-range-picker -->
<script src="plugins/daterangepicker/daterangepicker.js"></script>

<script src="dist/js/app.min.js" type="text/javascript"></script>

<script src="dist/js/demo.js" type="text/javascript"></script>
<script src="dist/js/myjquery.js" type="text/javascript"></script>
<script src="dist/js/ckeditor/ckeditor.js" type="text/javascript"></script>

<!-- Page specific script -->
<script>
  $(function () {

	CKEDITOR.replace('editor2', { height: 70, width: 800 });
    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'MM/DD/YYYY hh:mm A'
      }
    })

  })
</script>
</body>
</html>
