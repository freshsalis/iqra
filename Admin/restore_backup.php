<?php 
    

    $conn = mysqli_connect("localhost", "root", "", "test_master");
    if (!empty($_FILES)) {

        // Validating SQL file type by extensions
        if (!in_array(strtolower(pathinfo($_FILES["backup_file"]["name"], PATHINFO_EXTENSION)), array(
            "sql"
        ))) {
            $response = array(
                "type" => "error",
                "message" => "Invalid File Type"
            );
        } else {
            if (is_uploaded_file($_FILES["backup_file"]["tmp_name"])) {
                $folder ="./backups";
                move_uploaded_file($_FILES["backup_file"]["tmp_name"], $folder.$_FILES["backup_file"]["name"]);
                // DROP TABLES IF EXIST
                $sql = "DROP TABLE IF EXISTS admin,access_token,attendance,class,question,question_type,schedule_student,student,sub_question,test,testscore,test_attempt,track_timer";
                mysqli_query($conn, $sql) or die(mysqli_error(conn()));
                $response = restoreMysqlDB($folder.$_FILES["backup_file"]["name"], $conn);
    
                echo "<h3>Backup status: ".$response['type']."</h3>";
                echo "<h3>Message: ".$response['message']."</h3>";
            }
        }
    }

function restoreMysqlDB($filePath, $conn)
{
    $sql = '';
    $error = '';
    
    if (file_exists($filePath)) {
        $lines = file($filePath);
       
        
        foreach ($lines as $line) {
            
            // Ignoring comments from the SQL script
            if (substr($line, 0, 2) == '--' || $line == '') {
                continue;
            }
            
            $sql .= $line;
            
            if (substr(trim($line), - 1, 1) == ';') {
                $result = mysqli_query($conn, $sql);
                if (! $result) {
                    $error .= mysqli_error($conn) . "\n";
                }
                $sql = '';
            }
        } // end foreach
        
        if ($error) {
            $response = array(
                "type" => "error",
                "message" => $error
            );
        } else {
            $response = array(
                "type" => "success",
                "message" => "Database Restore Completed Successfully."
            );
        }
    } // end if file exists
    return $response;
}