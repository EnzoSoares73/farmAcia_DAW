<?php

    require_once 'dbconfig.php';
    
    $tbl_name=$_GET['table'];
    $id=$_GET['id'];
    
    $myConnection= mysqli_connect("$host","$username","$password") or die ("could not connect to mysql");
    mysqli_select_db($myConnection, $dbname) or die ("no database"); //realiza a conexão
    
    $sql = "DELETE FROM $tbl_name WHERE id=$id";
    
    if ($myConnection->query($sql) === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $myConnection->error;
    }
    
    $myConnection=null; //fecha a conexão

    
    header('Location: menu.php');
    exit();
    
?>