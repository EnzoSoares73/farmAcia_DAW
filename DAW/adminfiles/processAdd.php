<?php

    require_once 'dbconfig.php';
    
    $tbl_name=$_GET['table'];
    
    try { //verifica se um arquivo foi passado por form
        $filename = $_FILES["imagem/"]["name"];
        $tempname = $_FILES["imagem/"]["tmp_name"];
        $folder = "images/".$filename; 
    } catch (Exception $e) {
        echo "Nenhum arquivo";
    }
    
    $myConnection= mysqli_connect("$host","$username","$password") or die ("could not connect to mysql");
    mysqli_select_db($myConnection, $dbname) or die ("no database"); //realiza a conexão
    
    $sql="SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '$dbname' AND TABLE_NAME = '$tbl_name'";
    
    if(!$query = mysqli_query($myConnection, $sql)){ //realiza query
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($myConnection);
    }
    
    while ($row = $query->fetch_assoc()) {
        $result[] = $row;
    }
    
    $columnArr = array_column($result, 'COLUMN_NAME'); //separa todos os nomes de colunas da table $tbl_name
    
    $infos = [];
    
    foreach ($columnArr as $columnname) {
        if ($columnname != "id" and $columnname != "imagem") {
            $infos[] = $_POST[$columnname.'/']; //recupera todos parametros $_POST e os coloca no array $infos
        }
    }
    
    

    if ($filename != null) {
        array_push($infos, $filename);
    }
    unset($columnArr[0]);
    $columnArr = implode(', ', $columnArr);
    $infos = "'".implode("', '", $infos)."'"; //formata $columnArr e $infos para passá-los como argumento de query
    
    $sql = "INSERT INTO $tbl_name (".$columnArr.")
    VALUES (".$infos.")"; //cria a query
    
    if (mysqli_query($myConnection, $sql)) {
        echo "New record created successfully";
    } else {
        echo "Record not created" . mysqli_error($myConnection);
    }
    
    if (move_uploaded_file($tempname, $folder))  {
        echo "Image uploaded successfully";
    }else{
        echo "Failed to upload image";
    }
    
    $myConnection=null; //fecha a conexão
    
    header('Location: menu.php');
    exit();
   
?>