<?php
namespace Admin\Model;
use Think\Model;
class UploadModel extends Model{
	public static function plupload(){
		header('Content-type: text/plain; charset=UTF-8');
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");

        $tmp_dir = where_is_tmp();
        $targetDir =  $tmp_dir. DIRECTORY_SEPARATOR . "plupload";

        $cleanupTargetDir = false; //移除旧的临时文件
        $maxFileAge = 60 * 60; //临时文件超时时间

        // 5 分钟的执行时间
        @set_time_limit(5 * 60);

        $chunk = isset($_REQUEST["chunk"]) ? $_REQUEST["chunk"] : 0;
        $chunks = isset($_REQUEST["chunks"]) ? $_REQUEST["chunks"] : 0;
        $fileName = isset($_REQUEST["name"]) ? $_REQUEST["name"] : '';

        $fileName = preg_replace('/[^\w\._]+/', '', $fileName);

        if (!file_exists($targetDir))
            @mkdir($targetDir);

        if (is_dir($targetDir) && ($dir = opendir($targetDir))) {
            while (($file = readdir($dir)) !== false) {
                $filePath = $targetDir . DIRECTORY_SEPARATOR . $file;
                if (preg_match('/\\.tmp$/', $file) && (filemtime($filePath) < time() - $maxFileAge))
                    @unlink($filePath);
            }
            closedir($dir);
        } else
            die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');

        // 查看 header信息: content type
        if (isset($_SERVER["HTTP_CONTENT_TYPE"]))
            $contentType = $_SERVER["HTTP_CONTENT_TYPE"];

        if (isset($_SERVER["CONTENT_TYPE"]))
            $contentType = $_SERVER["CONTENT_TYPE"];

        if (strpos($contentType, "multipart") !== false) {
            if (isset($_FILES['file']['tmp_name']) && is_uploaded_file($_FILES['file']['tmp_name'])) {
                $out = fopen($targetDir . DIRECTORY_SEPARATOR . $fileName, $chunk == 0 ? "wb" : "ab");
                if ($out) {
                    $in = fopen($_FILES['file']['tmp_name'], "rb");

                    if ($in) {
                        while ($buff = fread($in, 4096))
                            fwrite($out, $buff);
                    } else
                        die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');

                    fclose($out);
                    unlink($_FILES['file']['tmp_name']);
                } else
                    die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
            } else
                die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
        } else {
            $out = fopen($targetDir . DIRECTORY_SEPARATOR . $fileName, $chunk == 0 ? "wb" : "ab");
            if ($out) {
                $in = fopen("php://input", "rb");

                if ($in) {
                    while ($buff = fread($in, 4096))
                        fwrite($out, $buff);
                } else
                    die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');

                fclose($out);
            } else
                die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
        }

        die('{"jsonrpc" : "2.0", "result" : null, "id" : "id"}');
	}
}