<?php
/**
 * Created by PhpStorm.
 * User: freshsalis
 * Date: 12/12/2017
 * Time: 1:58 PM
 */
header('Content-Type: text/html; charset=utf-8');
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
if(isset($_GET['id']))
    $idm = $_GET['id'];
echo $user -> getHeader();
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
            Question<small>Module</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Question</li>
            <li class="active">Add Questiont</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-2">
                    <div class="box box-solid">
                        <?php
                        echo $test ->getExamMenu($idm,'?id=');
                        ?>

                    </div><!-- /. box -->
                    
                </div>
            <div class="col-md-3">
                    <div class="box box-solid">
                        <?php
                        echo $test ->getPaperMenu($idm,'',$_GET['paper'] ?? "");
                        ?>
                    </div><!-- /. box -->
            </div><!-- /.col -->
            <div class="col-md-7">
                <div class="box box-primary">
                    <!-- /.box-header -->
                    <?php
                    echo $question ->getQuestionForm($_GET['paper'] ?? "");
                    ?>
                </div><!-- /. box -->
            </div>
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

<script src="plugins/jquery/jQuery-2.1.3.min.js"></script>
<!-- Bootstrap 3.3.2 JS -->
<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<!-- DATA TABES SCRIPT -->

<!-- SlimScroll -->
<!-- FastClick -->

<script src="dist/js/app.min.js" type="text/javascript"></script>
<script src="dist/js/ckeditor/ckeditor.js" type="text/javascript"></script>

<script src="dist/js/myjquery.js" type="text/javascript"></script>
<!-- page script -->
<!-- InputMask -->
<!-- date-range-picker -->
<!-- bootstrap color picker -->
<!-- bootstrap time picker -->
<!-- iCheck 1.0.1 -->

<!-- Page script -->
<!-- Page script -->
<script type="text/javascript">
	initSample();

	CKEDITOR.replace('editor2', { height: 70, width: 430 });
	CKEDITOR.replace('editor3', { height: 70, width: 430});
	CKEDITOR.replace('editor4', { height: 70, width: 430});
	CKEDITOR.replace('editor5', { height: 70, width: 430});
    function myFunction() {
        var data = CKEDITOR.instances.editor.getData();

    // alert(data)
    document.getElementById("demo").innerHTML = data;
    }
</script>

</body>
</html>
