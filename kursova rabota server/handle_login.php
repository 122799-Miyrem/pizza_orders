<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (!empty($username) && !empty($password)) {
        $conn = db_connect();
        $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                session_start();
                $_SESSION['user_id'] = $user['id'];
                header("Location: home.php");
                exit();
            } else {
                echo "Грешно потребителско име или парола!";
            }
        } else {
            echo "Грешно потребителско име или парола!";
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "Моля, попълнете всички полета!";
    }
}
?>
