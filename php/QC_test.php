<!DOCTYPE html>
<html ng-app>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name=viewport content="width=device-width, initial-scale=1">
<meta name=description content="">
<meta name=author content="">
<link rel=icon href="./image/logo2.png">
<title>品質管制系統</title>
<link href="../dist/css/bootstrap.min.css" rel=stylesheet>
<link href="../dist/jumbotron.css" rel=stylesheet> 

<script src="../dist/ie-emulation-modes-warning.js"></script> 

  <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/themes/hot-sneaks/jquery-ui.css" rel="stylesheet">	
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>

<nav class="navbar navbar-inverse navbar-fixed-top" role=navigation>
	<div class=container>
	<div class=navbar-header>
	<button type=button class="navbar-toggle collapsed" data-toggle=collapse data-target=#navbar aria-expanded=false aria-controls=navbar> 

		<span class=icon-bar></span> 
		<span class=icon-bar></span> 
		<span class=icon-bar></span> 
	</button> 
	<a class=navbar-brand href=#>品質管制系統</a>
	<a class=navbar-brand href=#>
	<?php echo @$USERNAME."先生/小姐 歡迎使用此系統";?></a>
</div>
</div>
</nav>
<meta name="robots" content="noindex">
<script src="../js/angular.min.js"></script>
</head>
<body>
<div class=jumbotron>
<div class=container>
<div class="row">
<div class="col-xs-6">
<?php
	$date =$_POST["date"];
	$MoId1 =$_POST["MoId1"];
	echo "日期:".$date;
	echo "<br>製令編號:".$MoId1."<br>";
    
	//get the MO(Manufacturing Order) Information
    //connect to the MSSQL database in localhost(IP:192.168.2.17)
	$conn = mssql_connect("192.168.2.17", "sa", "20265001");
    //select the database table and check if it exists or not
	if(!$conn)
		echo '連接伺服器失敗(Connection fail)<br>';
	//The below two lines is help to remove the error message
	$result = mssql_query("SET ANSI_NULLS ON") or die(mssql_get_last_message());
	$result = mssql_query("SET ANSI_WARNINGS ON") or die(mssql_get_last_message());
	
	//The query fot searching the specific database table
	$result=mssql_query(
	'SELECT [CMOID]
      ,[DOID]
      ,[SEQUENCE]
      ,[ITEMID]
      ,[QTY]
      ,[UNIT]
      ,[MO003]
      ,[MO004]
      ,[MO013]
      ,[MO014]
      ,[MO021]
      ,[MO022]
		FROM [ERPSOURCE].[SFT_HM2014].[dbo].[MODETAIL]
		WHERE [CMOID] LIKE "'.$MoId1.'"');
	
	while ($row = mssql_fetch_assoc ($result)) {
		echo "訂單編號：".$row["DOID"]."-".$row["SEQUENCE"]."<br>品號：".$row["ITEMID"]."<br>數量：".$row["QTY"]."  單位：".$row["UNIT"]."<br>品名：".iconv("big5","UTF-8",$row["MO021"])."<br>規格：".iconv("big5","UTF-8",$row["MO022"]);
	}
?>
</div></div></div></div>
<div class=container>
<div class="row">
  <!--<div ng-controller="MyCtrl">-->
    <form name="test_form" ng-submit="submit()"  method="post" action="../test.php">
	    <div class="row">
			<div class="col-xs-2">本批檢驗方式：</div>
			<div class="col-xs-4"><select name="QCtype" id="QCtype" tabindex=1>
				<option value="1">1:全檢</option>
				<option value="2">2:抽檢</option>
				<option value="3">3:巡檢</option>
				<option value="4">4:免驗</option>
			</select></div>
		</div>
		<div class="row">
			<div class="col-xs-2">抽樣數：</div>
			<div class="col-xs-8"><input id="SampleNumber" name="SampleNumber" type="number" style="ime-mode:disabled" onkeyup="return ValidateNumber(this,value)" maxlength="5" tabindex=2/></div>
		</div>
		<div class="row">
			<div class="col-xs-2">不良數：</div>
			<div class="col-xs-8"><input id="DefectNumber" name="DefectNumber"  type="number" style="ime-mode:disabled" onkeyup="return ValidateNumber(this,value)" maxlength="5" tabindex=3/></div>
		</div>
		<div class="row">
			<div class="col-xs-2">總數：</div>
			<div class="col-xs-8"><input id="Number" name="Number" type="number"  style="ime-mode:disabled" onkeyup="return ValidateNumber(this,value)"  maxlength="5" tabindex=4/></div>
		</div>

		<div class="row">
			<div class="col-xs-2">備註</div><div class="col-xs-10"><textarea id="Remark" rows="2" cols="40" maxlength="100" placeholder="異常原因補充(字數上限：255)" name="remark" tabindex=5></textarea></div>
		</div>
		<div class="row">
			<div class="col-xs-2">不良原因：</div>
			<div class="col-xs-4"><select name="input_name1" type="number">
			<option value=1 selected="selected">Defect_A</option>
　			<option value=2>Defect_B</option>
　			<option value=3>Defect_C</option>
　			<option value=4>Defect_D</option>
		</select></div>
			<div class="col-xs-2">數量：</div>
			<div class="col-xs-4"><input id="DefectNumber1" name="DefectNumber1" type="number"  style="ime-mode:disabled" onkeyup="return ValidateNumber(this,value)"  maxlength="5" tabindex=4/></div>
		</div>
		<div class="row">
			<div class="col-xs-2">不良原因：</div>
			<div class="col-xs-4"><select name="input_name2" type="number">
			<option value=1 selected="selected">Defect_A</option>
　			<option value=2>Defect_B</option>
　			<option value=3>Defect_C</option>
　			<option value=4>Defect_D</option>
		</select></div>
			<div class="col-xs-2">數量：</div>
			<div class="col-xs-4"><input id="DefectNumber2" name="DefectNumber2" type="number"  style="ime-mode:disabled" onkeyup="return ValidateNumber(this,value)"  maxlength="5" tabindex=4/></div>
		</div>
		<div class="row">
			<div class="col-xs-2">不良原因：</div>
			<div class="col-xs-4"><select name="input_name3" type="number">
			<option value=1 selected="selected">Defect_A</option>
　			<option value=2>Defect_B</option>
　			<option value=3>Defect_C</option>
　			<option value=4>Defect_D</option>
		</select></div>
			<div class="col-xs-2">數量：</div>
			<div class="col-xs-4"><input id="DefectNumber3" name="DefectNumber3" type="number"  style="ime-mode:disabled" onkeyup="return ValidateNumber(this,value)"  maxlength="5" tabindex=4/></div>
		</div>
		<div class="row">
			<div class="col-xs-2">不良原因：</div>
			<div class="col-xs-4"><select name="input_name4" type="number">
			<option value=1 selected="selected">Defect_A</option>
　			<option value=2>Defect_B</option>
　			<option value=3>Defect_C</option>
　			<option value=4>Defect_D</option>
		</select></div>
			<div class="col-xs-2">數量：</div>
			<div class="col-xs-4"><input id="DefectNumber4" name="DefectNumber4" type="number"  style="ime-mode:disabled" onkeyup="return ValidateNumber(this,value)"  maxlength="5" tabindex=4/></div>
		</div>
		<div class="row">
			<div class="col-xs-2"></div>
			<div class="col-xs-4"><button type="submit"  id="submitbutton" class="btn btn-success">送出</button></div>
		</div>
		</div>
<!--  
	  <ng-form ng-repeat="key in keys" name="keyForm">
        不良原因：<select name="input_name" type="number" ng-model="key.DefectCode" required>
			<option value=1 selected="selected">Defect_A</option>
　			<option value=2>Defect_B</option>
　			<option value=3>Defect_C</option>
　			<option value=4>Defect_D</option>
		</select>
        數量：<input type="number" name="input_age" ng-model="key.Number" required>
        <br>
      </ng-form>
	  <input type="button" value="+" name="點選新增不良原因" ng-click="addKey()"/> 
      <input type="submit" value="儲存"/>
	  
    </form>
    <br>  
    {{keys}}
<script language="javascipt">document.write($scope.keys.pop());</script>
  </div>  
</div></div>
<script>
function MyCtrl($scope){
	$scope.keys = [];
	$scope.keys.push({DefectCode:'1',Number:0});
	$scope.addKey = function () {
		$scope.keys.push({DefectCode:'',Number:null});
		i++;
	};
	$scope.submit = function () {
        console.log($scope.keys);
		document.test_form.input.value=$scope.keys;
    };

}
function Assign(){
	injectQC.phpvar.value=$scope.keys.pop();
}
</script>
-->
</body>
</html>