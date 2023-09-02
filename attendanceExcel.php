<?php
require_once 'Admin/asset/classes/db.php';
date_default_timezone_set('Africa/Lagos');
 	 $test_id = $_GET['tid'];
	  $batch = $_GET['batch'];
 	$t1 = "SELECT * from test WHERE test_id='".$test_id."'";
 	$query = mysqli_query(conn(),$t1) or die(mysqli_error(conn()));
 	$row = mysqli_fetch_assoc($query);
 	 $testname = $row['name']."";
    $filename = str_replace(" ", "_", $testname)." attendance (Batch_".$batch.") as at ".date('d-m-Y, h_i a');         //File Name


	//querying the database  
	if ($batch ==='all') {
		$Q = 'SELECT schedule_student.surname,schedule_student.othername,schedule_student.dept,
			schedule_student.reg_no,test.name,
			a.time_in,a.time_out,
			ip_address
			FROM  schedule_student
			INNER JOIN attendance a ON a.stdid = schedule_student.stdid
			INNER JOIN test
			ON a.stdid = schedule_student.stdid
			AND a.test_id = test.test_id
			WHERE test.test_id="'.$test_id.'" ORDER BY reg_no';
	} else{
	$Q = 'SELECT schedule_student.surname,schedule_student.othername,schedule_student.dept,
				schedule_student.reg_no,test.name,
				a.time_in,a.time_out,
				ip_address
				FROM  schedule_student
				INNER JOIN attendance a ON a.stdid = schedule_student.stdid
                INNER JOIN test
                ON a.stdid = schedule_student.stdid
                AND a.test_id = test.test_id
                WHERE test.test_id = '.$test_id.' AND batch="'.$batch.'" ORDER BY reg_no';
	}
		$result=mysqli_query(conn(),$Q) or die(mysqli_error(conn()));
	
	$file_ending = "xls";

	//header info for browser
	// header('');
	header("Content-Type: application/xls, charset=utf-8");    
	header("Content-Disposition: attachment; filename=$filename.xls");  
	header("Pragma: no-cache"); 
	header("Expires: 0");

	/*******Start of Formatting for Excel*******/   
	//define separator (defines columns in excel & tabs in word)
		$sep = "\t"; //tabbed character
	//start of printing column Headers
		echo "SN \t";
		echo "FULL NAME \t";
		echo "PROGRAM \t";
		echo "MATRIC NO. \t";
		echo "TEST \t";
		echo "TIME IN \t";
		echo "TIME OUT \t";
		echo "MACHINE NAME \t";
		print("\n");
	//end of printing column names 

	//start while loop to get data
		$sn = 0;
	    while($row = mysqli_fetch_row($result))
	    {
	    	$sn++;
	        $schema_insert = "";
	        echo $sn.$sep;
	        for($j=0; $j<mysqli_num_fields($result);$j++)
	        {
	            if(!isset($row[$j]))
	                $schema_insert .= "NULL".$sep;
	            elseif ($row[$j] != ""){
                    if($j==0){
                        $schema_insert .="$row[$j] $row[1]".$sep;
                        $j++;
                    }
                    else
                        $schema_insert .="$row[$j]".$sep;
	            }else
	                $schema_insert .= "".$sep;
	        }
	        $schema_insert = str_replace($sep."$", "", $schema_insert);
	        $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
	        $schema_insert .= "\t";
	        print(trim($schema_insert));
	        print "\n";
	    }

		
?>
