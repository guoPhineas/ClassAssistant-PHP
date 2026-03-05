<?php


function httpRequestPost($url,$header,$data){
    //$url = 'https://open.feishu.cn/open-apis/authen/v2/oauth/token';

// $data = [
//     'grant_type' => 'authorization_code',
//     'client_id' => 'client_id',
//     'client_secret' => 'client_secret',
//     'code' => $code,
// 	'redirect_uri' => 'https://host/lark/auth/callback'
// ];

$options = [
    'http' => [
        'header' => $header,
                    
        'method' => 'POST',
        'content' => $data,
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
    $responseData = json_decode($response, true);
    // print_r($responseData1);
	//echo $responseData1['access_token'];
	//开始请求登录信息
    return $responseData;

}
}

$key="GKBGh$%bsjfy^kkyu%G&&Kuyc";











$msggg=$_GET['msgg'] ?? "";

// $chatId=$_POST['chatId'] ?? "";

$templ='
"{"text":"'.$msggg.'"}"


';
//echo $templ;
//exit;
$rand=rand(10000,9999999);
//qun1
$userID=$_GET["userID"];
$kId=$_GET["kId"];//.md5($userID.$templ.$rand.$key)
$a=httpRequestPost("https://host/lark/platformSend/platformSendMsgToPerson.php?rand=".$rand,"Content-Type: application/x-www-form-urlencoded; charset=utf-8","userID=".$userID."&msg=".$templ."&msg_type=text&kId=".$kId);
//echo $a;
//qun2
//$chatId='oc_9f91';
//$a=httpRequestPost("https://host/lark/platformSend/platformSendMsgToGroup.php?rand=".$rand,"Content-Type: application/x-www-form-urlencoded; charset=utf-8","chatId=".$chatId."&msg=".$templ."&msg_type=interactive&kId=".md5($chatId.$templ.$rand.$key));

?>