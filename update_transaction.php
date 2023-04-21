<?php

session_start();

if (isset($_COOKIE['userid_'])==true){
   
    include "dbconfig.php";
	
	$con = mysqli_connect($host, $username, $password, $dbname);
	
	if ($con==false){
		die("Connection Failed. " . mysqli_connect_error());
		echo "Connection to Database was unsuccesful. Please try again.";
	}
    
    $mids = $_POST['mids'];
   
    $codes = $_POST['codes'];
    
    $notes = $_POST['notes'];
    
    $notesarr = array();
  
    $deleteaccount= 0;
  
    $updateaccount=0;

    
    $sql = "select mid,note from CPS3740_2023S.Money_manoranl where cid=".$_COOKIE['userid_'].";";
    $result = mysqli_query($con,$sql);
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_array($result)){
            $notesarr[$row['mid']]=$row['note'];
        }
    }
    elseif($result==false){
        echo "sql failed";
    }
    mysqli_free_result($result);
   
    for($i=0;$i<count($mids);$i++){
     $delete[$i]=isset($_POST['delete'][$i]);
    
    if(($delete[$i]==1)){
        $sql = "delete from CPS3740_2023S.Money_manoranl where mid=".$mids[$i].";";
        $result = mysqli_query($con,$sql);
        echo "<br>$sql";
        if($result==false){
           echo "<br>Invalid. Could not delete note ".$sql."";
        }
        else{
            echo "<br>Transaction deleted. Record has been updated ".$codes[$i].": ".$sql."";
            $deleteaccount = $deleteaccount + 1;
        }
    }
    elseif($notes[$i] != $notesarr[$mids[$i]]){
        $sql = "update CPS3740_2023S.Money_manoranl set note='".$notes[$i]."', mydatetime = CURRENT_TIMESTAMP where mid=".$mids[$i].";";
        $result = mysqli_query($con,$sql);
        if($result==false){
           echo "<br>Invalid. Could not update note ".$sql."";
        }
        else{
            echo "<br>Transaction updated. Record ".$codes[$i]." has been updated.";
            $updateaccount = $updateaccount + 1;
        }
    }   
    }
    
    echo "<br><br>Finished deleting ".$deleteaccount." records and updating ".$updateaccount." transactions";
    echo "<br><a href='index.html'>Return to home page</a>";
    
    mysqli_close($con);
}
else{
  
    echo "<br><a href='index.html'>Return to home page</a>";

}
?>