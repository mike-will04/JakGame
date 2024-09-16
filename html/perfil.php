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

  echo "<script>location = '../html/index.php' </script>";
}
?>

<head>
  <title>Perfil</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v2.1.9/css/unicons.css">
  <link rel="shortcut icon" href="../img/jaca.ico" type="image/x-icon">
  <link rel="stylesheet" href="../css/perfil.css">
  <link rel="stylesheet" href="../css/cabecalho.css">
  <link rel="stylesheet" href="../css/menu.css">
  <link rel="stylesheet" href="../css/card_perfil.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
  <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
</head>

<body>
  <header>
    <div class="col-4">
      <img src="../img/icons/menu.png" alt="Menu" class="menu" onclick="abrir()" style="cursor:pointer">
    </div>
    <div class="col-4 div1">
      <a href="../html/index.php"><img src="../img/logo.png" alt="Logo" class="logo anima-logo"></a>
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
        <p style="font-size:30px;cursor:pointer;margin-right: 5px;" class="x2" onclick="fechar()">&times;</p>
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
        <p style="margin: 0;">Devs:<br>Felipe de Assis<br>Gabriel da Silva <br>Mike Will</p>
        <br>
        <p style="margin: 0;">Contato:<br>eujakgame@gmail.com <br><img src="../img/mascote.png" alt="Mascote" style="width: 50px; height: 60px;"></p>
      </div>
    </div>

    <div class="card" id="carde" style="display: none">
      <a href="../html/login.html" style="display: block" id="btn1-1">Entrar</a>
      <a href="../html/cadastro.html" style="display: block" id="btn1-2">Cadastrar-se</a>
      <a href="../html/perfil.php" style="display: none" id="btn2-1">Perfil</a>
      <a href="../php/sair.php" style="display: none" id="btn2-2">Sair</a>
    </div>
  </header>

  <div class="wallpaper">
    <?php
    if ($linha['foto_wallpaper'] == null) {
      echo "<img src='../img/mascote.png' width='250px' height='300px' class='foto'>";
    } else {
      echo "<img src='../img/perfil/foto_wallpaper/" . $linha['foto_wallpaper'] . "' width='100%' height='300px'>";
    }
    ?>
  </div>

  <div class="upload">
    <div style="float: left;">
      <?php
      if ($linha['foto_perfil'] == null) {
        echo "<img src='../img/noprofil.jpg' width='125' height='125'/>";
      } else {
        echo "<img src='../img/perfil/foto_perfil/" . $linha['foto_perfil'] . "' width='125' height='125' id='profile' />";
      }
      ?>
    </div>
    <div style="float: left; margin-top: 60px; margin-left: 10px">
      <?php
      echo "<p class='nome_usuario'>" . $linha['usuario'] . "</p>";
      ?>
    </div>
  </div>

  <div class="teste">
    <div class="config" style="float: left;">
      <p onclick="pessoal()" id="corpessoal">Dados Pessoais</p>
      <p onclick="coment()" id="corcoment">Comentários</p>
    </div>

    <div class="conteudo" style="float: left">
      <div class="dados_pessoais" id="pessoal">
        <h1>Alterar dados</h1>
        <form action="../php/alterar/alterar_usuario.php" method="post">
          <div class="alterar">
            <p>Usuário:</p>
            <input type="text" placeholder="Usuário" name="user"> <input type="submit" class="btn mt-4" value="Alterar Usuário"> <br>
          </div>
        </form>
        <form action="../php/alterar/alterar_email.php" method="post">
          <div class="alterar">
            <p>E-mail:</p>
            <input type="text" placeholder="E-mail" name="email"> <input type="submit" class="btn mt-4" value="Alterar e-mail"> <br>
          </div>
        </form>
        <form action="../php/alterar/alterar_senha.php" method="post">
          <div class="alterar">
            <p>Senha antiga:</p>
            <input type="password" placeholder="Senha antiga" name="senha_antiga"> <br><br>
            <p>Nova senha:</p>
            <input type="password" placeholder="Nova senha" name="senha_nova"> <input type="submit" class="btn mt-4" value="Alterar senha">
          </div>
        </form>
        <form action="../php/alterar/alterar_foto.php" method="post" enctype="multipart/form-data">
          <div class="alterar">
            <p>Foto de perfil:</p>
            <input type="file" name="image"> <input type="submit" class="btn mt-4" value="Alterar foto"> <br>
          </div>
        </form>
        <form action="../php/alterar/gravar_wallpaper.php" method="post" enctype="multipart/form-data">
          <div class="alterar">
            <p>Foto de wallpaper:</p>
            <input type="file" name="wallpaper"> <input type="submit" class="btn mt-4" value="Alterar wallpaper"> <br>
          </div>
        </form>
      </div>

      <div class="comentarios dados_pessoais" id="coment" style="display: none;">
      <h1>Seus Comentários</h1>
        <?php
        $comentario = $conn->prepare(
          'SELECT * FROM comentarios WHERE id_usuario = :id'
        );
        $comentario->execute(array(
          ':id' => $id
        ));

        $comentariocount = $conn->prepare(
          'SELECT count(*) as cont FROM comentarios WHERE id_usuario = :id'
        );
        $comentariocount->execute(array(
          ':id' => $id
        ));

        foreach ($comentariocount as $count) {
          if ($count['cont'] > 0) {
            foreach ($comentario as $linha) {
              echo "<p class= 'col-9' style='border: solid black; background: white; height: fit-content; word-wrap: break-word; color: black;'> " . $linha['comentario'] . " </p> ";
              echo "<a href='admin/apagarcomment.php?id=" . $linha['id_comentario'] . "' class='col-2 btncoment'>Apagar Comentário</a> <br><br><br>";
            }
          } else {
            echo "<p>Faça um comentário!!!</p>";
          }
        }

        ?>
      </div>
    </div>
  </div>

</body>

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

<script src="../js/btnPerfil.js"></script>

<script src="../js/menu.js"></script>

<script src="../js/wallpaper.js"></script>

<script src="../js/conteudo.js"></script>