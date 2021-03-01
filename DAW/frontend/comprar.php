<?php

    require_once '../adminfiles/dbconfig.php';

    $id=$_GET['id'];
    
    $myConnection= mysqli_connect("$host","$username","$password") or die ("could not connect to mysql");
    mysqli_select_db($myConnection, $dbname) or die ("no database"); //realiza a conexão
    
    $sql = "SELECT * FROM produto WHERE id=$id";
    $retval = mysqli_query($myConnection, $sql); //recupera a entrada $id
    $row = mysqli_fetch_array($retval);
    
    $sql = "SELECT * FROM clientes";
    $retval = mysqli_query($myConnection, $sql);
    
    /*while($row1=mysqli_fetch_assoc($retval)){
        #echo '<pre>'; print_r($row1); echo '</pre>';
        echo ($row1['nome']);
    }*/
    

    
    
?>

<html>
    <head>
	 	<?php require_once '../templates/headtag.php'; ?>
	 	<title>Comprar</title>
    </head>
    
    <body>
    
		<form action="processCompra.php?id=<?php echo $id?>" method="post" enctype="multipart/form-data"> 
		
        	<table border="1">

                    <tr>
                        <td><?php echo $row['nome']; ?></td>
						<td><?php echo $row['preco']; ?></td>
                        <td><img src="<?php echo "../adminfiles/images/".$row['imagem']?>" width="50" height="60"></td>
                        <td> 
                        			<label for="quantidade">Quantidade (entre 1 e 10):</label>
									<input type="number" id="quantidade" name="quantidade" min="1" max="10">
						</td>
						<td>  
                        <label for="browser">Choose your browser from the list:</label> <!-- browser quer dizer cliente, mas toda vez que eu mudo o código para de funcionar, então browser será -->
                              <input list="browsers" name="browser" id="browser">
                              <datalist id="browsers">
                              	<?php while ($row1 =mysqli_fetch_assoc($retval)):?>
                                    <option value="<?php echo $row1['nome']; ?>">
                                <?php endwhile; ?>
                              </datalist>
                              <input type="submit">
                        </td>
						<td><input type="submit" value="Comprar"></td>
                    </tr>
        	
        	</table>
    
    	</form>	
    	
   
    
    </body>
</html>