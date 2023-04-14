<?php
session_start();

//pull the books and quantity from the session
$cart  = array();
$cart = $_SESSION['cart'];

//pull isUser from the session
$isUser = $_SESSION['isUser'];

echo "<script type='text/javascript'>alert('You must be a user to checkout.');</script>";

if ($isUser == false) {
    header("Location: customer_registration_screen3.php");
}
else {
    header("Location: confirm_order.php");
}

?>