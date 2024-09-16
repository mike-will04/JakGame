<?php
include "conexao.php";
session_start();

$login = $_POST['login'];
$senha = $_POST['senha'];

$check = $conn->prepare(
    'SELECT count(*) as count FROM usuario WHERE usuario = :login or email = :login'
);
$check->execute(array(
    ':login' => $login
));

$check1 = $conn->prepare(
    'SELECT * FROM usuario WHERE usuario = :login or email = :login'
);
$check1->execute(array(
    ':login' => $login
));

if (($login == "") || ($senha == "")) {
    echo "<script>alert('Campos nao podem ser vazios!!!');history.go(-1);</script>";
} else {
    foreach ($check as $linha) {
        if ($linha['count'] >= 1) {
            foreach ($check1 as $linha1) {
                if ($linha1['admin'] == 1) {
                    if (password_verify($senha, $linha1['senha'])) {
                        $_SESSION['logado'] = true;
                        $_SESSION['iduser'] = $linha1['id'];
                        echo "<script>alert('Logado com sucesso!!!');location = '../html/admin/inicial.html' </script>";
                    } else {
                        echo "<script>alert('Senha inválida');history.go(-1);</script>";
                    }
                }
                else {
                    if (password_verify($senha, $linha1['senha'])) {
                        $_SESSION['logado'] = true;
                        $_SESSION['iduser'] = $linha1['id'];
                        echo "<script>alert('Logado com sucesso!!!');location = '../html/index.php' </script>";
                    } else {
                        echo "<script>alert('Senha inválida');history.go(-1);</script>";
                    }
                }
            }
        } else {
            echo "<script>alert('Usuário não existe');history.go(-1);</script>";
        }
    }
}
