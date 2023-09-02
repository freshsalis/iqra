<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=
    , initial-scale=1.0">
    <title>Exam Token | Test Master</title>
    <style>
        .card-container {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
}

.card {
  box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
  transition: 0.3s;
  width: calc(20% - 10px); /* adjust the width based on how many cards you want in a row */
  margin-bottom: 20px;
}

.container {
  padding: 2px 16px;
}
    </style>
</head>
<body>
<?php
include_once("asset/classes/db.php");
$con = pdo();

$unique_numbers = array();
$used_numbers = array();
$key =0;
$exam = $_POST['exam'];
$number = $_POST['number'];
$venue = strtoupper($_POST['venue']);

$stmt = $con->prepare('SELECT name FROM test WHERE test_id = :exam ');
    $stmt->bindParam(':exam', $exam);
    $stmt->execute();
    $count = $stmt->rowCount();

    if ($count>0) {
        $name = $stmt->fetchColumn();
        # code...
        while (count($unique_numbers) < $number) {
            $key++;
            $numbers = range(0, 6);
            shuffle($numbers);
            $pad = str_pad($key, 4, '0', STR_PAD_LEFT);
            $token = implode('', array_slice($numbers, 0, 10));
            $token = $token."".$pad;
            // Check if the token already exists in the database
            $stmt = $con->prepare('SELECT COUNT(*) FROM access_token WHERE token = :token AND exam_id=:exam');
            $stmt->bindParam(':token', $token);
            $stmt->bindParam(':exam', $exam);
            $stmt->execute();
            $count = $stmt->fetchColumn();
            // If the token already exists, generate a new unique token
            if ($count > 0) {
                continue;
            }
            $unique_numbers[] = $token;
        }
        
        $sn=0;
        echo '<div class="card-container">';
        $stmt = $con->prepare('INSERT INTO access_token (token,exam_id) VALUES (:token,:exam)');
        foreach ($unique_numbers as $token) {
            $sn++;
            $stmt->bindParam(':token', $token);
            $stmt->bindParam(':exam', $exam);
            $stmt->execute();
            echo '
                <div class="card">
                    <div class="container">
                        <p>EXAM TOKEN ('.$name.')</p>
                        <h3><b> '.$token.'</b></h3> 
                        <p><small>'.$venue.'</small></p>
                    </div>
                </div>
            ';
        }
        echo '</div>';
    }


?>
</body>
</html>
