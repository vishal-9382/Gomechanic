<?php
include('adminheader.php');
require_once('db_connection.php'); // Uses $conn connection variable

// Fetch statistics
$usersCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM user"))['c'];
$mechsCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM professional"))['c'];
$jobsCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM jobs"))['c'];
$completedCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM jobs WHERE work_status = 'Completed'"))['c'];
$earningsCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(bill_amount) AS s FROM jobs WHERE job_status = 'Paid'"))['s'] ?: 0;
$queriesCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM contact_queries"))['c'];
?>

<div class="container my-5" data-aos="fade-up">
    <!-- Welcome Header Card -->
    <div class="welcome-box mb-5">
        <h2>Welcome to Admin Panel</h2>
        <p>Manage cities, locations, service professionals, customer requests, and review platform earnings.</p>
    </div>

    <!-- Dashboard Statistics Grid -->
    <h3 class="fw-bold mb-4" style="font-family:'Outfit',sans-serif;"><i class="fas fa-chart-line text-primary me-2"></i>Platform Overview</h3>
    <div class="dashboard-grid">
        <!-- Card 1: Users -->
        <div class="metric-card">
            <div class="metric-info">
                <h4>Total Users</h4>
                <div class="metric-value"><?php echo $usersCount; ?></div>
            </div>
            <div class="metric-icon">
                <i class="fas fa-users"></i>
            </div>
        </div>

        <!-- Card 2: Mechanics -->
        <div class="metric-card color-accent">
            <div class="metric-info">
                <h4>Active Mechanics</h4>
                <div class="metric-value"><?php echo $mechsCount; ?></div>
            </div>
            <div class="metric-icon">
                <i class="fas fa-user-gear"></i>
            </div>
        </div>

        <!-- Card 3: Requests -->
        <div class="metric-card color-warning">
            <div class="metric-info">
                <h4>Service Requests</h4>
                <div class="metric-value"><?php echo $jobsCount; ?></div>
            </div>
            <div class="metric-icon">
                <i class="fas fa-tools"></i>
            </div>
        </div>

        <!-- Card 4: Completed -->
        <div class="metric-card color-success">
            <div class="metric-info">
                <h4>Completed Services</h4>
                <div class="metric-value"><?php echo $completedCount; ?></div>
            </div>
            <div class="metric-icon">
                <i class="fas fa-clipboard-check"></i>
            </div>
        </div>

        <!-- Card 5: Revenue -->
        <div class="metric-card">
            <div class="metric-info">
                <h4>Platform Revenue</h4>
                <div class="metric-value">₹<?php echo number_format($earningsCount, 2); ?></div>
            </div>
            <div class="metric-icon" style="background: rgba(16, 185, 129, 0.08); color: var(--success);">
                <i class="fas fa-wallet"></i>
            </div>
        </div>

        <!-- Card 6: Queries -->
        <div class="metric-card color-danger">
            <div class="metric-info">
                <h4>Customer Queries</h4>
                <div class="metric-value"><?php echo $queriesCount; ?></div>
            </div>
            <div class="metric-icon">
                <i class="fas fa-envelope-open-text"></i>
            </div>
        </div>
    </div>

    <!-- Quick Links Grid -->
    <div class="row g-4 mt-2">
        <div class="col-md-6">
            <div class="card p-4 h-100">
                <h4 class="fw-bold mb-3"><i class="fas fa-map-marked-alt text-primary me-2"></i>Quick Location Configuration</h4>
                <p class="text-secondary small">Instantly define coverage nodes by adding cities and service areas. Ensure users can locate mechanics accurately.</p>
                <div class="d-flex gap-2 mt-3">
                    <a href="addnewcity.php" class="btn btn-primary btn-sm"><i class="fas fa-plus me-1"></i> Add City</a>
                    <a href="addnewarea.php" class="btn btn-outline-secondary btn-sm"><i class="fas fa-plus me-1"></i> Add Area</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card p-4 h-100">
                <h4 class="fw-bold mb-3"><i class="fas fa-users-cog text-accent me-2"></i>User &amp; Provider Moderation</h4>
                <p class="text-secondary small">Review query submissions, view customer feedback reports, and suspend/activate mechanic credentials.</p>
                <div class="d-flex gap-2 mt-3">
                    <a href="manageprofessional.php" class="btn btn-accent btn-sm text-white"><i class="fas fa-user-shield me-1"></i> Mechanics</a>
                    <a href="manageusers.php" class="btn btn-outline-secondary btn-sm"><i class="fas fa-user-edit me-1"></i> Users</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include('footer.php');
?>

