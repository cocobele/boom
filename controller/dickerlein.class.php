<?php
if( !defined('IN') ) die('bad request');
include_once( AROOT . 'controller'.DS.'app.class.php' );
include_once( AROOT . 'model'.DS.'excelDisposer.function.php' );
include_once( AROOT . 'model'.DS.'filter.function.php' );
class dickerleinController extends appController
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
            $data=excel2array($tmp_name,1);
            $result=array();
          /*  foreach($data as $one){
                if($one[$column]=$sieve){
                    array_push($result,$one);
                }
            }*/
            foreach($data as $one){
                if($this->prepare_data($one)){
                    array_push($result,$one);
                    echo $one['B'].'<br/>';
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

    function prepare_data($arr){
        $city=$arr['B'];
        $population=$arr['F'];
        $innocent=$arr['R'];
        $incineration=$arr['AK'];;
        $waste_output_average=1.03;
        return $this->prefecture_level_city($city,$population,$innocent,$incineration,$waste_output_average);
    }

    function prefecture_level_city($city,$population,$innocent,$incineration,$waste_output_average){
        $result=array();
        $disposal_rate=1;
        $remain_incineration_scale=($population*$waste_output_average*$disposal_rate*$innocent)-$incineration;
        echo '城市：'.$city.'人口：'.$population.'  现存焚烧规模：'.$incineration.'  无害化处理：'.$innocent."  剩余：".$remain_incineration_scale.'<br/>';
        if($population<50){
            return false;
        }
        if($remain_incineration_scale<500){
            return false;
        }
        return true;
    }


}//class  end
