<?php
include "conexao.php";

$user = $_POST["user"];
$email = $_POST["email"];
$senha = $_POST["senha"];
$dir = '../img/perfil/foto_perfil/';
$tmpName = $_FILES['image']['tmp_name']; 
$name = $_FILES['image']['name'];

$check = $conn->prepare(
    'SELECT count(*) as count FROM usuario WHERE usuario = :user or email = :email'
);
$check -> execute(array(
    ':user' => $user,
    ':email' => $email
));

$senhahash = password_hash($senha,PASSWORD_DEFAULT);

if (($user == "") || ($email == "") || ($senha == "")) {
    echo "<script>alert('Campos nao podem ser vazios!!!');history.go(-1);</script>";
} else {
    foreach ($check as $linha) {
        try {
            if ($linha['count'] >= 1) {
                echo "<script>alert('Nome de usuário ou email já cadastrado');history.go(-1)</script>";                
            }
            else {
                if ($name == null) {
                        $cadastro = $conn->prepare('INSERT INTO usuario (usuario, senha, email) VALUES 
                        (:usuario, :senha, :email)');
            
                        $cadastro->execute(array(
                            ':usuario' => $user,
                            ':senha' => $senhahash,
                            ':email' => $email
                        ));
            
                        if ($cadastro->rowCount() == 1) {
                            echo "<script>alert('Cadastro realizado com sucesso!!!');location = '../html/login.html' </script>";
                        } else {
                            echo "<script>alert('Erro ao cadastrar');history.go(-1)</script>";
                        }     
                } else {
                    if (move_uploaded_file( $tmpName, $dir . $name )){
                        $cadastro = $conn->prepare('INSERT INTO usuario (usuario, senha, email, foto_perfil) VALUES 
                        (:usuario, :senha, :email, :foto_perfil)');
            
                        $cadastro->execute(array(
                            ':usuario' => $user,
                            ':senha' => $senhahash,
                            ':email' => $email,
                            ':foto_perfil' => $name
                        ));
            
                        if ($cadastro->rowCount() == 1) {
                            echo "<script>alert('Cadastro realizado com sucesso!!!');location = '../html/login.html' </script>";
                        } else {
                            echo "<script>alert('Erro ao cadastrar');history.go(-1)</script>";
                        }
                    } else {
                            echo "<script>alert('Erro ao salvar a foto de perfil.');history.go(-1)</script>";
                    }        
                }
            }
        } catch (PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }
}
