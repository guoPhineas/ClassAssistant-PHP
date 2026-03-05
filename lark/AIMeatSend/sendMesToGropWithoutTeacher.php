<?php
require '../support.php';
if(isset($_POST['msg'])&&isset($_POST['kId'])&&isset($_GET['rand'])){
    if(md5($_POST['msg'].$_GET['rand'].$key) == $_POST['kId']){
        
        $msg=$_POST['msg'];
        
        $token=httpRequestPost("https://www.feishu.cn/flow/api/trigger-webhook/2c77cf12f50842f376de2b7c79aa2cc1","Content-Type: application/json; charset=utf-8",[
    
        'msg' => $msg,
        'destination' => 'groupWithoutTeacher'
        
    ]);

    }
}


?>