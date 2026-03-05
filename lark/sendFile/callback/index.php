<?php
include '../../../src/conj.php';
//作废登录
// setcookie("rand","",time()-3600);
// setcookie("auth","",time()-3600);

//setcookie("userName","",time()-3600);
?>
<?php
if(isset($_GET['code'])){
$code=$_GET['code'];
//echo $code;
$state=$_GET['state'] ?? "";

$url = 'https://open.feishu.cn/open-apis/authen/v2/oauth/token';

$data = [
    'grant_type' => 'authorization_code',
    'client_id' => 'client_id',
    'client_secret' => 'client_secret',
    'code' => $code,
	'redirect_uri' => 'https://host/lark/sendFile/callback'
];

$options = [
    'http' => [
        'header' => "Content-Type: application/json\r\n",
                    
        'method' => 'POST',
        'content' => json_encode($data),
        'ignore_errors' => true // 允许获取错误响应
    ],
    'ssl' => [
        'verify_peer' => true,
        'verify_peer_name' => true
    ]
];

$context = stream_context_create($options);
$response = file_get_contents($url, false, $context);

if ($response === FALSE) {
    $error = error_get_last();
    echo "Error: " . $error['message'];
} else {
    $responseData1 = json_decode($response, true);
    // print_r($responseData1);
	//echo $responseData1['access_token'];
	//开始请求登录信息
	$url = 'https://open.feishu.cn/open-apis/authen/v1/user_info';

// $data = [
//     'grant_type' => 'authorization_code',
//     'client_id' => 'client_id',
//     'client_secret' => 'client_secret',
//     'code' => $code,
// 	'redirect_uri' => 'https://host/lark/auth/callback'
// ];
$accessToken=$responseData1['access_token'];
$options = [
    'http' => [
        'header' => "Content-Type: application/json\r\n".'Authorization: Bearer ' . $accessToken,
                    
        'method' => 'GET',
        //'content' => json_encode($data),
        'ignore_errors' => true // 允许获取错误响应
    ],
    'ssl' => [
        'verify_peer' => true,
        'verify_peer_name' => true
    ]
];

$context = stream_context_create($options);
$response = file_get_contents($url, false, $context);

if ($response === FALSE) {
    $error = error_get_last();
    echo "Error: " . $error['message'];
} else {
    $responseData1 = json_decode($response, true);
    // print_r($responseData1);
	//echo $responseData1['access_token'];
	//登录

    setcookie("userIdsStu",$responseData1['data']['user_id'],time()+20,'/namelist');
    setcookie("userIdsAuth",md5($responseData1['data']['user_id']."kk9944ll##@&hh"),time()+20,'/namelist');
    header("Location: https://host/deleteFile.php?fID=".$state);
	
  
}
	
//以上	
	
	
}



//






}else{
echo 'error';
}
//echo $_COOKIE['userName'];
?>
