<?php
require_once 'Admin/asset/classes/db.php';
 	$test_id = $_GET['tid'];
 	$t1 = "SELECT * from test WHERE test_id='".$test_id."'";
 	$query = mysqli_query(conn(),$t1) or die(mysqli_error(conn()));
 	$row = mysqli_fetch_assoc($query);
 	 $testname = $row['name']."";
    $filename = str_replace(" ", "_", $testname)."Result_analysis_".date('Y');         //File Name


	//querying the database   
		# code...
		$Q = 'SELECT schedule_student.surname,schedule_student.othername,schedule_student.dept,
				schedule_student.reg_no,test.name,testscore.right_answered,wrong_answer,unanswered,
				test.question_per_stud,a.time_in,testscore.date_time,earnable_score ,
				test.time AS ttime,weight,tr.time AS spent,ip_address
				FROM testscore
                INNER JOIN schedule_student ON schedule_student.stdid = testscore.stdid
				INNER JOIN attendance a ON a.stdid = schedule_student.stdid
                INNER JOIN test ON test.test_id = schedule_student.test_id
				JOIN track_timer as tr ON tr.stdid = schedule_student.stdid 
                WHERE testscore.testid = "'.$test_id.'" AND test.test_id = "'.$test_id.'" ORDER BY reg_no';		
	
	$result=mysqli_query(conn(),$Q) or die(mysqli_error(conn()));
	
	
	$file_ending = "xls";

	//header info for browser
	header("Content-Type: application/xls, charset=utf-8");    
	header("Content-Disposition: attachment; filename=".$filename.".xls");  
	header("Pragma: no-cache"); 
	header("Expires: 0");

	/*******Start of Formatting for Excel*******/   
	//define separator (defines columns in excel & tabs in word)
		$sep = "\t"; //tabbed character
	//start of printing column Headers
		echo "SN \t";
		echo "MATRIC NO. \t";
		echo "FULL NAME \t";
		echo "PROGRAM \t";
		echo "EXAM NAME \t";
		echo "RIGHT ANSWER \t";
		echo "WRONG ANSWER \t";
		echo "UNANSWERED \t";
		echo "OUT OF \t";
		echo "WEIGHT \t";
		echo "SCORES \t";
		echo "STARTED AT \t";
		echo "SUBMITTED AT \t";
		echo "MINUTES SPENT \t";
		echo "MACHINE NAME \t";
		print("\n");
	//end of printing column names 

	//start while loop to get data
		$sn = 0;
	    while($row = mysqli_fetch_assoc($result))
	    {
	    	$sn++;
			$time = $row['ttime'];
			$spent = $row['spent'];

			$time_diff = round(($time-$spent)/60);
			if(($time_diff+3) < round($time/60)){
				$time_diff = $time_diff+3;
			}
			$fullname = str_replace(","," ",$row['surname']." ".$row['othername']);
	        $schema_insert = "";
	        echo $sn.$sep;
	        $schema_insert = "";
			$schema_insert .=$row['reg_no'].$sep;
			$schema_insert .= $fullname.$sep;
			$schema_insert .=$row['dept'].$sep;
			$schema_insert .=$testname.$sep;
			$schema_insert .=$row['right_answered'].$sep;
			$schema_insert .=$row['wrong_answer'].$sep;
			$schema_insert .=$row['unanswered'].$sep;
			$schema_insert .=$row['question_per_stud'].$sep;
			$schema_insert .=$row['weight'].$sep;
			$schema_insert .=$row['right_answered']*$row['weight'].$sep;
			$schema_insert .=$row['time_in'].$sep;
			$schema_insert .=$row['date_time'].$sep;
			$schema_insert .=$time_diff.$sep;
			$schema_insert .=$row['ip_address'].$sep;
			
	        
	        $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
	        $schema_insert .= "\t";
	        print(trim($schema_insert));
	        print "\n";
	    }

?>
