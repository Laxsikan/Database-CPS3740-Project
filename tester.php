<?php
include "dbconfig.php";
$con=mysqli_connect($hostname,$username,$password,$dbname)
or die("<br>Cannont connect to DB\n");
$query = "Select fName from dreamhome.Staff where sex ='FF' and salary > 2000";
$result = mysqli_query($con,$query);
if($result){
    if(mysqli_num_rows($result>0))
    echo "Monkey\n";
    else
    echo "Tiger\n";
}
else
   echo "Dog\n";

   mysqli_close($con);
?>
