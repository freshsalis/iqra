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



    $regno = clean($_POST['regno']);
    $paper = clean($_POST['paper']);

    $class = new _Class();
    $student = new Student();
    $question = new Question();
    $user = new User();
    $test = new Test();

    echo $student->searchStudent($paper,$regno);








?>