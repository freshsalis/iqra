<?php
/**
 * Created by PhpStorm.
 * User: freshsalis
 * Date: 12/12/2017
 * Time: 2:07 PM
 */
date_default_timezone_set('Africa/Lagos');
require_once 'db.php';



class Question {

    private  $class;

    public function addQuestion()
    {
        if ($_POST['question1'] !='' && $_POST['opt1']!='' && $_POST['opt2']!='' && $_POST['answer']!='') {

            $question = clean($_POST['question1']);
            $opt1 = clean($_POST['opt1']);
            $opt2 = clean($_POST['opt2']);
            $opt3 = clean($_POST['opt3']);
            $opt4 = clean($_POST['opt4']);
             $answer = clean($_POST['answer']);
            $test = clean($_POST['test_id']);
            $section = clean($_POST['section']);
            $type = 1;
            $url = '';
            if (isset($_FILES['file'])) {
                $url = $this->UploadDiagram();
                $type = 3;
                if ($url ==1) {
                    return "Diagram not an image";
                }elseif ($url == 2) {
                    return "Sorry, diagram already exist, rename the file and try again";
                }
                elseif ($url == 3) {
                    return "Sorry, file is too large";
                }
                elseif ($url == 4) {
                    return "Sorry, only JPG, JPEG, PNG files are allowed for diagrams.";
                }
                elseif ($url == 7 || $url == 5) {
                    return "Sorry, there was an error uploading your file. Contact system admin";
                }
            }

                $sql = "insert into question 
                    (question_name,question_type,diagram,test_id,answer1,answer2,answer3,answer4,answer,section)
                 values ('".$question."','".$type."','".$url."','".$test."','".$opt1."',
                 '".$opt2."','".$opt3."','".$opt4."','".$answer."','".$section."')";
                $q1 = mysqli_query(conn(), $sql) or die(mysqli_error(conn()));

                if ($q1) {
                    echo 1;
                } else {
                    echo mysqli_error(conn());
                }

        }else
            echo 4;
    }
    function UploadDiagram()
    {
        if(isset($_FILES['file'])){
            $_SESSION['err_mssg1'] = "";
            $target_dir = "../../../images/diagrams/";
            $target_file = $target_dir . basename($_FILES["file"]["name"]);
            $uploadOk = 1;
            $filename = "";
            $ext = "";
            $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
            function getExtension($str)
            {
                $i = strrpos($str, ".");
                if (!$i) {
                    return "";
                }
                $l = strlen($str) - $i;
                $ext = substr($str, $i + 1, $l);
                return $ext;
            }

            // Check if image file is a actual image or fake image
            if (isset($_POST["file"])) {
                $check = getimagesize($_FILES["file"]["tmp_name"]);
                if ($check !== false) {
                    $_SESSION['err_mssg1'] = "File is an image - " . $check["mime"] . ".";
                    $filename = stripslashes($target_file);
                    $ext = getExtension($filename);
                    $ext = strtolower($ext);

                    $uploadOk = 1;
                } else {
                    $_SESSION['err_mssg1'] = "File is not an image.";
                    $uploadOk = 0;
                    return 1; //File is not an image

                }
            } // Check if file already exists
            else if (file_exists($target_file)) {
                $_SESSION['err_mssg1'] = "Sorry, file already exists.";
                $uploadOk = 0;
                $target_file = "";
                return 2; //Sorry, file already exists

            } // Check file size 2MB
            else if ($_FILES["file"]["size"] > 2000 * 1024) {
                $_SESSION['err_mssg1'] = "Sorry, your file is too large.";
                $target_file = "";
                $uploadOk = 0;
                return 3; //Sorry, your file is too large.
            } // Allow certain file formats
            elseif ($imageFileType != "jpg" && $imageFileType != "png") {
                $_SESSION['err_mssg1'] = ".jpg and .png file extensions are allowed";
                $target_file = "";
                $uploadOk = 0;
                return 4; // Sorry, only JPG, JPEG, PNG files are allowed.
            } // Check if $uploadOk is set to 0 by an error
            elseif ($uploadOk == 0) {
               $_SESSION['err_mssg1'] = "Sorry, your file was not uploaded.";
                return 5;
                // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                    return $url = $target_file;
                    //$_SESSION['err_mssg1'] = saveAppointment($name, $title,$dept, $staffid, $effective_date,$url);
                    // /$this->saveCertificate($member_id,$target_file);
                    //return 6;

                } else {
                    $_SESSION['err_mssg1'] = "Sorry, there was an error uploading your file.";
                    return 7;
                }
            }
            //echo  $_SESSION['err_mssg1']. $_SESSION['err_mssg2']. $_SESSION['err_mssg3']. $_SESSION['err_mssg4'];

        }
        else{
            $_SESSION['err_mssg1'] = 'Picture file not selected';
        }
    }
    public function getQuestionTable($class_id)
    {
        $class_name ='';
        $r = '';
        $r .= '

        <button data-toggle="modal" data-target="#del_all_question_modal" data-whatever="@mdo" test='.$class_id.' id="all_del_question" class="btn btn-md btn-danger pull-right">Delete All Questions <span class="glyphicon glyphicon-delete"></span></button>
        <br><br>
            <div class="box-body bx" >
            <table id="example1" class="table table-bordered table-striped table-responsive">
                <thead>
                <tr>
                    <th>SN</th>
                    <th>Question</th>
                    <th>Diagram</th>
                    <th>Section</th>
                    <th>Option 1</th>
                    <th>Option 2</th>
                    <th>Option 3</th>
                    <th>Option 4</th>
                    <th>Answer</th>
                    <th>Edit</th>
                </tr>
                </thead>
                <tbody>';
        $sql = "SELECT * FROM question,test where
			test.test_id='".$class_id."' AND question.test_id='".$class_id."'    ORDER BY name";
        $q1 = mysqli_query(conn(), $sql) or die(mysqli_error(conn()));
        $sn = 0;

        // <td>

		// 					<a type="button" title="delete" class="btn btn-danger btn-sm delete"  rel="question" data-toggle="modal" data-target="#delete" data-whatever="@mdo" onclick="myDelete(' . $id . ','.$class_id.');"><span class="glyphicon glyphicon-trash"></span>
		// 					</a>

		// 				</td>

        if (mysqli_num_rows($q1) > 0) {
            while ($row = mysqli_fetch_assoc($q1)) {
                $sn++;
                $class_name = $row['name'];
                $id = $row['question_id'];
                $question = $row['question_name'];
                $opt1 = $row['answer1'];
                $opt2 = $row['answer2'];
                $section = $row['section'];
                $opt3 = $row['answer3'];
                $opt4 = $row['answer4'];
                $answer = $row['answer'];
                $diagram = $row['diagram'];
                if(strlen(trim($diagram)) == 0){
                    $pic = '';
                }else{

                    $pic = '<img src="'.$diagram.'" height="50" width="100"/>';

                }
                $r .= '<tr>
                        <td>' . $sn . '</td>
                        <td>' . htmlspecialchars_decode($question) . '</td>
                        <td>' . $pic . '</td>
                        <td>' . $section . '</td>
                        <td>' . htmlspecialchars_decode(mysqli_real_escape_string(conn(), $opt1) ). ' </td>
                        <td>' . htmlspecialchars_decode($opt2) . ' </td>
                        <td>' . htmlspecialchars_decode($opt3) . ' </td>
                        <td>' . htmlspecialchars_decode($opt4). ' </td>
						<td>Option ' . $answer . ' </td>
						<td>
							<a title="edit" href="javascript:void(0)" rel="question" class="btn btn-primary btn-sm edit" data-toggle="" data-target="'.$class_id.'" onclick="mode(' . $id . ','.$class_id.');">
							    <span class="glyphicon glyphicon-pencil"></span>
							 </a>
                        </td>
                        
					</tr>



				';
            }
            echo '<div class="box-header with-border">
                        <h3 class="box-title">'.$class_name.' questions</h3>
                      </div>';
        }
        else {
            $sql = "SELECT * FROM test WHERE test_id='" . $class_id . "' ORDER BY name limit 1";
            $q1 = mysqli_query(conn(), $sql) or die(mysqli_error(conn()));
            if (mysqli_num_rows($q1) > 0) {
                $row = mysqli_fetch_assoc($q1);
                $class = $row['name'];
                echo '<div class="box-header with-border">
                        <h3 class="box-title">'.$class.'</h3>
                      </div>';



            }
        }
        $r .= '
                </tbody>
                <tfoot>
                <tr>
                <th>SN</th>
                <th>Question</th>
                <th>Diagram</th>
                <th>Section</th>
                <th>Option 1</th>
                <th>Option 2</th>
                <th>Option 3</th>
                <th>Option 4</th>
                <th>Answer</th>
                <th>Edit</th>
                </tr>
                </tfoot>
            </table>
            </div>
        ';

        return $r;

    }

    public function getResultTable($test_id,$batch){
        $class_name ='';
        $r = '';
        $r .= '


            <div class="box-body">
            <a href="viewResult.php?id='.$test_id.'&action=force&batch='.$batch.'"class="btn btn-md btn-danger " id="">Force Submit <span class="glyphicon glyphicon-upload"></span></a>
            <br><br/>
            <table id="example1" class="table table-bordered table-striped table-responsive">
                <thead>
                <tr>
                    <th>SN</th>
                    <th>Student Names</th>
                    <th>Matric No</th>
                    <th>View Attempts</th>
                    <th>Right Answered</th>
                    <th>Scores*Weight</th>
                </tr>
                </thead>
                <tbody>';
        if ($batch === 'all') {
            // echo $batch;die();

            $Q = ' SELECT *
                FROM testscore
                INNER JOIN schedule_student
                INNER JOIN attendance a ON a.stdid = schedule_student.stdid
                INNER JOIN test
                ON testscore.stdid = schedule_student.stdid
                AND testscore.testid = test.test_id
                WHERE testscore.testid = "'.$test_id.'" ORDER BY reg_no';
        }else{
            $Q = ' SELECT *
                FROM testscore
                INNER JOIN schedule_student
                INNER JOIN attendance a ON a.stdid = schedule_student.stdid
                INNER JOIN test
                ON testscore.stdid = schedule_student.stdid
                AND testscore.testid = test.test_id
                WHERE testscore.testid = '.$test_id.' AND batch="'.$batch.'" ORDER BY reg_no';
        }
        
        $q1 = mysqli_query(conn(), $Q) or die(mysqli_error(conn()));


        $sn = 0;
        if (mysqli_num_rows($q1) >0) {

            // find the total number of question in a particular test to get % d stud get from the test
            $s= 'select * from question q where q.test_id = '.$test_id.' ';
            $sq = mysqli_query(conn(), $s) or die(mysqli_error(conn()));

            //print reult table

            while ($row = mysqli_fetch_assoc($q1)) {
                $sn++;
                $stdname = $row['surname']." ".$row['othername'];
                $answer = $row['right_answered'];
                //$answer = (100.0/$num_quest)*$row['right_answered'];
                $test_title = $row['name'];
                $user = $row['reg_no'];
                $user_id = $row['stdid'];
                $test_id = $row['test_id'];
                $num_quest = $row['question_per_stud'];
                $enable = $row['earnable_score'];
                $weight = $row['weight'];



                $r .= "<tr>
						<td>".$sn."</td>
						<td>".$stdname."</td>
						<td>".$user."</td>
						<td><a href='./view_attempts.php?user=".$user_id."&test=".$test_id."' target='_blank' class='btn btn-default'>View Attempts</a></td>
						<td>".round($answer,2)."/".$num_quest."</td>
						<td>".(round($answer,2) *$weight)."</td>

				</tr>";


            }
            echo '<div class="box-header with-border">
                        <h3 class="box-title">'.$test_title.' results (Batch: '.$batch.')</h3>
                            <a href="../testExcel.php?tid='.$test_id.'&batch='.$batch.'"class="btn btn-md btn-primary pull-right" id="download" rel="'.$class_name.'">Download Results <span class="glyphicon glyphicon-download-alt"></span></a>
                      </div>';
        }
        else {
            $sql = "SELECT * FROM test WHERE test_id='" . $test_id . "' ORDER BY name limit 1";
            $q1 = mysqli_query(conn(), $sql) or die(mysqli_error(conn()));
            if (mysqli_num_rows($q1) > 0) {
                $row = mysqli_fetch_assoc($q1);
                $class = $row['name'];
                echo '<div class="box-header with-border">
                        <h3 class="box-title">'.$class.'</h3>
                      </div>';



            }
        }

        $r .= '
                </tbody>
                <tfoot>
                <tr>
                <th>SN</th>
                <th>Student Names</th>
                <th>Matric No</th>
                <th>View Attempts</th>
                <th>Right Answered</th>
                <th>Scores*Weight</th>
                </tr>
                </tfoot>
            </table>
            </div>
        ';

        return $r;

    }
    public function getAnalysisTable($class_id){
        $class_name ='';
        $r = '';
        $r .= '


            <div class="box-body">
            <table id="example1" class="table table-bordered table-responsive table-striped">
                <thead>
                <tr>
                    <th>SN</th>
                    <th>Student Names</th>
                    <th>Matric No</th>
                    <th>Right answer</th>
                    <th>Wrong answer</th>
                    <th>Unanswered</th>
                    <th>Scores</th>
                    <th>Out of</th>
                    <th>View Attempts</th>
                </tr>
                </thead>
                <tbody>';
        $Q = 'SELECT * FROM testscore
                INNER JOIN schedule_student
                INNER JOIN test
                ON testscore.stdid = schedule_student.stdid
                AND testscore.testid = test.test_id
                WHERE testscore.testid = '.$class_id.'';
        $q1 = mysqli_query(conn(), $Q) or die(mysqli_error(conn()));


        $sn = 0;
        if (mysqli_num_rows($q1) >0) {

            // find the total number of question in a particular test to get % d stud get from the test
            $s= 'select * from question q where q.test_id = '.$class_id.' ';
            $sq = mysqli_query(conn(), $s) or die(mysqli_error(conn()));

            //print reult table

            while ($row = mysqli_fetch_assoc($q1)) {
                $sn++;
                $stdname = $row['surname']." ".$row['othername'];
                $answer = $row['right_answered'];
                $wrong_answer = $row['wrong_answer'];
                $unanswerered = $row['unanswered'];
                //$answer = (100.0/$num_quest)*$row['right_answered'];
                $test_title = $row['name'];
                $user = $row['reg_no'];
                $user_id = $row['stdid'];
                $test_id = $row['test_id'];
                $num_quest = $row['question_per_stud'];



                $r .= "<tr>
						<td>".$sn."</td>
						<td>".$stdname."</td>
						<td>".$user."</td>
						<td>".$answer."</td>
						<td>".$wrong_answer."</td>
                        <td>".$unanswerered."</td>
						<td>".round($answer,2)."</td>
						<td>".$num_quest."</td>
						<td><a href='./view_attempts.php?user=".$user_id."&test=".$test_id."' target='_blank' class='btn btn-default'>View Attempts</a></td>

				</tr>";


            }
            echo '
                      <div class="box-header with-border">
                        <h3 class="box-title">'.$test_title.' results</h3>
                            <a href="../analysisExcel.php?tid='.$test_id.'"class="btn btn-md btn-primary pull-right" id="download" rel="'.$class_name.'">Download Results <span class="glyphicon glyphicon-download-alt"></span></a>

                      </div>
                      ';
        }
        else {
            $sql = "SELECT * FROM test WHERE test_id='" . $class_id . "' ORDER BY name limit 1";
            $q1 = mysqli_query(conn(), $sql) or die(mysqli_error(conn()));
            if (mysqli_num_rows($q1) > 0) {
                $row = mysqli_fetch_assoc($q1);
                $class = $row['name'];
                echo '<div class="box-header with-border">
                        <h3 class="box-title">'.$class.'</h3>
                      </div>';



            }
        }

        $r .= '
                </tbody>
                <tfoot>
                <tr>
                    <th>SN</th>
                    <th>Student Names</th>
                    <th>Matric No</th>
                    <th>Right answer</th>
                    <th>Wrong answer</th>
                    <th>Unanswered</th>
                    <th>Scores</th>
                    <th>View Attempts</th>
                </tr>
                </tfoot>
            </table>
            </div>
        ';

        return $r;

    }
    public function getChartData($test_id){
        $class_name ='';
        $r = '';
        
        $Q = 'SELECT * FROM testscore
                INNER JOIN schedule_student
                INNER JOIN test
                ON testscore.stdid = schedule_student.stdid
                AND testscore.testid = test.test_id
                WHERE testscore.testid = '.$test_id.'';
        $q1 = mysqli_query(conn(), $Q) or die(mysqli_error(conn()));


        $sn = 0;
        if (mysqli_num_rows($q1) >0) {

            // find the total number of question in a particular test to get % d stud get from the test
            // $s= 'select * from question q where q.test_id = '.$test_id.' ';
            // $sq = mysqli_query(conn(), $s) or die(mysqli_error(conn()));

            //print reult table

            while ($row = mysqli_fetch_assoc($q1)) {
                $sn++;
                $stdname = $row['surname']." ".$row['othername'];
                $answer = $row['right_answered'];
                $wrong_answer = $row['wrong_answer'];
                $unanswerered = $row['unanswered'];
                //$answer = (100.0/$num_quest)*$row['right_answered'];
                $test_title = $row['name'];
                $user = $row['reg_no'];
                $user_id = $row['stdid'];
                $test_id = $row['test_id'];
                $num_quest = $row['question_per_stud'];
            }
            
        }
        else {
            // $sql = "SELECT * FROM test WHERE test_id='" . $class_id . "' ORDER BY name limit 1";
            // $q1 = mysqli_query(conn(), $sql) or die(mysqli_error(conn()));
            // if (mysqli_num_rows($q1) > 0) {
            //     $row = mysqli_fetch_assoc($q1);
            //     $class = $row['name'];
            //     echo '<div class="box-header with-border">
            //             <h3 class="box-title">'.$class.'</h3>
            //           </div>';
            // }
        }
        return $r;

    }
    public function viewAttempts($user,$test_id){
        $class_name ='';
        $r = '';
        
        $Q = 'SELECT * FROM testscore
                INNER JOIN schedule_student
                INNER JOIN test
                ON testscore.stdid = schedule_student.stdid
                AND testscore.testid = test.test_id
                WHERE testscore.testid = '.$test_id.' AND schedule_student.stdid="'.$user.'"';
        $q1 = mysqli_query(conn(), $Q) or die(mysqli_error(conn()));


        $sn = 0;
        if (mysqli_num_rows($q1) >0) {

            // find the total number of question in a particular test to get % d stud get from the test
            // $s= 'select * from question q where q.test_id = '.$test_id.' ';
            // $sq = mysqli_query(conn(), $s) or die(mysqli_error(conn()));

            //print reult table

            $row = mysqli_fetch_assoc($q1);

                $stdname = $row['surname']." ".$row['othername'];
                $answer = $row['right_answered'];
                //$answer = (100.0/$num_quest)*$row['right_answered'];
                $test_title = $row['name'];
                $user = $row['reg_no'];
                $user_id = $row['stdid'];
                $test_id = $row['test_id'];
                $num_quest = $row['question_per_stud'];

                $r .= '
                <div class="col-md-3">
                <div class="box box-solid">
                    

                </div><!-- /. box -->
                <div class="box box-solid">

                    <div class="box-body ">
                        <h5><ul class="nav nav-pills nav-stacked">
                            <li><i class="glyphicon glyphicon-user"></i> <b>NAME :</b> '.$stdname.'</li>
                            <li><i class="glyphicon glyphicon-check"></i> <b>TEST :</b> '.$test_title.'</li>
                            <li><i class="glyphicon glyphicon-check"></i> <b>TOTAL MARKS :</b> '.round($answer,2)."/".$num_quest.'</li>

                        </ul></h5>
                    </div>
                </div>
            </div>
                ';
        }
        
            $sql = "SELECT * FROM question q INNER JOIN sub_question s
            ON q.question_id = s.question_id
            WHERE s.stud_id = '$user_id' AND q.test_id = '$test_id'";
            $q1 = mysqli_query(conn(), $sql) or die(mysqli_error(conn()));
            $n = 0;
            if (mysqli_num_rows($q1) > 0) {
                echo '
                <div class="col-md-9" >
                    <div class="box box-solid" style="padding:20px;">';
                  
                while ($row = mysqli_fetch_assoc($q1)) {
                    $n ++;
                    echo $this->questionAttempts($user_id,$test_id,$row['question_id'],$n);
                }                                      
                    echo '</div></div>';
            }        

        

        return $r;

    }
    public function questionAttempts($user_id,$test_id,$qid,$n){
        $class_name ='';
        $r = '';
            $sql = "SELECT * FROM question q INNER JOIN test_attempt t
            ON q.question_id = t.quid
            WHERE t.stdid = '$user_id' AND q.test_id = '$test_id' AND question_id='$qid' limit 1";
            $q1 = mysqli_query(conn(), $sql) or die(mysqli_error(conn()));            
            if (mysqli_num_rows($q1) > 0) {
                
                while ($row = mysqli_fetch_assoc($q1)) {
                    echo "<p><p>".$n.". ".$row['question_name']."</p>
                        <code>                                
                            A. ".$row["answer1"]."
                                <br/>
                            B. ".$row["answer2"]."
                                <br/>
                            C. ".$row["answer3"]."
                            <br/>
                            D. ".$row["answer4"]."
                            
                        </code>
                        <div class='pull-right'>
                            <div class='text-success'>Correct Option: ".$this->getOption($row['answer'])."</div>
                            <div class='text-danger'>Selected Option: ".$this->getOption($row['ans'])."</div>
                        </div>
                        <hr/>    
                    </p>";
                }
            }else{
                $sql = "SELECT * FROM question q INNER JOIN sub_question s
                ON q.question_id = s.question_id
                WHERE s.stud_id = '$user_id' AND q.test_id = '$test_id' AND q.question_id='$qid' limit 1";
                $q1 = mysqli_query(conn(), $sql) or die(mysqli_error(conn()));            
                if (mysqli_num_rows($q1) > 0) {
                
                    while ($row = mysqli_fetch_assoc($q1)) {
                        echo "<p><p>".$n.". ".$row['question_name']."</p>
                            <code>                                
                                A. ".$row["answer1"]."
                                    <br/>
                                B. ".$row["answer2"]."
                                    <br/>
                                C. ".$row["answer3"]."
                                <br/>
                                D. ".$row["answer4"]."
                                
                            </code>
                            <div class='pull-right'>
                                <div class='text-success'>Correct Option: ".$this->getOption($row['answer'])."</div>
                                <div class='text-danger'>Selected Option: N/A</div>
                            </div>
                            <hr/>    
                        </p>";
                    }
                }
            }    

        

        return $r;

    }
    public function getOption($opt)
    {
        if($opt ==1){
            return 'A';
        }elseif ($opt ==2) {
            return 'B';
        }
        elseif ($opt ==3) {
            return 'C';
        }elseif ($opt ==4) {
            return 'D';
        }
    }
    function getQuestionModal($question,$opt1,$opt2,$opt3,$opt4,$answer,$test_id){
        $this->class = new _Class();
        $r ='<div class="panel panel-success cbtlogin" >
                            <div class="panel-body">
                            <div ID="alert1"></div>
                            <div id="editbody"></div>

                                <form class="form-horizontal stdform" method="post" name="form1" id="studentForm">
                                    <div class="box-body">
                                            <div class="input-group">
                                            <span class="input-group-addon">Question</span>
                                            <textarea class="ckeditor form-control" id="question" name="question">'.$question.'</textarea>
                                            <input type="hidden" value="'.$test_id.'" name="test_id" id="test_id" class="" placeholder="">

                                        </div>
                                        <br/>
                                             <div class="input-group">
                                                <span class="input-group-addon">Option 1</span>
                                            <input type="text" value="'.$opt1.'" name="opt1" id="opt1" class="form-control" placeholder="Option A">
                                        </div>
                                    <br/>
                                        <div class="input-group">
                                            <span class="input-group-addon">Option 2</span>
                                            <input type="text" value="'.$opt2.'" name="opt2" id="opt2" class="form-control" placeholder="Option B">
                                        </div>
                                    <br/>
                                    <div class="input-group">
                                            <span class="input-group-addon">Option 3</span>
                                            <input type="text" value="'.$opt3.'" name="opt3" id="opt3" class="form-control" placeholder="Option C">
                                        </div>
                                    <br/>
                                    <div class="input-group">
                                            <span class="input-group-addon">Option 4</span>
                                            <input type="text" value="'.$opt4.'" name="opt4" id="opt4" class="form-control" placeholder="Option D">
                                        </div>
                                    <br/>
                                    <div class="input-group">
                                            <span class="input-group-addon">Answer</span>
                                            <input type="text" value="'.$answer.'" name="answer" id="answer" class="form-control" placeholder="Option D">
                                        </div>
                                    <br/>

                <!-- /input-group -->
        <!-- /input-group -->

                        </form>
                    </div>

                </div>
            </div>
            </div>
            </div>
            <div class="modal-footer">
                <div class="col-sm-10 col-sm-offset-2">
                    <button class="btn btn-md btn-primary" type="submit"  id="update">Update</button>
                </div>
            </div>
            </div>
            ';
        return $r;
    }

    public function getEditQuestion(){
        $idm = $_POST['idm'];
        $sql = 'select * from question WHERE question_id="'.$idm.'" limit 1';
        $q1 = mysqli_query(conn(), $sql) or die(mysqli_error(conn()));
        $row = mysqli_fetch_assoc($q1);
        $question = $row['question_name'];
        $opt1 = $row['answer1'];
        $opt2 = $row['answer2'];
        $opt3 = $row['answer3'];
        $opt4 = $row['answer4'];
        $answer = $row['answer'];
        $question_id = $row['question_id'];


        return $this -> getQuestionModal($question,$opt1,$opt2,$opt3,$opt4,$answer,$question_id);

    }

    public function  editQuestion(){
        $question = clean($_POST['question']);
        $opt1 = clean($_POST['opt1']);
        $opt2 = clean($_POST['opt2']);
        $opt3 = clean($_POST['opt3']);
        $opt4 = clean($_POST['opt4']);
        $answer = clean($_POST['answer']);
        $test = clean($_POST['test_id']);



        $sql = 'UPDATE question SET question_name="'.$question.'",
                answer1="'.$opt1.'",
                answer2="'.$opt2.'",
                answer3="'.$opt3.'",
                answer4="'.$opt4.'",
                answer="'.$answer.'"
                WHERE question_id="'.$test.'" ';
        $q1 = mysqli_query(conn(), $sql) or die(mysqli_error(conn()));



        if($q1){
            echo  1;
        }else echo mysqli_error(conn());

    }

    public function delete($idm){
        $sql = 'delete from question where question_id="'.$idm.'"' ;
        $q1 = mysqli_query(conn(), $sql) or die(mysqli_error(conn()));

        if($q1){
            echo 1;
        }else echo mysqli_error(conn());
    }
    public function deleteAllQuestions($name,$password,$test_id)
    {
        $class_name ='';
        $sql="select * from admin where username='$name' and password='$password' ";
		$qry=mysqli_query(conn(), $sql) or die(mysqli_error(conn()));
		$numrows = mysqli_num_rows($qry);

		if ($numrows ==1){
                $del1="DELETE FROM question WHERE test_id='".$test_id."' ";
                $response1= mysqli_query(conn(), $del1) or die(mysqli_error(conn()));
                
                $del6="DELETE FROM sub_question   WHERE test_id='".$test_id."' ";
                $response1= mysqli_query(conn(), $del6) or die(mysqli_error(conn()));
            
                return 1;
	 	}else{
	 	    return -1;
		}       
    }

    public function getQuestionForm($test_id){
        $sql = "SELECT * FROM test WHERE test_id='" . $test_id . "' limit 1";
        $q1 = mysqli_query(conn(), $sql) or die(mysqli_error(conn()));
        $r = '';
        if (mysqli_num_rows($q1) > 0) {
            while ($row = mysqli_fetch_assoc($q1)) {
                $class = $row['name'];
                $r .= '<div class="box-header with-border">
                        <h3 class="box-title">Add questions to '.$class.'</h3>
                      </div>';
                $r .='
                        <div class="box-body">
                            <div class="box box-info">
                                <div class="box-body">
                                    <form class="form-add" role="form" id="form-add" enctype="multipart/form-data">
                                        <b>Question:</b>
                                            <textarea class="col-lg-12 form-control" id="editor" name="question"></textarea>
                                            <input type="hidden" value="'.$test_id.'" name="test_id" id="test_id" class="" placeholder="">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <b>Option 1: </b>
                                                <textarea class="col-lg-12 form-control" id="editor2" name="question"></textarea>
                                            </div>
                                            <div class="col-lg-6">
                                                <b>Option 2: </b>
                                                <textarea class="col-lg-12 form-control" id="editor3" name="question"></textarea>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <b>Option 3: </b>
                                                <textarea class="col-lg-12 form-control" id="editor4" name="question"></textarea>
                                            </div>
                                            <div class="col-lg-6">
                                                <b>Option 4: </b>
                                                <textarea class="col-lg-12 form-control" id="editor5" name="question"></textarea>
                                            </div>
                                        </div>
                                        
                                    <br/>                                    
                                        <div class="input-group">
                                            <span class="input-group-addon">Section</span>
                                            <select class="form-control" name="section" id="section">
                                                <option value="">-Select option-</option>
                                                
                                           
                                        ';
                                        for ($i=1; $i <= $row['batches']; $i++) { 
                                            $r .='<option value="'.$i.'">Section '.$i.'</option>';
                                        }
                                        $r .='
                                        </select>
                                        </div>
                                    <br>
                                    <div class="input-group">
                                            <span class="input-group-addon">Answer</span>
                                            <select class="form-control" name="answer" id="answer">
                                                <option value="">-Select correct answer-</option>
                                                <option value="1">Optiop 1</option>
                                                <option value="2">Optiop 2</option>
                                                <option value="3">Optiop 3</option>
                                                <option value="4">Optiop 4</option>
                                            </select>
                                        </div>
                                    <br/>
                                    <div class="input-group">
                                    <span class="input-group-addon">Diagram</span>
                                    <input type="file" name="file" id="file" class="form-control" placeholder="Select file">
                                </div>
                            <br/>

                <!-- /input-group -->

                                                    <br/>
                                                    <input type="submit" id="add" class="btn btn-primary form-control add" rel="Question" value="Add" placeholder="">
                                </form>
                                </div><!-- /input-group -->
                                <br/>
                                <div class="jumbotron msg"></div>

                            </div><!-- /.box-body -->
                        </div><!-- /.box -->

                ';

            }
        }
        else{
            $r .='<div class="box-header with-border">
                    <div class="jumbotron"><div class="panel"><h3> Add Question</h3></div></div>
                      </div>';
        }
        return $r;
    }

    public function getQuestionExcelForm($test_id){
        $sql = "SELECT * FROM test WHERE test_id='" . $test_id . "' limit 1";
        $q1 = mysqli_query(conn(), $sql) or die(mysqli_error(conn()));
        $r = '';
        if (mysqli_num_rows($q1) > 0) {
            while ($row = mysqli_fetch_assoc($q1)) {
                $class = $row['name'];
                $r .= '<div class="box-header with-border">
                        <h3 class="box-title">Upload questions to '.$class.'</h3>
                      </div>';
                $r .='
                        <div class="box-body">
                            <div class="box box-info">
                                <div class="box-body">
                                    <form class="form-add" role="form" id="form-upload" enctype="multipart/form-data">
                                        <div class="input-group">
                                            <span class="input-group-addon">Select file</span>
                                            <input type="file" name="uploadFile" id="uploadFile" class="form-control" placeholder=""/>
                                            <input type="hidden" value="'.$test_id.'" name="test_id" id="test_id" class="" placeholder=""/>
                                               </div>
                                               <br/>
                                               <div class="input-group">
                                                   <span class="input-group-addon">Section</span>
                                                   <select class="form-control" name="section" id="section">
                                                       <option value="">-Select option-</option>
                                                       
                                                  
                                               ';
                                               for ($i=1; $i <= $row['components']; $i++) { 
                                                   $r .='<option value="'.$i.'">Section '.$i.'</option>';
                                               }
                                               $r .='
                                               </select>
                                               </div>
                                         <br/>
                        <input type="submit" id="upload" class="btn btn-primary form-control upload" rel="Question" value="Upload" placeholder="">


                <!-- /input-group -->


                                </form>
                                </div><!-- /input-group -->
                                <br/>
                                <div class="jumbotron msg">
                                    <div class="panel panel-defaut report">
                                            <ul class="text-danger ul">
                                                <li>Use the <a href="../question.csv" download>sample excel template</a> to insert ur questions</li>
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
                    <div class="jumbotron"><div class="panel"><h3> Upload Questions</h3></div></div>
                      </div>';
        }
        return $r;
    }

    public function getQuestionWordForm($test_id){
        $sql = "SELECT * FROM test WHERE test_id='" . $test_id . "' limit 1";
        $q1 = mysqli_query(conn(), $sql) or die(mysqli_error(conn()));
        $r = '';
        if (mysqli_num_rows($q1) > 0) {
            while ($row = mysqli_fetch_assoc($q1)) {
                $class = $row['name'];
                $r .= '<div class="box-header with-border">
                        <h3 class="box-title">Upload questions to '.$class.'</h3>
                      </div>';
                $r .='
                        <div class="box-body">
                            <div class="box box-info">
                                <div class="box-body">
                                    <form class="form-add" role="form" id="form-upload" enctype="multipart/form-data">
                                        <div class="input-group">
                                            <span class="input-group-addon">Select file</span>
                                            <input type="file" name="uploadFile" id="uploadFile" class="form-control" placeholder=""/>
                                            <input type="hidden" value="'.$test_id.'" name="test_id" id="test_id" class="" placeholder=""/>
                                         </div><br>
                                         <div class="input-group">
                                            <span class="input-group-addon">Section</span>
                                            <select class="form-control" name="section" id="section">
                                                <option value="">-Select option-</option>
                                                
                                           
                                        ';
                                        for ($i=1; $i <= $row['components']; $i++) { 
                                            $r .='<option value="'.$i.'">Section '.$i.'</option>';
                                        }
                                        $r .='
                                        </select>
                                        </div>
                                         <br/>
                                        <input type="submit" id="uploadWord" class="btn btn-primary form-control uploadWord" rel="Question" value="Upload" placeholder="">


                <!-- /input-group -->


                                </form>
                                </div><!-- /input-group -->
                                <br/>
                                <div class="jumbotron msg">
                                    <div class="panel panel-defaut report">
                                            <ul class="text-danger ul">
                                                <li>Make sure your document is in .docx format</li>
                                                <li>Make sure your docx file follow the CBT format.</li>
                                                <li>Download sample <a href="../card.docx">here</a> .</li>
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
                    <div class="jumbotron"><div class="panel"><h3> Upload Questions from Word Documents</h3></div></div>
                      </div>';
        }
        return $r;
    }

    public function forceSubmit($test_id,$batch){    
        if ($batch == 'all') {
            $Q = 'SELECT DISTINCT(schedule_student.stdid),test.* FROM schedule_student
                    INNER JOIN test
                        ON schedule_student.test_id = test.test_id
                        INNER JOIN sub_question sq ON sq.stud_id = schedule_student.stdid
                        WHERE schedule_student.stdid 
                            NOT IN (SELECT schedule_student.stdid FROM testscore ts INNER JOIN test t
                            ON t.test_id = ts.testid INNER JOIN schedule_student  
                                    ON schedule_student.stdid = ts.stdid
                            WHERE t.test_id = "'.$test_id.'") 
                        AND test.test_id = "'.$test_id.'"
                ';
        } else{   
        $Q = 'SELECT DISTINCT(schedule_student.stdid),test.* FROM schedule_student
                    INNER JOIN test
                        ON schedule_student.test_id = test.test_id
                        INNER JOIN sub_question sq ON sq.stud_id = schedule_student.stdid
                        WHERE schedule_student.stdid 
                            NOT IN (SELECT schedule_student.stdid FROM testscore ts INNER JOIN test t
                            ON t.test_id = ts.testid INNER JOIN schedule_student  
                                    ON schedule_student.stdid = ts.stdid
                            WHERE t.test_id = "'.$test_id.'" AND batch="'.$batch.'") 
                        AND test.test_id = "'.$test_id.'"   AND batch="'.$batch.'"
                ';
            }
        $q1 = mysqli_query(conn(), $Q) or die(mysqli_error(conn()));
        // echo mysqli_num_rows($q1);
        if (mysqli_num_rows($q1) >0) {
            while ($row = mysqli_fetch_assoc($q1)) {                
                $stdid = $row['stdid'];
                $test_id = $row['test_id'];
                $num_quest = $row['question_per_stud'];

                $sql = 'select * from test_attempt t
                INNER JOIN question q 
                ON quid = question_id
                where stdid = "'.$stdid.'" ';
                $correct =0;
                $wrong = 0;
                $unanswerered =0;
                $query = mysqli_query(conn(), $sql) or die(mysqli_error(conn()));
                // // echo mysqli_num_rows($query);
                if (mysqli_num_rows($query) >0) {
                    while ($row2 = mysqli_fetch_assoc($query)) {
                        $ans = $row2['ans'];
                        $right = $row2['answer'];
                        if($ans == $right){
                            $correct++;
                        }else{
                            $wrong++;
                        }
                    }
                }
                $unanswerered = $num_quest-($correct+$wrong);
                $submitted_at = date('Y-m-d h:i:s');
                $sql_submit = 'INSERT INTO testscore (stdid,testid,right_answered,wrong_answer,unanswered,date_time)
                                VALUES ("'.$stdid.'","'.$test_id.'", "'.$correct.'","'.$wrong.'","'.$unanswerered.'","'.$submitted_at.'")';    
                $query_submit = mysqli_query(conn(), $sql_submit) or die(mysqli_error(conn()));
                
            }
            
        }
    }


} 