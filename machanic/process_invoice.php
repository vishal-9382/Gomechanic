<?php
require '../database.php';
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION["user_id"]; // Get logged-in user ID

    // Check if hours worked data is set
    if (!isset($_POST['hours_worked']) || !is_array($_POST['hours_worked'])) {
        die("Invalid request.");
    }

    $invoiceData = $_POST['hours_worked']; // Array of hours worked for each job
    $totalInvoiceAmount = 0;

    foreach ($invoiceData as $job_id => $hours) {
        $hours = intval($hours); // Convert to integer

        if ($hours <= 0) {
            continue; // Skip invalid hours
        }

        // Fetch the mechanic's hourly rate
        $query = "SELECT professional.rate_per_hour 
                  FROM jobs 
                  INNER JOIN professional ON professional.mechanic_id = jobs.job_machanic 
                  WHERE jobs.job_id = ?";
        
        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, "i", $job_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $rate_per_hour);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        if (!$rate_per_hour) {
            continue; // Skip if no rate found
        }

        // Calculate total cost
        $total_cost = $rate_per_hour * $hours;
        $totalInvoiceAmount += $total_cost;

        // Update the bill_amount in jobs table
        $update_query = "UPDATE jobs SET bill_amount = ? WHERE job_id = ?";
        $update_stmt = mysqli_prepare($connection, $update_query);
        mysqli_stmt_bind_param($update_stmt, "di", $total_cost, $job_id);
        mysqli_stmt_execute($update_stmt);
        mysqli_stmt_close($update_stmt);
    }

    // Output the total invoice amount
    echo "<script>alert('Total Invoice Amount Updated: $$totalInvoiceAmount'); window.location.href='invoice.php';</script>";

} else {
    die("Unauthorized access.");
}
?>
