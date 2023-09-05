<?php
/**
 * Created by PhpStorm.
 * User: freshsalis
 * Date: 12/9/2017
 * Time: 4:28 PM
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

    $test = new Test();
    $student = new Student();
    $idm =0;
    $batch = 0;
    if(isset($_GET['batch'])){
        $batch = $_GET['batch'];
    }
    if(isset($_GET['id']))
     $idm = $_GET['id'];

    echo  $user->getHeader();
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
            Access Token<small>Module</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Student</li>
            <li class="active">Access Tokens</li>
        </ol>
    </section>

<!-- Main content -->
<section class="content">
<div class="row">
<div class="col-md-3">
    <div class="box box-solid">
        <?php
            echo $test ->getExamMenu($idm,'access_tokens.php?id=','token');
        ?>
    </div><!-- /. box -->
</div><!-- /.col -->

<div class="col-md-9">
<div class="box box-primary">
<!-- /.box-header -->
    <?php
        echo $test ->getTokenTable($idm);
    ?>

</div><!-- /. box -->
</div><!-- /.col -->
</div><!-- /.row -->
</section><!-- /.content -->
</div><!-- /.content-wrapper -->
<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <b>Version</b> 2.0
    </div>
    <strong>Copyright &copy; 2022 <a href="#">Test Master</a>.</strong> All rights reserved.
</footer>
</div><!-- ./wrapper -->

<!------------------------------------- Default modal --------------------------------------------------->

<!------------------------------------- Delete modal --------------------------------------------------->


<!-- DELETE BATCH STUDENTS -->
<div class="modal fade" id="del_batch_stud_modal" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="delete">
    <div class="modal-dialog modal-md mdls" role="document">
        <form action="generate_token.php" target="_blank" method="post">
            <div class="modal-content">
                <div class="modal-body">
                    <h4><span id="confirm">Generate Tokens</span></h4>
                    Number of tokens<input type="number" required name="number" class="form-control form-control-lg" id=""><br>
                    Exam Venue<input type="text" name="venue" required class="form-control form-control-lg" id=""><br>
                    <input type="hidden" name="exam" value="<?php echo $idm ?>" class="form-control form-control-lg" id=""><br>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-danger pull-left">Submit</button>
                    <button class="btn btn-md btn-info" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
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
