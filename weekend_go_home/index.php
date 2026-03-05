<?php
include '../src/conj.php';
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
if(! $conn )
    {
        mysqli_close($conn);
        //header("Location: ".$hostURL."err2.html");
        print("连接失败，请重试！");
        exit;
    }
    $today=date('Y-m-d');
$sql = "SELECT * FROM `weekend_grade` WHERE '$today' BETWEEN `startDate` AND `endDate`";
$result = mysqli_query($conn, $sql);
 
if (mysqli_num_rows($result) > 0) {
    // 输出数据
    while($row = mysqli_fetch_assoc($result)) {
        //echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
        $gradeNum=$row["grade"];
        $gradeName=$row["gradeName"];
        $startDate=$row["startDate"];
        $endDate=$row["endDate"];
    }
} else {
    echo "<script>alert('抱歉，当前日期不在可请假的学期内。');window.close();window.history.go(-1);</script>";
    exit;
}

$stDate = new DateTime($startDate);
$toDate = new DateTime($today);
$interval = date_diff($stDate, $toDate);
$weekNum=zhengchu($interval->format('%a'),7)+1;

$dayOfWeek = date('N');

//临时时间限制
/*
$currentTime = time();
if ($currentTime >= strtotime('00:00') && $dayOfWeek>=3) {
        echo "<script>alert('假期请假条已停止填写。如需补填或其他问题请联系辅导员');window.history.go(-1);</script>";
        exit;
}
*/
//临时时间限制结束
//$dayOfWeek = 5;
// echo $dayOfWeek;

if($dayOfWeek==5){
    $currentTime = time();

    if ($currentTime >= strtotime('17:00')) {
        echo "<script>alert('本周请假单已上报并生效。补填或其他相关问题请联系辅导员。');window.close();window.history.go(-1);</script>";
        exit;
    }

    if ($currentTime >= strtotime('14:00')) {
        echo "<script>alert('抱歉，本周请假单已上报至辅导员。若有需要，请在17:00前及时联系辅导员。');window.close();window.history.go(-1);</script>";
        exit;
    }
/*
    if ($currentTime >= strtotime('14:00')) {
        echo "<script>alert('抱歉，本周线上请假单填写已在今天14:00截止。如需补填，请在今天14:00前及时联系并线下填写。');window.history.go(-1);</script>";
        exit;
    }
*/
    
    
}elseif($dayOfWeek==6 || $dayOfWeek==7){

   //$nextWeek=$weekNum+1;
    echo "<script>alert('请假单已生效。新的请假条于周一开始填写。');window.close();window.history.go(-1);</script>";
    exit;
}
$nameAndID=isset($_COOKIE['nameAndID']) ? $_COOKIE['nameAndID'] : "";
$myPhone=isset($_COOKIE['myPhone']) ? $_COOKIE['myPhone'] : "";
$dormID=isset($_COOKIE['dormID']) ? $_COOKIE['dormID'] : "";
$parentName=isset($_COOKIE['parentName']) ? $_COOKIE['parentName'] : "";
$parentPhone=isset($_COOKIE['parentPhone']) ? $_COOKIE['parentPhone'] : "";


?>

<html lang="zh-CN"><head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>周末(假期)请假单填写 - 班级名单及应用平台</title>
    <link href="../font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../styles.css">
    <script src="https://staticHost/jquery-3.7.1.min.js"></script>


<style>

            #signatureCanvas{
                /* border: solid; */
                border-radius: 10px;
                width: 90%;
                height: auto;
                margin: 15px;
                aspect-ratio: 16/9;
            }
            .canvasBut{
                
                border:none;
                padding: 5px 15px;
                font-size: 25px;
                height:auto;
            }
            .canButtonsDest{
                background-color: rgb(255, 56, 0);;
                color:white;
                border-radius:30px;
            }
            .canButtonsDest:hover{
                background-color: rgb(255, 109, 69);
                
            }
            .canButtonsGo{
                /* background-color:rgb(84, 170, 255); */
                color:white;
                border-radius:30px;
            }
            #signArea{
                background-color: rgb(223, 236, 255); 
				text-align: center;
            }
            .dateInput{
                padding-right: initial;
                padding-left: initial;
            }
			@media (prefers-color-scheme: dark){
    #signArea {
        background-color: rgb(55, 83, 125);
    }
}


@media (orientation: landscape) {
#rotateInstruction {
display: none;
}
#kqw1{
    display: block;
}
}

@media (orientation: portrait) {

#rotateInstruction {
display: block;
}
#kqw1{
    display: none;
}
}
        </style>



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
                    <h2>周末(假期)请假单填写</h2>
                    <p>填写并提交周末(假期)请假信息</p>
                </div>
                
                <div class="data-card card-shadow">
                    
                    <!-- 提交表单 -->
                    <div class="form-card card-shadow">
                        <div class="card-header">
                            <h3 class="form-title">第<?php echo $weekNum;?>周请假单</h3>
                            <div class="card-actions" style="">
                            <a href="https://host/privacy_statement/"><button type="button" class="btn btn-sm btn-primary btn-hover" style="/*background-color:red;color:white;*/">查看《关于本平台信息处理的说明》</button></a>
                        </div>
                        </div>
                        <div class="form-content">
                            <form id="form1" action="./week_sub.php?grade=<?php echo $gradeNum;?>&weekNum=<?php echo $weekNum;?>" method="post">
                                <div class="form-group">
                                    <label for="sel1" class="form-label">学号姓名</label>
                                    <select name="studentName" required="" id="sel1" class="form-select">
                                        <option style="dispaly: none"></option>
                            <?php 
                                $sql = "SELECT * FROM  `namelist`";
                                $retval = mysqli_query( $conn, $sql );
                            // if(mysqli_num_rows($retval) == 0){
                            // echo "<script>alert('链接无效');window.history.go(-1);;</script>";
                            //print();// exit;//$passwordCode=md5($password);
                                while($row = mysqli_fetch_array($retval)){
                                    echo "<option value='".$row['number']."+".$row['name']."'>".$row['name']."（".$row['number']."）"."</option>";
                                }
                            ?>
                                                                                
                                    </select>
                                </div><div class="form-group">
                                    <label for="phm" class="form-label">本人电话</label><input type="phone" name="myPhone" id="phm" required="" value="" class="form-select">
                                    
                                </div><div class="form-group">
                                    <label for="dorm" class="form-label">宿舍号</label><input type="text" name="dormNum" id="dorm" required="" placeholder="例：西3-224" value="" class="form-select">
                                    
                                </div><div class="form-group">
                                    <label for="sel2" class="form-label">家长是否知情并同意</label><select name="parentKnown" required="" id="sel2" class="form-select">
    <option style="dispaly: none"></option>
    <option>是</option>
    <option>否</option>
</select>
                                    
                                </div><div class="form-group">
                                    <label for="you" class="form-label">请假事由</label><input type="text" name="myRas" id="you" required="" placeholder="回家、游玩等" class="form-select">
                                    
                                </div><div class="form-group">
                                    <label for="destm" class="form-label">离校目的地</label><input type="text" name="myDestnation" id="destm" required="" placeholder="具体到村、小区" class="form-select">
                                    
                                </div><div class="form-group">
                                    <label for="start" class="form-label">离校时间</label><input type="datetime-local" id="start" name="start" required="" placeholder="具体到几点" class="form-select dateInput">
                                    
                                </div><div class="form-group">
                                    <label for="end" class="form-label">返校时间</label><input type="datetime-local" id="end" name="end" required="" placeholder="具体到几点" class="form-select dateInput">
                                    
                                </div><div class="form-group">
                                    <label for="emep" class="form-label">紧急联系人关系及姓名</label><input type="name" id="emep" name="myParent" required="" placeholder="例：父子 姓名" value="" class="form-select">
                                    
                                </div><div class="form-group">
                                    <label for="pphone" class="form-label">紧急联系人电话</label><input type="phone" name="ePhone" id="pphone" required="" value="" class="form-select">
                                    
                                </div><div class="form-group">
                                    <label for="" class="form-label">本人签名</label>

                                    <div style="display: inline-flex;;align-items:center">
                                    <img id="signImage" style="background-color: #FFF;display:none;height: 62px;border-radius: 10px;">
<div id="signStartBut" style="display:inline-block;padding:5px">
        <button type="button" class="btn btn-sm btn-primary btn-hover" onclick="showSign()" id="signStartBut1">开始签字</button>
        </div>
        </div>

        <input type="text" name="signBase64" style="display:none;" value="" id="signBase64Sub"><div id="signArea" style="/* margin: 0px 32%; */ padding-bottom: 30px; padding-top: 5px; border-radius: 10px; display:none;">
    <!--span>请签字：</span><br/-->
	<div style="display: grid; gap: 10px; padding: 10px;">
	
    <button type="button" class="btn btn-sm btn-primary btn-hover" onclick="undoLast()" style="background-color:red;">撤销笔画</button>
    <button type="button" class="btn btn-sm btn-primary btn-hover" onclick="clearSignature()" style="background-color:red;">全部清空</button>
	
    
    <button type="button" class="btn btn-sm btn-primary btn-success btn-hover" onclick="saveSignature()">完成签字</button>
	</div>
	
    <canvas id="signatureCanvas" style="background: white;" width="0" height="0"></canvas>
    <br>
    <span style="font-size: 0.875rem;"><!--span>建议复制链接并用手机默认浏览器打开并横屏签字<br/></span--><div id="rotateInstruction" style="color:red;">
建议横屏签字<br/>旋转屏幕后自动完成签字（若签名合规）<br/>
</div><div id="kqw1" style="color:red;">
旋转屏幕后自动完成签字（若签名合规）<br/>
</div>签名仅用作本次请假条填写使用</span>
    </div>
                                    
                                </div>

                                <br/>
                                <div class="form-group">

                                <label for="isSaveCheckbox">
<input type="checkbox" name="isSave"  style value="true" id="isSaveCheckbox" checked="checked">将固定信息保存到本设备浏览器上
</label>
</div>
<br/>

                                
                                
								
                                
                                <!-- <div class="form-group">
                                    <label for="submit-notes" class="form-label">提交备注</label>
                                    <textarea id="submit-notes" class="form-textarea" placeholder="请输入备注信息（可选）"></textarea>
                                </div> -->
                                
                                <div class="form-actions">
                                    <button type="button" id="cancel-btn" class="btn btn-sm btn-outline btn-hover" style="display:none;">
                                        重置
                                    </button>
                                    <button type="submit" id="button4" class="btn btn-sm btn-primary btn-hover" style="">
                                        <i class="fa fa-paper-plane"></i>&nbsp;&nbsp;提交
                                    </button>
									
									
                                </div>
                            </form>
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
                    班级名单及应用平台 © 2024-Now 版权所有
                </div>
            </div>
        </footer>
    </div>

    
<script>
function setValues(key,value1){
    //window.localStorage.setItem(key,value)
    document.getElementById(value1).value=window.localStorage.getItem(key)// ? window.localStorage.getItem(key) : ""
}

setValues("nameAndID",'sel1');
setValues("myPhone",'phm');
setValues("dormID",'dorm');
setValues("parentName",'emep');
setValues("parentPhone",'pphone');


function setCookie(name, value, days) {
   var expires = "";
   if (days) {
       var date = new Date();
       date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
       expires = "; expires=" + date.toUTCString();
   }
   document.cookie = name + "=" + (value || "")  + expires + "; path=/";
}




    const canvas = document.getElementById('signatureCanvas');
    
        const ctx = canvas.getContext('2d');
        const container = document.body;
            const containerRect = container.getBoundingClientRect();
            const canvasRect = canvas.getBoundingClientRect();
        
        let isDrawing = false;
        let lastX, lastY;
        let strokes = []; // 用于存储每一步的绘制操作
        // canvas.onresize=function(){
        //     canvas.width=canvas.style.width;
        //     canvas.height=canvas.style.height;
        // }
            

        // 触摸开始事件
        function handleTouchStart(e) {
			e.preventDefault(); // 阻止默认的触摸事件
            isDrawing = true;
            [lastX, lastY] = [e.touches[0].clientX - canvas.getBoundingClientRect().left, e.touches[0].clientY - canvas.getBoundingClientRect().top];
            strokes.push([]); // 开始新的笔画
        }
 
        // 触摸移动事件
        function handleTouchMove(e) {
			e.preventDefault(); // 阻止默认的触摸事件
            if (!isDrawing) return; // 如果没有触摸，则退出函数
            

            const x = e.clientX - canvas.getBoundingClientRect().left || e.touches[0].clientX - canvas.getBoundingClientRect().left;
            const y = e.clientY - canvas.getBoundingClientRect().top || e.touches[0].clientY - canvas.getBoundingClientRect().top;
            // console.log(x);
            // console.log(y);
            // console.log(e.touches[0].clientX);
            // console.log(e.touches[0].clientY);
            // console.log(canvas.offsetLeft);
            // console.log(canvas.offsetTop);
            ctx.beginPath();
            ctx.moveTo(lastX, lastY);
            ctx.lineTo(x, y);
            ctx.stroke();
 
            strokes[strokes.length - 1].push({ x: lastX, y: lastY, x2: x, y2: y }); // 记录当前笔画
 
            [lastX, lastY] = [x, y];
        }
 
        // 触摸结束事件
        function handleTouchEnd(e) {
			e.preventDefault(); // 阻止默认的触摸事件
            isDrawing = false;
        }
 
        // 清除签名
        function clearSignature() {
            document.getElementById('signBase64Sub').value=""
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            strokes = []; // 清空所有笔画记录
        }
 
        // 撤销上一步
        function undoLast() {
            strokes.pop(); // 移除最后一个笔画
            redraw(); // 重新绘制画布
        }
 
        // 重新绘制画布
        function redraw() {
            ctx.clearRect(0, 0, canvas.width, canvas.height); // 清空画布
            strokes.forEach(stroke => {
                stroke.forEach(line => {
                    ctx.beginPath();
                    ctx.moveTo(line.x, line.y);
                    ctx.lineTo(line.x2, line.y2);
                    ctx.stroke();
                });
            });
        }
        
 
        // 保存签名
        function saveComment() {
            const imgData = ctx.getImageData(0, 0, canvas.width, canvas.height);
 
            // 将图片数据转换成 base64 格式
            const base64ImageData = canvas.toDataURL();
            
            //console.log(base64ImageData);
            $("#signImage").show();
            document.getElementById('signImage').src=base64ImageData
            document.getElementById('signBase64Sub').value=base64ImageData.split(',')[1]
            $("#signArea").hide();
            $("#signStartBut1").text("重新签名");
            $("#signStartBut").show();
            
        }

        function saveSignature(){
            if(strokes.length > 2){

            saveComment()
            
        }else{
            alert("签名貌似不正确，请重新签名。有问题请联系。")
        }
        }

        function autoSaveWhenWindowResize(){
            if(strokes.length > 2){

            saveComment()
            
        }else{
            clearSignature()
            canvas.width=canvas.clientWidth;
            canvas.height=canvas.clientHeight;
            ctx.lineWidth = 3
        }
        }

        window.onload = function() {
        canvas.width=canvas.clientWidth;
     canvas.height=canvas.clientHeight;
    };
 
        // 绑定事件
        canvas.addEventListener('touchstart', handleTouchStart);
        canvas.addEventListener('touchmove', handleTouchMove);
        canvas.addEventListener('touchend', handleTouchEnd);
        canvas.addEventListener('touchcancel', handleTouchEnd);
</script>


<script>
function scrollToAnchor(anchorName) {
    
    var anchorElement = document.getElementById(anchorName);
    if(anchorElement) {
      
        anchorElement.scrollIntoView();
    } else {
        window.location.hash = anchorName;
    }
}
    function showSign(){
        document.getElementById('signImage').src="";
        document.getElementById('signImage').style.display="none";
        clearSignature();
        if('ontouchstart' in document.documentElement){
            
            $("#signArea").show();
            $("#signStartBut").hide();
            canvas.width=canvas.clientWidth;
            canvas.height=canvas.clientHeight;
            scrollToAnchor("signArea");
            ctx.lineWidth = 3
        }else{
            //ctx.fillText("非触摸屏设备，无法签字。\n请更换设备或线下填写请假单。",0,0)
            alert("非触摸屏设备，无法签字。\n请更换设备（如手机等）或线下填写请假单。")
        }


        
    }
      
    window.onresize=function(){
        // canvas.width=canvas.clientWidth;
        // canvas.height=canvas.clientHeight;
        // ctx.lineWidth = 3
        // redraw()
        
        //console.log("123tweg")
    }
    
    
    
    </script>
<script>
     if(!('ontouchstart' in document.documentElement)){
         alert("非触摸屏设备，无法签字。\n请更换设备（如手机等）或线下填写请假单。")
        
         document.body.innerHTML="<h1>非触摸屏设备，无法签字。<br/>请更换设备（如手机等）或线下填写请假单。</h1>"
        
        
         window.history.go(-1);
     }



    $(document).ready(function() {
	/**
	$('#end').on('change', function() { //当input元素的值改变时触发该事件
        var inputValue = $(this).val(); //获取input元素的新值
        
        if (inputValue === 'example'){ //判断新值是否等于'example'
            alert("输入的值与'example'相符！"); //显示一条消息
        } else {
            console.log("输入的值与'example'不相符！"); //打印到控制台上
        }
    });

	*/
	function setLocalStorage(key,value){
        window.localStorage.setItem(key,value)
    }
    $('#form1').on('submit', function(e) {
	var shouldStartDateString="20xx-01-01 20:30"
	var shouldEndDateString="20xx-01-02 18:39"
	var timeshould=false;//此处控制是否受时间限制，一般在大假条填写时设置为true
	var endDate=new Date($('#end').val());
	var startDate=new Date($('#start').val());
	var shouldEndDate=new Date(shouldEndDateString);
	var shouldStartDate=new Date(shouldStartDateString);
	var canSub=true;
	if (endDate>shouldEndDate || startDate < shouldStartDate){
		//e.preventDefault();
		canSub=false;
		
		
	}
	
	var phoneyes=false
	var phone1 = $("#phm").val();
	var phone2 = $("#pphone").val();
    if((/^1[3456789]\d{9}$/.test(phone1)) && (/^1[3456789]\d{9}$/.test(phone2)) ){ 
        phoneyes=false
        
    }else{
	    phoneyes=true
	}
	
	if (document.getElementById('isSaveCheckbox').checked){
        setLocalStorage("nameAndID",$('#sel1 option:selected').val());
        setLocalStorage("myPhone",document.getElementById('phm').value);
        setLocalStorage("dormID",document.getElementById('dorm').value);
        setLocalStorage("parentName",document.getElementById('emep').value);
        setLocalStorage("parentPhone",document.getElementById('pphone').value);
    }else{
        setLocalStorage("nameAndID","");
        setLocalStorage("myPhone","");
        setLocalStorage("dormID","");
        setLocalStorage("parentName","");
        setLocalStorage("parentPhone","");
    }
	
	
	
        // 阻止表单默认提交行为
        //e.preventDefault();
        if($('#sel2 option:selected').val() != "是"){
            e.preventDefault();
            alert("家长必须知情并同意才可请假");
        }else if(document.getElementById('signBase64Sub').value==""){
            e.preventDefault();
            alert("请先完成签字后再提交");
        }else if((!canSub && timeshould)){
		 	e.preventDefault();
			alert("抱歉，请假日期须在"+shouldStartDateString+"至"+shouldEndDateString+"之间，请检查并修改后再提交。");
		}else if(phoneyes){
			e.preventDefault();
			alert("抱歉，本人电话或紧急联系人电话不正确，请检查并修改后再提交。若有问题请联系。");  
		}else{
            e.preventDefault();
            if (confirm("请假须知：\n1.学生离校前应提前与监护人沟通，并取得监护人同意；\n2.填写此假条离校后，由学生本人负责个人人身财产安全。\n\n是否阅读以上内容并提交请假条？")) {
            //if (confirm('姓名和学号：'+$('#sel1 option:selected').val()+"\n请务必确认好！")) {
                // 如果用户确认，则继续提交表单
                $(this).unbind('submit').submit();
            }
        }
       
    });
});

if (navigator.userAgent.includes('Lark')) {

}else{
//document.body.innerHTML="<h1 glign='center'>请使用飞书App打开</h1>"
//alert('请使用飞书打开。')
}

//if(confirm("这是有关于本平台信息收集及处理方式的详细说明。现向大家予以说明，并接受监督。\n\n是否查看全文？\n《关于本平台对于信息处理和其他问题的说明》")){
//window.location.href='https://host/privacy_statement/';
//}


function handleOrientationChange() {
// if (window.orientation === 0 || window.orientation === 180) {
// console.log('竖屏');
// } else if (window.orientation === 90 || window.orientation === -90) {
// console.log('横屏');
// }
autoSaveWhenWindowResize()



}

window.addEventListener("orientationchange", handleOrientationChange);

    
 </script>


    </body>
    
    </html>