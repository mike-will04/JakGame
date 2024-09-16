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

        <h1 style="color: white;">Alterar/Jogos</h1>
        <?php
            $tabela = $conn->prepare('SELECT DISTINCT id, jogo, descricao, foto
            FROM jogo J
            INNER JOIN fotos F ON J.id = F.id_jogo
            ORDER BY id ');
            $tabela->execute(array());

            $tabelatag = $conn->prepare('SELECT* FROM tags WHERE id_jogo = :id');


            if ($tabela->rowCount() >= 1) {
                echo "<table border=1 width=100%>";
                echo "<tr><th>Nome</th><th>Tags</th><th>Descrição</th><th>Imagem</th><th>Excluir</th></tr>";
                foreach ($tabela as $linha) {
                    echo "<tr>";
                    echo "<td>" . $linha["jogo"] . "</td>";
                    echo "<td>" ;
                    $tabelatag->execute(array(
                        ':id' => $linha['id'] 
                    ));
                    foreach ($tabelatag as $tags) {
                        echo $tags["tag"] . "; ";

                    }
                    echo "</td>";
                    echo "<td>" . $linha["descricao"] . "</td>";
                    echo "<td>" . $linha["foto"] . "</td>";
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