<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register your interest</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body class="bg-base bg-register d-flex flex-column min-vh-100">
    
    <main class="container d-flex flex-grow-1 align-items-center justify-content-center my-4">
        
        <div class="glass-card p-5 w-100 text-center shadow-lg" style="max-width: 500px;">
            
            <div class="mb-4 text-white">
                <i class="fa-solid fa-clipboard-check fa-4x opacity-75"></i>
            </div>
            
            <h2 class="mb-4 fw-bold text-white">Registration Status</h2>
            
            <div class="status-message">
                <?php
                include 'dbconnect.php';

                try {
                    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                    $firstname = $_POST['firstname'];
                    $surname = $_POST['surname'];
                    $email = $_POST['email'];
                    $terms = $_POST['terms'] ? 1:0;

                    if (empty($firstname) || empty($surname) || empty($email) || empty($terms)) {
                        echo "<p>Please fill in all fields and accept the terms.</p>";
                    } else {
                        $stmt = $conn->prepare(
                            "INSERT INTO interest (firstname, surname, email, terms)
                            VALUES (:firstname, :surname, :email, :terms)"
                        );
                        $stmt->bindParam(':firstname', $firstname);
                        $stmt->bindParam(':surname', $surname);
                        $stmt->bindParam(':email', $email);
                        $stmt->bindParam(':terms', $terms, PDO::PARAM_INT);
                        $stmt->execute();

                        echo "<p>Thank you " . htmlspecialchars($firstname) . ", your interest has been registered.</p>";
                    }
                }

                } catch (PDOException $e) {
                    echo $e->getMessage();
                }
                ?>
            </div>

            <hr class="text-white my-4 border-2 opacity-25">
            
            <a href="index.html" class="btn btn-cyan-primary fw-bold px-4">
                <i class="fa-solid fa-arrow-left me-2"></i> Return to Home
            </a>
            
        </div>
        
    </main>

</body>
</html>