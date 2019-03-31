<!DOCTYPE html>
<html lang="en">
<head>
<title>{{ project_name }}</title>
<meta charset="utf-8">
<meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="<?php echo base_url('assets/lib/bootstrap/css/bootstrap.css');?>">
<link rel="stylesheet" href="<?php echo base_url('assets/{{ project_theme }}/theme.css');?>">
<link rel="stylesheet" href="<?php echo base_url('assets/lib/font-awesome/css/font-awesome.css');?>">
<link rel="stylesheet" href="<?php echo base_url('assets/css/other.css');?>">
<script src="<?php echo base_url('assets/lib/jquery/jquery-1.8.1.min.js');?>"></script>
<script src="<?php echo base_url('assets/lib/bootstrap/js/bootstrap.min.js');?>"></script>
<script src="<?php echo base_url('assets/lib/bootstrap/js/bootbox.min.js');?>"></script>
<!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
</head>

<!--[if lt IE 7 ]> <body class="ie ie6"> <![endif]-->
<!--[if IE 7 ]> <body class="ie ie7 "> <![endif]-->
<!--[if IE 8 ]> <body class="ie ie8 "> <![endif]-->
<!--[if IE 9 ]> <body class="ie ie9 "> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<body class="simple_body"><!--<![endif]-->
<div class="navbar">
    <div class="navbar-inner">
        <a class="brand" onclick="javascript:void(0);"><span class="second">{{ project_name }}</span></a>
    </div>
</div>
<div class="container-fluid">
    <div class="row-fluid">
    <div class="dialog">
    <?php if(isset($message) && $message) : ?>
    <div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><?php echo $message;?></div>
    <?php endif;?>
        <div class="block">
            <p class="block-heading">登入</p>
            <div class="block-body">
                <form name="login" method="post" action="">
                    <label>账号</label>
                    <input type="text" class="span12" name="username" value="" required="true" autofocus="true" autocomplete="off">
                    <label>密码</label>
                    <input type="password" class="span12" name="password" value="" required="true">
                    <label>验证码</label>
                    <input type="text" name="verify_code" class="span4" placeholder="输入验证码" autocomplete="off" required="required">
                    <img title="验证码" id="verify_code" src="<?php echo site_url('verify_code');?>" style="vertical-align:top">
                    <input type="submit" class="btn btn-primary pull-right" name="loginSubmit" value="登入"></div>
                </form>
            </div>
        </div>
    </div>
    <footer><hr><p>&copy; {{ "now"|date("Y") }}</p></footer>
</div>
</body>
</html>