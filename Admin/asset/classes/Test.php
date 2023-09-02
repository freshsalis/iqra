<?php
require_once 'db.php';
require_once '_Class.php';

/**
 * Created by PhpStorm.
 * User: freshsalis
 * Date: 8/21/2015
 * Time: 4:12 PM
 */
error_reporting(E_ALL ^ E_DEPRECATED);


class Test{

    private  $class;

    public function addTest()
    {
        if ($_POST['testTitle'] !='' && $_POST['duration']!='' && $_POST['qstn-student']!='' && $_POST['reservationtime']!='' && $_POST['quest-section']!='') {

            $title = clean($_POST['testTitle']);
            $class = clean($_POST['class_id']);
            $duration = clean($_POST['duration'])*60;
            $no_question= clean($_POST['qstn-student']);
            $date_range= clean($_POST['reservationtime'])."";
            $status= clean($_POST['status']);
            $instant= clean($_POST['iresult']);
            $breaker = strpos($date_range,'-');
            $start_time = clean(substr($date_range,0,$breaker));
            $stop_time = clean(substr($date_range,$breaker+1));
            $score= $no_question;
            $sections= clean($_POST['component']);
            $per_section= clean($_POST['quest-section']);
            $session= clean($_POST['session']);
            $batches= clean($_POST['batches']);
            $weight= clean($_POST['weight']);
            $instruction= clean($_POST['instruction']);



            // $s1 = 'select * from test WHERE name="' . $title . '"';
            // $q1 = mysqli_query(conn(), $s1) or die(mysqli_error(conn()));

            // if (mysqli_num_rows($q1) > 0) {
            //     echo 0; //test already exist
            // }
            // else {
                $sql = "insert into test(name,time,start_time,stop_time,class_id,
                question_per_stud,status,instant_result,earnable_score,components,question_per_component,session,batches,weight,instruction) 
                values('$title','$duration','$start_time','$stop_time',$class,
                '$no_question','$status','$instant','$score','$sections','$per_section','$session','$batches','$weight', '$instruction')";
                $q1 = mysqli_query(conn(), $sql) or die(mysqli_error(conn()));

                if ($q1) {
                    echo 1;
                } else {
                    echo mysqli_error(conn());
                }
            // }
            echo mysqli_error(conn());

        }else
            echo 3; //some fields required
    }

    public function getTestTable($class_id)
    {
        $class_name ='';
        $r = '';
        $r .= '


            <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>SN</th>
                    <th>Exam Name</th>
                    <th>Duration</th>
                    <th>Questions/Student</th>
                    <th>Weight</th>
                    <th>Sections</th>
                    <th>Questions/section</th>
                    <th>Session</th>
                    <th>Batches</th>
                    <th>Status</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
                </thead>
                <tbody>';
        $sql = "SELECT * FROM test t,class c WHERE t.class_id='".$class_id."' And
                c.class_id=t.class_id    ORDER BY name";
        $q1 = mysqli_query(conn(), $sql) or die(mysqli_error(conn()));
        $sn = 0;

        if (mysqli_num_rows($q1) > 0) {
            while ($row = mysqli_fetch_assoc($q1)) {
                $sn++;
                $class_name = $row['classname'];
                $id = $row['test_id'];
                $name = $row['name'];
                $duration = $row['time']/60;
                $qstn = $row['question_per_stud'];
                $session = $row['session'];
                $secion = $row['components'];
                $status = $row['status'];
                $batches = $row['batches'];
                $weight = $row['weight'];
                $quest_component = $row['question_per_component'];

                $r .= '<tr>
						<td>' . $sn . '</td>
						<td>' . $name . '</td>
						<td>' . $duration . ' minutes </td>
						<td>' . $qstn . ' </td>
						<td>' . $weight . ' </td>
						<td>' . $secion . ' </td>
						<td>' . $quest_component . ' </td>
						<td>' . $session. ' </td>
						<td>' . $batches. ' </td>
						<td>' . $status . ' </td>
						<td>
							<a title="edit" href="javascript:void(0)" rel="test" class="btn btn-primary btn-sm edit" data-toggle="modal" data-target="#addstudent" data-whatever="@mdo" onclick="mode(' . $id . ','.$class_id.');">
							    <span class="glyphicon glyphicon-pencil"></span>
							 </a>
                        </td>
                        <td>

							<a type="button" title="delete" class="btn btn-danger btn-sm delete"  rel="test" data-toggle="modal" data-target="#delete" data-whatever="@mdo" onclick="myDelete(' . $id . ','.$class_id.');"><span class="glyphicon glyphicon-trash"></span>
							</a>

						</td>
					</tr>



				';
            }
            echo '<div class="box-header with-border">
                        <h3 class="box-title">'.$class_name.' Exams</h3>
                      </div>';
        }
        else {
            $sql = "SELECT * FROM class WHERE class_id='" . $class_id . "' ORDER BY classname limit 1";
            $q1 = mysqli_query(conn(), $sql) or die(mysqli_error(conn()));
            if (mysqli_num_rows($q1) > 0) {
                $row = mysqli_fetch_assoc($q1);
                $class = $row['classname'];
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
                <th>Exam Name</th>
                <th>Duration</th>
                <th>Questions/Student</th>
                <th>Weight</th>
                <th>Sections</th>
                <th>Questions/section</th>
                <th>Session</th>
                <th>Batches</th>
                <th>Status</th>
                <th>Edit</th>
                <th>Delete</th>
                </tr>
                </tfoot>
            </table>
            </div>
        ';

        return $r;

    }

    public function getTokenTable($test_id)
    {
        $student = new Student();
        $class_name ='';

        $r = '
            <div class="box-body">
            <button data-toggle="modal" data-target="#del_batch_stud_modal" data-whatever="@mdo" test='.$test_id.' id="batch_del_student" class="btn btn-md btn-danger pull-right">Generate Token <span class="glyphicon glyphicon-delete"></span></button>
            <br><br/>
            <table id="example1" class="table table-bordered table-striped table-responsive">
                <thead>
                <tr>
                    <th>SN</th>
                    <th>Token</th>
                    <th>Assigned to</th>
                </tr>
                </thead>
                <tbody>';
            $sql = "SELECT * FROM access_token s INNER JOIN test t ON  t.test_id=exam_id
                     WHERE exam_id='".$test_id."' ";
        
        
        $q1 = mysqli_query(conn(), $sql) or die(mysqli_error(conn()));
        $sn = 0;

        if (mysqli_num_rows($q1) > 0) {
            while ($row = mysqli_fetch_assoc($q1)) {
                $sn++;
                 $class_name = $row['name'];

                $token = $row['token'];
                $assigned = is_null($row['user_id']) ? "<b class='text-danger'>Not assigned</b>" : "<b class='text-success'>".$student->getStudentName($row['user_id'])."</b>";

                $r .= '<tr>
                            <td>' . $sn . '</td>
                            <td><b>' . $token . '</b></td>
                            <td>' . $assigned . ' </td>
						</tr>
				';
            }            echo '<div class="box-header with-border">
                        <h1 class="box-title">'.$class_name.' tokens</h1>
                      </div>';
        }
       
        $r .= '
                </tbody>
                <tfoot>
                <tr>
                    <th>SN</th>
                    <th>Token</th>
                    <th>Assigned to</th>
                </tr>
                </tfoot>
            </table>
            </div>
        ';

        return $r;

    }

    public function getEditTest(){
        $idm = $_POST['idm'];
        $sql = 'select * from test WHERE test_id="'.$idm.'" limit 1';
        $q1 = mysqli_query(conn(), $sql) or die(mysqli_error(conn()));
        $row = mysqli_fetch_assoc($q1);
        $title = $row['name'];
        $duration = $row['time']/60;
        $class_id = $row['class_id'];
        $qstn = $row['question_per_stud'];
        $start = $row['start_time'];
        $stop = $row['stop_time'];
        $status = $row['status'];
        $instant = $row['instant_result'];
        $sections = $row['components'];
        $sections_quest = $row['question_per_component'];
        $batches = $row['batches'];
        $weight = $row['weight'];

        return $this -> getTestModal($title,$duration,$qstn,$class_id,$start.'-'.$stop,$status,$instant,$sections,$sections_quest,$batches,$weight);

    }

    function getTestModal($title='',$duration='',$qstn='',$class_id,$date='',$status,$instant,$sections,$sections_quest,$batches,$weight){
        $this->class = new _Class();
        $r ='<div class="panel panel-success cbtlogin" >
                            <div class="panel-body">
                               <div id="error"></div>
                                <form class="form-horizontal stdform" method="post" name="form1" id="studentForm">
                                    <div class="box-body">
                                            <div class="input-group">
                                                <span class="input-group-addon">Test Title</span>
                                                <input type="text" value="'.$title.'" name="testTitle" id="testTitle" class="form-control" placeholder="">
                                            </div>
                                            <br/>
                                            <div class="input-group">
                                                <span class="input-group-addon">Duration</span>
                                                <input type="number" value="'.$duration.'" name="duration" id="duration" class="form-control" placeholder="In minutes">
                                            </div><br/>
                                            <div class="input-group">
                                                <span class="input-group-addon">Question per Student</span>
                                                <input type="number" value="'.$qstn.'"  name="qstn-student" id="qstn-student" class="form-control" placeholder="No. of question per student">
                                            </div><br>
                                            <div class="input-group">
                                                <span class="input-group-addon">Weight (marks per right answer)</span>
                                                <input type="number" value="'.$weight.'"  name="weight" id="weight" class="form-control" placeholder="No. of question per student">
                                            </div><br>
                                            <div class="input-group">
                                                <span class="input-group-addon">Number of Sections</span>
                                                <input type="number" value="'.$sections.'"  name="component" id="component" class="form-control" placeholder="No. of sections">
                                            </div><br>
                                            <div class="input-group">
                                                <span class="input-group-addon">Questions per Sections (comma separated)</span>
                                                <input type="text"  name="quest-section" value="'.$sections_quest.'" id="quest-section" class="form-control" placeholder="50,30,30">
                                            </div><br>
                                            <div class="input-group">
                                                <span class="input-group-addon">No. of bactches</span>
                                                <input type="number" default="1" min="1" value="'.$batches.'"  name="batches" id="baches" class="form-control" placeholder="50,30,30">
                                            </div><br>
                                            
                                            <div class="input-group">
                                                <span class="input-group-addon">Time range</span>
                                                    <input type="text" value="'.$date.'" name="reservationtime"  class="form-control pull-right" id="reservationtime"/>
                                            </div>
                                            <br/>
                                <div class="input-group">
                                                <span class="input-group-addon">Class</span>

                                    ';
        $r.= $this ->class ->getClassCombo($class_id);
        $r.='
                                    </select>
                                </div><br/>
                                <div class="input-group">
                                                <span class="input-group-addon">Status</span>
                                                <select  class="form-control" name="status" id="status">';
                                                if ($status =='Pending') {
                                                    $r .='<option >Active</option>
                                                    <option selected>Pending</option>
                                                    <option>Completed</option>';
                                                }elseif ($status == 'Completed') {
                                                    $r .='<option>Active</option>
                                                    <option >Pending</option>
                                                    <option selected>Completed</option>';
                                                }
                                                elseif ($status == 'Active') {
                                                    $r .='<option selected>Active</option>
                                                    <option >Pending</option>
                                                    <option >Completed</option>';
                                                }else {
                                                    $r .='<option>Active</option>
                                                    <option>Pending</option>
                                                    <option>Completed</option>';
                                                }
                                                $r .='
                                                    
                                                </select>
                                            </div>
                                            <br/>
                                            <div class="input-group">
                                                <span class="input-group-addon">Instant result</span>
                                                <select  class="form-control" name="iresult" id="iresult">
                                                    ';
                                                    if ($instant ==0) {
                                                        $r .='<option value="0" selected>No</option>
                                                        <option value="1">Yes</option>';
                                                    }elseif ($instant == 1) {
                                                        $r .='<option value="0" >No</option>
                                                        <option value="1" selected>Yes</option>';
                                                    }
                                                    $r .='
                                                </select>
                                            </div>
                                            <br/>
                                        </div><!-- /input-group -->

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

    public function  editTest(){
        $title = clean($_POST['testTitle']);
        $class = clean($_POST['sclass']);
        $duration = clean($_POST['duration'])*60;
        $no_question= clean($_POST['qstn-student']);
        $date_range= clean($_POST['reservationtime'])."";
        $status= clean($_POST['status']);
        $instant= clean($_POST['iresult']);
        $breaker = strpos($date_range,'-');
        $start_time = clean(substr($date_range,0,$breaker));
        $stop_time = clean(substr($date_range,$breaker+1));
        $score= $no_question;
        $sections= clean($_POST['component']);
        $per_section= clean($_POST['quest-section']);
        $batches= clean($_POST['batches']);
        $weight= clean($_POST['weight']);


        $idm = $_POST['idm'];

        $sql = 'UPDATE test SET name="'.$title.'",
                time="'.$duration.'",
                class_id="'.$class.'",
                question_per_stud="'.$no_question.'",
                status="'.$status.'",
                start_time="'.$start_time.'",
                instant_result="'.$instant.'",
                stop_time="'.$stop_time.'",
                earnable_score="'.$score.'",
                components="'.$sections.'",
                question_per_component="'.$per_section.'",
                weight="'.$weight.'",
                batches="'.$batches.'"
                WHERE test_id="'.$idm.'" ';
        $q1 = mysqli_query(conn(), $sql) or die(mysqli_error(conn()));



        if($q1){
            echo  1;
        }else echo mysqli_error(conn());

    }

    public function delete($idm){
        $sql = 'delete from test where test_id="'.$idm.'"' ;
        $q1 = mysqli_query(conn(), $sql) or die(mysqli_error(conn()));

        if($q1){
            echo 1;
        }else echo mysqli_error(conn());
    }

    public function getTestForm($class_id){
        $sql = "SELECT * FROM class WHERE class_id='" . $class_id . "' ORDER BY classname";
        $q1 = mysqli_query(conn(), $sql) or die(mysqli_error(conn()));
        $r = '';
        if (mysqli_num_rows($q1) > 0) {
            while ($row = mysqli_fetch_assoc($q1)) {
                $class = $row['classname'];
                $r .= '<div class="box-header with-border">
                        <h3 class="box-title">Add Exam to '.$class.'</h3>
                      </div>';
                $r .='
                        <div class="box-body">
                            <div class="box box-info">
                                <div class="box-body">
                                    <form class="form-add" role="form" id="form-add">
                                        <div class="box-body">
                                            <div class="input-group">
                                                <span class="input-group-addon">Exam Name (Course code) </span>
                                                <input type="text" name="testTitle" id="testTitle" class="form-control" placeholder="">
                                                <input type="hidden" value="'.$class_id.'" name="class_id" id="class_id" class="" placeholder="">
                                            </div>
                                            <br/>
                                            <div class="input-group">
                                                <span class="input-group-addon">Duration</span>
                                                <input type="number" name="duration" id="duration" class="form-control" placeholder="In minutes">
                                            </div><br/>
                                            <div class="form-group">
                                                <label>Date and time range:</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-clock-o"></i>
                                                    </div>
                                                    <input type="text" name="reservationtime"  class="form-control pull-right" id="reservationtime"/>
                                                </div><!-- /.input group -->
                                            </div><!-- /.form group -->
                                            <div class="input-group">
                                                <span class="input-group-addon">Academic Session:</span>
                                                <input type="text"  name="session" id="session" class="form-control" placeholder="">
                                            </div><br>
                                            <div class="input-group">
                                                <span class="input-group-addon">Question per Student</span>
                                                <input type="number"  name="qstn-student" id="qstn-student" class="form-control" placeholder="No. of question per student">
                                            </div><br>
                                            <div class="input-group">
                                                <span class="input-group-addon">Weight (Marks per right answer)</span>
                                                <input type="number" value="1"  name="weight" id="weight" class="form-control" placeholder="No. of question per student">
                                            </div><br>
                                            <div class="input-group">
                                                <span class="input-group-addon">Number of Sections</span>
                                                <input type="number" value="1"  name="component" id="component" class="form-control" placeholder="No. of sections">
                                            </div><br>
                                            <div class="input-group">
                                                <span class="input-group-addon">Questions per Sections (sect1,sect2,sect3)</span>
                                                <input type="text"  name="quest-section" id="quest-section" class="form-control" placeholder="50,30,30">
                                            </div><br>
                                            <div class="input-group">
                                                <span class="input-group-addon">No. of bactches</span>
                                                <input type="number" default="1" min="1" value="1"  name="batches" id="baches" class="form-control" placeholder="50,30,30">
                                            </div><br>
                                            <div class="input-group">
                                                <span class="input-group-addon">Status</span>
                                                <select  class="form-control" name="status" id="status">
                                                    <option>Pending</option>
                                                    <option>Active</option>
                                                </select>
                                            </div>
                                            <br/>
                                            <div class="input-group">
                                                <span class="input-group-addon">Instant result</span>
                                                <select  class="form-control" name="iresult" id="iresult">
                                                    <option value="0">No</option>
                                                    <option value="1">Yes</option>
                                                </select>
                                            </div>
                                            <br>
                                            <div class="input-group hidden" >
                                                <span class="input-group-addon">Earnable score</span>
                                                <input type="number" name="score" id="score" class="form-control" placeholder="">
                                            </div>
                                            <div class="input-group">
                                                <b>Exam Instructions: </b>
                                                <textarea class="col-lg-12 form-control" id="editor2" name=""></textarea>
                                            </div>
                                            <br>
                                        </div><!-- /input-group -->

                                                    <br/>
                                                    <input type="submit" id="add" class="btn btn-primary form-control add" rel="test" value="Add" placeholder="">
                                </form>
                                </div><!-- /input-group -->
                                <br/>
                                <div class="jumbotron msg" id="msg"></div>

                            </div><!-- /.box-body -->
                        </div><!-- /.box -->

                ';

            }
        }
        else{
            $r .='<div class="box-header with-border">
                    <div class="jumbotron"><div class="panel"><h3> Add Tests</h3></div></div>
                      </div>';
        }
        return $r;
    }

    public function getTestMenu($idm = '', $url)
    {
        $r = '
            <div class="box box-solid" style="height: 500px;;overflow:scroll;">
                <div class="box-header with-border">
                    <h3 class="box-title">Tests</h3>
                </div>
                <div class="box-body no-padding">
                    <ul class="nav nav-pills nav-stacked">
                    ';
        $sql = "SELECT * FROM test INNER JOIN class ON class.class_id=test.class_id ORDER BY test_id DESC limit 50";
        $q1 = mysqli_query(conn(), $sql) or die(mysqli_error(conn()));
        $sn = 0;

        if (mysqli_num_rows($q1) > 0) {
            while ($row = mysqli_fetch_assoc($q1)) {
                $sn++;
                $id = $row['test_id'];
                $class = $row['name'];
                $session = $row['session'];

                if ($idm == $id) {
                    $r .= '
                        <li class="active"><a href="' . $url . $id . '" id="' . $id . '"><i class="glyphicon glyphicon-th-list"></i> ' . $class . ' - '.$session.'<span class="label label-primary pull-right"><span class="glyphicon glyphicon-chevron-down"></span></span></a></li>
                       ';
                } else {
                    $r .= '
                        <li class=""><a href="' . $url . $id . '" id="' . $id . '"><i class="glyphicon glyphicon-th-list"></i> ' . $class . ' - '.$session.' <span class="label label-primary pull-right"><span class="glyphicon glyphicon-chevron-right"></span></span></a></li>
                       ';
                }

            }
        } else
            $r .= ' No tests found';
        $r .= '
                    </ul>
                </div><!-- /.box-body -->
        </div><!-- /. box -->

        ';
        return $r;
    }
    public function getBatchMenu($idm='' , $url,$batch=0)
    {
        $r = '
            <div class="box box-solid" >
                <div class="box-header with-border">
                    <h3 class="box-title">Batches</h3>
                </div>
                <div class="box-body no-padding">
                    <ul class="nav nav-pills nav-stacked">
                    ';
        $sql = "SELECT * FROM test WHERE test_id='".$idm."'";
        $q1 = mysqli_query(conn(), $sql) or die(mysqli_error(conn()));
        if (mysqli_num_rows($q1) > 0) {
            $row = mysqli_fetch_assoc($q1);
            $section = $row['batches']+0;
        
            for ($i=1; $i <= $section; $i++) { 
                        if ($i == $batch) {
                            $r .= '
                                <li class="active"><a href="' . $url. '?id=' . $idm . '&batch='.$i.' ">
                                <i class="glyphicon glyphicon-th-list"></i> Batch' .$i.'<span class="label label-primary pull-right">
                                <span class="glyphicon glyphicon-chevron-down"></span></span></a></li>
                               ';
                        } else {
                            $r .= '
                                <li class=""><a href="' . $url. '?id=' . $idm . '&batch='.$i.' ">
                                <i class="glyphicon glyphicon-th-list"></i> Batch' .$i.'<span class="label label-primary pull-right">
                                <span class="glyphicon glyphicon-chevron-down"></span></span></a></li>
                               ';
                        }
            }
            if ($batch === 'all') {
                $r .= '
                <li class="active"><a href="' . $url. '?id=' . $idm . '&batch=all ">
                <i class="glyphicon glyphicon-th-list"></i>All Batches<span class="label label-primary pull-right">
                <span class="glyphicon glyphicon-chevron-down"></span></span></a></li>
               ';
            }else {
                $r .= '
                <li class=""><a href="' . $url. '?id=' . $idm . '&batch=all ">
                <i class="glyphicon glyphicon-th-list"></i>All Batches<span class="label label-primary pull-right">
                <span class="glyphicon glyphicon-chevron-down"></span></span></a></li>
               ';
            }
           

        }

            
        
        $r .= '
                    </ul>
                </div><!-- /.box-body -->
        </div><!-- /. box -->

        ';
        return $r;
    }
    public function getActiveTestMenu($idm = '', $url)
    {
        $r = '
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Active Tests</h3>
                </div>
                <div class="box-body no-padding">
                    <ul class="nav nav-pills nav-stacked">
                    ';
        $sql = "SELECT * FROM test INNER JOIN class 
                ON class.class_id=test.class_id WHERE status='Active' ORDER BY test_id DESC limit 20";
        $q1 = mysqli_query(conn(), $sql) or die(mysqli_error(conn()));
        $sn = 0;

        if (mysqli_num_rows($q1) > 0) {
            while ($row = mysqli_fetch_assoc($q1)) {
                $sn++;
                $id = $row['test_id'];
                $class = $row['name'];

                if ($idm == $id) {
                    $r .= '
                        <li class="active"><a href="' . $url . $id . '" id="' . $id . '"><i class="glyphicon glyphicon-th-list"></i> ' . $class . ' <span class="label label-primary pull-right"><span class="glyphicon glyphicon-chevron-down"></span></span></a></li>
                       ';
                } else {
                    $r .= '
                        <li class=""><a href="' . $url . $id . '" id="' . $id . '"><i class="glyphicon glyphicon-th-list"></i> ' . $class . ' <span class="label label-primary pull-right"><span class="glyphicon glyphicon-chevron-right"></span></span></a></li>
                       ';
                }

            }
        } else
            $r .= ' No tests found';
        $r .= '
                    </ul>
                </div><!-- /.box-body -->
        </div><!-- /. box -->

        ';
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

        $sql = "select * FROM track_timer WHERE stdid='".$studentId."' AND test_id='".$testid."'";
        $query = mysqli_query(conn(), $sql) or die(mysqli_error(conn()));
        if(mysqli_num_rows($query) > 0){
            $sql2 = "UPDATE track_timer SET time='".$time."' WHERE stdid='".$studentId."' AND test_id='".$testid."'";
            $query2 = mysqli_query(conn(), $sql2) or die(mysqli_error(conn()));
            if($query2) echo "updated";
        }else{
            $sql2 = "INSERT INTO track_timer (stdId,test_id,time) VALUES('','".$studentId."','".$testid."','".$time."')";
            $query2 = mysqli_query(conn(), $sql2) or die(mysqli_error(conn()));
            if($query2) echo "inserted";
        }
    }

    public function getTestCount($status)
    {
        $count =0;


        $sql = "SELECT COUNT(test_id) AS cc FROM test t,class c WHERE t.status='".$status."' And
                c.class_id=t.class_id  ";
        $q1 = mysqli_query(conn(), $sql) or die(mysqli_error(conn()));
        $sn = 0;

        if (mysqli_num_rows($q1) > 0) {
            while ($row = mysqli_fetch_assoc($q1)) {
                $sn++;
                $count = $row['cc'];
            }

        }

        return $count;

    }

    function getTestCombo($default=''){
        $s="SELECT * FROM test INNER JOIN class ON class.class_id=test.class_id where status='active'";
        $sql = mysqli_query(conn(), $s) or die(mysqli_error(conn()));
        $select= '<select name="test" id="test" class="col-lg-12 form-control">';

        if(mysqli_num_rows($sql) >0){
            while($rs=mysqli_fetch_array($sql)){
                $title = $rs['name'];
                $id = $rs['test_id'];

                if($default !='' && $default ==$id) {
                    $option = '<option value=' . $id . ' selected>' . $title . '</option>';
                    $select .= $option;
                }else{
                    $option = '<option value=' . $id . '>' . $title . '</option>';
                    $select .= $option;
                }
            }
        }
        $select.='</select>';
        //check for the selected option
        return $select;

    }

    public function attendance($test_id,$batch)
    {
        $class_name ='';
        $r = '';
        $r .= '


            <div class="box-body">
            
            <table id="example1" class="table table-bordered table-responsive table-striped">
                <thead>
                <tr>
                    <th>SN</th>
                    <th>REG.NO</th>
                    <th>FULLNAME</th>
                    <th>PROGRAM</th>
                    <th>STARTED AT</th>
                    <th>TIME SPENT (min.)</th>
                    <th>ATTEMPTS</th>
                    <th>TOTAL QUEST.</th>
                    <th>IP ADR.</th>
                </tr>
                </thead>
                <tbody>';
        if ($batch ==='all') {
            $sql = "SELECT *
                FROM schedule_student
                INNER JOIN attendance a ON a.stdid = schedule_student.stdid
                INNER JOIN test
                ON schedule_student.test_id = test.test_id
                WHERE schedule_student.test_id = '".$test_id."'";
        }else{
        $sql = "SELECT *
                FROM schedule_student
                INNER JOIN attendance a ON a.stdid = schedule_student.stdid
                INNER JOIN test
                ON schedule_student.test_id = test.test_id
                WHERE schedule_student.test_id = '".$test_id."' AND batch='".$batch."'";
        }
        $q1 = mysqli_query(conn(), $sql) or die(mysqli_error(conn()));
        $sn = 0;
        $test = '';
        if (mysqli_num_rows($q1) > 0) {
            while ($row = mysqli_fetch_assoc($q1)) {
                $sn++;
                $name = $row['surname']." ".$row['othername'];
                $dept = $row['dept'];
                $regno = $row['reg_no'];
                $time_in = $row['time_in'];
                $ip = $row['ip_address'];
                $test = $row['name'];
                $track_timer = $this->timeSpent($row['stdid']);
                $test_time = $row['time'];
                $spent = round(($test_time-$track_timer)/60);
                if(($spent+3) < round($test_time/60)){
                    $spent = $spent+3;
                }
                $r .= '<tr>
						<td>' . $sn . '</td>
                        <td>' . $regno . ' </td>
						<td>' . $name . '</td>
						<td>' . $dept. ' </td>
						<td>' . $time_in . ' </td>
						<td>' . $spent.' </td>
						<td>' . $this->testAttempts($row['stdid']) .' </td>
						<td>' .$row['question_per_stud'].' </td>
						<td>' . $ip . ' </td>						
					</tr>



				';
            }
              
                $r .= '
                </tbody>
                <tfoot>
                <tr>
                    <th>SN</th>
                    <th>REG.NO</th>
                    <th>FULLNAME</th>
                    <th>PROGRAM</th>
                    <th>STARTED AT</th>
                    <th>TIME SPENT</th>
                    <th>ATTEMPT</th>
                    <th>IP ADDRESS</th>
                </tr>
                </tfoot>
            </table>
            </div>
        ';
            echo '<div class="box-header with-border">
                        <h3 class="box-title">'.$test.' Attendance (Batch: '.$batch.')</h3>
                      </div>';
            echo '<div class="box-header with-border">
                <a href="../attendanceExcel.php?tid='.$test_id.'&batch='.$batch.'"class="btn btn-md btn-primary pull-right" id="download" rel="'.$class_name.'">Download <span class="glyphicon glyphicon-download-alt"></span></a>

        </div>';
        }
        else {
            $r .='<div class="box-header with-border">
                    <div class="jumbotron"><div class="panel"><h3> ATTENDANCE</h3></div></div>
                      </div>';
            }
      

        return $r;

    }
    public function resetExams($test_id,$batch)
    {
        $class_name ='';
        $r = '';
        $r .= '


            <div class="box-body">
            
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>SN</th>
                    <th>REG.NO</th>
                    <th>FULLNAME</th>
                    <th>STARTED AT</th>
                    <th>TIME SPENT</th>
                    <th>ATTEMPTS</th>
                    <th>IP ADDRESS</th>
                    <th>ACTION</th>
                </tr>
                </thead>
                <tbody>';
        if ($batch ==='all') {
            $sql = "SELECT *
                FROM schedule_student
                INNER JOIN attendance a ON a.stdid = schedule_student.stdid
                INNER JOIN test
                ON schedule_student.test_id = test.test_id
                WHERE schedule_student.test_id = '".$test_id."'";
        }else{
        $sql = "SELECT *
                FROM schedule_student
                INNER JOIN attendance a ON a.stdid = schedule_student.stdid
                INNER JOIN test
                ON schedule_student.test_id = test.test_id
                WHERE schedule_student.test_id = '".$test_id."' AND batch='".$batch."'";
        }
        $q1 = mysqli_query(conn(), $sql) or die(mysqli_error(conn()));
        $sn = 0;
        $test = '';
        if (mysqli_num_rows($q1) > 0) {
            while ($row = mysqli_fetch_assoc($q1)) {
                $sn++;
                $name = $row['surname']." ".$row['othername'];
                $id = $row['stdid'];
                $regno = $row['reg_no'];
                $time_in = $row['time_in'];
                $ip = $row['ip_address'];
                $test = $row['name'];
                $track_timer = $this->timeSpent($row['stdid']);
                $test_time = $row['time'];
                $spent = round(($test_time-$track_timer)/60);
                if(($spent+3) < round($test_time/60)){
                    $spent = $spent+3;
                }
                $r .= '<tr>
						<td>' . $sn . '</td>
                        <td>' . $regno . ' </td>
						<td>' . $name . '</td>
						<td>' . $time_in . ' </td>
						<td>' . $spent.'/'.($row['time']/60).' </td>
						<td>' . $this->testAttempts($row['stdid']) . '/'.$row['question_per_stud'].' </td>
						<td>' . $ip . ' </td>	
                        <td>

							<a type="button" title="delete" class="btn btn-danger btn-sm resetM" level="ind" batch="'.$batch.'" name="'.$regno.'"  rel="'.$id.'" data-toggle="modal" data-target="#reset_modal" data-whatever="@mdo">
                             Reset <span class="glyphicon glyphicon-refresh"></span>
							</a>

						</td>					
					</tr>



				';
            }
              
                $r .= '
                </tbody>
                <tfoot>
                <tr>
                    <th>SN</th>
                    <th>REG.NO</th>
                    <th>FULLNAME</th>
                    <th>PROGRAM</th>
                    <th>STARTED AT</th>
                    <th>TIME SPENT</th>
                    <th>ATTEMPT</th>
                    <th>IP ADDRESS</th>
                </tr>
                </tfoot>
            </table>
            </div>
        ';
            echo '<div class="box-header with-border">
                        <h3 class="box-title">'.$test.' Attendance (Batch: '.$batch.')</h3>
                      </div>';
            echo '<div class="box-header with-border">
                <a href="#" class="btn btn-md btn-danger resetM pull-right" level="batch" data-toggle="modal" name="batch: '.$batch.'" batch="'.$batch.'" data-target="#reset_modal" rel="'.$test_id.'">
                RESET EXAM (Batch: '.$batch.') <span class="glyphicon glyphicon-refresh"></span></a>

        </div>';
        }
        else {
            $r .='<div class="box-header with-border">
                    <div class="jumbotron"><div class="panel"><h3> NO ITEMS SELECTED</h3></div></div>
                      </div>';
            }
      

        return $r;

    }
    public function resetSoftware($user,$password)
    {
        $class_name ='';
        $sql="select * from admin where username='$user' and password='$password' ";
		$qry=mysqli_query(conn(), $sql) or die(mysqli_error(conn()));
		$numrows = mysqli_num_rows($qry);

		if ($numrows ==1){
                $del2="DELETE FROM  attendance ";
                $response2= mysqli_query(conn(), $del2) or die(mysqli_error(conn()));
                $del4="DELETE FROM  testscore ";
                $response1= mysqli_query(conn(), $del4) or die(mysqli_error(conn()));
                $del5="DELETE FROM  track_timer";
                $response1= mysqli_query(conn(), $del5) or die(mysqli_error(conn()));
                $del6="DELETE FROM  sub_question";
                $response1= mysqli_query(conn(), $del6) or die(mysqli_error(conn()));
                $del7="DELETE FROM  test_attempt";
                $response7= mysqli_query(conn(), $del7) or die(mysqli_error(conn()));
                $del8="DELETE FROM  question";
                $response8= mysqli_query(conn(), $del8) or die(mysqli_error(conn()));
                $del9="DELETE FROM  test";
                $response9= mysqli_query(conn(), $del9) or die(mysqli_error(conn()));
                $del="DELETE FROM  schedule_student";
                $response= mysqli_query(conn(), $del) or die(mysqli_error(conn()));
                $del10="DELETE FROM  schedule_student";
                $response10= mysqli_query(conn(), $del10) or die(mysqli_error(conn()));
                $del11="DELETE FROM  access_token";
                $response11= mysqli_query(conn(), $del11) or die(mysqli_error(conn()));
                return 1;
                        
        }else{
            return -1;
       }
    }
    public function absentees($test_id,$batch)
    {
        $class_name ='';
        $r = '';
        $r .= '


            <div class="box-body">
            
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>SN</th>
                    <th>REG.NO</th>
                    <th>FULLNAME</th>
                    <th>PROGRAM</th>                    
                </tr>
                </thead>
                <tbody>';
        if ($batch ==='all') {
            $sql = "SELECT *
                FROM schedule_student as s INNER JOIN test t ON t.test_id=s.test_id
                WHERE s.stdid NOT IN ( SELECT stdid from attendance a where a.test_id = '".$test_id."')
                AND s.test_id = '".$test_id."'";
        }else{
        $sql = "SELECT *
                FROM schedule_student as s INNER JOIN test t ON t.test_id=s.test_id
                WHERE s.stdid NOT IN ( SELECT stdid from attendance a where a.test_id = '".$test_id."')
                AND s.test_id = '".$test_id."' AND batch='".$batch."'";
        }
        $q1 = mysqli_query(conn(), $sql) or die(mysqli_error(conn()));
        $sn = 0;
        $test = '';
        if (mysqli_num_rows($q1) > 0) {
            while ($row = mysqli_fetch_assoc($q1)) {
                $sn++;
                $name = $row['surname']." ".$row['othername'];
                $dept = $row['dept'];
                $regno = $row['reg_no'];
                
                $test = $row['name'];
                $r .= '<tr>
						<td>' . $sn . '</td>
                        <td>' . $regno . ' </td>
						<td>' . $name . '</td>
						<td>' . $dept . ' </td>											
					</tr>
				';
            }
              
                $r .= '
                </tbody>
                <tfoot>
                <tr>
                    <th>SN</th>
                    <th>REG.NO</th>
                    <th>FULLNAME</th>
                    <th>PROGRAM</th>
                    
                </tr>
                </tfoot>
            </table>
            </div>
        ';
            echo '<div class="box-header with-border">
                        <h3 class="box-title">'.$test.' Attendance (Batch: '.$batch.')</h3>
                      </div>';
            echo '<div class="box-header with-border">
                <a href="../absenteesExcel.php?tid='.$test_id.'&batch='.$batch.'"class="btn btn-md btn-primary pull-right" id="download" rel="'.$class_name.'">Download <span class="glyphicon glyphicon-download-alt"></span></a>

        </div>';
        }
        else {
            $r .='<div class="box-header with-border">
                    <div class="jumbotron"><div class="panel"><h3> ABSENTEES</h3></div></div>
                      </div>';
            }
      

        return $r;

    }
    public function without_score($test_id,$batch)
    {
        $class_name ='';
        $r = '';
        $r .= '


            <div class="box-body">
            
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>SN</th>
                    <th>REG.NO</th>
                    <th>FULLNAME</th>
                    <th>PROGRAM</th>  
                    <th>TIME IN</th>
                    <th>IP</th>
                </tr>
                </thead>
                <tbody>';
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
        $q1 = mysqli_query(conn(), $sql) or die(mysqli_error(conn()));
        $sn = 0;
        $test = '';
        if (mysqli_num_rows($q1) > 0) {
            while ($row = mysqli_fetch_assoc($q1)) {
                $sn++;
                $name = $row['surname']." ".$row['othername'];
                $dept = $row['dept'];
                $regno = $row['reg_no'];
                $time_in = $row['time_in'];
                $ip = $row['ip_address'];
                
                $test = $row['name'];
                $r .= '<tr>
						<td>' . $sn . '</td>
                        <td>' . $regno . ' </td>
						<td>' . $name . '</td>
						<td>' . $dept . '</td>
						<td>' . $time_in . ' </td>											
						<td>' . $ip . ' </td>											
					</tr>
				';
            }
              
                $r .= '
                </tbody>
                <tfoot>
                <tr>
                    <th>SN</th>
                    <th>REG.NO</th>
                    <th>FULLNAME</th>
                    <th>PROGRAM</th>
                    <th>TIME IN</th>
                    <th>IP</th>
                    
                </tr>
                </tfoot>
            </table>
            </div>
        ';
            echo '<div class="box-header with-border">
                        <h3 class="box-title">'.$test.' - Attendance without score (Batch: '.$batch.')</h3>
                      </div>';
            echo '<div class="box-header with-border">
                <a href="../without_scoreExcel.php?tid='.$test_id.'&batch='.$batch.'"class="btn btn-md btn-primary pull-right" id="download" rel="'.$class_name.'">Download <span class="glyphicon glyphicon-download-alt"></span></a>

        </div>';
        }
        else {
            $r .='<div class="box-header with-border">
                    <div class="jumbotron"><div class="panel"><h3> ABSENTEES</h3></div></div>
                      </div>';
            }
      

        return $r;

    }
    public function testAttempts($id)
    {
                   
            $sql = "SELECT count(atid) as r
                FROM test_attempt 
                WHERE stdid='".$id."'";
       
        $q1 = mysqli_query(conn(), $sql) or die(mysqli_error(conn()));
        
        
        $row = mysqli_fetch_assoc($q1);
        
        return $row['r'];

    }
    public function timeSpent($id)
    {
                   
            $sql = "SELECT time
                FROM track_timer 
                WHERE stdId='".$id."'";
       
        $q1 = mysqli_query(conn(), $sql) or die(mysqli_error(conn()));
        
        if (mysqli_num_rows($q1) > 0) {
            $row = mysqli_fetch_assoc($q1);
        
            return $row['time'];
        }else{
            return 0;
        }
        

    }
    public function resetExam($name,$password,$rel,$level,$batch)
    {
        $class_name ='';
        $sql="select * from admin where username='$name' and password='$password' ";
		$qry=mysqli_query(conn(), $sql) or die(mysqli_error(conn()));
		$numrows = mysqli_num_rows($qry);

		if ($numrows ==1){
            if ($level == 'ind') {
                $del2="DELETE FROM attendance   WHERE stdid='".$rel."' ";
                $response2= mysqli_query(conn(), $del2) or die(mysqli_error(conn()));
                $del4="DELETE FROM testscore   WHERE stdid='".$rel."' ";
                $response1= mysqli_query(conn(), $del4) or die(mysqli_error(conn()));
                $del5="DELETE FROM track_timer   WHERE stdId='".$rel."' ";
                $response1= mysqli_query(conn(), $del5) or die(mysqli_error(conn()));
                $del6="DELETE FROM sub_question   WHERE stud_id='".$rel."' ";
                $response1= mysqli_query(conn(), $del6) or die(mysqli_error(conn()));
                $del7="DELETE FROM test_attempt   WHERE stdid='".$rel."' ";
                $response7= mysqli_query(conn(), $del7) or die(mysqli_error(conn()));
            
                return 1;
            }else{
                if ($batch == 'all') {
                    
                    $del2="DELETE FROM attendance   WHERE test_id='".$rel."' ";
                    $response2= mysqli_query(conn(), $del2) or die(mysqli_error(conn()));
                    $del4="DELETE FROM testscore   WHERE testid='".$rel."' ";
                    $response1= mysqli_query(conn(), $del4) or die(mysqli_error(conn()));
                    $del5="DELETE FROM track_timer   WHERE test_id='".$rel."' ";
                    $response1= mysqli_query(conn(), $del5) or die(mysqli_error(conn()));
                    $del6="DELETE FROM sub_question   WHERE test_id='".$rel."' ";
                    $response1= mysqli_query(conn(), $del6) or die(mysqli_error(conn()));

                    return 1;
                    
                }else{
                    $del="DELETE FROM schedule_student 
                    WHERE test_id='".$rel."' AND batch='".$batch."'";
                    $response= mysqli_query(conn(), $del) or die(mysqli_error(conn()));

                    if ($response) {
                        return 1;
                    }
                    
                }
            }
            
	 	}else{
	 	    return -1;
		}
        
        

       
        return ;

    }

}