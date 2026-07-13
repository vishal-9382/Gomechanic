<?php
require '../database.php';
$msg = null;
$msg_type = 'success';

if (isset($_POST['add_city'])) {
    $city_name = mysqli_real_escape_string($connection, trim($_POST['cityname']));
    $query = "SELECT * FROM cities WHERE city_name='$city_name'";
    $results = mysqli_query($connection, $query);
    
    if ($results) {
        if (mysqli_num_rows($results) > 0) {
            $msg = "City name already exists!";
            $msg_type = "warning";
        } else {
            $query = "INSERT INTO cities VALUES ('','$city_name')";
            $results = mysqli_query($connection, $query);
            if ($results) {
                $msg = "City added successfully!";
                $msg_type = "success";
            } else {
                $msg = "Database error: " . mysqli_error($connection);
                $msg_type = "error";
            }
        }
    }
}

require('adminheader.php');
?>

<div class="container my-5" data-aos="fade-up" style="max-width: 600px;">
    <div class="card p-4">
        <div class="card-body">
            <h2 class="fw-bold mb-4 text-center" style="font-family:'Outfit',sans-serif;"><i class="fas fa-city text-primary me-2"></i>Add New City</h2>
            <form method="post" action="">
                <div class="mb-4">
                    <label for="cityname" class="form-label fw-bold text-secondary">City Name</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0" style="border-color: var(--border-color); border-radius: 10px 0 0 10px;"><i class="fas fa-building text-secondary"></i></span>
                        <input type="text" id="cityname" name="cityname" class="form-control border-start-0" placeholder="Enter City Name (e.g., Delhi, Mumbai)" required style="border-radius: 0 10px 10px 0 !important;">
                    </div>
                </div>
                <button type="submit" name="add_city" class="btn btn-custom w-100 py-3 fw-bold">
                    <i class="fas fa-plus me-1"></i> Add City
                </button>
            </form>
            <div class="text-center mt-4">
                <a href="adminhome.php" class="text-secondary small"><i class="fas fa-arrow-left me-1"></i> Back to Dashboard</a>
            </div>
        </div>
    </div>
</div>

<?php if (isset($msg)): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: '<?php echo $msg_type; ?>',
                title: '<?php echo ucfirst($msg_type); ?>',
                text: '<?php echo addslashes($msg); ?>',
                confirmButtonColor: '#2563EB'
            });
        });
    </script>
<?php endif; ?>

<?php include('footer.php'); ?>
