<?php
include('adminheader.php');
require '../database.php';
session_start();

// Handle status updates
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_status'])) {
    $jobid = $_POST['jobid'];
    $new_job_status = $_POST['job_status'];
    $new_work_status = $_POST['work_status'];
    $new_payment_status = $_POST['payment_status']; // Get the payment status

    // Update the job status, work status, and payment status in the database
    $query = "UPDATE jobs SET job_status = '$new_job_status', work_status = '$new_work_status', payment_status = '$new_payment_status' WHERE job_id = '$jobid'";
    $result = mysqli_query($connection, $query);

    if ($result) {
        echo "<script>alert('Status updated successfully!'); window.location.href = 'adminviewrequests.php';</script>";
    } else {
        echo "<script>alert('Error updating status: " . mysqli_error($connection) . "');</script>";
    }
}

// Handle deletion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_job'])) {
    $jobid = $_POST['jobid'];
    $query = "DELETE FROM jobs WHERE job_id = '$jobid'";
    $result = mysqli_query($connection, $query);

    if ($result) {
        echo "<script>alert('Job request deleted successfully!'); window.location.href = 'adminviewrequests.php';</script>";
    } else {
        echo "<script>alert('Error deleting job request: " . mysqli_error($connection) . "');</script>";
    }
}
?>

<?php
// Handle status updates
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_status'])) {
    $jobid = $_POST['jobid'];
    $new_job_status = $_POST['job_status'];
    $new_work_status = $_POST['work_status'];
    $new_payment_status = $_POST['payment_status']; // Get the payment status

    // Update the job status, work status, and payment status in the database
    $query = "UPDATE jobs SET job_status = '$new_job_status', work_status = '$new_work_status', payment_status = '$new_payment_status' WHERE job_id = '$jobid'";
    $result = mysqli_query($connection, $query);

    if ($result) {
        $msg = "Status updated successfully!";
    } else {
        $msg = "Error updating status: " . mysqli_error($connection);
    }
}

// Handle deletion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_job'])) {
    $jobid = $_POST['jobid'];
    $query = "DELETE FROM jobs WHERE job_id = '$jobid'";
    $result = mysqli_query($connection, $query);

    if ($result) {
        $msg = "Job request deleted successfully!";
    } else {
        $msg = "Error deleting job request: " . mysqli_error($connection);
    }
}
?>

<div class="container my-5" data-aos="fade-up">
    <div class="card p-4">
        <h2 class="fw-bold mb-4" style="font-family:'Outfit',sans-serif;"><i class="fas fa-tasks text-primary me-2"></i>View & Manage All Requests</h2>
        
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>User Name</th>
                        <th>Mechanic Name</th>
                        <th>Mechanic Address</th>
                        <th>Request Date</th>
                        <th>Request Status</th>
                        <th>Work Status</th>
                        <th>Fixed Issue</th>
                        <th>Bill Amount</th>
                        <th>Payment Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch job requests along with mechanics & users and bill amount
                    $query = "SELECT jobs.job_id, jobs.job_status, jobs.work_status, jobs.job_date, jobs.bill_amount, jobs.fixed_issue, jobs.payment_status,
                                     user.user_Fullname, 
                                     professional.mechanic_Fullname, professional.mechanic_address, professional.mechanic_id,
                                     cities.city_name, city_area.area_name
                              FROM jobs 
                              INNER JOIN user ON user.user_id = jobs.user_id 
                              INNER JOIN professional ON professional.mechanic_id = jobs.job_machanic
                              INNER JOIN city_area ON city_area.area_id = professional.machanic_city_area
                              INNER JOIN cities ON cities.city_id = professional.mechanic_city
                              ORDER BY jobs.job_date DESC";
                    
                    $results = mysqli_query($connection, $query);
                    $sno = 1;

                    if ($results && mysqli_num_rows($results) > 0) {
                        while ($row = mysqli_fetch_assoc($results)) {
                            $jobid = $row['job_id'];
                            $user_Name = htmlspecialchars($row['user_Fullname']);
                            $mach_Name = htmlspecialchars($row['mechanic_Fullname']);
                            $address = htmlspecialchars($row['mechanic_address']);
                            $city = htmlspecialchars($row['city_name']);
                            $area = htmlspecialchars($row['area_name']);
                            $date = date('d M Y, h:i A', strtotime($row['job_date']));
                            $status = htmlspecialchars($row['job_status']);
                            $work_status = htmlspecialchars($row['work_status']);
                            $fixed_issue = htmlspecialchars($row['fixed_issue']);
                            $bill_amount = $row['bill_amount'];
                            $payment_status = htmlspecialchars($row['payment_status']);
                            $professionalid = $row['mechanic_id'];
                            ?>

                            <tr>
                                <td><?php echo $sno++; ?></td>
                                <td><strong><?php echo $user_Name; ?></strong></td>
                                <td><strong><?php echo $mach_Name; ?></strong></td>
                                <td><small class="text-secondary"><?php echo $address . ', ' . $area . ', ' . $city; ?></small></td>
                                <td><small><?php echo $date; ?></small></td>
                                <form method="post" action="">
                                    <input type="hidden" name="jobid" value="<?php echo $jobid; ?>">
                                    <td>
                                        <select name="job_status" class="form-select form-select-sm" style="min-width: 100px;">
                                            <option value="Pending" <?php if ($status == 'Pending') echo 'selected'; ?>>Pending</option>
                                            <option value="Accepted" <?php if ($status == 'Accepted') echo 'selected'; ?>>Accepted</option>
                                            <option value="Rejected" <?php if ($status == 'Rejected') echo 'selected'; ?>>Rejected</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="work_status" class="form-select form-select-sm" style="min-width: 110px;">
                                            <option value="Pending" <?php if ($work_status == 'Pending') echo 'selected'; ?>>Pending</option>
                                            <option value="In Progress" <?php if ($work_status == 'In Progress') echo 'selected'; ?>>In Progress</option>
                                            <option value="Completed" <?php if ($work_status == 'Completed') echo 'selected'; ?>>Completed</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" name="fixed_issue" value="<?php echo $fixed_issue; ?>" class="form-control form-control-sm" readonly style="min-width: 120px;">
                                    </td>
                                    <td><strong class="text-primary">₹<?php echo number_format($bill_amount, 2); ?></strong></td>
                                    <td>
                                        <select name="payment_status" class="form-select form-select-sm" style="min-width: 100px;">
                                            <option value="Paid" <?php if ($payment_status == 'Paid') echo 'selected'; ?>>Paid</option>
                                            <option value="Unpaid" <?php if ($payment_status == 'Unpaid' || strtolower($payment_status) == 'unpaid') echo 'selected'; ?>>Unpaid</option>
                                        </select>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-1">
                                            <button type="submit" name="update_status" class="btn btn-success btn-sm"><i class="fas fa-save me-1"></i> Update</button>
                                </form>
                                            <form method="post" action="" onsubmit="return confirm('Are you sure you want to delete this job request?');">
                                                <input type="hidden" name="jobid" value="<?php echo $jobid; ?>">
                                                <button type="submit" name="delete_job" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt me-1"></i> Delete</button>
                                            </form>
                                        </div>
                                    </td>
                            </tr>

                            <?php 
                        }
                    } else {
                        echo "<tr><td colspan='11' class='text-center py-4 text-secondary'><i class='fas fa-folder-open fa-2x mb-2 d-block text-muted'></i>No job requests found.</td></tr>";
                    } 
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php if (isset($msg)): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: '<?php echo (strpos($msg, "successfully") !== false) ? "success" : "error"; ?>',
                title: 'Operation Status',
                text: '<?php echo addslashes($msg); ?>',
                confirmButtonColor: '#2563EB'
            });
        });
    </script>
<?php endif; ?>

<?php include('footer.php'); ?>

