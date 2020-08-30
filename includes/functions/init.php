<?php ob_start();

session_start();



include("db.php");
include("functions.php");
if($con){
    echo "Database is connected";
}else{
    echo "No Database Connection";
}


?>