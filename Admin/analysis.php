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

    echo $user->getHeader();
?>

  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <?php echo $user ->getUserMenu($pre); ?>

        <!-- /.sidebar -->
    </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Analysis</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Chart</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
            <div class="col-md-2">
                <div class="box box-solid">
                    <?php
                        echo $test ->getTestMenu($idm,'analysis.php?id=');
                        ?>
                </div><!-- /. box -->
            </div><!-- /.col -->
            <div class="col-md-10">
                <div class="row card">
              
                    <div class="col-md-2"></div>

                    <div class="col-md-10 box box-solid">
                      <div class="row">
                        <?php
                          echo $question ->getAnalysisTable($idm);
                          ?>
                      </div>
                      <!-- /.card -->
                    </div>
              <!-- /.col -->
                </div>
            </div>
        </div>
        
        
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.1.0-pre
    </div>
    <strong>Copyright &copy; 2014-2020 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

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
