<?php
session_start();
session_destroy();
/**
 * Created by PhpStorm.
 * User: freshsalis
 * Date: 12/15/2017
 * Time: 2:15 PM
 */
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Test Master| Log in</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <link href="Admin/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <!-- <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" /> -->
    <!-- Theme style -->
    <link href="Admin/dist/css/AdminLTE.css" rel="stylesheet" type="text/css" />
    <!-- iCheck -->

    <link
      rel="shortcut icon"
      type="image/x-icon"
      href="./logo.png"
    />

    <!-- <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script> -->

</head>
<body class="login-page" oncontextmenu="return false">
    <img src="images/ba.jpg" class="img-responsive logo-img" style="height:200;"/>


<div class="login-box">
    <div class="login-logo">
        <small>CBT Student Login</small>

    </div><!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Sign in to start your test</p>
        <div class="alert alert1" hidden="hidden"><span><img src="images/mm.gif"/></span>
            <b>Success! </b>Login Sucessfully
        </div>
        <form action="#" method="post" class="login" role="form" name="cbt" id="cbt">
            <div class="form-group input-group has-feedback">
                <span class="input-group-addon">Reg. No.</span>
                <input class="form-control" type="text" id="username" name="username"  required />
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group input-group has-feedback">
                <span class="input-group-addon">Acces PIN</span>
                <input class="form-control" type="text" id="pwd" name="pwd"  required />
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="form-group input-group has-feedback">
                <span class="input-group-addon">Exam</span>
                <?php
                include 'Admin/asset/classes/Test.php';
                $test = new Test();
                echo $test->getActiveExamCombo();
                ?>
            </div>
            <div class="row">
                <!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" id="subm" class="btn btn-primary btn-block btn-flat">Login</button>
                </div><!-- /.col -->
            </div>
        </form>

    </div><!-- /.login-box-body -->
</div><!-- /.login-box -->



<!-- jQuery 2.1.3 -->
<script src="Admin/plugins/jquery/jQuery-2.1.3.min.js"></script>
<!-- Bootstrap 3.3.2 JS -->
<script src="Admin/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="Admin/dist/js/myjquery.js" type="text/javascript"></script>
<!-- iCheck -->
<script>
    // function requestFullScreen(element) {
    //     var requestMethod = element.requestFullScreen || element.webkitRequestFullScreen || element.mozRequestFullScreen || element.msRequestFullScreen;
    //     if (requestMethod) {
    //         requestMethod.call(element)
    //     } else if (typeof window.ActiveXObject !== "undefined") {
    //         var wscript = new ActiveXObject("WScript.Shell");
    //         if (wscript !== null) {
    //             wscript.SendKeys("{F11}");
    //         }
            
    //     }
    // }
    // $('body').click(function () {
    //     var elem = document.body;
    //     requestFullScreen(elem);
    // });
    
</script>
</body>
</html>