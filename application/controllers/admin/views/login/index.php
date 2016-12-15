<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!--[if IE]>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <![endif]-->
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimal-ui, user-scalable=no">
    <meta name="description" content="" />
    <meta name="author" content="heartphp" />
    <title>内容管理系统</title>
    <link href="<?=$domain.$css?>bootstrap.min.css" rel="stylesheet" />
    <link href="<?=$domain.$css?>bootstrapreset.css" rel="stylesheet" />
    <link href="<?=$domain.$css?>pxgridsicons.min.css" rel="stylesheet" />
    <link href="<?=$domain.$css?>style.css" rel="stylesheet" />
    <link href="<?=$domain.$css?>responsive.css" rel="stylesheet" media="screen"/>
    <link href="<?=$domain.$css?>animation.css" rel="stylesheet" />
    <script src="<?=$domain.$js?>jquery.min.js"></script>

</head>
<body class="login-body">
<div class="container fadeInDown">
    <form class="form-signin" id="form_login" action="" method="post">
        <div class="form-signin-heading"></div>
        <div class="login-wrap">
            <div class="form-group" style="margin-top:30px; ">
                <div class="input-group" id="username_error">
                    <div class="input-group-addon">
                        <i class="icon-user"></i>
                    </div>
                    <input type="text" class="form-control" name="username" id="username" placeholder="用户名" autocomplete="off" autofocus>
                </div>
            </div>
            <div class="form-group">
                <div class="input-group" id="password_error">
                    <div class="input-group-addon">
                        <i class="icon-key5"></i>
                    </div>
                    <input type="password" class="form-control" name="password" id="password" placeholder="密码" autocomplete="off">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group" id="codeid_error">
                    <div class="input-group-addon">
                        <i class="icon-qrcode"></i>
                    </div>
                    <input type="text" id="codeid" name="checkcode" class="form-control" placeholder="验证码" onfocus="javascript:document.getElementById('code_img').src='/admin/login/code?rd='+Math.random();void(0);">
                    <div class="input-group-addon" id="logincode">
                        <img src="<?=$domain.$images?>logincode.jpg" id="code_img" alt="点击刷新" onclick="javascript:this.src='/admin/login/code?rd='+Math.random();void(0);">
                    </div>
                </div>
            </div>
            <input type="hidden" value="1" name="dosubmit" />
            <button type="submit" name="submit" class="btn btn-shadow btn-danger btn-block btn-login">登 录</button>
        </div>
        <div class="form-signin-bottom center">Copyright &copy; 2016 heartphp.com </div>
    </form>
</div>

</body>
</html>