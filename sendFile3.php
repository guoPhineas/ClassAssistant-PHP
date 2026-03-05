<?php
include './src/conj.php';
//登录合法验证
//if(!(isset($_COOKIE['userName']) && isset($_COOKIE['auth']) && isset($_COOKIE['rand']))){
   // header("Location: ./");
//}
if(isset($_GET["fID"])){
$fID=$_GET["fID"];
}else{
echo "<script>alert('链接错误!');window.history.go(-1);;</script>";
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
echo "<script>alert('链接无效');window.close();window.history.go(-1);;</script>";
//print();
            exit;
}
    //$passwordCode=md5($password);
    while($row = mysqli_fetch_array($retval))
    {
		$SubNote=$row['detail'];
    	$deadlineDate=$row['deadline'];
		if(!(empty($row["deadline"]))){
			$dateTime = new DateTime($row["deadline"]);
			$now = new DateTime('now');
		}else{
            $deadlineDate="手动停止提交";
        }
	if($row["isStop"] || (!empty($row["deadline"]) && $now>$dateTime)){
	// echo "<script>alert('抱歉，链接已关闭。已停止上传文件。');</script>";
	//print();
            	//exit;
                }
 $mainName=$row["mainName"];
 if($row["suffix"]==""){
 $suffix="docx";
 }else{
 $suffix=$row["suffix"];
 }
 $isStop=$row["isStop"];

      

    }

?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>提交文件 - 班级名单及应用平台</title>
    <link href="./font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./styles.css">
    <script src="https://staticHost/jquery-3.7.1.min.js"></script>
</head>
<body>
    <!-- 作业提交页面 -->
    <div id="homework-submit-page" class="homework-page">
        <!-- 顶部导航 -->
        <header>
            <div class="container">
                <div class="header-content">
                    <div class="logo">
                        <!-- <button id="back-btn" class="back-button">
                            <i class="fa fa-arrow-left"></i>
                        </button> -->
                        <i class="fa fa-graduation-cap"></i>
                        <span class="logo-text">班级名单及应用平台</span>
                    </div>
                    <!-- <div class="user-info">
                        <span class="user-name">你好，xxx</span>
                        <div class="user-avatar">
                            <i class="fa fa-user"></i>
                        </div>
                    </div> -->
                </div>
            </div>
        </header>
        
        <!-- 主内容区 -->
        <main>
            <div class="container">
                <div class="page-title">
                    <h2>提交文件</h2>
                    <p>提交规定格式的文件或作业</p>
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
                                <p class="info-value"><?php echo $mainName;?></p>
                            </div>
                            <div class="info-item">
                                <h4 class="info-label">允许上传的格式</h4>
                                <p class="info-value"><span id="suff1"><?php echo $suffix;?></span></p>
                            </div>
                            <div class="info-item">
                                <h4 class="info-label">任务状态</h4>
                                <p class="info-value"><span><?php echo $isStop ? "<span class='deadline'>❌ 提交已终止</span>" : "✅ 可以提交";?></span></p>
                            </div>
                            <div class="info-item">
                                <h4 class="info-label">截止时间</h4>
                                <p class="info-value deadline"><?php echo $deadlineDate;?></p>
                            </div>
                            <div class="info-item">
                                <h4 class="info-label">提交要求（备注）</h4>
                                <p class="info-value" style="font-size: 0.875rem;"><?php 
                                    if(!empty($SubNote)){
                                        echo "$SubNote";
                                    }else{
                                        echo "无";
                                    }
                                    ?></p>
                            </div>
							
							<div class="card-actions">
                                
                                
                                <!-- <button id="showNameNotSub" class="btn btn-sm btn-primary btn-hover">显示未提交名单</button> -->
                        
                            </div>
                            
                               
                            
                        </div>
                    </div>
                    
                    <!-- 提交表单 -->
                    <div class="form-card card-shadow">
                        <div class="card-header">
                            <h3 class="form-title">提交文件</h3>
                            <div class="card-actions">
                            <button id="select-all" class="btn btn-sm btn-primary btn-hover" style="background-color:red;" onClick="deleteF()">
                                <i class="fa fa-trash"></i>&nbsp&nbsp删除已提交的文件
                            </button>
                        </div>
                        </div>
                        <div class="form-content">
                            <form id="homework-form" action="./fileUpdate.php?fID=<?php echo $fID;?>&proName=<?php echo $mainName;?>" enctype="multipart/form-data" method="post">
                                <div class="form-group">
                                    <label for="student-select" class="form-label">学号姓名</label>
                                    <select id="student-select" class="form-select" name="studentName" required>
                                        <option value="">请选择学号姓名</option>
                                        <?php 
                                            if($isStop==false){$sql = "SELECT * FROM  `namelist`";
                                            $retval = mysqli_query( $conn, $sql );
                                        // if(mysqli_num_rows($retval) == 0){
                                        // echo "<script>alert('链接无效');window.history.go(-1);;</script>";
                                        //print();// exit;//$passwordCode=md5($password);
                                            while($row = mysqli_fetch_array($retval)){
                                                echo "<option value='".$row['number']."+".$row['name']."'>".$row['name']."（".$row['number']."）"."</option>";
                                            }}
                                        ?>
                                        
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label for="file-upload" class="form-label">上传作业文件</label>
                                    <input id="file-upload" name="file" type="file" class="sr-only" required>
                                    <label for="file-upload" class="upload-link">
                                        <div class="file-upload">
                                            <div class="upload-content">
                                                <div class="upload-icon">
                                                    <i class="fa fa-cloud-upload" id="iconView"></i>
                                                </div>
                                                <div class="upload-text">
                                                    
                                                    <span id="fileViewTitle">点击选择文件或将文件拖放到此区域</span>
                                                </div>
                                                <p class="upload-hint" id="fileViewSubTitle">仅允许上传<span id="suff">---</span>格式的文件</p>
                                            </div>
                                        </div>
                                    </label><br/>
                                    <span style='font-size:15px;'>如需修改文件，请直接上传新文件即可，自动覆盖，无需登录删除。请务必确认姓名学号正确。</span><br/>
                                </div>
								
                                
                                <!-- <div class="form-group">
                                    <label for="submit-notes" class="form-label">提交备注</label>
                                    <textarea id="submit-notes" class="form-textarea" placeholder="请输入备注信息（可选）"></textarea>
                                </div> -->
								<a href='https://host/privacy_statement/'><button type="button" class="btn btn-sm btn-primary btn-hover" style='/*background-color:red;color:white;*/'>查看《关于本平台信息处理的说明》</button></a>
                                <br/><br/>
                                <div class="form-actions">
                                    <button type="button" id="cancel-btn" class="btn btn-sm btn-outline btn-hover" style="display:none;">
                                        重置
                                    </button>
                                    <button type="submit" id="submit-btn" class="btn btn-sm btn-primary btn-hover">
                                        <i class="fa fa-paper-plane"></i>&nbsp&nbsp提交
                                    </button>
									
									
                                </div>
                            </form>
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
                    班级名单及应用平台 © 2024-Now 版权所有
                </div>
            </div>
        </footer>
    </div>

    <script src="homework-submit.js"></script>
</body>
<script>
function deleteF(){
if(confirm("确定要删除你提交过的此次作业的文件吗？删除后不可恢复。\n\n注意：将在验证你所登录的班级飞书账号后删除与此账号关联的此次作业。")){
//window.location.href='https://open.feishu.cn/open-apis/authen/v1/index?client_id=client_id&redirect_uri=https%3a%2f%2fhost%2fnamelist%2flark%2fsendFile%2fcallback&scope=contact:user.employee:readonly contact:user.employee_id:readonly&state=<?php echo $fID;?>'
window.location.href='./delTo.php?fID=<?php echo $fID;?>'
}
}


var iconView=document.getElementById('iconView')
// iconView.className='fa fa-file-text'
var fileViewTitle=document.getElementById('fileViewTitle')
var fileViewSubTitle=document.getElementById('fileViewSubTitle')
var fileUploadArea1 = document.querySelector('.file-upload');
var studentSelect1 = document.getElementById('student-select');
var submitBtn1 = document.getElementById('submit-btn');
var fileInput1 = document.getElementById('file-upload');
var file_upload = document.getElementById('file-upload');
var select_all = document.getElementById('select-all');
var uploadLink1 = document.querySelector('.upload-link');

select_all.parentNode.style.display='none'
var isStop=<?php echo $isStop ? 'true' : 'false'?>

if (isStop){
    fileViewTitle.innerHTML='无法上传'
    fileViewSubTitle.innerHTML='已停止上传文件'
    fileUploadArea1.disabled=true
    studentSelect1.disabled=true
    submitBtn1.style.display='none'
    file_upload.disabled=true
    iconView.className='fa fa-close'
    select_all.parentNode.style.display='none'
    select_all.onclick=function(){
        alert("当前提交已终止，不可通过此方式删除文件")
    }
    submitBtn1.parentNode.innerHTML+="<span class='deadline'>提交已终止，不再接受新文件</span>"

    
    // fileUploadArea1.addEventListener('dragover', function(e) {
    //     return;
    // });
    
    // fileUploadArea.addEventListener('dragleave', function() {
    //     return;
    // });
    
    // fileUploadArea1.addEventListener('drop', function(e) {
    //     return;
    // });

    // fileInput1.addEventListener('change', function(e) {
    //     return;
    // });
    // uploadLink1.addEventListener('click', function(e) {
    //     e.preventDefault();
    //     fileInput.click();
    // });

}
/*
if(confirm("这是有关于本平台信息收集及处理方式的详细说明。现向大家说明，并接受监督。\n\n是否查看全文？\n《关于本平台对于信息处理和其他问题的说明》")){
window.location.href='https://host/privacy_statement/';
}
*/
//alert("关于本平台信息收集及处理方式的详细说明已公布并接受监督，大家可在本页面上点击按钮查看。");
</script>
</html>
    