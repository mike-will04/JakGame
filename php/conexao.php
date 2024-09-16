<?php
$servidor = 'localhost';
$db = "jakgame";
$user = 'root';
$pass = '';
try {

  $conn = new PDO('mysql:host=' . $servidor . ';dbname=' . $db,  $user, $pass);
  //echo 'Conectado com sucesso';
} catch (PDOException $e) {
  echo 'Erro número : ' . $e->getMessage();
}
