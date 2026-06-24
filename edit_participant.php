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
    <title>Update participants score</title>
</head>

<body>
    <a href="view_participants_edit_delete.php">Back to participants</a>
    <?php
    include 'dbconnect.php';

    try {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $id = $_POST['id'];
            $power_output = $_POST['power_output'];
            $distance = $_POST['distance_travelled'];

            if (empty($power_output) || empty($distance)) {
                echo "<p>Power output and distance cannot be empty.</p>";
                echo "<a href='view_participants_edit_delete.php'>Back to participants</a>";
            } else {
                $stmt = $conn->prepare(
                    "UPDATE participant
                 SET power_output = :power_output,
                     distance = :distance
                 WHERE id = :id"
                );
                $stmt->bindParam(':power_output', $power_output);
                $stmt->bindParam(':distance', $distance);
                $stmt->bindParam(':id', $id);
                $stmt->execute();

                echo "<p>Participant updated successfully.</p>";
                echo "<a href='view_participants_edit_delete.php'>Back to participants</a>";
            }

        } else {

            $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $id = $_GET['id'];

            $stmt = $conn->prepare("SELECT * FROM participant WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            include "edit_participant_form.php";
        }

    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    ?>
</body>

</html>