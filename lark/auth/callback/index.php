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


$url = 'https://open.feishu.cn/open-apis/authen/v2/oauth/token';

$data = [
    'grant_type' => 'authorization_code',
    'client_id' => 'client_id',
    'client_secret' => 'client_secret',
    'code' => $code,
	'redirect_uri' => 'https://host/lark/auth/callback'
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

    $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);


if(! $conn )
{
    mysqli_close($conn);
    //header("Location: ".$hostURL."err2.html");
    
    exit;
}
// echo $responseData1['data']['user_id'];
$sql = "SELECT * FROM `admin_user` WHERE `userName` = '".$responseData1['data']['user_id']."'";

$retval = mysqli_query( $conn, $sql );
//$passwordCode=md5($password);
if (mysqli_num_rows($retval) > 0) {
while($row = mysqli_fetch_array($retval))
{
    // echo $row["UserName"];
    if(($row["UserName"] == $responseData1['data']['user_id'])){
        
        //echo "yes";
        
            $random=rand(1000000, 999999999999);
            $cook=md5($key.$random.$row["UserName"].$row["Password"]);
            //$cook=$key."-".$random."-".$id."-".md5($passwordCode);
            //echo "yes";
        
//        echo $key.$random.$id.$passwordCode;
        setcookie("userName",$row["UserName"],time()+3600,'/namelist/admin');
        setcookie("auth",$cook,time()+3600,'/namelist/admin');
        setcookie("rand",$random,time()+3600,'/namelist/admin');
        // echo 'ok';
        // echo $row["UserName"].$row["Password"];
           header("Location: https://host/admin/admin.php");
           //echo '<a herf="https://host/admin/admin.php">aa</a>';
        // echo $_COOKIE['userName'];
        // echo $_COOKIE['auth'];
        // echo $_COOKIE['rand'];
            
        
    }else{
	//print($userName);
	//print($password);
        echo "<script>alert('验证失败');window.history.go(-1);</script>";
    }
}
}else{
echo "<script>alert('抱歉，当前你没有登录管理页面的权限。若有需要，请联系申请。');window.history.go(-1);</script>";
}


	
//以上	
	
	
}
	
//以上	
	
	
}



//






}else{
echo 'error';
}
//echo $_COOKIE['userName'];
?>
