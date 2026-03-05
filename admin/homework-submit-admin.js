// 作业提交页面专用脚本
document.addEventListener('DOMContentLoaded', function() {
  

    notNames=notName.split(",")
yesNames=yesName.split(",")
var hasSubNum=document.getElementById('hasSubNum')
var noSubNum=document.getElementById('noSubNum')
var hasSubPer=document.getElementById('hasSubPer')


hasSubNum.innerHTML=yesNames.length-1
noSubNum.innerHTML=notNames.length-yesNames.length
hasSubPer.style.width=((yesNames.length-1)/(notNames.length-1))*100+"%"

var nas=""
/*for(i=0;i<notNames.length;i++){
if(yesNames.includes(notNames[i])){
notNames.splice(i, 1)
}
//nas=nas+notNames[i]+"\n"
}*/
var finame=notNames.filter(item => !yesNames.includes(item));
for(i=0;i<finame.length;i++){
nas=nas+finame[i]+"\n"

}

    $("#showNameNotSub").click(function(){
	if(finame.length <= 0){
		 alert("已全部提交")
	}else{
        alert("尚未提交的文件（共"+finame.length+"份）：\n"+nas)
	}
    })







});

    