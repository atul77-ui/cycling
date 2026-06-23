<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
</head>

<body>
    <?php
    include 'dbconnect.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $inputUsername = $_POST['username'];
            $inputPassword = $_POST['password'];

            $stmt = $conn->prepare(
                "SELECT * FROM user
                WHERE username = :username
                AND password = :password
                LIMIT 1"
            );
            $stmt->bindParam(':username', $inputUsername);
            $stmt->bindParam(':password', $inputPassword);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $user['username'];
                header('Location: admin_menu.php');
                exit;
            } else {
                echo "<p>Invalid username or password. Please try again.</p>";
                echo "<a href='admin_login.html'>Go back</a>";
            }

        } catch (PDOException $e) {
            echo $e->getMessage();
        }

    } else {
        echo "You're here by mistake";
        echo "<a href='admin_login.html'>Go to login</a>";
    }
    ?>
</body>

</html>