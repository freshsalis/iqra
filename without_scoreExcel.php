<?php
require_once 'Admin/asset/classes/db.php';
date_default_timezone_set('Africa/Lagos');
	$test_id = $_GET['tid'];
	$batch = $_GET['batch'];
 	$t1 = "SELECT * from test WHERE test_id='".$test_id."'";
 	$query = mysqli_query(conn(),$t1) or die(mysqli_error(conn()));
 	$row = mysqli_fetch_assoc($query);
 	$testname = $row['name']."";
	$date = date('d.m.Y, h_i a');
    $filename = str_replace(" ", "_", $testname)." attendance without score_BATCH_".$batch;         //File Name


	//header info for browser
	header("Content-Type: application/xls, charset=utf-8");    
	header("Content-Disposition: attachment; filename=".$filename.".xls");  
	header("Pragma: no-cache"); 
	header("Expires: 0");

	//querying the database  
	if ($batch ==='all') {
	$sql = "SELECT *
			FROM schedule_student as s INNER JOIN test t ON t.test_id=s.test_id
			INNER JOIN attendance ON attendance.stdid=s.stdid 
			WHERE s.stdid NOT IN ( SELECT sb.stud_id from sub_question sb where sb.test_id = '".$test_id."')
			AND s.test_id = '".$test_id."'";
	}else{
	$sql = "SELECT *
			FROM schedule_student as s INNER JOIN test t ON t.test_id=s.test_id
			INNER JOIN attendance ON attendance.stdid=s.stdid 
			WHERE s.stdid NOT IN ( SELECT sb.stud_id from sub_question sb where sb.test_id = '".$test_id."')
			AND s.test_id = '".$test_id."' AND batch='".$batch."'";
	}
	$result=mysqli_query(conn(),$sql) or die(mysqli_error(conn()));
	// echo mysqli_num_rows($result);
	
	$file_ending = "xls";

	

	/*******Start of Formatting for Excel*******/   
	//define separator (defines columns in excel & tabs in word)
		$sep = "\t"; //tabbed character
	//start of printing column Headers
		echo "SN \t";
		echo "FULL NAME \t";
		echo "PROGRAM \t";
		echo "REG. NO. \t";
		echo "TEST \t";
		echo "TIME IN \t";
		echo "MACHINE IP ADDRESS \t";
		print("\n");
	//end of printing column names 

	//start while loop to get data
		$sn = 0;
	    while($row = mysqli_fetch_assoc($result))
	    {
	    	$sn++;
	        $schema_insert = "";
	        echo $sn.$sep;
			$schema_insert .= $row['surname']." ".$row['othername'].$sep;
			$schema_insert .=$row['dept'] !="" ? $row['dept'].$sep : "".$sep;
			$schema_insert .=$row['reg_no'].$sep;
			$schema_insert .=$testname.$sep;
			$schema_insert .=$row['time_in'].$sep;
			$schema_insert .=$row['ip_address'].$sep;
	        
	        $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
	        $schema_insert .= "\t";
	        print(trim($schema_insert));
	        print "\n";
	    }

		
?>