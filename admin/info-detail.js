// 管理信息详情页面专用脚本
document.addEventListener('DOMContentLoaded', function() {
    // 返回按钮点击事件
    document.getElementById('back-btn').addEventListener('click', function() {
        window.location.href = './admin.php';
    });
    
    // // 分页功能
    // const pageBtns = document.querySelectorAll('.page-btn:not(.prev-btn):not(.next-btn)');
    // const prevBtn = document.querySelector('.prev-btn');
    // const nextBtn = document.querySelector('.next-btn');
    
    // pageBtns.forEach(btn => {
    //     btn.addEventListener('click', function() {
    //         pageBtns.forEach(b => b.classList.remove('active'));
    //         this.classList.add('active');
            
    //         // 更新前后按钮状态
    //         prevBtn.disabled = this.textContent === '1';
    //     });
    // });
    
    // // 下一页按钮
    // nextBtn.addEventListener('click', function() {
    //     const activeBtn = document.querySelector('.page-btn.active');
    //     const nextSibling = activeBtn.nextElementSibling;
        
    //     if (nextSibling && nextSibling.classList.contains('page-btn') && !nextSibling.classList.contains('next-btn')) {
    //         activeBtn.classList.remove('active');
    //         nextSibling.classList.add('active');
    //         prevBtn.disabled = false;
    //     }
    // });
    
    // // 上一页按钮
    // prevBtn.addEventListener('click', function() {
    //     const activeBtn = document.querySelector('.page-btn.active');
    //     const prevSibling = activeBtn.previousElementSibling;
        
    //     if (prevSibling && prevSibling.classList.contains('page-btn') && !prevSibling.classList.contains('prev-btn')) {
    //         activeBtn.classList.remove('active');
    //         prevSibling.classList.add('active');
            
    //         if (prevSibling.textContent === '1') {
    //             prevBtn.disabled = true;
    //         }
    //     }
    // });
    
    // 筛选按钮
    // document.querySelector('.btn-filter').addEventListener('click', function() {
    //     alert('筛选功能将在这里实现');
    // });
});
    