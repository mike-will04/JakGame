<?php
    include "../conexao.php";

    $dir = '../../img/perfil/foto_perfil/';
    $tmpName = $_FILES['image']['tmp_name']; 
    $name = $_FILES['image']['name'];

    session_start();
    $id = $_SESSION['iduser'];

    if ($name == null) {
    echo "<script>alert('Campo não pode ser vazio');location = '../../html/perfil.php'</script>";
    } else {
            try{
                if (move_uploaded_file( $tmpName, $dir . $name )) {
                    $cadastro = $conn->prepare('UPDATE usuario set foto_perfil = :foto where id = :id 
                    ');
            
                    $cadastro->execute(array(
                        ':foto' => $name,
                        ':id'=> $id
                    ));
            
                    if ($cadastro->rowCount() == 1) {
                        echo "<script>alert('Atualização realizada com sucesso!!!');location = '../../html/perfil.php'</script>";
                    } else {
                        echo "<script>alert('Erro ao atualizar');location = '../../html/perfil.php'</script>";
                    }     
                } else {
                    echo "<script>alert('Erro ao salvar a foto de perfil.');location = '../../html/perfil.php'</script>";
                }
            } catch (PDOException $e) {
                echo 'ERROR: ' . $e->getMessage();
            }
    }

?>