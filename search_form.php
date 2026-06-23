<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register your interest</title>
</head>


<body>
    <a href=".">Back to index</a>
    <h1>Search for participants or clubs</h1>

    <h2>Search for an individual participant</h2>
    <form action="search_result.php" method="POST">
        <p>Participant firstname or surname</p>
        <input type="text" name="firstname"><br>
        <input type="hidden" name="participant" value="1">
        <input type = "Submit">

    </form>
    
    <h2>Search for a club / team</h2>
    <form action="search_result.php" method="POST">
        <p>Club name</p>
        <input type="text" name="club"><br>
        <input type = "Submit">

    </form>
</body>
</html>