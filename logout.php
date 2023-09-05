<?php
/**
 * Created by PhpStorm.
 * User: freshsalis
 * Date: 11/3/2017
 * Time: 7:51 AM
 */
session_start();
include_once('Admin/asset/classes/Student.php');
//$student = new Student();
//$id = $_SESSION['stdid'];
//$test = $_SESSION['test_id'];
//$student->signOutAttendance($id,$test);
session_destroy();
header('Location:login.php');
