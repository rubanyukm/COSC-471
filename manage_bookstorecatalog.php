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

//create a table with a form to add a new book
echo "<table align='center' style='border:2px solid blue;'>";
echo "<tr>";
echo "<th>ISBN</th>";
echo "<th>Title</th>";
echo "<th>Author</th>";
echo "<th>Publisher</th>";
echo "<th>Category</th>";
echo "<th>Price</th>";
echo "</tr>";
echo "<tr>";
echo "<form action='manage_bookstorecatalog.php' method='post'>";
echo "<td><input type='text' name='isbn' id='isbn' value='enter an ISBN'></td>";
echo "<td><input type='text' name='title' id='title' value='enter a title'></td>";
echo "<td><input type='text' name='author' id='author' value='enter an author'></td>";
echo "<td><input type='text' name='publisher' id='publisher' value='enter a publisher'></td>";
echo "<td><input type='text' name='category' id='category' value='enter a category'></td>";
echo "<td><input type='text' name='price' id='price' value='enter a price'></td>";
echo "<td><input type='submit' name='add' id='add' value='Add'></td>";
echo "</form>";

//pull all the books from the DB 
$query = "SELECT * FROM books";
$result = $dbConnection->query($query);

//display the books in a table
echo "<table align='center' style='border:2px solid blue;'>";
echo "<tr>";
echo "<th>ISBN</th>";
echo "<th>Title</th>";
echo "<th>Author</th>";
echo "<th>Publisher</th>";
echo "<th>Category</th>";
echo "<th>Price</th>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row['ISBN'] . "</td>";
    echo "<td>" . $row['title'] . "</td>";
    echo "<td>" . $row['Author'] . "</td>";
    echo "<td>" . $row['publisher'] . "</td>";
    echo "<td>" . $row['category'] . "</td>";
    echo "<td>" . $row['price'] . "</td>";
    //add a delete button by each book
    echo "<td><form action='manage_bookstorecatalog.php' method='post'>";
    echo "<input type='hidden' name='isbn' value='" . $row['ISBN'] . "'>";
    echo "<input type='submit' name='delete' value='Delete'>";
    echo "</form></td>";
    echo "</tr>";
}
echo "</table>";

//back button 
echo "<form action='admin_tasks.php' method='post' align='center'>";
echo "<input type='submit' name='back' value='Back'>";
echo "</form>";

if (isset($_POST['delete'])) {
    $isbn = $_POST['isbn'];
    $query = "DELETE FROM books WHERE ISBN = '$isbn'";
    $result = $dbConnection->query($query);
    header("Location: manage_bookstorecatalog.php");
}

if (isset($_POST['add'])) {
    $isbn = $_POST['isbn'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $publisher = $_POST['publisher'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $query = "INSERT INTO books (ISBN, title, Author, publisher, category, price) VALUES ('$isbn', '$title', '$author', '$publisher', '$category', '$price')";
    $result = $dbConnection->query($query);
    header("Location: manage_bookstorecatalog.php");
}

?>