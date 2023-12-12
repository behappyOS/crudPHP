<?php
include 'functions.php';

$usuarios = getAllUsers();
$setores = getAllSetores();

if (isset($_GET['setor'])) {
    $usuarios = getUsersBySetor($_GET['setor']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'create':
                createUser($_POST['nome'], $_POST['email'], isset($_POST['setores']) ? $_POST['setores'] : []);
                break;
            case 'update':
                updateUser($_POST['user_id'], $_POST['nome'], $_POST['email'], isset($_POST['setores']) ? $_POST['setores'] : []);
                break;
            case 'delete':
                deleteUser($_POST['user_id']);
                break;
            case 'linkSetores':
                linkSetoresToUser($_POST['user_id'], $_POST['setores']);
                break;
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST["action"] == "delete") {
        $userId = $_POST["user_id"];
        deleteUser($userId);
        // Adiciona redirecionamento após a exclusão
        header("Location: index.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Usuários</title>
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    
    <style>
        .container {
            margin-top: 50px;
        }
    </style>
</head>
<body class="container">

    <h2 class="mb-4">Listar Usuários</h2>

    <form action="index.php" method="get" class="mb-4">
        <div class="form-group">
            <label for="setor">Filtrar por Setor:</label>
            <select name="setor" id="setor" class="form-control">
                <option value="">Todos</option>
                <?php foreach ($setores as $setor): ?>
                    <option value="<?= $setor['id']; ?>" <?= ($_GET['setor'] == $setor['id']) ? 'selected' : ''; ?>>
                        <?= $setor['nome']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Filtrar</button>
    </form>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Setores</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $usuario): ?>
                <tr>
                    <td><?= $usuario['id']; ?></td>
                    <td><?= $usuario['nome']; ?></td>
                    <td><?= $usuario['email']; ?></td>
                    <td><?= implode(', ', getUserSetores($usuario['id'])); ?></td>
                    <td>
                        <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editUserModal<?= $usuario['id']; ?>">Editar</button>
                        <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteUserModal<?= $usuario['id']; ?>">Excluir</button>
                    </td>
                </tr>

                <div class="modal fade" id="editUserModal<?= $usuario['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
                    <?php include 'edit_modal.php'; ?>
                </div>

                <div class="modal fade" id="deleteUserModal<?= $usuario['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
                    <?php include 'delete_modal.php'; ?>
                </div>
            <?php endforeach; ?>
        </tbody>
    </table>

    <button class="btn btn-success" data-toggle="modal" data-target="#createUserModal">Novo Usuário</button>

    <div class="modal fade" id="createUserModal" tabindex="-1" role="dialog" aria-labelledby="createUserModalLabel" aria-hidden="true">
        <?php include 'create_modal.php'; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
