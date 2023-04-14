<!-- UI: Prithviraj Narahari, php code: Alexander Martens -->
<head>
<title> CUSTOMER REGISTRATION </title>
</head>
<body>
<?php
session_start();

//pull the books and quantity from the session
$cart  = array();
$cart = $_SESSION['cart'];

$user = 'admin1';
$pass = 'Admin1Pass4235!a';
$db = 'cosc471';

try {
$dbConnection = new mysqli('localhost', $user, $pass, $db) or die("Unable to connect");
} catch (mysqli_sql_exception $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}

$username = "";
$pin = "";
$retype_pin = "";
$firstname = "";
$lastname = "";
$address = "";
$city = "";
$state = "";
$cardType = "";
$cardNumber = "";

$isUser = $_SESSION['isUser'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

	if (!empty($_POST['username'])) {
    	$username = $_POST['username'];
	}
	if (!empty($_POST['pin'])) {
		$pin = $_POST['pin'];
	}
	if (!empty($_POST['retype_pin'])) {
		$retype_pin = $_POST['retype_pin'];
	}
	if (!empty($_POST['firstname'])) {
		$firstname = $_POST['firstname'];
	}
	if (!empty($_POST['lastname'])) {
		$lastname = $_POST['lastname'];
	}
	if (!empty($_POST['address'])) {
		$address = $_POST['address'];
	}
	if (!empty($_POST['city'])) {
		$city = $_POST['city'];
	}
	if (!empty($_POST['state'])) {
		$state = $_POST['state'];	
	}
	if (!empty($_POST['credit_card'])) {
		$cardType = $_POST['credit_card'];
	}
	if (!empty($_POST['card_number'])) {
		$cardNumber = $_POST['card_number'];
	}
    
    //if statements to check if fields are valid
    if (!preg_match("/^[a-zA-Z ]*$/",$firstname)) {
        echo "<script type='text/javascript'>alert('First name must contain only letters.');</script>";
    }
    if (!preg_match("/^[a-zA-Z ]*$/",$lastname)) {
        echo "<script type='text/javascript'>alert('Last name must contain only letters.');</script>";
    }
    if (!preg_match("/^[a-zA-Z ]*$/",$city)) {
        echo "<script type='text/javascript'>alert('City must contain only letters.');</script>";
    }
    if (!preg_match("/^[a-zA-Z ]*$/",$state)) {
        echo "<script type='text/javascript'>alert('State must contain only letters.');</script>";
    }
    if (!preg_match("/^[0-9]*$/",$cardNumber)) {
        echo "<script type='text/javascript'>alert('Credit card number must contain only numbers.');</script>";
    }
    if (strlen($username) > 20) {
        echo "<script type='text/javascript'>alert('Username must be less than 20 characters.');</script>";
    }
    
    if (!empty($username) && !empty($pin) && !empty($retype_pin) && !empty($firstname) && !empty($lastname) && !empty($address) && !empty($city) && !empty($state) && !empty($cardType) && !empty($cardNumber)) {
        //check if PINs match  
        if($pin == $retype_pin) {
            $sql = "SELECT * FROM customer WHERE username = '$username'";
            $result = mysqli_query($dbConnection, $sql);
            //check if the unsername already exists
            if(mysqli_num_rows($result) > 0) {
                echo "<script type='text/javascript'>alert('Username already exists.');</script>";
            }
            else {
                $sql = "INSERT INTO customer (username, pin, fname, lname, custaddress, city, custState, cardType, cardNo) VALUES ('$username', '$pin', '$firstname', '$lastname', '$address', '$city', '$state', '$cardType', '$cardNumber')";
                $result = mysqli_query($dbConnection, $sql);
				$isUser = true;
				$_SESSION['isUser'] = $isUser;
				$_SESSION['cardType'] = $cardType;
				$_SESSION['cardNumber'] = $cardNumber;
				$_SESSION['username'] = $username;
                echo "<script type='text/javascript'>alert('Registration successful.');</script>";
                header("Location: confirm_order.php");
            }
        }
        else {
            echo "<script type='text/javascript'>alert('PINs do not match.');</script>";
        }
	
    }
    else {
        echo "<script type='text/javascript'>alert('All fields are required.');</script>";
    }
}
	
?>
	
	<table align="center" style="border:2px solid blue;">
	<form id="register" action="customer_registration_screen3.php" method="post">
		<tr>
			<td align="right">
				Username<span style="color:red">*</span>:
			</td>
			<td align="left" colspan="3">
				<input type="text" id="username" name="username" placeholder="Enter your username">
			</td>
		</tr>
		<tr>
			<td align="right">
				PIN<span style="color:red">*</span>:
			</td>
			<td align="left">
				<input type="password" id="pin" name="pin">
			</td>
			<td align="right">
				Re-type PIN<span style="color:red">*</span>:
			</td>
			<td align="left">
				<input type="password" id="retype_pin" name="retype_pin">
			</td>
		</tr>
		<tr>
			<td align="right">
				Firstname<span style="color:red">*</span>:
			</td>
			<td colspan="3" align="left">
				<input type="text" id="firstname" name="firstname" placeholder="Enter your firstname">
			</td>
		</tr>
		<tr>
			<td align="right">
				Lastname<span style="color:red">*</span>:
			</td>
			<td colspan="3" align="left">
				<input type="text" id="lastname" name="lastname" placeholder="Enter your lastname">
			</td>
		</tr>
		<tr>
			<td align="right">
				Address<span style="color:red">*</span>:
			</td>
			<td colspan="3" align="left">
				<input type="text" id="address" name="address">
			</td>
		</tr>
		<tr>
			<td align="right">
				City<span style="color:red">*</span>:
			</td>
			<td colspan="3" align="left">
				<input type="text" id="city" name="city">
			</td>
		</tr>
		<tr>
			<td align="right">
				State<span style="color:red">*</span>:
			</td>
			<td align="left">
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
			<td align="left">
				<input type="text" id="zip" name="zip">
			</td>
		</tr>
		<tr>
			<td align="right">
				Credit Card<span style="color:red">*</span>
			</td>
			<td align="left">
				<select id="credit_card" name="credit_card">
				<option selected disabled>select a card type</option>
				<option>VISA</option>
				<option>MASTER</option>
				<option>DISCOVER</option>
				</select>
			</td>
			<td colspan="2" align="left">
				<input type="text" id="card_number" name="card_number" placeholder="Credit card number">
			</td>
		</tr>
		<tr>
			<td colspan="2" align="right">
				Expiration Date<span style="color:red">*</span>:
			</td>
			<td colspan="2" align="left">
				<input type="text" id="expiration" name="expiration" placeholder="MM/YY">
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center"> 
				<input type="submit" id="register_submit" name="register_submit" value="Register">
			</td>
		</form>

			<form id="no_registration" action="index.php" method="post">
			<td colspan="2" align="center">
				<form id="no_registration" action="index.php" method="post">
				<input type="submit" id="donotregister" name="donotregister" value="Don't Register">
			</td>
			</form>
		</tr>
	</table>
</body>
</HTML>