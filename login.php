<?php

include "dbconfig.php"; 
$con = mysqli_connect($host, $username, $password, $dbname) 
or die("<br>Cannot connect to DB:$dbname on $host. Error: " .
mysqli_connect_error());
 

$username=$_POST['username'];
$password=$_POST['password'];

$ip =$_SERVER['REMOTE_ADDR']; 
$browser=$_SERVER['HTTP_USER_AGENT'];
$balance=0;
$IPv4= explode(".",$ip); 

$sql= "select *, timestampdiff(year, dob, curdate()) as age from CPS3740.Customers where login='$username'";
$result = mysqli_query($con, $sql); 

if($result==true){
    
    echo "Your IP: ".$_SERVER['REMOTE_ADDR'];
    
    echo "<br>Your Browser and OS: ".$_SERVER['HTTP_USER_AGENT'];
   
    if($IPv4[0]=="10"){
    echo "<br>You are from Kean wifi domain.\n";
    }
    else{
    
    echo "<br>You are not from Kean wifi domain.\n";
    }
    
    echo "<br><a href='logout.php'>User logout</a>";

  
    if (mysqli_num_rows($result)>0) {
        
        while($row = mysqli_fetch_array($result)){
            
            if ($password== $row["password"]){
               
                echo "<br>Login Succesful.\n";
               
                setcookie("userid_",$row['id'],time()+(600), "/");
                
                echo "<br>Welcome Customer: ".$row['name'];
                
                echo "<br>Age: ".$row['age'];
                
                echo "<br>Address: ".$row['street'].", ".$row['city'].", ".$row['state'].", ".$row['zipcode'];
                
                echo "<br><img src='data:image/jpeg;base64,".base64_encode($row['img'])."'>";
              
                $sql_command= "select mid, code, cid, type, amount, y.name as source, mydatetime, note from CPS3740_2023S.Money_manoranl x, CPS3740.Sources y where x.sid=y.id and x.cid='".$row['id']."'";
                $command_result= mysqli_query($con,$sql_command);
                
                if ($command_result==false){
                    
                    echo "<br>Transaction Failed";
                }
                else{
                   
                    if(mysqli_num_rows($command_result)>0){
                       
                        echo "<br>There are ".mysqli_num_rows($command_result)." customer's transactions ".$row['name']."";
                       
                        echo "<br><table border=1>
                            <tr> 
                            <th>ID</th>
                            <th>Code</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Source</th>
                            <th>Date/Time</th>
                            <th>Note</th>
                            </tr>";
                        
                         while ($row_t = mysqli_fetch_array($command_result)){
                            echo "<tr>";
                            echo "<td>".$row_t['mid']."</td>";
                            echo "<td>".$row_t['code']."</td>";
                            
                            if ($row_t['type'] == 'D'){
                                echo "<td>Deposit</td>";
                                echo "<td style='color:Blue'>+".$row_t['amount']."</td>";
                                $balance= $row_t['amount']+$balance;
                            }
                            else{
                           
                            echo "<td>Withdrawal</td>";
                            echo "<td style='color:Red'>-".$row_t['amount']."</td>";
                            $balance = $balance - $row_t['amount'];
                             }
                            echo "<td>".$row_t['source']."</td>";
                            echo "<td>".$row_t['mydatetime']."</td>";
                            echo "<td>".$row_t['note']."</td>";
                            echo "</tr>";
                         }
                            
                            echo "</table>";
                            
                            if($balance>0){
                                echo "<br>Balance: <span style='color:Blue'>".$balance."</span>";
                            }
                            else{
                                
                                echo "<br>Balance: <span style='color:Red'>".$balance."</span>";
                            }
                        }
                        else {
                            echo "<br> Error. No available transactions to display ".$row['name']."<br";
                        }

                    }

                    

                    echo "<br><form action='search.php' method='GET'>
                            Keyword: <input type='text' name='keywords' required='required'>
                            <input type='submit' value='Search Transaction'></form>";
                    echo "<br><form action='add_transaction.php' method='POST'>
                            <input type='hidden' name='name' value='".$row['name']."'>
                            <input type='hidden' name='balance' value='".$balance."'>
                            <input type='submit' value='Add transaction'></form>";
                    echo "<br><a href='display_transaction.php'>Display and Update Transactions</a>";

                }
                else{
                     echo "<br>User $username is in the system, but wrong password.\n";
                     echo "<br><a href='index.html'>Return to home page</a>";
                }

            }
             
        }
        else{
             echo "<br> No such user: $username in the system\n"; 
             echo "<br><a href='index.html'>Return to home page</a>";

        }       
    }
    elseif($result==false){
        echo "<br>Something is wrong with SQL:" .mysqli_error($con);
    }

mysqli_close($con);
?>