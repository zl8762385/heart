<?php tpl_include( 'public/header' );?>
<link rel="stylesheet" href="<?=$domain.$js?>dialog/ui-dialog.css" />
<script src="<?=$domain.$js?>dialog/dialog-plus.js"></script>

<section id="container" >
    <!--header start-->
    <header class="header pxgrids-bg">
        <a href="<?=$domain?>" target="_blank" class="logo pull-left">
            <img src="<?=$domain.$images?>admin_logo.png" title="点击打开网站首页">
        </a>

        <div class="pull-left topmenunav" id="menu">
            <ul class="pull-left" id="top_menu">
                <?php foreach( $menus as $k => $v ):?>
                    <li><a href="javascript:;" <?php if($k == 0):?> class="active" <?php endif;?>onclick="PANEL(this,<?=$v['menuid']?>, '<?=$v['name']?>')"><?=$v['name']?></a></li>
                <?php endforeach;?>
            </ul>
        </div>

        <div class="pull-right mobliebtn"><a id="mobile-nav" class="menu-nav" href="#menu-nav"></a></div>
        <div class="top-nav pull-right">
            <ul class="pull-right top-menu">
                <!-- userinfo dropdown start-->
                <li class="dropdown userinfo">
                    <!--
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <img src="<?=$domain.$images?>userimg.jpg" class="userimg" id="siteimg">
                        <span class="username" id="sitename">默认站点</span>
                        <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu extended userullist" id="userullist">
                        <div class="log-arrow-up"><i class="icon-sort-up"></i></div>
                        <li class="usersettitle"><h5>切换站点</h5></li>
                        <li><a href="">默认站点</a></li>
                    </ul>
                    -->
                </li>
                <!-- userinfo dropdown end -->
                <li>
                    <a href="<?=make_url( 'admin', 'login', 'logout' )?>">
                        <i class="icon-power-off"></i><span>退出</span>
                    </a>
                </li>
            </ul>
        </div>
    </header>
    <!--header end-->
    <!--sidebar start-->
    <aside>
        <div id="sidebar"  class="nav-collapse ">
            <?php foreach( $menus as $mk => $mv ):?>
            <ul class="sidebar-menu <?php if( !empty($mk) ):?>hide<?php endif;?>" id="panel-<?=$mv['menuid']?>" >
                <div class="appicon center"><img src="<?=$domain.$images.$mv['icon']?>" alt=""></div>
                <?php $sub_menus = $db_menus->select( '*', 'display=1 AND parentid='.$mv['menuid'].' AND menuid in ('.$role_list_str.')', '', 'sort ASC,menuid ASC' );?>
                <?php foreach( $sub_menus as $sk => $sv ):?>

                    <?php
                        $param = [];
                        if( strstr( $sv['param'], '&' ) ):
                            $param = explode( '&', $sv['param'] );
                        endif;

                        $url = make_url( $sv['model'], $sv['controller'], $sv['action'], $param)
                    ?>

                    <li>
                        <a href="javascript:void(0);" data-url="<?=$url?>" data-name="<?=$sv['name']?>"  onclick="_PANEL(this,<?=$sv['menuid']?>,'<?=$url?>', '<?=$sv['name']?>')" class="_p_menu <?php if( $sk == 0 ):?>active<?php endif;?>" ><span><?=$sv['name']?></span></a>
                    </li>
                <?php endforeach;?>
            </ul>
            <?php endforeach;?>
            <!-- sidebar menu end-->
        </div>
    </aside>
    <!--sidebar end-->
    <!--main content start-->
    <section id="main-content">
        <div class="main-nav">
            <div class="pull-right crumbsbutton">
                <span style="font-weight: 800;"><?=$userinfos['role']['name']?> : <?=$userinfos['username']?></span>
                <a href="" target="iframeid">更新缓存</a>
                <a href="" target="iframeid">生成首页</a>
                <a href="#" onclick="refresh_iframe()">刷新</a>
                <a href="" target="_blank" id="weburl">站点首页</a>
            </div>
            <i class="icon-desktop2"></i>
            <span id="position">
                <span data-pos="1">我的面板</span>
                <span>></span>
                <span data-pos="2">系统首页</span>
                <span>></span>
            </span>
        </div>
        <div class="alert alert-warning fade in fadeInDown hide" id="alert-warning">
            <button class="close close-sm" type="button" onclick="$('#alert-warning').addClass('hide');"><i class="icon-times2"></i></button>
            <span id="warning-tips"><strong>安全提示：</strong> 建议您将网站admin目录设置为644或只读，<a href="#">点击查看设置方法！</a></span>
        </div>
        <section id="iframecontent"><iframe  width="100%" name="iframeid" id="iframeid" frameborder="false" scrolling="auto" height="auto" allowtransparency="true" frameborder="0" src="<?=make_url( 'admin', 'index', 'right' )?>"></iframe>
        </section>
    </section>
</section>

<script src="<?=$domain.$js?>bootstrap.min.js"></script>
<script src="<?=$domain.$js?>site.js"></script>
<script src="<?=$domain.$js?>jquery.nicescroll.js" type="text/javascript"></script>

<style type="text/css">
    .validate-has-error {border-color: #EC7876;box-shadow: 0 0 0 2px rgba(236, 89, 86, 0.35);border: #EC7876 1px dotted;}
</style>
<script type="text/javascript">
    var parentpos = '';
    function PANEL(obj,menuid,name) {
        $("#top_menu li a").removeClass('active');
        $(obj).addClass('active');

        $("#sidebar ul").addClass('hide');
        $("#panel-"+menuid).removeClass("hide");
        $("._p_menu").removeClass('active');


        var _li_href = $("#panel-"+menuid+ ' li a');
        _li_href.eq(0).addClass("active");
        var gotourl = _li_href.attr( 'data-url'),
            sub_name = _li_href.attr( 'data-name' );


        $('[data-pos=1]').html( name );
        $('[data-pos=2]').html( sub_name );

        if(gotourl) $("#iframeid").attr('src', gotourl);
    }
    function _PANEL(obj,menuid,gotourl, name) {
        $('[data-pos=2]').html( name );
        $("#iframeid").attr('src', gotourl);
        $("._p_menu").removeClass('active');
        $(obj).addClass('active');
    }
    //刷新主框架
    function refresh_iframe() {
        var _iframe = document.getElementById("iframeid");
        if($("#iframeid").attr('url')) {
            _iframe.src = $("#iframeid").attr('url');
        }
    }

</script>
</body>
</html>