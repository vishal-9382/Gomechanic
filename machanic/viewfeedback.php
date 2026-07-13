<?php
include('machanicheader.php');
?>

<!-- Apply background color to the whole page -->
<div class="container mt-4" style="background-color: #f0f8ff; padding: 20px;">
    <div class="card">
        <div class="card-header bg-dark text-white text-center">
            <h3>Users Feedback</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered text-center">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>User Name</th>
                            <th>Rating</th>
                            <th>Feedback</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require '../database.php';
                        $msg = null;
                        session_start();

                        $sno = 1;
                        $profid = $_SESSION["proff_id"];
                        $query = "SELECT *, date(feedback_date) as fbackdate FROM feedback INNER JOIN user ON user.user_id = feedback_user WHERE feedback.feedback_proffessional = '$profid'";
                        $result = mysqli_query($connection, $query);

                        if ($result) {
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_object($result)) {
                                    $proff_id = $row->feedback_id;
                                    $u_name = $row->user_Fullname;
                                    $rating = $row->rating;
                                    $comments = $row->feedback_comments;
                                    $commentsdate = $row->fbackdate;
                                    ?>
                                    <tr>
                                        <td><?php echo $sno++; ?></td>
                                        <td><?php echo htmlspecialchars($u_name); ?></td>
                                        <td>
                                            <?php 
                                            // Display stars based on rating
                                            echo str_repeat('⭐', $rating) . " ({$rating} Stars)";
                                            ?>
                                        </td>
                                        <td><?php echo htmlspecialchars($comments); ?></td>
                                        <td><?php echo htmlspecialchars($commentsdate); ?></td>
                                    </tr>
                                <?php }
                            } else {
                                echo "<tr><td colspan='5' class='text-center text-danger'>No feedback available.</td></tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5' class='text-center text-danger'>Error fetching feedback: " . mysqli_error($connection) . "</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

