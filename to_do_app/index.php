<?php
session_start();

if (isset($_POST["login"])) {
    $username = strip_tags(trim($_POST["username"]));
    $password = strip_tags(trim($_POST["password"]));

    $db = new PDO('sqlite:database/todo.db');

    $query = $db->prepare("SELECT * FROM users WHERE username = :username AND  password = :password");
    $query->bindParam(':username', $username, PDO::PARAM_STR);
    $query->bindParam(':password', $password, PDO::PARAM_STR);
    $query->execute();
    $control = $query->fetch(PDO::FETCH_ASSOC);

    if ($control != null) {
        session_start();

        $_SESSION['userId'] = $control['userId'];
        $_SESSION["username"] = $control['username'];
        $_SESSION["email"] = $control['email'];

        header("Location: todo.php");
        return;
    } else {
        echo "<center><h1>Yanlış kullanıcı adı veya şifre!</h1></center>";
    }
}
?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>

        body {
            background-color: #111827;
            color: #ebe8d6;
        }

        .container {
            margin-top: 200px;
        }
        button[name="login"] {
    background-color: #de9024;
        }
        button[name="login"]:hover {
    background-color: #ffae42;
}

    </style>
</head>

<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h2 class="text-center">Giriş Yap</h2>
                        <form method="POST">
                            <div class="mb-3">
                                <label for="username" class="form-label">Kullanıcı Adı</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Şifre</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" name="login" class="btn btn-primary">Giriş Yap</button>
                            </div>
                            <p class="text-center mt-3">
                                Hesabınız yok mu? <a href="register.php">Kaydolun</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
