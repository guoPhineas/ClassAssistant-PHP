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

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>全部应用 - 班级名单及应用平台</title>
    <link href="../font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <!-- 总管理页面 -->
    <div id="management-page" class="management-page">
        <!-- 顶部导航 -->
        <header>
            <div class="container">
                <div class="header-content">
                    <div class="logo">
                        <i class="fa fa-graduation-cap"></i>
                        <span class="logo-text">班级名单及应用平台</span>
                    </div>
                    <div class="user-info">
                        <span class="user-name">你好，<?php print($nameUser); ?></span>
                        <div class="user-avatar">
                            <i class="fa fa-user"></i>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        
        <!-- 主内容区 -->
        <main>
            <div class="container">
                <div class="page-title">
                    <h2>全部应用</h2>
                    <!-- <p>请选择需要操作的功能模块</p> -->
                </div>
                
                <div class="module-grid">
                    <!-- 班级花名册卡片 -->
                    <a href="./name_list.php" class="aTag">
                        <div class="module-card card-shadow card-hover" id="class-roster-card">
                            <div class="module-icon">
                                <i class="fa fa-users"></i>
                            </div>
                            <h3 class="module-title">点名册</h3>
                            <p class="module-desc">班级名单及进行现场点名
                                <!-- <br/><span style="color:red;">该功能不保存点名信息，请不要刷新</span> -->
                            </p>
                        </div>
                    </a>
                    
                    <!-- 管理信息详情卡片 -->
                     <a href="./adminGoHome.php" class="aTag">
                        <div class="module-card card-shadow card-hover" id="info-detail-card">
                            <div class="module-icon">
                                <i class="fa fa-list-alt"></i>
                            </div>
                            <h3 class="module-title">周末请假信息管理</h3>
                            <p class="module-desc">查看周末请假信息及下载请假单</p>
                        </div>
                    </a>
                    
                    
                    <!-- 作业提交卡片 -->
                     <a href="./adminFileUpload.php"  class="aTag">
                        <div class="module-card card-shadow card-hover" id="homework-submit-card">
                            <div class="module-icon">
                                <i class="fa fa-file-text-o"></i>
                            </div>
                            <h3 class="module-title">文件提交管理</h3>
                            <p class="module-desc">管理作业提交任务及打包下载已提交作业</p>
                        </div>
                    </a>
                </div>
            </div>
        </main>
        
        <!-- 页脚 -->
        <footer>
            <div class="container">
                <div class="footer-content">
                    班级名单及应用平台 © 2025 版权所有
                </div>
            </div>
        </footer>
    </div>

    <script src="management.js"></script>
</body>
</html>
    

