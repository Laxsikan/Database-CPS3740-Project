<?php
if (!isset($_GET['user']))
  die("<BR><front color = red>Must provide keyword user and value");
else
     $myuser=$_GET["user"];
if (!isset($_GET['password']))
   die("<BR><front color = red>Must provide keyword user and value");

   $mypassword=$_GET['password'];

echo "user:$myuser\n";
echo "password:$mypassword\n";
 
$ip = $_SERVER['REMOTE_ADDR'];
echo "<br>Your IP: $ip\n";
$IPv4= explode(".",$ip);

if( ($IPv4[0] . $IPv4[1]=="131.125") || ($IPv4[0]=="10"))

{echo "<br>You are from Kean University.\n";}

else
{echo "<br>You are from Kean University.\n";

}



?>