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
    include 'asset/classes/Test.php';
    include 'asset/classes/Student.php';
    include 'asset/classes/User.php';
    $userid= $_SESSION['adminId'];
    $pre = $_SESSION['pre'];
    $user = new User();

    $test = new Test();
    $student = new Student();
    $idm =0;
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
                Software Reset<small>Module</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Reset</li>
                <li class="active">Backup</li>
            </ol>
        </section>

        <section class="content">
            <div class="row">
                
                <div class="col-md-12">
                    <div class="box box-primary text-center">
                        <div class="alert ">
                            <h2>Backup <i class="glyphicon glyphicon-download-alt"></i></h2>
                            <h3>This downloads all datable structures and data from the database</h3>
                            <a class="btn btn-success" href="backup.php">Download Database Backup <i class="glyphicon glyphicon-download-alt"></i></a>
                        </div>
                    </div><!-- /.box-body -->
                    <div class="box box-primary text-center">
                        <div class="alert ">
                            <h2>Restore Backup <i class="glyphicon glyphicon-download"></i></h2>
                            <h5 class="text-danger">This restores all data from the backup file and delete all existing ones. 
                                Ensure you have backedup the current data before performing this operation as this operation is irreversible.</h5>
                            <form action="restore_backup.php" target="_blank" class="form-inline" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="">Backup file:</label>
                                    <input type="file" name="backup_file" id="backup_file" class="form-control" accept=".sql">
                                </div>
                                <button type="submit" class="btn btn-primary">Backup now</button>
                            </form>
                        </div>
                    </div><!-- /.box-body -->
                    <div class="box box-danger text-center">
                        <div class="m-2">
                            <h2>Reset <i class="glyphicon glyphicon-refresh"></i></h2>
                            <h3>Warning!!!</h3>
                            <h4>Ensure that you have backed up your data before proceeding as this operation deletes and resets all data in the database</h4>
                            <button data-target="#software_reset_modal" data-toggle="modal" class="btn btn-danger">Reset Software <i class="glyphicon glyphicon-refresh"></i></button>                        
                        </div>
                        <br><br>
                    </div>

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
    <strong>Copyright &copy; 2017 <a href="#">Test Master</a>.</strong> All rights reserved.
</footer>
</div><!-- ./wrapper -->
<div class="modal fade" id="software_reset_modal" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="delete">
    <div class="modal-dialog modal-md mdls" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <code><h3>Resetting this sofware will delete all data on the database. Are you sure you want to continue?</h3></code>
                <h4><span id="confirm">Please enter admin password to continue</span></h4>
                <input type="password" class="form-control form-control-lg" id="del_confirm">
                <p class="" id="status"></p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-md btn-danger pull-left" id="ok_resetS">Submit</button>
                <button class="btn btn-md btn-info" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<?php
echo $user->getPasswordModal($userid);
?>
<script src="plugins/jquery/jQuery-2.1.3.min.js"></script>
<!-- Bootstrap 3.3.2 JS -->
<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<!-- DATA TABES SCRIPT -->

<script src="dist/js/app.min.js" type="text/javascript"></script>

<script src="dist/js/demo.js" type="text/javascript"></script>
<script src="dist/js/myjquery.js" type="text/javascript"></script>
<!-- page script -->

<!-- Page script -->

</body>
</html>
