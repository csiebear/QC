<?php
    //The php to get the MO(Manufacturing Order) Information

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
  WHERE [CMOID] like ''');
	
	while ($row = mssql_fetch_assoc ($result)) {
		echo '<tr><td>'.$row["SearchDate"].'</td><td>'.$row["ERP_WSID"].'</td><td>'.iconv("big5","UTF-8",$row["WORKNAME"]).'</td>'.'<td>'.number_format($row["WIP"]).'</td><td>'.$row["UNIT"].'</td></tr>';
		if($numberofline%2==1){
			if($numberofline!==$total_rows-1)
				$data1=$data1.' '.$row["WIP"].',';
			else
				$data1=$data1.' '.$row["WIP"].']';
		}else{
			if($numberofline!==$total_rows)
				$data2=$data2.' '.$row["WIP"].',';
			else
				$data2=$data2.' '.$row["WIP"].']';
		}
		$numberofline++;
	}
