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
    <title>Search results</title>
</head>

<body>
    <a href=".">Back to index</a>
    <?php
    include 'dbconnect.php';

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if (isset($_POST['participant']) && $_POST['participant'] == "1") {

            $search = "%" . $_POST['firstname'] . "%";

            $stmt = $conn->prepare(
                "SELECT * FROM participant
             WHERE firstname LIKE :search
             OR surname LIKE :search"
            );
            $stmt->bindParam(':search', $search);
            $stmt->execute();

            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo "<h2>Participant search results</h2>";

            if (count($results) == 0) {
                echo "<p>No participants found.</p>";
            } else {
                echo "<table border='1'>";
                echo "<tr>
                    <th>Firstname</th>
                    <th>Surname</th>
                    <th>Email</th>
                    <th>Power Output</th>
                    <th>Distance</th>
                  </tr>";

                foreach ($results as $p) {
                    echo "<tr>";
                    echo "<td>" . $p['firstname'] . "</td>";
                    echo "<td>" . $p['surname'] . "</td>";
                    echo "<td>" . $p['email'] . "</td>";
                    echo "<td>" . $p['power_output'] . "</td>";
                    echo "<td>" . $p['distance'] . "</td>";
                    echo "</tr>";
                }

                echo "</table>";
            }

        } else {

            $search = "%" . $_POST['club'] . "%";

            $stmt = $conn->prepare("SELECT * FROM club WHERE name LIKE :search");
            $stmt->bindParam(':search', $search);
            $stmt->execute();

            $clubs = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo "<h2>Club search results</h2>";

            foreach ($clubs as $club) {

                echo "<h3>" . $club['name'] . "</h3>";

                $stmt2 = $conn->prepare(
                    "SELECT * FROM participant WHERE club_id = :club_id"
                );
                $stmt2->bindParam(':club_id', $club['id']);
                $stmt2->execute();
                $members = $stmt2->fetchAll(PDO::FETCH_ASSOC);

                $totalDistance = 0;
                $totalPower = 0;
                $count = count($members);

                foreach ($members as $m) {
                    $totalDistance += $m['distance'];
                    $totalPower += $m['power_output'];
                }

                $avgDistance = $count > 0 ? round($totalDistance / $count, 2) : 0;
                $avgPower = $count > 0 ? round($totalPower / $count, 2) : 0;

                echo "<p>Total distance: " . $totalDistance . " km | Average distance: " . $avgDistance . " km</p>";
                echo "<p>Total power: " . $totalPower . " W | Average power: " . $avgPower . " W</p>";

                echo "<table border='1'>";
                echo "<tr>
                    <th>Firstname</th>
                    <th>Surname</th>
                    <th>Email</th>
                    <th>Power Output</th>
                    <th>Distance</th>
                </tr>";

                foreach ($members as $m) {
                    echo "<tr>";
                    echo "<td>" . $m['firstname'] . "</td>";
                    echo "<td>" . $m['surname'] . "</td>";
                    echo "<td>" . $m['email'] . "</td>";
                    echo "<td>" . $m['power_output'] . "</td>";
                    echo "<td>" . $m['distance'] . "</td>";
                    echo "</tr>";
                }

                echo "</table>";
            }
        }

    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    ?>
</body>

</html>