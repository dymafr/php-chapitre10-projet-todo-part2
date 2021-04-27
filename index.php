<?php
require_once 'errors.php';
$filename = __DIR__ . "/data/todos.json";
$error = '';
$todo = '';
$todos = [];

if (file_exists($filename)) {
    $data = file_get_contents($filename);
    $todos = json_decode($data, true) ?? [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'add-todo.php';
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once 'includes/head.php' ?>
    <title>Todo</title>
</head>

<body>
    <div class="container">
        <?php require_once 'includes/header.php' ?>
        <div class="content">
            <div class="todo-container">
                <h1>Ma Todo</h1>
                <form action="/" method="POST" class="todo-form">
                    <input value="<?= $todo ?>" name="todo" type="text">
                    <button class="btn btn-primary">Ajouter</button>
                </form>
                <?php if ($error) : ?>
                    <p class="text-danger"><?= $error ?></p>
                <?php endif; ?>
                <ul class="todo-list">
                    <?php foreach ($todos as $t) : ?>
                        <li class="todo-item <?= $t['done'] ? 'low-opacity' : '' ?>">
                            <span class="todo-name"><?= $t['name'] ?></span>
                            <form action="/modify-todo.php" method="post">
                                <input type="hidden" value="edit" name="action">
                                <input type="hidden" value="<?= $t['id'] ?>" name="id">
                                <button type="submit" class="btn btn-primary btn-small"><?= $t['done'] ? 'Annuler' : 'Valider' ?></button>
                            </form>
                            <form action="/modify-todo.php" method="post">
                                <input type="hidden" value="delete" name="action">
                                <input type="hidden" value="<?= $t['id'] ?>" name="id">
                                <button type="submit" class="btn btn-danger btn-small">Supprimer</button>
                            </form>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <?php require_once 'includes/footer.php' ?>
    </div>

</body>

</html>