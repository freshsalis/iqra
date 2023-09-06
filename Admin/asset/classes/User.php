<?php
require_once 'db.php';

/**
 * Created by PhpStorm.
 * User: freshsalis
 * Date: 8/21/2015
 * Time: 4:12 PM
 */
error_reporting(E_ALL ^ E_DEPRECATED);

class User
{
    public function getHeader()
    {
        return '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>Test Master || Admin</title>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <!-- Bootstrap 3.3.2 -->
            <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
            <link href="plugins/daterangepicker/daterangepicker.css" type="text/css" />
            <link
            rel="shortcut icon"
            type="image/x-icon"
            href="../logo.png"
          />
            <!-- Font Awesome Icons -->
            <!-- DATA TABLES -->
            <link href="plugins2/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
            <!-- Theme style -->
            <link href="dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
            <!-- AdminLTE Skins. Choose a skin from the css/skins
                 folder instead of downloading all of them to reduce the load. -->
            <link href="dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
            <script src="../ckeditor/ckeditor.js"></script>
            <script src="../ckeditor/samples/js/sample.js"></script>
            <link rel="stylesheet" href="../ckeditor/samples/toolbarconfigurator/lib/codemirror/neo.css">
            <script id="MathJax-script" async src="../ckeditor/samples/MathJax-master/es5/mml-chtml.js"></script>
           
        </head>
        <body class="skin-green">
        <div class="wrapper">
        
            <header class="main-header">
                <!-- Logo -->
                <a href="index.php" class="logo"><b>TEST</b> Master</a>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top" role="navigation">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                    </a>
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <!-- User Account: style can be found in dropdown.less -->
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="dist/img/staffb.jpg" class="user-image" alt="User Image"/>
                                    <span class="hidden-xs"> '.$this->getAdmin($_SESSION['adminId']).'</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header">
                                        <img src="dist/img/staffb.jpg" class="img-circle" alt="User Image" />
                                        <p>
                                            '.$this->getAdmin($_SESSION['adminId']).' - Exams Officer
                                        </p>
                                    </li>
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <a href="#"  data-toggle="modal" data-target="#myModal" data-whatever="@mdo" class="btn btn-default btn-flat">Change password</a>
                                        </div>
                                        <div class="pull-right">
                                            <a href="logout.php" class="btn btn-default btn-flat">Sign out</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
        
        ';
    }
    public function getPasswordModal($user){
        $r = '<div class="modal modal-success fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Change password</h4>
                            </div>
                            <div class="err_msg"></div><br/>
                            <form id="changePassword">
                                <div class="form-group input-group has-feedback">
                                    <span class="input-group-addon">Current password.</span>
                                    <input type="password" class="form-control input-sm" name="cpass" id="cpass"/>
                                    <input type="hidden" value="'.$user.'" class=" input-sm" name="user" id="user"/>
                                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                                </div>
                                <div class="form-group input-group has-feedback">
                                    <span class="input-group-addon">New Password</span>
                                    <input type="password" class="form-control input-sm" name="npass" id="npass"/>
                                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                </div>
                                <div class="form-group input-group has-feedback">
                                    <span class="input-group-addon">Confirm password</span>
                                                <input type="password" class="form-control input-sm " name="cnpass" id="cnpass"/>
                                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                </div>
                                </form>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" id="saveChanges">Save changes</button>
                            </div>
        </div>
        </div>
        </div>
                ';
        return $r;
    }

    public function changePassword()
    {
        $current = $_POST['cpass'];
        $newPass = $_POST['npass'];
        $confirmPass = $_POST['cnpass'];
        $user = $_POST['user'];

        if ($current != '' && $newPass != '' && $confirmPass != '') {
            $sql = 'SELECT password FROM admin WHERE adid="' . $user . '"';
            $result = mysqli_query(conn(), $sql) or die(mysqli_error(conn()));
            $row = mysqli_fetch_assoc($result);
            $curr = $row['password'];
            if ($curr != $current) {
                echo 0; //'invalid current password';
            }elseif($newPass != $confirmPass){
                echo 1; //'password mismatch';
            }else {
                $sql2 = 'UPDATE admin SET password="' .$confirmPass.'" WHERE adid="'.$user.'"';
                $result2 = mysqli_query(conn(), $sql2) or die(mysqli_error(conn()));
                if($result2){
                    echo 3; //'password successfully changed';
                }else echo mysqli_error(conn());
            }
        }else echo 4; //'all fields required';
    }

    public function getAdmin($user)
    {

            $sql = 'SELECT staff_name FROM admin WHERE adid="' . $user . '"';
            $result = mysqli_query(conn(), $sql) or die(mysqli_error(conn()));
            $row = mysqli_fetch_assoc($result);
            $name = $row['staff_name'];
            return $name;
    }

    public function getUserMenu($pre){
        $r ='';
        if($pre == 1){
            $r ='    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="dist/img/staffb.jpg" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
                <p>'.$this->getAdmin($_SESSION["adminId"]).'</p>

                <a href="#"><i class="glyphicon glyphicon-ban-circle text-green"></i> Online</a>
            </div>
        </div>

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">MAIN MENU</li>
            <li class="active treeview">
                <a href="index.php">
                    <i class="glyphicon glyphicon-home"></i> <span>Dashboard</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
            </li>
           <!-- <li class=" treeview">
                <a href="#">
                    <i class="glyphicon glyphicon-cog"></i>
                    <span>Users</span>
                    <span class=" glyphicon glyphicon-chevron-down pull-right"></span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="viewUser.php"><i class="glyphicon glyphicon-asterisk"></i>Manage User</a></li>
                    <li><a href="addUser.php"><i class="glyphicon glyphicon-plus"></i>Upload New Users</a></li>

                </ul>
            </li>-->
            <li class="active treeview">
                <a href="index.php">
                    <i class="glyphicon glyphicon-home"></i> <span>Unloack Student</span> <i class="fa fa-edit pull-right"></i>
                </a>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="glyphicon glyphicon-cog"></i>
                    <span>Class</span>
                    <span class=" glyphicon glyphicon-chevron-down pull-right"></span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="viewClass.php"><i class="glyphicon glyphicon-th-list"></i> View Class</a></li>
                    <li><a href="addClass.php"><i class="glyphicon glyphicon-plus"></i> Add New Class</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="glyphicon glyphicon-cog"></i>
                    <span>Test</span>
                    <span class=" glyphicon glyphicon-chevron-down pull-right"></span>
                </a>
                <ul class="treeview-menu">
                    <!--<li><a href="addTest.php"><i class="glyphicon glyphicon-plus"></i> Add New Exam</a></li>->>
                    <li><a href="viewTest.php"><i class="glyphicon glyphicon-th-list"></i> View Exams</a></li>
                    <li><a href="papers.php"><i class="glyphicon glyphicon-th-list"></i>Paper</a></li>

                </ul>
            </li>
            <li class=" treeview">
                <a href="#">
                    <i class="glyphicon glyphicon-cog"></i> <span>Questions</span>
                    <span class=" glyphicon glyphicon-chevron-down pull-right"></span>
                </a>
                <ul class="active treeview-menu">
                    <li><a href="viewQuestion.php"><i class="glyphicon glyphicon-cog"></i> Manage Qustions</a></li>
                    <li>
                        <a href="#"><i class="glyphicon glyphicon-plus"></i> Add Questions<i class="fa fa-angle-left pull-right"></i></a>
                        <ul class="treeview-menu">
                            <li><a href="addQuestion.php"><i class="glyphicon glyphicon-upload"></i> Manual Upload</a></li>
                            <li>
                                <a href="addQuestion_excel.php"><i class="glyphicon glyphicon-cloud-upload"></i> Upload from Excel </a>
                            </li>
                            <li>
                                <a href="addQuestion_word.php"><i class="glyphicon glyphicon-cloud-upload"></i> Upload from Word </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li class=" treeview">
                <a href="#">
                    <i class="glyphicon glyphicon-cog"></i>
                    <span>Schedule Students</span>
                    <span class=" glyphicon glyphicon-chevron-down pull-right"></span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="viewStudent.php"><i class="glyphicon glyphicon-asterisk"></i>Manage Students</a></li>
                    <li><a href="addStudent.php"><i class="glyphicon glyphicon-plus"></i>Shedule New Students</a></li>

                </ul>
            </li>

            <li class="treeview">
                <a href="viewResult.php">
                    <i class="glyphicon glyphicon-check"></i>
                    <span>Results</span>
                </a>
            </li>
        </ul>
    </section>';
        }elseif($pre ==2){
            $r ='    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="dist/img/staffb.jpg" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
                <p>'.$this->getAdmin($_SESSION["adminId"]).'</p>

                <a href="#"><i class="glyphicon glyphicon-ban-circle text-green"></i> Online</a>
            </div>
        </div>

        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">MAIN MENU</li>
            <li class="active treeview">
                <a href="index.php">
                    <i class="glyphicon glyphicon-home"></i> <span>Dashboard</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
            </li>
            <li class=" treeview">
                <a href="#">
                    <i class="glyphicon glyphicon-user"></i>
                    <span>Student</span>
                    <span class=" glyphicon glyphicon-chevron-down pull-right"></span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="viewStudent.php"><i class="glyphicon glyphicon-asterisk"></i>Manage Student</a></li>
                    <li><a href="addStudent.php"><i class="glyphicon glyphicon-plus"></i>Upload New Students</a></li>
                   <!-- <li><a href="addIndividualStudent.php"><i class="glyphicon glyphicon-plus"></i>Add Indivinual Student</a></li>-->
                </ul>
            </li>
           <!-- <li class=" treeview">
                <a href="unlock.php">
                    <i class="glyphicon glyphicon-lock"></i> <span>Unlock Student</span> 
                </a>
            </li>-->
            <li class=" treeview">
                <a href="access_tokens.php">
                    <i class="glyphicon glyphicon-lock"></i> <span>Access Tokens</span> 
                </a>
            </li>
            <li class=" treeview">
                
                <a href="#">
                    <i class="glyphicon glyphicon-user"></i>
                    <span>Attendance</span>
                    <span class=" glyphicon glyphicon-chevron-down pull-right"></span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="attendance.php">
                        <i class="glyphicon glyphicon-check"></i> <span>View Attendance</span> 
                        </a>
                    </li>
                   <!-- <li><a href="without_score.php"><i class="glyphicon glyphicon-plus"></i> Attendance without score</a></li>
                    <li><a href="absentees.php"><i class="glyphicon glyphicon-plus"></i> Absentees</a></li>
                    <li><a href="reset_exam.php"><i class="glyphicon glyphicon-file"></i> Reset Exam</a></li> -->
                </ul>
            </li>
            <!-- <li class="treeview">
                <a href="#">
                    <i class="glyphicon glyphicon-cog"></i>
                    <span>Class</span>
                    <span class=" glyphicon glyphicon-chevron-down pull-right"></span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="viewClass.php"><i class="glyphicon glyphicon-th-list"></i> View Class</a></li>
                    <li><a href="addClass.php"><i class="glyphicon glyphicon-plus"></i> Add New Class</a></li>
                </ul>
            </li>-->
            <li class="treeview">
                <a href="#">
                    <i class="glyphicon glyphicon-cog"></i>
                    <span>Exam</span>
                    <span class=" glyphicon glyphicon-chevron-down pull-right"></span>
                </a>
                <ul class="treeview-menu">
                   <!-- <li><a href="addTest.php"><i class="glyphicon glyphicon-plus"></i> Add New Exams</a></li>-->
                    <li><a href="exams.php"><i class="glyphicon glyphicon-th-list"></i> View Exams</a></li>
                    <li><a href="papers.php"><i class="glyphicon glyphicon-book"></i>Papers</a></li>
                    <li><a href="examiners.php"><i class="glyphicon glyphicon-user"></i>Examinars</a></li>

                </ul>
            </li>
            <li class=" treeview">
                <a href="#">
                    <i class="glyphicon glyphicon-file"></i> <span>Questions</span>
                    <span class=" glyphicon glyphicon-chevron-down pull-right"></span>
                </a>
                <ul class="active treeview-menu">
                    <li><a href="viewQuestion.php"><i class="glyphicon glyphicon-cog"></i> Manage Qustions</a></li>
                    <li>
                        <a href="#"><i class="glyphicon glyphicon-plus"></i> Add Questions<i class="fa fa-angle-left pull-right"></i></a>
                        <ul class="treeview-menu">
                            <li><a href="addQuestion.php"><i class="glyphicon glyphicon-upload"></i> Manual Upload</a></li>
                            <li>
                                <a href="addQuestion_excel.php"><i class="glyphicon glyphicon-cloud-upload"></i> Upload from Excel </a>
                            </li>
                             <li>
                                <a href="addQuestion_word.php"><i class="glyphicon glyphicon-cloud-upload"></i> Upload from Word </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="glyphicon glyphicon-file"></i>
                    <span>Results</span>
                    <span class=" glyphicon glyphicon-chevron-down pull-right"></span>
                </a>
                <ul class="treeview-menu">
                    <!--<li><a href="analysis.php"><i class="glyphicon glyphicon-th-list"></i> Analysis</a></li>-->
                    <li><a href="viewResult.php"><i class="glyphicon glyphicon-th-list"></i> View & Download Results</a></li>
                </ul>
            </li> 
            <li class=" treeview">
            <a href="backup_and_reset.php">
                <i class="glyphicon glyphicon-cog"></i> <span>Backup & Software Reset</span> 
            </a>
        </li>          
        </ul>
    </section>';
        }
        elseif($pre ==3){
            $r ='    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="dist/img/staffb.jpg" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
                <p>'.$this->getAdmin($_SESSION["adminId"]).'</p>
                <a href="#"><i class="glyphicon glyphicon-ban-circle text-green"></i> Online</a>
            </div>
        </div>

        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">MAIN MENU</li>
            <li class="active treeview">
                <a href="index.php">
                    <i class="glyphicon glyphicon-home"></i> <span>Dashboard</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
            </li>
            <li class=" treeview">
                <a href="#">
                    <i class="glyphicon glyphicon-cog"></i>
                    <span>Student</span>
                    <span class=" glyphicon glyphicon-chevron-down pull-right"></span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="viewStudent.php"><i class="glyphicon glyphicon-asterisk"></i>Manage Student</a></li>
                    <li><a href="addStudent.php"><i class="glyphicon glyphicon-plus"></i>Add New Student</a></li>

                </ul>
            </li>

            <li class="treeview">
                <a href="viewResult.php">
                    <i class="glyphicon glyphicon-check"></i>
                    <span>Results</span>
                </a>
            </li>
        </ul>
    </section>';

        }
        else{
            header('Location:adminLogin.php');
        }
        return $r;
    }

    public function addUser()
    {
        $className = clean($_POST['className']);
        $teacher = clean($_POST['teacher']);

        if (isset($_POST['className']) && $className != '') {
            $s1 = 'select * from class WHERE classname="' . $className . '"';
            $q1 = mysqli_query(conn(), $s1);

            if (mysqli_num_rows($q1) > 0) {
                echo 0; //class already exist
            } else { //not exist
                $s2 = ("insert into class(classname,classteacher) values('$className','$teacher')");
                $q2 = mysqli_query(conn(), $s2) or die(mysqli_error(conn()));
                if ($q2) {
                    echo 1; //inserted
                } else echo 2; //not inserted

            }
        } else echo 3; //empty class cannot be inseted

    }

    public function getUserTable()
    {
        $r = '';
        $r .= '
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>SN</th>
                    <th>Full Name</th>
                    <th>Usernames</th>
                    <th>Previledge</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>';
        $sql = "SELECT * FROM admin ORDER BY pre";
        $q1 = mysqli_query(conn(), $sql) or die(mysqli_error(conn()));
        $sn = 0;

        if (mysqli_num_rows($q1) > 0) {
            while ($row = mysqli_fetch_assoc($q1)) {
                $sn++;
                $id = $row['adid'];
                $name = $row['staff_name'];
                $username = $row['username'];
                $pre = $row['pre'];

                $r .= '<tr>
						<td>' . $sn . '</td>
						<td>' . $name . '</td>
						<td>' . $username . ' </td>
						<td>'.$pre.'</td>
						<td>
							<a title="edit" href="javascript:void(0)" rel="class" class="btn btn-primary btn-lg edit" data-toggle="modal" data-target="#addstudent" data-whatever="@mdo" onclick="mode(' . $id . ');">
							    <span class="glyphicon glyphicon-pencil"></span>
							 </a>


							<a type="button" title="delete" class="btn btn-danger btn-lg delete"  rel="class" data-toggle="modal" data-target="#delete" data-whatever="@mdo" onclick="myDelete(' . $id . ');"><span class="glyphicon glyphicon-trash"></span>
							</a>

						</td>
					</tr>



				';
            }
        }
        $r .= '
                </tbody>
                <tfoot>
                <tr>
                    <th>SN</th>
                    <th>Full Name</th>
                    <th>Usernames</th>
                    <th>Previledge</th>
                    <th>Action</th>
                </tr>
                </tfoot>
            </table>

        ';

        return $r;

    }

    public function getUserModel($className = '', $classTeacher = '')
    {
        $r = '
                        <div class="panel panel-success cbtlogin" >

                            <div class="panel-body">

                            <div id="error"></div>

                                <form class="form-horizontal login" role="form" name="cbt" id="cbt" >
                                    <div class="form-group form-group-sm">
                                        <label class="control-label text-info col-sm-3" for="username" >Class name:</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="text" id="name" name="name" value="' . $className . '"  required="" />
                                        </div>
                                    </div>
                                    <!--end form-group-->
                                    <div class="form-group form-group-sm">
                                        <label class="control-label text-info col-sm-3" for="teacher">Class Teacher:</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="text" id="teacher" name="teacher" value="' . $classTeacher . '"/></input>
                                        </div>
                                    </div>
                                </div>
                                <!--end form-group-->

                                <!--end form-group-->

                            </form>

                        </div>
            ';
        return $r;
    }

    public function getEdit()
    {
        $idm = $_POST['idm'];
        $sql = 'select * from class WHERE class_id="' . $idm . '"';
        $q1 = mysqli_query(conn(), $sql);
        $row = mysqli_fetch_assoc($q1);
        $className = $row['classname'];
        $classTeacher = $row['classteacher'];

        return $this->getClassModel($className, $classTeacher);

    }

    public function  editUser()
    {
        $className = clean($_POST['name']);
        $teacher = clean($_POST['teacher']);
        $idm =clean( $_POST['idm']);

        $sql = 'UPDATE class SET classname="' . $className . '", classteacher="' . $teacher . '" WHERE class_id="' . $idm . '" limit 1';
        $q1 = mysqli_query(conn(), $sql);
        if ($q1) {
            echo 1;
        } else echo mysqli_error(conn());

    }

    public function delete($idm)
    {
        $sql = 'delete from class where class_id="' . $idm . '"';
        $q1 = mysqli_query(conn(), $sql);

        if ($q1) {
            echo 1;
        } else echo mysqli_error(conn());
    }






}