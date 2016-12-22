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
                <a href="<?=make_url( __M__, __C__, 'index', ['sid='.$sid] )?>" class="btn btn-default btn-sm" id="index-listing">
                    <i class="icon-gears2 btn-icon"></i>碎片列表
                </a>
            </header>
        </header>

        <header class="panel-heading">
            <span>修改碎片</span>
        </header>

        <div class="panel-body">
            <form class="form-horizontal tasi-form" method="post" action="">
                <div class="form-group">
                    <label class="col-sm-2 col-xs-4 control-label">所属专题</label>
                    <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                        <?php if( !empty( $sid ) ):?>
                            <input type="hidden" name="infos[sid]" value="<?=$sid?>">
                            <input class="form-control" id="disabledInput" placeholder="<?=$special_infos['name']?>" disabled="" type="text">
                        <?php endif;?>
                    </div>
                </div>

                 <div class="form-group">
                    <label class="col-sm-2 col-xs-4 control-label"></label>
                    <div class="col-lg-4 col-sm-6 col-xs-6 input-group">

                        <div class="radioscross">
                            <label class="label_radio">
                                <input name="infos[type]" node-data="type" value="0" type="radio" <?php if( $infos['type'] == 0 ):?>checked<?php endif;?>/> 代码块[编辑器]
                            </label>

                            <label class="label_radio">
                                <input name="infos[type]" node-data="type" value="1" type="radio" <?php if( $infos['type'] == 1 ):?>checked<?php endif;?>/> 代码块[文本框]
                            </label>

                            <label class="label_radio">
                                <input name="infos[type]" node-data="type" value="2" type="radio" <?php if( $infos['type'] == 2 ):?>checked<?php endif;?>/> 数据列表
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group" <?php if( $infos['type'] == 0 || $infos['type'] == 1 ):?>style="display:none;"<?php endif;?> model-data="type">
                    <label class="col-sm-2 col-xs-4 control-label">数据模型</label>
                    <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                        <select name="infos[mid]" class="form-control">
                            <option value="0" >请选择模型</option>
                            <?php foreach( $m_lists as $k => $v ):?>
                            <option value="<?=$v['id']?>" <?php if( $infos['mid'] == $v['id'] ):?>selected<?php endif;?>><?=$v['name']?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 col-xs-4 control-label">碎片键值</label>
                    <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                        <input type="text" class="form-control" name="infos[name]" value="<?=$infos['name']?>" color="#000000">
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-sm-2 col-xs-4 control-label">碎片内容</label>
                    <div class="col-lg-7 col-sm-4 col-xs-4 input-group">
                        <div id="editor_content">
                            <?=$editor?>
                        </div>
                        <div id="textarea_content" style="display: none;">
                            <textarea name="new_content" class="form-control" cols="60" rows="20"><?=$infos['content']?></textarea>
                        </div>

                        <span class="help-block">如果类型为数据列表需要输入模板代码,代码块这里则是正常碎片数据</span>
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-sm-2 col-xs-4 control-label"></label>
                    <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                        <input type="hidden" name="id" value="<?=$infos['id']?>" />
                        <input class="btn btn-info col-sm-12 col-xs-12" type="submit" name="dosubmit" value="提交">
                    </div>
                </div>
            </form>
        </div>

        </form>
    </div>
    </div>
</section>
<script>

    editor( <?=$infos['type']?> );
    function editor( value ) {
        if( value == 2 ) {
            $("#editor_content").hide();
            $("#textarea_content").show();
        } else if ( value == 1 ){
            $("#editor_content").hide();
            $("#textarea_content").show();

        } else {
            $( "#editor_content" ).show();
            $( "#textarea_content" ).hide();
        }
    }
    jQuery(document).ready( function () {
        $('#destroy').bind( 'click', function ()  {
            var num = $(this).attr( 'num-data' );

            if( num == 1 ) {

                $(this).attr( 'num-data', 0);
            } else {

                $(this).attr( 'num-data', 1);
            }
            editor( num );

        } );
        $('[node-data=type]').bind( 'click', function () {
            var value = $(this).val();
            $('[model-data=type]').hide();
            if( value == 2 ) {
                $('[model-data=type]').show();
            }

            editor( value, 'content' )
        } );
    } );

</script>
<?php tpl_include( 'public/footer' )?>
