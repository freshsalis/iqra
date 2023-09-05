<?php
require_once 'Admin/asset/classes/db.php';
date_default_timezone_set('Africa/Lagos');
 	 $test_id = $_GET['tid'];
 	$t1 = "SELECT * from test WHERE test_id='".$test_id."'";
 	$query = mysqli_query(conn(),$t1) or die(mysqli_error(conn()));
 	$row = mysqli_fetch_assoc($query);
	$num_quest = $row['question_per_stud'];
 	 $testname = $row['name']."";
    $filename = str_replace(" ", "_", $testname)." individual score".date('Y');         //File Name


	//querying the database   
	$Q = 'SELECT reg_no,stdid FROM schedule_student 
                
                WHERE test_id = '.$test_id.'';
		$result=mysqli_query(conn(),$Q) or die(mysqli_error(conn()));
	

	echo'
		<table border="1">
			<thead>
				<tr>
					<th>SN</th>
					<th>REG.NO</th>
				
	';

	
		
		for ($i=1; $i <= $num_quest; $i++) { 
			echo "<td>Q".$i."</td>";
		}
		echo '</tr>
		</thead><tbody>';
	
		$sn = 0;
	    while($row = mysqli_fetch_assoc($result))
	    {
	    	$sn++;
	        echo "<tr><td>".$sn."</td>";
			$regno = $row['reg_no'];
			$stdid = $row['stdid'];
	        
			echo "<td>".$regno."</td>";
			$s1 = "SELECT * FROM question q INNER JOIN sub_question s
                ON q.question_id = s.question_id
                WHERE s.stud_id = '$stdid' AND q.test_id = '$test_id' limit $num_quest";
                $q1 = mysqli_query(conn(), $s1) or die(mysqli_error(conn()));            
                    while ($row2 = mysqli_fetch_assoc($q1)) {
						$qid = $row2['question_id'];
						$answer = $row2['answer'];
						//check answer
						$s2 = "SELECT * FROM test_attempt 
						
						WHERE stdid = '$stdid' AND quid = '$qid'";
						$q2 = mysqli_query(conn(), $s2) or die(mysqli_error(conn()));
						if(mysqli_num_rows($q2)>0){
							$row3 = mysqli_fetch_assoc($q2);
							$attempted = $row3['ans'];
							if ($answer == $attempted) {
								$r .= "<td>1</td>";
							}else{
								$r .= "<td>0</td>";
							}
						}else{
							$r .= "<td>0</td>";
						}
					}
			$r .="</tr>";

	        
	    }
		$r .="</tbody></table>";
	   echo $r;

		
?>