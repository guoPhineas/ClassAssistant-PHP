<?php
require '../support.php';
if(isset($_POST['chatId'])&&isset($_POST['msg'])&&isset($_POST['kId'])&&isset($_POST['msg_type'])&&isset($_GET['rand'])){
    if(md5($_POST['chatId'].$_POST['msg'].$_GET['rand'].$key) == $_POST['kId']){
        $chatID=$_POST['chatId'];
        $msg=$_POST['msg'];
        $msg_type=$_POST['msg_type'];
        $token=httpRequestPost("https://open.feishu.cn/open-apis/auth/v3/tenant_access_token/internal","Content-Type: application/json; charset=utf-8",[
    
        'app_id' => 'client_id',
        'app_secret' => 'client_secret'
    
    ])['tenant_access_token'];

    httpRequestPost('https://open.feishu.cn/open-apis/im/v1/messages?receive_id_type=chat_id',"Content-Type: application/json; charset=utf-8\r\nAuthorization: Bearer ".$token,[

        'receive_id' => $chatID,
        'msg_type' => $msg_type,
        'content' => $msg
    ]);




    }else{
	echo '11234';
	}
}else{
	echo '55922';
	}


?>