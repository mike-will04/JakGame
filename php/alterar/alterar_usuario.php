<?php
    include "../conexao.php";

    $user = $_POST["user"];

    session_start();
    $id = $_SESSION['iduser'];

    $check = $conn->prepare(
        'SELECT count(*) as count FROM usuario WHERE usuario = :user'
    );
    $check -> execute(array(
        ':user' => $user
    ));

    if ($user == null) {
        echo "<script>alert('Campo não pode ser vazio');location = '../../html/perfil.php'</script>";
    } else {
        foreach ($check as $linha) {
            try{
                if ($linha['count'] >= 1) {
                    echo "<script>alert('Nome de usuário já cadastrado');location = '../../html/perfil.php'</script>";                
                } else {
                    $cadastro = $conn->prepare('UPDATE usuario set usuario = :usuario where id = :id 
                    ');
            
                    $cadastro->execute(array(
                        ':usuario' => $user,
                        ':id'=> $id
                    ));
            
                    if ($cadastro->rowCount() == 1) {
                        echo "<script>alert('Atualização realizada com sucesso!!!');location = '../../html/perfil.php'</script>";
                    } else {
                        echo "<script>alert('Erro ao atualizar');location = '../../html/perfil.php'</script>";
                    }   
                }
                
            } catch (PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
            }
        }
    }
?>