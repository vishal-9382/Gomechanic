<?php
require '../database.php';
session_start();

if (isset($_POST['job_id'])) {
    $job_id = $_POST['job_id'];
    $query = "DELETE FROM jobs WHERE job_id = '$job_id'";

    if (mysqli_query($connection, $query)) {
        // Redirect to the same page to reflect changes
        header("Location: view_job_history.php"); // Adjust to your actual file name
        exit();
    } else {
        echo "Error deleting record: " . mysqli_error($connection);
    }
}
?>
