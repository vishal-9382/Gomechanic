<?php
require '../database.php';
$msg = null;
$msg_type = 'success';

if (isset($_POST['add_area'])) {
    $city = mysqli_real_escape_string($connection, $_POST['city']);
    $area_name = mysqli_real_escape_string($connection, trim($_POST['area']));
    $query = "SELECT * FROM city_area WHERE area_name='$area_name' AND area_city='$city'";
    $results = mysqli_query($connection, $query);
    if ($results) {
        if (mysqli_num_rows($results) > 0) {
            $msg = "Area name already exists!";
            $msg_type = "warning";
        } else {
            $query = "INSERT INTO city_area VALUES ('', '$area_name', '$city')";
            $results = mysqli_query($connection, $query);
            if ($results) {
                $msg = "Area added successfully!";
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
            <h2 class="fw-bold mb-4 text-center" style="font-family:'Outfit',sans-serif;"><i class="fas fa-map-marked-alt text-primary me-2"></i>Add New Area in City</h2>
            <form method="post" action="">
                <div class="mb-3">
                    <label for="city" class="form-label fw-bold text-secondary">Select City</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0" style="border-color: var(--border-color); border-radius: 10px 0 0 10px;"><i class="fas fa-city text-secondary"></i></span>
                        <select name="city" id="city" class="form-control border-start-0" required style="border-radius: 0 10px 10px 0 !important;">
                            <option selected disabled value="">Select City</option>
                            <?php
                            $query = "SELECT * FROM cities";
                            $results = mysqli_query($connection, $query);
                            if ($results) {
                                if (mysqli_num_rows($results) > 0) {
                                    while ($row = mysqli_fetch_object($results)) {
                                        $cityid = $row->city_id;
                                        $cityName = $row->city_name;
                                        echo "<option value='$cityid'>$cityName</option>";
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="area" class="form-label fw-bold text-secondary">Area Name</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0" style="border-color: var(--border-color); border-radius: 10px 0 0 10px;"><i class="fas fa-map-pin text-secondary"></i></span>
                        <input type="text" name="area" id="area" class="form-control border-start-0" placeholder="Enter Area Name" required style="border-radius: 0 10px 10px 0 !important;">
                    </div>
                </div>

                <button type="submit" name="add_area" class="btn btn-custom w-100 py-3 fw-bold">
                    <i class="fas fa-plus me-1"></i> Add Area
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
