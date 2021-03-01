<?php

    require_once '../adminfiles/dbconfig.php';
    
    $myConnection= mysqli_connect("$host","$username","$password") or die ("could not connect to mysql");
    mysqli_select_db($myConnection, $dbname) or die ("no database");
    
    $sql = 'SELECT * FROM produto';
    $retval = mysqli_query($myConnection, $sql);
    
    
    $myConnection = null;

?>

<html>

	<head>
	 	<?php require_once '../templates/headtag.php'; ?>
	 	<title>Produtos</title>
	
	</head>

	<body>
		
        	<table border="1">
            
                <?php while( $row = $retval->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['nome']; ?></td>
						<td><?php echo $row['preco']; ?></td>
                        <td><img src="<?php echo "../adminfiles/images/".$row['imagem']?>" width="50" height="60"></td>
                        <td><a href="comprar.php?id=<?php echo $row['id'];?>">Comprar</a>
						
                    </tr>
                <?php endwhile ?>
        	
        	</table>


	
	</body>
	
</html>