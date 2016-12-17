<?php tpl_include( 'public/header' )?>

<section class="wrapper">
    <div class="panel mr0">

        <form name="myform" method="post" action="">
            <div class="panel-body" id="panel-bodys">
                <table class="table table-striped table-advance table-hover">
                    <thead>
                    <tr>
                        <th class="tablehead" style="padding-left:20px;"> 文件名</th>
                        <th class="tablehead" style="padding-left:20px;"> 操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach( $files_arr as $k => $v ):?>
                    <tr>
                        <td><?=$v?></td>
                        <td style="width:10%">
                            <a target="_blank" href="<?=make_url( __M__, __C__, 'view', [ 'id='.$infos['id'], 'page_url='.urlencode( $v ) ] )?>" class="btn btn-primary btn-xs">可视化编辑</a>
                        </td>
                    </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </form>
    </div>
</section>
<script src="<?=$domain.$js?>bootstrap.min.js"></script>
<script src="<?=$domain.$js?>jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?=$domain.$js?>pxgrids-scripts.js"></script>
</body>
</html>