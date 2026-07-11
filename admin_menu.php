<?php
session_start();
// Security check: If not logged in, redirect back to login page
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
    <title>Admin Dashboard | Cit-E</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-base bg-admin-menu d-flex flex-row" style="min-height: 100vh;">

    <aside class="glass-sidebar d-flex flex-column p-4 flex-shrink-0" style="width: 280px; height: 100vh; position: sticky; top: 0;">
        
        <a href="index.html" class="d-flex align-items-center mb-1 me-md-auto text-white text-decoration-none">
            <img src="assets/logo.png" alt="Cit-E Logo" class="sidebar-logo me-2">
            <span class="fs-5 fw-bold">Cit-E Cycling</span>
        </a>
        <span class="text-uppercase text-light opacity-75 fw-bold mb-4 ms-1" style="font-size: 0.7rem; letter-spacing: 1.5px;">Admin Portal</span>
        
        <ul class="nav nav-pills flex-column mb-auto sidebar-nav">
            <li class="nav-item">
                <a href="admin_menu.php" class="nav-link active mb-2" aria-current="page">
                    Dashboard
                </a>
            </li>
            <li>
                <a href="search_form.php" class="nav-link text-white mb-2">
                    Search clubs & participants
                </a>
            </li>
            <li>
                <a href="view_participants_edit_delete.php" class="nav-link text-white mb-2">
                    View / edit / delete participants
                </a>
            </li>
            <li>
                <a href="view_interest.php" class="nav-link text-white mb-2">
                    View registered interest
                </a>
            </li>
        </ul>
        
        <hr class="text-white opacity-25">
        
        <div class="mt-auto">
            <div class="mb-3 ms-2">
                <small class="text-light opacity-75 d-block text-uppercase fw-bold" style="font-size: 0.7rem;">Signed in as</small>
                <strong class="text-white"><?php echo htmlspecialchars($_SESSION['username']); ?></strong>
            </div>
            <a href="login.php?action=logout" class="btn btn-outline-danger w-100 fw-bold rounded-pill">
                Logout
            </a>
        </div>
    </aside>

    <main class="flex-grow-1 p-4 p-md-5 overflow-auto d-flex flex-column" style="height: 100vh;">
        
        <div class="mb-1 fw-bold text-info" style="font-size: 0.85rem;">
            Admin / Dashboard
        </div>
        <h2 class="fw-bold text-white mb-1">Cit-E Cycling web portal</h2>
        <p class="text-light opacity-75 mb-5">Welcome back. Choose an action below to get started.</p>
        
        <div class="glass-card p-4 p-md-5 w-100 shadow-lg" style="max-width: 800px;">
            <h6 class="text-uppercase text-light opacity-75 fw-bold mb-4" style="letter-spacing: 1px;">Quick Actions</h6>
            
            <div class="d-grid gap-3">
                <a href="search_form.php" class="btn btn-white-outline btn-lg fw-bold text-start px-4 rounded-pill">
                    Search for clubs or participants
                </a>
                
                <a href="view_participants_edit_delete.php" class="btn btn-white-outline btn-lg fw-bold text-start px-4 rounded-pill">
                    View all participants to edit or delete
                </a>

                <a href="view_interest.php" class="btn btn-white-outline btn-lg fw-bold text-start px-4 rounded-pill">
                    View registered interest
                </a>
            </div>
        </div>


    </main>

    <h1>Cit-E Cycling web portal</h1>

    <?php
    echo "<p>Welcome, " . htmlspecialchars($_SESSION['username']) . "</p>";
    ?>
    <ul>
        <li><a href="search_form.php">Search for clubs or participants</a></li>
        <li><a href="view_participants_edit_delete.php">View all participants to either edit or delete</a></li>
        <li><a href="view_interest.php">View registered interest</a></li>
        <li><a href="login.php?action=logout">Logout</a></li>
   
    </ul> 
</body>
</html>
