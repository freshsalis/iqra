<?php
include '../classes/_Class.php';
include '../classes/Student.php';
include '../classes/Test.php';
include '../classes/Question.php';
$class = new _Class();
$student = new Student();
$test = new Test();
$question = new Question();

    $table = $_POST['table'];
    $idm = $_POST['idm'];

    if($table =='test'){
        $test ->delete($idm);
    }
    elseif ($table =='class'){
        $class ->delete($idm);
    }
    elseif ($table =='paper'){
        $test ->deletePaper($idm);
    }
    elseif ($table =='exam'){
        $test ->deleteExam($idm);
    }
    elseif ($table =='examiner'){
        $test ->deleteExaminer($idm);
    }
    elseif ($table =='student'){
        $student ->delete($idm);
    }

    elseif ($table =='question'){
        $question ->delete($idm);
    }




?>