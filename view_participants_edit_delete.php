<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>View participants</title>
</head>
<body>
    <h1>View all of the participants for edit or delete</h1>
    <a href=".">Back to index</a>
    <?php
        
    //including connection variables - remember to update these if you are using XAMPP    
    include 'dbconnect.php';
        
        try {
            $conn = new PDO("mysql:host=$servername;port=$port;dbname=$database", $username, $password); //building a new connection object
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            //TODO SELECT - view the participants with links to edit or delete them. 
            
            }
        catch(PDOException $e)
            {
            echo $e->getMessage(); //If we are not successful we will see an error
            }
        ?>


</body>
</html>