<?php 
session_start();
if($_SESSION["adminid"])
{
session_destroy();
echo "<script> window.location = 'login.php';</script>";

}

?>