<?php
/**
 * Created by PhpStorm.
 * User: freshsalis
 * Date: 1/8/2018
 * Time: 9:21 AM
 */

define('HOSTNAME','localhost');
define('DB_USERNAME','root');
define('DB_PASSWORD','');
define('DB_NAME', 'test_master');

//global $con;
$con = mysqli_connect(HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_NAME) or die ("error");
// Check connection
if(mysqli_connect_errno($con))	die("Failed to connect MySQL: " .mysqli_connect_error());

function conn(){
    global $con;
    $v = $con;
    return $v;
}

function clean($data)
{
    $result = mysqli_real_escape_string(conn(),trim($data));
    return $result;
}

function pdo()
{
    $dsn = 'mysql:host=localhost;dbname='.DB_NAME;
    $options = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    );
   return new PDO($dsn, DB_USERNAME, DB_PASSWORD, $options);

}

