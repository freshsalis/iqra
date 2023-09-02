<?php
/*##############################################################################
	Designed by: YUSUF SALISU BAKO
	Author	: Fresh salis
	Year 	:2016
##############################################################################*/

    include '../classes/_Class.php';
    include '../classes/Student.php';
    include '../classes/Test.php';
    include '../classes/Question.php';

    $class = new _Class();
    $student = new Student();
    $test = new Test();
    $question = new Question();


    $dt =$_POST['dt'];
        switch ($dt){
            case 'editTest':
                $test -> editTest();
                break;

            case 'editClass':
                $class ->editClass();
                break;

            case 'editStudent':
                $student ->editStudent();
                break;
            case 'unlock':
                $student ->unlockStudent();
                break;
            case 'unlock_all':
                $student ->unlockAllStudent();
                    break;

            case 'editQuestion':
                $question ->editQuestion();
                break;

        }

?>