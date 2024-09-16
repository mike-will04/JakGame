<?php
include "conexao.php";
session_start();

$comentario = $_POST['comentario'];
$iduser = $_SESSION['iduser'];
$id_jogo = $_GET['id'];

if (($comentario == "")) {
    echo "<script>alert('Campo vazio!');location = 'jogo.php?id=" . $id_jogo . "';</script>";
} else {
    try {
        $coment = $conn->prepare('INSERT INTO comentarios (comentario, id_usuario, id_jogo) VALUES 
            (:coment, :iduser, :id)');

        $coment->execute(array(
            ':coment' => $comentario,
            ':iduser' => $iduser,
            ':id' => $id_jogo
        ));

        echo "<script>alert('Comentário feito com sucesso!');location = 'jogo.php?id=" . $id_jogo . "';</script>";
    } catch (PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
    }
}
