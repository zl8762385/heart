<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8;"/>

    <title>Plupload - jQuery UI Widget</title>

    <link rel="stylesheet" href="<?=$domain.$js?>jquery-ui/jquery-ui.css" type="text/css" />
    <link rel="stylesheet" href="<?=$domain.$js?>html5upload/jquery.plupload.queue/css/jquery.plupload.queue.css" type="text/css" />

    <script src="<?=$domain.$js?>jquery.min.js"></script>
    <script type="text/javascript" src="<?=$domain.$js?>jquery-ui/jquery-ui.min.js"></script>

    <!-- production -->
    <script type="text/javascript" src="<?=$domain.$js?>html5upload/plupload.full.min.js"></script>
    <script type="text/javascript" src="<?=$domain.$js?>html5upload/i18n/zh_cn.js"></script>
    <script type="text/javascript" src="<?=$domain.$js?>html5upload/extension.js"></script>

    <script type="text/javascript" src="<?=$domain.$js?>html5upload/jquery.plupload.queue/jquery.plupload.queue.min.js"></script>
</head>
<body>

<form id="form" method="post" action="../dump.php">
    <div id="uploader">
        <p>Your browser doesn't have Flash, Silverlight or HTML5 support.</p>
    </div>

</form>

<script type="text/javascript">
    jQuery(document).ready( function () {

        var uploadfiles = '';
        $("#uploader").pluploadQueue({
            // General settings
            runtimes : 'html5,flash,silverlight,html4',
            url : '<?=make_url( 'admin', 'attachment' , 'h5upload')?>',
            max_file_size : '10mb',
            chunk_size : '1mb',
            unique_names : true,

            // Resize images on clientside if we can
            resize : {crop: false},

            // Specify what files to browse for
            filters : [
                {title : "Image files", extensions : "<?=$extimg?>"},
                {title : "Zip files", extensions : "<?=$extzip?>"},
                {title : "Word files", extensions : "<?=$extword?>"},
                {title : "pdf", extensions : "<?=$extpdf?>"},
                {title : "other", extensions : "<?=$extother?>"}
            ],
            init: {
                FileUploaded: function(up, file, info) {

                    var myres = $.parseJSON( info.response );

                    if(myres['error']) {
                        alert(myres['error']['message']);
                        return ;
                    }
                    if(myres['result']) {
                        if(<?=$limit?> > 1) {
                            uploadfiles += myres['result']+','+myres['path']+','+myres['id']+'|';
                        } else {
                            uploadfiles += myres['result']+'|'+myres['path'];
                        }
                    }
                },
                UploadComplete: function( up, files ) {
//                    if(uploadfiles!='') {
//                        uploadfiles = uploadfiles.substring(0, uploadfiles.lastIndexOf('|'));
//                    }

                    <?=$callback?>(uploadfiles,'<?=$htmlid?>',<?=$is_thumb?>,'<?=$htmlname?>');
                    //console.info(file);
                },
                FilesAdded: function (uploader, file) {
                    var _limit = '<?=$limit?>';
                    if( uploader.files.length > _limit ) {
                        if(uploader.files.length>_limit){ // 最多上传3张图
                            uploader.splice(_limit,999);
                        }
                        alert('文件数量错误。每次只接受同时上传 '+ _limit +' 个文件，多余的文件将会被删除。')

                        uploader.start();
                    }
                }
            },

            // Flash settings
            flash_swf_url : '<?=$domain.$js?>html5upload/Moxie.swf',

            // Silverlight settings
            silverlight_xap_url : '<?=$domain.$js?>html5upload/Moxie.xap'
        });

        // Client side form validation
        $('form').submit(function(e) {
            var uploader = $('#uploader').pluploadQueue();

            // Validate number of uploaded files
            if (uploader.total.uploaded == 0) {
                // Files in queue upload them first
                if (uploader.files.length > 0) {
                    // When all files are uploaded submit form
                    uploader.bind('UploadProgress', function() {
                        if (uploader.total.uploaded == uploader.files.length)
                            $('form').submit();
                    });

                    uploader.start();
                } else
                    alert('You must at least upload one file.');

                e.preventDefault();
            }
        });
    } );

    var dialog = '';
    $(function () {
        try {
            dialog = top.dialog.get(window);
        } catch (e) {
            $('body').append(
                '<p><strong>Error:</strong> 跨域无法无法操作 iframe 对象</p>'
                +'<p>chrome 浏览器本地会认为跨域，请使用 http 方式访问当前页面</p>'
            );
            return;
        }

        dialog.title('上传附件');
        //dialog.width(550);
        //dialog.height($(document).height());
        dialog.reset();
    })

</script>
</body>
</html>
