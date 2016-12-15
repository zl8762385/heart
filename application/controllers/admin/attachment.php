<?php
/*
 * 附件相关
 *
 * @copyright			(C) 2016 Heart
 * @author              maoxiaoqi <15501100090@163.com> <qq:3677989>
 *
 * 您可以自由使用该源码，但是在使用过程中，请保留作者信息。尊重他人劳动成果就是尊重自己
 */
namespace controllers\admin;

use services\admin_base;

class attachment extends admin_base{

    public function __construct() {
        parent::__construct();

    }

    public function h5upload() {
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");

        // Settings
        $root_path = "resource/upload/";
        $dir_path = date("Ymd").'/';

        $targetDir = ROOT_PATH . $root_path .$dir_path;
        $fileurl = load_config( 'domain' ) . $root_path . $dir_path;

        $cleanupTargetDir = true; // Remove old files
        $maxFileAge = 5 * 3600; // Temp file age in seconds

        // 5 minutes execution time
        @set_time_limit(5 * 60);

        // Uncomment this one to fake upload time
        // usleep(5000);

        // Get parameters
        $chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
        $chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;
        $fileName = isset($_REQUEST["name"]) ? $_REQUEST["name"] : '';

        // Clean the fileName for security reasons
        $fileName = preg_replace('/[^\w\._]+/', '_', $fileName);

        // Make sure the fileName is unique but only if chunking is disabled
        if ($chunks < 2 && file_exists($targetDir . DIRECTORY_SEPARATOR . $fileName)) {
            $ext = strrpos($fileName, '.');
            $fileName_a = substr($fileName, 0, $ext);
            $fileName_b = substr($fileName, $ext);

            $count = 1;
            while (file_exists($targetDir . DIRECTORY_SEPARATOR . $fileName_a . '_' . $count . $fileName_b))
                $count++;

            $fileName = $fileName_a . '_' . $count . $fileName_b;
        }

        $filePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;

        // Create target dir
        if (!file_exists($targetDir)) mkdir($targetDir, 0755, true);

        // Remove old temp files
        if ($cleanupTargetDir) {
            if (is_dir($targetDir) && ($dir = opendir($targetDir))) {
                while (($file = readdir($dir)) !== false) {
                    $tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;

                    // Remove temp file if it is older than the max age and is not the current file
                    if (preg_match('/\.part$/', $file) && (filemtime($tmpfilePath) < time() - $maxFileAge) && ($tmpfilePath != "{$filePath}.part")) {
                        @unlink($tmpfilePath);
                    }
                }
                closedir($dir);
            } else {
                die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
            }
        }

        // Look for the content type header
        if (isset($_SERVER["HTTP_CONTENT_TYPE"])) $contentType = $_SERVER["HTTP_CONTENT_TYPE"];

        if (isset($_SERVER["CONTENT_TYPE"])) $contentType = $_SERVER["CONTENT_TYPE"];

        // Handle non multipart uploads older WebKit versions didn't support multipart in HTML5
        if (strpos($contentType, "multipart") !== false) {
            if (isset($_FILES['file']['tmp_name']) && is_uploaded_file($_FILES['file']['tmp_name'])) {
                // Open temp file
                $out = @fopen("{$filePath}.part", $chunk == 0 ? "wb" : "ab");

                if ($out) {
                    // Read binary input stream and append it to temp file
                    $in = fopen($_FILES['file']['tmp_name'], "rb");

                    if ($in) {
                        while ($buff = fread($in, 4096)) {
                            fwrite($out, $buff);
                        }
                    } else {
                        die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
                    }

                    @fclose($in);
                    @fclose($out);
                    @unlink($_FILES['file']['tmp_name']);
                } else
                    die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
            } else
                die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
        } else {
            // Open temp file
            $out = @fopen("{$filePath}.part", $chunk == 0 ? "wb" : "ab");
            if ($out) {
                // Read binary input stream and append it to temp file
                $in = @fopen("php://input", "rb");

                if ($in) {
                    while ($buff = fread($in, 4096)) {
                        fwrite($out, $buff);
                    }

                } else {
                    die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
                }

                @fclose($in);
                @fclose($out);
            } else
                die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
        }

        // Check if file has been uploaded
        if (!$chunks || $chunk == $chunks - 1) {
            // Strip the temp .part suffix off
            rename("{$filePath}.part", $filePath);
        }

        die('{"jsonrpc" : "2.0", "result" : "'.$fileurl . $fileName.'", "path": "'.$dir_path.$fileName.'", "id" : "'.md5($fileName).'"}');
    }

    public function upload_dialog() {
        upload_url_safe();
        $callback = gpc('callback') ? gpc('callback') : 'callback_thumb_dialog';
        $htmlid = gpc('htmlid') ? gpc('htmlid') : 'file';
        $limit = gpc('limit') ? gpc('limit') : '0';
        $is_thumb = gpc( 'is_thumb' ) ? intval( gpc( 'is_thumb' ) ) : '0';
        $htmlname = gpc( 'htmlname' ) ? gpc( 'htmlname' ) : '';
        $ext = gpc( 'ext' );

        $_KEY = load_config( 'public_key' );
        $token = gpc( 'token' );
        if($ext=='' || md5($ext.$_KEY)!=$token) $this->show_message( '参数错误.' );

        $maxsize = ini_get('upload_max_filesize');
        $extimg = array('gif','bmp','jpg','jpeg','png');
        $extzip = array('zip','7z','rar','gz','tar');
        $extpdf = 'pdf';
        $extword = array('doc','docx','xls','xlsx','ppt','pptx');
        $exts = explode('|',$ext);

        $extother = array_diff($exts,$extimg,$extword,$extzip);
        $extother = ($extother) ? implode(',',$extother) : '' ;

        $extimg = array_intersect($extimg,$exts);
        $extimg = ($extimg) ? implode(',',$extimg) : '' ;

        $extzip = array_intersect($extzip,$exts);
        $extzip = ($extzip) ? implode(',',$extzip) : '' ;

        $extword = array_intersect($extword,$exts);
        $extword = ($extword) ? implode(',',$extword) : '' ;

        if(!in_array($extpdf,$exts)) $extpdf = '';

        $this->view->assign( 'limit', $limit );
        $this->view->assign( 'width', 800);
        $this->view->assign( 'height', 500);
        $this->view->assign( 'ext', $ext);
        $this->view->assign( 'maxsite', $maxsize);
        $this->view->assign( 'extimg', $extimg);
        $this->view->assign( 'extzip', $extzip);
        $this->view->assign( 'extword', $extword);
        $this->view->assign( 'extpdf', $extpdf);
        $this->view->assign( 'extother', $extother);
        $this->view->assign( 'htmlid', $htmlid);
        $this->view->assign( 'is_thumb', $is_thumb);
        $this->view->assign( 'htmlname', $htmlname);
        $this->view->assign( 'callback', $callback);
        $this->view->assign( 'maxsize', $maxsize);
        $this->view->display( 'public/upload_dialog' );
//        include T('attachment','upload_dialog');
    }


}