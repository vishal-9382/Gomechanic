<?php
session_start();
if (!isset($_SESSION["proff_id"])) {
    header("Location: ../login.php");
    exit();
}
include('machanicheader.php');
require '../database.php'; // Uses $connection

$proff_id = $_SESSION["proff_id"];

// Query statistics
$assignedCount = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(*) AS c FROM jobs WHERE job_machanic = '$proff_id'"))['c'];
$pendingCount = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(*) AS c FROM jobs WHERE job_machanic = '$proff_id' AND work_status = 'Pending'"))['c'];
$completedCount = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(*) AS c FROM jobs WHERE job_machanic = '$proff_id' AND work_status = 'Completed'"))['c'];
$earningsSum = mysqli_fetch_assoc(mysqli_query($connection, "SELECT SUM(bill_amount) AS s FROM jobs WHERE job_machanic = '$proff_id' AND job_status = 'Paid'"))['s'] ?: 0;
?>

<div class="container my-5" data-aos="fade-up">
    <!-- Welcome Header Card -->
    <div class="welcome-box mb-5">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION["proff_name"]); ?>!</h2>
        <p>Manage your assigned service jobs, respond to customer bookings, invoice repairs, and track your total earnings.</p>
    </div>

    <!-- Mechanic Stats Dashboard Grid -->
    <h3 class="fw-bold mb-4" style="font-family:'Outfit',sans-serif;"><i class="fas fa-toolbox text-primary me-2"></i>Performance Overview</h3>
    <div class="dashboard-grid">
        <!-- Card 1: Total Assigned -->
        <div class="metric-card">
            <div class="metric-info">
                <h4>Total Assigned Jobs</h4>
                <div class="metric-value"><?php echo $assignedCount; ?></div>
            </div>
            <div class="metric-icon">
                <i class="fas fa-list-check"></i>
            </div>
        </div>

        <!-- Card 2: Pending -->
        <div class="metric-card color-warning">
            <div class="metric-info">
                <h4>Pending Requests</h4>
                <div class="metric-value"><?php echo $pendingCount; ?></div>
            </div>
            <div class="metric-icon">
                <i class="fas fa-hourglass-half"></i>
            </div>
        </div>

        <!-- Card 3: Completed -->
        <div class="metric-card color-success">
            <div class="metric-info">
                <h4>Completed Work</h4>
                <div class="metric-value"><?php echo $completedCount; ?></div>
            </div>
            <div class="metric-icon">
                <i class="fas fa-check-double"></i>
            </div>
        </div>

        <!-- Card 4: Total Earnings -->
        <div class="metric-card">
            <div class="metric-info">
                <h4>My Paid Earnings</h4>
                <div class="metric-value">₹<?php echo number_format($earningsSum, 2); ?></div>
            </div>
            <div class="metric-icon" style="background: rgba(16, 185, 129, 0.08); color: var(--success);">
                <i class="fas fa-wallet"></i>
            </div>
        </div>
    </div>

    <!-- Quick action links -->
    <div class="row g-4 mt-2">
        <div class="col-md-6">
            <div class="card p-4 h-100">
                <h4 class="fw-bold mb-3"><i class="fas fa-tasks text-primary me-2"></i>Manage Bookings</h4>
                <p class="text-secondary small">View and manage your active customer work requests. You can accept jobs, update progress, and generate repair invoices.</p>
                <div class="mt-3">
                    <a href="viewwork.php" class="btn btn-primary"><i class="fas fa-eye me-1"></i> View Assigned Jobs</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card p-4 h-100">
                <h4 class="fw-bold mb-3"><i class="fas fa-star-half-alt text-warning me-2"></i>Customer Feedbacks</h4>
                <p class="text-secondary small">See what users have said about your recent service work. Read testimonials and track your rating profile.</p>
                <div class="mt-3">
                    <a href="viewfeedback.php" class="btn btn-outline-secondary"><i class="fas fa-comments me-1"></i> View Feedback Reports</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include('footer.php');
?>

