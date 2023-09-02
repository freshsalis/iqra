<?php
/**
 * Created by PhpStorm.
 * User: freshsalis
 * Date: 12/12/2017
 * Time: 1:58 PM
 */
session_start();

if (!$_SESSION['adminId']) {
    header('Location:adminLogin.php');
}
include 'asset/classes/Question.php';
include 'asset/classes/Test.php';
include 'asset/classes/User.php';
$userid= $_SESSION['adminId'];
$pre = $_SESSION['pre'];
$user = new User();

$question = new Question();
$test = new Test();
$idm =0;
$batch = 0;
if(isset($_GET['batch'])){
    $batch = $_GET['batch'];
}
if(isset($_GET['id']))
    $idm = $_GET['id'];

    echo $user->getHeader();
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
                Attendance without score<small>Module</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Attendance</li>
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-3">
                    <div class="box box-solid">
                        <?php
                        echo $test ->getTestMenu($idm,'without_score.php?id=');
                        ?>

                    </div><!-- /. box -->
                    
                </div><!-- /.col -->
                <div class="col-md-2">
                    <div class="box box-solid">
                    <?php
                        echo $test ->getBatchMenu($idm , 'without_score.php',$batch);
                        ?>
                    

                    </div><!-- /. box -->
                    
                </div><!-- /.col -->
                <div class="col-md-7">

                    <div class="box box-primary">
                        <!-- /.box-header -->
                        <?php
                        echo $test ->without_score($idm,$batch);
                        ?>

                    </div><!-- /. box -->

                </div>
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

<!------------------------------------- Default modal --------------------------------------------------->
<div class="modal fade modal-default" id="addstudent" tabindex="-1" role="dialog" aria-labelledby="addstudent1">

    <div class="modal-dialog modal-md mdls" role="document">
        <div class="modal-content">
            <div class="modal-header"><h4><b>Edit Test</b></h4></div>
            <div class="modal-body">
                <div ID="alert1"></div>
                <div id="editbody"></div>
                <div class="myclass"></div>

            </div>
            <div class="modal-footer">
                <div class="col-sm-10 col-sm-offset-2">
                    <button class="btn btn-md btn-primary" type="submit"  id="update">Update</button>
                    <button class="btn btn-md btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>


    </div>
</div>
<!------------------------------------- Delete modal --------------------------------------------------->
<div class="modal fade" id="delete" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="delete">
    <div class="modal-dialog modal-sm mdls" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <small><b><span id="confirm">Are you sure you want to delete this Test?</span></b></small>
            </div>
            <div class="modal-footer">
                <button class="btn btn-md btn-primary" id="ok" data-dismiss="modal">OK</button>
                <a class="btn btn-md btn-danger" href="viewQuestion.php" id="del" >Close</a>
            </div>
        </div>
    </div>
</div>

<?php
echo $user->getPasswordModal($userid);
?>
<!-- jQuery 2.1.3 -->
<script src="plugins/jquery/jQuery-2.1.3.min.js"></script>
<!-- Bootstrap 3.3.2 JS -->
<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<!-- DATA TABES SCRIPT -->
<script src="plugins2/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="plugins2/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
<!-- SlimScroll -->


<script src="dist/js/app.min.js" type="text/javascript"></script>

<script src="dist/js/demo.js" type="text/javascript"></script>
<script src="dist/js/myjquery.js" type="text/javascript"></script>
<!-- page script -->
<script type="text/javascript">
    $(function () {
        $("#example1").dataTable();
        $('#example2').dataTable({
            "bPaginate": true,
            "bLengthChange": false,
            "bFilter": false,
            "bSort": true,
            "bInfo": true,
            "bAutoWidth": false
        });
    });
</script>

</body>
</html>
