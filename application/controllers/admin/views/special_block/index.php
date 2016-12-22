<?php tpl_include( 'public/header' )?>

<section class="wrapper">
    <div class="panel mr0">
        <?php if( !empty( $sid ) ):?>
        <header class="panel-heading">
            <a href="<?=make_url( __M__, 'special', 'index' )?>">
                <button type="button" class="btn btn-inverse">
                    <i class="icon-chevron-left btn-icon"></i>返回 - 专题列表
                </button>
            </a>
            <a href="<?=$refer?>">
                <button type="button" class="btn btn-inverse">
                    <i class="icon-chevron-left btn-icon"></i>返回上一级
                </button>
            </a>
        </header>
        <?php endif;?>

        <header>
            <header class="panel-heading">
                <a href="<?=make_url( 'admin', __C__, 'index', [ 'sid='.$sid ] )?>" class="btn btn-info btn-sm" id="index-listing">
                    <i class="icon-gears2 btn-icon"></i>
                    <?php if( isset( $special_infos['name'] ) ):?>
                        <?=$special_infos['name']?> -
                    <?php endif;?>
                    碎片列表
                </a>
                <a href="<?=make_url( 'admin', __C__, 'add', [ 'sid='.$sid ] )?>" class="btn btn-default btn-sm" id="index-add">
                    <i class="icon-plus btn-icon"></i>添加碎片
                </a>
            </header>
        </header>

        <form name="myform" method="post" action="<?=make_url( 'admin', 'menu', 'sort' )?>">
            <div class="panel-body" id="panel-bodys">
                <table class="table table-striped table-advance table-hover">
                    <thead>
                    <tr>
                        <th class="tablehead">ID</th>
                        <th class="tablehead">碎片键值</th>
                        <th class="tablehead">碎片类型</th>
                        <th class="tablehead">调用代码</th>
                        <th class="tablehead">创建时间</th>
                        <th class="tablehead">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach( $lists as $k => $v ):?>
                    <tr id="m_<?=$v['id']?>">
                        <td><?=$v['id']?></td>
                        <td><?=$v['name']?></td>
                        <td>
                            <?php if( $v['type'] == 0 || $v['type'] == 1 ):?>
                                代码块
                            <?php elseif( $v['type'] == 2 ):?>
                                数据列表 ( <span style="font-weight: 800;">模型:</span><?=$v['model_infos']['name']?> )
                            <?php endif;?>
                        </td>
                        <td>
                            <input class="form-control" value="<{block('<?=$v['name']?>')}>" color="#000000" type="text">
                        </td>
                        <td><?=date( "Y-m-d H:i:s", $v['createtime'] )?></td>

                        <td>
                            <a href="<?=make_url( __M__, __C__, 'edit', ['id='.$v['id'], 'sid='.$v['sid']] )?>" class="btn btn-primary btn-xs">修改</a>
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