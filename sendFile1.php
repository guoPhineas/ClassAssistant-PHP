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
echo "<script>alert('链接无效');window.history.go(-1);;</script>";
//print();
            exit;
}
    //$passwordCode=md5($password);
    while($row = mysqli_fetch_array($retval))
    {
	if($row["isStop"]){
	echo "<script>alert('链接已关闭。已停止上传文件。');window.history.go(-1);;</script>";
	//print();
            	exit;
                }else{
 $mainName=$row["mainName"];
 if($row["suffix"]==""){
 $suffix="docx";
 }else{
 $suffix=$row["suffix"];
 }
}
      

    }

?>

<html><head>
        <link rel="stylesheet" type="text/css" href="https://staticHost/dark.css">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>提交文件：<?php echo $mainName;?> - 班级名单及应用平台</title>
		<script src="https://staticHost/jquery-3.7.1.min.js"></script>
		<link rel="icon" href="https://staticHost/wp-content/uploads/2022/12/cropped-cropped-GLLogo3-192x192.png" sizes="192x192">
        <style>
            
            #mainDiv{
                text-align: center;
                font-size: 40px;
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
            font-size: 25px;
        }
        input{
            font-size: 35px;
        }
        select{
            font-size: 35px;
        }
        .allApplications{
            padding:10px;
            border-radius:20px;
            //display: inline-flex;
                
        }
            .applicationCard{
                //width:30%;
                //height:30%;
                padding:20px;
                background-color:red;
                margin:30px;
                border-radius: 30px;
                
            }
            .cardName{
                font-size:70%;
            }
        
        </style>
    </head>
    <body>
        <div id="mainDiv">
		<br/>
        <span style="font-size:50px">提交文件：<?php echo $mainName;?></span>
        <br/>
        
        <br/>
        <br/>
        

	<div>
	<form action="./fileUpdate.php?fID=<?php echo $fID;?>&proName=<?php echo $mainName;?>" method="post" enctype="multipart/form-data" id="form1">
<span><span class="red">*</span>学号姓名：</span>
<select name="studentName" required="" id="sel1">
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
</select><br/><br/>
    <label for="file"><span class="red">*</span>文件：</label>
    <input type="file" name="file" id="file" required accept="<?php echo ".".$suffix;?>"><br/>
	<span style="font-size:25px;color:red;">仅允许上传.<?php echo $suffix;?>文件</span><br/>
<button type="submit" style='margin:20px;padding: 5px 30px;'>提交</button><br/>
<span style='font-size: 20px;'>注意事项：<br/>1、<span style='color:red;'>请上传规定的格式，否则无法上传；</span><br/>2、若需要修改已上传的文件，请再次上传最新（修改后）的文件即可，自动覆盖。<span style='color:red;'>但请务必确认姓名正确；</span><br/>3、仅需要保证文件格式（后缀名）符合要求即可，文件上传后名称会自动修改为正确的名称。</span><br/>
    
</form>
<br>
<!--div style="font-size:20px">

</div-->
<span style="font-size:20px">©班级名单及应用平台<br/></span>
<br/>
</div>        

        </div>
    


<script>
alert("提交前请注意：\n1、请上传规定的格式，否则无法上传；\n2、若需要修改已上传的文件，请再次上传最新（修改后）的文件即可，自动覆盖。但请务必确认姓名正确；\n3、仅需要保证文件格式（后缀名）符合要求即可，文件上传后名称会自动修改为正确的名称。");
$(document).ready(function() {
    $('#form1').on('submit', function(e) {
        // 阻止表单默认提交行为
        e.preventDefault();
 
        // 弹出确认框
        if (confirm('姓名和学号：'+$('#sel1 option:selected').text()+"\n请务必确认无误后再提交！")) {
		//if (confirm('姓名和学号：'+$('#sel1 option:selected').val()+"\n请务必确认好！")) {
            // 如果用户确认，则继续提交表单
            $(this).unbind('submit').submit();
        }
    });
});

</script>

</body></html>

