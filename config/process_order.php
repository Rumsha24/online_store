<?php
<?php
// Database connection settings
$servername = "localhost";
$username = "root";
$password = ""; // default XAMPP password
$dbname = "online_store"; // make sure this matches your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$customer_name = $_POST['customer_name'];
$product = $_POST['product'];
$quantity = (int)$_POST['quantity'];
$address = $_POST['address'];

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO orders (customer_name, product, quantity, address) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssis", $customer_name, $product, $quantity, $address);

if ($stmt->execute()) {
    echo "<h2 style='color:#28a745;'>Order placed successfully!</h2>";
    echo "<a href='index.html'>Back to Home</a>";
} else {
    echo "<h2 style='color:#c9184a;'>Error: " . $stmt->error . "</h2>";
}

$stmt->close();
$conn->close();
?>