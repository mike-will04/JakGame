<?php 
include "../../php/conexao.php";
$id = $_GET["id"];

try {
    $excluir2 = $conn->prepare('DELETE FROM tags where id_jogo = :id');
    $excluir2->execute(array(
        ':id' => $id
    ));
    
    $excluir3 = $conn->prepare('DELETE FROM fotos where id_jogo = :id');
    $excluir3->execute(array(
        ':id' => $id
    ));

    $excluir = $conn->prepare('DELETE FROM jogo where id = :id');
    $excluir->execute(array(
        ':id' => $id
    ));

    $excluir4 = $conn->prepare('DELETE FROM usuario where id = :id');
    $excluir4->execute(array(
        ':id' => $id
    ));


    if ($excluir->rowCount() == 0) {
        echo "<script>alert('Dados não foram apagados');history.go(-1);</script>";
    } else {
        echo "<script>alert('Dados excluidos com sucesso!!!');history.go(-2);</script>";
    }
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
