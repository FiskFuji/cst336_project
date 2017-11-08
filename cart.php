<?php
session_start();
$_SESSION['cart'] = array();
$_SESSION['cart'][0] = $_POST['passedVal'];

if(isset($_SESSION['Cart'])){
    echo "<h1>Cart is Empty!</h1>";
}

echo $_SESSION['cart'][0];


?>