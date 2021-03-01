<?php
    require_once '../adminfiles/dbconfig.php';
    
    $id=$_GET['id'];
    $quantidade = $_POST['quantidade'];
    $cliente = $_POST['browser'];
    
    $myConnection= mysqli_connect("$host","$username","$password") or die ("could not connect to mysql");
    mysqli_select_db($myConnection, $dbname) or die ("no database"); //realiza a conexão
    
    $sql = "SELECT * FROM produto WHERE id=$id";
    $retval = mysqli_query($myConnection, $sql); //recupera a entrada $id
    $row = mysqli_fetch_array($retval);
    
    $nome = $row['nome'];
    $preco = $row['preco'];
    $valor = $preco*$quantidade;
    
    $myfile = fopen("../adminfiles/log.txt", "a") or die("Unable to open file!");
    $txt = "Vendido: $id $nome. $quantidade unidades vendidas por $preco cada para um total de $valor para $cliente\r";
    fwrite($myfile, $txt);
    fclose($myfile);
    
    header('Location: showprodutos.php');
    exit();
?>