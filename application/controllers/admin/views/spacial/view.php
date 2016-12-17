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
    <meta name="author" content="Pixel grid studio" />
    <title>内容管理系统</title>
    <link href="<?=$domain.$css?>bootstrap.min.css" rel="stylesheet" />
    <link href="<?=$domain.$css?>bootstrapreset.css" rel="stylesheet" />
    <link href="<?=$domain.$css?>responsive.css" rel="stylesheet" media="screen"/>
    <link href="<?=$domain.$css?>animation.css" rel="stylesheet" />
    <script src="<?=$domain.$js?>modernizr-2.6.2-respond-1.1.0.min.js"></script>
    <script src="<?=$domain.$js?>jquery.min.js"></script>
    <script src="<?=$domain.$js?>base.js"></script>
    <script src="<?=$domain.$js?>jquery-easing.js"></script>
    <script src="<?=$domain.$js?>responsivenav.js"></script>

    <!--[if lt IE 9]>
    <script src="<?=$domain.$js?>html5shiv.js"></script>
    <script src="<?=$domain.$js?>respond.min.js"></script>
    <![endif]-->

    <!--[if lt IE 8]>
    <link rel="stylesheet" href="<?=$domain.$css?>ie7/ie7.css">
    <![endif]-->
</head><body class="body ">

<link rel="stylesheet" href="<?=$domain.$js?>CodeMirror/codemirror.css">
<link rel="stylesheet" href="<?=$domain.$js?>CodeMirror/theme/ambiance.css" id="mirrTheme">
<script src="<?=$domain.$js?>CodeMirror/codemirror.js"></script>
<script src="<?=$domain.$js?>CodeMirror/util.js"></script>
<script src="<?=$domain.$js?>CodeMirror/mode.js"></script>
<style>
    .top_text{margin-right:70px;line-height:40px;font-weight:800;}
</style>

<section class="wrapper">
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">

                <div class="panel-body">

                    <form name="myform" method="post" id="myform" action="" onsubmit="template_edit();return false;">

                    <div style="padding:0px 10px 25px 10px;">
                        <a href="<?=make_url( __M__, 'spacial', 'index' )?>">
                            <img src="<?=$domain.$images?>icon/folder-upload.png" />&nbsp;返回上级目录
                        </a>

                        <span class="pull-right">

                        <span class="pull-left top_text">
                            文件路径：<?=$head->root_path?>
                        </span>
                            <select node-data="select_file" name="form[lang]" class="form-control" style="width:150px;height:35px;;float:left;margin-right:20px;">
                                <?php foreach( $files as $k => $v ):?>
                                <option value="<?=$v?>" <?php if( $v == $page_url ):?>selected<?php endif;?>><?=$v?></option>
                                <?php endforeach;?>
                            </select>

                            <input type="hidden" name="page_tpl" value="<?=$page_tpl?>" />
                            <input type="hidden" name="page_node" value="<?=$page_node?>" />
                            <input type="submit" name="dosubmit" value="保存模板" class="btn btn-info" />
                        </span>
                    </div>

                    <div>
                        <textarea name="newcontent" id="newcontent" tabindex="1" style="display:none"><?=$content?></textarea>

                        <div id="flashContent" style="width:100%"></div>

                    </div>
                </div>
                    </form>
                    <script type="text/javascript">


                        function template_edit() {
                            var code = document.getElementById('ctlFlash').getText();
                            $("#wzhtml").val(code);
                            $("$myform").submit();
                        }
                    </script>

                </div>
            </section>
        </div>
    </div>
    <!-- page end-->
</section>


<script>
    jQuery(document).ready( function () {
        $('[node-data=select_file]').bind( 'change', function () {
            var value = $(this).val();
            location.href="<?=make_url( 'admin', 'spacial_tpl', 'view', ['id='.$id] )?>&page_url="+value;
        } );
    } );
function isFullScreen(cm) {
   console.log( cm.getWrapperElement().className )
   return /\bCodeMirror-fullscreen\b/.test(cm.getWrapperElement().className);
}

function winHeight() {
    return window.innerHeight || (document.documentElement || document.body).clientHeight;
}
function setFullScreen(cm, full) {
  var wrap = cm.getWrapperElement();
  if (full) {
    wrap.style.width = "100%";
    $(wrap).addClass("CodeMirror-fullscreen")
           .height(winHeight() + "px");
    document.documentElement.style.overflow = "hidden";
  } else {
    $(wrap).removeClass("CodeMirror-fullscreen");
    wrap.style.height = "";
    document.documentElement.style.overflow = "";
  }
  cm.refresh();
}
CodeMirror.on(window, "resize", function() {
  var showing = document.body.getElementsByClassName("CodeMirror-fullscreen")[0];
  if (!showing) return;
  showing.CodeMirror.getWrapperElement().style.height = winHeight() + "px";
});
var CodeMirrorEditor = CodeMirror.fromTextArea(document.getElementById("newcontent"), {
    lineNumbers: true,
    matchBrackets: true,
    mode: "application/x-httpd-php",
    indentUnit: 4,
    indentWithTabs: true,
    enterMode: "keep",
    tabMode: "shift",
    theme:"ambiance",
    extraKeys: {
        "Esc": function(cm) {
          if (isFullScreen(cm)) setFullScreen(cm, false);
        }
    }
});
CodeMirrorEditor.setSize(null,570);


</script>   
</body>
</html>