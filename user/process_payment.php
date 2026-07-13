<?php
session_start();

// Include your database connection
include('../database.php');

if (!isset($_POST['jobid'])) {
    die("Invalid request.");
}

$jobid = $_POST['jobid'];  // Getting the job ID from the form

// Process the payment here (update the database, etc.)
$query = "UPDATE jobs SET payment_status = 'paid', job_status = 'Paid' WHERE job_id = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param("i", $jobid);
$stmt->execute();

// If payment is successful, set session variable
$_SESSION['payment_success'] = "Payment Successful!";

// Redirect to the print_bill.php page
header('Location: print_bill.php?job_id=' . $jobid);
exit;
?>
