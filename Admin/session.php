<?php 
session_start();
if(!$_SESSION["adminid"])
{
echo "<script> window.location = 'login.php';</script>";

}
?>