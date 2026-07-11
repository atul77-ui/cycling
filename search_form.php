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
    <title>Search for participants or clubs | Cit-E Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-base bg-admin-search d-flex flex-row" style="min-height: 100vh;">

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
        <div class="mb-1 fw-bold text-info" style="font-size: 0.85rem;">Admin / Search</div>
        <h2 class="fw-bold text-white mb-5">Search Database</h2>
        
        <div class="glass-card p-4 p-md-5 w-100 shadow-lg animate-card-fade" style="max-width: 700px;">
            
            <h6 class="text-uppercase text-light opacity-75 fw-bold mb-4" style="letter-spacing: 1px;">Search for an individual participant</h6>
            
            <form action="search_result.php" method="POST">
                <div class="mb-4">
                    <label class="form-label text-white fw-bold">Participant firstname or surname</label>
                    <input type="text" name="firstname" class="form-control glass-input form-control-lg" placeholder="Enter name...">
                    <input type="hidden" name="participant" value="1">
                </div>
                <button type="submit" class="btn btn-cyan-primary btn-lg fw-bold w-100 rounded-pill">
                    <i class="fa-solid fa-user me-2"></i> Search Participant
                </button>
            </form>

            <hr class="text-white opacity-25 my-5">

            <h6 class="text-uppercase text-light opacity-75 fw-bold mb-4" style="letter-spacing: 1px;">Search for a club / team</h6>
            
            <form action="search_result.php" method="POST">
                <div class="mb-4">
                    <label class="form-label text-white fw-bold">Club name</label>
                    <input type="text" name="club" class="form-control glass-input form-control-lg" placeholder="Enter club name...">
                </div>
                <button type="submit" class="btn btn-cyan-primary btn-lg fw-bold w-100 rounded-pill">
                    <i class="fa-solid fa-users me-2"></i> Search Club
                </button>
            </form>

        </div>
    </main>

</body>
</html>