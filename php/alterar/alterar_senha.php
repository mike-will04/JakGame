<?php
    include "../conexao.php";

    $senha_nova = $_POST["senha_nova"];
    $senha_antiga = $_POST["senha_antiga"];

    $senhahash = password_hash($senha_nova,PASSWORD_DEFAULT);
    
    session_start();
    $id = $_SESSION['iduser'];
    
    $check = $conn->prepare(
        'SELECT * FROM usuario WHERE id = :id'
    );
    $check->execute(array(
        ':id' => $id
    ));

    if (($senha_nova == null) and ($senha_antiga == null)) {
        echo "<script>alert('Campos não podem ser vazios!!!');location = '../../html/perfil.php'</script>";
    } else {
        foreach ($check as $linha){
            try{
                if (password_verify($senha_antiga, $linha['senha'])){

                    $cadastro = $conn->prepare('UPDATE usuario set senha = :senha where id = :id 
                    ');
            
                    $cadastro->execute(array(
                        ':senha' => $senhahash,
                        ':id'=> $id
                    ));
            
                    if ($cadastro->rowCount() == 1) {
                        echo "<script>alert('Atualização realizada com sucesso!!!');location = '../../html/perfil.php'</script>";
                    } else {
                        echo "<script>alert('Erro ao atualizar');location = '../../html/perfil.php'</script>";
                    }   
                
                } else {
                    echo "<script>alert('Senha antiga inválida');location = '../../html/perfil.php';</script>";
                }
            } catch (PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
            }
    }
        }
?>