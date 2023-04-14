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

$isbn = "";

//pull the isbn from the session if it is set
if (isset($_SESSION['isbn'])) {
    $isbn = $_SESSION['isbn'];
}

//query the database for all the reviews for the book with the isbn
$query = "SELECT * FROM reviews WHERE ISBN = '$isbn'";
$result = $dbConnection->query($query);

//add a text box and a submit button to search for the ISBN of a book and see the reviews for that book
echo "<form action='reviews.php' method='post'>";
echo "<table align='center' style='border:1px solid blue;''>";
echo "<tr>";
echo "<th>ISBN</th>";
echo "</tr>";
echo "<tr>";
echo "<td><input type='text' name='isbn' id='isbn' value='enter an ISBN'></td>";
echo "</tr>";
echo "<tr>";
echo "<td><input type='submit' name='submit' id='submit' value='Submit'></td>";
echo "</tr>";
echo "</table>";

//if the user hits the submit button then display the reviews for the book in a table
if (isset($_POST['submit'])) {
    //pull the isbn from the text box
    $isbn = $_POST['isbn'];
    //query the database for all the reviews for the book with the isbn
    $query = "SELECT * FROM reviews WHERE ISBN = '$isbn'";
    $result = $dbConnection->query($query);
    //if there are no reviews for the book then display a message saying there are no reviews
    if ($result->num_rows == 0) {
        echo "<table align='center' style='border:1px solid blue;''>";
        echo "<tr>";
        echo "<th>Review</th>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>There are no reviews for this book</td>";
        echo "</tr>";
        echo "</table>";
    }
    else {
        //build the table
        echo "<table align='center' style='border:1px solid blue;''>";
        echo "<tr>";
        echo "<th>Review</th>";
        echo "</tr>";
        while ($row = $result->fetch_assoc()) {
            $reviewID = $row['reviewID'];
            $review = $row['reviewText'];
            //put the review in a table 
            echo "<tr>";
            echo "<td>$reviewID</td>";
            echo "<td>$review</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
}
else {
    //display the reviews if there are any reviews for the book 
    if ($result->num_rows > 0) {
        echo "<table align='center' style='border:1px solid blue;''>";
        echo "<tr>";
        echo "<th>Review</th>";
        echo "</tr>";
        while ($row = $result->fetch_assoc()) {
            $reviewID = $row['reviewID'];
            $review = $row['reviewText'];
            //put the review in a table 
            echo "<tr>";
            echo "<td>$reviewID</td>";
            echo "<td>$review</td>";
            echo "</tr>";
        }
    }
    else {
        //display a message if there are no reviews for the book in a table
        echo "<table align='center' style='border:1px solid blue;''>
        <tr>
        <th>Review</th>
        </tr>
        <tr>
        <td>There are no reviews for this book.</td>
        </tr>
        </table>";
    }
}
//back button
echo "<table align='center' style='border:1px solid blue;''>";
echo "<tr>";
echo "<td><a href='screen3.php'>Back</a></td>";
echo "</tr>";
echo "</table>";
?>