<?php
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
    <title>Test Master | Log in</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <link href="../Admin/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <!-- <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" /> -->
    <!-- Theme style -->
    <link href="../Admin/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="../Admin/plugins/iCheck/square/blue.css" rel="stylesheet" type="text/css" />
    <link
      rel="shortcut icon"
      type="image/x-icon"
      href="../logo.png"
    />
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<body class="login-page">
    <img src="../images/ba.jpg" class="img-responsive" width="100%" height="5%"/>


<div class="login-box">
    <div class="login-logo">
        <small>Examiner's Login</small>

    </div><!-- /.login-logo -->
    <div class="login-box-body">

        <div class="alert alert1" hidden="hidden"><span><img src="images/mm.gif"/></span>
            <b>Success! </b>Login Sucessfully
        </div>
        <form action="#" method="post" class="examiner-login" role="form" name="examiner-login" id="examiner-login">
            <div class="form-group input-group has-feedback">
                <span class="input-group-addon">Matric No.</span>
                <input class="form-control" type="text" id="username" name="username"  required />
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group input-group has-feedback">
                <span class="input-group-addon">Password</span>
                <input class="form-control" type="password" id="pwd" name="pwd"  required />
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox icheck">
                        Student's <a href="../login.php">login</a>
                    </div>
                </div><!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" id="subm" class="btn btn-primary btn-block btn-flat">Login</button>
                </div><!-- /.col -->
            </div>
        </form>

    </div><!-- /.login-box-body -->
</div><!-- /.login-box -->



<!-- jQuery 2.1.3 -->
<script src="../Admin/plugins/jquery/jQuery-2.1.3.min.js"></script>
<!-- Bootstrap 3.3.2 JS -->
<script src="../Admin/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="../Admin/dist/js/myjquery.js" type="text/javascript"></script>
<!-- iCheck -->
<script src="../Admin/plugins/iCheck/icheck.min.js" type="text/javascript"></script>
<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    });
</script>
</body>
</html>