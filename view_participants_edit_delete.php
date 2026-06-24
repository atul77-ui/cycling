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
    <title>View participants</title>
</head>

<body>
    <h1>View all of the participants for edit or delete</h1>
    <a href=".">Back to index</a>
    <?php
    include 'dbconnect.php';

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->query("SELECT * FROM participant ORDER BY surname ASC");
        $participants = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo "<table border='1'>";
        echo "<tr>
                <th>ID</th>
                <th>Firstname</th>
                <th>Surname</th>
                <th>Email</th>
                <th>Power Output</th>
                <th>Distance</th>
                <th>Actions</th>
            </tr>";

        foreach ($participants as $p) {
            echo "<tr>";
            echo "<td>" . $p['id'] . "</td>";
            echo "<td>" . $p['firstname'] . "</td>";
            echo "<td>" . $p['surname'] . "</td>";
            echo "<td>" . $p['email'] . "</td>";
            echo "<td>" . $p['power_output'] . "</td>";
            echo "<td>" . $p['distance'] . "</td>";
            echo "<td>
                    <a href='edit_participant.php?id=" . $p['id'] . "'>Edit</a> |
                    <a href='delete.php?id=" . $p['id'] . "'>Delete</a>
                </td>";
            echo "</tr>";
        }

        echo "</table>";

    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    ?>
</body>

</html>