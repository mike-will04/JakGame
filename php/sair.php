<?php
    session_start();

    $_SESSION['logado'] = false;
    $_SESSION['iduser'] = null;

    echo "<script> history.go(-1); </script>";
?>