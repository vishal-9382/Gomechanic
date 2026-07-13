<?php
session_start();
include('adminheader.php');
require '../database.php';
?>

<div class="container my-5" data-aos="fade-up">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark mb-0" style="font-family:'Outfit',sans-serif;"><i class="fas fa-comments text-primary me-2"></i>User Testimonials</h2>
        <a href="adminhome.php" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i> Dashboard</a>
    </div>

    <div class="card p-4">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th style="width: 80px;">S.No</th>
                        <th>User Name</th>
                        <th>Mechanic Name</th>
                        <th>Rating</th>
                        <th style="width: 40%; min-width: 250px;">Feedback</th>
                        <th>Date Submitted</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sno = 1;
                    $query = "SELECT *, DATE(feedback_date) as fbackdate FROM feedback 
                              INNER JOIN user ON user.user_id = feedback_user 
                              INNER JOIN professional ON mechanic_id = feedback_proffessional
                              ORDER BY feedback_date DESC";
                    $result = mysqli_query($connection, $query);

                    if ($result) {
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_object($result)) {
                                $rating = (int) $row->rating;
                                $starsHtml = '';
                                for ($i = 1; $i <= 5; $i++) {
                                    if ($i <= $rating) {
                                        $starsHtml .= '<i class="fas fa-star text-warning small me-0.5"></i>';
                                    } else {
                                        $starsHtml .= '<i class="far fa-star text-muted small me-0.5"></i>';
                                    }
                                }
                                $date = date('d M Y', strtotime($row->fbackdate));
                                ?>
                                <tr>
                                    <td><?php echo $sno++; ?></td>
                                    <td><strong><?php echo htmlspecialchars($row->user_Fullname); ?></strong></td>
                                    <td><strong><?php echo htmlspecialchars($row->mechanic_Fullname); ?></strong></td>
                                    <td>
                                        <div class="d-flex align-items-center gap-1.5">
                                            <span><?php echo $starsHtml; ?></span>
                                            <span class="small fw-semibold text-secondary ms-1">(<?php echo $rating; ?>)</span>
                                        </div>
                                    </td>
                                    <td><small class="text-secondary d-block" style="word-break: break-word; white-space: normal;"><?php echo htmlspecialchars($row->feedback_comments); ?></small></td>
                                    <td><small class="text-secondary"><?php echo $date; ?></small></td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo "<tr><td colspan='6' class='text-center py-4 text-secondary'><i class='fas fa-comment-slash fa-2x mb-2 d-block text-muted'></i>No feedback reports found.</td></tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6' class='text-center text-danger'>" . mysqli_error($connection) . "</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
