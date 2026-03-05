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
//echo $fID;
//exit;
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


    $dir = "./fileUpload/".$fID."/";
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
?>





<!DOCTYPE html>
<html lang="zh-CN"><head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理文件提交项目 - 班级名单及应用平台</title>
    <link href="../font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../styles.css">

    <script src="https://staticHost/jquery-3.7.1.min.js"></script>
    <script>
        function copyURL(URL){
            navigator.clipboard.writeText(URL);
            alert("已复制");
}

    </script>
</head>
<body>
    <!-- 作业提交页面 -->
    <div id="homework-submit-page" class="homework-page">
        <!-- 顶部导航 -->
        <header>
            <div class="container">
                <div class="header-content">
                    <div class="logo">
                        <a href="./adminFileUpload.php">
                        <button id="back-btn" class="back-button">
                            <i class="fa fa-arrow-left"></i>
                        </button>
                        </a>
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
                    <h2>管理文件提交项目</h2>
                    <p>查看与管理文件提交项目详情</p>
                </div>
                
                <div class="homework-grid">
                    <!-- 作业信息卡片 -->
                    <div class="info-card card-shadow">
                        <div class="info-header">
                            <h3 class="info-title">提交项目详情</h3>
                        </div>
                        <div class="info-content">
                            <div class="info-item">
                                <h4 class="info-label">提交项目名称</h4>
                                <p class="info-value">

                                    <?php
                                    //echo $fID;

                                    $sql = "SELECT * FROM `file_send` WHERE `ID`=".$fID;
                                    $retval = mysqli_query( $conn, $sql );
                                    //$allNames=[];
                                    while($row = mysqli_fetch_array($retval)){
                                        $mainName=$row['mainName'];
                                        $suffix=$row["suffix"];
                                        $SubNote=$row['detail'];
                                        $deadlineDate=$row['deadline'];
                                        $isStop=$row['isStop'] ? "<span>❌ 不可提交</span>" : "<span>✅ 可以提交</span>";
                                        if(!(empty($row["deadline"]))){
                                            $dateTime = new DateTime($row["deadline"]);
                                            $now = new DateTime('now');
                                        }
                                        if((!empty($row["deadline"]) && $now>$dateTime)){
                                            $isStop="<span>❌ 不可提交</span>";
                                        }
                                        echo $row['mainName'];
                                    }
                                    ?>
                                    <?php 
                                $allNames="";
								$sql = "SELECT * FROM  `namelist`";
                                $retval = mysqli_query( $conn, $sql );
                            // if(mysqli_num_rows($retval) == 0){
                            // echo "<script>alert('链接无效');window.history.go(-1);;</script>";
                            //print();// exit;//$passwordCode=md5($password);
                                while($row = mysqli_fetch_array($retval)){
                                    //echo "<option value='".$row['number']."+".$row['name']."'>".$row['name']."（".$row['number']."）"."</option>";
									//$allNames=$allNames.$mainName."+".$row['number']."+".$row['name'].".".$suffix.",";
									$allNames=$allNames.$mainName."+".$row['number']."+".$row['name'].".".$suffix.",";
                                }
								//echo "<script>var names='".$allNames."'</script>";
                                ?>

                                </p>
                            </div>
                            <div class="info-item">
                                <h4 class="info-label">允许上传的格式</h4>
                                <p class="info-value"><?php echo $suffix;?></p>
                            </div>
                            <div class="info-item">
                                <h4 class="info-label">任务状态</h4>
                                <p class="info-value"><?php echo $isStop;?></p>
                            </div>
                            <div class="info-item">
                                <h4 class="info-label">截止时间</h4>
                                <p class="info-value deadline">
                                    <?php 
                                    if(!empty($deadlineDate)){
                                        echo $deadlineDate;
                                    }else{
                                        $deadlineDate='手动停止提交';
                                        echo $deadlineDate;
                                    }
                                    ?>
                                </p>
                            </div>
                            <div class="info-item">
                                <h4 class="info-label">提交要求（备注）</h4>
                                <p class="info-value" style="font-size: 0.875rem;">
                                    <?php 
                                    if(!empty($SubNote)){
                                        echo $SubNote;
                                    }else{
                                        echo "无";
                                    }
                                    ?>
                                </p>
                            </div>
                            <div class="info-item">
                                <h4 class="info-label">提交情况</h4>
                                <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                                    <span style="font-size: 0.875rem;">已提交: <span id="hasSubNum">--</span>人</span>
                                    <span style="font-size: 0.875rem;">未提交: <span id="noSubNum">--</span>人</span>
                                </div>
                                <div class="progress-container">
                                    <div class="progress-bar" style="width: 50%" id="hasSubPer"></div>
                                </div>
                                </div>
                                <div class="card-actions">
                                <button class="btn btn-sm btn-primary btn-hover" onClick="copyURL('https://host/sendFile.php?fID=<?php echo $fID;?>')">复制上传链接</button>
                                <button class="btn btn-sm btn-primary btn-hover" onClick="sendToLarkGroup()">飞书群发</button>
                                <!-- <button id="showNameNotSub" class="btn btn-sm btn-primary btn-hover">显示未提交名单</button> -->
                        
                            </div>
                            
                        </div>
                    </div>
                    
                    <!-- 提交表单 -->
                    <div class="form-card card-shadow">
                        <div class="card-header">
                            <h3 class="form-title">已提交的文件</h3>
                            <div class="card-actions">
                                <!-- <button class="btn btn-sm btn-primary btn-hover" onClick="copyURL('https://host/sendFile.php?fID=<?php echo $fID;?>')">复制上传链接</button>
                                <button class="btn btn-sm btn-primary btn-hover" onClick="sendToLarkGroup()">飞书通知</button> -->
                                <button id='showNameNotSub' class="btn btn-sm btn-primary btn-hover">显示未提交名单</button><br/><br/>

                            <?php 
                            $yesName="";
                            $totalFiles=0;
                            $sql = 'SELECT * FROM `file_send` WHERE `ID`='.$fID;
                            $retval = mysqli_query( $conn, $sql );

                            $dir = "./fileUpload/".$fID."/";
                            $files = scandir($dir);
                            $files = array_diff($files, array('.', '..'));
                            $totalFiles=count($files);
                                if($totalFiles > 0){
                                    echo "<a id='exportFiles' href='./filesZipDownlod.php?fID=";
                                    echo $fID;
                                    echo "&proName=";
                                    echo $mainName;
                                    echo "'>
                                        <button class='btn btn-sm btn-success btn-hover'>
                                    导出压缩文件
                                    </button>
                                    </a>";
                                }
                            ?>
                            
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
                        <div class="form-content">
                            <div class="table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <!-- <th>学期</th> -->
                                    <th>文件名</th>
                                    <th>修改日期</th>
                                    <th style="">操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
				
                echo "<tr>";
                    echo "<th style='display:none;' colspan='3' style='text-align:center;'>";
                    echo "已提交总数量：<span id='hasNum'>".count($files)."</span>";
                    
                    echo "&nbsp;";
					//echo "<button id='showNameNotSub'>显示未提交名单</button></th>";

                    echo "</th></tr>";
                    // echo "<tr><th>文件名</th><th>修改日期</th><th>操作</th></tr>";
                foreach ($files as $file) {
                    echo "<tr>";
                    echo "<td>";
                    echo $file;
                    echo "</td>";

                    echo "<td>";
                    echo date("Y-m-d H:i:s",filemtime($dir.$file));
                    echo "</td>";

                    echo "<td class='card-actions'>";
                    //echo "<a href='./previewFile.php?fID=&file='>下载该文件</a>";
                    $temS=explode(".", $file);
                    if(end($temS) == "md"){
                        echo "<a href='./MarkdownViewer/index.php?fID=".$fID."&file=".urlencode($file)."' target='_blank'><button class='btn btn-sm btn-primary btn-hover'>
                            在线预览
                        </button></a>";
                    }else if(in_array(end($temS),["png","jpg","jpeg","bmp"])){
						echo "<a href='./imageViewer/index.php?fID=".$fID."&file=".urlencode($file)."' target='_blank'><button class='btn btn-sm btn-primary btn-hover'>
                            在线预览
                        </button></a>";
					}
                    
                    echo "<a href='./downloadFile.php?fID=".$fID."&file=".urlencode($file)."'>
                        <button class='btn btn-sm btn-primary btn-hover'>
                            下载该文件
                        </button></a>";
                    // echo "/";
                    echo "</td>";

                    echo "</tr>";
					$yesName=$yesName.$file.",";
					
					//$key = array_search($file, $allNames);
					//if ($key != false) {
  					//  unset($allNames[$key]);
					//}
					
					//if(!(in_array($file,$allNames))){
						//$notName=$notName.$file."";
					//}
                }
                // while($row = mysqli_fetch_array($retval)){
                    
                //     $StuAndIDs=explode("\n",$row['hasSendStudentIDs']);
                //     foreach ($StuAndIDs as $eachLine) {
                //         $eachItems=explode(",",$eachLine);
                //         echo "<tr>";
                //         foreach ($eachItems as $eachItem) {
                            
                //             echo "<td>";
                //             echo $eachItem;
                //             echo "</td>";
                            
                //         }
                //         echo "<td>具体操作</td>";
                //         echo "</tr>";
                //     }

                    
                //     // echo "<td>";
                //     // echo "";
                //     // echo "</td>";
                    
                // }
                ?>
                        
                                                      
                            </tbody>
                        </table>
                    </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <br>
        <br>
        <br>
        <br>
        <br>
        <!-- 页脚 -->
        <footer>
            <div class="container">
                <div class="footer-content">
                    班级名单及应用平台 © 2025 版权所有
                </div>
            </div>
        </footer>
    </div>
<?php 

echo "<script>var notName='".$allNames."'</script>";
echo "<script>var yesName='".$yesName."'</script>";

?>
<script>
function sendToLarkGroup() {
if(confirm("将发送到飞书群，是否继续？")){
 var xhr = new XMLHttpRequest();
  xhr.open("POST", './lark/sendSendPro.php?fID=<?php echo $fID?>', true);
  xhr.withCredentials = true;
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      console.log(xhr.responseText);
    }
  };
  xhr.send("proName=<?php echo $mainName; ?>&diedline=<?php echo $deadlineDate; ?>&url=https://host/sendFile.php?fID=<?php echo $fID;?>");
alert("已提交发送任务，请等待完成。")
}
 }
 </script>

    <script src="homework-submit-admin.js"></script>


    </body></html>