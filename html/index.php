<!DOCTYPE html>
<html lang="pt-br">
<?php
include "../php/conexao.php";
session_start();

if (isset($_SESSION['iduser'])) {
    $id = $_SESSION['iduser'];

    $check = $conn->prepare(
        'SELECT * FROM usuario WHERE id = :id'
    )
    ;
    $check->execute(array(
        ':id' => $id
    ));
} else {
    $_SESSION['logado'] = false;
}
?>

<head>
    <title>JakGame</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="../img/jaca.ico" type="image/x-icon" />
    <link rel="stylesheet" href="../css/home.css">
    <link rel="stylesheet" href="../css/cabecalho.css" />
    <link rel="stylesheet" href="../css/menu.css" />
    <link rel="stylesheet" href="../css/card_perfil.css" />
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>

<body>
    <header>
        <div class="col-4">
            <img src="../img/icons/menu.png" alt="Menu" class="menu" onclick="abrir()" style="cursor: pointer" />
        </div>

        <div class="col-4 div1">
            <a href="../html/index.php">
                <img src="../img/logo.png" alt="Logo" class="logo anima-logo" />
            </a>
        </div>
        <?php
        if (isset($_SESSION['logado']) and $_SESSION['logado'] === true) {
            foreach ($check as $linha) {
                if ($linha['foto_perfil'] == null) {
                    echo "
                    <div class='col-4'>
                    <img src='../img/icons/user.png' alt='Perfil' class='user anima-perfil' onclick='perfil()' id='btn-perfil' style='cursor: pointer; border-radius: 50%;' /> 
                    </div>
                    ";

                    echo "<script> var logado = true; </script>";
                } else {
                    echo "
                    <div class='col-4'>
                    <img src='../img/perfil/foto_perfil/" . $linha['foto_perfil'] .  "' alt='Perfil' class='user anima-perfil' onclick='perfil()' id='btn-perfil' style='cursor: pointer; border-radius: 50%; border: 1px solid white;' /> 
                    </div>
                    ";

                    echo "<script> var logado = true; </script>";
                }
            }
        } else {
            echo "
                <div class='col-4'>
                <img src='../img/icons/user.png' alt='Perfil' class='user anima-perfil' onclick='perfil()' id='btn-perfil' style='cursor: pointer; border-radius: 50%;' /> 
                </div>
                ";

            echo "<script> var logado = false; </script>";
        }
        ?>


        <div id="myNav" class="overlay">
            <div class="x">
                <p style="font-size: 30px;cursor: pointer;margin-right: 5px;" onclick="fechar()">
                    &times;
                </p>
            </div>
            <div class="overlay-content">
                <p class="categoria">
                    <a href="../php/pesquisa.php?tag=1 jogador">1 jogador</a>
                    <a href="../php/pesquisa.php?tag=2 jogadores">2 jogadores</a>
                    <a href="../php/pesquisa.php?tag=3D">3D</a>
                    <a href="../php/pesquisa.php?tag=Quebra-cabeças">Quebra-cabeças</a>
                    <a href="../php/pesquisa.php?tag=Puzzle">Puzzle</a>
                    <a href="../php/pesquisa.php?tag=Corrida">Corrida</a>
                    <a href="../php/pesquisa.php?tag=Luta">Luta</a>
                    <a href="../php/pesquisa.php?tag=Robôs">Robôs</a>
                    <a href="../php/pesquisa.php?tag=Sustentabilidade">Sustentabilidade</a>
                </p>
            </div>
            <div class="rodape">
                <p>
                    Devs:<br />Felipe de Assis<br />Gabriel da Silva<br />Mike Will
                </p>
                <br />
                <p>
                    Contato:<br />eujakgame@gmail.com <br />
                    <img src="../img/mascote.png" alt="Mascote" style="width: 50px; height: 60px;">
                </p>
            </div>
        </div>

        <div class="card" id="carde" style="display: none;">
            <a href="../html/login.html" style="display: block" id="btn1-1">Entrar</a>
            <a href="../html/cadastro.html" style="display: block" id="btn1-2">Cadastrar-se</a>
            <a href="../html/perfil.php" style="display: none" id="btn2-1">Perfil</a>
            <a href="../php/sair.php" style="display: none" id="btn2-2">Sair</a>
        </div>
    </header>

    <?php
    $jogos = $conn->prepare('SELECT DISTINCT id, jogo, foto, id_jogo
    FROM jogo J
    INNER JOIN fotos F ON J.id = F.id_jogo
    ORDER BY id');
    $jogos->execute(array());

    if ($jogos->rowCount() >= 0) {
        echo "<div class='divpai'>";
        foreach ($jogos as $linha) {
            echo "<div class='divjogos jogo'><a href='../php/jogo.php?id=" . $linha['id_jogo'] . "'><img src='../img/admin/" . $linha['foto'] . "' style='width:150px; height:150px; border-radius: 15px; border: 2px solid black;' class=''></a><label>". $linha['jogo'] ."</label></div>";
        }
        echo "</div>";
    } else {
        echo "<script>alert('Dados não encontrados');history.go(-1);</script>";
    }
    ?>
</body>

</html>

<script src="../js/btnPerfil.js"></script>

<script src="../js/menu.js"></script>

<script>
    document.addEventListener('mouseup', function(e) {
        var container = document.getElementById('carde');
        if (!container.contains(e.target)) {
            container.style.display = 'none';
        }
    });
    document.addEventListener('mouseup', function(e) {
        var container = document.getElementById('myNav');
        if (!container.contains(e.target)) {
            document.getElementById("myNav").style.width = "0";
        }
    });
</script>