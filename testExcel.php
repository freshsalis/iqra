<?php
require_once 'Admin/asset/classes/db.php';
require_once 'Admin/asset/classes/Question.php';
 	$test_id = clean($_GET['tid']);
	$paper = clean($_GET['paper']);
 	


	//querying the database   
	if ($paper === 'all') {
		$question = new Question();
            // echo $batch;die();
			$t1 = "SELECT * from exam WHERE exam_id='".$test_id."'";
			$query = mysqli_query(conn(),$t1) or die(mysqli_error(conn()));
			$row = mysqli_fetch_assoc($query);
			$testname = $row['name']."";
   			$filename = str_replace(" ", "_", $testname)."Result_".date('Y');         //File Name

            $colNames = [];
            $colIds = [];

			$file_ending = "xls";

			header("Content-Type: application/xls, charset=utf-8");    
			header("Content-Disposition: attachment; filename=".$filename.".xls");  
			header("Pragma: no-cache"); 
			header("Expires: 0");

			/*******Start of Formatting for Excel*******/   
			//define separator (defines columns in excel & tabs in word)
			$sep = "\t"; //tabbed character
			//start of printing column Headers
			echo "SN \t";
			echo "FULL NAME \t";
			echo "MATRIC NO. \t";
		
            
                //    get table header
                $sql_headers= "select p.*,e.name as examName FROM papers p INNER JOIN exam e ON e.exam_id=p.exam_id WHERE p.exam_id='".$test_id."'";
                $query_headers = mysqli_query(conn(), $sql_headers) or die(mysqli_error(conn()));

                $numrows=mysqli_num_rows($query_headers);
                $examName = "";
                
                // die($numrows);
                if($numrows > 0){
                    while ($row = mysqli_fetch_assoc($query_headers)) {
                        $colNames[] = $row['name'];
                        $colIds[] = $row['paper_id'];
                        $examName = $row['examName'];
                    }
                }

                

                for ($i=0; $i <  count($colIds); $i++) { 
                    echo $colNames[$i]."\t";
                }

                echo "Cumm. Score";
				print("\n");

               $sep ="\t";

            $Q = ' SELECT *
                FROM schedule_student s
                WHERE exam_id = "'.$test_id.'" ORDER BY reg_no';

                $q1 = mysqli_query(conn(), $Q) or die(mysqli_error(conn()));

                $sn = 0;
                if (mysqli_num_rows($q1) >0) {

                    while ($row = mysqli_fetch_assoc($q1)) {
                        $sn++;

					
					$schema_insert = "";
					$stdname = $row['surname']." ".$row['othername'];
					$regno = $row['reg_no'];
					$user_id = $row['stdid'];
                        // $test_id = $row['test_id'];
                        $total = 0;
                        $schema_insert .= $sn."\t";
                        $schema_insert .= $stdname."\t";
                        $schema_insert .= $regno."\t";
                        for ($i=0; $i <  count($colIds); $i++) { 
                            $score = $question->studentPaperResult($user_id,$colIds[$i]);
                            $total +=$score;
                            $schema_insert .= $score."\t";
                        }
                        $schema_insert .= $total."\t";

						$schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
						$schema_insert .= "\t";
						print(trim($schema_insert));
						print "\n";

                    }
                   
                }
				        	
	}else{

		$t1 = "SELECT * from papers WHERE paper_id='".$paper."'";
		$query = mysqli_query(conn(),$t1) or die(mysqli_error(conn()));
		$row = mysqli_fetch_assoc($query);
		$testname = $row['name']."";
		$type = $row['paper_type_id'];
		$filename = str_replace(" ", "_", $testname)."Result_".date('Y');         //File Name

		$Q = 'SELECT t.*,s.*,e.name as examName,p.name as paperName,question_per_stud
		FROM testscore t
		INNER JOIN schedule_student s ON s.stdid=t.stdid
		INNER JOIN papers p ON p.paper_id = t.paper_id
		INNER JOIN exam e  ON e.exam_id = p.exam_id
		WHERE t.paper_id = "'.$paper.'" ORDER BY reg_no';
	
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
				echo "PAPER NAME \t";
				echo "EXAM NAME \t";
				echo "SCORES \t";
				echo "OUT OF \t";
				print("\n");
			//end of printing column names 

			//start while loop to get data
				$sn = 0;
				while($row = mysqli_fetch_assoc($result))
				{
					$sn++;

					
					echo $sn.$sep;
					$schema_insert = "";
					$schema_insert .=$row['reg_no'].$sep;
					$schema_insert .= $row['surname']." ".$row['othername'].$sep;
					$schema_insert .=$row['dept'].$sep;
					$schema_insert .=$row['paperName'].$sep;
					$schema_insert .=$row['examName'].$sep;
					$schema_insert .=$row['right_answered'].$sep;
					$schema_insert .=$row['question_per_stud'].$sep;
					
					
					$schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
					$schema_insert .= "\t";
					print(trim($schema_insert));
					print "\n";
				}
	}
?>
