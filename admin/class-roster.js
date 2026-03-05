// 班级花名册页面专用脚本
document.addEventListener('DOMContentLoaded', function() {
    // 返回按钮点击事件
    document.getElementById('back-btn').addEventListener('click', function() {
        window.location.href = '../admin/admin.php';
    });
    
    // 获取DOM元素
    const studentItems = document.querySelectorAll('.student-item');
    const checkboxes = document.querySelectorAll('.student-check');
    const selectAllBtn = document.getElementById('select-all');
    const resetAllBtn = document.getElementById('reset-all');
    const showResultBtn = document.getElementById('show-result');
    const presentCountEl = document.getElementById('present-count');
    const absentCountEl = document.getElementById('absent-count');
    const leaveCountEl = document.getElementById('leave-count');
    
    // 学生项点击事件 - 点名功能
    studentItems.forEach(item => {
        item.addEventListener('click', function(e) {
            // 如果点击的是复选框，不触发此事件（由复选框自己处理）
            if (e.target.type === 'checkbox') return;
            
            const checkbox = this.querySelector('.student-check');
            const statusBadge = this.querySelector('.student-status');
            
            // 切换复选框状态
            checkbox.checked = !checkbox.checked;
            
            // 更新样式和状态文本
            updateStudentStatus(this, checkbox.checked);
            
            // 更新统计
            updateRosterStats();
        });
        
        // 复选框单独处理
        const checkbox = item.querySelector('.student-check');
        checkbox.addEventListener('change', function() {
            updateStudentStatus(item, this.checked);
            updateRosterStats();
        });
    });
    
    // 全选按钮
    selectAllBtn.addEventListener('click', function() {
        studentItems.forEach(item => {
            const checkbox = item.querySelector('.student-check');
            // 跳过请假状态的学生
            const statusBadge = item.querySelector('.student-status');
            if (!statusBadge.classList.contains('status-warning')) {
                checkbox.checked = true;
                updateStudentStatus(item, true);
            }
        });
        updateRosterStats();
    });
    
    // 重置按钮
    resetAllBtn.addEventListener('click', function() {
        studentItems.forEach(item => {
            const checkbox = item.querySelector('.student-check');
            checkbox.checked = false;
            updateStudentStatus(item, false);
        });
        updateRosterStats();
    });
    
    // 未点名按钮
    showResultBtn.addEventListener('click', function() {
        //alert('点名结果');
        var namelistsNot="未点名：\n";
        $('.nameCheck:not(:checked)').each(function() {
            var name = $(this).attr('name');
        namelistsNot=namelistsNot+name+"\n"
            //console.log(name); // 输出每个选中复选框的name属性值
        });
        alert(namelistsNot)
    });
    
    // 更新学生状态样式
    function updateStudentStatus(item, isPresent) {
        const statusBadge = item.querySelector('.student-status');
        
        // 移除所有状态类
        statusBadge.classList.remove('status-success', 'status-default', 'status-warning');
        item.classList.remove('student-present', 'student-absent', 'student-leave');
        
        if (isPresent) {
            // 已到状态
            statusBadge.classList.add('status-success');
            statusBadge.textContent = '已到';
            item.classList.add('student-present');
        } else {
            // 未到状态
            statusBadge.classList.add('status-default');
            statusBadge.textContent = '未到';
            item.classList.add('student-absent');
        }
    }
    
    // 更新花名册统计
    function updateRosterStats() {
        let present = 0;
        let absent = 0;
        let leave = 0;
        
        studentItems.forEach(item => {
            const checkbox = item.querySelector('.student-check');
            const statusBadge = item.querySelector('.student-status');
            
            if (statusBadge.classList.contains('status-warning')) {
                leave++;
            } else if (checkbox.checked) {
                present++;
            } else {
                absent++;
            }
        });
        
        presentCountEl.textContent = present;
        absentCountEl.textContent = absent;
        leaveCountEl.textContent = leave;
    }
    updateRosterStats();
    var total_count=document.getElementById('total-count');
    total_count.innerHTML=studentItems.length
});
    