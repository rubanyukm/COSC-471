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

$quantity = 0;
$isbnArray = array();
$isUser; 

if (empty($_SESSION['isUser']) || $_SESSION['isUser'] == false) {
	$isUser = false;
}
else {
	$isUser = true;
}

//pull the ISBNs from the session array if it is not empty
if (!empty($_SESSION['cart'])) {
	//pull the ISBNs and the quantities for the specified ISBNs from the session array
	$isbnArray = $_SESSION['cart'];
	/* this is what the session array looks like
	$_SESSION['cart'] = array();
	//for each selected ISBN add it and its quantity to the cart
	for ($i = 0; $i < count($isbn); $i++) {
		$_SESSION['cart'][$isbn[$i]] = $quantity[$i];
	}
	*/
	$isbn = array_keys($isbnArray);
	$quantity = array_values($isbnArray);
	
	//pull the book information from the database for the specified ISBNs
	$query = "SELECT * FROM books WHERE isbn IN (" . implode(',', $isbn) . ")";
	$result = $dbConnection->query($query);

	//display the book information in a table with the quantity and a remove button for each book in the cart and a total price for all books in the cart at the bottom
	echo "<table align='center' style='border:2px solid blue;'>";
	echo "<tr>";
	//create a back button to go back to the search results
	echo "<td align='center'>";
	echo "<form id='back' action='screen3.php' method='post'>";
	echo "<input type='submit' name='back' id='back' value='Back to Search Results'>";
	echo "</form>";
	echo "<td align='center'>";
	echo "<form id='checkout' action='confirm_order.php' method='get'>";
	echo "<input type='submit' name='checkout_submit' id='checkout_submit' value='Proceed to Checkout'>";
	echo "</form>";
	echo "</td>";
	echo "<td align='center'>";
	echo "<form id='new_search' action='screen2.php' method='post'>";
	echo "<input type='submit' name='search' id='search' value='New Search'>";
	echo "</form>";
	echo "</td>";
	echo "<td align='center'>";
	echo "<form id='exit' action='index.php' method='post'>";
	echo "<input type='submit' name='exit' id='exit' value='EXIT 3-B.com'>";
	echo "</form>";
	echo "</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td colspan='3' align='center'>";
	echo "<table align='center' style='border:2px solid blue;'>";
	echo "<tr>";
	echo "<td align='center'>ISBN</td>";
	echo "<td align='center'>Title</td>";
	echo "<td align='center'>Author</td>";
	echo "<td align='center'>Price</td>";
	echo "<td align='center'>Quantity</td>";
	echo "<td align='center'>Update</td>";
	echo "<td align='center'>Remove</td>";
	echo "</tr>";
	$totalPrice = 0;
	while ($row = $result->fetch_assoc()) {
		$isbn = $row['ISBN'];
		$title = $row['title'];
		$author = $row['Author'];
		$price = $row['price'];
		$quantity = $isbnArray[$isbn];
		$totalPrice += $price * $quantity;
		echo "<tr>";
		echo "<td align='center'>" . $isbn . "</td>";
		echo "<td align='center'>" . $title . "</td>";
		echo "<td align='center'>" . $author . "</td>";
		echo "<td align='center'>$" . $price . "</td>";
		//allow the user to edit the quantity of the book in the cart
		echo "<form id='quantity' action='shopping_cart.php' method='post'>";
		echo "<td align='center'><input type='text' name='quantity' id='quantity' value='" . $quantity . "'></td>";
		echo "<input type='hidden' name='isbn' id='isbn' value='" . $isbn . "'>";
		echo "<td align='center'><input type='submit' name='update' id='update' value='Update'></td>";
		//echo "<td align='center'>" . $quantity . "</td>";
		echo "<form id='remove' action='shopping_cart.php' method='post'>";
		echo "<td align='center'><input type='submit' name='remove' id='remove' value='Remove'></td>";
		echo "</form>";
		echo "</tr>";
	}
	echo "<tr>";
	echo "<td colspan='5' align='right'>Total Price:</td>";
	echo "<td align='center'>$" . $totalPrice . "</td>";
	echo "</tr>";
	echo "</table>";
	echo "</td>";
	echo "</tr>";
	echo "</table>";
} else {
	//if the session array is empty display a message that the cart is empty
	echo "<table align='center' style='border:2px solid blue;'>";
	echo "<tr>";
	echo "<td align='center'>";
	echo "<form id='new_search' action='screen2.php' method='post'>";
	echo "<input type='submit' name='search' id='search' value='New Search'>";
	echo "</form>";
	echo "</td>";
	echo "<td align='center'>";
	echo "<form id='exit' action='index.php' method='post'>";
	echo "<input type='submit' name='exit' id='exit' value='EXIT 3-B.com'>";
	echo "</form>";
	echo "</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td colspan='2' align='center'>Your cart is empty.</td>";
	echo "</tr>";
	echo "</table>";
}

if (isset($_POST['remove'])) {
	//remove the specified ISBN from the session array
	unset($_SESSION['cart'][$isbn]);
	//refresh the page
	header("Refresh:0");
}

if (isset($_POST['update'])) {
	//get the quantity from the form
	$quantity = $_POST['quantity'];
	//update the quantity of the specified ISBN in the session array
	$_SESSION['cart'][$isbn] = $quantity;
	//refresh the page
	header("Refresh:0");
}

?>
<!--
<!DOCTYPE HTML>
<head>
	<title>Shopping Cart</title>
	<script>
	//remove from cart
	function del(isbn){
		window.location.href="shopping_cart.html?delIsbn="+ isbn;
	}
	</script>
</head>
<body>
	<table align="center" style="border:2px solid blue;">
		<tr>
			<td align="center">
				<form id="checkout" action="confirm_order.html" method="get">
					<input type="submit" name="checkout_submit" id="checkout_submit" value="Proceed to Checkout">
				</form>
			</td>
			<td align="center">
				<form id="new_search" action="screen2.html" method="post">
					<input type="submit" name="search" id="search" value="New Search">
				</form>								
			</td>
			<td align="center">
				<form id="exit" action="index.html" method="post">
					<input type="submit" name="exit" id="exit" value="EXIT 3-B.com">
				</form>					
			</td>
		</tr>
		<tr>
				<form id="recalculate" name="recalculate" action="" method="post">
			<td  colspan="3">
				<div id="bookdetails" style="overflow:scroll;height:180px;width:400px;border:1px solid black;">
					<table align="center" BORDER="2" CELLPADDING="2" CELLSPACING="2" WIDTH="100%">
						<th width='10%'>Remove</th><th width='60%'>Book Description</th><th width='10%'>Qty</th><th width='10%'>Price</th>
						<tr><td><button name='delete' id='delete' onClick='del("123441");return false;'>Delete Item</button></td><td>iuhdf</br><b>By</b> Avi Silberschatz</br><b>Publisher:</b> McGraw-Hill</td><td><input id='txt123441' name='txt123441' value='1' size='1' /></td><td>12.99</td></tr>					</table>
				</div>
			</td>
		</tr>
		<tr>
			<td align="center">				
					<input type="submit" name="recalculate_payment" id="recalculate_payment" value="Recalculate Payment">
				</form>
			</td>
			<td align="center">
				&nbsp;
			</td>
			<td align="center">			
				Subtotal:  $12.99			</td>
		</tr>
	</table>
</body>
-->