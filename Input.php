<!--測試環境沒有登入資料驗證，故cookie先行不啟用>
<?php
	if (isset($_COOKIE["name"]))
		$name=$_COOKIE["name"];
	else 
		echo "<script type='text/javascript'>window.location.href='http://192.168.2.17/QC/Index.html'</script>";
?>
-->
<!--本網頁撰寫者為李碩軒(https://github.com/csiebear)，切勿於尚未告知情況下挪用-->
<!--網頁樣板修改自BootStrap：https://kkbruce.tw/bs3/Examples/jumbotron-->
<!DOCTYPE html>
<html lang="zh-TW">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name=viewport content="width=device-width, initial-scale=1">
<meta name=description content="">
<meta name=author content="">
<link rel="icon" href="./img/logo2.png">
<title>品質管制記錄</title>
<link href="dist/css/bootstrap.min.css" rel=stylesheet>
<link href="dist/jumbotron.css" rel=stylesheet> 
<!--[if lt IE 9]><script src=~/Scripts/AssetsBS3/ie8-responsive-file-warning.js></script><![endif]-->
<script src="dist/ie-emulation-modes-warning.js"</script> 
<!--[if lt IE 9]><script src=https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js></script><script src=https://oss.maxcdn.com/respond/1.4.2/respond.min.js></script><![endif]-->
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/themes/hot-sneaks/jquery-ui.css" rel="stylesheet">	
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
<style type="text/css">
p,h1,h2,label,input,div{
	font-family:微軟正黑體;
	font-weight:bold;
	color: 	#5B5B5B;
}
h1{
	font-size:26px;
}
body {
	background-color:#F0F0F0;
}
div {
    border-color:  	#921AFF;
}
input{
	border-radius:3px
}
</style>
</head>
<nav class="navbar navbar-inverse navbar-fixed-top" role=navigation>
	<div class=container>
	<div class=navbar-header>
	<button type=button class="navbar-toggle collapsed" data-toggle=collapse data-target=#navbar aria-expanded=false aria-controls=navbar> 

		<span class=icon-bar></span> 
		<span class=icon-bar></span> 
		<span class=icon-bar></span> 
	</button> 
	<a class=navbar-brand>品質管制系統</a>
	<a class=navbar-brand>
	<?php 
		//echo $name." 先生/小姐 歡迎使用此系統</a>";
		echo "<a class=navbar-brand><form method=\"post\" action=\"./php/logout.php\"><button class=\"btn btn-success\" >登出</button></form></a>";
	?>
</div>
</div>
</nav>
<script language="JavaScript">
		function FormCheck()
        {
				if(injectQC.MoId1.value == "" || injectQC.MoId2.value=="") 
                {
                    confirm("製造命令資料不可為空");
					return false;
				}
                else 
					return true;
        }
</script>
</head>
<body>
<!--<div class=jumbotron><div class=container>
<div class="row">
	<div class="col-xs-3"></div><div class="col-xs-6"><img src="./img/QC_flow.png" width="600px"></div><div class="col-xs-3"></div>
	<div class="col-xs-3"></div><div class="col-xs-6"><B>品質檢驗資料登記，使用方式</B>
	<li>Step1：掃描途程單上資訊</li>
	<li>Step2：依照網頁頁面要求填寫欄位，並進行確認</li>
	<li>Step3：送出資料，完成登記</li></div><div class="col-xs-3"></div>
</div>
</div></div>-->
<div class="container">
<div class="row">
<h2 style="font-family:Microsoft JhengHei;">檢驗記錄查詢</h2>
<input type="button" class="btn btn-primary" value="查詢" action="local.href=''">

<h2 style="font-family:Microsoft JhengHei;">檢驗資料填寫</h2>
<table border="1" width="1000px"><tr><td>
<form name="injectQC"  method="post" action="php/QC.php" onSubmit="return FormCheck();">
		<div class="row"><B>
		<div class="col-xs-2"></div><div class="col-xs-2"><p style="font-family:Microsoft JhengHei;">檢驗日期：</p></div>

			<div class="col-xs-4">
			<input type="hidden" name="date" value="2016-12-23"/>
				<script language="javascript">
				function SystemTime(){
					//var Today=new Date();
					//reference from:http://stackoverflow.com/questions/3066586/get-string-in-yyyymmdd-format-from-js-date-object
					var Today=new Date(Date.now()-(new Date()).getTimezoneOffset() * 60000).toISOString().slice(0, 19).replace(/[^0-9]/g, "-");
					//document.write(Today.getFullYear()+"-"+(Today.getMonth()+1)+"-"+Today.getDate()+" "+Today.getHours()+":");
					document.write("<p  style='font-family:Microsoft JhengHei;'>"+Today+"</p>");
					};
					SystemTime();
				</script>
			</div>
			<div class="col-xs-4" style="font-family:Microsoft JhengHei;">自動帶入目前系統日期與時間</div>
		</div>
		<div class="row">
		<script>
			window.onload = function() {
				document.getElementById('MoId1').focus();
			}
		</script> 
			<div class="col-xs-2"></div><div class="col-xs-2"><p style="font-family:Microsoft JhengHei;">製令編號：</p></div><div class="col-xs-4"><input id="MoId1" name="MoId1"  type="text" maxlength="21" placeholder="5171-20161227001" autofocus /></div>
			<div class="col-xs-3" style="font-family:Microsoft JhengHei;">請以條碼機輸入製令編號</div>
		</div>			
</td></tr></table>
		<div class="row"><div class="col-xs-2"><br></div></div>
		<div class="row">
			<div class="col-xs-4"></div>
			<div class="col-xs-2"><button type="reset" class="btn btn-primary">重置</button></div>
			<div class="col-xs-2"><button type="submit" id="submitbutton" value="送出" class="btn btn-success">送出</button></div>
		</div>
	</form>
</div>
</div>
</div>
</div>
<footer style="bottom:0;position: absolute;">Copyright &copy; Hwa Meei Optical Co., Ltd. All rights reserved.Design by <a href="https://github.com/csiebear">ShouHsuanLi</a></footer>
</body>
<script src=dist/jquery.min.js></script>
<script src=dist/js/bootstrap.min.js></script>
<script src=dist/ie10-viewport-bug-workaround.js></script>
</html>