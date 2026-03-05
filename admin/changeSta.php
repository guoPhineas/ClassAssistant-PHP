<?php
include '../src/conj.php';
//登录合法验证
if(!(isset($_COOKIE['userName']) && isset($_COOKIE['auth']) && isset($_COOKIE['rand']))){
    header("Location: ./");
}
$userName = $_COOKIE['userName'];
$auth = $_COOKIE['auth'];
$random=$_COOKIE['rand'];
$fID=$_GET['fID'];
$newChang=$_GET['newChang'];
//连接mySQL
$adminName="";
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
            $adminName=$row["ID"];
            $nameUser=$row["Name"];
        }
//
    }

    $sql = "UPDATE file_send SET isStop='$newChang' WHERE ID='$fID'";
     
    if ($conn->query($sql) === TRUE) {
        header("Location: ./adminFileUpload.php");
    } else {
        echo "<script>alert('更改失败！请重试。');window.history.go(-1);</script>";
        //echo "Error: " . $sql . "<br>" . $conn->error;
    }


?>
