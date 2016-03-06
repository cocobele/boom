<?php
if( !defined('IN') ) die('bad request');
include_once( AROOT . 'controller'.DS.'app.class.php' );
include_once( AROOT . 'model'.DS.'excelDisposer.function.php' );
include_once( AROOT . 'model'.DS.'filter.function.php' );
class excelDisposerController extends appController
{
    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        $data['title'] =$data['top_title'] = 'excel处刑人';
        render( $data );
    }

    function getFile(){
            $column=$_POST['column'];
            $sieve=$_POST['sieve'];
        if(is_uploaded_file($_FILES['upfile']['tmp_name'])){
            $upfile=$_FILES["upfile"];
            $name=$upfile["name"];//上传文件的文件名
            $type=$upfile["type"];//上传文件的类型
            $size=$upfile["size"];//上传文件的大小
            $tmp_name=$upfile["tmp_name"];//上传文件的临时存放路径
            $data=excel2array($tmp_name);
            $result=array();
         foreach($data as $one){
                if($one[$column]==$sieve){
                    array_push($result,$one);
                }
            }
            $fileName = "test_excel";
            $headArr = $data[1];
            $fileUrl=getExcel($fileName,$headArr,$result);
            $data=array();
            $data['status']=1;
            $data['url']='index.php?c=excelDisposer&a=export&file='.$fileUrl;
            echo json_encode($data,true);
        }
    }

    function export(){
        $file = v('file');
        $filename = basename($file);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        //处理中文文件名
        $ua = $_SERVER["HTTP_USER_AGENT"];
        $encoded_filename = rawurlencode($filename);
        if (preg_match("/MSIE/", $ua)) {
            header('Content-Disposition: attachment; filename="' . $encoded_filename . '"');
        } else if (preg_match("/Firefox/", $ua)) {
            header("Content-Disposition: attachment; filename*=\"utf8''" . $filename . '"');
        } else {
            header('Content-Disposition: attachment; filename="' . $filename . '"');
        }
        readfile($file);
    }

   function xsendfile(){
    $file = v('file');
       echo $file;exit;
    $filename = basename($file);
       header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    //处理中文文件名
    $ua = $_SERVER["HTTP_USER_AGENT"];
    $encoded_filename = rawurlencode($filename);
    if (preg_match("/MSIE/", $ua)) {
        header('Content-Disposition: attachment; filename="' . $encoded_filename . '"');
    } else if (preg_match("/Firefox/", $ua)) {
        header("Content-Disposition: attachment; filename*=\"utf8''" . $filename . '"');
    } else {
        header('Content-Disposition: attachment; filename="' . $filename . '"');
    }
    //让Xsendfile发送文件
       if(stristr($_SERVER['SERVER_SOFTWARE'],'nginx')){
           header('X-Accel-Redirect: '.$file);
       }
    //apache让Xsendfile发送文件
       if(stristr($_SERVER['SERVER_SOFTWARE'],'apache')){
           header("X-Sendfile: $file");
       }
   }

}//class  end
