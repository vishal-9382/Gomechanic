<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GoMechanic - User Panel</title>
    <!-- Bootstrap 5.3.3 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <!-- Font Awesome 6.4.0 CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- SweetAlert 2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Custom Style Sheet -->
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="userhome.php">
            <img src="../images/logo.png" alt="GoMechanic" style="height: 40px; border-radius: 6px;">
        </a>
        
        <div class="d-flex align-items-center order-lg-last">
            <!-- Theme Toggle button -->
            <button class="theme-toggle-btn" id="themeToggle" title="Toggle Theme">
                <i class="fas fa-moon"></i>
            </button>
            
            <button class="navbar-toggler ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link" href="userhome.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="findmacanic.php">Find Mechanics</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="myrequest.php">My Requests</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="user_contact.php">Contact Us</a>
                </li>
                <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                    <a class="btn btn-danger text-white px-4 font-weight-bold" href="../logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Bootstrap 5.3.3 Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Global Animations and Light/Dark Mode Logic -->
<script src="../js/modern.js"></script>

</body>
</html>