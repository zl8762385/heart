
<?php tpl_include( 'public/header' )?>

<section class="wrapper">
    <div class="panel mr0">
        <?php if( !empty( $pid ) ):?>
        <header class="panel-heading">
            <a href="<?=$refer?>">
                <button type="button" class="btn btn-inverse">
                    <i class="icon-chevron-left btn-icon"></i>返回上级
                </button>
            </a>
        </header>
        <?php endif;?>

        <header>
            <header class="panel-heading">
                <a href="<?=make_url( 'admin', __C__, 'index', ['pid='.$pid] )?>" class="btn btn-info btn-sm" id="index-listing">
                    <i class="icon-gears2 btn-icon"></i>菜单列表
                </a>
                <a href="<?=make_url( 'admin', __C__, 'add', ['pid='.$pid] )?>" class="btn btn-default btn-sm" id="index-add">
                    <i class="icon-plus btn-icon"></i>添加菜单
                </a>
            </header>
        </header>

        <form name="myform" method="post" action="<?=make_url( 'admin', 'menu', 'sort' )?>">
            <div class="panel-body" id="panel-bodys">
                <table class="table table-striped table-advance table-hover">
                    <thead>
                    <tr>
                        <th class="tablehead"><i class="icon-home"></i> 排序</th>
                        <th class="tablehead">ID</th>
                        <th class="tablehead">菜单名</th>
                        <th class="tablehead">模块名</th>
                        <th class="tablehead">控制器名</th>
                        <th class="tablehead">方法名</th>
                        <th class="tablehead">是否显示</th>
                        <th class="tablehead">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach( $lists as $k => $v ):?>
                    <tr id="m_<?=$v['menuid']?>">
                        <td>
                            <div>
                                <input type="text" class="center" style="padding:3px;" name="ids[<?=$v['menuid']?>]" size="3" value="<?=$v['sort']?>" >
                            </div>
                        </td>
                        <td><?=$v['menuid']?></td>
                        <td><a href="<?=make_url( __M__, __C__, 'index', ['pid='.$v['menuid']])?>" class="menunamea"><?=$v['name']?> <i class="icon-gears2"></i></a> </td>
                        <td><?=$v['model']?></td>
                        <td><?=$v['controller']?></td>
                        <td><?=$v['action']?></td>
                        <td class="hidden-phone">
                            <?php if( empty( $v['display'] ) ):?>
                            <span class="label btn-danger label-mini">
                                不显示
                            </span>
                            <?php else:?>
                            <span class="label btn-primary label-mini">
                                显示
                            </span>
                            <?php endif;?>
                        </td>
                        <td>
                            <a href="<?=make_url( __M__, __C__, 'add', ["pid={$v['menuid']}"] )?>" class="btn btn-info btn-xs">添加子菜单</a>
                            <a href="<?=make_url( __M__, __C__, 'edit', ['menuid='.$v['menuid']] )?>" class="btn btn-primary btn-xs">修改</a>
                            <a href="javascript:void(0)" onclick="del('<?=make_url( __M__, __C__, 'del', ['menuid='.$v['menuid']] )?>', <?=$v['menuid']?>)" class="btn btn-danger btn-xs">删除</a>
                        </td>
                    </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="pull-left">
                            <input type="submit" class="btn btn-info" name="submit" value="排序">
                        </div>

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

<?php tpl_include( 'public/footer' )?>
