<?php tpl_include( 'public/header' )?>

<section class="wrapper">
    <div class="panel mr0">
        <header>
            <header class="panel-heading">
                <a href="<?=make_url( 'admin', 'user', 'index' )?>" class="btn btn-info btn-sm" id="index-listing">
                    <i class="icon-gears2 btn-icon"></i>管理员列表
                </a>
                <a href="<?=make_url( 'admin', 'user', 'add' )?>" class="btn btn-default btn-sm" id="index-add">
                    <i class="icon-plus btn-icon"></i>添加管理员
                </a>
            </header>
        </header>
        <header class="panel-heading">
            <form class="form-inline" role="form">
                <input type="hidden" name="m" value="<?=__M__?>" />
                <input type="hidden" name="c" value="<?=__C__?>" />
                <input type="hidden" name="a" value="<?=__A__?>" />
                <div class="input-group">
                    <select name="column" class="form-control">
                        <option value="username" selected>用户名</option>
                        <option value="truename">真实姓名</option>
                        <option value="uid" >UID</option>
                        <option value="email" >Email</option>
                    </select>
                </div>
                <input type="text" name="q" class="usernamekey form-control" value=""/>

                <button type="submit" class="btn btn-info btn-sm">搜索</button>
            </form>
        </header>
        <form name="myform" method="post" action="?m=member&f=index&v=del&_su=wuzhicms&_menuid=30">
            <div class="panel-body" id="panel-bodys">
                <table class="table table-striped table-advance table-hover">
                    <thead>
                    <tr>
                        <th class="tablehead">UID</th>
                        <th class="tablehead">用户名</th>
                        <th class="tablehead">真实姓名</th>
                        <th class="tablehead">Email</th>
                        <th class="tablehead">所属角色</th>
                        <th class="tablehead">创建时间</th>
                        <th class="tablehead">更新时间</th>
                        <th class="tablehead">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach( $lists as $k => $v ):?>
                    <tr id="u_<?=$v['uid']?>">
                        <td><?=$v['uid']?></td>
                        <td><?=$v['username']?></td>
                        <td><?=$v['truename']?></td>
                        <td><?=$v['email']?></td>
                        <td>
                            <?php $role_infos = $db_role->get_one( 'id,name', ['id' => $v['groupid']]);?>
                            <font color="#AD5B0D"><?=$role_infos['name']?></font>
                        </td>
                        <td><?=date('Y-m-d', $v['createtime'])?></td>
                        <td><?=date('Y-m-d', $v['updatetime'])?></td>
                        <td>
                            <a href="javascript:void(0)" onclick="setpassword(1, 'admin', '123@admin.com')" class="btn btn-warning btn-xs"><?php if( $v['islock'] ):?>锁定<?php else:?>未锁定<?php endif;?></a>
                            <a href="<?=make_url( 'admin', 'user', 'edit', ['uid='.$v['uid']] )?>" class="btn btn-primary btn-xs">修改</a>
                            <a href="javascript:void(0)" onclick="del('<?=make_url( 'admin', 'user', 'del', ['uid='.$v['uid']] )?>', <?=$v['uid']?>)" class="btn btn-danger btn-xs">删除</a>
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
                $('#u_' + uid).remove();
            }else{
                toast('删除失败');
            }
        });
    }
</script>

<?php tpl_include( 'public/footer' )?>
