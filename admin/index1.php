<?php
//作废登录
setcookie("rand","",time()-3600);
setcookie("auth","",time()-3600);
setcookie("userName","",time()-3600);
?>
<html><head>
        <link rel="stylesheet" type="text/css" href="https://staticHost/dark.css">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>班级名单及应用平台</title>
		<link rel="icon" href="https://staticHost/wp-content/uploads/2022/12/cropped-cropped-GLLogo3-192x192.png" sizes="192x192">
        <style>
            
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
        
        </style>
    </head>
    <body>
        <div id="mainDiv">
        <h1>班级名单及应用平台</h1>
        <form action="./login.php" method="post"><div style="line-height:30px">
                <span><span class="red">*</span>用户名：</span>
                <input type="userName" name="userName" required="">
                
                
            </div>
            
            
                        
                        
                        <br><div style="line-height:30px">
                            <span><span class="red">*</span>密码：</span>
                            <input type="password" name="password" required="">
                                
                        
                        </div>
                        
                        

                        
                        <br>
                        
                        <br>
                        <button type="submit"> 登录 </button>
<br>
                    <div style="line-height:30px">
<br>
                        
    
    
    
</div>
                    </form>
        </div>
    


<script>


</script>

</body></html>
