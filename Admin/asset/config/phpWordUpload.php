<?php
header('Content-Type: text/html; charset=utf-8');
include("../classes/db.php");

if(isset($_FILES['uploadFile']['name']) && $_FILES['uploadFile']['name'] != "") {
    $test_id = $_POST['test'];
    $section = $_POST['section'];

    $filename = "".$_FILES['uploadFile']['name'];
    $fileArray = pathinfo($filename);
    $file_ext  = $fileArray['extension'];
    if($file_ext == "docx") {
        $striped_content = '';
        $content = '';
        $file = $_FILES['uploadFile']['name'];
        $isUploaded = @copy($_FILES['uploadFile']['tmp_name'], $file);


        try {
            $zip = @zip_open($filename);
            if (!$zip || is_numeric($zip)) echo "";
        } catch (Exception $e) {
            die('Error loading file "' . pathinfo($file, PATHINFO_BASENAME). '": ' . $e->getMessage());
        }



        while ($zip_entry = @zip_read($zip)) {

            if (@zip_entry_open($zip, $zip_entry) == FALSE) continue;

            if (@zip_entry_name($zip_entry) != "word/document.xml") continue;

            $content .= @zip_entry_read($zip_entry, @zip_entry_filesize($zip_entry));

            @zip_entry_close($zip_entry);
        }
        @zip_close($zip);
        $content = str_replace('</w:r></w:p></w:tc><w:tc>', " ", $content);
        $content = str_replace('</w:r></w:p>', "\r\n", $content);

        $striped_content = (string)strip_tags($content);
        $i =0;
        //$correct =array();
        $data=explode("$$",$striped_content);
        $sn =0;
        $num=0;
        echo '<table id="example1" class="table table-bordered table-striped">';
        for ($i=1;$i<count($data);$i++) {
            $sn++;
            $correct=0;
            $opt='A';
            //$correct[$sn] =1;
            @list($q,$a,$b,$c,$d)=explode("@@",$data[$i]);//Separate string by the means of @@
            $a=mysqli_real_escape_string($con,trim($a));
            $b=mysqli_real_escape_string($con,trim($b));
            $c=mysqli_real_escape_string($con,trim($c));
            $d=mysqli_real_escape_string($con,trim($d));
            $q=mysqli_real_escape_string($con,trim($q));
            if(substr((string)$a,-1) == "~"){
                $correct =1;
                $a=substr($a, 0,strlen($a)-1);
                $opt="A";
            }
            elseif(substr((string)$b,-1) == "~"){
                $correct =2;
                $b=substr($b, 0,strlen($b)-1);
                $opt="B";

            }
            elseif(substr((string)$c,-1) == "~"){
                $correct =3;
                $c=substr($c, 0,strlen($c)-1);
                $opt="C";

            }
            elseif(substr((string)$d,-1) == "~"){
                $correct =4;
                $d=substr($d, 0,strlen($d)-1);
                $opt="D";

            }
            $query = "insert into question (question_name, answer1, answer2, answer3, answer4, answer,test_id,section) VALUES ('$q','$a','$b','$c','$d','$correct','$test_id','$section') ";
            $result = mysqli_query($con,$query) or die(mysqli_error($con));
            if($num_rows=mysqli_affected_rows($con)>0){
                $num=$num+$num_rows;
            }else{
                die("<h3 class='text-danger'>Error!!! cannot upload</h3>");
            }
            echo "<tr><td>";
            echo $sn.". ".$q."<br/>";
            echo "a.".$a."<br/>";
            echo "b.".$b."<br/>";
            echo "c.".$c."<br/>";
            echo "d.".$d."<br/>";
            echo "<div class='alert-success'>Correct option: ".$opt."</div></td></tr>";

        }
        //echo $striped_content;
        echo("<caption><h3 class='text-danger'>".$num." Questions uploaded</h3></caption></table>");


    } else {
        echo "<div class='text-danger'><h3 class=''>Error!!! Invalid File Type</h3>
                <b>1. Make sure your document is in .docx format</b><br/>
                <b>2. Make sure your docx file follow the CBT syntax.</b></div>";
    }

}else {
    echo "<div class='text-danger'><h3 class='text-danger'>Error!!! Select a docx file and try again</h3>
                <b>1. Make sure your document is in .docx format</b><br/>
                <b>2. Make sure your docx file follow the CBT syntax.</b></div>
            ";
}


?>