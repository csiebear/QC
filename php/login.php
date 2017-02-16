<?php
	$url_Homepage="http://192.168.2.17/QC/Index.php";
	$url_QCHome="http://192.168.2.17/QC/Input.php";

	$account=$_POST["account"];//the variable for storing the user account
	$password=$_POST["password"];//the variable for storing the user password
	
	if ($account== '' || $password == '')
	{
		// No login information(the account or password is empty),then come back to the homepage and login again
		echo "<script type='text/javascript'>";
		echo "window.location.href='$url_Homepage'";
		echo "</script>"; 
	}
	else{
		//the account and password both are not empty then check then.
		//connect to the MSSQL database in localhost(IP:192.168.2.17)
		$conn = mssql_connect("192.168.2.17", "sa", "20265001");
		//select the database table and check if it exists or not
		if(!$conn){
			echo '<div class="container">連接伺服器失敗(Connection fail)<br> 請與系統管理員聯絡 <br>';
			echo "<script type='text/javascript'>window.location.href='$url_Homepage</script>";
		}
		//The following two lines is help to remove the error message
		$result = mssql_query("SET ANSI_NULLS ON") or die(mssql_get_last_message());
		$result = mssql_query("SET ANSI_WARNINGS ON") or die(mssql_get_last_message());
	
		//The query fot searching the account
		$data=mssql_query(
		"SET ANSI_NULLS  ON;SET ANSI_WARNINGS  ON;
		SELECT [UserName]
		,[Account]
		,[Password]
		,[AccountType]
		FROM [WebData].[dbo].[WebUser]
		WHERE (Account='$account')
		");
		
		$total_fields=mssql_num_fields($data);
		$total_rows=mssql_num_rows($data);

		//echo '資料列數(The number of the fields): '.$total_fields.'<br>';
		//echo '資料行數(The number of the rows): '.$total_rows.'<br></div>';
		$row = mssql_fetch_array($data);
		//echo iconv("big5","UTF-8",$row["UserName"]);
		//echo $row['Password'];

		if($total_rows==1 && $row['Password']==$password) {
			$UsernameTrans=iconv("big5","UTF-8",$row["UserName"]);
			setcookie("name",$UsernameTrans,time()+60*10, "/");
			echo "<script type='text/javascript'>";
			echo "window.location.href='$url_QCHome'";
			echo "</script>"; 
		}else {
			echo "<script type='text/javascript'>";
			echo "window.location.href='$url_Homepage'";
			echo "</script>"; 
		}
	}
?>
