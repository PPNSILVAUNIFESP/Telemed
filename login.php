<?php
session_start();
include "php/conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = trim($_POST["login"]);
    $senha = trim($_POST["senha"]);
    
    // Prepara a consulta para verificar o login no banco de dados
    $stmt = $conn->prepare("SELECT senha FROM tbusuarios WHERE login = ?");
    $stmt->bind_param("s", $login);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($senha_db);
        $stmt->fetch();
        
        // Agora a verificação é direta, sem hash
        if ($senha === $senha_db) {
            $_SESSION["login"] = $login;
            header("Location: Cmedico.php");
            exit();
        }
    }
    
    echo "<script>alert('Login ou senha incorretos!'); window.location.href='index.html';</script>";
    $stmt->close();
} else {
    header("Location: index.html");
    exit();
}
?>
