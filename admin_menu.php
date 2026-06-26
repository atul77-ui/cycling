<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
     header('Location: admin_login.html');
exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin menu</title>
</head>


<body>

    <h1>Cit-E Cycling web portal</h1>

    <?php
    echo "<p>Welcome, " . htmlspecialchars($_SESSION['username']) . "</p>";
    ?>
    <ul>
        <li><a href="search_form.php">Search for clubs or participants</a></li>
        <li><a href="view_participants_edit_delete.php">View all participants to either edit or delete</a></li>
        <li><a href="view_interest.php">View registered interest</a></li>
        <li><a href="login.php?action=logout">Logout</a></li>
   
    </ul> 
</body>
</html>
