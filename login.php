<?php
session_start();

if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_destroy();
    header('Location: index.html');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Status | Cit-E</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body class="bg-base bg-admin d-flex flex-column min-vh-100">

    <main class="container d-flex flex-grow-1 align-items-center justify-content-center" style="min-height: 100vh;">
        
        <div class="glass-card p-5 w-100 text-center shadow-lg" style="max-width: 500px;">
            
            <div class="mb-4 text-warning">
                <i class="fa-solid fa-triangle-exclamation fa-4x opacity-75"></i>
            </div>
            
            <h2 class="mb-4 fw-bold text-white">Login Issue</h2>
            
            <div class="status-message">
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
            </div>
            
        </div>
    </main>
</body>
</html>