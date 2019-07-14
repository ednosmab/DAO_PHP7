<?php
    require_once "config.php";
    
    /*
    //Função estática, lista todos os usuarios do banco
    $lista = Usuario::getList();
    echo "<p>";
    echo json_encode($lista); 
    echo "</p>";
     */
    /*
    //Carrega uma lista de usuarios buscanco pelo login
    $search = Usuario::getSearch("ed");
    echo json_encode($search);
    */
    /*
    //Carrega um usuário usando o login e a senha
    $usuario = new Usuario();
    $usuario->login("root", '@#$rrf');
    echo $usuario;
     */

    $aluno = new Usuario('aluno', '@lun0');
    $aluno->insert();
    echo $aluno;
?>