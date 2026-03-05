<?php

include '../../src/conj.php';

//登录合法验证
if(!(isset($_COOKIE['userName']) && isset($_COOKIE['auth']) && isset($_COOKIE['rand']))){
    header("Location: ./");
	
}
$userName = $_COOKIE['userName'];
$auth = $_COOKIE['auth'];
$random=$_COOKIE['rand'];
//连接mySQL
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
    if(! $conn )
    {
        mysqli_close($conn);
        //header("Location: ".$hostURL."err2.html");
        print("连接失败，请重试！");
        exit;
    }
    //echo '数据库连接成功！';
    $sql = 'SELECT * FROM `admin_user` WHERE `userName` = '.$userName;

    $retval = mysqli_query( $conn, $sql );
    //$passwordCode=md5($password);
if(mysqli_num_rows($retval) == 0){
header("Location: ./");
//print();
            exit;
}
    while($row = mysqli_fetch_array($retval))
    {
         if(($row["UserName"] != $userName) || $auth != md5($key.$random.$userName.$row["Password"])){
	//print(mysqli_num_rows($row));
	header("Location: ./");
            exit;
        }else{
	
            $nameUser=$row["Name"];
        }
//        if(($row["UserName"] == $userName) && ($row["Password"] == $password)){
//            
//            echo "yes";
//            
//                $random=rand(1000000, 999999999999);
//                $cook=md5($key.$random.$userName.$password);
//                //$cook=$key."-".$random."-".$id."-".md5($passwordCode);
//                //echo "yes";
//            
//    //        echo $key.$random.$id.$passwordCode;
//            setcookie("userName",$userName,time()+3600);
//            setcookie("auth",$cook,time()+3600);
//               header("Location: ./admin.php");
//                
//            
//        }else{
//        //print($userName);
//        //print($password);
//            echo "<script>alert('密码错误');window.history.go(-1);</script>";
//        }
    }

?>
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










$proName=$_POST['proName'] ?? "";
$diedline=$_POST['diedline'] ?? "";
$url=$_POST['url'] ?? "";
$fID=$_GET['fID'] ?? "";

// $chatId=$_POST['chatId'] ?? "";

$templ='
{
    "type": "template",
    "data":{
        "template_id":"AAqdrtsOmBilG",
        
        "template_variable":{
            "proName":"'.$proName.'",    
            
            "diedline":"'.$diedline.'",
            "adminName":"'.$nameUser.'",
            "url":{
                "url": "'.$url.'"
            },
			"url2":{
                "url": "https://host/delTo.php?fID='.$fID.'"
            }
            
        }       
    }
}


';
//echo $templ;
//exit;
$rand=rand(10000,9999999);
//qun1
$chatId='oc_36c992345353d586c17a4a4c3cf6f';//测试群：oc_9f91
$a=httpRequestPost("https://host/lark/platformSend/platformSendMsgToGroup.php?rand=".$rand,"Content-Type: application/x-www-form-urlencoded; charset=utf-8","chatId=".$chatId."&msg=".$templ."&msg_type=interactive&kId=".md5($chatId.$templ.$rand.$key));
echo $a;
//qun2
$chatId='oc_9f91';
$templ='{"text":"“'.$proName.'”已在群发布，请及时提交。"}';
//$a=httpRequestPost("https://host/lark/platformSend/platformSendMsgToGroup.php?rand=".$rand,"Content-Type: application/x-www-form-urlencoded; charset=utf-8","chatId=".$chatId."&msg=".$templ."&msg_type=text&kId=".md5($chatId.$templ.$rand.$key));

?>