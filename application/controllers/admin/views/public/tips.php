<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js sidebar-large lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js sidebar-large lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js sidebar-large lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="zh-cn" class="no-js sidebar-large"> <!--<![endif]-->
<meta http-equiv="content-type" content="text/html;charset=utf-8 echo CHARSET;?>" />
<!--[if IE]>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<![endif]-->
<head>
    <title>内容管理系统</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="" />
    <meta name="author" content="Pixel grid studio"  />
    <link href="<?=$domain.$css?>bootstrap.min.css" rel="stylesheet">
    <link href="<?=$domain.$css?>bootstrapreset.css" rel="stylesheet">
    <link href="<?=$domain.$css?>pxgridsicons.min.css" rel="stylesheet" />
    <link href="<?=$domain.$css?>style.css" rel="stylesheet">
    <link href="<?=$domain.$css?>responsive.css" rel="stylesheet" />
    <script src="<?=$domain.$js?>jquery.min.js"></script>
    <script src="<?=$domain.$js?>base.js"></script>

</head>
<body class="body pxgridsbody">
<div class="container">
    <div class="prompt center">
        <div class="promptmain">
            <div class="prompthead"></div>
            <div class="prompcontainer">
                <h4><i class="icon-info"></i><span><?=$title?></span></h4>

                <?php if( !empty( $url ) ):?>
                <script language="javascript">
                    setTimeout("gotourl('<?=$url?>');",3000);
                </script>
                <a href="<?=$url?>">页面将自动跳转，请稍等</a>
                <?php endif;?>
            </div>
            <div class="promptfooter"><a href="javascript:history.back();" >[ 返回上一页 ]</a></div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function(){
        parent.window.scroll(0,0);
    })
</script>
</body>
</html>
