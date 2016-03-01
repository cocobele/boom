<?php
if( !defined('IN') ) die('bad request');
include_once( AROOT . 'controller'.DS.'app.class.php' );
include_once( AROOT . 'model'.DS.'user.function.php' );
class defaultController extends appController
{
	function __construct()
	{
		parent::__construct();
	}
	
	function index()
	{
        $data['list']=get_user();
        $data['title'] = $data['top_title'] = '首页';
		render( $data );
	}

	function register(){
        $user=v("user");
        insert_user($user);
        if(db_error()){
            return   ajax_echo(db_error());
        }
        $data=get_user();
          echo  $data;
    }

function record(){
    $str="";
    $arr=json_decode(v('list'));
    db();
    $date=date("Y-m-d");
    foreach( $arr as $user){
      $stat=run_sql("INSERT INTO `bill` ( `user`, `amount`, `type`, `date`) VALUES ('$user', '5', '1', '$date')");
    if($stat==1)$str.=$user."提交成功\n";
        else$str.=$user."提交失败\n";
    }
    ajax_echo( $str);
    }

function pay_site(){
    $amount=v("amount");
    $date=v("date");
    if($date==null)  $date=date("Y-m-d");
    $note=v("note");
    db();
    $sql="INSERT INTO `bill` ( `user`, `amount`, `type`, `date`,`note`) VALUES ('admin', '$amount', '2', '$date','$note')";
    $stat=run_sql($sql);
    if($stat==1) $str="提交成功\n";
    else $str="提交失败\n";
    ajax_echo( $str);
}

    function pay_badminton(){
        $amount=v("amount");
        $date=v("date");
        if($date==null)  $date=date("Y-m-d");
        $note=v("note");
        db();
        $sql="INSERT INTO `bill` ( `user`, `amount`, `type`, `date`,`note`) VALUES ('admin', '$amount', '3', '$date','$note')";
        $stat=run_sql($sql);
        if($stat==1) $str="提交成功\n";
        else $str="提交失败\n";
        ajax_echo( $str);
    }

    function offer(){
        $amount=v("amount");
        $date=v("date");
        if($date==null)  $date=date("Y-m-d");
        $note=v("note");
        db();
        $sql="INSERT INTO `bill` ( `user`, `amount`, `type`, `date`,`note`) VALUES ('admin', '$amount', '0', '$date','$note')";
        $stat=run_sql($sql);
        if($stat==1) $str="提交成功\n";
        else $str="提交失败\n";
        ajax_echo( $str);
    }




}//class  end
	