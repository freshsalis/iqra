<?php
require_once 'db.php';

/**
 * Created by PhpStorm.
 * User: freshsalis
 * Date: 8/21/2015
 * Time: 4:12 PM
 */
error_reporting(E_ALL ^ E_DEPRECATED);

class _Class
{


    public function addClass()
    {
        $className = clean($_POST['className']);
        // $teacher = clean($_POST['teacher']);

        if (isset($_POST['className']) && $className != '') {
            $s1 = 'select * from class WHERE classname="' . $className . '"';
            $q1 = mysqli_query(conn(), $s1);

            if (mysqli_num_rows($q1) > 0) {
                echo 0; //class already exist
            } else { //not exist
                $s2 = ("insert into class(classname) values('$className')");
                $q2 = mysqli_query(conn(), $s2) or die(mysqli_error(conn()));
                if ($q2) {
                    echo 1; //inserted
                } else echo 2; //not inserted

            }
        } else echo 3; //empty class cannot be inseted

    }

    public function getClassTable()
    {
        $r = '';
        $r .= '
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>SN</th>
                    <th>Class Name</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>';
        $sql = "SELECT * FROM class ORDER BY classname";
        $q1 = mysqli_query(conn(), $sql) or die(mysqli_error(conn()));
        $sn = 0;

        if (mysqli_num_rows($q1) > 0) {
            while ($row = mysqli_fetch_assoc($q1)) {
                $sn++;
                $id = $row['class_id'];
                $class = $row['classname'];
                // $teacher = $row['classteacher'];

                $r .= '<tr>
						<td>' . $sn . '</td>
						<td>' . $class . '</td>
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
                    <th>Class Name</th>                   
                    <th>Action</th>
                </tr>
                </tfoot>
            </table>

        ';

        return $r;

    }

    public function getClassModel($className = '', $classTeacher = '')
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

    public function  editClass()
    {
        $className = clean($_POST['name']);
        // $teacher = clean($_POST['teacher']);
        $idm =clean( $_POST['idm']);

        $sql = 'UPDATE class SET classname="' . $className . '" WHERE class_id="' . $idm . '" limit 1';
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

    public function getClassMenu($idm = '', $url,$table='')
    {
        $r = '
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Classes</h3>
                </div>
                <div class="box-body no-padding">
                    <ul class="nav nav-pills nav-stacked">
                    ';
        $sql = "SELECT * FROM class ORDER BY classname";
        $q1 = mysqli_query(conn(), $sql) or die(mysqli_error(conn()));
        $sn = 0;

        if (mysqli_num_rows($q1) > 0) {
            while ($row = mysqli_fetch_assoc($q1)) {
                $sn++;
                $id = $row['class_id'];
                $class = $row['classname'];
                $teacher = $row['classteacher'];

                if ($idm == $id) {
                    $r .= '
                        <li class="active"><a href="' . $url . $id . '" id="' . $id . '"><i class=" glyphicon glyphicon-th-list"></i> ' . $class . '<span class="label label-primary pull-right"><span class="glyphicon glyphicon-chevron-down"></span></span> </a></li>
                       ';
                } else {
                    $r .= '
                        <li class=""><a href="' . $url . $id . '" id="' . $id . '"><i class="glyphicon glyphicon-th-list"></i> ' . $class . '<span class="label label-primary pull-right"><span class="glyphicon glyphicon-chevron-right"></span></span> </a></li>
                       ';
                }

            }
        } else
            $r .= ' No classes found';
        $r .= '
                    </ul>
                </div><!-- /.box-body -->
        </div><!-- /. box -->

        ';
        return $r;
    }

    public function getBadge($idm = '', $table)
    {
        $r = '';

        $sql = "SELECT COUNT(*) as num FROM ".$table." where class_id='".$idm."' ";
        $q1 = mysqli_query(conn(), $sql) or die(mysqli_error(conn()));
        if (mysqli_num_rows($q1) > 0) {
            $row = mysqli_fetch_assoc($q1);
                $num = $row['num'];
                $r .= '
                     <span class="label label-primary pull-right">'.$num.'</span>
                   ';
        } else
            $r .= ' <span class="label label-primary pull-right">0</span>';
        return $r;
    }

    function getClassCombo($default = '')
    {
        $r = '<select name="sclass" id="sclass" class="col-md-12 form-control">';
        $sql = "SELECT * FROM class ORDER BY classname";
        $q1 = mysqli_query(conn(), $sql) or die(mysqli_error(conn()));
        $sn = 0;

        if (mysqli_num_rows($q1) > 0) {
            while ($row = mysqli_fetch_assoc($q1)) {
                $sn++;
                $id = $row['class_id'];
                $class = $row['classname'];

                //check for the selected option
                if ($default != '' && $default == $id) {
                    $option = '<option value=' . $id . ' selected>' . $class . '</option>';
                    $r .= $option;
                } else {
                    $option = '<option value=' . $id . '>' . $class . '</option>';
                    $r .= $option;
                }
            }
            return $r;
        }


    }

    public function getClassCount()
    {
        $count =0;


        $sql = "SELECT COUNT(class_id) AS cc FROM class  ";
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

    public function getStudentCount()
    {
        $count =0;


        $sql = "SELECT COUNT(class_id) AS cc FROM student  ";
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

    public function getStudentCount2($class_id)
    {
        $count =0;


        $sql = "SELECT COUNT(class_id) AS cc FROM student WHERE class_id='".$class_id."'";
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

    public function getTestCount()
    {
        $count =0;


        $sql = "SELECT COUNT(class_id) AS cc FROM test  ";
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

}