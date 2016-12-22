<?php tpl_include( 'public/header' )?>

<section class="wrapper">
    <div class="panel mr0">

        <header>
            <header class="panel-heading">
                <a href="<?=make_url( 'admin', __C__, 'index' )?>" class="btn btn-info btn-sm" id="index-listing">
                    <i class="icon-gears2 btn-icon"></i>专题列表
                </a>
                <a href="<?=make_url( 'admin', __C__, 'add' )?>" class="btn btn-default btn-sm" id="index-add">
                    <i class="icon-plus btn-icon"></i>添加专题
                </a>
            </header>
        </header>

        <form name="myform" method="post" action="<?=make_url( 'admin', 'menu', 'sort' )?>">
            <div class="panel-body" id="panel-bodys">
                <table class="table table-striped table-advance table-hover">
                    <thead>
                    <tr>
                        <th class="tablehead">ID</th>
                        <th class="tablehead">专题名称</th>
                        <th class="tablehead">创建时间</th>
                        <th class="tablehead">数据操作</th>
                        <th class="tablehead">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach( $lists as $k => $v ):?>
                    <tr id="m_<?=$v['id']?>">

                        <td><?=$v['id']?></td>
                        <td><a href="<?=make_url( __M__, __C__, 'index', ['id='.$v['id']])?>" class="menunamea"><?=$v['name']?> <i class="icon-gears2"></i></a> </td>
                        <td><?=date('Y-m-d H:i:s', $v['createtime'])?></td>
                        <td>

                            <a class="btn btn-default btn-xs" href="<?=make_url( __M__, 'special_data_model', 'index', ['sid='.$v['id']])?>" title="数据模型">数据模型</a>
<!--                            <a class="btn btn-default btn-xs" target="_blank" href="--><?//=make_url( __M__, 'special_data', 'index', ['id='.$v['id']])?><!--">数据块</a>-->
                            <a class="btn btn-default btn-xs" href="<?=make_url( __M__, 'special_tpl', 'view', ['id='.$v['id']])?>" title="在线编辑模板 - 快捷添加碎片数据">编辑模板</a>
                            <a class="btn btn-default btn-xs" href="javascript:dialog_tpl('<?=make_url( __M__, __C__, 'view', ['id='.$v['id'], 'type=select' ])?>', '选择 - 可视化编辑页面','view_tpl', 800, 300)">可视化编辑</a>

                        </td>

                        <td>

                            <a href="<?=make_url( __M__, 'special_block', 'index', ['sid='.$v['id']] )?>" class="btn btn-info btn-xs">碎片管理</a>
                            <a href="<?=make_url( __M__, __C__, 'edit', ['id='.$v['id']] )?>" class="btn btn-primary btn-xs">修改</a>
                            <a href="javascript:void(0)" onclick="del('<?=make_url( __M__, __C__, 'del', ['id='.$v['id']] )?>', <?=$v['id']?>)" class="btn btn-danger btn-xs">删除</a>
                        </td>
                    </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
<!--                        <div class="pull-left">-->
<!--                            <input type="submit" class="btn btn-info" name="submit" value="排序">-->
<!--                        </div>-->

                        <div class="pull-right">
                            <ul class="pagination pagination-sm mr0">
                                <?=$page?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
<script type="text/javascript">
    function del(url, uid){
        if(!confirm('您确认要删除吗，该操作不可恢复！'))return false;

        $.get(url, function(data){
            if(data == 1) {
                toast('删除成功');
                $('#m_' + uid).remove();
            }else{
                toast('删除失败');
            }
        });
    }

</script>
</body>
</html>