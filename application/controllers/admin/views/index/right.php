<?=tpl_include( 'public/header' );?>
<section class="wrapper">
    <!--state overview start-->
    <div class="row state-overview">
        <div class="col-lg-3 col-sm-6">
            <section class="panel">
                <div class="symbol userblue">
                    <i class="icon-users"></i>
                </div>
                <div class="value">
                    <a href=""><h1 id="count1">0</h1></a>
                    <p>用户总量</p>
                </div>
            </section>
        </div>
        <div class="col-lg-3 col-sm-6">
            <section class="panel">
                <div class="symbol commred">
                    <i class="icon-user-add"></i>
                </div>
                <div class="value">
                    <a href="?"><h1 id="count2">0</h1></a>
                    <p>今日注册用户</p>
                </div>
            </section>
        </div>
        <div class="col-lg-3 col-sm-6">
            <section class="panel">
                <div class="symbol articlegreen">
                    <i class="icon-file-word-o"></i>
                </div>
                <div class="value">
                    <a href=""><h1 id="count3">0</h1></a>
                    <p>文章总数</p>
                </div>
            </section>
        </div>
        <div class="col-lg-3 col-sm-6">
            <section class="panel">
                <div class="symbol rsswet">
                    <i class="icon-check-circle"></i>
                </div>
                <div class="value">
                    <a href=""><h1 id="count4">0</h1></a>
                    <p>待审文章总数</p>
                </div>
            </section>
        </div>
    </div>
    <!--state overview end-->

    <div class="row">
        <!-- 表单 -->
        <div class="col-lg-6">
            <section class="panel">
                <header class="panel-heading bm0">
                    <span>最新发布内容</span>
                            <span class="tools pull-right">
                                <a class="icon-chevron-down" href="javascript:;"></a>
                            </span>

                </header>
                <div class="panel-body" id="panel-bodys">
                    <table class="table table-hover personal-task">
                        <tbody>

                        <tr>
                            <td>单品团</td>
                            <td><a href='/index.php?v=show&cid=48&id=2' target='_blank'>往期团购</a></td>
                            <td class="col-md-4">
                                2016-03-31 15:36:52                                    </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
        <!-- 表单 -->
        <div class="col-lg-6">
            <!--系统升级-->
            <section class="panel">
                <header class="panel-heading bm0">
                    <span>系统更新 </span><span class="badge" style="background-color:#FF3333"></span>
                    <span class="tools pull-right">
                        <a class="icon-chevron-down" href="javascript:;"></a>
                    </span>
                </header>
                <div class="panel-body" id="panel-bodys">
                    <table class="table table-hover system-upgrade">
                        <tbody>
                        <tr>
                            <td>
                                <strong>版本信息</strong>：当前版本 V
                                3.0.0                                                     </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>

                                <strong>升级信息</strong>：
                                已经是最新版本: V3.0.0

                            </td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </section>
            <!-- 版权信息 -->
            <section class="panel">
                <header class="panel-heading bm0">
                    <span>团队及版权信息</span>
                            <span class="tools pull-right">
                                <a class="icon-chevron-down" href="javascript:;"></a>
                            </span>
                </header>
                <div class="panel-body" id="panel-bodys">
                    <table class="table table-hover personal-task">
                        <tbody>
                        <tr>
                            <td>
                                <strong>架构设计</strong>： 猫小七
                                <a href="http://www.heartphp.com" target="_blank">[HeartPHP.com 版权所有]</a>

                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><strong>环境信息</strong>：<a data-toggle="modal" href="#chartsetting"><?=PHP_OS.'  '.$_SERVER["SERVER_SOFTWARE"]?>【查看基本信息】</a>
                                <a href="<?=make_url( 'admin', 'index', 'phpinfo' )?>" target="_blank" >【点击查看 phpinfo()】</a><br/>
                                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="chartsetting" class="modal fade">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title">服务器基本信息</h4>
                                            </div>
                                            <div class="modal-body">
                                                <p>
                                                    系统类型及版本号： <?=php_uname()?><br/>
                                                    站点路径： <?=$_SERVER['DOCUMENT_ROOT']?><br/>
                                                    PHP运行方式：<?=php_sapi_name();?> <br/>
                                                    服务器软件：<?=$_SERVER["SERVER_SOFTWARE"]?> <br/>
                                                    浏览信息：<?=substr($_SERVER['HTTP_USER_AGENT'], 0, 40)?> <br/>
                                                    PHP 版本： <?=PHP_VERSION?><br/>
                                                    <!--                            上传文件最大限制：--><!-- <br/>-->
                                                    Zend版本：Zend_Version()                                              </p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" data-dismiss="modal" class="btn btn-default">隐藏</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                <strong>服务器IP</strong>：<?=$_SERVER['REMOTE_ADDR']?>                            </td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
        <!-- 版权信息 -->
    </div>
    </div>
</section>


<?=tpl_include( 'public/footer' );?>
