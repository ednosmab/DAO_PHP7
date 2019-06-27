<?php
    require_once "config.php";
    $login = "root";
    $pass = "";
    $tipoBanco = "mysql:host=localhost";
    $nomeBanco = "dbname=dbphp7";
    $sql = new Sql($tipoBanco, $nomeBanco, $login, $pass);

    //Executando comando no banco de dados
    $usuarios = $sql->select("SELECT * FROM tb_usuarios ORDER BY idusuario");

    //Executando JSON ENCODE para exibir na tela
    echo json_encode($usuarios);


?>