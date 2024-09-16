<!DOCTYPE html>
<html lang="pt-br">
<?php
include "../php/conexao.php";
session_start();

if (isset($_SESSION['iduser'])) {
    $id = $_SESSION['iduser'];

    $check = $conn->prepare(
        'SELECT * FROM usuario WHERE id = :id'
    );
    $check->execute(array(
        ':id' => $id
    ));
} else {
    $_SESSION['logado'] = false;
}

$idjogo = $_GET['id'];
$dados = $conn->prepare('SELECT * FROM jogo WHERE id = :id');
$dados->execute(array(
    ':id' => $idjogo,
));

$dadosnome = $conn->prepare('SELECT * FROM jogo WHERE id = :id');
$dadosnome->execute(array(
    ':id' => $idjogo,
));

$dadoslink = $conn->prepare('SELECT * FROM jogo WHERE id = :id');
$dadoslink->execute(array(
    ':id' => $idjogo,
));

$comentarios = $conn->prepare('SELECT usuario, foto_perfil, comentario 
FROM comentarios C
INNER JOIN usuario U ON U.id = C.id_usuario
WHERE id_jogo = :idjogo');

$comentarios->execute(array(
    ':idjogo' => $idjogo,
));

$dadostag = $conn->prepare('SELECT * FROM tags WHERE id_jogo = :id');
?>

<head>
    <?php
    echo "<title>";
    foreach ($dadosnome as $nomejogo) {
        echo $nomejogo['jogo'];
    }
    echo "</title>";
    ?>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="../img/jaca.ico" type="image/x-icon" />
    <link rel="stylesheet" href="../css/jogo.css" />
    <link rel="stylesheet" href="../css/index.css" />
    <link rel="stylesheet" href="../css/cabecalho.css" />
    <link rel="stylesheet" href="../css/menu.css" />
    <link rel="stylesheet" href="../css/card_perfil.css" />
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        textarea {
            resize: none;
        }
    </style>
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
        if (isset($_SESSION['logado']) and $_SESSION['logado'] == true) {
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

        <div class="card" id="carde" style="display: none">
            <a href="../html/login.html" style="display: block" id="btn1-1">Entrar</a>
            <a href="../html/cadastro.html" style="display: block" id="btn1-2">Cadastrar-se</a>
            <a href="../html/perfil.php" style="display: none" id="btn2-1">Perfil</a>
            <a href="../php/sair.php" style="display: none" id="btn2-2">Sair</a>
        </div>
    </header>
    
    <div style="position: absolute; width: 100%">
    <div class="link">
        <?php
            foreach ($dadoslink as $link) {
                echo $link['link'];
            }
        ?>
    </div>

     <div class="fundo">
        <div style="float: left; width: 100%; padding-top: 20px; padding-left: 20px; padding-right: 20px" class="info">
            <?php
            foreach ($dados as $linha) {
                echo "Nome: " . $linha['jogo'] . " <br><br>";
                echo "Tags: ";
                $dadostag->execute(array(
                    ':id' => $linha['id']
                ));
                foreach ($dadostag as $linha1) {
                    echo $linha1["tag"] . "; ";
                }
                echo "<br><br> Descrição: " . $linha['descricao'] . "<br><br>";
            }
            ?>
        </div>
        <div style="padding-left: 20px">
            <?php
            echo "<form action='salvar_comentario.php?id=" . $idjogo . "' method='POST' id='form'>";
            echo "<textarea name='comentario' cols='100' rows='6' maxlength='255' placeholder='Faça seu comentário aqui!'></textarea><br>";
            echo "<input type='submit' value='Publicar' onclick='check_conta()' class='btn'>";
            echo "</form> <br>";
            ?>
        </div>
        <div>
            <div style="text-align: center;">
                <h1>Comentários</h1>
                <br>
                <hr>
                <br>
            </div>
            <div style="padding-left: 20px">
            <?php
                foreach ($comentarios as $comment) {
                    echo "<img src='../img/perfil/foto_perfil/" . $comment['foto_perfil'] .  "' class='col-1' style='width: 45px; height: 45px; border-radius: 50%; border: 1px solid white; margin-right: 5px;' />";
                    echo "<p class='col-1'>" . $comment['usuario'] . "</p> ";
                    echo "<br> <p class= 'col-11' style='border: solid black; color: black; background: white; height: fit-content; word-wrap: break-word; padding-left: 5px;'> " . $comment['comentario'] . " </p> <br> <br>";
                }
                echo "</div>";
                ?>  
            </div>
        </div>
     </div>
    </div>
    
</body>

</html>

<script src="../js/btnPerfil.js"></script>

<script src="../js/menu.js"></script>

<script>
    function check_conta() {
        <?php
        if (isset($_SESSION['iduser'])) {
        } else {
            echo "document.getElementById('form').action = 'jogo.php?id=" . $idjogo . "'; ";
            echo "alert('Para comentar logue no site'); history.go(-1);";
        }
        ?>
    }
</script>

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