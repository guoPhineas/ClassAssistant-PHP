<?php
//作废登录
setcookie("rand","",time()-3600);
setcookie("auth","",time()-3600);
//setcookie("userName","",time()-3600);
?>
<?php
if(isset($_COOKIE['userName'])){
$use=$_COOKIE['userName'];
}else{
$use="";
}
//echo $_COOKIE['userName'];
?>
<html lang="zh-CN"><head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>登录 - 班级名单及应用平台</title>
	<meta name="robots" content="noindex, nofollow, noarchive">
<link rel="stylesheet" id="dashicons-css" href="https://staticHost/wp-includes/css/dashicons.min.css?ver=6.5.5" media="all">
<link rel="stylesheet" id="buttons-css" href="https://staticHost/wp-includes/css/buttons.min.css?ver=6.5.5" media="all">
<link rel="stylesheet" id="forms-css" href="https://staticHost/wp-admin/css/forms.min.css?ver=6.5.5" media="all">
<link rel="stylesheet" id="l10n-css" href="https://staticHost/wp-admin/css/l10n.min.css?ver=6.5.5" media="all">
<link rel="stylesheet" id="login-css" href="https://staticHost/wp-admin/css/login.min.css?ver=6.5.5" media="all">
	<meta name="referrer" content="strict-origin-when-cross-origin">
		<meta name="viewport" content="width=device-width">
	<link rel="icon" href="https://staticHost/wp-content/uploads/2022/12/cropped-cropped-GLLogo3-32x32.png" sizes="32x32">
<link rel="icon" href="https://staticHost/wp-content/uploads/2022/12/cropped-cropped-GLLogo3-192x192.png" sizes="192x192">
<link rel="apple-touch-icon" href="https://staticHost/wp-content/uploads/2022/12/cropped-cropped-GLLogo3-180x180.png">
<meta name="msapplication-TileImage" content="https://staticHost/wp-content/uploads/2022/12/cropped-cropped-GLLogo3-270x270.png">
<style>
@media (prefers-color-scheme: dark) 
{
	body {
		background-color: #161616;
		color:white;
		
	}
	.login form{
		background-color: #292929;
		border: none;
	}
	}
</style>
	</head>
	<body class="login js login-action-login wp-core-ui  locale-zh-cn">
	<script src="https://staticHost/wp-includes/js/zxcvbn.min.js" type="text/javascript" async=""></script><script>
document.body.className = document.body.className.replace('no-js','js');
</script>

		<div id="login">
		<h1><a href="" style="background-image: url(https://staticHost/wp-content/uploads/2022/12/cropped-cropped-GLLogo3-192x192.png);
background-image: none,url(https://staticHost/wp-content/uploads/2022/12/cropped-cropped-GLLogo3-192x192.png);">班级名单及应用平台</a></h1>
	
		<form name="loginform" id="loginform" action="./login.php" method="post">
			<p>
				<label for="user_login">用户名</label>
				<input type="text" name="userName" id="user_login" class="input" value="<?php echo $use;?>" size="20" autocapitalize="off" autocomplete="username" required="required">
			</p>

			<div class="user-pass-wrap">
				<label for="user_pass">密码</label>
				<div class="wp-pwd">
					<input type="password" name="password" id="user_pass" class="input password-input" value="" size="20" autocomplete="current-password" spellcheck="false" required="required">
					<button type="button" class="button button-secondary wp-hide-pw hide-if-no-js" data-toggle="0" aria-label="显示密码">
						<span class="dashicons dashicons-visibility" aria-hidden="true"></span>
					</button>
				</div>
			</div>
						<!-- <p class="forgetmenot"><input name="rememberme" type="checkbox" id="rememberme" value="forever"> <label for="rememberme">记住我</label></p> -->
                        <p class="forgetmenot"><input name="rememberme" type="checkbox" id="rememberme" value="forever" checked disabled> <label for="rememberme">1小时内记住用户名</label></p>
			<p class="submit">
				<input type="submit" name="wp-submit" id="wp-submit" class="button button-primary button-large" value="登录">
			</p>
		</form>

					<p id="nav">
				 <a class="wp-login-lost-password" href="https://host/lark/login.html">-> 通过飞书登录（推荐）</a>			</p>
			<script>
function wp_attempt_focus() {setTimeout( function() {try {d = document.getElementById( "user_login" );d.focus(); d.select();} catch( er ) {}}, 200);}
wp_attempt_focus();
if ( typeof wpOnload === 'function' ) { wpOnload() }
</script>
		<p id="backtoblog">
			
			</div>
				<div class="language-switcher">
				
				</div>
				<script src="https://staticHost/wp-includes/js/jquery/jquery.min.js?ver=3.7.1" id="jquery-core-js"></script>
<script src="https://staticHost/wp-includes/js/jquery/jquery-migrate.min.js?ver=3.4.1" id="jquery-migrate-js"></script>
<script id="zxcvbn-async-js-extra">
var _zxcvbnSettings = {"src":"https:\/\/staticHost\/wp-includes\/js\/zxcvbn.min.js"};
</script>
<script src="https://staticHost/wp-includes/js/zxcvbn-async.min.js?ver=1.0" id="zxcvbn-async-js"></script>
<script src="https://staticHost/wp-includes/js/dist/vendor/wp-polyfill-inert.min.js?ver=3.1.2" id="wp-polyfill-inert-js"></script>
<script src="https://staticHost/wp-includes/js/dist/vendor/regenerator-runtime.min.js?ver=0.14.0" id="regenerator-runtime-js"></script>
<script src="https://staticHost/wp-includes/js/dist/vendor/wp-polyfill.min.js?ver=3.15.0" id="wp-polyfill-js"></script>
<script src="https://staticHost/wp-includes/js/dist/hooks.min.js?ver=2810c76e705dd1a53b18" id="wp-hooks-js"></script>
<script src="https://staticHost/wp-includes/js/dist/i18n.min.js?ver=5e580eb46a90c2b997e6" id="wp-i18n-js"></script>
<script id="wp-i18n-js-after">
wp.i18n.setLocaleData( { 'text direction\u0004ltr': [ 'ltr' ] } );
</script>
<script id="password-strength-meter-js-extra">
var pwsL10n = {"unknown":"\u5bc6\u7801\u5f3a\u5ea6\u672a\u77e5","short":"\u975e\u5e38\u5f31","bad":"\u5f31","good":"\u4e2d\u7b49","strong":"\u5f3a","mismatch":"\u4e0d\u5339\u914d"};
</script>
<script id="password-strength-meter-js-translations">
( function( domain, translations ) {
	var localeData = translations.locale_data[ domain ] || translations.locale_data.messages;
	localeData[""].domain = domain;
	wp.i18n.setLocaleData( localeData, domain );
} )( "default", {"translation-revision-date":"2024-06-03 15:01:22+0000","generator":"GlotPress\/4.0.1","domain":"messages","locale_data":{"messages":{"":{"domain":"messages","plural-forms":"nplurals=1; plural=0;","lang":"zh_CN"},"%1$s is deprecated since version %2$s! Use %3$s instead. Please consider writing more inclusive code.":["\u81ea %2$s \u7248\u5f00\u59cb\uff0c%1$s \u5df2\u7ecf\u6dd8\u6c70\uff0c\u8bf7\u6539\u7528 %3$s\u3002\u8bf7\u8003\u8651\u64b0\u5199\u66f4\u5177\u517c\u5bb9\u6027\u7684\u4ee3\u7801\u3002"]}},"comment":{"reference":"wp-admin\/js\/password-strength-meter.js"}} );
</script>
<script src="https://staticHost/wp-admin/js/password-strength-meter.min.js?ver=6.5.5" id="password-strength-meter-js"></script>
<script src="https://staticHost/wp-includes/js/underscore.min.js?ver=1.13.4" id="underscore-js"></script>
<script id="wp-util-js-extra">
var _wpUtilSettings = {"ajax":{"url":"\/wp-admin\/admin-ajax.php"}};
</script>
<script src="https://staticHost/wp-includes/js/wp-util.min.js?ver=6.5.5" id="wp-util-js"></script>
<script id="user-profile-js-extra">
var userProfileL10n = {"user_id":"0","nonce":"58b3c26fd7"};
</script>
<script id="user-profile-js-translations">
( function( domain, translations ) {
	var localeData = translations.locale_data[ domain ] || translations.locale_data.messages;
	localeData[""].domain = domain;
	wp.i18n.setLocaleData( localeData, domain );
} )( "default", {"translation-revision-date":"2024-06-03 15:01:22+0000","generator":"GlotPress\/4.0.1","domain":"messages","locale_data":{"messages":{"":{"domain":"messages","plural-forms":"nplurals=1; plural=0;","lang":"zh_CN"},"Your new password has not been saved.":["\u60a8\u7684\u65b0\u5bc6\u7801\u672a\u88ab\u4fdd\u5b58\u3002"],"Show":["\u663e\u793a"],"Confirm use of weak password":["\u786e\u8ba4\u4f7f\u7528\u5f31\u5bc6\u7801"],"Hide password":["\u9690\u85cf\u5bc6\u7801"],"Show password":["\u663e\u793a\u5bc6\u7801"],"Hide":["\u9690\u85cf"]}},"comment":{"reference":"wp-admin\/js\/user-profile.js"}} );
</script>
<script src="https://staticHost/wp-admin/js/user-profile.min.js?ver=6.5.5" id="user-profile-js"></script>
<script>
if (navigator.userAgent.includes('Lark')) {

document.body.innerHTML="<h1 align='center'>正在使用飞书登录，请稍后</h1>"
  const appId = 'client_id';
  var hostname = window.location.hostname;
  //alert("https://"+hostname+"/auth/callback")
  const redirectUri = encodeURIComponent("https://"+hostname+"/namelist/lark/auth/callback");
  
 // alert("https://open.feishu.cn/open-apis/authen/v1/index?client_id="+appId+"&redirect_uri="+redirectUri)
  window.location.href = "https://open.feishu.cn/open-apis/authen/v1/index?client_id="+appId+"&redirect_uri="+redirectUri+"&scope=contact:user.employee:readonly contact:user.employee_id:readonly";
}
</script>	
	
	</body></html>