<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Duzenle</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.5.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #111827;
            color: #374151;
            padding: 50px;
        }

        .container {
            background-color: #ebe8d6;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
        }

        input[type="text"] {
            background-color: white ;
            color: #212529;
            border-radius: 5px;
            padding: 5px;
        }

        .btn-primary {
            background-color:#de9024 ;
            border: none;
        }

    
    </style>
</head>

<body>
    <?php
    if (isset($_POST['newTask'])) {
        $taskId = $_GET['taskId'];
        $deger = $_POST['newTask'];

        $pdo = new PDO("sqlite:database/todo.db");

        $pdo->exec("UPDATE tasks SET description = '$deger' WHERE taskId = $taskId");
        header("Location: todo.php");
        return;
    }
    ?>
    <div class="container mt-5">
        <form id="new-task-form" method="post">
            <div class="input-group">
                <input type="text" id="new-task-input" name="newTask" class="form-control" placeholder="Yeni Görev Ekle" required />
                <div class="input-group-append">
                    <button type="submit" id="new-task-submit" class="btn btn-primary">Düzenle</button>
                </div>
            </div>
        </form>
    </div>
</body>

</html>
