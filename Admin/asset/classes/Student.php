<?php
require_once 'db.php';
require_once '_Class.php';

/**
 * Created by PhpStorm.
 * User: freshsalis
 * Date: 8/21/2015
 * Time: 4:12 PM
 */
// error_reporting(E_ALL ^ E_DEPRECATED);
// date_timezone_set('Africa/Lagos');
date_default_timezone_set('Africa/Lagos');

class Student{

    private  $class;

    public function addStudent()
    {
        if ($_POST['surname'] !='' && $_POST['othername'] !='' && $_POST['dept']!='' && $_POST['username']!='' && $_POST['batch']!='') {

            $sname = clean($_POST['surname']);
            $oname = clean($_POST['othername']);
            $testid= clean($_POST['test_id']);
            $dept= clean($_POST['dept']);
            $regno= clean($_POST['username']);
            $batch= clean($_POST['batch']);

                $s1 = 'select * from schedule_student WHERE reg_no="' . $regno . '" AND test_id = "'.$testid.'"';
                $q1 = mysqli_query(conn(), $s1) or die(mysqli_error(conn()));

                if (mysqli_num_rows($q1) > 0) {
                    echo 0; //test already exist
                    return;
                }
                else {
                    $sql = "insert into schedule_student(surname,othername,reg_no,test_id,dept,batch) 
                    values('$sname','$oname','$regno','$testid','$dept','$batch')";
                    $q1 = mysqli_query(conn(), $sql) or die(mysqli_error(conn()));

                    if ($q1) {
                        echo 1;
                    } else {
                        echo mysqli_error(conn());
                    }
                }
                echo mysqli_error(conn());
            
        }else
        echo 4;
    }

    public function getStudentTable($test_id,$batch)
    {
        $class_name ='';
        $r = '';
        $r .= '


            <div class="box-body">
            <button data-toggle="modal" data-target="#del_batch_stud_modal" data-whatever="@mdo" test='.$test_id.' id="batch_del_student" batch="" class="btn btn-md btn-danger pull-right">Delete all  students <span class="glyphicon glyphicon-delete"></span></button>
            <br><br/>
            <table id="example1" class="table table-bordered table-striped table-responsive">
                <thead>
                <tr>
                    <th>SN</th>
                    <th>Student Name</th>
                    <th>Username</th>
                    <th>Department</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>';

                $sql = "SELECT * FROM schedule_student s,exam e WHERE s.exam_id='".$test_id."' And
                e.exam_id=s.exam_id   ORDER BY surname";
        
        
        $q1 = mysqli_query(conn(), $sql) or die(mysqli_error(conn()));
        $sn = 0;

        if (mysqli_num_rows($q1) > 0) {
            while ($row = mysqli_fetch_assoc($q1)) {
                $sn++;
                $id = $row['stdid'];
                 $class_name = $row['name'];

                $name = $row['surname']." ".$row['othername'];
                $username = $row['reg_no'];
                $dept = $row['dept'];

                $r .= '<tr>
						<td>' . $sn . '</td>
						<td>' . $name . '</td>
						<td>' . $username . ' </td>
						<td>' . $dept . ' </td>
						<td>
							<a title="edit" href="javascript:void(0)" rel="student" class="btn btn-primary btn-sm edit" data-toggle="modal" data-target="#addstudent" data-whatever="@mdo" onclick="mode(' . $id . ','.$test_id.');">
							    <span class="glyphicon glyphicon-pencil"></span>
							 </a>


							<a type="button" title="delete" class="btn btn-danger btn-sm delete"  rel="student" data-toggle="modal" data-target="#delete" data-whatever="@mdo" onclick="myDelete(' . $id . ','.$test_id.');"><span class="glyphicon glyphicon-trash"></span>
							</a>

						</td>
					</tr>



				';
            }            echo '<div class="box-header with-border">
                        <h3 class="box-title">'.$class_name.'</h3>
                      </div>';

        }
        else {
            $sql = "SELECT * FROM test WHERE test_id='" . $test_id . "'";
            $q1 = mysqli_query(conn(), $sql) or die(mysqli_error(conn()));
            if (mysqli_num_rows($q1) > 0) {
                while ($row = mysqli_fetch_assoc($q1)) {
                    $class = $row['name'];
                    echo '<div class="box-header with-border">
                        <h3 class="box-title">'.$class.'</h3>
                      </div>';


                }
            }
        }
        $r .= '
                </tbody>
                <tfoot>
                <tr>
                    <th>SN</th>
                    <th>Student Name</th>
                    <th>Username</th>
                    <th>Department</th>
                    <th>Action</th>
                </tr>
                </tfoot>
            </table>
            </div>
        ';

        return $r;

    }

    public function deleteBatchStudent($name,$password,$test_id,$batch)
    {
        $class_name ='';
        $sql="select * from admin where username='$name' and password='$password' ";
		$qry=mysqli_query(conn(), $sql) or die(mysqli_error(conn()));
		$numrows = mysqli_num_rows($qry);

		if ($numrows ==1){
                $del1="DELETE FROM schedule_student WHERE exam_id='".$test_id."' ";
                $response1= mysqli_query(conn(), $del1) or die(mysqli_error(conn()));
                $del2="DELETE FROM attendance   WHERE exam_id='".$test_id."' ";
                $response2= mysqli_query(conn(), $del2) or die(mysqli_error(conn()));
                $del4="DELETE FROM testscore   WHERE paper_id='".$test_id."' ";
                $response1= mysqli_query(conn(), $del4) or die(mysqli_error(conn()));
                $del5="DELETE FROM track_timer   WHERE paper_id='".$test_id."' ";
                $response1= mysqli_query(conn(), $del5) or die(mysqli_error(conn()));
                $del6="DELETE FROM sub_question   WHERE paper_id='".$test_id."' ";
                $response1= mysqli_query(conn(), $del6) or die(mysqli_error(conn()));
            
                return 1;
                
            
            $q1 = mysqli_query(conn(), $sql) or die(mysqli_error(conn()));
			return ;
	 	}else{
	 	    return -1;
		}
        
        

       
        return ;

    }

    function searchStudent($paper_id,$regno)  {

        $sql1 = "SELECT * FROM schedule_student s INNER JOIN exam e ON e.exam_id = s.exam_id
                INNER JOIN papers p ON p.exam_id=e.exam_id WHERE
                p.paper_id='".$paper_id."' AND  reg_no='".$regno."' LIMIT 1";
        $q11 = mysqli_query(conn(), $sql1) or die(mysqli_error(conn()));
        $sn = 0;
        $aid = 0;
        $r = '';
        if (mysqli_num_rows($q11) > 0) {
            $row1 = mysqli_fetch_assoc($q11);
            $student = $row1['stdid'];
            echo '<h3>'.$row1['surname'].' '.$row1['othername'].' ('.$regno.')</h3>';
            // check already graded
            $sel = 'SELECT * FROM testscore WHERE stdid="'.$student.'" AND paper_id="'.$paper_id.'"';
            $check = mysqli_query(conn(), $sel) or die(mysqli_error(conn()));
            $r ='';
            if(mysqli_num_rows($check)>0){
                $rowScore = mysqli_fetch_assoc($check);
                echo '
                    <h3 class=" panel panel-info ">Student was already graded and his total score is:
                        <b id="" class="text-danger">'.$rowScore['right_answered'].'</b></h3>
                    <br>';

                return;
            }


            $sql = "SELECT * FROM other_question o INNER JOIN papers p ON  p.paper_id=o.paper_id where
            p.paper_id='".$paper_id."' AND o.paper_id='".$paper_id."'    ORDER BY name";
            $q1 = mysqli_query(conn(), $sql) or die(mysqli_error(conn()));
            $sn = 0;

            $r .= '
                    <div class="col-md-10">
                    <table class="table table-bordered" text-left>
                    <thead>
                    <tr>
                        <th>SN</th>
                        <th>Question</th>
                        <th>Mark 1</th>
                        <th>Mark 2</th>
                        <th>Mark 3</th>
                        <th>Mark 4</th> 
                    </tr>
                    </thead>
                    <tbody>';
            if (mysqli_num_rows($q1) > 0) {
                $aid =  $this->signAttendance($row1['stdid'],$paper_id);

                while ($row = mysqli_fetch_assoc($q1)) {
                    $sn++;
                    $class_name = $row['name'];
                    $id = $row['question_id'];
                    $question = $row['question_name'];
                    $opt1 = $row['mark1'];
                    $opt2 = $row['mark2'];
                    $opt3 = $row['mark3'];
                    $opt4 = $row['mark4'];
                    $init= trim($row['time'])+0;
                    $minute=floor(($init/60)) ;
                    $sec=$init%60;
                    
                    $r .= '<tr>
                            <td>' . $sn . '</td>
                            <td class="text-left">' . htmlspecialchars_decode($question) . '</td>
                            <td> 
                               <label id="ans1_'.$sn.'" class="quest" rel="'. $id.'">
                                    <h4> <input type="radio" rel="'. $id.'"
                                            role="c'.$sn.'" class="mark" data-stdid='.$row1['stdid'].' value="'.$opt1.'" id="'. $sn.'" name="'. $sn.'" />
                                            '.$opt1.'
                                    </h4>
                                </label>
                            </td>
                            <td> 
                               <label id="ans1_'.$sn.'" >
                                    <h4> <input type="radio" rel="'. $id.'"
                                            role="c'.$sn.'" class="mark" data-stdid='.$row1['stdid'].' value="'.$opt2.'" id="'. $sn.'" name="'. $sn.'" />
                                            '.$opt2.'
                                    </h4>
                                </label>
                            </td>
                            <td> 
                               <label id="ans1_'.$sn.'" >
                                    <h4> <input type="radio" rel="'. $id.'"
                                            role="c'.$sn.'" class="mark" data-stdid='.$row1['stdid'].' value="'.$opt3.'" id="'. $sn.'" name="'. $sn.'" />
                                            '.$opt3.'
                                    </h4>
                                </label>
                            </td>
                            <td> 
                               <label id="ans1_'.$sn.'" >
                                    <h4> <input type="radio" rel="'. $id.'"
                                            role="c'.$sn.'" class="mark" data-stdid='.$row1['stdid'].' value="'.$opt4.'" id="'. $sn.'" name="'. $sn.'" />
                                            '.$opt4.'
                                    </h4>
                                </label>
                            </td>
                        </tr>

                    ';
                }
                echo $r;
                echo '</tbody></table>
                        </div>
                        <div class="col-md-2">
                            <div class="head2  text-center text-uppercase" style="font-size: 3vmin;margin-top:20px; ">
                                <span class="clock text-center" style="background-color: green;color:white">

                                    <hr class="timer"/>
                                <span>
                                    <b><span class="min">'.str_pad($minute,2,"0",STR_PAD_LEFT).'</span>
                                    <span>
                                <span> : </span>
                                </span>
                                        <span class="sec">'. str_pad($sec,2,"0",STR_PAD_LEFT).'</span></b>
                                        <input type="hidden" name="aid" value="'.$aid.'" id="aid"/>
                                </span>
                                </span>
                                <hr>

                                <h1 class="text-primary">Total: <b id="total" class="text-danger">0</b></h1>
                                <br>
                                <button class="btn btn-danger submit-grading" data-student="'.$student.'" data-paper="'.$paper_id.'">Submit</div>
                            </div>
                        </div>';
            }
        }else{
            echo "<h4 class='text-center'>Student not found!</h4>";
        }
    }
    function getStudentModal($surname='',$othername='',$dept='',$regno=''){
        $this->class = new _Class();
        $r ='<div class="panel panel-success cbtlogin" >
                            <div class="panel-body">
                               <div id="error"></div>
                                <form class="form-horizontal stdform" method="post" name="form1" id="studentForm">
                                    <div class="form-group form-group-sm">
                                        <label class="control-label col-sm-2" for="name" >Surname:</label>
                                        <div class="col-sm-10">
                                        <input class="form-control" type="text" id="name" value="'.$surname.'" name="name" type="text" required/>
                                    </div>
                                </div> <!--end form-group-->
                                <div class="form-group form-group-sm">
                                    <label class="control-label col-sm-2" for="class" >Other names:</label>
                                    <div class="col-sm-10">
                                    <input class="form-control" type="text" id="othername" value="'.$othername.'" name="othername" type="text" required/>

                                    </select>
                                </div>
                            </div> <!--end form-group-->
                            <div class="form-group form-group-sm">
                                <label class="control-label col-sm-2" for="dept" >Department:</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" value="'.$dept.'" id="dept" name="dept" type="text" required/>
                                </div>
                            </div> <!--end form-group-->
                            <div class="form-group form-group-sm">
                                <label class="control-label col-sm-2" for="name" >Reg. No:</label>
                                <div class="col-sm-10">
                                    <input class="form-control" value="'.$regno.'" type="text" id="uname" name="uname" type="text" required/>
                                </div>
                            </div> <!--end form-group-->
                            <!--end form-group-->

                        </form>
                    </div>

                </div>
            </div>
            </div>
            </div>
            </div>
            ';
        return $r;
    }

    public function getEditStudent(){
        $idm = $_POST['idm'];
        $sql = 'select * from schedule_student WHERE stdid="'.$idm.'" limit 1';
        $q1 = mysqli_query(conn(), $sql) or die(mysqli_error(conn()));
        $row = mysqli_fetch_assoc($q1);
        $stdid = $row['stdid'];
        $sname = $row['surname'];
        $oname = $row['othername'];
        $username = $row['reg_no'];
        $dept = $row['dept'];

        return $this -> getStudentModal($sname,$oname,$dept,$username);

    }

    public function  editStudent(){
        $SName = clean($_POST['name']);
        $oClass = clean( $_POST['othername']);
        $uName = clean($_POST['uname']);
        $dept = clean($_POST['dept']);

        $idm = $_POST['idm'];

        $sql = 'UPDATE schedule_student SET surname="'.$SName.'",
                othername="'.$oClass.'",
                reg_no="'.$uName.'",
                dept="'.$dept.'"
                WHERE stdid="'.$idm.'" ';
        $q1 = mysqli_query(conn(), $sql) or die(mysqli_error(conn()));



        if($q1){
            echo  1;
        }else echo mysqli_error(conn());

    }

    public function delete($idm){
        $sql = 'delete from schedule_student where stdid="'.$idm.'"' ;
        $q1 = mysqli_query(conn(), $sql) or die(mysqli_error(conn()));

        if($q1){
            echo 1;
        }else echo mysqli_error(conn());
    }
    public function getStudentName($id){
        $sql = 'SELECT * from schedule_student where stdid="'.$id.'"' ;
        $q1 = mysqli_query(conn(), $sql) or die(mysqli_error(conn()));
        $count = mysqli_num_rows($q1);
        if($count>0){
            $row = mysqli_fetch_assoc($q1);
            return $row['reg_no']." (".$row['surname']." ".$row['othername'].")";
        }else return null;
    }

    public function getStudentForm($test_id){
        $sql = "SELECT * FROM test WHERE test_id='" . $test_id . "' ";
        $q1 = mysqli_query(conn(), $sql) or die(mysqli_error(conn()));
        $r = '';
        if (mysqli_num_rows($q1) > 0) {
                $row = mysqli_fetch_assoc($q1);
                $test = $row['name'];
                $r .= '<div class="box-header with-border">
                        <h3 class="box-title">Add student to '.$test.'</h3>
                      </div>';
                $r .='
                        <div class="box-body">
                            <div class="box box-info">
                                <div class="box-body">
                                    <form class="form-add" role="form" id="studentForm">
                                        <div class="input-group">
                                            <span class="input-group-addon">Registration No.</span>
                                            <input type="text" name="username" id="username" class="form-control" placeholder="username">
                                        </div><br/>
                                        <div class="input-group">
                                            <span class="input-group-addon">Surname</span>
                                            <input type="text" name="surname" id="surname" class="form-control" placeholder="">
                                            <input type="hidden" value="'.$test_id.'" name="test_id" class="" placeholder="">
                                        </div><br>
                                        <div class="input-group">
                                            <span class="input-group-addon">Othernames</span>
                                            <input type="text" name="othername" id="othername" class="form-control" placeholder="">
                                        </div>
                                        <br/>
                                        <div class="input-group">
                                            <span class="input-group-addon" >Program</span>
                                            <input type="text" name="dept" id="dept" class="form-control" placeholder="">
                                        </div>
                                        <br/>
                                        <div class="input-group">
                                            <span class="input-group-addon">Batch</span>
                                            <select class="form-control" name="batch" id="batch">
                                                <option value="">-Select option-</option>
                                                
                                           
                                        ';
                                        for ($i=1; $i <= $row['batches']; $i++) { 
                                            $r .='<option value="'.$i.'">Section '.$i.'</option>';
                                        }
                                        $r .='
                                        </select>
                                        </div>
                                        <br/>
                                        <input type="submit" id="add" class="btn btn-primary form-control add" rel="student" value="Add" placeholder="">
                                </form>
                                </div><!-- /input-group -->
                                <br/>
                                <div class="jumbotron msg"></div>

                            </div><!-- /.box-body -->
                        </div><!-- /.box -->

                ';

            
        }
        else{
            $r .='<div class="box-header with-border">
                    <div class="jumbotron"><div class="panel"><h3> Add Students</h3></div></div>
                      </div>';
        }
        return $r;
    }

    public function optionClick(){
        $studentId = $_POST['studentId'];
        $qId = $_POST['qId'];
        $option = $_POST['option'];
        $sql = "SELECT * FROM test_attempt WHERE stdid='".$studentId."' AND quid='".$qId."'";
        $query = mysqli_query(conn(), $sql) or die(mysqli_error(conn()));
        if (mysqli_num_rows($query) > 0) {
            $sql2 = ("UPDATE test_attempt SET ans='".$option."' WHERE stdid='".$studentId."' AND quid='".$qId."'");
            $q1 = mysqli_query(conn(), $sql2) or die(mysqli_error(conn()));

            if ($q1) {
                echo "Update";
            }
        }
        else{
            $sql2 = ("INSERT INTO test_attempt (stdid,quid,ans) VALUES ('".$studentId."','".$qId."','".$option."') ");
            $q = mysqli_query(conn(), $sql2) or die(mysqli_error(conn()));
            if ($q) {
                echo "inserted";
            }
        }
    }

    public function trackTimer(){
        $studentId = $_POST['studentId'];
        $testid = $_POST['testId'];
        $time = $_POST['time'];

        $sql = "select * FROM track_timer WHERE stdid='".$studentId."' AND paper_id='".$testid."'";
        $query = mysqli_query(conn(), $sql) or die(mysqli_error(conn()));
        if(mysqli_num_rows($query) > 0){
            $sql2 = "UPDATE track_timer SET time='".$time."' WHERE stdid='".$studentId."' AND paper_id='".$testid."'";
            $query2 = mysqli_query(conn(), $sql2) or die(mysqli_error(conn()));
            if($query2) echo "updated";
        }else{
            $sql2 = "INSERT INTO track_timer (stdId,paper_id,time) VALUES('".$studentId."','".$testid."','".$time."')";
            $query2 = mysqli_query(conn(), $sql2) or die(mysqli_error(conn()));
            if($query2) echo "inserted";
        }
    }


    public function getScheduleForm($exam_id){
        $sql = "SELECT * FROM exam WHERE exam_id='" . $exam_id . "' limit 1";
        $q1 = mysqli_query(conn(), $sql) or die(mysqli_error(conn()));
        $r = '';
        if (mysqli_num_rows($q1) > 0) {
            while ($row = mysqli_fetch_assoc($q1)) {
                $class = $row['name'];
                $r .= '<div class="box-header with-border">
                        <h3 class="box-title">Upload students for '.strtoupper($class).'</h3>
                      </div>';
                $r .='
                        <div class="box-body">
                            <div class="box box-info">
                                <div class="box-body">
                                    <form class="form-add" role="form" id="form-upload" enctype="multipart/form-data">
                                        <div class="input-group">
                                            <span class="input-group-addon">Select file</span>
                                            <input type="file" name="uploadFile" id="uploadFile" class="form-control" placeholder=""/>
                                            <input type="hidden" value="'.$exam_id.'" name="test_id" id="test_id" class="" placeholder=""/>
                                               </div>
                                         <br/>
                                         
                        <input type="submit" id="uploadStudents" class="btn btn-primary form-control uploadStudents" rel="uploadStudents" value="Upload" placeholder="">


                <!-- /input-group -->


                                </form>
                                </div><!-- /input-group -->
                                <br/>
                                <div class="jumbotron msg">
                                    <div class="panel panel-defaut report">
                                            <ul class="text-danger ul">
                                                <li>Use the <a href="../StudentsList.csv" download>sample excel template</a> to insert students</li>
                                                <li>Do not increase or decrease number of columns of the excel file. Otherwise, it will not store data into database.</li>
                                            </ul>
                                            <img src="../images/status.gif" hidden="hidden" class="spin pull-center"/>
                                    </div>
                                </div>

                            </div><!-- /.box-body -->
                        </div><!-- /.box -->

                ';

            }
        }
        else{
            $r .='<div class="box-header with-border">
                    <div class="jumbotron"><div class="panel"><h3> Schedule Students</h3></div></div>
                      </div>';
        }
        return $r;
    }

    public function signAttendance($stdid,$test_id)
    {
        
            $time_in = date('Y-m-d h:i:s');
            $ip = $_SERVER['REMOTE_ADDR'];
            $s1 = 'select * from attendance WHERE stdid="' . $stdid . '"    AND paper_id="'.$test_id.'"';
            $q1 = mysqli_query(conn(), $s1) or die(mysqli_error(conn()));
            $row = mysqli_fetch_assoc($q1);

            if (mysqli_num_rows($q1) > 0) {
                $sql = 'UPDATE attendance SET session_status=1
                WHERE stdid="'.$stdid.'" AND paper_id ="'.$test_id.'" ';
                $q1 = mysqli_query(conn(), $sql) or die(mysqli_error(conn()));



                if($q1){
                    return $row['attendance_id'];
                }
            }
            else {
                $sql = "insert into attendance(stdid,paper_id,ip_address,time_in,session_status) 
                values('$stdid','$test_id','$ip','$time_in',1)";
                $q = mysqli_query(conn(), $sql) or die(mysqli_error(conn()));

                if ($q) {
                    return mysqli_insert_id(conn());
                } else {
                    echo mysqli_error(conn());
                }
            }
            mysqli_error(conn());

       
    }
    public function signOutAttendance($stdid,$test_id)
    {
        
            $time_out = date('Y-m-d h:i:s');
            
            $sql = 'UPDATE attendance SET session_status=1,time_out="'.$time_out.'"
            WHERE stdid="'.$stdid.'" AND test_id ="'.$test_id.'"';
            $q1 = mysqli_query(conn(), $sql) or die(mysqli_error(conn()));



            if($q1){
                // echo  1;
                return 1;
            }else{
                return 0;
            }
            

       
    }

    public function getUnlockForm($test_id){
        $sql = "SELECT * FROM test WHERE test_id='" . $test_id . "' limit 1";
        $q1 = mysqli_query(conn(), $sql) or die(mysqli_error(conn()));
        $r = '';
        if (mysqli_num_rows($q1) > 0) {
            while ($row = mysqli_fetch_assoc($q1)) {
                $class = $row['name'];
                $r .= '<div class="box-header with-border">
                        <h3 class="box-title">Unlock students for '.strtoupper($class).'</h3>
                      </div>';
                $r .='
                        <div class="box-body">
                            <div class="box box-info">
                                <div class="box-body">
                                    <button class="btn btn-danger btn-lg pull-right" id="unlock_all">Unlock All</button><br/><br/><br><br>
                                    <form class="form-add" role="form" id="form-upload" enctype="multipart/form-data">
                                        <div class="input-group">
                                            <span class="input-group-addon">Matric No.</span>
                                            <input type="text" name="uploadFile" id="regno" class="form-control" placeholder=""/>
                                            <input type="hidden" value="'.$test_id.'" name="test_id" id="test_id" class="" placeholder=""/>
                                               </div>
                                         <br/>
                                        <button type="button" id="unlock" class="btn btn-primary col-lg-offset-5">
                                            Unlock <span class="glyphicon glyphicon-lock"></span>
                                        </button>


                <!-- /input-group -->


                                </form>
                                </div><!-- /input-group -->
                                <br/>
                                <div class="jumbotron msg">
                                    <div class="panel panel-defaut report">
                                            
                                            <img src="../images/status.gif" hidden="hidden" class="spin pull-center"/>
                                    </div>
                                </div>

                            </div><!-- /.box-body -->
                        </div><!-- /.box -->

                ';

            }
        }
        else{
            $r .='<div class="box-header with-border">
                    <div class="jumbotron"><div class="panel"><h3> Unlock Students</h3></div></div>
                      </div>';
        }
        return $r;
    }
    public function  getStudentId($regno,$test_id){
        $regno = clean($_POST['regno']);
        $test_id = clean($_POST['test_id']);
        

        $s1 = 'select * from schedule_student WHERE reg_no="' . $regno. '"    AND test_id="'.$test_id.'" ';
        $q1 = mysqli_query(conn(), $s1) or die(mysqli_error(conn()));

        if (mysqli_num_rows($q1) > 0) {
            $fetch = mysqli_fetch_assoc($q1);
            return $fetch['stdid'];
        }else{
            return 0;
        }

        

    }
    public function  unlockStudent(){
        $regno = clean($_POST['regno']);
        $test_id = clean($_POST['test_id']);
        $stdid = $this->getStudentId($regno,$test_id);

        if ($stdid !=0) {
            # code...
            $sql = 'UPDATE attendance SET session_status=0
                WHERE stdid="'.$stdid.'" AND test_id ="'.$test_id.'"';
            $q1 = mysqli_query(conn(), $sql) or die(mysqli_error(conn()));



            if($q1){
                echo  1;
                return;
            }
        }else{
            echo -1;
            return;
        }
        

    }
    public function  unlockAllStudent(){
        // $regno = clean($_POST['regno']);
        $test_id = clean($_POST['test_id']);
        // $stdid = $this->getStudentId($regno,$test_id);

            $sql = 'UPDATE attendance SET session_status=0
                WHERE test_id ="'.$test_id.'"';
            $q1 = mysqli_query(conn(), $sql) or die(mysqli_error(conn()));



            if($q1){
                echo  1;
                return;
            
            }else{
                echo -1;
                return;
            }
        

    }



}