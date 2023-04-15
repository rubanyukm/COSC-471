
<!-- Figure 2: Search Screen by Alexander -->
<html>
<head>
	<title>SEARCH - 3-B.com</title>
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

$searchFor = "";
$searchOn = "";
$category = "";

if (isset($_GET['search-submit'])) {
	$searchFor = $_GET['searchfor'];
	$searchOn = $_GET['searchon'];
	$category = $_GET['category'];
	
	if (empty($searchFor)) {
		echo "<script type='text/javascript'>alert('Search field is empty.');</script>";
	} 
	else {
		header("Location: screen3.php");
	}
}

$_SESSION['searchFor'] = $searchFor;
$_SESSION['searchOn'] = $searchOn;
$_SESSION['category'] = $category;


?>
	<table align="center" style="border:1px solid blue;">
		<tr>
			<td>Search for: </td>
			<form action="screen2.php" method="get">
				<td><input name="searchfor" /></td>
				<td><input type="submit" name="search-submit" value="Search" /></td>
		</tr>
		<tr>
			<td>Search In: </td>
				<td>
					<select name="searchon" multiple>
						<option value="anywhere" selected='selected'>Keyword anywhere</option>
						<option value="title">Title</option>
						<option value="author">Author</option>
						<option value="publisher">Publisher</option>
						<option value="isbn">ISBN</option>				
					</select>
				</td>
				<td><a href="shopping_cart.php"><input type="button" name="manage" value="Manage Shopping Cart" /></a></td>
		</tr>
		<tr>
			<td>Category: </td>
				<td><select name="category">
						<option value='all' selected='selected'>All Categories</option>
						<option value='1'>Fantasy</option><option value='2'>Adventure</option><option value='3'>Fiction</option><option value='4'>Horror</option>				</select></td>
			</form>

		<form action="index.php" method="post">	
				<td><input type="submit" name="exit" value="EXIT 3-B.com" /></td>
			</form>
		</tr>
	</table>
</body>
</html>
