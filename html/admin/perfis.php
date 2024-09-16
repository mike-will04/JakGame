<!DOCTYPE html>
<html lang="pt-br">
    <?php
        include "../../php/conexao.php";
    ?>
    <head>
        <title>Admin</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="shortcut icon" href="../../img/jaca.ico" type="image/x-icon" />
        <link rel="stylesheet" href="../../css/inicial.css">
        <link rel="stylesheet" href="../../css/cabecalho.css" />
        <style>
            img{
                height: 70px;
                width: 70px;
            }
        </style>
    </head>
    <body style="background-color: #676761;">
        <header>
            <div class="col-12 div1">
                <a href="../admin/inicial.html">
                    <img src="../../img/logo.png" alt="Logo" class="logo anima-logo" />
                </a>
            </div>
        </header>

        <h1 style="color: white;">Perfis</h1>
        <?php
            $tabela = $conn->prepare('SELECT * FROM usuario');
            $tabela->execute(array(
            ));

            if ($tabela->rowCount() >= 1) {
                echo "<table border=1 width=100%>";
                echo "<tr><th>Usuário</th><th>Imagem</th><th>Excluir</th></tr>";
                foreach ($tabela as $linha) {
                    echo "<tr>";
                    echo "<td>" . $linha["usuario"] . "</td>";
                    echo "<td><img src='../../img/perfil/foto_perfil/". $linha['foto_perfil'] ."'></td>";
                    echo "<td> <a href='apagar.php?id=";
                    echo $linha["id"];
                    echo "'>Excluir</a> </td>";        
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<script>alert('Dados não encontrados');history.go(-1);</script>";
            }
        ?>
        <a href="inicial.html">
            <input type="button" value="Voltar">
        </a>
    </body>
</html>