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
                <a href="<?=make_url( __M__, __C__, 'index_field', [ 'id='.$id ] )?>" class="btn btn-default btn-sm" id="index-listing">
                    <i class="icon-gears2 btn-icon"></i><?=$name?> - 字段列表
                </a>
                <a href="javascript:void(0)" class="btn btn-info btn-sm" id="index-add">
                    <i class="icon-plus btn-icon"></i>添加字段
                </a>
            </header>
        </header>

        <header class="panel-heading">
            <span>添加字段</span>
        </header>

        <div class="panel-body">
            <form class="form-horizontal tasi-form" method="post" action="">

                <!--
                <div class="form-group">
                    <label class="col-sm-2 col-xs-4 control-label">类别</label>
                    <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                        <select name="form[lang]" class="form-control">
                            <option value="zh-cn" selected="">中文</option>
                        </select>
                    </div>
                </div>
                -->

                <div class="form-group">
                    <label class="col-sm-2 col-xs-4 control-label">字段类别</label>
                    <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                        <select name="infos[type]" class="form-control">
                            <?php foreach( $field_list as $k => $v ):?>
                            <option value="<?=$k?>"><?=$v?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 col-xs-4 control-label">字段名</label>
                    <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                        <input type="text" class="form-control" name="infos[field_name]" value="">
                        <span class="help-block">例如：只能由英文字母、数字和下划线组成</span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 col-xs-4 control-label">字段别名</label>
                    <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                        <input type="text" class="form-control" name="infos[name]" value="" color="#000000">
                        <span class="help-block">例如：文章标题</span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 col-xs-4 control-label">字段简介</label>
                    <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                        <textarea name="infos[description]" class="form-control" cols="60" rows="3"></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 col-xs-4 control-label"></label>
                    <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                        <input type="hidden" name="model_id" value="<?=$id?>" />
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