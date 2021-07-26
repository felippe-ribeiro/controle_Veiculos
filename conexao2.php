<?php
    $servidor = "localhost";
    $usuario = "admin";
    $senha = "h@5sup2017";
    $dbname = "controle_veiculos";
    
    //Criar a conexao
    $conn = mysqli_connect($servidor, $usuario, $senha, $dbname);
    
    if(!$conn){
        die("Falha na conexao: " . mysqli_connect_error());
    }else{
        //echo "Conexao realizada com sucesso";
    }      
?>
