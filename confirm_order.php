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

//pull cart from session
$cart = array();
$cart = $_SESSION['cart'];

$isbnArray = array_keys($cart);
$quantityArray = array_values($cart);

//grab the key from cart
$isbn = array_keys($cart);
//convert the array to a string
$isbn = implode("','", $isbn);
//grab the value from cart
$quantity = array_values($cart);
//convert the array to a string
$quantity = implode("','", $quantity);

$totalPrice = 0;

$query = "SELECT price FROM books WHERE isbn IN ('$isbn')";
$result = $dbConnection->query($query);
//calculate the total price based on the book price and quantity of each book
while ($row = $result->fetch_assoc()) {
	//convert $quantity to an integer
	$quantity = (int)$quantity;
	$totalPrice += $row['price'] * $quantity;
}


$username = $_SESSION['username'];

//display the customer information in a table 
$query = "SELECT * FROM customer WHERE username = '$username'";
$result = $dbConnection->query($query);
$row = $result->fetch_assoc();
$firstname = $row['fname'];
$lastname = $row['lname'];
$address = $row['custaddress'];
$city = $row['city'];
$state = $row['custState'];
$cardtype = $row['cardType'];
$cardnumber = $row['cardNo'];

//put them all in session
$_SESSION['firstname'] = $firstname;
$_SESSION['lastname'] = $lastname;
$_SESSION['address'] = $address;
$_SESSION['city'] = $city;
$_SESSION['state'] = $state;
$_SESSION['cardtype'] = $cardtype;
$_SESSION['cardnumber'] = $cardnumber;

echo "<table align='center' style='border:2px solid blue;''>";
echo "<caption>Customer Information</caption>";
echo "<tr>";
echo "<td>Shipping Address:</td>";
echo "</tr>";
echo "<td colspan='2'>$firstname $lastname</td>";
echo "<form action=confirm_order.php method='post'>";
echo "<td rowspan='3' colspan='2'><input type='radio' name='cardgroup' value='profile_card' checked>Use Credit card on file<br />$cardtype - $cardnumber <br/><input type='radio' name='cardgroup' value='new_card'>New Credit Card<br /><select id='credit_card' name='credit_card'><option selected disabled>select a card type</option><option>VISA</option><option>MASTER</option><option>DISCOVER</option></select><input type='text' id='card_number' name='card_number' placeholder='Credit card number'><br /></td>";
//button to add a new credit card
echo "<td rowspan='5' colspan='3'><input type='submit' name='new-card' value='Add Credit Card'</td>";
echo "</form>";
echo "<tr>";
echo "<td colspan='2'>$address</td>";
echo "</tr>";
echo "<tr>";
echo "<td colspan='2'>$city, $state</td>";
echo "</tr>";
echo "<tr>";
echo "<form action='confirm_order.php' method='post'>";
echo "<td colspan='2'><input type='submit' name='confirm-order' value='Confirm Order'></td>";
echo "</form>";
echo "</tr>";
//update customer profile button
echo "<tr>";
echo "<td colspan='2'><form action='update_customerprofile.php' method='post'><input type='submit' value='Update Profile'></form></td>";
echo "</tr>";
echo "</table>";
echo "</form>";

echo "<table align='center' style='border:2px solid blue;''>";
echo "<caption>Order Details</caption>";
echo "<tr>";
echo "<th>Item</th>";
echo "<th>Quantity</th>";
echo "<th>Price</th>";
echo "<th>Total Price</th>";
echo "</tr>";
foreach ($isbnArray as $isbn) {
	$query = "SELECT title, price FROM books WHERE ISBN IN ('$isbn')";
	$result = $dbConnection->query($query);
	$row = $result->fetch_assoc();
	$title = $row['title'];
	$price = $row['price'];
	$quantity = (int)$quantity;
	//loop through and display the title, quantity, and price for each book in the cart
	echo "<tr>";
	echo "<td>$title</td>";
	echo "<td>$quantity</td>";
	echo "<td>$price</td>";
}
echo "<td>$totalPrice</td>";
echo "</tr>";
echo "</table>";

$_SESSION['totalPrice'] = $totalPrice;


if (isset($_POST['new-card'])) {
	//replace the credit card on file with the new credit card
	$cardtype = $_POST['credit_card'];
	$cardnumber = $_POST['card_number'];
	$query = "UPDATE customer SET cardType = '$cardtype', cardNo = '$cardnumber' WHERE username = '$username'";
	//execute the query
	$result = $dbConnection->query($query);
	//JS alert
	echo "<script type='text/javascript'>alert('Credit card updated!');</script>";

}

if (isset($_POST['confirm-order'])) {
	//insert the order into the database
	$orderID = rand(100000, 999999);
	$customerUsername = $_SESSION['username'];
	$orderDate = date("Y-m-d");
	
	//write the query to insert into the orders table
	//if there are multiple isbn's in the cart, then we need to insert multiple rows into the orders table
	$query = "INSERT INTO orders (orderID, customerUsername, ISBN, quantity, orderDate, totalPrice) VALUES ('$orderID', '$customerUsername', '$isbn', '$quantity', '$orderDate', '$totalPrice')";
	//execute the query
	$result = $dbConnection->query($query);
	//JS alert
	echo "<script type='text/javascript'>alert('Order confirmed!');</script>";
	//redirect to the order confirmation page
	header("Location: proof_purchase.php");
}

?>

