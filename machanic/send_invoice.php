<?php
session_start();
include('../database.php');

// Check if job ID is passed
if (!isset($_POST['jobid'])) {
    die("Invalid request.");
}

$jobid = $_POST['jobid'];

// Fetch job details
$query = "SELECT jobs.*, user.user_Fullname, user.user_address, user.user_city, user.user_contact, 
                 professional.mechanic_Fullname, professional.mechanic_contact, professional.rate_per_hour 
          FROM jobs
          INNER JOIN user ON jobs.user_id = user.user_id
          INNER JOIN professional ON jobs.job_machanic = professional.mechanic_id
          WHERE jobs.job_id = '$jobid'";

$result = mysqli_query($connection, $query);
if (!$result || mysqli_num_rows($result) == 0) {
    die("Job details not found.");
}

$job = mysqli_fetch_assoc($result);

// Store invoice details in session to access on 'My Requests' page
$_SESSION['invoice'] = [
    'jobid' => $jobid,
    'user_Fullname' => $job['user_Fullname'],
    'user_address' => $job['user_address'],
    'user_city' => $job['user_city'],
    'user_contact' => $job['user_contact'],
    'mechanic_Fullname' => $job['mechanic_Fullname'],
    'mechanic_contact' => $job['mechanic_contact'],
    'rate_per_hour' => $job['rate_per_hour'],
    'bill_amount' => $job['bill_amount'],
    'work_status' => $job['work_status'],
    'job_date' => $job['job_date']
];

// Redirect user to "My Requests" page
header('Location: myrequests.php');
exit();
?>
