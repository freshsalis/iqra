<?php
/**
 * Created by PhpStorm.
 * User: freshsalis
 * Date: 12/10/2017
 * Time: 6:31 PM
 */
session_start();

if (!$_SESSION['adminId']) {
    header('Location:adminLogin.php');
}
include 'asset/classes/_Class.php';
include 'asset/classes/Student.php';
include 'asset/classes/User.php';
$userid= $_SESSION['adminId'];
$pre = $_SESSION['pre'];
$user = new User();

$class = new _Class();
$student = new Student();
$idm =0;
if(isset($_GET['id']))
    $idm = $_GET['id'];

    $user->getHeader();
?>

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
                Users<small>Module</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">User</li>
                <li class="active">Add Users</li>
            </ol>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-md-11">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Add new User</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div class="box box-info">
                                <div class="box-body">
                                    <form class="form-add" role="form" id="form-add">

                                        <div class="input-group">
                                            <span class="input-group-addon">Full Name</span>
                                            <input type="text" name="className" id="className" class="form-control" placeholder="">
                                        </div>
                                        <br/>
                                        <div class="input-group">
                                            <span class="input-group-addon">Username</span>
                                            <input type="text" name="teacher" id="teacher" class="form-control" placeholder="">
                                        </div><br/>
                                        <div class="input-group">
                                            <span class="input-group-addon">Passsword</span>
                                            <input type="text" name="teacher" id="teacher" class="form-control" placeholder="">
                                        </div>
                                        <br/>
                                        <div class="input-group">
                                            <span class="input-group-addon">Previledge</span>
                                            <select  class="form-control" name="status" id="status">
                                                <option>--</option>
                                                <option>Admin I</option>
                                                <option>Admin II</option>
                                            </select>
                                        </div>
                                        <br/>
                                        <div class="input-group">
                                            <input type="submit" id="add" class="btn btn-primary form-control add" rel="class" value="Add" placeholder="">
                                        </div><br/>
                                        <div class="jumbotron msg"></div>
                                    </form><!-- /input-group -->
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div><!-- /.box-body -->

                    </div><!-- /. box -->
                </div>

                <div class="col-md-1"></div>  <!-- /.col -->
            </div><!-- /.row -->
        </section><!-- /.content -->
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
<script src="plugins/jquery/jQuery-2.1.3.min.js"></script>
<!-- Bootstrap 3.3.2 JS -->
<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<!-- DATA TABES SCRIPT -->
<script src="plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
<!-- SlimScroll -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<!-- FastClick -->
<script src='plugins/fastclick/fastclick.min.js'></script>

<script src="dist/js/app.min.js" type="text/javascript"></script>

<script src="dist/js/demo.js" type="text/javascript"></script>
<script src="dist/js/myjquery.js" type="text/javascript"></script>
<!-- page script -->

<!-- Page script -->

</body>
</html>
