<?php

include "dbconfig.php"; 

session_start();

if (isset($_COOKIE['userid_'])==true){
   
    include "dbconfig.php";
	
	$con = mysqli_connect($host, $username, $password, $dbname);
	
	if ($con==false){
		die("Connection Failed. " . mysqli_connect_error());
		echo "Connection to Database was unsuccesful. Please try again.";
	}
    
    $sql="select mid, code,cid,type, amount, y.name as source,mydatetime,note from
    CPS3740_2023S.Money_manoranl x, CPS3740.Sources y where x.sid=y.id and cid='".$_COOKIE['userid_']."';";
    $result = mysqli_query($con,$sql);
    if(mysqli_num_rows($result)>0){
        
        $balance=0;
        $ct=0;
        
        echo"You can only udpdate Note column.";
       
        echo "<form action='update_transaction.php' method='post'>
        <br><table border=1>
        <tr> 
        <th>ID</th>
        <th>Code</th>
        <th>Type</th>
        <th>Amount</th>
        <th>Source</th>
        <th>Date/Time</th>
        <th>Note</th>
        <th>Delete</th>
        </tr>";
            while($row=mysqli_fetch_array($result)){
                echo "<tr>";
                echo "<td>".$row['mid']."</td>";
                echo "<td>".$row['code']."</td>";
               
                if ($row['type'] == 'D'){
                    echo "<td>Deposit</td>";
                    echo "<td style='color:Blue'>+".$row['amount']."</td>";
                    $balance= $row['amount']+$balance;
                }
                else{
              
                echo "<td>Withdrawal</td>";
                echo "<td style='color:Red'>-".$row['amount']."</td>";
                $balance = $balance - $row['amount'];
                 }
                echo "<td>".$row['source']."</td>";
                echo "<td>".$row['mydatetime']."</td>";
               
               echo "<td><input type='text' value='".$row['note']."' name='notes[".$ct."]'
               style='background-color: yellow'</td>";
               
               echo "<td><input type='checkbox' name='delete[".$ct."]'></td>";
               echo "<input type='hidden' value='".$row['code']."' name='codes[".$ct."]'>";
               echo "<input type='hidden' value='".$row['mid']."' name='mids[".$ct."]'>";
               echo "</tr>";
               $ct=$ct+1;
            }
                          
                            echo "</table>";
                            
                            if($balance>0){
                                echo "<br>Balance: <span style='color:Blue'>$".$balance."</span>";
                            }
                            elseif ($balance<0){
                                
                                echo "<br>Balance: <span style='color:Red'>$".$balance."</span>";
                            }
            echo "<br><input type='submit' value='Update Transaction'> </form>";
    }
    elseif($result==false){
        echo "<br>SQL failed.";
    }
mysqli_close($con);
}
else{
    echo "Invalid." . $_COOKIE['userid_'] ." does not exist!";
    echo "<br><a href='index.html'>Return to home page</a>";
}
?>