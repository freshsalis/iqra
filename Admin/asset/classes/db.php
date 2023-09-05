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
define('DB_NAME', 'iqra');

// $key = openssl_random_pseudo_bytes(32); // 256-bit key (32 bytes)
// $iv = openssl_random_pseudo_bytes(16); // 128-bit IV (16 bytes)
define('ENCRYPTION_KEY', openssl_random_pseudo_bytes(32));
define('ENCRYPTION_IV', openssl_random_pseudo_bytes(16));

//global $con;
$con = mysqli_connect(HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_NAME) or die ("error");
// Check connection
if(mysqli_connect_errno())	die("Failed to connect MySQL: " .mysqli_connect_error());

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

function encryptData($data) {
    $key ="sabilab";

    $plaintext = "message to be encrypted";
    //$key previously generated safely, ie: openssl_random_pseudo_bytes
    $plaintext = "message to be encrypted";
    $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
    $iv = openssl_random_pseudo_bytes($ivlen);
    $ciphertext_raw = openssl_encrypt($data, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
    $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
    $ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );

    return $ciphertext;
 
}

function decryptData($ciphertext) {
    $key ="sabilab";
    $c = base64_decode($ciphertext);
    $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
    $iv = substr($c, 0, $ivlen);
    $hmac = substr($c, $ivlen, $sha2len=32);
    $ciphertext_raw = substr($c, $ivlen+$sha2len);
    $original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
    $calcmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
    if (hash_equals($hmac, $calcmac))// timing attack safe comparison
    {
        return $original_plaintext;
    }

}

