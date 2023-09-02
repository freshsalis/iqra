
<?php
if(isset($_FILES['uploadFile'])) {
    $test_id = $_POST['test'];
    $batch = $_POST['batch'];
    if(isset($_FILES['uploadFile']['name']) && $_FILES['uploadFile']['name'] != "") {
        $allowedExtensions = array("csv");
        $ext = pathinfo($_FILES['uploadFile']['name'], PATHINFO_EXTENSION);
        if(in_array($ext, $allowedExtensions)) {
            $file_size = $_FILES['uploadFile']['size'] / 1024;
            if($file_size < 1000) {
                $file = "uploads/".$_FILES['uploadFile']['name'];
                $isUploaded = copy($_FILES['uploadFile']['tmp_name'], $file);
                if($isUploaded) {
                    include("../classes/db.php");

                    $handle = fopen($_FILES['uploadFile']['tmp_name'], 'r');
                    $i = 0;

                    $r ='<table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>SN</th>
                                            <th>MATRIC. NO.</th>
                                            <th>SURNAME</th>
                                            <th>OTHERNAMES</th>
                                            <th>PROGRAM</th>
                                            <th>BATCH</th>
                                        </tr>
                                        </thead>

                                    ';

                    while(($data = fgetcsv($handle,1000,',')) !== FALSE){
                        if($i >0){
                            $regno = clean($data[0]);
                            $surname = clean($data[1]);
                            $othername = clean($data[2]);
                            $dept = clean($data[3]);
                            $sql_select = " SELECT * FROM schedule_student WHERE test_id ='$test_id' 
                                    AND reg_no = '$regno' ";
                            $query_select = mysqli_query(conn(),$sql_select) or die(mysqli_error(conn()));
                             $count = mysqli_num_rows($query_select);
                            
                            if ($count>0) {
                                // echo 1;
                                $sql_check = " UPDATE schedule_student SET reg_no='$regno',surname='$surname',
                                    othername='$othername',dept='$dept',batch='".$batch."' WHERE test_id ='".$test_id."' 
                                    AND reg_no = '$regno' ";
                                    $query_check = mysqli_query(conn(),$sql_check) or die(mysqli_error(conn()));
                                    $count = mysqli_affected_rows(conn());
                            }                            
                            else{
                                // echo -1;
                                $sql = " INSERT INTO schedule_student VALUES 
                                    (0,'".clean($data[0])."','".clean($data[1])."','".clean($data[2])."',
                                    '".$test_id."','".clean($data[3])."','".$batch."')";
                                $query = mysqli_query(conn(),$sql) or die(mysqli_error(conn()));
                                if($query){
                                    $r .= "<tr/>
                                                <td>".$i."</td>
                                                <td>".$data[0]."</td>
                                                <td>".$data[1]."</td>
                                                <td>".$data[2]."</td>
                                                <td>".$data[3]."</td>
                                                <td>".$batch."</td>
    
                                               </tr>
                                       ";
    
                                }
                            }

                            
                            //echo mysqli_affected_rows(conn(),$query);
                        }
                        $i++;
                    }
                    fclose($handle);
                    $r .='<tfoot>
                                        <tr>
                                            <th>SN</th>
                                            <th>MATRIC. NO.</th>
                                            <th>SURNAME</th>
                                            <th>OTHERNAMES</th>
                                            <th>PROGRAM</th>                                        
                                            <th>BATCH</th>                                        

                                        </tr>
                                        </tfoot>';
                    if($i ==0)
                        echo $i."<h1> records uploaded</h1>";
                    else echo "<h3 class='text-success text-center'>".($i-1)." Students Successfully Uploaded</h3>".$r;
                } else {
                    echo '<img src="../images/status.gif" hidden="hidden" class="spin pull-center"/>
                                <h3 class="text-danger">Error!!! File not uploaded!</h3>';
                }
            } else {
                echo '<img src="../images/status.gif" hidden="hidden" class="spin pull-center"/>
                            <h3 class="text-danger">Error!!! Maximum file size should not cross 50 KB on size!</h3>';
            }
        } else {
            echo ' <img src="../images/status.gif" hidden="hidden" class="spin pull-center"/>
                        <h3 class="text-danger">Error!!! This type of file is not allowed, select an excel file and try again!</h3>';
        }
    } else {
        echo '<img src="../images/status.gif" hidden="hidden" class="spin pull-center"/>
                    <h3 class="text-danger">Error!!! Select an excel file first!</h3>';
    }
}else echo "<h3 class='text-danger'>Error!!! Please select an excel file and try again!</h3>"

?>
