<?php
include './src/conj.php';
//登录合法验证
//if(!(isset($_COOKIE['userName']) && isset($_COOKIE['auth']) && isset($_COOKIE['rand']))){
   // header("Location: ./");
//}
if(isset($_GET["fID"])){
$fID=$_GET["fID"];
$name1=$_POST['studentName'];
$proName=$_GET["proName"];
}else{
echo "<script>alert('链接不完整!\n上传失败！\n请重试。');window.history.go(-1);;</script>";
exit;
}

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
    $sql = 'SELECT * FROM `file_send` WHERE `ID` = '.$fID;
    $mainName="";
    $retval = mysqli_query( $conn, $sql );
if(mysqli_num_rows($retval) == 0){
echo "<script>alert('链接无效');window.history.go(-1);;</script>";
//print();
            exit;
}
    //$passwordCode=md5($password);
    while($row = mysqli_fetch_array($retval))
    {
        if(!(empty($row["deadline"]))){
			$dateTime = new DateTime($row["deadline"]);
			$now = new DateTime('now');
		}
	if($row["isStop"] || (!empty($row["deadline"]) && $now>$dateTime)){
	echo "<script>alert('已停止上传文件');window.history.go(-1);;</script>";
	//print();
            	exit;
                }else{
 $mainName=$row["mainName"];
 if($row["suffix"]==""){
 	$suffix="docx";
 }else{
 	$suffix=$row["suffix"];
 }
 
 
}
      

    }







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
//echo "9261";
if ($response === FALSE) {
    $error = error_get_last();
    echo "Error: " . $error['message'];
} else {
    $responseData = json_decode($response, true);
    print_r($response);
	//echo "9260";
	//开始请求登录信息
    return $responseData;

}
}













$allowedExts = array($suffix);
$temp = explode(".", $_FILES["file"]["name"]);
$extension = strtolower(end($temp));        // 获取文件后缀名
if (in_array($extension, $allowedExts))
{
    if ($_FILES["file"]["error"] > 0)
    {
        echo "错误：: " . $_FILES["file"]["error"] . "<br>";
    }
    else
    {
        // echo "上传文件名: " . $_FILES["file"]["name"] . "<br>";
        // echo "文件类型: " . $_FILES["file"]["type"] . "<br>";
        // echo "文件大小: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
        // echo "文件临时存储的位置: " . $_FILES["file"]["tmp_name"];
        $dir = "./admin/fileUpload/".$fID."/";
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
		if (($_FILES["file"]["size"] / 1024 /1024)>5){
			unlink($_FILES["file"]["tmp_name"]);
            echo "<script>alert('上传的文件大小超过5MB，请尝试压缩文件后再试。');window.history.go(-1);</script>";
			exit;
		}
        /*if(file_exists($dir.$proName."+".$name1.'.'.$extension)){
			unlink($_FILES["file"]["tmp_name"]);
            echo "<script>alert('提交失败！为防止误操作，请先删除已提交的文件后再提交新文件。');window.history.go(-1);</script>";
        }else{*/
			//ignore_user_abort(true); // 即使用户断开连接也继续执行
            move_uploaded_file($_FILES["file"]["tmp_name"], $dir.$proName."+".$name1.'.'.$extension);
			$aaText="“".$mainName."”的文件已成功提交。若需修改，请直接上传修改后的文件，自动覆盖旧文件。若非本人操作，则可能是其他同学错误选择了姓名及学号。如有疑问请联系。";

$templ='{"text":"'.$aaText.'"}';

$key2="GKBGh$%bsjfy^kkyu%G&&Kuyc";
$rand=rand(10000,9999999);
$userID=explode("+", $name1)[0];
//echo $userID;
header("Location: ./success.html");

header('Connection: close');
			//httpRequestPost("https://host/lark/platformSend/platformSendMsgToPerson.php?rand=".$rand,"Content-Type: application/x-www-form-urlencoded; charset=utf-8","userID=".$userID."&msg=".$templ."&msg_type=text&kId=".md5($userID.$templ.$rand.$key2));
            
        //}
        

    }
}
else
{
    echo "<script>alert('上传失败！文件格式错误！仅允许上传.".$suffix."格式的文件！请按照要求的文件格式上传文件！');window.history.go(-1);</script>";
}


?>