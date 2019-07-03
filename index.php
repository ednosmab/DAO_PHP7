<?php
    require_once "config.php";
    $login = "root";
    $pass = "";
    $tipoBanco = "mysql:host=localhost";
    $nomeBanco = "dbname=dbphp7";
    $sql = new Sql($tipoBanco, $nomeBanco, $login, $pass);
    
    //Comentando trecho do códito para testar a classe usuario
    //Executando comando no banco de dados
    $usuarios = $sql->select("SELECT * FROM tb_usuarios ORDER BY idusuario");
    
    //Executando JSON ENCODE para exibir na tela
    echo json_encode($usuarios);
    
    echo "<p>";
    $root = new Usuario($tipoBanco, $nomeBanco, $login, $pass);
    $root->loadById(6,$tipoBanco, $nomeBanco, $login, $pass);
    echo $root;
    echo "</p>";
?>