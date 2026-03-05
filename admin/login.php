<?php
include '../src/conj.php';
$userName = $_POST['userName'];
$gavenPassword = $_POST['password'];
$password=md5($gavenPassword);
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);


if(! $conn )
{
    mysqli_close($conn);
    //header("Location: ".$hostURL."err2.html");
    
    exit;
}

$sql = "SELECT * FROM `admin_user` WHERE `userName` = '".$userName."'";

$retval = mysqli_query( $conn, $sql );
//$passwordCode=md5($password);
while($row = mysqli_fetch_array($retval))
{
    if(($row["UserName"] == $userName) && ($row["Password"] == $password)){
        
        echo "yes";
        
            $random=rand(1000000, 999999999999);
            $cook=md5($key.$random.$userName.$password);
            //$cook=$key."-".$random."-".$id."-".md5($passwordCode);
            //echo "yes";
        
//        echo $key.$random.$id.$passwordCode;
        setcookie("userName",$userName,time()+3600);
        setcookie("auth",$cook,time()+3600);
        setcookie("rand",$random,time()+3600);
           header("Location: ./admin.php");
            
        
    }else{
	//print($userName);
	//print($password);
        echo "<script>alert('密码错误');window.history.go(-1);</script>";
    }
}



?>
