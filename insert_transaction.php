<?php

include "dbconfig.php"; 
$con = mysqli_connect($host, $username, $password, $dbname) 
or die("<br>Cannot connect to DB:$dbname on $host. Error: " .
mysqli_connect_error());

$balance=0;

$user=$_COOKIE['userid_'];

$type=$_POST['type'];

$code=$_POST['code'];

$note=$_POST['note'];

$amount=$_POST['amount'];

$source=$_POST['source_id'];

$sql="select type, amount, code 
from CPS3740_2023S.Money_manoranl where cid='".$user."';";

$result = mysqli_query($con,$sql);

if(mysqli_num_rows($result) > 0){
	while($row = mysqli_fetch_array($result)){
		
		if ($row['type'] == 'D'){
			$balance= $row['amount']+$balance;
		}
		else {
			$balance= $balance -$row['amount'];
		}
	}

}

echo "<br><a href='logout.php'>User logout</a>";

if($amount>$balance && $type=='W'){
	echo "<br>You do not have enough funds to withdraw from your account.";
}
elseif($amount<=0){ 
	echo "<br>You cannot input $0 or any negative amount.";
	echo "<br>Please try again.";
}
elseif($source==false){
	echo "<br>You must select a valid source before proceeding";

}

elseif($type!='D' && $type!='W'){
	echo"<br>You must select a valid type of transaction before proceeding";
}
else{
	mysqli_free_result($result);
	
	$sql="select code from CPS3740_2023S.Money_manoranl where code='".$code."'";
	$result= mysqli_query($con,$sql);
	if($result==false){
		echo"<br> SQL error";
	}
	else{
		if(mysqli_num_rows($result)>0){
			echo"<br>Duplicate code. Try again submitting sql to the database";
		}
		else{
			mysqli_free_result($result);
			
			$sql="insert into CPS3740_2023S.Money_manoranl (code, cid, sid, type, amount, mydatetime, note)
			values ('$code',$user,$source,'$type',$amount,CURRENT_TIMESTAMP,'$note');";
			$result= mysqli_query($con,$sql);
			if($result==false){
				echo"<br> Error: Unsuccesful transaction";
			}
			else{
				echo"<br>Succesfully added the transaction!";
				if ($type == 'D'){
					echo "<br>Balance Updated=$".($balance+$amount)."";
				}
				else {
					echo "<br>Balance Updated=$".($balance-$amount)."";
				}
			}

		}
	}

mysqli_close($con);
}
?>