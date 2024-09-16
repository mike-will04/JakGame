<?php
    include "../../php/conexao.php";

    $nome = $_POST['nome'];
    $link = $_POST['link'];
    $descricao = $_POST['descricao'];
    $dir = '../../img/admin/';
    $tmpName = $_FILES['image']['tmp_name']; 
    $name = $_FILES['image']['name'];

    $check = $conn->prepare(
        'SELECT count(*) as count FROM jogo WHERE jogo = :jogo'
    );
    $check -> execute(array(
        ':jogo' => $nome,
    ));

    if (($nome == null) || ($link == null) || ($name == null)) {
        echo "<script>alert('Campos não podem estar vazios');history.go(-1)</script>";
    } else {
        foreach ($check as $linha) {
            try {
                if ($linha['count'] >= 1) {
                    echo "<script>alert('Jogo já cadastrado');history.go(-1)</script>";                
                }
                else {
                    if (move_uploaded_file( $tmpName, $dir . $name )){
                        $jogo = $conn->prepare('INSERT INTO jogo (jogo, link, descricao) VALUES 
                        (:jogo, :link, :descricao)');
            
                        $jogo->execute(array(
                            ':jogo' => $nome,
                            ':link' => $link,
                            ':descricao' => $descricao
                        ));

                        $id_jogo = $conn->lastInsertId();

                        $foto = $conn->prepare('INSERT INTO fotos (foto, id_jogo) VALUES 
                        (:foto, :id_jogo)');
                        
                        $foto->execute(array(
                            ':foto' => $name,
                            ':id_jogo' => $id_jogo,
                        ));

                        if ($jogo->rowCount() == 1) {
                            echo "<script>alert('Cadastro do jogo realizado com sucesso!!!');history.go(-1)</script>";
                        } else {
                            echo "<script>alert('Erro ao cadastrar o jogo');history.go(-1)</script>";
                        }
                    } else {
                            echo "<script>alert('Erro ao salvar a foto do jogo');history.go(-1)</script>";
                    }  
                }   
            } catch (PDOException $e) {
                echo 'ERROR: ' . $e->getMessage();
            }
        }
    }
?>