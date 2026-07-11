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
    <title>Registered Interest | Cit-E Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-base bg-wheel-to-sprocket d-flex flex-row" style="min-height: 100vh;">
    
    <aside class="glass-sidebar d-flex flex-column p-4 flex-shrink-0" style="width: 280px; height: 100vh; position: sticky; top: 0;">
        <a href="index.html" class="d-flex align-items-center mb-1 me-md-auto text-white text-decoration-none">
            <img src="assets/logo.png" alt="Cit-E Logo" class="sidebar-logo me-2">
            <span class="fs-5 fw-bold">Cit-E Cycling</span>
        </a>
        <span class="text-uppercase text-light opacity-75 fw-bold mb-4 ms-1" style="font-size: 0.7rem; letter-spacing: 1.5px;">Admin Portal</span>
        
        <ul class="nav nav-pills flex-column mb-auto sidebar-nav">
            <li class="nav-item"><a href="admin_menu.php" class="nav-link text-white mb-2">Dashboard</a></li>
            <li><a href="search_form.php" class="nav-link text-white mb-2">Search clubs & participants</a></li>
            <li><a href="view_participants_edit_delete.php" class="nav-link text-white mb-2">View / edit / delete participants</a></li>
            <li><a href="view_interest.php" class="nav-link active mb-2" aria-current="page">View registered interest</a></li>
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
        <div class="mb-1 fw-bold text-info" style="font-size: 0.85rem;">Admin / Roster / Registered Interest</div>
        <h2 class="fw-bold text-white mb-5">People who have registered interest</h2>
        
        <div class="glass-card p-4 p-md-5 w-100 shadow-lg animate-card-fade">
            
            <?php
            include 'dbconnect.php';

            try {
                $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $stmt = $conn->query("SELECT * FROM interest ORDER BY id ASC");
                $interests = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if (count($interests) == 0) {
                    echo "<p class='text-light opacity-75'>Nobody has registered interest yet.</p>";
                } else {
                    echo "<div class='table-responsive'>";
                    echo "<table class='table table-dark table-hover table-bordered align-middle'>";
                    echo "<thead class='table-dark'><tr>
                            <th>ID</th>
                            <th>Firstname</th>
                            <th>Surname</th>
                            <th>Email</th>
                            <th>Terms Accepted</th>
                          </tr></thead><tbody>";

                    foreach ($interests as $i) {
                        echo "<tr>";
                        echo "<td class='fw-bold text-info'>" . htmlspecialchars($i['id']) . "</td>";
                        echo "<td>" . htmlspecialchars($i['firstname']) . "</td>";
                        echo "<td>" . htmlspecialchars($i['surname']) . "</td>";
                        echo "<td class='text-white'>" . htmlspecialchars($i['email']) . "</td>";
                        
                        if ($i['terms'] == 1) {
                            echo "<td><span class='badge bg-success'>Yes</span></td>";
                        } else {
                            echo "<td><span class='badge bg-danger'>No</span></td>";
                        }
                        
                        echo "</tr>";
                    }

                    echo "</tbody></table></div>";
                }

            } catch (PDOException $e) {
                echo "<div class='alert alert-danger' role='alert'><i class='fa-solid fa-bug me-2'></i>" . htmlspecialchars($e->getMessage()) . "</div>";
            }
            ?>
        </div>
    </main>
</body>
</html>