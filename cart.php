<?php
session_start();
//fuck im so sorry
$maxCart = 10;
if($_GET("Add to Cart")){
    $_SESSION['Cart'][$maxCart] = $_GET("Add to Cart");
    $maxCart = $maxCart - 1;
}

if(isset($_SESSION['Cart'][$maxCart])){
    echo "<h1>Cart is Empty!</h1>";
}

print_r($_SESSION['Cart']);


?>