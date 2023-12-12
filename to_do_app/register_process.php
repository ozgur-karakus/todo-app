<?php
session_start();

if (isset($_POST["register"])) {
    $username = strip_tags(trim($_POST["username"]));
    $password = strip_tags(trim($_POST["password"]));

    $db = new PDO('sqlite:database/todo.db');

    $checkUsernameQuery = "SELECT COUNT(*) FROM users WHERE username = :username";
    $stmt = $db->prepare($checkUsernameQuery);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        $errorMessage = "Bu kullanıcı adı zaten kullanılıyor. Lütfen farklı bir kullanıcı adı seçin.";
        $_SESSION["message"] = $errorMessage;
        header("Location: register.php");
        exit;
    }

    $insertUserQuery = "INSERT INTO users (username, password) VALUES (:username, :password)";
    $stmt = $db->prepare($insertUserQuery);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $stmt->execute();

    $_SESSION["message"] = "Kayıt işlemi başarılı. Şimdi giriş yapabilirsiniz.";
    header("Location: index.php");
    exit;
}
?>
