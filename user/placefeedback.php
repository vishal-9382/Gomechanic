<?php
include('../database.php');
$msg = null;
$msg_type = 'success';
session_start();

if (isset($_POST['submitfeedback'])) {
    $userid = $_SESSION["user_id"];
    $jobid = mysqli_real_escape_string($connection, $_POST['jobid']);
    $professionalid = mysqli_real_escape_string($connection, $_POST['professionalid']);
    $rating = mysqli_real_escape_string($connection, $_POST['rating']);
    $comments = mysqli_real_escape_string($connection, trim($_POST['feedbackcomment']));
    $currentdatetime = date('Y-m-d H:i:s');
    
    $query = "INSERT INTO feedback VALUES ('','$jobid','$professionalid','$userid','$rating','$comments','$currentdatetime')";
    $results = mysqli_query($connection, $query);
    if ($results) {
        $msg = "Your feedback has been submitted successfully!";
        $msg_type = "success";
    } else {
        $msg = mysqli_error($connection);
        $msg_type = "error";
    }
}

$machid = isset($_GET['professional']) ? mysqli_real_escape_string($connection, $_GET['professional']) : '';
$jobid = isset($_GET['job_id']) ? mysqli_real_escape_string($connection, $_GET['job_id']) : (isset($_GET['job']) ? mysqli_real_escape_string($connection, $_GET['job']) : '');
$professionalName = '';

if ($machid) {
    $query = "SELECT * FROM professional WHERE mechanic_id='$machid'";
    $results = mysqli_query($connection, $query);
    if ($results && mysqli_num_rows($results) > 0) {
        $row = mysqli_fetch_object($results);
        $professionalName = $row->mechanic_Fullname;
    }
}

include('userheader.php');
?>

<div class="container my-5" data-aos="fade-up" style="max-width: 600px;">
    <div class="card p-4">
        <div class="card-body">
            <h2 class="fw-bold mb-4 text-center" style="font-family:'Outfit',sans-serif;"><i class="fas fa-star-half-alt text-primary me-2"></i>Give Mechanic Feedback</h2>
            
            <form method="post" action="">
                <input type="hidden" name="professionalid" value="<?php echo htmlspecialchars($machid); ?>">
                <input type="hidden" name="jobid" value="<?php echo htmlspecialchars($jobid); ?>">

                <div class="mb-3">
                    <label class="form-label fw-bold text-secondary">Mechanic Name</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0" style="border-color: var(--border-color); border-radius: 10px 0 0 10px;"><i class="fas fa-user-cog text-secondary"></i></span>
                        <input type="text" class="form-control border-start-0" value="<?php echo htmlspecialchars($professionalName); ?>" readonly style="border-radius: 0 10px 10px 0 !important; background: #eef2f6;">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="rating" class="form-label fw-bold text-secondary">Service Rating</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0" style="border-color: var(--border-color); border-radius: 10px 0 0 10px;"><i class="fas fa-star text-warning"></i></span>
                        <select name="rating" id="rating" class="form-select border-start-0" required style="border-radius: 0 10px 10px 0 !important;">
                            <option value="5" selected>⭐ ⭐ ⭐ ⭐ ⭐ (5 - Excellent)</option>
                            <option value="4">⭐ ⭐ ⭐ ⭐ (4 - Very Good)</option>
                            <option value="3">⭐ ⭐ ⭐ (3 - Good)</option>
                            <option value="2">⭐ ⭐ (2 - Fair)</option>
                            <option value="1">⭐ (1 - Poor)</option>
                        </select>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="feedbackcomment" class="form-label fw-bold text-secondary">Your Comments</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0 align-items-start pt-2" style="border-color: var(--border-color); border-radius: 10px 0 0 10px;"><i class="fas fa-comment-dots text-secondary"></i></span>
                        <textarea name="feedbackcomment" id="feedbackcomment" class="form-control border-start-0" rows="6" placeholder="Describe your experience with the mechanic..." required style="border-radius: 0 10px 10px 0 !important;"></textarea>
                    </div>
                </div>

                <button type="submit" name="submitfeedback" class="btn btn-custom w-100 py-3 fw-bold">
                    <i class="fas fa-paper-plane me-1"></i> Submit Review
                </button>
            </form>
            
            <div class="text-center mt-4">
                <a href="myrequest.php" class="text-secondary small"><i class="fas fa-arrow-left me-1"></i> Back to History</a>
            </div>
        </div>
    </div>
</div>

<?php if (isset($msg)): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: '<?php echo $msg_type; ?>',
                title: 'Review Status',
                text: '<?php echo addslashes($msg); ?>',
                confirmButtonColor: '#2563EB'
            }).then(() => {
                <?php if ($msg_type === 'success'): ?>
                window.location.href = 'myrequest.php';
                <?php endif; ?>
            });
        });
    </script>
<?php endif; ?>

<?php include('footer.php'); ?>