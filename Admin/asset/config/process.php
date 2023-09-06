<?php
/*##############################################################################
	Designed by: YUSUF SALISU BAKO
	Author	: Fresh salis
	Year 	:2016
##############################################################################*/
include '../classes/_Class.php';
include '../classes/Student.php';
include '../classes/Question.php';
include '../classes/User.php';
include '../classes/Test.php';


$time = date('d/m/Y');
$converted = strtotime($time);
if($converted < strtotime('6/6/2025')){
    $did = $_POST['id'];
    $data = $_POST['data'];

    $class = new _Class();
    $student = new Student();
    $question = new Question();
    $user = new User();
    $test = new Test();


    session_start();
    // echo $did;
    switch($did){
        /*####################### add segment ####################################*/
        case "add":
            switch($data){
                case "class":
                    $class ->addClass();
                    break;
                case "student":
                    $student ->addStudent();
                    break;
                case "test":
                    $test ->addTest();
                    break;
                case "Question":
                    $question ->addQuestion();
                    break;
                case "paper":
                    $test ->addPaper();
                    break;
                case "examiner":
                    $test ->addExaminer();
                    break;
                case "exam":
                    $test ->addExam();
                    break;
            }
            break;
        /*####################### edit segment ####################################*/
        case "edit":
            switch($data){
                case "editClass":
                    echo $class ->getEdit();
                    break;
                case "editStudent":
                    echo $student ->getEditStudent();
                    break;
                case "editTest":
                    // echo 'hello';
                    echo $test->getEditTest();
                    break;
                case "editQuestion":
                    echo $question ->getEditQuestion();
                    break;
                case "editPaper":
                    echo $test ->getEditPaper();
                    break;
                case "editExam":
                    echo $test ->getEditExam();
                    break;
            }

            break;
        /*####################### delete segment ####################################*/
        case "delete":
            break;
        case 'optionClick':
            $student->optionClick();
            break;
        case 'trackTimer':
            $student ->trackTimer();
            break;
        case "changePassword":
            $user->changePassword();
            break;
        case "batch_del_student":
            $batch = clean($_POST['batch']);
            $test = clean($_POST['test']);
            $password = clean($_POST['password']);
            $user = $_SESSION['aUser'];
            $response = $student->deleteBatchStudent($user,$password,$test,$batch);
            if ($response == 1) {
                echo json_encode(array('response_status' => 'success', 'message' => "Request successcfully processed.",'code'=>$response)); 
                return http_response_code(200);
            }else{
                echo json_encode(array('response_status' => 'error', 'message' => "Invalid password.",'code'=>$response)); 
                return http_response_code(200);
            }
            break;
        case "all_del_question":
            $test = clean($_POST['test']);
            $password = clean($_POST['password']);
            $type = clean($_POST['type']);
            $user = $_SESSION['aUser'];
            $response = $question->deleteAllQuestions($user,$password,$test,$type);
            if ($response == 1) {
                echo json_encode(array('response_status' => 'success', 'message' => "Request successcfully processed.",'code'=>$response)); 
                return http_response_code(200);
            }else{
                echo json_encode(array('response_status' => 'error', 'message' => "Invalid password.",'code'=>$response)); 
                return http_response_code(200);
            }
            break;
        case "reset_exam":
            $rel = $_POST['rel'];
            $level = $_POST['level'];
            $batch = $_POST['batch'];
            $password = clean($_POST['password']);
            $user = $_SESSION['aUser'];
            $response = $test->resetExam($user,$password,$rel,$level,$batch);
            if ($response == 1) {
                echo json_encode(array('response_status' => 'success', 'message' => "Exam successcfully reset.",'code'=>$response)); 
                return http_response_code(200);
            }else{
                echo json_encode(array('response_status' => 'error', 'message' => "Invalid password.",'code'=>$response)); 
                return http_response_code(200);
            }
            
            break;
        case "software_reset":
            $password = clean($_POST['password']);
            $user = $_SESSION['aUser'];
            $response = $test->resetSoftware($user,$password);
            if ($response == 1) {
                echo json_encode(array('response_status' => 'success', 'message' => "Software successcfully reset to default settings.",'code'=>$response)); 
                return http_response_code(200);
            }else{
                echo json_encode(array('response_status' => 'error', 'message' => "Invalid password.",'code'=>$response)); 
                return http_response_code(200);
            }
            break;
        
    }

}else{
    echo "ERROR, Contact Administrator";
}





?>