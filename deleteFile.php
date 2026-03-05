<?php 
include './src/conj.php';
$userIdsStu=$_COOKIE["userIdsStu"] ?? "";
$userIdsAuth=$_COOKIE["userIdsAuth"] ?? "";
$fID=$_GET["fID"] ?? "";




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
	echo "<script>alert('抱歉，该提交项目的链接已关闭，无法删除文件。');window.close();window.history.go(-1);;</script>";
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






$sql = 'SELECT * FROM `namelist` WHERE `number` = '.$userIdsStu;

$retval = mysqli_query( $conn, $sql );
if(mysqli_num_rows($retval) == 0){
echo "<script>alert('抱歉，该飞书账号暂未与学号关联。若为刚刚注册的班级飞书账号，则请稍后再试；若为其他情况，请联系处理。');window.history.go(-1);;</script>";
//print();
            exit;
}
    //$passwordCode=md5($password);
    while($row2 = mysqli_fetch_array($retval))
    {

      $name1=$row2["number"]."+".$row2["name"];

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













$aaText="“".$mainName."”的文件已删除，请重新提交。如有疑问请联系。";
//$templ='{"text":"文件“'.$mainName."+".$name1.'.'.$suffix.'”已删除，请重新提交。如有疑问请联系。"}';
$templ='{"text":"'.$aaText.'"}';
//echo $templ;
//exit;
$key2="GKBGh$%bsjfy^kkyu%G&&Kuyc";
$rand=rand(10000,9999999);
$userID=$userIdsStu;
//echo "原始1".$rand."userID=".$userID."&msg=".$templ."&msg_type=text&kId=".md5($userID.$templ.$rand.$key2);
//echo "后来2";

//$abc=httpRequestPost("https://host/lark/platformSend/platformSendMsgToPerson.php?rand=".$rand,"Content-Type: application/x-www-form-urlencoded; charset=utf-8","userID=".$userID."&msg=".$templ."&msg_type=text&kId=".md5($userID.$templ.$rand.$key2));
//echo $abc;




if(md5($userIdsStu."kk9944ll##@&hh")==$userIdsAuth){
if(file_exists("./admin/fileUpload/".$fID."/".$mainName."+".$name1.'.'.$suffix)){
    if(unlink("./admin/fileUpload/".$fID."/".$mainName."+".$name1.'.'.$suffix)){
		httpRequestPost("https://host/lark/platformSend/platformSendMsgToPerson.php?rand=".$rand,"Content-Type: application/x-www-form-urlencoded; charset=utf-8","userID=".$userID."&msg=".$templ."&msg_type=text&kId=".md5($userID.$templ.$rand.$key2));
        echo "<script>alert('删除成功，请重新提交');window.close();window.history.go(-1);</script>";
    }else{
        echo "<script>alert('删除失败，请联系处理');window.close();window.history.go(-1);</script>";
    }
}else{
echo "<script>alert('无可删除的文件，请先提交。如需修改时再依次删除、提交。');window.close();window.history.go(-1);</script>";
}
}else{
    echo "<script>alert('鉴权失败，请重试。');window.history.go(-1);</script>";
}





























?>