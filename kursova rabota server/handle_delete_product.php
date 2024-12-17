<?php
include 'functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];

    if (!empty($id)) {
        $conn = db_connect();

        $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo "Продуктът е изтрит успешно!";
        } else {
            echo "Грешка при изтриване на продукта: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "ID на продукта е задължително.";
    }
}
?>
