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
                <a href="<?=make_url( __M__, __C__, 'index' )?>" class="btn btn-default btn-sm" id="index-listing">
                    <i class="icon-gears2 btn-icon"></i>专题列表
                </a>
                <a href="<?=make_url( __M__, __C__, 'add' )?>" class="btn btn-info btn-sm" id="index-add">
                    <i class="icon-plus btn-icon"></i>添加专题
                </a>
            </header>
        </header>

        <div class="panel-body">
            <form class="form-horizontal tasi-form" method="post" action="">

                <div class="form-group">
                    <label class="col-sm-2 col-xs-4 control-label">专题名称(中文)</label>
                    <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                        <input type="text" class="form-control" name="infos[name]" value="" color="#000000">
                    </div>
                </div>

                <!--
                <div class="form-group">
                    <label class="col-sm-2 col-xs-4 control-label">专题名称(英文)</label>
                    <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                        <input type="text" class="form-control" name="infos[en_name]" value="" color="#000000">
                        <span class="help-block">例如：http://www.xx.com/special_names</span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 col-xs-4 control-label">文件名</label>
                    <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                        <input type="text" class="form-control" name="infos[files]" value="" color="#000000">
                        <span class="help-block">如果未填写,默认index.html,压缩包存在多文件使用逗号区分,例如:a.html,b.html,c.html</span>
                    </div>
                </div>
                -->

                <div class="form-group">
                    <label class="col-sm-2 col-xs-4 control-label">封面图</label>
                    <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                        <div class="input-group"><?=$atta;?></div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 col-xs-4 control-label">ZIP压缩包</label>
                    <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                        <div class="input-group"><?=$zip;?></div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 col-xs-4 control-label">专题简介</label>
                    <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                        <textarea name="infos[description]" class="form-control" cols="60" rows="3"></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 col-xs-4 control-label"></label>
                    <div class="col-lg-4 col-sm-6 col-xs-6 input-group">
                        <div class="radioscross">
                            <label class="label_radio">
                                <input name="infos[status]" value="0" type="radio" checked />  发布
                            </label>

                            <label class="label_radio">
                                <input name="infos[status]" value="1" type="radio" /> 暂停
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 col-xs-4 control-label"></label>
                    <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                        <input class="btn btn-info col-sm-12 col-xs-12" type="submit" name="dosubmit" value="提交">
                    </div>
                </div>
            </form>
        </div>

        </form>
    </div>
    </div>
</section>
<?php tpl_include( 'public/footer' )?>
