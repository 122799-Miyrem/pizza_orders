<?php
// Database connection function
function db_connect() {
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "pizza_order";

    $conn = new mysqli($host, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

// Function to fetch all products
function get_products($conn) {
    $query = "SELECT * FROM products";
    $result = $conn->query($query);

    $products = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    }
    return $products;
}

// Function to add a new order
function add_order($conn, $customer_name, $address, $phone, $product_id, $quantity) {
    $stmt = $conn->prepare("INSERT INTO orders (customer_name, address, phone, product_id, quantity) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssii", $customer_name, $address, $phone, $product_id, $quantity);
    $stmt->execute();
    $stmt->close();
}
?>
