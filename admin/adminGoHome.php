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

?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>周末请假信息管理 - 班级名单及应用平台</title>
    <link href="../font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <!-- 管理信息详情页面 -->
    <div id="info-detail-page" class="info-detail-page">
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
                    <h2>周末请假信息管理</h2>
                    <p>查看周末请假信息及下载请假单</p>
                </div>
                
                <div class="data-card card-shadow">
                    <div class="card-header">
                        <div class="card-title">所有教学周</div>
                        <div class="card-actions">
                            <div style="display:none;">
                                <div class="search-box">
                                    <i class="fa fa-search"></i>
                                    <input type="text" placeholder="搜索学生...">
                                </div>
                                <button class="btn btn-sm btn-outline btn-filter">
                                    <i class="fa fa-filter"></i>筛选
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <!-- <th>学期</th> -->
                                    <th>教学周</th>
                                    <th style="width: 20%;">操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                $sql = "SELECT DISTINCT `weekend_grade`.* FROM (`weekend_home` JOIN `weekend_grade` ON `weekend_grade`.`grade` = `weekend_home`.`grade`) ORDER BY `weekend_grade`.`grade` DESC";
                $retval = mysqli_query( $conn, $sql );
                while($row = mysqli_fetch_array($retval)){
                    echo "<tr>";
                    echo "<td colspan='2' style='text-align: center;'>".$row["gradeName"]."</td>";
                    echo "</tr>";
                    $sql2 = "SELECT DISTINCT `weekNum` FROM `weekend_home` WHERE `grade`='".$row['grade']."' ORDER BY `weekNum` DESC";
                    $retval2 = mysqli_query( $conn, $sql2 );
                    while($row2 = mysqli_fetch_array($retval2)){
                        echo "<tr>";
                        echo "<td>第".$row2["weekNum"]."周</td>";
                        echo '<td>
                        <a href="./adminEachWeekGoHome.php?grade='.$row["grade"].'&weekNum='.$row2["weekNum"].'">
                        <button class="btn btn-sm btn-primary btn-hover">
                            查看
                        </button>
                        </a>
                        
                        </td>';
                        echo "</tr>";
                    }
                }
                ?>
                                <!-- <tr>
                                    <td rowspan="2">2024-2025学年度第二学期</td>
                                    <td>第16周</td>
                                    <td>
                                        <button id="see" class="btn btn-sm btn-primary btn-hover">
                                            查看
                                        </button>
                        </td>
                                    
                                </tr>
                                <tr>
                                    
                                    <td>第16周</td>
                                    <td>
                                        <button id="see" class="btn btn-sm btn-primary btn-hover">
                                            查看
                                        </button>
                        </td>
                                    
                                </tr> -->
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="pagination">
                        <div class="pagination-info">
                            <!-- 显示 x 到 x，共 x 条记录 -->
                             已加载全部信息
                        </div>
                        <!-- <div class="pagination-controls">
                            <button class="page-btn prev-btn" disabled>
                                <i class="fa fa-chevron-left"></i>
                            </button>
                            <button class="page-btn active">1</button>
                            <button class="page-btn">2</button>
                            <button class="page-btn">3</button>
                            <button class="page-btn next-btn">
                                <i class="fa fa-chevron-right"></i>
                            </button>
                        </div> -->
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

    <script src="info-detail.js"></script>
</body>
</html>
    