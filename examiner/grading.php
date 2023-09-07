<?php
/**
 * Created by PhpStorm.
 * User: freshsalis
 * Date: 12/15/2017
 * Time: 2:15 PM
 */
session_start();
require_once '../Admin/asset/classes/Student.php';
require_once '../Admin/asset/classes/Test.php';
require_once '../Admin/asset/classes/db.php';
$student = new Student();
if (!$_SESSION['examinerId']){
    header('location:index.php');
}

$examiner_id = $_SESSION['examinerId'];
$examiner_id = $_SESSION['examinerId'];

$paper = clean($_GET['p']);

        

        
//  check paper
$sql_check = "select * FROM papers WHERE sha1(paper_id)='".$paper."'";
$query_check = mysqli_query(conn(), $sql_check) or die(mysqli_error(conn()));

$numrows=mysqli_num_rows($query_check);

// die($numrows);
if($numrows > 0){
    $fetch1 = mysqli_fetch_assoc($query_check);
    $paper_id = $fetch1['paper_id'];
    $paper_name= $fetch1['name'];
    $num_quest = $fetch1['question_per_stud'];
    $duration = $fetch1['time'];
}


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Test Master | Examiner</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <link href="../Admin/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    
    <link href="../Admin/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <link href="../Admin/dist/css/style.css" rel="stylesheet" type="text/css" />


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <link
      rel="shortcut icon"
      type="image/x-icon"
      href="./logo.png"
    />
    <style>
        @keyframes blink {
            0% { opacity: 1; }
            50% { opacity: 0; }
            100% { opacity: 1; }
        }

        .blinking {
            animation: blink 1s infinite;
        }
    </style>
</head>
<body class="login-page">
<!-- <img src="../images/ba.jpg" class="img-responsive logo-img" width="100%" height="5%"/> -->


<div class="row text-center">
    <!-- /.login-logo -->
    <h2>Examiner's Grading Page</h2>

    <div class="container-fluid">
   
        <div class="login-box-body col-md-3" style="margin-left: 10px;">

            <div class="panel panel-success cbtlogin" >
                <div class="panel-body ">
                    <div class="col-md-12 text-justify">
                        <div>
                            <h3 class="rapi text-center"><strong> <?php  echo $_SESSION['exam'] ?>  </strong></h3>

                            <div class="table col-md-12">

                                        <?php //echo $student->signAttendance($_SESSION['stdid'],$_SESSION['test_id']); ?>

                                        <p>Welcome  <b><?php echo $_SESSION['name']; ?> (<?php echo $_SESSION['username']; ?>) </b>. 
                                                <li>This is your dashboard for grading CAOSCE exam.</li>
                                            </ul>
                                        </p>
                                    
                            </div>
                        </div> 
                        <!-- <button type="button" class="btn btn-success btn-block" onClick=window.location='./?testid=<?php echo sha1($_SESSION['test_id']) ?>'>Start Exam</button> -->
                        <?php
                            $test = new Test();
                            echo $test->getCaoscePaperMenu($examiner_id,"./grading.php",$paper_id,$examiner_id);
                            ?>
                    </div>
                    <br>
                <a href="./logout.php" class="btn btn-danger">Logout</a>

                </div>
            </div>
        </div>
        <div class="login-box-body col-md-8" style="min-height: 500px;margin-left:2px;">

            <div class="panel panel-success cbtlogin" >
                <div class="panel-body ">
                    <div class="col-md-12 text-center" style="min-height: 400px;">
                       <h3> <?php echo $paper_name?></h3>
                       <form action="" id="grading-form" method="post">
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="input-group">
                                        <span class="input-group-addon">Student's Matric No.</span>
                                        <input type="text" value="" name="regno" id="regno" class="form-control" placeholder="">
                                        <input type="hidden" value="<?php echo $paper_id ?>" name="paper" id="paper" class="form-control" placeholder="">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                <div class="input-group">
                                        <input type="submit" value="Search" name="search2" id="search2" class="btn btn-primary" placeholder="">
                                    </div>
                                </div>
                            </div>
                            
                            <br/>
                            <div id="status">
                                <?php 
                                    if (isset($_POST['search2'])) {
                                        echo $student->searchStudent(clean($_POST['paper']), clean($_POST['regno']));
                                    }
                                ?>
                            </div>
                       </form>
                    </div>

                </div>
        </div>
        </div>
    </div>
        <!-- /.login-box-body -->
</div><!-- /.login-box -->



<!-- jQuery 2.1.3 -->
<script src="../Admin/plugins/jquery/jQuery-2.1.3.min.js"></script>
<!-- Bootstrap 3.3.2 JS -->
<script src="../Admin/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="../Admin/dist/js/myjquery.js" type="text/javascript"></script>
<!-- iCheck -->
<script>
    
    $(document).ready(function (e) {
          const a = $(document).find('#aid').val();

         setInterval(function() {
            countdown2(a);
        }, 1000)
            

            var storedTime = JSON.parse(localStorage.getItem(a));
            // console.log(storedTime);
            $('.min').html(padZero(storedTime.min));
            $('.sec').html(padZero(storedTime.sec));
           
            
        })
    
</script>
</body>
</html>
