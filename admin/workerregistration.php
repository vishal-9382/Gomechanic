<?php
include('../database.php');
require('adminheader.php');

$msg = null;

if (isset($_POST['register'])) {
    if (
        !empty($_POST['name']) && !empty($_POST['cnic']) && !empty($_POST['mobile']) &&
        !empty($_POST['city']) && !empty($_POST['password']) && !empty($_POST['confirmpassword'])
    ) {
        $name = $_POST['name'];
        $cnic = $_POST['cnic'];
        $address = $_POST['address'];
        $contact = $_POST['mobile'];
        $city = $_POST['city'];
        $area = $_POST['area'];
        $email = $_POST['email'];
        $experience = $_POST['experience'];
        $hourlyrate = $_POST['rate'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirmpassword'];

        if ($password === $confirm_password) {
            $image = "";
            $server_folder = "../profilePhoto/";
            $server_path = $server_folder . basename($_FILES['photo']['name']);

            if (move_uploaded_file($_FILES["photo"]["tmp_name"], $server_path)) {
                $image = $_FILES['photo']['name'];
            }

            $query = "INSERT INTO professional VALUES ('', '$name', '$cnic', '$address', '$city', '$area', '$contact', '$email', '$experience', '$hourlyrate', '$password', 'Active', '$image')";
            $results = mysqli_query($connection, $query);

            if ($results) {
                $msg = "Mechanic registered successfully!";
            }
        } else {
            $msg = "Passwords do not match!";
        }
    } else {
        $msg = "Fill all required fields!";
    }
}

if (isset($msg)) {
    echo ("<script>alert('$msg');window.location.replace('manageprofessional.php');</script>");
}
?>

<script>
    function loadarea() {
        var district = $('#distt').val();
        $.ajax({
            type: "POST",
            url: "../selectarea_ajax.php",
            data: { 'distt': district },
            success: function (data) {
                console.log(data);
                $('#area').html('<option selected disabled>Select Area</option>' + data);
            }
        });
    }
</script>

<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white text-center">
            <h3>Mechanic Registration</h3>
        </div>
        <div class="card-body">
            <form method="post" action="" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" class="form-control" name="name" placeholder="Enter Name" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">CNIC</label>
                        <input type="text" class="form-control" name="cnic" placeholder="CNIC" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Address</label>
                        <input type="text" class="form-control" name="address" placeholder="Address" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">City</label>
                        <select class="form-control" id="distt" name="city" onchange="loadarea()" required>
                            <option selected disabled>Select City</option>
                            <?php
                            $query = "SELECT * FROM cities";
                            $results = mysqli_query($connection, $query);
                            if ($results) {
                                while ($row = mysqli_fetch_object($results)) {
                                    echo "<option value='$row->city_id'>$row->city_name</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Area</label>
                        <select class="form-control" id="area" name="area" required>
                            <option selected disabled>Select Area</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Mobile</label>
                        <input type="text" class="form-control" name="mobile" placeholder="Mobile" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" placeholder="Email" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Experience (in years)</label>
                        <input type="text" class="form-control" name="experience" placeholder="Experience" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Per Hour Rate</label>
                        <input type="text" class="form-control" name="rate" placeholder="Per Hour Rate" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" name="confirmpassword" id="confirm_password" placeholder="Confirm Password" required>
                        <small id="password_error" class="text-danger"></small>
                    </div>

                                    </div>

                <div class="text-center">
                    <button type="submit" name="register" class="btn btn-success w-50">Sign Up</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('confirm_password').addEventListener('input', function () {
        var password = document.getElementById('password').value;
        var confirmPassword = this.value;
        var errorElement = document.getElementById('password_error');

        if (password !== confirmPassword) {
            errorElement.textContent = "Passwords do not match!";
        } else {
            errorElement.textContent = "";
        }
    });
</script>

<?php include('footer.php'); ?>
