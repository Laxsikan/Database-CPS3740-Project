<?php


if (isset($_COOKIE['userid_'])==true){
  
    include "dbconfig.php";
	
	$con = mysqli_connect($host, $username, $password, $dbname);
	
	if ($con==false){
		die("Connection Failed. " . mysqli_connect_error());
		echo "Connection to Database was unsuccesful. Please try again.";
	}
   
    echo "<br><a href='logout.php'>User Logout</a><br>";
    
    $sql = "select * from CPS3740.Sources;";
    $result = mysqli_query($con,$sql);
	
	$name= $_POST['name'];
	$balance = $_POST['balance'];

    echo "<br><u>Add Transaction</u><br>";
    echo "Customer Name: ".$name.". Current balance: ". $balance."";
    
    echo "<br><form name='input' action='insert_transaction.php' method='post' required='required'>
         <input type='hidden' name='name' value='".$name."'>
         <input type='hidden' name='balance' value='".$balance."'>
         Transaction Code: <input type='text' name='code' required='required'>";
    echo "<br><input type='radio' name='type' value='D'>Deposit
         <input type='radio' name='type' value='W'>Withdraw";
    echo "<br>Amount: <input type='text' name='amount' required='required'>";
    echo "<br>Select A Source: <select name='source_id'>
         <option value=''></option>";
          
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_array($result)){
                echo "<option value='".$row['id']."'>".$row['name']."</option>";
            }
        }
    echo "</select>";
    echo "<br>Note: <input type='text' name='note'>";
    echo "<br><input type='submit' value='submit'>
         </form>";

mysqli_close($con);
}
else{
    echo "Invalid." . $_COOKIE['userid_'] ." does not exist!";
    echo "<br><a href='index.html'>Return to home page</a>";
}
?>