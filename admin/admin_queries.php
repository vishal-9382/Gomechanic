<?php
include('adminheader.php');
include('../database.php');
session_start();

// Handle delete query request
if (isset($_POST['delete_query'])) {
    $query_id = $_POST['query_id'];
    $delete_query = "DELETE FROM contact_queries WHERE id = ?";
    $stmt = mysqli_prepare($connection, $delete_query);
    mysqli_stmt_bind_param($stmt, 'i', $query_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("Location: admin_queries.php"); // Refresh the page
    exit();
}

// Fetch all queries
$query = "SELECT * FROM contact_queries ORDER BY created_at DESC";
$results = mysqli_query($connection, $query);
?>

<div class="container my-5" data-aos="fade-up">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark mb-0" style="font-family:'Outfit',sans-serif;"><i class="fas fa-envelope-open-text text-primary me-2"></i>Contact Queries</h2>
        <a href="adminhome.php" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i> Dashboard</a>
    </div>

    <div class="card p-4">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>User Type</th>
                        <th style="width: 40%; min-width: 250px;">Message</th>
                        <th>Date Received</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($results && mysqli_num_rows($results) > 0) {
                        while ($row = mysqli_fetch_assoc($results)) { 
                            $date = date('d M Y, h:i A', strtotime($row['created_at']));
                            $userType = htmlspecialchars($row['user_type']);
                            $type_class = ($userType === 'mechanic') ? 'badge-accepted' : 'badge-pending';
                            ?>
                            <tr>
                                <td><strong><?php echo htmlspecialchars($row['name']); ?></strong></td>
                                <td><a href="mailto:<?php echo htmlspecialchars($row['email']); ?>" class="text-secondary"><?php echo htmlspecialchars($row['email']); ?></a></td>
                                <td>
                                    <span class="status-badge <?php echo $type_class; ?>">
                                        <?php echo ucfirst($userType); ?>
                                    </span>
                                </td>
                                <td><small class="text-secondary d-block" style="word-break: break-word; white-space: normal;"><?php echo htmlspecialchars($row['message']); ?></small></td>
                                <td><small class="text-secondary"><?php echo $date; ?></small></td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <form method="POST" onsubmit="return confirm('Are you sure you want to delete this query?');">
                                            <input type="hidden" name="query_id" value="<?php echo $row['id']; ?>">
                                            <button type="submit" name="delete_query" class="btn btn-danger btn-sm fw-bold"><i class="fas fa-trash-alt me-1"></i> Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php } 
                    } else {
                        echo "<tr><td colspan='6' class='text-center py-4 text-secondary'><i class='fas fa-folder-open fa-2x mb-2 d-block text-muted'></i>No query messages found.</td></tr>";
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
