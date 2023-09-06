<?php
/**
 * Created by PhpStorm.
 * User: freshsalis
 * Date: 12/11/2017
 * Time: 2:53 PM
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
            Exam<small>Module</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Exam</li>
            <li class="active">View Exam</li>
        </ol>
    </section>


    <!-- Main content -->
<section class="content">
<div class="row">
    
    <div class="col-md-12 box"><br>
    <button data-toggle="modal" data-target="#exam_modal" data-whatever="@mdo" id="new_exam" class="btn btn-md btn-primary pull-right">
                Create New Exam <span class="glyphicon glyphicon-plus"></span>
            </button><br><br>
        <div class="box box-primary" style="width:100%;overflow:scroll;">
            <!-- /.box-header -->
            <br><br>

            
            

            <?php
            echo $test ->getExamTable($idm,'');
            ?>

        </div><!-- /. box -->
        
    </div>
</div><!-- /.row -->
</section><!-- /.content -->
</div><!-- /.content-wrapper -->
<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <b>Version</b> 2.0
    </div>
    <strong>Copyright &copy; 2023 <a href="#">Test Master</a>.</strong> All rights reserved.
</footer>
</div><!-- ./wrapper -->



<div class="modal fade" id="exam_modal" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="exam_modal">
    <div class="modal-dialog panel modal-md mdls" role="document">
        <div class="modal-heading"><h3>Create New Exam</h3></div>
        <div class="modal-content">
            <div class="modal-body">
                <div class="panel panel-success cbtlogin" >
                                <div class="panel-body">
                                <div id="error"></div>
                                    <form class="form-horizontal" action="#" method="post" name="form1" id="exam-form">
                                        <div class="box-body">
                                                <div class="input-group">
                                                    <span class="input-group-addon">Exam Name</span>
                                                    <input type="text" value="" name="testTitle" id="testTitle" class="form-control" placeholder="">
                                                </div>
                                                <br/>

                                        <div class="input-group">
                                            <span class="input-group-addon">Academic Session</span>
                                            <input type="text" value="" name="session" id="session" class="form-control" placeholder="">
                                        </div>
                                        <br/>
                                        <div class="input-group">
                                            <span class="input-group-addon">Status</span>
                                            <select  class="form-control" name="status" id="status">';
                                            <option >Active</option>
                                               
                                                <option>Active</option>
                                                <option>Pending</option>
                                                <option>Completed</option>
                                                
                                            </select>
                                        </div>
                                        <br/>
                                        
                                        <br/>
                                        <div class="input-group">
                                            <b>Exam Instructions: </b>
                                            <textarea class="col-md-12 form-control" name="instruction" cols="60" id="editor2" name=""></textarea>
                                        </div>
                                        <br>
                                        <br/>
                                        <input type="submit" id="submit-exam" class="btn btn-primary form-control submit-exam" rel="exam" value="Submit" placeholder="">
                                        <br><br>
                                        <div class=" msg" id="msg"></div>

                                            </div><!-- /input-group -->

                            </form>
                        </div>

                    </div>
            </div>
            
            <div class="modal-footer">
                <a class="btn btn-md btn-danger" href="" id="del" >Close</a>
            </div>
        </div>
</div>
</div>
    

<!------------------------------------- Default modal --------------------------------------------------->
<div class="modal fade modal-default" id="addstudent" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="addstudent1">

    <div class="modal-dialog modal-md mdls" role="document">
        <div class="modal-content">
            <div class="modal-header"><h4><b>Edit Exam</b></h4></div>
            <div class="modal-body">
                <div ID="alert1"></div>
                <div id="editbody"></div>
                <div class="myclass"></div>

            </div>
            <div class="modal-footer">
                <div class="col-sm-10 col-sm-offset-2">
                    <button class="btn btn-md btn-primary" type="submit"  id="update">Update</button>
                    <a href="" class="btn btn-md btn-danger" >Close</a>
                </div>
            </div>
        </div>


    </div>
</div>
<!------------------------------------- Delete modal --------------------------------------------------->
<div class="modal fade" id="delete" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="delete">
    <div class="modal-dialog modal-md mdls" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h4><span id="confirm">Are you sure you want to delete this Exam?</span></h4>
            </div>
            <div class="modal-footer">
                <button class="btn btn-md btn-primary" id="ok" >Yes</button>
                <a class="btn btn-md btn-danger" href="" id="del" >Close</a>
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
<script src="plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<!-- FastClick -->
<script src='plugins/fastclick/fastclick.min.js'></script>

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
