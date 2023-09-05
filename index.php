<?php
session_start();
require_once 'Admin/asset/classes/db.php';
require_once 'Admin/asset/classes/Student.php';


 
 		if (!$_SESSION['stdid']){
			header('location:login.php');
		}

         $testid=$_SESSION['test_id'];
         $stdid = $_SESSION['stdid'];
         $paper = clean($_GET['p']);

        

        
        //  check paper
        $sql_check = "select * FROM papers WHERE sha1(paper_id)='".$paper."'";
        $query_check = mysqli_query(conn(), $sql_check) or die(mysqli_error(conn()));

        $numrows=mysqli_num_rows($query_check);
        
        // die($numrows);
        if($numrows > 0){

            $fetch1 = mysqli_fetch_assoc($query_check);
            $paper_id = $fetch1['paper_id'];
            $num_quest = $fetch1['question_per_stud'];
            $duration = $fetch1['time'];
            $insta = $fetch1['instant_result'];

            // sign attendance
            $student = new Student();
            $aid =  $student->signAttendance($stdid,$paper_id);
            

            // check if already taken
            $sql_taken = "select * FROM testscore WHERE paper_id='".$paper_id."'  AND stdid='".$stdid."'";
            $query_taken = mysqli_query(conn(), $sql_taken) or die(mysqli_error(conn()));
            $numrow_taken=mysqli_num_rows($query_taken);

            if ($numrow_taken >0) {
                header('location:welcome.php');
                return;
            }

            // check if already has question
            $sqlsub = "select * FROM sub_question WHERE paper_id='".$paper_id."'  AND stud_id='".$stdid."'";
            $querysub = mysqli_query(conn(), $sqlsub) or die(mysqli_error(conn()));
            $numrowssub=mysqli_num_rows($querysub);

            if ($numrowssub ==0) {
                $str = '';
                $check_quest = 0;
                $min_array = 0;
                $max_array = 0;
                $sql = "SELECT section,MAX(question_id) as maxQ,MIN(question_id) as minQ FROM `question`  WHERE paper_id='".$paper_id."' GROUP BY section ORDER BY section";
                $query = mysqli_query(conn(), $sql) or die(mysqli_error(conn()));
                while($fetch=mysqli_fetch_assoc($query)){
                    $min_array= $fetch['minQ'];
                    $max_array = $fetch['maxQ'];
                }
                    
                        $a = range($min_array,$max_array);
                        shuffle($a);
                        
                        $hundred = array_slice($a,0,$num_quest);
                        shuffle($hundred);
                        $str .=implode(", ",$hundred);
                    
                    if ($max_array ==0) {
                        echo "<h2>No questions available.</h2>";
                        return;
                    }
                    
                    $r0="INSERT INTO sub_question (question_id,stud_id,paper_id)
                         SELECT question.question_id,'$stdid',question.paper_id FROM question 
                         WHERE question.question_id IN ($str) AND question.paper_id='$paper_id'  
                         order by FIELD(question.question_id,$str) 
                         LIMIT ".$num_quest."";

                        $response=mysqli_query(conn(), $r0) or die(mysqli_error(conn()));
                        
                }
                
            
        }else{
            header('location:login.php');

        }
       
        $sql = "select * FROM track_timer WHERE stdid='".trim($stdid)."' AND paper_id='".$paper_id."'";
        $query1 = mysqli_query(conn(), $sql) or die(mysqli_error(conn()));

         $numrows=mysqli_num_rows($query1);
        // die($numrows);
    if($numrows > 0){
        $row=mysqli_fetch_assoc($query1);
        $init = $row['time'];
        $minute=floor(($init/60));
        $sec=$init%60;
        // echo "fresh";
    }
    else{
        $sql0="select * from papers where paper_id='$paper_id'";
        $qry = mysqli_query(conn(), $sql0) or die(mysqli_error(conn()));

        
        $numrows=mysqli_num_rows($qry);
        if ($numrows>0){
            $row=mysqli_fetch_assoc($qry);
             $init= trim($row['time'])+0;
             $minute=floor(($init/60)) ;
             $sec=$init%60;
            // die();

        }
    }


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns="http://www.w3.org/1999/html">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>CBT EXAM</title>
    <link href="Admin/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="Admin/dist/css/AdminLTE.css" rel="stylesheet" type="text/css" />
    <link href="Admin/dist/css/style.css" rel="stylesheet" type="text/css" />
    <link
      rel="shortcut icon"
      type="image/x-icon"
      href="./logo.png"
    />
    <script id="MathJax-script" async src="ckeditor/samples/MathJax-master/es5/mml-chtml.js"></script>

    <!-- iCheck -->
    <style>
        p {display:inline};

    </style>

</head>
<body class="login-page" oncontextmenu2="false">
	<div class="row">

	<?php


    ?>
        <br>




	<div class="row container-fluid" style="background-color: #ecf0f5;min-height:98vh;padding:5px;">
        <div class="col-md-12">
            <div class="col-md-8">
                <div class="container-fluid panel panel-success text-left qtn" style="">
                    <div class="col-sm-12 cquestion">Question <span id="cquestion"></span> of <span id="tquestion"></span> </div>
                    
                    <div class="clearfix"></div>
                <div id="question_container" style="border:0px solid red; padding:3em;min-height:400px;">

                <?php
                //check if user started d test elsewhere
                $r1="select * from sub_question s,question q where s.paper_id='".$paper_id."'
                AND s.stud_id='".$stdid."' AND s.question_id=q.question_id ORDER BY s.sub_id limit ".$num_quest." ";
                $response1= mysqli_query(conn(), $r1) or die(mysqli_error(conn()));

                if(mysqli_num_rows($response1)>0){
                    $sn=0;
                    $numQuestion=mysqli_num_rows($response1);
                    ?>
                    <form method='post' id='quiz_form' action="">
                        <input type="hidden" class="last" value="<?php echo mysqli_num_rows($response1); ?>">
                        <input type="hidden" class="std" name="std" value="<?php echo $stdid; ?>">
                        <input type="hidden" class="paper" name="paper" value="<?php echo $paper_id; ?>">
                        <input type="hidden" class="insta" name="insta" value="<?php echo $paper_id; ?>">
                        <?php
                        while($result=mysqli_fetch_array($response1)){ $sn++;
                            $optAnswered = 0;
                            //select to check if user started d test somewhere
                            $sql = "SELECT * FROM test_attempt WHERE stdid='".$stdid."' AND quid='".$result['question_id']."'";
                            $query = mysqli_query(conn(), $sql) or die(mysqli_error(conn()));


                            if (mysqli_num_rows($query)>0) {
                                $r =mysqli_fetch_array($query);
                                $optAnswered = $r['ans'];
                            }


                            
                            ?>

                            <!-- display question -->
                            <div id="<?php echo 'c'.$sn;?>" class='question' hidden="hidden">
                                <p id="question_<?php echo $sn;?>" class="qname">
                                <?php
                                // if question has diagram display diagram before question
                                
                                // display question text
                                // display question text
                                echo "<div class='row'  style='max-height: 250px;min-height:100px;overflow:auto;font-size: 1.9vw;'>
                                    <div class='col-md-1'><b>" .$sn.". </b></div>
                                    <div class='col-md-11 ql' style='width: px;overflow:scroll2;' >
                                        <p>".htmlspecialchars_decode($result['question_name'])."</p>
                                    </div>
                                </div>";
                                if ($result['question_type'] ==3) {
                                    
                                    echo "<img src='".$result['diagram']."' style='width:80%;height:100px;' class='img-responsive'/>";
                                }
                                ?>
                                </p>
                                <div class='align'>
                                    <!-- options display -->
                                    <input type="radio" rel="<?php $val=5; echo $result['question_id'];?>" checked value="5" style='display:none' id='<?php echo $sn;?>' name='<?php echo $sn;?>'/>
                                    <?php 
                                    $shuffle = [1,2,3,4];
                                        if (trim($result['answer3']) !='' && trim($result['answer4']) =='') {
                                            $shuffle = [1,2,3];
                                        }
                                    shuffle($shuffle);
                                        // not a true and false question
                                        if (trim($result['answer3']) !='' && trim($result['answer4']) !='') {
                                            echo '<div class="col-md-12 row">
                                                <label id="ans1_'.$sn.'" >
                                                    <input type="radio" rel="'. $result["question_id"].'"
                                                role="c'.$sn.'" class="rg" value="'.$shuffle[0].'" id="'. $sn.'" name="'. $sn.'" ';
                                                if ($optAnswered==$shuffle[0]){$val=$shuffle[0]; echo " checked='checked'";}
                                                echo ' /><span>
                                                        <b>(A)</b>. '.htmlspecialchars_decode($result["answer".$shuffle[0]]).'
                                                        </span></label>
                                                        <input type="hidden" id="val" name="val" value="'. $val.'"/><br/>
                                                
                                                <label id="ans2_'.$sn.'" >
                                                <input type="radio" rel="'. $result["question_id"].'"
                                                role="c'.$sn.'" class="rg" value="'.$shuffle[1].'" id="'. $sn.'" name="'. $sn.'" ';
                                                if ($optAnswered==$shuffle[1]){$val=$shuffle[1]; echo " checked='checked'";}
                                                echo ' /><span>
                                                    <b>(B)</b>. '.htmlspecialchars_decode($result["answer".$shuffle[1]]).'</span></label>
                                                    <input type="hidden" id="val" name="val" value="'. $val.'"/><br/>
                                                
                                                ';                                   
                                    }else{
                                        //true and false
                                        $shuffle = [1,2,3,4];
                                        echo ' <div class="col-md-12 row">
                                                <label id="ans1_'.$sn.'" >
                                                    <input type="radio" rel="'. $result["question_id"].'"
                                                role="c'.$sn.'" class="rg" value="1" id="'. $sn.'" name="'. $sn.'" ';
                                                if ($optAnswered==1){$val=1; echo " checked='checked'";}
                                                echo ' /><span>
                                                <b>(A)</b>.'.htmlspecialchars_decode($result["answer1"]).'</span></label>
                                                        <input type="hidden" id="val" name="val" value="'. $val.'"/><br/>
                                                
                                                <label id="ans2_'.$sn.'" >
                                                <input type="radio" rel="'. $result["question_id"].'"
                                                role="c'.$sn.'" class="rg" value="2" id="'. $sn.'" name="'. $sn.'" ';
                                                if ($optAnswered==2){$val=2; echo " checked='checked'";}
                                                echo ' /><span>
                                                <b>(B)</b>.'.htmlspecialchars_decode($result["answer2"]).'</span></label>
                                                    <input type="hidden" id="val" name="val" value="'. $val.'"/><br/>
                                                
                                                ';
                                    }
                                    //check if its only two options applied
                                    if (trim($result['answer3']) !='') {
                                        echo '
                                            <label id="ans3_'.$sn.'" >
                                                <input type="radio" rel="'. $result["question_id"].'"
                                            role="c'.$sn.'" class="rg" value="'.$shuffle[2].'" id="'. $sn.'" name="'. $sn.'" ';
                                            if ($optAnswered==$shuffle[2]){$val=$shuffle[2]; echo " checked='checked'";}
                                            echo ' /><span>
                                                    <b>(C)</b>. '.htmlspecialchars_decode($result["answer".$shuffle[2]]).'</span></label>
                                                    <input type="hidden" id="val" name="val" value="'. $val.'"/><br/>
                                            ';                                   
                                    }if (trim($result['answer4']) !='') {
                                        echo '
                                            <label id="ans4_'.$sn.'" >
                                                <input type="radio" rel="'. $result["question_id"].'"
                                            role="c'.$sn.'" class="rg" value="'.$shuffle[3].'" id="'. $sn.'" name="'. $sn.'" ';
                                            if ($optAnswered==$shuffle[3]){$val=$shuffle[3]; echo " checked='checked'";}
                                            echo ' /><span>
                                                    <b>(D)</b>. '.htmlspecialchars_decode($result["answer".$shuffle[3]]).'</span></label>
                                                    <input type="hidden" id="val" name="val" value="'. $val.'"/><br/>
        
                                            ';
                                    }
                                    echo "<br/></div>";
                                ?>
                                

                                </div>
                            </div><!--end div question-->

                        <?php }?>
                    </form>
                <?php }?>

                

            </div>	
            <br>
            <div class="row" style="margin: 10px;">
                <button type="button" class="btn btn-md btn-success col-md-2 pull-left btnNavigate" id="btnPrev" >
                        <span class="glyphicon glyphicon-fast-backward"></span> Previous
                    </button>
                    <button type="button" class="btn btn-md btn-success col-md-2 pull-right btnNavigate" id="btnNext" >
                    Next <span class="glyphicon glyphicon-fast-forward"></span> 
                </button>
            </div>            	
            </div><!--end panel-->

            </div><!--col-8-->

            <div class="col-md-4">
                <div class="box box-solid">
                    <div class="box-body no-padding">
                        <div class="panel panel-default">
                            <div class="panel-body text-center">
                                <div class="head2  text-center text-uppercase" style="font-size: 3vmin;margin-top:20px; ">
                                    <span class="clock text-center" style="background-color: green;color:white">

                                        <hr class="timer"/>
                                    <span>
                                        <b><span class="min"><?php echo str_pad($minute,2,"0",STR_PAD_LEFT); ?></span>
                                        <span>
                                    <span> : </span>
                                    </span>
                                            <span class="sec"><?php echo str_pad($sec,2,"0",STR_PAD_LEFT); ?></span></b>
                                    </span>
                                    </span>
                                </div>
                                <div class="mb-5">
                                    <button type="submit" class="btn btn-lg btn-danger col-lg-12 hidden mb-5" style="margin-bottom: 10px;" data-toggle="modal" data-target="#confirmSubmit" data-whatever="@mdo" id="saveSubmit" >Submit Exam</button>
                                </div>
                                <hr>
                                <div class="head  text-left text-uppercase" style="max-height: 300px;overflow:scroll;">
                                    <b style="font-size: 1.5vmax;">Name: <b><span><?PHP echo strtoupper($_SESSION['name']); ?></span></b> </b><br/>
                                    <b style="font-size: 1.5vmax;">Reg. No.: <b><span><?PHP echo strtoupper($_SESSION['user']); ?></span></b> </b><br/>
                                    <b style="font-size: 1.0vmax;">Program: <b><span><?PHP echo  $_SESSION['dept']; ?></span></b> </b><br/>
                                    <b style="font-size: 1.0vmax;"> Exam : <b><span><?PHP echo $_SESSION['exam']; ?></span></b><br/>
                                    </b>
                                </div>
                                <div class="pull-right">
                                    <small><a href="./logout.php" class="btn btn-warning" id="signout" ><span class="glyphicon glyphicon-log-out"></span> Logout</a>
                                    <input type="hidden" value="<?php echo $duration?>" id="dur">
                                </div>
                            </div>
                        </div><!-- /.box-body -->
                        
                    </div>
                </div>
                
                
            </div>
        </div>
        <div class="col-lg-12">
            <div class="col-md-12 col-md-offset2-1">
                <div class="panel panel-default num">
                    <div class="panel-body text-justify">
                        <?php
                            for($i=1;$i<=$numQuestion;$i++){?>
                                <span style="border: 0px;" id="<?php echo 'c'.$i;?>" rel="<?php echo $i;?>" class="btn numNav btn-sm btn-danger" ><b><?php echo $i?></b></span>
                        <?php
                            }
                        ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="confirmSubmit" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="delete">
    <div class="modal-dialog modal-md moda-danger mdls" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h3><b><span id="confirm">Are you sure you want to submit this exam?</span></b></h3>
            </div>
            <div class="modal-footer">
                <button class="btn btn-lg btn-success pull-left submit" id="submit" data-dismiss="modal">Yes! Submit</button>
                <button class="btn btn-lg btn-danger" data-dismiss="modal" >No</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="errorModal" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="error">
    <div class="modal-dialog modal-md moda-danger mdls" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h1 class="text-danger"><b>
                    ERROR! YOU COMPUTER IS NOT CONNECTED TO THE NETWORK, PLEASE CONTACT SYSTEM ADMIN.
                </b></h1>
            </div>
        </div>
    </div>
</div>

<!-- TAB ONE script -->
    <script src='js/jquery-2.1.0.min.js' type="text/javascript"></script>
    <script src='js/bootstrap.js' type="text/javascript"></script>
    <script type="text/javascript" src="Admin/dist/js/custom.js"></script>
    <script type="text/javascript">
        var totalq = <?php echo $numrows; ?>;
        var id = <?php echo $stdid; ?>;
        var aid = <?php echo $aid; ?>;

        //var testid = <?php //echo $_SESSION['testid']; ?>
        
        function requestFullScreen(element) {
            var requestMethod = element.requestFullScreen || element.webkitRequestFullScreen || element.mozRequestFullScreen || element.msRequestFullScreen;
            if (requestMethod) {
                requestMethod.call(element)
            } else if (typeof window.ActiveXObject !== "undefined") {
                var wscript = new ActiveXObject("WScript.Shell");
                if (wscript !== null) {
                    wscript.SendKeys("{F11}");
                }
                
            }
        }
        document.addEventListener('contextmenu', event => event.preventDefault());
        
        $(document).ready(function (e) {
            setInterval ('countdown(aid)', 1000);
            setInterval('trackTimer(<?php echo $stdid; ?>, <?php echo $paper_id; ?>)', 1000*5)
            confirmSubmit();
            optionClick(<?php echo $stdid; ?>);
            logout();

            var storedTime = JSON.parse(localStorage.getItem(aid));
            $('.min').html(padZero(storedTime.min));
            $('.sec').html(padZero(storedTime.sec));
            $('body').click(function() {
                var elem = document.body;
                requestFullScreen(elem);
            });
        })
    </script>
<!--END OF TAB ONE script -->

</div>
</body>

</html>
