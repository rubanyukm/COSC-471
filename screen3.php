
<!-- Figure 3: Search Result Screen by Prithviraj Narahari, php coding: Alexander Martens -->
<html>
<head>
	<title> Search Result - 3-B.com </title>
</head>
<body>
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

//pull the variables from the session and display the search results
$searchFor = $_SESSION['searchFor'];
$searchOn = $_SESSION['searchOn'];
$category = $_SESSION['category'];

$isUser = $_SESSION['isUser']; 

//the possible categories are Fantasy, Adventure, Fiction, and Horror
//the possible searchOn values are anywhere, title, author, publisher, and isbn

//perform the search based on the searchFor searchOn and category

//if the category = "all" then we don't need to add the category to the query
if ($category == "all") {
	if ($searchOn == "anywhere") {
		$query = "SELECT * FROM books WHERE title LIKE '%$searchFor%' OR author LIKE '%$searchFor%' OR publisher LIKE '%$searchFor%' OR isbn LIKE '%$searchFor%'";
	}
	else if ($searchOn == "title") {
		$query = "SELECT * FROM books WHERE title LIKE '%$searchFor%'";
	}
	else if ($searchOn == "author") {
		$query = "SELECT * FROM books WHERE author LIKE '%$searchFor%'";
	}
	else if ($searchOn == "publisher") {
		$query = "SELECT * FROM books WHERE publisher LIKE '%$searchFor%'";
	}
	else if ($searchOn == "isbn") {
		$query = "SELECT * FROM books WHERE isbn LIKE '%$searchFor%'";
	}
}
else {
	if ($searchOn == "anywhere") {
	$query = "SELECT * FROM books WHERE (title LIKE '%$searchFor%' OR author LIKE '%$searchFor%' OR publisher LIKE '%$searchFor%' OR isbn LIKE '%$searchFor%') AND category LIKE '%$category%'";
	}
	else if ($searchOn == "title") {
	$query = "SELECT * FROM books WHERE title LIKE '%$searchFor%' AND category LIKE '%$category%'";
	}
	else if ($searchOn == "author") {
	$query = "SELECT * FROM books WHERE author LIKE '%$searchFor%' AND category LIKE '%$category%'";
	}
	else if ($searchOn == "publisher") {
	$query = "SELECT * FROM books WHERE publisher LIKE '%$searchFor%' AND category LIKE '%$category%'";
	}
	else if ($searchOn == "isbn") {
	$query = "SELECT * FROM books WHERE isbn LIKE '%$searchFor%' AND category LIKE '%$category%'";
	}
}

//execute the query
$result = mysqli_query($dbConnection, $query);

//display the results in a table with the following columns: title, author, publisher, isbn, price, quantity and add to cart checkbox
//allow the user to update the quantity of the book and add it to the cart by clicking the add to cart button
//the add to cart button should call the screen3.php page and pass the isbn and quantity of the book to the session
//there should also be a manage cart button that allows the user to go to shipping_cart.php and manage the cart
//make the table
//display each book
echo "<table align='center' style='border:1px solid blue;''>";
echo "<tr><th>Title</th><th>Author</th><th>Publisher</th><th>ISBN</th><th>Price</th><th>Quantity</th><th>Add to Cart</th></tr>";

echo "<form action='screen3.php' method='post'>";
while ($row = mysqli_fetch_array($result)) {
	echo "<tr>";
	echo "<td>" . $row['title'] . "</td>";
	echo "<td>" . $row['Author'] . "</td>";
	echo "<td>" . $row['publisher'] . "</td>";
	echo "<td>" . $row['ISBN'] . "</td>";
	echo "<td>" . $row['price'] . "</td>";

	echo "<td><input type='text' name='quantity[]' id='quantity' value='1'></td>";

	echo "<td><input type='checkbox' name='addtocart[]' id='addtocart' value='" . $row['ISBN'] . "'></td>";
	echo "</tr>";
}
echo "<tr>";
echo "<td colspan='7' align='center'>";
echo "<input type='submit' name='add-cart' value='Add to Cart'>";
echo "</td>";
echo "</form>";
//loop through and add a review button for each book on the same row as the book
echo "<td>";
echo "<form action='reviews.php' method='post'>";
echo "<input type='submit' name='review' value='Reviews'>";
echo "</form>";
echo "</td>";
echo "</tr>";

//manage cart button that goes to shopping_cart.php
echo "<tr><td><form action='shopping_cart.php' method='post'><input type='submit' value='Manage Shopping Cart'></form></td></tr>";
//checkout button
echo "<tr><td><form action='isUserCheck.php' method='post'><input type='submit' name='proceed-checkout' value='Checkout'></form></td></tr>";
//button back to home
echo "<tr><td><form action='index.php' method='post'><input type='submit' value='Back to Home'></form></td></tr>";
echo "</table>";

//if the add to cart button is clicked, then add the book and quantity of the book to the session and then cart
if (isset($_POST['add-cart'])) {
	$quantity = $_POST['quantity'];
	$isbn = $_POST['addtocart'];
	$_SESSION['cart'] = array();
	//for each selected ISBN add it and its quantity to the cart
	for ($i = 0; $i < count($isbn); $i++) {
		$_SESSION['cart'][$isbn[$i]] = $quantity[$i];
	}
}



/*if (isset($_POST['proceed-checkout'])) {
	if ($isUser == false) {
		//echo "<header('Location: customer_registration_screen3.php');>";
		echo "<script type='text/javascript'>alert('You must be a user to checkout.');</script>";
	}
	else {
		header("Location: confirm_order.php");
	}
}*/

?>

