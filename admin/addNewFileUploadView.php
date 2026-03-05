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
<html><head>
        <link rel="stylesheet" type="text/css" href="https://staticHost/dark.css">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>添加文件提交项目 - 班级名单及应用平台</title>
        <style>
            a{
				background: rgb(0, 132, 255);
margin: 17px;
padding: 3px 20px;
border-radius: 100px;
color: white;
text-decoration: none;
display: inline-block;
			}
			a:hover{
			background: rgb(0, 164, 255);
			}
            #mainDiv{
                text-align: center;
                font-size: 40px;
            }
        button{
            border-radius:30px;
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
            font-size: 25px;
        }
        input{
            font-size: 35px;
        }
        select{
            font-size: 35px;
        }
        #textareaNote{
            height: 150px;
            width: 35vw;
            resize: vertical;
        }
        @media (prefers-color-scheme: dark){
            textarea{
            color:white;
            }
        }
        
        </style>
    </head>
    <body>
        <div id="mainDiv">
        <h2>添加新上传文件项目</h2>
        <a href='./adminFileUpload.php'>返回</a>
        <br/>
        <br/>
        <form action="./addNewFileUpload.php" method="post"><div style="line-height:30px">
                <span><span class="red">*</span>项目（作业）名称：</span>
                <input type="text" name="proName" required="">
                <br/>
                <br/>
                <div>
                
                <span style="vertical-align: top;">提交要求（备注）：</span>
                
                <textarea name="note" id="textareaNote" style="min-height: 80px;font-size: 30px;" placeholder="可在此处添加说明，允许换行（回车）&#10;备注将在提交页面显示（可选填）"></textarea>
                </div>
				<br/>
				<br/>
                
				<span><span class="red">*</span>允许上传格式：</span>
                <select name='suffix' required>
				<option></option>
				<option>docx</option>
				<option>png</option>
				<option>md</option>
				<option>pdf</option>
				<option>jpg</option>
				<option>jpeg</option>
				<option>pptx</option>
				<option>xlsx</option>
				<option>zip</option>
				<option>doc</option>
				<option>ppt</option>
				<option>xls</option>
				<option>mov</option>
				<option>mp4</option>
				<option>mp3</option>
				<option>avi</option>
				<option>m4a</option>
				</select>
                <br/>
                <br/>
                <div>
                <span><span class="red">*</span>停止收集：</span>
                <input type="radio" id="no" name="haveDeadline" value="0" checked onClick="disShow()">
                <label for="no">手动停止</label>
                &nbsp;&nbsp;
                <input type="radio" id="date" name="haveDeadline" value="1" onClick="show()">
                
                <label for="date">自动停止</label>
                </div>
                <br/>
                <br/>
                <div id="deadlineTime" style="display:none">
                <span><span class="red">*</span>截止时间：</span>
                <input type="datetime-local" id="deadlineT" name="deadlineDate"/>
                <br/>
                <span style="font-size:20px">将于截止时间之后自动停止收集</span>
                </div>
                
            </div>
                        
                        <br>
                        
                        <br>
                        <button type="submit"> 创建 </button>
<br>
                    <div style="line-height:30px">
<br>
                        
    
    
    
</div>
                    </form>
        </div>
    


<script>
function show(){
    var a=document.getElementById('deadlineTime')
    a.style.display=""
    var b=document.getElementById('deadlineT')
    b.required=true
   
}
function disShow(){
    var a=document.getElementById('deadlineTime')
    a.style.display="none"
    var b=document.getElementById('deadlineT')
    b.required=false
}


</script>

</body></html>
