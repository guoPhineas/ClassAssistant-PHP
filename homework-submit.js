// 作业提交页面专用脚本
const fileInput = document.getElementById('file-upload');
const fileUploadArea = document.querySelector('.file-upload');
const uploadLink = document.querySelector('.upload-link');
document.addEventListener('DOMContentLoaded', function() {
    // 返回按钮点击事件
    // document.getElementById('back-btn').addEventListener('click', function() {
    //     window.location.href = '../management/management.html';
    // });
    
    

    // 文件上传处理
    

    var suff1=document.getElementById('suff1')
    var suff=document.getElementById('suff')
    suff.innerText='.'+suff1.innerText
    fileInput.accept='.'+suff1.innerText
    
    // 点击上传链接触发文件选择
    uploadLink.addEventListener('click', function(e) {
        e.preventDefault();
        fileInput.click();
    });
    
    // 文件选择处理
    fileInput.addEventListener('change', function(e) {
        if (e.target.files && e.target.files.length > 0) {
			if((e.target.files[0].size/1024/1024)>5){
				e.target.files=null
				alert("仅允许上传5MB以内大小的文件")
				
				
			}else{
            const fileName = e.target.files[0].name;
            showUploadedFile(fileName,e.target.files.files);
			}
            
        }
    });
    
    // 拖放功能
    fileUploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        fileUploadArea.classList.add('dragover');
    });
    
    fileUploadArea.addEventListener('dragleave', function() {
        fileUploadArea.classList.remove('dragover');
    });
    
    fileUploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        fileUploadArea.classList.remove('dragover');
        
        if (e.dataTransfer.files && e.dataTransfer.files.length > 0) {
            if (e.dataTransfer.files.length>1){
                alert("仅允许选择一个文件")
            }else{
				if((e.dataTransfer.files[0].size/1024/1024)>5){
					e.dataTransfer.files=null
				alert("仅允许上传5MB以内大小的文件")
				
				
			}else{
                const fileName = e.dataTransfer.files[0].name;
                showUploadedFile(fileName,e.dataTransfer.files);
			}
            }
            
        }
    });
    
    // 显示已上传文件
    function showUploadedFile(fileName,file) {
        
        var a=fileName.split('.')
        //alert(a[a.length-1])
        if(a[a.length-1]==suff1.innerText){
			//alert(file.size)
			//if (!((file.size/1024/1024)>5)){
				
			
			
            	var iconView=document.getElementById('iconView')
            	iconView.className='fa fa-file-text'
           		var fileViewTitle=document.getElementById('fileViewTitle')
            	var fileViewSubTitle=document.getElementById('fileViewSubTitle')
            	fileViewTitle.innerHTML=fileName
            	fileViewSubTitle.innerHTML=''
            	fileInput.files=file
            	//alert(`已选择文件: ${fileName}`);
			//}else{
				//alert("仅允许上传5MB以内的文件")
			//}
			

        }else{
            alert(`仅允许上传.${suff1.innerText}文件`)
        }

        
    }
    
    

    
    // 取消按钮
    document.getElementById('cancel-btn').addEventListener('click', function() {
        if (confirm('确定要取消吗？已填写的内容将会丢失。')) {
            resetForm();
        }
    });
    
    // 重置表单
    function resetForm() {
        document.getElementById('homework-form').reset();
        // 重置文件输入
        fileInput.value = '';
    }
    
    
});

// 提交按钮

        
        
        // 提交
        // alert('作业提交成功！');
        // resetForm();
    $('#homework-form').on('submit', function(e) {
        // 阻止表单默认提交行为
        e.preventDefault();
        const studentSelect = document.getElementById('student-select');
        //const submitNotes = document.getElementById('submit-notes');
        
        // 验证
        if (!studentSelect.value) {
            alert('请选择学号姓名');
            return;
        }
        
        if (!fileInput.files || fileInput.files.length === 0) {
            alert('请选择要上传的文件');
            return;
        }
 
        // 弹出确认框
        if (confirm('姓名和学号：'+$('#student-select option:selected').text()+"\n请务必确认无误后再提交！\n\n请等待上传完成后再关闭页面。")) {
		//if (confirm('姓名和学号：'+$('#sel1 option:selected').val()+"\n请务必确认好！")) {
            // 如果确认，则继续提交表单
            $(this).unbind('submit').submit();
        }
    });

    
    