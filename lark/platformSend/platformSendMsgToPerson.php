<?php
require '../support.php';
/*echo md5($_POST['userID'].$_POST['msg'].$_GET['rand'].$key);
	echo "\n";
	echo $_POST['kId'];
	exit;
	*/
if(isset($_POST['userID'])&&isset($_POST['msg'])&&isset($_POST['kId'])&&isset($_POST['msg_type'])&&isset($_GET['rand'])){
    if(md5($_POST['userID'].$_POST['msg'].$_GET['rand'].$key) == $_POST['kId']){
        $userID=$_POST['userID'];
        $msg=$_POST['msg'];
        $msg_type=$_POST['msg_type'];
        $token=httpRequestPost("https://open.feishu.cn/open-apis/auth/v3/tenant_access_token/internal","Content-Type: application/json; charset=utf-8",[
    
        'app_id' => 'client_id',
        'app_secret' => 'client_secret'
    
    ])['tenant_access_token'];

    httpRequestPost('https://open.feishu.cn/open-apis/im/v1/messages?receive_id_type=user_id',"Content-Type: application/json; charset=utf-8\r\nAuthorization: Bearer ".$token,[

        'receive_id' => $userID,
        'msg_type' => $msg_type,
        'content' => $msg
    ]);




    }else{
	//echo "xx";
	}
}else{
//echo "1x";
}
//echo "2x3";

?>