<?php
$Connections = mysqli_connect("localhost:3306","root","", "furryc");
    if(mysqli_connect_errno()){
        echo"Failed to connect in mysql" . mysqli_connect_error();
    }else{
        echo"";
    }

?>