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
    </head>
    <body style="background-color: #676761;">
        <header>
            <div class="col-12 div1">
                <a href="../admin/inicial.html">
                    <img src="../../img/logo.png" alt="Logo" class="logo anima-logo" />
                </a>
            </div>
        </header>
        <h1 style="color: white;">Comentários</h1>
        <?php
            $comentarios = $conn->prepare('SELECT U.id, usuario, foto_perfil, comentario, jogo, id_comentario
            FROM comentarios C
            INNER JOIN usuario U ON U.id = C.id_usuario
            INNER JOIN jogo J ON J.id = C.id_jogo
            ORDER BY U.id'
            );

            $comentarios->execute(array(
            ));

            if ($comentarios->rowCount() >= 1) {
                echo "<table border=1 width=100%>";
                echo "<tr><th>Usuário</th><th>Jogo</th><th>Comentário</th><th>Excluir</th>";
                foreach ($comentarios as $linha) {
                    echo "<tr>";
                    echo "<td>" . $linha["usuario"] . "</td>";
                    echo "<td>" . $linha["jogo"] . "</td>";
                    echo "<td>" . $linha["comentario"] . "</td>";
                    echo "<td> <a href='apagarcomment.php?id=";
                    echo $linha["id_comentario"];
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