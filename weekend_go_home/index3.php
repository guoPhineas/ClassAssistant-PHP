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
<html><head>
        <!--link rel="stylesheet" type="text/css" href="https://staticHost/dark.css"-->
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>周末请假单填写 - 班级名单及应用平台</title>
		<script src="https://staticHost/jquery-3.7.1.min.js"></script>
        
        <style>
            
            #mainDiv{
                text-align: center;
                /*font-size: 40px;*/
				display: flex;
				padding-top: 50px;
				/*gap: 150px;*/
				justify-content: space-around;
            }
			#button4{
			padding: 5px 30px;
			font-weight: ;
			}
        button{
            border-radius:50px;
            height:65px;
            
            background:rgb(0, 132, 255);
            color:white;
            font-size:40px;
            -webkit-appearance:none;
            outline: none;
            border: 0;
            display:inline-block
            
            
        }
        button:hover{
            background: rgb(0, 164, 255);
        }
            
        #div2{
            //text-align:left
        }
        textarea{
            border-radius:10px;
            height:25%;
            width:30%;
            font-size:15px
            
        }
        #span1{
            position: absolute;
            left: 35%;
        }
        #js{
            font-size:13px;
            position: relative;
            left: 15px;
        }
        .red{
            color:red;
            vertical-align:super;
            font-size: 2vw;
        }
        input{
            /*font-size: 35px;*/
        }
        select{
           /* font-size: 35px;*/
        }
        .allApplications{
            padding:10px;
            border-radius:20px;
            //display: inline-flex;
                
        }
        input{
            margin:20px;
        }
            .applicationCard{
                /* //width:30%;
                //height:30%; */
                padding:20px;
                background-color:red;
                margin:30px;
                border-radius: 30px;
                
            }
            .cardName{
                font-size:70%;
            }
            #signatureCanvas{
                /* border: solid; */
                border-radius: 10px;
                width: 90%;
                height: 330px;
                margin: 15px;
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
			nav{
    /*border-top: rgb(218, 218, 218) 1px solid;*/
    border-bottom: rgb(184, 218, 255) 1px solid;
box-shadow: 0px 0px 20px rgba(218, 218, 218,0.6);
background-color: rgb(240, 240, 240);

}

nav *{
    display:inline-block;
    align-items:center;
	text-decoration:none;
}
nav a{
color: rgb(47, 67, 92);
}
nav a:hover{
color: rgb(101, 127, 158);

}
nav .cont{
    display:flex;
    justify-content: space-around;
    font-size:20px;
    

}

.cont li{
    display:inline-block;
    padding: 0 40px 0 40px;
}
nav .title{
    font-size:35px;
}
body{
    text-align:center;
    margin: 0;
    padding: 0;
	font-family: Monospace, serif;
}
nav div{
    padding:6px;
}

.titl2{
padding-left: 3.5vw;
font-size: 2.7vw;
min-width: 30%;
/*position: relative;*/
}
.right{
text-align:left;

}
.right,select,input{
font-size: 2vw;
}
.he1{
display: block;
font-size: 1.17em;

font-weight: bold;
}
.he2{
display: block;
font-size: 0.83em;
margin-top: 1.2em;
font-weight: bold;
}
.ti11{
position: sticky;
top: 40px;
text-align: left;
}
.bott1{
		font-size:20px;
		}
            @media (prefers-color-scheme: dark) {
            body {
                background-color:#1e1e1e;
                color:#FFF;
            }
            #signArea{
                background-color: rgb(55, 83, 125);
            }
			nav{
			border-bottom: rgb(0, 68, 106) 1px solid;
			box-shadow: 0 0 20px rgba(0, 22, 110, 0.32);
			background-color: rgb(41, 41, 41);
			}
			nav a{
			color: rgb(131, 163, 203);
			}
			nav a:hover{
			color: rgb(73, 103, 164);
			}
    }
	
	@media (orientation:portrait) or (max-width:850px){
		#mainDiv{
			flex-direction: column;
			gap: 50px;
			font-align:center;
		}
		nav{
		position: sticky;
		top: -1;
		}
		.ti11{
		text-align: center;
		}
		.titl2{
		padding-left: 0;
		font-size: 6.5vw;
		}
		.he2{
		margin-top: 20px;
		}
		.right{
		text-align:center;
		/*margin-left:20px;
		margin-right:20px;*/
		}
		.right,select,input{

margin-bottom:40px

}
		.right,select,input,.canvasBut{
font-size: 5vw;


}
button{
padding:30px;
font-size: 5vw;
}
.canvasBut{
padding-right:30px;
padding-left:30px;
border-radius:100px
}
		.n1{
		text-align:center;
		}
		.div .titl2{
		text-align:center;
		}
		nav .cont{
		font-size: 3vw;
		}
		nav .title{
		font-size: 4vw;
		}
		#button4{
		padding: 10px 40px;
		font-size: 7vw;
		height: auto;
		}
		.bott1{
		font-size:30px;
		}
		.con123{
		margin-left: 20px;
		}
		.ti11{
		position: unset;
		}
		
	}
	@media (orientation:portrait) and (max-width:650px){
	.nav-item{
	display:none;
	}
	.cont{
	text-align: left;
	justify-content:start;
	}
	}
        </style>
    </head>
    <body>
	<nav><div class="cont"><div class="title titl2">周末请假单填写</div>
	<div class='nav-item'>
	<ul><a onclick='alert("请使用链接打开页面以上传作业")'>文件作业提交</a></ul>
	<ul><a href=''>周末请假单填写</a></ul>
	<ul><a href='../admin/admin.php'>管理</a></ul>
	</div>
	</div></nav>
	<div class='n1'>
        <div id="mainDiv">
		<div class='titl2' align=''>
        <div class='ti11'><span class='he1'>第<?php echo $weekNum;?>周周末请假单</span><span class='he2'><?php echo $gradeName;?></span><br/>
		<a href='https://host/privacy_statement/' style="font-size:0.83em;background-color:rgb(0, 132, 255);border-radius:999px;padding:5px;margin:0px;color:white;text-decoration: none;">查看《关于本平台信息处理的说明》</a>
		</div>
        <!--h3>第<?php echo $weekNum;?>周周末请假单</h3-->
        <!--span style="font-size:50px">第<?php echo $weekNum;?>周周末请假单</span-->
		 <!--a href='https://host/privacy_statement/'><button align='center' type="button" style='margin:0px;font-size:20px' id="b">查看《关于本平台信息处理的说明》</button></a-->
        </div>
        <div class='right'>
        

	
	<form action="./week_sub.php?grade=<?php echo $gradeNum;?>&weekNum=<?php echo $weekNum;?>" method="post" id="form1">
	<div style="text-align: left;" class='con123'>
        <label for="sel1"><span><span class="red">*</span>学号姓名：</span></label>
<select name="studentName" required="" id="sel1"">
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
                            <!--option value=''>测试姓名</option-->
</select><br/>
<label for="phm"><span><span class="red">*</span>本人电话：</span></label><input type="phone" name="myPhone" id="phm" required=""  value="<?php //echo $myPhone;?>">
<br/>
<label for="dorm"><span><span class="red">*</span>宿舍号：</span></label><input type="text" name="dormNum" id="dorm" required="" placeholder="例：西3-224"  value="<?php //echo $dormID;?>">
<br/>
<label for="sel2"><span><span class="red">*</span>家长是否知情并同意：</span></label><select name="parentKnown" required="" id="sel2">
    <option style="dispaly: none"></option>
    <option>是</option>
    <option>否</option>
</select>
<br/>
<label for="you"><span><span class="red">*</span>请假事由：</span></label><input type="text" name="myRas" id="you" required="" placeholder="回家、游玩等">
<br/>
<label for="destm"><span><span class="red">*</span>离校目的地：</span></label><input type="text" name="myDestnation" id="destm" required="" placeholder="具体到村、小区">
<br/>
<label for="start"><span><span class="red">*</span>离校时间：</span></label><input type="datetime-local" id="start" name="start" required="" placeholder="具体到几点">
<br/>
<label for="end"><span><span class="red">*</span>返校时间：</span></label><input type="datetime-local" id="end" name="end" required="" placeholder="具体到几点">
<br/>
<label for="emep"><span><span class="red">*</span>紧急联系人关系及姓名：</span></label><input type="name" id="emep" name="myParent" required="" placeholder="例：父子 姓名" value="<?php //echo $parentName;?>">
<br/>
<label for="pphone"><span><span class="red">*</span>紧急联系人电话：</span></label><input type="phone" name="ePhone" id="pphone" required="" value="<?php //echo $parentPhone;?>">
<br/>
<label for="signBase64Sub">
<div style="display: inline-flex;;align-items:center"><span><span class="red">*</span>本人签名：</span>
    <!-- <a href="javascript:showSign()"> -->
        <img id="signImage" style="background-color: #FFF;display:none;height: 62px;border-radius: 10px;"/>
    <!-- </a> -->
    <div id="signStartBut" style="display:inline-block;padding:5px">
        <button type="button" onClick="showSign()" class="canvasBut canButtonsGo" id="signStartBut1">开始签字</button>
        </div>
</div>
<div id="signArea" style="margin: 0px 32%; padding-bottom: 30px;padding-top: 5px; border-radius: 10px;margin: 20px;display:none">
    <!--span>请签字：</span><br/-->
	<div>
	
    <button type="button" onClick="undoLast()" class="canvasBut canButtonsDest">撤销笔画</button>
    <button type="button" onClick="clearSignature()" class="canvasBut canButtonsDest">全部清空</button>
	&nbsp;
    
    <button type="button" onClick="saveSignature()" class="canvasBut canButtonsGo">完成签字</button>
	</div>
	
    <canvas id="signatureCanvas" style="background: white;"></canvas>
    <br/>
    <span style="font-size: 60%;"><!--span>建议复制链接并用手机默认浏览器打开并横屏签字<br/></span-->签名仅用作本次请假条填写使用</span>
    </div>
    

<br/>
</label>
<input type="text" name="signBase64"  style="display:none;" value="" id="signBase64Sub">
<br/>
<label for="isSaveCheckbox">
<input type="checkbox" name="isSave"  style value="true" id="isSaveCheckbox" checked="checked">将固定信息保存到本设备浏览器上
</label>
<br/>

  </div>
  <button align='center' type="submit" style='margin:20px;' id="button4">提交</button><br/>
</form>

</div>


</div> 
<span style="" class='bott1'>©班级名单及应用平台<br/></span>
<br/>   
</div>    

        
    





<script>
  //document.getElementById("sel1").value = "<?php echo $nameAndID;?>"; // 设置默认值为 "2"
</script>


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
        function saveSignature() {

            if(strokes.length > 2){

            
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
        }else{
            alert("签名貌似不正确，请重新签名。有问题请联系。")
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
        canvas.width=canvas.clientWidth;
        canvas.height=canvas.clientHeight;
        ctx.lineWidth = 3
        redraw()
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

    
 </script>
</body></html>

