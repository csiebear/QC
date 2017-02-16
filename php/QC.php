<?php
	if (isset($_COOKIE["name"]))
		$Username=$_COOKIE["name"];
	else 
		echo "<script type='text/javascript'>window.location.href='http://192.168.2.17/QC/Index.html'</script>";
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="Unicode">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name=viewport content="width=device-width, initial-scale=1">
<meta name=description content="">
<meta name=author content="">
<link rel=icon href="../img/logo2.png">
<title>品質管制系統</title>
<link href="../dist/css/bootstrap.min.css" rel=stylesheet>
<link href="../dist/jumbotron.css" rel=stylesheet> 
<script src="../dist/ie-emulation-modes-warning.js"></script>
<script language="JavaScript">
		function FormCheck()
        {
			if(QCData.SampleNumber.value == "" || QCData.SampleNumber.value <= 0) 
            {
				confirm("請填寫抽樣數量(必填欄位)\n抽樣數量不可小於、等於0數字");
				return false;
			}else if(QCData.DefectNumber.value == ""){
				confirm("不良數量不可為空(若為0，請輸入0)");
				return false;				
			}else if(QCData.DefectNumber.value < 0 || QCData.DefectNumber.value > QCData.SampleNumber.value){
				confirm("不良數量不可輸入小於0之數字\n不良數量不可超過抽檢數量");
				return false;
			}else if(QCData.Number.value == "" || QCData.SampleNumber.value>QCData.Number.value){
				confirm("送檢數量不可為空\n抽樣數量不可以大於送檢總數");
				return false;
			}else if(QCData.input_name1.value !="Not" && (QCData.DefectNumber1.value <0 || QCData.DefectNumber1.value =='') ){
					confirm("不良數量登記錯誤");
					return false;
			}else if(QCData.input_name1.value =="Not" ){
					confirm("不良原因尚未登記");
					return false;
			}else
				return true;
        }
</script>
<!--
<script language="javascript">
	function change($this) {
		var select=document.getElementById($this);
		for(var i=0;i<select.options.length;i++){
			if(select.options[i].selected==true){
				document.getElementById("D2").options[i].disabled = true;
				document.getElementById("D3").options[i].disabled = true;
				document.getElementById("D4").options[i].disabled = true;
				document.getElementById("D5").options[i].disabled = true;
				document.getElementById("D6").options[i].disabled = true;
				document.getElementById("D7").options[i].disabled = true;
				document.getElementById("D8").options[i].disabled = true;
			}
			//document.getElementById("Test2").remove(i);
		}//end for
	}
</script>-->
<style type="text/css">
	a,div{font-family:"微軟正黑體";}
	table.top,td{text-align:center;border:2px #8E8E8E solid;font-family:"微軟正黑體";}
	table.bot{text-align:center;border:2px #FFC78E solid;font-family:"微軟正黑體";}
	table.Head{border:1px #5B5B5B solid;}
	tr.Head{background:orange;text-align:center;border:1px #5B5B5B solid;font-family:"微軟正黑體";color:#FFFFFF;}
	tr{vertical-align:middle;}
</style>
</head>

<body>
<nav class="navbar navbar-inverse navbar-fixed-top" role=navigation>
	<div class=container>
	<div class=navbar-header>
	<button type=button class="navbar-toggle collapsed" data-toggle=collapse data-target=#navbar aria-expanded=false aria-controls=navbar> 
		<span class=icon-bar></span> 
		<span class=icon-bar></span> 
		<span class=icon-bar></span> 
	</button> 

	<a class=navbar-brand href=#>
	<?php 
		echo $_COOKIE["name"]." 先生/小姐 歡迎使用 品質管制系統";
		echo "<form method=\"post\" action=\"./php/logout.php\"><a class=navbar-brand><button class=\"btn btn-warning\" >登出</button></a></form>";	
	?></a>
</div>
</div>
</nav>
<br><br>
<!--<div class=jumbotron>-->
<div class=container>
<div class="row">
<div class="col-xs-6">
<?php
	$date =$_POST["date"];
	$MoId1 =$_POST["MoId1"];
	echo "<table class='top' width ='1000px' border='1px'><tr class='Head'><td>日期</td><td>製令編號</td><td>訂單編號</td><td>品號</td><td>品名</td><td>規格</td><td>數量</td><td>單位</td>";
	
	echo "<tr><td>".$date.'</td>';
	echo "<td>".$MoId1."</td>";
    
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
	'SELECT [CMOID],[DOID],[SEQUENCE],[ITEMID],[QTY],[UNIT],[MO004],[MO005],[MO013],[MO014],[MO021],[MO022]
		FROM [ERPSOURCE].[SFT_HM2014].[dbo].[MODETAIL]
		WHERE [CMOID] LIKE "'.$MoId1.'"');
	$total_rows=mssql_num_rows($result);
	
	if($total_rows==0){
		echo "<script type='text/javascript'>window.location.href='../Input.php'</script>";
	}
	
	while ($row = mssql_fetch_assoc ($result)) {
		echo "<td>".$row["DOID"]."-".$row["SEQUENCE"]."</td><td>".$row["ITEMID"]."</td><td>".iconv("big5","UTF-8",$row["MO021"])."</td><td>".iconv("big5","UTF-8",$row["MO022"])."</td><td>".$row["QTY"]."</td><td>".$row["UNIT"]."</td></tr></table>";
		$Item=$row["ITEMID"];
		$ItemName=iconv("big5","UTF-8",$row["MO021"]);
		$Spec=iconv("big5","UTF-8",$row["MO022"]);
		$TA004=$row["MO004"];
		$TA005=$row["MO005"];
	}
?>
</div></div></div><!--</div>--><br><br><br><br>
<div class=container>
	<div class="row">
    <form name="QCData" id="QCData" method="post" action="../Insert.php" onSubmit="return FormCheck();">
		<input type="hidden" id="Moid" name="Moid" value="<?php echo $MoId1;?>">
		<input type="hidden" id="TA004" name="TA004" value="<?php echo $TA004;?>">
		<input type="hidden" id="TA005" name="TA005" value="<?php echo $TA005;?>">
		<input type="hidden" id="Item" name="Item" value="<?php echo $Item;?>">
		<input type="hidden" id="ItemName" name="ItemName" value="<?php echo $ItemName;?>">
		<input type="hidden" id="Spec" name="Spec" value="<?php echo $Spec;?>">
	</div>
	<div class="row">
		<div class="col-xs-2"></div>
		<div class="col-xs-2">工序/製程代號/線別代號：</div>
		<div class="col-xs-4">
			<select id="ProcessID" name="ProcessID" type="string" tabindex=0 style="width:200px;">
			<?php
			//The query fot searching the specific database table
			$result2=mssql_query(
			'SELECT
			SFT_OP_REALRUN.ERP_OPSEQ,SFT_OP_REALRUN.OPID,SFT_OP_REALRUN.ERP_OPID,SFT_OP_REALRUN.ERP_WSID
			FROM
				[ERPSOURCE].[SFT_HM2014].[dbo].SFT_OP_REALRUN
			WHERE  SFT_OP_REALRUN.SEQUENCE="0" AND SFT_OP_REALRUN.ID LIKE "'.$MoId1.'"
			ORDER BY SFT_OP_REALRUN.ERP_OPSEQ
			');
			$total_rows=mssql_num_rows($result2);
			if($total_rows==0){
				echo "<script type='text/javascript'>window.location.href='../Input.php'</script>";
			}
			while ($row = mssql_fetch_assoc ($result2)) {
				$OPID[$row["ERP_OPSEQ"]]=$row["ERP_OPID"];
				$WSID[$row["ERP_OPSEQ"]]=$row["ERP_WSID"];
				echo "<option value=\"".$row["ERP_OPSEQ"]."\">".$row["ERP_OPSEQ"]." ".$row["ERP_OPID"]." ".$row["ERP_WSID"]."</option><br>";
			}
			?>
			</select>	
		</div>
	</div>

		<div class="row">
			<div class="col-xs-2"></div>
			<div class="col-xs-2">檢驗站:</div>
			<div class="col-xs-4"><select id="Station" name="Station" type="string" tabindex=0/></div>
				<option value="QC01">射出</option>
				<option value="QC02">射包</option>
				<option value="QC03">噴漆</option>
				<option value="QC04">齊料倉</option>
				<option value="QC05">成品檢驗</option>
			</select></div>
		</div>

		<div class="row">
			<div class="col-xs-2"></div>
			<div class="col-xs-2">檢驗人員:</div>
			<div class="col-xs-4"><input type="hidden" id="User" name="User" maxlength="5"  value="<?php echo $Username;?>"><?php echo $Username;?></div>
		</div>

		<div class="row">
			<div class="col-xs-2"></div>
			<div class="col-xs-2">本批檢驗方式:</div>
			<div class="col-xs-4"><select name="QCtype" id="QCtype"type="number" tabindex=2>
				<option value="1">1:全檢</option>
				<option value="2">2:抽檢</option>
				<option value="3">3:巡檢</option>
				<option value="4">4:免驗</option>
			</select></div>
		</div>
<fieldset>
		<div class="row">
			<div class="col-xs-2"></div>
			<div class="col-xs-2">抽樣數量:</div>
			<div class="col-xs-8"><input id="SampleNumber" name="SampleNumber" type="number" style="ime-mode:disabled" onkeyup="return ValidateNumber(this,value)" maxlength="5" tabindex=3></div>
		</div>
		<div class="row">
			<div class="col-xs-2"></div>
			<div class="col-xs-2">不良數量:</div>
			<div class="col-xs-8"><input id="DefectNumber" name="DefectNumber"  type="number" style="ime-mode:disabled" onkeyup="return ValidateNumber(this,value)" maxlength="5" tabindex=4></div>
		</div>
		<div class="row">
			<div class="col-xs-2"></div><div class="col-xs-2">送檢數量:</div>
			<div class="col-xs-8"><input id="Number" name="Number" type="number"  style="ime-mode:disabled" onkeyup="return ValidateNumber(this,value)"  maxlength="5" tabindex=5></div>
		</div>
</fieldset>
		<div class="row">
				<div class="col-xs-2"></div><div class="col-xs-2">備註:</div><div class="col-xs-8"><textarea id="Remark" rows="2" cols="40" maxlength="100" placeholder="異常原因補充(字數上限：255)" name="Remark" tabindex=6 value="可填寫備註說明(字數上限制:255)">無</textarea></div>
		</div>
		<br>
		<table class="bot" width="1000">
		<tr><td><br>
		<div class="row" > 
			<div class="col-xs-1"></div>
			<div class="col-xs-2">不良原因：</div>
			<div class="col-xs-2"><select id="D1" style="width:150px;" name="input_name1">
			<option value= "Not" selected> =請選擇不良原因= </option>
			<option value="A01"> A01 撬傷 </option>
<option value= A02 > A02 表面擦傷(刮傷) </option>
<option value= A03 > A03 拖傷 </option>
<option value= A04 > A04 螺絲孔NG </option>
<option value= A05 > A05 刻字錯誤 </option>
<option value= A06 > A06 變形 </option>
<option value= A07 > A07 灌口不良 </option>
<option value= A08 > A08 拋光/剪澆口不良 </option>
<option value= A09 > A09 白霧 </option>
<option value= A10 > A10 彈傷 </option>
<option value= A11 > A11 斷裂 </option>
<option value= A12 > A12 雞爪 </option>
<option value= A13 > A13 包風 </option>
<option value= A14 > A14 鉸鍊歪斜 </option>
<option value= A15 > A15 倒邊, 唇邊 </option>
<option value= A16 > A16 冷料痕 </option>
<option value= A17 > A17 脫皮 </option>
<option value= A18 > A18 氣泡 </option>
<option value= A19 > A19 射出不足/縮水/缺料 </option>
<option value= A21 > A21 作號 </option>
<option value= A22 > A22 分模線 </option>
<option value= A23 > A23 肉粒, 毛邊 </option>
<option value= A24 > A24 色差/色點 </option>
<option value= A25 > A25 模傷/夾傷 </option>
<option value= A26 > A26 裂痕 </option>
<option value= A27 > A27 片模仁受損 </option>
<option value= A28 > A28 油痕 </option>
<option value= A29 > A29 射出重量太輕/太重 </option>
<option value= A30 > A30 研磨受損 </option>
<option value= A31 > A31 C-size偏大或過小 </option>
<option value= B01 > B01 擦傷, ,  </option>
<option value= B02 > B02 轉印破損 </option>
<option value= B03 > B03 掉漆,  </option>
<option value= B04 > B04 水染不良 </option>
<option value= B05 > B05 水痕 </option>
<option value= B06 > B06 染料附著 </option>
<option value= B07 > B07 色差 </option>
<option value= B08 > B08 噴漆不良, 不均 </option>
<option value= B09 > B09 金油不足, 不均 </option>
<option value= B10 > B10 刻字模糊 </option>
<option value= B11 > B11 吊色 </option>
<option value= B12 > B12 橘皮 </option>
<option value= B13 > B13 流膏/垂流 </option>
<option value= B14 > B14 痱子 </option>
<option value= B15 > B15 背噴過度 </option>
<option value= B16 > B16 作號 </option>
<option value= B17 > B17 遮噴不良 </option>
<option value= B18 > B18 變黃 </option>
<option value= B19 > B19 噴錯型體 </option>
<option value= B20 > B20 磨後不良, 見底 </option>
<option value= B21 > B21 水轉不良 </option>
<option value= B22 > B22 水標不良 </option>
<option value= B23 > B23 熱轉不良 </option>
<option value= B24 > B24 雜點, 色點 </option>
<option value= B25 > B25 夾具痕 </option>
<option value= B26 > B26 油點 </option>
<option value= B27 > B27 棉絮 </option>
<option value= B28 > B28 砂點, 砂粒 </option>
<option value= B29 > B29 髒污 </option>
<option value= B30 > B30 附著度不佳 </option>
<option value= B31 > B31 夾具造成變形 </option>
<option value= C01 > C01 刻字錯誤 </option>
<option value= C02 > C02 變形 </option>
<option value= C03 > C03 包風 </option>
<option value= C04 > C04 射包不足/缺料/縮水 </option>
<option value= C06 > C06 冷料痕 </option>
<option value= C07 > C07 毛邊 </option>
<option value= C08 > C08 灌口不良 </option>
<option value= C09 > C09 分模線 </option>
<option value= C10 > C10 結合線過深 </option>
<option value= C11 > C11 壓傷 </option>
<option value= C12 > C12 色點 </option>
<option value= C13 > C13 色差 </option>
<option value= C14 > C14 脫皮 </option>
<option value= C15 > C15 橘皮, 透底色 </option>
<option value= C16 > C16 模具受損 </option>
<option value= C17 > C17 磁極錯誤 </option>
<option value= C18 > C18 軟料斷差 </option>
<option value= C19 > C19 射包附著度不佳 </option>
<option value= C20 > C20 C-size偏大或過小 </option>
<option value= D01 > D01 字體糢糊/掉字 </option>
<option value= D02 > D02 字型錯誤 </option>
<option value= D03 > D03 未印字 </option>
<option value= D04 > D04 位置錯誤 </option>
<option value= E01 > E01 點漆不良 </option>
<option value= E03 > E03 組片不良 </option>
<option value= E04 > E04 組合或黏貼錯誤 </option>
<option value= E05 > E05 鼻墊/飾片/耳扣/泡棉未牢固 </option>
<option value= E07 > E07 高低腳 </option>
<option value= E08 > E08 腳尾距不良 </option>
<option value= E09 > E09 開合有異音 </option>
<option value= E11 > E11 刮傷 </option>
<option value= E12 > E12 飾片/鼻墊顏色異常 </option>
<option value= E13 > E13 左右腳/轉軸鬆緊度不同 </option>
<option value= E14 > E14 撇腳/軟腳 </option>
<option value= E15 > E15 出貨短少 </option>
<option value= E16 > E16 鏡片刮傷 </option>
<option value= E17 > E17 印字不良 </option>
<option value= E18 > E18 轉軸失效 </option>
<option value= E19 > E19 泡棉附著度不佳 </option>
<option value= E19 > E19 掉漆 </option>
<option value= E20 > E20 螺絲凸出 </option>
<option value= E20 > E20 刮傷 </option>
<option value= E21 > E21 缺少組件(鼻墊/飾片/頭帶/泡棉/說明書等) </option>
<option value= E21 > E21 出貨延遲 </option>
<option value= E23 > E23 頭帶異常(Logo/位置/顏色錯誤) </option>
<option value= E25 > E25 配件遺失(泡棉/內片/鏡片/飾片等) </option>
<option value= L01 > L01 鏡片擦傷, 刮傷 </option>
<option value= L02 > L02 灌口不良 </option>
<option value= L03 > L03 拋光不良 </option>
<option value= L04 > L04 裁片片型不良 </option>
<option value= L05 > L05 鏡片鑽孔走位 </option>
<option value= L06 > L06 鐳刻字體錯誤 </option>
<option value= L07 > L07 鏡片裂片/斷裂 </option>
<option value= L08 > L08 鏡片應力過大 </option>
<option value= L09 > L09 片緣過利 </option>
<option value= L10 > L10 強化痕 </option>
<option value= L11 > L11 鍍膜色差 </option>
<option value= L12 > L12 鏡片砂點 </option>
<option value= L13 > L13 鏡片色差 </option>
<option value= L14 > L14 鏡片裂膜/脫膜 </option>
<option value= L15 > L15 跳片/鏡片脫離 </option>
<option value= L16 > L16 光學量測未過 </option>
<option value= L17 > L17  配戴舒適感不佳 </option>
<option value= L18 > L18 鏡片有不明痕跡 </option>
<option value= O01 > O01 混料 </option>
<option value= O02 > O02 製令單錯誤 </option>
<option value= O03 > O03 數量短缺 </option>
<option value= O99 > O99 其他 </option>
		</select></div>
			<div class="col-xs-1">數量：</div>
			<div class="col-xs-1"><input style="width:50px" id="DefectNumber1" name="DefectNumber1" type="number"  style="ime-mode:disabled" onkeyup="return ValidateNumber(this,value)"  maxlength="5" tabindex=7/></div>
			<div class="col-xs-1">備註：</div>
			<div class="col-xs-1"><input style="width:200px" id="DefectRemark1" name="DefectRemark1" type="string"></div>
		</div>
		<div class="row">
			<br><div class="col-xs-1"></div>
			<div class="col-xs-2">不良原因：</div>
			<div class="col-xs-2"><select id="D2" style="width:150px;" name="input_name2" type="string">
			<option value= "Not" selected> =請選擇不良原因= </option>
<option value= A01 > A01 撬傷 </option>
<option value= A02 > A02 表面擦傷(刮傷) </option>
<option value= A03 > A03 拖傷 </option>
<option value= A04 > A04 螺絲孔NG </option>
<option value= A05 > A05 刻字錯誤 </option>
<option value= A06 > A06 變形 </option>
<option value= A07 > A07 灌口不良 </option>
<option value= A08 > A08 拋光/剪澆口不良 </option>
<option value= A09 > A09 白霧 </option>
<option value= A10 > A10 彈傷 </option>
<option value= A11 > A11 斷裂 </option>
<option value= A12 > A12 雞爪 </option>
<option value= A13 > A13 包風 </option>
<option value= A14 > A14 鉸鍊歪斜 </option>
<option value= A15 > A15 倒邊, 唇邊 </option>
<option value= A16 > A16 冷料痕 </option>
<option value= A17 > A17 脫皮 </option>
<option value= A18 > A18 氣泡 </option>
<option value= A19 > A19 射出不足/縮水/缺料 </option>
<option value= A21 > A21 作號 </option>
<option value= A22 > A22 分模線 </option>
<option value= A23 > A23 肉粒, 毛邊 </option>
<option value= A24 > A24 色差/色點 </option>
<option value= A25 > A25 模傷/夾傷 </option>
<option value= A26 > A26 裂痕 </option>
<option value= A27 > A27 片模仁受損 </option>
<option value= A28 > A28 油痕 </option>
<option value= A29 > A29 射出重量太輕/太重 </option>
<option value= A30 > A30 研磨受損 </option>
<option value= A31 > A31 C-size偏大或過小 </option>
<option value= B01 > B01 擦傷, ,  </option>
<option value= B02 > B02 轉印破損 </option>
<option value= B03 > B03 掉漆,  </option>
<option value= B04 > B04 水染不良 </option>
<option value= B05 > B05 水痕 </option>
<option value= B06 > B06 染料附著 </option>
<option value= B07 > B07 色差 </option>
<option value= B08 > B08 噴漆不良, 不均 </option>
<option value= B09 > B09 金油不足, 不均 </option>
<option value= B10 > B10 刻字模糊 </option>
<option value= B11 > B11 吊色 </option>
<option value= B12 > B12 橘皮 </option>
<option value= B13 > B13 流膏/垂流 </option>
<option value= B14 > B14 痱子 </option>
<option value= B15 > B15 背噴過度 </option>
<option value= B16 > B16 作號 </option>
<option value= B17 > B17 遮噴不良 </option>
<option value= B18 > B18 變黃 </option>
<option value= B19 > B19 噴錯型體 </option>
<option value= B20 > B20 磨後不良, 見底 </option>
<option value= B21 > B21 水轉不良 </option>
<option value= B22 > B22 水標不良 </option>
<option value= B23 > B23 熱轉不良 </option>
<option value= B24 > B24 雜點, 色點 </option>
<option value= B25 > B25 夾具痕 </option>
<option value= B26 > B26 油點 </option>
<option value= B27 > B27 棉絮 </option>
<option value= B28 > B28 砂點, 砂粒 </option>
<option value= B29 > B29 髒污 </option>
<option value= B30 > B30 附著度不佳 </option>
<option value= B31 > B31 夾具造成變形 </option>
<option value= C01 > C01 刻字錯誤 </option>
<option value= C02 > C02 變形 </option>
<option value= C03 > C03 包風 </option>
<option value= C04 > C04 射包不足/缺料/縮水 </option>
<option value= C06 > C06 冷料痕 </option>
<option value= C07 > C07 毛邊 </option>
<option value= C08 > C08 灌口不良 </option>
<option value= C09 > C09 分模線 </option>
<option value= C10 > C10 結合線過深 </option>
<option value= C11 > C11 壓傷 </option>
<option value= C12 > C12 色點 </option>
<option value= C13 > C13 色差 </option>
<option value= C14 > C14 脫皮 </option>
<option value= C15 > C15 橘皮, 透底色 </option>
<option value= C16 > C16 模具受損 </option>
<option value= C17 > C17 磁極錯誤 </option>
<option value= C18 > C18 軟料斷差 </option>
<option value= C19 > C19 射包附著度不佳 </option>
<option value= C20 > C20 C-size偏大或過小 </option>
<option value= D01 > D01 字體糢糊/掉字 </option>
<option value= D02 > D02 字型錯誤 </option>
<option value= D03 > D03 未印字 </option>
<option value= D04 > D04 位置錯誤 </option>
<option value= E01 > E01 點漆不良 </option>
<option value= E03 > E03 組片不良 </option>
<option value= E04 > E04 組合或黏貼錯誤 </option>
<option value= E05 > E05 鼻墊/飾片/耳扣/泡棉未牢固 </option>
<option value= E07 > E07 高低腳 </option>
<option value= E08 > E08 腳尾距不良 </option>
<option value= E09 > E09 開合有異音 </option>
<option value= E11 > E11 刮傷 </option>
<option value= E12 > E12 飾片/鼻墊顏色異常 </option>
<option value= E13 > E13 左右腳/轉軸鬆緊度不同 </option>
<option value= E14 > E14 撇腳/軟腳 </option>
<option value= E15 > E15 出貨短少 </option>
<option value= E16 > E16 鏡片刮傷 </option>
<option value= E17 > E17 印字不良 </option>
<option value= E18 > E18 轉軸失效 </option>
<option value= E19 > E19 泡棉附著度不佳 </option>
<option value= E19 > E19 掉漆 </option>
<option value= E20 > E20 螺絲凸出 </option>
<option value= E20 > E20 刮傷 </option>
<option value= E21 > E21 缺少組件(鼻墊/飾片/頭帶/泡棉/說明書等) </option>
<option value= E21 > E21 出貨延遲 </option>
<option value= E23 > E23 頭帶異常(Logo/位置/顏色錯誤) </option>
<option value= E25 > E25 配件遺失(泡棉/內片/鏡片/飾片等) </option>
<option value= L01 > L01 鏡片擦傷, 刮傷 </option>
<option value= L02 > L02 灌口不良 </option>
<option value= L03 > L03 拋光不良 </option>
<option value= L04 > L04 裁片片型不良 </option>
<option value= L05 > L05 鏡片鑽孔走位 </option>
<option value= L06 > L06 鐳刻字體錯誤 </option>
<option value= L07 > L07 鏡片裂片/斷裂 </option>
<option value= L08 > L08 鏡片應力過大 </option>
<option value= L09 > L09 片緣過利 </option>
<option value= L10 > L10 強化痕 </option>
<option value= L11 > L11 鍍膜色差 </option>
<option value= L12 > L12 鏡片砂點 </option>
<option value= L13 > L13 鏡片色差 </option>
<option value= L14 > L14 鏡片裂膜/脫膜 </option>
<option value= L15 > L15 跳片/鏡片脫離 </option>
<option value= L16 > L16 光學量測未過 </option>
<option value= L17 > L17  配戴舒適感不佳 </option>
<option value= L18 > L18 鏡片有不明痕跡 </option>
<option value= O01 > O01 混料 </option>
<option value= O02 > O02 製令單錯誤 </option>
<option value= O03 > O03 數量短缺 </option>
<option value= O99 > O99 其他 </option>
		</select></div>
			<div class="col-xs-1">數量：</div>
			<div class="col-xs-1"><input style="width:50px" id="DefectNumber2" name="DefectNumber2" type="number"  style="ime-mode:disabled" onkeyup="return ValidateNumber(this,value)"  maxlength="5" tabindex=7/></div>
			<div class="col-xs-1">備註：</div>
			<div class="col-xs-1"><input style="width:200px" id="DefectRemark2" name="DefectRemark2" type="string"></div>
		</div>
		<div class="row"  id="default1" style="display:none">
			<br><div class="col-xs-1"></div>
			<div class="col-xs-2">不良原因：</div>
			<div class="col-xs-2"><select id="D3" style="width:150px;" name="input_name3" type="string">
			<option value= "Not" selected> =請選擇不良原因= </option>
<option value= A01 > A01 撬傷 </option>
<option value= A02 > A02 表面擦傷(刮傷) </option>
<option value= A03 > A03 拖傷 </option>
<option value= A04 > A04 螺絲孔NG </option>
<option value= A05 > A05 刻字錯誤 </option>
<option value= A06 > A06 變形 </option>
<option value= A07 > A07 灌口不良 </option>
<option value= A08 > A08 拋光/剪澆口不良 </option>
<option value= A09 > A09 白霧 </option>
<option value= A10 > A10 彈傷 </option>
<option value= A11 > A11 斷裂 </option>
<option value= A12 > A12 雞爪 </option>
<option value= A13 > A13 包風 </option>
<option value= A14 > A14 鉸鍊歪斜 </option>
<option value= A15 > A15 倒邊, 唇邊 </option>
<option value= A16 > A16 冷料痕 </option>
<option value= A17 > A17 脫皮 </option>
<option value= A18 > A18 氣泡 </option>
<option value= A19 > A19 射出不足/縮水/缺料 </option>
<option value= A21 > A21 作號 </option>
<option value= A22 > A22 分模線 </option>
<option value= A23 > A23 肉粒, 毛邊 </option>
<option value= A24 > A24 色差/色點 </option>
<option value= A25 > A25 模傷/夾傷 </option>
<option value= A26 > A26 裂痕 </option>
<option value= A27 > A27 片模仁受損 </option>
<option value= A28 > A28 油痕 </option>
<option value= A29 > A29 射出重量太輕/太重 </option>
<option value= A30 > A30 研磨受損 </option>
<option value= A31 > A31 C-size偏大或過小 </option>
<option value= B01 > B01 擦傷, ,  </option>
<option value= B02 > B02 轉印破損 </option>
<option value= B03 > B03 掉漆,  </option>
<option value= B04 > B04 水染不良 </option>
<option value= B05 > B05 水痕 </option>
<option value= B06 > B06 染料附著 </option>
<option value= B07 > B07 色差 </option>
<option value= B08 > B08 噴漆不良, 不均 </option>
<option value= B09 > B09 金油不足, 不均 </option>
<option value= B10 > B10 刻字模糊 </option>
<option value= B11 > B11 吊色 </option>
<option value= B12 > B12 橘皮 </option>
<option value= B13 > B13 流膏/垂流 </option>
<option value= B14 > B14 痱子 </option>
<option value= B15 > B15 背噴過度 </option>
<option value= B16 > B16 作號 </option>
<option value= B17 > B17 遮噴不良 </option>
<option value= B18 > B18 變黃 </option>
<option value= B19 > B19 噴錯型體 </option>
<option value= B20 > B20 磨後不良, 見底 </option>
<option value= B21 > B21 水轉不良 </option>
<option value= B22 > B22 水標不良 </option>
<option value= B23 > B23 熱轉不良 </option>
<option value= B24 > B24 雜點, 色點 </option>
<option value= B25 > B25 夾具痕 </option>
<option value= B26 > B26 油點 </option>
<option value= B27 > B27 棉絮 </option>
<option value= B28 > B28 砂點, 砂粒 </option>
<option value= B29 > B29 髒污 </option>
<option value= B30 > B30 附著度不佳 </option>
<option value= B31 > B31 夾具造成變形 </option>
<option value= C01 > C01 刻字錯誤 </option>
<option value= C02 > C02 變形 </option>
<option value= C03 > C03 包風 </option>
<option value= C04 > C04 射包不足/缺料/縮水 </option>
<option value= C06 > C06 冷料痕 </option>
<option value= C07 > C07 毛邊 </option>
<option value= C08 > C08 灌口不良 </option>
<option value= C09 > C09 分模線 </option>
<option value= C10 > C10 結合線過深 </option>
<option value= C11 > C11 壓傷 </option>
<option value= C12 > C12 色點 </option>
<option value= C13 > C13 色差 </option>
<option value= C14 > C14 脫皮 </option>
<option value= C15 > C15 橘皮, 透底色 </option>
<option value= C16 > C16 模具受損 </option>
<option value= C17 > C17 磁極錯誤 </option>
<option value= C18 > C18 軟料斷差 </option>
<option value= C19 > C19 射包附著度不佳 </option>
<option value= C20 > C20 C-size偏大或過小 </option>
<option value= D01 > D01 字體糢糊/掉字 </option>
<option value= D02 > D02 字型錯誤 </option>
<option value= D03 > D03 未印字 </option>
<option value= D04 > D04 位置錯誤 </option>
<option value= E01 > E01 點漆不良 </option>
<option value= E03 > E03 組片不良 </option>
<option value= E04 > E04 組合或黏貼錯誤 </option>
<option value= E05 > E05 鼻墊/飾片/耳扣/泡棉未牢固 </option>
<option value= E07 > E07 高低腳 </option>
<option value= E08 > E08 腳尾距不良 </option>
<option value= E09 > E09 開合有異音 </option>
<option value= E11 > E11 刮傷 </option>
<option value= E12 > E12 飾片/鼻墊顏色異常 </option>
<option value= E13 > E13 左右腳/轉軸鬆緊度不同 </option>
<option value= E14 > E14 撇腳/軟腳 </option>
<option value= E15 > E15 出貨短少 </option>
<option value= E16 > E16 鏡片刮傷 </option>
<option value= E17 > E17 印字不良 </option>
<option value= E18 > E18 轉軸失效 </option>
<option value= E19 > E19 泡棉附著度不佳 </option>
<option value= E19 > E19 掉漆 </option>
<option value= E20 > E20 螺絲凸出 </option>
<option value= E20 > E20 刮傷 </option>
<option value= E21 > E21 缺少組件(鼻墊/飾片/頭帶/泡棉/說明書等) </option>
<option value= E21 > E21 出貨延遲 </option>
<option value= E23 > E23 頭帶異常(Logo/位置/顏色錯誤) </option>
<option value= E25 > E25 配件遺失(泡棉/內片/鏡片/飾片等) </option>
<option value= L01 > L01 鏡片擦傷, 刮傷 </option>
<option value= L02 > L02 灌口不良 </option>
<option value= L03 > L03 拋光不良 </option>
<option value= L04 > L04 裁片片型不良 </option>
<option value= L05 > L05 鏡片鑽孔走位 </option>
<option value= L06 > L06 鐳刻字體錯誤 </option>
<option value= L07 > L07 鏡片裂片/斷裂 </option>
<option value= L08 > L08 鏡片應力過大 </option>
<option value= L09 > L09 片緣過利 </option>
<option value= L10 > L10 強化痕 </option>
<option value= L11 > L11 鍍膜色差 </option>
<option value= L12 > L12 鏡片砂點 </option>
<option value= L13 > L13 鏡片色差 </option>
<option value= L14 > L14 鏡片裂膜/脫膜 </option>
<option value= L15 > L15 跳片/鏡片脫離 </option>
<option value= L16 > L16 光學量測未過 </option>
<option value= L17 > L17  配戴舒適感不佳 </option>
<option value= L18 > L18 鏡片有不明痕跡 </option>
<option value= O01 > O01 混料 </option>
<option value= O02 > O02 製令單錯誤 </option>
<option value= O03 > O03 數量短缺 </option>
<option value= O99 > O99 其他 </option>
		</select></div>
			<div class="col-xs-1">數量：</div>
			<div class="col-xs-1"><input style="width:50px" id="DefectNumber3" name="DefectNumber3" type="number"  style="ime-mode:disabled" onkeyup="return ValidateNumber(this,value)"  maxlength="5" tabindex=7/></div>
			<div class="col-xs-1">備註：</div>
			<div class="col-xs-1"><input style="width:200px" id="DefectRemark3" name="DefectRemark3" type="string"></div>
		</div>
		<div class="row"  id="default2" style="display:none">
			<br><div class="col-xs-1"></div>
			<div class="col-xs-2">不良原因：</div>
			<div class="col-xs-2"><select id="D4" style="width:150px;" name="input_name4" type="string" >
			<option value= "Not" selected> =請選擇不良原因= </option>
			<option value= A01> A01 撬傷 </option>
<option value= A02 > A02 表面擦傷(刮傷) </option>
<option value= A03 > A03 拖傷 </option>
<option value= A04 > A04 螺絲孔NG </option>
<option value= A05 > A05 刻字錯誤 </option>
<option value= A06 > A06 變形 </option>
<option value= A07 > A07 灌口不良 </option>
<option value= A08 > A08 拋光/剪澆口不良 </option>
<option value= A09 > A09 白霧 </option>
<option value= A10 > A10 彈傷 </option>
<option value= A11 > A11 斷裂 </option>
<option value= A12 > A12 雞爪 </option>
<option value= A13 > A13 包風 </option>
<option value= A14 > A14 鉸鍊歪斜 </option>
<option value= A15 > A15 倒邊, 唇邊 </option>
<option value= A16 > A16 冷料痕 </option>
<option value= A17 > A17 脫皮 </option>
<option value= A18 > A18 氣泡 </option>
<option value= A19 > A19 射出不足/縮水/缺料 </option>
<option value= A21 > A21 作號 </option>
<option value= A22 > A22 分模線 </option>
<option value= A23 > A23 肉粒, 毛邊 </option>
<option value= A24 > A24 色差/色點 </option>
<option value= A25 > A25 模傷/夾傷 </option>
<option value= A26 > A26 裂痕 </option>
<option value= A27 > A27 片模仁受損 </option>
<option value= A28 > A28 油痕 </option>
<option value= A29 > A29 射出重量太輕/太重 </option>
<option value= A30 > A30 研磨受損 </option>
<option value= A31 > A31 C-size偏大或過小 </option>
<option value= B01 > B01 擦傷, ,  </option>
<option value= B02 > B02 轉印破損 </option>
<option value= B03 > B03 掉漆,  </option>
<option value= B04 > B04 水染不良 </option>
<option value= B05 > B05 水痕 </option>
<option value= B06 > B06 染料附著 </option>
<option value= B07 > B07 色差 </option>
<option value= B08 > B08 噴漆不良, 不均 </option>
<option value= B09 > B09 金油不足, 不均 </option>
<option value= B10 > B10 刻字模糊 </option>
<option value= B11 > B11 吊色 </option>
<option value= B12 > B12 橘皮 </option>
<option value= B13 > B13 流膏/垂流 </option>
<option value= B14 > B14 痱子 </option>
<option value= B15 > B15 背噴過度 </option>
<option value= B16 > B16 作號 </option>
<option value= B17 > B17 遮噴不良 </option>
<option value= B18 > B18 變黃 </option>
<option value= B19 > B19 噴錯型體 </option>
<option value= B20 > B20 磨後不良, 見底 </option>
<option value= B21 > B21 水轉不良 </option>
<option value= B22 > B22 水標不良 </option>
<option value= B23 > B23 熱轉不良 </option>
<option value= B24 > B24 雜點, 色點 </option>
<option value= B25 > B25 夾具痕 </option>
<option value= B26 > B26 油點 </option>
<option value= B27 > B27 棉絮 </option>
<option value= B28 > B28 砂點, 砂粒 </option>
<option value= B29 > B29 髒污 </option>
<option value= B30 > B30 附著度不佳 </option>
<option value= B31 > B31 夾具造成變形 </option>
<option value= C01 > C01 刻字錯誤 </option>
<option value= C02 > C02 變形 </option>
<option value= C03 > C03 包風 </option>
<option value= C04 > C04 射包不足/缺料/縮水 </option>
<option value= C06 > C06 冷料痕 </option>
<option value= C07 > C07 毛邊 </option>
<option value= C08 > C08 灌口不良 </option>
<option value= C09 > C09 分模線 </option>
<option value= C10 > C10 結合線過深 </option>
<option value= C11 > C11 壓傷 </option>
<option value= C12 > C12 色點 </option>
<option value= C13 > C13 色差 </option>
<option value= C14 > C14 脫皮 </option>
<option value= C15 > C15 橘皮, 透底色 </option>
<option value= C16 > C16 模具受損 </option>
<option value= C17 > C17 磁極錯誤 </option>
<option value= C18 > C18 軟料斷差 </option>
<option value= C19 > C19 射包附著度不佳 </option>
<option value= C20 > C20 C-size偏大或過小 </option>
<option value= D01 > D01 字體糢糊/掉字 </option>
<option value= D02 > D02 字型錯誤 </option>
<option value= D03 > D03 未印字 </option>
<option value= D04 > D04 位置錯誤 </option>
<option value= E01 > E01 點漆不良 </option>
<option value= E03 > E03 組片不良 </option>
<option value= E04 > E04 組合或黏貼錯誤 </option>
<option value= E05 > E05 鼻墊/飾片/耳扣/泡棉未牢固 </option>
<option value= E07 > E07 高低腳 </option>
<option value= E08 > E08 腳尾距不良 </option>
<option value= E09 > E09 開合有異音 </option>
<option value= E11 > E11 刮傷 </option>
<option value= E12 > E12 飾片/鼻墊顏色異常 </option>
<option value= E13 > E13 左右腳/轉軸鬆緊度不同 </option>
<option value= E14 > E14 撇腳/軟腳 </option>
<option value= E15 > E15 出貨短少 </option>
<option value= E16 > E16 鏡片刮傷 </option>
<option value= E17 > E17 印字不良 </option>
<option value= E18 > E18 轉軸失效 </option>
<option value= E19 > E19 泡棉附著度不佳 </option>
<option value= E19 > E19 掉漆 </option>
<option value= E20 > E20 螺絲凸出 </option>
<option value= E20 > E20 刮傷 </option>
<option value= E21 > E21 缺少組件(鼻墊/飾片/頭帶/泡棉/說明書等) </option>
<option value= E21 > E21 出貨延遲 </option>
<option value= E23 > E23 頭帶異常(Logo/位置/顏色錯誤) </option>
<option value= E25 > E25 配件遺失(泡棉/內片/鏡片/飾片等) </option>
<option value= L01 > L01 鏡片擦傷, 刮傷 </option>
<option value= L02 > L02 灌口不良 </option>
<option value= L03 > L03 拋光不良 </option>
<option value= L04 > L04 裁片片型不良 </option>
<option value= L05 > L05 鏡片鑽孔走位 </option>
<option value= L06 > L06 鐳刻字體錯誤 </option>
<option value= L07 > L07 鏡片裂片/斷裂 </option>
<option value= L08 > L08 鏡片應力過大 </option>
<option value= L09 > L09 片緣過利 </option>
<option value= L10 > L10 強化痕 </option>
<option value= L11 > L11 鍍膜色差 </option>
<option value= L12 > L12 鏡片砂點 </option>
<option value= L13 > L13 鏡片色差 </option>
<option value= L14 > L14 鏡片裂膜/脫膜 </option>
<option value= L15 > L15 跳片/鏡片脫離 </option>
<option value= L16 > L16 光學量測未過 </option>
<option value= L17 > L17  配戴舒適感不佳 </option>
<option value= L18 > L18 鏡片有不明痕跡 </option>
<option value= O01 > O01 混料 </option>
<option value= O02 > O02 製令單錯誤 </option>
<option value= O03 > O03 數量短缺 </option>
<option value= O99 > O99 其他 </option>
		</select></div>
			<div class="col-xs-1">數量：</div>
			<div class="col-xs-1"><input style="width:50px" id="DefectNumber4" name="DefectNumber4" type="number"  style="ime-mode:disabled" onkeyup="return ValidateNumber(this,value)"  maxlength="5" tabindex=7/></div>
			<div class="col-xs-1">備註：</div>
			<div class="col-xs-1"><input style="width:200px" id="DefectRemark4" name="DefectRemark4" type="string"></div>
		</div>
		<div class="row" id="default3" style="display:none">
			<br><div class="col-xs-1"></div>
			<div class="col-xs-2">不良原因：</div>
			<div class="col-xs-2"><select id="D5" style="width:150px;" name="input_name5" type="string" >
			<option value= "Not" selected> =請選擇不良原因= </option>
			<option value= A01> A01 撬傷 </option>
<option value= A02 > A02 表面擦傷(刮傷) </option>
<option value= A03 > A03 拖傷 </option>
<option value= A04 > A04 螺絲孔NG </option>
<option value= A05 > A05 刻字錯誤 </option>
<option value= A06 > A06 變形 </option>
<option value= A07 > A07 灌口不良 </option>
<option value= A08 > A08 拋光/剪澆口不良 </option>
<option value= A09 > A09 白霧 </option>
<option value= A10 > A10 彈傷 </option>
<option value= A11 > A11 斷裂 </option>
<option value= A12 > A12 雞爪 </option>
<option value= A13 > A13 包風 </option>
<option value= A14 > A14 鉸鍊歪斜 </option>
<option value= A15 > A15 倒邊, 唇邊 </option>
<option value= A16 > A16 冷料痕 </option>
<option value= A17 > A17 脫皮 </option>
<option value= A18 > A18 氣泡 </option>
<option value= A19 > A19 射出不足/縮水/缺料 </option>
<option value= A21 > A21 作號 </option>
<option value= A22 > A22 分模線 </option>
<option value= A23 > A23 肉粒, 毛邊 </option>
<option value= A24 > A24 色差/色點 </option>
<option value= A25 > A25 模傷/夾傷 </option>
<option value= A26 > A26 裂痕 </option>
<option value= A27 > A27 片模仁受損 </option>
<option value= A28 > A28 油痕 </option>
<option value= A29 > A29 射出重量太輕/太重 </option>
<option value= A30 > A30 研磨受損 </option>
<option value= A31 > A31 C-size偏大或過小 </option>
<option value= B01 > B01 擦傷, ,  </option>
<option value= B02 > B02 轉印破損 </option>
<option value= B03 > B03 掉漆,  </option>
<option value= B04 > B04 水染不良 </option>
<option value= B05 > B05 水痕 </option>
<option value= B06 > B06 染料附著 </option>
<option value= B07 > B07 色差 </option>
<option value= B08 > B08 噴漆不良, 不均 </option>
<option value= B09 > B09 金油不足, 不均 </option>
<option value= B10 > B10 刻字模糊 </option>
<option value= B11 > B11 吊色 </option>
<option value= B12 > B12 橘皮 </option>
<option value= B13 > B13 流膏/垂流 </option>
<option value= B14 > B14 痱子 </option>
<option value= B15 > B15 背噴過度 </option>
<option value= B16 > B16 作號 </option>
<option value= B17 > B17 遮噴不良 </option>
<option value= B18 > B18 變黃 </option>
<option value= B19 > B19 噴錯型體 </option>
<option value= B20 > B20 磨後不良, 見底 </option>
<option value= B21 > B21 水轉不良 </option>
<option value= B22 > B22 水標不良 </option>
<option value= B23 > B23 熱轉不良 </option>
<option value= B24 > B24 雜點, 色點 </option>
<option value= B25 > B25 夾具痕 </option>
<option value= B26 > B26 油點 </option>
<option value= B27 > B27 棉絮 </option>
<option value= B28 > B28 砂點, 砂粒 </option>
<option value= B29 > B29 髒污 </option>
<option value= B30 > B30 附著度不佳 </option>
<option value= B31 > B31 夾具造成變形 </option>
<option value= C01 > C01 刻字錯誤 </option>
<option value= C02 > C02 變形 </option>
<option value= C03 > C03 包風 </option>
<option value= C04 > C04 射包不足/缺料/縮水 </option>
<option value= C06 > C06 冷料痕 </option>
<option value= C07 > C07 毛邊 </option>
<option value= C08 > C08 灌口不良 </option>
<option value= C09 > C09 分模線 </option>
<option value= C10 > C10 結合線過深 </option>
<option value= C11 > C11 壓傷 </option>
<option value= C12 > C12 色點 </option>
<option value= C13 > C13 色差 </option>
<option value= C14 > C14 脫皮 </option>
<option value= C15 > C15 橘皮, 透底色 </option>
<option value= C16 > C16 模具受損 </option>
<option value= C17 > C17 磁極錯誤 </option>
<option value= C18 > C18 軟料斷差 </option>
<option value= C19 > C19 射包附著度不佳 </option>
<option value= C20 > C20 C-size偏大或過小 </option>
<option value= D01 > D01 字體糢糊/掉字 </option>
<option value= D02 > D02 字型錯誤 </option>
<option value= D03 > D03 未印字 </option>
<option value= D04 > D04 位置錯誤 </option>
<option value= E01 > E01 點漆不良 </option>
<option value= E03 > E03 組片不良 </option>
<option value= E04 > E04 組合或黏貼錯誤 </option>
<option value= E05 > E05 鼻墊/飾片/耳扣/泡棉未牢固 </option>
<option value= E07 > E07 高低腳 </option>
<option value= E08 > E08 腳尾距不良 </option>
<option value= E09 > E09 開合有異音 </option>
<option value= E11 > E11 刮傷 </option>
<option value= E12 > E12 飾片/鼻墊顏色異常 </option>
<option value= E13 > E13 左右腳/轉軸鬆緊度不同 </option>
<option value= E14 > E14 撇腳/軟腳 </option>
<option value= E15 > E15 出貨短少 </option>
<option value= E16 > E16 鏡片刮傷 </option>
<option value= E17 > E17 印字不良 </option>
<option value= E18 > E18 轉軸失效 </option>
<option value= E19 > E19 泡棉附著度不佳 </option>
<option value= E19 > E19 掉漆 </option>
<option value= E20 > E20 螺絲凸出 </option>
<option value= E20 > E20 刮傷 </option>
<option value= E21 > E21 缺少組件(鼻墊/飾片/頭帶/泡棉/說明書等) </option>
<option value= E21 > E21 出貨延遲 </option>
<option value= E23 > E23 頭帶異常(Logo/位置/顏色錯誤) </option>
<option value= E25 > E25 配件遺失(泡棉/內片/鏡片/飾片等) </option>
<option value= L01 > L01 鏡片擦傷, 刮傷 </option>
<option value= L02 > L02 灌口不良 </option>
<option value= L03 > L03 拋光不良 </option>
<option value= L04 > L04 裁片片型不良 </option>
<option value= L05 > L05 鏡片鑽孔走位 </option>
<option value= L06 > L06 鐳刻字體錯誤 </option>
<option value= L07 > L07 鏡片裂片/斷裂 </option>
<option value= L08 > L08 鏡片應力過大 </option>
<option value= L09 > L09 片緣過利 </option>
<option value= L10 > L10 強化痕 </option>
<option value= L11 > L11 鍍膜色差 </option>
<option value= L12 > L12 鏡片砂點 </option>
<option value= L13 > L13 鏡片色差 </option>
<option value= L14 > L14 鏡片裂膜/脫膜 </option>
<option value= L15 > L15 跳片/鏡片脫離 </option>
<option value= L16 > L16 光學量測未過 </option>
<option value= L17 > L17  配戴舒適感不佳 </option>
<option value= L18 > L18 鏡片有不明痕跡 </option>
<option value= O01 > O01 混料 </option>
<option value= O02 > O02 製令單錯誤 </option>
<option value= O03 > O03 數量短缺 </option>
<option value= O99 > O99 其他 </option>
		</select></div>
			<div class="col-xs-1">數量：</div>
			<div class="col-xs-1"><input style="width:50px" id="DefectNumber5" name="DefectNumber5" type="number"  style="ime-mode:disabled" onkeyup="return ValidateNumber(this,value)"  maxlength="5" tabindex=7/></div>
			<div class="col-xs-1">備註：</div>
			<div class="col-xs-1"><input style="width:200px" id="DefectRemark5" name="DefectRemark5" type="string"></div>
		</div>
		<div class="row" id="default4" style="display:none">
			<br><div class="col-xs-1"></div>
			<div class="col-xs-2">不良原因：</div>
			<div class="col-xs-2"><select id="D6" style="width:150px;" name="input_name6" type="string" >
			<option value= "Not" selected> =請選擇不良原因= </option>
			<option value= A01 > A01 撬傷 </option>
<option value= A02 > A02 表面擦傷(刮傷) </option>
<option value= A03 > A03 拖傷 </option>
<option value= A04 > A04 螺絲孔NG </option>
<option value= A05 > A05 刻字錯誤 </option>
<option value= A06 > A06 變形 </option>
<option value= A07 > A07 灌口不良 </option>
<option value= A08 > A08 拋光/剪澆口不良 </option>
<option value= A09 > A09 白霧 </option>
<option value= A10 > A10 彈傷 </option>
<option value= A11 > A11 斷裂 </option>
<option value= A12 > A12 雞爪 </option>
<option value= A13 > A13 包風 </option>
<option value= A14 > A14 鉸鍊歪斜 </option>
<option value= A15 > A15 倒邊, 唇邊 </option>
<option value= A16 > A16 冷料痕 </option>
<option value= A17 > A17 脫皮 </option>
<option value= A18 > A18 氣泡 </option>
<option value= A19 > A19 射出不足/縮水/缺料 </option>
<option value= A21 > A21 作號 </option>
<option value= A22 > A22 分模線 </option>
<option value= A23 > A23 肉粒, 毛邊 </option>
<option value= A24 > A24 色差/色點 </option>
<option value= A25 > A25 模傷/夾傷 </option>
<option value= A26 > A26 裂痕 </option>
<option value= A27 > A27 片模仁受損 </option>
<option value= A28 > A28 油痕 </option>
<option value= A29 > A29 射出重量太輕/太重 </option>
<option value= A30 > A30 研磨受損 </option>
<option value= A31 > A31 C-size偏大或過小 </option>
<option value= B01 > B01 擦傷, ,  </option>
<option value= B02 > B02 轉印破損 </option>
<option value= B03 > B03 掉漆,  </option>
<option value= B04 > B04 水染不良 </option>
<option value= B05 > B05 水痕 </option>
<option value= B06 > B06 染料附著 </option>
<option value= B07 > B07 色差 </option>
<option value= B08 > B08 噴漆不良, 不均 </option>
<option value= B09 > B09 金油不足, 不均 </option>
<option value= B10 > B10 刻字模糊 </option>
<option value= B11 > B11 吊色 </option>
<option value= B12 > B12 橘皮 </option>
<option value= B13 > B13 流膏/垂流 </option>
<option value= B14 > B14 痱子 </option>
<option value= B15 > B15 背噴過度 </option>
<option value= B16 > B16 作號 </option>
<option value= B17 > B17 遮噴不良 </option>
<option value= B18 > B18 變黃 </option>
<option value= B19 > B19 噴錯型體 </option>
<option value= B20 > B20 磨後不良, 見底 </option>
<option value= B21 > B21 水轉不良 </option>
<option value= B22 > B22 水標不良 </option>
<option value= B23 > B23 熱轉不良 </option>
<option value= B24 > B24 雜點, 色點 </option>
<option value= B25 > B25 夾具痕 </option>
<option value= B26 > B26 油點 </option>
<option value= B27 > B27 棉絮 </option>
<option value= B28 > B28 砂點, 砂粒 </option>
<option value= B29 > B29 髒污 </option>
<option value= B30 > B30 附著度不佳 </option>
<option value= B31 > B31 夾具造成變形 </option>
<option value= C01 > C01 刻字錯誤 </option>
<option value= C02 > C02 變形 </option>
<option value= C03 > C03 包風 </option>
<option value= C04 > C04 射包不足/缺料/縮水 </option>
<option value= C06 > C06 冷料痕 </option>
<option value= C07 > C07 毛邊 </option>
<option value= C08 > C08 灌口不良 </option>
<option value= C09 > C09 分模線 </option>
<option value= C10 > C10 結合線過深 </option>
<option value= C11 > C11 壓傷 </option>
<option value= C12 > C12 色點 </option>
<option value= C13 > C13 色差 </option>
<option value= C14 > C14 脫皮 </option>
<option value= C15 > C15 橘皮, 透底色 </option>
<option value= C16 > C16 模具受損 </option>
<option value= C17 > C17 磁極錯誤 </option>
<option value= C18 > C18 軟料斷差 </option>
<option value= C19 > C19 射包附著度不佳 </option>
<option value= C20 > C20 C-size偏大或過小 </option>
<option value= D01 > D01 字體糢糊/掉字 </option>
<option value= D02 > D02 字型錯誤 </option>
<option value= D03 > D03 未印字 </option>
<option value= D04 > D04 位置錯誤 </option>
<option value= E01 > E01 點漆不良 </option>
<option value= E03 > E03 組片不良 </option>
<option value= E04 > E04 組合或黏貼錯誤 </option>
<option value= E05 > E05 鼻墊/飾片/耳扣/泡棉未牢固 </option>
<option value= E07 > E07 高低腳 </option>
<option value= E08 > E08 腳尾距不良 </option>
<option value= E09 > E09 開合有異音 </option>
<option value= E11 > E11 刮傷 </option>
<option value= E12 > E12 飾片/鼻墊顏色異常 </option>
<option value= E13 > E13 左右腳/轉軸鬆緊度不同 </option>
<option value= E14 > E14 撇腳/軟腳 </option>
<option value= E15 > E15 出貨短少 </option>
<option value= E16 > E16 鏡片刮傷 </option>
<option value= E17 > E17 印字不良 </option>
<option value= E18 > E18 轉軸失效 </option>
<option value= E19 > E19 泡棉附著度不佳 </option>
<option value= E19 > E19 掉漆 </option>
<option value= E20 > E20 螺絲凸出 </option>
<option value= E20 > E20 刮傷 </option>
<option value= E21 > E21 缺少組件(鼻墊/飾片/頭帶/泡棉/說明書等) </option>
<option value= E21 > E21 出貨延遲 </option>
<option value= E23 > E23 頭帶異常(Logo/位置/顏色錯誤) </option>
<option value= E25 > E25 配件遺失(泡棉/內片/鏡片/飾片等) </option>
<option value= L01 > L01 鏡片擦傷, 刮傷 </option>
<option value= L02 > L02 灌口不良 </option>
<option value= L03 > L03 拋光不良 </option>
<option value= L04 > L04 裁片片型不良 </option>
<option value= L05 > L05 鏡片鑽孔走位 </option>
<option value= L06 > L06 鐳刻字體錯誤 </option>
<option value= L07 > L07 鏡片裂片/斷裂 </option>
<option value= L08 > L08 鏡片應力過大 </option>
<option value= L09 > L09 片緣過利 </option>
<option value= L10 > L10 強化痕 </option>
<option value= L11 > L11 鍍膜色差 </option>
<option value= L12 > L12 鏡片砂點 </option>
<option value= L13 > L13 鏡片色差 </option>
<option value= L14 > L14 鏡片裂膜/脫膜 </option>
<option value= L15 > L15 跳片/鏡片脫離 </option>
<option value= L16 > L16 光學量測未過 </option>
<option value= L17 > L17  配戴舒適感不佳 </option>
<option value= L18 > L18 鏡片有不明痕跡 </option>
<option value= O01 > O01 混料 </option>
<option value= O02 > O02 製令單錯誤 </option>
<option value= O03 > O03 數量短缺 </option>
<option value= O99 > O99 其他 </option>
		</select></div>
			<div class="col-xs-1">數量：</div>
			<div class="col-xs-1"><input style="width:50px" id="DefectNumber6" name="DefectNumber6" type="number"  style="ime-mode:disabled" onkeyup="return ValidateNumber(this,value)"  maxlength="5" tabindex=7/></div>
			<div class="col-xs-1">備註：</div>
			<div class="col-xs-1"><input style="width:200px" id="DefectRemark6" name="DefectRemark6" type="string"></div>
		</div>
		<div class="row" id="default5" style="display:none">
			<br><div class="col-xs-1"></div>
			<div class="col-xs-2">不良原因：</div>
			<div class="col-xs-2"><select id="D7" style="width:150px;" name="input_name7" type="string" >
			<option value= "Not" selected> =請選擇不良原因= </option>
			<option value= A01 > A01 撬傷 </option>
<option value= A02 > A02 表面擦傷(刮傷) </option>
<option value= A03 > A03 拖傷 </option>
<option value= A04 > A04 螺絲孔NG </option>
<option value= A05 > A05 刻字錯誤 </option>
<option value= A06 > A06 變形 </option>
<option value= A07 > A07 灌口不良 </option>
<option value= A08 > A08 拋光/剪澆口不良 </option>
<option value= A09 > A09 白霧 </option>
<option value= A10 > A10 彈傷 </option>
<option value= A11 > A11 斷裂 </option>
<option value= A12 > A12 雞爪 </option>
<option value= A13 > A13 包風 </option>
<option value= A14 > A14 鉸鍊歪斜 </option>
<option value= A15 > A15 倒邊, 唇邊 </option>
<option value= A16 > A16 冷料痕 </option>
<option value= A17 > A17 脫皮 </option>
<option value= A18 > A18 氣泡 </option>
<option value= A19 > A19 射出不足/縮水/缺料 </option>
<option value= A21 > A21 作號 </option>
<option value= A22 > A22 分模線 </option>
<option value= A23 > A23 肉粒, 毛邊 </option>
<option value= A24 > A24 色差/色點 </option>
<option value= A25 > A25 模傷/夾傷 </option>
<option value= A26 > A26 裂痕 </option>
<option value= A27 > A27 片模仁受損 </option>
<option value= A28 > A28 油痕 </option>
<option value= A29 > A29 射出重量太輕/太重 </option>
<option value= A30 > A30 研磨受損 </option>
<option value= A31 > A31 C-size偏大或過小 </option>
<option value= B01 > B01 擦傷, ,  </option>
<option value= B02 > B02 轉印破損 </option>
<option value= B03 > B03 掉漆,  </option>
<option value= B04 > B04 水染不良 </option>
<option value= B05 > B05 水痕 </option>
<option value= B06 > B06 染料附著 </option>
<option value= B07 > B07 色差 </option>
<option value= B08 > B08 噴漆不良, 不均 </option>
<option value= B09 > B09 金油不足, 不均 </option>
<option value= B10 > B10 刻字模糊 </option>
<option value= B11 > B11 吊色 </option>
<option value= B12 > B12 橘皮 </option>
<option value= B13 > B13 流膏/垂流 </option>
<option value= B14 > B14 痱子 </option>
<option value= B15 > B15 背噴過度 </option>
<option value= B16 > B16 作號 </option>
<option value= B17 > B17 遮噴不良 </option>
<option value= B18 > B18 變黃 </option>
<option value= B19 > B19 噴錯型體 </option>
<option value= B20 > B20 磨後不良, 見底 </option>
<option value= B21 > B21 水轉不良 </option>
<option value= B22 > B22 水標不良 </option>
<option value= B23 > B23 熱轉不良 </option>
<option value= B24 > B24 雜點, 色點 </option>
<option value= B25 > B25 夾具痕 </option>
<option value= B26 > B26 油點 </option>
<option value= B27 > B27 棉絮 </option>
<option value= B28 > B28 砂點, 砂粒 </option>
<option value= B29 > B29 髒污 </option>
<option value= B30 > B30 附著度不佳 </option>
<option value= B31 > B31 夾具造成變形 </option>
<option value= C01 > C01 刻字錯誤 </option>
<option value= C02 > C02 變形 </option>
<option value= C03 > C03 包風 </option>
<option value= C04 > C04 射包不足/缺料/縮水 </option>
<option value= C06 > C06 冷料痕 </option>
<option value= C07 > C07 毛邊 </option>
<option value= C08 > C08 灌口不良 </option>
<option value= C09 > C09 分模線 </option>
<option value= C10 > C10 結合線過深 </option>
<option value= C11 > C11 壓傷 </option>
<option value= C12 > C12 色點 </option>
<option value= C13 > C13 色差 </option>
<option value= C14 > C14 脫皮 </option>
<option value= C15 > C15 橘皮, 透底色 </option>
<option value= C16 > C16 模具受損 </option>
<option value= C17 > C17 磁極錯誤 </option>
<option value= C18 > C18 軟料斷差 </option>
<option value= C19 > C19 射包附著度不佳 </option>
<option value= C20 > C20 C-size偏大或過小 </option>
<option value= D01 > D01 字體糢糊/掉字 </option>
<option value= D02 > D02 字型錯誤 </option>
<option value= D03 > D03 未印字 </option>
<option value= D04 > D04 位置錯誤 </option>
<option value= E01 > E01 點漆不良 </option>
<option value= E03 > E03 組片不良 </option>
<option value= E04 > E04 組合或黏貼錯誤 </option>
<option value= E05 > E05 鼻墊/飾片/耳扣/泡棉未牢固 </option>
<option value= E07 > E07 高低腳 </option>
<option value= E08 > E08 腳尾距不良 </option>
<option value= E09 > E09 開合有異音 </option>
<option value= E11 > E11 刮傷 </option>
<option value= E12 > E12 飾片/鼻墊顏色異常 </option>
<option value= E13 > E13 左右腳/轉軸鬆緊度不同 </option>
<option value= E14 > E14 撇腳/軟腳 </option>
<option value= E15 > E15 出貨短少 </option>
<option value= E16 > E16 鏡片刮傷 </option>
<option value= E17 > E17 印字不良 </option>
<option value= E18 > E18 轉軸失效 </option>
<option value= E19 > E19 泡棉附著度不佳 </option>
<option value= E19 > E19 掉漆 </option>
<option value= E20 > E20 螺絲凸出 </option>
<option value= E20 > E20 刮傷 </option>
<option value= E21 > E21 缺少組件(鼻墊/飾片/頭帶/泡棉/說明書等) </option>
<option value= E21 > E21 出貨延遲 </option>
<option value= E23 > E23 頭帶異常(Logo/位置/顏色錯誤) </option>
<option value= E25 > E25 配件遺失(泡棉/內片/鏡片/飾片等) </option>
<option value= L01 > L01 鏡片擦傷, 刮傷 </option>
<option value= L02 > L02 灌口不良 </option>
<option value= L03 > L03 拋光不良 </option>
<option value= L04 > L04 裁片片型不良 </option>
<option value= L05 > L05 鏡片鑽孔走位 </option>
<option value= L06 > L06 鐳刻字體錯誤 </option>
<option value= L07 > L07 鏡片裂片/斷裂 </option>
<option value= L08 > L08 鏡片應力過大 </option>
<option value= L09 > L09 片緣過利 </option>
<option value= L10 > L10 強化痕 </option>
<option value= L11 > L11 鍍膜色差 </option>
<option value= L12 > L12 鏡片砂點 </option>
<option value= L13 > L13 鏡片色差 </option>
<option value= L14 > L14 鏡片裂膜/脫膜 </option>
<option value= L15 > L15 跳片/鏡片脫離 </option>
<option value= L16 > L16 光學量測未過 </option>
<option value= L17 > L17  配戴舒適感不佳 </option>
<option value= L18 > L18 鏡片有不明痕跡 </option>
<option value= O01 > O01 混料 </option>
<option value= O02 > O02 製令單錯誤 </option>
<option value= O03 > O03 數量短缺 </option>
<option value= O99 > O99 其他 </option>
		</select></div>
			<div class="col-xs-1">數量：</div>
			<div class="col-xs-1"><input style="width:50px" id="DefectNumber7" name="DefectNumber7" type="number"  style="ime-mode:disabled" onkeyup="return ValidateNumber(this,value)"  maxlength="5" tabindex=7/></div>
			<div class="col-xs-1">備註：</div>
			<div class="col-xs-1"><input style="width:200px" id="DefectRemark7" name="DefectRemark7" type="string"></div>
		</div>
		<div class="row" id="default6" style="display:none">
			<br><div class="col-xs-1"></div>
			<div class="col-xs-2">不良原因：</div>
			<div class="col-xs-2"><select id="D8" style="width:150px;" name="input_name8" type="string" >
			<option value= "Not" selected> =請選擇不良原因= </option>
			<option value= A01 > A01 撬傷 </option>
<option value= A02 > A02 表面擦傷(刮傷) </option>
<option value= A03 > A03 拖傷 </option>
<option value= A04 > A04 螺絲孔NG </option>
<option value= A05 > A05 刻字錯誤 </option>
<option value= A06 > A06 變形 </option>
<option value= A07 > A07 灌口不良 </option>
<option value= A08 > A08 拋光/剪澆口不良 </option>
<option value= A09 > A09 白霧 </option>
<option value= A10 > A10 彈傷 </option>
<option value= A11 > A11 斷裂 </option>
<option value= A12 > A12 雞爪 </option>
<option value= A13 > A13 包風 </option>
<option value= A14 > A14 鉸鍊歪斜 </option>
<option value= A15 > A15 倒邊, 唇邊 </option>
<option value= A16 > A16 冷料痕 </option>
<option value= A17 > A17 脫皮 </option>
<option value= A18 > A18 氣泡 </option>
<option value= A19 > A19 射出不足/縮水/缺料 </option>
<option value= A21 > A21 作號 </option>
<option value= A22 > A22 分模線 </option>
<option value= A23 > A23 肉粒, 毛邊 </option>
<option value= A24 > A24 色差/色點 </option>
<option value= A25 > A25 模傷/夾傷 </option>
<option value= A26 > A26 裂痕 </option>
<option value= A27 > A27 片模仁受損 </option>
<option value= A28 > A28 油痕 </option>
<option value= A29 > A29 射出重量太輕/太重 </option>
<option value= A30 > A30 研磨受損 </option>
<option value= A31 > A31 C-size偏大或過小 </option>
<option value= B01 > B01 擦傷, ,  </option>
<option value= B02 > B02 轉印破損 </option>
<option value= B03 > B03 掉漆,  </option>
<option value= B04 > B04 水染不良 </option>
<option value= B05 > B05 水痕 </option>
<option value= B06 > B06 染料附著 </option>
<option value= B07 > B07 色差 </option>
<option value= B08 > B08 噴漆不良, 不均 </option>
<option value= B09 > B09 金油不足, 不均 </option>
<option value= B10 > B10 刻字模糊 </option>
<option value= B11 > B11 吊色 </option>
<option value= B12 > B12 橘皮 </option>
<option value= B13 > B13 流膏/垂流 </option>
<option value= B14 > B14 痱子 </option>
<option value= B15 > B15 背噴過度 </option>
<option value= B16 > B16 作號 </option>
<option value= B17 > B17 遮噴不良 </option>
<option value= B18 > B18 變黃 </option>
<option value= B19 > B19 噴錯型體 </option>
<option value= B20 > B20 磨後不良, 見底 </option>
<option value= B21 > B21 水轉不良 </option>
<option value= B22 > B22 水標不良 </option>
<option value= B23 > B23 熱轉不良 </option>
<option value= B24 > B24 雜點, 色點 </option>
<option value= B25 > B25 夾具痕 </option>
<option value= B26 > B26 油點 </option>
<option value= B27 > B27 棉絮 </option>
<option value= B28 > B28 砂點, 砂粒 </option>
<option value= B29 > B29 髒污 </option>
<option value= B30 > B30 附著度不佳 </option>
<option value= B31 > B31 夾具造成變形 </option>
<option value= C01 > C01 刻字錯誤 </option>
<option value= C02 > C02 變形 </option>
<option value= C03 > C03 包風 </option>
<option value= C04 > C04 射包不足/缺料/縮水 </option>
<option value= C06 > C06 冷料痕 </option>
<option value= C07 > C07 毛邊 </option>
<option value= C08 > C08 灌口不良 </option>
<option value= C09 > C09 分模線 </option>
<option value= C10 > C10 結合線過深 </option>
<option value= C11 > C11 壓傷 </option>
<option value= C12 > C12 色點 </option>
<option value= C13 > C13 色差 </option>
<option value= C14 > C14 脫皮 </option>
<option value= C15 > C15 橘皮, 透底色 </option>
<option value= C16 > C16 模具受損 </option>
<option value= C17 > C17 磁極錯誤 </option>
<option value= C18 > C18 軟料斷差 </option>
<option value= C19 > C19 射包附著度不佳 </option>
<option value= C20 > C20 C-size偏大或過小 </option>
<option value= D01 > D01 字體糢糊/掉字 </option>
<option value= D02 > D02 字型錯誤 </option>
<option value= D03 > D03 未印字 </option>
<option value= D04 > D04 位置錯誤 </option>
<option value= E01 > E01 點漆不良 </option>
<option value= E03 > E03 組片不良 </option>
<option value= E04 > E04 組合或黏貼錯誤 </option>
<option value= E05 > E05 鼻墊/飾片/耳扣/泡棉未牢固 </option>
<option value= E07 > E07 高低腳 </option>
<option value= E08 > E08 腳尾距不良 </option>
<option value= E09 > E09 開合有異音 </option>
<option value= E11 > E11 刮傷 </option>
<option value= E12 > E12 飾片/鼻墊顏色異常 </option>
<option value= E13 > E13 左右腳/轉軸鬆緊度不同 </option>
<option value= E14 > E14 撇腳/軟腳 </option>
<option value= E15 > E15 出貨短少 </option>
<option value= E16 > E16 鏡片刮傷 </option>
<option value= E17 > E17 印字不良 </option>
<option value= E18 > E18 轉軸失效 </option>
<option value= E19 > E19 泡棉附著度不佳 </option>
<option value= E19 > E19 掉漆 </option>
<option value= E20 > E20 螺絲凸出 </option>
<option value= E20 > E20 刮傷 </option>
<option value= E21 > E21 缺少組件(鼻墊/飾片/頭帶/泡棉/說明書等) </option>
<option value= E21 > E21 出貨延遲 </option>
<option value= E23 > E23 頭帶異常(Logo/位置/顏色錯誤) </option>
<option value= E25 > E25 配件遺失(泡棉/內片/鏡片/飾片等) </option>
<option value= L01 > L01 鏡片擦傷, 刮傷 </option>
<option value= L02 > L02 灌口不良 </option>
<option value= L03 > L03 拋光不良 </option>
<option value= L04 > L04 裁片片型不良 </option>
<option value= L05 > L05 鏡片鑽孔走位 </option>
<option value= L06 > L06 鐳刻字體錯誤 </option>
<option value= L07 > L07 鏡片裂片/斷裂 </option>
<option value= L08 > L08 鏡片應力過大 </option>
<option value= L09 > L09 片緣過利 </option>
<option value= L10 > L10 強化痕 </option>
<option value= L11 > L11 鍍膜色差 </option>
<option value= L12 > L12 鏡片砂點 </option>
<option value= L13 > L13 鏡片色差 </option>
<option value= L14 > L14 鏡片裂膜/脫膜 </option>
<option value= L15 > L15 跳片/鏡片脫離 </option>
<option value= L16 > L16 光學量測未過 </option>
<option value= L17 > L17  配戴舒適感不佳 </option>
<option value= L18 > L18 鏡片有不明痕跡 </option>
<option value= O01 > O01 混料 </option>
<option value= O02 > O02 製令單錯誤 </option>
<option value= O03 > O03 數量短缺 </option>
<option value= O99 > O99 其他 </option>
		</select></div>
			<div class="col-xs-1">數量：</div>
			<div class="col-xs-1"><input style="width:50px" id="DefectNumber8" name="DefectNumber8" type="number"  style="ime-mode:disabled" onkeyup="return ValidateNumber(this,value)"  maxlength="5" tabindex=7/></div>
			<div class="col-xs-1">備註：</div>
			<div class="col-xs-1"><input style="width:200px" id="DefectRemark8" name="DefectRemark8" type="string"></div>
		</div>
		<div class="row">
		<br>
			<div class="col-xs-4"></div>		
			<div class="col-xs-2"><input type="button" id="button_hide" value="-" class="btn" onclick="do_hide()"/></div>
			<div class="col-xs-2"><input type="button" id="button_show" value="+" class="btn" onclick="do_show()"/></div>
		</div>
		<br></td></tr></table>
		

<script language="javascript">
var col_opened=1;

function do_hide()
{
	if(col_opened>=2){
		var div = document.getElementById("default"+(col_opened-1));
		div.style.display = 'none';
		col_opened--;
	}
}
function do_show()
{
	if(col_opened<=6){
		var div = document.getElementById("default"+col_opened);
		div.style.display = '';
		col_opened++;
	}
}
</script>
		<div class="row">
		<br>
			<div class="col-xs-4"></div>
			<div class="col-xs-2"><button type="reset" class="btn btn-primary">重置</button></div>
			<div class="col-xs-4"><button type="submit"  id="submitbutton" class="btn btn-success">送出</button></div>
		</div>

	</div>
	</div>

</body>
</html>