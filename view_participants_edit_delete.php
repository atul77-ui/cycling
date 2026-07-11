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
    <title>View Participants | Cit-E Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body class="bg-base bg-admin-roster d-flex flex-row" style="min-height: 100vh;">

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

    <main class="flex-grow-1 p-4 p-md-5 overflow-auto d-flex flex-column" style="height: 100vh;">
        <div class="mb-1 fw-bold text-info" style="font-size: 0.85rem;">Admin / Roster</div>
        <h2 class="fw-bold text-white mb-5">Manage Participants</h2>
        
        <div class="glass-card p-4 p-md-5 w-100 shadow-lg animate-card-fade">
            
            <?php
            include 'dbconnect.php';

            try {
                $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // --- NEW: Calculate Total Power and Distance ---
                $totalsStmt = $conn->query("SELECT SUM(power_output) as total_power, SUM(distance) as total_distance FROM participant");
                $totals = $totalsStmt->fetch(PDO::FETCH_ASSOC);
                
                $grandTotalPower = $totals['total_power'] ?? 0;
                $grandTotalDistance = $totals['total_distance'] ?? 0;
                ?>

                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
                    <h6 class="text-uppercase text-light opacity-75 fw-bold mb-0 mt-2" style="letter-spacing: 1px;">Registered Participants</h6>
                    
                    <div class="d-flex gap-3 mt-3 mt-md-0">
                        <span class="badge bg-info text-dark px-3 py-2 rounded-pill shadow-sm" style="font-size: 0.95rem;">
                            <i class="fa-solid fa-bolt me-1"></i> Total Power: <?php echo htmlspecialchars($grandTotalPower); ?> W
                        </span>
                        <span class="badge bg-primary text-white px-3 py-2 rounded-pill shadow-sm" style="font-size: 0.95rem;">
                            <i class="fa-solid fa-road me-1"></i> Total Distance: <?php echo htmlspecialchars($grandTotalDistance); ?> km
                        </span>
                    </div>
                </div>

                <?php
                // --- ORIGINAL QUERY: Fetch participants by Surname ---
                $stmt = $conn->query("SELECT * FROM participant ORDER BY id ASC");
                $participants = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if (count($participants) == 0) {
                    echo "<p class='text-light opacity-75 m-0'>No participants found in the database.</p>";
                } else {
                    echo "<div class='table-responsive'>";
                    echo "<table class='table table-dark table-hover table-bordered align-middle m-0'>";
                    echo "<thead class='table-dark'><tr>
                            <th>ID</th>
                            <th>Firstname</th>
                            <th>Surname</th>
                            <th>Email</th>
                            <th>Power Output</th>
                            <th>Distance</th>
                            <th class='text-center'>Actions</th>
                          </tr></thead><tbody>";

                    foreach ($participants as $p) {
                        echo "<tr>";
                        echo "<td class='fw-bold text-info'>" . htmlspecialchars($p['id']) . "</td>";
                        echo "<td>" . htmlspecialchars($p['firstname']) . "</td>";
                        echo "<td>" . htmlspecialchars($p['surname']) . "</td>";
                        echo "<td class='text-white'>" . htmlspecialchars($p['email']) . "</td>";
                        echo "<td>" . htmlspecialchars($p['power_output']) . " W</td>";
                        echo "<td>" . htmlspecialchars($p['distance']) . " km</td>";
                        
                        // Edit & Delete Buttons
                        echo "<td class='text-center' style='min-width: 180px;'>
                                <a href='edit_participant.php?id=" . htmlspecialchars($p['id']) . "' class='btn btn-sm btn-outline-light me-1 px-3 rounded-pill'>
                                    <i class='fa-solid fa-pen-to-square me-1'></i> Edit
                                </a>
                                <a href='delete.php?id=" . htmlspecialchars($p['id']) . "' class='btn btn-sm btn-outline-danger px-3 rounded-pill' onclick='return confirm(\"Are you sure you want to delete this participant?\");'>
                                    <i class='fa-solid fa-trash me-1'></i> Delete
                                </a>
                              </td>";
                        echo "</tr>";
                    }

                    echo "</tbody></table></div>";
                }

            } catch (PDOException $e) {
                echo "<div class='alert alert-danger m-0' role='alert'><i class='fa-solid fa-bug me-2'></i>" . htmlspecialchars($e->getMessage()) . "</div>";
            }
            ?>
        </div>
    </main>
</body>
</html>