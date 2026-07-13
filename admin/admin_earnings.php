<?php
include('adminheader.php');
require '../database.php';

// Fetch admin commission rate
$admin = mysqli_fetch_assoc(mysqli_query($connection, "SELECT commission_percent FROM admin WHERE admin_id = 1"));
$commission_rate = $admin['commission_percent'] ?? 10;

// Date Filters
$from_date = $_GET['from_date'] ?? '';
$to_date   = $_GET['to_date'] ?? '';

$date_condition = "";
if (!empty($from_date) && !empty($to_date)) {
    $date_condition = " AND DATE(j.job_date) BETWEEN '$from_date' AND '$to_date' ";
}

// Summary totals
$total_billed     = 0;
$total_commission = 0;
$total_received   = 0;
$total_pending    = 0;

// Fetch all billed jobs with filters
$query = "
    SELECT j.job_id, j.job_date, j.bill_amount, j.payment_status,
           j.admin_commission, j.mechanic_earnings,
           u.user_Fullname AS customer_name,
           p.mechanic_Fullname AS mechanic_name
    FROM jobs j
    LEFT JOIN user u ON j.user_id = u.user_id
    LEFT JOIN professional p ON j.job_machanic = p.mechanic_id
    WHERE j.bill_amount > 0 $date_condition
    ORDER BY j.job_date DESC
";

$result = mysqli_query($connection, $query);
$jobs = [];

while ($row = mysqli_fetch_assoc($result)) {
    // Calculate commission if not stored
    if ($row['admin_commission'] == 0 && $row['bill_amount'] > 0) {
        $row['admin_commission']  = round($row['bill_amount'] * $commission_rate / 100);
        $row['mechanic_earnings'] = $row['bill_amount'] - $row['admin_commission'];
    }

    $total_billed     += $row['bill_amount'];
    $total_commission += $row['admin_commission'];

    if ($row['payment_status'] === 'Paid') {
        $total_received += $row['admin_commission'];
    } else {
        $total_pending += $row['admin_commission'];
    }

    $jobs[] = $row;
}
?>

<div class="container my-5" data-aos="fade-up">
    <!-- Welcome/Title Row -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark mb-0" style="font-family:'Outfit',sans-serif;"><i class="fas fa-wallet text-primary me-2"></i>Earnings Dashboard</h2>
        <a href="adminhome.php" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i> Dashboard</a>
    </div>

    <!-- Summary Metrics Cards Grid -->
    <div class="dashboard-grid mb-5">
        <!-- Card 1: Total Billed -->
        <div class="metric-card">
            <div class="metric-info">
                <h4>Total Billed Amount</h4>
                <div class="metric-value">₹<?php echo number_format($total_billed, 2); ?></div>
            </div>
            <div class="metric-icon">
                <i class="fas fa-file-invoice-dollar"></i>
            </div>
        </div>

        <!-- Card 2: Commission Rate -->
        <div class="metric-card color-accent">
            <div class="metric-info">
                <h4>Commission Rate</h4>
                <div class="metric-value"><?php echo $commission_rate; ?>%</div>
            </div>
            <div class="metric-icon">
                <i class="fas fa-percent"></i>
            </div>
        </div>

        <!-- Card 3: Total Commission -->
        <div class="metric-card color-success">
            <div class="metric-info">
                <h4>Total Commissions</h4>
                <div class="metric-value">₹<?php echo number_format($total_commission, 2); ?></div>
            </div>
            <div class="metric-icon">
                <i class="fas fa-hand-holding-dollar"></i>
            </div>
        </div>

        <!-- Card 4: Received Commission -->
        <div class="metric-card">
            <div class="metric-info">
                <h4>Received (Paid)</h4>
                <div class="metric-value" style="color: var(--success);">₹<?php echo number_format($total_received, 2); ?></div>
            </div>
            <div class="metric-icon" style="background: rgba(16, 185, 129, 0.08); color: var(--success);">
                <i class="fas fa-piggy-bank"></i>
            </div>
        </div>

        <!-- Card 5: Pending Commission -->
        <div class="metric-card color-warning">
            <div class="metric-info">
                <h4>Pending (Unpaid)</h4>
                <div class="metric-value">₹<?php echo number_format($total_pending, 2); ?></div>
            </div>
            <div class="metric-icon">
                <i class="fas fa-clock"></i>
            </div>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="card p-4 mb-4">
        <h4 class="fw-bold mb-3" style="font-family:'Outfit',sans-serif;"><i class="fas fa-calendar-alt text-primary me-2"></i>Filter Transactions</h4>
        <form method="GET" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label fw-bold text-secondary">From Date</label>
                <input type="date" name="from_date" value="<?php echo htmlspecialchars($from_date); ?>" class="form-control">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold text-secondary">To Date</label>
                <input type="date" name="to_date" value="<?php echo htmlspecialchars($to_date); ?>" class="form-control">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100 py-2.5 fw-bold"><i class="fas fa-filter me-1"></i> Filter</button>
            </div>
            <div class="col-md-2">
                <a href="admin_earnings.php" class="btn btn-outline-secondary w-100 py-2.5 fw-bold"><i class="fas fa-undo me-1"></i> Reset</a>
            </div>
        </form>
    </div>

    <!-- Earnings Breakdown Table -->
    <div class="card p-4">
        <h4 class="fw-bold mb-4" style="font-family:'Outfit',sans-serif;"><i class="fas fa-list-check text-primary me-2"></i>Job-wise Earnings Breakdown</h4>
        
        <?php if (empty($jobs)): ?>
            <div class="text-center py-5 text-secondary">
                <i class="fas fa-folder-open fa-3x mb-3 d-block text-muted"></i>
                No billed transactions found matching the selected dates.
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th style="width: 60px;">#</th>
                            <th>Job ID</th>
                            <th>Date Issued</th>
                            <th>Customer</th>
                            <th>Mechanic</th>
                            <th class="text-end">Bill Amount</th>
                            <th class="text-end">Commission (<?php echo $commission_rate; ?>%)</th>
                            <th class="text-end">Mechanic Earnings</th>
                            <th class="text-center">Payment Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $sr = 1; foreach ($jobs as $job): ?>
                            <tr>
                                <td><?php echo $sr++; ?></td>
                                <td><strong>#<?php echo $job['job_id']; ?></strong></td>
                                <td><small class="text-secondary"><?php echo date('d M Y, h:i A', strtotime($job['job_date'])); ?></small></td>
                                <td><strong><?php echo htmlspecialchars($job['customer_name'] ?? 'N/A'); ?></strong></td>
                                <td><strong><?php echo htmlspecialchars($job['mechanic_name'] ?? 'N/A'); ?></strong></td>
                                <td class="text-end">₹<?php echo number_format($job['bill_amount'], 2); ?></td>
                                <td class="text-end text-success fw-bold">₹<?php echo number_format($job['admin_commission'], 2); ?></td>
                                <td class="text-end text-primary fw-bold">₹<?php echo number_format($job['mechanic_earnings'], 2); ?></td>
                                <td class="text-center">
                                    <?php if ($job['payment_status'] === 'Paid'): ?>
                                        <span class="status-badge badge-paid"><i class="fas fa-check-circle me-1"></i> Paid</span>
                                    <?php else: ?>
                                        <span class="status-badge badge-rejected"><i class="fas fa-times-circle me-1"></i> Unpaid</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr class="fw-bold" style="background-color: var(--bg-light); border-top: 2px solid var(--border-color);">
                            <td colspan="5" class="text-end py-3">Totals:</td>
                            <td class="text-end py-3">₹<?php echo number_format($total_billed, 2); ?></td>
                            <td class="text-end py-3 text-success">₹<?php echo number_format($total_commission, 2); ?></td>
                            <td class="text-end py-3 text-primary">₹<?php echo number_format($total_billed - $total_commission, 2); ?></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include('footer.php'); ?>