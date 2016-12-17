<?php tpl_include( 'public/header' )?>
<style type="text/css">
    .table_form td{
        padding: 10px;
    }
    .trbg{background-color: #b2d8e4;}
    .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
        line-height: 0.8;
    }
    .opheight>option{
        height:26px;}
</style>
<section class="wrapper">
    <div class="panel">
        <header>
            <header class="panel-heading">
                <a href="<?=make_url( 'admin', 'menu', 'index' )?>" class="btn btn-default btn-sm" id="index-listing">
                    <i class="icon-gears2 btn-icon"></i>菜单列表
                </a>
                <a href="javascript:void(0);" class="btn btn-info btn-sm" id="index-add">
                    <i class="icon-plus btn-icon"></i>修改菜单
                </a>
            </header>
        </header>

        <header class="panel-heading">
            <span>修改菜单</span>
        </header>

        <div class="panel-body">
            <form class="form-horizontal tasi-form" method="post" action="">
                <div class="form-group">
                    <label class="col-sm-2 col-xs-4 control-label">菜单名</label>
                    <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                        <input type="text" class="form-control" name="infos[name]" value="<?=$infos['name']?>" color="#000000">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 col-xs-4 control-label">模块名</label>
                    <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                        <input type="text" class="form-control" name="infos[model]" value="<?=$infos['model']?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 col-xs-4 control-label">控制器名</label>
                    <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                        <input type="text" class="form-control" name="infos[controller]" value="<?=$infos['controller']?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 col-xs-4 control-label">方法名</label>
                    <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                        <input type="text" class="form-control" name="infos[action]" value="<?=$infos['action']?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 col-xs-4 control-label">ICON</label>
                    <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                        <input type="text" class="form-control" name="infos[icon]" value="<?=$infos['icon']?>">
                        <span class="help-block">例如：appicons/1.png</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 col-xs-4 control-label">附加参数</label>
                    <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                        <input type="text" class="form-control" name="infos[param]" value="<?=$infos['param']?>">
                        <span class="help-block">例如：type=1&flag=open</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 col-xs-4 control-label"></label>
                    <div class="col-lg-4 col-sm-6 col-xs-6 input-group">
                        <div class="radioscross">
                            <label class="label_radio">
                                <input name="infos[display]" value="1" type="radio" <?php if( $infos['display'] == 1 ):?>checked<?php endif;?> /> 显示
                            </label>

                            <label class="label_radio">
                                <input name="infos[display]" value="0" type="radio" <?php if( empty( $infos['display'] ) ):?>checked<?php endif;?>/> 不显示
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 col-xs-4 control-label"></label>
                    <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                        <input type="hidden" name="menuid" value="<?=$infos['menuid']?>" />
                        <input class="btn btn-info col-sm-12 col-xs-12" type="submit" name="dosubmit" value="提交">
                    </div>
                </div>
            </form>
        </div>

        </form>
    </div>
    </div>
</section>
<script src="<?=$domain.$js?>bootstrap.min.js"></script>
<script src="<?=$domain.$js?>jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?=$domain.$js?>pxgrids-scripts.js"></script>