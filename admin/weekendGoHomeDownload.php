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

    $grade=$_GET['grade'];
    $weekNum=$_GET['weekNum'];
    require_once './package/PHPOffice/PHPWord/bootstrap.php';
    use PhpOffice\PhpWord\PhpWord;
    


    $sql = "SELECT * FROM `weekend_home` WHERE `grade`='$grade' AND `weekNum`='$weekNum'";

    $retval = mysqli_query( $conn, $sql );
    //$passwordCode=md5($password);
if(mysqli_num_rows($retval) == 0){
    echo "<script>alert('暂无请假人员，不可下载');window.history.go(-1);</script>";
    exit;
}
    $tmp=new \PhpOffice\PhpWord\TemplateProcessor('tmplWeek.docx');//打开模板
    $tmp->setValue("weekNum",$weekNum);
    $tmp->cloneRow('studentNum',mysqli_num_rows($retval));
    $index1=1;
    while($row = mysqli_fetch_array($retval))
    {
        
        $tmp->setValue("studentNum#".$index1,$row["studentID"]);//替换变量
        $tmp->setValue("name#".$index1,$row["name"]);//替换变量
        $tmp->setValue("phone#".$index1,$row["mPhone"]);//替换变量
        $tmp->setValue("dorm#".$index1,$row["dorm"]);//替换变量
        $tmp->setValue("reason#".$index1,$row["reason"]);//替换变量
        $tmp->setValue("known#".$index1,$row["parentYes"]);//替换变量
        $tmp->setValue("destnation#".$index1,$row["destination"]);//替换变量
        $tmp->setValue("leaveTime#".$index1,$row["leaveSchoolTime"]);//替换变量
        $tmp->setValue("backTime#".$index1,$row["BackSchoolTime"]);//替换变量
        $tmp->setValue("ePrent#".$index1,$row["eParent"]);//替换变量
        $tmp->setValue("ePhone#".$index1,$row["ePPhone"]);//替换变量
    
        // 将数据保存为文件
        $result = file_put_contents("./fileUpload/downloadFile/temp".$index1.".png", base64_decode($row["pSign"]));
        
        if ($result == false) {
            echo "签名信息不完整或当前教学周的请假信息已删除，仅可查看当周请假人员的姓名、学号等非敏感字段，无法导出请假单。";
            exit;
        }


        $tmp->setImageValue("sign#".$index1,['path'=>"./fileUpload/downloadFile/temp".$index1.".png",'width'=>80,'height'=>40]);

        unlink("./fileUpload/downloadFile/temp".$index1.".png");
        
        $index1=$index1+1;
    }
    $index1=1;


    $sql = "SELECT * FROM `weekend_approve` WHERE `grade`='$grade' AND `weekNum`='$weekNum'";

    $retval = mysqli_query( $conn, $sql );
    //$passwordCode=md5($password);

    while($row = mysqli_fetch_array($retval))
    {
        $result = file_put_contents("./fileUpload/downloadFile/tempA.png", base64_decode($row["aSign"]));
        
        if ($result == false) {
            echo "请联系管理员";
            exit;
        }


        $tmp->setImageValue("aSign",['path'=>"./fileUpload/downloadFile/tempA.png",'width'=>80,'height'=>40]);

        unlink("./fileUpload/downloadFile/tempA.png");
    }


    $tmp->saveAs('./fileUpload/downloadFile/weekend.docx');//另存为
    $destinationDocx = "./fileUpload/downloadFile/weekend.docx"; // 压缩文件存储路径
    header("Content-Type: application/octet-stream");
    header("Content-Disposition: attachment; filename=" . "第".$weekNum."周请假单（总学期：".$grade."）.docx"); 
    header("Content-Length: " . filesize($destinationDocx));
    readfile($destinationDocx);
    unlink($destinationDocx);



?>