<?php
/**
 * Created by PhpStorm.
 * User: freshsalis
 * Date: 11/3/2017
 * Time: 7:51 AM
 */
session_start();
session_destroy();
header('Location:adminLogin.php');