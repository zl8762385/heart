<?php tpl_include( 'public/header' )?>
<link rel="stylesheet" href="<?=$domain.$js?>ztree/ztreestyle/zTreeStyle.css" type="text/css" />
<script type="text/javascript" src="<?=$domain.$js?>ztree/jquery.ztree.core-3.5.js"></script>
<script type="text/javascript" src="<?=$domain.$js?>ztree/jquery.ztree.excheck-3.5.js"></script>
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

<SCRIPT type="text/javascript">
    var setting = {
        check: {
            enable: true
        },
        data: {
            simpleData: {
                enable: true,
                idKey:'id',
                pIdKey:'parentid'
            }
        },

        callback: {
            onCheck: onCheck
        }
    };

    var nodes = <?=$menus?>;

    function onCheck(e, treeId, treeNode) {
        var zTree = $.fn.zTree.getZTreeObj("power_tree_check"),
            nodes = zTree.getCheckedNodes(true),
            input = [];

        for( var n in nodes ) {
            input.push( nodes[n].id );
        }

        $('[name=group_ids]').val( input.join(',') );
    }

    $(document).ready(function(){
        $.fn.zTree.init($("#power_tree_check"), setting, nodes);
    });
</SCRIPT>

<section class="wrapper">
    <div class="panel">
        <header>
            <header class="panel-heading">
                <a href="<?=make_url( __M__, __C__, 'index' )?>" class="btn btn-default btn-sm" id="index-listing">
                    <i class="icon-gears2 btn-icon"></i>角色列表
                </a>
                <a href="<?=make_url( __M__, __C__, 'add' )?>" class="btn btn-info btn-sm" id="index-add">
                    <i class="icon-plus btn-icon"></i>添加角色
                </a>
            </header>
        </header>

        <header class="panel-heading">
            <span>添加角色</span>
        </header>

        <div class="panel-body">
            <form class="form-horizontal tasi-form" method="post" action="">

                <div class="form-group">
                    <label class="col-sm-2 col-xs-4 control-label">角色名称</label>
                    <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                        <input type="text" class="form-control" name="infos[name]" value="" color="#000000">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 col-xs-4 control-label">简介</label>
                    <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                        <textarea name="infos[description]" class="form-control" cols="60" rows="3"></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 col-xs-4 control-label">权限</label>
                    <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
<!--                        <select name="infos[groupid]" style="height:300px;" class="form-control" multiple="multiple" title="按住“Ctrl”或“Shift”键可以多选，按住“Ctrl”可取消选择">-->
<!--                            <option value="" selected="">≡ 全部 ≡</option>-->
<!--                            <option value="1">新闻</option>-->
<!--                            <option value="56">&nbsp;└&nbsp;付款方式</option>-->
<!--                        </select>-->

                        <input type="hidden" name="group_ids" value="" />
                        <div class="zTreeDemoBackground left">
                            <ul id="power_tree_check" class="ztree"></ul>
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
