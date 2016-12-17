<?php tpl_include( 'public/header' )?>

<section class="wrapper">
    <div class="panel mr0">

        <header>
            <header class="panel-heading">
                <a href="<?=make_url( 'admin', __C__, 'index' )?>" class="btn btn-info btn-sm" id="index-listing">
                    <i class="icon-gears2 btn-icon"></i>角色列表
                </a>
                <a href="<?=make_url( 'admin', __C__, 'add' )?>" class="btn btn-default btn-sm" id="index-add">
                    <i class="icon-plus btn-icon"></i>添加角色
                </a>
            </header>
        </header>

        <form name="myform" method="post" action="">
            <div class="panel-body" id="panel-bodys">
                <table class="table table-striped table-advance table-hover">
                    <thead>
                    <tr>
                        <th class="tablehead">ID</th>
                        <th class="tablehead">角色名称</th>
                        <th class="tablehead">创建时间</th>
                        <th class="tablehead">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach( $lists as $k => $v ):?>
                    <tr id="m_<?=$v['id']?>">
                        <td><?=$v['id']?></td>
                        <td><?=$v['name']?></td>
                        <td><?=date('Y-m-d H:i:s', $v['createtime'])?></td>
                        <td>
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