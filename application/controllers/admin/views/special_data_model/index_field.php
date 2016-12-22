<?php tpl_include( 'public/header' )?>

<section class="wrapper">
    <div class="panel mr0">
        <?php if( !empty( $id ) ):?>
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
                <a href="javascript:void(0);" class="btn btn-info btn-sm" id="index-listing">
                    <i class="icon-gears2 btn-icon"></i><?=$name?> - 字段列表
                </a>
                <a href="<?=make_url( __M__, __C__, 'add_field', [ 'id='.$id ] )?>" class="btn btn-default btn-sm" id="index-add">
                    <i class="icon-plus btn-icon"></i>添加字段
                </a>
            </header>
        </header>

        <form name="myform" method="post" action="<?=make_url( 'admin', 'menu', 'sort' )?>">
            <div class="panel-body" id="panel-bodys">
                <table class="table table-striped table-advance table-hover">
                    <thead>
                    <tr>
                        <th class="tablehead">ID</th>
                        <th class="tablehead">字段类型</th>
                        <th class="tablehead">字段别名</th>
                        <th class="tablehead">字段名</th>
                        <th class="tablehead">创建时间</th>
                        <th class="tablehead">更新时间</th>
                        <th class="tablehead">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        foreach( $lists as $k => $v ):
                    ?>

                    <tr id="m_<?=$k?>">

                        <td><?=$k+1?></td>
                        <td><?=$v['type']?></td>
                        <td><?=urldecode( $v['name'] )?> </td>
                        <td><?=urldecode( $v['field_name'] )?> </td>
                        <td><?=date( 'Y-m-d H:i:s', $v['createtime'] )?></td>
                        <td><?=date( 'Y-m-d H:i:s', $v['updatetime'] )?></td>

                        <td>
                            <a href="<?=make_url( __M__, __C__, 'edit_field', ['id='.$id, 'k='.$k] )?>" class="btn btn-primary btn-xs">修改</a>
                            <a href="javascript:void(0)" onclick="del('<?=make_url( __M__, __C__, 'del_field', ['id='.$id,'k='.$k] )?>', <?=$k?>)" class="btn btn-danger btn-xs">删除</a>
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