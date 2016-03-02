<?php

function prefecture_level_city($population,$innocent,$incineration,$waste_output_average){
    $result=array();
    $disposal_rate=1;
    $remain_incineration_scale=($population*$waste_output_average*$disposal_rate*$innocent)-$incineration;
    if($population<50){
        return false;
    }
    if($remain_incineration_scale<500){
        return false;
    }
    return true;
}

?>