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
    
    $sql = "SELECT * FROM $tbl_name WHERE id=$id";
    $retval = mysqli_query($myConnection, $sql); //recupera a entrada $id na tabela $tbl_name
    $row = mysqli_fetch_array($retval);
    
    $myConnection=null; //fecha a conexão
    
    function verificaNome($nome) { //retorna qual o tipo de input será utilizada com base no nome da row
        if ($nome == "imagem") {
            return "file";
        } else {
            return "text";
        }
    }
    

?>

<html> 
    
    <head>
		<?php require_once 'headtag.php';?>
        <title>Modificar</title>
    
    </head>

	<body>
        <form action="processModify.php?id=<?php echo $id?>&table=<?php echo $tbl_name?>" method="post" enctype="multipart/form-data">
            	
                <?php foreach ($columnArr as $columnname) : ?>
                	<?php if ($columnname != "id"):?>
    					<label><?php echo $columnname; ?></label>
                			<input type=<?php echo verificaNome($columnname)?> name=<?php echo $columnname; ?> value='<?php print $row[$columnname]?>'/><br>
                	<?php endif; ?>
                <?php endforeach; ?>
            	
            <input type="submit" name=submit value="Enviar"/>
        </form>
    
    </body>
    
</html> 