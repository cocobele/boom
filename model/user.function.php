
<?php
function get_user(){
    db();
    $sql="SELECT * FROM user";
    $list=get_data( $sql);
    $str= "";
    if($list):foreach($list as $v):
        $str.='<p class="drag ui-draggable"><a class="btn btn-default">'.$v["user"].'</a></p>';
         endforeach;endif;
    return $str;
}
function delete_user($user){
    db();
    $sql=prepare("delete from table where user=?s",array($user));
    return run_sql( $sql);
}

function insert_user($user){
    db();
     $sql = prepare( "INSERT INTO `user` (user) VALUES (?s) " , array( $user) );
    return  run_sql($sql);
}
?>