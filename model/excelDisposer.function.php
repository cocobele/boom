
<?php


/** PHPExcel_IOFactory */
include AROOT.'/lib/phpExcel/Classes/PHPExcel/IOFactory.php';
include AROOT.'/lib/phpExcel/Classes/PHPExcel.php';
include AROOT.'/lib/phpExcel/Classes/PHPExcel/Reader/Excel2007.php';
include AROOT.'/lib/phpExcel/Classes/PHPExcel/Reader/Excel5.php';
ini_set("memory_limit", -1);
set_time_limit(0);
function excel2array($filePath='',$sheet=0){
    if(empty($filePath) or !file_exists($filePath)){die('file not exists');}
    $PHPReader = new PHPExcel_Reader_Excel2007();        //建立reader对象
    if(!$PHPReader->canRead($filePath)){
        $PHPReader = new PHPExcel_Reader_Excel5();
        if(!$PHPReader->canRead($filePath)){
            echo 'no Excel';
            return ;
        }
    }
    $PHPExcel = $PHPReader->load($filePath);        //建立excel对象
    $currentSheet = $PHPExcel->getSheet($sheet);        //**读取excel文件中的指定工作表*/
    $allColumn = $currentSheet->getHighestColumn();        //**取得最大的列号*/
    $allRow = $currentSheet->getHighestRow();        //**取得一共有多少行*/
    $data = array();
    for($rowIndex=1;$rowIndex<=$allRow;$rowIndex++){        //循环读取每个单元格的内容。注意行从1开始，列从A开始
        for($colIndex='A';$colIndex!=$allColumn;$colIndex++){

            $addr = $colIndex.$rowIndex;
            $cell = $currentSheet->getCell($addr)->getFormattedValue();
            if($cell instanceof PHPExcel_RichText){ //富文本转换字符串
                $cell = $cell->__toString();
            }
            $data[$rowIndex][$colIndex] = $cell;
        }
    }
 //   echo memory_get_usage()/(1024*1024).'<br/>';
    return $data;
}


function getExcel($fileName,$headArr,$data){
    if(empty($data) || !is_array($data)){
        die("data must be a array");
    }
    if(empty($fileName)){
        exit;
    }
    $date = date("Y_m_d",time());
    $fileName .= "_{$date}.xlsx";

    //创建新的PHPExcel对象
    $objPHPExcel = new PHPExcel();
    $objProps = $objPHPExcel->getProperties();

    //设置表头
    $key = "A";
    foreach($headArr as $v){
        $objPHPExcel->setActiveSheetIndex(0) ->setCellValue($key.'1', $v);
        $key++;
    }

    $column = 2;
    $objActSheet = $objPHPExcel->getActiveSheet();
    foreach($data as $key => $rows){ //行写入
        $span = 'A';
        foreach($rows as $keyName=>$value){// 列写入
            $objActSheet->setCellValue($span.$column, $value);
            $span++;
        }
        $column++;
    }

    $fileName = iconv("utf-8", "gb2312", $fileName);
    //重命名表
    $objPHPExcel->getActiveSheet()->setTitle('Simple');
    //设置活动单指数到第一个表,所以Excel打开这是第一个表
    $objPHPExcel->setActiveSheetIndex(0);
    //将输出重定向到一个客户端web浏览器(Excel2007)
  /*  header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header("Content-Disposition: attachment; filename=\"$fileName\"");
    header('Cache-Control: max-age=0');*/
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save($fileName);exit;
    if(!empty($_GET['excel'])){
        $objWriter->save('php://output'); //文件通过浏览器下载
    }else{
        $objWriter->save($fileName); //脚本方式运行，保存在当前目录
    }
    exit;

}


?>