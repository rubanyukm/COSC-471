<?php
session_start();

$user = 'admin1';
$pass = 'Admin1Pass4235!a';
$db = 'cosc471';

try {
$dbConnection = new mysqli('localhost', $user, $pass, $db);
} catch (mysqli_sql_exception $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}

//get the username from session
$username = $_SESSION['username'];
//pull cart from session
$cart = array();
$cart = $_SESSION['cart'];

//grab the key from cart
$isbn = array_keys($cart);
//convert the array to a string
$isbn = implode("','", $isbn);
//grab the value from cart
$quantity = array_values($cart);
//convert the array to a string
$quantity = implode("','", $quantity);

$quantity = (int)$quantity;

//get the current time and date
date_default_timezone_set('America/New_York');
$date = date('Y-m-d');
$time = date('H:i:s');

//get the info from session
$address = $_SESSION['address'];
$city = $_SESSION['city'];
$state = $_SESSION['state'];
$cardtype = $_SESSION['cardtype'];
$cardnumber = $_SESSION['cardnumber'];
$total = $_SESSION['totalPrice'];
$firstname = $_SESSION['firstname'];
$lastname = $_SESSION['lastname'];

//create a table that displays isbns, quantities, username, date, time, total price, address, city, state, and card info
echo "<table align='center' style='border:2px solid blue;''>";
echo "<caption>Customer Information</caption>";
echo "<tr>";
echo "<td>Shipping Address:</td>";
echo "</tr>";
echo "<td colspan='2'>$firstname $lastname</td>";
echo "<td rowspan='3' colspan='2'><b>UserID:</b>$username<br /><b>Date:</b>$date<br /><b>Time:</b>$time<br /><b>Card Info:</b>$cardtype<br />$cardnumber</td>";
echo "<tr>";
echo "<td colspan='2'>$address</td>";
echo "</tr>";
echo "<tr>";
echo "<td colspan='2'>$city</td>";
echo "</tr>";
echo "<tr>";
echo "<td colspan='2'>$state</td>";
echo "</tr>";
echo "</table>";

//create a table that displays the isbn, quantity, and total price
echo "<table align='center' style='border:2px solid blue;''>";
echo "<caption>Order Information</caption>";
echo "<tr>";
echo "<th>Book Description</th><th>Qty</th><th>Price</th>";
echo "</tr>";
//query the database for the book info
$query = "SELECT * FROM books WHERE ISBN IN ('$isbn')";
$result = mysqli_query($dbConnection, $query);

//display the book info in a table
while ($row = mysqli_fetch_array($result)) {
	$isbn = $row['ISBN'];
	$title = $row['title'];
	$author = $row['Author'];
	$price = $row['price'];
	echo "<tr>";
	echo "<td>$title<br />$author</td>";
	echo "<td>$quantity</td>";
	echo "<td>$price</td>";
	echo "</tr>";
}
echo "<tr>";
echo "<td colspan='2'>Total</td>";
echo "<td>$total</td>";
echo "</tr>";
echo "</table>";

//button to take the user back to index.php
echo "<p align='center'><a href='index.php'>Back to Home</a></p>";

//let the user know that they will receive their books in a few days
echo "<p align='center'>Your order will be shipped in 3-5 business days.</p>";


?>

