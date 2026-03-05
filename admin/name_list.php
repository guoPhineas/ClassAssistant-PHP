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

if(mysqli_num_rows($retval) == 0){
header("Location: ./");
//print();
            exit;
}

    //$passwordCode=md5($password);
    while($row = mysqli_fetch_array($retval))
    {
        if(($row["UserName"] != $userName) || $auth != md5($key.$random.$userName.$row["Password"])){
	
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
    <title>点名册 - 班级名单及应用平台</title>
    <link href="../font-awesome.min.css" rel="stylesheet">
    <script src="https://staticHost/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <!-- 班级花名册页面 -->
    <div id="class-roster-page" class="class-roster-page">
        <!-- 顶部导航 -->
        <header>
            <div class="container">
                <div class="header-content">
                    <div class="logo">
                        <button id="back-btn" class="back-button">
                            <i class="fa fa-arrow-left"></i>
                        </button>
                        <i class="fa fa-graduation-cap"></i>
                        <span class="logo-text">班级名单及应用平台</span>
                    </div>
                    <div class="user-info">
                        <span class="user-name">你好，<?php echo $nameUser;?></span>
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
                    <h2>点名册</h2>
                    <p>点击姓名可进行点名标记。不保存，勿刷新</p>
                </div>
                
                <div class="roster-card card-shadow">
                    <div class="card-header">
                        <div class="card-title">全体名单</div>
                        <div class="card-actions">
                            <button id="select-all" class="btn btn-sm btn-primary btn-hover">
                                <i class="fa fa-check-square-o"></i>全部到达
                            </button>
                            <button id="reset-all" class="btn btn-sm btn-outline btn-hover">
                                <i class="fa fa-refresh"></i>全部重置
                            </button>
                            <button id="show-result" class="btn btn-sm btn-success btn-hover">
                                <!-- <i class="fa fa-save"></i> -->
                                显示未到名单
                            </button>
                        </div>
                    </div>
                    
                    <div class="roster-grid">
                        
                        <?php
$sql = 'SELECT * FROM `namelist`';

    $retval = mysqli_query( $conn, $sql );
   
    while($row = mysqli_fetch_array($retval))
    {
	//print();
	//print( "<label><input type='checkbox' name='".$row["number"]." ".$row["name"]."' class='nameCheck'>".$row["name"]."</label><br>");
    echo '
    <div class="student-item" data-id="'.$row["number"].'">
        <input type="checkbox" class="student-check nameCheck" name="'.$row["number"]." ".$row["name"].'">
        <span class="student-name">'.$row["name"].'</span>
        <span class="student-status status-default">未到</span>
    </div>
    ';

}

            
               
            ?>
                        
                        
                    </div>
                    
                    <div class="roster-summary">
                        <div class="summary-item">
                            <span class="summary-indicator success"></span>
                            <span class="summary-text">已到: <span id="present-count">-</span>人</span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-indicator default"></span>
                            <span class="summary-text">未到: <span id="absent-count">-</span>人</span>
                        </div>
                        <div class="summary-item" style="display:none;">
                            <span class="summary-indicator warning"></span>
                            <span class="summary-text">请假: <span id="leave-count">-</span>人</span>
                        </div>
                        <div class="summary-total">
                            总人数: <span id="total-count">-</span>人
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        
        <!-- 页脚 -->
        <footer>
            <div class="container">
                <div class="footer-content">
                    班级名单及应用平台 © 2025 版权所有
                </div>
            </div>
        </footer>
    </div>

    <script src="class-roster.js"></script>
</body>
</html>
    

<script>
$('#showNot').click(function(){



})


</script>