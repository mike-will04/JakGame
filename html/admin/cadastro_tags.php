<?php
    include "../../php/conexao.php";

    $nome = $_POST['nome'];
    $tags = $_POST['tags'];

    $checkid = $conn->prepare(
        'SELECT * FROM jogo WHERE jogo = :jogo'
    );
    $checkid -> execute(array(
        ':jogo' => $nome,
    ));

    $check = $conn->prepare(
        'SELECT count(*) as count FROM jogo WHERE jogo = :jogo'
    );
    $check-> execute(array(
        ':jogo' => $nome,
    ));

    if (($nome == null) || ($tags == null)) {
        echo "<script>alert('Campos não podem estar vazios');history.go(-1)</script>";
    } else {
        foreach ($check as $linha) {
            try {          
                if ($linha['count'] >= 1) {
                    foreach ($checkid as $linha1) {
                        $tagsin = $conn->prepare('INSERT INTO tags (tag, id_jogo) VALUES 
                        (:tag, :id_jogo)');
        
                        $tagsin->execute(array(
                            ':tag' => $tags,
                            ':id_jogo' => $linha1['id'],
                        ));
                        if ($tagsin->rowCount() == 1) {
                            echo "<script>alert('Cadastro da tag realizada com sucesso!!!');history.go(-1)</script>";
                        } else {
                            echo "<script>alert('Erro ao cadastrar a tag');history.go(-1)</script>";
                        }
                    }
                } else {
                    echo "<script>alert('Jogo não existe');history.go(-1)</script>";                
                }      
            } catch (PDOException $e) {
                echo 'ERROR: ' . $e->getMessage();
            }
        }
    }
?>