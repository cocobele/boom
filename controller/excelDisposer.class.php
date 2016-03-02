<?php
if( !defined('IN') ) die('bad request');
include_once( AROOT . 'controller'.DS.'app.class.php' );
include_once( AROOT . 'model'.DS.'excelDisposer.function.php' );
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
                if($one[$column]=$sieve){
                    array_push($result,$one);
                }
            }
            $fileName = "test_excel";
            $headArr = $data[1];
            getExcel($fileName,$headArr,$result);
        }
    }
}//class  end
