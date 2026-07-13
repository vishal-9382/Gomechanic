<?php
include('adminheader.php');
?>

<div class="container my-5" data-aos="fade-up">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark mb-0" style="font-family:'Outfit',sans-serif;"><i class="fas fa-users text-primary me-2"></i>User Management</h2>
        <a href="adminhome.php" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i> Dashboard</a>
    </div>

    <div class="card p-4">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Aadhar Card / ID</th>
                        <th>Address</th>
                        <th>City</th>
                        <th>Contact</th>
                        <th>Email</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require '../database.php';
                    $query = "SELECT * FROM user";
                    $results = mysqli_query($connection, $query);

                    if ($results && mysqli_num_rows($results) > 0) {
                        while ($row = mysqli_fetch_object($results)) {
                            ?>
                            <tr>
                                <td><?php echo $row->user_id; ?></td>
                                <td><strong><?php echo htmlspecialchars($row->user_Fullname); ?></strong></td>
                                <td><small class="text-secondary"><?php echo htmlspecialchars($row->user_cnic); ?></small></td>
                                <td><small class="text-secondary"><?php echo htmlspecialchars($row->user_address); ?></small></td>
                                <td><?php echo htmlspecialchars($row->user_city); ?></td>
                                <td><a href="tel:<?php echo $row->user_contact; ?>" class="text-secondary"><?php echo htmlspecialchars($row->user_contact); ?></a></td>
                                <td><small><a href="mailto:<?php echo $row->user_email; ?>" class="text-secondary"><?php echo htmlspecialchars($row->user_email); ?></a></small></td>
                                <td>
                                    <div class="d-flex justify-content-center gap-1.5">
                                        <form action="updateuser.php" method="POST" class="d-inline">
                                            <input type="hidden" name="userid" value="<?php echo $row->user_id; ?>"/>
                                            <button type="submit" name="update" class="btn btn-warning btn-sm fw-bold"><i class="fas fa-edit me-1"></i> Edit</button>
                                        </form>
                                        <form action="deleteuser.php" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this user account?');">
                                            <input type="hidden" name="userid" value="<?php echo $row->user_id; ?>"/>
                                            <button type="submit" name="delete" class="btn btn-danger btn-sm fw-bold"><i class="fas fa-trash-alt me-1"></i> Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <?php
                        }
                    } else {
                        echo "<tr><td colspan='8' class='text-center py-4 text-secondary'><i class='fas fa-user-slash fa-2x mb-2 d-block text-muted'></i>No users found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
include('footer.php');
?>
