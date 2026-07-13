<?php
include('../database.php');
session_start();
$msg = null;

// ─────────────────────────────────────────────
// Helper: run a prepared UPDATE, return bool
// ─────────────────────────────────────────────
function runUpdate(mysqli $conn, string $sql, string $types, ...$params): bool {
    $stmt = $conn->prepare($sql);
    if (!$stmt) return false;
    $stmt->bind_param($types, ...$params);
    $ok = $stmt->execute();
    $stmt->close();
    return $ok;
}

// ── Accept job ───────────────────────────────
if (isset($_POST['accept'])) {
    $jobid       = (int) $_POST['jobid'];
    $fixed_issue = $_POST['fixed_issue'] ?? '';   // field absent on Accept form → default ''

    $ok  = runUpdate($connection,
        "UPDATE jobs SET job_status='Accepted', work_status='Pending', fixed_issue=? WHERE job_id=?",
        'si', $fixed_issue, $jobid);
    $msg = $ok ? "Job Accepted Successfully" : $connection->error;
}

// ── Reject job ───────────────────────────────
if (isset($_POST['reject'])) {
    $jobid = (int) $_POST['jobid'];

    $ok  = runUpdate($connection,
        "UPDATE jobs SET job_status='Rejected', work_status='Pending' WHERE job_id=?",
        'i', $jobid);
    $msg = $ok ? "Job Rejected Successfully" : $connection->error;
}

// ── Mark work as completed ───────────────────
if (isset($_POST['complete'])) {
    $jobid = (int) $_POST['jobid'];

    $ok  = runUpdate($connection,
        "UPDATE jobs SET work_status='Completed' WHERE job_id=?",
        'i', $jobid);
    $msg = $ok ? "Work Marked as Completed" : $connection->error;
}

// ── Generate Bill ────────────────────────────
if (isset($_POST['generate_bill'])) {
    $jobid        = (int)   $_POST['jobid'];
    $worked_hours = (float) $_POST['worked_hours'];
    $fixed_issue  = trim($_POST['fixed_issue']);
    $upi_id       = trim($_POST['upi_id']);

    // Fetch mechanic rate + admin commission via prepared statement
    $stmt = $connection->prepare(
        "SELECT p.rate_per_hour, a.commission_percent
         FROM jobs j
         INNER JOIN professional p ON j.job_machanic = p.mechanic_id
         INNER JOIN admin        a ON a.admin_id = 1
         WHERE j.job_id = ?"
    );
    $stmt->bind_param('i', $jobid);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res && $res->num_rows > 0) {
        $row                = $res->fetch_assoc();
        $rate_per_hour      = (float) $row['rate_per_hour'];
        $commission_percent = (float) $row['commission_percent'];

        $total_bill        = (int) round($worked_hours * $rate_per_hour);
        $admin_commission  = (int) round($total_bill * $commission_percent / 100);
        $mechanic_earnings = $total_bill - $admin_commission;

        $stmt->close();

        $ok  = runUpdate($connection,
            "UPDATE jobs
             SET bill_amount=?, fixed_issue=?, upi_id=?,
                 admin_commission=?, mechanic_earnings=?
             WHERE job_id=?",
            'isssii',
            $total_bill, $fixed_issue, $upi_id,
            $admin_commission, $mechanic_earnings, $jobid);
        $msg = $ok
            ? "Bill Generated Successfully! Total Bill: ₹$total_bill"
            : $connection->error;
    } else {
        $stmt->close();
        $msg = "Error fetching mechanic's rate.";
    }
}

// ── Safe alert message ───────────────────────
if ($msg) {
    $safe_msg = addslashes(htmlspecialchars($msg, ENT_QUOTES, 'UTF-8'));
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: '" . (strpos($msg, "Successfully") !== false ? "success" : "error") . "',
                title: 'Notification',
                text: '$safe_msg',
                confirmButtonColor: '#2563EB'
            });
        });
    </script>";
}

include('machanicheader.php');
?>

<div class="container my-5" data-aos="fade-up">
    <div class="card p-4">
        <h2 class="fw-bold mb-4" style="font-family:'Outfit',sans-serif;"><i class="fas fa-tasks text-primary me-2"></i>Job Request Queue</h2>
        
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>User Name</th>
                        <th>User Address</th>
                        <th>User Contact</th>
                        <th>Request Date</th>
                        <th>Request Status</th>
                        <th>Action</th>
                        <th>Work Status</th>
                        <th>Complete Job</th>
                        <th>Generate Bill</th>
                        <th>Bill Amount</th>
                        <th>Final Earnings</th>
                        <th>Payment Status</th>
                        <th>Invoice</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sno        = 1;
                    $machanicid = (int) $_SESSION["proff_id"];

                    // Fetch admin commission once
                    $comm_stmt = $connection->prepare("SELECT commission_percent FROM admin WHERE admin_id = 1");
                    $comm_stmt->execute();
                    $comm_res = $comm_stmt->get_result();
                    $commission_percent = ($comm_res && $comm_res->num_rows > 0)
                        ? (float) $comm_res->fetch_assoc()['commission_percent']
                        : 10;
                    $comm_stmt->close();
                    // Fetch jobs for this mechanic
                    ?>
                    <?php
                    $stmt = $connection->prepare(
                        "SELECT j.*, u.user_Fullname, u.user_address, u.user_city, u.user_contact
                         FROM jobs j
                         INNER JOIN user u ON u.user_id = j.user_id
                         WHERE j.job_machanic = ?
                         ORDER BY j.job_date DESC"
                    );
                    $stmt->bind_param('i', $machanicid);
                    $stmt->execute();
                    $results = $stmt->get_result();

                    if ($results && $results->num_rows > 0):
                        while ($row = $results->fetch_object()):
                            $jobid          = (int)   $row->job_id;
                            $user_Name      = $row->user_Fullname;
                            $address        = $row->user_address;
                            $city           = $row->user_city;
                            $Contact        = $row->user_contact;
                            $date           = date('d M Y, h:i A', strtotime($row->job_date));
                            $status         = $row->job_status;
                            $work_status    = $row->work_status;
                            $bill_amount    = (int) $row->bill_amount;
                            $fixed_issue    = $row->fixed_issue;
                            $upi_id         = $row->upi_id;
                            $payment_status = $row->payment_status;

                            // Final amount after admin commission
                            if ($bill_amount > 0) {
                                $mechanic_earnings = ((int)$row->mechanic_earnings > 0)
                                    ? (int) $row->mechanic_earnings
                                    : (int) round($bill_amount - ($bill_amount * $commission_percent / 100));
                            } else {
                                $mechanic_earnings = 0;
                            }

                            // Badge classes
                            $badge_class = 'badge-pending';
                            if ($status === 'Accepted') $badge_class = 'badge-accepted';
                            elseif ($status === 'Rejected') $badge_class = 'badge-rejected';

                            $wbadge = 'badge-pending';
                            if ($work_status === 'Completed')   $wbadge = 'badge-completed';
                            elseif ($work_status === 'In Progress') $wbadge = 'badge-progress';
                    ?>
                    <tr>
                        <td><?= $sno++ ?></td>
                        <td><strong><?= htmlspecialchars($user_Name, ENT_QUOTES, 'UTF-8') ?></strong></td>
                        <td><small class="text-secondary"><?= htmlspecialchars($address . ', ' . $city, ENT_QUOTES, 'UTF-8') ?></small></td>
                        <td><small><a href="tel:<?= $Contact ?>" class="text-secondary"><?= htmlspecialchars($Contact, ENT_QUOTES, 'UTF-8') ?></a></small></td>
                        <td><small><?= htmlspecialchars($date, ENT_QUOTES, 'UTF-8') ?></small></td>
                        <td>
                            <span class="status-badge <?= $badge_class ?>">
                                <?= htmlspecialchars($status, ENT_QUOTES, 'UTF-8') ?>
                            </span>
                        </td>
                        <td>
                            <?php if ($status === 'Pending' || $status === 'Rejected'): ?>
                                <form method="post" action="" class="d-flex flex-column gap-1 align-items-center">
                                    <input type="hidden" name="jobid" value="<?= $jobid ?>">
                                    <button type="submit" name="accept" class="btn btn-success btn-sm w-100"><i class="fas fa-check me-1"></i> Accept</button>
                                    <button type="submit" name="reject" class="btn btn-danger btn-sm w-100"><i class="fas fa-times me-1"></i> Reject</button>
                                </form>
                            <?php else: ?>
                                <span class="status-badge badge-accepted"><i class="fas fa-check-circle me-1"></i> Accepted</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span class="status-badge <?= $wbadge ?>">
                                <?= htmlspecialchars($work_status, ENT_QUOTES, 'UTF-8') ?>
                            </span>
                        </td>
                        <td>
                            <?php if ($status === 'Accepted' && $work_status === 'Pending'): ?>
                                <form method="post" action="" class="d-inline">
                                    <input type="hidden" name="jobid" value="<?= $jobid ?>">
                                    <button type="submit" name="complete" class="btn btn-primary btn-sm"><i class="fas fa-check-double me-1"></i> Finish</button>
                                </form>
                            <?php else: echo "-"; endif; ?>
                        </td>
                        <td>
                            <?php if ($work_status === 'Completed' && $bill_amount === 0): ?>
                                <form method="post" action="" class="d-flex flex-column gap-1">
                                    <input type="hidden" name="jobid" value="<?= $jobid ?>">
                                    <input type="number" name="worked_hours" class="form-control form-control-sm mb-1" placeholder="Hours" min="0.5" step="0.5" required style="max-width: 80px;">
                                    <input type="text" name="fixed_issue" class="form-control form-control-sm mb-1" placeholder="Describe issue" required style="max-width: 140px;" value="<?= htmlspecialchars($fixed_issue, ENT_QUOTES, 'UTF-8') ?>">
                                    <input type="text" name="upi_id" class="form-control form-control-sm mb-1" placeholder="UPI ID" required style="max-width: 140px;" value="<?= htmlspecialchars($upi_id ?? '', ENT_QUOTES, 'UTF-8') ?>">
                                    <button type="submit" name="generate_bill" class="btn btn-success btn-sm w-100"><i class="fas fa-file-invoice-dollar me-1"></i> Generate</button>
                                </form>
                            <?php else: echo "-"; endif; ?>
                        </td>
                        <td><?= $bill_amount > 0 ? "<strong>₹$bill_amount</strong>" : "-" ?></td>
                        <td>
                            <?php if ($bill_amount > 0): ?>
                                <span class="status-badge badge-paid">₹<?= $mechanic_earnings ?></span>
                            <?php else: echo "-"; endif; ?>
                        </td>
                        <td>
                            <?= $payment_status === 'Paid'
                                ? '<span class="status-badge badge-paid"><i class="fas fa-check-circle me-1"></i> Paid</span>'
                                : '<span class="status-badge badge-rejected"><i class="fas fa-times-circle me-1"></i> Unpaid</span>' ?>
                        </td>
                        <td>
                            <?php if ($bill_amount > 0): ?>
                                <form method="post" action="print_bill.php" target="_blank" class="d-inline">
                                    <input type="hidden" name="jobid" value="<?= $jobid ?>">
                                    <button type="submit" class="btn btn-info btn-sm text-white"><i class="fas fa-print me-1"></i> Invoice</button>
                                </form>
                            <?php else: echo "-"; endif; ?>
                        </td>
                    </tr>
                    <?php
                        endwhile;
                    else:
                    ?>
                    <tr>
                        <td colspan="14" class="text-center py-4 text-secondary"><i class="fas fa-folder-open fa-2x mb-2 d-block text-muted"></i>No work requests found.</td>
                    </tr>
                    <?php
                    endif;
                    $stmt->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>