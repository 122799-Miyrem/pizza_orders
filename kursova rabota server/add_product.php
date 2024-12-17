<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    if (!empty($name) && !empty($price)) {
        $conn = db_connect();
        $stmt = $conn->prepare("INSERT INTO products (name, price, description) VALUES (?, ?, ?)");
        $stmt->bind_param("sds", $name, $price, $description);

        if ($stmt->execute()) {
            echo "Продуктът е добавен успешно!";
        } else {
            echo "Грешка при добавяне на продукта: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "Всички полета са задължителни!";
    }
}
?>
