<?php

session_start();
require_once 'Admin/asset/classes/db.php';
//git test
if (isset($_POST['uname']) && isset($_POST['password'])){
    $name=clean($_POST['uname']);
    $pass= clean($_POST['password']);
    $test= clean($_POST['test']);
    $test_id =$test;
    //get max,min question_id
    $min_array = array();
    $max_array = array();
    $sql = "SELECT section,MAX(question_id) as maxQ,MIN(question_id) as minQ FROM `question`  WHERE test_id='".$test."' GROUP BY section ORDER BY section";
    $query = mysqli_query(conn(), $sql) or die(mysqli_error(conn()));
    while($fetch=mysqli_fetch_assoc($query)){
        $min_array[] = $fetch['minQ'];
        $max_array[] = $fetch['maxQ'];
    }
    $_SESSION['minQ'] = $min_array;
    $_SESSION['maxQ'] = $max_array;
    
    $sql = "SELECT * FROM schedule_student s INNER JOIN access_token a ON a.exam_id=test_id
              WHERE reg_no='".$name."' AND test_id='".$test."' 
                 AND ((token='$pass' AND  user_id=stdid) OR (token='$pass' AND  a.user_id IS NULL) )
               limit 1";
    $query = mysqli_query(conn(), $sql) or die(mysqli_error(conn()));

    
    
    if(mysqli_num_rows($query) >0){
        $fetch=mysqli_fetch_assoc($query);
        $_SESSION['test_id'] = $test_id;
        $_SESSION['stdid'] = $fetch['stdid'];
        $_SESSION['user']=$fetch['reg_no'];
        $_SESSION['name']=$fetch['surname']." ".$fetch['othername'];
        $_SESSION['dept']=$fetch['dept'];   
        
        $user_id = $fetch['user_id'];
        if (is_null($user_id)) {
            // empty token allocate 
            $token_id = $fetch['token_id'];
            $sql= "UPDATE  access_token SET user_id='".$fetch['stdid']."' WHERE token_id='".$token_id."'";
            $query = mysqli_query(conn(), $sql) or die(mysqli_error(conn()));
        }
        
        $sql2 = "SELECT * FROM testscore WHERE testscore.stdid='".$_SESSION['stdid']."' AND testid='".$test."'";
        $query2 = mysqli_query(conn(), $sql2) or die(mysqli_error(conn()));
        
        if(mysqli_num_rows($query2) >0){
            echo   1; //check if the user already taken the test
            return;
        }
        else {
            $sql3 = 'SELECT * FROM test WHERE test_id="'.$test.'" AND status="Active" limit 1';
            $query3 =mysqli_query(conn(), $sql3) or die(mysqli_error(conn()));


            $num_rows = mysqli_num_rows($query3);
            if($num_rows>0) {
                while($fetch=mysqli_fetch_assoc($query3)){
                    $_SESSION['test']=$fetch['name'];
                    $_SESSION['testid']=$fetch['test_id'];
                   // $_SESSION['fresh']=$fetch['classname'];
                    $_SESSION['limit']=$fetch['question_per_stud'];
                    $_SESSION['quest_per_sect']=$fetch['question_per_component'];
                    $_SESSION['duration']=$fetch['time'];
                    $_SESSION['instant']=$fetch['instant_result'];
                    $_SESSION['instruction']=$fetch['instruction'];
                    // $_SESSION['stdid']=$fetch['stdid'];
                }
                // check if already signed in on another system
                $sqlA = 'select * from attendance WHERE stdid="' . $_SESSION['stdid'] . '"    AND test_id="'.$_SESSION['testid'].'"';
                $qA = mysqli_query(conn(), $sqlA) or die(mysqli_error(conn()));
                if (mysqli_num_rows($qA) > 0) {
                    $fetchA=mysqli_fetch_assoc($qA);
                    if($fetchA['session_status'] ==1){
                        echo -1;
                        return;
                    }
                    // echo 0; //test already exist
                }
                echo 4; //can write
                return;
            }
            else{
                echo 5; //test selected is not for ur class/level
                return;

            }

        }
    }
    else{
        echo 2; //invalid username and password
        return;
    }
}else{
     echo 3; 	//empty username
     return;
}
mysqli_close(conn());
