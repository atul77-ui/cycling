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
    <title>Search results | Cit-E Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-base bg-admin-search-result d-flex flex-row" style="min-height: 100vh;">

    <aside class="glass-sidebar d-flex flex-column p-4 flex-shrink-0" style="width: 280px; height: 100vh; position: sticky; top: 0;">
        <a href="index.html" class="d-flex align-items-center mb-1 me-md-auto text-white text-decoration-none">
            <img src="assets/logo.png" alt="Cit-E Logo" class="sidebar-logo me-2">
            <span class="fs-5 fw-bold">Cit-E Cycling</span>
        </a>
        <span class="text-uppercase text-light opacity-75 fw-bold mb-4 ms-1" style="font-size: 0.7rem; letter-spacing: 1.5px;">Admin Portal</span>
        
        <ul class="nav nav-pills flex-column mb-auto sidebar-nav">
            <li class="nav-item"><a href="admin_menu.php" class="nav-link text-white mb-2">Dashboard</a></li>
            <li><a href="search_form.php" class="nav-link active mb-2" aria-current="page">Search clubs & participants</a></li>
            <li><a href="view_participants_edit_delete.php" class="nav-link text-white mb-2">View / edit / delete participants</a></li>
            <li><a href="view_interest.php" class="nav-link text-white mb-2">View registered interest</a></li>
        </ul>
        
        <hr class="text-white opacity-25">
        <div class="mt-auto">
            <div class="mb-3 ms-2">
                <small class="text-light opacity-75 d-block text-uppercase fw-bold" style="font-size: 0.7rem;">Signed in as</small>
                <strong class="text-white"><?php echo htmlspecialchars($_SESSION['username']); ?></strong>
            </div>
            <a href="login.php?action=logout" class="btn btn-outline-danger w-100 fw-bold rounded-pill">Logout</a>
        </div>
    </aside>

    <main class="flex-grow-1 p-4 p-md-5 overflow-auto" style="height: 100vh;">
        <div class="mb-1 fw-bold text-info" style="font-size: 0.85rem;">Admin / Search / Results</div>
        
        <div class="d-flex justify-content-between align-items-center mb-5">
            <h2 class="fw-bold text-white mb-0">Search Results</h2>
            <a href="search_form.php" class="btn btn-outline-info rounded-pill fw-bold px-4">
                <i class="fa-solid fa-arrow-left me-2"></i> Back to search
            </a>
        </div>
        
        <div class="glass-card p-4 p-md-5 w-100 shadow-lg animate-card-fade">
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

                    echo "<h4 class='text-white fw-bold mb-4 border-bottom pb-2 border-secondary'>Participant search results</h4>";

                    if (count($results) == 0) {
                        echo "<p class='text-light opacity-75'>No participants found.</p>";
                    } else {
                        // Styled Bootstrap Table
                        echo "<div class='table-responsive'>";
                        echo "<table class='table table-dark table-hover table-bordered align-middle'>";
                        echo "<thead class='table-dark'><tr>
                            <th>Firstname</th>
                            <th>Surname</th>
                            <th>Email</th>
                            <th>Power Output</th>
                            <th>Distance</th>
                          </tr></thead><tbody>";

                        foreach ($results as $p) {
                            echo "<tr>";
                            echo "<td>" . $p['firstname'] . "</td>";
                            echo "<td>" . $p['surname'] . "</td>";
                            echo "<td>" . $p['email'] . "</td>";
                            echo "<td>" . $p['power_output'] . "</td>";
                            echo "<td>" . $p['distance'] . "</td>";
                            echo "</tr>";
                        }

                        echo "</tbody></table></div>";
                    }

                } else {

                    $search = "%" . $_POST['club'] . "%";

                    $stmt = $conn->prepare("SELECT * FROM club WHERE name LIKE :search");
                    $stmt->bindParam(':search', $search);
                    $stmt->execute();

                    $clubs = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    echo "<h4 class='text-white fw-bold mb-4 border-bottom pb-2 border-secondary'>Club search results</h4>";

                    foreach ($clubs as $club) {

                        echo "<h5 class='text-info fw-bold mt-4 mb-3'>" . $club['name'] . "</h5>";

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

                        // Styled Stats Blocks
                        echo "<div class='d-flex flex-wrap gap-3 mb-4'>";
                        echo "<span class='badge bg-dark border border-secondary p-2 fs-6'>Total distance: <span class='text-info'>" . $totalDistance . " km</span> | Avg: <span class='text-info'>" . $avgDistance . " km</span></span>";
                        echo "<span class='badge bg-dark border border-secondary p-2 fs-6'>Total power: <span class='text-info'>" . $totalPower . " W</span> | Avg: <span class='text-info'>" . $avgPower . " W</span></span>";
                        echo "</div>";

                        // Styled Bootstrap Table
                        echo "<div class='table-responsive mb-5'>";
                        echo "<table class='table table-dark table-hover table-bordered align-middle'>";
                        echo "<thead class='table-dark'><tr>
                            <th>Firstname</th>
                            <th>Surname</th>
                            <th>Email</th>
                            <th>Power Output</th>
                            <th>Distance</th>
                        </tr></thead><tbody>";

                        foreach ($members as $m) {
                            echo "<tr>";
                            echo "<td>" . $m['firstname'] . "</td>";
                            echo "<td>" . $m['surname'] . "</td>";
                            echo "<td>" . $m['email'] . "</td>";
                            echo "<td>" . $m['power_output'] . "</td>";
                            echo "<td>" . $m['distance'] . "</td>";
                            echo "</tr>";
                        }

                        echo "</tbody></table></div>";
                    }
                }

            } catch (PDOException $e) {
                // Styled error message
                echo "<div class='alert alert-danger'>" . $e->getMessage() . "</div>";
            }
            ?>
        </div>
    </main>

</body>
</html>