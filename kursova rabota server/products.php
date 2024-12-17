<?php
include 'functions.php';

$conn = db_connect();

$result = $conn->query("SELECT * FROM products");

if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>ID</th><th>Име</th><th>Цена</th><th>Количество</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>" . $row['price'] . "</td>";
        echo "<td>" . $row['quantity'] . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "Няма налични продукти.";
}

$conn->close();
?>
