<?php
    $server="localhost";
    $user="root";
    $password="";
    $db="shop_db";

// $conn = mysqli_connect($server,$user,$password,$db);
//         if (!$conn){
//             echo mysqli_connect_error($conn);

// }

$conn = mysqli_connect($server,$user,$password,$db)
 or die('connection failed');


?>

