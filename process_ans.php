<?php
require_once 'Admin/asset/classes/db.php';
date_default_timezone_set('Africa/lagos');
session_start();
	$testid=$_POST['paper'];
	$stdid =$_POST['std'];
	$instant =$_POST['insta'];

    $right_answer=0;
    $wrong_answer=0;
    $unanswered=0;

    $sql="select * from question q,sub_question sub WHERE sub.paper_id='".$testid."' and q.question_id=sub.question_id AND sub.stud_id='".$stdid."'";
    $response=mysqli_query(conn(), $sql) or die(mysqli_error(conn()));
    $i=1;
    $num = mysqli_num_rows($response);

    while($result=mysqli_fetch_array($response)){
        $qid = $result['question_id'];
        $answer=$result['answer'];
        // select and check answer
        $sql2="select * from test_attempt  WHERE quid='".$qid."' AND stdid='".$stdid."'";
        $response2=mysqli_query(conn(), $sql2) or die(mysqli_error(conn()));
        $num2 = mysqli_num_rows($response2);

        if($num2 == 0){
            $unanswered++;
        }else {
            while ($result2 = mysqli_fetch_array($response2)) {
                $ans = $result2['ans'];
                if ($answer == $ans){
                    $right_answer++;
                }
                else
                    $wrong_answer++;
            }
        }
    }

    // if student already written d test update his scores
    $time = date('Y-m-d h:i:s');
    $sel = 'SELECT * FROM testscore WHERE stdid="'.$stdid.'" AND paper_id="'.$testid.'"';
    $check = mysqli_query(conn(), $sel) or die(mysqli_error(conn()));
    $r ='';
    if(mysqli_num_rows($check)>0){
        $s = "UPDATE testscore SET right_answered='".$right_answer."',
            wrong_answer='".$wrong_answer."',unanswered='".$unanswered."',date_time='".$time."' WHERE stdid='".$stdid."'";
        $sql = mysqli_query(conn(), $s) or die(mysqli_error(conn()));
        $r .= "<div class='jumbotron'>
                <h4>Your score!</h4>
                <div class=''>Right Answer: ".$right_answer."</div>
                <div>Wrong Answer: ".$wrong_answer."</div>
                <div>Unanswered Answer: ".$unanswered."</div>
                <h4>Total scores: $right_answer/".($right_answer+$wrong_answer+$unanswered)."</h4>
                <a href='logout.php' class='pull-right btn btn-success' id='tryAgain' >Close <span class='glyphicon glyphicon-log-out'></span></a>
            </div>
        ";
    }
    //else insert his scores into the db
    else {
        $s = "INSERT INTO testscore(stdid,paper_id,right_answered,wrong_answer,unanswered,date_time)
                    values('" . $stdid . "','" . $testid . "','" . $right_answer . "',
                    '" . $wrong_answer . "','" . $unanswered . "','".$time."'
                    )";
        $sql = mysqli_query(conn(), $s) or die(mysqli_error(conn()));
        if ($sql) {
            $r .= "<div class='jumbotron'>
                <h4>Your score!</h4>
                <div class=''>Right Answer: ".$right_answer."</div>
                <div>Wrong Answer: ".$wrong_answer."</div>
                <div>Unanswered Answer: ".$unanswered."</div>
                <h4>Total scores: $right_answer/".($right_answer+$wrong_answer+$unanswered)."</h4>
                <a href='logout.php' class='pull-right btn btn-success' id='tryAgain' >Close <span class='glyphicon glyphicon-log-out'></span></a>
            </div>
        "; // scores inserted successfully
        }
        else $r .= "<div class='jumbotron'>
                    <h3 class='text-danger'>Error, please contact admin</h3>
                 </div>
        "; // couldn't insert
    }
    if($instant ==1){
        echo $r;
    }else{
        echo "<br><br>
            <div class='jumbotron'>
                    <h3 class='text-info'><b>Your exam was submitted successfully. Kindly leave the exam hall quitely.</b></h3>
                                    <a href='logout.php' class='pull-right btn btn-success' id='tryAgain' >Close <span class='glyphicon glyphicon-log-out'></span></a>
                 </div>
        ";
    }
    mysqli_close(conn());
    session_destroy();