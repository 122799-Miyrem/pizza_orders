<?php
include 'functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    if (!empty($id) && !empty($name) && !empty($price) && !empty($quantity)) {
        $conn = db_connect();

        $stmt = $conn->prepare("UPDATE products SET name = ?, price = ?, quantity = ? WHERE id = ?");
        $stmt->bind_param("sdii", $name, $price, $quantity, $id);

        if ($stmt->execute()) {
            echo "Продуктът е редактиран успешно!";
        } else {
            echo "Грешка при редактиране: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "Всички полета трябва да бъдат попълнени.";
    }
}
?>
