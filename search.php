<?php
include "dbconfig.php";


$con = mysqli_connect($host, $username, $password, $dbname) 
  or die("<br>Cannot connect to DB:$dbname on $host\n");


$keywords=$_GET['keywords'];


$sql ="SELECT * from CPS3740_2023S.Money_manoranl where note like '%$keywords%' ";
echo "<br>SQL: $sql\n";
$result = mysqli_query($con, $sql); 
$rowsql = mysqli_num_rows($result);

$GetSid = "Select name from CPS3740.Sources s, CPS3740_2023S.Money_manoranl m where s.id = m.sid";
$SID = mysqli_query($con, $GetSid);

$sqlAll = "SELECT * from CPS3740_2023S.Money_manoranl";
$All = mysqli_query($con,$sqlAll);
$rowAll = mysqli_num_rows($All);




if ($rowAll > 0) {
	if ($keywords == "*") {
	echo "<TABLE border=1>\n";
	echo "<TR><TH>ID<TH>Code<TH>Type<TH>Amount<TH>Source<TH>Date Time<TH>Note\n";
	while($rowGetAll = mysqli_fetch_array($All)){
	$ID = $rowGetAll["cid"];
	$Code = $rowGetAll["code"];
	$Type = $rowGetAll["type"];
	$Amount = $rowGetAll["amount"];
	$rowSID = mysqli_fetch_array($SID);
	$Source = $rowSID["name"];
	$Date = $rowGetAll["mydatetime"];
	$Note = $rowGetAll["note"];
	if ($Type == "D") {
	$color = "blue";
	}
	else {
	$color = "red";
	}
	echo "<TR><TD>$ID<TD>$Code<TD><font color = '$color'>$Type<TD>$Amount<TD>$Source<TD>$Date<TD>$Note\n";
	}
	echo "</TABLE>\n";
	}
	}
	
	if ($keywords != "*") {
	if ($rowsql==0) {
		  echo "<br>No record found.\n";
	}elseif($rowsql > 0) {
	echo "<TABLE border=1>\n";
	echo "<TR><TH>ID<TH>Code<TH>Type<TH>Amount<TH>Source<TH>Date Time<TH>Note\n";
	while($rowMoney = mysqli_fetch_array($result)){
	$ID = $rowMoney["cid"];
	$Code = $rowMoney["code"];
	$Type = $rowMoney["type"];
	$Amount = $rowMoney["amount"];
	$rowSID = mysqli_fetch_array($SID);
	$Source = $rowSID["name"];
	$Date = $rowMoney["mydatetime"];
	$Note = $rowMoney["note"];
	if ($Type == "D") {
	$color = "blue";
	}
	else {
	$color = "red";
	}
	echo "<TR><TD>$ID<TD>$Code<TD><font color = '$color'>$Type<TD>$Amount<TD>$Source<TD>$Date<TD>$Note\n";
	}
	echo "</TABLE>\n";
	}
	  else {
	  echo "<br>Something wrong. Error: " . mysqli_error($con);
	}
	}
mysqli_free_result($result);
mysqli_close($con); 



?>
