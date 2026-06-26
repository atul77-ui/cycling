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
    <title>Registered Interest</title>
</head>

<body>
    <h1>People who have registered interest</h1>
    <a href="admin_menu.php">Back to menu</a>

    <?php
    include 'dbconnect.php';

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->query("SELECT * FROM interest ORDER BY id ASC");
        $interests = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($interests) == 0) {
            echo "<p>Nobody has registered interest yet.</p>";
        } else {
            echo "<table border='1'>";
            echo "<tr>
                    <th>ID</th>
                    <th>Firstname</th>
                    <th>Surname</th>
                    <th>Email</th>
                    <th>Terms Accepted</th>
                  </tr>";

            foreach ($interests as $i) {
                echo "<tr>";
                echo "<td>" . $i['id'] . "</td>";
                echo "<td>" . $i['firstname'] . "</td>";
                echo "<td>" . $i['surname'] . "</td>";
                echo "<td>" . $i['email'] . "</td>";
                echo "<td>" . ($i['terms'] == 1 ? 'Yes' : 'No') . "</td>";
                echo "</tr>";
            }

            echo "</table>";
        }

    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    ?>
</body>

</html>