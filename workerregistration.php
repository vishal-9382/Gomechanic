<?php
include('database.php');

$msg = null;

if (isset($_POST['register'])) {

    // Check required fields
    if (
        !empty($_POST['name']) &&
        !empty($_POST['cnic']) &&
        !empty($_POST['mobile']) &&
        !empty($_POST['city']) &&
        !empty($_POST['mechanic_type']) &&
        !empty($_POST['password']) &&
        !empty($_POST['confirmpassword'])
    ) {

        $name = mysqli_real_escape_string($connection, $_POST['name']);
        $cnic = mysqli_real_escape_string($connection, $_POST['cnic']);
        $address = mysqli_real_escape_string($connection, $_POST['address']);
        $contact = mysqli_real_escape_string($connection, $_POST['mobile']);
        $city = mysqli_real_escape_string($connection, $_POST['city']);
        $area = mysqli_real_escape_string($connection, $_POST['area']);
        $email = mysqli_real_escape_string($connection, $_POST['email']);
        $experience = mysqli_real_escape_string($connection, $_POST['experience']);
        $hourlyrate = mysqli_real_escape_string($connection, $_POST['rate']);
        $mechanic_type = mysqli_real_escape_string($connection, $_POST['mechanic_type']);
        $password = mysqli_real_escape_string($connection, $_POST['password']);
        $confirm_password = mysqli_real_escape_string($connection, $_POST['confirmpassword']);

        // Password length check
        if (strlen($password) < 8) {

            $msg = "Your Password Must Contain At Least 8 Characters!";

        } else {

            // Password match check
            if ($password === $confirm_password) {

                // Hash password
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // Insert mechanic
                $query = "INSERT INTO professional
                (
                    mechanic_Fullname,
                    mechanic_cnic,
                    mechanic_address,
                    mechanic_city,
                    machanic_city_area,
                    mechanic_contact,
                    mechanic_email,
                    experience,
                    rate_per_hour,
                    password,
                    status,
                    mechanic_type
                )
                VALUES
                (
                    '$name',
                    '$cnic',
                    '$address',
                    '$city',
                    '$area',
                    '$contact',
                    '$email',
                    '$experience',
                    '$hourlyrate',
                    '$hashed_password',
                    'Active',
                    '$mechanic_type'
                )";

                $results = mysqli_query($connection, $query);

                if ($results) {

                    $msg = "Mechanic registered successfully!";

                } else {

                    $msg = "Error in registration: " . mysqli_error($connection);
                }

            } else {

                $msg = "Passwords do not match!";
            }
        }

    } else {

        $msg = "Fill all input fields";
    }
}

// Display message
?>

<?php include('navbar.php'); ?>

<?php include('mechForm.php'); ?>

<?php if (!empty($msg)): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: '<?php echo (strpos($msg, "successfully") !== false) ? "success" : "error"; ?>',
                title: 'Registration Info',
                text: '<?php echo addslashes($msg); ?>',
                confirmButtonColor: '#2563EB'
			}).then((result) => {
				<?php if (strpos($msg, "successfully") !== false): ?>
					window.location.href = 'login.php';
				<?php endif; ?>
			});
        });
    </script>
<?php endif; ?>

<!-- AJAX Load Area Script -->
<script>
function loadarea() {
    var district = $('#distt').val();
    $.ajax({
        type: "POST",
        url: "selectarea_ajax.php",
        data: { 'distt': district },
        success: function (data) {
            $('#area').html('<option selected disabled>Select Area</option>' + data);
        }
    });
}
</script>

<?php include('footer.php'); ?>