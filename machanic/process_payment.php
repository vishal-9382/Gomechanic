// process_payment.php
<?php
include('../database.php');

if (!isset($_POST['jobid'])) {
    die("Invalid request.");
}

$jobid = $_POST['jobid'];

// Update payment status to 'Paid' in the database
$query = "UPDATE jobs SET payment_status='Paid' WHERE job_id='$jobid'";
$result = mysqli_query($connection, $query);

if ($result) {
    // Redirect back to viewwork.php with a success message
    header("Location: viewwork.php?msg=Payment Confirmed Successfully");
} else {
    // Redirect back with an error message
    header("Location: viewwork.php?msg=Failed to Update Payment Status");
}
?>
