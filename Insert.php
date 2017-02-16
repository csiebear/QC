<?php
	if (isset($_COOKIE["name"]))
		$name=$_COOKIE["name"];
	else 
		echo "<script type='text/javascript'>window.location.href='http://192.168.2.17/QC/Index.php'</script>";
?>
<!--本網頁撰寫者為李碩軒(https://github.com/csiebear)，切勿於尚未告知情況下挪用-->
<!--網頁樣板修改自BootStrap：https://kkbruce.tw/bs3/Examples/jumbotron-->
<!DOCTYPE html>
<html lang="zh-TW">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name=viewport content="width=device-width, initial-scale=1">
<link rel="icon" href="./img/logo2.png">
<title>品質管制記錄</title>
<link href="./dist/css/bootstrap.min.css" rel=stylesheet>
<link href="./dist/jumbotron.css" rel=stylesheet> 
	<style>
	table{text-align:center;background:#CCEEFF;}
	tr{vertical-align:middle;}
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
	<a class=navbar-brand href=#>品質管制系統</a>
	<a class=navbar-brand href=#>
	<?php 
		echo $name." 先生/小姐 歡迎使用此系統</a>";
		echo "<a class=navbar-brand><form method=\"post\" action=\"./php/logout.php\"><button class=\"btn btn-success\" >登出</button></form></a>";
	?>
</div>
</div>
</nav>
<div class="jumbotron">
<div class="container">
<div class="row">
<?php
	//Using the POST method to get data
	$time=date('Y-m-d H:m:s');
	$day=date('Ymd');
	$Moid=$_POST["Moid"];
	$TA004=$_POST["TA004"];
	$TA005=$_POST["TA005"];
	$Station=$_POST["Station"];
	$User=$_POST["User"];
	$QCtype=$_POST["QCtype"];
	$SampleNumber=$_POST["SampleNumber"];
	$DefectNumber=$_POST["DefectNumber"];
	$Number=$_POST["Number"];
	$Remark=$_POST["Remark"];
	$Item=$_POST["Item"];
	$ItemName=$_POST["ItemName"];
	$Spec=$_POST["Spec"];
	$ProcessID=$_POST["ProcessID"];
	
	$conn = mssql_connect("192.168.2.17", "sa", "20265001");
    //select the database table and check if it exists or not
	if(!$conn)
		echo '連接伺服器失敗(Connection fail)<br>';
	//The below two lines is help to remove the error message
	$result = mssql_query("SET ANSI_NULLS ON") or die(mssql_get_last_message());
	$result = mssql_query("SET ANSI_WARNINGS ON") or die(mssql_get_last_message());
	$result=mssql_query(
			'SELECT
			SFT_OP_REALRUN.ERP_OPID, SFT_OP_REALRUN.ERP_WSID
			FROM
				[ERPSOURCE].[SFT_HM2014].[dbo].SFT_OP_REALRUN
			WHERE  SFT_OP_REALRUN.SEQUENCE="0" AND SFT_OP_REALRUN.ID LIKE "'.$Moid.'" AND SFT_OP_REALRUN.ERP_OPSEQ="'.$ProcessID.'"
			');
	while ($row = mssql_fetch_assoc ($result)) {
		$OPID=$row["ERP_OPID"];
		$WSID=$row["ERP_WSID"];
	}
	
	$result2 = mssql_query("SET ANSI_NULLS ON") or die(mssql_get_last_message());
	$result2 = mssql_query("SET ANSI_WARNINGS ON") or die(mssql_get_last_message());
	
	//The query fot searching the specific database table
	$result2=mssql_query(
	'SELECT [TA013],[TA026],[TA027],[TA028],[TA030]
	FROM [ERPSOURCE].[HM2014].[dbo].[MOCTA]
	WHERE TA001 ="'.$TA004.'" AND TA002 ="'.$TA005.'"
	');
	while ($row = mssql_fetch_assoc ($result2)) {
		$TD001=$row['TA026'];
		$TD002=$row['TA027'];
		$TD003=$row['TA028'];
		$MOCheck=$row['TA013'];
		$MOType=$row['TA030'];
	}
	//Define the table header for presenting the data
	$tablehead= "<table class=\"table\"><tr><td>檢驗單別</td><td>檢驗單號</td><td>檢驗日期</td><td>檢驗時間</td><td>檢驗方式</td><td>送檢數量</td><td>抽樣數量</td><td>不良數量</td><td>檢驗人員</td><td>備註</td><td>製程代號</td><td>線別代號</td><td>製令單別</td><td>製令單號</td><td>製令品號</td><td>性質</td><td>確認碼</td><td>訂單單別</td><td>訂單單號</td><td>訂單序號</td><td>產品品名</td><td>產品規格</td></tr>";
	//<td>製令編號</td>因為已經有製令單別單號，不用顯示此欄位
	echo "<p>資料庫當日資料:</p></div></div><div class=\"row\">";
	echo $tablehead;
	//connect the database
	$dbc = mssql_connect("192.168.2.17", "sa", "20265001");
	//fetch the data in the TQCTA for see how many row data in that day and station
	$CurrentQCData=mssql_query(
		'SELECT
			TA001,TA002,TA003,TA004,TA005,TA006,TA007,TA008,TA009,TA010
           ,TA011,TA012,TA014,TA015,TA016,TA017,TA018,TA019,TA020
           ,TA021,TA022,TA023
		FROM
			WebData.dbo.TQCTA
		WHERE  TA001="'.$Station.'" AND TA003="'.$day.'"
	');
	$total_rows=mssql_num_rows($CurrentQCData);
	$num_fields=mssql_num_fields($CurrentQCData);
	echo "<tr>";
	while ($row=mssql_fetch_row ($CurrentQCData)) {
		echo "<tr>";
		for($i=0;$i<$num_fields;$i++)
			echo "<td>".iconv("big5","UTF-8",$row[$i])."</td>";
			echo "</tr>";
	}
	echo "</table>";
	
	echo "</div></div></div>";
	
	//下一段的資料，切開div
	echo "<div class=\"jumbotron\"><div class=\"container\"><div class=\"row\"><br>";
	//echo "目前資料筆數".$total_rows;
	//目前資料筆數加1
	$nextrow=$total_rows+1;
	//下一筆的編號，並且將其展開成3位數，STR_PAD_LEFT在字串的左側補上0組成的字串
	$value = str_pad($nextrow,3,'0',STR_PAD_LEFT);
    $dayCode = $day.$value;
	//echo "下一列資料的檢驗單號：".$dayCode."<br>";
	
	echo "<p>本筆使用者輸入資料:</p><br></div></div>";
	echo $tablehead;

	echo "<tr><td>".$Station."</td>";
	echo "<td>".$dayCode."</td>";
	echo "<td>".$day."</td>";
	echo "<td>".$time."</td>";
	echo "<td>".$QCtype."</td>";
	echo "<td>".$Number."</td>";
	echo "<td>".$SampleNumber."</td>";
	echo "<td>".$DefectNumber."</td>";
	echo "<td>".$User."</td>";
	echo "<td>".$Remark."</td>";
	echo "<td>".$OPID."</td>";
	echo "<td>".$WSID."</td>";
	//echo "<td>".$Moid."</td>";
	echo "<td>".$TA004."</td>";
	echo "<td>".$TA005."</td>";
	echo "<td>".$Item."</td>";
	echo "<td>".$MOType."</td>";
	echo "<td>".$MOCheck."</td>";
	echo "<td>".$TD001."</td>";
	echo "<td>".$TD002."</td>";
	echo "<td>".$TD003."</td>";
	echo "<td>".$ItemName."</td>";
	echo "<td>".$Spec."</td>";
	echo "</tr></table></div>";

	
	global $Defect;
	$GLOBALS['Defect']=0;
	$tablecontent="<tr>";
	//單身部分編號從0001開始，多增加0000是為了避免後序需要調整array index(讓array[1]="0001")		
	$Body=array("0000","0001","0002","0003","0004","0005","0006","0007","0008");
	for($i=1 ; $i<=8 ;$i++){
		//if the defect number is not number(ex: null boolean string) and then return false
		if( ($_POST['input_name'.$i])!="Not" && !empty($_POST['DefectNumber'.$i])){
			$input_name[$i]=$_POST['input_name'.$i];
			$DefectNumber[$i]=$_POST['DefectNumber'.$i];
			$DefectReamrk[$i]=$_POST['DefectRemark'.$i];
			//echo "<br>第".$Body[$i]."筆不良原因記錄，不良原因代碼為：".$input_name[$i]."，不良數量為：".$DefectNumber[$i]."，備註為：".$DefectReamrk[$i];
			echo "<br>第".$Body[$i];
			$tablecontent=$tablecontent."<td>".$Station."</td><td>".$dayCode."</td><td>".$Body[$i]."</td><td>".$input_name[$i]."</td><td>".$DefectNumber[$i]."</td><td>".$DefectReamrk[$i]."</td><tr>";
			$GLOBALS['Defect']++;
		}
	}
	echo "<br><div class=\"jumbotron\"><div class=\"container\"><div class=\"row\"><p>共有".$GLOBALS['Defect']."筆不良資料</p></div></div>";

	//<td>不良原因名稱</td>目前暫時不mapping這個欄位
	$tablehead2= "<table class=\"table\"><tr><td>檢驗單別</td><td>檢驗單號</td><td>序號</td><td>不良原因代碼</td><td>數量</td><td>備註</td>";
	echo $tablehead2.$tablecontent;
	echo "</table></div>";
	
	//convert some column with chinese.Their encoding transform from UTF-8 to BIG5 and then it can store into the database
	$User=iconv("UTF-8","BIG5",$User);
	$Remark=iconv("UTF-8","BIG5",$Remark);
	$ItemName=iconv("UTF-8","BIG5",$ItemName);
	$Spec=iconv("UTF-8","BIG5",$Spec);
	
	if($GLOBALS['Defect']!=0){
	//TQCTA Table Insert	
	$sql="insert into WebData.dbo.TQCTA
           (TA001,TA002,TA003,TA004,TA005,TA006,TA007,TA008,TA009,TA010
           ,TA011,TA012,TA013,TA014,TA015,TA016,TA017,TA018,TA019,TA020
           ,TA021,TA022,TA023)
     VALUES
           ('$Station'
           ,'$dayCode'
           ,'$day'
           ,'$time'
		   ,'$QCtype'
           ,'$Number'
           ,'$SampleNumber'
           ,'$DefectNumber'
           ,N'$User'
           ,N'$Remark'
           ,'$OPID'
           ,'$WSID'
           ,'$Moid'
           ,'$TA004'
           ,'$TA005'
           ,'$Item'
           ,'$MOType'
           ,'$MOCheck'
           ,'$TD001'
           ,'$TD002'
           ,'$TD003'
           ,N'$ItemName'
           ,N'$Spec')";
	$query=mssql_query($sql,$conn);
	
	for($i=1;$i<=$GLOBALS['Defect'];$i++){
		$Body=iconv("UTF-8","BIG5",$Body[$i]);
		$input_name=iconv("UTF-8","BIG5",$input_name[$i]);
		$DefectNumber=iconv("UTF-8","BIG5",$DefectNumber[$i]);
		$Reamrk=iconv("UTF-8","BIG5",$DefectReamrk[$i]);

		$sql_body="INSERT INTO [WebData].[dbo].[TQCTB]
           ([TB001],[TB002],[TB003],[TB004],[TB005],[TB006])
			VALUES
           ('$Station'
           ,'$dayCode'
           ,'$Body'
           ,N'$input_name'
           ,'$DefectNumber'
           ,N'$Reamrk')";
		$query_body=mssql_query($sql_body,$conn);
	}
	}
?>
</div></div></div>
<br>
<nav><ul class="pager"><li><a href="http://192.168.2.17/QC/Input.php">回製令輸入介面</a></li></ul></nav>
<div></div>