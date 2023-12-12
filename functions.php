<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "crud_example";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function getAllUsers() {
    global $conn;
    $sql = "SELECT * FROM usuarios";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $data;
}

function getAllSetores() {
    global $conn;
    $sql = "SELECT * FROM setores";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $data;
}

function getUsersBySetor($setorId) {
    global $conn;
    
    // Verifica se $setorId é vazio ou nulo
    if (empty($setorId)) {
        return getAllUsers();
    }

    $sql = "SELECT usuarios.* FROM usuarios
            INNER JOIN usuario_setor ON usuarios.id = usuario_setor.id_usuario
            WHERE usuario_setor.id_setor = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $setorId);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $data;
}

function getUserSetores($userId) {
    global $conn;
    $sql = "SELECT setores.nome FROM setores
            INNER JOIN usuario_setor ON setores.id = usuario_setor.id_setor
            WHERE usuario_setor.id_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return array_column($data, 'nome');
}

function deleteUser($userId) {
    global $conn;

    // Desvincula o usuário de todos os setores
    $sqlDeleteSetores = "DELETE FROM usuario_setor WHERE id_usuario = ?";
    $stmtDeleteSetores = $conn->prepare($sqlDeleteSetores);
    $stmtDeleteSetores->bind_param("i", $userId);
    $stmtDeleteSetores->execute();
    $stmtDeleteSetores->close();

    // Agora, exclui o usuário
    $sqlDeleteUsuario = "DELETE FROM usuarios WHERE id = ?";
    $stmtDeleteUsuario = $conn->prepare($sqlDeleteUsuario);
    $stmtDeleteUsuario->bind_param("i", $userId);
    $stmtDeleteUsuario->execute();
    $stmtDeleteUsuario->close();
}

function createUser($nome, $email, $setores = []) {
    global $conn;

    $stmt = $conn->prepare("INSERT INTO usuarios (nome, email) VALUES (?, ?)");
    $stmt->bind_param("ss", $nome, $email);
    $stmt->execute();
    $userId = $stmt->insert_id;
    $stmt->close();

    linkSetoresToUser($userId, $setores);
   
    header("Location: index.php");
    exit();

    return $userId;
}

function updateUser($userId, $nome, $email, $setores = []) {
    global $conn;

    $stmt = $conn->prepare("UPDATE usuarios SET nome = ?, email = ? WHERE id = ?");
    $stmt->bind_param("ssi", $nome, $email, $userId);
    $stmt->execute();
    $stmt->close();

    unlinkAllSetoresFromUser($userId);

    linkSetoresToUser($userId, $setores);

    header("Location: index.php");
    exit();
}

function linkSetoresToUser($userId, $setores) {
    global $conn;

    foreach ($setores as $setorId) {
        $stmt = $conn->prepare("INSERT INTO usuario_setor (id_usuario, id_setor) VALUES (?, ?)");
        $stmt->bind_param("ii", $userId, $setorId);
        $stmt->execute();
        $stmt->close();
    }
}

function unlinkAllSetoresFromUser($userId) {
    global $conn;

    $stmt = $conn->prepare("DELETE FROM usuario_setor WHERE id_usuario = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->close();
}

