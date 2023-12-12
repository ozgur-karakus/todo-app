<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kayıt Ol</title>
    <link rel="stylesheet" href="css/bootstrap.min.css"> 
    <style>
        .card{
            margin-top: 200px;
        }
        body {
            background-color: #111827;
            color: #ebe8d6;
        }

        input[type="text"],
        input[type="password"] {
            color: #063375;
            border-radius: 5px;
            padding: 5px;
        }

        button[name="register"] {
            background-color: #de9024;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
        }

        button[name="register"]:hover {
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
                        <h2 class="text-center">Kayıt Ol</h2>
                        <form method="POST" action="register_process.php">
                            <div class="mb-3">
                                <label for="username" class="form-label">Kullanıcı Adı</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Şifre</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" name="register" class="btn btn-primary">Kayıt Ol</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
