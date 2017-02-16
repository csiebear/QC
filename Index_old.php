<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" rev="stylesheet" href="css/login.css" />
<title>品質管制系統</title>
<script src="js/jquery-1.2.6.min.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
<script type="text/javascript">
$(document).ready(function()
{
	$("#login_form input:first").focus();
});
</script>
</head>
<body>
<h1>品質管制系統</h1>

<form action="php/login.php" method="post"  accept-charset="utf-8"><div id="container">
	<div id="top">
	登入	</div>
	<div id="login_form">
		<div id="welcome_message">
		歡迎使用品質管制系統。請輸入您的帳號和密碼進行登入。</div>
		<div class="form_field_label">帳號: </div>
		<div class="form_field">
		<input type="text" name="account" value="" size="20"  /></div>

		<div class="form_field_label">密碼: </div>
		<div class="form_field">
		<input type="password" name="password" value="" size="20"  />		
		</div>		
		<div id="submit_button">
		<input type="submit" name="loginButton" value="登入"  />		</div>
	</div>
</div>
</form>
<div style="text-align:center;"><footer style="text-align:center;bottom:0;position: absolute;">Copyright &copy; Hwa Meei Optical Co., Ltd. All rights reserved.Design by <a href="https://github.com/csiebear">ShouHsuanLi</a></footer></div>
</body>
</html>
