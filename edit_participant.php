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
    <title>Update Participants Score | Cit-E Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-base bg-admin-roster bg-static d-flex flex-row" style="min-height: 100vh;">

    <aside class="glass-sidebar d-flex flex-column p-4 flex-shrink-0" style="width: 280px; height: 100vh; position: sticky; top: 0;">
        <a href="index.html" class="d-flex align-items-center mb-1 me-md-auto text-white text-decoration-none">
            <img src="assets/logo.png" alt="Cit-E Logo" class="sidebar-logo me-2">
            <span class="fs-5 fw-bold">Cit-E Cycling</span>
        </a>
        <span class="text-uppercase text-light opacity-75 fw-bold mb-4 ms-1" style="font-size: 0.7rem; letter-spacing: 1.5px;">Admin Portal</span>
        
        <ul class="nav nav-pills flex-column mb-auto sidebar-nav">
            <li class="nav-item"><a href="admin_menu.php" class="nav-link text-white mb-2">Dashboard</a></li>
            <li><a href="search_form.php" class="nav-link text-white mb-2">Search clubs & participants</a></li>
            <li><a href="view_participants_edit_delete.php" class="nav-link active mb-2" aria-current="page">View / edit / delete participants</a></li>
            <li><a href="view_interest.php" class="nav-link text-white mb-2">View registered interest</a></li>
        </ul>
        
        <hr class="text-white opacity-25">
        <div class="mt-auto">
            <div class="mb-3 ms-2">
                <small class="text-light opacity-75 d-block text-uppercase fw-bold" style="font-size: 0.7rem;">Signed in as</small>
                <strong class="text-white"><?php echo htmlspecialchars($_SESSION['username'] ?? 'admin'); ?></strong>
            </div>
            <a href="login.php?action=logout" class="btn btn-outline-danger w-100 fw-bold rounded-pill">Logout</a>
        </div>
    </aside>

    <main class="flex-grow-1 p-4 p-md-5 overflow-auto" style="height: 100vh;">
        <div class="mb-1 fw-bold text-info" style="font-size: 0.85rem;">Admin / Roster / Edit</div>
        
        <div class="d-flex justify-content-between align-items-center mb-5">
            <h2 class="fw-bold text-white mb-0">Update Participant Metrics</h2>
            <a href="view_participants_edit_delete.php" class="btn btn-outline-info rounded-pill fw-bold px-4">
                <i class="fa-solid fa-arrow-left me-2"></i> Back to participants
            </a>
        </div>
        
        <div class="glass-card p-4 p-md-5 w-100 shadow-lg animate-card-fade" style="max-width: 650px;">
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
                        echo "<div class='alert alert-warning d-flex align-items-center' role='alert'>
                                <i class='fa-solid fa-triangle-exclamation me-3 fs-4'></i>
                                <div><strong>Validation Error:</strong> Power output and distance fields cannot be empty.</div>
                              </div>";
                        echo "<a href='view_participants_edit_delete.php' class='btn btn-cyan-primary fw-bold w-100 rounded-pill mt-3'>Return to Participant List</a>";
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

                        echo "<div class='alert alert-success d-flex align-items-center' role='alert'>
                                <i class='fa-solid fa-circle-check me-3 fs-4'></i>
                                <div><strong>Success!</strong> Participant metrics have been successfully updated.</div>
                              </div>";
                        echo "<a href='view_participants_edit_delete.php' class='btn btn-cyan-primary fw-bold w-100 rounded-pill mt-3'>Return to Participant List</a>";
                    }

                } else {

                    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    $id = $_GET['id'];

                    $stmt = $conn->prepare("SELECT * FROM participant WHERE id = :id");
                    $stmt->bindParam(':id', $id);
                    $stmt->execute();

                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                    // This includes your custom inputs file cleanly inside our glass wrapper layout
                    include "edit_participant_form.php";
                }

            } catch (PDOException $e) {
                echo "<div class='alert alert-danger role='alert'><i class='fa-solid fa-bug me-2'></i>" . htmlspecialchars($e->getMessage()) . "</div>";
            }
            ?>
        </div>
    </main>

</body>
</html>