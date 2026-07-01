<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register your interest</title>
</head>
<body>
    <?php
    include 'dbconnect.php';

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $firstname = $_POST['firstname'];
            $surname   = $_POST['surname'];
            $email     = $_POST['email'];
            $terms     = isset($_POST['terms']) ? 1 : 0;

            if (empty($firstname) || empty($surname) || empty($email) || $terms === 0) {
                echo "<p>Please fill in all fields and accept the terms.</p>";
            } else {
                $stmt = $conn->prepare(
                    "INSERT INTO interest (firstname, surname, email, terms)
                     VALUES (:firstname, :surname, :email, :terms)"
                );
                $stmt->bindParam(':firstname', $firstname);
                $stmt->bindParam(':surname',   $surname);
                $stmt->bindParam(':email',     $email);
                $stmt->bindParam(':terms',     $terms, PDO::PARAM_INT);
                $stmt->execute();

                echo "<p>Thank you " . htmlspecialchars($firstname) . ", your interest has been registered.</p>";
                echo "<a href='.'>Back to home</a>";
            }
        }

    } catch(PDOException $e) {
        echo $e->getMessage();
    }
    ?>
</body>
</html>
