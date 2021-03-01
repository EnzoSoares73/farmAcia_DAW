<?php

    require_once 'dbconfig.php';
    
    $tbl_name=$_GET['table'];
    $id=$_GET['id'];
    
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
            $infos[] = $_POST[$columnname]; //recupera todos parametros $_POST e os coloca no array $infos
        }
    }
    
    
    if ($filename = $_FILES["imagem"]["name"]) {
        $tempname = $_FILES["imagem"]["tmp_name"];
        $folder = "images/".$filename;
    } else {
        if (in_array("imagem", $columnArr)) {
            array_pop($columnArr);
        }
    }
    
    if ($filename != null) {
        array_push($infos, $filename);
    }
    
    unset($columnArr[0]);
    
    $string = '';
    foreach($columnArr as $key =>$val) { //formata $string para query
        $string = $string.$val."='".$infos[$key-1]."', ";
    }
    
    $string = substr($string, 0, -2); //retira os dois ultimos chars de $string
    
    $sql = "UPDATE $tbl_name SET $string WHERE id=$id"; //cria a query
    
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