<?php
include('./database.php');
include('./navbar.php');
$msg = null;
session_start();

if (isset($_POST['sendrequest'])) {
    $msg = "You are not logged in! Please login first to send a request.";
}

if (isset($_POST['viewfeedback'])) {
    $msg = "You are not logged in! Please login first to view feedback.";
}
?>

<div class="container my-5">
    <!-- "Find a Mechanic in Your Area" Section Box -->
    <div class="card p-4 mb-5" data-aos="fade-up">
        <h2 class="fw-bold mb-4" style="font-family:'Outfit',sans-serif;"><i class="fas fa-search-location text-primary me-2"></i>Find a Mechanic in Your Area</h2>

        <form method="post" action="" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label for="distt" class="form-label fw-bold">Select City:</label>
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-end-0" style="border-color: var(--border-color); border-radius: 10px 0 0 10px;"><i class="fas fa-city text-secondary"></i></span>
                    <select id="distt" name="disstrict" class="form-control border-start-0" onchange="loadarea()" required style="border-radius: 0 10px 10px 0 !important;">
                        <option selected disabled value="">Select City</option>
                        <?php
                        $query = "SELECT * FROM cities";
                        $results = mysqli_query($connection, $query);
                        if ($results) {
                            while ($row = mysqli_fetch_object($results)) {
                                echo "<option value='{$row->city_id}'>{$row->city_name}</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="col-md-4">
                <label for="area" class="form-label fw-bold">Select Area:</label>
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-end-0" style="border-color: var(--border-color); border-radius: 10px 0 0 10px;"><i class="fas fa-map-pin text-secondary"></i></span>
                    <select id="area" name="area" class="form-control border-start-0" required style="border-radius: 0 10px 10px 0 !important;">
                        <option selected disabled value="">Select Area</option>
                    </select>
                </div>
            </div>

            <div class="col-md-4">
                <label for="mechtype" class="form-label fw-bold">Specialization:</label>
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-end-0" style="border-color: var(--border-color); border-radius: 10px 0 0 10px;"><i class="fas fa-cogs text-secondary"></i></span>
                    <select id="mechtype" name="mechanic_type" class="form-control border-start-0" style="border-radius: 0 10px 10px 0 !important;">
                        <option value="">All Specializations</option>
                        <option value="Engine">🔧 Engine Repair</option>
                        <option value="Electrical">⚡ Electrical &amp; Battery</option>
                        <option value="Car Washing">🚿 Car Washing &amp; Detailing</option>
                        <option value="Tyre &amp; Wheel">🔩 Tyre &amp; Wheel Alignment</option>
                        <option value="AC Repair">❄️ AC Repair &amp; Gas Fill</option>
                    </select>
                </div>
            </div>

            <div class="col-12 mt-4">
                <button type="submit" value="Search" name="searchmechanic" class="btn btn-custom w-100 py-3 fw-bold">
                    <i class="fas fa-search me-2"></i> Search Available Mechanics
                </button>
            </div>
        </form>
    </div>

    <!-- "All Mechanics in Your Selected Area" Section Box -->
    <?php
    if (isset($_POST['searchmechanic']) && isset($_POST['area'])) {
        $selectedarea = $_POST['area'];
        $selectedtype = isset($_POST['mechanic_type']) ? mysqli_real_escape_string($connection, $_POST['mechanic_type']) : '';
        
        $type_icons = [
            'Engine'       => '🔧',
            'Electrical'   => '⚡',
            'Car Washing'  => '🚿',
            'Tyre & Wheel' => '🔩',
            'AC Repair'    => '❄️',
        ];

        $type_filter = $selectedtype ? "AND professional.mechanic_type = '$selectedtype'" : '';

        $query = "SELECT *, IFNULL((SELECT (SUM(rating) / COUNT(rating)) FROM feedback WHERE feedback_proffessional=professional.mechanic_id), 0) AS mechRating 
                  FROM professional 
                  INNER JOIN city_area ON city_area.area_id = professional.machanic_city_area 
                  INNER JOIN cities ON cities.city_id = professional.mechanic_city 
                  WHERE machanic_city_area = '$selectedarea' $type_filter";

        $results = mysqli_query($connection, $query);
        ?>
        <div class="card p-4" data-aos="fade-up">
            <h3 class="fw-bold mb-4 text-center"><i class="fas fa-user-friends text-primary me-2"></i>Available Mechanics in Selected Area</h3>
            
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Mechanic Name</th>
                            <th>Type</th>
                            <th>Address</th>
                            <th>Experience</th>
                            <th>Rate/Hour</th>
                            <th>Contact Info</th>
                            <th>Rating</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sno = 1;
                        if ($results && mysqli_num_rows($results) > 0) {
                            while ($row = mysqli_fetch_object($results)) {
                                $typeLabel = $row->mechanic_type ?: 'General';
                                $typeIcon  = $type_icons[$row->mechanic_type] ?? '🔧';
                                $rating = round($row->mechRating, 1);
                                
                                // Star rendering helper
                                $starsHtml = '';
                                $fullStars = floor($rating);
                                $halfStar = ($rating - $fullStars >= 0.5) ? 1 : 0;
                                for ($i = 1; $i <= 5; $i++) {
                                    if ($i <= $fullStars) {
                                        $starsHtml .= '<i class="fas fa-star text-warning small"></i>';
                                    } elseif ($i == $fullStars + 1 && $halfStar) {
                                        $starsHtml .= '<i class="fas fa-star-half-alt text-warning small"></i>';
                                    } else {
                                        $starsHtml .= '<i class="far fa-star text-muted small"></i>';
                                    }
                                }
                                ?>
                                <tr>
                                    <td><?php echo $sno++; ?></td>
                                    <td><strong><?php echo htmlspecialchars($row->mechanic_Fullname); ?></strong></td>
                                    <td>
                                        <span class="status-badge badge-accepted">
                                            <?php echo $typeIcon; ?> <?php echo htmlspecialchars($typeLabel); ?>
                                        </span>
                                    </td>
                                    <td><small class="text-secondary"><?php echo htmlspecialchars($row->mechanic_address); ?></small></td>
                                    <td><span class="badge bg-secondary-subtle text-secondary px-2.5 py-1.5 rounded-pill"><?php echo htmlspecialchars($row->experience); ?> Years</span></td>
                                    <td><strong class="text-primary">₹<?php echo htmlspecialchars($row->rate_per_hour); ?>/hr</strong></td>
                                    <td><a href="tel:<?php echo $row->mechanic_contact; ?>" class="text-secondary"><i class="fas fa-phone-alt me-1 small"></i> <?php echo htmlspecialchars($row->mechanic_contact); ?></a></td>
                                    <td>
                                        <div class="d-flex align-items-center gap-1.5">
                                            <span><?php echo $starsHtml; ?></span>
                                            <span class="small fw-semibold text-secondary ms-1">(<?php echo $rating ?: '0.0'; ?>)</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <form method="POST" class="d-inline">
                                                <input type="hidden" name="machanicid" value="<?php echo $row->mechanic_id; ?>"/>
                                                <button type="submit" name="viewfeedback" class="btn btn-info btn-sm text-white"><i class="fas fa-comments me-1"></i> Feedback</button>
                                            </form>
                                            <form method="POST" class="d-inline">
                                                <input type="hidden" name="machanicid" value="<?php echo $row->mechanic_id; ?>"/>
                                                <button type="submit" name="sendrequest" class="btn btn-success btn-sm"><i class="fas fa-paper-plane me-1"></i> Book</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo "<tr><td colspan='9' class='text-center py-4 text-danger fw-semibold'><i class='fas fa-exclamation-triangle me-2'></i>No mechanics found in the selected area matching your criteria.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php } ?>
</div>

<script>
    function loadarea() {
        var district = $('#distt').val();
        $.ajax({
            type: "POST",
            url: "selectarea_ajax.php",
            data: { 'distt': district },
            success: function(data) {
                $('#area').html('<option selected disabled value="">Select Area</option>' + data);
            }
        });
    }
</script>

<?php if (isset($msg)): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'warning',
                title: 'Authentication Required',
                text: '<?php echo addslashes($msg); ?>',
                showCancelButton: true,
                confirmButtonColor: '#2563EB',
                cancelButtonColor: '#64748B',
                confirmButtonText: 'Login Now',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'login.php';
                }
            });
        });
    </script>
<?php endif; ?>

<?php include('footer.php'); ?>