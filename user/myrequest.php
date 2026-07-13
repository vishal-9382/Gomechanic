<?php
include('userheader.php');
require '../database.php';
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

// Function to handle payment (simulated in this case)
function processPayment($job_id, $bill_amount) {
    global $connection;
    $query = "UPDATE jobs SET job_status = 'Paid', work_status = 'Completed' WHERE job_id = '$job_id'";
    mysqli_query($connection, $query);
    return "Payment of ₹$bill_amount for Job ID $job_id was successful!";
}

$payment_message = '';
if (isset($_POST['pay_job'])) {
    $job_id = $_POST['job_id'];
    $bill_amount = $_POST['bill_amount'];
    $payment_message = processPayment($job_id, $bill_amount);
}
?>

<div class="container my-5" data-aos="fade-up">
    <div class="card p-4">
        <h2 class="fw-bold mb-4" style="font-family:'Outfit',sans-serif;"><i class="fas fa-history text-primary me-2"></i>View Request History</h2>
        
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Mechanic Name</th>
                        <th>Address</th>
                        <th>Request Date</th>
                        <th>Request Status</th>
                        <th>Work Status</th>
                        <th>Bill Amount</th>
                        <th>Feedback</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT jobs.job_id, jobs.job_status, jobs.work_status, jobs.job_date, jobs.bill_amount,
                                     professional.mechanic_Fullname, professional.mechanic_address, professional.mechanic_id,
                                     cities.city_name, city_area.area_name
                              FROM jobs
                              INNER JOIN professional ON professional.mechanic_id = jobs.job_machanic
                              INNER JOIN city_area ON city_area.area_id = professional.machanic_city_area
                              INNER JOIN cities ON cities.city_id = professional.mechanic_city
                              WHERE jobs.user_id = '$user_id'
                              ORDER BY jobs.job_date DESC";

                    $results = mysqli_query($connection, $query);
                    $sno = 1;

                    if ($results && mysqli_num_rows($results) > 0) {
                        while ($row = mysqli_fetch_assoc($results)) {
                            $jobid = $row['job_id'];
                            $mach_Name = htmlspecialchars($row['mechanic_Fullname']);
                            $address = htmlspecialchars($row['mechanic_address']);
                            $city = htmlspecialchars($row['city_name']);
                            $area = htmlspecialchars($row['area_name']);
                            $date = date('d M Y, h:i A', strtotime($row['job_date']));
                            $status = htmlspecialchars($row['job_status']);
                            $work_status = htmlspecialchars($row['work_status']);
                            $bill_amount = $row['bill_amount'];
                            $professionalid = $row['mechanic_id'];

                            // Status badge helper
                            $status_class = 'badge-pending';
                            if ($status === 'Accepted') { $status_class = 'badge-accepted'; }
                            elseif ($status === 'Paid') { $status_class = 'badge-paid'; }
                            elseif ($status === 'Rejected') { $status_class = 'badge-rejected'; }

                            // Work status badge helper
                            $work_class = 'badge-pending';
                            if ($work_status === 'Completed') { $work_class = 'badge-completed'; }
                            elseif ($work_status === 'In Progress') { $work_class = 'badge-accepted'; }
                            ?>
                            <tr>
                                <td><?php echo $sno++; ?></td>
                                <td><strong><?php echo $mach_Name; ?></strong></td>
                                <td><small class="text-secondary"><?php echo "$address, $area, $city"; ?></small></td>
                                <td><small><?php echo $date; ?></small></td>
                                <td><span class="status-badge <?php echo $status_class; ?>"><?php echo $status; ?></span></td>
                                <td><span class="status-badge <?php echo $work_class; ?>"><?php echo $work_status; ?></span></td>
                                <td><strong class="text-primary">₹<?php echo number_format($bill_amount, 2); ?></strong></td>
                                <td>
                                    <a href="placefeedback.php?professional=<?php echo $professionalid; ?>&job_id=<?php echo $jobid; ?>" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                                        <i class="far fa-star me-1"></i> Rate
                                    </a>
                                </td>
                                <td class="text-center">
                                    <?php if ($status !== 'Paid'): ?>
                                        <form method="GET" action="print_bill.php" class="d-inline">
                                            <input type="hidden" name="job_id" value="<?php echo $jobid; ?>">
                                            <button type="submit" class="btn btn-warning btn-sm fw-bold"><i class="fas fa-credit-card me-1"></i> Pay Now</button>
                                        </form>
                                    <?php else: ?>
                                        <span class="status-badge badge-paid"><i class="fas fa-check-circle me-1"></i> Paid</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php 
                        }
                    } else {
                        echo "<tr><td colspan='9' class='text-center py-4 text-secondary'><i class='fas fa-receipt fa-2x mb-2 d-block text-muted'></i>No bookings found.</td></tr>";
                    } 
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php if ($payment_message): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Payment Status',
                text: '<?php echo addslashes($payment_message); ?>',
                confirmButtonColor: '#2563EB'
            });
        });
    </script>
<?php endif; ?>

<?php include('footer.php'); ?>

