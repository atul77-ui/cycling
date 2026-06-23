<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Search results</title>
    
</head>
<body>
<a href=".">Back to index</a>
    <?php
        
            
            include 'dbconnect.php';
        
        try {
            $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password); //building a new connection object
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            //checking which form has been posted
            if ($_POST['participant'] == "1") {

                echo "search participant";
            }
            else{

                echo "search club";
            }
            
               
            }
        catch(PDOException $e)
            {
                //put error stuff here
            }
        ?>


</body>
</html>