<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Update participant scores</title>
</head>
<body>
    <form action="edit_participant.php" method="POST">
        Particpant Firstname<br>
        <input type="text" name="firstname" disabled value="<?php ?>"> <br>
        Particpant Surname <br>
        <input type="text" name="surname" disabled value="<?php ?>"> <br>
        Power output in watts<br>
        <input type="text" name="power_output" value="<?php ?>"> <br>
        Distance in KM<br>
        <input type="text" name="distance_travelled" value="<?php ?>"> <br>
        <input type="hidden" name ="id" value="<?php ?>">

        <input type="submit" value="Update this rider">
            
        
    </form>
    
</body>
</html>