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
$proName=$_GET['proName'];
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




    function zipFolder($source, $destination) {
        $zip = new ZipArchive();
        $filename = $destination;
        
        if ($zip->open($filename, ZipArchive::CREATE) !== TRUE) {
            exit("无法打开 <$filename>\n");
        }
        
         // 添加文件到ZIP中，可以指定新的文件名
        //$zip->addFile('file2.txt', 'file2.txt'); // 添加另一个文件
        // $dir = "./fileUpload/".$fID."/";
                $files = scandir($source);
                $files = array_diff($files, array('.', '..'));
                foreach ($files as $file) {
                    $zip->addFile($source.$file, $file);


                }
       
     
        return $zip->close();
    }
     
    // 使用函数压缩文件
    $sourceFolder = "./fileUpload/".$fID."/"; // 要压缩的文件夹路径
    $destinationZip = "./fileUpload/downloadFile/".$proName.".zip"; // 压缩文件存储路径
     
    if (zipFolder($sourceFolder, $destinationZip)) {

        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=" . basename($destinationZip)); 
        header("Content-Length: " . filesize($destinationZip));
        readfile($destinationZip);
        unlink($destinationZip);
    } else {
        echo "<script>alert('压缩文件失败。');window.history.go(-1);;</script>";
    }












?>
