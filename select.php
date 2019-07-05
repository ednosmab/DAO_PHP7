<?php
    require_once "config.php";
    $login = "root";
    $pass = "";
    $tipoBanco = "mysql:host=localhost";
    $nomeBanco = "dbname=dbphp7";
    $sql = new Sql();
    
    /*Executa Select do banco inteiro
    //Comentando trecho do códito para testar a classe usuario
    //Executando comando no banco de dados
    $usuarios = $sql->select("SELECT * FROM tb_usuarios ORDER BY idusuario");
    
    //Executando JSON ENCODE para exibir na tela
    echo json_encode($usuarios);
    */

    echo "<p>";
    $root = new Usuario();
    $root->loadById(6);
    echo $root;
    echo "</p>";
?>