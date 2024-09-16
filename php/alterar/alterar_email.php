<?php
    include "../conexao.php";

    $email = $_POST["email"];

    session_start();
    $id = $_SESSION['iduser'];

    $check = $conn->prepare(
        'SELECT count(*) as count FROM usuario WHERE email = :email'
    );
    $check -> execute(array(
        ':email' => $email,
    ));

    if ($email == null) {
        echo "<script>alert('Campo não pode ser vazio');location = '../../html/perfil.php'</script>";
    } else {
        foreach ($check as $linha) {
            try{
                if ($linha['count'] >= 1) {
                    echo "<script>alert('Nome de usuário já cadastrado');location = '../../html/perfil.php'</script>";                
                } else {
                    $cadastro = $conn->prepare('UPDATE usuario set email = :email where id = :id 
                    ');
            
                    $cadastro->execute(array(
                        ':email' => $email,
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