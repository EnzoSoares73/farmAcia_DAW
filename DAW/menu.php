<?php

    require_once 'dbconfig.php';
    
    $myConnection= mysqli_connect("$host","$username","$password") or die ("could not connect to mysql");
    mysqli_select_db($myConnection, $dbname) or die ("no database");
    
    $sql="SHOW tables FROM $dbname ";
    
    if(!$result = mysqli_query($myConnection, $sql)){
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($myConnection);
    }
    
    $myConnection=null;
?>

<html> 
    
    <head>
		<?php require_once 'headtag.php';?>
        <title>Menu</title>
    </head>
    
    <body>
    
    	<ul>
			<?php while ($row = mysqli_fetch_row($result)) : ?>
				<li><a href="templateShow.php?table=<?php  echo $row[0]; ?>" ><?php echo $row[0]; ?></a></li>
			<?php endwhile;?>
			
    	</ul>
    
    </body>


    
</html> 