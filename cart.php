<?php
session_start();

if(isset($_SESSION['Cart'])){
    echo "<h1>Cart is Empty!</h1>";
}



?>