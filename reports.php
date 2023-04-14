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

$sql = "SELECT * FROM customer";
$result = $dbConnection->query($sql);
$num_cust = $result->num_rows;

//display the total number of customers 
echo "<p align='center'>Total number of customers: $num_cust</p>";

$sql = "SELECT * FROM books";
$result = $dbConnection->query($sql);
$num_books = $result->num_rows;

//display the total number of books
echo "<p align='center'>Total number of books: $num_books</p>";

//get the average monthly sales ordered by month and year 
$sql = "SELECT MONTHNAME(orderDate) AS month, YEAR(orderDate) AS year, SUM(totalPrice) AS total FROM orders GROUP BY MONTHNAME(orderDate), YEAR(orderDate)";
$result = $dbConnection->query($sql);
//display the table
echo "<table align='center' style='border:2px solid blue'>";
echo "<tr>";
echo "<th>Month</th>";
echo "<th>Year</th>";
echo "<th>Total</th>";
echo "</tr>";

while ($row = $result->fetch_assoc()) {
    //calculate the yearly average
    $yearly_avg = $row['total'] / 12;
    echo "<tr>";
    echo "<td>" . $row['month'] . "</td>";
    echo "<td>" . $row['year'] . "</td>";
    echo "<td>" . $row['total'] . "</td>";
    echo "</tr>";
    //display the yearly average
    echo "<tr>";
    echo "<td colspan='3' align='center'>Yearly Average: $yearly_avg</td>";
    echo "</tr>";
}
//button to go back to the admin_tasks page
echo "<tr>";
echo "<td colspan='3' align='center'><form action='admin_tasks.php' method='post'>";
echo "<input type='submit' name='back' id='back' value='Back'>";
echo "</form></td>";
echo "</table>";


?>