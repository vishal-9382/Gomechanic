<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: ../login.php");
    exit();
}
include('userheader.php');
require '../database.php'; // Uses $connection

$user_id = $_SESSION["user_id"];

// Query statistics
$bookingsCount = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(*) AS c FROM jobs WHERE user_id = '$user_id'"))['c'];
$pendingCount = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(*) AS c FROM jobs WHERE user_id = '$user_id' AND work_status = 'Pending'"))['c'];
$completedCount = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(*) AS c FROM jobs WHERE user_id = '$user_id' AND work_status = 'Completed'"))['c'];
$spentSum = mysqli_fetch_assoc(mysqli_query($connection, "SELECT SUM(bill_amount) AS s FROM jobs WHERE user_id = '$user_id' AND job_status = 'Paid'"))['s'] ?: 0;
?>

<div class="container my-5" data-aos="fade-up">
    <!-- Welcome Header Card -->
    <div class="welcome-box mb-5">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION["user_name"]); ?>!</h2>
        <p>Book a local certified auto mechanic, manage active repair jobs, track your service histories, and leave feedback.</p>
    </div>

    <!-- User Stats Dashboard Grid -->
    <h3 class="fw-bold mb-4" style="font-family:'Outfit',sans-serif;"><i class="fas fa-history text-primary me-2"></i>My Activity</h3>
    <div class="dashboard-grid">
        <!-- Card 1: Requests Sent -->
        <div class="metric-card">
            <div class="metric-info">
                <h4>Total Bookings</h4>
                <div class="metric-value"><?php echo $bookingsCount; ?></div>
            </div>
            <div class="metric-icon">
                <i class="fas fa-clipboard-list"></i>
            </div>
        </div>

        <!-- Card 2: Pending -->
        <div class="metric-card color-warning">
            <div class="metric-info">
                <h4>Pending Assistance</h4>
                <div class="metric-value"><?php echo $pendingCount; ?></div>
            </div>
            <div class="metric-icon">
                <i class="fas fa-spinner fa-spin"></i>
            </div>
        </div>

        <!-- Card 3: Completed -->
        <div class="metric-card color-success">
            <div class="metric-info">
                <h4>Completed Work</h4>
                <div class="metric-value"><?php echo $completedCount; ?></div>
            </div>
            <div class="metric-icon">
                <i class="fas fa-check-circle"></i>
            </div>
        </div>

        <!-- Card 4: Total Spent -->
        <div class="metric-card">
            <div class="metric-info">
                <h4>Total Spent</h4>
                <div class="metric-value">₹<?php echo number_format($spentSum, 2); ?></div>
            </div>
            <div class="metric-icon" style="background: rgba(16, 185, 129, 0.08); color: var(--success);">
                <i class="fas fa-wallet"></i>
            </div>
        </div>
    </div>

    <!-- Action Shortcuts -->
    <div class="row g-4 mt-2">
        <div class="col-md-6">
            <div class="card p-4 h-100">
                <h4 class="fw-bold mb-3"><i class="fas fa-search text-primary me-2"></i>Find and Book Mechanics</h4>
                <p class="text-secondary small">Search for expert mechanics in your area by city and neighborhood, filter by specialty, and send book requests instantly.</p>
                <div class="mt-3">
                    <a href="findmacanic.php" class="btn btn-primary"><i class="fas fa-search me-1"></i> Book a Mechanic</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card p-4 h-100">
                <h4 class="fw-bold mb-3"><i class="fas fa-history text-accent me-2"></i>My Booking Records</h4>
                <p class="text-secondary small">Review booking logs, check request status (pending/accepted/paid), print invoices, and write reviews for completed services.</p>
                <div class="mt-3">
                    <a href="myrequest.php" class="btn btn-accent text-white"><i class="fas fa-receipt me-1"></i> View Booking History</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include('footer.php');
?>

