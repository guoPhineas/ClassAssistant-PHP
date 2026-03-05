<?php
include '../../src/conj.php';
//登录合法验证
if(!(isset($_COOKIE['userName']) && isset($_COOKIE['auth']) && isset($_COOKIE['rand']))){
    header("Location: ./");
}
$userName = $_COOKIE['userName'];
$auth = $_COOKIE['auth'];
$random=$_COOKIE['rand'];
$fID=$_GET['fID'];
$fileName=$_GET['file'];
$fileName=rawurldecode($fileName);
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
header("Location: ../");
//print();
            exit;
}
    while($row = mysqli_fetch_array($retval))
    {
         if(($row["UserName"] != $userName) || $auth != md5($key.$random.$userName.$row["Password"])){
	//print(mysqli_num_rows($row));
	header("Location: ../");
            exit;
        }else{
	
            $nameUser=$row["Name"];
        }
//       
    }

    if(!(isset($fID) && isset($fileName))){
        echo "<script>alert('请重试。');window.history.go(-1);;</script>";
        exit;
    }

    $destinationZip="../fileUpload/".$fID."/".$fileName;
    if(file_exists($destinationZip) && ($fID != "" && $fileName != "")){
        $base64Image = base64_encode(file_get_contents($destinationZip));
        
    }else{
        echo "<script>alert('请重试。');window.history.go(-1);;</script>";
        exit;
    }
    
   












?>


<!DOCTYPE html>
<html>
<head>
    <!-- <link rel="stylesheet" href="./style-1.css"/> -->
    <!-- <script src="./main.js"></script> -->
    <meta charset="utf-8">
    <title><?php echo $fileName;?> - 在线查看</title>
    <style>
        #main{
            outline: none;
            -webkit-tap-highlight-color: rgba(0,0,0,0);
            display: inline-block;
            /* width: 50%; */
            /* padding-bottom: 100%; */
            /* padding-top: 0px; */
            display:none;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }
        #show{
            display: inline-block;
            /*width: 49%;*/
            height: 100%;
            word-wrap: break-word;
            overflow-wrap: break-word;
            outline: none;
            -webkit-tap-highlight-color: rgba(0,0,0,0);
        }
        #con{
            display: flex;
			padding-top: 70px;
        }
		#bar{
			background-color: rgb(79, 158, 254);
display: block;
margin: -10px;
padding: 15px;
margin-bottom: 20px;
font-size: 30px;
/* padding: 19px; */
/*position: fixed;*/
width: 100vw;
height: 42px;
		}
    </style>
</head>
<body>
	<div id="bar"><?php echo $fileName;?></div>
    <img style="width: 100vw; /* height: 100vh; */" src="data:image/png;base64,<?php echo $base64Image;?>">
    <br/>
</body>
</html>