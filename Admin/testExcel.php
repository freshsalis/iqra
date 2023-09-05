<?php
 	require 'admin/conn.php';
 	$test_id = $_GET['tid'];
 	$testnamequery = mysql_query("SELECT name from test WHERE test_id='".$test_id."'") or die(mysql_error());
 	$testname = mysql_fetch_assoc($testnamequery)['name']."";
 	$filename = str_replace(" ", "_", $testname)."Result_".date('Y');         //File Name   

	//querying the database   
	$Q = 'SELECT student.fullname,student.username,testscore.right_answered FROM testscore
                INNER JOIN student
                INNER JOIN test
                ON testscore.stdid = student.stdid
                AND testscore.testid = test.test_id
                WHERE testscore.testid = '.$test_id.'';
		$result=mysql_query($Q);
	
	$file_ending = "xls";

	//header info for browser
	header("Content-Type: application/xls");    
	header("Content-Disposition: attachment; filename=$filename.xls");  
	header("Pragma: no-cache"); 
	header("Expires: 0");

	/*******Start of Formatting for Excel*******/   
	//define separator (defines columns in excel & tabs in word)
		$sep = "\t"; //tabbed character
	//start of printing column Headers
		echo "SN \t";
		echo "Fullname \t";
		echo "Username \t";
		echo "Scores \t";
		print("\n");    
	//end of printing column names 

	//start while loop to get data
		$sn = 0;
	    while($row = mysql_fetch_row($result))
	    {
	    	$sn++;
	        $schema_insert = "";
	        echo $sn.$sep;
	        for($j=0; $j<mysql_num_fields($result);$j++)
	        {
	            if(!isset($row[$j]))
	                $schema_insert .= "NULL".$sep;
	            elseif ($row[$j] != ""){
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