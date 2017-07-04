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
                <a href="<?=make_url( 'admin', 'user', 'index' )?>" class="btn btn-default btn-sm" id="index-listing">
                    <i class="icon-gears2 btn-icon"></i>管理员列表
                </a>
                <a href="javascript:void(0);" class="btn btn-info btn-sm" id="index-add">
                    <i class="icon-plus btn-icon"></i>修改管理员
                </a>
            </header>
        </header>
        <div class="panel-body" id="panel-bodys">
        <form name="myfrom1" class="form-horizontal tasi-form" method="post" action="">
            <table class="table table-striped table-advance table-hover">
                <thead>
                <tr>
                    <th class="tablehead"></th>
                    <th class="tablehead"></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="col-sm-2 col-xs-4 text-right"><label class="control-label">用户名</label></td>
                    <td>
                        <div class="col-lg-3 col-sm-4 col-xs-4 input-group"><input type="text" name="infos[username]" class="form-control" placeholder="请输入用户名" value="<?=$infos['username']?>" /></div>
                    </td>
                </tr>

                <tr>
                    <td class="col-sm-2 col-xs-4 text-right"><label class="control-label">密码</label></td>
                    <td>
                        <div class="col-lg-3 col-sm-4 col-xs-4 input-group"><input type="password" name="infos[password]" class="form-control" placeholder="请输入密码" /></div>
                    </td>
                </tr>
                <tr>
                    <td class="col-sm-2 col-xs-4 text-right"><label class="control-label">确认密码</label></td>
                    <td>
                        <div class="col-lg-3 col-sm-4 col-xs-4 input-group"><input type="password" name="infos[pwdconfirm]" class="form-control" placeholder="请重复输入密码" /></div>
                    </td>
                </tr>
                <tr>
                    <td class="col-sm-2 col-xs-4 text-right"><label class="control-label">邮箱</label></td>
                    <td>
                        <div class="col-lg-3 col-sm-4 col-xs-4 input-group"><input type="text" name="infos[email]" class="form-control" value="<?=$infos['email']?>" errormsg="请输入正确的Email" /></div>
                    </td>
                </tr>
                <tr>
                    <td class="col-sm-2 col-xs-4 text-right"><label class="control-label">真实姓名</label></td>
                    <td>
                        <div class="col-lg-3 col-sm-4 col-xs-4 input-group"><input type="text" name="infos[truename]" class="form-control" placeholder="" value="<?=$infos['truename']?>"/></div>
                    </td>
                </tr>
                <tr>
                    <td class="text-right"><label class="control-label">所属角色</label></td>
                    <td><div class="col-sm-4 col-xs-4 input-group">
                        <select name="infos[groupid]" class="form-control">

                            <?php foreach( $role_lists as $k => $v ):?>
                                <option value="<?=$v['id']?>" <?php if( $infos['groupid'] == $v['id'] ):?>selected<?php endif;?>><?=$v['name']?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                    </td>
                </tr>

                <tr>
                    <td class="col-sm-2 col-xs-4 text-right"><label class="control-label">状态</label></td>
                    <td>
                        <div class="col-lg-8 col-sm-8 col-xs-8 input-group">
                            <label>
                                <input type="radio" name="infos[islock]" <?php if($infos['islock']==0):?>checked<?php endif;?> value="0"> 未锁定
                            </label>
                            <label style="padding-left: 20px;">
                                <input type="radio" name="infos[islock]" <?php if($infos['islock']==1):?>checked<?php endif;?> value="1"> 锁定
                            </label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="col-sm-2 col-xs-4 text-right"><label class="control-label"></label></td>
                    <td>
                        <div class="col-lg-4 col-lg-3 col-sm-4 col-xs-4 input-group panel-footer">
                            <input type="hidden" value="<?=$infos['uid'];?>" name="uid" />
                            <input class="btn btn-info col-sm-12 col-xs-12" type="submit" name="dosubmit" value="提交">
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
    </div>

        </form>
    </div>
    </div>
</section>
<?php tpl_include( 'public/footer' )?>
