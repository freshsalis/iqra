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


// $r1="select * from sub_question WHERE sub_question.stud_id='".$stdid."' ";
// $response1= mysqli_query(conn(), $r1) or die(mysqli_error(conn()));
// $count = mysqli_num_rows($response1);


// if ($count ==0) {
//     // echo "empty";
//     $str = '';
//     $check_quest = 0;
//     for ($i=0; $i < count($_SESSION['minQ']); $i++) { 
//         $check_quest++;
//         $a = range($_SESSION['minQ'][$i],$_SESSION['maxQ'][$i]);
//         shuffle($a);
//         $limit = explode(',',$_SESSION['quest_per_sect']);
//         $hundred = array_slice($a,0,$limit[$i]+2);
//         shuffle($hundred);
//         $str .=implode(", ",$hundred);
//     }
//     if ($check_quest ==0) {
//         echo "<h2>No questions available.</h2>";
//         return;
//     }
    
//     $r0="INSERT INTO sub_question (question_id,stud_id,test_id)
//          SELECT question.question_id,'$stdid',question.test_id FROM question 
//          WHERE question.question_id IN ($str) AND test_id='$testid'  
//          order by FIELD(question.question_id,$str) 
//          LIMIT ".$num_quest."";

//         $response=mysqli_query(conn(), $r0) or die(mysqli_error(conn()));
        
// }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Test Master | Examiner</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <link href="../Admin/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <!-- <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" /> -->
    <!-- Theme style -->
    <link href="../Admin/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- iCheck -->

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
</head>
<body class="login-page">
<img src="../images/ba.jpg" class="img-responsive logo-img" width="100%" height="5%"/>


<div class="content-wrapper row text-center">
    <!-- /.login-logo -->
    <h2>Examiner's Grading Page</h2>
    <div class="login-logo">
    </div>
    <div class="login-box-body col-md-3 margin-4">

        <div class="panel panel-success cbtlogin" >
            <div class="panel-body ">
                <div class="col-md-12 text-justify">
                    <div>
                        <h3 class="rapi text-center"><strong> <?php  echo $_SESSION['exam']; ?>  </strong></h3>

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
                        echo $test->getCaoscePaperMenu($examiner_id,"./grading.php",$_GET['p'] ?? "",$examiner_id);
                        ?>
                </div>
                <br>
                <a href="./logout.php" class="btn btn-danger">Logout</a>

            </div>
        </div>
    </div>
    <div class="login-box-body col-md-7" style="min-height: 500px;margin-left:10px;">

        <div class="panel panel-success cbtlogin" >
            <div class="panel-body ">
                <div class="col-md-12 text-justify">
                   
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
    
    
    
</script>
</body>
</html>
