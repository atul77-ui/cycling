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
    <title>Delete participant</title>
</head>

<body>
    <?php
    include 'dbconnect.php';

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $id = $_POST['id'];

            $stmt = $conn->prepare("DELETE FROM participant WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            echo "<p>Participant deleted successfully.</p>";
            echo "<a href='view_participants_edit_delete.php'>Back to participants</a>";

        } else {

            $id = $_GET['id'];

            $stmt = $conn->prepare("SELECT * FROM participant WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $p = $stmt->fetch(PDO::FETCH_ASSOC);

            echo "<p>Are you sure you want to delete <strong>"
                . $p['firstname'] . " " . $p['surname']
                . "</strong>? This cannot be undone.</p>";
            echo "<form method='POST' action='delete.php'>";
            echo "<input type='hidden' name='id' value='" . $p['id'] . "'>";
            echo "<input type='submit' value='Yes, delete this participant'>";
            echo "</form>";
            echo "<a href='view_participants_edit_delete.php'>Cancel</a>";
        }

    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    ?>
</body>

</html>