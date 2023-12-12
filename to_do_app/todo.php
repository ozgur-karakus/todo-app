<?php
require_once('createDB.php');
createDb();

session_start();


?>

<style>
    :root {
        --blue: #063375;
        --darkblue: #1b71b8;
        --darkestblue: #3f97d8;
        --light: #ebe8d6;
        --yellow: #e3b135;
        --darkyellow: #de9024;
        --orange: #d75619;
        --darkorange: #b64d36;
        --gray: #6b7280;
        --dark: #374151;
        --darker: #1f2937;
        --darkest: #111827;
    }

    * {
        box-sizing: border-box;
        margin: 0;
        font-family: 'fira sans', sans-serif;
    }


    body {
        font-family: 'fira sans', sans-serif;
        background-image: linear-gradient(to bottom right, var(--blue), var(--darkblue), var(--darkestblue), var(--light), var(--darkyellow), var(--darkorange), var(--orange));
        color: #de9024;
    }

    header {
        margin: 0 auto;
    }

    header h1 {
        font-size: 2.5rem;
        color: var(--dark);
        margin-bottom: 1rem;
    }

    #login-box {
        position: absolute;
        top: 10px;
        right: 10px;
    }

    button[type="submit"] {
        background-color: #1f2937;
        color: #ebe8d6;
        border: none;
        padding: 5px 10px;
        border-radius: 3px;
        cursor: pointer;
    }

    #new-task-form {
        display: flex;
    }

    input,
    button {
        appearance: none;
        border: none;
        outline: none;
        background: none;
    }

    #new-task-input {
        flex: 1 1 0%;
        background-color: var(--darker);
        padding: 1rem;
        border-radius: 1rem;
        margin-right: 1rem;
        color: var(--darkyellow);
        font-size: 1.25rem;
    }

    #new-task-input::placeholder {
        color: var(--darkyellow);
    }

    #new-task-submit {
        color: var(--light);
        font-size: 1.25rem;
        font-weight: 700;
        background-color: #1f2937;
        cursor: pointer;
        transition: 0.4s;
        padding: 1rem;
        border-radius: 1rem;
    }

    #new-task-submit:hover {
        opacity: 0.8;
    }

    #new-task-submit:active {
        opacity: 0.6;
    }

    main {
        flex: 1 1 0%;
        padding: 2rem 1rem;
        max-width: 800px;
        width: 100%;
        margin: 0 auto;
    }

    .task-list {
        padding: 1rem;
    }

    .task-list h2 {
        font-size: 1.5rem;
        color: var(--dark);
        margin-bottom: 1rem;
    }


    #tasks .list-group-item {
        display: flex;
        justify-content: space-between;
        background-color: var(--darker);
        padding: 1rem;
        border-radius: 1rem;
        margin-bottom: 1rem;
        align-items: center;
    }

    .task .actions .Edit {
        background-color: blue;
        color: white;
    }

    .task .actions .Delete {
        background-color: #1b71b8;
        color: #1b71b8;
    }

    #tasks .list-group-item span {
        flex: 1;
        color: var(--darkyellow);
        font-size: 1.125rem;
    }

    #tasks .list-group-item button {
        cursor: pointer;
        font-size: 1.125rem;
        font-weight: 700;
        text-transform: uppercase;
        margin-left: 1rem;
    }

    #tasks .list-group-item .btn-danger {
        color: #ebe8d6;
    }


    .filtered-tasks {
        background-color: #d75619;
        padding: 1rem;
        border-radius: 1rem;
    }
</style>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do App</title>

    <link rel="stylesheet" href="css/bootstrap.min.css">

</head>

<body>
    <?php
    $pdo = new PDO("sqlite:database/todo.db");

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $userId = $_SESSION['userId'];

        $newTask = $_POST['newTask'];

        if (!empty($newTask)) {
            $stmt = $pdo->prepare('INSERT INTO tasks (userId,description) VALUES (:userId,:description)');
            $stmt->bindParam(':userId', $userId);
            $stmt->bindParam(':description', $newTask, PDO::PARAM_STR);
            $stmt->execute();

            header("Location: todo.php");
        }

        if (isset($_GET['tasks'])) {
            $task = $_GET['description'];
            $taskId = $_POST['taskId'];

            if (!empty($editedTask)) {
                editTask($pdo, $description, $taskId);
            }
        }
    }

    $filter = isset($_GET['filter']) ? $_GET['filter'] : '';
    $tasks = [];

    if (!empty($filter)) {
        $userId = $_SESSION['userId'];

        $stmt = $pdo->prepare('SELECT taskId, description FROM tasks WHERE description LIKE :filter AND userId = :userId');
        $stmt->bindValue(':filter', '%' . $filter . '%', PDO::PARAM_STR);
        $stmt->bindValue(':userId', $userId);
        $stmt->execute();
    } else {
        $userId = $_SESSION['userId'];

        $stmt = $pdo->query("SELECT taskId, description FROM tasks WHERE userId = $userId");
    }

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $tasks[] = $row;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['delete'])) {

        $taskId = $_GET['delete'];
        $stmt = $pdo->prepare('DELETE FROM tasks WHERE taskId = :taskId');
        $stmt->bindParam(':taskId', $taskId, PDO::PARAM_INT);
        $stmt->execute();

        header("Location: todo.php");
    }

    function editTask($pdo, $description, $taskId)
    {
        $stmt = $pdo->prepare('UPDATE tasks SET description = :description WHERE taskId = :taskId');
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':taskId', $taskId, PDO::PARAM_INT);
        $stmt->execute();
    }
    ?>

    <div class="container">
        <header>

            <h1 class="mt-4">To-Do App</h1>
            <div id="login-box" class="d-flex justify-content-end mt-3">
                <form method="post" action="logout.php">
                    <button type="submit" class="btn btn-danger" name="logout">Çıkış Yap</button>
                </form>
            </div>
            <form id="new-task-form" method="post" class="mt-3">
                <div class="input-group">
                    <input type="text" id="new-task-input" name="newTask" class="form-control" placeholder="Yeni Görev Ekle" required />
                    <button type="submit" id="new-task-submit" class="btn btn-primary">Ekle</button>
                </div>
            </form>
        </header>
        <main>
            <section class="task-list mt-4">
                <div id="search-box">
                    <form method="get" action="todo.php">
                        <div class="input-group">

                            <input type="text" id="task-filter" name="filter" class="form-control" placeholder="Görevleri Filtrele" value="<?php echo htmlspecialchars($filter); ?>" />
                            <button type="submit" class="btn btn-secondary">Filtrele</button>
                        </div>
                    </form>
                </div>
                <h2 class="mt-4">Görevler</h2>
                <div id="tasks">
                    <ul class="list-group">
                        <?php foreach ($tasks as $task) : ?>

                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span><?php echo htmlspecialchars($task['description']); ?></span>
                                <div>
                                    <a class="btn btn-primary Edit" data-toggle="modal" href=<?php echo "duzenle.php?taskId=".$task['taskId'] ?>>Düzenle</a>
                                    <a href="?delete=<?php echo $task['taskId']; ?>" class="btn btn-danger Delete">Sil</a>
                                </div>
                            </li>


                            <div class="modal fade" id="editTaskModal<?php echo $task['taskId']; ?>" tabindex="-1" aria-labelledby="editTaskModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editTaskModalLabel">Görevi Düzenle</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form method="post" action="todo.php">
                                            <div class="modal-body">
                                                <input type="hidden" name="taskId" value="<?php echo $task['taskId']; ?>">
                                                <div class="form-group">
                                                    <label for="editedTask">Yeni Görev İçeriği</label>

                                                    <input type="text" class="form-control" id="editedTask" name="editedTask" value="<?php echo htmlspecialchars($task['description']); ?>" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">

                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
                                                <button type="submit" class="btn btn-primary" name="editTask">Kaydet</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </section>
        </main>
    </div>

</body>

</html>