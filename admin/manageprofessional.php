<?php
include('adminheader.php');
?>
<div class="container my-5" data-aos="fade-up">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark mb-0" style="font-family:'Outfit',sans-serif;"><i class="fas fa-user-gear text-primary me-2"></i>Mechanic Directory</h2>
        <a href="../workerregistration.php" class="btn btn-custom px-4 py-2.5 fw-bold"><i class="fas fa-plus me-1"></i> Add New Mechanic</a>
    </div>
    
    <div class="card p-4">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Full Name</th>
                        <th>Aadhar / ID</th>
                        <th>Address</th>
                        <th>City</th>
                        <th>Contact</th>
                        <th>Email</th>
                        <th>Specialty</th>
                        <th>Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require '../database.php';
                    $query = "SELECT * FROM professional";
                    $results = mysqli_query($connection, $query);
                    if ($results) {
                        if (mysqli_num_rows($results) > 0) {
                            while ($row = mysqli_fetch_object($results)) {
                                $status = htmlspecialchars($row->status);
                                $status_class = 'badge-pending';
                                if ($status === 'Approved' || $status === 'Accepted' || $status === 'Active') {
                                    $status_class = 'badge-accepted';
                                } elseif ($status === 'Blocked' || $status === 'Suspended' || $status === 'Rejected') {
                                    $status_class = 'badge-rejected';
                                }
                                ?>
                                <tr>
                                    <td><?php echo $row->mechanic_id; ?></td>
                                    <td><strong><?php echo htmlspecialchars($row->mechanic_Fullname); ?></strong></td>
                                    <td><small class="text-secondary"><?php echo htmlspecialchars($row->mechanic_cnic); ?></small></td>
                                    <td><small class="text-secondary"><?php echo htmlspecialchars($row->mechanic_address); ?></small></td>
                                    <td><?php echo htmlspecialchars($row->mechanic_city); ?></td>
                                    <td><a href="tel:<?php echo $row->mechanic_contact; ?>" class="text-secondary"><?php echo htmlspecialchars($row->mechanic_contact); ?></a></td>
                                    <td><small><a href="mailto:<?php echo $row->mechanic_email; ?>" class="text-secondary"><?php echo htmlspecialchars($row->mechanic_email); ?></a></small></td>
                                    <td>
                                        <span class="status-badge badge-accepted">
                                            <?php echo !empty($row->mechanic_type) ? htmlspecialchars($row->mechanic_type) : 'General'; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="status-badge <?php echo $status_class; ?>">
                                            <?php echo $status; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <form action='updatemechinics.php' method='POST' class="d-flex justify-content-center gap-1.5">
                                            <input type='hidden' name='mech_id' value='<?php echo $row->mechanic_id; ?>'/>
                                            <button type='submit' name='update' class='btn btn-warning btn-sm fw-bold'><i class="fas fa-edit me-1"></i> Edit</button>
                                            <button type='submit' name='delete' class='btn btn-danger btn-sm fw-bold' onClick='return confirm("Are you sure you want to delete this mechanic record?")'><i class="fas fa-trash-alt me-1"></i> Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo "<tr><td colspan='10' class='text-center py-4 text-secondary'><i class='fas fa-user-slash fa-2x mb-2 d-block text-muted'></i>No mechanics found.</td></tr>";
                        }
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