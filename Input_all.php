<?php
	$USERNAME=$_POST["username"];
	$PASSWORD=$_POST["password"];;
?>
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
<link rel=icon href="./image/logo2.png">
<title>品質檢驗記錄</title>
<link href="dist/css/bootstrap.min.css" rel=stylesheet>
<link href="dist/jumbotron.css" rel=stylesheet> 
<!--[if lt IE 9]><script src=~/Scripts/AssetsBS3/ie8-responsive-file-warning.js></script><![endif]-->
<script src=dist/ie-emulation-modes-warning.js></script> 
<!--[if lt IE 9]><script src=https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js></script><script src=https://oss.maxcdn.com/respond/1.4.2/respond.min.js></script><![endif]-->
  <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/themes/hot-sneaks/jquery-ui.css" rel="stylesheet">	
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
  <script type="text/javascript" src="http://192.168.2.17/jQuery/jquery.ui.datepicker-zh-TW.js"></script>
  <style type="text/css">
	ul, li {
		margin: 0;
		padding: 0;
		list-style: none;
	}
	.abgne_tab {
		clear: left;
		width: 100%;
		margin: 10px 0;
	}
	ul.tabs {
		width: 100%;
		height: 32px;
		border-bottom: 1px solid #999;
		border-left: 1px solid #999;
	}
	ul.tabs li {
		float: left;
		height: 31px;
		line-height: 31px;
		overflow: hidden;
		position: relative;
		margin-bottom: -1px;	/* 讓 li 往下移來遮住 ul 的部份 border-bottom */
		border: 1px solid #999;
		border-left: none;
		background: #e1e1e1;
	}
	ul.tabs li a {
		display: block;
		padding: 0 20px;
		color: #000;
		border: 1px solid #fff;
		text-decoration: none;
	}
	ul.tabs li a:hover {
		background: #ccc;
	}
	ul.tabs li.active  {
		background: #fff;
		border-bottom: 1px solid #fff;
	}
	ul.tabs li.active a:hover {
		background: #fff;
	}
	div.tab_container {
		clear: left;
		width: 100%;
		border: 1px solid #999;
		border-top: none;
		background: #fff;
	}
	div.tab_container .tab_content {
		padding: 20px;
	}
	div.tab_container .tab_content h2 {
		margin: 0 0 20px;
	}

</style>
<nav class="navbar navbar-inverse navbar-fixed-top" role=navigation>
	<div class=container>
	<div class=navbar-header>
	<button type=button class="navbar-toggle collapsed" data-toggle=collapse data-target=#navbar aria-expanded=false aria-controls=navbar> 

		<span class=icon-bar></span> 
		<span class=icon-bar></span> 
		<span class=icon-bar></span> 
	</button> 
	<a class=navbar-brand href=#>品質檢驗系統</a>
	<a class=navbar-brand href=#>
	<?php echo @$USERNAME."先生/小姐 歡迎使用此系統";?></a>
</div>
</div>
</nav>
<script type="text/javascript">
	$(function(){
		// 預設顯示第一個 Tab
		var _showTab = 0;
		$('.abgne_tab').each(function(){
			// 目前的頁籤區塊
			var $tab = $(this);

			var $defaultLi = $('ul.tabs li', $tab).eq(_showTab).addClass('active');
			$($defaultLi.find('a').attr('href')).siblings().hide();
			
			// 當 li 頁籤被點擊時...
			// 若要改成滑鼠移到 li 頁籤就切換時, 把 click 改成 mouseover
			$('ul.tabs li', $tab).click(function() {
				// 找出 li 中的超連結 href(#id)
				var $this = $(this),
					_clickTab = $this.find('a').attr('href');
				// 把目前點擊到的 li 頁籤加上 .active
				// 並把兄弟元素中有 .active 的都移除 class
				$this.addClass('active').siblings('.active').removeClass('active');
				// 淡入相對應的內容並隱藏兄弟元素
				$(_clickTab).stop(false, true).fadeIn().siblings().hide();

				return false;
			}).find('a').focus(function(){
				this.blur();
			});
		});
	});
	
</script>
</head>
<body>
<div class=jumbotron><div class=container>
<div class="row"><img src="./img/QC_flow.png"></div>
<B>品質檢驗資料登記，使用方式</B>
<li>Step1：選定檢驗製程站</li>
<li>Step2：依照需求欄位填寫，並進行確認</li>
<li>Step3：送出資料，完成登記</li>

</div></div>
<div class="container">
<div class="row">
	<div class="col-xs-1"></div>
	<div class="col-xs-10">
  	<div class="abgne_tab">
		<ul class="tabs">
			<li><a href="#tab1">射出</a></li>
			<li><a href="#tab2">噴漆</a></li>
			<li><a href="#tab3">射包</a></li>
			<li><a href="#tab4">配件</a></li>
			<li><a href="#tab5">組裝</a></li>
			<li><a href="#tab6">鏡片</a></li>
			<li><a href="#tab7">齊料</a></li>
			<li><a href="#tab8">最終檢驗</a></li>
		</ul>

	<div class="tab_container">
		<div id="tab1" class="tab_content">
		<h2>射出檢驗</h2>
		<p>於射出完成後，進行檢驗，記錄各訂單對應製造命令所製作之品項，進行品質檢驗。檢驗規則請參考作業指導書。</p>
<B>		<div class="container">
	<form name="injectQC" method="post" action="php/QC.php" onSubmit="return FormCheck();">
		<div class="row">
			<div class="col-xs-2">檢驗日期：</div>

			<div class="col-xs-4">
				<input id="datepicker1" name="date" type="date" placeholder="YYYY-MM-DD"/>
				<?php 
					$agent = $_SERVER['HTTP_USER_AGENT'];
					if(!strpos($agent,"Chrome")){
						echo "
						<script language=\"JavaScript\">
							$(document).ready(function(){ 
							$(\"#datepicker1\").datepicker({showWeek: true,dafaultDate: new Date(),minDate: \"-1m\", maxDate: new Date()});
						});
						</script>";
					}
				?>
				</div>
				<div class="col-xs-2">預設為系統日期
			</div>
		</div>
		<div class="row">
			<div class="col-xs-2">訂單單別：</div><div class="col-xs-4"><input id="orderId1" name="OrderId1"  type="string" maxlength="4"/></div><div class="col-xs-2"><div id="msg1">訂單單別至多4碼</div></div>
		</div>
		<div class="row">
			<div class="col-xs-2">訂單單號：</div><div class="col-xs-8"><input id="orderId2" name="OrderId2"  type="string" maxlength="11"/></div>
		</div>
		<div class="row">
			<div class="col-xs-2">訂單序號：</div><div class="col-xs-8"><input id="orderId3" name="OrderId3"  type="string" maxlength="4"/></div>
		</div>
		<div class="row">
			<div class="col-xs-2">製令單別：</div><div class="col-xs-8"><input id="MoId1" name="MoId1"  type="string" maxlength="4"/></div>
		</div>
		<div class="row">
			<div class="col-xs-2">製令單號：</div><div class="col-xs-8"><input id="MoId2" name="MoId2"  type="string" maxlength="11"/></div>
		</div>
		<div class="row">
			<div class="col-xs-12">==========================================================</div>
		</div>
		<div class="row">
			<div class="col-xs-2">檢驗人員：</div>
			<div class="col-xs-8"><input id="QCPerson" name="QCPerson" type="string" maxlength="3"/></div>
		</div>
		
		<div class="row">
			<div class="col-xs-2">抽樣數：</div>
			<div class="col-xs-8"><input id="SampleNumber" name="SampleNumber" type="number" style="ime-mode:disabled" onkeyup="return ValidateNumber(this,value)" maxlength="5"/></div>
		</div>
		<div class="row">
			<div class="col-xs-2">不良數：</div>
			<div class="col-xs-8"><input id="DefectNumber" name="DefectNumber"  type="number" style="ime-mode:disabled" onkeyup="return ValidateNumber(this,value)" maxlength="5"/></div>
		</div>
		<div class="row">
			<div class="col-xs-2">總數：</div>
			<div class="col-xs-8"><input id="Number" name="Number" style="ime-mode:disabled" onkeyup="return ValidateNumber(this,value)" type="number" maxlength="5"/></div>
		</div>

		<div class="row">
			<div class="col-xs-2">備註</div><div class="col-xs-10"><textarea rows="6" cols="25" maxlength="100" placeholder="異常原因補充(字數上限：100)" name="remark" ></textarea></div>
		</div>
		<div class="row"><div class="col-xs-2"><br></div></div>
		<div class="row">
			<div class="col-xs-2"></div>
			<div class="col-xs-2"><button type="button" id="button1" class="btn btn-primary" onclick="check();">資料檢驗</button></div>
			<div class="col-xs-2"><button type="reset" class="btn btn-primary">重置</button></div>
			<div class="col-xs-2"><button type="submit" id="submitbutton" value="送出" class="btn btn-success">送出</button></div>
		</div>
	</form>	
		
		</div>
		<script language="JavaScript">
			function check(){
				var CheckResult="None";
			if( injectQC.SampleNumber.value==0 || injectQC.QCNumber.value==0){
			CheckResult="抽樣數量與總數不可為0";}
			else if (injectQC.SampleNumber.value==injectQC.Number.value)
				CheckResult="全檢";
			else
				CheckResult="抽檢";
				
				alert("檢驗日期："+injectQC.date.value+"\n訂單編號："+injectQC.OrderId1.value+"-"+injectQC.OrderId2.value+"-"+injectQC.OrderId3.value+"\n檢驗方式："+CheckResult);
			}
			//reference from:http://demo.tc/post/617
		function ValidateNumber(e, pnumber)
		{
			if (!/^\d+$/.test(pnumber)){
				var newValue =/^\d+/.exec(e.value);         
				if (newValue != null)          
					e.value = newValue;         
				else          
					e.value = "";    
			}
			return false;
		}
		function FormCheck()
        {
				if(injectQC.date.value==""){
                    confirm("請輸入正確日期");
					return false;					
				}
                <!-- 若<form>屬性name為injectQC的OrderId1,2,3皆不可為空，否則顯示提醒訂單資料不可為空-->
                else if(injectQC.orderId1.value == "" || injectQC.orderId2.value == "" || injectQC.orderId3.value == "") 
                {
                    confirm("訂單資料不可為空");
					return false;
                }
				<!-- 若<form>屬性name為injectQC的MoId1,2,3皆不可為空，否則顯示提醒製造命令資料不可為空-->
				else if(injectQC.MoId1.value == "" || injectQC.MoId2.value=="") 
                {
                    confirm("製造命令資料不可為空");
					return false;
                }
				<!-- 抽樣的數量，不可以大於送驗總數，不良品的數量不可以大於檢驗數量-->
				else if(injectQC.Number.value < injectQC.SampleNumber.value) 
                {
                    confirm("檢驗數不可大於送檢量");
					return false;
                }
				else if(injectQC.SampleNumber.value < injectQC.DefectNumber.value)
				{
                    confirm("不良數不可大於檢驗數");
					return false;					
				}
                else return true;
        }
		</script>
		</div>
</B>			

		<div id="tab2" class="tab_content">
				<h2>噴漆檢驗</h2>
				<p>噴漆檢驗人員請依照下述指示與作業指導書撰寫SOP(標準作業流程)填寫下表。本表單由湯仕敬 專員 設計</p>
		<form name="injectQC" method="post" action="php/QC.php" onSubmit="return FormCheck();">
		<div class="row">
<B>
		<div class="col-xs-2">檢驗日期：</div>

			<div class="col-xs-4">
				<script language="javascript">
				function SystemTime(){
					//var Today=new Date();
					//reference from:http://stackoverflow.com/questions/3066586/get-string-in-yyyymmdd-format-from-js-date-object
					var Today=new Date(Date.now()-(new Date()).getTimezoneOffset() * 60000).toISOString().slice(0, 19).replace(/[^0-9]/g, "-");
					//document.write(Today.getFullYear()+"-"+(Today.getMonth()+1)+"-"+Today.getDate()+" "+Today.getHours()+":");
					document.write(Today);
					};
					SystemTime();</script>
			</div>
			<div class="col-xs-3">自動帶入目前系統日期與時間</div>
		</div>
		<div class="row">
			<div class="col-xs-2">製令單：</div><div class="col-xs-4"><input id="MoId1" name="Mo"  type="string" maxlength="21"/></div>
			<div class="col-xs-3">請以條碼機輸入製令單號-單別</div>
		</div>
		<div class="row">
			<div class="col-xs-2">檢驗人員：</div>
			<div class="col-xs-4"><input id="QCPerson" name="QCPerson" type="string" maxlength="3"/></div>
			<div class="col-xs-3">請以條碼機輸入檢驗人員工號</div>
		</div>
		
		<div class="row">
			<div class="col-xs-2">本批檢驗方式：</div>
			<div class="col-xs-4"><select name="QCtype" id="QCtype">
				<option value="1">1:全檢</option>
				<option value="2">2:抽檢</option>
				<option value="3">3:巡檢</option>
				<option value="4">4:免驗</option>
			</select></div>
		</div>
		<div class="row">
			<div class="col-xs-2">抽樣數：</div>
			<div class="col-xs-8"><input id="SampleNumber" name="SampleNumber" type="number" style="ime-mode:disabled" onkeyup="return ValidateNumber(this,value)" maxlength="5"/></div>
		</div>
		<div class="row">
			<div class="col-xs-2">不良數：</div>
			<div class="col-xs-8"><input id="DefectNumber" name="DefectNumber"  type="number" style="ime-mode:disabled" onkeyup="return ValidateNumber(this,value)" maxlength="5"/></div>
		</div>
		<div class="row">
			<div class="col-xs-2">總數：</div>
			<div class="col-xs-8"><input id="Number" name="Number" style="ime-mode:disabled" onkeyup="return ValidateNumber(this,value)" type="number" maxlength="5"/></div>
		</div>

		<div class="row">
			<div class="col-xs-2">備註</div><div class="col-xs-10"><textarea rows="2" cols="40" maxlength="100" placeholder="異常原因補充(字數上限：100)" name="remark" ></textarea></div>
		</div>
</B>
		<div class="row"><div class="col-xs-2"><br></div></div>
		<div class="row">
			<div class="col-xs-2"></div>
			<div class="col-xs-2"><button type="button" id="button1" class="btn btn-primary" onclick="check();">資料檢驗</button></div>
			<div class="col-xs-2"><button type="reset" class="btn btn-primary">重置</button></div>
			<div class="col-xs-2"><button type="submit" id="submitbutton" value="送出" class="btn btn-success">送出</button></div>
		</div>
	</form>	
			</div>
			<div id="tab3" class="tab_content">
				<h2>成品倉檢驗</h2>
				<p>於成品倉庫檢驗最終成品合格數量，並登記成品不良品的缺失原因，檢驗規則請參考作業指導書。</p>
			</div>
			<div id="tab4" class="tab_content">
				<h2>成品倉檢驗</h2>
				<p>於成品倉庫檢驗最終成品合格數量，並登記成品不良品的缺失原因，檢驗規則請參考作業指導書。</p>
			</div>
			<div id="tab5" class="tab_content">
				<h2>成品倉檢驗</h2>
				<p>於成品倉庫檢驗最終成品合格數量，並登記成品不良品的缺失原因，檢驗規則請參考作業指導書。</p>
			</div>
			<div id="tab6" class="tab_content">
				<h2>成品倉檢驗</h2>
				<p>於成品倉庫檢驗最終成品合格數量，並登記成品不良品的缺失原因，檢驗規則請參考作業指導書。</p>
			</div>
			<div id="tab7" class="tab_content">
				<h2>成品倉檢驗</h2>
				<p>於成品倉庫檢驗最終成品合格數量，並登記成品不良品的缺失原因，檢驗規則請參考作業指導書。</p>
			</div>
			<div id="tab8" class="tab_content">
				<h2>最終(成品倉)檢驗</h2>
				<p>於成品倉庫檢驗最終成品合格數量，並登記成品不良品的缺失原因，檢驗規則請參考作業指導書。</p>
	<form name="injectQC" method="post" action="php/QC.php" onSubmit="return FormCheck();">
		<div class="row">
			<div class="col-xs-2">檢驗日期：</div>

			<div class="col-xs-4">
				<input id="datepicker1" name="date" type="date" placeholder="YYYY-MM-DD"/>
				<?php 
					$agent = $_SERVER['HTTP_USER_AGENT'];
					if(!strpos($agent,"Chrome")){
						echo "
						<script language=\"JavaScript\">
							$(document).ready(function(){ 
							$(\"#datepicker1\").datepicker({showWeek: true,dafaultDate: new Date(),minDate: \"-1m\", maxDate: new Date()});
						});
						</script>";
					}
				?>
				</div>
				<div class="col-xs-2">預設為系統日期
			</div>
		</div>
		<div class="row">
			<div class="col-xs-2">訂單單別：</div><div class="col-xs-4"><input id="orderId1" name="OrderId1"  type="string" maxlength="4"/></div><div class="col-xs-2"><div id="msg1">訂單單別至多4碼</div></div>
		</div>
		<div class="row">
			<div class="col-xs-2">訂單單號：</div><div class="col-xs-8"><input id="orderId2" name="OrderId2"  type="string" maxlength="11"/></div>
		</div>
		<div class="row">
			<div class="col-xs-2">訂單序號：</div><div class="col-xs-8"><input id="orderId3" name="OrderId3"  type="string" maxlength="4"/></div>
		</div>
		<div class="row">
			<div class="col-xs-2">製令單別：</div><div class="col-xs-8"><input id="MoId1" name="MoId1"  type="string" maxlength="4"/></div>
		</div>
		<div class="row">
			<div class="col-xs-2">製令單號：</div><div class="col-xs-8"><input id="MoId2" name="MoId2"  type="string" maxlength="11"/></div>
		</div>
		<div class="row">
			<div class="col-xs-12">==========================================================</div>
		</div>
		<div class="row">
			<div class="col-xs-2">檢驗人員：</div>
			<div class="col-xs-8"><input id="QCPerson" name="QCPerson" type="string" maxlength="3"/></div>
		</div>
		
		<div class="row">
			<div class="col-xs-2">抽樣數：</div>
			<div class="col-xs-8"><input id="SampleNumber" name="SampleNumber" type="number" style="ime-mode:disabled" onkeyup="return ValidateNumber(this,value)" maxlength="5"/></div>
		</div>
		<div class="row">
			<div class="col-xs-2">不良數：</div>
			<div class="col-xs-8"><input id="DefectNumber" name="DefectNumber"  type="number" style="ime-mode:disabled" onkeyup="return ValidateNumber(this,value)" maxlength="5"/></div>
		</div>
		<div class="row">
			<div class="col-xs-2">總數：</div>
			<div class="col-xs-8"><input id="Number" name="Number" style="ime-mode:disabled" onkeyup="return ValidateNumber(this,value)" type="number" maxlength="5"/></div>
		</div>

		<div class="row">
			<div class="col-xs-2">備註</div><div class="col-xs-10"><textarea rows="6" cols="25" maxlength="100" placeholder="異常原因補充(字數上限：100)" name="remark" ></textarea></div>
		</div>
		<div class="row"><div class="col-xs-2"><br></div></div>
		<div class="row">
			<div class="col-xs-2"></div>
			<div class="col-xs-2"><button type="button" id="button1" class="btn btn-primary" onclick="check();">資料檢驗</button></div>
			<div class="col-xs-2"><button type="reset" class="btn btn-primary">重置</button></div>
			<div class="col-xs-2"><button type="submit" id="submitbutton" value="送出" class="btn btn-success">送出</button></div>
		</div>
	</form>	
			</div>
			</div>
	</div>
</div>
</div>
</div>
</body>
</html>

</div>
<div><footer><p> Copyright &copy; Hwa Meei Optical Co., Ltd. All rights reserved.Design by <a href="https://github.com/csiebear">ShouHsuanLi</a></footer></div>
<script src=dist/jquery.min.js></script>
<script src=dist/js/bootstrap.min.js></script>
<script src=dist/ie10-viewport-bug-workaround.js></script>