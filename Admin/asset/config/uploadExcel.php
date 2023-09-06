
    <?php
    header('Content-Type: text/html; charset=utf-8');
    if(isset($_FILES['uploadFile'])) {
        $paper_id = $_POST['paper'];
        $batch = $_POST['section'];
        if(isset($_FILES['uploadFile']['name']) && $_FILES['uploadFile']['name'] != "") {
            $allowedExtensions = array("csv");
            $ext = pathinfo($_FILES['uploadFile']['name'], PATHINFO_EXTENSION);
            if(in_array($ext, $allowedExtensions)) {
                $file_size = $_FILES['uploadFile']['size'] / 1024;
                if($file_size < 50000) {
                    $file = "uploads/".$_FILES['uploadFile']['name'];
                    $isUploaded = copy($_FILES['uploadFile']['tmp_name'], $file);
                    if($isUploaded) {
                        include("../classes/db.php");

                        $handle = fopen($_FILES['uploadFile']['tmp_name'], 'r');
                        $handle2 = fopen($_FILES['uploadFile']['tmp_name'], 'r');
                        $i = 0;

                        //check paper type
                        $sql = "SELECT * FROM papers WHERE paper_id='" . $paper_id . "' limit 1";
                        $q1 = mysqli_query(conn(), $sql) or die(mysqli_error(conn()));
                        $row = $row = mysqli_fetch_assoc($q1);
                        if ($row['paper_type_id'] == 1) { 
                            $expectedColumns = [ "Question","Oprion 1"	,"Option 2",	"Option 3",	"Option 4",	"Answer",	"Type",	"Diagram"];

                            $headerRow = fgetcsv($handle2, 10000, ',');

    
                            
                            // Check if the header row matches the expected columns
                            if (count(($expectedColumns))  === count($headerRow)) {
       
                                $r ='<table id="example1" class="table table-bordered table-striped">
                                                <thead>
                                                <tr>
                                                    <th>SN</th>
                                                    <th>Question</th>
                                                    <th>Option A</th>
                                                    <th>Option B</th>
                                                    <th>Option C</th>
                                                    <th>Option D</th>
                                                    <th>ANSWER</th>
                                                </tr>
                                                </thead>

                                            ';

                                while(($data = fgetcsv($handle,10000,',')) !== FALSE){
                                    if($i >0){
                                       

                                        $question = mysqli_real_escape_string(conn(),($data[0]));
                                        $option1 = mysqli_real_escape_string(conn(),$data[1]);
                                        $option2 = mysqli_real_escape_string(conn(),$data[2]);
                                        $option3 = mysqli_real_escape_string(conn(),$data[3]);
                                        $option4 = mysqli_real_escape_string(conn(),$data[4]);
                                        $answer = mysqli_real_escape_string(conn(),$data[5]);
                                        $type = mysqli_real_escape_string(conn(),$data[6]);
                                        $diagram = mysqli_real_escape_string(conn(),$data[7]);
                                    $sql = " INSERT INTO question (question_name,paper_id,answer1,answer2,answer3,answer4,answer,question_type,diagram)
                                        VALUES ('".$question."','".$paper_id."','".$option1."','".$option2."','".$option3."','".$option4."',
                                        '".$answer."','".$type."','".$diagram."')";
                                    $query = mysqli_query(conn(),$sql) or die(mysqli_error(conn()));
                                        if(true){
                                            $r .= "<tr/>
                                                    <td>".$i."</td>
                                                    <td>".$question."</td>
                                                    <td>".$option1."</td>
                                                    <td>".$option2."</td>
                                                    <td>".$option3."</td>
                                                    <td>".$option4."</td>
                                                    <td>".$answer."</td>
                                                </tr>
                                        ";

                                        }
                                    //    echo mysqli_affected_rows(conn());
                                    }
                                    $i++;
                                }
                            } else {
                                // Header does not match the expected columns
                                echo "<h3 class='text-danger text-center'>CSV file does not have the expected columns</h3>";
                            }
                            fclose($handle);
                        }else{

                            $expectedColumns = [ "Question","Mark 1"	,"Mark 2",	"Mark 3",	"Mark 4"];

                            $headerRow = fgetcsv($handle2, 10000, ',');

    
                            
                            // Check if the header row matches the expected columns
                            if (count(($expectedColumns))  === count($headerRow)) {
                                $r ='<table id="example1" class="table table-bordered table-striped">
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

                                            ';

                                while(($data = fgetcsv($handle,10000,',')) !== FALSE){
                                    if($i >0){
                                        $question = mysqli_real_escape_string(conn(),($data[0]));
                                        $mark1 = mysqli_real_escape_string(conn(),$data[1]);
                                        $mark2 = mysqli_real_escape_string(conn(),$data[2]);
                                        $mark3 = mysqli_real_escape_string(conn(),$data[3]);
                                        $mark4 = mysqli_real_escape_string(conn(),$data[4]);
                                    $sql = " INSERT INTO other_question (question_name,paper_id,mark1,mark2,mark3,mark4)
                                        VALUES ('".$question."','".$paper_id."','".$mark1."','".$mark2."','".$mark3."','".$mark4."')";
                                    $query = mysqli_query(conn(),$sql) or die(mysqli_error(conn()));
                                        if(true){
                                            $r .= "<tr/>
                                                    <td>".$i."</td>
                                                    <td>".$question."</td>
                                                    <td>".$mark1."</td>
                                                    <td>".$mark2."</td>
                                                    <td>".$mark3."</td>
                                                    <td>".$mark4."</td>
                                                </tr>
                                        ";

                                        }
                                    //    echo mysqli_affected_rows(conn());
                                    }
                                    $i++;
                                }
                            }
                            else {
                                // Header does not match the expected columns
                                echo "<h3 class='text-danger text-center'>CSV file does not have the expected columns</h3>";
                            }
                            fclose($handle);
                        }
                        
                        if($i ==0)
                            echo $i."<h1> records uploaded</h1>";
                        else echo "<h3 class='text-success text-center'>".($i-1)." Questions Successfully Uploaded</h3>".$r;
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
