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

<body>
    <?php
    include 'dbconnect.php';

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $firstname = $_POST['firstname'];
        $surname = $_POST['surname'];
        $email = $_POST['email'];
        $terms = $_POST['terms'] ?? '';

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
            $stmt->bindParam(':terms', $terms);
            $stmt->execute();

            echo "<p>Thank you " . htmlspecialchars($firstname) . ", your interest has been registered.</p>";
        }

    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    ?>
</body>
</html>
