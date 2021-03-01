<?php

    require_once 'dbconfig.php';
    
    $tbl_name=$_GET['table'];
    
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

    $sql = "SELECT * FROM $tbl_name";
    $retval = mysqli_query($myConnection, $sql); //recupera a tabela $tbl_name
    
    $myConnection=null; //fecha a conexão
    
?>

<html>

	<head>
		<?php require_once '../templates/headtag.php';?>
		<title>Mostrar</title>
	
	</head>

	<body>
		
        	<table border="1">
        	
        		<thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                    </tr>
                </thead>
            
                <?php while( $row = $retval->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo $row[$columnArr[0]]; ?></td>
                        <td><?php echo $row[$columnArr[1]]; ?></td>
						<td><a href="templateDelete.php?id=<?php echo $row[$columnArr[0]]; ?>&table=<?php echo $tbl_name; ?>" >Deletar</a></td>
						<td><a href="templateModify.php?id=<?php echo $row[$columnArr[0]]; ?>&table=<?php echo $tbl_name; ?>" >Modificar</a></td>
						
						
                    </tr>
                <?php endwhile; ?>
        	
        	</table>
        	
        	<br>
        	<a href="TemplateAdd.php?table=<?php echo $tbl_name; ?>">Adicionar</a>
        	<br>

	
	</body>
	
</html>