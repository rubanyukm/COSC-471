<script>alert('Please enter all values')</script><!DOCTYPE HTML>
<?php
session_start();
$username = $_SESSION['username'];

$user = 'admin1';
$pass = 'Admin1Pass4235!a';
$db = 'cosc471';

try {
$dbConnection = new mysqli('localhost', $user, $pass, $db);
} catch (mysqli_sql_exception $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}

if (isset($_POST['update_submit'])) {
	//pull all the values from the form
	$new_pin = $_POST['new_pin'];
	$retypenew_pin = $_POST['retypenew_pin'];
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$address = $_POST['address'];
	$city = $_POST['city'];
	$state = $_POST['state'];
	$zip = $_POST['zip'];
	$credit_card = $_POST['card_number'];
	$credit_card_type = $_POST['credit_card'];
	$credit_card_exp = $_POST['expiration_date'];

	//make sure all fields are filled out
	if (empty($new_pin) || empty($retypenew_pin) || empty($firstname) || empty($lastname) || empty($address) || empty($city) || empty($state) || empty($zip) || empty($credit_card) || empty($credit_card_type) || empty($credit_card_exp)) {
		echo "<script>alert('Please enter all values')</script>";
		echo "<script>window.open('update_customerprofile.php','_self')</script>";
		exit();
	} // check if the new pin and re-type new pin match
	else {
		if ($new_pin != $retypenew_pin) {
			echo "<script>alert('New PIN and Re-type New PIN do not match.')</script>";
			echo "<script>window.open('update_customerprofile.php','_self')</script>";
			exit();
		} 
		else {
			//run a query to update the customer profile
			$update_query = "UPDATE customer SET pin = '$new_pin', fname = '$firstname', lname = '$lastname', custaddress = '$address', city = '$city', custState = '$state', cardNo = '$credit_card', cardType = '$credit_card_type' WHERE username = '$username'";
			//run the query
			$run_query = mysqli_query($dbConnection, $update_query);
			//JS alert to let the user know the update was successful
			echo "<script>alert('Your profile has been updated.')</script>";
			//take the user back to confirm their order
			header('location: confirm_order.php');
		}
	}

}

?>
<head>
<title>UPDATE CUSTOMER PROFILE</title>

</head>
<body>
	<form id="update_profile" action="update_customerprofile.php" method="post">
	<table align="center" style="border:2px solid blue;">
		<tr>
			<td align="right">
				Username: 
			</td>
			<td colspan="3" align="center">
							</td>
		</tr>
		<tr>
			<td align="right">
				New PIN<span style="color:red">*</span>:
			</td>
			<td>
				<input type="text" id="new_pin" name="new_pin">
			</td>
			<td align="right">
				Re-type New PIN<span style="color:red">*</span>:
			</td>
			<td>
				<input type="text" id="retypenew_pin" name="retypenew_pin">
			</td>
		</tr>
		<tr>
			<td align="right">
				First Name<span style="color:red">*</span>:
			</td>
			<td colspan="3">
				<input type="text" id="firstname" name="firstname">
			</td>
		</tr>
		<tr>
			<td align="right"> 
				Last Name<span style="color:red">*</span>:
			</td>
			<td colspan="3">
				<input type="text" id="lastname" name="lastname">
			</td>
		</tr>
		<tr>
			<td align="right">
				Address<span style="color:red">*</span>:
			</td>
			<td colspan="3">
				<input type="text" id="address" name="address">
			</td>
		</tr>
		<tr>
			<td align="right">
				City<span style="color:red">*</span>:
			</td>
			<td colspan="3">
				<input type="text" id="city" name="city">
			</td>
		</tr>
		<tr>
			<td align="right">
				State<span style="color:red">*</span>:
			</td>
			<td>
				<select id="state" name="state">
				<option selected disabled>select a state</option>
				<option>MI</option>
				<option>CA</option>
				<option>TN</option>
				</select>
			</td>
			<td align="right">
				Zip<span style="color:red">*</span>:
			</td>
			<td>
				<input type="text" id="zip" name="zip">
			</td>
		</tr>
		<tr>
			<td align="right">
				Credit Card<span style="color:red">*</span>:
			</td>
			<td>
				<select id="credit_card" name="credit_card">
				<option selected disabled>select a card type</option>
				<option>VISA</option>
				<option>MASTER</option>
				<option>DISCOVER</option>
				</select>
			</td>
			<td align="left" colspan="2">
				<input type="text" id="card_number" name="card_number" placeholder="Credit card number">
			</td>
		</tr>
		<tr>
			<td align="right" colspan="2">
				Expiration Date<span style="color:red">*</span>:
			</td>
			<td colspan="2" align="left">
				<input type="text" id="expiration_date" name="expiration_date" placeholder="MM/YY">
			</td>
		</tr>
		<tr>
			<td align="right" colspan="2">
				<input type="submit" id="update_submit" name="update_submit" value="Update">
			</td>
			</form>
		<form id="cancel" action="index.html" method="post">	
			<td align="left" colspan="2">
				<input type="submit" id="cancel_submit" name="cancel_submit" value="Cancel">
			</td>
		</tr>
	</table>
	</form>
</body>
</html>