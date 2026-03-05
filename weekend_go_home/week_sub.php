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

$grade=$_GET["grade"];
$weekNum=$_GET["weekNum"];
$studentName=$_POST["studentName"];
$myPhone=$_POST["myPhone"];
$dormNum=$_POST["dormNum"];
$parentKnown=$_POST["parentKnown"];
$myRas=$_POST["myRas"];
$myDestnation=$_POST["myDestnation"];
$start=$_POST["start"];
$end=$_POST["end"];
$myParent=$_POST["myParent"];
$ePhone=$_POST["ePhone"];
$signBase64=$_POST["signBase64"];
$nowTime = date('Y-m-d H:i:s');

$nameAndNum=explode("+",$studentName);


$isSave=isset($_POST["isSave"]) ? true : false;


// if($isSave){
// setcookie("nameAndID", $studentName, time()+36000000, "/");
// setcookie("myPhone", $myPhone, time()+36000000, "/");
// setcookie("dormID", $dormNum, time()+36000000, "/");
// setcookie("parentName", $myParent, time()+36000000, "/");
// setcookie("parentPhone", $ePhone, time()+36000000, "/");
// }else{
// setcookie("nameAndID", $studentName, time()-36000000, "/");
// setcookie("myPhone", $myPhone, time()-36000000, "/");
// setcookie("dormID", $dormNum, time()-36000000, "/");
// setcookie("parentName", $myParent, time()-36000000, "/");
// setcookie("parentPhone", $ePhone, time()-36000000, "/");
// }




$sql = "SELECT * FROM `weekend_home` WHERE `grade`='$grade' AND `weekNum`='$weekNum' AND `studentID`='$nameAndNum[0]'";
$result = $conn->query($sql);
 
if ($result->num_rows > 0) {
    echo "<script>alert('已提交过本周的请假单，请勿重复提交。如需修改请联系。');window.history.go(-1);</script>";
    exit;
}

$sql = "INSERT INTO `weekend_home`(`grade`, `weekNum`, `studentID`, `name`, `mPhone`, `parentYes`, `reason`, `destination`, `leaveSchoolTime`, `BackSchoolTime`, `eParent`, `ePPhone`, `pSign`, `subTime`, `dorm`) VALUES ('$grade','$weekNum','$nameAndNum[0]','$nameAndNum[1]','$myPhone','$parentKnown','$myRas','$myDestnation','$start','$end','$myParent','$ePhone','$signBase64','$nowTime','$dormNum')";
 
if (mysqli_query($conn, $sql)) {

	//$succHTML = file_get_contents('./success.html');
	//echo $succHTML;
    header("Location: ./success.html");
} else {
    //echo "Error: " . $sql . "<br>" . $conn->error;
     echo "<script>alert('提交失败。请重试。若多次失败请线下填写。');window.history.go(-1);</script>";
}
 
mysqli_close($conn);

?>