<?php
include '../src/conj.php';
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
//       
    }

    $grade=$_GET['grade'];
    $weekNum=$_GET['weekNum'];
    $signBase64=$_POST['signBase64'];
    $sql = "INSERT INTO `weekend_approve`(`grade`, `weekNum`, `aSign`) VALUES ('$grade','$weekNum','$signBase64')";
 
if (mysqli_query($conn, $sql)) {
    echo "<script>alert('已审批成功');window.location.replace(document.referrer);</script>";
    //header("Location: ./adminEachWeekGoHome.php?grade=".$grade."&weekNum=".$weekNum);
} else {
    echo "<script>alert('错误，请重试');window.history.go(-1);</script>";
}
 
mysqli_close($conn);


?>
