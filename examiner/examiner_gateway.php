<?php
	session_start();
require_once '../Admin/asset/classes/db.php';
		$name = clean($_POST['uname']);
		 $pass = clean($_POST['password']);

		$sql="select e.*,ex.name as examName from examiners  e INNER JOIN papers p ON e.paper_id=p.paper_id
				INNER JOIN exam ex  ON ex.exam_id=p.exam_id  where username='$name' and password='$pass'";
		$qry=mysqli_query(conn(), $sql) or die(mysqli_error(conn()));
		$numrows = mysqli_num_rows($qry);

		if ($numrows ==1){
			while($fetch=mysqli_fetch_array($qry)){

				$_SESSION['examinerId'] = $fetch['examiner_id'];
				$_SESSION['username'] = $fetch['username'];
				$_SESSION['name'] = $fetch['name'];
				$_SESSION['exam'] = $fetch['examName'];
				$_SESSION['pre'] = "examiner";
			}

			echo 4;
	 	}else{
	 	echo 2;
		}
		
?>